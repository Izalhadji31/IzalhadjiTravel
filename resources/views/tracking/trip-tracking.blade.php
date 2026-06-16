@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0 text-gray-800">Trip Tracking - Trip #{{ $trip->id }}</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('tracking.dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <!-- Trip Info -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <p class="text-muted mb-1">Booking ID</p>
                    <h5 class="mb-0">#{{ $trip->rental_booking_id }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <p class="text-muted mb-1">Vehicle</p>
                    <h5 class="mb-0">{{ $trip->armada->plate_number }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <p class="text-muted mb-1">Customer</p>
                    <h5 class="mb-0">{{ $trip->user->name }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <p class="text-muted mb-1">Status</p>
                    <span class="badge bg-{{ $trip->status === 'completed' ? 'success' : 'primary' }}">
                        {{ ucfirst($trip->status) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Trip Route Map</h6>
                </div>
                <div class="card-body p-0">
                    <div id="tripMap" style="height: 400px; border-radius: 5px;"></div>
                </div>
            </div>
        </div>

        <!-- Trip Summary -->
        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Trip Summary</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-6">
                            <p class="text-muted mb-1">Total Distance</p>
                            <h5 class="mb-0">{{ round($trip->total_distance, 2) }} km</h5>
                        </div>
                        <div class="col-6">
                            <p class="text-muted mb-1">Duration</p>
                            <h5 class="mb-0">{{ $trip->getDurationFormatted() }}</h5>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <div class="col-6">
                            <p class="text-muted mb-1">Average Speed</p>
                            <h5 class="mb-0">{{ round($trip->average_speed, 2) }} km/h</h5>
                        </div>
                        <div class="col-6">
                            <p class="text-muted mb-1">Fuel Consumption</p>
                            <h5 class="mb-0">{{ round($trip->calculateFuel(), 2) }} L</h5>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-6">
                            <p class="text-muted mb-1">Start Time</p>
                            <small>{{ $trip->start_time->format('Y-m-d H:i:s') }}</small>
                        </div>
                        <div class="col-6">
                            <p class="text-muted mb-1">End Time</p>
                            <small>{{ $trip->end_time?->format('Y-m-d H:i:s') ?? 'In progress' }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Location Details -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Location History</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Time</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Speed</th>
                                <th>Heading</th>
                                <th>Accuracy</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($locations as $location)
                            <tr>
                                <td>{{ $location->recorded_at->format('H:i:s') }}</td>
                                <td>{{ $location->latitude }}</td>
                                <td>{{ $location->longitude }}</td>
                                <td>{{ $location->speed }} km/h</td>
                                <td>{{ $location->heading ?? '-' }}°</td>
                                <td>±{{ $location->accuracy ?? '-' }}m</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No location data available</td>
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
function initializeTripMap() {
    const locations = @json($locations);
    
    if (locations.length === 0) {
        document.getElementById('tripMap').innerHTML = '<div class="d-flex align-items-center justify-content-center h-100"><p class="text-muted">No location data available</p></div>';
        return;
    }

    const map = new google.maps.Map(document.getElementById('tripMap'), {
        zoom: 13,
        center: {
            lat: parseFloat(locations[0].latitude),
            lng: parseFloat(locations[0].longitude)
        }
    });

    // Plot all points
    const polylineCoordinates = [];
    locations.forEach((location, index) => {
        const lat = parseFloat(location.latitude);
        const lng = parseFloat(location.longitude);
        
        polylineCoordinates.push({ lat, lng });

        // Start marker
        if (index === 0) {
            new google.maps.Marker({
                position: { lat, lng },
                map: map,
                title: 'Start',
                icon: 'https://maps.gstatic.com/mapfiles/ms2/micons/green-dot.png'
            });
        }
        // End marker
        else if (index === locations.length - 1) {
            new google.maps.Marker({
                position: { lat, lng },
                map: map,
                title: 'End',
                icon: 'https://maps.gstatic.com/mapfiles/ms2/micons/red-dot.png'
            });
        }
    });

    // Draw polyline
    const polyline = new google.maps.Polyline({
        path: polylineCoordinates,
        geodesic: true,
        strokeColor: '#0066FF',
        strokeOpacity: 0.7,
        strokeWeight: 3,
        map: map
    });

    // Fit to bounds
    const bounds = new google.maps.LatLngBounds();
    polylineCoordinates.forEach(coord => bounds.extend(coord));
    map.fitBounds(bounds);
}

document.addEventListener('DOMContentLoaded', initializeTripMap);
</script>
@endsection
