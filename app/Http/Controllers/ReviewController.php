<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\TravelBooking;
use App\Models\RentalBooking;
use App\Models\AirportTransferBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Tampilkan formulir ulasan untuk pemesanan yang sudah selesai.
     */
    public function create(mixed $booking)
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
            $booking = AirportTransferBooking::with(['user', 'armada'])
                ->where('id', $booking)
                ->where('user_id', $user->id)
                ->first();
            $bookingType = 'airport_transfer';
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
    public function store(Request $request, mixed $booking)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'review_type' => 'nullable|in:cleanliness,comfort,driver,price,overall',
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
            $bookingModel = AirportTransferBooking::where('id', $booking)
                ->where('user_id', $user->id)
                ->first();
            $bookingType = 'airport_transfer';
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
            'review_type' => $validated['review_type'] ?? 'overall',
            'is_verified' => true,
            'status' => 'pending', // Default to pending for admin approval
        ]);

        return redirect()->route('bookings.index')
            ->with('success', 'Terima kasih atas ulasan Anda! Ulasan Anda akan ditinjau oleh admin sebelum ditampilkan.');
    }

    /**
     * Admin: Display all reviews for moderation
     */
    public function index(Request $request)
    {
        $status = $request->get('status', '');
        
        $query = Review::with(['user', 'ratedUser', 'booking'])
            ->orderBy('created_at', 'desc');
        
        if ($status) {
            $query->where('status', $status);
        }
        
        $reviews = $query->paginate(20);
        
        // Get statistics
        $totalReviews = Review::count();
        $pendingReviews = Review::where('status', 'pending')->count();
        $avgRating = Review::where('status', 'approved')->avg('rating');

        return view('admin.reviews', compact('reviews', 'status', 'totalReviews', 'pendingReviews', 'avgRating'));
    }

    /**
     * Admin: Approve a review
     */
    public function approve(Review $review)
    {
        $review->approve();
        
        return back()->with('success', 'Ulasan berhasil disetujui.');
    }

    /**
     * Admin: Reject a review
     */
    public function reject(Review $review)
    {
        $review->reject();
        
        return back()->with('success', 'Ulasan berhasil ditolak.');
    }

    /**
     * Admin: Delete a review
     */
    public function destroy(Review $review)
    {
        $review->delete();
        
        return back()->with('success', 'Ulasan berhasil dihapus.');
    }
}
