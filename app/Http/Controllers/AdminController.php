<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TravelBooking;
use App\Models\RentalBooking;
use App\Models\Payment;
use App\Models\RevenueSharing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function dashboard()
    {
        $totalUsers = User::where('role', 'user')->count();
        $totalPartners = User::where('role', 'partner')->count();
        $totalDrivers = User::where('role', 'driver')->count();
        $totalBookings = TravelBooking::count() + RentalBooking::count();
        $totalRevenue = Payment::where('status', 'success')->sum('amount');
        $pendingBookings = TravelBooking::where('status', 'pending')->count()
            + RentalBooking::where('status', 'pending')->count();

        $recentUsers = User::latest()
                           ->take(5)
                           ->get();

        $recentTravelBookings = TravelBooking::with('user')
                                             ->latest()
                                             ->take(5)
                                             ->get();

        $recentRentalBookings = RentalBooking::with('user')
                                             ->latest()
                                             ->take(5)
                                             ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalPartners',
            'totalDrivers',
            'totalBookings',
            'totalRevenue',
            'pendingBookings',
            'recentUsers',
            'recentTravelBookings',
            'recentRentalBookings'
        ));
    }

    /**
     * Show user management
     */
    public function users()
    {
        $users = User::where('role', 'user')
                     ->latest()
                     ->paginate(10);

        return view('admin.users', compact('users'));
    }

    /**
     * Show settings
     */
    public function settings()
    {
        return view('admin.settings');
    }

    /**
     * Update settings
     */
    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'app_name' => 'required|string',
            'app_url' => 'required|url',
            'support_email' => 'required|email',
            'timezone' => 'required|string',
        ]);

        // Update settings (implement based on your settings storage)
        foreach ($validated as $key => $value) {
            setting([$key => $value]);
        }
        setting()->save();

        return back()->with('success', 'Settings updated successfully');
    }

    /**
     * Delete user
     */
    public function deleteUser($userId)
    {
        $user = User::findOrFail($userId);

        if ($user->role === 'admin') {
            return back()->with('error', 'Cannot delete admin users');
        }

        $user->delete();
        return redirect()->route('admin.users')
                         ->with('success', 'User deleted successfully');
    }

    /**
     * Manage all bookings (travel + rental) with status filter
     */
    public function manageBookings(Request $request)
    {
        $status = $request->get('status', 'all');

        $travelBookings = TravelBooking::with(['user', 'armada'])
            ->when($status !== 'all', function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $rentalBookings = RentalBooking::with(['user', 'armada'])
            ->when($status !== 'all', function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.bookings', compact('travelBookings', 'rentalBookings', 'status'));
    }

    /**
     * Approve booking and assign armada
     */
    public function approveBooking(Request $request, $type, $id)
    {
        $request->validate([
            'armada_id' => 'required|integer',
        ]);

        if ($type === 'travel') {
            $booking = TravelBooking::findOrFail($id);
        } elseif ($type === 'rental') {
            $booking = RentalBooking::findOrFail($id);
        } else {
            return back()->with('error', 'Invalid booking type');
        }

        if ($booking->status !== 'pending') {
            return back()->with('error', 'Only pending bookings can be approved');
        }

        $booking->armada_id = $request->armada_id;
        $booking->status = 'approved';
        $booking->save();

        return back()->with('success', ucfirst($type) . ' booking approved and armada assigned successfully');
    }

    /**
     * Manage partners with earnings data
     */
    public function managePartners()
    {
        $partners = User::where('role', 'partner')
            ->withCount(['revenueSharings as total_earnings' => function ($query) {
                $query->select(DB::raw('COALESCE(SUM(partner_amount), 0)'));
            }])
            ->withCount(['revenueSharings as pending_payouts' => function ($query) {
                $query->where('status', 'pending')->select(DB::raw('COALESCE(SUM(partner_amount), 0)'));
            }])
            ->latest()
            ->paginate(15);

        return view('admin.partners', compact('partners'));
    }

    /**
     * Process payout to partner (mark revenue sharing as completed)
     */
    public function payoutMitra(Request $request, $mitraId)
    {
        $revenueSharings = RevenueSharing::where('partner_id', $mitraId)
            ->where('status', 'pending')
            ->get();

        if ($revenueSharings->isEmpty()) {
            return back()->with('error', 'No pending payouts found for this partner');
        }

        $totalPayout = $revenueSharings->sum('partner_amount');

        RevenueSharing::where('partner_id', $mitraId)
            ->where('status', 'pending')
            ->update([
                'status' => 'completed',
                'paid_at' => now(),
            ]);

        // Optionally create a payout record or log
        return back()->with('success', 'Payout of Rp ' . number_format($totalPayout, 0, ',', '.') . ' processed successfully');
    }

    /**
     * Manage drivers with status and earnings
     */
    public function manageDrivers()
    {
        $drivers = User::where('role', 'driver')
            ->withCount(['bookings as total_trips' => function ($query) {
                $query->select(DB::raw('COUNT(*)'));
            }])
            ->withCount(['payments as total_earnings' => function ($query) {
                $query->where('status', 'success')->select(DB::raw('COALESCE(SUM(driver_amount), 0)'));
            }])
            ->latest()
            ->paginate(15);

        return view('admin.drivers', compact('drivers'));
    }

    /**
     * Approve/activate driver
     */
    public function approveDriver($driverId)
    {
        $user = User::where('role', 'driver')->findOrFail($driverId);
        $driver = $user->driverProfile;

        if (!$driver) {
            $driver = \App\Models\Driver::create([
                'user_id' => $user->id,
                'phone' => $user->phone ?? '0800000000',
                'sim_number' => 'PENDING-' . strtoupper(\Illuminate\Support\Str::random(8)),
                'sim_expiry' => now()->addYears(5),
                'address' => $user->address ?? '',
                'status' => 'available',
            ]);
            return back()->with('success', 'Driver profile created and activated');
        }

        if ($driver->status === 'available') {
            return back()->with('warning', 'Driver is already available');
        }

        $driver->status = 'available';
        $driver->save();

        return back()->with('success', 'Driver activated successfully');
    }
}
