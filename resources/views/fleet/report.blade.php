@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0 text-gray-800">Fleet Report</h1>
            <p class="text-muted">Last {{ $days }} days performance</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('fleet.export-report') . '?days=' . $days }}" class="btn btn-success">
                <i class="fas fa-download"></i> Export CSV
            </a>
            <a href="{{ route('fleet.dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <!-- Summary -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <p class="text-muted mb-1">Fleet Utilization</p>
                    <h3 class="h4 mb-0">{{ $utilization }}%</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <p class="text-muted mb-1">Total Vehicles</p>
                    <h3 class="h4 mb-0">{{ count($report) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <p class="text-muted mb-1">Report Period</p>
                    <h3 class="h4 mb-0">{{ $days }} days</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Report -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Vehicle Performance Report</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Plate Number</th>
                                <th>Type</th>
                                <th>Trips</th>
                                <th>Distance (km)</th>
                                <th>Duration (min)</th>
                                <th>Avg Speed (km/h)</th>
                                <th>Utilization (%)</th>
                                <th>Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($report as $item)
                            <tr>
                                <td><strong>{{ $item['vehicle'] }}</strong></td>
                                <td>{{ $item['type'] }}</td>
                                <td>{{ $item['metrics']['total_trips'] }}</td>
                                <td>{{ round($item['metrics']['total_distance'], 2) }}</td>
                                <td>{{ $item['metrics']['total_duration'] }}</td>
                                <td>{{ round($item['metrics']['average_speed'], 2) }}</td>
                                <td>
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar" role="progressbar" style="width: {{ $item['metrics']['utilization_rate'] }}%;">
                                            {{ round($item['metrics']['utilization_rate'], 2) }}%
                                        </div>
                                    </div>
                                </td>
                                <td>Rp {{ number_format($item['metrics']['revenue'], 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">No report data available</td>
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
