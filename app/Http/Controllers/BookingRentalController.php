<?php

namespace App\Http\Controllers;

use App\Models\RentalBooking;
use App\Models\Route;
use App\Models\RentalPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingRentalController extends Controller
{
    /**
     * Display rental bookings
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $bookings = RentalBooking::query();

        if ($user->role !== 'admin') {
            $bookings->where('user_id', $user->id);
        }

        if ($request->has('status') && $request->status !== 'all') {
            $bookings->where('status', $request->status);
        }

        $bookings = $bookings->with(['user', 'route', 'armada'])
                             ->latest()
                             ->paginate(10);

        return view('bookings.rental', compact('bookings'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $routes = Route::where('is_active', true)
                       ->where(fn($query) => $query
                           ->where('route_type', 'rental')
                           ->orWhere('route_type', 'both'))
                       ->get();

        return view('bookings.rental-create', compact('routes'));
    }

    /**
     * Store booking
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Check identity verification
        if (!$user->is_identity_verified) {
            return redirect()->route('profile.edit')
                           ->with('error', 'Please verify your identity before booking');
        }

        $validated = $request->validate([
            'route_id' => 'required|exists:routes,id',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
            'with_driver' => 'boolean',
        ]);

        $rentalPrice = RentalPrice::where('route_id', $validated['route_id'])->first();
        $base_price = $rentalPrice->price_without_driver;

        // Calculate driver fee if needed
        $driver_fee = 0;
        if ($validated['with_driver']) {
            // Count regencies (for this demo, assume 2 regencies per route)
            $num_regencies = 2;
            $driver_fee = $num_regencies * $rentalPrice->driver_fee_per_regency;
        }

        $total_price = $base_price + $driver_fee;

        $booking = RentalBooking::create([
            'user_id' => $user->id,
            'route_id' => $validated['route_id'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'with_driver' => $validated['with_driver'],
            'total_price' => $total_price,
            'status' => 'pending',
        ]);

        return redirect()->route('bookings.rental.show', $booking->id)
                       ->with('success', 'Rental booking created. Please complete payment');
    }

    /**
     * Show booking details
     */
    public function show(RentalBooking $booking)
    {
        $this->authorize('view', $booking);
        $booking->load(['user', 'route', 'armada']);
        return view('bookings.rental-show', compact('booking'));
    }

    /**
     * Cancel booking
     */
    public function destroy(RentalBooking $booking)
    {
        $this->authorize('delete', $booking);

        if ($booking->status === 'cancelled') {
            return back()->with('error', 'Booking already cancelled');
        }

        $booking->update(['status' => 'cancelled']);
        return back()->with('success', 'Booking cancelled successfully');
    }
}
