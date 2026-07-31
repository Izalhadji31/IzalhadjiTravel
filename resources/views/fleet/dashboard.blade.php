@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0 text-gray-800">Fleet Dashboard</h1>
            <p class="text-muted">Manage and monitor your entire vehicle fleet</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('fleet.report') }}" class="btn btn-primary">
                <i class="fas fa-file-pdf"></i> Generate Report
            </a>
        </div>
    </div>

    <!-- Fleet Overview -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-left-primary shadow h-100">
                <div class="card-body">
                    <div class="text-primary font-weight-bold text-uppercase mb-1">Total Fleet</div>
                    <h3 class="h4 mb-0">{{ $data['overview']['total'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-success shadow h-100">
                <div class="card-body">
                    <div class="text-success font-weight-bold text-uppercase mb-1">Available</div>
                    <h3 class="h4 mb-0">{{ $data['overview']['available'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-warning shadow h-100">
                <div class="card-body">
                    <div class="text-warning font-weight-bold text-uppercase mb-1">On Rental</div>
                    <h3 class="h4 mb-0">{{ $data['overview']['on_rental'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-info shadow h-100">
                <div class="card-body">
                    <div class="text-info font-weight-bold text-uppercase mb-1">Utilization</div>
                    <h3 class="h4 mb-0">{{ $data['average_utilization'] }}%</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Key Metrics -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Monthly Performance</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Total Trips</p>
                            <h4 class="mb-2">{{ $data['total_trips'] }}</h4>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Total Distance</p>
                            <h4 class="mb-2">{{ round($data['total_distance'], 0) }} km</h4>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Total Revenue</p>
                            <h4 class="mb-0">Rp {{ number_format($data['total_revenue'], 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vehicles Needing Attention -->
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-danger">Needs Attention ({{ $vehiclesNeedingAttention->count() }})</h6>
                    <a href="{{ route('fleet.needs-attention') }}" class="btn btn-sm btn-danger">View All</a>
                </div>
                <div class="card-body">
                    @forelse($vehiclesNeedingAttention as $vehicle)
                    <div class="row mb-2 pb-2 border-bottom">
                        <div class="col-md-8">
                            <p class="mb-0"><strong>{{ $vehicle->plate_number }}</strong></p>
                            <small class="text-muted">{{ $vehicle->vehicle_type }}</small>
                        </div>
                        <div class="col-md-4 text-end">
                            <a href="{{ route('fleet.vehicle-detail', $vehicle->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted mb-0">No vehicles needing attention</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Vehicles Performance -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Vehicle Performance (30 Days)</h6>
                    <a href="{{ route('fleet.vehicles') }}" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Plate Number</th>
                                <th>Type</th>
                                <th>Trips</th>
                                <th>Distance</th>
                                <th>Duration</th>
                                <th>Utilization</th>
                                <th>Revenue</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data['armadas'] as $armada)
                            <tr>
                                <td><strong>{{ $armada['plate_number'] }}</strong></td>
                                <td>{{ $armada['vehicle_type'] }}</td>
                                <td>{{ $armada['total_trips'] }}</td>
                                <td>{{ round($armada['total_distance'], 2) }} km</td>
                                <td>{{ floor($armada['total_duration'] / 60) }}h</td>
                                <td>
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar" role="progressbar" style="width: {{ $armada['utilization_rate'] }}%;">
                                            {{ $armada['utilization_rate'] }}%
                                        </div>
                                    </div>
                                </td>
                                <td>Rp {{ number_format($armada['revenue'], 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge bg-{{ $armada['status'] === 'tersedia' ? 'success' : 'warning' }}">
                                        {{ ucfirst($armada['status']) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">No vehicle data available</td>
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
