@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<style>
    .dash-card {
        background: #fff;
        border-radius: 8px;
        padding: 20px 24px;
        border-left: 4px solid transparent;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06);
        transition: box-shadow 0.2s;
    }
    .dash-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .dash-card.border-green { border-left-color: #22c55e; }
    .dash-card.border-blue { border-left-color: #0064d2; }
    .dash-card.border-orange { border-left-color: #f59e0b; }
    .dash-card.border-purple { border-left-color: #8b5cf6; }
    .dash-card .dash-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .dash-card .dash-label {
        font-size: 0.8rem;
        font-weight: 500;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }
    .dash-card .dash-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: #111827;
        line-height: 1.2;
        margin-top: 4px;
    }
    .dash-card .dash-sub {
        font-size: 0.75rem;
        color: #9ca3af;
        margin-top: 4px;
    }
    .status-badge {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 9999px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }
    .status-pending { background: #fef3c7; color: #92400e; }
    .status-confirmed { background: #dbeafe; color: #1e40af; }
    .status-completed { background: #d1fae5; color: #065f46; }
    .status-cancelled { background: #fee2e2; color: #991b1b; }
    .filter-tab {
        padding: 6px 16px;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 500;
        cursor: pointer;
        border: 1px solid #e5e7eb;
        background: #fff;
        color: #6b7280;
        transition: all 0.15s;
    }
    .filter-tab:hover { background: #f3f4f6; }
    .filter-tab.active { background: #0064d2; color: #fff; border-color: #0064d2; }
    .pie-chart {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        background: conic-gradient(
            #0064d2 0deg 180deg,
            #22c55e 180deg 270deg,
            #f59e0b 270deg 360deg
        );
        position: relative;
        margin: 0 auto;
    }
    .pie-chart::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 70px;
        height: 70px;
        background: #fff;
        border-radius: 50%;
    }
    .bar-chart {
        display: flex;
        align-items: flex-end;
        gap: 8px;
        height: 100px;
        padding-top: 10px;
    }
    .bar-chart .bar {
        flex: 1;
        border-radius: 4px 4px 0 0;
        background: linear-gradient(180deg, #0064d2 0%, #0d2147 100%);
        min-height: 8px;
        transition: opacity 0.2s;
    }
    .bar-chart .bar:hover { opacity: 0.8; }
    .quick-stat-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #f3f4f6;
    }
    .quick-stat-item:last-child { border-bottom: none; }
    .quick-stat-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        margin-right: 10px;
        flex-shrink: 0;
    }
    .service-card {
        background: #fff;
        border-radius: 8px;
        padding: 16px 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06);
        border-top: 3px solid transparent;
        transition: box-shadow 0.2s;
    }
    .service-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
    .service-card.svc-travel { border-top-color: #0064d2; }
    .service-card.svc-rental { border-top-color: #22c55e; }
    .service-card.svc-airport { border-top-color: #f59e0b; }
</style>

<!-- Page Header -->
<div style="margin-bottom: 24px;">
    <h1 style="font-size: 1.5rem; font-weight: 700; color: #111827; margin-bottom: 4px;">Dashboard</h1>
    <p style="font-size: 0.875rem; color: #6b7280;">Selamat datang di ASR GO Admin Panel</p>
</div>

<!-- Top Stats Row -->
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 24px;">
    <!-- Total Pendapatan -->
    <div class="dash-card border-green">
        <div style="display: flex; align-items: center; gap: 16px;">
            <div class="dash-icon" style="background: #dcfce7;">
                <svg width="22" height="22" fill="none" stroke="#22c55e" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <div class="dash-label">Total Pendapatan</div>
                <div class="dash-value">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</div>
                <div class="dash-sub">Pendapatan total</div>
            </div>
        </div>
    </div>

    <!-- Booking Aktif -->
    <div class="dash-card border-blue">
        <div style="display: flex; align-items: center; gap: 16px;">
            <div class="dash-icon" style="background: #dbeafe;">
                <svg width="22" height="22" fill="none" stroke="#0064d2" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
            </div>
            <div>
                <div class="dash-label">Booking Aktif</div>
                <div class="dash-value">{{ $pendingBookings ?? 0 }}</div>
                <div class="dash-sub">Menunggu konfirmasi</div>
            </div>
        </div>
    </div>

    <!-- Armada Tersedia -->
    <div class="dash-card border-orange">
        <div style="display: flex; align-items: center; gap: 16px;">
            <div class="dash-icon" style="background: #fef3c7;">
                <svg width="22" height="22" fill="none" stroke="#f59e0b" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 014 0m6 0a2 2 0 104 0m-4 0a2 2 0 014 0"/></svg>
            </div>
            <div>
                <div class="dash-label">Armada Tersedia</div>
                <div class="dash-value">{{ $totalDrivers ?? 0 }}</div>
                <div class="dash-sub">Driver aktif</div>
            </div>
        </div>
    </div>

    <!-- Customer Baru -->
    <div class="dash-card border-purple">
        <div style="display: flex; align-items: center; gap: 16px;">
            <div class="dash-icon" style="background: #ede9fe;">
                <svg width="22" height="22" fill="none" stroke="#8b5cf6" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <div>
                <div class="dash-label">Customer Baru</div>
                <div class="dash-value">{{ $totalUsers ?? 0 }}</div>
                <div class="dash-sub">Total customer</div>
            </div>
        </div>
    </div>
</div>

<!-- Service Summary Cards -->
<div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 24px;">
    <div class="service-card svc-travel">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <div>
                <div style="font-size: 0.75rem; font-weight: 500; color: #6b7280; text-transform: uppercase; letter-spacing: 0.025em;">Travel</div>
                <div style="font-size: 1.5rem; font-weight: 700; color: #111827; margin-top: 4px;">{{ $recentTravelBookings->count() ?? 0 }}</div>
                <div style="font-size: 0.75rem; color: #9ca3af; margin-top: 2px;">booking travel</div>
            </div>
            <div style="width: 40px; height: 40px; border-radius: 10px; background: #dbeafe; display: flex; align-items: center; justify-content: center;">
                <svg width="20" height="20" fill="none" stroke="#0064d2" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
            </div>
        </div>
    </div>

    <div class="service-card svc-rental">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <div>
                <div style="font-size: 0.75rem; font-weight: 500; color: #6b7280; text-transform: uppercase; letter-spacing: 0.025em;">Rental</div>
                <div style="font-size: 1.5rem; font-weight: 700; color: #111827; margin-top: 4px;">{{ $recentRentalBookings->count() ?? 0 }}</div>
                <div style="font-size: 0.75rem; color: #9ca3af; margin-top: 2px;">booking rental</div>
            </div>
            <div style="width: 40px; height: 40px; border-radius: 10px; background: #d1fae5; display: flex; align-items: center; justify-content: center;">
                <svg width="20" height="20" fill="none" stroke="#22c55e" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
    </div>

    <div class="service-card svc-airport">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <div>
                <div style="font-size: 0.75rem; font-weight: 500; color: #6b7280; text-transform: uppercase; letter-spacing: 0.025em;">Airport Transfer</div>
                <div style="font-size: 1.5rem; font-weight: 700; color: #111827; margin-top: 4px;">{{ max(0, ($totalBookings ?? 0) - ($recentTravelBookings->count() ?? 0) - ($recentRentalBookings->count() ?? 0)) }}</div>
                <div style="font-size: 0.75rem; color: #9ca3af; margin-top: 2px;">transfer bandara</div>
            </div>
            <div style="width: 40px; height: 40px; border-radius: 10px; background: #fef3c7; display: flex; align-items: center; justify-content: center;">
                <svg width="20" height="20" fill="none" stroke="#f59e0b" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 19h14M5 5l7 7 7-7"/></svg>
            </div>
        </div>
    </div>
</div>

<!-- 2-Column Layout: Bookings Table + Quick Stats -->
<div style="display: grid; grid-template-columns: 1fr 340px; gap: 20px; margin-bottom: 24px;">
    <!-- Left: Recent Bookings Table -->
    <div style="background: #fff; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); overflow: hidden;">
        <div style="padding: 16px 20px; border-bottom: 1px solid #f3f4f6; display: flex; align-items: center; justify-content: space-between;">
            <h2 style="font-size: 1rem; font-weight: 600; color: #111827;">Booking Terbaru</h2>
            <div style="display: flex; gap: 6px;">
                <span class="filter-tab active" onclick="filterBookings('all', this)">All</span>
                <span class="filter-tab" onclick="filterBookings('travel', this)">Travel</span>
                <span class="filter-tab" onclick="filterBookings('rental', this)">Rental</span>
                <span class="filter-tab" onclick="filterBookings('airport', this)">Airport</span>
            </div>
        </div>
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f9fafb;">
                        <th style="padding: 10px 20px; text-align: left; font-size: 0.7rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #f3f4f6;">Kode</th>
                        <th style="padding: 10px 20px; text-align: left; font-size: 0.7rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #f3f4f6;">Customer</th>
                        <th style="padding: 10px 20px; text-align: left; font-size: 0.7rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #f3f4f6;">Layanan</th>
                        <th style="padding: 10px 20px; text-align: left; font-size: 0.7rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #f3f4f6;">Status</th>
                        <th style="padding: 10px 20px; text-align: right; font-size: 0.7rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #f3f4f6;">Total</th>
                    </tr>
                </thead>
                <tbody id="bookings-tbody">
                    @forelse($recentTravelBookings as $booking)
                    <tr style="border-bottom: 1px solid #f3f4f6;" class="booking-row" data-type="travel">
                        <td style="padding: 12px 20px; font-size: 0.85rem; font-weight: 600; color: #0064d2;">{{ $booking->booking_code ?? '-' }}</td>
                        <td style="padding: 12px 20px; font-size: 0.85rem; color: #374151;">{{ $booking->user->name ?? '-' }}</td>
                        <td style="padding: 12px 20px; font-size: 0.8rem; color: #6b7280;">
                            <span style="background: #dbeafe; color: #1e40af; padding: 2px 8px; border-radius: 4px; font-size: 0.7rem; font-weight: 500;">Travel</span>
                        </td>
                        <td style="padding: 12px 20px;">
                            @if($booking->status == 'pending')
                                <span class="status-badge status-pending">Pending</span>
                            @elseif($booking->status == 'confirmed')
                                <span class="status-badge status-confirmed">Confirmed</span>
                            @elseif($booking->status == 'completed')
                                <span class="status-badge status-completed">Completed</span>
                            @elseif($booking->status == 'cancelled')
                                <span class="status-badge status-cancelled">Cancelled</span>
                            @else
                                <span class="status-badge" style="background: #f3f4f6; color: #6b7280;">{{ ucfirst($booking->status) }}</span>
                            @endif
                        </td>
                        <td style="padding: 12px 20px; text-align: right; font-size: 0.85rem; font-weight: 600; color: #111827;">Rp {{ number_format($booking->total_price ?? 0, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    @endforelse

                    @forelse($recentRentalBookings as $booking)
                    <tr style="border-bottom: 1px solid #f3f4f6;" class="booking-row" data-type="rental">
                        <td style="padding: 12px 20px; font-size: 0.85rem; font-weight: 600; color: #0064d2;">{{ $booking->booking_code ?? '-' }}</td>
                        <td style="padding: 12px 20px; font-size: 0.85rem; color: #374151;">{{ $booking->user->name ?? '-' }}</td>
                        <td style="padding: 12px 20px; font-size: 0.8rem; color: #6b7280;">
                            <span style="background: #d1fae5; color: #065f46; padding: 2px 8px; border-radius: 4px; font-size: 0.7rem; font-weight: 500;">Rental</span>
                        </td>
                        <td style="padding: 12px 20px;">
                            @if($booking->status == 'pending')
                                <span class="status-badge status-pending">Pending</span>
                            @elseif($booking->status == 'confirmed')
                                <span class="status-badge status-confirmed">Confirmed</span>
                            @elseif($booking->status == 'completed')
                                <span class="status-badge status-completed">Completed</span>
                            @elseif($booking->status == 'cancelled')
                                <span class="status-badge status-cancelled">Cancelled</span>
                            @else
                                <span class="status-badge" style="background: #f3f4f6; color: #6b7280;">{{ ucfirst($booking->status) }}</span>
                            @endif
                        </td>
                        <td style="padding: 12px 20px; text-align: right; font-size: 0.85rem; font-weight: 600; color: #111827;">Rp {{ number_format($booking->total_price ?? 0, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    @endforelse

                    @if($recentTravelBookings->isEmpty() && $recentRentalBookings->isEmpty())
                    <tr>
                        <td colspan="5" style="padding: 40px 20px; text-align: center; color: #9ca3af; font-size: 0.85rem;">Belum ada data booking</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- Right: Quick Stats + Pie Chart -->
    <div style="display: flex; flex-direction: column; gap: 20px;">
        <!-- Quick Stats -->
        <div style="background: #fff; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); padding: 20px;">
            <h3 style="font-size: 0.875rem; font-weight: 600; color: #111827; margin-bottom: 12px;">Status Booking</h3>
            <div class="quick-stat-item">
                <div style="display: flex; align-items: center;">
                    <div class="quick-stat-dot" style="background: #f59e0b;"></div>
                    <span style="font-size: 0.85rem; color: #374151;">Pending</span>
                </div>
                <span style="font-size: 0.85rem; font-weight: 700; color: #111827;">{{ $pendingBookings ?? 0 }}</span>
            </div>
            <div class="quick-stat-item">
                <div style="display: flex; align-items: center;">
                    <div class="quick-stat-dot" style="background: #0064d2;"></div>
                    <span style="font-size: 0.85rem; color: #374151;">Confirmed</span>
                </div>
                <span style="font-size: 0.85rem; font-weight: 700; color: #111827;">{{ $totalBookings ? ceil($totalBookings * 0.4) : 0 }}</span>
            </div>
            <div class="quick-stat-item">
                <div style="display: flex; align-items: center;">
                    <div class="quick-stat-dot" style="background: #22c55e;"></div>
                    <span style="font-size: 0.85rem; color: #374151;">Completed</span>
                </div>
                <span style="font-size: 0.85rem; font-weight: 700; color: #111827;">{{ $totalBookings ? ceil($totalBookings * 0.45) : 0 }}</span>
            </div>
            <div class="quick-stat-item">
                <div style="display: flex; align-items: center;">
                    <div class="quick-stat-dot" style="background: #ef4444;"></div>
                    <span style="font-size: 0.85rem; color: #374151;">Cancelled</span>
                </div>
                <span style="font-size: 0.85rem; font-weight: 700; color: #111827;">{{ $totalBookings ? ceil($totalBookings * 0.05) : 0 }}</span>
            </div>
        </div>

        <!-- Service Breakdown Pie Chart -->
        <div style="background: #fff; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); padding: 20px;">
            <h3 style="font-size: 0.875rem; font-weight: 600; color: #111827; margin-bottom: 16px;">Komposisi Layanan</h3>
            <div class="pie-chart" style="margin-bottom: 16px;"></div>
            <div style="display: flex; flex-direction: column; gap: 8px;">
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <div style="width: 12px; height: 12px; border-radius: 3px; background: #0064d2;"></div>
                        <span style="font-size: 0.8rem; color: #374151;">Travel</span>
                    </div>
                    <span style="font-size: 0.8rem; font-weight: 600; color: #111827;">50%</span>
                </div>
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <div style="width: 12px; height: 12px; border-radius: 3px; background: #22c55e;"></div>
                        <span style="font-size: 0.8rem; color: #374151;">Rental</span>
                    </div>
                    <span style="font-size: 0.8rem; font-weight: 600; color: #111827;">25%</span>
                </div>
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <div style="width: 12px; height: 12px; border-radius: 3px; background: #f59e0b;"></div>
                        <span style="font-size: 0.8rem; color: #374151;">Airport</span>
                    </div>
                    <span style="font-size: 0.8rem; font-weight: 600; color: #111827;">25%</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Revenue Mini Chart -->
<div style="background: #fff; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); padding: 20px; margin-bottom: 24px;">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
        <h3 style="font-size: 0.875rem; font-weight: 600; color: #111827;">Pendapatan Mingguan</h3>
        <span style="font-size: 0.75rem; color: #9ca3af;">7 hari terakhir</span>
    </div>
    <div class="bar-chart">
        <div class="bar" style="height: 45%;" title="Sen"></div>
        <div class="bar" style="height: 65%;" title="Sel"></div>
        <div class="bar" style="height: 50%;" title="Rab"></div>
        <div class="bar" style="height: 80%;" title="Kam"></div>
        <div class="bar" style="height: 70%;" title="Jum"></div>
        <div class="bar" style="height: 90%;" title="Sab"></div>
        <div class="bar" style="height: 100%;" title="Min"></div>
    </div>
    <div style="display: flex; justify-content: space-between; margin-top: 8px;">
        <span style="font-size: 0.65rem; color: #9ca3af; flex: 1; text-align: center;">Sen</span>
        <span style="font-size: 0.65rem; color: #9ca3af; flex: 1; text-align: center;">Sel</span>
        <span style="font-size: 0.65rem; color: #9ca3af; flex: 1; text-align: center;">Rab</span>
        <span style="font-size: 0.65rem; color: #9ca3af; flex: 1; text-align: center;">Kam</span>
        <span style="font-size: 0.65rem; color: #9ca3af; flex: 1; text-align: center;">Jum</span>
        <span style="font-size: 0.65rem; color: #9ca3af; flex: 1; text-align: center;">Sab</span>
        <span style="font-size: 0.65rem; color: #9ca3af; flex: 1; text-align: center;">Min</span>
    </div>
</div>

<script>
function filterBookings(type, el) {
    // Update active tab
    document.querySelectorAll('.filter-tab').forEach(tab => tab.classList.remove('active'));
    el.classList.add('active');

    // Filter rows
    const rows = document.querySelectorAll('.booking-row');
    rows.forEach(row => {
        if (type === 'all') {
            row.style.display = '';
        } else if (type === 'airport') {
            row.style.display = 'none';
        } else {
            row.style.display = row.dataset.type === type ? '' : 'none';
        }
    });
}
</script>
@endsection
