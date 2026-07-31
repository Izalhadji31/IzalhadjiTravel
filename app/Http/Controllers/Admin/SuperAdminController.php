<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use App\Models\User;
use App\Models\TravelBooking;
use App\Models\RentalBooking;
use App\Models\Payment;
use App\Models\Mitra;
use App\Models\Armada;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class SuperAdminController extends Controller
{
    /**
     * Dashboard - Show global metrics
     */
    public function dashboard()
    {
        // Overall metrics
        $totalCompanies = Company::count();
        $activeCompanies = Company::where('status', 'active')->count();
        $totalUsers = User::count();
        $totalRevenue = Payment::where('status', 'settlement')->sum('amount');
        
        // Recent transactions
        $recentTransactions = Payment::with('user')
            ->where('status', 'settlement')
            ->latest()
            ->limit(10)
            ->get();

        // Companies by subscription
        $companySubscriptions = Company::groupBy('subscription_plan')
            ->selectRaw('subscription_plan, COUNT(*) as count')
            ->get();

        // Monthly revenue trend
        $monthlyRevenue = Payment::where('status', 'settlement')
            ->where('created_at', '>=', Carbon::now()->subMonths(12))
            ->selectRaw('DATE_TRUNC(\'month\', created_at) as month, SUM(amount) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('admin.super-admin.dashboard', [
            'totalCompanies' => $totalCompanies,
            'activeCompanies' => $activeCompanies,
            'totalUsers' => $totalUsers,
            'totalRevenue' => $totalRevenue,
            'recentTransactions' => $recentTransactions,
            'companySubscriptions' => $companySubscriptions,
            'monthlyRevenue' => $monthlyRevenue,
        ]);
    }

    /**
     * List all companies
     */
    public function companies()
    {
        $companies = Company::with('adminUser')
            ->paginate(15);

        return view('admin.super-admin.companies.index', [
            'companies' => $companies,
        ]);
    }

    /**
     * Show company details
     */
    public function showCompany(Company $company)
    {
        $company->load(['users', 'mitras', 'travelBookings', 'rentalBookings']);
        
        $stats = [
            'total_users' => $company->users()->count(),
            'total_mitras' => $company->mitras()->count(),
            'total_vehicles' => $company->mitras()->sum('vehicle_count'),
            'total_bookings' => $company->travelBookings()->count() + $company->rentalBookings()->count(),
            'total_revenue' => Payment::whereHasMorph('booking', 
                [TravelBooking::class, RentalBooking::class],
                function ($query) use ($company) {
                    $query->where('company_id', $company->id);
                }
            )->sum('amount'),
        ];

        return view('admin.super-admin.companies.show', [
            'company' => $company,
            'stats' => $stats,
        ]);
    }

    /**
     * Create company
     */
    public function createCompany()
    {
        return view('admin.super-admin.companies.create');
    }

    /**
     * Store company
     */
    public function storeCompany(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:companies',
            'slug' => 'required|string|max:255|unique:companies',
            'email' => 'required|email|unique:companies',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'province' => 'nullable|string',
            'subscription_plan' => 'required|in:starter,professional,enterprise',
            'max_users' => 'required|integer|min:1',
            'max_vehicles' => 'required|integer|min:1',
        ]);

        $company = Company::create($validated);

        return redirect()->route('super-admin.companies.show', $company)
            ->with('success', 'Company created successfully');
    }

    /**
     * Update company
     */
    public function updateCompany(Company $company, Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:companies,name,' . $company->id,
            'email' => 'required|email|unique:companies,email,' . $company->id,
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'status' => 'required|in:active,inactive,suspended,trial',
            'subscription_plan' => 'required|in:starter,professional,enterprise',
            'max_users' => 'required|integer|min:1',
            'max_vehicles' => 'required|integer|min:1',
        ]);

        $company->update($validated);

        return redirect()->back()->with('success', 'Company updated successfully');
    }

    /**
     * Suspend company
     */
    public function suspendCompany(Company $company)
    {
        $company->suspend();
        return redirect()->back()->with('success', 'Company suspended');
    }

    /**
     * Activate company
     */
    public function activateCompany(Company $company)
    {
        $company->activate();
        return redirect()->back()->with('success', 'Company activated');
    }

    /**
     * List all users with company info
     */
    public function users()
    {
        $users = User::with('company')
            ->paginate(20);

        return view('admin.super-admin.users.index', [
            'users' => $users,
        ]);
    }

    /**
     * Global analytics
     */
    public function analytics()
    {
        // Revenue by company
        $revenueByCompany = Company::with(['travelBookings', 'rentalBookings'])
            ->get()
            ->map(function ($company) {
                $revenue = Payment::whereHasMorph('booking', 
                    [TravelBooking::class, RentalBooking::class],
                    function ($query) use ($company) {
                        $query->where('company_id', $company->id);
                    }
                )->where('status', 'settlement')->sum('amount');
                
                return [
                    'name' => $company->name,
                    'revenue' => $revenue,
                ];
            })
            ->sortByDesc('revenue');

        // Top mitras globally
        $topMitras = Mitra::withSum('revenueSharings', 'mitra_amount')
            ->orderByDesc('revenue_sharings_sum_mitra_amount')
            ->limit(10)
            ->get();

        // Payment methods distribution
        $paymentMethods = Payment::selectRaw('payment_method, COUNT(*) as count, SUM(amount) as total')
            ->where('status', 'settlement')
            ->groupBy('payment_method')
            ->get();

        return view('admin.super-admin.analytics.index', [
            'revenueByCompany' => $revenueByCompany,
            'topMitras' => $topMitras,
            'paymentMethods' => $paymentMethods,
        ]);
    }

    /**
     * Settings
     */
    public function settings()
    {
        return view('admin.super-admin.settings.index');
    }

    /**
     * Update settings
     */
    public function updateSettings(Request $request)
    {
        // Update global settings like commission rates, etc.
        // This can be stored in a settings table or .env

        return redirect()->back()->with('success', 'Settings updated');
    }
}
