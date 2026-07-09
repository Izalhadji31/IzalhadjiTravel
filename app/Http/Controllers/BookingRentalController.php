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

        // Check identity verification — skip jika kolom belum ada
        if (\Illuminate\Support\Facades\Schema::hasColumn('users', 'is_identity_verified') && !$user->is_identity_verified) {
            return redirect()->route('profile.edit')
                           ->with('error', 'Silakan verifikasi identitas Anda sebelum melakukan pemesanan');
        }

        $validated = $request->validate([
            'route_id' => 'required|exists:routes,id',
            'start_date' => 'required|date|after:today',
            'end_date' => 'nullable|date|after:start_date',
            'rental_type' => 'required|in:with_driver,without_driver',
            'regency_count' => 'required_if:rental_type,with_driver|integer|min:1',
        ]);

        // If end_date not provided, default to start_date + 1 day
        if (empty($validated['end_date'])) {
            $validated['end_date'] = date('Y-m-d', strtotime($validated['start_date'] . ' +1 day'));
        }

        $rentalPrice = RentalPrice::where('route_id', $validated['route_id'])->first();
        
        if (!$rentalPrice) {
            return back()->with('error', 'Harga rental untuk rute ini belum tersedia.')->withInput();
        }
        
        $base_price = $rentalPrice->price_without_driver ?? 0;

        // Calculate driver fee if needed
        $driver_fee = 0;
        if ($validated['rental_type'] === 'with_driver') {
            $num_regencies = $validated['regency_count'] ?? 2;
            $driver_fee = $num_regencies * ($rentalPrice->driver_fee_per_regency ?? 0);
        }

        $total_price = $base_price + $driver_fee;

        $withDriver = $validated['rental_type'] === 'with_driver';

        $booking = RentalBooking::create([
            'user_id' => $user->id,
            'route_id' => $validated['route_id'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'rental_type' => $validated['rental_type'],
            'with_driver' => $withDriver,
            'total_price' => $total_price,
            'status' => 'pending',
        ]);

        // Generate booking code if not auto-generated
        if (empty($booking->booking_code)) {
            $booking->update([
                'booking_code' => 'RNT-' . now()->format('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(6))
            ]);
        }

        // Send WhatsApp notification
        try {
            $notificationService = app(\App\Services\BookingNotificationService::class);
            $notificationService->notifyBookingCreated($booking);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Notification failed: ' . $e->getMessage());
        }

        return redirect()->route('payments.rental', $booking->id)
                       ->with('success', 'Pemesanan rental berhasil. Silakan selesaikan pembayaran.');
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
            return back()->with('error', 'Pemesanan sudah dibatalkan');
        }

        $booking->update(['status' => 'cancelled']);
        return back()->with('success', 'Pemesanan berhasil dibatalkan');
    }
}
