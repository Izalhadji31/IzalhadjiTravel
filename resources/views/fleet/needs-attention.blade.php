@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0 text-gray-800">Vehicles Needing Attention</h1>
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
                    <h6 class="m-0 font-weight-bold text-danger">{{ $vehicles->count() }} Vehicles Require Attention</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Plate Number</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Issue</th>
                                <th>Last Update</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($vehicles as $vehicle)
                            <tr class="table-danger">
                                <td><strong>{{ $vehicle->plate_number }}</strong></td>
                                <td>{{ $vehicle->vehicle_type }}</td>
                                <td>
                                    <span class="badge bg-warning">{{ ucfirst($vehicle->status) }}</span>
                                </td>
                                <td>
                                    @if($vehicle->status === 'perawatan')
                                        In Maintenance
                                    @else
                                        Overdue Maintenance / Offline
                                    @endif
                                </td>
                                <td>{{ $vehicle->updated_at->diffForHumans() }}</td>
                                <td>
                                    <a href="{{ route('fleet.vehicle-detail', $vehicle->id) }}" class="btn btn-sm btn-danger">
                                        <i class="fas fa-eye"></i> Review
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No vehicles needing attention</td>
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
