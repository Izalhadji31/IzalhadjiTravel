<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TrackingDashboardController;
use App\Http\Controllers\FleetDashboardController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\BookingTravelController;
use App\Http\Controllers\BookingRentalController;
use App\Http\Controllers\AirportTransferController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DriverDashboardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\IdentityVerificationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\Admin\CmsPageController;
use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RefundController;
use App\Http\Controllers\Admin\SuperAdminController;
use App\Http\Controllers\AdminRefundController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ChatController;


// Language Switch
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['id', 'en'])) {
        Session::put('locale', $locale);
        App::setLocale($locale);
        return redirect()->back()->withCookie(cookie()->forever('locale', $locale));
    }
    return redirect()->back();
})->name('lang.switch');

// Landing Page
Route::get('/', [PublicController::class, 'home'])->name('home');

// Public Pages (Guest Accessible)
Route::prefix('public')->group(function () {
    Route::get('/travel', [PublicController::class, 'travelList'])->name('public.travel');
    Route::get('/rental', [PublicController::class, 'rentalList'])->name('public.rental');
    Route::get('/vehicles', [PublicController::class, 'vehiclesList'])->name('public.vehicles');
    Route::get('/price-calculator', [PublicController::class, 'priceCalculator'])->name('public.price-calculator');
    Route::post('/calculate-price', [PublicController::class, 'calculatePrice'])->name('public.calculate-price');
    Route::get('/about', [PublicController::class, 'about'])->name('public.about');
    Route::get('/contact', [PublicController::class, 'contact'])->name('public.contact');
    Route::post('/contact', [PublicController::class, 'submitContact'])->name('public.contact.submit');
    Route::get('/destinasi', [PublicController::class, 'destinasi'])->name('public.destinasi');
    Route::get('/testimoni', [PublicController::class, 'testimoni'])->name('public.testimoni');
    Route::get('/faq', [PublicController::class, 'faq'])->name('public.faq');
    Route::get('/syarat-ketentuan', [PublicController::class, 'syaratKetentuan'])->name('public.syarat-ketentuan');
    Route::get('/kebijakan-privasi', [PublicController::class, 'kebijakanPrivasi'])->name('public.kebijakan-privasi');
    Route::get('/cek-booking', [PublicController::class, 'cekBooking'])->name('public.cek-booking');
    Route::get('/destinasi/{slug}', [PublicController::class, 'destinasiDetail'])->name('public.destinasi.detail');
    Route::get('/blog', [PublicController::class, 'blog'])->name('public.blog');
    Route::get('/blog/{slug}', [PublicController::class, 'blogDetail'])->name('public.blog.detail');
    Route::post('/subscribe', [PublicController::class, 'subscribe'])->name('public.subscribe');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/bookings', [BookingTravelController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [BookingTravelController::class, 'show'])->name('bookings.show');
});

// Booking & Payment Routes - Require Verified Email
Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/bookings/verified-store', [BookingTravelController::class, 'store'])->name('bookings.verified-store');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::get('/login/{role}', [LoginController::class, 'create'])->name('login.role');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

    // Forgot Password Routes
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');
});

Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

// Email Verification Routes (must be authenticated but NOT verified)
Route::middleware(['auth'])->group(function () {
    Route::get('/email/verify', [EmailVerificationController::class, 'showVerificationNotice'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])->middleware('signed')->name('verification.verify');
    Route::post('/email/resend', [EmailVerificationController::class, 'resend'])->name('verification.send');
});

