<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FleetManagementService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FleetTrackingApiController extends Controller
{
    public function __construct(private FleetManagementService $fleetService) {}

    /**
     * Get fleet overview
     */
    public function getFleetOverview(): JsonResponse
    {
        $overview = $this->fleetService->getFleetOverview();

        return response()->json([
            'success' => true,
            'data' => $overview,
        ]);
    }

    /**
     * Get complete fleet dashboard
     */
    public function getFleetDashboard(Request $request): JsonResponse
    {
        $days = $request->input('days', 30);
        $dashboard = $this->fleetService->getFleetDashboard($days);

        return response()->json([
            'success' => true,
            'data' => $dashboard,
        ]);
    }

    /**
     * Get metrics for a specific vehicle
     */
    public function getArmadaMetrics(int $armadaId, Request $request): JsonResponse
    {
        $days = $request->input('days', 30);
        $metrics = $this->fleetService->getArmadaMetrics($armadaId, $days);

        return response()->json([
            'success' => true,
            'data' => $metrics,
        ]);
    }

    /**
     * Get maintenance status
     */
    public function getMaintenanceStatus(int $armadaId): JsonResponse
    {
        $status = $this->fleetService->getMaintenanceStatus($armadaId);

        return response()->json([
            'success' => true,
            'data' => $status,
        ]);
    }

    /**
     * Log maintenance
     */
    public function logMaintenance(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'armada_id' => 'required|exists:armadas,id',
            'maintenance_type' => 'required|string',
            'cost' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'scheduled_next_at' => 'nullable|date',
        ]);

        $maintenance = $this->fleetService->logMaintenance(
            $validated['armada_id'],
            $validated['maintenance_type'],
            $validated['cost'],
            $validated['description'] ?? null,
            $validated['scheduled_next_at'] ?? null
        );

        return response()->json([
            'success' => true,
            'message' => 'Maintenance logged successfully',
            'data' => $maintenance,
        ], 201);
    }

    /**
     * Schedule maintenance
     */
    public function scheduleMaintenance(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'armada_id' => 'required|exists:armadas,id',
            'maintenance_type' => 'required|string',
            'scheduled_date' => 'required|date|after:today',
            'description' => 'nullable|string',
        ]);

        $maintenance = $this->fleetService->scheduleMaintenance(
            $validated['armada_id'],
            $validated['maintenance_type'],
            $validated['scheduled_date'],
            $validated['description'] ?? null
        );

        return response()->json([
            'success' => true,
            'message' => 'Maintenance scheduled successfully',
            'data' => $maintenance,
        ], 201);
    }

    /**
     * Get vehicles needing attention
     */
    public function getVehiclesNeedingAttention(): JsonResponse
    {
        $vehicles = $this->fleetService->getVehiclesNeedingAttention();

        return response()->json([
            'success' => true,
            'count' => $vehicles->count(),
            'data' => $vehicles,
        ]);
    }

    /**
     * Get fleet utilization statistics
     */
    public function getFleetUtilization(Request $request): JsonResponse
    {
        $days = $request->input('days', 30);
        $utilization = $this->fleetService->getAverageUtilization($days);

        return response()->json([
            'success' => true,
            'average_utilization' => round($utilization, 2),
        ]);
    }

    /**
     * Generate fleet report
     */
    public function generateFleetReport(Request $request): JsonResponse
    {
        $days = $request->get('days', 30);
        $report = $this->fleetService->generateFleetReport($days);

        return response()->json([
            'success' => true,
            'data' => $report,
        ]);
    }
}
