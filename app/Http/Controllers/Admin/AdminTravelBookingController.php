<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TravelBooking;
use App\Services\TravelBookingService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminTravelBookingController extends Controller
{
    protected $bookingService;

    public function __construct(TravelBookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    /**
     * Get all travel bookings
     */
    public function index(Request $request)
    {
        $bookings = TravelBooking::query();

        if ($request->has('status')) {
            $bookings->where('status', $request->status);
        }

        if ($request->has('user_id')) {
            $bookings->where('user_id', $request->user_id);
        }

        if ($request->has('route_id')) {
            $bookings->where('route_id', $request->route_id);
        }

        if ($request->has('date_from')) {
            $bookings->whereDate('scheduled_date', '>=', $request->date_from);
        }

        if ($request->has('date_to')) {
            $bookings->whereDate('scheduled_date', '<=', $request->date_to);
        }

        $bookings = $bookings->with(['user', 'route', 'assignedArmada'])
                            ->latest()
                            ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $bookings,
        ]);
    }

    /**
     * Get single booking
     */
    public function show(TravelBooking $travelBooking)
    {
        $travelBooking->load(['user', 'route', 'assignedArmada', 'payments']);

        return response()->json([
            'success' => true,
            'data' => $travelBooking,
        ]);
    }

    /**
     * Assign armada to booking
     */
    public function assignArmada(Request $request, TravelBooking $travelBooking)
    {
        $validated = $request->validate([
            'armada_id' => 'required|exists:armadas,id',
        ]);

        try {
            $booking = $this->bookingService->confirmBooking($travelBooking, $validated['armada_id']);
            $booking->load(['user', 'route', 'assignedArmada']);

            return response()->json([
                'success' => true,
                'message' => 'Armada assigned successfully',
                'data' => $booking,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Complete booking
     */
    public function complete(TravelBooking $travelBooking)
    {
        try {
            $booking = $this->bookingService->completeBooking($travelBooking);
            $booking->load(['user', 'route', 'assignedArmada']);

            return response()->json([
                'success' => true,
                'message' => 'Booking completed successfully',
                'data' => $booking,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Cancel booking
     */
    public function cancel(TravelBooking $travelBooking)
    {
        try {
            $booking = $this->bookingService->cancelBooking($travelBooking);
            $booking->load(['user', 'route', 'assignedArmada']);

            return response()->json([
                'success' => true,
                'message' => 'Booking cancelled successfully',
                'data' => $booking,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Get pending bookings for assignment
     */
    public function getPending()
    {
        $bookings = TravelBooking::pending()
                                ->with(['user', 'route'])
                                ->orderBy('scheduled_date')
                                ->get();

        return response()->json([
            'success' => true,
            'data' => $bookings,
            'count' => $bookings->count(),
        ]);
    }

    /**
     * Get upcoming bookings
     */
    public function getUpcoming(Request $request)
    {
        $bookings = TravelBooking::upcoming()
                                ->with(['user', 'route', 'assignedArmada'])
                                ->orderBy('scheduled_date')
                                ->get();

        if ($request->has('limit')) {
            $bookings = $bookings->take($request->limit);
        }

        return response()->json([
            'success' => true,
            'data' => $bookings,
            'count' => $bookings->count(),
        ]);
    }

    /**
     * Get bookings statistics
     */
    public function getStats()
    {
        $stats = [
            'pending' => TravelBooking::where('status', 'pending')->count(),
            'confirmed' => TravelBooking::where('status', 'confirmed')->count(),
            'completed' => TravelBooking::where('status', 'completed')->count(),
            'cancelled' => TravelBooking::where('status', 'cancelled')->count(),
            'total_revenue' => TravelBooking::where('status', 'completed')
                                           ->sum('total_price'),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats,
        ]);
    }
}
