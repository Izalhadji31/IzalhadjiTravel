@extends('layouts.app')

@section('content')
<style>
    :root {
        --trvl-blue: #0064d2;
        --trvl-green: #00a651;
        --trvl-green-light: #e8f5e9;
        --trvl-blue-light: #e3f2fd;
        --trvl-orange: #ff9800;
        --trvl-orange-light: #fff3e0;
        --trvl-red: #e53935;
        --trvl-red-light: #ffebee;
        --trvl-gray-50: #fafafa;
        --trvl-gray-100: #f5f5f5;
        --trvl-gray-200: #eeeeee;
        --trvl-gray-300: #e0e0e0;
        --trvl-gray-500: #9e9e9e;
        --trvl-gray-700: #616161;
        --trvl-gray-900: #212121;
        --trvl-shadow: 0 2px 8px rgba(0,0,0,0.08);
        --trvl-shadow-lg: 0 4px 16px rgba(0,0,0,0.12);
        --trvl-radius: 12px;
        --trvl-radius-sm: 8px;
    }

    .revenue-dashboard {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        max-width: 1200px;
        margin: 0 auto;
        padding: 24px;
        color: var(--trvl-gray-900);
    }

    .revenue-dashboard * {
        box-sizing: border-box;
    }

    /* Page Header */
    .revenue-header {
        margin-bottom: 32px;
    }

    .revenue-header h1 {
        font-size: 28px;
        font-weight: 700;
        color: var(--trvl-gray-900);
        margin: 0 0 4px 0;
    }

    .revenue-header p {
        font-size: 14px;
        color: var(--trvl-gray-500);
        margin: 0;
    }

    /* Summary Cards */
    .summary-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        margin-bottom: 32px;
    }

    .summary-card {
        background: #fff;
        border-radius: var(--trvl-radius);
        padding: 24px;
        box-shadow: var(--trvl-shadow);
        border: 1px solid var(--trvl-gray-200);
        transition: box-shadow 0.2s ease, transform 0.2s ease;
    }

    .summary-card:hover {
        box-shadow: var(--trvl-shadow-lg);
        transform: translateY(-2px);
    }

    .summary-card .card-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        margin-bottom: 16px;
    }

    .summary-card.total-earnings .card-icon {
        background: var(--trvl-green-light);
        color: var(--trvl-green);
    }

    .summary-card.pending-payouts .card-icon {
        background: var(--trvl-orange-light);
        color: var(--trvl-orange);
    }

    .summary-card.completed-payouts .card-icon {
        background: var(--trvl-blue-light);
        color: var(--trvl-blue);
    }

    .summary-card .card-label {
        font-size: 13px;
        font-weight: 500;
        color: var(--trvl-gray-500);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }

    .summary-card .card-value {
        font-size: 32px;
        font-weight: 700;
        color: var(--trvl-gray-900);
        line-height: 1.2;
    }

    .summary-card.total-earnings .card-value {
        color: var(--trvl-green);
    }

    .summary-card .card-subtitle {
        font-size: 12px;
        color: var(--trvl-gray-500);
        margin-top: 8px;
    }

    /* Partner Info Bar */
    .partner-info-bar {
        background: #fff;
        border-radius: var(--trvl-radius);
        padding: 20px 24px;
        box-shadow: var(--trvl-shadow);
        border: 1px solid var(--trvl-gray-200);
        margin-bottom: 32px;
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .partner-info-bar .partner-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--trvl-blue), var(--trvl-green));
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 20px;
        font-weight: 700;
        flex-shrink: 0;
    }

    .partner-info-bar .partner-details h3 {
        font-size: 16px;
        font-weight: 600;
        color: var(--trvl-gray-900);
        margin: 0 0 2px 0;
    }

    .partner-info-bar .partner-details p {
        font-size: 13px;
        color: var(--trvl-gray-500);
        margin: 0;
    }

    .partner-info-bar .partner-badge {
        margin-left: auto;
        background: var(--trvl-green-light);
        color: var(--trvl-green);
        font-size: 12px;
        font-weight: 600;
        padding: 6px 14px;
        border-radius: 20px;
    }

    /* Table Section */
    .table-section {
        background: #fff;
        border-radius: var(--trvl-radius);
        box-shadow: var(--trvl-shadow);
        border: 1px solid var(--trvl-gray-200);
        overflow: hidden;
    }

    .table-section-header {
        padding: 20px 24px;
        border-bottom: 1px solid var(--trvl-gray-200);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .table-section-header h2 {
        font-size: 18px;
        font-weight: 600;
        color: var(--trvl-gray-900);
        margin: 0;
    }

    .table-section-header .record-count {
        font-size: 13px;
        color: var(--trvl-gray-500);
        background: var(--trvl-gray-100);
        padding: 4px 12px;
        border-radius: 20px;
    }

    /* Table Styles */
    .revenue-table {
        width: 100%;
        border-collapse: collapse;
    }

    .revenue-table thead th {
        background: var(--trvl-gray-50);
        padding: 14px 16px;
        font-size: 12px;
        font-weight: 600;
        color: var(--trvl-gray-700);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        text-align: left;
        border-bottom: 2px solid var(--trvl-gray-200);
        white-space: nowrap;
    }

    .revenue-table tbody td {
        padding: 14px 16px;
        font-size: 14px;
        color: var(--trvl-gray-900);
        border-bottom: 1px solid var(--trvl-gray-100);
        vertical-align: middle;
    }

    .revenue-table tbody tr:hover {
        background: var(--trvl-gray-50);
    }

    .revenue-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Booking Code */
    .booking-code {
        font-family: 'SF Mono', 'Fira Code', monospace;
        font-size: 13px;
        font-weight: 600;
        color: var(--trvl-blue);
        background: var(--trvl-blue-light);
        padding: 4px 8px;
        border-radius: 4px;
    }

    /* Type Badge */
    .type-badge {
        display: inline-block;
        font-size: 12px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 20px;
    }

    .type-badge.travel {
        background: var(--trvl-blue-light);
        color: var(--trvl-blue);
    }

    .type-badge.rental {
        background: var(--trvl-green-light);
        color: var(--trvl-green);
    }

    /* Share Amount */
    .share-amount {
        font-weight: 600;
        font-size: 13px;
    }

    .share-amount.admin {
        color: var(--trvl-gray-700);
    }

    .share-amount.mitra {
        color: var(--trvl-green);
    }

    .share-amount.driver {
        color: var(--trvl-blue);
    }

    /* Status Badge */
    .status-badge {
        display: inline-block;
        font-size: 12px;
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 20px;
    }

    .status-badge.completed {
        background: var(--trvl-green-light);
        color: var(--trvl-green);
    }

    .status-badge.pending {
        background: var(--trvl-orange-light);
        color: var(--trvl-orange);
    }

    .status-badge.processing {
        background: var(--trvl-blue-light);
        color: var(--trvl-blue);
    }

    .status-badge.cancelled {
        background: var(--trvl-red-light);
        color: var(--trvl-red);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 24px;
    }

    .empty-state .empty-icon {
        font-size: 48px;
        margin-bottom: 16px;
        opacity: 0.5;
    }

    .empty-state h3 {
        font-size: 16px;
        font-weight: 600;
        color: var(--trvl-gray-700);
        margin: 0 0 8px 0;
    }

    .empty-state p {
        font-size: 14px;
        color: var(--trvl-gray-500);
        margin: 0;
    }

    /* Table Footer / Summary */
    .table-footer {
        padding: 16px 24px;
        background: var(--trvl-gray-50);
        border-top: 1px solid var(--trvl-gray-200);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .table-footer .footer-total {
        font-size: 14px;
        color: var(--trvl-gray-700);
    }

    .table-footer .footer-total strong {
        color: var(--trvl-green);
        font-size: 16px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .revenue-dashboard {
            padding: 16px;
        }

        .summary-cards {
            grid-template-columns: 1fr;
        }

        .revenue-table {
            display: block;
            overflow-x: auto;
        }

        .partner-info-bar {
            flex-wrap: wrap;
        }

        .partner-info-bar .partner-badge {
            margin-left: 0;
        }
    }
</style>

<div class="revenue-dashboard">
    <!-- Page Header -->
    <div class="revenue-header">
        <h1>Revenue Dashboard</h1>
        <p>Track your earnings and revenue sharing history</p>
    </div>

    <!-- Partner Info Bar -->
    <div class="partner-info-bar">
        <div class="partner-avatar">
            {{ strtoupper(substr($partner->name ?? 'P', 0, 1)) }}
        </div>
        <div class="partner-details">
            <h3>{{ $partner->name ?? 'Partner' }}</h3>
            <p>{{ $partner->email ?? '' }}</p>
        </div>
        <span class="partner-badge">Mitra Partner</span>
    </div>

    <!-- Summary Cards -->
    <div class="summary-cards">
        <div class="summary-card total-earnings">
            <div class="card-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="1" x2="12" y2="23"></line>
                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                </svg>
            </div>
            <div class="card-label">Total Earnings</div>
            <div class="card-value">Rp {{ number_format($totalEarnings ?? 0, 0, ',', '.') }}</div>
            <div class="card-subtitle">All time earnings</div>
        </div>

        <div class="summary-card pending-payouts">
            <div class="card-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
            </div>
            <div class="card-label">Pending Payouts</div>
            <div class="card-value">Rp {{ number_format($pendingPayouts ?? 0, 0, ',', '.') }}</div>
            <div class="card-subtitle">Awaiting disbursement</div>
        </div>

        <div class="summary-card completed-payouts">
            <div class="card-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            </div>
            <div class="card-label">Completed Payouts</div>
            <div class="card-value">Rp {{ number_format($completedPayouts ?? 0, 0, ',', '.') }}</div>
            <div class="card-subtitle">Successfully disbursed</div>
        </div>
    </div>

    <!-- Revenue Sharing History Table -->
    <div class="table-section">
        <div class="table-section-header">
            <h2>Revenue Sharing History</h2>
            <span class="record-count">{{ $revenueSharings->count() ?? 0 }} records</span>
        </div>

        @if(isset($revenueSharings) && $revenueSharings->count() > 0)
        <table class="revenue-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Booking Code</th>
                    <th>Type</th>
                    <th>Admin Share</th>
                    <th>Mitra Share</th>
                    <th>Driver Share</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($revenueSharings as $sharing)
                <tr>
                    <td>
                        <span style="color: var(--trvl-gray-700); font-size: 13px;">
                            {{ isset($sharing->created_at) ? \Carbon\Carbon::parse($sharing->created_at)->format('d M Y') : '-' }}
                        </span>
                    </td>
                    <td>
                        <span class="booking-code">{{ $sharing->booking_code ?? $sharing->booking->code ?? '-' }}</span>
                    </td>
                    <td>
                        @if(isset($sharing->type) && strtolower($sharing->type) === 'travel')
                            <span class="type-badge travel">Travel</span>
                        @elseif(isset($sharing->type) && strtolower($sharing->type) === 'rental')
                            <span class="type-badge rental">Rental</span>
                        @elseif(isset($sharing->booking_type) && strtolower($sharing->booking_type) === 'travel')
                            <span class="type-badge travel">Travel</span>
                        @elseif(isset($sharing->booking_type) && strtolower($sharing->booking_type) === 'rental')
                            <span class="type-badge rental">Rental</span>
                        @else
                            <span class="type-badge travel">{{ ucfirst($sharing->type ?? 'Travel') }}</span>
                        @endif
                    </td>
                    <td>
                        <span class="share-amount admin">
                            Rp {{ number_format($sharing->admin_share ?? 0, 0, ',', '.') }}
                        </span>
                    </td>
                    <td>
                        <span class="share-amount mitra">
                            Rp {{ number_format($sharing->mitra_share ?? $sharing->partner_share ?? 0, 0, ',', '.') }}
                        </span>
                    </td>
                    <td>
                        <span class="share-amount driver">
                            Rp {{ number_format($sharing->driver_share ?? 0, 0, ',', '.') }}
                        </span>
                    </td>
                    <td>
                        @php
                            $status = strtolower($sharing->status ?? 'pending');
                        @endphp
                        @if($status === 'completed' || $status === 'paid')
                            <span class="status-badge completed">{{ ucfirst($sharing->status) }}</span>
                        @elseif($status === 'pending')
                            <span class="status-badge pending">{{ ucfirst($sharing->status) }}</span>
                        @elseif($status === 'processing')
                            <span class="status-badge processing">{{ ucfirst($sharing->status) }}</span>
                        @elseif($status === 'cancelled' || $status === 'canceled')
                            <span class="status-badge cancelled">{{ ucfirst($sharing->status) }}</span>
                        @else
                            <span class="status-badge pending">{{ ucfirst($sharing->status) }}</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="table-footer">
            <span class="footer-total">Total Records: <strong>{{ $revenueSharings->count() }}</strong></span>
            <span class="footer-total">Total Mitra Share: <strong>Rp {{ number_format($revenueSharings->sum('mitra_share') ?? $revenueSharings->sum('partner_share') ?? 0, 0, ',', '.') }}</strong></span>
        </div>
        @else
        <div class="empty-state">
            <div class="empty-icon">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="var(--trvl-gray-300)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                </svg>
            </div>
            <h3>No Revenue Data Yet</h3>
            <p>Your revenue sharing history will appear here once bookings are completed.</p>
        </div>
        @endif
    </div>
</div>
@endsection
