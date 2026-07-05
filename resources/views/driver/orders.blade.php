@extends('layouts.app')

@section('title', 'Order Aktif')

@section('content')
<style>
    .dark .bg-white { background-color: var(--trvl-card) !important; }
    .dark .bg-gray-100 { background-color: var(--trvl-gray-100) !important; }
    .dark .bg-gray-50 { background-color: var(--trvl-gray-100) !important; }
    .dark .bg-gray-200 { background-color: var(--trvl-border) !important; }
    .dark .border-gray-200 { border-color: var(--trvl-border) !important; }
    .dark .border-gray-300 { border-color: var(--trvl-border) !important; }
    .dark .text-gray-500 { color: var(--trvl-gray-600) !important; }
    .dark .text-gray-700 { color: var(--trvl-text) !important; }
    .dark .text-gray-800 { color: var(--trvl-text) !important; }
    .dark .text-gray-900 { color: var(--trvl-text) !important; }
    .dark .text-gray-400 { color: var(--trvl-gray-600) !important; }
    .dark .shadow-sm { box-shadow: 0 1px 2px rgba(0,0,0,0.2) !important; }
</style>
<div class="min-h-screen bg-gray-100">
    <!-- Page Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Order Aktif</h1>
                    <p class="mt-1 text-sm text-gray-500">Daftar perjalanan yang sedang Anda tangani</p>
                </div>
                <div class="flex items-center space-x-3">
                    @if($armada)
                    <div class="text-right">
                        <p class="text-xs text-gray-500">Armada</p>
                        <p class="text-sm font-semibold text-gray-800">{{ $armada->plate_number }} - {{ $armada->vehicle_type }}</p>
                    </div>
                    @endif
                    <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold text-sm">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Orders List -->
        @forelse($orders as $order)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-5 overflow-hidden">
            <div class="p-6">
                <!-- Header Row -->
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <!-- Type Badge -->
                        @if($order->order_type === 'travel')
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                            <svg class="h-3.5 w-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"/>
                            </svg>
                            Travel
                        </span>
                        @else
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">
                            <svg class="h-3.5 w-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                            </svg>
                            Rental
                        </span>
                        @endif

                        <!-- Booking Code -->
                        <span class="text-sm font-mono text-gray-500 bg-gray-100 px-2 py-1 rounded">
                            #{{ $order->booking_code }}
                        </span>
                    </div>

                    <!-- Status Badge -->
                    @if($order->status === 'confirmed')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                        <span class="h-2 w-2 rounded-full bg-yellow-500 mr-2"></span>
                        Menunggu Berangkat
                    </span>
                    @elseif($order->status === 'departed' || $order->status === 'active')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                        <span class="h-2 w-2 rounded-full bg-green-500 mr-2 animate-pulse"></span>
                        Dalam Perjalanan
                    </span>
                    @endif
                </div>

                <!-- Route Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-5">
                    <!-- Customer -->
                    <div class="flex items-start space-x-3">
                        <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center flex-shrink-0">
                            <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Pelanggan</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $order->user->name ?? '-' }}</p>
                            <p class="text-xs text-gray-500">{{ $order->user->phone ?? '' }}</p>
                        </div>
                    </div>

                    <!-- Route -->
                    <div class="flex items-start space-x-3">
                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Rute</p>
                            <p class="text-sm font-semibold text-gray-900">
                                {{ $order->route->origin_city ?? 'Kota Asal' }} → {{ $order->route->destination_city ?? 'Kota Tujuan' }}
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ $order->route->distance_km ?? 0 }} km
                                @if($order->route->estimated_hours) · {{ $order->route->estimated_hours }} jam @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Details Row -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-5 p-4 bg-gray-50 rounded-lg">
                    <div>
                        <p class="text-xs text-gray-500">Tanggal</p>
                        <p class="text-sm font-medium text-gray-900">
                            @if($order->order_type === 'travel')
                                {{ $order->scheduled_date ? \Carbon\Carbon::parse($order->scheduled_date)->format('d M Y') : '-' }}
                            @else
                                {{ $order->start_date ? \Carbon\Carbon::parse($order->start_date)->format('d M Y') : '-' }}
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Harga</p>
                        <p class="text-sm font-semibold text-gray-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Tipe</p>
                        <p class="text-sm font-medium text-gray-900">{{ ucfirst($order->order_type) }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Status</p>
                        <p class="text-sm font-medium text-gray-900">{{ ucfirst($order->status) }}</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between">
                    <!-- Navigate Button -->
                    @if($order->route)
                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ urlencode($order->route->destination_city ?? '') }}&travelmode=driving"
                       target="_blank"
                       class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                        <svg class="h-4 w-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                        </svg>
                        Buka di Google Maps
                    </a>
                    @else
                    <div></div>
                    @endif

                    <!-- Trip Action Buttons -->
                    <div class="flex items-center space-x-3">
                        @if($order->status === 'confirmed')
                        <form method="POST" action="{{ route('driver.trip.start', ['booking' => $order->id, 'type' => $order->order_type]) }}" style="display: inline;">
                            @csrf
                            <button type="submit"
                                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-semibold transition-colors shadow-sm"
                                    onclick="return confirm('Apakah Anda yakin ingin memulai perjalanan ini?')">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Mulai Perjalanan
                            </button>
                        </form>
                        @endif

                        @if($order->status === 'departed' || $order->status === 'active')
                        <form method="POST" action="{{ route('driver.trip.complete', ['booking' => $order->id, 'type' => $order->order_type]) }}" style="display: inline;">
                            @csrf
                            <button type="submit"
                                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold transition-colors shadow-sm"
                                    onclick="return confirm('Apakah Anda yakin ingin menyelesaikan perjalanan ini?')">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Selesaikan Perjalanan
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
        <!-- Empty State -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
            <div class="flex flex-col items-center">
                <div class="h-20 w-20 rounded-full bg-gray-100 flex items-center justify-center mb-6">
                    <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Tidak Ada Order Aktif</h3>
                <p class="text-sm text-gray-500 max-w-md">
                    Anda tidak memiliki order yang sedang berjalan. Order akan muncul di sini ketika admin menugaskan Anda untuk perjalanan.
                </p>
                <a href="{{ route('driver.dashboard') }}" class="mt-6 inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h3v-6h4v6h3a1 1 0 001-1v-10"/>
                    </svg>
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection
