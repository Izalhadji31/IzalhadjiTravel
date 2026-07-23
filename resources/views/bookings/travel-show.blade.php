@extends('layouts.app')

@section('title', 'Detail Booking Travel')

@section('content')
    <!-- CSS Accent for Boarding Pass Style -->
    <style>
        .boarding-card {
            background-image: radial-gradient(circle at 0% 50%, transparent 12px, #ffffff 12px), 
                              radial-gradient(circle at 100% 50%, transparent 12px, #ffffff 12px);
            background-size: 100% 100%;
            background-repeat: no-repeat;
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.05));
        }
        .ticket-dashed-line {
            border-style: dashed;
            border-width: 2px;
            border-color: #f3f4f6;
        }
        .barcode-line {
            display: inline-block;
            background-color: #111827;
            height: 48px;
        }
    </style>

    <div class="mb-6">
        <!-- Back Button -->
        <a href="{{ route('bookings.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors mb-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Daftar Pemesanan
        </a>
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Detail Tiket Travel</h1>
                <p class="text-gray-500 text-sm">Pemesanan Kode: <span class="font-mono font-bold text-gray-800">{{ $booking->booking_code }}</span></p>
            </div>
            
            <!-- Status Badge -->
            <div>
                @php
                    $statusClasses = [
                        'pending' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                        'confirmed' => 'bg-blue-50 text-blue-700 border-blue-200',
                        'completed' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                        'cancelled' => 'bg-red-50 text-red-700 border-red-200',
                    ];
                    $statusText = [
                        'pending' => 'MENUNGGU PEMBAYARAN',
                        'confirmed' => 'TERKONFIRMASI',
                        'completed' => 'SELESAI',
                        'cancelled' => 'DIBATALKAN',
                    ];
                    $currentStatus = $booking->status;
                    $badgeClass = $statusClasses[$currentStatus] ?? 'bg-gray-50 text-gray-700 border-gray-200';
                    $textShow = $statusText[$currentStatus] ?? strtoupper($currentStatus);
                @endphp
                <span class="px-4 py-2 rounded-full border text-xs font-black tracking-wider {{ $badgeClass }}">
                    {{ $textShow }}
                </span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        
        <!-- LEFT COLUMN: Ticket Boarding Pass & Passengers -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- E-Ticket / Boarding Pass Card -->
            <div class="boarding-card bg-white rounded-3xl p-6 relative overflow-hidden border border-gray-100">
                
                <!-- Ticket Top Header -->
                <div class="flex justify-between items-center pb-4 border-b border-gray-100 mb-6">
                    <div class="flex items-center gap-2">
                        <div class="p-1.5 bg-blue-600 text-white rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                            </svg>
                        </div>
                        <span class="text-sm font-black tracking-wider text-gray-800">ASR GO TRAVEL TICKET</span>
                    </div>
                    <div class="text-xs font-bold text-gray-400 font-mono">
                        TERBIT: {{ $booking->created_at->format('d M Y') }}
                    </div>
                </div>

                <!-- Ticket Core Route Info -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                    
                    <!-- Origin -->
                    <div class="space-y-1">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">KOTA ASAL</span>
                        <h3 class="text-2xl font-black text-gray-900 leading-tight">
                            {{ $booking->route?->origin_city ?? 'N/A' }}
                        </h3>
                        <p class="text-xs text-gray-500 font-medium">Jawa Tengah, Indonesia</p>
                    </div>

                    <!-- Journey Icon Arrow -->
                    <div class="flex flex-col items-center justify-center text-center px-4">
                        <span class="text-xs font-bold text-blue-600 bg-blue-50 px-3 py-1 rounded-full mb-2">
                            {{ $booking->route?->distance_km ? number_format($booking->route->distance_km, 0) . ' km' : '-' }}
                        </span>
                        <div class="w-full flex items-center justify-center gap-1">
                            <span class="h-0.5 w-8 bg-blue-200"></span>
                            <div class="w-6 h-6 rounded-full bg-blue-600 text-white flex items-center justify-center">
                                <svg class="w-3.5 h-3.5 transform rotate-90 md:rotate-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </div>
                            <span class="h-0.5 w-8 bg-blue-200"></span>
                        </div>
                        <span class="text-xs font-medium text-gray-400 mt-2">
                            {{ $booking->route?->estimated_hours ? number_format($booking->route->estimated_hours, 1) . ' jam estimasi' : '-' }}
                        </span>
                    </div>

                    <!-- Destination -->
                    <div class="space-y-1 text-left md:text-right">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">KOTA TUJUAN</span>
                        <h3 class="text-2xl font-black text-gray-900 leading-tight">
                            {{ $booking->route?->destination_city ?? 'N/A' }}
                        </h3>
                        <p class="text-xs text-gray-500 font-medium">Nusa Tenggara Timur, Indonesia</p>
                    </div>

                </div>

                <!-- Dashed ticket divider -->
                <div class="relative my-6">
                    <div class="ticket-dashed-line w-full border-t"></div>
                </div>

                <!-- Ticket Details (Date, Time, Passenger Count, Seat list) -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-6">
                    <div>
                        <span class="text-xs font-bold text-gray-400 block mb-1">TANGGAL BERANGKAT</span>
                        <span class="font-bold text-gray-800 text-sm">
                            {{ \Carbon\Carbon::parse($booking->scheduled_date ?? $booking->departure_time)->format('d F Y') }}
                        </span>
                    </div>
                    <div>
                        <span class="text-xs font-bold text-gray-400 block mb-1">JAM BERANGKAT</span>
                        <span class="font-bold text-gray-800 text-sm">
                            {{ \Carbon\Carbon::parse($booking->departure_time)->format('H:i') }} WIB
                        </span>
                    </div>
                    <div>
                        <span class="text-xs font-bold text-gray-400 block mb-1">JUMLAH KURSI</span>
                        <span class="font-bold text-blue-600 text-sm">
                            {{ $booking->number_of_seats }} Kursi
                        </span>
                    </div>
                    <div>
                        <span class="text-xs font-bold text-gray-400 block mb-1">KODE BOOKING</span>
                        <span class="font-mono font-bold text-gray-800 text-sm select-all">
                            {{ $booking->booking_code }}
                        </span>
                    </div>
                </div>

                <!-- Visual Barcode Section -->
                <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100 flex flex-col md:flex-row items-center justify-between gap-4">
                    <div class="space-y-1 text-center md:text-left">
                        <h4 class="text-sm font-bold text-gray-900">ASR Boarding Pass Scan</h4>
                        <p class="text-xs text-gray-500">Tunjukkan barcode ini kepada kru minibus kami saat naik</p>
                    </div>
                    
                    <!-- Simulated Vector Barcode -->
                    <div class="bg-white p-3 rounded-xl border border-gray-200 flex flex-col items-center justify-center gap-1.5">
                        <div class="flex items-center gap-0.5 px-2">
                            <span class="barcode-line w-1.5"></span>
                            <span class="barcode-line w-0.5"></span>
                            <span class="barcode-line w-1"></span>
                            <span class="barcode-line w-0.5"></span>
                            <span class="barcode-line w-2"></span>
                            <span class="barcode-line w-0.5"></span>
                            <span class="barcode-line w-1"></span>
                            <span class="barcode-line w-1.5"></span>
                            <span class="barcode-line w-0.5"></span>
                            <span class="barcode-line w-2"></span>
                            <span class="barcode-line w-0.5"></span>
                            <span class="barcode-line w-1.5"></span>
                        </div>
                        <span class="text-xxs font-mono tracking-widest text-gray-700 font-bold">{{ $booking->booking_code }}</span>
                    </div>
                </div>

            </div>

            <!-- Passenger Details Card -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-4">
                <h3 class="text-lg font-bold text-gray-900 pb-3 border-b border-gray-100">Informasi Penumpang</h3>
                
                @php
                    $passengers = $booking->passengers;
                @endphp

                @if($passengers && $passengers->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($passengers as $idx => $p)
                            <div class="bg-gray-50 rounded-xl p-4 border border-gray-200 flex items-center justify-between gap-4">
                                <div class="space-y-1">
                                    <span class="text-xxs font-black text-blue-600 bg-blue-50 px-2 py-0.5 rounded-md">PENUMPANG #{{ $idx + 1 }}</span>
                                    <h4 class="text-sm font-bold text-gray-900">{{ $p->name }}</h4>
                                    <p class="text-xs text-gray-500 font-mono">NIK: {{ $p->nik }}</p>
                                </div>
                                <div class="text-center bg-blue-600 text-white rounded-xl px-4 py-2">
                                    <span class="text-xxs font-bold uppercase block tracking-wider text-blue-200">Kursi</span>
                                    <span class="text-lg font-black">{{ $p->seat_number }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-6 text-gray-500 text-sm">
                        Data penumpang terintegrasi dengan pemesan utama ({{ $booking->user?->name ?? 'N/A' }}).
                    </div>
                @endif
            </div>

            <!-- Assigned Fleet / Vehicle details -->
            @if($booking->armada)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-4">
                    <h3 class="text-lg font-bold text-gray-900 pb-3 border-b border-gray-100">Armada & Supir yang Ditugaskan</h3>
                    
                    <div class="flex flex-col md:flex-row gap-6">
                        <!-- Vehicle Visual Info -->
                        <div class="flex-1 bg-gray-50 rounded-xl p-4 border border-gray-200 flex items-center gap-4">
                            <div class="p-3 bg-blue-100 text-blue-600 rounded-xl">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                </svg>
                            </div>
                            <div>
                                <span class="text-xxs font-bold text-gray-400 uppercase">KENDARAAN</span>
                                <h4 class="text-base font-bold text-gray-900">{{ $booking->armada->vehicle_type }}</h4>
                                <span class="inline-block mt-1 font-mono font-bold text-xs bg-gray-200 text-gray-800 px-2 py-0.5 rounded">
                                    {{ $booking->armada->plate_number }}
                                </span>
                            </div>
                        </div>

                        <!-- Driver Info -->
                        <div class="flex-1 bg-gray-50 rounded-xl p-4 border border-gray-200 flex items-center gap-4">
                            <div class="p-3 bg-emerald-100 text-emerald-600 rounded-xl">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <span class="text-xxs font-bold text-gray-400 uppercase">PENGEMUDI (SOPIR)</span>
                                <h4 class="text-base font-bold text-gray-900">{{ $booking->armada->driver_name ?? 'Sopir ASR GO' }}</h4>
                                <p class="text-xs text-gray-500 font-semibold mt-0.5">HP: {{ $booking->armada->driver_phone ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>

        <!-- RIGHT COLUMN: Payment Details / Action Steps -->
        <div class="space-y-6 lg:sticky lg:top-20">
            
            <!-- Price Summary Panel -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-md p-6 space-y-4">
                <h3 class="text-lg font-bold text-gray-900 pb-3 border-b border-gray-100">Rincian Pembayaran</h3>
                
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">Harga Tiket per Kursi</span>
                        <span class="font-bold text-gray-800">
                            Rp {{ number_format($booking->route->travelPrices->first()?->price_per_seat ?? ($booking->total_price / ($booking->number_of_seats ?: 1)), 0, ',', '.') }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">Jumlah Kursi</span>
                        <span class="font-bold text-gray-800">{{ $booking->number_of_seats }} Kursi</span>
                    </div>
                    
                    <div class="border-t pt-3 flex justify-between items-end">
                        <span class="font-bold text-gray-900">Total Harga</span>
                        <span class="text-xl font-black text-orange-500">
                            Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <!-- Payment Status Notice -->
                <div class="bg-gray-50 rounded-xl p-4 border border-gray-200 space-y-2">
                    <span class="text-xxs font-bold text-gray-400 uppercase block">Status Pembayaran</span>
                    <div class="flex items-center gap-2">
                        @if($booking->status === 'pending')
                            <span class="w-2.5 h-2.5 bg-yellow-500 rounded-full animate-ping"></span>
                            <span class="text-sm font-extrabold text-yellow-700 uppercase">Menunggu Transfer</span>
                        @elseif($booking->status === 'confirmed' || $booking->status === 'completed')
                            <span class="text-sm font-extrabold text-emerald-700 uppercase flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                Lunas (Paid)
                            </span>
                        @else
                            <span class="text-sm font-extrabold text-red-700 uppercase">Dibatalkan</span>
                        @endif
                    </div>
                </div>

                <!-- Payment Process Instruction / Action Button -->
                @if($booking->status === 'pending')
                    <div class="bg-blue-50 rounded-xl p-4 border border-blue-200 space-y-3">
                        <h4 class="text-xs font-black text-blue-800 uppercase tracking-wider">Instruksi Pembayaran</h4>
                        <p class="text-xxs text-blue-900 leading-relaxed">
                            Silakan transfer pembayaran Anda ke salah satu rekening Bank ASR GO resmi berikut sebesar nominal di atas.
                        </p>
                        <div class="space-y-2 text-xs">
                            <div class="bg-white p-2 rounded-lg border border-blue-100 flex items-center justify-between">
                                <div>
                                    <span class="font-black text-gray-800 block text-xxs">MANDIRI TRANSFER</span>
                                    <span class="font-mono font-bold text-gray-700 text-xs">181-000-987-6543</span>
                                </div>
                                <span class="text-xxs font-bold text-blue-600 uppercase select-all cursor-pointer">Salin</span>
                            </div>
                            <div class="bg-white p-2 rounded-lg border border-blue-100 flex items-center justify-between">
                                <div>
                                    <span class="font-black text-gray-800 block text-xxs">BCA VIRTUAL</span>
                                    <span class="font-mono font-bold text-gray-700 text-xs">8277-0812-3456-7890</span>
                                </div>
                                <span class="text-xxs font-bold text-blue-600 uppercase select-all cursor-pointer">Salin</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Real Route Payment Action Link -->
                    <a href="{{ route('payments.travel', $booking->id) }}" class="block w-full py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-center font-bold text-sm shadow-md transition-all">
                        Proses Unggah Bukti Bayar
                    </a>
                @endif

                <!-- Cancel Booking -->
                @if($booking->status === 'pending')
                    <form action="{{ route('bookings.travel.destroy', $booking) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pemesanan tiket travel ini?')" class="mt-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full py-2.5 bg-white hover:bg-red-50 text-red-600 border border-red-200 hover:border-red-300 rounded-xl text-center font-bold text-xs transition-all">
                            Batalkan Pemesanan Tiket
                        </button>
                    </form>
                @endif

                <!-- Post-completion Review/Refund Actions -->
                @if($booking->status === 'completed')
                    @php
                        $hasReviewed = \App\Models\Review::where('booking_id', $booking->id)->where('user_id', auth()->id())->exists();
                    @endphp
                    @if(!$hasReviewed)
                        <a href="{{ route('bookings.review.create', $booking) }}" class="block w-full py-3 bg-yellow-500 hover:bg-yellow-600 text-white rounded-xl text-center font-bold text-sm shadow-md transition-all mb-2">
                            Tulis Ulasan Perjalanan
                        </a>
                    @endif
                    <a href="{{ route('bookings.refund.create', $booking) }}" class="block w-full py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl text-center font-bold text-sm shadow-md transition-all">
                        Ajukan Refund Tiket
                    </a>
                @endif

            </div>

        </div>

    </div>
@endsection
