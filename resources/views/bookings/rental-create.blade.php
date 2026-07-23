@extends('layouts.app')

@section('title', 'Sewa Rental Mobil')

@section('content')
    <!-- Custom Styles for Rental Form -->
    <style>
        .btn-traveloka-primary {
            background-color: #0064d2;
            color: #ffffff;
            transition: all 0.2s ease-in-out;
        }
        .btn-traveloka-primary:hover {
            background-color: #0051a8;
        }
        .radio-card {
            border: 2px solid #e5e7eb;
            transition: all 0.2s ease;
        }
        .radio-card:hover {
            border-color: #93c5fd;
            background-color: #f9fafb;
        }
        .radio-card.selected {
            border-color: #0064d2;
            background-color: #f2f7fe;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }
        .area-card {
            border: 2px solid #e5e7eb;
            border-radius: 1rem;
            padding: 1.25rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .area-card:hover {
            border-color: #93c5fd;
            background-color: #f0f7ff;
        }
        .area-card.selected {
            border-color: #0064d2;
            background-color: #ebf4ff;
            box-shadow: 0 4px 6px -1px rgba(0, 100, 210, 0.1);
        }
        .area-card .icon-wrap {
            width: 2.5rem; height: 2.5rem;
            border-radius: 0.75rem;
            display: flex; align-items: center; justify-content: center;
            transition: background 0.2s;
        }
        .area-card.selected .icon-wrap {
            background-color: #dbeafe !important;
            color: #0064d2 !important;
        }
    </style>

    <div class="mb-6">
        <!-- Back Button -->
        <a href="{{ route('bookings.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Pemesanan
        </a>
        <div class="flex items-center gap-3">
            <div class="p-2.5 bg-blue-100 text-blue-600 rounded-xl">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 leading-tight">Sewa Rental Mobil</h1>
                @php $selectedVehicle = request('vehicle'); @endphp
                @if($selectedVehicle)
                    <p class="text-gray-500 text-sm">Kendaraan dipilih: <span class="font-semibold text-blue-600">{{ $selectedVehicle }}</span></p>
                @else
                    <p class="text-gray-500 text-sm">Pilih jenis sewa dengan armada terbaik kami</p>
                @endif
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg shadow-sm">
            <p class="text-red-700 font-bold mb-1 text-sm">Harap perbaiki kesalahan berikut:</p>
            <ul class="text-red-600 text-xs space-y-1 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('bookings.rental.store') }}" method="POST" id="rentalBookingForm" class="space-y-6">
        @csrf
        @if($selectedVehicle)
            <input type="hidden" name="vehicle_name" value="{{ $selectedVehicle }}">
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

            <!-- LEFT COLUMN: Input Fields -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Section 1: Area & Dates -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-5">
                    <div class="flex items-center gap-2 pb-3 border-b border-gray-100">
                        <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-bold">1</span>
                        <h2 class="text-lg font-bold text-gray-900">Wilayah & Tanggal Rental</h2>
                    </div>

                    <!-- Area Type: Dalam Kota / Luar Kota -->
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Pilih Wilayah Sewa</label>
                        <input type="hidden" id="area_type" name="area_type" value="{{ old('area_type', 'dalam_kota') }}">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Dalam Kota Ende -->
                            <div id="card_dalam_kota" class="area-card {{ old('area_type', 'dalam_kota') == 'dalam_kota' ? 'selected' : '' }}" onclick="selectArea('dalam_kota')">
                                <div class="flex items-start gap-3">
                                    <div class="icon-wrap bg-gray-100 text-gray-600 {{ old('area_type', 'dalam_kota') == 'dalam_kota' ? 'bg-blue-100 text-blue-600' : '' }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-900 text-sm">Dalam Kota Ende</h3>
                                        <p class="text-xs text-gray-500 mt-0.5">Perjalanan di dalam wilayah Kota Ende</p>
                                        <p class="text-xs font-semibold text-blue-600 mt-1">Harga tetap · Tanpa biaya tambahan</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Luar Kota Ende -->
                            <div id="card_luar_kota" class="area-card {{ old('area_type') == 'luar_kota' ? 'selected' : '' }}" onclick="selectArea('luar_kota')">
                                <div class="flex items-start gap-3">
                                    <div class="icon-wrap bg-gray-100 text-gray-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-900 text-sm">Luar Kota Ende</h3>
                                        <p class="text-xs text-gray-500 mt-0.5">Perjalanan ke luar wilayah Kota Ende</p>
                                        <p class="text-xs font-semibold text-orange-500 mt-1">+ Biaya per kabupaten yang dilalui</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Destination (only shown for luar_kota) -->
                    <div id="destinationContainer" class="{{ old('area_type') == 'luar_kota' ? '' : 'hidden' }}">
                        <label for="destination" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tujuan Perjalanan</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400 pointer-events-none">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                </svg>
                            </span>
                            <input type="text" name="destination" id="destination"
                                   value="{{ old('destination') }}"
                                   placeholder="Contoh: Maumere, Ruteng, Bajawa..."
                                   class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-800 font-medium transition-all">
                        </div>
                    </div>

                    <!-- Regency Count (luar_kota) -->
                    <div id="regencyAreaContainer" class="{{ old('area_type') == 'luar_kota' ? '' : 'hidden' }} p-4 bg-amber-50 rounded-xl border border-amber-200">
                        <div class="flex justify-between items-start gap-4">
                            <div>
                                <label for="regency_count" class="text-sm font-bold text-gray-800 block">Jumlah Kabupaten yang Dilalui</label>
                                <span class="text-xs text-gray-500">Biaya tambahan dihitung per kabupaten yang dilewati</span>
                            </div>
                            <div class="flex items-center border border-amber-300 rounded-lg overflow-hidden bg-white">
                                <button type="button" class="px-3 py-1 bg-amber-50 hover:bg-amber-100 text-gray-700 font-bold" onclick="adjustRegency(-1)">&minus;</button>
                                <input type="number" name="regency_count" id="regency_count" min="1" max="15"
                                       value="{{ old('regency_count', 1) }}"
                                       class="w-12 text-center py-1 font-bold text-gray-800 border-none focus:outline-none" readonly>
                                <button type="button" class="px-3 py-1 bg-amber-50 hover:bg-amber-100 text-gray-700 font-bold" onclick="adjustRegency(1)">&plus;</button>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Start Date -->
                        <div>
                            <label for="start_date" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tanggal Mulai Rental</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400 pointer-events-none">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </span>
                                <input type="date" name="start_date" id="start_date"
                                       value="{{ old('start_date') }}" required
                                       min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                       class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-800 font-medium transition-all">
                            </div>
                        </div>

                        <!-- End Date -->
                        <div>
                            <label for="end_date" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tanggal Selesai Rental (Opsional)</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400 pointer-events-none">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </span>
                                <input type="date" name="end_date" id="end_date"
                                       value="{{ old('end_date') }}"
                                       class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-800 font-medium transition-all">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Rental Type (Lepas Kunci / Dengan Sopir) -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-5">
                    <div class="flex items-center gap-2 pb-3 border-b border-gray-100">
                        <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-bold">2</span>
                        <h2 class="text-lg font-bold text-gray-900">Pilih Tipe Rental & Driver</h2>
                    </div>

                    <!-- Radio Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Tipe: Lepas Kunci -->
                        <div id="card_without_driver" class="radio-card rounded-2xl p-5 cursor-pointer relative" onclick="selectRentalType('without_driver')">
                            <div class="flex items-start gap-4">
                                <div class="p-3 bg-gray-100 text-gray-700 rounded-xl icon-box transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                    </svg>
                                </div>
                                <div class="space-y-1">
                                    <h3 class="font-bold text-gray-900 text-base">Lepas Kunci</h3>
                                    <p class="text-xs text-gray-500 leading-relaxed">Tanpa sopir. Anda mengemudikan kendaraan sendiri dengan bebas.</p>
                                </div>
                            </div>
                            <input type="radio" name="rental_type" id="radio_without_driver" value="without_driver" class="hidden" required @checked(old('rental_type', 'without_driver') == 'without_driver')>
                        </div>

                        <!-- Tipe: Dengan Sopir -->
                        <div id="card_with_driver" class="radio-card rounded-2xl p-5 cursor-pointer relative" onclick="selectRentalType('with_driver')">
                            <div class="flex items-start gap-4">
                                <div class="p-3 bg-gray-100 text-gray-700 rounded-xl icon-box transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div class="space-y-1">
                                    <h3 class="font-bold text-gray-900 text-base">Dengan Sopir</h3>
                                    <p class="text-xs text-gray-500 leading-relaxed">Santai dan nikmati perjalanan bersama sopir profesional kami.</p>
                                </div>
                            </div>
                            <input type="radio" name="rental_type" id="radio_with_driver" value="with_driver" class="hidden" required @checked(old('rental_type') == 'with_driver')>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Catatan Tambahan -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <div class="flex items-center gap-2 pb-3 border-b border-gray-100 mb-4">
                        <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-bold">3</span>
                        <h2 class="text-lg font-bold text-gray-900">Informasi Tambahan</h2>
                    </div>
                    <div>
                        <label for="pickup_location" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Lokasi Penjemputan</label>
                        <input type="text" name="pickup_location" id="pickup_location"
                               value="{{ old('pickup_location') }}"
                               placeholder="Contoh: Hotel Flores Mandiri, Jl. Ahmad Yani No. 5..."
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-800 font-medium transition-all">
                    </div>
                    <div class="mt-4">
                        <label for="notes" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Catatan (Opsional)</label>
                        <textarea name="notes" id="notes" rows="3"
                                  placeholder="Permintaan khusus, kebutuhan tambahan, dsb..."
                                  class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-800 font-medium transition-all resize-none">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN: Pricing Summary Card -->
            <div class="space-y-6 lg:sticky lg:top-20">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-md overflow-hidden">
                    <div class="bg-blue-600 text-white p-5">
                        <h3 class="font-extrabold text-lg">Ringkasan Rental</h3>
                        <p class="text-blue-100 text-xs mt-0.5">Detail sewa kendaraan Anda</p>
                    </div>

                    <div class="p-6 space-y-5">
                        @if($selectedVehicle)
                        <!-- Vehicle Info -->
                        <div class="flex items-center gap-3 p-3 bg-blue-50 rounded-xl border border-blue-100">
                            <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                                </svg>
                            </div>
                            <div>
                                <span class="text-xs text-blue-500 font-semibold block">Kendaraan Dipilih</span>
                                <span class="text-sm font-bold text-gray-800">{{ $selectedVehicle }}</span>
                            </div>
                        </div>
                        @endif

                        <!-- Route Details Summary -->
                        <div class="space-y-3 pb-4 border-b border-gray-100">
                            <div>
                                <span class="text-xs font-bold text-gray-400 uppercase">Wilayah Rental</span>
                                <div id="summaryArea" class="text-base font-bold text-gray-800 mt-0.5">Dalam Kota Ende</div>
                                <div id="summaryDestination" class="text-sm text-gray-500 mt-0.5 hidden"></div>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-500">Tipe Pengemudi</span>
                                <span id="summaryDriverType" class="font-semibold text-gray-700">Lepas Kunci</span>
                            </div>
                        </div>

                        <!-- Price Breakdown -->
                        <div class="space-y-3 pb-4 border-b border-gray-100">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-500">Biaya Sewa Dasar</span>
                                <span id="summaryBasePrice" class="font-bold text-gray-800">Rp 0</span>
                            </div>
                            <div id="summaryRegencyRow" class="flex justify-between items-center text-sm hidden">
                                <span class="text-gray-500">Biaya Luar Kota (<span id="summaryRegencyText">1 kab.</span>)</span>
                                <span id="summaryRegencyFee" class="font-bold text-orange-600">+Rp 0</span>
                            </div>
                        </div>

                        <!-- Grand Total -->
                        <div class="pt-2 flex justify-between items-end">
                            <div>
                                <span class="text-xs font-bold text-gray-400 uppercase block">Total Estimasi</span>
                                <span id="summaryTotalPrice" class="text-2xl font-black text-orange-500">Hubungi Admin</span>
                            </div>
                            <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-md">Bebas Biaya Admin</span>
                        </div>

                        <!-- Info Alert -->
                        <div class="bg-blue-50 border border-blue-100 rounded-xl p-3.5 flex gap-2">
                            <svg class="w-5 h-5 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-xs text-blue-800 leading-normal">
                                Harga final akan dikonfirmasi oleh Admin ASR GO setelah pemesanan diterima. Pembayaran dilakukan setelah konfirmasi.
                            </p>
                        </div>

                        <!-- Submit button -->
                        <button type="submit" class="w-full py-3.5 btn-traveloka-primary rounded-xl font-bold text-center text-base shadow-lg shadow-blue-200 transition-all transform hover:-translate-y-0.5">
                            Pesan Sekarang
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const areaInput = document.getElementById('area_type');
    const startInput = document.getElementById('start_date');
    const endInput = document.getElementById('end_date');
    const regencyInput = document.getElementById('regency_count');
    const destinationInput = document.getElementById('destination');

    // Summary elements
    const summaryArea = document.getElementById('summaryArea');
    const summaryDestination = document.getElementById('summaryDestination');
    const summaryDriverType = document.getElementById('summaryDriverType');
    const summaryTotalPrice = document.getElementById('summaryTotalPrice');
    const summaryRegencyRow = document.getElementById('summaryRegencyRow');
    const summaryRegencyText = document.getElementById('summaryRegencyText');
    const summaryRegencyFee = document.getElementById('summaryRegencyFee');

    // Flat rates
    const BASE_PRICE_DALAM = 300000;  // per day, within Ende
    const REGENCY_FEE = 150000;       // per regency outside Ende

    function formatIDR(num) {
        return 'Rp ' + Number(num).toLocaleString('id-ID');
    }

    // Area selection
    window.selectArea = function(type) {
        areaInput.value = type;

        const cardDalam = document.getElementById('card_dalam_kota');
        const cardLuar = document.getElementById('card_luar_kota');
        const destContainer = document.getElementById('destinationContainer');
        const regencyAreaContainer = document.getElementById('regencyAreaContainer');

        if (type === 'luar_kota') {
            cardLuar.classList.add('selected');
            cardLuar.querySelector('.icon-wrap').classList.add('bg-blue-100', 'text-blue-600');
            cardDalam.classList.remove('selected');
            cardDalam.querySelector('.icon-wrap').classList.remove('bg-blue-100', 'text-blue-600');
            destContainer.classList.remove('hidden');
            regencyAreaContainer.classList.remove('hidden');
            summaryArea.textContent = 'Luar Kota Ende';
            summaryRegencyRow.classList.remove('hidden');
        } else {
            cardDalam.classList.add('selected');
            cardDalam.querySelector('.icon-wrap').classList.add('bg-blue-100', 'text-blue-600');
            cardLuar.classList.remove('selected');
            cardLuar.querySelector('.icon-wrap').classList.remove('bg-blue-100', 'text-blue-600');
            destContainer.classList.add('hidden');
            regencyAreaContainer.classList.add('hidden');
            summaryArea.textContent = 'Dalam Kota Ende';
            summaryDestination.classList.add('hidden');
            summaryRegencyRow.classList.add('hidden');
        }
        updateSummary();
    };

    // Listen to destination changes
    if (destinationInput) {
        destinationInput.addEventListener('input', function() {
            if (destinationInput.value.trim()) {
                summaryDestination.textContent = '→ ' + destinationInput.value.trim();
                summaryDestination.classList.remove('hidden');
            } else {
                summaryDestination.classList.add('hidden');
            }
            updateSummary();
        });
    }

    // Rental type selection
    window.selectRentalType = function(type) {
        const withoutDriverCard = document.getElementById('card_without_driver');
        const withDriverCard = document.getElementById('card_with_driver');
        const withoutRadio = document.getElementById('radio_without_driver');
        const withRadio = document.getElementById('radio_with_driver');

        if (type === 'with_driver') {
            withDriverCard.classList.add('selected');
            withDriverCard.querySelector('.icon-box').classList.add('bg-blue-100', 'text-blue-600');
            withoutDriverCard.classList.remove('selected');
            withoutDriverCard.querySelector('.icon-box').classList.remove('bg-blue-100', 'text-blue-600');
            withRadio.checked = true;
            withoutRadio.checked = false;
            summaryDriverType.textContent = 'Dengan Sopir';
        } else {
            withoutDriverCard.classList.add('selected');
            withoutDriverCard.querySelector('.icon-box').classList.add('bg-blue-100', 'text-blue-600');
            withDriverCard.classList.remove('selected');
            withDriverCard.querySelector('.icon-box').classList.remove('bg-blue-100', 'text-blue-600');
            withoutRadio.checked = true;
            withRadio.checked = false;
            summaryDriverType.textContent = 'Lepas Kunci';
        }
        updateSummary();
    };

    // Regency count
    window.adjustRegency = function(change) {
        let val = parseInt(regencyInput.value) || 1;
        val += change;
        if (val < 1) val = 1;
        if (val > 15) val = 15;
        regencyInput.value = val;
        updateSummary();
    };

    // Update summary prices
    function updateSummary() {
        const area = areaInput.value;
        const regency = parseInt(regencyInput.value) || 1;

        if (area === 'luar_kota') {
            const regencyTotal = regency * REGENCY_FEE;
            summaryRegencyText.textContent = regency + ' kab.';
            summaryRegencyFee.textContent = '+' + formatIDR(regencyTotal);
            summaryTotalPrice.textContent = 'Hubungi Admin';
        } else {
            summaryTotalPrice.textContent = 'Hubungi Admin';
        }
    }

    // Date validation
    const tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    const tomorrowStr = tomorrow.toISOString().split('T')[0];
    startInput.min = tomorrowStr;
    startInput.addEventListener('change', function() {
        endInput.min = startInput.value;
        if (endInput.value && endInput.value < startInput.value) {
            endInput.value = '';
        }
    });

    // Initialize with old values
    const currentArea = areaInput.value || 'dalam_kota';
    selectArea(currentArea);

    const currentRentalType = "{{ old('rental_type', 'without_driver') }}";
    selectRentalType(currentRentalType);

    // Restore destination in summary
    if (destinationInput && destinationInput.value.trim()) {
        summaryDestination.textContent = '→ ' + destinationInput.value.trim();
        summaryDestination.classList.remove('hidden');
    }
});
</script>
@endpush
