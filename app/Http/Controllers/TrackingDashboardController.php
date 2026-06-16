<?php

namespace App\Http\Controllers;

use App\Models\VehicleLocation;
use App\Models\TripTracking;
use App\Models\Armada;
use App\Services\VehicleTrackingService;
use App\Services\TripTrackingService;
use App\Services\FleetManagementService;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TrackingDashboardController extends Controller
{
    public function __construct(
        private VehicleTrackingService $trackingService,
        private TripTrackingService $tripService,
        private FleetManagementService $fleetService,
    ) {}

    /**
     * Show main tracking dashboard
     */
    public function index(): View
    {
        $activeLocations = $this->trackingService->getAllActiveLocations();
        $activeTrips = $this->tripService->getActiveTrips();
        $fleetOverview = $this->fleetService->getFleetOverview();
        $vehiclesOnRental = $this->trackingService->getVehiclesOnRental();

        return view('tracking.dashboard', [
            'activeLocations' => $activeLocations,
            'activeTrips' => $activeTrips,
            'fleetOverview' => $fleetOverview,
            'vehiclesOnRental' => $vehiclesOnRental,
        ]);
    }

    /**
     * Show real-time tracking map
     */
    public function map(): View
    {
        $locations = $this->trackingService->getAllActiveLocations();

        return view('tracking.map', [
            'locations' => $locations,
        ]);
    }

    /**
     * Show vehicle details page
     */
    public function vehicleDetails(int $armadaId): View
    {
        $armada = Armada::with(['mitra', 'travelAssignments', 'rentalAssignments'])->findOrFail($armadaId);
        $currentLocation = $this->trackingService->getLatestLocation($armadaId);
        $locationHistory = $this->trackingService->getLocationHistory($armadaId, 24);
        $tripHistory = $this->tripService->getVehicleTripHistory($armadaId, 30);
        $statistics = $this->tripService->getVehicleStatistics($armadaId, 30);
        $metrics = $this->fleetService->getArmadaMetrics($armadaId, 30);

        return view('tracking.vehicle-details', [
            'armada' => $armada,
            'currentLocation' => $currentLocation,
            'locationHistory' => $locationHistory,
            'tripHistory' => $tripHistory,
            'statistics' => $statistics,
            'metrics' => $metrics,
        ]);
    }

    /**
     * Show trip tracking page
     */
    public function tripTracking(int $tripId): View
    {
        $trip = $this->tripService->getTripDetails($tripId);
        $locations = VehicleLocation::where('rental_booking_id', $trip->rental_booking_id)
            ->where('recorded_at', '>=', $trip->start_time)
            ->where('recorded_at', '<=', $trip->end_time ?? now())
            ->orderBy('recorded_at')
            ->get();

        return view('tracking.trip-tracking', [
            'trip' => $trip,
            'locations' => $locations,
        ]);
    }

    /**
     * Show active bookings with tracking
     */
    public function activeBookings(): View
    {
        $activeTrips = $this->tripService->getActiveTrips();

        return view('tracking.active-bookings', [
            'activeTrips' => $activeTrips,
        ]);
    }

    /**
     * Show geofence management
     */
    public function geofence(): View
    {
        $armadas = Armada::where('status', 'tersedia')->get();

        return view('tracking.geofence', [
            'armadas' => $armadas,
        ]);
    }

    /**
     * Show offline vehicles alert
     */
    public function offlineVehicles(): View
    {
        $offlineVehicles = $this->trackingService->getOfflineVehicles();

        return view('tracking.offline-vehicles', [
            'offlineVehicles' => $offlineVehicles,
        ]);
    }

    /**
     * Export location data
     */
    public function exportData($armadaId): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $history = $this->trackingService->getLocationHistory($armadaId, 30);

        $csvData = "Latitude,Longitude,Speed,Address,Status,Recorded At\n";
        foreach ($history as $location) {
            $csvData .= "{$location->latitude},{$location->longitude},{$location->speed},\"{$location->address}\",{$location->status},{$location->recorded_at}\n";
        }

        $fileName = "vehicle_{$armadaId}_locations_" . now()->format('Y-m-d_H-i-s') . '.csv';
        
        return response()->streamDownload(function () use ($csvData) {
            echo $csvData;
        }, $fileName, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ]);
    }
}
