@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0 text-gray-800">Maintenance Management</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('fleet.dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <!-- Overdue Maintenance Alert -->
    @if($overdueMaintenance->count() > 0)
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><i class="fas fa-exclamation-triangle"></i> Overdue Maintenance!</strong>
                <p class="mb-0">{{ $overdueMaintenance->count() }} vehicle(s) have overdue maintenance that needs to be addressed immediately.</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
    @endif

    <!-- Overdue Maintenance -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card shadow border-left-danger">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-danger">Overdue Maintenance</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Vehicle</th>
                                <th>Maintenance Type</th>
                                <th>Scheduled Date</th>
                                <th>Days Overdue</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($overdueMaintenance as $maintenance)
                            <tr class="table-danger">
                                <td><strong>{{ $maintenance->armada->plate_number }}</strong></td>
                                <td>{{ $maintenance->maintenance_type }}</td>
                                <td>{{ $maintenance->scheduled_next_at->format('Y-m-d') }}</td>
                                <td>
                                    <span class="badge bg-danger">
                                        {{ $maintenance->scheduled_next_at->diffInDays(now()) }} days
                                    </span>
                                </td>
                                <td><span class="badge bg-danger">Overdue</span></td>
                                <td>
                                    <a href="{{ route('fleet.vehicle-detail', $maintenance->armada_id) }}" class="btn btn-sm btn-danger">
                                        Mark Complete
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No overdue maintenance</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming Maintenance -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card shadow border-left-warning">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning">Upcoming Maintenance (Next 7 Days)</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Vehicle</th>
                                <th>Maintenance Type</th>
                                <th>Scheduled Date</th>
                                <th>Days Until</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($upcomingMaintenance as $maintenance)
                            <tr>
                                <td><strong>{{ $maintenance->armada->plate_number }}</strong></td>
                                <td>{{ $maintenance->maintenance_type }}</td>
                                <td>{{ $maintenance->scheduled_next_at->format('Y-m-d') }}</td>
                                <td>
                                    <span class="badge bg-warning">
                                        {{ now()->diffInDays($maintenance->scheduled_next_at) }} days
                                    </span>
                                </td>
                                <td><span class="badge bg-warning">Scheduled</span></td>
                                <td>
                                    <a href="{{ route('fleet.vehicle-detail', $maintenance->armada_id) }}" class="btn btn-sm btn-warning">
                                        View
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No upcoming maintenance</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Completed Maintenance History -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Completed Maintenance (Recent)</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Vehicle</th>
                                <th>Maintenance Type</th>
                                <th>Date</th>
                                <th>Cost</th>
                                <th>Description</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($completedMaintenance as $maintenance)
                            <tr>
                                <td><strong>{{ $maintenance->armada->plate_number }}</strong></td>
                                <td>{{ $maintenance->maintenance_type }}</td>
                                <td>{{ $maintenance->maintenance_date->format('Y-m-d') }}</td>
                                <td>Rp {{ number_format($maintenance->cost, 0, ',', '.') }}</td>
                                <td>{{ $maintenance->description ?? '-' }}</td>
                                <td><span class="badge bg-success">Completed</span></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No maintenance history</td>
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
