<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\TravelBooking;
use App\Models\RentalBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Show review form for a completed booking
     */
    public function create($booking)
    {
        $user = Auth::user();

        // Try to find booking in travel_bookings first
        $booking = TravelBooking::with(['user', 'route', 'armada'])
            ->where('id', $booking)
            ->where('user_id', $user->id)
            ->first();

        $bookingType = 'travel';

        if (!$booking) {
            $booking = RentalBooking::with(['user', 'route', 'armada'])
                ->where('id', $booking)
                ->where('user_id', $user->id)
                ->first();
            $bookingType = 'rental';
        }

        if (!$booking) {
            abort(404, 'Booking not found');
        }

        // Only completed bookings can be reviewed
        if ($booking->status !== 'completed') {
            return back()->with('error', 'Only completed bookings can be reviewed.');
        }

        // Check if already reviewed
        $existingReview = Review::where('booking_id', $booking->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'You have already reviewed this booking.');
        }

        // Get driver info from armada
        $driver = null;
        if ($booking->armada && $booking->armada->driver_phone) {
            $driver = \App\Models\User::where('phone', $booking->armada->driver_phone)->first();
        }

        return view('reviews.create', compact('booking', 'bookingType', 'driver'));
    }

    /**
     * Store review
     */
    public function store(Request $request, $booking)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Find booking
        $bookingModel = TravelBooking::where('id', $booking)
            ->where('user_id', $user->id)
            ->first();

        $bookingType = 'travel';

        if (!$bookingModel) {
            $bookingModel = RentalBooking::where('id', $booking)
                ->where('user_id', $user->id)
                ->first();
            $bookingType = 'rental';
        }

        if (!$bookingModel) {
            abort(404, 'Booking not found');
        }

        // Only completed bookings
        if ($bookingModel->status !== 'completed') {
            return back()->with('error', 'Only completed bookings can be reviewed.');
        }

        // Prevent duplicate reviews
        $existingReview = Review::where('booking_id', $bookingModel->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'You have already reviewed this booking.');
        }

        // Get driver id
        $driverId = null;
        if ($bookingModel->armada && $bookingModel->armada->driver_phone) {
            $driver = \App\Models\User::where('phone', $bookingModel->armada->driver_phone)->first();
            $driverId = $driver?->id;
        }

        Review::create([
            'user_id' => $user->id,
            'booking_id' => $bookingModel->id,
            'rated_user_id' => $driverId,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
            'review_type' => 'overall',
            'is_verified' => true,
        ]);

        return redirect()->route('bookings.show', $bookingModel->id)
            ->with('success', 'Thank you for your review!');
    }
}
