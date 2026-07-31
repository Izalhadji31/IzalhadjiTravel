@extends('layouts.app')

@section('title', 'Vehicles Management')

@section('content')
    <!-- Page Header -->
    <div class="page-header mb-8 flex justify-between items-start">
        <div>
            <h1 class="page-title">Fleet Management</h1>
            <p class="page-subtitle">Manage your fleet of rental vehicles.</p>
        </div>
        <a href="{{ route('vehicles.create') }}" class="btn-primary">
            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add Vehicle
        </a>
    </div>

    <!-- Fleet Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Vehicles</p>
                    <p class="text-3xl font-bold text-blue-600 mt-2">24</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Available</p>
                    <p class="text-3xl font-bold text-emerald-600 mt-2">18</p>
                </div>
                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">In Use</p>
                    <p class="text-3xl font-bold text-amber-600 mt-2">6</p>
                </div>
                <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Vehicles Grid -->
    <div class="grid-responsive">
        @php
            $vehicleTypes = [
                ['name' => 'Toyota Avanza', 'type' => 'MPV', 'seats' => '7', 'rate' => '$45.00', 'image' => 'avanza'],
                ['name' => 'Honda Odyssey', 'type' => 'Minivan', 'seats' => '8', 'rate' => '$55.00', 'image' => 'odyssey'],
                ['name' => 'Toyota Innova', 'type' => 'SUV', 'seats' => '7', 'rate' => '$50.00', 'image' => 'innova'],
                ['name' => 'Nissan Serena', 'type' => 'Minivan', 'seats' => '7', 'rate' => '$48.00', 'image' => 'serena'],
                ['name' => 'Toyota Avanza', 'type' => 'MPV', 'seats' => '7', 'rate' => '$45.00', 'image' => 'avanza'],
                ['name' => 'Honda Odyssey', 'type' => 'Minivan', 'seats' => '8', 'rate' => '$55.00', 'image' => 'odyssey'],
            ];
        @endphp
        @foreach($vehicleTypes as $vehicle)
        <div class="card hover:shadow-lg transition-shadow duration-200">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ $vehicle['name'] }}</h3>
                    <p class="text-sm text-gray-600 mt-1">Plate: <strong>B-{{ rand(1000, 9999) }}-ABC</strong></p>
                </div>
                <span class="badge badge-success">Available</span>
            </div>

            <div class="bg-white rounded-lg h-40 flex items-center justify-center mb-4 border border-gray-200 overflow-hidden">
                <img src="/images/vehicles/{{ $vehicle['image'] }}.svg" alt="{{ $vehicle['name'] }}" class="w-full h-full object-contain p-4">
            </div>

            <div class="space-y-2 mb-4 pb-4 border-b border-gray-200 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">Type:</span>
                    <span class="font-medium text-gray-900">{{ $vehicle['type'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Capacity:</span>
                    <span class="font-medium text-gray-900">{{ $vehicle['seats'] }} Seats</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Daily Rate:</span>
                    <span class="font-bold text-emerald-600">{{ $vehicle['rate'] }}</span>
                </div>
            </div>

            <div class="flex gap-2">
                <a href="#" class="flex-1 px-3 py-2 bg-blue-50 text-blue-600 rounded-lg font-medium hover:bg-blue-100 text-center text-sm transition-colors">Details</a>
                <a href="#" class="flex-1 px-3 py-2 bg-red-50 text-red-600 rounded-lg font-medium hover:bg-red-100 text-center text-sm transition-colors">Delete</a>
            </div>
        </div>
        @endforeach
    </div>
@endsection
