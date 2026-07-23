@extends('layouts.app')

@section('title', 'Pesan Travel')

@section('content')
    <!-- Traveloka Style CSS Accent -->
    <style>
        .btn-traveloka-primary {
            background-color: #0064d2;
            color: #ffffff;
            transition: all 0.2s ease-in-out;
        }
        .btn-traveloka-primary:hover {
            background-color: #0051a8;
        }
        .bg-traveloka-light {
            background-color: #f2f7fe;
        }
        .text-traveloka {
            color: #0064d2;
        }
        .border-traveloka {
            border-color: #0064d2;
        }
        /* Seat styling */
        .seat {
            aspect-ratio: 1;
            transition: all 0.15s ease-in-out;
        }
        .seat.available:hover {
            background-color: #dbeafe;
            border-color: #3b82f6;
            transform: scale(1.05);
        }
        .seat.selected {
            background-color: #0064d2;
            border-color: #0064d2;
            color: white;
        }
        .seat.occupied {
            background-color: #e5e7eb;
            border-color: #d1d5db;
            color: #9ca3af;
            cursor: not-allowed;
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 leading-tight">Pesan Tiket Travel</h1>
                <p class="text-gray-500 text-sm">Lengkapi detail perjalanan Anda dengan aman dan cepat</p>
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

    <form action="{{ route('bookings.travel.store') }}" method="POST" id="travelBookingForm" class="space-y-6">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            <!-- LEFT COLUMN: Form & Passengers -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Section 1: Route & Date -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-5">
                    <div class="flex items-center gap-2 pb-3 border-b border-gray-100">
                        <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-bold">1</span>
                        <h2 class="text-lg font-bold text-gray-900">Rute & Tanggal Keberangkatan</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Route -->
                        <div>
                            <label for="route_id" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Pilih Rute Perjalanan</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400 pointer-events-none">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </span>
                                <select name="route_id" id="route_id" required
                                        class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-800 font-medium transition-all">
                                    <option value="">-- Pilih Rute --</option>
                                    @foreach ($routes as $route)
                                        <option value="{{ $route->id }}" @selected(old('route_id') == $route->id)>
                                            {{ $route->origin_city }} &rarr; {{ $route->destination_city }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Date -->
                        <div>
                            <label for="scheduled_date" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tanggal Berangkat</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400 pointer-events-none">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </span>
                                <input type="date" name="scheduled_date" id="scheduled_date" 
                                       value="{{ old('scheduled_date') }}" required
                                       min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                       class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-800 font-medium transition-all">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Seats & Passengers -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-5">
                    <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-bold">2</span>
                            <h2 class="text-lg font-bold text-gray-900">Jumlah Kursi & Data Penumpang</h2>
                        </div>
                        <div class="flex items-center gap-2">
                            <label for="number_of_seats" class="text-sm font-semibold text-gray-600">Jumlah Kursi:</label>
                            <select name="number_of_seats" id="number_of_seats" class="px-3 py-1.5 bg-gray-50 border border-gray-200 rounded-lg text-sm font-bold focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @for($i = 1; $i <= 6; $i++)
                                    <option value="{{ $i }}" @selected(old('number_of_seats', 1) == $i)>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <!-- Passengers Input Container -->
                    <div id="passengersContainer" class="space-y-4">
                        <!-- Will be dynamically populated by JS based on number_of_seats -->
                    </div>

                    <!-- Visual Bus Seat Selection Grid -->
                    <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-sm font-bold text-gray-900">Pilih Kursi Secara Visual</h3>
                                <p class="text-xs text-gray-500">Klik kursi untuk penumpang yang sedang dipilih</p>
                            </div>
                            <div class="flex gap-4 text-xs">
                                <span class="flex items-center gap-1.5 text-gray-600"><span class="w-3.5 h-3.5 bg-white border border-gray-300 rounded"></span>Tersedia</span>
                                <span class="flex items-center gap-1.5 text-gray-600"><span class="w-3.5 h-3.5 bg-blue-600 rounded"></span>Dipilih</span>
                                <span class="flex items-center gap-1.5 text-gray-600"><span class="w-3.5 h-3.5 bg-gray-200 border border-gray-300 rounded"></span>Terisi</span>
                            </div>
                        </div>

                        <!-- Mini Bus Layout -->
                        <div class="max-w-xs mx-auto bg-white border-2 border-gray-300 rounded-2xl p-4 relative shadow-inner">
                            <div class="text-center font-bold text-xs text-gray-400 border-b pb-2 mb-4 tracking-widest uppercase">Bagian Depan (Avanza / APV / Ertiga)</div>
                            
                            <!-- Bus Grid Layout (3 Columns) -->
                            <div class="grid grid-cols-3 gap-3 text-center">
                                <!-- Row 0 (Driver on the right, Passenger 1A on the left) -->
                                <div class="seat available text-xs font-bold flex items-center justify-center border border-gray-300 rounded-lg cursor-pointer bg-white" data-seat="1A">1A</div>
                                <div></div>
                                <div class="seat occupied text-xs font-bold flex items-center justify-center border border-gray-300 rounded-lg bg-gray-100">Sopir</div>

                                <!-- Row 1 (Middle Row - 3 seats) -->
                                <div class="seat available text-xs font-bold flex items-center justify-center border border-gray-300 rounded-lg cursor-pointer bg-white" data-seat="2A">2A</div>
                                <div class="seat available text-xs font-bold flex items-center justify-center border border-gray-300 rounded-lg cursor-pointer bg-white" data-seat="2B">2B</div>
                                <div class="seat available text-xs font-bold flex items-center justify-center border border-gray-300 rounded-lg cursor-pointer bg-white" data-seat="2C">2C</div>

                                <!-- Row 2 (Back Row - 2 seats) -->
                                <div class="seat available text-xs font-bold flex items-center justify-center border border-gray-300 rounded-lg cursor-pointer bg-white" data-seat="3A">3A</div>
                                <div></div>
                                <div class="seat available text-xs font-bold flex items-center justify-center border border-gray-300 rounded-lg cursor-pointer bg-white" data-seat="3B">3B</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN: Sticky Pricing Summary -->
            <div class="space-y-6 lg:sticky lg:top-20">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-md overflow-hidden">
                    <!-- Title -->
                    <div class="bg-blue-600 text-white p-5">
                        <h3 class="font-extrabold text-lg">Ringkasan Pemesanan</h3>
                        <p class="text-blue-100 text-xs mt-0.5">Detail perjalanan Anda akan tertera di sini</p>
                    </div>

                    <!-- Content -->
                    <div class="p-6 space-y-5">
                        <!-- Route Details Summary -->
                        <div class="space-y-3 pb-4 border-b border-gray-100">
                            <div>
                                <span class="text-xs font-bold text-gray-400 uppercase">Rute Perjalanan</span>
                                <div id="summaryRoute" class="text-base font-bold text-gray-800 mt-0.5">Belum memilih rute</div>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-500">Estimasi Jarak</span>
                                <span id="summaryDistance" class="font-semibold text-gray-700">-</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-500">Estimasi Waktu</span>
                                <span id="summaryDuration" class="font-semibold text-gray-700">-</span>
                            </div>
                        </div>

                        <!-- Price breakdown -->
                        <div class="space-y-3 pb-4 border-b border-gray-100">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-500">Harga per Kursi</span>
                                <span id="summaryPricePerSeat" class="font-bold text-gray-800">Rp 0</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span id="summarySeatsLabel" class="text-gray-500">Jumlah Penumpang (1x)</span>
                                <span id="summarySeatsCount" class="font-semibold text-gray-700">1 Kursi</span>
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

                        <!-- Terms Card -->
                        <div class="bg-blue-50 border border-blue-100 rounded-xl p-3.5 flex gap-2">
                            <svg class="w-5 h-5 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-xs text-blue-800 leading-normal">
                                Tiket elektronik akan diterbitkan setelah pembayaran Anda berhasil diverifikasi oleh sistem ASR GO.
                            </p>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full py-3.5 btn-traveloka-primary rounded-xl font-bold text-center text-base shadow-lg shadow-blue-200 transition-all transform hover:-translate-y-0.5">
                            Lanjutkan Ke Pembayaran
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
    // Inject active routes list with their travel prices
    const routes = @json($routes);
    
    // Elements
    const routeSelect = document.getElementById('route_id');
    const seatsSelect = document.getElementById('number_of_seats');
    const container = document.getElementById('passengersContainer');
    const seatElements = document.querySelectorAll('.seat.available');
    
    // Summary elements
    const summaryRoute = document.getElementById('summaryRoute');
    const summaryDistance = document.getElementById('summaryDistance');
    const summaryDuration = document.getElementById('summaryDuration');
    const summaryPricePerSeat = document.getElementById('summaryPricePerSeat');
    const summarySeatsLabel = document.getElementById('summarySeatsLabel');
    const summarySeatsCount = document.getElementById('summarySeatsCount');
    const summaryTotalPrice = document.getElementById('summaryTotalPrice');

    // State for tracking active passenger inputs and selected seats
    let activeInputIndex = 0;

    // Format currency to IDR helper
    function formatIDR(num) {
        return 'Rp ' + Number(num).toLocaleString('id-ID', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
    }

    // Update dynamic summary card
    function updateSummary() {
        const selectedRouteId = routeSelect.value;
        const numSeats = parseInt(seatsSelect.value) || 1;
        const routeObj = routes.find(r => r.id === selectedRouteId);

        if (routeObj) {
            summaryRoute.innerHTML = `${routeObj.origin_city} &rarr; ${routeObj.destination_city}`;
            summaryDistance.textContent = routeObj.distance_km ? `${Number(routeObj.distance_km).toFixed(0)} km` : '-';
            summaryDuration.textContent = routeObj.estimated_hours ? `${Number(routeObj.estimated_hours).toFixed(1)} Jam` : '-';
            
            // Get price from travel_prices relation
            let pricePerSeat = 0;
            if (routeObj.travel_prices && routeObj.travel_prices.length > 0) {
                pricePerSeat = parseFloat(routeObj.travel_prices[0].price_per_seat);
            } else if (routeObj.price_per_seat) {
                pricePerSeat = parseFloat(routeObj.price_per_seat);
            }
            
            summaryPricePerSeat.textContent = formatIDR(pricePerSeat);
            summarySeatsLabel.textContent = `Jumlah Penumpang (${numSeats}x)`;
            summarySeatsCount.textContent = `${numSeats} Kursi`;
            summaryTotalPrice.textContent = formatIDR(pricePerSeat * numSeats);
        } else {
            summaryRoute.textContent = 'Belum memilih rute';
            summaryDistance.textContent = '-';
            summaryDuration.textContent = '-';
            summaryPricePerSeat.textContent = 'Rp 0';
            summarySeatsLabel.textContent = 'Jumlah Penumpang';
            summarySeatsCount.textContent = '-';
            summaryTotalPrice.textContent = 'Rp 0';
        }
    }

    // Generate passenger forms dynamically based on selected seats count
    function syncPassengerForms() {
        const numSeats = parseInt(seatsSelect.value) || 1;
        const currentCount = container.querySelectorAll('.passenger-card').length;
        
        // Save current values to restore them
        const savedData = [];
        for (let i = 0; i < currentCount; i++) {
            const nameVal = container.querySelector(`[name="passengers[${i}][name]"]`)?.value || '';
            const nikVal = container.querySelector(`[name="passengers[${i}][nik]"]`)?.value || '';
            const seatVal = container.querySelector(`[name="passengers[${i}][seat_number]"]`)?.value || '';
            savedData.push({ name: nameVal, nik: nikVal, seat: seatVal });
        }

        container.innerHTML = '';
        
        for (let i = 0; i < numSeats; i++) {
            const card = document.createElement('div');
            card.className = `passenger-card bg-gray-50 border ${i === activeInputIndex ? 'border-blue-400 ring-2 ring-blue-50' : 'border-gray-200'} rounded-xl p-4 relative transition-all`;
            card.dataset.index = i;
            
            // Event listener to set active passenger for seat selection
            card.addEventListener('click', function() {
                setActivePassenger(i);
            });

            const prefilled = savedData[i] || { name: '', nik: '', seat: '' };
            
            card.innerHTML = `
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-md">PENUMPANG #${i + 1}</span>
                    ${i === activeInputIndex ? '<span class="text-xxs font-semibold text-blue-500 animate-pulse">Menunggu Peta Kursi...</span>' : ''}
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div>
                        <label class="text-xxs font-bold text-gray-400 uppercase tracking-wider block mb-1">Nama Lengkap</label>
                        <input type="text" name="passengers[${i}][name]" required
                               value="${prefilled.name}"
                               class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 text-sm font-semibold"
                               placeholder="Contoh: Budi Santoso">
                    </div>
                    <div>
                        <label class="text-xxs font-bold text-gray-400 uppercase tracking-wider block mb-1">NIK (KTP)</label>
                        <input type="text" name="passengers[${i}][nik]" required
                               value="${prefilled.nik}"
                               class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 text-sm font-semibold font-mono"
                               placeholder="16-digit Nomor KTP">
                    </div>
                    <div>
                        <label class="text-xxs font-bold text-gray-400 uppercase tracking-wider block mb-1">No. Kursi</label>
                        <input type="text" name="passengers[${i}][seat_number]" required readonly
                               value="${prefilled.seat}"
                               class="passenger-seat-input w-full px-3 py-2 bg-blue-50 border border-blue-200 rounded-lg text-sm font-bold text-blue-700 text-center cursor-pointer"
                               placeholder="Pilih di bawah">
                    </div>
                </div>
            `;
            container.appendChild(card);
        }
        
        updateSeatHighlighting();
    }

    // Set which passenger is currently selected/active for seat map allocation
    function setActivePassenger(idx) {
        activeInputIndex = idx;
        const cards = container.querySelectorAll('.passenger-card');
        cards.forEach((card, index) => {
            if (index === idx) {
                card.className = 'passenger-card bg-gray-50 border border-blue-400 ring-2 ring-blue-50 rounded-xl p-4 relative transition-all';
            } else {
                card.className = 'passenger-card bg-gray-50 border border-gray-200 rounded-xl p-4 relative transition-all';
            }
        });
    }

    // Highlight selected seats in the visual minibus
    function updateSeatHighlighting() {
        // Collect currently assigned seats
        const assignedSeats = [];
        const inputs = container.querySelectorAll('.passenger-seat-input');
        inputs.forEach(input => {
            if (input.value) {
                assignedSeats.push(input.value);
            }
        });

        // Reset visual seats
        seatElements.forEach(seat => {
            const seatNum = seat.dataset.seat;
            if (assignedSeats.includes(seatNum)) {
                seat.className = 'seat text-xs font-bold flex items-center justify-center border rounded-lg cursor-pointer selected';
            } else {
                seat.className = 'seat available text-xs font-bold flex items-center justify-center border border-gray-300 rounded-lg cursor-pointer bg-white';
            }
        });
    }

    // Seat click event handler
    seatElements.forEach(seat => {
        seat.addEventListener('click', function() {
            const seatNum = this.dataset.seat;
            
            // Check if another passenger already has this seat
            const currentInputs = container.querySelectorAll('.passenger-seat-input');
            let alreadyAssignedIdx = -1;
            
            currentInputs.forEach((input, index) => {
                if (input.value === seatNum) {
                    alreadyAssignedIdx = index;
                }
            });

            if (alreadyAssignedIdx !== -1) {
                // Remove from that passenger
                currentInputs[alreadyAssignedIdx].value = '';
            }

            // Assign to active passenger
            const activeInput = container.querySelector(`[name="passengers[${activeInputIndex}][seat_number]"]`);
            if (activeInput) {
                activeInput.value = seatNum;
            }

            updateSeatHighlighting();
            
            // Move to next passenger automatically if empty
            const numSeats = parseInt(seatsSelect.value) || 1;
            let nextIndex = -1;
            for (let i = 0; i < numSeats; i++) {
                const checkInput = container.querySelector(`[name="passengers[${i}][seat_number]"]`);
                if (checkInput && !checkInput.value) {
                    nextIndex = i;
                    break;
                }
            }
            
            if (nextIndex !== -1) {
                setActivePassenger(nextIndex);
            }
        });
    });

    // Listeners
    routeSelect.addEventListener('change', updateSummary);
    seatsSelect.addEventListener('change', function() {
        syncPassengerForms();
        updateSummary();
    });

    // Initial setup
    syncPassengerForms();
    updateSummary();
});
</script>
@endpush
