@extends('layouts.app')

@section('title', app()->getLocale() === 'id' ? 'Dashboard Saya' : 'My Dashboard')

@section('content')
@php
    $locale = app()->getLocale();
    $user   = Auth::user();
@endphp

<style>
/* ===== TRACGO-STYLE CUSTOMER DASHBOARD ===== */
.ud-profile-card {
    background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 60%, #3b82f6 100%);
    border-radius: 1.25rem; padding: 2rem;
    display: flex; align-items: center; gap: 1.5rem;
    margin-bottom: 1.75rem; position: relative; overflow: hidden;
}
.ud-profile-card::before {
    content: ''; position: absolute; inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    pointer-events: none;
}
.ud-avatar {
    width: 72px; height: 72px; border-radius: 50%;
    background: rgba(255,255,255,0.2); border: 3px solid rgba(255,255,255,0.45);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.75rem; font-weight: 800; color: white;
    flex-shrink: 0; overflow: hidden; position: relative; z-index: 1;
}
.ud-avatar img { width: 100%; height: 100%; object-fit: cover; }
.ud-profile-info { flex: 1; position: relative; z-index: 1; }
.ud-profile-name  { font-size: 1.3rem; font-weight: 800; color: white; margin-bottom: 0.2rem; }
.ud-profile-email { font-size: 0.85rem; color: rgba(255,255,255,0.75); }
.ud-profile-badge {
    display: inline-flex; align-items: center; gap: 0.35rem;
    background: rgba(255,255,255,0.18); color: white;
    border: 1px solid rgba(255,255,255,0.3);
    padding: 0.25rem 0.75rem; border-radius: 2rem;
    font-size: 0.75rem; font-weight: 700; margin-top: 0.5rem;
}
.ud-edit-btn {
    background: rgba(255,255,255,0.15); border: 1.5px solid rgba(255,255,255,0.4);
    color: white; text-decoration: none;
    padding: 0.5rem 1.25rem; border-radius: 0.625rem;
    font-size: 0.82rem; font-weight: 600; transition: background 0.2s;
    position: relative; z-index: 1; white-space: nowrap;
}
.ud-edit-btn:hover { background: rgba(255,255,255,0.28); }

