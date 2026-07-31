<?php

namespace App\Http\Controllers;

use App\Models\RentalBooking;
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
        return view('bookings.rental-create');
    }

    /**
     * Store booking
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Email verification check - disabled for development, can be enabled later
        // if (! $user->hasVerifiedEmail()) {
        //     $user->sendEmailVerificationNotification();
        //     session()->put('verification.intended', route('bookings.rental.create'));

        //     return redirect()->route('verification.notice')
        //         ->with('status', 'Link verifikasi telah dikirim ke email Anda. Silakan klik link untuk melanjutkan pemesanan.');
        // }

        $validated = $request->validate([
            'area_type'      => 'required|in:dalam_kota,luar_kota',
            'destination'    => 'nullable|string|max:255',
            'start_date'     => 'required|date|after:today',
            'end_date'       => 'nullable|date|after_or_equal:start_date',
            'rental_type'    => 'required|in:with_driver,without_driver',
            'regency_count'  => 'nullable|integer|min:1|max:15',
            'pickup_location'=> 'nullable|string|max:255',
            'notes'          => 'nullable|string|max:1000',
            'vehicle_name'   => 'nullable|string|max:255',
        ]);

        // Default end_date to start_date + 1 day if not provided
        if (empty($validated['end_date'])) {
            $validated['end_date'] = date('Y-m-d', strtotime($validated['start_date'] . ' +1 day'));
        }

        $isLuarKota   = $validated['area_type'] === 'luar_kota';
        $regencyCount = $isLuarKota ? ($validated['regency_count'] ?? 1) : 0;
        $withDriver   = $validated['rental_type'] === 'with_driver';

        // Generate booking code
        $bookingCode = 'RNT-' . now()->format('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(6));

        // Build notes with area/destination info for admin
        $adminNote = '[' . ($isLuarKota ? 'Luar Kota Ende' : 'Dalam Kota Ende') . ']';
        if ($isLuarKota && !empty($validated['destination'])) {
            $adminNote .= ' Tujuan: ' . $validated['destination'];
            $adminNote .= ' | Kabupaten: ' . $regencyCount;
        }
        if (!empty($validated['vehicle_name'])) {
            $adminNote .= ' | Kendaraan Diminta: ' . $validated['vehicle_name'];
        }
        if (!empty($validated['notes'])) {
            $adminNote .= ' | Catatan: ' . $validated['notes'];
        }

        // Use DB insert to handle legacy non-nullable columns safely
        $bookingId = (string) \Illuminate\Support\Str::uuid();
        $now = now();

        // Get a placeholder vehicle_id (first available) or auto-create fallback
        $vehicleId = \Illuminate\Support\Facades\DB::table('vehicles')->value('id');
        if (!$vehicleId) {
            $vehicleId = (string) \Illuminate\Support\Str::uuid();
            \Illuminate\Support\Facades\DB::table('vehicles')->insert([
                'id'           => $vehicleId,
                'plate_number' => 'EB 1001 AS',
                'brand'        => 'Toyota',
                'model'        => 'Innova Reborn',
                'year'         => 2023,
                'service_type' => 'rental',
                'total_seats'  => 7,
                'daily_rate'   => 500000,
                'status'       => 'available',
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }

        \Illuminate\Support\Facades\DB::table('rental_bookings')->insert([
            'id'              => $bookingId,
            'user_id'         => $user->id,
            'vehicle_id'      => $vehicleId,   // placeholder; admin will assign real armada
            'booking_code'    => $bookingCode,
            'rental_type'     => $validated['rental_type'],
            'with_driver'     => $withDriver ? 1 : 0,
            'regency_count'   => $regencyCount,
            'base_price'      => 0,
            'driver_fee'      => 0,
            'start_date'      => $validated['start_date'],
            'end_date'        => $validated['end_date'],
            'days'            => max(1, (int) ceil((strtotime($validated['end_date']) - strtotime($validated['start_date'])) / 86400)),
            'daily_rate'      => 0,
            'total_price'     => 0,
            'discount'        => 0,
            'final_price'     => 0,
            'pickup_location' => $validated['pickup_location'] ?? null,
            'notes'           => $adminNote,
            'status'          => 'pending',
            'payment_status'  => 'unpaid',
            'created_at'      => $now,
            'updated_at'      => $now,
        ]);

        $booking = RentalBooking::find($bookingId);

        // Send WhatsApp notification
        try {
            $notificationService = app(\App\Services\BookingNotificationService::class);
            $notificationService->notifyBookingCreated($booking);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Notification failed: ' . $e->getMessage());
        }

        return redirect()->route('payments.rental', $booking->id)
                       ->with('success', 'Pemesanan rental berhasil dibuat! Kode: ' . $bookingCode . '. Admin akan menghubungi Anda untuk konfirmasi dan detail harga.');
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
