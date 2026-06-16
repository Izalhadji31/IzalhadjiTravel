@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0 text-gray-800">Vehicle Details - {{ $armada->plate_number }}</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('fleet.vehicles') }}" class="btn btn-secondary">
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

    <!-- Performance Metrics -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Performance (30 Days)</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-6">
                            <p class="text-muted mb-1">Total Trips</p>
                            <h4 class="mb-0">{{ $metrics['total_trips'] }}</h4>
                        </div>
                        <div class="col-6">
                            <p class="text-muted mb-1">Total Distance</p>
                            <h4 class="mb-0">{{ round($metrics['total_distance'], 2) }} km</h4>
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-6">
                            <p class="text-muted mb-1">Duration</p>
                            <h4 class="mb-0">{{ floor($metrics['total_duration'] / 60) }}h</h4>
                        </div>
                        <div class="col-6">
                            <p class="text-muted mb-1">Avg Speed</p>
                            <h4 class="mb-0">{{ round($metrics['average_speed'], 2) }} km/h</h4>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-6">
                            <p class="text-muted mb-1">Utilization</p>
                            <h4 class="mb-0">{{ $metrics['utilization_rate'] }}%</h4>
                        </div>
                        <div class="col-6">
                            <p class="text-muted mb-1">Revenue</p>
                            <h4 class="mb-0">Rp {{ number_format($metrics['revenue'], 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Maintenance Status -->
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Maintenance Status</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-6">
                            <p class="text-muted mb-1">Overdue</p>
                            <h4 class="mb-0">{{ $maintenanceStatus['overdue'] }}</h4>
                        </div>
                        <div class="col-6">
                            <p class="text-muted mb-1">Upcoming</p>
                            <h4 class="mb-0">{{ $maintenanceStatus['upcoming'] }}</h4>
                        </div>
                    </div>
                    @if($maintenanceStatus['needs_attention'])
                    <div class="alert alert-warning mb-0">
                        <i class="fas fa-exclamation-triangle"></i> This vehicle needs maintenance attention!
                    </div>
                    @else
                    <div class="alert alert-success mb-0">
                        <i class="fas fa-check-circle"></i> All maintenance up to date
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Maintenance Logs -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Maintenance History</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Description</th>
                                <th>Cost</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($maintenanceLogs as $log)
                            <tr>
                                <td>{{ $log->maintenance_date->format('Y-m-d') }}</td>
                                <td>{{ $log->maintenance_type }}</td>
                                <td>{{ $log->description ?? '-' }}</td>
                                <td>Rp {{ number_format($log->cost, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge bg-{{ $log->status === 'completed' ? 'success' : 'warning' }}">
                                        {{ ucfirst($log->status) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No maintenance records</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($maintenanceLogs->hasPages())
                <div class="card-footer">
                    {{ $maintenanceLogs->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
