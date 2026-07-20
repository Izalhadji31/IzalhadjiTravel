<?php

namespace App\Http\Controllers;

use App\Models\TravelBooking;
use App\Models\Route;
use App\Models\TravelPrice;
use App\Services\BookingNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class BookingTravelController extends Controller
{
    /**
     * Display travel bookings
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $bookings = TravelBooking::query();

        if ($user->role !== 'admin') {
            $bookings->where('user_id', $user->id);
        }

        if ($request->has('status') && $request->status !== 'all') {
            $bookings->where('status', $request->status);
        }

        $bookings = $bookings->with(['user', 'route', 'armada'])
                             ->latest()
                             ->paginate(10);

        $pendingCount = TravelBooking::where('status', 'pending')->count();
        $confirmedCount = TravelBooking::where('status', 'confirmed')->count();
        $completedCount = TravelBooking::where('status', 'completed')->count();

        return view('bookings.travel', compact('bookings', 'pendingCount', 'confirmedCount', 'completedCount'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $routes = Route::where('is_active', true)
                       ->where(fn($query) => $query
                           ->where('route_type', 'travel')
                           ->orWhere('route_type', 'both'))
                       ->get();

        return view('bookings.travel-create', compact('routes'));
    }

    /**
     * Store booking
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        if (! $user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();
            session()->put('verification.intended', route('bookings.travel.create'));

            return redirect()->route('verification.notice')
                ->with('status', 'Link verifikasi telah dikirim ke email Anda. Silakan klik link untuk melanjutkan pemesanan.');
        }

        // Check identity verification — skip jika kolom belum ada
        if (Schema::hasColumn('users', 'is_identity_verified') && !$user->is_identity_verified) {
            return redirect()->route('profile.edit')
                           ->with('error', 'Silakan verifikasi identitas Anda sebelum melakukan pemesanan');
        }

        $validated = $request->validate([
            'route_id' => 'required|exists:routes,id',
            'travel_date' => 'required_without:scheduled_date|date|after:today',
            'scheduled_date' => 'required_without:travel_date|date|after:today',
            'number_of_seats' => 'required|integer|min:1|max:16',
            'passengers' => 'nullable|array',
            'passengers.*.name' => 'required_with:passengers|string|max:255',
            'passengers.*.nik' => 'required_with:passengers|string|max:50',
            'passengers.*.seat_number' => 'required_with:passengers|string|max:10',
        ]);

        $travelPrice = TravelPrice::where('route_id', $validated['route_id'])->first();
        $seatPrice = $travelPrice?->price_per_seat ?? 0;
        $total_price = $seatPrice * $validated['number_of_seats'];
        $scheduledDate = $validated['travel_date'] ?? $validated['scheduled_date'];

        $booking = TravelBooking::create([
            'user_id' => $user->id,
            'route_id' => $validated['route_id'],
            'booking_code' => 'TRV-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6)),
            'passenger_count' => $validated['number_of_seats'],
            'number_of_seats' => $validated['number_of_seats'],
            'scheduled_date' => $scheduledDate,
            'departure_time' => $scheduledDate,
            'total_price' => $total_price,
            'final_price' => $total_price,
            'status' => 'pending',
        ]);

        // Store passengers if provided
        if (!empty($validated['passengers'])) {
            foreach ($validated['passengers'] as $passengerData) {
                \App\Models\BookingPassenger::create([
                    'travel_booking_id' => $booking->id,
                    'name' => $passengerData['name'],
                    'nik' => $passengerData['nik'],
                    'seat_number' => $passengerData['seat_number'],
                ]);
            }
        }

        // Send WhatsApp notification
        try {
            $notificationService = app(BookingNotificationService::class);
            $notificationService->notifyBookingCreated($booking);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Notification failed: ' . $e->getMessage());
        }

        return redirect()->route('payments.travel', $booking->id)
                       ->with('success', 'Pemesanan travel berhasil. Silakan selesaikan pembayaran.');
    }

    /**
     * Show booking details
     */
    public function show(TravelBooking $booking)
    {
        $this->authorize('view', $booking);
        $booking->load(['user', 'route', 'armada']);
        return view('bookings.travel-show', compact('booking'));
    }

    /**
     * Cancel booking
     */
    public function destroy(TravelBooking $booking)
    {
        $this->authorize('delete', $booking);

        if ($booking->status === 'cancelled') {
            return back()->with('error', 'Pemesanan sudah dibatalkan');
        }

        $booking->update(['status' => 'cancelled']);
        return back()->with('success', 'Pemesanan berhasil dibatalkan');
    }
}
