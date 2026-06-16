@extends('layouts.app')

@section('title', 'Rental Bookings')

@section('content')
    <!-- Page Header -->
    <div class="mb-8 flex justify-between items-start">
        <div>
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Rental Bookings</h1>
            <p class="text-gray-600">Manage all rental vehicle bookings</p>
        </div>
        <a href="{{ route('bookings.rental.create') }}" class="btn-primary">
            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            New Booking
        </a>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="card">
            <p class="text-gray-600 text-sm">Total Bookings</p>
            <p class="text-3xl font-bold text-blue-600 mt-2">{{ count($bookings ?? []) }}</p>
            <p class="text-gray-600 text-xs mt-2">All time</p>
        </div>
        <div class="card">
            <p class="text-gray-600 text-sm">Pending</p>
            <p class="text-3xl font-bold text-yellow-600 mt-2">{{ count($bookings->where('status', 'pending') ?? []) }}</p>
            <p class="text-gray-600 text-xs mt-2">Awaiting confirmation</p>
        </div>
        <div class="card">
            <p class="text-gray-600 text-sm">Confirmed</p>
            <p class="text-3xl font-bold text-blue-600 mt-2">{{ count($bookings->where('status', 'confirmed') ?? []) }}</p>
            <p class="text-gray-600 text-xs mt-2">Active rentals</p>
        </div>
        <div class="card">
            <p class="text-gray-600 text-sm">Completed</p>
            <p class="text-3xl font-bold text-green-600 mt-2">{{ count($bookings->where('status', 'completed') ?? []) }}</p>
            <p class="text-gray-600 text-xs mt-2">Finished rentals</p>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8 border border-blue-100">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <input type="text" placeholder="Search booking ID or customer..." 
                       class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600">
            </div>
            <div>
                <select class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
            <div>
                <select class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600">
                    <option value="">All Types</option>
                    <option value="with_driver">With Driver</option>
                    <option value="without_driver">Without Driver</option>
                </select>
            </div>
            <div>
                <button class="btn-primary w-full">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Search
                </button>
            </div>
        </div>
    </div>

    <!-- Rental Bookings Table -->
    <div class="card overflow-hidden">
        <div class="card-header">Rental Bookings List</div>
        
        @if($bookings && $bookings->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Booking Code</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Customer</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Route</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Type</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Start Date</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Price</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                        <tr class="border-b border-gray-100 hover:bg-blue-50 transition-colors">
                            <td class="px-6 py-3 font-semibold text-gray-900">{{ $booking->booking_code ?? '#RB-' . $booking->id }}</td>
                            <td class="px-6 py-3 text-gray-700">{{ $booking->user->name ?? 'N/A' }}</td>
                            <td class="px-6 py-3 text-gray-700">{{ $booking->route->origin_city ?? '' }} → {{ $booking->route->destination_city ?? '' }}</td>
                            <td class="px-6 py-3 text-gray-700">
                                @if($booking->rental_type === 'with_driver')
                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-medium">With Driver</span>
                                @else
                                    <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-xs font-medium">Self Drive</span>
                                @endif
                            </td>
                            <td class="px-6 py-3 text-gray-700">{{ $booking->start_date?->format('M d, Y') ?? '-' }}</td>
                            <td class="px-6 py-3 font-semibold text-blue-600">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                            <td class="px-6 py-3">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    @if($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($booking->status === 'confirmed') bg-blue-100 text-blue-800
                                    @elseif($booking->status === 'completed') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-3">
                                <a href="{{ route('bookings.rental.show', $booking) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($bookings instanceof \Illuminate\Pagination\Paginator)
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $bookings->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                </svg>
                <p class="text-gray-500 text-lg">No rental bookings found</p>
                <p class="text-gray-400 mb-4">Start creating bookings to see them here</p>
                <a href="{{ route('bookings.rental.create') }}" class="btn-primary inline-block">Create First Booking</a>
            </div>
        @endif
    </div>
@endsection
                <div class="flex justify-between">
                    <span class="text-gray-600">Rental Period:</span>
                    <span class="font-medium text-gray-900">May 22-29</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Price/Day:</span>
                    <span class="font-medium text-blue-600">$65.00</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Total:</span>
                    <span class="font-bold text-gray-900">$455.00</span>
                </div>
            </div>

            <div class="flex gap-2">
                <button class="flex-1 px-3 py-2 bg-blue-50 text-blue-600 rounded-lg font-medium hover:bg-blue-100">Confirm</button>
                <button class="flex-1 px-3 py-2 bg-red-50 text-red-600 rounded-lg font-medium hover:bg-red-100">Reject</button>
            </div>
        </div>

        <!-- Booking Card 3 -->
        <div class="card hover:shadow-xl transition-shadow">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h4 class="font-bold text-gray-900">#RB003</h4>
                    <p class="text-sm text-gray-600">Mitsubishi Xpander</p>
                </div>
                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-semibold">Completed</span>
            </div>

            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-lg p-4 mb-4 text-center">
                <svg class="w-12 h-12 text-blue-600 mx-auto mb-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                </svg>
            </div>

            <div class="space-y-2 mb-4 pb-4 border-b border-gray-200 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">Customer:</span>
                    <span class="font-medium text-gray-900">Chris Martinez</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Rental Period:</span>
                    <span class="font-medium text-gray-900">May 10-17</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Price/Day:</span>
                    <span class="font-medium text-blue-600">$55.00</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Total:</span>
                    <span class="font-bold text-gray-900">$385.00</span>
                </div>
            </div>

            <button class="w-full px-3 py-2 bg-gray-100 text-gray-600 rounded-lg font-medium hover:bg-gray-200">Download Invoice</button>
        </div>
    </div>
@endsection
