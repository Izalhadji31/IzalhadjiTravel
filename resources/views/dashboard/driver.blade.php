@extends('layouts.app')

@section('title', 'Dashboard Driver')

@section('content')
    <!-- Back Button -->
    <a href="{{ url()->previous() }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors mb-4">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali
    </a>
    <!-- Alerts for success/error -->
    @if(session('success'))
        <div style="background: #d1fae5; border: 1px solid #10b981; color: #059669; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background: #fee2e2; border: 1px solid #f87171; color: #dc2626; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
            {{ session('error') }}
        </div>
    @endif

    <div class="page-header" style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 1rem; margin-bottom: 2rem;">
        <div>
            <h1 class="page-title">Dashboard Pengemudi</h1>
            <p class="page-subtitle">Selamat bekerja! Selalu periksa tugas aktif dan jaga keselamatan berkendara.</p>
        </div>
        
        <!-- Status Keaktifan (Toggle Online/Offline) -->
        <div class="card" style="padding: 0.75rem 1.25rem; display: flex; align-items: center; gap: 1rem; margin: 0;">
            <span style="font-size: 0.9rem; font-weight: 600; color: #666;">Status Anda:</span>
            
            @if($driverStatus === 'available')
                <span style="display: inline-flex; align-items: center; gap: 0.25rem; background: #d1fae5; color: #059669; padding: 0.35rem 0.75rem; border-radius: 2rem; font-size: 0.85rem; font-weight: 600;">
                    <span style="width: 0.5rem; height: 0.5rem; background: #10b981; border-radius: 50%;"></span>
                    Online
                </span>
                <form action="{{ route('driver.status.toggle') }}" method="POST" style="margin: 0;">
                    @csrf
                    <input type="hidden" name="status" value="offline">
                    <button type="submit" class="btn btn-secondary" style="font-size: 0.8rem; padding: 0.35rem 0.75rem;">Set Offline</button>
                </form>
            @else
                <span style="display: inline-flex; align-items: center; gap: 0.25rem; background: #fee2e2; color: #dc2626; padding: 0.35rem 0.75rem; border-radius: 2rem; font-size: 0.85rem; font-weight: 600;">
                    <span style="width: 0.5rem; height: 0.5rem; background: #ef4444; border-radius: 50%;"></span>
                    Offline
                </span>
                <form action="{{ route('driver.status.toggle') }}" method="POST" style="margin: 0;">
                    @csrf
                    <input type="hidden" name="status" value="available">
                    <button type="submit" class="btn btn-primary" style="font-size: 0.8rem; padding: 0.35rem 0.75rem;">Set Online</button>
                </form>
            @endif
        </div>
    </div>

    <!-- Quick Stats Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        <!-- Saldo Driver -->
        <div class="card" style="border-left: 4px solid #059669;">
            <p style="color: #666; font-size: 0.9rem; margin: 0;">Saldo Driver / Pendapatan</p>
            <p style="color: #059669; font-size: 2rem; font-weight: 700; margin: 0.5rem 0 0 0;">
                Rp {{ number_format($driverBalance, 0, ',', '.') }}
            </p>
        </div>

        <!-- Total Trip Selesai -->
        <div class="card" style="border-left: 4px solid #2563eb;">
            <p style="color: #666; font-size: 0.9rem; margin: 0;">Total Perjalanan Selesai</p>
            <p style="color: #2563eb; font-size: 2rem; font-weight: 700; margin: 0.5rem 0 0 0;">
                {{ $driverTripsCount ?? 0 }} Trip
            </p>
        </div>

        <!-- Detail Armada Pengemudi -->
        <div class="card" style="border-left: 4px solid #3b82f6;">
            <p style="color: #666; font-size: 0.9rem; margin: 0;">Mobil Ditugaskan</p>
            @if($armada)
                <p style="color: #111; font-size: 1.25rem; font-weight: 700; margin: 0.5rem 0 0 0;">
                    {{ $armada->plate_number }} ({{ $armada->vehicle_type }})
                </p>
                <p style="color: #666; font-size: 0.75rem; margin: 0.25rem 0 0 0;">Status Mobil: 
                    <span style="font-weight: 600;">{{ strtoupper($armada->status) }}</span>
                </p>
            @else
                <p style="color: #999; font-size: 1rem; font-weight: 500; margin: 0.5rem 0 0 0;">
                    Belum ada armada terhubung.
                </p>
            @endif
        </div>
    </div>

    <!-- Active Tasks / Order List -->
    <div class="card" style="margin-bottom: 2rem;">
        <h2 style="font-size: 1.1rem; font-weight: 600; color: #111; margin: 0 0 1.5rem 0;">Tugas Perjalanan Aktif</h2>

        @php
            $hasActiveJobs = $activeTravels->count() > 0 || $activeRentals->count() > 0;
        @endphp

        @if($hasActiveJobs)
            <div style="display: grid; grid-template-columns: 1fr; gap: 1.5rem;">
                <!-- Active Travel Bookings -->
                @foreach($activeTravels as $booking)
                    <div style="border: 1px solid #e5e7eb; border-radius: 0.5rem; padding: 1.5rem; background: #f8fafc;">
                        <div style="display: flex; justify-content: space-between; align-items: start; flex-wrap: wrap; gap: 0.5rem; border-bottom: 1px dashed #e5e7eb; padding-bottom: 1rem; margin-bottom: 1rem;">
                            <div>
                                <span style="display: inline-block; background: #dbeafe; color: #2563eb; padding: 0.25rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 600; text-transform: uppercase;">Travel Shuttle</span>
                                <h3 style="margin: 0.25rem 0 0 0; font-size: 1.1rem; font-weight: 700;">Kode: {{ $booking->booking_code }}</h3>
                            </div>
                            <div style="text-align: right;">
                                <div style="font-size: 0.8rem; color: #666;">Status Perjalanan</div>
                                <span style="display: inline-block; background: #fed7aa; color: #d97706; padding: 0.25rem 0.5rem; border-radius: 0.25rem; font-size: 0.8rem; font-weight: 600;">
                                    {{ $booking->status === 'departed' ? 'Sedang Jalan' : 'Menunggu Berangkat' }}
                                </span>
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
                            <div>
                                <div style="font-size: 0.8rem; color: #666;">Rute Perjalanan</div>
                                <div style="font-weight: 600; color: #111;">{{ $booking->route ? $booking->route->name : 'N/A' }}</div>
                            </div>
                            <div>
                                <div style="font-size: 0.8rem; color: #666;">Jadwal Penjemputan</div>
                                <div style="font-weight: 600; color: #111;">
                                    {{ $booking->scheduled_date ? $booking->scheduled_date->format('d M Y') : '-' }} 
                                    ({{ $booking->departure_time ? $booking->departure_time->format('H:i') : '-' }})
                                </div>
                            </div>
                            <div>
                                <div style="font-size: 0.8rem; color: #666;">Detail Penumpang</div>
                                <div style="font-weight: 600; color: #111;">{{ $booking->user ? $booking->user->name : 'Customer' }}</div>
                                <div style="font-size: 0.8rem; color: #666;">{{ $booking->number_of_seats }} Kursi</div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div style="display: flex; gap: 1rem;">
                            @if($booking->status === 'confirmed')
                                <form action="{{ route('driver.trip.start', [$booking->id, 'travel']) }}" method="POST" style="margin: 0; width: 100%;">
                                    @csrf
                                    <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 0.75rem;">
                                        Mulai Perjalanan (Depart)
                                    </button>
                                </form>
                            @elseif($booking->status === 'departed')
                                <form action="{{ route('driver.trip.complete', [$booking->id, 'travel']) }}" method="POST" style="margin: 0; width: 100%;">
                                    @csrf
                                    <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; background: #059669; padding: 0.75rem;">
                                        Selesaikan Perjalanan & Tambah Saldo
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach

                <!-- Active Rental Bookings -->
                @foreach($activeRentals as $booking)
                    <div style="border: 1px solid #e5e7eb; border-radius: 0.5rem; padding: 1.5rem; background: #f0fdf4;">
                        <div style="display: flex; justify-content: space-between; align-items: start; flex-wrap: wrap; gap: 0.5rem; border-bottom: 1px dashed #e5e7eb; padding-bottom: 1rem; margin-bottom: 1rem;">
                            <div>
                                <span style="display: inline-block; background: #d1fae5; color: #059669; padding: 0.25rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 600; text-transform: uppercase;">Rental Mobil</span>
                                <h3 style="margin: 0.25rem 0 0 0; font-size: 1.1rem; font-weight: 700;">Kode: {{ $booking->booking_code }}</h3>
                            </div>
                            <div style="text-align: right;">
                                <div style="font-size: 0.8rem; color: #666;">Status Perjalanan</div>
                                <span style="display: inline-block; background: #fed7aa; color: #d97706; padding: 0.25rem 0.5rem; border-radius: 0.25rem; font-size: 0.8rem; font-weight: 600;">
                                    {{ $booking->status === 'active' ? 'Sedang Jalan' : 'Menunggu Berangkat' }}
                                </span>
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
                            <div>
                                <div style="font-size: 0.8rem; color: #666;">Kota/Rute Sewa</div>
                                <div style="font-weight: 600; color: #111;">{{ $booking->route ? $booking->route->name : 'N/A' }}</div>
                            </div>
                            <div>
                                <div style="font-size: 0.8rem; color: #666;">Tanggal Sewa</div>
                                <div style="font-weight: 600; color: #111;">
                                    {{ $booking->start_date ? $booking->start_date->format('d M Y') : '-' }} 
                                </div>
                            </div>
                            <div>
                                <div style="font-size: 0.8rem; color: #666;">Detail Pelanggan</div>
                                <div style="font-weight: 600; color: #111;">{{ $booking->user ? $booking->user->name : 'Customer' }}</div>
                                <div style="font-size: 0.8rem; color: #666;">Biaya Driver: Rp {{ number_format($booking->driver_fee, 0, ',', '.') }}</div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div style="display: flex; gap: 1rem;">
                            @if($booking->status === 'confirmed')
                                <form action="{{ route('driver.trip.start', [$booking->id, 'rental']) }}" method="POST" style="margin: 0; width: 100%;">
                                    @csrf
                                    <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 0.75rem;">
                                        Mulai Perjalanan (Start Trip)
                                    </button>
                                </form>
                            @elseif($booking->status === 'active')
                                <form action="{{ route('driver.trip.complete', [$booking->id, 'rental']) }}" method="POST" style="margin: 0; width: 100%;">
                                    @csrf
                                    <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; background: #059669; padding: 0.75rem;">
                                        Selesaikan Perjalanan & Tambah Saldo
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div style="text-align: center; padding: 3rem; color: #666;">
                <svg style="width: 3rem; height: 3rem; color: #d1d5db; margin-bottom: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <p style="margin: 0;">Tidak ada tugas perjalanan aktif yang ditugaskan ke armada Anda saat ini.</p>
            </div>
        @endif
    </div>
@endsection
