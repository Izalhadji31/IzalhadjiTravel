@extends('layouts.app')

@section('title', __('driver.dashboard_title'))

@section('content')
<style>
    .tracgo-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
    }
    .tracgo-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1a1a1a;
    }
    .tracgo-greeting {
        font-size: 0.875rem;
        color: #6b7280;
        margin-top: 0.25rem;
    }
    /* Status Toggle */
    .status-card {
        background: white;
        border-radius: 1rem;
        padding: 1.5rem;
        border: 1px solid #e5e7eb;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .status-left {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .status-indicator {
        width: 14px;
        height: 14px;
        border-radius: 50%;
        display: inline-block;
    }
    .status-online { background-color: #22c55e; box-shadow: 0 0 8px rgba(34,197,94,0.4); }
    .status-offline { background-color: #ef4444; }
    .status-busy { background-color: #f59e0b; }
    .status-label {
        font-weight: 600;
        font-size: 1rem;
        color: #1a1a1a;
    }
    .status-desc {
        font-size: 0.8rem;
        color: #6b7280;
    }
    .status-form {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .status-toggle-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.875rem 2rem;
        border-radius: 0.75rem;
        font-weight: 700;
        font-size: 1.1rem;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        letter-spacing: 0.02em;
    }
    .status-toggle-btn.online {
        background-color: #22c55e;
        color: white;
    }
    .status-toggle-btn.online:hover { background-color: #16a34a; }
    .status-toggle-btn.offline {
        background-color: #ef4444;
        color: white;
    }
    .status-toggle-btn.offline:hover { background-color: #dc2626; }
    .status-toggle-btn.busy {
        background-color: #f59e0b;
        color: white;
    }
    .status-toggle-btn.busy:hover { background-color: #d97706; }

    /* Stats Row */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.25rem;
        margin-bottom: 1.5rem;
    }
    .stat-card {
        background: white;
        border-radius: 1rem;
        padding: 1.5rem;
        border: 1px solid #e5e7eb;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    }
    .stat-label {
        font-size: 0.85rem;
        color: #6b7280;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
    .stat-value {
        font-size: 2rem;
        font-weight: 800;
    }
    .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .stat-icon svg { width: 28px; height: 28px; }
    .stat-blue .stat-value { color: #0064d2; }
    .stat-blue .stat-icon { background-color: rgba(0,100,210,0.1); color: #0064d2; }
    .stat-green .stat-value { color: #22c55e; }
    .stat-green .stat-icon { background-color: rgba(34,197,94,0.1); color: #22c55e; }
    .stat-orange .stat-value { color: #f59e0b; }
    .stat-orange .stat-icon { background-color: rgba(245,158,11,0.1); color: #f59e0b; }

    /* Orders Section */
    .orders-section {
        margin-top: 0.5rem;
    }
    .orders-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
    }
    .orders-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1a1a1a;
    }
    .orders-count {
        font-size: 0.85rem;
        color: #6b7280;
        background: #f3f4f6;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-weight: 600;
    }

    /* Order Card */
    .order-card {
        background: white;
        border-radius: 1rem;
        border: 1px solid #e5e7eb;
        padding: 1.5rem;
        margin-bottom: 1rem;
        transition: box-shadow 0.2s;
    }
    .order-card:hover {
        box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    }
    .order-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    .order-booking-code {
        font-weight: 700;
        font-size: 1.1rem;
        color: #1a1a1a;
        font-family: 'SF Mono', 'Consolas', monospace;
        letter-spacing: 0.02em;
    }
    .order-badges {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }
    .badge {
        display: inline-flex;
        align-items: center;
        padding: 0.3rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.02em;
    }
    .badge-travel { background-color: rgba(0,100,210,0.1); color: #0064d2; }
    .badge-rental { background-color: rgba(168,85,247,0.1); color: #7c3aed; }
    .badge-airport { background-color: rgba(14,165,233,0.1); color: #0284c7; }
    .badge-confirmed { background-color: rgba(34,197,94,0.1); color: #16a34a; }
    .badge-departed { background-color: rgba(245,158,11,0.1); color: #d97706; }
    .badge-active { background-color: rgba(0,100,210,0.1); color: #0064d2; }
    .badge-completed { background-color: #f3f4f6; color: #6b7280; }

    .order-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 1.25rem;
    }
    .order-detail-item {
        display: flex;
        flex-direction: column;
        gap: 0.2rem;
    }
    .order-detail-label {
        font-size: 0.75rem;
        color: #9ca3af;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }
    .order-detail-value {
        font-size: 0.95rem;
        color: #1a1a1a;
        font-weight: 600;
    }
    .order-detail-value.price {
        color: #0064d2;
        font-size: 1.1rem;
    }
    .order-route {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.95rem;
        color: #1a1a1a;
        font-weight: 600;
    }
    .route-arrow {
        color: #9ca3af;
        font-size: 0.85rem;
    }

    /* Action Buttons */
    .order-actions {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
        padding-top: 1rem;
        border-top: 1px solid #f3f4f6;
    }
    .action-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.625rem 1.25rem;
        border-radius: 0.625rem;
        font-weight: 600;
        font-size: 0.875rem;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
    }
    .action-btn svg { width: 18px; height: 18px; }
    .btn-start {
        background-color: #0064d2;
        color: white;
    }
    .btn-start:hover { background-color: #0050a8; }
    .btn-complete {
        background-color: #22c55e;
        color: white;
    }
    .btn-complete:hover { background-color: #16a34a; }
    .btn-navigate {
        background-color: #f3f4f6;
        color: #1a1a1a;
        border: 1px solid #e5e7eb;
    }
    .btn-navigate:hover { background-color: #e5e7eb; }

    /* Empty State */
    .empty-state {
        background: white;
        border-radius: 1rem;
        border: 1px solid #e5e7eb;
        padding: 4rem 2rem;
        text-align: center;
    }
    .empty-icon {
        width: 80px;
        height: 80px;
        background: #f3f4f6;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
    }
    .empty-icon svg { width: 40px; height: 40px; color: #9ca3af; }
    .empty-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 0.5rem;
    }
    .empty-desc {
        font-size: 0.9rem;
        color: #6b7280;
        max-width: 400px;
        margin: 0 auto;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .stats-row { grid-template-columns: 1fr; }
        .status-card { flex-direction: column; align-items: flex-start; }
        .order-actions { flex-direction: column; }
        .action-btn { justify-content: center; }
    }
</style>

<!-- Header -->
<div class="tracgo-header">
    <div>
        <h1 class="tracgo-title">{{ __('driver.dashboard_title') }}</h1>
        <p class="tracgo-greeting">{{ __('driver.welcome', [':name' => auth()->user()->name]) }}</p>
    </div>
</div>

<!-- Status Toggle Card -->
<div class="status-card">
    <div class="status-left">
        <span class="status-indicator 
            {{ ($driverStatus ?? '') === 'available' ? 'status-online' : '' }}
            {{ ($driverStatus ?? '') === 'offline' ? 'status-offline' : '' }}
            {{ ($driverStatus ?? '') === 'busy' ? 'status-busy' : '' }}"></span>
        <div>
            <div class="status-label">
                {{ __('driver.status_label') }}: 
                @if(($driverStatus ?? '') === 'available')
                    {{ __('driver.online') }}
                @elseif(($driverStatus ?? '') === 'busy')
                    {{ __('driver.busy') }}
                @else
                    {{ __('driver.offline') }}
                @endif
            </div>
            <div class="status-desc">{{ __('driver.status_desc') }}</div>
        </div>
    </div>
    <form method="POST" action="{{ route('driver.status.toggle') }}" class="status-form">
        @csrf
        <input type="hidden" name="status" value="
            @if(($driverStatus ?? '') === 'available')
                offline
            @elseif(($driverStatus ?? '') === 'busy')
                available
            @else
                available
            @endif
        ">
        <button type="submit" class="status-toggle-btn 
            @if(($driverStatus ?? '') === 'available')
                online
            @elseif(($driverStatus ?? '') === 'busy')
                busy
            @else
                offline
            @endif">
            @if(($driverStatus ?? '') === 'available')
                {{ __('driver.online') }}
            @elseif(($driverStatus ?? '') === 'busy')
                {{ __('driver.busy') }}
            @else
                {{ __('driver.offline') }}
            @endif
        </button>
    </form>
</div>

<!-- Stats Row -->
<div class="stats-row">
    <div class="stat-card stat-blue">
        <div>
            <div class="stat-label">{{ __('driver.order_aktif') }}</div>
            <div class="stat-value">{{ $activeOrderCount ?? 0 }}</div>
        </div>
        <div class="stat-icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
        </div>
    </div>
    <div class="stat-card stat-green">
        <div>
            <div class="stat-label">{{ __('driver.total_trip') }}</div>
            <div class="stat-value">{{ $totalTrips ?? 0 }}</div>
        </div>
        <div class="stat-icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
    </div>
    <div class="stat-card stat-orange">
        <div>
            <div class="stat-label">{{ __('driver.saldo') }}</div>
            <div class="stat-value" style="font-size: 1.5rem;">Rp {{ number_format($balance ?? 0, 0, ',', '.') }}</div>
        </div>
        <div class="stat-icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
    </div>
</div>

<!-- Active Orders Section -->
<div class="orders-section">
    <div class="orders-header">
        <h2 class="orders-title">{{ __('driver.active_orders') }}</h2>
        <span class="orders-count">{{ $activeOrderCount ?? 0 }} {{ __('driver.order_count') }}</span>
    </div>

    @php
        $hasOrders = isset($activeOrders) && count($activeOrders) > 0;
    @endphp

    @if(!$hasOrders)
        <!-- Empty State -->
        <div class="empty-state">
            <div class="empty-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
            </div>
            <div class="empty-title">{{ __('driver.empty_title') }}</div>
            <div class="empty-desc">{{ __('driver.empty_desc') }}</div>
        </div>
    @else
        @foreach($activeOrders as $order)
            @php
                $isTravel = ($order->order_type ?? '') === 'travel';
                $isRental = ($order->order_type ?? '') === 'rental';
                $isAirport = ($order->order_type ?? '') === 'airport';
                $status = $order->status ?? 'pending';
                $bookingCode = $order->booking_code ?? ('#' . str_pad($order->id, 5, '0', STR_PAD_LEFT));
                $customerName = $order->user->name ?? 'Pelanggan';
                
                // Route info
                $origin = $isTravel ? ($order->route->origin_city ?? 'Kota Asal') : ($order->origin ?? 'Kota Asal');
                $destination = $isTravel ? ($order->route->destination_city ?? 'Kota Tujuan') : ($order->destination ?? 'Kota Tujuan');
                
                // Date
                $orderDate = $order->scheduled_date ?? $order->start_date ?? $order->created_at ?? now();
                $formattedDate = \Carbon\Carbon::parse($orderDate)->locale('id')->isoFormat('DD MMM YYYY, HH:mm');
                
                // Price
                $price = $order->total_price ?? $order->price ?? $order->driver_fee ?? 0;
                
                // Navigation URL
                $navUrl = 'https://www.google.com/maps/dir/?api=1&destination=' . urlencode($destination);
            @endphp

            <div class="order-card">
                <div class="order-top">
                    <span class="order-booking-code">{{ $bookingCode }}</span>
                    <div class="order-badges">
                        @if($isTravel)
                            <span class="badge badge-travel">{{ __('driver.badge_travel') }}</span>
                        @elseif($isRental)
                            <span class="badge badge-rental">{{ __('driver.badge_rental') }}</span>
                        @elseif($isAirport)
                            <span class="badge badge-airport">{{ __('driver.badge_airport') }}</span>
                        @endif

                        @if($status === 'confirmed')
                            <span class="badge badge-confirmed">{{ __('driver.status_confirmed') }}</span>
                        @elseif($status === 'departed')
                            <span class="badge badge-departed">{{ __('driver.status_departed') }}</span>
                        @elseif($status === 'active')
                            <span class="badge badge-active">{{ __('driver.status_active') }}</span>
                        @elseif($status === 'completed')
                            <span class="badge badge-completed">{{ __('driver.status_completed') }}</span>
                        @endif
                    </div>
                </div>

                <div class="order-details">
                    <div class="order-detail-item">
                        <span class="order-detail-label">{{ __('driver.label_customer') }}</span>
                        <span class="order-detail-value">{{ $customerName }}</span>
                    </div>
                    <div class="order-detail-item">
                        <span class="order-detail-label">{{ __('driver.label_route') }}</span>
                        <div class="order-route">
                            <span>{{ $origin }}</span>
                            <span class="route-arrow">&rarr;</span>
                            <span>{{ $destination }}</span>
                        </div>
                    </div>
                    <div class="order-detail-item">
                        <span class="order-detail-label">{{ __('driver.label_date') }}</span>
                        <span class="order-detail-value">{{ $formattedDate }}</span>
                    </div>
                    <div class="order-detail-item">
                        <span class="order-detail-label">{{ __('driver.label_price') }}</span>
                        <span class="order-detail-value price">Rp {{ number_format($price, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="order-actions">
                    @if($status === 'confirmed')
                        <form method="POST" action="{{ route('driver.trip.start', ['booking' => $order->id, 'type' => $isTravel ? 'travel' : 'rental']) }}" style="display:inline;">
                            @csrf
                            <button type="submit" class="action-btn btn-start">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ __('driver.btn_start') }}
                            </button>
                        </form>
                    @endif

                    @if($status === 'departed' || $status === 'active')
                        <form method="POST" action="{{ route('driver.trip.complete', ['booking' => $order->id, 'type' => $isTravel ? 'travel' : 'rental']) }}" style="display:inline;">
                            @csrf
                            <button type="submit" class="action-btn btn-complete">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                {{ __('driver.btn_complete') }}
                            </button>
                        </form>
                    @endif

                    <a href="{{ $navUrl }}" target="_blank" rel="noopener" class="action-btn btn-navigate">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        {{ __('driver.btn_navigate') }}
                    </a>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
