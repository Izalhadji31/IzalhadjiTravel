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
     * Tampilkan formulir ulasan untuk pemesanan yang sudah selesai.
     */
    public function create($booking)
    {
        $user = Auth::user();

        // Cari pemesanan travel terlebih dahulu.
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

        // Hanya pemesanan selesai yang dapat diberi ulasan.
        if ($booking->status !== 'completed') {
            return back()->with('error', 'Hanya pemesanan yang sudah selesai yang dapat diberi ulasan.');
        }

        // Cegah ulasan ganda.
        $existingReview = Review::where('booking_id', $booking->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk pemesanan ini.');
        }

        // Ambil info driver dari armada.
        $driver = null;
        if ($booking->armada && $booking->armada->driver_phone) {
            $driver = \App\Models\User::where('phone', $booking->armada->driver_phone)->first();
        }

        return view('reviews.create', compact('booking', 'bookingType', 'driver'));
    }

    /**
     * Simpan ulasan.
     */
    public function store(Request $request, $booking)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Cari pemesanan.
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

        // Hanya pemesanan selesai yang dapat diberi ulasan.
        if ($bookingModel->status !== 'completed') {
            return back()->with('error', 'Hanya pemesanan yang sudah selesai yang dapat diberi ulasan.');
        }

        // Cegah ulasan ganda.
        $existingReview = Review::where('booking_id', $bookingModel->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk pemesanan ini.');
        }

        // Ambil ID driver.
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
            ->with('success', 'Terima kasih atas ulasan Anda!');
    }
}
