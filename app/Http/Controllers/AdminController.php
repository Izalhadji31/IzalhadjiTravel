<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TravelBooking;
use App\Models\RentalBooking;
use App\Models\Armada;
use App\Models\Payment;
use App\Models\RevenueSharing;
use App\Models\Review;
use App\Models\Voucher;
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

        $booking->assigned_armada_id = $request->armada_id;
        $booking->status = 'confirmed';
        $booking->save();

        // Send WhatsApp notification to customer
        try {
            $notificationService = app(\App\Services\BookingNotificationService::class);
            $notificationService->notifyBookingConfirmed($booking);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Notification failed: ' . $e->getMessage());
        }

        return back()->with('success', ucfirst($type) . ' booking approved and armada assigned successfully');
    }

    /**
     * Complete a booking
     */
    public function completeBooking($type, $id)
    {
        if ($type === 'travel') {
            $booking = TravelBooking::findOrFail($id);
        } elseif ($type === 'rental') {
            $booking = RentalBooking::findOrFail($id);
        } else {
            return back()->with('error', 'Invalid booking type');
        }

        if (!in_array($booking->status, ['confirmed', 'departed'])) {
            return back()->with('error', 'Only confirmed or departed bookings can be completed');
        }

        $booking->status = 'completed';
        $booking->save();

        // Send WhatsApp notification to customer
        try {
            $notificationService = app(\App\Services\BookingNotificationService::class);
            $notificationService->notifyBookingCompleted($booking);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Notification failed: ' . $e->getMessage());
        }

        return back()->with('success', ucfirst($type) . ' booking marked as completed');
    }

    /**
     * Cancel a booking
     */
    public function cancelBooking($type, $id)
    {
        if ($type === 'travel') {
            $booking = TravelBooking::findOrFail($id);
        } elseif ($type === 'rental') {
            $booking = RentalBooking::findOrFail($id);
        } else {
            return back()->with('error', 'Invalid booking type');
        }

        if (in_array($booking->status, ['completed', 'cancelled'])) {
            return back()->with('error', 'This booking cannot be cancelled');
        }

        $booking->status = 'cancelled';
        $booking->save();

        // Send WhatsApp notification to customer
        try {
            $notificationService = app(\App\Services\BookingNotificationService::class);
            $notificationService->notifyBookingCancelled($booking);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Notification failed: ' . $e->getMessage());
        }

        return back()->with('success', ucfirst($type) . ' booking cancelled');
    }

    /**
     * Show booking detail with armada assignment
     */
    public function showBooking($type, $id)
    {
        if ($type === 'travel') {
            $booking = TravelBooking::with(['user', 'route', 'armada', 'payments'])->findOrFail($id);
        } elseif ($type === 'rental') {
            $booking = RentalBooking::with(['user', 'route', 'armada', 'payments'])->findOrFail($id);
        } else {
            abort(404, 'Invalid booking type');
        }

        $availableArmadas = Armada::where('status', 'tersedia')
            ->orderBy('plate_number')
            ->get();

        return view('admin.booking-detail', compact('booking', 'type', 'availableArmadas'));
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
        $revenueSharings = RevenueSharing::where('mitra_id', $mitraId)
            ->where('status', 'pending')
            ->get();

        if ($revenueSharings->isEmpty()) {
            return back()->with('error', 'No pending payouts found for this partner');
        }

        $totalPayout = $revenueSharings->sum('partner_amount');

        RevenueSharing::where('mitra_id', $mitraId)
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
            ->addSelect(['total_trips' => function ($query) {
                $query->selectRaw('COALESCE((SELECT COUNT(*) FROM travel_bookings WHERE travel_bookings.assigned_armada_id IN (SELECT id FROM armadas WHERE armadas.driver_phone = users.phone)), 0) + COALESCE((SELECT COUNT(*) FROM rental_bookings WHERE rental_bookings.assigned_armada_id IN (SELECT id FROM armadas WHERE armadas.driver_phone = users.phone)), 0)');
            }])
            ->addSelect(['total_earnings' => RevenueSharing::query()
                ->selectRaw('COALESCE(SUM(driver_amount), 0)')
                ->where(function ($q) {
                    $q->where(function ($q2) {
                        $q2->where('booking_type', TravelBooking::class)
                            ->whereIn('booking_id', function ($q3) {
                                $q3->select('id')->from('travel_bookings')
                                    ->whereIn('assigned_armada_id', function ($q4) {
                                        $q4->select('a.id')->from('armadas as a')
                                            ->join('drivers as d', 'd.phone', '=', 'a.driver_phone')
                                            ->whereColumn('d.user_id', 'users.id');
                                    });
                            });
                    })->orWhere(function ($q2) {
                        $q2->where('booking_type', RentalBooking::class)
                            ->whereIn('booking_id', function ($q3) {
                                $q3->select('id')->from('rental_bookings')
                                    ->whereIn('assigned_armada_id', function ($q4) {
                                        $q4->select('a.id')->from('armadas as a')
                                            ->join('drivers as d', 'd.phone', '=', 'a.driver_phone')
                                            ->whereColumn('d.user_id', 'users.id');
                                    });
                            });
                    });
                })
            ])
            ->latest()
            ->paginate(15);

        return view('admin.drivers', compact('drivers'));
    }

    /**
     * Show payments management page
     */
    public function payments(Request $request)
    {
        $status = $request->get('status', '');
        $dateFrom = $request->get('date_from', '');
        $dateTo = $request->get('date_to', '');

        // Base query with booking relationship and nested user
        $query = Payment::with(['booking' => function ($morphTo) {
            $morphTo->morphWith([
                TravelBooking::class => ['user'],
                RentalBooking::class => ['user'],
            ]);
        }]);

        // Apply status filter
        if ($status) {
            $query->where('status', $status);
        }

        // Apply date range filter
        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        // Calculate stats (before pagination)
        $allQuery = Payment::query();
        if ($dateFrom) {
            $allQuery->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $allQuery->whereDate('created_at', '<=', $dateTo);
        }

        $totalAmount = (clone $allQuery)->sum('amount');
        $totalSuccess = (clone $allQuery)->where('status', 'success')->sum('amount');
        $totalPending = (clone $allQuery)->where('status', 'pending')->sum('amount');
        $totalFailed = (clone $allQuery)->where('status', 'failed')->sum('amount');

        // Paginate results
        $payments = $query->latest()->paginate(15)->withQueryString();

        return view('admin.payments', compact(
            'payments',
            'totalAmount',
            'totalSuccess',
            'totalPending',
            'totalFailed'
        ));
    }

    /**
     * Show revenue sharing detail page with filters
     */
    public function revenueSharing(Request $request)
    {
        $dateFrom = $request->get('date_from', '');
        $dateTo = $request->get('date_to', '');
        $status = $request->get('status', 'all');
        $bookingType = $request->get('booking_type', 'all');

        // Base query with relationships
        $query = RevenueSharing::with(['booking' => function ($morphTo) {
            $morphTo->morphWith([
                TravelBooking::class => ['user'],
                RentalBooking::class => ['user'],
            ]);
        }, 'mitra', 'payment']);

        // Apply date range filter
        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        // Apply status filter
        if ($status !== 'all') {
            $query->where('status', $status);
        }

        // Apply booking type filter
        if ($bookingType === 'travel') {
            $query->where('booking_type', 'App\\Models\\TravelBooking');
        } elseif ($bookingType === 'rental') {
            $query->where('booking_type', 'App\\Models\\RentalBooking');
        }

        // Calculate totals for stats (using same filters)
        $statsQuery = clone $query;
        $stats = $statsQuery->selectRaw('
            COALESCE(SUM(admin_amount), 0) as total_admin,
            COALESCE(SUM(mitra_amount), 0) as total_mitra,
            COALESCE(SUM(driver_amount), 0) as total_driver,
            COALESCE(SUM(admin_amount + mitra_amount + driver_amount), 0) as total_overall
        ')->first();

        $totalAdminShare = $stats->total_admin ?? 0;
        $totalMitraShare = $stats->total_mitra ?? 0;
        $totalDriverShare = $stats->total_driver ?? 0;
        $totalOverall = $stats->total_overall ?? 0;

        // Partner summary (group by mitra_id)
        $partnerSummaryQuery = clone $query;
        $partnerData = $partnerSummaryQuery
            ->selectRaw('
                mitra_id,
                COUNT(*) as total_bookings,
                COALESCE(SUM(admin_amount), 0) as admin_total,
                COALESCE(SUM(mitra_amount), 0) as mitra_total,
                COALESCE(SUM(driver_amount), 0) as driver_total,
                COALESCE(SUM(admin_amount + mitra_amount + driver_amount), 0) as grand_total,
                SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as pending_count
            ', ['pending'])
            ->groupBy('mitra_id')
            ->get();

        // Enrich partner data with names
        $partnerSummary = $partnerData->map(function ($item) {
            $mitra = \App\Models\Mitra::find($item->mitra_id);
            return [
                'mitra_id' => $item->mitra_id,
                'name' => $mitra->name ?? 'Unknown Partner',
                'total_bookings' => $item->total_bookings,
                'admin_total' => $item->admin_total,
                'mitra_total' => $item->mitra_total,
                'driver_total' => $item->driver_total,
                'grand_total' => $item->grand_total,
                'pending_count' => $item->pending_count,
            ];
        })->sortByDesc('grand_total')->values();

        // Paginate results
        $revenueSharings = $query->latest()->paginate(15)->withQueryString();

        return view('admin.revenue-sharing', compact(
            'revenueSharings',
            'totalAdminShare',
            'totalMitraShare',
            'totalDriverShare',
            'totalOverall',
            'partnerSummary'
        ));
    }

    /**
     * Export revenue sharing data as CSV
     */
    public function exportRevenueSharingCSV(Request $request)
    {
        $dateFrom = $request->get('date_from', '');
        $dateTo = $request->get('date_to', '');
        $status = $request->get('status', 'all');
        $bookingType = $request->get('booking_type', 'all');

        $query = RevenueSharing::with(['booking', 'mitra']);

        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        if ($bookingType === 'travel') {
            $query->where('booking_type', 'App\\Models\\TravelBooking');
        } elseif ($bookingType === 'rental') {
            $query->where('booking_type', 'App\\Models\\RentalBooking');
        }

        $revenueSharings = $query->latest()->get();

        $filename = 'revenue-sharing-' . date('Y-m-d-His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($revenueSharings) {
            $file = fopen('php://output', 'w');
            // BOM for UTF-8
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($file, ['Date', 'Booking Code', 'Partner', 'Admin %', 'Mitra %', 'Driver %', 'Admin Amount', 'Mitra Amount', 'Driver Amount', 'Total Amount', 'Status']);

            foreach ($revenueSharings as $sharing) {
                $bookingCode = $sharing->booking ? ($sharing->booking->booking_code ?? 'N/A') : 'N/A';
                $partnerName = $sharing->mitra ? ($sharing->mitra->name ?? 'N/A') : 'N/A';
                fputcsv($file, [
                    $sharing->created_at ? $sharing->created_at->format('Y-m-d H:i') : '-',
                    $bookingCode,
                    $partnerName,
                    $sharing->admin_percentage . '%',
                    $sharing->mitra_percentage . '%',
                    $sharing->driver_percentage . '%',
                    $sharing->admin_amount,
                    $sharing->mitra_amount,
                    $sharing->driver_amount,
                    $sharing->getTotalAmount(),
                    ucfirst($sharing->status),
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Show single revenue sharing detail (payout view)
     */
    public function showRevenueSharing(RevenueSharing $revenueSharing)
    {
        $revenueSharing->load(['booking' => function ($morphTo) {
            $morphTo->morphWith([
                TravelBooking::class => ['user', 'route', 'armada'],
                RentalBooking::class => ['user', 'route', 'armada'],
            ]);
        }, 'mitra', 'payment']);

        return view('admin.revenue-sharing-show', compact('revenueSharing'));
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

    /**
     * List vouchers
     */
    public function vouchers()
    {
        $vouchers = Voucher::latest()->paginate(20);
        return view('admin.vouchers', compact('vouchers'));
    }

    /**
     * Store voucher
     */
    public function storeVoucher(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:vouchers,code',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:1',
            'max_discount' => 'nullable|numeric|min:1',
            'usage_limit' => 'nullable|integer|min:1',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after:valid_from',
            'description' => 'nullable|string|max:255',
        ]);

        Voucher::create($validated);
        return back()->with('success', 'Voucher created successfully');
    }

    /**
     * Delete voucher
     */
    public function destroyVoucher(Voucher $voucher)
    {
        $voucher->delete();
        return back()->with('success', 'Voucher deleted successfully');
    }

    /**
     * Show review moderation page
     */
    public function reviews(Request $request)
    {
        $status = $request->get('status', '');

        $reviews = Review::with(['user', 'booking'])
            ->when($status, function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $totalReviews = Review::count();
        $pendingReviews = Review::where('status', 'pending')->count();
        $avgRating = Review::where('status', 'approved')->avg('rating');

        return view('admin.reviews', compact(
            'reviews',
            'totalReviews',
            'pendingReviews',
            'avgRating',
            'status'
        ));
    }

    /**
     * Approve a review
     */
    public function approveReview(Review $review)
    {
        $review->status = 'approved';
        $review->save();

        return back()->with('success', 'Review approved successfully');
    }

    /**
     * Reject a review
     */
    public function rejectReview(Review $review)
    {
        $review->status = 'rejected';
        $review->save();

        return back()->with('success', 'Review rejected successfully');
    }

    /**
     * Show newsletter subscribers list
     */
    public function newsletters(Request $request)
    {
        $query = \App\Models\Newsletter::query();

        // Search by email or name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('email', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%");
            });
        }

        // Filter by subscription status
        if ($request->filled('subscribed')) {
            $query->where('subscribed', $request->subscribed === 'yes');
        }

        $subscribers = $query->latest()->paginate(20);

        $totalSubscribers = \App\Models\Newsletter::count();
        $activeSubscribers = \App\Models\Newsletter::where('subscribed', true)->count();

        return view('admin.newsletters', compact('subscribers', 'totalSubscribers', 'activeSubscribers'));
    }
}
