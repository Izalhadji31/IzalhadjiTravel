@extends('layouts.app')

@section('title', 'Pesan Tiket Travel')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap');

    .travel-booking-wrapper { font-family: 'Inter', sans-serif; }

    /* ── STEP INDICATOR ── */
    .step-wrap { display: flex; align-items: center; gap: 0; margin-bottom: 28px; }
    .step-item  { display: flex; flex-direction: column; align-items: center; flex: 1; position: relative; }
    .step-circle {
        width: 36px; height: 36px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 14px; font-weight: 800; z-index: 1;
        transition: all .3s;
    }
    .step-circle.done   { background: #10b981; color: #fff; }
    .step-circle.active { background: #2563eb; color: #fff; box-shadow: 0 0 0 4px rgba(37,99,235,.2); }
    .step-circle.idle   { background: #f1f5f9; color: #94a3b8; }
    .step-label { font-size: 11px; font-weight: 700; margin-top: 6px; color: #6b7280; text-align: center; }
    .step-label.active { color: #2563eb; }
    .step-line { flex: 1; height: 3px; background: #e5e7eb; margin-top: -17px; transition: background .3s; }
    .step-line.done { background: #10b981; }

    /* ── SECTION CARD ── */
    .section-card {
        background: #fff; border: 1.5px solid #e5e7eb;
        border-radius: 20px; padding: 24px;
        box-shadow: 0 2px 12px rgba(0,0,0,.05);
        transition: opacity .3s, filter .3s, border-color .3s, background-color .3s;
        margin-bottom: 20px;
        position: relative;
    }
    .section-card.locked {
        opacity: 0.7; border-color: #fed7aa;
        background: #fffbeb;
    }
    .section-title {
        display: flex; align-items: center; gap: 10px;
        padding-bottom: 16px; border-bottom: 1px solid #f1f5f9; margin-bottom: 20px;
    }
    .section-num {
        width: 28px; height: 28px; border-radius: 50%;
        background: #2563eb; color: #fff;
        display: flex; align-items: center; justify-content: center;
        font-size: 12px; font-weight: 800; flex-shrink: 0;
    }
    .section-num.done { background: #10b981; }

    /* ── FORM INPUTS ── */
    .form-field {
        width: 100%; padding: 10px 14px;
        border: 2px solid #e5e7eb; border-radius: 10px;
        background: #fff; font-size: 14px; color: #111827;
        transition: border-color .15s; outline: none;
        font-family: 'Inter', sans-serif;
    }
    .form-field:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,.1); }

    /* ── SEAT MAP ── */
    .seat-map-vehicle {
        background: #fff; border: 2px solid #e5e7eb;
        border-radius: 20px; padding: 16px;
        max-width: 260px; margin: 0 auto;
        box-shadow: inset 0 2px 8px rgba(0,0,0,.04);
    }
    .seat-map-vehicle::before {
        content: ''; display: block; height: 12px;
        background: linear-gradient(to right, #dbeafe, #eff6ff);
        border-radius: 10px 10px 0 0;
        margin: -16px -16px 12px -16px;
        border-bottom: 2px dashed #bfdbfe;
    }
    .seat-btn {
        width: 100%; aspect-ratio: 1; border-radius: 10px;
        border: 2px solid #d1d5db; background: #fff;
        font-size: 11px; font-weight: 700; color: #6b7280;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: all .18s cubic-bezier(.4,0,.2,1);
        position: relative; overflow: hidden; user-select: none;
    }
    .seat-btn.available:hover {
        border-color: #3b82f6; background: #eff6ff; color: #1d4ed8;
        transform: scale(1.08); box-shadow: 0 4px 12px rgba(59,130,246,.3);
    }
    .seat-btn.selected {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        border-color: #1d4ed8; color: #fff;
        box-shadow: 0 4px 12px rgba(37,99,235,.5); transform: scale(1.05);
    }
    .seat-btn.occupied {
        background: #f3f4f6; border-color: #e5e7eb; color: #9ca3af;
        cursor: not-allowed; opacity: .7;
    }
    .seat-btn.driver-seat {
        background: linear-gradient(135deg, #374151, #1f2937);
        border-color: #111827; color: #fff; cursor: default; font-size: 10px;
    }
    .seat-btn.active-passenger {
        border-color: #f59e0b !important;
        box-shadow: 0 0 0 3px rgba(245,158,11,.3) !important;
    }

    /* ── PASSENGER CARD ── */
    .passenger-card {
        background: #f8fafc; border: 2px solid #e2e8f0;
        border-radius: 14px; padding: 14px;
        transition: all .2s; cursor: pointer;
    }
    .passenger-card.active {
        border-color: #3b82f6; background: #eff6ff;
        box-shadow: 0 0 0 4px rgba(59,130,246,.12);
    }
    .passenger-card.complete { border-color: #10b981; background: #f0fdf4; }

    /* ── JOURNEY SUMMARY (step 3) ── */
    .journey-summary {
        background: linear-gradient(135deg, #1e3a8a, #1d4ed8, #3b82f6);
        border-radius: 20px; overflow: hidden; color: #fff;
        box-shadow: 0 8px 32px rgba(30,64,175,.3);
    }
    .journey-route-row {
        display: flex; align-items: center; justify-content: space-between; gap: 12px;
        padding: 24px 24px 0;
    }
    .city-name { font-size: 22px; font-weight: 900; }
    .city-sub  { font-size: 11px; font-weight: 600; opacity: .7; margin-top: 2px; }
    .route-arrow {
        display: flex; flex-direction: column; align-items: center; gap: 4px;
        flex: 1;
    }
    .route-arrow .line {
        height: 2px; width: 100%; background: rgba(255,255,255,.3);
        position: relative; border-radius: 2px;
    }
    .route-arrow .line::after {
        content: '▶'; position: absolute; right: -6px; top: -9px;
        font-size: 16px; color: rgba(255,255,255,.7);
    }
    .journey-details {
        display: grid; grid-template-columns: 1fr 1fr 1fr;
        gap: 1px; background: rgba(255,255,255,.1);
        margin-top: 20px;
    }
    .detail-cell {
        background: rgba(0,0,0,.15);
        padding: 14px 16px;
        text-align: center;
    }
    .detail-cell-label { font-size: 10px; font-weight: 700; opacity: .6; text-transform: uppercase; letter-spacing: .06em; }
    .detail-cell-val   { font-size: 15px; font-weight: 800; margin-top: 3px; }
    .price-row {
        padding: 20px 24px;
        display: flex; align-items: center; justify-content: space-between;
        border-top: 1px solid rgba(255,255,255,.15);
    }
    .price-label { font-size: 13px; font-weight: 600; opacity: .8; }
    .price-value { font-size: 30px; font-weight: 900; }
    .price-sub   { font-size: 11px; opacity: .6; margin-top: 2px; }
    .seats-chips { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 10px; }
    .seat-chip {
        background: rgba(255,255,255,.2); border: 1px solid rgba(255,255,255,.3);
        border-radius: 20px; padding: 4px 12px; font-size: 12px; font-weight: 700;
    }

    /* ── SUBMIT BTN ── */
    .btn-pay {
        background: linear-gradient(135deg, #10b981, #059669);
        color: #fff; border: none; border-radius: 14px;
        padding: 16px 24px; font-size: 16px; font-weight: 800;
        width: 100%; cursor: pointer;
        box-shadow: 0 4px 16px rgba(16,185,129,.4);
        transition: all .2s;
        display: flex; align-items: center; justify-content: center; gap: 10px;
    }
    .btn-pay:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(16,185,129,.5);
    }
    .btn-pay:disabled {
        background: #e5e7eb; color: #9ca3af;
        box-shadow: none; cursor: not-allowed; transform: none;
    }

    /* ── LEGEND ── */
    .legend-dot {
        width: 14px; height: 14px; border-radius: 4px;
        border: 2px solid currentColor; flex-shrink: 0;
    }

    @media (max-width: 768px) {
        .two-col  { grid-template-columns: 1fr !important; }
        .seat-section { flex-direction: column !important; }
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50%       { opacity: .4; }
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .fade-in { animation: fadeIn .4s ease-out; }
</style>

<div class="mx-auto max-w-5xl px-2">

    {{-- Back & Title --}}
    <div class="mb-6">
        <a href="{{ route('bookings.index') }}"
           class="mb-4 inline-flex items-center gap-2 text-sm font-semibold text-slate-500 transition hover:text-blue-600">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar Pemesanan
        </a>
        <h1 class="mb-1 text-2xl font-black text-slate-900">Pesan Tiket Travel</h1>
        <p class="text-sm text-slate-500">Pilih rute → isi data penumpang → konfirmasi → bayar</p>
    </div>

    {{-- Step Indicator --}}
    <div class="step-wrap" id="stepIndicator">
        <div class="step-item">
            <div class="step-circle active" id="stepCircle1">1</div>
            <div class="step-label active" id="stepLabel1">Rute & Tanggal</div>
        </div>
        <div class="step-line" id="stepLine1"></div>
        <div class="step-item">
            <div class="step-circle idle" id="stepCircle2">2</div>
            <div class="step-label" id="stepLabel2">Data Penumpang</div>
        </div>
        <div class="step-line" id="stepLine2"></div>
        <div class="step-item">
            <div class="step-circle idle" id="stepCircle3">3</div>
            <div class="step-label" id="stepLabel3">Detail & Bayar</div>
        </div>
    </div>

    @if ($errors->any())
        <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4">
            <p class="mb-2 text-sm font-bold text-red-700">⚠️ Harap perbaiki kesalahan berikut:</p>
            <ul class="list-disc space-y-1 pl-5 text-sm text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('bookings.travel.store') }}" method="POST" id="travelBookingForm">
        @csrf

        {{-- ══════════════════════════════════════════════
             STEP 1: Rute & Tanggal
        ══════════════════════════════════════════════ --}}
        <div class="section-card" id="step1Card">
            <div class="section-title">
                <div class="section-num" id="sn1">1</div>
                <h2 style="font-size:16px;font-weight:800;color:#111827;margin:0;">Rute & Tanggal Keberangkatan</h2>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;" class="two-col">
                {{-- Route --}}
                <div>
                    <label style="display:block;font-size:11px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:.08em;margin-bottom:8px;">Rute Perjalanan *</label>
                    <div style="position:relative;">
                        <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#9ca3af;pointer-events:none;">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </span>
                        <select name="route_id" id="route_id" required class="form-field" style="padding-left:40px;">
                            <option value="">-- Pilih Rute --</option>
                            @foreach ($routes as $route)
                                <option value="{{ $route->id }}"
                                        data-price="{{ optional($route->travelPrices->first())->price_per_seat ?? 0 }}"
                                        data-origin="{{ $route->origin_city }}"
                                        data-destination="{{ $route->destination_city }}"
                                        data-distance="{{ $route->distance_km }}"
                                        data-duration="{{ $route->estimated_hours }}"
                                        @selected(strtolower((string) old('route_id', $selectedRouteId ?? request('route_id'))) === strtolower((string) $route->id))>
                                    {{ $route->origin_city }} → {{ $route->destination_city }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                {{-- Date --}}
                <div>
                    <label style="display:block;font-size:11px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:.08em;margin-bottom:8px;">Tanggal Berangkat *</label>
                    <div style="position:relative;">
                        <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#9ca3af;pointer-events:none;">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </span>
                        <input type="date" name="scheduled_date" id="scheduled_date"
                               value="{{ old('scheduled_date', $selectedDate ?? request('date')) }}" required
                               min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                               class="form-field" style="padding-left:40px;">
                    </div>
                </div>
            </div>
            {{-- Step 1 CTA --}}
            <div id="step1Cta" style="margin-top:16px;display:none;">
                <div style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:12px;padding:12px 16px;display:flex;align-items:center;justify-content:space-between;gap:12px;">
                    <span style="font-size:13px;color:#1d4ed8;font-weight:600;" id="step1CtaText">Rute dipilih ✓</span>
                    <button type="button" id="goToStep2Btn"
                        style="background:#2563eb;color:#fff;border:none;border-radius:10px;padding:8px 20px;font-size:13px;font-weight:700;cursor:pointer;white-space:nowrap;">
                        Lanjut ke Data Penumpang →
                    </button>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════
             STEP 2: Data Penumpang
        ══════════════════════════════════════════════ --}}
        <div class="section-card locked" id="step2Card">
            <div class="section-title">
                <div class="section-num" id="sn2" style="background:#94a3b8;">2</div>
                <div>
                    <h2 style="font-size:16px;font-weight:800;color:#111827;margin:0;">Data Penumpang</h2>
                    <p style="font-size:12px;color:#6b7280;margin:2px 0 0;" id="seatSubtitle">Pilih rute & tanggal dahulu</p>
                </div>
                <div style="margin-left:auto;display:flex;align-items:center;gap:8px;">
                    <label style="font-size:13px;font-weight:600;color:#374151;">Jumlah:</label>
                    <select name="number_of_seats" id="number_of_seats"
                        style="padding:6px 10px;border:2px solid #e5e7eb;border-radius:8px;font-weight:700;font-size:14px;outline:none;background:#f9fafb;">
                        @for($i = 1; $i <= 6; $i++)
                            <option value="{{ $i }}" @selected((string) old('number_of_seats', $selectedPassengers ?? request('passengers', 1)) === (string) $i)>{{ $i }} Penumpang</option>
                        @endfor
                    </select>
                </div>
            </div>

            <div style="display:flex;flex-direction:column;gap:12px;">
                <div id="passengersContainer" style="display:flex;flex-direction:column;gap:12px;"></div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════
             STEP 3: Detail Perjalanan & Konfirmasi
        ══════════════════════════════════════════════ --}}
        <div class="section-card locked fade-in" id="step3Card">
            <div class="section-title">
                <div class="section-num" id="sn3" style="background:#94a3b8;">3</div>
                <h2 style="font-size:16px;font-weight:800;color:#111827;margin:0;">Detail Perjalanan & Pembayaran</h2>
            </div>

            {{-- Journey Summary Card --}}
            <div class="journey-summary" id="journeySummaryCard" style="display:none;">
                {{-- Route --}}
                <div class="journey-route-row">
                    <div>
                        <div class="city-name" id="js_origin">-</div>
                        <div class="city-sub">Kota Asal</div>
                    </div>
                    <div class="route-arrow">
                        <div class="line"></div>
                        <div style="font-size:10px;font-weight:700;opacity:.6;margin-top:4px;" id="js_dist">-</div>
                    </div>
                    <div style="text-align:right;">
                        <div class="city-name" id="js_dest">-</div>
                        <div class="city-sub">Kota Tujuan</div>
                    </div>
                </div>

                {{-- Details grid --}}
                <div class="journey-details">
                    <div class="detail-cell">
                        <div class="detail-cell-label">📅 Tanggal</div>
                        <div class="detail-cell-val" id="js_date">-</div>
                    </div>
                    <div class="detail-cell">
                        <div class="detail-cell-label">⏱ Estimasi</div>
                        <div class="detail-cell-val" id="js_dur">-</div>
                    </div>
                    <div class="detail-cell">
                        <div class="detail-cell-label">� Penumpang</div>
                        <div class="detail-cell-val" id="js_seats_count">-</div>
                    </div>
                </div>

                {{-- Passenger chips --}}
                <div style="padding:14px 24px;border-bottom:1px solid rgba(255,255,255,.15);">
                    <div style="font-size:11px;font-weight:700;opacity:.7;text-transform:uppercase;letter-spacing:.06em;margin-bottom:8px;">Data Penumpang</div>
                    <div class="seats-chips" id="js_seat_chips"></div>
                </div>

                {{-- Price --}}
                <div class="price-row">
                    <div>
                        <div class="price-label">Harga per penumpang × <span id="js_seat_multi">1</span></div>
                        <div class="price-label" style="margin-top:3px;" id="js_price_detail">Rp 0 × 1 penumpang</div>
                    </div>
                    <div style="text-align:right;">
                        <div style="font-size:11px;font-weight:700;opacity:.6;text-transform:uppercase;letter-spacing:.06em;">Total Bayar</div>
                        <div class="price-value" id="js_total">Rp 0</div>
                        <div class="price-sub">Bebas biaya admin</div>
                    </div>
                </div>
            </div>

            {{-- Placeholder if not ready --}}
            <div id="step3Placeholder" style="text-align:center;padding:40px 20px;color:#94a3b8;">
                <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin:0 auto 12px;opacity:.4;display:block;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                <p style="font-size:14px;font-weight:600;margin:0;">Lengkapi data penumpang untuk melihat detail perjalanan</p>
            </div>

            {{-- Payment info + Submit --}}
            <div id="paymentSection" style="display:none;margin-top:20px;">
                <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;padding:12px 16px;margin-bottom:16px;display:flex;gap:10px;align-items:flex-start;">
                    <span style="font-size:18px;">✅</span>
                    <div>
                        <p style="font-size:13px;font-weight:700;color:#065f46;margin:0 0 2px;">Semua data penumpang sudah lengkap!</p>
                        <p style="font-size:12px;color:#047857;margin:0;">E-tiket akan diterbitkan otomatis setelah pembayaran dikonfirmasi admin ASR GO.</p>
                    </div>
                </div>

                <div style="display:flex;flex-wrap:wrap;gap:6px;margin-bottom:16px;">
                    <span style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:6px;padding:4px 10px;font-size:11px;font-weight:700;color:#15803d;">QRIS</span>
                    <span style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:6px;padding:4px 10px;font-size:11px;font-weight:700;color:#1d4ed8;">GoPay</span>
                    <span style="background:#fdf4ff;border:1px solid #e9d5ff;border-radius:6px;padding:4px 10px;font-size:11px;font-weight:700;color:#7e22ce;">OVO</span>
                    <span style="background:#fff7ed;border:1px solid #fed7aa;border-radius:6px;padding:4px 10px;font-size:11px;font-weight:700;color:#c2410c;">Dana</span>
                    <span style="background:#f0f9ff;border:1px solid #bae6fd;border-radius:6px;padding:4px 10px;font-size:11px;font-weight:700;color:#0369a1;">VA Bank</span>
                </div>

                <button type="submit" class="btn-pay" id="submitBtn">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Konfirmasi & Lanjut ke Pembayaran
                </button>
                <p style="font-size:11px;color:#94a3b8;text-align:center;margin:10px 0 0;">🔒 Pembayaran aman dengan enkripsi SSL via Midtrans</p>
            </div>
        </div>

    </form>
</div>
@endsection

@php
    $bookingPrefill = [
        'route_id' => !empty(old('route_id')) && !empty(old('scheduled_date')),
        'scheduled_date' => !empty(old('scheduled_date')),
        'passengers' => !empty(old('route_id')) && !empty(old('scheduled_date')) && !empty(old('passengers')),
    ];
@endphp

@push('scripts')
<script type="text/plain" id="routes-data">{{ json_encode($routes->map(function ($r) {
    return [
        'id' => (string) $r->id,
        'origin_city' => $r->origin_city,
        'destination_city' => $r->destination_city,
        'distance_km' => $r->distance_km,
        'estimated_hours' => $r->estimated_hours,
        'price_per_seat' => optional($r->travelPrices->first())->price_per_seat ?? 0,
    ];
})->all()) }}</script>
<script type="text/plain" id="booking-prefill-data">{{ json_encode($bookingPrefill) }}</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // ── DATA ──
    const routes = JSON.parse(document.getElementById('routes-data').textContent || '[]');
    const bookingPrefill = JSON.parse(document.getElementById('booking-prefill-data').textContent || '{}');

    // ── ELEMENTS ──
    const routeSelect    = document.getElementById('route_id');
    const seatsSelect    = document.getElementById('number_of_seats');
    const dateInput      = document.getElementById('scheduled_date');
    const container      = document.getElementById('passengersContainer');

    const step1Card      = document.getElementById('step1Card');
    const step2Card      = document.getElementById('step2Card');
    const step3Card      = document.getElementById('step3Card');
    const step1Cta       = document.getElementById('step1Cta');
    const step1CtaText   = document.getElementById('step1CtaText');
    const seatSubtitle   = document.getElementById('seatSubtitle');
    const seatProgress   = document.getElementById('seatProgress');
    const seatProgressText = document.getElementById('seatProgressText');
    const seatProgressBar  = document.getElementById('seatProgressBar');
    const seatProgressBadge= document.getElementById('seatProgressBadge');

    const journeySummaryCard = document.getElementById('journeySummaryCard');
    const step3Placeholder   = document.getElementById('step3Placeholder');
    const paymentSection     = document.getElementById('paymentSection');

    // ── STATE ──
    let activePassengerIdx = 0;
    let currentStep        = 1;

    // ── HELPERS ──
    function fmtIDR(n) {
        return 'Rp ' + Number(n).toLocaleString('id-ID', { maximumFractionDigits: 0 });
    }

    function getSelectedRoute() {
        const val = routeSelect.value;
        if (!val) return null;
        const match = routes.find(r => String(r.id).toLowerCase() === String(val).toLowerCase());
        if (match) return match;
        if (routeSelect.selectedIndex >= 0) {
            const opt = routeSelect.options[routeSelect.selectedIndex];
            if (opt && opt.value) {
                return {
                    id: opt.value,
                    origin_city:      opt.getAttribute('data-origin') || '',
                    destination_city: opt.getAttribute('data-destination') || '',
                    distance_km:      opt.getAttribute('data-distance') || '',
                    estimated_hours:  opt.getAttribute('data-duration') || '',
                    price_per_seat:   parseFloat(opt.getAttribute('data-price') || 0)
                };
            }
        }
        return null;
    }

    function getPassengerNames() {
        return Array.from(container.querySelectorAll('[name^="passengers["][name$="[name]"]'))
            .map(i => i.value.trim())
            .filter(Boolean);
    }

    function allPassengersReady() {
        const num      = parseInt(seatsSelect.value) || 1;
        const names    = getPassengerNames();
        return names.length >= num;
    }

    // ── STEP CONTROL ──
    function setStep(n) {
        currentStep = n;

        // Step circles
        ['1','2','3'].forEach(s => {
            const circle = document.getElementById('stepCircle' + s);
            const label  = document.getElementById('stepLabel'  + s);
            const si     = parseInt(s);
            circle.className = 'step-circle ' + (si < n ? 'done' : si === n ? 'active' : 'idle');
            label.className  = 'step-label'   + (si === n ? ' active' : '');
            if (si < n) circle.textContent = '✓';
            else        circle.textContent = s;
        });

        // Step lines
        document.getElementById('stepLine1').className = 'step-line' + (n > 1 ? ' done' : '');
        document.getElementById('stepLine2').className = 'step-line' + (n > 2 ? ' done' : '');

        // Section nums
        [1,2,3].forEach(si => {
            const sn = document.getElementById('sn' + si);
            if (si < n)       { sn.style.background = '#10b981'; sn.textContent = '✓'; }
            else if (si === n){ sn.style.background = '#2563eb'; sn.textContent = si; }
            else              { sn.style.background = '#94a3b8'; sn.textContent = si; }
        });

        // Card locked state
        step2Card.classList.toggle('locked', n < 2);
        step3Card.classList.toggle('locked', n < 3);
    }

    // ── STEP 1 CTA ──
    function checkStep1Ready() {
        const route   = getSelectedRoute();
        const dateVal = dateInput.value;
        if (route && dateVal) {
            step1Cta.style.display = 'block';
            step1CtaText.textContent = `${route.origin_city} → ${route.destination_city} | ${formatDate(dateVal)} ✓`;
            setTimeout(() => advanceToStep2(), 300);
        } else {
            step1Cta.style.display = 'none';
        }
    }

    function advanceToStep2() {
        setStep(2);
        step2Card.classList.remove('locked');
        seatSubtitle.textContent = 'Isi data penumpang untuk setiap penumpang';
        seatProgress.style.display = 'block';
        step2Card.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    document.getElementById('goToStep2Btn').addEventListener('click', function () {
        advanceToStep2();
    });

    // ── FORMAT DATE ──
    function formatDate(val) {
        if (!val) return '-';
        const d = new Date(val + 'T00:00:00');
        return d.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
    }

    // ── JOURNEY SUMMARY (STEP 3) ──
    function updateJourneySummary() {
        const route    = getSelectedRoute();
        const numSeats = parseInt(seatsSelect.value) || 1;
        const dateVal  = dateInput.value;
        const passengers = getPassengerNames();

        if (!route || passengers.length < numSeats) {
            journeySummaryCard.style.display = 'none';
            step3Placeholder.style.display   = 'block';
            paymentSection.style.display      = 'none';
            return;
        }

        const price = parseFloat(route.price_per_seat) || 0;
        const total = price * numSeats;

        document.getElementById('js_origin').textContent = route.origin_city;
        document.getElementById('js_dest').textContent   = route.destination_city;
        document.getElementById('js_dist').textContent   = route.distance_km ? parseFloat(route.distance_km).toFixed(0) + ' km' : '-';
        document.getElementById('js_date').textContent   = formatDate(dateVal);
        document.getElementById('js_dur').textContent    = route.estimated_hours ? parseFloat(route.estimated_hours).toFixed(1) + ' jam' : '-';
        document.getElementById('js_seats_count').textContent = numSeats + ' penumpang';
        document.getElementById('js_seat_multi').textContent  = numSeats;
        document.getElementById('js_price_detail').textContent = `${fmtIDR(price)} × ${numSeats} penumpang`;
        document.getElementById('js_total').textContent = fmtIDR(total);

        // Passenger chips
        const chipsEl = document.getElementById('js_seat_chips');
        chipsEl.innerHTML = passengers.map(name => `<span class="seat-chip">👤 ${name}</span>`).join('');

        journeySummaryCard.style.display = 'block';
        step3Placeholder.style.display   = 'none';
        paymentSection.style.display      = 'block';
    }

    // ── PROGRESS ──
    function updateSeatProgress() {
        const numSeats = parseInt(seatsSelect.value) || 1;
        const done     = getPassengerNames().length;
        const pct      = Math.min((done / numSeats) * 100, 100);

        seatProgressText.textContent = `${done} dari ${numSeats} penumpang lengkap`;
        seatProgressBar.style.width  = pct + '%';
        seatProgressBar.style.background = done >= numSeats ? '#10b981' : '#2563eb';

        if (done >= numSeats) {
            seatProgressBadge.textContent  = '✓ Semua data lengkap!';
            seatProgressBadge.style.color  = '#10b981';
            setStep(3);
            step3Card.classList.remove('locked');
            step3Card.scrollIntoView({ behavior: 'smooth', block: 'start' });
        } else {
            seatProgressBadge.textContent = `${numSeats - done} lagi`;
            seatProgressBadge.style.color = '#f59e0b';
        }
        updateJourneySummary();
    }

    // ── PASSENGER FORMS ──
    function syncPassengerForms() {
        const numSeats    = parseInt(seatsSelect.value) || 1;
        const currentCount = container.querySelectorAll('.passenger-card').length;

        const saved = [];
        for (let i = 0; i < currentCount; i++) {
            saved.push({
                name:      container.querySelector(`[name="passengers[${i}][name]"]`)?.value || '',
                nik:       container.querySelector(`[name="passengers[${i}][nik]"]`)?.value || '',
                phone:     container.querySelector(`[name="passengers[${i}][phone]"]`)?.value || '',
            });
        }

        container.innerHTML = '';

        for (let i = 0; i < numSeats; i++) {
            const pre = saved[i] || { name: '', nik: '', phone: '' };
            const isComplete = !!(pre.name && pre.nik && pre.phone);
            const isActive = i === activePassengerIdx;

            const card = document.createElement('div');
            card.className = `passenger-card${isActive ? ' active' : isComplete ? ' complete' : ''}`;
            card.dataset.idx = i;

            card.innerHTML = `
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
                    <div style="display:flex;align-items:center;gap:8px;">
                        <span style="font-size:11px;font-weight:800;
                            color:${isActive ? '#1d4ed8' : isComplete ? '#059669' : '#6b7280'};
                            background:${isActive ? '#dbeafe' : isComplete ? '#d1fae5' : '#f1f5f9'};
                            border-radius:6px;padding:3px 10px;text-transform:uppercase;letter-spacing:.06em;">
                            Penumpang #${i + 1}
                        </span>
                        ${isComplete ? '<span style="font-size:11px;color:#10b981;font-weight:700;">✓ Lengkap</span>' : ''}
                    </div>
                </div>

                <div style="display:grid;gap:10px;">
                    <div>
                        <label style="display:block;font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.08em;margin-bottom:5px;">Nama Lengkap *</label>
                        <input type="text" name="passengers[${i}][name]" required
                               value="${pre.name.replace(/"/g,'&quot;')}"
                               class="form-field" style="padding:8px 12px;font-size:13px;"
                               placeholder="Sesuai dokumen"
                               pattern="^[a-zA-Z\\s\\-\\.\']+$"
                               oninput="this.setCustomValidity(this.validity.patternMismatch ? 'Nama hanya boleh mengandung huruf, spasi, dan tanda hubung' : '')">
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
                        <div>
                            <label style="display:block;font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.08em;margin-bottom:5px;">NIK *</label>
                            <input type="text" name="passengers[${i}][nik]" required
                                   value="${pre.nik}"
                                   class="form-field" style="padding:8px 12px;font-size:13px;font-family:monospace;"
                                   placeholder="16 digit NIK"
                                   maxlength="16"
                                   inputmode="numeric"
                                   pattern="^\\d{16}$"
                                   oninput="this.setCustomValidity(this.validity.patternMismatch ? 'NIK harus 16 digit angka' : '')">
                        </div>
                        <div>
                            <label style="display:block;font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.08em;margin-bottom:5px;">Telepon *</label>
                            <input type="text" name="passengers[${i}][phone]" required
                                   value="${pre.phone}"
                                   class="form-field" style="padding:8px 12px;font-size:13px;"
                                   placeholder="Contoh: 081234567890"
                                   pattern="^(\\+62|62|0)[0-9]{8,15}$"
                                   oninput="this.setCustomValidity(this.validity.patternMismatch ? 'Nomor telepon tidak valid' : '')">
                        </div>
                    </div>
                </div>`;
            container.appendChild(card);
        }
        updateSeatProgress();
    }

    function setActivePassenger(idx) {
        activePassengerIdx = idx;
        syncPassengerForms();
    }

    // ── FORM VALIDATION ──
    document.getElementById('travelBookingForm').addEventListener('submit', function (e) {
        const numSeats  = parseInt(seatsSelect.value) || 1;

        if (!routeSelect.value) {
            e.preventDefault(); alert('❌ Silakan pilih rute perjalanan terlebih dahulu.'); return;
        }
        if (!dateInput.value) {
            e.preventDefault(); alert('❌ Silakan pilih tanggal keberangkatan.'); return;
        }

        for (let i = 0; i < numSeats; i++) {
            const nameEl = container.querySelector(`[name="passengers[${i}][name]"]`);
            const nikEl  = container.querySelector(`[name="passengers[${i}][nik]"]`);
            const phoneEl = container.querySelector(`[name="passengers[${i}][phone]"]`);

            if (!nameEl?.value?.trim()) {
                e.preventDefault();
                alert(`❌ Harap isi nama lengkap penumpang #${i + 1}.`);
                nameEl?.focus();
                return;
            }

            if (!/^[a-zA-Z\s\-\.\']+$/.test(nameEl.value)) {
                e.preventDefault();
                alert(`❌ Nama penumpang #${i + 1} hanya boleh mengandung huruf, spasi, dan tanda hubung.`);
                nameEl.focus();
                return;
            }

            if (!nikEl?.value?.trim()) {
                e.preventDefault();
                alert(`❌ Harap isi NIK penumpang #${i + 1}.`);
                nikEl?.focus();
                return;
            }

            if (!/^\d{16}$/.test(nikEl.value.trim())) {
                e.preventDefault();
                alert(`❌ NIK penumpang #${i + 1} harus 16 digit angka.`);
                nikEl.focus();
                return;
            }

            if (!phoneEl?.value?.trim()) {
                e.preventDefault();
                alert(`❌ Harap isi nomor telepon penumpang #${i + 1}.`);
                phoneEl?.focus();
                return;
            }

            if (!/^(\+62|62|0)[0-9]{8,15}$/.test(phoneEl.value.trim())) {
                e.preventDefault();
                alert(`❌ Nomor telepon penumpang #${i + 1} tidak valid.`);
                phoneEl.focus();
                return;
            }
        }
    });

    // ── LISTENERS ──
    routeSelect.addEventListener('change', function () {
        checkStep1Ready();
        if (currentStep > 1) { setStep(1); }
    });
    dateInput.addEventListener('change', function () {
        checkStep1Ready();
        if (currentStep > 1) { updateJourneySummary(); }
    });
    seatsSelect.addEventListener('change', function () {
        activePassengerIdx = 0;
        syncPassengerForms();
    });

    // ── INIT ──
    console.log('Initializing travel booking form...');
    const container_check = document.getElementById('passengersContainer');
    console.log('Passengers container found:', !!container_check);
    
    syncPassengerForms();
    checkStep1Ready();
    console.log('Form initialization complete');

    // If returning from error (old input), auto-advance steps
    if (bookingPrefill.route_id && bookingPrefill.scheduled_date) {
        setStep(2);
        step2Card.classList.remove('locked');
        seatProgress.style.display = 'block';
        if (bookingPrefill.passengers) {
            setTimeout(() => {
                syncPassengerForms();
                if (allPassengersReady()) setStep(3);
            }, 600);
        }
    }
});
</script>
<style>
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50%       { opacity: 0.4; }
}
</style>
@endpush
