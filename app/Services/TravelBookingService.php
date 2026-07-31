<?php

namespace App\Services;

use App\Models\TravelBooking;
use App\Models\Route;
use Illuminate\Support\Str;

class TravelBookingService
{
    /**
     * Create a new travel booking
     */
    public function createBooking(
        int $userId,
        int $routeId,
        int $numberOfSeats,
        string $scheduledDate
    ): TravelBooking {
        $route = Route::findOrFail($routeId);
        $travelPrice = $route->getTravelPrice();

        if (!$travelPrice) {
            throw new \Exception('Travel price not available for this route');
        }

        $totalPrice = $numberOfSeats * $travelPrice->price_per_seat;

        return TravelBooking::create([
            'user_id' => $userId,
            'route_id' => $routeId,
            'number_of_seats' => $numberOfSeats,
            'total_price' => $totalPrice,
            'booking_code' => $this->generateBookingCode(),
            'status' => 'pending',
            'scheduled_date' => $scheduledDate,
        ]);
    }

    /**
     * Confirm a travel booking and assign armada
     */
    public function confirmBooking(TravelBooking $booking, int $armadaId): TravelBooking
    {
        $armada = \App\Models\Armada::findOrFail($armadaId);

        if (!$armada->isAvailable()) {
            throw new \Exception('Armada is not available');
        }

        // Check if armada has enough seats
        if ($armada->seat_capacity < $booking->number_of_seats) {
            throw new \Exception('Armada does not have enough seats');
        }

        $booking->update([
            'assigned_armada_id' => $armadaId,
            'status' => 'confirmed',
        ]);

        $armada->setToJalan();

        return $booking;
    }

    /**
     * Complete a travel booking
     */
    public function completeBooking(TravelBooking $booking): TravelBooking
    {
        $booking->update(['status' => 'completed']);

        // Set armada back to available
        if ($booking->assigned_armada_id) {
            $booking->assignedArmada->setToAvailable();
        }

        return $booking;
    }

    /**
     * Cancel a travel booking
     */
    public function cancelBooking(TravelBooking $booking): TravelBooking
    {
        if (!$booking->canBeCancelled()) {
            throw new \Exception('Booking cannot be cancelled in current status');
        }

        $booking->cancel();

        // Set armada back to available if assigned
        if ($booking->assigned_armada_id && $booking->assignedArmada->status === 'jalan') {
            $booking->assignedArmada->setToAvailable();
        }

        return $booking;
    }

    /**
     * Generate booking code
     */
    private function generateBookingCode(): string
    {
        $prefix = 'TB'; // Travel Booking
        $timestamp = now()->format('YmdHis');
        $random = strtoupper(Str::random(6));

        return "{$prefix}{$timestamp}{$random}";
    }
}
