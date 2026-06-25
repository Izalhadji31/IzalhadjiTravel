@extends('layouts.app')

@section('title', 'Revenue Sharing')

@section('content')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.25rem;
        margin-bottom: 2rem;
    }
    .stat-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 0.625rem;
        padding: 1.5rem;
        transition: all 0.2s;
    }
    .stat-card:hover {
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }
    .stat-card .stat-label {
        font-size: 0.85rem;
        color: #6b7280;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
    .stat-card .stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: #111;
    }
    .stat-card .stat-icon {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 0.75rem;
    }
    .stat-card .stat-icon svg {
        width: 1.25rem;
        height: 1.25rem;
    }
    .filter-bar {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 0.625rem;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
    }
    .filter-form {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        align-items: flex-end;
    }
    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.375rem;
    }
    .filter-group label {
        font-size: 0.8rem;
        font-weight: 600;
        color: #374151;
    }
    .filter-group select,
    .filter-group input {
        padding: 0.5rem 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        font-size: 0.9rem;
        color: #374151;
        background: white;
        min-width: 160px;
    }
    .filter-group select:focus,
    .filter-group input:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }
    .revenue-table-container {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 0.625rem;
        overflow: hidden;
        margin-bottom: 2rem;
    }
    .revenue-table {
        width: 100%;
        border-collapse: collapse;
    }
    .revenue-table thead {
        background: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
    }
    .revenue-table th {
        padding: 0.875rem 1rem;
        text-align: left;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #6b7280;
    }
    .revenue-table td {
        padding: 1rem;
        border-bottom: 1px solid #f3f4f6;
        font-size: 0.9rem;
        color: #374151;
        vertical-align: middle;
    }
    .revenue-table tbody tr:hover {
        background: #f9fafb;
    }
    .revenue-table tbody tr:last-child td {
        border-bottom: none;
    }
    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: capitalize;
    }
    .status-badge.completed {
        background: #d1fae5;
        color: #065f46;
    }
    .status-badge.pending {
        background: #fef3c7;
        color: #92400e;
    }
    .btn-view {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.5rem 1rem;
        background: #2563eb;
        color: white;
        border-radius: 0.375rem;
        font-size: 0.8rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
    }
    .btn-view:hover {
        background: #1d4ed8;
    }
    .btn-view svg {
        width: 0.875rem;
        height: 0.875rem;
    }
    .btn-export {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.625rem 1.25rem;
        background: #059669;
        color: white;
        border-radius: 0.5rem;
        font-weight: 500;
        font-size: 0.9rem;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
    }
    .btn-export:hover {
        background: #047857;
    }
    .btn-export svg {
        width: 1rem;
        height: 1rem;
    }
    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #6b7280;
    }
    .empty-state svg {
        width: 3rem;
        height: 3rem;
        margin-bottom: 1rem;
        color: #d1d5db;
    }
    .amount {
        font-weight: 600;
        color: #111;
    }
    .booking-code {
        font-family: 'Monaco', 'Consolas', monospace;
        font-size: 0.8rem;
        background: #f3f4f6;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        color: #374151;
    }
    .percentage {
        font-weight: 600;
        color: #2563eb;
    }
    .partner-summary-section {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 0.625rem;
        overflow: hidden;
    }
    .partner-summary-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #e5e7eb;
        background: #f9fafb;
    }
    .partner-summary-header h3 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 600;
        color: #111;
    }
    .partner-summary-header p {
        margin: 0.25rem 0 0 0;
        font-size: 0.85rem;
        color: #6b7280;
    }
    .partner-table {
        width: 100%;
        border-collapse: collapse;
    }
    .partner-table thead {
        background: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
    }
    .partner-table th {
        padding: 0.875rem 1rem;
        text-align: left;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #6b7280;
    }
    .partner-table td {
        padding: 1rem;
        border-bottom: 1px solid #f3f4f6;
        font-size: 0.9rem;
        color: #374151;
        vertical-align: middle;
    }
    .partner-table tbody tr:hover {
        background: #f9fafb;
    }
    .partner-table tbody tr:last-child td {
        border-bottom: none;
    }
    .partner-name {
        font-weight: 600;
        color: #111;
    }
    .section-header-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    .pagination-container {
        padding: 1rem;
        border-top: 1px solid #e5e7eb;
    }
</style>

<div class="page-header">
    <h1 class="page-title">Revenue Sharing</h1>
    <p class="page-subtitle">Detail bagi hasil pendapatan antara Admin, Mitra, dan Driver</p>
