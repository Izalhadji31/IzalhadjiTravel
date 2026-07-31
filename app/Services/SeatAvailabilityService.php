<?php

namespace App\Services;

use App\Models\SeatAvailability;
use App\Models\Route;
use App\Models\Armada;
use App\Models\TravelBooking;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SeatAvailabilityService
{
    /**
     * Get seat availability for a route and date
     */
    public function getSeatAvailability($routeId, $travelDate, $armadaId = null): array
    {
        // Release expired locks first
        SeatAvailability::releaseExpiredLocks();

        $availableSeats = SeatAvailability::getAvailableSeats($routeId, $travelDate, $armadaId);
        $bookedSeats = SeatAvailability::getBookedSeats($routeId, $travelDate, $armadaId);
        $lockedSeats = SeatAvailability::getLockedSeats($routeId, $travelDate, $armadaId);

        return [
            'available' => $availableSeats,
            'booked' => $bookedSeats,
            'locked' => $lockedSeats,
            'total_seats' => 6, // Default for minibus
        ];
    }

    /**
     * Lock seats for temporary hold
     */
    public function lockSeats($routeId, $travelDate, $armadaId, array $seatNumbers, $userId, $minutes = 15): array
    {
        // Release expired locks first
        SeatAvailability::releaseExpiredLocks();

        $lockedSeats = [];
        $failedSeats = [];

        foreach ($seatNumbers as $seatNumber) {
            $seat = SeatAvailability::forRoute($routeId, $travelDate)
                                   ->where('seat_number', $seatNumber);

            if ($armadaId) {
                $seat->forArmada($armadaId);
            }

            $seat = $seat->first();

            if (!$seat) {
                // Create seat if it doesn't exist
                $seat = SeatAvailability::create([
                    'route_id' => $routeId,
                    'travel_date' => $travelDate,
                    'armada_id' => $armadaId,
                    'seat_number' => $seatNumber,
                    'status' => 'available',
                ]);
            }

            if ($seat->lockSeat($userId, $minutes)) {
                $lockedSeats[] = $seatNumber;
            } else {
                $failedSeats[] = [
                    'seat_number' => $seatNumber,
                    'reason' => $seat->status === 'booked' ? 'already_booked' : 'locked_by_other',
                ];
            }
        }

        return [
            'success' => count($lockedSeats) === count($seatNumbers),
            'locked_seats' => $lockedSeats,
            'failed_seats' => $failedSeats,
        ];
    }

    /**
     * Unlock seats
     */
    public function unlockSeats($routeId, $travelDate, $armadaId, array $seatNumbers, $userId): array
    {
        $unlockedSeats = [];
        $failedSeats = [];

        foreach ($seatNumbers as $seatNumber) {
            $seat = SeatAvailability::forRoute($routeId, $travelDate)
                                   ->where('seat_number', $seatNumber);

            if ($armadaId) {
                $seat->forArmada($armadaId);
            }

            $seat = $seat->first();

            if ($seat && $seat->locked_by === $userId) {
                if ($seat->unlockSeat()) {
                    $unlockedSeats[] = $seatNumber;
                } else {
                    $failedSeats[] = [
                        'seat_number' => $seatNumber,
                        'reason' => 'cannot_unlock',
                    ];
                }
            } else {
                $failedSeats[] = [
                    'seat_number' => $seatNumber,
                    'reason' => 'not_locked_by_user',
                ];
            }
        }

        return [
            'success' => count($unlockedSeats) === count($seatNumbers),
            'unlocked_seats' => $unlockedSeats,
            'failed_seats' => $failedSeats,
        ];
    }

    /**
     * Book seats after successful payment
     */
    public function bookSeats($routeId, $travelDate, $armadaId, array $seatNumbers, $travelBookingId): array
    {
        // Release expired locks first
        SeatAvailability::releaseExpiredLocks();

        $bookedSeats = [];
        $failedSeats = [];

        foreach ($seatNumbers as $seatNumber) {
            $seat = SeatAvailability::forRoute($routeId, $travelDate)
                                   ->where('seat_number', $seatNumber);

            if ($armadaId) {
                $seat->forArmada($armadaId);
            }

            $seat = $seat->first();

            if (!$seat) {
                // Create seat if it doesn't exist
                $seat = SeatAvailability::create([
                    'route_id' => $routeId,
                    'travel_date' => $travelDate,
                    'armada_id' => $armadaId,
                    'seat_number' => $seatNumber,
                    'status' => 'available',
                ]);
            }

            if ($seat->bookSeat($travelBookingId)) {
                $bookedSeats[] = $seatNumber;
            } else {
                $failedSeats[] = [
                    'seat_number' => $seatNumber,
                    'reason' => 'not_available',
                ];
            }
        }

        return [
            'success' => count($bookedSeats) === count($seatNumbers),
            'booked_seats' => $bookedSeats,
            'failed_seats' => $failedSeats,
        ];
    }

    /**
     * Release seats after failed payment or cancellation
     */
    public function releaseSeats($routeId, $travelDate, $armadaId, array $seatNumbers, $userId): array
    {
        $releasedSeats = [];
        $failedSeats = [];

        foreach ($seatNumbers as $seatNumber) {
            $seat = SeatAvailability::forRoute($routeId, $travelDate)
                                   ->where('seat_number', $seatNumber);

            if ($armadaId) {
                $seat->forArmada($armadaId);
            }

            $seat = $seat->first();

            if ($seat && ($seat->locked_by === $userId || $seat->status === 'locked')) {
                if ($seat->unlockSeat()) {
                    $releasedSeats[] = $seatNumber;
                } else {
                    $failedSeats[] = [
                        'seat_number' => $seatNumber,
                        'reason' => 'cannot_release',
                    ];
                }
            } else {
                $failedSeats[] = [
                    'seat_number' => $seatNumber,
                    'reason' => 'not_releasable',
                ];
            }
        }

        return [
            'success' => count($releasedSeats) === count($seatNumbers),
            'released_seats' => $releasedSeats,
            'failed_seats' => $failedSeats,
        ];
    }

    /**
     * Initialize seat availability for a new armada assignment
     */
    public function initializeArmadaSeats($routeId, $travelDate, $armadaId, $totalSeats = 6): void
    {
        SeatAvailability::initializeSeats($routeId, $travelDate, $armadaId, $totalSeats);
    }

    /**
     * Get seat availability for multiple dates (for calendar view)
     */
    public function getAvailabilityForDateRange($routeId, $startDate, $endDate, $armadaId = null): array
    {
        $availabilities = [];
        $currentDate = $startDate;
        $endDate = $endDate;

        while ($currentDate <= $endDate) {
            $dateString = $currentDate->format('Y-m-d');
            $availabilities[$dateString] = $this->getSeatAvailability($routeId, $dateString, $armadaId);
            $currentDate->addDay();
        }

        return $availabilities;
    }

    /**
     * Check if specific seats are available
     */
    public function checkSeatsAvailability($routeId, $travelDate, $armadaId, array $seatNumbers): array
    {
        SeatAvailability::releaseExpiredLocks();

        $results = [];

        foreach ($seatNumbers as $seatNumber) {
            $seat = SeatAvailability::forRoute($routeId, $travelDate)
                                   ->where('seat_number', $seatNumber);

            if ($armadaId) {
                $seat->forArmada($armadaId);
            }

            $seat = $seat->first();

            if (!$seat) {
                $results[$seatNumber] = [
                    'available' => true,
                    'status' => 'not_initialized',
                ];
            } else {
                $results[$seatNumber] = [
                    'available' => $seat->isAvailable(),
                    'status' => $seat->status,
                    'locked_by' => $seat->locked_by,
                    'locked_until' => $seat->locked_until,
                ];
            }
        }

        return $results;
    }

    /**
     * Get user's locked seats
     */
    public function getUserLockedSeats($userId): array
    {
        return SeatAvailability::where('locked_by', $userId)
                               ->where('locked_until', '>', now())
                               ->with(['route', 'armada'])
                               ->get()
                               ->map(function ($seat) {
                                   return [
                                       'id' => $seat->id,
                                       'route_name' => $seat->route->name ?? 'Unknown',
                                       'travel_date' => $seat->travel_date,
                                       'seat_number' => $seat->seat_number,
                                       'locked_until' => $seat->locked_until,
                                       'expires_in' => now()->diffInMinutes($seat->locked_until) . ' minutes',
                                   ];
                               })->toArray();
    }

    /**
     * Clean up expired locks for a user
     */
    public function cleanupUserExpiredLocks($userId): int
    {
        return SeatAvailability::where('locked_by', $userId)
                               ->where('locked_until', '<', now())
                               ->update([
                                   'status' => 'available',
                                   'locked_by' => null,
                                   'locked_until' => null,
                               ]);
    }
}