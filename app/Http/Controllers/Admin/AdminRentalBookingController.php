<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RentalBooking;
use App\Services\RentalBookingService;
use Illuminate\Http\Request;

class AdminRentalBookingController extends Controller
{
    protected $bookingService;

    public function __construct(RentalBookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    /**
     * Get all rental bookings
     */
    public function index(Request $request)
    {
        $bookings = RentalBooking::query();

        if ($request->has('status')) {
            $bookings->where('status', $request->status);
        }

        if ($request->has('user_id')) {
            $bookings->where('user_id', $request->user_id);
        }

        if ($request->has('route_id')) {
            $bookings->where('route_id', $request->route_id);
        }

        if ($request->has('rental_type')) {
            $bookings->where('rental_type', $request->rental_type);
        }

        if ($request->has('date_from')) {
            $bookings->whereDate('start_date', '>=', $request->date_from);
        }

        if ($request->has('date_to')) {
            $bookings->whereDate('start_date', '<=', $request->date_to);
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
    public function show(RentalBooking $rentalBooking)
    {
        $rentalBooking->load(['user', 'route', 'assignedArmada', 'payments']);

        return response()->json([
            'success' => true,
            'data' => $rentalBooking,
        ]);
    }

    /**
     * Assign armada to booking
     */
    public function assignArmada(Request $request, RentalBooking $rentalBooking)
    {
        $validated = $request->validate([
            'armada_id' => 'required|exists:armadas,id',
        ]);

        try {
            $booking = $this->bookingService->confirmBooking($rentalBooking, $validated['armada_id']);
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
    public function complete(RentalBooking $rentalBooking)
    {
        try {
            $booking = $this->bookingService->completeBooking($rentalBooking);
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
    public function cancel(RentalBooking $rentalBooking)
    {
        try {
            $booking = $this->bookingService->cancelBooking($rentalBooking);
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
        $bookings = RentalBooking::pending()
                                ->with(['user', 'route'])
                                ->orderBy('start_date')
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
        $bookings = RentalBooking::upcoming()
                                ->with(['user', 'route', 'assignedArmada'])
                                ->orderBy('start_date')
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
            'pending' => RentalBooking::where('status', 'pending')->count(),
            'confirmed' => RentalBooking::where('status', 'confirmed')->count(),
            'completed' => RentalBooking::where('status', 'completed')->count(),
            'cancelled' => RentalBooking::where('status', 'cancelled')->count(),
            'total_revenue' => RentalBooking::where('status', 'completed')
                                           ->sum('total_price'),
            'with_driver' => RentalBooking::where('rental_type', 'with_driver')
                                         ->where('status', 'completed')
                                         ->count(),
            'without_driver' => RentalBooking::where('rental_type', 'without_driver')
                                            ->where('status', 'completed')
                                            ->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats,
        ]);
    }
}
