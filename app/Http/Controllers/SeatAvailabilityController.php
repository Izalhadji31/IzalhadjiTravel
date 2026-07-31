<?php

namespace App\Http\Controllers;

use App\Services\SeatAvailabilityService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class SeatAvailabilityController extends Controller
{
    protected SeatAvailabilityService $seatAvailabilityService;

    public function __construct(SeatAvailabilityService $seatAvailabilityService)
    {
        $this->seatAvailabilityService = $seatAvailabilityService;
    }

    /**
     * Get seat availability for a route and date
     */
    public function getAvailability(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'route_id' => 'required|uuid',
            'travel_date' => 'required|date|after_or_equal:today',
            'armada_id' => 'nullable|uuid',
        ]);

        $availability = $this->seatAvailabilityService->getSeatAvailability(
            $validated['route_id'],
            $validated['travel_date'],
            $validated['armada_id'] ?? null
        );

        return response()->json([
            'success' => true,
            'data' => $availability,
        ]);
    }

    /**
     * Lock seats for temporary hold (Web/Session Auth)
     */
    public function lockSeats(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'route_id' => 'required|uuid',
            'travel_date' => 'required|date|after_or_equal:today',
            'armada_id' => 'nullable|uuid',
            'seat_numbers' => 'required|array|min:1',
            'seat_numbers.*' => 'integer|min:1|max:6',
            'lock_minutes' => 'nullable|integer|min:5|max:30',
        ]);

        $userId = Auth::id();
        $lockMinutes = $validated['lock_minutes'] ?? 15;

        $result = $this->seatAvailabilityService->lockSeats(
            $validated['route_id'],
            $validated['travel_date'],
            $validated['armada_id'] ?? null,
            $validated['seat_numbers'],
            $userId,
            $lockMinutes
        );

        return response()->json([
            'success' => $result['success'],
            'data' => $result,
        ]);
    }

    /**
     * Unlock seats
     */
    public function unlockSeats(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'route_id' => 'required|uuid',
            'travel_date' => 'required|date',
            'armada_id' => 'nullable|uuid',
            'seat_numbers' => 'required|array|min:1',
            'seat_numbers.*' => 'integer|min:1|max:6',
        ]);

        $userId = Auth::id();

        $result = $this->seatAvailabilityService->unlockSeats(
            $validated['route_id'],
            $validated['travel_date'],
            $validated['armada_id'] ?? null,
            $validated['seat_numbers'],
            $userId
        );

        return response()->json([
            'success' => $result['success'],
            'data' => $result,
        ]);
    }

    /**
     * Check if specific seats are available
     */
    public function checkAvailability(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'route_id' => 'required|uuid',
            'travel_date' => 'required|date|after_or_equal:today',
            'armada_id' => 'nullable|uuid',
            'seat_numbers' => 'required|array|min:1',
            'seat_numbers.*' => 'integer|min:1|max:6',
        ]);

        $availability = $this->seatAvailabilityService->checkSeatsAvailability(
            $validated['route_id'],
            $validated['travel_date'],
            $validated['armada_id'] ?? null,
            $validated['seat_numbers']
        );

        return response()->json([
            'success' => true,
            'data' => $availability,
        ]);
    }

    /**
     * Get user's locked seats
     */
    public function getUserLockedSeats(): JsonResponse
    {
        $userId = Auth::id();
        $lockedSeats = $this->seatAvailabilityService->getUserLockedSeats($userId);

        return response()->json([
            'success' => true,
            'data' => $lockedSeats,
        ]);
    }

    /**
     * Get availability for date range (for calendar view)
     */
    public function getDateRangeAvailability(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'route_id' => 'required|uuid',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
            'armada_id' => 'nullable|uuid',
        ]);

        $startDate = \Carbon\Carbon::parse($validated['start_date']);
        $endDate = \Carbon\Carbon::parse($validated['end_date']);

        $availability = $this->seatAvailabilityService->getAvailabilityForDateRange(
            $validated['route_id'],
            $startDate,
            $endDate,
            $validated['armada_id'] ?? null
        );

        return response()->json([
            'success' => true,
            'data' => $availability,
        ]);
    }

    /**
     * Cleanup user's expired locks
     */
    public function cleanupExpiredLocks(): JsonResponse
    {
        $userId = Auth::id();
        $cleaned = $this->seatAvailabilityService->cleanupUserExpiredLocks($userId);

        return response()->json([
            'success' => true,
            'data' => [
                'cleaned_count' => $cleaned,
            ],
        ]);
    }
}
