@extends('layouts.app')

@section('title', 'Search Rental')

@section('content')
<div class="page-header">
    <h1 class="page-title">Search Car Rental</h1>
    <p class="page-subtitle">Find the perfect vehicle for your trip</p>
</div>

<div class="max-w-4xl">
    <div class="card">
        <form action="{{ route('bookings.rental.search-results') }}" method="POST" class="space-y-6">
            @csrf

            <!-- City Selection -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="pickup_city" class="block text-gray-700 font-medium mb-2">Pickup City</label>
                    <select name="pickup_city" id="pickup_city" required
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600 transition-colors @error('pickup_city') border-red-500 @enderror">
                        <option value="">-- Select pickup city --</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city }}" @selected(old('pickup_city') == $city)>{{ $city }}</option>
                        @endforeach
                    </select>
                    @error('pickup_city') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="dropoff_city" class="block text-gray-700 font-medium mb-2">Drop-off City</label>
                    <select name="dropoff_city" id="dropoff_city" required
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600 transition-colors @error('dropoff_city') border-red-500 @enderror">
                        <option value="">-- Select drop-off city --</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city }}" @selected(old('dropoff_city') == $city)>{{ $city }}</option>
                        @endforeach
                    </select>
                    @error('dropoff_city') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Date & Time Selection -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="start_date" class="block text-gray-700 font-medium mb-2">Pickup Date</label>
                    <input type="date" name="start_date" id="start_date"
                           value="{{ old('start_date') }}" required
                           min="{{ now()->addDay()->format('Y-m-d') }}"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600 transition-colors @error('start_date') border-red-500 @enderror">
                    @error('start_date') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="start_time" class="block text-gray-700 font-medium mb-2">Pickup Time</label>
                    <input type="time" name="start_time" id="start_time"
                           value="{{ old('start_time', '09:00') }}" required
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600 transition-colors @error('start_time') border-red-500 @enderror">
                    @error('start_time') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="end_date" class="block text-gray-700 font-medium mb-2">Drop-off Date</label>
                    <input type="date" name="end_date" id="end_date"
                           value="{{ old('end_date') }}" required
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600 transition-colors @error('end_date') border-red-500 @enderror">
                    @error('end_date') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="end_time" class="block text-gray-700 font-medium mb-2">Drop-off Time</label>
                    <input type="time" name="end_time" id="end_time"
                           value="{{ old('end_time', '18:00') }}" required
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600 transition-colors @error('end_time') border-red-500 @enderror">
                    @error('end_time') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Vehicle Type -->
            <div>
                <label class="block text-gray-700 font-medium mb-3">Vehicle Type</label>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <label class="border-2 border-gray-200 rounded-lg p-4 cursor-pointer hover:border-blue-600 transition-colors @error('vehicle_type_id') border-red-500 @enderror">
                        <input type="radio" name="vehicle_type_id" value="" @checked(old('vehicle_type_id') == '')
                               class="hidden peer">
                        <div class="text-center peer-checked:bg-blue-50 peer-checked:border-blue-600">
                            <div class="text-2xl mb-2">🚗</div>
                            <div class="font-medium">All Types</div>
                        </div>
                    </label>
                    @foreach ($vehicleTypes as $type)
                    <label class="border-2 border-gray-200 rounded-lg p-4 cursor-pointer hover:border-blue-600 transition-colors @error('vehicle_type_id') border-red-500 @enderror">
                        <input type="radio" name="vehicle_type_id" value="{{ $type->id }}" @checked(old('vehicle_type_id') == $type->id)
                               class="hidden peer">
                        <div class="text-center peer-checked:bg-blue-50 peer-checked:border-blue-600">
                            <div class="text-2xl mb-2">{{ $type->icon }}</div>
                            <div class="font-medium">{{ $type->name }}</div>
                            <div class="text-sm text-gray-600">{{ $type->capacity }} seats</div>
                        </div>
                    </label>
                    @endforeach
                </div>
                @error('vehicle_type_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Rental Type -->
            <div>
                <label class="block text-gray-700 font-medium mb-3">Rental Type</label>
                <div class="flex gap-4">
                    <label class="flex items-center border-2 border-gray-200 rounded-lg px-4 py-3 cursor-pointer hover:border-blue-600 transition-colors @error('rental_type') border-red-500 @enderror">
                        <input type="radio" name="rental_type" value="with_driver" @checked(old('rental_type') == 'with_driver')
                               class="w-4 h-4 text-blue-600" required>
                        <span class="ml-2">With Driver</span>
                    </label>
                    <label class="flex items-center border-2 border-gray-200 rounded-lg px-4 py-3 cursor-pointer hover:border-blue-600 transition-colors @error('rental_type') border-red-500 @enderror">
                        <input type="radio" name="rental_type" value="without_driver" @checked(old('rental_type') == 'without_driver')
                               class="w-4 h-4 text-blue-600" required>
                        <span class="ml-2">Without Driver (Self Drive)</span>
                    </label>
                </div>
                @error('rental_type') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Same-day Booking Notice -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <p class="text-sm text-yellow-800">
                    <strong>Note:</strong> Same-day booking must be made at least 12 hours in advance.
                </p>
            </div>

            <!-- Submit Button -->
            <div class="pt-6 border-t border-gray-200">
                <button type="submit" class="btn btn-primary w-full">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 1.25rem; height: 1.25rem;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Search Available Vehicles
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Set minimum end date based on start date
    document.getElementById('start_date').addEventListener('change', function() {
        document.getElementById('end_date').min = this.value;
    });
</script>
@endsection