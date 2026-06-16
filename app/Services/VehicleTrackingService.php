<?php

namespace App\Services;

use App\Models\VehicleLocation;
use App\Models\Armada;
use App\Models\RentalBooking;
use Illuminate\Support\Collection;

class VehicleTrackingService
{
    /**
     * Record a new vehicle location
     */
    public function recordLocation(
        int $armadaId,
        float $latitude,
        float $longitude,
        array $additionalData = []
    ): VehicleLocation {
        $data = array_merge([
            'armada_id' => $armadaId,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'status' => 'active',
            'recorded_at' => now(),
        ], $additionalData);

        return VehicleLocation::create($data);
    }

    /**
     * Get latest location for a vehicle
     */
    public function getLatestLocation(int $armadaId): ?VehicleLocation
    {
        return VehicleLocation::where('armada_id', $armadaId)
            ->latest('recorded_at')
            ->first();
    }

    /**
     * Get all active vehicle locations (for dashboard)
     */
    public function getAllActiveLocations(): Collection
    {
        return VehicleLocation::whereIn('armada_id', function ($query) {
            $query->select('id')
                ->from('armadas')
                ->where('status', 'tersedia');
        })
            ->where('recorded_at', '>=', now()->subHours(1))
            ->latest('recorded_at')
            ->get();
    }

    /**
     * Get vehicles currently on rental
     */
    public function getVehiclesOnRental(): Collection
    {
        return VehicleLocation::whereNotNull('rental_booking_id')
            ->where('status', 'active')
            ->latest('recorded_at')
            ->get();
    }

    /**
     * Get location history for a vehicle
     */
    public function getLocationHistory(int $armadaId, $hoursBack = 24): Collection
    {
        return VehicleLocation::where('armada_id', $armadaId)
            ->where('recorded_at', '>=', now()->subHours($hoursBack))
            ->latest('recorded_at')
            ->get();
    }

    /**
     * Get real-time position of multiple vehicles
     */
    public function getRealTimePositions(array $armadaIds = []): Collection
    {
        $query = VehicleLocation::query();

        if (!empty($armadaIds)) {
            $query->whereIn('armada_id', $armadaIds);
        }

        return $query->where('recorded_at', '>=', now()->subMinutes(15))
            ->distinct('armada_id')
            ->get();
    }

    /**
     * Find vehicles near a location
     */
    public function findVehiclesNear(float $latitude, float $longitude, float $radiusKm = 5): Collection
    {
        $locations = VehicleLocation::where('status', 'active')
            ->where('recorded_at', '>=', now()->subHours(1))
            ->get();

        return $locations->filter(function ($location) use ($latitude, $longitude, $radiusKm) {
            $distance = $this->calculateDistance(
                $latitude,
                $longitude,
                $location->latitude,
                $location->longitude
            );
            return $distance <= $radiusKm;
        });
    }

    /**
     * Calculate distance between two coordinates (Haversine formula)
     */
    public function calculateDistance(
        float $lat1,
        float $lon1,
        float $lat2,
        float $lon2
    ): float {
        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $a = sin($latDelta / 2) ** 2 + cos($latFrom) * cos($latTo) * sin($lonDelta / 2) ** 2;
        $c = 2 * asin(sqrt($a));
        $radius = 6371; // Earth radius in km

        return $radius * $c;
    }

    /**
     * Update vehicle status based on speed
     */
    public function updateVehicleStatus(VehicleLocation $location): void
    {
        $newStatus = match (true) {
            $location->speed > 5 => 'moving',
            $location->speed > 0 => 'idle',
            default => 'stationary'
        };

        $location->update(['status' => $newStatus]);
    }

    /**
     * Get vehicles offline (no location update in last 30 minutes)
     */
    public function getOfflineVehicles(): Collection
    {
        return Armada::whereNotIn('id', function ($query) {
            $query->select('armada_id')
                ->from('vehicle_locations')
                ->where('recorded_at', '>=', now()->subMinutes(30));
        })->get();
    }

    /**
     * Clean old location records (keep only last 30 days)
     */
    public function cleanOldLocations(int $daysToKeep = 30): int
    {
        return VehicleLocation::where('recorded_at', '<', now()->subDays($daysToKeep))
            ->delete();
    }

    /**
     * Get location heatmap data for a vehicle
     */
    public function getHeatmapData(int $armadaId, $daysBack = 7): Collection
    {
        return VehicleLocation::where('armada_id', $armadaId)
            ->where('recorded_at', '>=', now()->subDays($daysBack))
            ->select('latitude', 'longitude')
            ->get();
    }
}
