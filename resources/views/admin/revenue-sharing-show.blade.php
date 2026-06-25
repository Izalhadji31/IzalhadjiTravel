@extends('layouts.app')

@section('title', 'Revenue Sharing Detail')

@section('content')
<style>
    .detail-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 0.625rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .detail-card h3 {
        margin: 0 0 1rem 0;
        font-size: 1.1rem;
        font-weight: 600;
        color: #111;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #e5e7eb;
    }
    .detail-row {
        display: flex;
        justify-content: space-between;
        padding: 0.625rem 0;
        border-bottom: 1px solid #f3f4f6;
    }
    .detail-row:last-child {
        border-bottom: none;
    }
    .detail-label {
        font-weight: 500;
        color: #6b7280;
    }
    .detail-value {
        font-weight: 600;
        color: #111;
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
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: #2563eb;
        text-decoration: none;
        font-weight: 500;
        margin-bottom: 1.5rem;
    }
    .back-link:hover {
        text-decoration: underline;
    }
    .back-link svg {
        width: 1rem;
        height: 1rem;
    }
</style>

<a href="{{ route('admin.revenue-sharing') }}" class="back-link">
    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
    Back to Revenue Sharing
</a>

<div class="page-header">
    <h1 class="page-title">Revenue Sharing Detail</h1>
    <p class="page-subtitle">Payout information for booking #{{ $revenueSharing->booking->booking_code ?? 'N/A' }}</p>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
    <div class="detail-card">
        <h3>Booking Information</h3>
        <div class="detail-row">
            <span class="detail-label">Booking Code</span>
            <span class="detail-value">{{ $revenueSharing->booking->booking_code ?? 'N/A' }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Type</span>
            <span class="detail-value">{{ $revenueSharing->booking_type === 'App\\Models\\TravelBooking' ? 'Travel' : 'Rental' }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Customer</span>
            <span class="detail-value">{{ $revenueSharing->booking->user->name ?? 'N/A' }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Date</span>
            <span class="detail-value">{{ $revenueSharing->created_at ? $revenueSharing->created_at->format('d M Y H:i') : '-' }}</span>
        </div>
    </div>

    <div class="detail-card">
        <h3>Revenue Breakdown</h3>
        <div class="detail-row">
            <span class="detail-label">Admin Share ({{ $revenueSharing->admin_percentage }}%)</span>
            <span class="detail-value">Rp {{ number_format($revenueSharing->admin_amount, 0, ',', '.') }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Mitra Share ({{ $revenueSharing->mitra_percentage }}%)</span>
            <span class="detail-value" style="color: #059669;">Rp {{ number_format($revenueSharing->mitra_amount, 0, ',', '.') }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Driver Share ({{ $revenueSharing->driver_percentage }}%)</span>
            <span class="detail-value" style="color: #d97706;">Rp {{ number_format($revenueSharing->driver_amount, 0, ',', '.') }}</span>
        </div>
        <div class="detail-row" style="border-top: 2px solid #e5e7eb; margin-top: 0.5rem; padding-top: 0.75rem;">
            <span class="detail-label" style="font-weight: 700;">Total</span>
            <span class="detail-value" style="font-size: 1.1rem; color: #7c3aed;">Rp {{ number_format($revenueSharing->getTotalAmount(), 0, ',', '.') }}</span>
        </div>
    </div>

    <div class="detail-card">
        <h3>Partner Information</h3>
        <div class="detail-row">
            <span class="detail-label">Partner Name</span>
            <span class="detail-value">{{ $revenueSharing->mitra->name ?? 'N/A' }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Phone</span>
            <span class="detail-value">{{ $revenueSharing->mitra->phone ?? '-' }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Bank</span>
            <span class="detail-value">{{ $revenueSharing->mitra->bank_name ?? '-' }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Account</span>
            <span class="detail-value">{{ $revenueSharing->mitra->bank_account ?? '-' }}</span>
        </div>
    </div>

    <div class="detail-card">
        <h3>Payout Status</h3>
        <div class="detail-row">
            <span class="detail-label">Status</span>
            <span class="status-badge {{ $revenueSharing->status }}">{{ ucfirst($revenueSharing->status) }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Paid At</span>
            <span class="detail-value">{{ $revenueSharing->paid_at ? $revenueSharing->paid_at->format('d M Y H:i') : '-' }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Payment ID</span>
            <span class="detail-value">{{ $revenueSharing->payment->id ?? 'N/A' }}</span>
        </div>
    </div>
</div>
@endsection
