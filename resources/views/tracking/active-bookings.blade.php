@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0 text-gray-800">Active Rentals & Bookings</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('tracking.dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Active Rental Trips ({{ $activeTrips->count() }})</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Booking ID</th>
                                <th>Vehicle</th>
                                <th>Customer</th>
                                <th>Start Time</th>
                                <th>Duration</th>
                                <th>Distance</th>
                                <th>Current Speed</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($activeTrips as $trip)
                            <tr>
                                <td><strong>#{{ $trip->rental_booking_id }}</strong></td>
                                <td>{{ $trip->armada->plate_number }}</td>
                                <td>{{ $trip->user->name }}</td>
                                <td>{{ $trip->start_time->format('Y-m-d H:i') }}</td>
                                <td>
                                    @php
                                        $now = now();
                                        $minutes = $trip->start_time->diffInMinutes($now);
                                        $hours = floor($minutes / 60);
                                        $mins = $minutes % 60;
                                    @endphp
                                    {{ $hours }}h {{ $mins }}m
                                </td>
                                <td>{{ round($trip->total_distance, 2) }} km</td>
                                <td>
                                    @php
                                        $lastLocation = \App\Models\VehicleLocation::where('rental_booking_id', $trip->rental_booking_id)
                                            ->latest('recorded_at')
                                            ->first();
                                    @endphp
                                    {{ $lastLocation->speed ?? 0 }} km/h
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{ ucfirst($trip->status) }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('tracking.trip', $trip->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-map"></i> Track
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">No active rental trips at the moment</td>
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
