@extends('layouts.app')

@section('title', 'Rental Booking Details')

@section('content')
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Rental Booking Details</h1>
            <span class="px-4 py-2 rounded-full text-sm font-bold
                @if($booking->status === 'pending') bg-yellow-100 text-yellow-800
                @elseif($booking->status === 'confirmed') bg-blue-100 text-blue-800
                @elseif($booking->status === 'completed') bg-green-100 text-green-800
                @else bg-red-100 text-red-800
                @endif
            ">{{ strtoupper($booking->status) }}</span>
        </div>
        <p class="text-gray-600">Booking ID: {{ $booking->id }}</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Booking Info -->
            <div class="card">
                <h3 class="card-header">Booking Information</h3>
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-gray-600 text-sm">Booking Date</p>
                            <p class="text-lg font-semibold">{{ $booking->created_at->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Rental Duration</p>
                            <p class="text-lg font-semibold">{{ \Carbon\Carbon::parse($booking->start_date)->diffInDays(\Carbon\Carbon::parse($booking->end_date)) }} Days</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-gray-600 text-sm">Pickup City</p>
                            <p class="text-lg font-semibold">{{ $booking->pickup_city }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Drop-off City</p>
                            <p class="text-lg font-semibold">{{ $booking->dropoff_city }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-gray-600 text-sm">Start Date</p>
                            <p class="text-lg font-semibold">{{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}</p>
                            <p class="text-sm text-gray-500">{{ $booking->start_time }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">End Date</p>
                            <p class="text-lg font-semibold">{{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}</p>
                            <p class="text-sm text-gray-500">{{ $booking->end_time }}</p>
                        </div>
                    </div>
                    @if($booking->pickup_location)
                    <div>
                        <p class="text-gray-600 text-sm">Pickup Location</p>
                        <p class="text-lg font-semibold">{{ $booking->pickup_location }}</p>
                        @if($booking->pickup_address)
                        <p class="text-sm text-gray-500">{{ $booking->pickup_address }}</p>
                        @endif
                    </div>
                    @endif
                    @if($booking->dropoff_location)
                    <div>
                        <p class="text-gray-600 text-sm">Drop-off Location</p>
                        <p class="text-lg font-semibold">{{ $booking->dropoff_location }}</p>
                        @if($booking->dropoff_address)
                        <p class="text-sm text-gray-500">{{ $booking->dropoff_address }}</p>
                        @endif
                    </div>
                    @endif
                    <div>
                        <p class="text-gray-600 text-sm">Rental Type</p>
                        <p class="text-lg font-semibold">
                            @if($booking->rental_type === 'with_driver')
                                ✓ With Driver
                            @else
                                ✗ Without Driver (Self Drive)
                            @endif
                        </p>
                    </div>
                    @if($booking->vehicleType)
                    <div>
                        <p class="text-gray-600 text-sm">Vehicle Type</p>
                        <p class="text-lg font-semibold">{{ $booking->vehicleType->name }} ({{ $booking->vehicleType->capacity }} seats)</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- E-Voucher -->
            @if($booking->voucher)
            <div class="card bg-gradient-to-r from-blue-50 to-purple-50">
                <h3 class="card-header">E-Voucher</h3>
                <div class="space-y-4">
                    <div class="bg-white rounded-lg p-4 border-2 border-dashed border-blue-300">
                        <div class="text-center mb-4">
                            <div class="text-4xl mb-2">🎫</div>
                            <p class="text-sm text-gray-600">Voucher Code</p>
                            <p class="text-2xl font-bold text-blue-600 font-mono">{{ $booking->voucher->code }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-sm text-gray-600 mb-2">QR Code</p>
                            <div class="bg-gray-100 rounded-lg p-4 inline-block">
                                <div class="w-32 h-32 bg-white rounded flex items-center justify-center mx-auto">
                                    <div class="text-center">
                                        <div class="text-3xl mb-1">📱</div>
                                        <p class="text-xs text-gray-500 font-mono">{{ $booking->voucher->qr_code }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <p class="text-gray-600">Valid From</p>
                                    <p class="font-medium">{{ $booking->voucher->valid_from->format('d M Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600">Valid Until</p>
                                    <p class="font-medium">{{ $booking->voucher->valid_until->format('d M Y') }}</p>
                                </div>
                            </div>
                            <div class="mt-3 text-sm">
                                <p class="text-gray-600">Status</p>
                                <p class="font-medium @if($booking->voucher->is_used) text-green-600 @else text-blue-600 @endif">
                                    @if($booking->voucher->is_used)
                                        Used ({{ $booking->voucher->used_at->format('d M Y H:i') }})
                                    @else
                                        Valid & Unused
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    <p class="text-xs text-gray-600 text-center">
                        Show this voucher to the driver to start your rental
                    </p>
                </div>
            </div>
            @endif

            <!-- Vehicle Info -->
            @if($booking->armada)
            <div class="card">
                <h3 class="card-header">Vehicle Information</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Vehicle</p>
                            <p class="text-lg font-semibold">{{ $booking->armada->vehicle_type }}</p>
                        </div>
                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-bold">{{ ucfirst($booking->armada->status) }}</span>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">License Plate</p>
                        <p class="text-lg font-semibold font-mono">{{ $booking->armada->plate_number }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Seat Capacity</p>
                        <p class="text-lg font-semibold">{{ $booking->armada->seat_capacity }} Persons</p>
                    </div>
                    
                    @if($booking->with_driver)
                    <div class="border-t pt-3 mt-3">
                        <p class="text-gray-600 text-sm">Driver</p>
                        <p class="text-lg font-semibold">{{ $booking->armada->driver_name }}</p>
                        <p class="text-gray-600 text-sm mt-2">Contact</p>
                        <p class="text-lg font-semibold">{{ $booking->armada->driver_phone }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Actions -->
            <div class="space-y-3">
                @if($booking->status === 'pending')
                    <form action="{{ route('bookings.rental.destroy', $booking) }}" method="POST" onsubmit="return confirm('Cancel this booking?')"
>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-danger w-full">Cancel Booking</button>
                    </form>
                @endif
                <a href="{{ route('bookings.rental') }}" class="btn-secondary w-full text-center">Back to Bookings</a>
            </div>
        </div>

        <!-- Price Summary -->
        <div>
            <div class="card sticky top-20">
                <h3 class="card-header">Price Breakdown</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-2 border-b border-gray-200">
                        <span class="text-gray-600">Base Rental</span>
                        <span class="font-semibold">Rp {{ number_format($booking->route->rentalPrices->first()->price_without_driver, 0, ',', '.') }}</span>
                    </div>

                    @if($booking->with_driver)
                    <div class="flex justify-between items-center py-2 border-b border-gray-200">
                        <span class="text-gray-600">Driver Fee</span>
                        <span class="font-semibold">Rp {{ number_format($booking->total_price - $booking->route->rentalPrices->first()->price_without_driver, 0, ',', '.') }}</span>
                    </div>
                    @else
                    <div class="bg-blue-50 p-2 rounded text-xs text-blue-700 mb-2">
                        Self-drive rental (no driver fee)
                    </div>
                    @endif

                    <div class="flex justify-between items-center py-2 border-t-2 border-blue-200 pt-4">
                        <span class="font-bold text-lg">Total Price</span>
                        <span class="text-2xl font-bold text-blue-600">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                    </div>

                    <div class="bg-blue-50 p-4 rounded-lg mt-4">
                        <p class="text-sm text-gray-600 mb-2">Payment Status</p>
                        <p class="text-lg font-bold text-blue-600">
                            @if($booking->status === 'pending')
                                Awaiting Payment
                            @elseif($booking->status === 'confirmed')
                                Paid ✓
                            @else
                                {{ ucfirst($booking->status) }}
                            @endif
                        </p>
                    </div>

                    @if($booking->status === 'pending')
                        <button class="btn-primary w-full mt-4">Process Payment</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
