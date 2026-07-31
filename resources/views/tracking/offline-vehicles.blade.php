@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0 text-gray-800">Offline Vehicles Alert</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('tracking.dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong><i class="fas fa-wifi"></i> Offline Vehicles</strong>
                <p class="mb-0">The following vehicles have not sent location updates in the last 30 minutes.</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-danger">{{ $offlineVehicles->count() }} Offline Vehicles</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Plate Number</th>
                                <th>Vehicle Type</th>
                                <th>Status</th>
                                <th>Driver</th>
                                <th>Last Seen</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($offlineVehicles as $vehicle)
                            <tr class="table-danger">
                                <td><strong>{{ $vehicle->plate_number }}</strong></td>
                                <td>{{ $vehicle->vehicle_type }}</td>
                                <td><span class="badge bg-secondary">Offline</span></td>
                                <td>{{ $vehicle->driver_name }}</td>
                                <td>
                                    @php
                                        $lastLocation = \App\Models\VehicleLocation::where('armada_id', $vehicle->id)
                                            ->latest('recorded_at')
                                            ->first();
                                    @endphp
                                    {{ $lastLocation?->recorded_at->diffForHumans() ?? 'Never' }}
                                </td>
                                <td>
                                    <a href="{{ route('tracking.vehicle', $vehicle->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-success py-4">
                                    <i class="fas fa-check-circle"></i> All vehicles are online!
                                </td>
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
