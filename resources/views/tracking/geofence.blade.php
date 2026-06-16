@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0 text-gray-800">Geofence Management</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('tracking.dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Setup Geofence</h6>
                </div>
                <div class="card-body">
                    <form id="geofenceForm">
                        <div class="mb-3">
                            <label for="armada" class="form-label">Select Vehicle</label>
                            <select class="form-select" id="armada" name="armada" required>
                                <option value="">-- Choose a vehicle --</option>
                                @foreach($armadas as $armada)
                                <option value="{{ $armada->id }}">{{ $armada->plate_number }} ({{ $armada->vehicle_type }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="latitude" class="form-label">Center Latitude</label>
                            <input type="number" class="form-control" id="latitude" name="latitude" step="0.00001" required 
                                   placeholder="-6.200000">
                        </div>

                        <div class="mb-3">
                            <label for="longitude" class="form-label">Center Longitude</label>
                            <input type="number" class="form-control" id="longitude" name="longitude" step="0.00001" required 
                                   placeholder="106.816666">
                        </div>

                        <div class="mb-3">
                            <label for="radius" class="form-label">Geofence Radius (km)</label>
                            <input type="number" class="form-control" id="radius" name="radius" step="0.1" min="0.1" required 
                                   value="5" placeholder="5">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-plus"></i> Create Geofence
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Geofence Map</h6>
                </div>
                <div class="card-body p-0">
                    <div id="geofenceMap" style="height: 400px; border-radius: 5px;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Active Geofences</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Vehicle</th>
                                <th>Center Point</th>
                                <th>Radius</th>
                                <th>Currently Inside</th>
                                <th>Last Check</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No active geofences configured</td>
                            </tr>
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
let map;
let circle;

function initializeGeofenceMap() {
    map = new google.maps.Map(document.getElementById('geofenceMap'), {
        zoom: 12,
        center: { lat: -6.2088, lng: 106.8456 } // Jakarta default
    });
}

document.getElementById('geofenceForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const latitude = parseFloat(document.getElementById('latitude').value);
    const longitude = parseFloat(document.getElementById('longitude').value);
    const radius = parseFloat(document.getElementById('radius').value);

    // Update map center
    const center = { lat: latitude, lng: longitude };
    map.setCenter(center);

    // Draw or update circle
    if (circle) {
        circle.setMap(null);
    }

    circle = new google.maps.Circle({
        center: center,
        radius: radius * 1000, // Convert km to meters
        map: map,
        fillColor: '#0066FF',
        fillOpacity: 0.2,
        strokeColor: '#0066FF',
        strokeOpacity: 0.8,
        strokeWeight: 2
    });

    // Add marker at center
    new google.maps.Marker({
        position: center,
        map: map,
        title: 'Geofence Center'
    });

    alert('Geofence created! Monitoring will start immediately.');
});

document.addEventListener('DOMContentLoaded', initializeGeofenceMap);
</script>
@endsection
