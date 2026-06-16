@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h3 mb-0 text-gray-800">Real-time Tracking Map</h1>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('tracking.dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-body p-0">
                    <div id="fullMap" style="height: 700px; border-radius: 5px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.api_key') }}"></script>
<script>
function initializeFullMap() {
    const locations = @json($locations);
    
    if (locations.length === 0) {
        document.getElementById('fullMap').innerHTML = '<div class="d-flex align-items-center justify-content-center h-100"><p class="text-muted">No vehicle locations available</p></div>';
        return;
    }

    const map = new google.maps.Map(document.getElementById('fullMap'), {
        zoom: 12,
        center: {
            lat: parseFloat(locations[0].latitude),
            lng: parseFloat(locations[0].longitude)
        },
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    const bounds = new google.maps.LatLngBounds();

    locations.forEach(location => {
        const marker = new google.maps.Marker({
            position: {
                lat: parseFloat(location.latitude),
                lng: parseFloat(location.longitude)
            },
            map: map,
            title: location.armada?.plate_number,
            icon: 'https://maps.gstatic.com/mapfiles/ms2/micons/blue-dot.png'
        });

        const infoWindow = new google.maps.InfoWindow({
            content: `
                <div>
                    <p><strong>${location.armada?.plate_number}</strong></p>
                    <p>${location.address || 'Location unknown'}</p>
                    <p>Speed: ${location.speed} km/h</p>
                    <p>Last updated: ${new Date(location.recorded_at).toLocaleTimeString()}</p>
                </div>
            `
        });

        marker.addListener('click', () => {
            infoWindow.open(map, marker);
        });

        bounds.extend(marker.getPosition());
    });

    map.fitBounds(bounds);
}

// Auto refresh every 10 seconds
setInterval(() => {
    fetch('/api/tracking/locations/realtime')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update markers
                console.log('Locations updated:', data.data);
            }
        });
}, 10000);

document.addEventListener('DOMContentLoaded', initializeFullMap);
</script>
@endsection