</div>

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background: #eff6ff;">
            <svg fill="none" stroke="#2563eb" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
        </div>
        <div class="stat-label">Total Admin Share</div>
        <div class="stat-value">Rp {{ number_format($totalAdminShare, 0, ',', '.') }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: #d1fae5;">
            <svg fill="none" stroke="#059669" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
        </div>
        <div class="stat-label">Total Mitra Share</div>
        <div class="stat-value" style="color: #059669;">Rp {{ number_format($totalMitraShare, 0, ',', '.') }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: #fef3c7;">
            <svg fill="none" stroke="#d97706" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        </div>
        <div class="stat-label">Total Driver Share</div>
        <div class="stat-value" style="color: #d97706;">Rp {{ number_format($totalDriverShare, 0, ',', '.') }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: #f3e8ff;">
            <svg fill="none" stroke="#7c3aed" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div class="stat-label">Total Overall</div>
        <div class="stat-value" style="color: #7c3aed;">Rp {{ number_format($totalOverall, 0, ',', '.') }}</div>
    </div>
</div>

<!-- Filter Bar -->
<div class="filter-bar">
    <form method="GET" action="{{ route('admin.revenue-sharing') }}" class="filter-form">
        <div class="filter-group">
            <label for="date_from">From Date</label>
            <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}">
        </div>
        <div class="filter-group">
            <label for="date_to">To Date</label>
            <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}">
        </div>
        <div class="filter-group">
            <label for="status">Status</label>
            <select name="status" id="status">
                <option value="all" {{ request('status', 'all') === 'all' ? 'selected' : '' }}>All Status</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>
        <div class="filter-group">
            <label for="booking_type">Booking Type</label>
            <select name="booking_type" id="booking_type">
                <option value="all" {{ request('booking_type', 'all') === 'all' ? 'selected' : '' }}>All Types</option>
                <option value="travel" {{ request('booking_type') === 'travel' ? 'selected' : '' }}>Travel</option>
                <option value="rental" {{ request('booking_type') === 'rental' ? 'selected' : '' }}>Rental</option>
            </select>
        </div>
        <div class="filter-group">
            <button type="submit" class="btn btn-primary">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 1rem; height: 1rem;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                Filter
            </button>
        </div>
        <div class="filter-group">
            <a href="{{ route('admin.revenue-sharing') }}" class="btn btn-secondary">Reset</a>
        </div>
        <div class="filter-group">
            <a href="{{ route('admin.revenue-sharing.export', request()->query()) }}" class="btn-export">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Export CSV
            </a>
        </div>
    </form>
</div>

<!-- Revenue Sharing Table -->
<div class="revenue-table-container">
    <table class="revenue-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Booking Code</th>
                <th>Admin %</th>
                <th>Mitra %</th>
                <th>Driver %</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($revenueSharings as $sharing)
            <tr>
                <td>{{ $sharing->created_at ? $sharing->created_at->format('d M Y') : '-' }}</td>
                <td>
                    @if($sharing->booking)
                        <span class="booking-code">{{ $sharing->booking->booking_code ?? 'N/A' }}</span>
                    @else
                        <span style="color: #9ca3af;">N/A</span>
                    @endif
                </td>
                <td class="percentage">{{ number_format($sharing->admin_percentage, 1) }}%</td>
                <td class="percentage">{{ number_format($sharing->mitra_percentage, 1) }}%</td>
                <td class="percentage">{{ number_format($sharing->driver_percentage, 1) }}%</td>
                <td class="amount">Rp {{ number_format($sharing->getTotalAmount(), 0, ',', '.') }}</td>
                <td>
                    <span class="status-badge {{ $sharing->status }}">
                        {{ ucfirst($sharing->status) }}
                    </span>
                </td>
                <td>
                    @if($sharing->payment)
                        <a href="{{ route('admin.revenue-sharing.show', $sharing->id) }}" class="btn-view">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            View Payout
                        </a>
                    @else
                        <span style="color: #9ca3af;">-</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8">
                    <div class="empty-state">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <p>No revenue sharing records found</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($revenueSharings->hasPages())
    <div class="pagination-container">
        {{ $revenueSharings->withQueryString()->links() }}
    </div>
    @endif
</div>

<!-- Partner Summary Section -->
<div class="partner-summary-section">
    <div class="partner-summary-header">
        <h3>Summary by Partner</h3>
        <p>Total revenue sharing grouped by partner (Mitra)</p>
    </div>
    <table class="partner-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Partner Name</th>
                <th>Total Bookings</th>
                <th>Admin Share</th>
                <th>Mitra Share</th>
                <th>Driver Share</th>
                <th>Total Amount</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($partnerSummary as $index => $partner)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td class="partner-name">{{ $partner['name'] }}</td>
                <td>{{ $partner['total_bookings'] }}</td>
                <td class="amount">Rp {{ number_format($partner['admin_total'], 0, ',', '.') }}</td>
                <td class="amount" style="color: #059669;">Rp {{ number_format($partner['mitra_total'], 0, ',', '.') }}</td>
                <td class="amount" style="color: #d97706;">Rp {{ number_format($partner['driver_total'], 0, ',', '.') }}</td>
                <td class="amount" style="color: #7c3aed; font-weight: 700;">Rp {{ number_format($partner['grand_total'], 0, ',', '.') }}</td>
                <td>
                    @if($partner['pending_count'] > 0)
                        <span class="status-badge pending">{{ $partner['pending_count'] }} Pending</span>
                    @else
                        <span class="status-badge completed">All Paid</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8">
                    <div class="empty-state">
                        <p>No partner data available</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
