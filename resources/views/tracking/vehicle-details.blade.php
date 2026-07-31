@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0 text-gray-800">Vehicle Details - {{ $armada->plate_number }}</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('tracking.dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <!-- Vehicle Info -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <p class="text-muted mb-1">Plate Number</p>
                    <h5 class="mb-0">{{ $armada->plate_number }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <p class="text-muted mb-1">Vehicle Type</p>
                    <h5 class="mb-0">{{ $armada->vehicle_type }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <p class="text-muted mb-1">Seat Capacity</p>
                    <h5 class="mb-0">{{ $armada->seat_capacity }} Seats</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <p class="text-muted mb-1">Status</p>
                    <span class="badge bg-{{ $armada->status === 'tersedia' ? 'success' : 'warning' }}">
                        {{ ucfirst($armada->status) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Current Location -->
    @if($currentLocation)
    <div class="row mb-4">
        <div class="col-lg-6">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Current Location</h6>
                </div>
                <div class="card-body">
                    <div id="currentMap" style="height: 300px; border-radius: 5px;"></div>
                    <div class="mt-3">
                        <p><strong>Address:</strong> {{ $currentLocation->address ?? 'Unknown' }}</p>
                        <p><strong>Latitude:</strong> {{ $currentLocation->latitude }}</p>
                        <p><strong>Longitude:</strong> {{ $currentLocation->longitude }}</p>
                        <p><strong>Speed:</strong> {{ $currentLocation->speed }} km/h</p>
                        <p><strong>Last Update:</strong> {{ $currentLocation->recorded_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="col-lg-6">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Performance Metrics (30 days)</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <p class="text-muted mb-1">Total Trips</p>
                            <h4 class="mb-0">{{ $statistics['total_trips'] }}</h4>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p class="text-muted mb-1">Total Distance</p>
                            <h4 class="mb-0">{{ round($statistics['total_distance'], 2) }} km</h4>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p class="text-muted mb-1">Total Duration</p>
                            <h4 class="mb-0">{{ floor($statistics['total_duration'] / 60) }}h {{ $statistics['total_duration'] % 60 }}m</h4>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p class="text-muted mb-1">Average Speed</p>
                            <h4 class="mb-0">{{ round($statistics['average_speed'], 2) }} km/h</h4>
                        </div>
                        <div class="col-md-6 mb-0">
                            <p class="text-muted mb-1">Max Speed</p>
                            <h4 class="mb-0">{{ round($statistics['max_speed'], 2) }} km/h</h4>
                        </div>
                        <div class="col-md-6 mb-0">
                            <p class="text-muted mb-1">Fuel Consumption</p>
                            <h4 class="mb-0">{{ round($statistics['fuel_consumption'], 2) }} L</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Location History -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Location History (Last 24 Hours)</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Time</th>
                                <th>Location</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Speed</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($locationHistory as $location)
                            <tr>
                                <td>{{ $location->recorded_at->format('H:i:s') }}</td>
                                <td>{{ $location->address ?? 'Unknown' }}</td>
                                <td>{{ $location->latitude }}</td>
                                <td>{{ $location->longitude }}</td>
                                <td>{{ $location->speed }} km/h</td>
                                <td>
                                    <span class="badge bg-{{ $location->status === 'active' ? 'success' : 'warning' }}">
                                        {{ ucfirst($location->status) }}
                                    </span>
                                </td>
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

    <!-- Trip History -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Trip History (Last 30 Days)</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Trip Date</th>
                                <th>Duration</th>
                                <th>Distance</th>
                                <th>Avg Speed</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tripHistory as $trip)
                            <tr>
                                <td>{{ $trip->start_time->format('Y-m-d H:i') }}</td>
                                <td>{{ $trip->getDurationFormatted() }}</td>
                                <td>{{ round($trip->total_distance, 2) }} km</td>
                                <td>{{ round($trip->average_speed, 2) }} km/h</td>
                                <td>
                                    <span class="badge bg-{{ $trip->status === 'completed' ? 'success' : 'warning' }}">
                                        {{ ucfirst($trip->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('tracking.trip', $trip->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-map"></i> View
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No trips found</td>
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
function initializeCurrentMap() {
    @if($currentLocation)
    const map = new google.maps.Map(document.getElementById('currentMap'), {
        zoom: 15,
        center: {
            lat: parseFloat({{ $currentLocation->latitude }}),
            lng: parseFloat({{ $currentLocation->longitude }})
        }
    });

    new google.maps.Marker({
        position: {
            lat: parseFloat({{ $currentLocation->latitude }}),
            lng: parseFloat({{ $currentLocation->longitude }})
        },
        map: map,
        title: '{{ $armada->plate_number }}'
    });
    @endif
}

document.addEventListener('DOMContentLoaded', initializeCurrentMap);
</script>
@endsection
