<?php

namespace App\Services;

use App\Models\Armada;
use App\Models\FleetAnalytic;
use App\Models\VehicleMaintenanceLog;
use App\Models\VehicleLocation;
use App\Models\TripTracking;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class FleetManagementService
{
    /**
     * Get fleet overview
     */
    public function getFleetOverview(): array
    {
        $armadas = Armada::all();
        $totalVehicles = $armadas->count();
        $availableVehicles = $armadas->where('status', 'tersedia')->count();
        $onRentalVehicles = $armadas->where('status', 'dalam_perjalanan')->count();
        $maintenanceVehicles = $armadas->where('status', 'perawatan')->count();

        return [
            'total' => $totalVehicles,
            'available' => $availableVehicles,
            'on_rental' => $onRentalVehicles,
            'in_maintenance' => $maintenanceVehicles,
            'utilization_rate' => $totalVehicles > 0 ? 
                round((($onRentalVehicles + $maintenanceVehicles) / $totalVehicles) * 100, 2) : 0,
        ];
    }

    /**
     * Get fleet dashboard data
     */
    public function getFleetDashboard(int $days = 30): array
    {
        $armadas = Armada::with('rentalAssignments')->get();

        $totalTrips = TripTracking::where('start_time', '>=', now()->subDays($days))->count();
        $totalDistance = TripTracking::where('start_time', '>=', now()->subDays($days))
            ->sum('total_distance');
        $totalRevenue = 0;

        foreach ($armadas as $armada) {
            $totalRevenue += $this->getArmadaRevenue($armada->id, $days);
        }

        return [
            'overview' => $this->getFleetOverview(),
            'total_trips' => $totalTrips,
            'total_distance' => round($totalDistance, 2),
            'total_revenue' => $totalRevenue,
            'average_utilization' => round($this->getAverageUtilization($days), 2),
            'armadas' => $armadas->map(fn ($armada) => $this->getArmadaMetrics($armada->id, $days))->toArray(),
        ];
    }

    /**
     * Get detailed metrics for a specific vehicle
     */
    public function getArmadaMetrics(int $armadaId, int $days = 30): array
    {
        $armada = Armada::find($armadaId);
        $analytics = FleetAnalytic::where('armada_id', $armadaId)
            ->where('date', '>=', now()->subDays($days))
            ->get();

        $trips = TripTracking::where('armada_id', $armadaId)
            ->where('start_time', '>=', now()->subDays($days))
            ->where('status', 'completed')
            ->get();

        return [
            'id' => $armada->id,
            'plate_number' => $armada->plate_number,
            'vehicle_type' => $armada->vehicle_type,
            'status' => $armada->status,
            'total_trips' => $trips->count(),
            'total_distance' => round($trips->sum('total_distance'), 2),
            'total_duration' => $trips->sum('duration_minutes'),
            'average_speed' => round($trips->avg('average_speed'), 2),
            'utilization_rate' => $this->calculateUtilization($armadaId, $days),
            'revenue' => $this->getArmadaRevenue($armadaId, $days),
            'fuel_consumption' => round($analytics->sum('fuel_consumption'), 2),
            'maintenance_status' => $this->getMaintenanceStatus($armadaId),
        ];
    }

    /**
     * Get maintenance status for a vehicle
     */
    public function getMaintenanceStatus(int $armadaId): array
    {
        $overdueMaintenance = VehicleMaintenanceLog::where('armada_id', $armadaId)
            ->where('status', 'scheduled')
            ->where('scheduled_next_at', '<', now())
            ->count();

        $upcomingMaintenance = VehicleMaintenanceLog::where('armada_id', $armadaId)
            ->where('status', 'scheduled')
            ->where('scheduled_next_at', '>=', now())
            ->where('scheduled_next_at', '<=', now()->addDays(7))
            ->count();

        $lastMaintenance = VehicleMaintenanceLog::where('armada_id', $armadaId)
            ->where('status', 'completed')
            ->latest('maintenance_date')
            ->first();

        return [
            'overdue' => $overdueMaintenance,
            'upcoming' => $upcomingMaintenance,
            'last_maintenance_date' => $lastMaintenance?->maintenance_date?->format('Y-m-d'),
            'needs_attention' => $overdueMaintenance > 0,
        ];
    }

    /**
     * Calculate utilization rate for a vehicle
     */
    public function calculateUtilization(int $armadaId, int $days = 30): float
    {
        $analytics = FleetAnalytic::where('armada_id', $armadaId)
            ->where('date', '>=', now()->subDays($days))
            ->get();

        if ($analytics->isEmpty()) {
            return 0;
        }

        $totalUtilization = $analytics->sum(function ($analytic) {
            return $analytic->getUtilizationPercentage();
        });

        return round($totalUtilization / $analytics->count(), 2);
    }

    /**
     * Get revenue for a specific vehicle
     */
    public function getArmadaRevenue(int $armadaId, int $days = 30): float
    {
        $trips = TripTracking::where('armada_id', $armadaId)
            ->where('start_time', '>=', now()->subDays($days))
            ->pluck('rental_booking_id');

        $revenue = \DB::table('rental_bookings')
            ->whereIn('id', $trips)
            ->sum('total_price');

        return $revenue ?? 0;
    }

    /**
     * Get average utilization across fleet
     */
    public function getAverageUtilization(int $days = 30): float
    {
        $armadas = Armada::all();

        if ($armadas->isEmpty()) {
            return 0;
        }

        $totalUtilization = 0;

        foreach ($armadas as $armada) {
            $totalUtilization += $this->calculateUtilization($armada->id, $days);
        }

        return $totalUtilization / $armadas->count();
    }

    /**
     * Log maintenance for a vehicle
     */
    public function logMaintenance(
        int $armadaId,
        string $type,
        float $cost,
        string $description = null,
        $scheduledNextAt = null
    ): VehicleMaintenanceLog {
        return VehicleMaintenanceLog::create([
            'armada_id' => $armadaId,
            'maintenance_type' => $type,
            'cost' => $cost,
            'description' => $description,
            'maintenance_date' => now(),
            'scheduled_next_at' => $scheduledNextAt,
            'status' => 'completed',
        ]);
    }

    /**
     * Schedule maintenance for a vehicle
     */
    public function scheduleMaintenance(
        int $armadaId,
        string $type,
        $scheduledDate,
        string $description = null
    ): VehicleMaintenanceLog {
        return VehicleMaintenanceLog::create([
            'armada_id' => $armadaId,
            'maintenance_type' => $type,
            'description' => $description,
            'scheduled_next_at' => $scheduledDate,
            'status' => 'scheduled',
            'cost' => 0,
        ]);
    }

    /**
     * Get vehicles requiring immediate attention
     */
    public function getVehiclesNeedingAttention(): Collection
    {
        $overdueMaintenance = VehicleMaintenanceLog::where('status', 'scheduled')
            ->where('scheduled_next_at', '<', now())
            ->pluck('armada_id')
            ->unique();

        $offlineVehicles = Armada::whereNotIn('id', function ($query) {
            $query->select('armada_id')
                ->from('vehicle_locations')
                ->where('recorded_at', '>=', now()->subMinutes(30));
        })->pluck('id');

        $allIds = $overdueMaintenance->merge($offlineVehicles)->unique();

        return Armada::whereIn('id', $allIds)->get();
    }

    /**
     * Generate fleet report
     */
    public function generateFleetReport(int $days = 30): array
    {
        $armadas = Armada::all();
        $report = [];

        foreach ($armadas as $armada) {
            $report[] = [
                'vehicle' => $armada->plate_number,
                'type' => $armada->vehicle_type,
                'metrics' => $this->getArmadaMetrics($armada->id, $days),
            ];
        }

        return $report;
    }
}
