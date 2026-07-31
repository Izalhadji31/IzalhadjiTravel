<?php

namespace App\Http\Controllers;

use App\Models\TravelBooking;
use App\Models\Route;
use App\Models\TravelPrice;
use App\Models\BookingPassenger;
use App\Models\TravelSeat;
use App\Rules\NikValidation;
use App\Rules\IndonesianPhoneValidation;
use App\Services\SeatAvailabilityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BookingTravelController extends Controller
{
    protected SeatAvailabilityService $seatAvailabilityService;

    public function __construct(SeatAvailabilityService $seatAvailabilityService)
    {
        $this->seatAvailabilityService = $seatAvailabilityService;
    }

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

        return view('bookings.travel', compact('bookings'));
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

        // Check identity verification
        if (!$user->is_identity_verified) {
            return redirect()->route('profile.edit')
                           ->with('error', 'Please verify your identity before booking');
        }

        $validated = $request->validate([
            'route_id' => 'required|exists:routes,id',
            'travel_date' => 'nullable|date|after:today',
            'scheduled_date' => 'nullable|date|after:today',
            'number_of_seats' => 'required|integer|min:1|max:6',
            'selected_seats' => 'required|string',
            'passenger_data' => 'required|array|min:1',
            'passenger_data.*.name' => 'required|string|max:255|min:3',
            'passenger_data.*.nik' => ['required', 'string', 'max:255', new NikValidation],
            'passenger_data.*.phone' => ['required', 'string', 'max:20', new IndonesianPhoneValidation],
        ]);

        // Parse selected_seats JSON
        $selectedSeats = json_decode($validated['selected_seats'], true);
        if (!is_array($selectedSeats) || count($selectedSeats) != $validated['number_of_seats']) {
            return back()->withInput()->with('error', 'Please select exactly ' . $validated['number_of_seats'] . ' seats');
        }

        // Check seat availability before proceeding
        $scheduledDate = $validated['travel_date'] ?? $validated['scheduled_date'];
        $seatCheck = $this->seatAvailabilityService->checkSeatsAvailability(
            $validated['route_id'],
            $scheduledDate,
            null, // armada_id - will be assigned later
            $selectedSeats
        );

        foreach ($seatCheck as $seatNumber => $availability) {
            if (!$availability['available']) {
                return back()->withInput()->with('error', "Kursi {$seatNumber} tidak tersedia. Silakan pilih kursi lain.");
            }
        }

        // Lock the seats for this user
        $lockResult = $this->seatAvailabilityService->lockSeats(
            $validated['route_id'],
            $scheduledDate,
            null, // armada_id - will be assigned later
            $selectedSeats,
            $user->id,
            15 // Lock for 15 minutes
        );

        if (!$lockResult['success']) {
            $failedSeats = implode(', ', array_column($lockResult['failed_seats'], 'seat_number'));
            return back()->withInput()->with('error', "Gagal mengunci kursi: {$failedSeats}. Kursi mungkin sudah dipesan oleh orang lain.");
        }

        $travelPrice = TravelPrice::where('route_id', $validated['route_id'])->first();
        $route = Route::findOrFail($validated['route_id']);
        $seatPrice = $travelPrice?->price_per_seat ?? $route->base_price ?? 0;
        $total_price = $seatPrice * $validated['number_of_seats'];
        $scheduledDate = $validated['travel_date'] ?? $validated['scheduled_date'];

        try {
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
                'selected_seats' => $selectedSeats,
                'passenger_data' => $validated['passenger_data'],
            ]);

            // Create passenger records
            foreach ($validated['passenger_data'] as $index => $passenger) {
                $booking->passengers()->create([
                    'name' => $passenger['name'],
                    'phone' => $passenger['phone'],
                    'email' => $user->email,
                    'id_type' => 'KTP',
                    'id_number' => $passenger['nik'],
                    'seat_number' => $selectedSeats[$index] ?? null,
                ]);
            }

            // Create travel seat records
            foreach ($selectedSeats as $index => $seatNumber) {
                TravelSeat::create([
                    'travel_booking_id' => $booking->id,
                    'seat_number' => $seatNumber,
                    'status' => 'booked',
                    'passenger_id' => $user->id,
                    'passenger_name' => $validated['passenger_data'][$index]['name'] ?? null,
                    'passenger_phone' => $validated['passenger_data'][$index]['phone'] ?? null,
                ]);
            }

            // Book the seats in the availability system
            $bookResult = $this->seatAvailabilityService->bookSeats(
                $validated['route_id'],
                $scheduledDate,
                null, // armada_id - will be assigned later
                $selectedSeats,
                $booking->id
            );

            if (!$bookResult['success']) {
                // Rollback booking if seat booking fails
                $booking->delete();
                throw new \Exception('Gagal memesan kursi: ' . implode(', ', array_column($bookResult['failed_seats'], 'seat_number')));
            }

            return redirect()->route('bookings.travel.show', $booking->id)
                           ->with('success', 'Booking created. Please complete payment');

        } catch (\Exception $e) {
            // Release seat locks if booking fails
            $this->seatAvailabilityService->releaseSeats(
                $validated['route_id'],
                $scheduledDate,
                null,
                $selectedSeats,
                $user->id
            );

            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Show booking details
     */
    public function show(TravelBooking $booking)
    {
        $this->authorize('view', $booking);
        $booking->load(['user', 'route', 'armada', 'passengers', 'seats']);
        return view('bookings.travel-show', compact('booking'));
    }

    /**
     * Cancel booking
     */
    public function destroy(TravelBooking $booking)
    {
        $this->authorize('delete', $booking);

        if ($booking->status === 'cancelled') {
            return back()->with('error', 'Booking already cancelled');
        }

        $booking->update(['status' => 'cancelled']);
        return back()->with('success', 'Booking cancelled successfully');
    }
}
