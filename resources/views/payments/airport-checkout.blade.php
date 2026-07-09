@extends('layouts.app')

@section('content')
<div style="min-height: 100vh; background-color: #f9fafb; padding: 3rem 1rem;">
    <div style="max-width: 72rem; margin: 0 auto;">
        <!-- Header -->
        <div style="margin-bottom: 2rem;">
            <a href="{{ route('bookings.airport-transfer') }}" style="color: #2563eb; font-weight: 600; text-decoration: none; font-size: 0.95rem;">
                ← Kembali ke Pemesanan
            </a>
            <h1 style="font-size: 2.25rem; font-weight: 700; color: #111827; margin-top: 1rem; margin-bottom: 0;">Pembayaran Airport Transfer</h1>
        </div>

        <div style="display: grid; grid-template-columns: 1fr; gap: 2rem;">
            @media (min-width: 1024px)
            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
            @endif

            <!-- Booking Details -->
            <div>
                <div style="background: #ffffff; border-radius: 0.5rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06); padding: 1.5rem;">
                    <h2 style="font-size: 1.5rem; font-weight: 700; color: #111827; margin-top: 0; margin-bottom: 1.5rem;">Detail Pemesanan</h2>

                    <!-- Countdown Timer -->
                    <div style="background: #fef3c7; border: 1px solid #fcd34d; border-radius: 0.5rem; padding: 1rem; margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between;">
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <span style="font-size: 1.25rem;">⌛</span>
                            <span style="font-weight: 600; color: #92400e;">Batas Waktu Pembayaran</span>
                        </div>
                        <div id="countdown-timer" style="font-weight: 700; font-size: 1.125rem; color: #92400e; font-family: monospace;">
                            24:00:00
                        </div>
                    </div>

                    <!-- Route Information -->
                    <div style="margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 1px solid #e5e7eb;">
                        <h3 style="font-weight: 600; color: #111827; margin-top: 0; margin-bottom: 0.5rem;">Lokasi Antar/Jemput</h3>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div>
                                <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">Lokasi Penjemputan</p>
                                <p style="font-weight: 600; color: #111827; margin: 0;">{{ $booking->pickup_location }}</p>
                            </div>
                            <div style="font-size: 1.5rem; color: #2563eb;">→</div>
                            <div>
                                <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">Lokasi Tujuan</p>
                                <p style="font-weight: 600; color: #111827; margin: 0;">{{ $booking->dropoff_location }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Details -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 1px solid #e5e7eb;">
                        <div>
                            <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">Kode Pemesanan</p>
                            <p style="font-weight: 600; color: #111827; margin: 0;">{{ $booking->booking_code }}</p>
                        </div>
                        <div>
                            <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">Jumlah Penumpang</p>
                            <p style="font-weight: 600; color: #111827; margin: 0;">{{ $booking->number_of_passengers }} Orang</p>
                        </div>
                        <div>
                            <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">Jadwal Penjemputan</p>
                            <p style="font-weight: 600; color: #111827; margin: 0;">{{ $booking->scheduled_date }}</p>
                        </div>
                        <div>
                            <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">Tipe Transfer</p>
                            <p style="font-weight: 600; color: #111827; margin: 0; text-transform: capitalize;">{{ str_replace('_', ' ', $booking->transfer_type) }}</p>
                        </div>
                    </div>

                    <!-- Status -->
                    <div>
                        <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">Status Pembayaran</p>
                        <div style="display: flex; align-items: center; gap: 0.5rem; margin-top: 0.5rem;">
                            @if($payment->status === 'success')
                                <span style="display: inline-block; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 600; background-color: #d1fae5; color: #065f46;">
                                    ✓ Success
                                </span>
                            @elseif($payment->status === 'pending')
                                <span style="display: inline-block; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 600; background-color: #d1fae5; color: #065f46;">
                                    ⏳ Pending
                                </span>
                            @else
                                <span style="display: inline-block; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 600; background-color: #fee2e2; color: #991b1b;">
                                    ✗ Failed
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Summary -->
            <div>
                <div style="background: #ffffff; border-radius: 0.5rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06); padding: 1.5rem; position: sticky; top: 1.5rem;">
                    <h3 style="font-size: 1.25rem; font-weight: 700; color: #111827; margin-top: 0; margin-bottom: 1.5rem;">Ringkasan Pembayaran</h3>

                    <div style="margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 1px solid #e5e7eb;">
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: #6b7280;">Layanan ({{ str_replace('_', ' ', $booking->transfer_type) }})</span>
                            <span style="font-weight: 600;">Rp {{ number_format($booking->base_price, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Voucher Section -->
                    <div style="margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 1px solid #e5e7eb;">
                        <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Kode Voucher (Opsional)</label>
                        <div style="display: flex; gap: 0.5rem;">
                            <input type="text" id="voucher-code" placeholder="Masukkan kode voucher" style="flex: 1; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem; text-transform: uppercase;">
                            <button onclick="applyVoucher()" style="padding: 0.5rem 1rem; background-color: #f3f4f6; color: #374151; border: 1px solid #d1d5db; border-radius: 0.375rem; font-weight: 600; cursor: pointer; font-size: 0.875rem;">Terapkan</button>
                        </div>
                        <div id="voucher-message" style="font-size: 0.8rem; margin-top: 0.5rem; display: none;"></div>
                        <input type="hidden" name="voucher_code" id="voucher-code-hidden" value="">
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                        <span style="font-size: 1.125rem; font-weight: 700; color: #111827;">Total</span>
                        <div style="text-align: right;">
                            <span id="original-price" style="font-size: 0.875rem; color: #9ca3af; text-decoration: line-through; display: none;">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                            <span id="final-price" style="font-size: 1.875rem; font-weight: 700; color: #2563eb;">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    @if($payment->status === 'success')
                        <div style="background: #ecfdf5; border: 1px solid #a7f3d0; border-radius: 0.5rem; padding: 1rem; text-align: center;">
                            <p style="color: #047857; font-weight: 600; margin: 0;">✓ Pembayaran Berhasil</p>
                            <a href="{{ route('bookings.airport-transfer.show', $booking) }}" 
                               style="color: #059669; font-weight: 600; font-size: 0.875rem; margin-top: 0.5rem; display: inline-block; text-decoration: none;">
                                Lihat Detail Pemesanan →
                            </a>
                        </div>
                    @else
                        <button onclick="triggerMidtransPayment()" 
                                style="width: 100%; background-color: #2563eb; color: #ffffff; font-weight: 700; padding: 0.75rem 1rem; border-radius: 0.5rem; border: none; cursor: pointer; font-size: 1rem; transition: background-color 0.2s;"
                                onmouseover="this.style.backgroundColor='#1d4ed8'" 
                                onmouseout="this.style.backgroundColor='#2563eb'">
                            Bayar Sekarang
                        </button>
                        
                        @if($payment->status === 'failed')
                            <button onclick="retryPayment()" 
                                    style="width: 100%; margin-top: 0.75rem; background-color: #e5e7eb; color: #111827; font-weight: 600; padding: 0.75rem 1rem; border-radius: 0.5rem; border: none; cursor: pointer; font-size: 1rem; transition: background-color 0.2s;"
                                    onmouseover="this.style.backgroundColor='#d1d5db'" 
                                    onmouseout="this.style.backgroundColor='#e5e7eb'">
                                Coba Lagi
                            </button>
                        @endif
                    @endif

                    <p style="font-size: 0.75rem; color: #6b7280; text-align: center; margin-top: 1rem; margin-bottom: 0;">
                        Pembayaran aman dengan Midtrans
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Voucher Apply Script -->
<script>
    const bookingTotal = {{ $booking->total_price }};
    let discountApplied = 0;

    function applyVoucher() {
        const code = document.getElementById('voucher-code').value.trim().toUpperCase();
        const messageEl = document.getElementById('voucher-message');
        
        if (!code) {
            messageEl.style.display = 'block';
            messageEl.style.color = '#dc2626';
            messageEl.textContent = 'Masukkan kode voucher';
            return;
        }

        // Simple client-side voucher validation (in production, use AJAX to validate server-side)
        fetch('/api/voucher/validate?code=' + encodeURIComponent(code) + '&amount=' + bookingTotal)
            .then(res => res.json())
            .then(data => {
                messageEl.style.display = 'block';
                if (data.valid) {
                    messageEl.style.color = '#059669';
                    messageEl.textContent = '✓ Voucher valid! Diskon: Rp ' + data.discount.toLocaleString('id-ID');
                    discountApplied = data.discount;
                    document.getElementById('voucher-code-hidden').value = code;
                    updatePrice();
                } else {
                    messageEl.style.color = '#dc2626';
                    messageEl.textContent = '✗ ' + (data.message || 'Kode voucher tidak valid');
                    discountApplied = 0;
                    document.getElementById('voucher-code-hidden').value = '';
                    updatePrice();
                }
            })
            .catch(() => {
                // Fallback: accept voucher, server will validate on payment
                messageEl.style.display = 'block';
                messageEl.style.color = '#d97706';
                messageEl.textContent = 'Memvalidasi voucher...';
                document.getElementById('voucher-code-hidden').value = code;
            });
    }

    function updatePrice() {
        const finalTotal = Math.max(0, bookingTotal - discountApplied);
        document.getElementById('final-price').textContent = 'Rp ' + finalTotal.toLocaleString('id-ID');
        if (discountApplied > 0) {
            document.getElementById('original-price').style.display = 'block';
        } else {
            document.getElementById('original-price').style.display = 'none';
        }
    }
</script>

<!-- Midtrans Snap Script -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $clientKey }}"></script>

<script>
    const snapToken = "{{ $snapToken ?? null }}";

    // Countdown Timer - 24 hours from payment creation
    @if($payment->status === 'pending' && $payment->created_at)
    (function() {
        // Set deadline to 24 hours after payment was created
        const deadline = new Date("{{ $payment->created_at->addHours(24)->toIso8601String() }}").getTime();

        function updateCountdown() {
            const now = new Date().getTime();
            const distance = deadline - now;

            if (distance < 0) {
                document.getElementById('countdown-timer').innerHTML = '<span style="color: #991b1b;">EXPIRED</span>';
                return;
            }

            const hours = Math.floor(distance / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById('countdown-timer').innerHTML = 
                String(hours).padStart(2, '0') + ':' + 
                String(minutes).padStart(2, '0') + ':' + 
                String(seconds).padStart(2, '0');
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);
    })();
    @endif

    function triggerMidtransPayment() {
        if (!snapToken || snapToken === 'null') {
            alert('Token pembayaran tidak tersedia');
            return;
        }

        snap.pay(snapToken, {
            onSuccess: function(result) {
                console.log('Payment successful:', result);
                window.location.href = "{{ route('payments.success') }}?" + new URLSearchParams({
                    order_id: result.order_id,
                    status_code: result.status_code,
                    transaction_status: result.transaction_status
                }).toString();
            },
            onPending: function(result) {
                console.log('Payment pending:', result);
                window.location.href = "{{ route('payments.pending') }}?" + new URLSearchParams({
                    order_id: result.order_id,
                    status_code: result.status_code
                }).toString();
            },
            onError: function(result) {
                console.log('Payment error:', result);
                window.location.href = "{{ route('payments.error') }}?" + new URLSearchParams({
                    order_id: result.order_id,
                    status_code: result.status_code
                }).toString();
            },
            onClose: function() {
                console.log('Payment modal closed');
            }
        });
    }

    function retryPayment() {
        fetch("{{ route('payments.retry', $payment) }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.snapToken = data.snapToken;
                triggerMidtransPayment();
            } else {
                alert('Gagal mempersiapkan pembayaran ulang: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan');
        });
    }
</script>
@endsection
