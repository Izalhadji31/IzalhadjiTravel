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
            Booking Baru
        </a>
    </div>

    <!-- Statistics Grid - Traveloka Style -->
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
                    <p class="text-3xl font-bold text-amber-600 mt-2">{{ $pendingCount ?? 0 }}</p>
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
                    <p class="text-3xl font-bold text-blue-600 mt-2">{{ $confirmedCount ?? 0 }}</p>
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
                    <p class="text-3xl font-bold text-emerald-600 mt-2">{{ $completedCount ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Bar - Traveloka Style -->
    <div class="filter-bar">
        <div class="filter-bar-inner">
            <span class="filter-chip active">Semua</span>
            <span class="filter-chip inactive">Menunggu</span>
            <span class="filter-chip inactive">Dikonfirmasi</span>
            <span class="filter-chip inactive">Selesai</span>
            <span class="filter-chip inactive">Dibatalkan</span>
            <div class="ml-auto flex items-center gap-3">
                <select class="form-select" style="width:auto; min-width:160px;">
                    <option>Urutkan: Terbaru</option>
                    <option>Urutkan: Terlama</option>
                    <option>Urutkan: Harga ↑</option>
                    <option>Urutkan: Harga ↓</option>
                </select>
            </div>
        </div>
    </div>

    <!-- View Toggle: Table / Card Grid -->
    <div class="flex items-center justify-between mb-5">
        <div class="results-count">
            <strong>{{ $bookings->total() }}</strong> pemesanan ditemukan
        </div>
        <div class="flex items-center gap-1 bg-slate-100 rounded-lg p-1">
            <button class="px-3 py-1.5 rounded-md text-sm font-medium bg-white text-slate-900 shadow-sm" id="view-grid" onclick="switchView('grid')">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
            </button>
            <button class="px-3 py-1.5 rounded-md text-sm font-medium text-slate-500" id="view-table" onclick="switchView('table')">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
            </button>
        </div>
    </div>

    <!-- ===== CARD GRID VIEW (Traveloka Style) ===== -->
    <div id="card-grid-view" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5 mb-8">
        @forelse($bookings as $booking)
        <div class="travel-card">
            <div class="travel-card-img" style="background:linear-gradient(135deg,
                @switch($booking->status)
                    @case('completed') #065f46 0%,#10b981 50%,#6ee7b7 100%
                    @case('confirmed') #1e3a8a 0%,#2563eb 50%,#60a5fa 100%
                    @case('cancelled') #991b1b 0%,#dc2626 50%,#f87171 100%
                    @default #92400e 0%,#d97706 50%,#fbbf24 100%
                @endswitch
            );">
                <span style="font-size:4rem; font-weight:700; color:#0064d2;">Bus</span>
                <span class="travel-card-badge
                    @switch($booking->status)
                        @case('pending') bg-amber-500
                        @case('confirmed') bg-blue-500
                        @case('completed') bg-emerald-500
                        @case('cancelled') bg-red-500
                        @default bg-amber-500
                    @endswitch
                text-white">
                    @switch($booking->status)
                        @case('pending') Menunggu
                        @case('confirmed') Dikonfirmasi
                        @case('completed') Selesai
                        @case('cancelled') Dibatalkan
                        @default {{ ucfirst($booking->status) }}
                    @endswitch
                </span>
            </div>
            <div class="travel-card-body">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-bold text-slate-400">{{ $booking->booking_code }}</span>
                    <span class="text-xs text-slate-400">{{ $booking->created_at ? $booking->created_at->format('M d, Y') : ($booking->scheduled_date ? $booking->scheduled_date->format('M d, Y') : '') }}</span>
                </div>
                <h3 class="travel-card-title">{{ $booking->route?->origin_city ?? 'N/A' }} → {{ $booking->route?->destination_city ?? 'N/A' }}</h3>
                <p class="travel-card-subtitle">{{ $booking->user?->name ?? 'N/A' }} · {{ $booking->passenger_count ?? $booking->number_of_seats ?? 1 }} kursi</p>
                <div class="travel-card-meta">
                    <span class="travel-card-meta-item">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $booking->route?->estimated_hours ? $booking->route->estimated_hours . ' jam' : '-' }}
                    </span>
                    <span class="travel-card-meta-item">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                        {{ $booking->route?->distance_km ? number_format($booking->route->distance_km, 0) . ' km' : '-' }}
                    </span>
                    <span class="travel-card-meta-item">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                        {{ $booking->armada?->vehicle_type ?? $booking->assignedArmada?->vehicle_type ?? 'Bus' }}
                    </span>
                </div>
                <div class="flex items-center justify-between mt-3 pt-3 border-t border-slate-100">
                    <p class="travel-card-price">Rp {{ number_format($booking->total_price, 0, ',', '.') }} <span class="unit">/org</span></p>
                    <a href="{{ route('bookings.travel.show', $booking) }}" class="text-blue-600 text-sm font-semibold hover:underline">Detail →</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
            </svg>
            <p class="text-gray-500 text-lg">No travel bookings found</p>
        </div>
        @endforelse
    </div>

    <!-- ===== TABLE VIEW ===== -->
    <div id="table-view" class="card overflow-hidden" style="display:none;">
        <h2 class="text-xl font-semibold text-gray-900 mb-6 pb-4 border-b border-gray-200">Travel Bookings List</h2>

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
                    @forelse($bookings as $booking)
                    <tr class="border-b border-gray-100 hover:bg-blue-50 transition-colors">
                        <td class="px-6 py-3 font-semibold text-gray-900">{{ $booking->booking_code }}</td>
                        <td class="px-6 py-3 text-gray-700">{{ $booking->user?->name ?? 'N/A' }}</td>
                        <td class="px-6 py-3 text-gray-700">{{ $booking->route?->origin_city ?? '' }} → {{ $booking->route?->destination_city ?? '' }}</td>
                        <td class="px-6 py-3 text-gray-700">{{ $booking->passenger_count ?? $booking->number_of_seats ?? 1 }}</td>
                        <td class="px-6 py-3 text-gray-700">{{ $booking->created_at ? $booking->created_at->format('M d, Y') : ($booking->scheduled_date ? $booking->scheduled_date->format('M d, Y') : '-') }}</td>
                        <td class="px-6 py-3 font-semibold text-blue-600">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                        <td class="px-6 py-3">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                @if($booking->status === 'completed') bg-green-100 text-green-800
                                @elseif($booking->status === 'confirmed') bg-blue-100 text-blue-800
                                @elseif($booking->status === 'cancelled') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800
                                @endif">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-3">
                            <a href="{{ route('bookings.travel.show', $booking) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center text-gray-500">No travel bookings found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $bookings->links() }}
        </div>
    </div>

    <script>
    function switchView(view) {
        const gridView = document.getElementById('card-grid-view');
        const tableView = document.getElementById('table-view');
        const gridBtn = document.getElementById('view-grid');
        const tableBtn = document.getElementById('view-table');

        if (view === 'grid') {
            gridView.style.display = 'grid';
            tableView.style.display = 'none';
            gridBtn.className = 'px-3 py-1.5 rounded-md text-sm font-medium bg-white text-slate-900 shadow-sm';
            tableBtn.className = 'px-3 py-1.5 rounded-md text-sm font-medium text-slate-500';
        } else {
            gridView.style.display = 'none';
            tableView.style.display = 'block';
            tableBtn.className = 'px-3 py-1.5 rounded-md text-sm font-medium bg-white text-slate-900 shadow-sm';
            gridBtn.className = 'px-3 py-1.5 rounded-md text-sm font-medium text-slate-500';
        }
    }
    </script>
@endsection
