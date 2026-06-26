@extends('layouts.app')

@section('title', 'Dashboard Customer')

@section('content')
    @unless(auth()->user()->hasVerifiedEmail())
        <div style="background: #fffbeb; border: 1px solid #fde68a; border-radius: 0.5rem; padding: 1rem 1.25rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
            <svg style="width: 1.25rem; height: 1.25rem; color: #f59e0b; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
            </svg>
            <div style="flex: 1;">
                <p style="margin: 0; font-size: 0.9rem; color: #92400e; font-weight: 500;">
                    Email Anda belum terverifikasi. Silakan verifikasi email untuk dapat melakukan pemesanan.
                    <a href="{{ route('verification.notice') }}" style="color: #0064d2; font-weight: 600; text-decoration: underline;">Verifikasi Sekarang</a>
                </p>
            </div>
        </div>
    @endunless

    <div class="page-header">
        <h1 class="page-title">Dashboard Pelanggan</h1>
        <p class="page-subtitle">Selamat datang kembali, {{ auth()->user()->name }}! Cari travel atau rental mobil Anda.</p>
    </div>

    <!-- Quick Action Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        <a href="/bookings/travel" style="text-decoration: none; color: inherit;">
            <div class="card" style="border-top: 4px solid #2563eb; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
                <h3 style="margin: 0; font-size: 1.1rem; font-weight: 600;">Pesan Tiket Travel</h3>
                <p style="color: #666; font-size: 0.85rem; margin: 0.5rem 0 1rem 0;">Perjalanan antar kota praktis dan terjadwal di Flores.</p>
                <span style="color: #2563eb; font-weight: 600; font-size: 0.9rem;">Pesan Sekarang &rarr;</span>
            </div>
        </a>
        <a href="/bookings/rental" style="text-decoration: none; color: inherit;">
            <div class="card" style="border-top: 4px solid #10b981; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
                <h3 style="margin: 0; font-size: 1.1rem; font-weight: 600;">Rental Mobil</h3>
                <p style="color: #666; font-size: 0.85rem; margin: 0.5rem 0 1rem 0;">Sewa mobil lepas kunci atau dengan driver untuk grup Anda.</p>
                <span style="color: #10b981; font-weight: 600; font-size: 0.9rem;">Sewa Sekarang &rarr;</span>
            </div>
        </a>
        <a href="/bookings/airport-transfer" style="text-decoration: none; color: inherit;">
            <div class="card" style="border-top: 4px solid #f59e0b; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
                <h3 style="margin: 0; font-size: 1.1rem; font-weight: 600;">Airport Transfer</h3>
                <p style="color: #666; font-size: 0.85rem; margin: 0.5rem 0 1rem 0;">Penjemputan langsung dari bandara Flores ke penginapan Anda.</p>
                <span style="color: #f59e0b; font-weight: 600; font-size: 0.9rem;">Pesan Sekarang &rarr;</span>
            </div>
        </a>
    </div>

    <!-- Stats Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        <!-- Total Bookings -->
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <p style="color: #666; font-size: 0.9rem; margin: 0;">Total Pemesanan Anda</p>
                    <p style="color: #2563eb; font-size: 2rem; font-weight: 700; margin: 0.5rem 0 0 0;">{{ $totalBookings ?? 0 }}</p>
                </div>
                <svg style="width: 2.5rem; height: 2.5rem; color: #dbeafe;" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

        <!-- Pending Bookings -->
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <p style="color: #666; font-size: 0.9rem; margin: 0;">Menunggu Pembayaran</p>
                    <p style="color: #f59e0b; font-size: 2rem; font-weight: 700; margin: 0.5rem 0 0 0;">{{ $pendingBookings ?? 0 }}</p>
                </div>
                <svg style="width: 2.5rem; height: 2.5rem; color: #fed7aa;" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

        <!-- Completed Bookings -->
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <p style="color: #666; font-size: 0.9rem; margin: 0;">Perjalanan Selesai</p>
                    <p style="color: #10b981; font-size: 2rem; font-weight: 700; margin: 0.5rem 0 0 0;">{{ $completedBookings ?? 0 }}</p>
                </div>
                <svg style="width: 2.5rem; height: 2.5rem; color: #d1fae5;" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

        <!-- Total Transactions -->
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <p style="color: #666; font-size: 0.9rem; margin: 0;">Total Pengeluaran</p>
                    <p style="color: #059669; font-size: 1.5rem; font-weight: 700; margin: 0.5rem 0 0 0;">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</p>
                </div>
                <svg style="width: 2.5rem; height: 2.5rem; color: #c6f6d5;" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Recent Activity Section -->
    <div style="margin-top: 2rem;">
        <div class="card">
            <h2 style="font-size: 1.1rem; font-weight: 600; color: #111; margin: 0 0 1rem 0;">Riwayat Perjalanan Terbaru</h2>
            @if(isset($recentBookings) && $recentBookings->count() > 0)
                <div style="overflow-x: auto;">
                    <table style="width: 100%; font-size: 0.9rem; border-collapse: collapse;">
                        <thead>
                            <tr style="border-bottom: 1px solid #e5e7eb; text-align: left;">
                                <th style="padding: 0.75rem; color: #666; font-weight: 500;">Kode Booking</th>
                                <th style="padding: 0.75rem; color: #666; font-weight: 500;">Rute</th>
                                <th style="padding: 0.75rem; color: #666; font-weight: 500;">Jadwal Keberangkatan</th>
                                <th style="padding: 0.75rem; color: #666; font-weight: 500;">Kursi</th>
                                <th style="padding: 0.75rem; color: #666; font-weight: 500;">Total Harga</th>
                                <th style="padding: 0.75rem; color: #666; font-weight: 500;">Status</th>
                                <th style="padding: 0.75rem; color: #666; font-weight: 500;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentBookings as $booking)
                                <tr style="border-bottom: 1px solid #f3f4f6;">
                                    <td style="padding: 0.75rem; font-weight: 600; color: #111;">{{ $booking->booking_code }}</td>
                                    <td style="padding: 0.75rem; color: #333;">{{ $booking->route ? $booking->route->name : 'N/A' }}</td>
                                    <td style="padding: 0.75rem; color: #666;">
                                        {{ $booking->scheduled_date ? $booking->scheduled_date->format('d M Y') : '-' }} 
                                        ({{ $booking->departure_time ? $booking->departure_time->format('H:i') : '-' }})
                                    </td>
                                    <td style="padding: 0.75rem; color: #666;">{{ $booking->number_of_seats }} Kursi</td>
                                    <td style="padding: 0.75rem; color: #111; font-weight: 500;">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                    <td style="padding: 0.75rem;">
                                        @if($booking->status === 'completed')
                                            <span style="display: inline-block; background: #d1fae5; color: #059669; padding: 0.25rem 0.75rem; border-radius: 0.25rem; font-size: 0.8rem; font-weight: 500;">Selesai</span>
                                        @elseif($booking->status === 'pending')
                                            <span style="display: inline-block; background: #fef3c7; color: #d97706; padding: 0.25rem 0.75rem; border-radius: 0.25rem; font-size: 0.8rem; font-weight: 500;">Menunggu</span>
                                        @elseif($booking->status === 'confirmed')
                                            <span style="display: inline-block; background: #dbeafe; color: #2563eb; padding: 0.25rem 0.75rem; border-radius: 0.25rem; font-size: 0.8rem; font-weight: 500;">Dikonfirmasi</span>
                                        @else
                                            <span style="display: inline-block; background: #f3f4f6; color: #666; padding: 0.25rem 0.75rem; border-radius: 0.25rem; font-size: 0.8rem; font-weight: 500;">{{ $booking->status }}</span>
                                        @endif
                                    </td>
                                    <td style="padding: 0.75rem;">
                                        <a href="{{ route('bookings.travel.show', $booking->id) }}" style="color: #2563eb; text-decoration: none; font-weight: 600;">Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div style="text-align: center; padding: 2rem; color: #666;">
                    <p style="margin: 0 0 1rem 0;">Anda belum memiliki riwayat pemesanan travel.</p>
                    <a href="/bookings/travel/create" class="btn btn-primary">Pesan Travel Pertama Anda</a>
                </div>
            @endif
        </div>
    </div>
@endsection
