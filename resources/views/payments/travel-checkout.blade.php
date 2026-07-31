@extends('layouts.app')

@section('title', 'Pembayaran Travel — ' . $booking->booking_code)

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap');

    .checkout-wrapper { font-family: 'Inter', sans-serif; }

    .detail-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    }

    .card-header {
        background: linear-gradient(135deg, #1e40af 0%, #2563eb 60%, #3b82f6 100%);
        padding: 20px 24px; color: #fff;
    }

    .info-row {
        display: flex; justify-content: space-between;
        align-items: flex-start; padding: 12px 0;
        border-bottom: 1px solid #f1f5f9; font-size: 14px;
    }
    .info-row:last-child { border-bottom: none; }
    .info-label { color: #6b7280; font-weight: 500; }
    .info-value { color: #111827; font-weight: 700; text-align: right; max-width: 60%; }

    .status-badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700;
    }
    .status-success { background: #d1fae5; color: #065f46; }
    .status-pending { background: #fef3c7; color: #92400e; }
    .status-failed  { background: #fee2e2; color: #991b1b; }

    .payment-method-btn {
        width: 100%; padding: 14px 20px;
        border-radius: 14px; border: 2px solid #e5e7eb;
        background: #fff; cursor: pointer;
        display: flex; align-items: center; justify-content: space-between;
        font-size: 14px; font-weight: 700; color: #374151;
        transition: all 0.18s ease; text-align: left;
    }
    .payment-method-btn:hover, .payment-method-btn.active {
        border-color: #2563eb; background: #eff6ff; color: #1d4ed8;
        box-shadow: 0 0 0 3px rgba(37,99,235,0.12);
    }

    .btn-pay-now {
        width: 100%; padding: 15px 24px;
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: #fff; border: none; border-radius: 14px;
        font-size: 15px; font-weight: 800; cursor: pointer;
        box-shadow: 0 6px 20px rgba(37,99,235,0.4);
        transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 8px;
        font-family: 'Inter', sans-serif;
    }
    .btn-pay-now:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(37,99,235,0.5); }
    .btn-pay-now:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }

    .countdown-box {
        background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
        border: 1px solid #fcd34d; border-radius: 14px;
        padding: 14px 18px; display: flex; align-items: center; justify-content: space-between;
    }

    .timer-display {
        font-size: 24px; font-weight: 900; color: #92400e;
        font-family: 'Courier New', monospace; letter-spacing: 0.05em;
    }

    @media (max-width: 768px) {
        .checkout-grid { grid-template-columns: 1fr !important; }
    }
</style>

<div class="checkout-wrapper" style="max-width: 1100px; margin: 0 auto; padding: 0 8px;">

    <!-- Header -->
    <div style="margin-bottom: 24px;">
        <a href="{{ route('bookings.travel') }}" style="display: inline-flex; align-items: center; gap: 6px; color: #6b7280; font-size: 13px; font-weight: 600; text-decoration: none; margin-bottom: 16px;"
           onmouseover="this.style.color='#2563eb'" onmouseout="this.style.color='#6b7280'">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar Pemesanan
        </a>
        <div style="display: flex; align-items: center; gap: 14px;">
            <div style="width: 52px; height: 52px; background: linear-gradient(135deg, #dbeafe, #eff6ff); border-radius: 16px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; border: 2px solid #bfdbfe;">
                <svg width="26" height="26" fill="none" stroke="#2563eb" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
            </div>
            <div>
                <h1 style="font-size: 26px; font-weight: 900; color: #111827; margin: 0 0 4px 0;">Pembayaran Travel</h1>
                <p style="font-size: 14px; color: #6b7280; margin: 0;">
                    Kode: <strong style="color: #2563eb;">{{ $booking->booking_code }}</strong>
                    &bull; Silakan selesaikan pembayaran Anda
                </p>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div style="background: #d1fae5; border: 1px solid #a7f3d0; border-radius: 12px; padding: 14px 18px; margin-bottom: 20px; color: #065f46; font-weight: 600; font-size: 14px;">
            ✓ {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background: #fee2e2; border: 1px solid #fecaca; border-radius: 12px; padding: 14px 18px; margin-bottom: 20px; color: #991b1b; font-weight: 600; font-size: 14px;">
            ✗ {{ session('error') }}
        </div>
    @endif

    <div style="display: grid; grid-template-columns: 1fr 360px; gap: 24px; align-items: start;" class="checkout-grid">

        <!-- ======================== LEFT: BOOKING DETAILS ======================== -->
        <div style="display: flex; flex-direction: column; gap: 20px;">

            <!-- Countdown Timer (only for pending) -->
            @if($payment && $payment->status === 'pending')
            <div class="countdown-box">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <span style="font-size: 24px;">⏰</span>
                    <div>
                        <p style="font-size: 12px; font-weight: 700; color: #92400e; margin: 0 0 2px 0; text-transform: uppercase; letter-spacing: 0.06em;">Batas Waktu Pembayaran</p>
                        <p style="font-size: 12px; color: #b45309; margin: 0;">Selesaikan sebelum waktu habis</p>
                    </div>
                </div>
                <div class="timer-display" id="countdown-timer">--:--:--</div>
            </div>
            @endif

            <!-- Route Card -->
            <div class="detail-card">
                <div class="card-header">
                    <p style="font-size: 11px; font-weight: 700; opacity: 0.75; letter-spacing: 0.1em; text-transform: uppercase; margin: 0 0 6px 0;">Rute Perjalanan</p>
                    <div style="display: flex; align-items: center; gap: 16px;">
                        <div>
                            <p style="font-size: 12px; opacity: 0.8; margin: 0 0 2px 0;">Dari</p>
                            <p style="font-size: 20px; font-weight: 900; margin: 0; line-height: 1.1;">
                                {{ $booking->route->origin_city ?? $booking->route->origin ?? '-' }}
                            </p>
                        </div>
                        <div style="font-size: 24px; opacity: 0.7;">→</div>
                        <div>
                            <p style="font-size: 12px; opacity: 0.8; margin: 0 0 2px 0;">Tujuan</p>
                            <p style="font-size: 20px; font-weight: 900; margin: 0; line-height: 1.1;">
                                {{ $booking->route->destination_city ?? $booking->route->destination ?? '-' }}
                            </p>
                        </div>
                    </div>
                </div>
                <div style="padding: 20px 24px;">
                    <div class="info-row">
                        <span class="info-label">Kode Pemesanan</span>
                        <span class="info-value" style="color: #2563eb; font-family: monospace; font-size: 15px;">{{ $booking->booking_code }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Tanggal Keberangkatan</span>
                        <span class="info-value">
                            {{ $booking->scheduled_date ? \Carbon\Carbon::parse($booking->scheduled_date)->translatedFormat('l, d F Y') : '-' }}
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Jumlah Penumpang</span>
                        <span class="info-value">{{ $booking->number_of_seats ?? $booking->passenger_count }} Kursi</span>
                    </div>
                    @if($booking->passengers && $booking->passengers->count() > 0)
                    <div class="info-row" style="align-items: flex-start;">
                        <span class="info-label">Data Penumpang</span>
                        <div class="info-value" style="display: flex; flex-direction: column; gap: 4px;">
                            @foreach($booking->passengers as $passenger)
                                <div style="background: #f8fafc; border-radius: 8px; padding: 6px 10px; font-size: 12px; text-align: left;">
                                    <strong>Kursi {{ $passenger->seat_number }}</strong>: {{ $passenger->name }}
                                    <span style="color: #94a3b8; font-family: monospace; font-size: 11px; display: block;">NIK: {{ $passenger->nik }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    <div class="info-row">
                        <span class="info-label">Status Pembayaran</span>
                        <span class="info-value">
                            @if($payment && $payment->status === 'success')
                                <span class="status-badge status-success">✓ Berhasil</span>
                            @elseif($payment && $payment->status === 'pending')
                                <span class="status-badge status-pending">⏳ Menunggu</span>
                            @elseif($payment && $payment->status === 'failed')
                                <span class="status-badge status-failed">✗ Gagal</span>
                            @else
                                <span class="status-badge" style="background: #f3f4f6; color: #374151;">— Belum ada</span>
                            @endif
                        </span>
                    </div>
                    @if($payment && $payment->midtrans_reference)
                    <div class="info-row">
                        <span class="info-label">No. Referensi</span>
                        <span class="info-value" style="font-family: monospace; font-size: 12px;">{{ $payment->midtrans_reference }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Payment Success Message -->
            @if($payment && $payment->status === 'success')
            <div style="background: #ecfdf5; border: 2px solid #a7f3d0; border-radius: 20px; padding: 28px; text-align: center;">
                <div style="width: 64px; height: 64px; background: #10b981; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px auto;">
                    <svg width="32" height="32" fill="none" stroke="#fff" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                </div>
                <h3 style="font-size: 22px; font-weight: 900; color: #065f46; margin: 0 0 8px 0;">Pembayaran Berhasil! 🎉</h3>
                <p style="font-size: 14px; color: #047857; margin: 0 0 20px 0; line-height: 1.6;">
                    Tiket elektronik Anda sudah aktif. Tunjukkan kode pemesanan kepada pengemudi saat keberangkatan.
                </p>
                <a href="{{ route('bookings.travel.show', $booking) }}"
                   style="display: inline-flex; align-items: center; gap: 8px; background: #10b981; color: #fff; padding: 12px 24px; border-radius: 12px; font-weight: 700; text-decoration: none; font-size: 14px;">
                    Lihat Detail Pemesanan →
                </a>
            </div>
            @endif

        </div>

        <!-- ======================== RIGHT: PAYMENT SUMMARY ======================== -->
        <div style="position: sticky; top: 80px;">
            <div class="detail-card">
                <!-- Header -->
                <div class="card-header">
                    <p style="font-size: 11px; opacity: 0.75; letter-spacing: 0.1em; text-transform: uppercase; margin: 0 0 4px 0; font-weight: 700;">Ringkasan Pembayaran</p>
                    <h3 style="font-size: 18px; font-weight: 900; margin: 0;">Total Tagihan</h3>
                </div>

                <div style="padding: 20px 24px;">

                    <!-- Price Detail -->
                    <div style="padding-bottom: 16px; border-bottom: 1px solid #f1f5f9; margin-bottom: 16px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; font-size: 14px;">
                            <span style="color: #6b7280; font-weight: 500;">Tiket Travel × {{ $booking->number_of_seats ?? $booking->passenger_count }}</span>
                            <span style="font-weight: 700; color: #111827;">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; font-size: 14px;">
                            <span style="color: #10b981; font-weight: 600;">Biaya Admin</span>
                            <span style="font-weight: 700; color: #10b981;">Gratis</span>
                        </div>
                    </div>

                    <!-- Voucher -->
                    @if($payment && $payment->status !== 'success')
                    <div style="padding-bottom: 16px; border-bottom: 1px solid #f1f5f9; margin-bottom: 16px;">
                        <label style="display: block; font-size: 12px; font-weight: 700; color: #374151; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.06em;">Kode Voucher (Opsional)</label>
                        <div style="display: flex; gap: 8px;">
                            <input type="text" id="voucher-code" placeholder="Masukkan voucher"
                                   style="flex: 1; padding: 9px 12px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 13px; text-transform: uppercase; outline: none; font-family: 'Inter', sans-serif;"
                                   onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='#e5e7eb'">
                            <button onclick="applyVoucher()" type="button"
                                    style="padding: 9px 14px; background: #f1f5f9; border: 2px solid #e5e7eb; border-radius: 10px; font-weight: 700; cursor: pointer; font-size: 13px; transition: all 0.15s; white-space: nowrap; font-family: 'Inter', sans-serif;"
                                    onmouseover="this.style.background='#dbeafe'; this.style.borderColor='#93c5fd'; this.style.color='#1d4ed8'"
                                    onmouseout="this.style.background='#f1f5f9'; this.style.borderColor='#e5e7eb'; this.style.color='#374151'">
                                Pakai
                            </button>
                        </div>
                        <div id="voucher-message" style="font-size: 12px; margin-top: 6px; font-weight: 600; display: none;"></div>
                        <input type="hidden" id="voucher-code-hidden" value="">
                    </div>
                    @endif

                    <!-- Total -->
                    <div style="background: linear-gradient(135deg, #eff6ff, #f0fdf4); border-radius: 14px; padding: 16px; margin-bottom: 20px; text-align: center;">
                        <p style="font-size: 12px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.08em; margin: 0 0 6px 0;">Total yang Harus Dibayar</p>
                        <p id="final-price" style="font-size: 32px; font-weight: 900; color: #f97316; margin: 0; line-height: 1.1;">
                            Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                        </p>
                        <p id="original-price" style="font-size: 14px; color: #94a3b8; text-decoration: line-through; margin: 4px 0 0 0; display: none;">
                            Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                        </p>
                    </div>

                    @if($payment && $payment->status === 'success')
                        <!-- Paid! -->
                        <div style="background: #ecfdf5; border: 2px solid #a7f3d0; border-radius: 14px; padding: 16px; text-align: center;">
                            <p style="font-weight: 800; color: #047857; font-size: 15px; margin: 0;">✅ Pembayaran Lunas</p>
                        </div>
                    @else
                        <!-- Payment Methods Info -->
                        <div style="margin-bottom: 16px;">
                            <p style="font-size: 12px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.06em; margin: 0 0 10px 0;">Tersedia via Midtrans</p>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                                <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px; padding: 10px; text-align: center;">
                                    <p style="font-size: 18px; margin: 0 0 3px 0;">📱</p>
                                    <p style="font-size: 11px; font-weight: 800; color: #15803d; margin: 0;">QRIS</p>
                                    <p style="font-size: 10px; color: #4ade80; margin: 0;">Semua e-wallet</p>
                                </div>
                                <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 10px; padding: 10px; text-align: center;">
                                    <p style="font-size: 18px; margin: 0 0 3px 0;">🏦</p>
                                    <p style="font-size: 11px; font-weight: 800; color: #1d4ed8; margin: 0;">Transfer Bank</p>
                                    <p style="font-size: 10px; color: #60a5fa; margin: 0;">Virtual Account</p>
                                </div>
                                <div style="background: #fdf4ff; border: 1px solid #e9d5ff; border-radius: 10px; padding: 10px; text-align: center;">
                                    <p style="font-size: 18px; margin: 0 0 3px 0;">💳</p>
                                    <p style="font-size: 11px; font-weight: 800; color: #7e22ce; margin: 0;">Kartu Kredit</p>
                                    <p style="font-size: 10px; color: #c084fc; margin: 0;">Visa / MC</p>
                                </div>
                                <div style="background: #fff7ed; border: 1px solid #fed7aa; border-radius: 10px; padding: 10px; text-align: center;">
                                    <p style="font-size: 18px; margin: 0 0 3px 0;">📲</p>
                                    <p style="font-size: 11px; font-weight: 800; color: #c2410c; margin: 0;">E-Wallet</p>
                                    <p style="font-size: 10px; color: #fb923c; margin: 0;">GoPay, OVO, Dana</p>
                                </div>
                            </div>
                        </div>

                        <!-- Pay Button -->
                        <button onclick="triggerMidtransPayment()" type="button" class="btn-pay-now" id="payBtn">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            Bayar Sekarang
                        </button>

                        @if($payment && $payment->status === 'failed')
                        <button onclick="retryPayment()" type="button"
                                style="width: 100%; margin-top: 10px; padding: 13px 24px; background: #f3f4f6; border: 2px solid #e5e7eb; border-radius: 14px; font-weight: 700; cursor: pointer; font-size: 14px; transition: all 0.2s; color: #374151; font-family: 'Inter', sans-serif;"
                                onmouseover="this.style.background='#e5e7eb'" onmouseout="this.style.background='#f3f4f6'">
                            🔄 Coba Bayar Lagi
                        </button>
                        @endif
                    @endif

                    <p style="font-size: 11px; color: #94a3b8; text-align: center; margin: 12px 0 0 0;">
                        🔒 Dijamin aman oleh Midtrans Payment Gateway
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- ========== SCRIPTS ========== -->
<script src="{{ config('midtrans.snap_url') }}" data-client-key="{{ $clientKey }}"></script>

<script>
const bookingTotal = {{ $booking->total_price }};
let discountApplied = 0;
let snapToken = @json($snapToken ?? null);

// ====== COUNTDOWN TIMER ======
@if($payment && $payment->status === 'pending' && $payment->created_at)
(function () {
    const deadline = new Date("{{ $payment->created_at->addHours(24)->toIso8601String() }}").getTime();
    const timerEl  = document.getElementById('countdown-timer');

    function tick() {
        const now  = Date.now();
        const diff = deadline - now;
        if (!timerEl) return;
        if (diff <= 0) {
            timerEl.innerHTML = '<span style="color:#991b1b;font-size:14px;">EXPIRED</span>';
            return;
        }
        const h = Math.floor(diff / 3600000);
        const m = Math.floor((diff % 3600000) / 60000);
        const s = Math.floor((diff % 60000) / 1000);
        timerEl.textContent = String(h).padStart(2,'0') + ':' + String(m).padStart(2,'0') + ':' + String(s).padStart(2,'0');
    }
    tick();
    setInterval(tick, 1000);
})();
@endif

// ====== VOUCHER ======
function applyVoucher() {
    const code = document.getElementById('voucher-code')?.value.trim().toUpperCase();
    const msgEl = document.getElementById('voucher-message');
    if (!code) {
        msgEl.style.display = 'block';
        msgEl.style.color = '#dc2626';
        msgEl.textContent = 'Masukkan kode voucher terlebih dahulu.';
        return;
    }
    msgEl.style.display = 'block';
    msgEl.style.color = '#94a3b8';
    msgEl.textContent = '⏳ Memvalidasi...';

    fetch('/api/voucher/validate?code=' + encodeURIComponent(code) + '&amount=' + bookingTotal)
        .then(r => r.json())
        .then(data => {
            if (data.valid) {
                discountApplied = data.discount || 0;
                document.getElementById('voucher-code-hidden').value = code;
                msgEl.style.color = '#059669';
                msgEl.textContent = `✓ Voucher valid! Hemat Rp ${discountApplied.toLocaleString('id-ID')}`;
                refreshTotal();
            } else {
                msgEl.style.color = '#dc2626';
                msgEl.textContent = '✗ ' + (data.message || 'Kode voucher tidak valid.');
                discountApplied = 0;
                refreshTotal();
            }
        })
        .catch(() => {
            msgEl.style.color = '#d97706';
            msgEl.textContent = '⚠ Tidak bisa memvalidasi. Voucher akan dicek saat pembayaran.';
            document.getElementById('voucher-code-hidden').value = code;
        });
}

function refreshTotal() {
    const final = Math.max(0, bookingTotal - discountApplied);
    document.getElementById('final-price').textContent = 'Rp ' + final.toLocaleString('id-ID');
    const origEl = document.getElementById('original-price');
    if (discountApplied > 0) {
        origEl.style.display = 'block';
    } else {
        origEl.style.display = 'none';
    }
}

// ====== MIDTRANS PAYMENT ======
function triggerMidtransPayment() {
    if (!snapToken) {
        alert('Token pembayaran tidak tersedia. Silakan refresh halaman.');
        return;
    }

    const payBtn = document.getElementById('payBtn');
    if (payBtn) { payBtn.disabled = true; payBtn.textContent = 'Membuka halaman pembayaran...'; }

    snap.pay(snapToken, {
        onSuccess: function(result) {
            window.location.href = "{{ route('payments.success') }}?" + new URLSearchParams({
                order_id: result.order_id,
                status_code: result.status_code,
                transaction_status: result.transaction_status
            }).toString();
        },
        onPending: function(result) {
            window.location.href = "{{ route('payments.pending') }}?" + new URLSearchParams({
                order_id: result.order_id,
                status_code: result.status_code
            }).toString();
        },
        onError: function(result) {
            window.location.href = "{{ route('payments.error') }}?" + new URLSearchParams({
                order_id: result.order_id,
                status_code: result.status_code
            }).toString();
        },
        onClose: function() {
            if (payBtn) { payBtn.disabled = false; payBtn.innerHTML = '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg> Bayar Sekarang'; }
        }
    });
}

function retryPayment() {
    fetch("{{ route('payments.retry', $payment ?? 0) }}", {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            snapToken = data.snapToken;
            triggerMidtransPayment();
        } else {
            alert('Gagal: ' + (data.message || 'Terjadi kesalahan'));
        }
    })
    .catch(() => alert('Terjadi kesalahan jaringan.'));
}
</script>
@endsection