// Protected Routes - Require Authentication
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Tracking Dashboard Routes
    Route::prefix('tracking')->group(function () {
        Route::get('/', [TrackingDashboardController::class, 'index'])->name('tracking.dashboard');
        Route::get('/map', [TrackingDashboardController::class, 'map'])->name('tracking.map');
        Route::get('/vehicle/{armadaId}', [TrackingDashboardController::class, 'vehicleDetails'])->name('tracking.vehicle');
        Route::get('/trip/{tripId}', [TrackingDashboardController::class, 'tripTracking'])->name('tracking.trip');
        Route::get('/active-bookings', [TrackingDashboardController::class, 'activeBookings'])->name('tracking.active-bookings');
        Route::get('/geofence', [TrackingDashboardController::class, 'geofence'])->name('tracking.geofence');
        Route::get('/offline-vehicles', [TrackingDashboardController::class, 'offlineVehicles'])->name('tracking.offline-vehicles');
        Route::get('/export/{armadaId}', [TrackingDashboardController::class, 'exportData'])->name('tracking.export');
    });

    // Fleet Management Dashboard Routes
    Route::middleware('role:admin')->prefix('fleet')->group(function () {
        Route::get('/', [FleetDashboardController::class, 'index'])->name('fleet.dashboard');
        Route::get('/vehicles', [FleetDashboardController::class, 'vehicles'])->name('fleet.vehicles');
        Route::get('/vehicle/{armadaId}', [FleetDashboardController::class, 'vehicleDetail'])->name('fleet.vehicle-detail');
        Route::get('/maintenance', [FleetDashboardController::class, 'maintenance'])->name('fleet.maintenance');
        Route::post('/maintenance/log', [FleetDashboardController::class, 'logMaintenance'])->name('fleet.maintenance.log');
        Route::post('/maintenance/schedule', [FleetDashboardController::class, 'scheduleMaintenance'])->name('fleet.maintenance.schedule');
        Route::get('/needs-attention', [FleetDashboardController::class, 'needsAttention'])->name('fleet.needs-attention');
        Route::get('/report', [FleetDashboardController::class, 'report'])->name('fleet.report');
        Route::get('/export-report', [FleetDashboardController::class, 'exportReport'])->name('fleet.export-report');
    });



    // Routes Management (Admin Only)
    Route::middleware('role:admin')->group(function () {
        Route::resource('routes', RouteController::class);
    });

    // Travel Bookings (Admin manages, customers create)
    Route::prefix('bookings/travel')->group(function () {
        Route::middleware('role:admin')->group(function () {
            Route::get('/', [BookingTravelController::class, 'index'])->name('bookings.travel');
            Route::get('/{travelBooking}', [BookingTravelController::class, 'show'])->name('bookings.travel.show');
            Route::delete('/{travelBooking}', [BookingTravelController::class, 'destroy'])->name('bookings.travel.destroy');
        });
        Route::get('/create', [BookingTravelController::class, 'create'])->middleware('verified')->name('bookings.travel.create');
        Route::post('/', [BookingTravelController::class, 'store'])->middleware('verified')->name('bookings.travel.store');
    });

    // Rental Bookings (Admin manages, customers create)
    Route::prefix('bookings/rental')->group(function () {
        Route::middleware('role:admin')->group(function () {
            Route::get('/', [BookingRentalController::class, 'index'])->name('bookings.rental');
            Route::get('/{rentalBooking}', [BookingRentalController::class, 'show'])->name('bookings.rental.show');
            Route::delete('/{rentalBooking}', [BookingRentalController::class, 'destroy'])->name('bookings.rental.destroy');
        });
        Route::get('/create', [BookingRentalController::class, 'create'])->middleware('verified')->name('bookings.rental.create');
        Route::post('/', [BookingRentalController::class, 'store'])->middleware('verified')->name('bookings.rental.store');
    });

    // Airport Transfer Bookings (Admin manages, customers create)
    Route::prefix('bookings/airport-transfer')->group(function () {
        Route::middleware('role:admin')->group(function () {
            Route::get('/', [AirportTransferController::class, 'index'])->name('bookings.airport-transfer');
            Route::get('/{airportTransferBooking}', [AirportTransferController::class, 'show'])->name('bookings.airport-transfer.show');
            Route::get('/{airportTransferBooking}/edit', [AirportTransferController::class, 'edit'])->name('bookings.airport-transfer.edit');
            Route::put('/{airportTransferBooking}', [AirportTransferController::class, 'update'])->name('bookings.airport-transfer.update');
            Route::post('/{airportTransferBooking}/cancel', [AirportTransferController::class, 'cancel'])->name('bookings.airport-transfer.cancel');
            Route::delete('/{airportTransferBooking}', [AirportTransferController::class, 'destroy'])->name('bookings.airport-transfer.destroy');
        });
        Route::get('/create', [AirportTransferController::class, 'create'])->middleware('verified')->name('bookings.airport-transfer.create');
        Route::post('/', [AirportTransferController::class, 'store'])->middleware('verified')->name('bookings.airport-transfer.store');
    });

    // Vehicles Management (Admin & Partner)
    Route::middleware('role:admin')->resource('vehicles', VehicleController::class);

    // Drivers Management (Admin only)
    Route::middleware('role:admin')->resource('drivers', DriverController::class);

    // Partners Management (Admin only)
    Route::middleware('role:admin')->resource('partners', PartnerController::class);

    // Analytics (Admin only)
    Route::middleware('role:admin')->prefix('analytics')->group(function () {
        Route::get('/revenue', [AnalyticsController::class, 'revenue'])->name('analytics.revenue');
        Route::get('/revenue/export-csv', [AnalyticsController::class, 'exportRevenueCSV'])->name('analytics.revenue.export-csv');
        Route::get('/bookings', [AnalyticsController::class, 'bookings'])->name('analytics.bookings');
        Route::get('/bookings/export-csv', [AnalyticsController::class, 'exportBookingsCSV'])->name('analytics.bookings.export-csv');
        Route::get('/drivers', [AnalyticsController::class, 'drivers'])->name('analytics.drivers');
        Route::get('/drivers/export-csv', [AnalyticsController::class, 'exportDriversCSV'])->name('analytics.drivers.export-csv');
    });

    // My Bookings (Unified)
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{id}', [BookingController::class, 'show'])->name('bookings.show');

    // Profile Management
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('profile.show');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('/verify-identity', [ProfileController::class, 'verifyIdentity'])->name('profile.verify-identity');
        Route::post('/upload-identity', [ProfileController::class, 'uploadIdentity'])->name('profile.upload-identity');
        Route::post('/upload-photo', [ProfileController::class, 'uploadPhoto'])->name('profile.upload-photo');
        Route::delete('/remove-photo', [ProfileController::class, 'removePhoto'])->name('profile.remove-photo');
    });

    // Search Routes
    Route::get('/api/search', [SearchController::class, 'index'])->name('api.search');
    Route::get('/search', [SearchController::class, 'show'])->name('search');

    // Admin Routes - Require Admin Role
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
        Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
        Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
        Route::put('/settings', [AdminController::class, 'updateSettings'])->name('admin.settings.update');
        Route::get('/bookings', [AdminController::class, 'manageBookings'])->name('admin.bookings');
        Route::get('/partners', [AdminController::class, 'managePartners'])->name('admin.partners');
        Route::post('/partners/{mitra}/payout', [AdminController::class, 'payoutMitra'])->name('admin.partners.payout');
        Route::get('/drivers', [AdminController::class, 'manageDrivers'])->name('admin.drivers');
        Route::post('/drivers/{driver}/approve', [AdminController::class, 'approveDriver'])->name('admin.drivers.approve');
        Route::post('/bookings/{type}/{id}/approve', [AdminController::class, 'approveBooking'])->name('admin.bookings.approve');
        Route::post('/bookings/{type}/{id}/complete', [AdminController::class, 'completeBooking'])->name('admin.bookings.complete');
        Route::post('/bookings/{type}/{id}/cancel', [AdminController::class, 'cancelBooking'])->name('admin.bookings.cancel');
        Route::get('/bookings/{type}/{id}', [AdminController::class, 'showBooking'])->name('admin.bookings.show');
        Route::get('/payments', [AdminController::class, 'payments'])->name('admin.payments');
        Route::get('/newsletters', [AdminController::class, 'newsletters'])->name('admin.newsletters');
        Route::get('/revenue-sharing', [AdminController::class, 'revenueSharing'])->name('admin.revenue-sharing');
        Route::get('/revenue-sharing/export', [AdminController::class, 'exportRevenueSharingCSV'])->name('admin.revenue-sharing.export');
        Route::get('/revenue-sharing/{revenueSharing}', [AdminController::class, 'showRevenueSharing'])->name('admin.revenue-sharing.show');
        Route::get('/vouchers', [AdminController::class, 'vouchers'])->name('admin.vouchers');
        Route::post('/vouchers', [AdminController::class, 'storeVoucher'])->name('admin.vouchers.store');
        Route::delete('/vouchers/{voucher}', [AdminController::class, 'destroyVoucher'])->name('admin.vouchers.destroy');

        // Review Moderation Routes
        Route::get('/reviews', [AdminController::class, 'reviews'])->name('admin.reviews');
        Route::post('/reviews/{review}/approve', [AdminController::class, 'approveReview'])->name('admin.reviews.approve');
        Route::post('/reviews/{review}/reject', [AdminController::class, 'rejectReview'])->name('admin.reviews.reject');
    });

    // Driver Routes - Require Driver Role
    Route::middleware('role:driver')->prefix('driver')->group(function () {
        Route::get('/', [DriverDashboardController::class, 'index'])->name('driver.dashboard');
        Route::post('/status', [DriverDashboardController::class, 'toggleStatus'])->name('driver.status.toggle');
        Route::get('/earnings', [DriverDashboardController::class, 'earnings'])->name('driver.earnings');
        Route::get('/orders', [DriverDashboardController::class, 'orders'])->name('driver.orders');
        Route::post('/trip/{booking}/{type}/start', [DriverDashboardController::class, 'startTrip'])->name('driver.trip.start');
        Route::post('/trip/{booking}/{type}/complete', [DriverDashboardController::class, 'completeTrip'])->name('driver.trip.complete');
    });

    // Partner/Mitra Routes
    Route::middleware('role:partner')->prefix('partner')->group(function () {
        Route::get('/dashboard', [PartnerController::class, 'dashboard'])->name('partner.dashboard');
        Route::get('/armadas', [PartnerController::class, 'armadas'])->name('partner.armadas');
        Route::post('/armadas', [PartnerController::class, 'storeArmada'])->name('partner.armadas.store');
        Route::get('/armadas/{armada}/edit', [PartnerController::class, 'editArmada'])->name('partner.armadas.edit');
        Route::put('/armadas/{armada}', [PartnerController::class, 'updateArmada'])->name('partner.armadas.update');
        Route::get('/drivers', [PartnerController::class, 'drivers'])->name('partner.drivers');
        Route::post('/drivers', [PartnerController::class, 'storeDriver'])->name('partner.drivers.store');
        Route::get('/drivers/{armada}/edit', [PartnerController::class, 'editDriver'])->name('partner.drivers.edit');
        Route::put('/drivers/{armada}', [PartnerController::class, 'updateDriver'])->name('partner.drivers.update');
        Route::get('/revenue', [PartnerController::class, 'revenue'])->name('partner.revenue');
    });

    // Payment Routes (require verified email)
    Route::middleware('verified')->prefix('payments')->group(function () {
        Route::get('/travel/{travelBooking}', [PaymentController::class, 'showTravelPayment'])->name('payments.travel');
        Route::get('/rental/{rentalBooking}', [PaymentController::class, 'showRentalPayment'])->name('payments.rental');
        Route::post('/check-status/{payment}', [PaymentController::class, 'checkStatus'])->name('payments.check-status');
        Route::post('/retry/{payment}', [PaymentController::class, 'retryPayment'])->name('payments.retry');
        Route::get('/success', [PaymentController::class, 'paymentSuccess'])->name('payments.success');
        Route::get('/error', [PaymentController::class, 'paymentError'])->name('payments.error');
        Route::get('/pending', [PaymentController::class, 'paymentPending'])->name('payments.pending');
    });

    // Export Routes (Admin only)
    Route::middleware('role:admin')->prefix('exports')->group(function () {
        Route::get('/bookings-excel', [ExportController::class, 'bookingsExcel'])->name('exports.bookings.excel');
        Route::get('/bookings-pdf', [ExportController::class, 'bookingsPdf'])->name('exports.bookings.pdf');
        Route::get('/revenue-excel', [ExportController::class, 'revenueExcel'])->name('exports.revenue.excel');
        Route::get('/revenue-pdf', [ExportController::class, 'revenuePdf'])->name('exports.revenue.pdf');
        Route::get('/drivers-excel', [ExportController::class, 'driversExcel'])->name('exports.drivers.excel');
        Route::get('/drivers-pdf', [ExportController::class, 'driversPdf'])->name('exports.drivers.pdf');
        Route::get('/invoice/{booking}', [ExportController::class, 'invoicePdf'])->name('exports.invoice');
        Route::get('/ticket/{booking}', [ExportController::class, 'ticketPdf'])->name('exports.ticket');
        Route::get('/manifest/{booking}', [ExportController::class, 'manifestPdf'])->name('exports.manifest');
    });

    // Voucher Validation API (for checkout)
    Route::get('/api/voucher/validate', function (Illuminate\Http\Request $request) {
        $code = strtoupper($request->get('code'));
        $amount = floatval($request->get('amount', 0));

        $voucher = \App\Models\Voucher::where('code', $code)->first();

        if (!$voucher) {
            return response()->json(['valid' => false, 'message' => 'Kode voucher tidak ditemukan']);
        }

        if (!$voucher->isValid()) {
            return response()->json(['valid' => false, 'message' => 'Voucher sudah tidak berlaku']);
        }

        $discount = 0;
        if ($voucher->type === 'percentage') {
            $discount = $amount * ($voucher->value / 100);
            if ($voucher->max_discount) {
                $discount = min($discount, $voucher->max_discount);
            }
        } else {
            $discount = min($voucher->value, $amount);
        }

        return response()->json(['valid' => true, 'discount' => round($discount), 'voucher_id' => $voucher->id]);
    })->middleware('auth');

    // Identity Verification Routes
    Route::prefix('identity')->group(function () {
        Route::get('/create', [IdentityVerificationController::class, 'create'])->name('identity.create');
        Route::post('/', [IdentityVerificationController::class, 'store'])->name('identity.store');
        Route::get('/show', [IdentityVerificationController::class, 'show'])->name('identity.show');
        
        // Admin routes for verification approval
        Route::middleware('role:admin')->group(function () {
            Route::get('/admin/pending', [IdentityVerificationController::class, 'adminPending'])->name('identity.admin.pending');
            Route::post('/approve/{verification}', [IdentityVerificationController::class, 'approve'])->name('identity.approve');
            Route::post('/reject/{verification}', [IdentityVerificationController::class, 'reject'])->name('identity.reject');
            Route::post('/batch-approve', [IdentityVerificationController::class, 'batchApprove'])->name('identity.batch-approve');
        });
    });

    // Ticket & QR Code Routes
    Route::prefix('tickets')->group(function () {
        Route::get('/{booking}', [TicketController::class, 'show'])->name('tickets.show');
        Route::get('/{booking}/qr', [TicketController::class, 'qrCode'])->name('tickets.qr');
        Route::get('/verify/{token}', [TicketController::class, 'verify'])->name('ticket.verify');
        Route::post('/checkin/{booking}', [TicketController::class, 'checkin'])->name('tickets.checkin');
    });

    // Review Routes
    Route::middleware('auth')->group(function () {
        Route::get('/bookings/{booking}/review', [ReviewController::class, 'create'])->name('bookings.review.create');
        Route::post('/bookings/{booking}/review', [ReviewController::class, 'store'])->name('bookings.review.store');
    });

    // Refund Routes
    Route::middleware('auth')->group(function () {
        Route::get('/bookings/{booking}/refund', [RefundController::class, 'create'])->name('bookings.refund.create');
        Route::post('/bookings/{booking}/refund', [RefundController::class, 'store'])->name('bookings.refund.store');
        Route::get('/refunds', [RefundController::class, 'index'])->name('refunds.index');
    });

    // Admin Refund Routes
    Route::middleware('role:admin')->prefix('admin/refunds')->group(function () {
        Route::get('/', [AdminRefundController::class, 'index'])->name('admin.refunds');
        Route::post('/{refund}/approve', [AdminRefundController::class, 'approve'])->name('admin.refunds.approve');
        Route::post('/{refund}/reject', [AdminRefundController::class, 'reject'])->name('admin.refunds.reject');
    });

    // Notification Routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.read-all');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

    // Chat Routes
    Route::prefix('chat')->group(function () {
        Route::get('/', [ChatController::class, 'index'])->name('chat.index');
        Route::get('/{user}/{booking?}', [ChatController::class, 'show'])->name('chat.show');
        Route::post('/', [ChatController::class, 'store'])->name('chat.store');
    });

    // Super Admin Routes - Global SaaS Management
    Route::middleware('role:admin')->prefix('super-admin')->group(function () {
        Route::get('/', [SuperAdminController::class, 'dashboard'])->name('super-admin.dashboard');
        Route::get('/companies', [SuperAdminController::class, 'companies'])->name('super-admin.companies');
        Route::get('/companies/create', [SuperAdminController::class, 'createCompany'])->name('super-admin.companies.create');
        Route::post('/companies', [SuperAdminController::class, 'storeCompany'])->name('super-admin.companies.store');
        Route::get('/companies/{company}', [SuperAdminController::class, 'showCompany'])->name('super-admin.companies.show');
        Route::put('/companies/{company}', [SuperAdminController::class, 'updateCompany'])->name('super-admin.companies.update');
        Route::post('/companies/{company}/suspend', [SuperAdminController::class, 'suspendCompany'])->name('super-admin.companies.suspend');
        Route::post('/companies/{company}/activate', [SuperAdminController::class, 'activateCompany'])->name('super-admin.companies.activate');
        Route::get('/users', [SuperAdminController::class, 'users'])->name('super-admin.users');
        Route::get('/analytics', [SuperAdminController::class, 'analytics'])->name('super-admin.analytics');
        Route::get('/settings', [SuperAdminController::class, 'settings'])->name('super-admin.settings');
        Route::put('/settings', [SuperAdminController::class, 'updateSettings'])->name('super-admin.settings.update');
    });
});

// Google OAuth Routes
Route::middleware('guest')->group(function () {
    Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('auth.google');
    Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('auth.google.callback');
});

// CMS Pages Admin Routes
Route::middleware('role:admin')->prefix('admin')->group(function () {
    Route::resource('cms', CmsPageController::class);
    Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('admin.audit-logs');
});

// GPS Devices Admin Routes
Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::resource('gps-devices', \App\Http\Controllers\Admin\GpsDeviceController::class)->except('show');
});

// Public CMS Page
Route::get('/pages/{slug}', [PublicController::class, 'showPage'])->name('public.page');


