@extends('layouts.app')

@section('title', 'Ubah Airport Transfer - ' . $booking->booking_code)

@section('content')
    <!-- Page Header -->
    <div class="page-header mb-8 flex justify-between items-start">
        <div>
            <h1 class="page-title">Ubah Pemesanan Airport Transfer</h1>
            <p class="page-subtitle">Kode Booking: <span class="font-semibold text-blue-600">{{ $booking->booking_code }}</span></p>
        </div>
        <a href="{{ route('bookings.airport-transfer.show', $booking) }}" class="btn-secondary">
            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
            <p class="text-red-700 font-semibold mb-2">Terjadi kesalahan:</p>
            <ul class="list-disc list-inside text-red-600 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

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
        <!-- Form -->
        <div class="lg:col-span-2">
            <form action="{{ route('bookings.airport-transfer.update', $booking) }}" method="POST" class="card">
                @csrf
                @method('PUT')

                <!-- Passenger Information -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Informasi Penumpang
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Penumpang <span class="text-red-500">*</span></label>
                            <input type="text" name="passenger_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('passenger_name') border-red-500 @enderror" value="{{ old('passenger_name', $booking->passenger_name) }}" required>
                            @error('passenger_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon <span class="text-red-500">*</span></label>
                            <input type="tel" name="passenger_phone" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('passenger_phone') border-red-500 @enderror" value="{{ old('passenger_phone', $booking->passenger_phone) }}" required>
                            @error('passenger_phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Location Information -->
                <div class="mb-6 pb-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Lokasi & Waktu
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi Penjemputan <span class="text-red-500">*</span></label>
                            <input type="text" name="pickup_location" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('pickup_location') border-red-500 @enderror" placeholder="Nama tempat atau alamat" value="{{ old('pickup_location', $booking->pickup_location) }}" required>
                            @error('pickup_location')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi Pengantaran <span class="text-red-500">*</span></label>
                            <input type="text" name="dropoff_location" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('dropoff_location') border-red-500 @enderror" placeholder="Nama tempat atau alamat" value="{{ old('dropoff_location', $booking->dropoff_location) }}" required>
                            @error('dropoff_location')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Perjalanan <span class="text-red-500">*</span></label>
                            <input type="date" name="scheduled_date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('scheduled_date') border-red-500 @enderror" value="{{ old('scheduled_date', \Carbon\Carbon::parse($booking->scheduled_date)->format('Y-m-d')) }}" required>
                            @error('scheduled_date')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Waktu Keberangkatan <span class="text-red-500">*</span></label>
                            <input type="time" name="departure_time" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('departure_time') border-red-500 @enderror" value="{{ old('departure_time', $booking->departure_time ? \Carbon\Carbon::parse($booking->departure_time)->format('H:i') : '') }}" required>
                            @error('departure_time')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Penumpang <span class="text-red-500">*</span></label>
                            <select name="number_of_passengers" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('number_of_passengers') border-red-500 @enderror" required>
                                <option value="">Pilih jumlah penumpang</option>
                                @for($i = 1; $i <= 8; $i++)
                                    <option value="{{ $i }}" {{ old('number_of_passengers', $booking->number_of_passengers) == $i ? 'selected' : '' }}>{{ $i }} penumpang</option>
                                @endfor
                            </select>
                            @error('number_of_passengers')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Special Requests -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Permintaan Khusus
                    </h3>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Permintaan Khusus</label>
                        <textarea name="special_requests" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('special_requests') border-red-500 @enderror" rows="3" placeholder="Contoh: Suara musik yang disukai, AC dingin, dll...">{{ old('special_requests', $booking->special_requests) }}</textarea>
                        @error('special_requests')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex gap-4">
                    <button type="submit" class="btn-primary flex-1">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('bookings.airport-transfer.show', $booking) }}" class="btn-secondary flex-1 text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-6">
            <!-- Current Status -->
            <div class="card">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Status Saat Ini
                </h3>
                <div class="text-center py-4">
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
            </div>

            <!-- Tips -->
            <div class="card">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                    Tips
                </h3>
                <div class="space-y-4 text-sm text-gray-600">
                    <div class="flex gap-3">
                        <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p>Perubahan akan menunggu konfirmasi ulang dari admin jika status sudah dikonfirmasi.</p>
                    </div>
                    <div class="flex gap-3">
                        <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p>Pastikan waktu keberangkatan cukup untuk menjangkau lokasi pengantaran.</p>
                    </div>
                    <div class="flex gap-3">
                        <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p>Jika mengubah tanggal atau waktu, koordinasi ulang dengan driver mungkin diperlukan.</p>
                    </div>
                </div>

                <div class="mt-6 p-4 bg-amber-50 rounded-lg border border-amber-200">
                    <p class="text-xs text-amber-700">
                        <span class="font-semibold">Perhatian:</span> Anda dapat mengubah pemesanan selama status masih <strong>Menunggu</strong>. Setelah dikonfirmasi, perubahan mungkin tidak dapat dilakukan.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
