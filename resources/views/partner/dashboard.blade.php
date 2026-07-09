@extends('layouts.app')

@section('title', __('partner.dashboard_title'))

@section('content')
<style>
    .dashboard-container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 24px;
    }
    .dashboard-header {
        margin-bottom: 28px;
    }
    .dashboard-header h1 {
        font-size: 26px;
        font-weight: 700;
        color: #111827;
        margin: 0;
    }
    .dashboard-header p {
        color: #6b7280;
        margin: 4px 0 0;
        font-size: 14px;
    }
    .stats-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 28px;
    }
    .stat-card {
        background: #fff;
        border-radius: 12px;
        padding: 22px 24px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        display: flex;
        align-items: center;
        gap: 16px;
        transition: box-shadow 0.2s ease, transform 0.2s ease;
    }
    .stat-card:hover {
        box-shadow: 0 6px 16px rgba(0,0,0,0.08);
        transform: translateY(-2px);
    }
    .stat-indicator {
        width: 4px;
        height: 48px;
        border-radius: 4px;
        flex-shrink: 0;
    }
    .stat-indicator.blue { background: #0064d2; }
    .stat-indicator.green { background: #22c55e; }
    .stat-indicator.orange { background: #f59e0b; }
    .stat-indicator.purple { background: #8b5cf6; }
    .stat-details .stat-label {
        font-size: 12px;
        font-weight: 500;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
    }
    .stat-details .stat-value {
        font-size: 26px;
        font-weight: 700;
        color: #111827;
        line-height: 1.2;
    }
    .service-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 28px;
    }
    .service-card {
        background: #fff;
        border-radius: 12px;
        padding: 20px 24px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: box-shadow 0.2s ease;
    }
    .service-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.07);
    }
    .service-info h3 {
        font-size: 13px;
        font-weight: 600;
        color: #6b7280;
        margin: 0 0 4px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    .service-info .service-count {
        font-size: 28px;
        font-weight: 700;
        color: #111827;
    }
    .service-badge {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .service-badge.travel { background: #eff6ff; }
    .service-badge.rental { background: #f0fdf4; }
    .service-badge.airport { background: #fefce8; }
    .main-content {
        display: grid;
        grid-template-columns: 60% 40%;
        gap: 24px;
        margin-bottom: 32px;
    }
    .panel-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }
    .panel-header {
        padding: 18px 22px;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .panel-header h2 {
        font-size: 15px;
        font-weight: 600;
        color: #111827;
        margin: 0;
    }
    .panel-body {
        padding: 0;
    }
    .panel-body.padded {
        padding: 20px 22px;
    }
    .data-table {
        width: 100%;
        border-collapse: collapse;
    }
    .data-table thead th {
        background: #f9fafb;
        padding: 10px 14px;
        font-size: 11px;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        text-align: left;
        border-bottom: 1px solid #e5e7eb;
    }
    .data-table tbody td {
        padding: 12px 14px;
        font-size: 13px;
        color: #374151;
        border-bottom: 1px solid #f3f4f6;
        vertical-align: middle;
    }
    .data-table tbody tr:hover { background: #fafafa; }
    .data-table tbody tr:last-child td { border-bottom: none; }
    .status-badge {
        display: inline-block;
        font-size: 11px;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 20px;
        text-transform: capitalize;
    }
    .status-badge.pending {
        background: #fef3c7;
        color: #92400e;
    }
    .status-badge.completed {
        background: #dcfce7;
        color: #166534;
    }
    .status-badge.processing {
        background: #dbeafe;
        color: #1e40af;
    }
    .status-badge.cancelled {
        background: #fee2e2;
        color: #991b1b;
    }
    .status-badge.tersedia {
        background: #dcfce7;
        color: #166534;
    }
    .status-badge.jalan {
        background: #dbeafe;
        color: #1e40af;
    }
    .status-badge.maintenance {
        background: #fee2e2;
        color: #991b1b;
    }
    .revenue-amount {
        font-weight: 600;
        color: #16a34a;
        font-size: 13px;
    }
    .armada-status-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }
    .armada-status-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 22px;
        border-bottom: 1px solid #f3f4f6;
    }
    .armada-status-item:last-child {
        border-bottom: none;
    }
    .armada-status-label {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
        color: #374151;
        font-weight: 500;
    }
    .status-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        flex-shrink: 0;
    }
    .status-dot.tersedia { background: #22c55e; }
    .status-dot.jalan { background: #0064d2; }
    .status-dot.maintenance { background: #ef4444; }
    .armada-count {
        font-size: 16px;
        font-weight: 700;
        color: #111827;
    }
    .quick-links-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        padding: 16px 22px 20px;
    }
    .quick-link-btn {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 14px 16px;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        text-decoration: none;
        color: #374151;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.2s ease;
    }
    .quick-link-btn:hover {
        border-color: #0064d2;
        background: #f8fafc;
    }
    .quick-link-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .quick-link-icon.armada-icon { background: #eff6ff; }
    .quick-link-icon.driver-icon { background: #f0fdf4; }
    .chart-container {
        padding: 20px 22px;
    }
    .chart-bars {
        display: flex;
        align-items: flex-end;
        gap: 8px;
        height: 120px;
        padding-top: 16px;
    }
    .chart-bar-wrapper {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        height: 100%;
        justify-content: flex-end;
    }
    .chart-bar {
        width: 100%;
        max-width: 48px;
        border-radius: 4px 4px 0 0;
        background: linear-gradient(180deg, #0064d2 0%, #3b82f6 100%);
        transition: height 0.3s ease;
        min-height: 4px;
    }
    .chart-bar-label {
        font-size: 10px;
        color: #9ca3af;
        margin-top: 8px;
        text-align: center;
    }
    .chart-bar-value {
        font-size: 10px;
        color: #6b7280;
        font-weight: 600;
        margin-bottom: 4px;
    }
    .empty-state {
        text-align: center;
        padding: 48px 24px;
    }
    .empty-state h3 {
        font-size: 14px;
        font-weight: 600;
        color: #6b7280;
        margin: 0 0 6px;
    }
    .empty-state p {
        font-size: 13px;
        color: #9ca3af;
        margin: 0;
    }
    .trend-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 8px;
    }
    .trend-total {
        font-size: 13px;
        color: #6b7280;
    }
    .trend-total strong {
        color: #111827;
    }
    @media (max-width: 1024px) {
        .stats-row { grid-template-columns: repeat(2, 1fr); }
        .main-content { grid-template-columns: 1fr; }
    }
    @media (max-width: 640px) {
        .stats-row { grid-template-columns: 1fr; }
        .service-row { grid-template-columns: 1fr; }
        .quick-links-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="dashboard-container">
    <!-- Header -->
    <div class="dashboard-header">
        <h1>{{ __('partner.dashboard_title') }}</h1>
        <p>{{ __('partner.welcome', [':name' => $partner->name ?? 'Partner']) }}</p>
    </div>

    <!-- Top Stats Row -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-indicator blue"></div>
            <div class="stat-details">
                <div class="stat-label">{{ __('partner.total_armada') }}</div>
                <div class="stat-value">{{ $totalArmadas ?? 0 }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-indicator green"></div>
            <div class="stat-details">
                <div class="stat-label">{{ __('partner.driver_aktif') }}</div>
                <div class="stat-value">{{ $totalDrivers ?? 0 }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-indicator orange"></div>
            <div class="stat-details">
                <div class="stat-label">{{ __('partner.total_earnings') }}</div>
                <div class="stat-value">Rp {{ number_format($totalEarnings ?? 0, 0, ',', '.') }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-indicator purple"></div>
            <div class="stat-details">
                <div class="stat-label">{{ __('partner.pending_payout') }}</div>
                <div class="stat-value">Rp {{ number_format($pendingPayouts ?? 0, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    <!-- Service Breakdown -->
    <div class="service-row">
        <div class="service-card">
            <div class="service-info">
                <h3>{{ __('partner.travel_bookings') }}</h3>
                <div class="service-count">{{ $travelBookings ?? 0 }}</div>
            </div>
            <div class="service-badge travel">
                <svg width="22" height="22" fill="none" stroke="#0064d2" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
            </div>
        </div>
        <div class="service-card">
            <div class="service-info">
                <h3>{{ __('partner.rental_bookings') }}</h3>
                <div class="service-count">{{ $rentalBookings ?? 0 }}</div>
            </div>
            <div class="service-badge rental">
                <svg width="22" height="22" fill="none" stroke="#22c55e" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
        </div>
        <div class="service-card">
            <div class="service-info">
                <h3>{{ __('partner.airport_transfer') }}</h3>
                <div class="service-count">{{ $airportBookings ?? 0 }}</div>
            </div>
            <div class="service-badge airport">
                <svg width="22" height="22" fill="none" stroke="#f59e0b" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
            </div>
        </div>
    </div>

    <!-- Main Content: 2-column layout -->
    <div class="main-content">
        <!-- Left: Recent Revenue Sharing Transactions -->
        <div class="panel-card">
            <div class="panel-header">
                <h2>{{ __('partner.revenue_sharing') }}</h2>
                <span style="font-size: 12px; color: #6b7280; background: #f3f4f6; padding: 3px 10px; border-radius: 12px;">{{ isset($recentTransactions) ? $recentTransactions->count() : 0 }} {{ __('partner.transactions_count') }}</span>
            </div>
            <div class="panel-body">
                @if(isset($recentTransactions) && $recentTransactions->count() > 0)
                <div style="overflow-x: auto;">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>{{ __('partner.table_date') }}</th>
                                <th>{{ __('partner.table_booking') }}</th>
                                <th>{{ __('partner.table_mitra_share') }}</th>
                                <th>{{ __('partner.table_status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentTransactions as $trx)
                            <tr>
                                <td style="color: #6b7280; white-space: nowrap;">
                                    {{ $trx->created_at ? \Carbon\Carbon::parse($trx->created_at)->format('d M Y') : '-' }}
                                </td>
                                <td style="font-weight: 600; color: #0064d2;">
                                    #{{ $trx->booking_id ?? '-' }}
                                </td>
                                <td>
                                    <span class="revenue-amount">Rp {{ number_format($trx->mitra_amount ?? 0, 0, ',', '.') }}</span>
                                </td>
                                <td>
                                    @if($trx->status == 'completed')
                                        <span class="status-badge completed">{{ __('status.completed') }}</span>
                                    @elseif($trx->status == 'pending')
                                        <span class="status-badge pending">{{ __('status.pending') }}</span>
                                    @else
                                        <span class="status-badge {{ $trx->status }}">{{ ucfirst($trx->status) }}</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="empty-state">
                    <h3>{{ __('partner.empty_transactions') }}</h3>
                    <p>{{ __('partner.empty_transactions_desc') }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Right: Armada Status + Quick Links -->
        <div style="display: flex; flex-direction: column; gap: 20px;">
            <!-- Armada Status Summary -->
            <div class="panel-card">
                <div class="panel-header">
                    <h2>{{ __('partner.armada_status') }}</h2>
                </div>
                <ul class="armada-status-list">
                    <li class="armada-status-item">
                        <div class="armada-status-label">
                            <span class="status-dot tersedia"></span>
                            <span>{{ __('partner.status_tersedia') }}</span>
                        </div>
                        <span class="armada-count">{{ $armadaTersedia ?? 0 }}</span>
                    </li>
                    <li class="armada-status-item">
                        <div class="armada-status-label">
                            <span class="status-dot jalan"></span>
                            <span>{{ __('partner.status_jalan') }}</span>
                        </div>
                        <span class="armada-count">{{ $armadaJalan ?? 0 }}</span>
                    </li>
                    <li class="armada-status-item">
                        <div class="armada-status-label">
                            <span class="status-dot maintenance"></span>
                            <span>{{ __('partner.status_maintenance') }}</span>
                        </div>
                        <span class="armada-count">{{ $armadaMaintenance ?? 0 }}</span>
                    </li>
                </ul>
            </div>

            <!-- Revenue Trend Mini Chart -->
            <div class="panel-card">
                <div class="panel-header">
                    <h2>{{ __('partner.revenue_trend') }}</h2>
                </div>
                <div class="chart-container">
                    @if(isset($revenueTrend) && $revenueTrend->count() > 0)
                    <div class="trend-header">
                        <span class="trend-total">{{ __('partner.total') }}: <strong>Rp {{ number_format($revenueTrend->sum('total'), 0, ',', '.') }}</strong></span>
                    </div>
                    <div class="chart-bars">
                        @php
                            $maxRevenue = $revenueTrend->max('total') ?: 1;
                        @endphp
                        @foreach($revenueTrend as $day)
                        @php
                            $heightPercent = ($day->total / $maxRevenue) * 100;
                            $dayLabel = \Carbon\Carbon::parse($day->date)->format('D');
                        @endphp
                        <div class="chart-bar-wrapper">
                            <div class="chart-bar-value">{{ number_format($day->total / 1000, 0) }}k</div>
                            <div class="chart-bar" style="height: {{ max($heightPercent, 5) }}%;"></div>
                            <div class="chart-bar-label">{{ $dayLabel }}</div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="empty-state" style="padding: 32px 24px;">
                        <h3>{{ __('partner.empty_revenue') }}</h3>
                        <p>{{ __('partner.empty_revenue_desc') }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Quick Links -->
            <div class="panel-card">
                <div class="panel-header">
                    <h2>{{ __('partner.quick_actions') }}</h2>
                </div>
                <div class="quick-links-grid">
                    <a href="{{ route('partner.armadas') }}" class="quick-link-btn">
                        <div class="quick-link-icon armada-icon">
                            <svg width="18" height="18" fill="none" stroke="#0064d2" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                        </div>
                        <span>{{ __('partner.manage_armada') }}</span>
                    </a>
                    <a href="{{ route('partner.drivers') }}" class="quick-link-btn">
                        <div class="quick-link-icon driver-icon">
                            <svg width="18" height="18" fill="none" stroke="#22c55e" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <span>{{ __('partner.manage_driver') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
