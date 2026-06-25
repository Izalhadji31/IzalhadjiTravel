<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TravelBooking;
use App\Models\RentalBooking;
use App\Models\Route;
use App\Models\Payment;
use App\Models\Mitra;
use App\Models\Driver;
use App\Models\Armada;
use App\Models\RevenueSharing;
use App\Models\TripTracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show dashboard
     */
    public function index()
    {
        $user = Auth::user();

        // 1. Branching for Admin
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        // 2. Branching for Partner/Mitra
        if ($user->isPartner() || $user->role === 'partner') {
            $partner = $user->partnerProfile;
            
            // Fallback in case profile is not yet created
            if (!$partner) {
                $partner = Mitra::where('email', $user->email)->first();
            }

            $armadas = $partner ? $partner->armadas : collect();
            $totalVehicles = $armadas->count();
            $activeVehicles = $armadas->where('status', 'jalan')->count();
            $availableVehicles = $armadas->where('status', 'tersedia')->count();
            $maintenanceVehicles = $armadas->where('status', 'maintenance')->count();

            $revenueSharings = $partner 
                ? RevenueSharing::where('mitra_id', $partner->id)->latest()->take(10)->get() 
                : collect();

            $totalEarnings = $partner ? $partner->total_earnings : 0;

            return view('dashboard.partner', compact(
                'partner',
                'armadas',
                'totalVehicles',
                'activeVehicles',
                'availableVehicles',
                'maintenanceVehicles',
                'revenueSharings',
                'totalEarnings'
            ));
        }

        // 3. Branching for Driver/Sopir
        if ($user->isDriver()) {
            $driver = $user->driverProfile;
            $armada = $user->armada;

            // Fallback: match by phone if relation returned null
            if (!$armada && $user->phone) {
                $armada = Armada::where('driver_phone', $user->phone)->first();
            }

            // Fetch active assignments assigned to their armada
            $activeTravels = collect();
            $activeRentals = collect();
            $completedTripsCount = 0;

            if ($armada) {
                $activeTravels = TravelBooking::where('assigned_armada_id', $armada->id)
                    ->whereIn('status', ['confirmed', 'departed'])
                    ->with(['route', 'user'])
                    ->latest()
                    ->get();

                $activeRentals = RentalBooking::where('assigned_armada_id', $armada->id)
                    ->whereIn('status', ['confirmed', 'active'])
                    ->with(['route', 'user'])
                    ->latest()
                    ->get();
                
                $completedTripsCount = TripTracking::where('armada_id', $armada->id)
                    ->where('status', 'completed')
                    ->count();
            }

            $driverBalance = $driver ? $driver->balance : 0;
            $driverStatus = $driver ? $driver->status : 'offline';
            $driverTripsCount = $driver ? $driver->total_trips : $completedTripsCount;

            return view('dashboard.driver', compact(
                'driver',
                'armada',
                'activeTravels',
                'activeRentals',
                'driverBalance',
                'driverStatus',
                'driverTripsCount'
            ));
        }

        // 4. Branching for Customer/User
        // Count total bookings (Travel + Rental)
        $travelBookings = TravelBooking::where('user_id', $user->id)->count();
        $rentalBookings = RentalBooking::where('user_id', $user->id)->count();
        $totalBookings = $travelBookings + $rentalBookings;

        // Count pending bookings
        $pendingBookings = TravelBooking::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();

        // Count active routes
        $activeRoutes = Route::where('is_active', true)->count();

        // Total revenue from travel bookings (via polymorphic relationship)
        $totalRevenue = Payment::where('booking_type', 'App\\Models\\TravelBooking')
            ->whereHas('booking', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->where('status', 'success')
            ->sum('amount');

        // Add rental booking revenue
        $rentalRevenue = Payment::where('booking_type', 'App\\Models\\RentalBooking')
            ->whereHas('booking', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->where('status', 'success')
            ->sum('amount');

        $totalRevenue += $rentalRevenue;

        // Recent bookings (Travel bookings only)
        $recentBookings = TravelBooking::where('user_id', $user->id)
            ->with('route')
            ->latest()
            ->take(5)
            ->get();

        // Completed bookings
        $completedBookings = TravelBooking::where('user_id', $user->id)
            ->where('status', 'completed')
            ->count();

        return view('dashboard.customer', compact(
            'totalBookings',
            'pendingBookings', 
            'activeRoutes',
            'totalRevenue',
            'recentBookings',
            'travelBookings',
            'rentalBookings',
            'completedBookings'
        ));
    }
}
