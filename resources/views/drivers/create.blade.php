@extends('layouts.app')

@section('title', 'Add New Driver')

@section('content')
    <!-- Page Header -->
    <div class="page-header mb-8">
        <h1 class="page-title">Add New Driver</h1>
        <p class="page-subtitle">Register a new driver to the system.</p>
    </div>

    <div class="max-w-2xl">
        <div class="card">
            <!-- Form Header -->
            <div class="flex items-center space-x-3 mb-6 pb-4 border-b border-gray-200">
                <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-gray-900">Driver Information</h2>
            </div>

            <!-- Form -->
            <form class="space-y-6">
                @csrf
                
                <!-- Full Name -->
                <div class="form-group">
                    <label for="name" class="form-label">Full Name</label>
                    <input 
                        type="text" 
                        id="name"
                        name="name"
                        placeholder="e.g., John Doe" 
                        class="form-input"
                        required
                    >
                </div>

                <!-- Phone Number -->
                <div class="form-group">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input 
                        type="tel" 
                        id="phone"
                        name="phone"
                        placeholder="e.g., +62 812-3456-7890" 
                        class="form-input"
                        required
                    >
                </div>

                <!-- License Number -->
                <div class="form-group">
                    <label for="license_number" class="form-label">License Number</label>
                    <input 
                        type="text" 
                        id="license_number"
                        name="license_number"
                        placeholder="e.g., DL-123456" 
                        class="form-input"
                        required
                    >
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input 
                        type="email" 
                        id="email"
                        name="email"
                        placeholder="e.g., driver@example.com" 
                        class="form-input"
                        required
                    >
                </div>

                <!-- Assign Vehicle -->
                <div class="form-group">
                    <label for="vehicle_id" class="form-label">Assign Vehicle (Optional)</label>
                    <select id="vehicle_id" name="vehicle_id" class="form-select">
                        <option value="">Select a vehicle</option>
                        <option value="1">Toyota Avanza</option>
                        <option value="2">Honda CR-V</option>
                    </select>
                </div>

                <!-- Form Actions -->
                <div class="flex gap-3 pt-6 border-t border-gray-200">
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add Driver
                    </button>
                    <a href="{{ route('drivers.index') }}" class="btn-secondary">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
