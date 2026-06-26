@extends('layouts.app')

@section('title', 'Booking Details')

@section('content')
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Booking Details</h1>
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
        <!-- Main Booking Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Booking Info Card -->
            <div class="card">
                <h3 class="card-header">Booking Information</h3>
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-gray-600 text-sm">Booking Date</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $booking->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Travel Date</p>
                            <p class="text-lg font-semibold text-gray-900">{{ \Carbon\Carbon::parse($booking->travel_date)->format('d M Y') }}</p>
                        </div>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Route</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $booking->route->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Distance</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $booking->route->distance_km }} km</p>
                    </div>
                </div>
            </div>

            <!-- Passenger Info Card -->
            <div class="card">
                <h3 class="card-header">Passenger Information</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-gray-600 text-sm">Number of Seats</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $booking->number_of_seats }} @if($booking->number_of_seats == 1) Seat @else Seats @endif</p>
                    </div>
                    @php
                        $passengers = \App\Models\BookingPassenger::where('travel_booking_id', $booking->id)->get();
                    @endphp
                    @if($passengers->count() > 0)
                    <div>
                        <p class="text-gray-600 text-sm mb-2">Passenger List</p>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-3 py-2 text-left font-semibold text-gray-700">#</th>
                                        <th class="px-3 py-2 text-left font-semibold text-gray-700">Name</th>
                                        <th class="px-3 py-2 text-left font-semibold text-gray-700">NIK</th>
                                        <th class="px-3 py-2 text-left font-semibold text-gray-700">Seat</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($passengers as $idx => $p)
                                    <tr>
                                        <td class="px-3 py-2 text-gray-600">{{ $idx + 1 }}</td>
                                        <td class="px-3 py-2 font-medium text-gray-900">{{ $p->name }}</td>
                                        <td class="px-3 py-2 text-gray-600 font-mono">{{ $p->nik }}</td>
                                        <td class="px-3 py-2 text-gray-600">{{ $p->seat_number }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                    <div>
                        <p class="text-gray-600 text-sm">Price per Seat</p>
                        <p class="text-lg font-semibold text-gray-900">Rp {{ number_format($booking->route->travelPrices->first()->price_per_seat, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <!-- Assigned Vehicle -->
            @if($booking->armada)
            <div class="card">
                <h3 class="card-header">Assigned Vehicle</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Vehicle Type</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $booking->armada->vehicle_type }}</p>
                        </div>
                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-bold">{{ ucfirst($booking->armada->status) }}</span>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">License Plate</p>
                        <p class="text-lg font-semibold text-gray-900 font-mono">{{ $booking->armada->plate_number }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Driver</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $booking->armada->driver_name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Driver Contact</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $booking->armada->driver_phone }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Actions -->
            <div class="space-y-3">
                @if($booking->status === 'pending')
                    <form action="{{ route('bookings.travel.destroy', $booking) }}" method="POST" onsubmit="return confirm('Cancel this booking?')">
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
                <a href="{{ route('bookings.travel') }}" class="btn-secondary w-full text-center">Back to Bookings</a>
            </div>
        </div>

        <!-- Pricing Summary -->
        <div>
            <div class="card sticky top-20">
                <h3 class="card-header">Price Summary</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-2 border-b border-gray-200">
                        <span class="text-gray-600">Price per Seat</span>
                        <span class="font-semibold">Rp {{ number_format($booking->route->travelPrices->first()->price_per_seat, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-200">
                        <span class="text-gray-600">Number of Seats</span>
                        <span class="font-semibold">{{ $booking->number_of_seats }}</span>
                    </div>
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
