<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VehicleLocation;
use App\Models\Armada;
use App\Services\VehicleTrackingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TrackingApiController extends Controller
{
    public function __construct(private VehicleTrackingService $trackingService) {}

    /**
     * Record vehicle GPS location
     */
    public function recordLocation(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'armada_id' => 'required|exists:armadas,id',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'address' => 'nullable|string',
            'speed' => 'nullable|numeric|min:0',
            'heading' => 'nullable|numeric|between:0,360',
            'accuracy' => 'nullable|numeric|min:0',
            'rental_booking_id' => 'nullable|exists:rental_bookings,id',
        ]);

        $location = $this->trackingService->recordLocation(
            $validated['armada_id'],
            $validated['latitude'],
            $validated['longitude'],
            [
                'address' => $validated['address'] ?? null,
                'speed' => $validated['speed'] ?? 0,
                'heading' => $validated['heading'] ?? null,
                'accuracy' => $validated['accuracy'] ?? null,
                'rental_booking_id' => $validated['rental_booking_id'] ?? null,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Location recorded successfully',
            'data' => $location,
        ], 201);
    }

    /**
     * Get latest location of a vehicle
     */
    public function getLatestLocation(int $armadaId): JsonResponse
    {
        $location = $this->trackingService->getLatestLocation($armadaId);

        if (!$location) {
            return response()->json([
                'success' => false,
                'message' => 'No location data found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $location,
        ]);
    }

    /**
     * Get all active vehicle locations
     */
    public function getAllActiveLocations(): JsonResponse
    {
        $locations = $this->trackingService->getAllActiveLocations();

        return response()->json([
            'success' => true,
            'count' => $locations->count(),
            'data' => $locations,
        ]);
    }

    /**
     * Get vehicles currently on rental
     */
    public function getVehiclesOnRental(): JsonResponse
    {
        $vehicles = $this->trackingService->getVehiclesOnRental();

        return response()->json([
            'success' => true,
            'count' => $vehicles->count(),
            'data' => $vehicles,
        ]);
    }

    /**
     * Get location history for a vehicle
     */
    public function getLocationHistory(int $armadaId, Request $request): JsonResponse
    {
        $hoursBack = $request->input('hours', 24);
        $history = $this->trackingService->getLocationHistory($armadaId, $hoursBack);

        return response()->json([
            'success' => true,
            'count' => $history->count(),
            'data' => $history,
        ]);
    }

    /**
     * Get real-time positions for tracking dashboard
     */
    public function getRealTimePositions(Request $request): JsonResponse
    {
        $armadaIds = $request->input('armada_ids', []);
        $positions = $this->trackingService->getRealTimePositions($armadaIds);

        return response()->json([
            'success' => true,
            'count' => $positions->count(),
            'data' => $positions->map(function ($position) {
                return [
                    'armada_id' => $position->armada_id,
                    'latitude' => $position->latitude,
                    'longitude' => $position->longitude,
                    'status' => $position->status,
                    'speed' => $position->speed,
                    'recorded_at' => $position->recorded_at,
                ];
            }),
        ]);
    }

    /**
     * Find vehicles near a location
     */
    public function findNearbyVehicles(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'radius_km' => 'nullable|numeric|min:0.1|max:100',
        ]);

        $radius = $validated['radius_km'] ?? 5;
        $vehicles = $this->trackingService->findVehiclesNear(
            $validated['latitude'],
            $validated['longitude'],
            $radius
        );

        return response()->json([
            'success' => true,
            'count' => $vehicles->count(),
            'data' => $vehicles->map(function ($vehicle) {
                return [
                    'armada_id' => $vehicle->armada_id,
                    'latitude' => $vehicle->latitude,
                    'longitude' => $vehicle->longitude,
                    'plate_number' => $vehicle->armada->plate_number,
                ];
            }),
        ]);
    }

    /**
     * Get offline vehicles
     */
    public function getOfflineVehicles(): JsonResponse
    {
        $vehicles = $this->trackingService->getOfflineVehicles();

        return response()->json([
            'success' => true,
            'count' => $vehicles->count(),
            'data' => $vehicles,
        ]);
    }

    /**
     * Get heatmap data for a vehicle
     */
    public function getHeatmapData(int $armadaId, Request $request): JsonResponse
    {
        $daysBack = $request->input('days', 7);
        $data = $this->trackingService->getHeatmapData($armadaId, $daysBack);

        return response()->json([
            'success' => true,
            'count' => $data->count(),
            'data' => $data->map(fn ($point) => [
                'lat' => (float) $point->latitude,
                'lng' => (float) $point->longitude,
            ]),
        ]);
    }

    /**
     * Get location geofence status
     */
    public function checkGeofence(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'armada_id' => 'required|exists:armadas,id',
            'geofence_latitude' => 'required|numeric|between:-90,90',
            'geofence_longitude' => 'required|numeric|between:-180,180',
            'radius_km' => 'required|numeric|min:0.1',
        ]);

        $location = $this->trackingService->getLatestLocation($validated['armada_id']);

        if (!$location) {
            return response()->json([
                'success' => false,
                'message' => 'No location data found',
            ], 404);
        }

        $distance = $this->trackingService->calculateDistance(
            $validated['geofence_latitude'],
            $validated['geofence_longitude'],
            $location->latitude,
            $location->longitude
        );

        $isInsideGeofence = $distance <= $validated['radius_km'];

        return response()->json([
            'success' => true,
            'is_inside_geofence' => $isInsideGeofence,
            'distance_km' => round($distance, 2),
        ]);
    }
}
