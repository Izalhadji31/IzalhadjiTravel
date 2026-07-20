@extends('layouts.app')

@section('title', app()->getLocale() === 'id' ? 'Dashboard Saya' : 'My Dashboard')

@section('content')
@php
    $locale = app()->getLocale();
    $user   = Auth::user();
@endphp

<style>
    /* ===== TRACGO-STYLE USER DASHBOARD ===== */
    .ud-wrap { padding: 0; }

    /* Profile Header Card */
    .ud-profile-card {
        background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 60%, #3b82f6 100%);
        border-radius: 1.25rem;
        padding: 2rem;
        display: flex;
        align-items: center;
        gap: 1.5rem;
        margin-bottom: 1.75rem;
        position: relative;
        overflow: hidden;
    }
    .ud-profile-card::before {
        content: '';
        position: absolute; inset: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
    .ud-avatar {
        width: 72px; height: 72px; border-radius: 50%;
        background: rgba(255,255,255,0.2);
        border: 3px solid rgba(255,255,255,0.5);
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
        background: rgba(255,255,255,0.2); color: white;
        border: 1px solid rgba(255,255,255,0.3);
        padding: 0.25rem 0.75rem; border-radius: 2rem;
        font-size: 0.75rem; font-weight: 700;
        margin-top: 0.5rem; backdrop-filter: blur(4px);
    }
    .ud-edit-btn {
        background: rgba(255,255,255,0.15);
        border: 1.5px solid rgba(255,255,255,0.4);
        color: white; text-decoration: none;
        padding: 0.5rem 1.25rem; border-radius: 0.625rem;
        font-size: 0.82rem; font-weight: 600;
        transition: background 0.2s;
        position: relative; z-index: 1;
    }
    .ud-edit-btn:hover { background: rgba(255,255,255,0.28); }

    /* Quick Stats */
    .ud-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 1rem;
        margin-bottom: 1.75rem;
    }
    .ud-stat-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 1rem;
        padding: 1.25rem;
        display: flex; align-items: center; gap: 1rem;
        transition: box-shadow 0.2s, transform 0.2s;
    }
    .ud-stat-card:hover { box-shadow: 0 6px 20px rgba(37,99,235,0.1); transform: translateY(-2px); }
    .ud-stat-icon {
        width: 44px; height: 44px; border-radius: 0.75rem;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.3rem; flex-shrink: 0;
    }
    .ud-stat-value { font-size: 1.4rem; font-weight: 800; color: #111; line-height: 1; }
    .ud-stat-label { font-size: 0.75rem; color: #6b7280; font-weight: 500; margin-top: 0.2rem; }

    /* Section Header */
    .ud-section-head {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 1rem;
    }
    .ud-section-title {
        font-size: 1rem; font-weight: 800; color: #111;
        display: flex; align-items: center; gap: 0.5rem;
    }
    .ud-section-title::before {
        content: '';
        width: 4px; height: 1.1rem; background: #2563eb; border-radius: 2px;
    }
    .ud-see-all {
        font-size: 0.8rem; color: #2563eb; text-decoration: none; font-weight: 600;
    }
    .ud-see-all:hover { text-decoration: underline; }

    /* Booking Table */
    .ud-bookings-wrap {
        background: white; border: 1px solid #e5e7eb;
        border-radius: 1rem; overflow: hidden;
        margin-bottom: 1.75rem;
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
        padding: 0.25rem 0.6rem; border-radius: 2rem;
        font-size: 0.73rem; font-weight: 700;
    }
    .badge-confirmed { background: #d1fae5; color: #065f46; }
    .badge-pending   { background: #fef3c7; color: #92400e; }
    .badge-completed { background: #dbeafe; color: #1e40af; }
    .badge-cancelled { background: #fee2e2; color: #7f1d1d; }

    .action-link {
        color: #2563eb; text-decoration: none; font-weight: 600; font-size: 0.82rem;
        display: inline-flex; align-items: center; gap: 0.3rem;
        transition: color 0.15s;
    }
    .action-link:hover { color: #1d4ed8; }

    /* Refund action inline */
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
    .ud-empty {
        padding: 3rem; text-align: center;
    }
    .ud-empty-emoji { font-size: 3rem; margin-bottom: 0.75rem; }
    .ud-empty-title { font-size: 1rem; font-weight: 700; color: #374151; margin-bottom: 0.4rem; }
    .ud-empty-sub   { font-size: 0.85rem; color: #9ca3af; }

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

    /* My Reviews section */
    .ud-reviews-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1rem; }
    .ud-review-card {
        background: white; border: 1px solid #e5e7eb; border-radius: 1rem; padding: 1.25rem;
        transition: box-shadow 0.2s;
    }
    .ud-review-card:hover { box-shadow: 0 4px 16px rgba(37,99,235,0.1); }
    .ud-review-stars { color: #f59e0b; font-size: 1rem; margin-bottom: 0.5rem; }
    .ud-review-text  { font-size: 0.85rem; color: #374151; line-height: 1.6; margin-bottom: 0.5rem; }
    .ud-review-meta  { font-size: 0.75rem; color: #9ca3af; }

    @media (max-width: 768px) {
        .ud-profile-card { flex-direction: column; text-align: center; }
        .ud-table th:nth-child(3), .ud-table td:nth-child(3) { display: none; }
    }
    @media (max-width: 540px) {
        .ud-table { display: none; }
        .ud-mobile-list { display: block; }
    }
</style>

<div class="ud-wrap">

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
                ✓ {{ $locale === 'id' ? 'Pelanggan' : 'Customer' }}
            </div>
        </div>
        <a href="{{ route('profile.edit') }}" class="ud-edit-btn">
            ✏️ {{ $locale === 'id' ? 'Edit Profil' : 'Edit Profile' }}
        </a>
    </div>

    {{-- Quick Stats (no total pengeluaran) --}}
    <div class="ud-stats">
        <div class="ud-stat-card">
            <div class="ud-stat-icon" style="background:#dbeafe;">🎫</div>
            <div>
                <div class="ud-stat-value">{{ $totalTrips }}</div>
                <div class="ud-stat-label">{{ $locale === 'id' ? 'Total Perjalanan' : 'Total Trips' }}</div>
            </div>
        </div>
        <div class="ud-stat-card">
            <div class="ud-stat-icon" style="background:#d1fae5;">✅</div>
            <div>
                <div class="ud-stat-value">{{ $bookings->where('status','completed')->count() }}</div>
                <div class="ud-stat-label">{{ $locale === 'id' ? 'Selesai' : 'Completed' }}</div>
            </div>
        </div>
        <div class="ud-stat-card">
            <div class="ud-stat-icon" style="background:#fef3c7;">⏳</div>
            <div>
                <div class="ud-stat-value">{{ $bookings->where('status','pending')->count() + $bookings->where('status','confirmed')->count() }}</div>
                <div class="ud-stat-label">{{ $locale === 'id' ? 'Aktif' : 'Active' }}</div>
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

    {{-- Cannot Book Notice --}}
    <div class="ud-notice">
        <span class="ud-notice-icon">🚧</span>
        <div>
            <div class="ud-notice-title">
                {{ $locale === 'id' ? 'Pemesanan Melalui Aplikasi Segera Hadir' : 'In-App Booking Coming Soon' }}
            </div>
            <div class="ud-notice-sub">
                {{ $locale === 'id'
                    ? 'Saat ini pemesanan travel dan rental dapat dilakukan melalui Call Center kami. Fitur booking online akan segera tersedia.'
                    : 'Currently, travel and rental bookings can be made via our Call Center. Online booking will be available soon.' }}
                <a href="tel:+6283156408078" style="color:#b45309; font-weight:700; margin-left:0.25rem;">
                    📞 {{ $locale === 'id' ? 'Hubungi Call Center' : 'Call Center' }} →
                </a>
            </div>
        </div>
    </div>

    {{-- My Bookings Section --}}
    <div class="ud-section-head">
        <div class="ud-section-title">{{ $locale === 'id' ? 'Perjalanan Saya' : 'My Bookings' }}</div>
        <a href="{{ route('bookings.index') }}" class="ud-see-all">
            {{ $locale === 'id' ? 'Lihat semua →' : 'See all →' }}
        </a>
    </div>

    <div class="ud-bookings-wrap">
        @if($bookings->count() > 0)
            <table class="ud-table">
                <thead>
                    <tr>
                        <th>{{ $locale === 'id' ? 'Kode Booking' : 'Booking Code' }}</th>
                        <th>{{ $locale === 'id' ? 'Rute' : 'Route' }}</th>
                        <th>{{ $locale === 'id' ? 'Harga' : 'Price' }}</th>
                        <th>Status</th>
                        <th>{{ $locale === 'id' ? 'Aksi' : 'Action' }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $booking)
                        <tr>
                            <td>
                                <span style="font-weight:700; color:#111;">{{ $booking->booking_code }}</span>
                            </td>
                            <td>
                                @if($booking->route)
                                    {{ $booking->route->fromLocation->name ?? '—' }}
                                    <span style="color:#9ca3af; margin:0 0.3rem;">→</span>
                                    {{ $booking->route->toLocation->name ?? '—' }}
                                @else
                                    <span style="color:#9ca3af;">—</span>
                                @endif
                            </td>
                            <td style="font-weight:700; color:#2563eb;">
                                Rp {{ number_format($booking->final_price, 0, ',', '.') }}
                            </td>
                            <td>
                                @php
                                    $badgeClass = match($booking->status) {
                                        'confirmed'  => 'badge-confirmed',
                                        'pending'    => 'badge-pending',
                                        'completed'  => 'badge-completed',
                                        default      => 'badge-cancelled',
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('bookings.detail', $booking->id) }}" class="action-link">
                                    {{ $locale === 'id' ? 'Detail' : 'View' }} →
                                </a>

                                {{-- Refund (inline, only for confirmed/pending) --}}
                                @if(in_array($booking->status, ['confirmed','pending']))
                                    <a href="{{ route('bookings.refund.create', $booking->id) }}" class="refund-btn">
                                        💰 {{ $locale === 'id' ? 'Refund' : 'Refund' }}
                                    </a>
                                @endif

                                {{-- Review (only after completed) --}}
                                @if($booking->status === 'completed')
                                    <a href="{{ route('bookings.review.create', $booking->id) }}" class="review-btn">
                                        ⭐ {{ $locale === 'id' ? 'Beri Ulasan' : 'Review' }}
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if($bookings->hasPages())
                <div style="padding: 1rem 1.25rem; border-top: 1px solid #e5e7eb;">
                    {{ $bookings->links() }}
                </div>
            @endif
        @else
            <div class="ud-empty">
                <div class="ud-empty-emoji">📭</div>
                <div class="ud-empty-title">{{ $locale === 'id' ? 'Belum ada perjalanan' : 'No bookings yet' }}</div>
                <div class="ud-empty-sub">
                    {{ $locale === 'id'
                        ? 'Untuk memulai, hubungi Call Center kami.'
                        : 'To get started, contact our Call Center.' }}
                </div>
                <a href="tel:+6283156408078"
                   style="display:inline-flex;align-items:center;gap:0.5rem;margin-top:1rem;padding:0.625rem 1.5rem;background:#2563eb;color:white;border-radius:0.625rem;text-decoration:none;font-weight:700;font-size:0.875rem;">
                    📞 {{ $locale === 'id' ? 'Hubungi Call Center' : 'Call Center' }}
                </a>
            </div>
        @endif
    </div>

    {{-- My Reviews (only shows if user has completed bookings) --}}
    @php
        $completedBookings = $bookings->filter(fn($b) => $b->status === 'completed');
        $reviews = $user->reviews()->latest()->take(4)->get();
    @endphp

    @if($completedBookings->count() > 0)
        <div class="ud-section-head">
            <div class="ud-section-title">{{ $locale === 'id' ? 'Ulasan Saya' : 'My Reviews' }}</div>
            <a href="{{ route('bookings.index', ['filter' => 'review']) }}" class="ud-see-all">
                {{ $locale === 'id' ? 'Kelola ulasan →' : 'Manage reviews →' }}
            </a>
        </div>

        @if($reviews->count() > 0)
            <div class="ud-reviews-grid">
                @foreach($reviews as $review)
                    <div class="ud-review-card">
                        <div class="ud-review-stars">
                            @for($i = 1; $i <= 5; $i++)
                                {{ $i <= ($review->rating ?? 0) ? '★' : '☆' }}
                            @endfor
                        </div>
                        <div class="ud-review-text">{{ $review->comment ?? ($locale === 'id' ? 'Tidak ada komentar' : 'No comment') }}</div>
                        <div class="ud-review-meta">
                            {{ $review->created_at?->format('d M Y') ?? '—' }}
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div style="background:white; border:1px solid #e5e7eb; border-radius:1rem; padding:2rem; text-align:center; color:#9ca3af; font-size:0.875rem;">
                ⭐ {{ $locale === 'id' ? 'Anda belum memberikan ulasan. Klik "Beri Ulasan" pada perjalanan yang sudah selesai.' : 'You have not given any reviews yet. Click "Review" on a completed trip.' }}
            </div>
        @endif
    @endif

</div>
@endsection
