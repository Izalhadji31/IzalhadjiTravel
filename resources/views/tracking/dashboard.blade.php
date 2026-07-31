@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0 text-gray-800">Tracking Dashboard</h1>
            <p class="text-muted">Real-time vehicle tracking and monitoring</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('tracking.map') }}" class="btn btn-primary">
                <i class="fas fa-map-marked-alt"></i> Full Map View
            </a>
        </div>
    </div>

    <!-- Fleet Overview Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-left-primary shadow h-100">
                <div class="card-body">
                    <div class="text-primary font-weight-bold text-uppercase mb-1">Total Vehicles</div>
                    <h3 class="h4 mb-0">{{ $fleetOverview['total'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-success shadow h-100">
                <div class="card-body">
                    <div class="text-success font-weight-bold text-uppercase mb-1">Available</div>
                    <h3 class="h4 mb-0">{{ $fleetOverview['available'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-warning shadow h-100">
                <div class="card-body">
                    <div class="text-warning font-weight-bold text-uppercase mb-1">On Rental</div>
                    <h3 class="h4 mb-0">{{ $fleetOverview['on_rental'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-danger shadow h-100">
                <div class="card-body">
                    <div class="text-danger font-weight-bold text-uppercase mb-1">Maintenance</div>
                    <h3 class="h4 mb-0">{{ $fleetOverview['in_maintenance'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Trips Section -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Active Trips ({{ $activeTrips->count() }})</h6>
                    <a href="{{ route('tracking.active-bookings') }}" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body">
                    @forelse($activeTrips as $trip)
                    <div class="row mb-3 pb-3 border-bottom">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Booking ID:</strong> {{ $trip->rental_booking_id }}</p>
                            <p class="mb-1"><strong>Vehicle:</strong> {{ $trip->armada->plate_number }}</p>
                            <p class="mb-0"><strong>Driver:</strong> {{ $trip->user->name }}</p>
                        </div>
                        <div class="col-md-6 text-end">
                            <p class="mb-1"><strong>Distance:</strong> {{ $trip->total_distance ?? 'Calculating...' }} km</p>
                            <p class="mb-1"><strong>Duration:</strong> {{ $trip->duration_minutes ?? 'In progress' }} min</p>
                            <a href="{{ route('tracking.trip', $trip->id) }}" class="btn btn-sm btn-info">Track</a>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted mb-0">No active trips at the moment.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Real-time Vehicles Location -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Vehicle Locations</h6>
                </div>
                <div class="card-body">
                    <div id="miniMap" style="height: 300px; border-radius: 5px; background: #f0f0f0;">
                        <!-- Mini map will be rendered here -->
                    </div>
                    <p class="text-muted text-center mt-3 mb-0">
                        <small>Last updated: {{ now()->format('H:i:s') }}</small>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Vehicles on Rental -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Vehicles Currently on Rental</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Plate Number</th>
                                <th>Vehicle Type</th>
                                <th>Location</th>
                                <th>Speed</th>
                                <th>Status</th>
                                <th>Last Update</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($vehiclesOnRental as $location)
                            <tr>
                                <td><strong>{{ $location->armada->plate_number }}</strong></td>
                                <td>{{ $location->armada->vehicle_type }}</td>
                                <td>{{ $location->address ?? 'Calculating...' }}</td>
                                <td>{{ $location->speed }} km/h</td>
                                <td>
                                    <span class="badge bg-{{ $location->status === 'active' ? 'success' : 'warning' }}">
                                        {{ ucfirst($location->status) }}
                                    </span>
                                </td>
                                <td>{{ $location->recorded_at->diffForHumans() }}</td>
                                <td>
                                    <a href="{{ route('tracking.vehicle', $location->armada_id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No vehicles currently on rental</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.api_key') }}"></script>
<script>
// Initialize mini map
function initializeMiniMap() {
    const locations = @json($activeLocations);
    if (locations.length === 0) return;

    const mapElement = document.getElementById('miniMap');
    const map = new google.maps.Map(mapElement, {
        zoom: 12,
        center: {
            lat: parseFloat(locations[0].latitude),
            lng: parseFloat(locations[0].longitude)
        }
    });

    locations.forEach(location => {
        new google.maps.Marker({
            position: {
                lat: parseFloat(location.latitude),
                lng: parseFloat(location.longitude)
            },
            map: map,
            title: location.armada?.plate_number
        });
    });
}

// Auto refresh every 30 seconds
setInterval(() => {
    location.reload();
}, 30000);

document.addEventListener('DOMContentLoaded', initializeMiniMap);
</script>
@endsection
