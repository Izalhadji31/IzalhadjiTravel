@extends('layouts.app')

@section('title', 'Add New Route')

@section('content')
    <!-- Page Header -->
    <div class="page-header mb-8">
        <h1 class="page-title">Add New Route</h1>
        <p class="page-subtitle">Create a new travel or rental route for your business.</p>
    </div>

    <div class="max-w-2xl">
        <div class="card">
            <!-- Form Header -->
            <div class="flex items-center space-x-3 mb-6 pb-4 border-b border-gray-200">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 003 16.382V5.618a1 1 0 011.553-.894L9 7.882"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-gray-900">Route Information</h2>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('routes.store') }}" class="space-y-6">
                @csrf
                
                <!-- Route Name -->
                <div class="form-group">
                    <label for="name" class="form-label">Route Name</label>
                    <input 
                        type="text" 
                        id="name"
                        name="name"
                        placeholder="e.g., Jakarta → Surabaya" 
                        class="form-input"
                        required
                    >
                    <p class="text-gray-500 text-sm mt-1">Enter a descriptive name for this route</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="form-group">
                        <label for="origin_city" class="form-label">Origin City</label>
                        <input type="text" id="origin_city" name="origin_city" placeholder="e.g., Ende" class="form-input">
                    </div>
                    <div class="form-group">
                        <label for="destination_city" class="form-label">Destination City</label>
                        <input type="text" id="destination_city" name="destination_city" placeholder="e.g., Bajawa" class="form-input">
                    </div>
                </div>

                <!-- Route Type -->
                <div class="form-group">
                    <label for="route_type" class="form-label">Route Type</label>
                    <select id="route_type" name="route_type" class="form-select" required>
                        <option value="">Select route type</option>
                        <option value="travel">Travel Route</option>
                        <option value="rental">Rental Route</option>
                        <option value="both">Travel & Rental</option>
                    </select>
                </div>

                <!-- Distance -->
                <div class="form-group">
                    <label for="distance_km" class="form-label">Distance (km)</label>
                    <input 
                        type="number" 
                        id="distance_km"
                        name="distance_km"
                        placeholder="e.g., 850" 
                        class="form-input"
                        min="0"
                        step="0.1"
                        required
                    >
                </div>

                <!-- Estimated Duration -->
                <div class="form-group">
                    <label for="estimated_hours" class="form-label">Estimated Duration (hours)</label>
                    <input type="number" id="estimated_hours" name="estimated_hours" placeholder="e.g., 2.5" class="form-input" min="0" step="0.1">
                </div>

                <!-- Form Actions -->
                <div class="flex gap-3 pt-6 border-t border-gray-200">
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Create Route
                    </button>
                    <a href="{{ route('routes.index') }}" class="btn-secondary">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
