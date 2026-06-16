@extends('layouts.app')

@section('title', 'Airport Transfer Bookings')

@section('content')
    <!-- Page Header -->
    <div class="page-header mb-8 flex justify-between items-start">
        <div>
            <h1 class="page-title">Airport Transfer Bookings</h1>
            <p class="page-subtitle">Kelola dan lacak semua pemesanan airport transfer Anda.</p>
        </div>
        <a href="{{ route('bookings.airport-transfer.create') }}" class="btn-primary">
            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Pesan Sekarang
        </a>
    </div>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700">
            {{ session('error') }}
        </div>
    @endif

    <!-- Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Pemesanan</p>
                    <p class="text-3xl font-bold text-blue-600 mt-2">{{ $bookings->total() }}</p>
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
                    <p class="text-gray-600 text-sm font-medium">Menunggu</p>
                    <p class="text-3xl font-bold text-amber-600 mt-2">{{ $bookings->where('status', 'pending')->count() }}</p>
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
                    <p class="text-gray-600 text-sm font-medium">Dikonfirmasi</p>
                    <p class="text-3xl font-bold text-blue-600 mt-2">{{ $bookings->where('status', 'confirmed')->count() }}</p>
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
                    <p class="text-gray-600 text-sm font-medium">Selesai</p>
                    <p class="text-3xl font-bold text-emerald-600 mt-2">{{ $bookings->where('status', 'completed')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Bookings Table -->
    <div class="card">
        @if($bookings->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="text-left py-3 px-4 font-semibold text-sm text-gray-700">Booking Code</th>
                            <th class="text-left py-3 px-4 font-semibold text-sm text-gray-700">Penumpang</th>
                            <th class="text-left py-3 px-4 font-semibold text-sm text-gray-700">Lokasi</th>
                            <th class="text-left py-3 px-4 font-semibold text-sm text-gray-700">Tanggal</th>
                            <th class="text-left py-3 px-4 font-semibold text-sm text-gray-700">Tipe</th>
                            <th class="text-left py-3 px-4 font-semibold text-sm text-gray-700">Harga</th>
                            <th class="text-left py-3 px-4 font-semibold text-sm text-gray-700">Status</th>
                            <th class="text-left py-3 px-4 font-semibold text-sm text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="py-3 px-4">
                                    <span class="font-medium text-gray-900">{{ $booking->booking_code }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="text-sm text-gray-600">{{ $booking->passenger_name }}</div>
                                    <div class="text-xs text-gray-500">{{ $booking->passenger_phone }}</div>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="text-sm text-gray-600">{{ $booking->pickup_location }}</div>
                                    <div class="text-xs text-gray-500">→ {{ $booking->dropoff_location }}</div>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="text-sm text-gray-600">{{ $booking->scheduled_date->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $booking->scheduled_date->format('H:i') }}</div>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="text-sm text-gray-600">
                                        @if($booking->transfer_type === 'one_way')
                                            Satu Arah
                                        @else
                                            Pulang Pergi
                                        @endif
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="font-semibold text-gray-900">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                                        @if($booking->status === 'pending')
                                            bg-amber-100 text-amber-800
                                        @elseif($booking->status === 'confirmed')
                                            bg-blue-100 text-blue-800
                                        @elseif($booking->status === 'completed')
                                            bg-green-100 text-green-800
                                        @elseif($booking->status === 'cancelled')
                                            bg-red-100 text-red-800
                                        @else
                                            bg-gray-100 text-gray-800
                                        @endif
                                    ">
                                        @if($booking->status === 'pending') Menunggu
                                        @elseif($booking->status === 'confirmed') Dikonfirmasi
                                        @elseif($booking->status === 'in_progress') Sedang Berjalan
                                        @elseif($booking->status === 'completed') Selesai
                                        @elseif($booking->status === 'cancelled') Dibatalkan
                                        @endif
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="flex gap-2">
                                        <a href="{{ route('bookings.airport-transfer.show', $booking) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                            Lihat
                                        </a>
                                        @if($booking->isPending())
                                            <a href="{{ route('bookings.airport-transfer.edit', $booking) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                Ubah
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $bookings->links() }}
            </div>
        @else
            <div class="py-12 text-center">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-gray-500 text-lg font-medium mb-4">Belum ada pemesanan</p>
                <p class="text-gray-400 mb-6">Mulai pesan airport transfer sekarang dan nikmati perjalanan yang nyaman!</p>
                <a href="{{ route('bookings.airport-transfer.create') }}" class="btn-primary inline-block">
                    Pesan Airport Transfer
                </a>
            </div>
        @endif
    </div>
@endsection
