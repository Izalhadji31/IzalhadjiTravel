<?php

namespace App\Services;

use App\Models\TripTracking;
use App\Models\RentalBooking;
use App\Models\VehicleLocation;
use Illuminate\Support\Collection;

class TripTrackingService
{
    /**
     * Start a new trip
     */
    public function startTrip(
        int $rentalBookingId,
        int $armadaId,
        int $userId,
        float $startLatitude,
        float $startLongitude,
        string $startAddress = null
    ): TripTracking {
        return TripTracking::create([
            'rental_booking_id' => $rentalBookingId,
            'armada_id' => $armadaId,
            'user_id' => $userId,
            'start_latitude' => $startLatitude,
            'start_longitude' => $startLongitude,
            'start_address' => $startAddress,
            'start_time' => now(),
            'status' => 'ongoing',
        ]);
    }

    /**
     * End a trip and calculate statistics
     */
    public function endTrip(
        int $tripId,
        float $endLatitude,
        float $endLongitude,
        string $endAddress = null
    ): TripTracking {
        $trip = TripTracking::findOrFail($tripId);

        $distance = $this->calculateTotalDistance($trip->id);
        $duration = $this->calculateDuration($trip->start_time, now());

        $trip->update([
            'end_latitude' => $endLatitude,
            'end_longitude' => $endLongitude,
            'end_address' => $endAddress,
            'end_time' => now(),
            'total_distance' => $distance,
            'duration_minutes' => $duration,
            'status' => 'completed',
        ]);

        if ($duration > 0) {
            $trip->average_speed = round($distance / ($duration / 60), 2);
            $trip->save();
        }

        return $trip;
    }

    /**
     * Get trip details
     */
    public function getTripDetails(int $tripId): ?TripTracking
    {
        return TripTracking::with(['armada', 'user', 'rentalBooking'])->find($tripId);
    }

    /**
     * Get trip history for a vehicle
     */
    public function getVehicleTripHistory(int $armadaId, $daysBack = 30): Collection
    {
        return TripTracking::where('armada_id', $armadaId)
            ->where('status', 'completed')
            ->where('start_time', '>=', now()->subDays($daysBack))
            ->latest('start_time')
            ->get();
    }

    /**
     * Get trip history for a booking
     */
    public function getBookingTripHistory(int $bookingId): Collection
    {
        return TripTracking::where('rental_booking_id', $bookingId)
            ->latest('start_time')
            ->get();
    }

    /**
     * Get active trips
     */
    public function getActiveTrips(): Collection
    {
        return TripTracking::where('status', 'ongoing')
            ->with(['armada', 'user'])
            ->latest('start_time')
            ->get();
    }

    /**
     * Calculate total distance traveled in a trip using location data
     */
    public function calculateTotalDistance(int $tripId): float
    {
        $trip = TripTracking::find($tripId);
        $locations = VehicleLocation::where('rental_booking_id', $trip->rental_booking_id)
            ->where('recorded_at', '>=', $trip->start_time)
            ->where('recorded_at', '<=', $trip->end_time ?? now())
            ->orderBy('recorded_at')
            ->get();

        if ($locations->count() < 2) {
            return 0;
        }

        $totalDistance = 0;
        $prevLocation = null;

        foreach ($locations as $location) {
            if ($prevLocation) {
                $totalDistance += $this->calculateDistance(
                    $prevLocation->latitude,
                    $prevLocation->longitude,
                    $location->latitude,
                    $location->longitude
                );
            }
            $prevLocation = $location;
        }

        return round($totalDistance, 2);
    }

    /**
     * Calculate trip duration in minutes
     */
    public function calculateDuration($startTime, $endTime): int
    {
        return (int) $startTime->diffInMinutes($endTime);
    }

    /**
     * Calculate distance between two points
     */
    private function calculateDistance(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $a = sin($latDelta / 2) ** 2 + cos($latFrom) * cos($latTo) * sin($lonDelta / 2) ** 2;
        $c = 2 * asin(sqrt($a));

        return 6371 * $c; // 6371 is Earth radius in km
    }

    /**
     * Get trip statistics for a vehicle
     */
    public function getVehicleStatistics(int $armadaId, $daysBack = 30): array
    {
        $trips = $this->getVehicleTripHistory($armadaId, $daysBack);

        return [
            'total_trips' => $trips->count(),
            'total_distance' => $trips->sum('total_distance'),
            'total_duration' => $trips->sum('duration_minutes'),
            'average_distance' => $trips->avg('total_distance'),
            'average_speed' => $trips->avg('average_speed'),
            'max_speed' => $trips->max('average_speed'),
            'fuel_consumption' => $trips->sum(fn ($trip) => $trip->calculateFuel()),
        ];
    }

    /**
     * Get daily revenue from trips
     */
    public function getDailyRevenue(int $armadaId, $date = null): float
    {
        $date = $date ?? today();

        $bookings = TripTracking::where('armada_id', $armadaId)
            ->where('status', 'completed')
            ->whereDate('start_time', $date)
            ->pluck('rental_booking_id');

        return RentalBooking::whereIn('id', $bookings)
            ->sum('total_price');
    }

    /**
     * Encode polyline from locations
     */
    public function encodePolyline(int $tripId): ?string
    {
        // This is a simplified version. For production, use a proper polyline encoding library
        $trip = TripTracking::find($tripId);
        $locations = VehicleLocation::where('rental_booking_id', $trip->rental_booking_id)
            ->where('recorded_at', '>=', $trip->start_time)
            ->where('recorded_at', '<=', $trip->end_time ?? now())
            ->select('latitude', 'longitude')
            ->get();

        return json_encode($locations->toArray());
    }
}
