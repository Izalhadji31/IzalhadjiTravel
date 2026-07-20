<?php

namespace App\Http\Controllers;

use App\Models\AirportTransferBooking;
use App\Models\Armada;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AirportTransferController extends Controller
{
    /**
     * Display airport transfer bookings
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $bookings = AirportTransferBooking::query();

        if ($user->role !== 'admin') {
            $bookings->where('user_id', $user->id);
        }

        if ($request->has('status') && $request->status !== 'all') {
            $bookings->where('status', $request->status);
        }

        if ($request->has('transfer_type') && $request->transfer_type !== 'all') {
            $bookings->where('transfer_type', $request->transfer_type);
        }

        $bookings = $bookings->with(['user', 'assignedArmada', 'assignedDriver'])
                             ->latest()
                             ->paginate(10);

        return view('bookings.airport-transfer', compact('bookings'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $armadas = Armada::where('is_available', true)
                         ->where('is_active', true)
                         ->get();

        return view('bookings.airport-transfer-create', compact('armadas'));
    }

    /**
     * Store booking
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        if (! $user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();
            session()->put('verification.intended', route('bookings.airport-transfer.create'));

            return redirect()->route('verification.notice')
                ->with('status', 'Link verifikasi telah dikirim ke email Anda. Silakan klik link untuk melanjutkan pemesanan.');
        }

        // Check identity verification
        if (!$user->is_identity_verified) {
            return redirect()->route('profile.edit')
                           ->with('error', 'Silakan verifikasi identitas Anda sebelum melakukan pemesanan');
        }

        $validated = $request->validate([
            'passenger_name' => 'required|string|max:255',
            'passenger_phone' => 'required|string|max:20',
            'pickup_location' => 'required|string|max:255',
            'dropoff_location' => 'required|string|max:255',
            'scheduled_date' => 'required|date|after:today',
            'departure_time' => 'required|date_format:H:i',
            'number_of_passengers' => 'required|integer|min:1|max:8',
            'transfer_type' => 'required|in:one_way,round_trip',
            'return_date' => 'nullable|date|after:scheduled_date|required_if:transfer_type,round_trip',
            'flight_number' => 'nullable|string|max:20',
            'airline' => 'nullable|string|max:100',
            'flight_arrival_time' => 'nullable|date_format:Y-m-d H:i',
            'special_requests' => 'nullable|string|max:500',
            'base_price' => 'required|numeric|min:0',
            'total_price' => 'required|numeric|min:0',
        ]);

        // Create booking
        $booking = AirportTransferBooking::create([
            'user_id' => $user->id,
            'booking_code' => 'ATB-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6)),
            'passenger_name' => $validated['passenger_name'],
            'passenger_phone' => $validated['passenger_phone'],
            'pickup_location' => $validated['pickup_location'],
            'dropoff_location' => $validated['dropoff_location'],
            'scheduled_date' => $validated['scheduled_date'] . ' ' . $validated['departure_time'],
            'departure_time' => $validated['departure_time'],
            'number_of_passengers' => $validated['number_of_passengers'],
            'transfer_type' => $validated['transfer_type'],
            'return_date' => $validated['return_date'] ?? null,
            'flight_number' => $validated['flight_number'] ?? null,
            'airline' => $validated['airline'] ?? null,
            'flight_arrival_time' => $validated['flight_arrival_time'] ?? null,
            'special_requests' => $validated['special_requests'] ?? null,
            'base_price' => $validated['base_price'],
            'total_price' => $validated['total_price'],
            'status' => 'pending',
            'company_id' => $user->company_id,
        ]);

        // Send WhatsApp notification
        try {
            $notificationService = app(\App\Services\BookingNotificationService::class);
            $notificationService->notifyBookingCreated($booking);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Notification failed: ' . $e->getMessage());
        }

        return redirect()->route('payments.airport', $booking->id)
                       ->with('success', 'Pemesanan airport transfer berhasil. Silakan selesaikan pembayaran.');
    }

    /**
     * Show booking details
     */
    public function show(AirportTransferBooking $airportTransferBooking)
    {
        $this->authorize('view', $airportTransferBooking);

        return view('bookings.airport-transfer-show', [
            'booking' => $airportTransferBooking->load([
                'user',
                'assignedArmada',
                'assignedDriver',
                'payments',
                'reviews'
            ])
        ]);
    }

    /**
     * Show edit form
     */
    public function edit(AirportTransferBooking $airportTransferBooking)
    {
        $this->authorize('update', $airportTransferBooking);

        $armadas = Armada::where('is_available', true)
                         ->where('is_active', true)
                         ->get();

        return view('bookings.airport-transfer-edit', compact('airportTransferBooking', 'armadas'));
    }

    /**
     * Update booking
     */
    public function update(Request $request, AirportTransferBooking $airportTransferBooking)
    {
        $this->authorize('update', $airportTransferBooking);

        // Only allow updates if booking is pending
        if (!$airportTransferBooking->isPending()) {
            return back()->with('error', 'Hanya pemesanan yang belum dikonfirmasi yang bisa diubah');
        }

        $validated = $request->validate([
            'passenger_name' => 'required|string|max:255',
            'passenger_phone' => 'required|string|max:20',
            'pickup_location' => 'required|string|max:255',
            'dropoff_location' => 'required|string|max:255',
            'scheduled_date' => 'required|date|after:today',
            'departure_time' => 'required|date_format:H:i',
            'number_of_passengers' => 'required|integer|min:1|max:8',
            'special_requests' => 'nullable|string|max:500',
        ]);

        $airportTransferBooking->update([
            'passenger_name' => $validated['passenger_name'],
            'passenger_phone' => $validated['passenger_phone'],
            'pickup_location' => $validated['pickup_location'],
            'dropoff_location' => $validated['dropoff_location'],
            'scheduled_date' => $validated['scheduled_date'] . ' ' . $validated['departure_time'],
            'departure_time' => $validated['departure_time'],
            'number_of_passengers' => $validated['number_of_passengers'],
            'special_requests' => $validated['special_requests'] ?? null,
        ]);

        return redirect()->route('bookings.airport-transfer.show', $airportTransferBooking)
                       ->with('success', 'Pemesanan berhasil diperbarui!');
    }

    /**
     * Cancel booking
     */
    public function cancel(Request $request, AirportTransferBooking $airportTransferBooking)
    {
        $this->authorize('delete', $airportTransferBooking);

        if (!$airportTransferBooking->isPending() && !$airportTransferBooking->isConfirmed()) {
            return back()->with('error', 'Hanya pemesanan yang belum selesai yang bisa dibatalkan');
        }

        $airportTransferBooking->update([
            'status' => 'cancelled',
            'notes' => 'Dibatalkan pada ' . now() . ' - Alasan: ' . ($request->reason ?? '-'),
        ]);

        return redirect()->route('bookings.airport-transfer')
                       ->with('success', 'Pemesanan berhasil dibatalkan!');
    }

    /**
     * Destroy booking
     */
    public function destroy(AirportTransferBooking $airportTransferBooking)
    {
        $this->authorize('delete', $airportTransferBooking);

        $airportTransferBooking->delete();

        return redirect()->route('bookings.airport-transfer')
                       ->with('success', 'Pemesanan berhasil dihapus!');
    }
}
