@extends('layouts.app')

@section('title', 'Ajukan Pembatalan & Refund')

@section('content')
<style>
    .refund-card {
        background: linear-gradient(135deg, #fff 0%, #f8fafc 100%);
    }
    .policy-badge-safe {
        background: linear-gradient(135deg, #ecfdf5, #d1fae5);
        border-color: #6ee7b7;
    }
    .policy-badge-late {
        background: linear-gradient(135deg, #fef2f2, #fee2e2);
        border-color: #fca5a5;
    }
    .breakdown-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.625rem 0;
    }
    .breakdown-row + .breakdown-row {
        border-top: 1px dashed #e5e7eb;
    }
</style>

<div class="max-w-2xl mx-auto py-8 px-4">

    {{-- Back Button --}}
    <a href="{{ url()->previous() }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors mb-6">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali ke Detail Pesanan
    </a>

    <div class="mb-6">
        <h1 class="text-2xl font-extrabold text-gray-900 mb-1">Ajukan Pembatalan & Refund</h1>
        <p class="text-gray-500 text-sm">Kode Pesanan: <span class="font-mono font-bold text-gray-800">{{ $bookingModel->booking_code }}</span></p>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg">
            <p class="text-red-700 font-semibold mb-2">Mohon perbaiki kesalahan berikut:</p>
            <ul class="text-red-600 text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- 24-Hour Policy Banner --}}
    @if($isLateCancel)
        <div class="policy-badge-late border rounded-2xl p-5 mb-6">
            <div class="flex items-start gap-3">
                <div class="p-2 bg-red-100 rounded-xl flex-shrink-0">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-red-800 text-sm mb-1">⚠️ Pembatalan Terlambat — PPN 11% Dikenakan</h3>
                    <p class="text-red-700 text-xs leading-relaxed">
                        Pembatalan dilakukan <strong>kurang dari 24 jam</strong> sebelum jadwal keberangkatan. 
                        Sesuai kebijakan ASR GO, pengembalian dana akan dikenakan <strong>Pajak Pertambahan Nilai (PPN) sebesar 11%</strong>.
                    </p>
                    @if($hoursUntilDeparture >= 0)
                        <p class="text-red-600 text-xs font-semibold mt-2">
                            ⏰ Sisa waktu keberangkatan: <strong>{{ round($hoursUntilDeparture) }} jam lagi</strong>
                        </p>
                    @else
                        <p class="text-red-600 text-xs font-semibold mt-2">
                            ⏰ Jadwal keberangkatan <strong>sudah lewat {{ abs(round($hoursUntilDeparture)) }} jam yang lalu</strong>
                        </p>
                    @endif
                </div>
            </div>
        </div>
    @else
        <div class="policy-badge-safe border rounded-2xl p-5 mb-6">
            <div class="flex items-start gap-3">
                <div class="p-2 bg-emerald-100 rounded-xl flex-shrink-0">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-emerald-800 text-sm mb-1">✅ Refund Penuh — Tanpa Potongan</h3>
                    <p class="text-emerald-700 text-xs leading-relaxed">
                        Pembatalan dilakukan <strong>lebih dari 24 jam</strong> sebelum jadwal keberangkatan. 
                        Anda berhak mendapatkan <strong>pengembalian dana penuh (100%)</strong> tanpa potongan PPN.
                    </p>
                    <p class="text-emerald-600 text-xs font-semibold mt-2">
                        ⏰ Sisa waktu keberangkatan: <strong>{{ round($hoursUntilDeparture) }} jam lagi</strong>
                    </p>
                </div>
            </div>
        </div>
    @endif

    {{-- Refund Breakdown Card --}}
    <div class="refund-card bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <h3 class="font-bold text-gray-900 text-base mb-4 pb-3 border-b border-gray-100">Rincian Pengembalian Dana</h3>

        <div class="space-y-0">
            <div class="breakdown-row">
                <span class="text-sm text-gray-600">Jenis Pesanan</span>
                <span class="text-sm font-semibold text-gray-800 capitalize">{{ $bookingType === 'travel' ? '🚌 Travel' : '🚗 Rental' }}</span>
            </div>
            <div class="breakdown-row">
                <span class="text-sm text-gray-600">Kode Booking</span>
                <span class="text-sm font-mono font-bold text-gray-800">{{ $bookingModel->booking_code }}</span>
            </div>
            @if($bookingType === 'travel')
                <div class="breakdown-row">
                    <span class="text-sm text-gray-600">Rute</span>
                    <span class="text-sm font-semibold text-gray-800">
                        {{ $bookingModel->route?->origin_city ?? '-' }} → {{ $bookingModel->route?->destination_city ?? '-' }}
                    </span>
                </div>
                <div class="breakdown-row">
                    <span class="text-sm text-gray-600">Tanggal Keberangkatan</span>
                    <span class="text-sm font-semibold text-gray-800">
                        {{ \Carbon\Carbon::parse($bookingModel->scheduled_date)->translatedFormat('d F Y') }}
                    </span>
                </div>
            @else
                <div class="breakdown-row">
                    <span class="text-sm text-gray-600">Tanggal Mulai Sewa</span>
                    <span class="text-sm font-semibold text-gray-800">
                        {{ \Carbon\Carbon::parse($bookingModel->start_date)->translatedFormat('d F Y') }}
                    </span>
                </div>
            @endif
            <div class="breakdown-row">
                <span class="text-sm text-gray-600">Total Pembayaran</span>
                <span class="text-sm font-bold text-gray-800">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
            </div>

            @if($isLateCancel)
                <div class="breakdown-row">
                    <div>
                        <span class="text-sm text-red-600 font-medium">Potongan PPN</span>
                        <span class="ml-2 text-xs bg-red-100 text-red-600 font-bold px-2 py-0.5 rounded-full">{{ ($ppnRate * 100) }}%</span>
                    </div>
                    <span class="text-sm font-bold text-red-600">- Rp {{ number_format($ppnAmount, 0, ',', '.') }}</span>
                </div>
            @endif

            <div class="breakdown-row pt-3 border-t-2 border-gray-200 mt-2">
                <span class="text-base font-black text-gray-900">Total Refund yang Dikembalikan</span>
                <span class="text-xl font-black {{ $isLateCancel ? 'text-orange-500' : 'text-emerald-600' }}">
                    Rp {{ number_format($refundAmount, 0, ',', '.') }}
                </span>
            </div>
        </div>

        <div class="mt-4 bg-blue-50 rounded-xl p-3 border border-blue-100">
            <p class="text-xs text-blue-700">
                <strong>ℹ️ Catatan:</strong> Proses pengembalian dana membutuhkan waktu <strong>3–5 hari kerja</strong> setelah permohonan disetujui oleh admin.
            </p>
        </div>
    </div>

    {{-- Reason Form --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('bookings.refund.store', $bookingModel) }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="reason" class="block text-sm font-bold text-gray-700 mb-2">
                    Alasan Pembatalan <span class="text-red-500">*</span>
                </label>
                <textarea name="reason" id="reason" rows="4" required
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 transition-colors resize-none text-sm @error('reason') border-red-500 @enderror"
                    placeholder="Jelaskan alasan Anda mengajukan pembatalan pesanan ini...">{{ old('reason') }}</textarea>
                @error('reason')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Confirmation Checkbox --}}
            <div class="flex items-start gap-3 bg-gray-50 rounded-xl p-4 border border-gray-200">
                <input type="checkbox" id="confirm_cancel" required
                    class="mt-0.5 w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 cursor-pointer">
                <label for="confirm_cancel" class="text-xs text-gray-700 cursor-pointer leading-relaxed">
                    Saya memahami dan menyetujui kebijakan pembatalan ASR GO.
                    @if($isLateCancel)
                        <strong class="text-red-600">Saya setuju bahwa refund akan dipotong PPN 11% (Rp {{ number_format($ppnAmount, 0, ',', '.') }}) karena pembatalan dilakukan kurang dari 24 jam sebelum keberangkatan.</strong>
                    @else
                        <strong class="text-emerald-600">Saya akan menerima refund penuh sebesar Rp {{ number_format($refundAmount, 0, ',', '.') }}.</strong>
                    @endif
                </label>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                    class="flex-1 {{ $isLateCancel ? 'bg-orange-500 hover:bg-orange-600' : 'bg-red-600 hover:bg-red-700' }} text-white py-3 px-6 rounded-xl font-bold text-sm shadow-md transition-all">
                    @if($isLateCancel)
                        ⚠️ Ajukan Pembatalan (Kena PPN 11%)
                    @else
                        Ajukan Pembatalan & Refund Penuh
                    @endif
                </button>
                <a href="{{ url()->previous() }}"
                    class="flex-1 bg-gray-100 text-gray-700 py-3 px-6 rounded-xl font-bold text-sm hover:bg-gray-200 transition-all text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>

</div>
@endsection
