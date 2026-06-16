@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Dashboard</h1>
        <p class="page-subtitle">Selamat datang kembali!</p>
    </div>

    <!-- Stats Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        <!-- Total Bookings -->
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <p style="color: #666; font-size: 0.9rem; margin: 0;">Total Pemesanan</p>
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
                    <p style="color: #666; font-size: 0.9rem; margin: 0;">Menunggu Persetujuan</p>
                    <p style="color: #f59e0b; font-size: 2rem; font-weight: 700; margin: 0.5rem 0 0 0;">{{ $pendingBookings ?? 0 }}</p>
                </div>
                <svg style="width: 2.5rem; height: 2.5rem; color: #fed7aa;" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

        <!-- Active Routes -->
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <p style="color: #666; font-size: 0.9rem; margin: 0;">Rute Aktif</p>
                    <p style="color: #10b981; font-size: 2rem; font-weight: 700; margin: 0.5rem 0 0 0;">{{ $activeRoutes ?? 0 }}</p>
                </div>
                <svg style="width: 2.5rem; height: 2.5rem; color: #d1fae5;" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <p style="color: #666; font-size: 0.9rem; margin: 0;">Total Pendapatan</p>
                    <p style="color: #059669; font-size: 1.5rem; font-weight: 700; margin: 0.5rem 0 0 0;">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</p>
                </div>
                <svg style="width: 2.5rem; height: 2.5rem; color: #c6f6d5;" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Recent Activity Section -->
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
        <!-- Recent Bookings -->
        <div class="card">
            <h2 style="font-size: 1.1rem; font-weight: 600; color: #111; margin: 0 0 1rem 0;">Pemesanan Terbaru</h2>
            <div style="overflow-x: auto;">
                <table style="width: 100%; font-size: 0.9rem;">
                    <thead>
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <th style="text-align: left; padding: 0.5rem 0; color: #666; font-weight: 500;">ID</th>
                            <th style="text-align: left; padding: 0.5rem 0; color: #666; font-weight: 500;">Tipe</th>
                            <th style="text-align: left; padding: 0.5rem 0; color: #666; font-weight: 500;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="border-bottom: 1px solid #f3f4f6;">
                            <td style="padding: 0.75rem 0; color: #111;">#BK001</td>
                            <td style="padding: 0.75rem 0; color: #666;">Travel</td>
                            <td style="padding: 0.75rem 0;"><span style="display: inline-block; background: #dbeafe; color: #2563eb; padding: 0.25rem 0.75rem; border-radius: 0.25rem; font-size: 0.85rem;">Aktif</span></td>
                        </tr>
                        <tr style="border-bottom: 1px solid #f3f4f6;">
                            <td style="padding: 0.75rem 0; color: #111;">#BK002</td>
                            <td style="padding: 0.75rem 0; color: #666;">Rental</td>
                            <td style="padding: 0.75rem 0;"><span style="display: inline-block; background: #fef3c7; color: #b45309; padding: 0.25rem 0.75rem; border-radius: 0.25rem; font-size: 0.85rem;">Menunggu</span></td>
                        </tr>
                        <tr>
                            <td style="padding: 0.75rem 0; color: #111;">#BK003</td>
                            <td style="padding: 0.75rem 0; color: #666;">Travel</td>
                            <td style="padding: 0.75rem 0;"><span style="display: inline-block; background: #d1fae5; color: #059669; padding: 0.25rem 0.75rem; border-radius: 0.25rem; font-size: 0.85rem;">Selesai</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <p style="text-align: center; margin: 1rem 0 0 0;"><a href="#" style="color: #2563eb; text-decoration: none; font-weight: 500;">Lihat semua →</a></p>
        </div>

        <!-- Quick Stats -->
        <div class="card">
            <h2 style="font-size: 1.1rem; font-weight: 600; color: #111; margin: 0 0 1rem 0;">Statistik</h2>
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="color: #666; font-size: 0.9rem;">Pengemudi Aktif</span>
                    <span style="font-weight: 600; color: #111;">{{ $activeDrivers ?? 0 }}</span>
                </div>
                <div style="border-top: 1px solid #e5e7eb; padding-top: 1rem;">
                    <span style="color: #666; font-size: 0.9rem;">Kendaraan Aktif</span>
                    <p style="font-weight: 600; color: #111; margin: 0.25rem 0 0 0;">{{ $activeVehicles ?? 0 }}</p>
                </div>
                <div style="border-top: 1px solid #e5e7eb; padding-top: 1rem;">
                    <span style="color: #666; font-size: 0.9rem;">Rute Tersedia</span>
                    <p style="font-weight: 600; color: #111; margin: 0.25rem 0 0 0;">{{ $totalRoutes ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
