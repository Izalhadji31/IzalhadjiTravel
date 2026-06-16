<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TripTracking;
use App\Models\RentalBooking;
use App\Services\TripTrackingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TripTrackingApiController extends Controller
{
    public function __construct(private TripTrackingService $tripService) {}

    /**
     * Start a new trip
     */
    public function startTrip(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'rental_booking_id' => 'required|exists:rental_bookings,id',
            'armada_id' => 'required|exists:armadas,id',
            'user_id' => 'required|exists:users,id',
            'start_latitude' => 'required|numeric|between:-90,90',
            'start_longitude' => 'required|numeric|between:-180,180',
            'start_address' => 'nullable|string',
        ]);

        $trip = $this->tripService->startTrip(
            $validated['rental_booking_id'],
            $validated['armada_id'],
            $validated['user_id'],
            $validated['start_latitude'],
            $validated['start_longitude'],
            $validated['start_address']
        );

        return response()->json([
            'success' => true,
            'message' => 'Trip started successfully',
            'data' => $trip,
        ], 201);
    }

    /**
     * End a trip
     */
    public function endTrip(Request $request, int $tripId): JsonResponse
    {
        $validated = $request->validate([
            'end_latitude' => 'required|numeric|between:-90,90',
            'end_longitude' => 'required|numeric|between:-180,180',
            'end_address' => 'nullable|string',
        ]);

        $trip = $this->tripService->endTrip(
            $tripId,
            $validated['end_latitude'],
            $validated['end_longitude'],
            $validated['end_address']
        );

        return response()->json([
            'success' => true,
            'message' => 'Trip ended successfully',
            'data' => $trip,
        ]);
    }

    /**
     * Get trip details
     */
    public function getTripDetails(int $tripId): JsonResponse
    {
        $trip = $this->tripService->getTripDetails($tripId);

        if (!$trip) {
            return response()->json([
                'success' => false,
                'message' => 'Trip not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $trip,
        ]);
    }

    /**
     * Get active trips
     */
    public function getActiveTrips(): JsonResponse
    {
        $trips = $this->tripService->getActiveTrips();

        return response()->json([
            'success' => true,
            'count' => $trips->count(),
            'data' => $trips,
        ]);
    }

    /**
     * Get trip history for a vehicle
     */
    public function getVehicleTripHistory($armadaId, Request $request): JsonResponse
    {
        $daysBack = $request->get('days', 30);
        $history = $this->tripService->getVehicleTripHistory($armadaId, $daysBack);

        return response()->json([
            'success' => true,
            'count' => $history->count(),
            'data' => $history,
        ]);
    }

    /**
     * Get trip history for a booking
     */
    public function getBookingTripHistory($bookingId): JsonResponse
    {
        $history = $this->tripService->getBookingTripHistory($bookingId);

        return response()->json([
            'success' => true,
            'count' => $history->count(),
            'data' => $history,
        ]);
    }

    /**
     * Get vehicle statistics
     */
    public function getVehicleStatistics($armadaId, Request $request): JsonResponse
    {
        $daysBack = $request->get('days', 30);
        $stats = $this->tripService->getVehicleStatistics($armadaId, $daysBack);

        return response()->json([
            'success' => true,
            'data' => $stats,
        ]);
    }

    /**
     * Get daily revenue
     */
    public function getDailyRevenue($armadaId, Request $request): JsonResponse
    {
        $date = $request->get('date') ? 
            \Carbon\Carbon::parse($request->get('date')) : 
            today();

        $revenue = $this->tripService->getDailyRevenue($armadaId, $date);

        return response()->json([
            'success' => true,
            'date' => $date->format('Y-m-d'),
            'revenue' => round($revenue, 2),
        ]);
    }

    /**
     * Get trip route polyline
     */
    public function getTripRoute(int $tripId): JsonResponse
    {
        $polyline = $this->tripService->encodePolyline($tripId);

        if (!$polyline) {
            return response()->json([
                'success' => false,
                'message' => 'Trip route not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $polyline,
        ]);
    }
}
