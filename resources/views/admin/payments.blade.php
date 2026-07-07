@extends('layouts.app')

@section('title', 'Manajemen Pembayaran')

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
    .payments-table-container {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 0.625rem;
        overflow: hidden;
    }
    .payments-table {
        width: 100%;
        border-collapse: collapse;
    }
    .payments-table thead {
        background: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
    }
    .payments-table th {
        padding: 0.875rem 1rem;
        text-align: left;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #6b7280;
    }
    .payments-table td {
        padding: 1rem;
        border-bottom: 1px solid #f3f4f6;
        font-size: 0.9rem;
        color: #374151;
        vertical-align: middle;
    }
    .payments-table tbody tr:hover {
        background: #f9fafb;
    }
    .payments-table tbody tr:last-child td {
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
    .status-badge.success {
        background: #d1fae5;
        color: #065f46;
    }
    .status-badge.pending {
        background: #fef3c7;
        color: #92400e;
    }
    .status-badge.failed {
        background: #fee2e2;
        color: #991b1b;
    }
    .status-badge.processing {
        background: #dbeafe;
        color: #1e40af;
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
    }
    .btn-view:hover {
        background: #1d4ed8;
    }
    .btn-view svg {
        width: 0.875rem;
        height: 0.875rem;
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
    .midtrans-ref {
        font-family: 'Monaco', 'Consolas', monospace;
        font-size: 0.8rem;
        color: #6b7280;
    }
    .pagination-container {
        padding: 1rem;
        border-top: 1px solid #e5e7eb;
    }
</style>

<div class="page-header">
            <h1 class="page-title">Manajemen Pembayaran</h1>
    <p class="page-subtitle">Pantau dan kelola semua transaksi pembayaran</p>
</div>

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background: #eff6ff;">
            <svg fill="none" stroke="#2563eb" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div class="stat-label">Total</div>
        <div class="stat-value">Rp {{ number_format($totalAmount, 0, ',', '.') }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: #d1fae5;">
            <svg fill="none" stroke="#059669" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div class="stat-label">Sukses</div>
        <div class="stat-value" style="color: #059669;">Rp {{ number_format($totalSuccess, 0, ',', '.') }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: #fef3c7;">
            <svg fill="none" stroke="#d97706" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div class="stat-label">Pending</div>
        <div class="stat-value" style="color: #d97706;">Rp {{ number_format($totalPending, 0, ',', '.') }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: #fee2e2;">
            <svg fill="none" stroke="#dc2626" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div class="stat-label">Gagal</div>
        <div class="stat-value" style="color: #dc2626;">Rp {{ number_format($totalFailed, 0, ',', '.') }}</div>
    </div>
</div>

<!-- Filter Bar -->
<div class="filter-bar">
    <form method="GET" action="{{ route('admin.payments') }}" class="filter-form">
        <div class="filter-group">
            <label for="status">Status</label>
            <select name="status" id="status">
                <option value="">Semua Status</option>
                <option value="success" {{ request('status') === 'success' ? 'selected' : '' }}>Sukses</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Diproses</option>
                <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Gagal</option>
            </select>
        </div>
        <div class="filter-group">
            <label for="date_from">Dari Tanggal</label>
            <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}">
        </div>
        <div class="filter-group">
            <label for="date_to">Sampai Tanggal</label>
            <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}">
        </div>
        <div class="filter-group">
            <button type="submit" class="btn btn-primary">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 1rem; height: 1rem;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                Filter
            </button>
        </div>
        <div class="filter-group">
            <a href="{{ route('admin.payments') }}" class="btn btn-secondary">Reset</a>
        </div>
    </form>
</div>

<!-- Payments Table -->
<div class="payments-table-container">
    <table class="payments-table">
        <thead>
            <tr>
            <th>ID</th>
                <th>Customer</th>
                <th>Kode Booking</th>
                <th>Jumlah</th>
                <th>Metode</th>
                <th>Referensi Midtrans</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payments as $payment)
            <tr>
                <td>#{{ $payment->id }}</td>
                <td>
                    @if($payment->booking && $payment->booking->user)
                        {{ $payment->booking->user->name }}
                    @else
                        <span style="color: #9ca3af;">N/A</span>
                    @endif
                </td>
                <td>
                    @if($payment->booking)
                        <span class="booking-code">{{ $payment->booking->booking_code ?? 'N/A' }}</span>
                    @else
                        <span style="color: #9ca3af;">N/A</span>
                    @endif
                </td>
                <td class="amount">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method ?? '-')) }}</td>
                <td>
                    @if($payment->midtrans_reference)
                        <span class="midtrans-ref">{{ $payment->midtrans_reference }}</span>
                    @else
                        <span style="color: #9ca3af;">-</span>
                    @endif
                </td>
                <td>
                    <span class="status-badge {{ $payment->status }}">
                        {{ ucfirst($payment->status) }}
                    </span>
                </td>
                <td>{{ $payment->created_at ? $payment->created_at->format('d M Y H:i') : '-' }}</td>
                <td>
                    @if($payment->booking_type === 'App\\Models\\TravelBooking')
                        <a href="{{ route('payments.travel', $payment->booking_id) }}" class="btn-view">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            View
                        </a>
                    @elseif($payment->booking_type === 'App\\Models\\RentalBooking')
                        <a href="{{ route('payments.rental', $payment->booking_id) }}" class="btn-view">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            View
                        </a>
                    @else
                        <span style="color: #9ca3af;">-</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9">
                    <div class="empty-state">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <p>Tidak ada data pembayaran</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($payments->hasPages())
    <div class="pagination-container">
        {{ $payments->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection
