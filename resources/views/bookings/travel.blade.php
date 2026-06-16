@extends('layouts.app')

@section('title', 'Travel Bookings')

@section('content')
    <!-- Page Header -->
    <div class="page-header mb-8 flex justify-between items-start">
        <div>
            <h1 class="page-title">Travel Bookings</h1>
            <p class="page-subtitle">Manage and track all travel bookings.</p>
        </div>
        <a href="{{ route('bookings.travel.create') }}" class="btn-primary">
            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            New Booking
        </a>
    </div>

    <!-- Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Bookings</p>
                    <p class="text-3xl font-bold text-blue-600 mt-2">{{ count($bookings ?? []) }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Pending</p>
                    <p class="text-3xl font-bold text-amber-600 mt-2">{{ count($bookings->where('status', 'pending') ?? []) }}</p>
                </div>
                <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Confirmed</p>
                    <p class="text-3xl font-bold text-blue-600 mt-2">{{ count($bookings->where('status', 'confirmed') ?? []) }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Completed</p>
                    <p class="text-3xl font-bold text-emerald-600 mt-2">{{ count($bookings->where('status', 'completed') ?? []) }}</p>
                </div>
                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="card mb-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <input type="text" placeholder="Search booking ID or customer..." 
                       class="form-input">
            </div>
            <div>
                <select class="form-select">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
            <div>
                <input type="date" class="form-input">
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

    <!-- Bookings Table -->
    <div class="card overflow-hidden">
        <h2 class="text-xl font-semibold text-gray-900 mb-6 pb-4 border-b border-gray-200">Travel Bookings List</h2>
        
        @if($bookings && $bookings->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Booking Code</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Customer</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Route</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Seats</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Date</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Price</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                        <tr class="border-b border-gray-100 hover:bg-blue-50 transition-colors">
                            <td class="px-6 py-3 font-semibold text-gray-900">{{ $booking->booking_code ?? '#TB-' . $booking->id }}</td>
                            <td class="px-6 py-3 text-gray-700">{{ $booking->user->name ?? 'N/A' }}</td>
                            <td class="px-6 py-3 text-gray-700">{{ $booking->route->origin_city ?? '' }} → {{ $booking->route->destination_city ?? '' }}</td>
                            <td class="px-6 py-3 text-gray-700">{{ $booking->number_of_seats ?? 0 }}</td>
                            <td class="px-6 py-3 text-gray-700">{{ $booking->scheduled_date?->format('M d, Y') ?? '-' }}</td>
                            <td class="px-6 py-3 font-semibold text-emerald-600">${{ number_format($booking->total_price, 2, '.', ',') }}</td>
                            <td class="px-6 py-3">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    @if($booking->status === 'pending') bg-amber-100 text-amber-800
                                    @elseif($booking->status === 'confirmed') bg-blue-100 text-blue-800
                                    @elseif($booking->status === 'completed') bg-emerald-100 text-emerald-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-3">
                                <a href="{{ route('bookings.travel.show', $booking) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View</a>
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
                <p class="text-gray-500 text-lg">No travel bookings found</p>
                <p class="text-gray-400 mb-4">Start creating bookings to see them here</p>
                <a href="{{ route('bookings.travel.create') }}" class="btn-primary inline-block">Create First Booking</a>
            </div>
        @endif
    </div>
@endsection
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
                                <a href="{{ route('bookings.travel.show', $booking) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View</a>
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
                <p class="text-gray-500 text-lg">No travel bookings found</p>
                <p class="text-gray-400 mb-4">Start creating bookings to see them here</p>
                <a href="{{ route('bookings.travel.create') }}" class="btn-primary inline-block">Create First Booking</a>
            </div>
        @endif
    </div>
@endsection
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Booking ID</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Customer</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Route</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Date</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Driver</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Amount</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-gray-100 hover:bg-blue-50 transition-colors">
                        <td class="px-6 py-3 font-semibold text-gray-900">#TB001</td>
                        <td class="px-6 py-3 text-gray-700">John Doe</td>
                        <td class="px-6 py-3 text-gray-700">Jakarta → Surabaya</td>
                        <td class="px-6 py-3 text-gray-700">May 15, 2026</td>
                        <td class="px-6 py-3 text-gray-700">Budi Santoso</td>
                        <td class="px-6 py-3 font-semibold text-blue-600">$250.00</td>
                        <td class="px-6 py-3">
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">Completed</span>
                        </td>
                        <td class="px-6 py-3">
                            <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">View</button>
                        </td>
                    </tr>
                    <tr class="border-b border-gray-100 hover:bg-blue-50 transition-colors">
                        <td class="px-6 py-3 font-semibold text-gray-900">#TB002</td>
                        <td class="px-6 py-3 text-gray-700">Jane Smith</td>
                        <td class="px-6 py-3 text-gray-700">Bandung → Jakarta</td>
                        <td class="px-6 py-3 text-gray-700">May 18, 2026</td>
                        <td class="px-6 py-3 text-gray-700">Rudi Hermawan</td>
                        <td class="px-6 py-3 font-semibold text-blue-600">$180.00</td>
                        <td class="px-6 py-3">
                            <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-semibold">In Progress</span>
                        </td>
                        <td class="px-6 py-3">
                            <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">View</button>
                        </td>
                    </tr>
                    <tr class="border-b border-gray-100 hover:bg-blue-50 transition-colors">
                        <td class="px-6 py-3 font-semibold text-gray-900">#TB003</td>
                        <td class="px-6 py-3 text-gray-700">Mike Johnson</td>
                        <td class="px-6 py-3 text-gray-700">Jakarta → Bandung</td>
                        <td class="px-6 py-3 text-gray-700">May 20, 2026</td>
                        <td class="px-6 py-3 text-gray-700">Adi Wijaya</td>
                        <td class="px-6 py-3 font-semibold text-blue-600">$160.00</td>
                        <td class="px-6 py-3">
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-semibold">Pending</span>
                        </td>
                        <td class="px-6 py-3">
                            <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">View</button>
                        </td>
                    </tr>
                    <tr class="border-b border-gray-100 hover:bg-blue-50 transition-colors">
                        <td class="px-6 py-3 font-semibold text-gray-900">#TB004</td>
                        <td class="px-6 py-3 text-gray-700">Sarah Wilson</td>
                        <td class="px-6 py-3 text-gray-700">Yogyakarta → Solo</td>
                        <td class="px-6 py-3 text-gray-700">May 12, 2026</td>
                        <td class="px-6 py-3 text-gray-700">Hendra Saputra</td>
                        <td class="px-6 py-3 font-semibold text-blue-600">$120.00</td>
                        <td class="px-6 py-3">
                            <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-semibold">Cancelled</span>
                        </td>
                        <td class="px-6 py-3">
                            <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">View</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200 flex items-center justify-between">
            <p class="text-sm text-gray-600">Showing 1 to 4 of 856 bookings</p>
            <div class="flex space-x-2">
                <button class="px-3 py-2 border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-50">← Previous</button>
                <button class="px-3 py-2 border-2 border-blue-600 bg-blue-50 text-blue-600 rounded-lg font-medium">1</button>
                <button class="px-3 py-2 border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-50">2</button>
                <button class="px-3 py-2 border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-50">3</button>
                <button class="px-3 py-2 border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-50">Next →</button>
            </div>
        </div>
    </div>
@endsection
