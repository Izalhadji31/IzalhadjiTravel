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
    </style>

    <div class="mb-6">
        <!-- Back Button -->
        <a href="{{ route('bookings.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors mb-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Pemesanan
        </a>
        <div class="flex items-center gap-3">
            <div class="p-2.5 bg-blue-100 text-blue-600 rounded-xl">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 leading-tight">Sewa Rental Mobil</h1>
                <p class="text-gray-500 text-sm">Pilih jenis sewa dengan armada terbaik kami</p>
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
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            <!-- LEFT COLUMN: Input Fields -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Section 1: Route & Dates -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-5">
                    <div class="flex items-center gap-2 pb-3 border-b border-gray-100">
                        <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-bold">1</span>
                        <h2 class="text-lg font-bold text-gray-900">Rute & Tanggal Rental</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Route Selection -->
                        <div class="col-span-1 md:col-span-2">
                            <label for="route_id" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Pilih Rute Sewa</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400 pointer-events-none">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    </svg>
                                </span>
                                <select name="route_id" id="route_id" required
                                        class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-800 font-medium transition-all">
                                    <option value="">-- Pilih Rute Rental --</option>
                                    @foreach ($routes as $route)
                                        <option value="{{ $route->id }}" @selected(old('route_id') == $route->id)>
                                            {{ $route->origin_city }} &rarr; {{ $route->destination_city }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

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

                <!-- Section 2: Rental Type Selection (Lepas Kunci / Dengan Sopir) -->
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

                    <!-- Dynamic Driver Parameter: Regency Count (Only shown for with_driver) -->
                    <div id="regencyCountContainer" class="p-4 bg-gray-50 rounded-xl border border-gray-200 space-y-3" style="display: none;">
                        <div class="flex justify-between items-start gap-4">
                            <div>
                                <label for="regency_count" class="text-sm font-bold text-gray-800 block">Jumlah Wilayah Kabupaten yang Dilalui</label>
                                <span class="text-xs text-gray-500">Biaya pengemudi dihitung berdasarkan jumlah kabupaten yang dilewati</span>
                            </div>
                            <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden bg-white">
                                <button type="button" class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold" onclick="adjustRegency(-1)">&minus;</button>
                                <input type="number" name="regency_count" id="regency_count" min="1" max="10" 
                                       value="{{ old('regency_count', 1) }}"
                                       class="w-12 text-center py-1 font-bold text-gray-800 border-none focus:outline-none" readonly>
                                <button type="button" class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold" onclick="adjustRegency(1)">&plus;</button>
                            </div>
                        </div>
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
                        <!-- Route Details Summary -->
                        <div class="space-y-3 pb-4 border-b border-gray-100">
                            <div>
                                <span class="text-xs font-bold text-gray-400 uppercase">Tujuan Rental</span>
                                <div id="summaryRoute" class="text-base font-bold text-gray-800 mt-0.5">Belum memilih rute</div>
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
                            <div id="summaryDriverFeeRow" class="flex justify-between items-center text-sm" style="display: none;">
                                <span class="text-gray-500">Biaya Sopir (<span id="summaryRegencyText">1 kabupaten</span>)</span>
                                <span id="summaryDriverFee" class="font-bold text-gray-800">Rp 0</span>
                            </div>
                        </div>

                        <!-- Grand Total -->
                        <div class="pt-2 flex justify-between items-end">
                            <div>
                                <span class="text-xs font-bold text-gray-400 uppercase block">Total Bayar</span>
                                <span id="summaryTotalPrice" class="text-2xl font-black text-orange-500">Rp 0</span>
                            </div>
                            <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-md">Bebas Biaya Admin</span>
                        </div>

                        <!-- Info Alert -->
                        <div class="bg-blue-50 border border-blue-100 rounded-xl p-3.5 flex gap-2">
                            <svg class="w-5 h-5 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-xs text-blue-800 leading-normal">
                                Konfirmasi sewa mobil akan diterbitkan segera setelah bukti transfer pembayaran diverifikasi oleh tim Admin ASR GO.
                            </p>
                        </div>

                        <!-- Submit button -->
                        <button type="submit" class="w-full py-3.5 btn-traveloka-primary rounded-xl font-bold text-center text-base shadow-lg shadow-blue-200 transition-all transform hover:-translate-y-0.5">
                            Sewa Mobil Sekarang
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
    const routes = @json($routes);

    // Elements
    const routeSelect = document.getElementById('route_id');
    const startInput = document.getElementById('start_date');
    const regencyInput = document.getElementById('regency_count');
    const regencyCountContainer = document.getElementById('regencyCountContainer');

    // Summary Elements
    const summaryRoute = document.getElementById('summaryRoute');
    const summaryDriverType = document.getElementById('summaryDriverType');
    const summaryBasePrice = document.getElementById('summaryBasePrice');
    const summaryDriverFeeRow = document.getElementById('summaryDriverFeeRow');
    const summaryRegencyText = document.getElementById('summaryRegencyText');
    const summaryDriverFee = document.getElementById('summaryDriverFee');
    const summaryTotalPrice = document.getElementById('summaryTotalPrice');

    // Helper Currency Format
    function formatIDR(num) {
        return 'Rp ' + Number(num).toLocaleString('id-ID', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
    }

    // Set rental type styling and sync hidden radio
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
            
            regencyCountContainer.style.display = 'block';
            summaryDriverType.textContent = 'Dengan Sopir';
            summaryDriverFeeRow.style.display = 'flex';
        } else {
            withoutDriverCard.classList.add('selected');
            withoutDriverCard.querySelector('.icon-box').classList.add('bg-blue-100', 'text-blue-600');
            withDriverCard.classList.remove('selected');
            withDriverCard.querySelector('.icon-box').classList.remove('bg-blue-100', 'text-blue-600');
            
            withoutRadio.checked = true;
            withRadio.checked = false;
            
            regencyCountContainer.style.display = 'none';
            summaryDriverType.textContent = 'Lepas Kunci';
            summaryDriverFeeRow.style.display = 'none';
        }
        updateSummary();
    };

    // Incrementor / Decrementor for regencies
    window.adjustRegency = function(change) {
        let val = parseInt(regencyInput.value) || 1;
        val += change;
        if (val < 1) val = 1;
        if (val > 10) val = 10;
        regencyInput.value = val;
        updateSummary();
    };

    // Calculate and update prices in summary
    function updateSummary() {
        const selectedRouteId = routeSelect.value;
        const routeObj = routes.find(r => r.id === selectedRouteId);
        const isWithDriver = document.getElementById('radio_with_driver').checked;
        const regencyCount = parseInt(regencyInput.value) || 1;

        if (routeObj) {
            summaryRoute.innerHTML = `${routeObj.origin_city} &rarr; ${routeObj.destination_city}`;
            
            let basePrice = 0;
            let driverFeePerRegency = 0;

            if (routeObj.rental_prices && routeObj.rental_prices.length > 0) {
                basePrice = parseFloat(routeObj.rental_prices[0].price_without_driver) || 0;
                driverFeePerRegency = parseFloat(routeObj.rental_prices[0].driver_fee_per_regency) || 0;
            }

            summaryBasePrice.textContent = formatIDR(basePrice);

            let driverFee = 0;
            if (isWithDriver) {
                driverFee = regencyCount * driverFeePerRegency;
                summaryRegencyText.textContent = `${regencyCount} Kabupaten`;
                summaryDriverFee.textContent = formatIDR(driverFee);
            }

            const totalPrice = basePrice + driverFee;
            summaryTotalPrice.textContent = formatIDR(totalPrice);
        } else {
            summaryRoute.textContent = 'Belum memilih rute';
            summaryBasePrice.textContent = 'Rp 0';
            summaryDriverFee.textContent = 'Rp 0';
            summaryTotalPrice.textContent = 'Rp 0';
        }
    }

    // Set initial date validation min tomorrow
    const tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    const tomorrowStr = tomorrow.toISOString().split('T')[0];
    startInput.min = tomorrowStr;
    startInput.addEventListener('change', function() {
        document.getElementById('end_date').min = startInput.value;
    });

    // Listeners
    routeSelect.addEventListener('change', updateSummary);

    // Initial select trigger
    const currentSelectedType = "{{ old('rental_type', 'without_driver') }}";
    selectRentalType(currentSelectedType);
});
</script>
@endpush
