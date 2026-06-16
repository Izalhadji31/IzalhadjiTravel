<?php

namespace App\Http\Controllers;

use App\Models\Armada;
use App\Models\VehicleMaintenanceLog;
use App\Services\FleetManagementService;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FleetDashboardController extends Controller
{
    public function __construct(private FleetManagementService $fleetService) {}

    /**
     * Show fleet dashboard
     */
    public function index(): View
    {
        $dashboardData = $this->fleetService->getFleetDashboard(30);
        $vehiclesNeedingAttention = $this->fleetService->getVehiclesNeedingAttention();

        return view('fleet.dashboard', [
            'data' => $dashboardData,
            'vehiclesNeedingAttention' => $vehiclesNeedingAttention,
        ]);
    }

    /**
     * Show all vehicles
     */
    public function vehicles(): View
    {
        $armadas = Armada::all();
        $vehicles = $armadas->map(fn ($armada) => [
            'armada' => $armada,
            'metrics' => $this->fleetService->getArmadaMetrics($armada->id, 30),
        ]);

        return view('fleet.vehicles', [
            'vehicles' => $vehicles,
        ]);
    }

    /**
     * Show vehicle detail page
     */
    public function vehicleDetail($armadaId): View
    {
        $armada = Armada::with('mitra')->findOrFail($armadaId);
        $metrics = $this->fleetService->getArmadaMetrics($armadaId, 30);
        $maintenanceStatus = $this->fleetService->getMaintenanceStatus($armadaId);
        $maintenanceLogs = VehicleMaintenanceLog::where('armada_id', $armadaId)
            ->latest('maintenance_date')
            ->paginate(15);

        return view('fleet.vehicle-detail', [
            'armada' => $armada,
            'metrics' => $metrics,
            'maintenanceStatus' => $maintenanceStatus,
            'maintenanceLogs' => $maintenanceLogs,
        ]);
    }

    /**
     * Show maintenance management
     */
    public function maintenance(): View
    {
        $overdueMaintenance = VehicleMaintenanceLog::where('status', 'scheduled')
            ->where('scheduled_next_at', '<', now())
            ->with('armada')
            ->get();

        $upcomingMaintenance = VehicleMaintenanceLog::where('status', 'scheduled')
            ->where('scheduled_next_at', '>=', now())
            ->where('scheduled_next_at', '<=', now()->addDays(7))
            ->with('armada')
            ->get();

        $completedMaintenance = VehicleMaintenanceLog::where('status', 'completed')
            ->latest('maintenance_date')
            ->with('armada')
            ->limit(10)
            ->get();

        return view('fleet.maintenance', [
            'overdueMaintenance' => $overdueMaintenance,
            'upcomingMaintenance' => $upcomingMaintenance,
            'completedMaintenance' => $completedMaintenance,
        ]);
    }

    /**
     * Log maintenance for a vehicle
     */
    public function logMaintenance(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'armada_id' => 'required|exists:armadas,id',
            'maintenance_type' => 'required|string',
            'description' => 'nullable|string',
            'cost' => 'required|numeric|min:0',
            'scheduled_next_at' => 'nullable|date|after:today',
        ]);

        $this->fleetService->logMaintenance(
            $validated['armada_id'],
            $validated['maintenance_type'],
            $validated['cost'],
            $validated['description'] ?? null,
            $validated['scheduled_next_at'] ?? null
        );

        return redirect()->back()->with('success', 'Maintenance logged successfully');
    }

    /**
     * Schedule maintenance for a vehicle
     */
    public function scheduleMaintenance(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'armada_id' => 'required|exists:armadas,id',
            'maintenance_type' => 'required|string',
            'description' => 'nullable|string',
            'scheduled_date' => 'required|date|after:today',
        ]);

        $this->fleetService->scheduleMaintenance(
            $validated['armada_id'],
            $validated['maintenance_type'],
            $validated['scheduled_date'],
            $validated['description'] ?? null
        );

        return redirect()->back()->with('success', 'Maintenance scheduled successfully');
    }

    /**
     * Show vehicles needing attention
     */
    public function needsAttention(): View
    {
        $vehicles = $this->fleetService->getVehiclesNeedingAttention();

        return view('fleet.needs-attention', [
            'vehicles' => $vehicles,
        ]);
    }

    /**
     * Generate fleet report
     */
    public function report(Request $request): View
    {
        $days = $request->get('days', 30);
        $report = $this->fleetService->generateFleetReport($days);
        $utilization = $this->fleetService->getAverageUtilization($days);

        return view('fleet.report', [
            'report' => $report,
            'utilization' => $utilization,
            'days' => $days,
        ]);
    }

    /**
     * Export fleet report
     */
    public function exportReport(Request $request)
    {
        $days = $request->get('days', 30);
        $report = $this->fleetService->generateFleetReport($days);

        $csvData = "Vehicle,Type,Trips,Distance,Duration,Avg Speed,Utilization,Revenue\n";
        foreach ($report as $item) {
            $metrics = $item['metrics'];
            $csvData .= "{$item['vehicle']},{$item['type']},{$metrics['total_trips']},{$metrics['total_distance']},{$metrics['total_duration']},{$metrics['average_speed']},{$metrics['utilization_rate']},{$metrics['revenue']}\n";
        }

        $fileName = "fleet_report_" . now()->format('Y-m-d_H-i-s') . '.csv';

        return response()->streamDownload(function () use ($csvData) {
            echo $csvData;
        }, $fileName, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ]);
    }
}
