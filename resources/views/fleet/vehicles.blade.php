@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0 text-gray-800">Fleet Vehicles</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('fleet.dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">All Vehicles</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Plate Number</th>
                                <th>Type</th>
                                <th>Capacity</th>
                                <th>Status</th>
                                <th>Trips (30d)</th>
                                <th>Distance (30d)</th>
                                <th>Utilization</th>
                                <th>Revenue (30d)</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($vehicles as $item)
                            <tr>
                                <td><strong>{{ $item['armada']->plate_number }}</strong></td>
                                <td>{{ $item['armada']->vehicle_type }}</td>
                                <td>{{ $item['armada']->seat_capacity }} seats</td>
                                <td>
                                    <span class="badge bg-{{ $item['armada']->status === 'tersedia' ? 'success' : 'warning' }}">
                                        {{ ucfirst($item['armada']->status) }}
                                    </span>
                                </td>
                                <td>{{ $item['metrics']['total_trips'] }}</td>
                                <td>{{ round($item['metrics']['total_distance'], 2) }} km</td>
                                <td>
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar" role="progressbar" style="width: {{ $item['metrics']['utilization_rate'] }}%;">
                                            {{ $item['metrics']['utilization_rate'] }}%
                                        </div>
                                    </div>
                                </td>
                                <td>Rp {{ number_format($item['metrics']['revenue'], 0, ',', '.') }}</td>
                                <td>
                                    <a href="{{ route('fleet.vehicle-detail', $item['armada']->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">No vehicles found</td>
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
