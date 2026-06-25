@extends('layouts.app')

@section('title', 'Partner Dashboard')

@section('content')
<style>
    .partner-dashboard {
        max-width: 1200px;
        margin: 0 auto;
    }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 32px;
    }
    .stat-card {
        background: #fff;
        border-radius: 12px;
        padding: 24px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        transition: box-shadow 0.2s, transform 0.2s;
        display: flex;
        align-items: flex-start;
        gap: 16px;
    }
    .stat-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        transform: translateY(-2px);
    }
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .stat-icon.armada { background: #eff6ff; color: #2563eb; }
    .stat-icon.drivers { background: #f0fdf4; color: #16a34a; }
    .stat-icon.earnings { background: #fefce8; color: #ca8a04; }
    .stat-icon.pending { background: #fef2f2; color: #dc2626; }
    .stat-info .stat-label {
        font-size: 13px;
        font-weight: 500;
        color: #6b7280;
        margin-bottom: 4px;
    }
    .stat-info .stat-value {
        font-size: 28px;
        font-weight: 700;
        color: #111827;
        line-height: 1.2;
    }
    .stat-info .stat-subtitle {
        font-size: 12px;
        color: #9ca3af;
        margin-top: 4px;
    }
    .quick-links {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 32px;
    }
    .quick-link-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 14px;
        text-decoration: none;
        color: #374151;
        transition: all 0.2s;
        cursor: pointer;
    }
    .quick-link-card:hover {
        border-color: #2563eb;
        box-shadow: 0 4px 12px rgba(37,99,235,0.1);
        transform: translateY(-1px);
    }
    .quick-link-icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .quick-link-icon.armada { background: #eff6ff; color: #2563eb; }
    .quick-link-icon.drivers { background: #f0fdf4; color: #16a34a; }
    .quick-link-icon.revenue { background: #fefce8; color: #ca8a04; }
    .quick-link-text h3 {
        font-size: 15px;
        font-weight: 600;
        color: #111827;
        margin: 0;
    }
    .quick-link-text p {
        font-size: 12px;
        color: #6b7280;
        margin: 2px 0 0;
    }
    .section-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
    }
    .section-header {
        padding: 20px 24px;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .section-header h2 {
        font-size: 18px;
        font-weight: 600;
        color: #111827;
        margin: 0;
    }
    .section-header .badge-count {
        font-size: 13px;
        color: #6b7280;
        background: #f3f4f6;
        padding: 4px 12px;
        border-radius: 20px;
    }
    .data-table {
        width: 100%;
        border-collapse: collapse;
    }
    .data-table thead th {
        background: #f9fafb;
        padding: 12px 16px;
        font-size: 12px;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        text-align: left;
        border-bottom: 1px solid #e5e7eb;
    }
    .data-table tbody td {
        padding: 14px 16px;
        font-size: 14px;
        color: #374151;
        border-bottom: 1px solid #f3f4f6;
        vertical-align: middle;
    }
    .data-table tbody tr:hover { background: #f9fafb; }
    .data-table tbody tr:last-child td { border-bottom: none; }
    .status-badge {
        display: inline-block;
        font-size: 12px;
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 20px;
    }
    .status-badge.completed { background: #dcfce7; color: #166534; }
    .status-badge.pending { background: #fef3c7; color: #92400e; }
    .status-badge.processing { background: #dbeafe; color: #1e40af; }
    .status-badge.cancelled { background: #fee2e2; color: #991b1b; }
    .amount { font-weight: 600; font-size: 13px; }
    .amount.mitra { color: #16a34a; }
    .amount.admin { color: #6b7280; }
    .amount.driver { color: #2563eb; }
    .empty-state { text-align: center; padding: 60px 24px; }
    .empty-state .empty-icon { font-size: 48px; margin-bottom: 16px; opacity: 0.4; }
    .empty-state h3 { font-size: 16px; font-weight: 600; color: #6b7280; margin: 0 0 8px; }
    .empty-state p { font-size: 14px; color: #9ca3af; margin: 0; }
    @media (max-width: 768px) {
        .stats-grid { grid-template-columns: 1fr 1fr; }
        .quick-links { grid-template-columns: 1fr; }
        .data-table { display: block; overflow-x: auto; }
    }
    @media (max-width: 480px) {
        .stats-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="partner-dashboard">
    <div style="margin-bottom: 28px;">
        <h1 style="font-size: 28px; font-weight: 700; color: #111827; margin: 0;">Partner Dashboard</h1>
        <p style="color: #6b7280; margin: 4px 0 0; font-size: 14px;">Welcome back, {{ $partner->name ?? 'Partner' }}! Here's your overview.</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon armada">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
            </div>
            <div class="stat-info">
                <div class="stat-label">Total Armada</div>
                <div class="stat-value">{{ $totalArmadas ?? 0 }}</div>
                <div class="stat-subtitle">Registered vehicles</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon drivers">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <div class="stat-info">
                <div class="stat-label">Total Drivers</div>
                <div class="stat-value">{{ $totalDrivers ?? 0 }}</div>
                <div class="stat-subtitle">Active drivers</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon earnings">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div class="stat-info">
                <div class="stat-label">Total Earnings</div>
                <div class="stat-value">Rp {{ number_format($totalEarnings ?? 0, 0, ',', '.') }}</div>
                <div class="stat-subtitle">All time earnings</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon pending">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div class="stat-info">
                <div class="stat-label">Pending Payouts</div>
                <div class="stat-value">Rp {{ number_format($pendingPayouts ?? 0, 0, ',', '.') }}</div>
                <div class="stat-subtitle">Awaiting disbursement</div>
            </div>
        </div>
    </div>

    <div style="margin-bottom: 32px;">
        <h2 style="font-size: 18px; font-weight: 600; color: #111827; margin: 0 0 16px;">Quick Actions</h2>
        <div class="quick-links">
            <a href="{{ route('partner.armadas') }}" class="quick-link-card">
                <div class="quick-link-icon armada">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                </div>
                <div class="quick-link-text">
                    <h3>Armada Management</h3>
                    <p>Manage your vehicle fleet</p>
                </div>
            </a>
            <a href="{{ route('partner.drivers') }}" class="quick-link-card">
                <div class="quick-link-icon drivers">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div class="quick-link-text">
                    <h3>Driver Management</h3>
                    <p>View and manage drivers</p>
                </div>
            </a>
            <a href="{{ route('partner.revenue') }}" class="quick-link-card">
                <div class="quick-link-icon revenue">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="quick-link-text">
                    <h3>Revenue</h3>
                    <p>View earnings and payouts</p>
                </div>
            </a>
        </div>
    </div>

    <div class="section-card">
        <div class="section-header">
            <h2>Recent Revenue Sharing Transactions</h2>
            <span class="badge-count">{{ $recentTransactions->count() ?? 0 }} records</span>
        </div>
        @if(isset($recentTransactions) && $recentTransactions->count() > 0)
        <div style="overflow-x: auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Booking ID</th>
                        <th>Admin Share</th>
                        <th>Mitra Share</th>
                        <th>Driver Share</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentTransactions as $transaction)
                    <tr>
                        <td style="font-size: 13px; color: #6b7280;">
                            {{ $transaction->created_at ? \Carbon\Carbon::parse($transaction->created_at)->format('d M Y') : '-' }}
                        </td>
                        <td style="font-size: 13px; font-weight: 600; color: #2563eb;">
                            #{{ $transaction->booking_id ?? '-' }}
                        </td>
                        <td><span class="amount admin">Rp {{ number_format($transaction->admin_amount ?? 0, 0, ',', '.') }}</span></td>
                        <td><span class="amount mitra">Rp {{ number_format($transaction->mitra_amount ?? 0, 0, ',', '.') }}</span></td>
                        <td><span class="amount driver">Rp {{ number_format($transaction->driver_amount ?? 0, 0, ',', '.') }}</span></td>
                        <td>
                            @if($transaction->status == 'completed')
                                <span class="status-badge completed">Completed</span>
                            @elseif($transaction->status == 'pending')
                                <span class="status-badge pending">Pending</span>
                            @elseif($transaction->status == 'processing')
                                <span class="status-badge processing">Processing</span>
                            @else
                                <span class="status-badge cancelled">{{ ucfirst($transaction->status) }}</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state">
            <div class="empty-icon">
                <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="color: #d1d5db;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <h3>No transactions yet</h3>
            <p>Revenue sharing transactions will appear here once bookings are completed.</p>
        </div>
        @endif
    </div>
</div>
@endsection
