@extends('layouts.app')

@section('title', 'Detail Booking Rental')

@section('content')
    <!-- CSS Accent for Rental E-Voucher Style -->
    <style>
        .voucher-card {
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
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Detail Voucher Rental</h1>
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
        
        <!-- LEFT COLUMN: Rental E-Voucher & Vehicle Details -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- E-Voucher Card -->
            <div class="voucher-card bg-white rounded-3xl p-6 relative overflow-hidden border border-gray-100">
                
                <!-- Ticket Top Header -->
                <div class="flex justify-between items-center pb-4 border-b border-gray-100 mb-6">
                    <div class="flex items-center gap-2">
                        <div class="p-1.5 bg-blue-600 text-white rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <span class="text-sm font-black tracking-wider text-gray-800">ASR GO CAR RENTAL VOUCHER</span>
                    </div>
                    <div class="text-xs font-bold text-gray-400 font-mono">
                        TERBIT: {{ $booking->created_at->format('d M Y') }}
                    </div>
                </div>

                <!-- Ticket Core Route / Location Info -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                    
                    <!-- Route Origin -->
                    <div class="space-y-1">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">WILAYAH ASAL</span>
                        <h3 class="text-2xl font-black text-gray-900 leading-tight">
                            {{ $booking->route?->origin_city ?? 'Ende' }}
                        </h3>
                        <p class="text-xs text-gray-500 font-medium">Tempat Penyerahan Kendaraan</p>
                    </div>

                    <!-- Journey Arrow -->
                    <div class="flex flex-col items-center justify-center text-center px-4">
                        <span class="text-xs font-bold text-blue-600 bg-blue-50 px-3 py-1 rounded-full mb-2">
                            @if($booking->with_driver)
                                Dengan Sopir
                            @else
                                Lepas Kunci
                            @endif
                        </span>
                        <div class="w-full flex items-center justify-center gap-1">
                            <span class="h-0.5 w-8 bg-blue-200"></span>
                            <div class="w-6 h-6 rounded-full bg-blue-600 text-white flex items-center justify-center">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <span class="h-0.5 w-8 bg-blue-200"></span>
                        </div>
                        <span class="text-xs font-medium text-gray-400 mt-2">
                            Durasi: {{ max(1, \Carbon\Carbon::parse($booking->start_date)->diffInDays(\Carbon\Carbon::parse($booking->end_date))) }} Hari
                        </span>
                    </div>

                    <!-- Route Destination -->
                    <div class="space-y-1 text-left md:text-right">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">WILAYAH TUJUAN</span>
                        <h3 class="text-2xl font-black text-gray-900 leading-tight">
                            @if($booking->route)
                                {{ $booking->route->destination_city }}
                            @else
                                @php
                                    $dest = 'Dalam Kota';
                                    if (str_contains($booking->notes ?? '', 'Luar Kota Ende')) {
                                        if (preg_match('/Tujuan:\s*([^|]+)/', $booking->notes ?? '', $matches)) {
                                            $dest = trim($matches[1]);
                                        } else {
                                            $dest = 'Luar Kota';
                                        }
                                    }
                                @endphp
                                {{ $dest }}
                            @endif
                        </h3>
                        <p class="text-xs text-gray-500 font-medium">Wilayah Pengoperasian Utama</p>
                    </div>

                </div>

                <!-- Dashed ticket divider -->
                <div class="relative my-6">
                    <div class="ticket-dashed-line w-full border-t"></div>
                </div>

                <!-- Ticket Details (Start, End, Driver Option, Code) -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-6">
                    <div>
                        <span class="text-xs font-bold text-gray-400 block mb-1">TANGGAL MULAI</span>
                        <span class="font-bold text-gray-800 text-sm">
                            {{ \Carbon\Carbon::parse($booking->start_date)->format('d F Y') }}
                        </span>
                    </div>
                    <div>
                        <span class="text-xs font-bold text-gray-400 block mb-1">TANGGAL SELESAI</span>
                        <span class="font-bold text-gray-800 text-sm">
                            {{ \Carbon\Carbon::parse($booking->end_date)->format('d F Y') }}
                        </span>
                    </div>
                    <div>
                        <span class="text-xs font-bold text-gray-400 block mb-1">PENGEMUDI</span>
                        <span class="font-bold text-blue-600 text-sm">
                            @if($booking->with_driver)
                                Dengan Sopir ({{ $booking->regency_count ?? 1 }} Kab)
                            @else
                                Tanpa Sopir (Self Drive)
                            @endif
                        </span>
                    </div>
                    <div>
                        <span class="text-xs font-bold text-gray-400 block mb-1">KODE VOUCHER</span>
                        <span class="font-mono font-bold text-gray-800 text-sm select-all">
                            {{ $booking->booking_code }}
                        </span>
                    </div>
                </div>

                <!-- Visual Barcode Section -->
                <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100 flex flex-col md:flex-row items-center justify-between gap-4">
                    <div class="space-y-1 text-center md:text-left">
                        <h4 class="text-sm font-bold text-gray-900">ASR Rental Verification Scan</h4>
                        <p class="text-xs text-gray-500">Tunjukkan barcode verifikasi saat serah terima unit kendaraan</p>
                    </div>
                    
                    <!-- Simulated Vector Barcode -->
                    <div class="bg-white p-3 rounded-xl border border-gray-200 flex flex-col items-center justify-center gap-1.5">
                        <div class="flex items-center gap-0.5 px-2">
                            <span class="barcode-line w-1.5"></span>
                            <span class="barcode-line w-0.5"></span>
                            <span class="barcode-line w-2"></span>
                            <span class="barcode-line w-0.5"></span>
                            <span class="barcode-line w-1"></span>
                            <span class="barcode-line w-1.5"></span>
                            <span class="barcode-line w-0.5"></span>
                            <span class="barcode-line w-1"></span>
                            <span class="barcode-line w-0.5"></span>
                            <span class="barcode-line w-2"></span>
                            <span class="barcode-line w-0.5"></span>
                            <span class="barcode-line w-1.5"></span>
                        </div>
                        <span class="text-xxs font-mono tracking-widest text-gray-700 font-bold">{{ $booking->booking_code }}</span>
                    </div>
                </div>

            </div>

            <!-- Assigned Fleet / Vehicle details -->
            @if($booking->armada)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-4">
                    <h3 class="text-lg font-bold text-gray-900 pb-3 border-b border-gray-100">Unit Mobil & Supir yang Ditugaskan</h3>
                    
                    <div class="flex flex-col md:flex-row gap-6">
                        <!-- Vehicle Visual Info -->
                        <div class="flex-1 bg-gray-50 rounded-xl p-4 border border-gray-200 flex items-center gap-4">
                            <div class="p-3 bg-blue-100 text-blue-600 rounded-xl">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <span class="text-xxs font-bold text-gray-400 uppercase">TIPE ARMADA MOBIL</span>
                                <h4 class="text-base font-bold text-gray-900">{{ $booking->armada->vehicle_type }}</h4>
                                <span class="inline-block mt-1 font-mono font-bold text-xs bg-gray-200 text-gray-800 px-2 py-0.5 rounded">
                                    Plat No: {{ $booking->armada->plate_number }}
                                </span>
                            </div>
                        </div>

                        <!-- Driver Info -->
                        @if($booking->with_driver)
                            <div class="flex-1 bg-gray-50 rounded-xl p-4 border border-gray-200 flex items-center gap-4">
                                <div class="p-3 bg-emerald-100 text-emerald-600 rounded-xl">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-xxs font-bold text-gray-400 uppercase">PENGEMUDI (SOPIR)</span>
                                    <h4 class="text-base font-bold text-gray-900">{{ $booking->armada->driver_name ?? 'Sopir ASR GO' }}</h4>
                                    <p class="text-xs text-gray-500 font-semibold mt-0.5">Telepon: {{ $booking->armada->driver_phone ?? '-' }}</p>
                                </div>
                            </div>
                        @else
                            <div class="flex-1 bg-gray-50 rounded-xl p-4 border border-gray-200 flex items-center gap-4">
                                <div class="p-3 bg-yellow-100 text-yellow-600 rounded-xl">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-xxs font-bold text-gray-400 uppercase">KETENTUAN DRIVER</span>
                                    <h4 class="text-base font-bold text-gray-900">Sewa Lepas Kunci</h4>
                                    <p class="text-xs text-gray-500 font-semibold mt-0.5">Unit diambil di kantor ASR GO</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

        </div>

        <!-- RIGHT COLUMN: Payment Details / Action Steps -->
        <div class="space-y-6 lg:sticky lg:top-20">
            
            <!-- Price Summary Panel -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-md p-6 space-y-4">
                <h3 class="text-lg font-bold text-gray-900 pb-3 border-b border-gray-100">Rincian Biaya Sewa</h3>
                
                @php
                    $baseRentalPrice = $booking->route?->rentalPrices?->first()?->price_without_driver ?? $booking->total_price;
                    $driverFee = $booking->with_driver ? ($booking->total_price - $baseRentalPrice) : 0;
                @endphp

                <div class="space-y-3 text-sm">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">Harga Sewa Mobil Dasar</span>
                        <span class="font-bold text-gray-800">
                            Rp {{ number_format($baseRentalPrice, 0, ',', '.') }}
                        </span>
                    </div>
                    
                    @if($booking->with_driver)
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500">Biaya Sopir ({{ $booking->regency_count ?? 1 }} Kab)</span>
                            <span class="font-bold text-gray-800">
                                Rp {{ number_format($driverFee, 0, ',', '.') }}
                            </span>
                        </div>
                    @endif
                    
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
                            Silakan transfer pembayaran sewa mobil Anda ke rekening resmi ASR GO berikut.
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
                    <a href="{{ route('payments.rental', $booking->id) }}" class="block w-full py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-center font-bold text-sm shadow-md transition-all">
                        Proses Unggah Bukti Bayar
                    </a>
                @endif

                <!-- Cancel Booking -->
                @if($booking->status === 'pending')
                    <form action="{{ route('bookings.rental.destroy', $booking) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pemesanan rental mobil ini?')" class="mt-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full py-2.5 bg-white hover:bg-red-50 text-red-600 border border-red-200 hover:border-red-300 rounded-xl text-center font-bold text-xs transition-all">
                            Batalkan Pemesanan Rental
                        </button>
                    </form>
                @endif

                <!-- Post-completion Actions -->
                @if($booking->status === 'completed')
                    @php
                        $hasReviewed = \App\Models\Review::where('booking_id', $booking->id)->where('user_id', auth()->id())->exists();
                    @endphp
                    @if(!$hasReviewed)
                        <a href="{{ route('bookings.review.create', $booking) }}" class="block w-full py-3 bg-yellow-500 hover:bg-yellow-600 text-white rounded-xl text-center font-bold text-sm shadow-md transition-all mb-2">
                            Tulis Ulasan Sewa Mobil
                        </a>
                    @endif
                    <a href="{{ route('bookings.refund.create', $booking) }}" class="block w-full py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl text-center font-bold text-sm shadow-md transition-all">
                        Ajukan Refund Sewa Mobil
                    </a>
                @endif

            </div>

        </div>

    </div>
@endsection
