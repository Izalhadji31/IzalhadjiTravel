@extends('layouts.app')

@section('title', 'Add New Vehicle')

@section('content')
    <!-- Page Header -->
    <div class="page-header mb-8">
        <h1 class="page-title">Add New Vehicle</h1>
        <p class="page-subtitle">Register a new vehicle to your fleet.</p>
    </div>

    <div class="max-w-2xl">
        <div class="card">
            <!-- Form Header -->
            <div class="flex items-center space-x-3 mb-6 pb-4 border-b border-gray-200">
                <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 17H6a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2h-2.183m-2.817-1.338A4 4 0 0014.146 4H14a4 4 0 00-4 4v4H8m0 0h.01"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-gray-900">Vehicle Information</h2>
            </div>

            <!-- Form -->
            <form class="space-y-6">
                @csrf
                
                <!-- Vehicle Name -->
                <div class="form-group">
                    <label for="name" class="form-label">Vehicle Name</label>
                    <input 
                        type="text" 
                        id="name"
                        name="name"
                        placeholder="e.g., Toyota Avanza" 
                        class="form-input"
                        required
                    >
                </div>

                <!-- License Plate -->
                <div class="form-group">
                    <label for="license_plate" class="form-label">License Plate</label>
                    <input 
                        type="text" 
                        id="license_plate"
                        name="license_plate"
                        placeholder="e.g., B-1234-ABC" 
                        class="form-input"
                        required
                    >
                </div>

                <!-- Vehicle Type -->
                <div class="form-group">
                    <label for="type" class="form-label">Vehicle Type</label>
                    <select id="type" name="type" class="form-select" required>
                        <option value="">Select vehicle type</option>
                        <option value="mpv">MPV</option>
                        <option value="sedan">Sedan</option>
                        <option value="truck">Truck</option>
                        <option value="bus">Bus</option>
                    </select>
                </div>

                <!-- Capacity -->
                <div class="form-group">
                    <label for="capacity" class="form-label">Passenger Capacity</label>
                    <input 
                        type="number" 
                        id="capacity"
                        name="capacity"
                        placeholder="e.g., 7" 
                        class="form-input"
                        min="1"
                        required
                    >
                </div>

                <!-- Daily Rate -->
                <div class="form-group">
                    <label for="daily_rate" class="form-label">Daily Rental Rate</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                        <input 
                            type="number" 
                            id="daily_rate"
                            name="daily_rate"
                            placeholder="e.g., 45.00" 
                            class="form-input pl-8"
                            min="0"
                            step="0.01"
                            required
                        >
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex gap-3 pt-6 border-t border-gray-200">
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add Vehicle
                    </button>
                    <a href="{{ route('vehicles.index') }}" class="btn-secondary">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
