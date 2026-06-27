<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GpsDevice;
use App\Models\VehicleLocation;
use App\Models\TripTracking;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GpsDeviceApiController extends Controller
{
    /**
     * Authenticate device via X-Device-Key header
     */
    private function authenticateDevice(Request $request): ?GpsDevice
    {
        $apiKey = $request->header('X-Device-Key');

        if (!$apiKey) {
            return null;
        }

        $device = GpsDevice::active()->get()->first(function ($device) use ($apiKey) {
            return hash_equals($device->api_key, $apiKey);
        });

        return $device;
    }

    /**
     * POST /api/gps/location
     * Receive GPS location from tracking devices (GT06, TK919, etc.)
     */
    public function receiveLocation(Request $request): JsonResponse
    {
        $device = $this->authenticateDevice($request);

        if (!$device) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized - Invalid or missing device key',
            ], 401);
        }

        $validated = $request->validate([
            'device_id' => 'required|string',
            'lat' => 'required|numeric|between:-90,90',
            'lng' => 'required|numeric|between:-180,180',
            'speed' => 'nullable|numeric|min:0',
            'heading' => 'nullable|numeric|between:0,360',
            'timestamp' => 'nullable|date',
            'battery' => 'nullable|numeric|between:0,100',
        ]);

        // Verify the device_id matches the authenticated device
        if ($validated['device_id'] !== $device->device_id) {
            return response()->json([
                'success' => false,
                'message' => 'Device ID mismatch',
            ], 403);
        }

        // Update device last contact
        $device->update(['last_contact_at' => now()]);

        // Record location if device is linked to an armada
        $location = null;
        if ($device->armada_id) {
            $location = VehicleLocation::create([
                'armada_id' => $device->armada_id,
                'latitude' => $validated['lat'],
                'longitude' => $validated['lng'],
                'speed' => $validated['speed'] ?? 0,
                'heading' => $validated['heading'] ?? null,
                'recorded_at' => $validated['timestamp'] ?? now(),
                'status' => 'active',
                'accuracy' => $request->input('accuracy'),
            ]);

            // Update active trip if exists (append to route_polyline)
            $activeTrip = TripTracking::where('armada_id', $device->armada_id)
                ->whereIn('status', ['ongoing', 'active'])
                ->latest()
                ->first();

            if ($activeTrip) {
                $polyline = $activeTrip->route_polyline ?? [];
                $polyline[] = [
                    'lat' => (float) $validated['lat'],
                    'lng' => (float) $validated['lng'],
                    'speed' => (float) ($validated['speed'] ?? 0),
                    'heading' => $validated['heading'] ? (float) $validated['heading'] : null,
                    'timestamp' => $validated['timestamp'] ?? now()->toIso8601String(),
                ];
                $activeTrip->update(['route_polyline' => $polyline]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Location received successfully',
            'data' => [
                'device_id' => $device->device_id,
                'armada_id' => $device->armada_id,
                'location_id' => $location?->id,
                'server_time' => now()->toIso8601String(),
            ],
        ], 201);
    }

    /**
     * GET /api/gps/vehicle/{deviceId}
     * Get current status of a vehicle for device sync
     */
    public function getVehicleStatus(Request $request, string $deviceId): JsonResponse
    {
        $device = $this->authenticateDevice($request);

        if (!$device) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized - Invalid or missing device key',
            ], 401);
        }

        $gpsDevice = GpsDevice::byDevice($deviceId)->active()->first();

        if (!$gpsDevice) {
            return response()->json([
                'success' => false,
                'message' => 'Device not found',
            ], 404);
        }

        $latestLocation = null;
        if ($gpsDevice->armada_id) {
            $latestLocation = VehicleLocation::where('armada_id', $gpsDevice->armada_id)
                ->latest('recorded_at')
                ->first();
        }

        return response()->json([
            'success' => true,
            'data' => [
                'device_id' => $gpsDevice->device_id,
                'device_name' => $gpsDevice->device_name,
                'device_type' => $gpsDevice->device_type,
                'is_active' => $gpsDevice->is_active,
                'last_contact_at' => $gpsDevice->last_contact_at?->toIso8601String(),
                'armada_id' => $gpsDevice->armada_id,
                'latest_location' => $latestLocation ? [
                    'latitude' => $latestLocation->latitude,
                    'longitude' => $latestLocation->longitude,
                    'speed' => $latestLocation->speed,
                    'heading' => $latestLocation->heading,
                    'recorded_at' => $latestLocation->recorded_at?->toIso8601String(),
                ] : null,
                'settings' => $gpsDevice->settings,
            ],
        ]);
    }
}
