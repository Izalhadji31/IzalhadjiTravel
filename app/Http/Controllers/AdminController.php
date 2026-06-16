<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TravelBooking;
use App\Models\RentalBooking;
use App\Models\Payment;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function dashboard()
    {
        $totalUsers = User::where('role', 'user')->count();
        $totalBookings = TravelBooking::count() + RentalBooking::count();
        $totalRevenue = Payment::where('status', 'completed')->sum('amount');
        $pendingBookings = TravelBooking::where('status', 'pending')->count();

        $recentUsers = User::where('role', 'user')
                           ->latest()
                           ->take(5)
                           ->get();

        $recentBookings = TravelBooking::with('user')
                                       ->latest()
                                       ->take(5)
                                       ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalBookings',
            'totalRevenue',
            'pendingBookings',
            'recentUsers',
            'recentBookings'
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
            'timezone' => 'required|timezone',
        ]);

        // Update settings (implement based on your settings storage)
        return back()->with('success', 'Settings updated successfully');
    }

    /**
     * Delete user
     */
    public function deleteUser(User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'Cannot delete admin users');
        }

        $user->delete();
        return redirect()->route('admin.users')
                       ->with('success', 'User deleted successfully');
    }
}
