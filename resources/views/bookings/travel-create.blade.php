@extends('layouts.app')

@section('title', 'Create Travel Booking')

@section('content')
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">Create Travel Booking</h1>
        <p class="text-gray-600">Book a travel trip to your preferred destination</p>
    </div>

    <div class="max-w-2xl">
        <div class="card">
            <div class="card-header mb-6">Fill in the booking details</div>
            
            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded">
                    <p class="text-red-700 font-semibold mb-2">Please fix the errors:</p>
                    <ul class="text-red-600 text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('bookings.travel.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Route Selection -->
                <div>
                    <label for="route_id" class="block text-gray-700 font-medium mb-2">Select Route</label>
                    <select name="route_id" id="route_id" required
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600 transition-colors @error('route_id') border-red-500 @enderror">
                        <option value="">-- Choose a route --</option>
                        @foreach ($routes as $route)
                            <option value="{{ $route->id }}" @selected(old('route_id') == $route->id)>
                                {{ $route->origin_city }} → {{ $route->destination_city }} ({{ $route->distance_km }} km)
                            </option>
                        @endforeach
                    </select>
                    @error('route_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Scheduled Date -->
                <div>
                    <label for="scheduled_date" class="block text-gray-700 font-medium mb-2">Travel Date</label>
                    <input type="date" name="scheduled_date" id="scheduled_date" 
                           value="{{ old('scheduled_date') }}" required
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600 transition-colors @error('scheduled_date') border-red-500 @enderror">
                    @error('scheduled_date') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Number of Seats -->
                <div>
                    <label for="number_of_seats" class="block text-gray-700 font-medium mb-2">Number of Seats</label>
                    <input type="number" name="number_of_seats" id="number_of_seats" min="1" max="16"
                           value="{{ old('number_of_seats', 1) }}" required
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600 transition-colors @error('number_of_seats') border-red-500 @enderror">
                    <p class="text-gray-500 text-sm mt-1">Maximum 16 seats per booking</p>
                    @error('number_of_seats') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Terms -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <p class="text-sm text-gray-700">
                        <strong>Note:</strong> You must have a verified identity to proceed with the booking. Please verify your identity in your profile settings.
                    </p>
                </div>

                <!-- Buttons -->
                <div class="flex gap-3 pt-6 border-t border-gray-200">
                    <button type="submit" class="btn-primary flex-1">Create Booking</button>
                    <a href="{{ route('bookings.travel') }}" class="btn-secondary flex-1 text-center">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
