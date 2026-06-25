<?php

use Illuminate\Support\Facades\Route;
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
});

Route::middleware(['auth'])->group(function () {
    Route::post('/bookings', [BookingTravelController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [BookingTravelController::class, 'show'])->name('bookings.show');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::get('/login/{role}', [LoginController::class, 'create'])->name('login.role');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
});

Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

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



    // Routes Management
    Route::resource('routes', RouteController::class);

    // Travel Bookings
    Route::prefix('bookings/travel')->group(function () {
        Route::get('/', [BookingTravelController::class, 'index'])->name('bookings.travel');
        Route::get('/create', [BookingTravelController::class, 'create'])->name('bookings.travel.create');
        Route::post('/', [BookingTravelController::class, 'store'])->name('bookings.travel.store');
        Route::get('/{travelBooking}', [BookingTravelController::class, 'show'])->name('bookings.travel.show');
        Route::delete('/{travelBooking}', [BookingTravelController::class, 'destroy'])->name('bookings.travel.destroy');
    });

    // Rental Bookings
    Route::prefix('bookings/rental')->group(function () {
        Route::get('/', [BookingRentalController::class, 'index'])->name('bookings.rental');
        Route::get('/create', [BookingRentalController::class, 'create'])->name('bookings.rental.create');
        Route::post('/', [BookingRentalController::class, 'store'])->name('bookings.rental.store');
        Route::get('/{rentalBooking}', [BookingRentalController::class, 'show'])->name('bookings.rental.show');
        Route::delete('/{rentalBooking}', [BookingRentalController::class, 'destroy'])->name('bookings.rental.destroy');
    });

    // Airport Transfer Bookings
    Route::prefix('bookings/airport-transfer')->group(function () {
        Route::get('/', [AirportTransferController::class, 'index'])->name('bookings.airport-transfer');
        Route::get('/create', [AirportTransferController::class, 'create'])->name('bookings.airport-transfer.create');
        Route::post('/', [AirportTransferController::class, 'store'])->name('bookings.airport-transfer.store');
        Route::get('/{airportTransferBooking}', [AirportTransferController::class, 'show'])->name('bookings.airport-transfer.show');
        Route::get('/{airportTransferBooking}/edit', [AirportTransferController::class, 'edit'])->name('bookings.airport-transfer.edit');
        Route::put('/{airportTransferBooking}', [AirportTransferController::class, 'update'])->name('bookings.airport-transfer.update');
        Route::post('/{airportTransferBooking}/cancel', [AirportTransferController::class, 'cancel'])->name('bookings.airport-transfer.cancel');
        Route::delete('/{airportTransferBooking}', [AirportTransferController::class, 'destroy'])->name('bookings.airport-transfer.destroy');
    });

    // Vehicles Management
    Route::resource('vehicles', VehicleController::class);

    // Drivers Management
    Route::resource('drivers', DriverController::class);

    // Partners Management
    Route::resource('partners', PartnerController::class);

    // Analytics
    Route::prefix('analytics')->group(function () {
        Route::get('/revenue', [AnalyticsController::class, 'revenue'])->name('analytics.revenue');
        Route::get('/revenue/export-csv', [AnalyticsController::class, 'exportRevenueCSV'])->name('analytics.revenue.export-csv');
        Route::get('/bookings', [AnalyticsController::class, 'bookings'])->name('analytics.bookings');
        Route::get('/bookings/export-csv', [AnalyticsController::class, 'exportBookingsCSV'])->name('analytics.bookings.export-csv');
        Route::get('/drivers', [AnalyticsController::class, 'drivers'])->name('analytics.drivers');
        Route::get('/drivers/export-csv', [AnalyticsController::class, 'exportDriversCSV'])->name('analytics.drivers.export-csv');
    });

    // Profile Management
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('profile.show');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('/verify-identity', [ProfileController::class, 'verifyIdentity'])->name('profile.verify-identity');
        Route::post('/upload-identity', [ProfileController::class, 'uploadIdentity'])->name('profile.upload-identity');
    });

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
        Route::get('/revenue-sharing', [AdminController::class, 'revenueSharing'])->name('admin.revenue-sharing');
        Route::get('/revenue-sharing/export', [AdminController::class, 'exportRevenueSharingCSV'])->name('admin.revenue-sharing.export');
        Route::get('/revenue-sharing/{revenueSharing}', [AdminController::class, 'showRevenueSharing'])->name('admin.revenue-sharing.show');
        Route::get('/vouchers', [AdminController::class, 'vouchers'])->name('admin.vouchers');
        Route::post('/vouchers', [AdminController::class, 'storeVoucher'])->name('admin.vouchers.store');
        Route::delete('/vouchers/{voucher}', [AdminController::class, 'destroyVoucher'])->name('admin.vouchers.destroy');
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

    // Payment Routes
    Route::prefix('payments')->group(function () {
        Route::get('/travel/{travelBooking}', [PaymentController::class, 'showTravelPayment'])->name('payments.travel');
        Route::get('/rental/{rentalBooking}', [PaymentController::class, 'showRentalPayment'])->name('payments.rental');
        Route::post('/check-status/{payment}', [PaymentController::class, 'checkStatus'])->name('payments.check-status');
        Route::post('/retry/{payment}', [PaymentController::class, 'retryPayment'])->name('payments.retry');
        Route::get('/success', [PaymentController::class, 'paymentSuccess'])->name('payments.success');
        Route::get('/error', [PaymentController::class, 'paymentError'])->name('payments.error');
        Route::get('/pending', [PaymentController::class, 'paymentPending'])->name('payments.pending');
    });

    // Export Routes
    Route::prefix('exports')->group(function () {
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

    // Notification Routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.read-all');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

    // Super Admin Routes - Global SaaS Management
    // Uncomment when views are created
    // Route::middleware('role:admin')->prefix('super-admin')->group(function () {
    //     Route::get('/', [SuperAdminController::class, 'dashboard'])->name('super-admin.dashboard');
    //     Route::get('/companies', [SuperAdminController::class, 'companies'])->name('super-admin.companies');
    //     Route::get('/companies/create', [SuperAdminController::class, 'createCompany'])->name('super-admin.companies.create');
    //     Route::post('/companies', [SuperAdminController::class, 'storeCompany'])->name('super-admin.companies.store');
    //     Route::get('/companies/{company}', [SuperAdminController::class, 'showCompany'])->name('super-admin.companies.show');
    //     Route::put('/companies/{company}', [SuperAdminController::class, 'updateCompany'])->name('super-admin.companies.update');
    //     Route::post('/companies/{company}/suspend', [SuperAdminController::class, 'suspendCompany'])->name('super-admin.companies.suspend');
    //     Route::post('/companies/{company}/activate', [SuperAdminController::class, 'activateCompany'])->name('super-admin.companies.activate');
    //     Route::get('/users', [SuperAdminController::class, 'users'])->name('super-admin.users');
    //     Route::get('/analytics', [SuperAdminController::class, 'analytics'])->name('super-admin.analytics');
    //     Route::get('/settings', [SuperAdminController::class, 'settings'])->name('super-admin.settings');
    //     Route::put('/settings', [SuperAdminController::class, 'updateSettings'])->name('super-admin.settings.update');
    // });
});
