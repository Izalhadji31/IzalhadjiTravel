@extends('layouts.app')

@section('title', 'Rental Booking Details')

@section('content')
    <div class="mb-8">
        <!-- Back Button -->
        <a href="{{ url()->previous() }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
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
                            <p class="text-gray-600 text-sm">Start Date</p>
                            <p class="text-lg font-semibold">{{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">End Date</p>
                            <p class="text-lg font-semibold">{{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}</p>
                        </div>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Route</p>
                        <p class="text-lg font-semibold">{{ $booking->route->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Driver Option</p>
                        <p class="text-lg font-semibold">
                            @if($booking->with_driver)
                                ✓ With Driver
                            @else
                                ✗ Without Driver (Self Drive)
                            @endif
                        </p>
                    </div>
                </div>
            </div>

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
                @if($booking->status === 'completed')
                    @php
                        $hasReviewed = \App\Models\Review::where('booking_id', $booking->id)->where('user_id', auth()->id())->exists();
                    @endphp
                    @if(!$hasReviewed)
                        <a href="{{ route('bookings.review.create', $booking) }}" class="btn-primary w-full text-center block">Write a Review</a>
                    @endif
                    <a href="{{ route('bookings.refund.create', $booking) }}" class="bg-red-600 text-white w-full text-center block py-3 px-6 rounded-lg font-semibold hover:bg-red-700 transition-colors">Request Refund</a>
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
                        <span class="font-semibold">Rp {{ number_format($booking->route->rentalPrices->first()?->price_without_driver ?? $booking->total_price, 0, ',', '.') }}</span>
                    </div>

                    @if($booking->with_driver)
                    <div class="flex justify-between items-center py-2 border-b border-gray-200">
                        <span class="text-gray-600">Driver Fee</span>
                        <span class="font-semibold">Rp {{ number_format($booking->total_price - ($booking->route->rentalPrices->first()?->price_without_driver ?? 0), 0, ',', '.') }}</span>
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
