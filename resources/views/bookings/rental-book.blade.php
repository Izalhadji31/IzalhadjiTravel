@extends('layouts.app')

@section('title', 'Complete Booking')

@section('content')
<div class="page-header">
    <h1 class="page-title">Complete Your Booking</h1>
    <p class="page-subtitle">{{ $searchParams['pickup_city'] }} → {{ $searchParams['dropoff_city'] }}</p>
</div>

<div class="max-w-4xl">
    <div class="card mb-6">
        <h2 class="text-xl font-bold mb-4">Booking Summary</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
            <div>
                <div class="text-gray-600">Pickup</div>
                <div class="font-medium">{{ \Carbon\Carbon::parse($searchParams['start_date'])->format('d M Y') }}</div>
                <div class="font-medium">{{ $searchParams['start_time'] }}</div>
            </div>
            <div>
                <div class="text-gray-600">Drop-off</div>
                <div class="font-medium">{{ \Carbon\Carbon::parse($searchParams['end_date'])->format('d M Y') }}</div>
                <div class="font-medium">{{ $searchParams['end_time'] }}</div>
            </div>
            <div>
                <div class="text-gray-600">Vehicle</div>
                <div class="font-medium">{{ $selectedArmada->vehicle_name ?? 'Standard Vehicle' }}</div>
                <div class="font-medium">{{ $selectedArmada->plate_number ?? '' }}</div>
            </div>
            <div>
                <div class="text-gray-600">Total Price</div>
                <div class="font-bold text-blue-600">Rp {{ number_format($searchParams['total_price'], 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    <div class="card">
        <form action="{{ route('bookings.rental.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Hidden Fields -->
            @foreach ($searchParams as $key => $value)
                @if (!in_array($key, ['_token', 'armada_id']))
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endif
            @endforeach
            <input type="hidden" name="assigned_armada_id" value="{{ $selectedArmada->id ?? '' }}">

            <!-- Pickup & Drop-off Locations -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="pickup_location" class="block text-gray-700 font-medium mb-2">Pickup Location</label>
                    <input type="text" name="pickup_location" id="pickup_location" required
                           value="{{ old('pickup_location', $searchParams['pickup_city']) }}"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600 transition-colors @error('pickup_location') border-red-500 @enderror"
                           placeholder="e.g., Airport, Hotel, Address">
                    @error('pickup_location') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="dropoff_location" class="block text-gray-700 font-medium mb-2">Drop-off Location</label>
                    <input type="text" name="dropoff_location" id="dropoff_location" required
                           value="{{ old('dropoff_location', $searchParams['dropoff_city']) }}"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600 transition-colors @error('dropoff_location') border-red-500 @enderror"
                           placeholder="e.g., Airport, Hotel, Address">
                    @error('dropoff_location') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Address Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="pickup_address" class="block text-gray-700 font-medium mb-2">Pickup Address (Optional)</label>
                    <textarea name="pickup_address" id="pickup_address" rows="2"
                              class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600 transition-colors @error('pickup_address') border-red-500 @enderror"
                              placeholder="Full address for pickup">{{ old('pickup_address') }}</textarea>
                    @error('pickup_address') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="dropoff_address" class="block text-gray-700 font-medium mb-2">Drop-off Address (Optional)</label>
                    <textarea name="dropoff_address" id="dropoff_address" rows="2"
                              class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600 transition-colors @error('dropoff_address') border-red-500 @enderror"
                              placeholder="Full address for drop-off">{{ old('dropoff_address') }}</textarea>
                    @error('dropoff_address') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Special Requests -->
            <div>
                <label for="special_requests" class="block text-gray-700 font-medium mb-2">Special Requests (Optional)</label>
                <textarea name="special_requests" id="special_requests" rows="3"
                          class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600 transition-colors @error('special_requests') border-red-500 @enderror"
                          placeholder="e.g., Child seat, GPS, extra luggage, etc.">{{ old('special_requests') }}</textarea>
                @error('special_requests') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Addons -->
            @if(isset($addonCategories))
            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Addons Tambahan (Opsional)</h3>
                
                @foreach ($addonCategories as $category)
                <div class="mb-6">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-2xl">{{ $category->icon }}</span>
                        <h4 class="font-medium text-gray-900">{{ $category->name }}</h4>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach ($category->addons as $addon)
                        <label class="border border-gray-200 rounded-lg p-3 cursor-pointer hover:border-blue-600 transition-colors">
                            <div class="flex items-start gap-3">
                                <input type="checkbox" name="addons[{{ $addon->id }}][addon_id]" value="{{ $addon->id }}"
                                       class="mt-1 w-4 h-4 text-blue-600 rounded addon-checkbox"
                                       onchange="toggleAddonQuantity('{{ $addon->id }}')">
                                <div class="flex-1">
                                    <div class="font-medium text-sm">{{ $addon->name }}</div>
                                    <div class="text-xs text-gray-600 mb-1">{{ $addon->description }}</div>
                                    <div class="text-sm font-semibold text-blue-600">
                                        Rp {{ number_format($addon->price, 0, ',', '.') }}
                                        @if($addon->pricing_type === 'daily')
                                        /hari
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="addon-quantity hidden mt-2" id="addon-quantity-{{ $addon->id }}">
                                <label class="text-xs text-gray-600">Jumlah:</label>
                                <select name="addons[{{ $addon->id }}][quantity]" class="w-20 px-2 py-1 border border-gray-200 rounded text-sm">
                                    @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            <!-- Pickup Instructions -->
            <div>
                <label for="pickup_instructions" class="block text-gray-700 font-medium mb-2">Pickup Instructions (Optional)</label>
                <textarea name="pickup_instructions" id="pickup_instructions" rows="2"
                          class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600 transition-colors @error('pickup_instructions') border-red-500 @enderror"
                          placeholder="e.g., Call me when you arrive, meet at entrance, etc.">{{ old('pickup_instructions') }}</textarea>
                @error('pickup_instructions') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Book for Guest -->
            <div>
                <label class="flex items-center">
                    <input type="checkbox" name="is_for_guest" value="1" class="w-4 h-4 text-blue-600 rounded">
                    <span class="ml-2 text-gray-700">Book for someone else</span>
                </label>
            </div>

            <!-- Guest Information (Conditional) -->
            <div id="guest-info" class="hidden space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="guest_name" class="block text-gray-700 font-medium mb-2">Guest Name</label>
                        <input type="text" name="guest_name" id="guest_name"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600 transition-colors @error('guest_name') border-red-500 @enderror"
                               placeholder="Full name">
                        @error('guest_name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="guest_phone" class="block text-gray-700 font-medium mb-2">Guest Phone</label>
                        <input type="tel" name="guest_phone" id="guest_phone"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600 transition-colors @error('guest_phone') border-red-500 @enderror"
                               placeholder="Phone number">
                        @error('guest_phone') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="guest_email" class="block text-gray-700 font-medium mb-2">Guest Email</label>
                        <input type="email" name="guest_email" id="guest_email"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600 transition-colors @error('guest_email') border-red-500 @enderror"
                               placeholder="Email address">
                        @error('guest_email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Terms -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <p class="text-sm text-gray-700">
                    <strong>Note:</strong> By completing this booking, you agree to our terms and conditions. Cancellation policies apply.
                </p>
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 pt-6 border-t border-gray-200">
                <button type="submit" class="btn btn-primary flex-1">
                    Complete Booking
                </button>
                <a href="{{ route('bookings.rental.search') }}" class="btn btn-secondary flex-1 text-center">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
    // Toggle guest info visibility
    document.querySelector('input[name="is_for_guest"]').addEventListener('change', function() {
        document.getElementById('guest-info').classList.toggle('hidden', !this.checked);
    });
</script>
@endsection