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

<div class="travel-booking-wrapper" style="max-width: 900px; margin: 0 auto; padding: 0 8px;">

    {{-- Back & Title --}}
    <div style="margin-bottom: 24px;">
        <a href="{{ route('bookings.index') }}"
           style="display:inline-flex;align-items:center;gap:6px;color:#6b7280;font-size:13px;font-weight:600;text-decoration:none;margin-bottom:16px;"
           onmouseover="this.style.color='#2563eb'" onmouseout="this.style.color='#6b7280'">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar Pemesanan
        </a>
        <h1 style="font-size:26px;font-weight:900;color:#111827;margin:0 0 4px;">Pesan Tiket Travel</h1>
        <p style="font-size:14px;color:#6b7280;margin:0;">Pilih rute → pilih kursi → konfirmasi → bayar</p>
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
            <div class="step-label" id="stepLabel2">Pilih Kursi</div>
        </div>
        <div class="step-line" id="stepLine2"></div>
        <div class="step-item">
            <div class="step-circle idle" id="stepCircle3">3</div>
            <div class="step-label" id="stepLabel3">Detail & Bayar</div>
        </div>
    </div>

    @if ($errors->any())
        <div style="background:#fef2f2;border:1px solid #fecaca;border-left:4px solid #ef4444;border-radius:12px;padding:14px 18px;margin-bottom:20px;">
            <p style="font-weight:700;color:#991b1b;margin:0 0 6px;font-size:13px;">⚠️ Harap perbaiki kesalahan berikut:</p>
            <ul style="color:#b91c1c;font-size:13px;margin:0;padding-left:18px;line-height:1.8;">
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
                        Lihat Kursi Tersedia →
                    </button>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════
             STEP 2: Pilih Kursi
        ══════════════════════════════════════════════ --}}
        <div class="section-card locked" id="step2Card">
            <div class="section-title">
                <div class="section-num" id="sn2" style="background:#94a3b8;">2</div>
                <div>
                    <h2 style="font-size:16px;font-weight:800;color:#111827;margin:0;">Pilih Kursi</h2>
                    <p style="font-size:12px;color:#6b7280;margin:2px 0 0;" id="seatSubtitle">Pilih rute & tanggal dahulu</p>
                </div>
                {{-- Seats count selector --}}
                <div style="margin-left:auto;display:flex;align-items:center;gap:8px;">
                    <label style="font-size:13px;font-weight:600;color:#374151;">Jumlah:</label>
                    <select name="number_of_seats" id="number_of_seats"
                        style="padding:6px 10px;border:2px solid #e5e7eb;border-radius:8px;font-weight:700;font-size:14px;outline:none;background:#f9fafb;">
                        @for($i = 1; $i <= 6; $i++)
                            <option value="{{ $i }}" @selected((string) old('number_of_seats', $selectedPassengers ?? request('passengers', 1)) === (string) $i)>{{ $i }} Kursi</option>
                        @endfor
                    </select>
                </div>
            </div>

            {{-- Seat map + Passenger forms --}}
            <div style="display:flex;gap:24px;align-items:flex-start;" class="seat-section">

                {{-- SEAT MAP --}}
                <div style="flex-shrink:0;">
                    <p style="font-size:12px;font-weight:700;color:#374151;text-align:center;margin:0 0 10px;text-transform:uppercase;letter-spacing:.06em;">Peta Kendaraan</p>
                    <div class="seat-map-vehicle">
                        <div style="text-align:center;font-size:10px;font-weight:700;color:#94a3b8;letter-spacing:.1em;margin-bottom:14px;padding-bottom:10px;border-bottom:2px dashed #e2e8f0;">
                            🚗 DEPAN / KACA
                        </div>
                        <div style="display:grid;grid-template-columns:1fr 24px 1fr 1fr;gap:8px;" id="seatGrid">
                            {{-- Row 1: 1A, aisle, empty, Driver --}}
                            <button type="button" class="seat-btn available" data-seat="1A" id="seat-1A">1A</button>
                            <div></div>
                            <div></div>
                            <button type="button" class="seat-btn driver-seat" disabled>
                                <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20"><path d="M10 3a7 7 0 100 14A7 7 0 0010 3z"/></svg>
                            </button>

                            {{-- Row 2: 2A, aisle, 2B, 2C --}}
                            <button type="button" class="seat-btn available" data-seat="2A" id="seat-2A">2A</button>
                            <div style="display:flex;align-items:center;justify-content:center;">
                                <div style="width:2px;height:100%;background:#e2e8f0;"></div>
                            </div>
                            <button type="button" class="seat-btn available" data-seat="2B" id="seat-2B">2B</button>
                            <button type="button" class="seat-btn available" data-seat="2C" id="seat-2C">2C</button>

                            {{-- Row 3: 3A, aisle, empty, 3B --}}
                            <button type="button" class="seat-btn available" data-seat="3A" id="seat-3A">3A</button>
                            <div></div>
                            <div></div>
                            <button type="button" class="seat-btn available" data-seat="3B" id="seat-3B">3B</button>

                            {{-- Row 4: 4A, aisle, 4B, 4C --}}
                            <button type="button" class="seat-btn available" data-seat="4A" id="seat-4A">4A</button>
                            <div style="display:flex;align-items:center;justify-content:center;">
                                <div style="width:2px;height:100%;background:#e2e8f0;"></div>
                            </div>
                            <button type="button" class="seat-btn available" data-seat="4B" id="seat-4B">4B</button>
                            <button type="button" class="seat-btn available" data-seat="4C" id="seat-4C">4C</button>
                        </div>
                        <div style="text-align:center;font-size:10px;font-weight:600;color:#94a3b8;margin-top:14px;padding-top:10px;border-top:2px dashed #e2e8f0;">
                            PINTU BELAKANG
                        </div>
                    </div>

                    {{-- Legend --}}
                    <div style="display:flex;flex-wrap:wrap;gap:8px;justify-content:center;margin-top:14px;">
                        <span style="display:flex;align-items:center;gap:5px;font-size:11px;color:#6b7280;font-weight:600;">
                            <span class="legend-dot" style="background:#fff;border-color:#d1d5db;"></span>Tersedia
                        </span>
                        <span style="display:flex;align-items:center;gap:5px;font-size:11px;color:#6b7280;font-weight:600;">
                            <span class="legend-dot" style="background:#2563eb;border-color:#2563eb;"></span>Dipilih
                        </span>
                        <span style="display:flex;align-items:center;gap:5px;font-size:11px;color:#6b7280;font-weight:600;">
                            <span class="legend-dot" style="background:#e5e7eb;border-color:#e5e7eb;"></span>Terisi
                        </span>
                    </div>
                </div>

                {{-- PASSENGER FORMS --}}
                <div style="flex:1;min-width:0;">
                    <p style="font-size:12px;font-weight:700;color:#374151;margin:0 0 6px;text-transform:uppercase;letter-spacing:.06em;">Data Penumpang</p>
                    <p style="font-size:12px;color:#94a3b8;margin:0 0 14px;">
                        💡 Klik kartu penumpang → klik kursi di peta kiri
                    </p>
                    <div id="passengersContainer" style="display:flex;flex-direction:column;gap:12px;"></div>
                </div>
            </div>

            {{-- Progress indicator --}}
            <div id="seatProgress" style="margin-top:16px;background:#f8fafc;border-radius:12px;padding:12px 16px;display:none;">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;">
                    <span style="font-size:12px;font-weight:700;color:#374151;" id="seatProgressText">0 dari ? kursi dipilih</span>
                    <span id="seatProgressBadge" style="font-size:11px;font-weight:700;"></span>
                </div>
                <div style="height:6px;background:#e5e7eb;border-radius:10px;overflow:hidden;">
                    <div id="seatProgressBar" style="height:100%;background:#2563eb;border-radius:10px;transition:width .3s;width:0%;"></div>
                </div>
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
                        <div class="detail-cell-label">💺 Kursi</div>
                        <div class="detail-cell-val" id="js_seats_count">-</div>
                    </div>
                </div>

                {{-- Seat chips --}}
                <div style="padding:14px 24px;border-bottom:1px solid rgba(255,255,255,.15);">
                    <div style="font-size:11px;font-weight:700;opacity:.7;text-transform:uppercase;letter-spacing:.06em;margin-bottom:8px;">Nomor Kursi</div>
                    <div class="seats-chips" id="js_seat_chips"></div>
                </div>

                {{-- Price --}}
                <div class="price-row">
                    <div>
                        <div class="price-label">Harga per kursi × <span id="js_seat_multi">1</span></div>
                        <div class="price-label" style="margin-top:3px;" id="js_price_detail">Rp 0 × 1 kursi</div>
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
                <p style="font-size:14px;font-weight:600;margin:0;">Selesaikan pemilihan kursi untuk melihat detail perjalanan</p>
            </div>

            {{-- Payment info + Submit --}}
            <div id="paymentSection" style="display:none;margin-top:20px;">
                <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;padding:12px 16px;margin-bottom:16px;display:flex;gap:10px;align-items:flex-start;">
                    <span style="font-size:18px;">✅</span>
                    <div>
                        <p style="font-size:13px;font-weight:700;color:#065f46;margin:0 0 2px;">Semua kursi sudah dipilih!</p>
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // ── DATA ──
    const routes = {!! json_encode($routes->map(function($r) {
        return [
            'id'               => (string) $r->id,
            'origin_city'      => $r->origin_city,
            'destination_city' => $r->destination_city,
            'distance_km'      => $r->distance_km,
            'estimated_hours'  => $r->estimated_hours,
            'price_per_seat'   => optional($r->travelPrices->first())->price_per_seat ?? 0,
        ];
    })) !!};

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
    let occupiedSeats      = [];
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

    function getAssignedSeats() {
        return Array.from(container.querySelectorAll('.seat-hidden-input'))
            .map(i => i.value).filter(Boolean);
    }

    function allSeatsAssigned() {
        const num      = parseInt(seatsSelect.value) || 1;
        const assigned = getAssignedSeats();
        const unique   = [...new Set(assigned)];
        return unique.length >= num;
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
            // Auto-advance to step 2
            setTimeout(() => advanceToStep2(), 300);
        } else {
            step1Cta.style.display = 'none';
        }
    }

    function advanceToStep2() {
        setStep(2);
        step2Card.classList.remove('locked');
        seatSubtitle.textContent = 'Pilih kursi yang tersedia (warna hijau), lalu isi data penumpang';
        seatProgress.style.display = 'block';
        fetchOccupiedSeats();
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

    // ── FETCH OCCUPIED SEATS ──
    async function fetchOccupiedSeats() {
        const routeId = routeSelect.value;
        const dateVal = dateInput.value;
        if (!routeId || !dateVal) { occupiedSeats = []; refreshSeatMap(); return; }
        try {
            const res  = await fetch(`{{ route('bookings.travel.occupied-seats') }}?route_id=${encodeURIComponent(routeId)}&date=${encodeURIComponent(dateVal)}`);
            if (res.ok) {
                const data = await res.json();
                if (data.success && Array.isArray(data.occupied_seats)) occupiedSeats = data.occupied_seats;
            }
        } catch(e) { console.error(e); }
        refreshSeatMap();
    }

    // ── JOURNEY SUMMARY (STEP 3) ──
    function updateJourneySummary() {
        const route    = getSelectedRoute();
        const numSeats = parseInt(seatsSelect.value) || 1;
        const dateVal  = dateInput.value;
        const assigned = [...new Set(getAssignedSeats())];

        if (!route || assigned.length < numSeats) {
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
        document.getElementById('js_seats_count').textContent = numSeats + ' kursi';
        document.getElementById('js_seat_multi').textContent  = numSeats;
        document.getElementById('js_price_detail').textContent = `${fmtIDR(price)} × ${numSeats} kursi`;
        document.getElementById('js_total').textContent = fmtIDR(total);

        // Seat chips
        const chipsEl = document.getElementById('js_seat_chips');
        chipsEl.innerHTML = assigned.map(s => `<span class="seat-chip">💺 ${s}</span>`).join('');

        journeySummaryCard.style.display = 'block';
        step3Placeholder.style.display   = 'none';
        paymentSection.style.display      = 'block';
    }

    // ── SEAT PROGRESS ──
    function updateSeatProgress() {
        const numSeats = parseInt(seatsSelect.value) || 1;
        const assigned = [...new Set(getAssignedSeats())];
        const done     = assigned.length;
        const pct      = Math.min((done / numSeats) * 100, 100);

        seatProgressText.textContent = `${done} dari ${numSeats} kursi dipilih`;
        seatProgressBar.style.width  = pct + '%';
        seatProgressBar.style.background = done >= numSeats ? '#10b981' : '#2563eb';

        if (done >= numSeats) {
            seatProgressBadge.textContent  = '✓ Semua kursi dipilih!';
            seatProgressBadge.style.color  = '#10b981';
            // Unlock step 3
            setStep(3);
            step3Card.classList.remove('locked');
            step3Card.scrollIntoView({ behavior: 'smooth', block: 'start' });
        } else {
            seatProgressBadge.textContent = `${numSeats - done} lagi`;
            seatProgressBadge.style.color = '#f59e0b';
        }
        updateJourneySummary();
    }

    // ── SEAT MAP ──
    function refreshSeatMap() {
        const assigned = getAssignedSeats();
        document.querySelectorAll('.seat-btn[data-seat]').forEach(btn => {
            const seatNum = btn.dataset.seat;
            if (occupiedSeats.includes(seatNum)) {
                btn.className = 'seat-btn occupied';
                btn.disabled  = true;
                btn.title     = `Kursi ${seatNum} sudah terisi`;
                container.querySelectorAll('.seat-hidden-input').forEach(inp => {
                    if (inp.value === seatNum) inp.value = '';
                });
            } else {
                btn.disabled  = false;
                btn.title     = `Kursi ${seatNum} tersedia`;
                btn.className = 'seat-btn available' + (assigned.includes(seatNum) ? ' selected' : '');
            }
        });

        // Gold ring on active passenger's seat
        const activeInput = container.querySelector(`.seat-hidden-input[data-idx="${activePassengerIdx}"]`);
        if (activeInput && activeInput.value && !occupiedSeats.includes(activeInput.value)) {
            const btn = document.getElementById(`seat-${activeInput.value}`);
            if (btn) btn.classList.add('active-passenger');
        }
    }

    // ── PASSENGER FORMS ──
    function syncPassengerForms() {
        const numSeats    = parseInt(seatsSelect.value) || 1;
        const currentCount = container.querySelectorAll('.passenger-card').length;

        console.log('syncPassengerForms called. numSeats:', numSeats, 'container:', !!container);

        // Save current data
        const saved = [];
        for (let i = 0; i < currentCount; i++) {
            saved.push({
                name:      container.querySelector(`[name="passengers[${i}][name]"]`)?.value || '',
                id_type:   container.querySelector(`[name="passengers[${i}][id_type]"]`)?.value || 'nik',
                id_number: container.querySelector(`[name="passengers[${i}][id_number]"]`)?.value || '',
                seat:      container.querySelector(`.seat-hidden-input[data-idx="${i}"]`)?.value || '',
            });
        }
        
        if (container) {
            container.innerHTML = '';
        } else {
            console.error('passengersContainer not found!');
            return;
        }

        for (let i = 0; i < numSeats; i++) {
            const isActive   = (i === activePassengerIdx);
            const pre        = saved[i] || { name:'', id_type:'nik', id_number:'', seat:'' };
            const isComplete = !!(pre.seat && pre.name && pre.id_number);

            // Doc type label map
            const docLabels = { nik: 'NIK (KTP)', sim: 'SIM', passport: 'Paspor' };
            const docPlaceholders = {
                nik:      '16 digit NIK',
                sim:      'Nomor SIM',
                passport: 'Nomor Paspor'
            };
            const docMaxlen = { nik: '16', sim: '12', passport: '20' };
            const docMode   = { nik: 'numeric', sim: 'text', passport: 'text' };

            const card = document.createElement('div');
            card.className = `passenger-card${isActive ? ' active' : isComplete ? ' complete' : ''}`;
            card.dataset.idx = i;
            card.addEventListener('click', (e) => {
                // Prevent triggering setActive when clicking inputs/selects
                if (['INPUT','SELECT','LABEL'].includes(e.target.tagName)) return;
                setActivePassenger(i);
            });

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
                    ${isActive ? '<span style="font-size:11px;color:#f59e0b;font-weight:700;animation:pulse 1.5s infinite;">⬅ Pilih Kursi</span>' : ''}
                    ${pre.seat ? `<span style="font-size:12px;font-weight:800;color:#fff;background:#2563eb;border-radius:6px;padding:3px 10px;">💺 ${pre.seat}</span>` : ''}
                </div>

                ${!pre.seat ? `
                <div style="text-align:center;padding:10px;background:#fff9c4;border:1.5px dashed #fbbf24;border-radius:10px;margin-bottom:10px;cursor:pointer;" onclick="setActivePassenger(${i})">
                    <p style="font-size:12px;font-weight:700;color:#92400e;margin:0;">
                        ${isActive ? '👆 Sekarang klik kursi di peta sebelah kiri' : '👉 Klik di sini lalu pilih kursi'}
                    </p>
                </div>` : ''}

                <div style="display:grid;grid-template-columns:1fr;gap:10px;">

                    <div>
                        <label style="display:block;font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.08em;margin-bottom:5px;">Nama Lengkap *</label>
                        <input type="text" name="passengers[${i}][name]" required
                               value="${pre.name.replace(/"/g,'&quot;')}"
                               class="form-field" style="padding:8px 12px;font-size:13px;"
                               placeholder="Sesuai dengan dokumen identitas (hanya huruf)"
                               pattern="^[a-zA-Z\\s\\-\\.\']+$"
                               oninput="this.setCustomValidity(this.validity.patternMismatch ? 'Nama hanya boleh mengandung huruf, spasi, dan tanda hubung' : '')">
                    </div>

                    <div style="display:grid;grid-template-columns:140px 1fr;gap:8px;">
                        <div>
                            <label style="display:block;font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.08em;margin-bottom:5px;">Jenis ID *</label>
                            <select name="passengers[${i}][id_type]" required
                                    id="id_type_${i}"
                                    class="form-field" style="padding:8px 12px;font-size:13px;"
                                    onchange="onIdTypeChange(${i})">
                                <option value="nik"   ${pre.id_type === 'nik'      ? 'selected' : ''}>NIK (KTP)</option>
                                <option value="sim"   ${pre.id_type === 'sim'      ? 'selected' : ''}>SIM</option>
                                <option value="passport" ${pre.id_type === 'passport' ? 'selected' : ''}>Paspor</option>
                            </select>
                        </div>
                        <div>
                            <label style="display:block;font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.08em;margin-bottom:5px;">
                                Nomor Dokumen * 
                                <span id="format_hint_${i}" style="font-size:9px;color:#f59e0b;font-weight:600;margin-left:4px;"></span>
                            </label>
                            <input type="text" name="passengers[${i}][id_number]" required
                                   id="id_number_${i}"
                                   value="${pre.id_number}"
                                   class="form-field" style="padding:8px 12px;font-size:13px;font-family:monospace;"
                                   placeholder="${docPlaceholders[pre.id_type] || '16 digit NIK'}"
                                   maxlength="${docMaxlen[pre.id_type] || '16'}"
                                   inputmode="${docMode[pre.id_type] || 'numeric'}"
                                   oninput="validateIdFormat(${i})"
                                   onfocus="showIdFormatHint(${i})"
                                   onblur="hideIdFormatHint(${i})">
                            <div id="id_format_help_${i}" style="font-size:10px;color:#6b7280;margin-top:4px;display:none;padding:6px 8px;background:#f9fafb;border-radius:6px;border-left:3px solid #2563eb;">
                                <div id="format_help_text_${i}"></div>
                            </div>
                        </div>
                    </div>

                </div>
                <input type="hidden" class="seat-hidden-input" name="passengers[${i}][seat_number]"
                       data-idx="${i}" value="${pre.seat}">
                ${!pre.seat ? '<p style="font-size:11px;color:#ef4444;margin:6px 0 0;text-align:center;font-weight:600;">⚠ Kursi belum dipilih</p>' : ''}
            `;
            container.appendChild(card);
        }
        console.log('Created', numSeats, 'passenger cards');
        refreshSeatMap();
        updateSeatProgress();
    }

    function setActivePassenger(idx) {
        activePassengerIdx = idx;
        syncPassengerForms();
    }

    // ── ID TYPE CHANGE ──
    window.onIdTypeChange = function(idx) {
        const typeEl   = document.getElementById(`id_type_${idx}`);
        const numEl    = document.getElementById(`id_number_${idx}`);
        if (!typeEl || !numEl) return;
        const t = typeEl.value;
        const placeholders = { nik: '16 digit NIK', sim: 'Nomor SIM', passport: 'Nomor Paspor' };
        const maxlens      = { nik: '16', sim: '12', passport: '20' };
        const modes        = { nik: 'numeric', sim: 'text', passport: 'text' };
        numEl.placeholder  = placeholders[t] || '16 digit NIK';
        numEl.maxLength    = maxlens[t] || 16;
        numEl.inputMode    = modes[t] || 'numeric';
        numEl.value        = '';
        numEl.focus();
        validateIdFormat(idx);
    };

    // ── ID FORMAT VALIDATION ──
    window.validateIdFormat = function(idx) {
        const typeEl   = document.getElementById(`id_type_${idx}`);
        const numEl    = document.getElementById(`id_number_${idx}`);
        const hintEl   = document.getElementById(`format_hint_${idx}`);
        if (!typeEl || !numEl || !hintEl) return;

        const t = typeEl.value;
        const val = numEl.value.trim();
        let isValid = false;
        let helpText = '';

        if (!val) {
            hintEl.textContent = '';
        } else if (t === 'nik') {
            isValid = /^\d{16}$/.test(val);
            helpText = isValid ? '✓ Format NIK benar' : '❌ NIK harus 16 digit (contoh: 3201234567890123)';
            hintEl.textContent = isValid ? '✓' : '❌';
            hintEl.style.color = isValid ? '#10b981' : '#ef4444';
        } else if (t === 'sim') {
            isValid = /^[A-Z0-9]{8,12}$/.test(val);
            helpText = isValid ? '✓ Format SIM benar' : '❌ SIM: 8-12 karakter alfanumerik (contoh: A1234567)';
            hintEl.textContent = isValid ? '✓' : '❌';
            hintEl.style.color = isValid ? '#10b981' : '#ef4444';
        } else if (t === 'passport') {
            isValid = /^[A-Z]{1,2}\d{7,8}$/.test(val);
            helpText = isValid ? '✓ Format Paspor benar' : '❌ Paspor: 1-2 huruf + 7-8 angka (contoh: A12345678)';
            hintEl.textContent = isValid ? '✓' : '❌';
            hintEl.style.color = isValid ? '#10b981' : '#ef4444';
        }

        const helpEl = document.getElementById(`id_format_help_${idx}`);
        const helpTextEl = document.getElementById(`format_help_text_${idx}`);
        if (helpEl && helpTextEl) {
            helpTextEl.innerHTML = helpText;
        }

        numEl.style.borderColor = isValid && val ? '#10b981' : '#e5e7eb';
    };

    window.showIdFormatHint = function(idx) {
        const helpEl = document.getElementById(`id_format_help_${idx}`);
        if (helpEl) {
            helpEl.style.display = 'block';
            validateIdFormat(idx);
        }
    };

    window.hideIdFormatHint = function(idx) {
        const helpEl = document.getElementById(`id_format_help_${idx}`);
        if (helpEl) {
            setTimeout(() => { helpEl.style.display = 'none'; }, 200);
        }
    };

    // ── SEAT CLICK ──
    document.querySelectorAll('.seat-btn[data-seat]').forEach(btn => {
        btn.addEventListener('click', function () {
            const seatNum = this.dataset.seat;
            if (currentStep < 2) {
                alert('⚠️ Silakan pilih rute dan tanggal terlebih dahulu, lalu klik "Lihat Kursi Tersedia".');
                return;
            }
            if (occupiedSeats.includes(seatNum) || this.classList.contains('occupied')) {
                alert(`❌ Kursi ${seatNum} sudah terisi oleh pemesan lain.`);
                return;
            }

            // Remove seat if already assigned to another passenger
            container.querySelectorAll('.seat-hidden-input').forEach(inp => {
                if (inp.value === seatNum) inp.value = '';
            });

            // Assign to active passenger
            const activeInput = container.querySelector(`.seat-hidden-input[data-idx="${activePassengerIdx}"]`);
            if (activeInput) activeInput.value = seatNum;

            // Auto-advance to next unassigned passenger
            const numSeats = parseInt(seatsSelect.value) || 1;
            for (let i = 0; i < numSeats; i++) {
                const inp = container.querySelector(`.seat-hidden-input[data-idx="${i}"]`);
                if (inp && !inp.value) { activePassengerIdx = i; break; }
            }

            syncPassengerForms();
        });
    });

    // ── FORM VALIDATION ──
    document.getElementById('travelBookingForm').addEventListener('submit', function (e) {
        const numSeats  = parseInt(seatsSelect.value) || 1;
        const assigned  = getAssignedSeats();
        const unique    = [...new Set(assigned.filter(Boolean))];

        if (!routeSelect.value) {
            e.preventDefault(); alert('❌ Silakan pilih rute perjalanan terlebih dahulu.'); return;
        }
        if (!dateInput.value) {
            e.preventDefault(); alert('❌ Silakan pilih tanggal keberangkatan.'); return;
        }
        if (unique.length < numSeats) {
            e.preventDefault();
            alert(`❌ Silakan pilih kursi untuk semua ${numSeats} penumpang. Baru ${unique.length} kursi dipilih.`);
            return;
        }

        // Check all passenger data filled and valid
        for (let i = 0; i < numSeats; i++) {
            const nameEl   = container.querySelector(`[name="passengers[${i}][name]"]`);
            const idTypeEl = container.querySelector(`[name="passengers[${i}][id_type]"]`);
            const idNumEl  = container.querySelector(`[name="passengers[${i}][id_number]"]`);

            if (!nameEl?.value?.trim()) {
                e.preventDefault();
                alert(`❌ Harap isi nama lengkap penumpang #${i + 1}.`);
                nameEl?.focus();
                return;
            }

            // Validate name format
            if (!/^[a-zA-Z\s\-\.\']+$/.test(nameEl.value)) {
                e.preventDefault();
                alert(`❌ Nama penumpang #${i + 1} hanya boleh mengandung huruf, spasi, dan tanda hubung.`);
                nameEl.focus();
                return;
            }

            if (!idNumEl?.value?.trim()) {
                e.preventDefault();
                alert(`❌ Harap isi nomor dokumen identitas penumpang #${i + 1}.`);
                idNumEl?.focus();
                return;
            }

            // Validate ID format
            const idType = idTypeEl?.value || 'nik';
            const idNum = idNumEl.value.trim();
            let isValidId = false;

            if (idType === 'nik') {
                isValidId = /^\d{16}$/.test(idNum);
                if (!isValidId) {
                    e.preventDefault();
                    alert(`❌ NIK penumpang #${i + 1} harus 16 digit angka (contoh: 3201234567890123).`);
                    idNumEl.focus();
                    return;
                }
            } else if (idType === 'sim') {
                isValidId = /^[A-Z0-9]{8,12}$/.test(idNum);
                if (!isValidId) {
                    e.preventDefault();
                    alert(`❌ Nomor SIM penumpang #${i + 1} harus 8-12 karakter alfanumerik (contoh: A1234567).`);
                    idNumEl.focus();
                    return;
                }
            } else if (idType === 'passport') {
                isValidId = /^[A-Z]{1,2}\d{7,8}$/.test(idNum);
                if (!isValidId) {
                    e.preventDefault();
                    alert(`❌ Nomor Paspor penumpang #${i + 1} tidak valid (contoh: A12345678 atau AB12345678).`);
                    idNumEl.focus();
                    return;
                }
            }
        }
    });

    // ── LISTENERS ──
    routeSelect.addEventListener('change', function () {
        checkStep1Ready();
        // Reset to step 1 if route changes
        if (currentStep > 1) { setStep(1); }
    });
    dateInput.addEventListener('change', function () {
        checkStep1Ready();
        if (currentStep > 1) { fetchOccupiedSeats(); updateJourneySummary(); }
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
    @if(old('route_id') && old('scheduled_date'))
        setStep(2);
        step2Card.classList.remove('locked');
        seatProgress.style.display = 'block';
        fetchOccupiedSeats();
        @if(old('passengers'))
            setTimeout(() => {
                syncPassengerForms();
                if (allSeatsAssigned()) setStep(3);
            }, 600);
        @endif
    @endif
});
</script>
<style>
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50%       { opacity: 0.4; }
}
</style>
@endpush