/* Stats */
.ud-stats {
    display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    gap: 1rem; margin-bottom: 1.75rem;
}
.ud-stat-card {
    background: white; border: 1px solid #e5e7eb; border-radius: 1rem;
    padding: 1.25rem; display: flex; align-items: center; gap: 1rem;
    transition: box-shadow 0.2s, transform 0.2s;
}
.ud-stat-card:hover { box-shadow: 0 6px 20px rgba(37,99,235,0.1); transform: translateY(-2px); }
.ud-stat-icon { width: 44px; height: 44px; border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0; }
.ud-stat-value { font-size: 1.4rem; font-weight: 800; color: #111; line-height: 1; }
.ud-stat-label { font-size: 0.75rem; color: #6b7280; font-weight: 500; margin-top: 0.2rem; }

/* Section header */
.ud-section-head { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem; }
.ud-section-title {
    font-size: 1rem; font-weight: 800; color: #111;
    display: flex; align-items: center; gap: 0.5rem;
}
.ud-section-title::before { content: ''; width: 4px; height: 1.1rem; background: #2563eb; border-radius: 2px; }
.ud-see-all { font-size: 0.8rem; color: #2563eb; text-decoration: none; font-weight: 600; }
.ud-see-all:hover { text-decoration: underline; }

/* Cannot book notice */
.ud-notice {
    background: #fffbeb; border: 1px solid #fde68a;
    border-radius: 1rem; padding: 1.25rem 1.5rem;
    display: flex; align-items: flex-start; gap: 0.875rem;
    margin-bottom: 1.75rem;
}
.ud-notice-icon { font-size: 1.4rem; flex-shrink: 0; }
.ud-notice-title { font-size: 0.9rem; font-weight: 700; color: #92400e; margin-bottom: 0.2rem; }
.ud-notice-sub   { font-size: 0.82rem; color: #b45309; line-height: 1.5; }

/* Bookings table */
.ud-bookings-wrap {
    background: white; border: 1px solid #e5e7eb;
    border-radius: 1rem; overflow: hidden; margin-bottom: 1.75rem;
}
.ud-table { width: 100%; border-collapse: collapse; }
.ud-table th {
    background: #f8fafc; padding: 0.875rem 1.25rem;
    text-align: left; font-size: 0.78rem; font-weight: 700;
    color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em;
    border-bottom: 1px solid #e5e7eb;
}
.ud-table td {
    padding: 1rem 1.25rem; border-bottom: 1px solid #f1f5f9;
    font-size: 0.875rem; color: #374151; vertical-align: middle;
}
.ud-table tr:last-child td { border-bottom: none; }
.ud-table tr:hover td { background: #f8fafc; }

.badge {
    display: inline-flex; align-items: center; gap: 0.3rem;
    padding: 0.25rem 0.625rem; border-radius: 2rem;
    font-size: 0.73rem; font-weight: 700;
}
.badge-confirmed { background: #d1fae5; color: #065f46; }
.badge-pending   { background: #fef3c7; color: #92400e; }
.badge-completed { background: #dbeafe; color: #1e40af; }
.badge-cancelled, .badge-rejected { background: #fee2e2; color: #7f1d1d; }

.action-link {
    color: #2563eb; text-decoration: none; font-weight: 600; font-size: 0.82rem;
    display: inline-flex; align-items: center; gap: 0.3rem; transition: color 0.15s;
}
.action-link:hover { color: #1d4ed8; }
.refund-btn {
    display: inline-flex; align-items: center; gap: 0.3rem;
    color: #d97706; font-size: 0.78rem; font-weight: 600;
    text-decoration: none; margin-left: 0.625rem;
}
.refund-btn:hover { color: #b45309; }
.review-btn {
    display: inline-flex; align-items: center; gap: 0.3rem;
    color: #7c3aed; font-size: 0.78rem; font-weight: 600;
    text-decoration: none; margin-left: 0.625rem;
}
.review-btn:hover { color: #6d28d9; }

/* Empty state */
.ud-empty { padding: 3rem; text-align: center; }
.ud-empty-emoji { font-size: 3rem; margin-bottom: 0.75rem; }
.ud-empty-title { font-size: 1rem; font-weight: 700; color: #374151; margin-bottom: 0.4rem; }
.ud-empty-sub   { font-size: 0.85rem; color: #9ca3af; }

/* Reviews grid */
.ud-reviews-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(270px, 1fr)); gap: 1rem; }
.ud-review-card {
    background: white; border: 1px solid #e5e7eb; border-radius: 1rem; padding: 1.25rem;
    transition: box-shadow 0.2s;
}
.ud-review-card:hover { box-shadow: 0 4px 16px rgba(37,99,235,0.1); }
.ud-review-stars { color: #f59e0b; font-size: 1rem; margin-bottom: 0.5rem; }
.ud-review-text  { font-size: 0.85rem; color: #374151; line-height: 1.6; margin-bottom: 0.5rem; }
.ud-review-meta  { font-size: 0.75rem; color: #9ca3af; }

@media (max-width: 768px) {
    .ud-profile-card { flex-wrap: wrap; }
    .ud-table th:nth-child(3), .ud-table td:nth-child(3) { display: none; }
}
</style>

<div>
    {{-- Profile Header --}}
    <div class="ud-profile-card">
        <div class="ud-avatar">
            @if($user->photo)
                <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}">
            @else
                {{ strtoupper(substr($user->name, 0, 1)) }}
            @endif
        </div>
        <div class="ud-profile-info">
            <div class="ud-profile-name">{{ $user->name }}</div>
            <div class="ud-profile-email">{{ $user->email }}</div>
            <div class="ud-profile-badge">
                ✓ {{ $locale === 'id' ? 'Pelanggan Terverifikasi' : 'Verified Customer' }}
            </div>
        </div>
        <a href="{{ route('profile.edit') }}" class="ud-edit-btn">
            ✏️ {{ $locale === 'id' ? 'Edit Profil' : 'Edit Profile' }}
        </a>
    </div>

    {{-- Quick Stats (no Total Pengeluaran) --}}
    <div class="ud-stats">
        <div class="ud-stat-card">
            <div class="ud-stat-icon" style="background:#dbeafe;">🎫</div>
            <div>
                <div class="ud-stat-value">{{ ($travelBookings ?? 0) + ($rentalBookings ?? 0) }}</div>
                <div class="ud-stat-label">{{ $locale === 'id' ? 'Total Booking' : 'Total Bookings' }}</div>
            </div>
        </div>
        <div class="ud-stat-card">
            <div class="ud-stat-icon" style="background:#d1fae5;">✅</div>
            <div>
                <div class="ud-stat-value">{{ $completedBookings ?? 0 }}</div>
                <div class="ud-stat-label">{{ $locale === 'id' ? 'Selesai' : 'Completed' }}</div>
            </div>
        </div>
        <div class="ud-stat-card">
            <div class="ud-stat-icon" style="background:#fef3c7;">⏳</div>
            <div>
                <div class="ud-stat-value">{{ $pendingBookings ?? 0 }}</div>
                <div class="ud-stat-label">{{ $locale === 'id' ? 'Menunggu' : 'Pending' }}</div>
            </div>
        </div>
        <div class="ud-stat-card">
            <div class="ud-stat-icon" style="background:#fce7f3;">⭐</div>
            <div>
                <div class="ud-stat-value">{{ $user->rating ?? '—' }}</div>
                <div class="ud-stat-label">{{ $locale === 'id' ? 'Rating Anda' : 'Your Rating' }}</div>
            </div>
        </div>
    </div>



    {{-- My Bookings --}}
    <div class="ud-section-head">
        <div class="ud-section-title">{{ $locale === 'id' ? 'Perjalanan Terbaru' : 'Recent Bookings' }}</div>
        <div style="display: flex; gap: 1rem; align-items: center;">
            <div style="position: relative; display: inline-block;" onmouseleave="document.getElementById('new-booking-dropdown').style.display='none'">
                <button onmouseover="document.getElementById('new-booking-dropdown').style.display='block'"
                        style="background: #2563eb; color: white; border: none; padding: 0.4rem 1rem; border-radius: 0.5rem; font-size: 0.8rem; font-weight: 600; cursor: pointer;">
                    + {{ $locale === 'id' ? 'Pesan Baru' : 'New Booking' }}
                </button>
                <div id="new-booking-dropdown" style="display: none; position: absolute; right: 0; top: 100%; background: white; border: 1px solid #e5e7eb; border-radius: 0.5rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); width: 160px; z-index: 10; overflow: hidden;">
                    <a href="{{ url('/travel') }}" style="display: block; padding: 0.75rem 1rem; color: #374151; text-decoration: none; font-size: 0.85rem; border-bottom: 1px solid #f3f4f6;">Travel</a>
                    <a href="{{ url('/rental') }}" style="display: block; padding: 0.75rem 1rem; color: #374151; text-decoration: none; font-size: 0.85rem; border-bottom: 1px solid #f3f4f6;">Rental</a>
                    <a href="{{ url('/airport') }}" style="display: block; padding: 0.75rem 1rem; color: #374151; text-decoration: none; font-size: 0.85rem;">Airport Transfer</a>
                </div>
            </div>
            <a href="{{ route('bookings.index') }}" class="ud-see-all">
                {{ $locale === 'id' ? 'Lihat semua →' : 'See all →' }}
            </a>
        </div>
    </div>

    <div class="ud-bookings-wrap">
        @if(isset($recentBookings) && $recentBookings->count() > 0)
            <table class="ud-table">
                <thead>
                    <tr>
                        <th>{{ $locale === 'id' ? 'Kode' : 'Code' }}</th>
                        <th>{{ $locale === 'id' ? 'Rute' : 'Route' }}</th>
                        <th>{{ $locale === 'id' ? 'Harga' : 'Price' }}</th>
                        <th>Status</th>
                        <th>{{ $locale === 'id' ? 'Aksi' : 'Actions' }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentBookings as $booking)
                    <tr>
                        <td><span style="font-weight:700;color:#111;">{{ $booking->booking_code }}</span></td>
                        <td>
                            @if($booking->route)
                                <span style="font-size:0.82rem;">
                                    {{ $booking->route->fromLocation->name ?? ($booking->route->name ?? '—') }}
                                </span>
                            @else
                                <span style="color:#9ca3af;">—</span>
                            @endif
                        </td>
                        <td style="font-weight:700;color:#2563eb;">
                            Rp {{ number_format($booking->total_price ?? $booking->final_price ?? 0, 0, ',', '.') }}
                        </td>
                        <td>
                            @php
                                $statusClass = match($booking->status) {
                                    'confirmed'  => 'badge-confirmed',
                                    'pending'    => 'badge-pending',
                                    'completed'  => 'badge-completed',
                                    default      => 'badge-cancelled',
                                };
                            @endphp
                            <span class="badge {{ $statusClass }}">{{ ucfirst($booking->status) }}</span>
                        </td>
                        <td>
                            {{-- View detail --}}
                            @if(Route::has('bookings.travel.show'))
                                <a href="{{ route('bookings.travel.show', $booking->id) }}" class="action-link">
                                    {{ $locale === 'id' ? 'Detail' : 'View' }} →
                                </a>
                            @endif

                            {{-- Refund (inline action, for pending/confirmed) --}}
                            @if(in_array($booking->status, ['confirmed','pending']) && Route::has('bookings.refund.create'))
                                <a href="{{ route('bookings.refund.create', $booking->id) }}" class="refund-btn">
                                    💰 Refund
                                </a>
                            @endif

                            {{-- Review only after completed --}}
                            @if($booking->status === 'completed' && Route::has('bookings.review.create'))
                                <a href="{{ route('bookings.review.create', $booking->id) }}" class="review-btn">
                                    ⭐ {{ $locale === 'id' ? 'Ulasan' : 'Review' }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="ud-empty">
                <div class="ud-empty-emoji">📭</div>
                <div class="ud-empty-title">{{ $locale === 'id' ? 'Belum ada perjalanan' : 'No trips yet' }}</div>
                <div class="ud-empty-sub">
                    {{ $locale === 'id'
                        ? 'Mulai perjalanan pertama Anda dengan memilih layanan kami.'
                        : 'Start your first trip by choosing our services.' }}
                </div>
                <div style="display: flex; justify-content: center; gap: 0.75rem; margin-top: 1.25rem; flex-wrap: wrap;">
                    <a href="{{ url('/travel') }}"
                       style="display:inline-flex;align-items:center;padding:0.625rem 1.25rem;background:#2563eb;color:white;border-radius:0.625rem;text-decoration:none;font-weight:600;font-size:0.875rem;transition:background 0.2s;" onmouseover="this.style.background='#1d4ed8'" onmouseout="this.style.background='#2563eb'">
                        Travel
                    </a>
                    <a href="{{ url('/rental') }}"
                       style="display:inline-flex;align-items:center;padding:0.625rem 1.25rem;background:#2563eb;color:white;border-radius:0.625rem;text-decoration:none;font-weight:600;font-size:0.875rem;transition:background 0.2s;" onmouseover="this.style.background='#1d4ed8'" onmouseout="this.style.background='#2563eb'">
                        Rental
                    </a>
                    <a href="{{ url('/airport') }}"
                       style="display:inline-flex;align-items:center;padding:0.625rem 1.25rem;background:#2563eb;color:white;border-radius:0.625rem;text-decoration:none;font-weight:600;font-size:0.875rem;transition:background 0.2s;" onmouseover="this.style.background='#1d4ed8'" onmouseout="this.style.background='#2563eb'">
                        Airport Transfer
                    </a>
                </div>
            </div>
        @endif
    </div>

    {{-- My Reviews – only shown when user has completed bookings --}}
    @if(($completedBookings ?? 0) > 0)
        @php $myReviews = $user->reviews()->latest()->take(4)->get() ?? collect(); @endphp

        <div class="ud-section-head">
            <div class="ud-section-title">{{ $locale === 'id' ? 'Ulasan Saya' : 'My Reviews' }}</div>
            <a href="{{ route('bookings.index', ['filter' => 'review']) }}" class="ud-see-all">
                {{ $locale === 'id' ? 'Kelola ulasan →' : 'Manage reviews →' }}
            </a>
        </div>

        @if($myReviews->count() > 0)
            <div class="ud-reviews-grid">
                @foreach($myReviews as $review)
                <div class="ud-review-card">
                    <div class="ud-review-stars">
                        @for($i = 1; $i <= 5; $i++){{ $i <= ($review->rating ?? 0) ? '★' : '☆' }}@endfor
                    </div>
                    <div class="ud-review-text">{{ $review->comment ?? ($locale === 'id' ? 'Tidak ada komentar' : 'No comment') }}</div>
                    <div class="ud-review-meta">{{ $review->created_at?->format('d M Y') ?? '—' }}</div>
                </div>
                @endforeach
            </div>
        @else
            <div style="background:white;border:1px solid #e5e7eb;border-radius:1rem;padding:2rem;text-align:center;color:#9ca3af;font-size:0.875rem;">
                ⭐ {{ $locale === 'id'
                    ? 'Anda belum memberikan ulasan. Klik "Ulasan" pada perjalanan yang sudah selesai.'
                    : 'No reviews yet. Click "Review" on a completed booking.' }}
            </div>
        @endif
    @endif
</div>
@endsection
