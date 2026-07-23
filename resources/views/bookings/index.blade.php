@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
    <!-- Custom Style for My Bookings Page -->
    <style>
        .filter-tab {
            transition: all 0.2s ease-in-out;
        }
        .filter-tab.active {
            background-color: #0064d2;
            color: #ffffff;
            box-shadow: 0 4px 6px -1px rgba(0, 100, 210, 0.2);
        }
        .ticket-card {
            border: 1px solid #f3f4f6;
            transition: all 0.25s ease-in-out;
        }
        .ticket-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.02);
            border-color: #dbeafe;
        }
        .ticket-left-accent {
            width: 6px;
        }
    </style>

    <!-- Page Header -->
    <div class="mb-8 flex justify-between items-center flex-wrap gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 leading-tight">Daftar Pesanan Saya</h1>
            <p class="text-gray-500 text-sm">Kelola tiket travel dan rental mobil Anda di satu tempat</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('bookings.travel.create') }}" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-md transition-all">
                + Pesan Tiket Travel
            </a>
            <a href="{{ route('bookings.rental.create') }}" class="px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-xl text-xs font-bold shadow-md transition-all">
                + Sewa Mobil
            </a>
        </div>
    </div>

    <!-- Tab Filter - Traveloka Style -->
    <div class="flex gap-2 mb-6 flex-wrap pb-2 border-b border-gray-100">
        @php
            $tabs = [
                ['key' => 'all', 'label' => 'Semua Pesanan'],
                ['key' => 'pending', 'label' => 'Menunggu Pembayaran'],
                ['key' => 'confirmed', 'label' => 'Terkonfirmasi'],
                ['key' => 'completed', 'label' => 'Selesai'],
                ['key' => 'cancelled', 'label' => 'Dibatalkan'],
            ];
        @endphp
        @foreach($tabs as $tab)
            <a href="{{ route('bookings.index', ['status' => $tab['key']]) }}" 
               class="filter-tab px-4 py-2 rounded-xl font-bold text-xs border border-transparent transition-all
               @if($status === $tab['key'])
                   active
               @else
                   bg-gray-50 text-gray-600 hover:bg-gray-100
               @endif">
                {{ $tab['label'] }}
            </a>
        @endforeach
    </div>

    <!-- Bookings Cards Container -->
    @if($bookings->count() > 0)
        <div class="space-y-4">
            @foreach($bookings as $booking)
                @php
                    // Define styles based on booking type
                    $typeConfig = [
                        'travel' => [
                            'label' => 'Tiket Travel',
                            'accent_bg' => 'bg-blue-600',
                            'light_bg' => 'bg-blue-50',
                            'text_color' => 'text-blue-700',
                            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>'
                        ],
                        'rental' => [
                            'label' => 'Rental Mobil',
                            'accent_bg' => 'bg-emerald-600',
                            'light_bg' => 'bg-emerald-50',
                            'text_color' => 'text-emerald-700',
                            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>'
                        ],
                        'airport_transfer' => [
                            'label' => 'Antar Jemput Bandara',
                            'accent_bg' => 'bg-purple-600',
                            'light_bg' => 'bg-purple-50',
                            'text_color' => 'text-purple-700',
                            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>'
                        ]
                    ];
                    $config = $typeConfig[$booking->type] ?? [
                        'label' => 'Pemesanan',
                        'accent_bg' => 'bg-gray-600',
                        'light_bg' => 'bg-gray-50',
                        'text_color' => 'text-gray-700',
                        'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>'
                    ];

                    // Status style
                    $statusColors = [
                        'pending' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                        'confirmed' => 'bg-blue-50 text-blue-700 border-blue-200',
                        'completed' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                        'cancelled' => 'bg-red-50 text-red-700 border-red-200',
                    ];
                    $statusText = [
                        'pending' => 'Menunggu Pembayaran',
                        'confirmed' => 'Terkonfirmasi',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                    ];
                    $statusClass = $statusColors[$booking->status] ?? 'bg-gray-50 text-gray-700 border-gray-200';
                    $statusLabel = $statusText[$booking->status] ?? ucfirst($booking->status);
                @endphp

                <!-- Ticket Card -->
                <div class="ticket-card bg-white rounded-2xl overflow-hidden flex flex-col md:flex-row items-stretch shadow-sm cursor-pointer border border-gray-100"
                     onclick="window.location='{{ $booking->show_route }}'">
                    
                    <!-- Color accent bar on the far left -->
                    <div class="ticket-left-accent {{ $config['accent_bg'] }}"></div>

                    <!-- Inner Card Content -->
                    <div class="p-5 flex-1 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                        
                        <!-- Route & Booking Type -->
                        <div class="space-y-2 flex-1">
                            <div class="flex items-center gap-2">
                                <span class="p-1 {{ $config['light_bg'] }} {{ $config['text_color'] }} rounded-lg">
                                    {!! $config['icon'] !!}
                                </span>
                                <span class="text-xs font-black tracking-wide uppercase {{ $config['text_color'] }}">{{ $config['label'] }}</span>
                                <span class="text-gray-300">•</span>
                                <span class="font-mono text-xs font-bold text-gray-500">{{ $booking->booking_code ?? '-' }}</span>
                            </div>
                            <h3 class="text-lg font-black text-gray-900 leading-tight">
                                {{ $booking->detail }}
                            </h3>
                            <div class="flex items-center gap-3 text-xs text-gray-500 font-medium">
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    @if(is_object($booking->date) && method_exists($booking->date, 'format'))
                                        {{ $booking->date->format('d M Y') }}
                                    @else
                                        {{ \Carbon\Carbon::parse($booking->date)->format('d M Y') }}
                                    @endif
                                </span>
                            </div>
                        </div>

                        <!-- Price & Status -->
                        <div class="flex flex-row md:flex-col items-center md:items-end justify-between w-full md:w-auto gap-4 border-t md:border-t-0 pt-3 md:pt-0">
                            <div class="text-left md:text-right">
                                <span class="text-xxs font-bold text-gray-400 uppercase tracking-widest block">Total Transaksi</span>
                                <span class="text-lg font-black text-orange-500">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="px-3 py-1 rounded-full border text-xxs font-bold {{ $statusClass }}">
                                    {{ $statusLabel }}
                                </span>
                                <span class="text-gray-400 text-sm hidden md:inline">&rarr;</span>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8 flex justify-center">
            {{ $pagination->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-12 text-center">
            <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-1">Belum Ada Pemesanan</h3>
            <p class="text-gray-500 text-sm max-w-sm mx-auto mb-6">Anda tidak memiliki daftar pemesanan aktif dengan filter status yang Anda pilih.</p>
            <div class="flex justify-center gap-3">
                <a href="{{ route('bookings.travel.create') }}" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-md transition-all">
                    Pesan Travel Baru
                </a>
                <a href="{{ route('bookings.rental.create') }}" class="px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-xl text-xs font-bold shadow-md transition-all">
                    Sewa Mobil Baru
                </a>
            </div>
        </div>
    @endif
@endsection
