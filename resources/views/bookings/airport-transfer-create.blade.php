@extends('layouts.app')

@section('title', 'Pesan Airport Transfer')

@section('content')
    <!-- Page Header -->
    <div class="page-header mb-8">
        <h1 class="page-title">Pesan Airport Transfer</h1>
        <p class="page-subtitle">Isi form di bawah untuk melakukan pemesanan airport transfer.</p>
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Form -->
        <div class="lg:col-span-2">
            <form action="{{ route('bookings.airport-transfer.store') }}" method="POST" class="card">
                @csrf

                <!-- Passenger Information -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Penumpang</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Penumpang <span class="text-red-500">*</span></label>
                            <input type="text" name="passenger_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('passenger_name') border-red-500 @enderror" value="{{ old('passenger_name') }}" required>
                            @error('passenger_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon <span class="text-red-500">*</span></label>
                            <input type="tel" name="passenger_phone" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('passenger_phone') border-red-500 @enderror" value="{{ old('passenger_phone') }}" required>
                            @error('passenger_phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Location Information -->
                <div class="mb-6 pb-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Lokasi & Waktu</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi Penjemputan <span class="text-red-500">*</span></label>
                            <input type="text" name="pickup_location" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('pickup_location') border-red-500 @enderror" placeholder="Nama tempat atau alamat" value="{{ old('pickup_location') }}" required>
                            @error('pickup_location')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi Pengantaran <span class="text-red-500">*</span></label>
                            <input type="text" name="dropoff_location" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('dropoff_location') border-red-500 @enderror" placeholder="Nama tempat atau alamat" value="{{ old('dropoff_location') }}" required>
                            @error('dropoff_location')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Perjalanan <span class="text-red-500">*</span></label>
                            <input type="date" name="scheduled_date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('scheduled_date') border-red-500 @enderror" value="{{ old('scheduled_date') }}" required>
                            @error('scheduled_date')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Waktu Keberangkatan <span class="text-red-500">*</span></label>
                            <input type="time" name="departure_time" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('departure_time') border-red-500 @enderror" value="{{ old('departure_time') }}" required>
                            @error('departure_time')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Transfer Type -->
                <div class="mb-6 pb-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Tipe Transfer</h3>
                    
                    <div class="space-y-3">
                        <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="transfer_type" value="one_way" class="w-4 h-4 text-blue-600" {{ old('transfer_type') === 'one_way' || !old('transfer_type') ? 'checked' : '' }} onchange="handleTransferTypeChange()">
                            <span class="ml-3">
                                <span class="font-medium text-gray-900">Satu Arah</span>
                                <p class="text-sm text-gray-500">Dari lokasi penjemputan ke lokasi pengantaran</p>
                            </span>
                        </label>
                        <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="transfer_type" value="round_trip" class="w-4 h-4 text-blue-600" {{ old('transfer_type') === 'round_trip' ? 'checked' : '' }} onchange="handleTransferTypeChange()">
                            <span class="ml-3">
                                <span class="font-medium text-gray-900">Pulang Pergi</span>
                                <p class="text-sm text-gray-500">Perjalanan ke lokasi pengantaran dan kembali lagi</p>
                            </span>
                        </label>
                    </div>

                    <div id="return-date-section" class="mt-4 hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pengembalian <span class="text-red-500">*</span></label>
                        <input type="date" name="return_date" id="return_date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('return_date') border-red-500 @enderror" value="{{ old('return_date') }}">
                        @error('return_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Passenger & Vehicle Info -->
                <div class="mb-6 pb-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Tambahan</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Penumpang <span class="text-red-500">*</span></label>
                            <select name="number_of_passengers" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('number_of_passengers') border-red-500 @enderror" required onchange="updatePrice()">
                                <option value="">Pilih jumlah penumpang</option>
                                @for($i = 1; $i <= 8; $i++)
                                    <option value="{{ $i }}" {{ old('number_of_passengers') == $i ? 'selected' : '' }}>{{ $i }} penumpang</option>
                                @endfor
                            </select>
                            @error('number_of_passengers')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Penerbangan</label>
                            <input type="text" name="flight_number" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" placeholder="Contoh: GA-123" value="{{ old('flight_number') }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Maskapai Penerbangan</label>
                            <input type="text" name="airline" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" placeholder="Contoh: Garuda Indonesia" value="{{ old('airline') }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Waktu Kedatangan Penerbangan</label>
                            <input type="datetime-local" name="flight_arrival_time" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" value="{{ old('flight_arrival_time') }}">
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Permintaan Khusus</label>
                        <textarea name="special_requests" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" rows="3" placeholder="Contoh: Suara musik yang disukai, AC dingin, dll..." value="{{ old('special_requests') }}"></textarea>
                    </div>
                </div>

                <!-- Pricing -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Harga</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Harga Dasar <span class="text-red-500">*</span></label>
                            <input type="number" name="base_price" id="base_price" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('base_price') border-red-500 @enderror" value="{{ old('base_price') }}" min="0" step="1000" required onchange="updatePrice()">
                            @error('base_price')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Total Harga <span class="text-red-500">*</span></label>
                            <input type="number" name="total_price" id="total_price" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('total_price') border-red-500 @enderror" value="{{ old('total_price') }}" min="0" step="1000" required readonly>
                            @error('total_price')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex gap-4">
                    <button type="submit" class="btn-primary flex-1">
                        Pesan Sekarang
                    </button>
                    <a href="{{ route('bookings.airport-transfer') }}" class="btn-secondary flex-1 text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>

        <!-- Info Panel -->
        <div>
            <div class="card sticky top-24">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pemesanan</h3>
                
                <div class="space-y-4 text-sm text-gray-600">
                    <div class="flex gap-3">
                        <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <p class="font-medium text-gray-900">Verifikasi Identitas Diperlukan</p>
                            <p class="text-xs mt-1">Pastikan Anda telah melakukan verifikasi identitas di profil Anda</p>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <p class="font-medium text-gray-900">Harga Transparan</p>
                            <p class="text-xs mt-1">Tidak ada biaya tersembunyi. Harga yang ditampilkan adalah harga final</p>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m7 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <p class="font-medium text-gray-900">Konfirmasi Cepat</p>
                            <p class="text-xs mt-1">Pemesanan Anda akan dikonfirmasi dalam waktu singkat oleh admin</p>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        <div>
                            <p class="font-medium text-gray-900">Tracking Real-time</p>
                            <p class="text-xs mt-1">Lacak posisi driver secara real-time setelah pemesanan dikonfirmasi</p>
                        </div>
                    </div>
                </div>

                <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <p class="text-xs text-blue-700">
                        <span class="font-semibold">Tips:</span> Isi semua informasi dengan benar untuk memastikan driver dapat menemukan Anda dengan mudah.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function handleTransferTypeChange() {
            const transferType = document.querySelector('input[name="transfer_type"]:checked').value;
            const returnDateSection = document.getElementById('return-date-section');
            const returnDateInput = document.getElementById('return_date');
            
            if (transferType === 'round_trip') {
                returnDateSection.classList.remove('hidden');
                returnDateInput.required = true;
            } else {
                returnDateSection.classList.add('hidden');
                returnDateInput.required = false;
                returnDateInput.value = '';
            }
        }

        function updatePrice() {
            const basePrice = parseFloat(document.getElementById('base_price').value) || 0;
            const passengers = parseInt(document.querySelector('select[name="number_of_passengers"]').value) || 1;
            const totalPrice = basePrice * passengers;
            document.getElementById('total_price').value = totalPrice;
        }

        // Initialize
        handleTransferTypeChange();
    </script>
@endsection
