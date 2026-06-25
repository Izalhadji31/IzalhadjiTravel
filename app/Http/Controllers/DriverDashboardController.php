<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Driver;
use App\Models\Armada;
use App\Models\TravelBooking;
use App\Models\RentalBooking;
use App\Models\TripTracking;
use App\Models\RevenueSharing;
use App\Services\TripTrackingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverDashboardController extends Controller
{
    public function __construct(
        private TripTrackingService $tripService
    ) {}

    /**
     * Show driver dashboard
     */
    public function index()
    {
        $user = Auth::user();
        $driver = $user->driverProfile;
        $armada = $user->armada;

        if (!$armada && $user->phone) {
            $armada = Armada::where('driver_phone', $user->phone)->first();
        }

        $balance = $driver ? $driver->balance : 0;
        $totalTrips = $driver ? $driver->total_trips : 0;
        $driverStatus = $driver ? $driver->status : 'offline';

        // Count active orders
        $activeOrderCount = 0;
        if ($armada) {
            $activeOrderCount = TravelBooking::where('assigned_armada_id', $armada->id)
                ->whereIn('status', ['confirmed', 'departed'])
                ->count()
                + RentalBooking::where('assigned_armada_id', $armada->id)
                ->whereIn('status', ['confirmed', 'departed', 'active'])
                ->count();
        }

        return view('driver.dashboard', compact(
            'armada',
            'driver',
            'balance',
            'totalTrips',
            'driverStatus',
            'activeOrderCount'
        ));
    }

    /**
     * Toggle driver availability status
     */
    public function toggleStatus(Request $request)
    {
        $request->validate([
            'status' => 'required|in:available,offline,busy,on_leave'
        ]);

        $user = Auth::user();
        $driver = $user->driverProfile;

        if (!$driver) {
            // Fallback: create driver profile if not exists
            $driver = Driver::create([
                'user_id' => $user->id,
                'phone' => $user->phone ?? '0800000000',
                'sim_number' => 'SIM-' . strtoupper(uniqid()),
                'sim_expiry' => now()->addYears(5),
                'address' => $user->address ?? 'Ende',
                'status' => $request->status,
            ]);
        } else {
            $driver->update(['status' => $request->status]);
        }

        return back()->with('success', 'Status keaktifan berhasil diubah menjadi ' . $request->status);
    }

    /**
     * Start a trip (Accept & depart)
     */
    public function startTrip(Request $request, $bookingId, $type)
    {
        $user = Auth::user();
        $armada = $user->armada;

        if (!$armada && $user->phone) {
            $armada = Armada::where('driver_phone', $user->phone)->first();
        }

        if (!$armada) {
            return back()->with('error', 'Anda belum ditugaskan ke armada manapun.');
        }

        // Set default coordinates for Ende
        $lat = -8.84;
        $lng = 121.66;

        if ($type === 'travel') {
            $booking = TravelBooking::findOrFail($bookingId);
            $booking->update([
                'status' => 'departed',
                'departure_time' => now()
            ]);
        } else {
            $booking = RentalBooking::findOrFail($bookingId);
            $booking->update([
                'status' => 'active',
                'start_time' => now()
            ]);
        }

        // Set armada to jalan
        $armada->setToJalan();

        // Create trip tracking record for rental only (since DB schema restricts rental_booking_id to NOT NULL)
        if ($type === 'rental') {
            TripTracking::create([
                'rental_booking_id' => $booking->id,
                'armada_id' => $armada->id,
                'user_id' => $booking->user_id,
                'start_latitude' => $lat,
                'start_longitude' => $lng,
                'start_address' => $booking->route ? $booking->route->origin_city : 'Kota Asal',
                'start_time' => now(),
                'status' => 'ongoing',
            ]);
        }

        return back()->with('success', 'Perjalanan telah dimulai! Semoga selamat sampai tujuan.');
    }

    /**
     * Complete a trip
     */
    public function completeTrip(Request $request, $bookingId, $type)
    {
        $user = Auth::user();
        $driver = $user->driverProfile;
        $armada = $user->armada;

        if (!$armada && $user->phone) {
            $armada = Armada::where('driver_phone', $user->phone)->first();
        }

        if (!$armada) {
            return back()->with('error', 'Armada tidak ditemukan.');
        }

        $lat = -8.84;
        $lng = 121.66;

        // Find and complete trip tracking
        $trip = TripTracking::where('armada_id', $armada->id)
            ->where('status', 'ongoing')
            ->first();

        if ($trip) {
            $trip->update([
                'end_latitude' => $lat,
                'end_longitude' => $lng,
                'end_address' => $trip->rentalBooking ? ($trip->rentalBooking->route ? $trip->rentalBooking->route->destination_city : 'Kota Tujuan') : 'Kota Tujuan',
                'end_time' => now(),
                'status' => 'completed',
                'duration_minutes' => now()->diffInMinutes($trip->start_time)
            ]);
        }

        $earnedAmount = 0;
        if ($type === 'travel') {
            $booking = TravelBooking::findOrFail($bookingId);
            $booking->update([
                'status' => 'completed',
                'arrival_time' => now()
            ]);
            $earnedAmount = 50000; // Flat travel trip fee
        } else {
            $booking = RentalBooking::findOrFail($bookingId);
            $booking->update([
                'status' => 'completed',
                'end_date' => now()
            ]);
            $earnedAmount = floatval($booking->driver_fee) > 0 ? floatval($booking->driver_fee) : 100000; // Driver fee or fallback
        }

        // Set armada back to available
        $armada->setToAvailable();

        // Increment driver balance and trip count
        if ($driver) {
            $driver->increment('balance', $earnedAmount);
            $driver->increment('total_trips');
        }

        return back()->with('success', 'Perjalanan telah selesai! Saldo Anda bertambah sebesar Rp ' . number_format($earnedAmount, 0, ',', '.'));
    }


    /**
     * Show driver's active orders (confirmed/departed)
     */
    public function orders()
    {
        $user = Auth::user();
        $armada = $user->armada;

        if (!$armada && $user->phone) {
            $armada = Armada::where('driver_phone', $user->phone)->first();
        }

        $orders = collect();

        if ($armada) {
            $travelOrders = TravelBooking::with(['user', 'route'])
                ->where('assigned_armada_id', $armada->id)
                ->whereIn('status', ['confirmed', 'departed'])
                ->get()
                ->map(function ($booking) {
                    $booking->order_type = 'travel';
                    return $booking;
                });

            $rentalOrders = RentalBooking::with(['user', 'route'])
                ->where('assigned_armada_id', $armada->id)
                ->whereIn('status', ['confirmed', 'departed', 'active'])
                ->get()
                ->map(function ($booking) {
                    $booking->order_type = 'rental';
                    return $booking;
                });

            $orders = $travelOrders->merge($rentalOrders)->sortByDesc(function ($order) {
                return $order->scheduled_date ?? $order->start_date;
            });
        }

        return view('driver.orders', compact('orders', 'armada'));
    }

    /**
     * Show driver's earnings history, balance, and trip history
     */
    public function earnings()
    {
        $user = Auth::user();
        $driver = $user->driverProfile;
        $armada = $user->armada;

        if (!$armada && $user->phone) {
            $armada = Armada::where('driver_phone', $user->phone)->first();
        }

        $balance = $driver ? $driver->balance : 0;
        $totalTrips = $driver ? $driver->total_trips : 0;

        // Get earnings history from RevenueSharing records linked to this driver's armada bookings
        $earningsHistory = collect();
        $totalEarnings = 0;
        $pendingEarnings = 0;

        if ($armada) {
            // Get all booking IDs assigned to this armada (both travel and rental)
            $travelBookingIds = TravelBooking::where('assigned_armada_id', $armada->id)->pluck('id');
            $rentalBookingIds = RentalBooking::where('assigned_armada_id', $armada->id)->pluck('id');

            // RevenueSharing records for travel bookings
            $travelEarnings = RevenueSharing::where('booking_type', TravelBooking::class)
                ->whereIn('booking_id', $travelBookingIds)
                ->orderBy('created_at', 'desc')
                ->get();

            // RevenueSharing records for rental bookings
            $rentalEarnings = RevenueSharing::where('booking_type', RentalBooking::class)
                ->whereIn('booking_id', $rentalBookingIds)
                ->orderBy('created_at', 'desc')
                ->get();

            // Merge and sort by created_at descending
            $earningsHistory = $travelEarnings->merge($rentalEarnings)->sortByDesc('created_at');

            // Calculate totals
            $totalEarnings = $earningsHistory->where('status', 'completed')->sum('driver_amount');
            $pendingEarnings = $earningsHistory->where('status', 'pending')->sum('driver_amount');
        }

        // Get trip history for this driver
        $tripHistory = TripTracking::when($armada, function ($query) use ($armada) {
                return $query->where('armada_id', $armada->id);
            })
            ->orderBy('start_time', 'desc')
            ->paginate(10);

        return view('driver.earnings', compact(
            'driver',
            'balance',
            'totalTrips',
            'earningsHistory',
            'totalEarnings',
            'pendingEarnings',
            'tripHistory'
        ));
    }
}
