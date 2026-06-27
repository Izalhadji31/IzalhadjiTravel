<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminRouteController;
use App\Http\Controllers\Admin\AdminArmadaController;
use App\Http\Controllers\Admin\AdminMitraController;
use App\Http\Controllers\Admin\AdminTravelBookingController;
use App\Http\Controllers\Admin\AdminRentalBookingController;
use App\Http\Controllers\PaymentController;

Route::middleware('api')->group(function () {
    /**
     * Admin Routes - Route Management
     */
    Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin/routes')->group(function () {
        Route::get('/', [AdminRouteController::class, 'index']);
        Route::post('/', [AdminRouteController::class, 'store']);
        Route::get('{route}', [AdminRouteController::class, 'show']);
        Route::put('{route}', [AdminRouteController::class, 'update']);
        Route::delete('{route}', [AdminRouteController::class, 'destroy']);
        Route::post('bulk-update-status', [AdminRouteController::class, 'bulkUpdateStatus']);
    });

    /**
     * Admin Routes - Armada Management
     */
    Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin/armadas')->group(function () {
        Route::get('/', [AdminArmadaController::class, 'index']);
        Route::post('/', [AdminArmadaController::class, 'store']);
        Route::get('{armada}', [AdminArmadaController::class, 'show']);
        Route::put('{armada}', [AdminArmadaController::class, 'update']);
        Route::delete('{armada}', [AdminArmadaController::class, 'destroy']);
        Route::get('by-status/{status}', [AdminArmadaController::class, 'getByStatus']);
        Route::put('{armada}/status', [AdminArmadaController::class, 'updateStatus']);
        Route::get('available/list', [AdminArmadaController::class, 'getAvailable']);
    });

    /**
     * Admin Routes - Mitra Management
     */
    Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin/mitras')->group(function () {
        Route::get('/', [AdminMitraController::class, 'index']);
        Route::post('/', [AdminMitraController::class, 'store']);
        Route::get('{mitra}', [AdminMitraController::class, 'show']);
        Route::put('{mitra}', [AdminMitraController::class, 'update']);
        Route::delete('{mitra}', [AdminMitraController::class, 'destroy']);
        Route::get('{mitra}/earnings', [AdminMitraController::class, 'getEarnings']);
        Route::post('{mitra}/toggle-status', [AdminMitraController::class, 'toggleStatus']);
    });

    /**
     * Admin Routes - Travel Booking Management
     */
    Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin/travel-bookings')->group(function () {
        Route::get('/', [AdminTravelBookingController::class, 'index']);
        Route::get('{travelBooking}', [AdminTravelBookingController::class, 'show']);
        Route::post('{travelBooking}/assign-armada', [AdminTravelBookingController::class, 'assignArmada']);
        Route::post('{travelBooking}/complete', [AdminTravelBookingController::class, 'complete']);
        Route::post('{travelBooking}/cancel', [AdminTravelBookingController::class, 'cancel']);
        Route::get('pending/list', [AdminTravelBookingController::class, 'getPending']);
        Route::get('upcoming/list', [AdminTravelBookingController::class, 'getUpcoming']);
        Route::get('stats/summary', [AdminTravelBookingController::class, 'getStats']);
    });

    /**
     * Admin Routes - Rental Booking Management
     */
    Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin/rental-bookings')->group(function () {
        Route::get('/', [AdminRentalBookingController::class, 'index']);
        Route::get('{rentalBooking}', [AdminRentalBookingController::class, 'show']);
        Route::post('{rentalBooking}/assign-armada', [AdminRentalBookingController::class, 'assignArmada']);
        Route::post('{rentalBooking}/complete', [AdminRentalBookingController::class, 'complete']);
        Route::post('{rentalBooking}/cancel', [AdminRentalBookingController::class, 'cancel']);
        Route::get('pending/list', [AdminRentalBookingController::class, 'getPending']);
        Route::get('upcoming/list', [AdminRentalBookingController::class, 'getUpcoming']);
        Route::get('stats/summary', [AdminRentalBookingController::class, 'getStats']);
    });

    /**
     * Public Routes - List Routes & Prices
     */
    Route::prefix('routes')->group(function () {
        Route::get('travel', function () {
            $routes = \App\Models\Route::active()
                                      ->travel()
                                      ->with('travelPrices')
                                      ->get();
            return response()->json(['success' => true, 'data' => $routes]);
        });

        Route::get('rental', function () {
            $routes = \App\Models\Route::active()
                                      ->rental()
                                      ->with('rentalPrices')
                                      ->get();
            return response()->json(['success' => true, 'data' => $routes]);
        });

        Route::get('{route_id}', function ($route_id) {
            $route = \App\Models\Route::find($route_id);
            
            if (!$route) {
                return response()->json([
                    'success' => false,
                    'message' => 'Route not found'
                ], 404);
            }
            
            $route->load(['travelPrices', 'rentalPrices']);
            return response()->json(['success' => true, 'data' => $route]);
        });
    });

    /**
     * Vehicle Tracking API Routes
     */
    Route::middleware('auth:sanctum')->prefix('tracking')->group(function () {
        // GPS Location Tracking
        Route::post('/location', [\App\Http\Controllers\Api\TrackingApiController::class, 'recordLocation']);
        Route::get('/location/{armadaId}/latest', [\App\Http\Controllers\Api\TrackingApiController::class, 'getLatestLocation']);
        Route::get('/location/{armadaId}/history', [\App\Http\Controllers\Api\TrackingApiController::class, 'getLocationHistory']);
        Route::get('/locations/active', [\App\Http\Controllers\Api\TrackingApiController::class, 'getAllActiveLocations']);
        Route::get('/locations/on-rental', [\App\Http\Controllers\Api\TrackingApiController::class, 'getVehiclesOnRental']);
        Route::get('/locations/realtime', [\App\Http\Controllers\Api\TrackingApiController::class, 'getRealTimePositions']);
        Route::post('/locations/nearby', [\App\Http\Controllers\Api\TrackingApiController::class, 'findNearbyVehicles']);
        Route::get('/locations/offline', [\App\Http\Controllers\Api\TrackingApiController::class, 'getOfflineVehicles']);
        Route::get('/heatmap/{armadaId}', [\App\Http\Controllers\Api\TrackingApiController::class, 'getHeatmapData']);
        Route::post('/geofence/check', [\App\Http\Controllers\Api\TrackingApiController::class, 'checkGeofence']);

        // Trip Tracking
        Route::post('/trip/start', [\App\Http\Controllers\Api\TripTrackingApiController::class, 'startTrip']);
        Route::post('/trip/{tripId}/end', [\App\Http\Controllers\Api\TripTrackingApiController::class, 'endTrip']);
        Route::get('/trip/{tripId}', [\App\Http\Controllers\Api\TripTrackingApiController::class, 'getTripDetails']);
        Route::get('/trip/{tripId}/route', [\App\Http\Controllers\Api\TripTrackingApiController::class, 'getTripRoute']);
        Route::get('/trips/active', [\App\Http\Controllers\Api\TripTrackingApiController::class, 'getActiveTrips']);
        Route::get('/trips/vehicle/{armadaId}', [\App\Http\Controllers\Api\TripTrackingApiController::class, 'getVehicleTripHistory']);
        Route::get('/trips/booking/{bookingId}', [\App\Http\Controllers\Api\TripTrackingApiController::class, 'getBookingTripHistory']);
        Route::get('/statistics/vehicle/{armadaId}', [\App\Http\Controllers\Api\TripTrackingApiController::class, 'getVehicleStatistics']);
        Route::get('/revenue/daily/{armadaId}', [\App\Http\Controllers\Api\TripTrackingApiController::class, 'getDailyRevenue']);

        // Fleet Management
        Route::get('/fleet/overview', [\App\Http\Controllers\Api\FleetTrackingApiController::class, 'getFleetOverview']);
        Route::get('/fleet/dashboard', [\App\Http\Controllers\Api\FleetTrackingApiController::class, 'getFleetDashboard']);
        Route::get('/fleet/metrics/{armadaId}', [\App\Http\Controllers\Api\FleetTrackingApiController::class, 'getArmadaMetrics']);
        Route::get('/fleet/maintenance/{armadaId}', [\App\Http\Controllers\Api\FleetTrackingApiController::class, 'getMaintenanceStatus']);
        Route::post('/fleet/maintenance/log', [\App\Http\Controllers\Api\FleetTrackingApiController::class, 'logMaintenance']);
        Route::post('/fleet/maintenance/schedule', [\App\Http\Controllers\Api\FleetTrackingApiController::class, 'scheduleMaintenance']);
        Route::get('/fleet/needs-attention', [\App\Http\Controllers\Api\FleetTrackingApiController::class, 'getVehiclesNeedingAttention']);
        Route::get('/fleet/utilization', [\App\Http\Controllers\Api\FleetTrackingApiController::class, 'getFleetUtilization']);
        Route::get('/fleet/report', [\App\Http\Controllers\Api\FleetTrackingApiController::class, 'generateFleetReport']);
    });

    /**
     * User authenticated routes (future expansion)
     */
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', function (Request $request) {
            return response()->json(['data' => $request->user()]);
        });
    });
});

/**
 * GPS Device API Routes - Device Key Authentication
 */
Route::prefix('gps')->group(function () {
    Route::post('/location', [\App\Http\Controllers\Api\GpsDeviceApiController::class, 'receiveLocation']);
    Route::get('/vehicle/{deviceId}', [\App\Http\Controllers\Api\GpsDeviceApiController::class, 'getVehicleStatus']);
});

/**
 * Midtrans Notification (Webhook) - No Auth Required
 */
Route::post('/midtrans/notification', [PaymentController::class, 'handleNotification']);
