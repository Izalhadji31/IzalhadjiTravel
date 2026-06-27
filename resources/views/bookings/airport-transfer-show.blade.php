@extends('layouts.app')

@section('title', 'Detail Airport Transfer - ' . $booking->booking_code)

@section('content')
    <!-- Page Header -->
    <div class="page-header mb-8 flex justify-between items-start">
        <div>
            <h1 class="page-title">Detail Airport Transfer</h1>
            <p class="page-subtitle">Kode Booking: <span class="font-semibold text-blue-600">{{ $booking->booking_code }}</span></p>
        </div>
        <a href="{{ route('bookings.airport-transfer') }}" class="btn-secondary">
            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Status Badge -->
            <div class="card flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <span class="text-sm font-medium text-gray-700">Status:</span>
                    <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold
                        @if($booking->status === 'pending')
                            bg-amber-100 text-amber-800
                        @elseif($booking->status === 'confirmed')
                            bg-blue-100 text-blue-800
                        @elseif($booking->status === 'in_progress')
                            bg-indigo-100 text-indigo-800
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
                        @else {{ ucfirst($booking->status) }}
                        @endif
                    </span>
                </div>
                <span class="text-sm text-gray-500">{{ $booking->scheduled_date->format('l, d F Y') }}</span>
            </div>

            <!-- Passenger Information -->
            <div class="card">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Informasi Penumpang
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Nama Penumpang</p>
                        <p class="font-medium text-gray-900">{{ $booking->passenger_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Nomor Telepon</p>
                        <p class="font-medium text-gray-900">{{ $booking->passenger_phone }}</p>
                    </div>
                </div>
            </div>

            <!-- Location & Time -->
            <div class="card">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Lokasi & Waktu
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Lokasi Penjemputan</p>
                        <p class="font-medium text-gray-900">{{ $booking->pickup_location }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Lokasi Pengantaran</p>
                        <p class="font-medium text-gray-900">{{ $booking->dropoff_location }}</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Tanggal Perjalanan</p>
                        <p class="font-medium text-gray-900">{{ $booking->scheduled_date->format('d F Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Waktu Keberangkatan</p>
                        <p class="font-medium text-gray-900">{{ $booking->departure_time ? \Carbon\Carbon::parse($booking->departure_time)->format('H:i') : '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Tipe Transfer</p>
                        <p class="font-medium text-gray-900">
                            @if($booking->transfer_type === 'one_way')
                                Satu Arah
                            @elseif($booking->transfer_type === 'round_trip')
                                Pulang Pergi
                            @else
                                {{ ucfirst($booking->transfer_type) }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Flight Info -->
            <div class="card">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19h14M5 5l7 7 7-7"></path>
                    </svg>
                    Informasi Penerbangan
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Nomor Penerbangan</p>
                        <p class="font-medium text-gray-900">{{ $booking->flight_number ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Maskapai</p>
                        <p class="font-medium text-gray-900">{{ $booking->airline ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Waktu Kedatangan</p>
                        <p class="font-medium text-gray-900">
                            {{ $booking->flight_arrival_time ? \Carbon\Carbon::parse($booking->flight_arrival_time)->format('d M Y H:i') : '-' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Additional Info -->
            <div class="card">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Informasi Tambahan
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Jumlah Penumpang</p>
                        <p class="font-medium text-gray-900">{{ $booking->number_of_passengers }} penumpang</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Permintaan Khusus</p>
                        <p class="font-medium text-gray-900">{{ $booking->special_requests ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Pricing -->
            <div class="card">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Detail Harga
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="p-4 bg-blue-50 rounded-lg">
                        <p class="text-sm text-gray-500 mb-1">Harga Dasar</p>
                        <p class="text-xl font-bold text-blue-600">Rp {{ number_format($booking->base_price, 0, ',', '.') }}</p>
                    </div>
                    <div class="p-4 bg-amber-50 rounded-lg">
                        <p class="text-sm text-gray-500 mb-1">Diskon</p>
                        <p class="text-xl font-bold text-amber-600">
                            @if($booking->discount)
                                Rp {{ number_format($booking->discount, 0, ',', '.') }}
                            @else
                                Rp 0
                            @endif
                        </p>
                    </div>
                    <div class="p-4 bg-green-50 rounded-lg">
                        <p class="text-sm text-gray-500 mb-1">Total Harga</p>
                        <p class="text-xl font-bold text-green-600">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="card">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi</h3>
                <div class="flex flex-wrap gap-3">
                    @if($booking->status === 'pending')
                        <a href="{{ route('bookings.airport-transfer.edit', $booking) }}" class="btn-primary">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Ubah Pemesanan
                        </a>
                    @endif
                    @if(in_array($booking->status, ['pending', 'confirmed']))
                        <form action="{{ route('bookings.airport-transfer.cancel', $booking) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pemesanan ini?');">
                            @csrf
                            <button type="submit" class="btn-secondary text-red-600 hover:text-red-800 border-red-200 hover:border-red-300">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Batalkan
                            </button>
                        </form>
                    @endif
                    @if($booking->status === 'completed' && $booking->reviews->count() === 0)
                        <a href="{{ route('bookings.airport-transfer.reviews.create', $booking) }}" class="btn-secondary">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                            </svg>
                            Tulis Review
                        </a>
                    @elseif($booking->status === 'completed' && $booking->reviews->count() > 0)
                        <span class="inline-flex items-center gap-1 text-sm text-green-600 font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Review telah dikirim
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Assigned Driver -->
            <div class="card">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Driver & Armada
                </h3>
                @if($booking->assignedArmada || $booking->assignedDriver)
                    @if($booking->assignedDriver)
                        <div class="mb-4">
                            <p class="text-sm text-gray-500 mb-1">Driver</p>
                            <p class="font-medium text-gray-900">{{ $booking->assignedDriver->name ?? 'Tidak diketahui' }}</p>
                            @if(isset($booking->assignedDriver->phone))
                                <p class="text-sm text-gray-600">{{ $booking->assignedDriver->phone }}</p>
                            @endif
                        </div>
                    @endif
                    @if($booking->assignedArmada)
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Armada</p>
                            <p class="font-medium text-gray-900">{{ $booking->assignedArmada->vehicle_type ?? '' }}</p>
                            <p class="text-sm text-gray-600">{{ $booking->assignedArmada->license_plate ?? '' }}</p>
                        </div>
                    @endif
                @else
                    <div class="text-center py-4">
                        <svg class="w-12 h-12 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-sm text-gray-500">Belum ada driver yang ditugaskan</p>
                    </div>
                @endif
            </div>

            <!-- Payment Status -->
            <div class="card">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                    Status Pembayaran
                </h3>
                @if($booking->payments->count() > 0)
                    @php
                        $latestPayment = $booking->payments->latest()->first();
                    @endphp
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Status</span>
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                                @if($latestPayment->status === 'paid' || $latestPayment->status === 'completed')
                                    bg-green-100 text-green-800
                                @elseif($latestPayment->status === 'pending')
                                    bg-amber-100 text-amber-800
                                @elseif($latestPayment->status === 'failed' || $latestPayment->status === 'cancelled')
                                    bg-red-100 text-red-800
                                @else
                                    bg-gray-100 text-gray-800
                                @endif
                            ">
                                @if($latestPayment->status === 'paid') Lunas
                                @elseif($latestPayment->status === 'completed') Selesai
                                @elseif($latestPayment->status === 'pending') Menunggu
                                @elseif($latestPayment->status === 'failed') Gagal
                                @elseif($latestPayment->status === 'cancelled') Dibatalkan
                                @else {{ ucfirst($latestPayment->status) }}
                                @endif
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Jumlah</span>
                            <span class="font-medium text-gray-900">Rp {{ number_format($latestPayment->amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Metode</span>
                            <span class="font-medium text-gray-900">{{ $latestPayment->payment_method ?? '-' }}</span>
                        </div>
                        @if($latestPayment->paid_at)
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Tanggal Bayar</span>
                                <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($latestPayment->paid_at)->format('d M Y H:i') }}</span>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="text-center py-4">
                        <svg class="w-12 h-12 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        <p class="text-sm text-gray-500">Belum ada data pembayaran</p>
                    </div>
                @endif
            </div>

            <!-- Booking Info -->
            <div class="card">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Info Pemesanan
                </h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Dibuat</span>
                        <span class="text-gray-900">{{ $booking->created_at->format('d M Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Diperbarui</span>
                        <span class="text-gray-900">{{ $booking->updated_at->format('d M Y H:i') }}</span>
                    </div>
                    @if($booking->user)
                        <div class="flex justify-between">
                            <span class="text-gray-500">Pemesan</span>
                            <span class="text-gray-900">{{ $booking->user->name ?? '-' }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
