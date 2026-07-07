@extends('layouts.public')

@section('title', __('cek_booking.title') . ' - ASR GO')

@section('content')
<div class="bg-gradient-to-br from-blue-50 to-white min-h-[80vh] py-16">
    <div class="max-w-xl mx-auto px-4">
        <div class="text-center mb-10">
            <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <h1 class="text-3xl font-extrabold text-gray-900 mb-2">{{ __('cek_booking.title') }}</h1>
            <p class="text-gray-500">{{ __('cek_booking.subtitle') }}</p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-8">
            <form onsubmit="checkBooking(event)" class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('cek_booking.code_label') }}</label>
                    <input type="text" id="bookingCode" placeholder="{{ __('cek_booking.code_placeholder') }}" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent text-lg font-mono uppercase">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('cek_booking.email_label') }}</label>
                    <input type="email" id="bookingEmail" placeholder="{{ __('cek_booking.email_placeholder') }}" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <button type="submit" class="w-full py-3.5 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    {{ __('cek_booking.submit') }}
                </button>
            </form>

            <!-- Result -->
            <div id="bookingResult" class="hidden mt-6 pt-6 border-t border-gray-100">
                <!-- Filled by JS -->
            </div>
        </div>

        <!-- Help -->
        <div class="mt-6 text-center text-sm text-gray-500">
            <p>{{ __('cek_booking.help') }} <a href="https://wa.me/6283156408078" class="text-blue-600 font-medium">{{ __('cek_booking.help_wa') }}</a></p>
        </div>
    </div>
</div>

<script>
function checkBooking(e) {
    e.preventDefault();
    const code = document.getElementById('bookingCode').value.trim().toUpperCase();
    const email = document.getElementById('bookingEmail').value.trim();
    const result = document.getElementById('bookingResult');
    
    // Demo data - in production this would be an API call
    const demoBookings = {
        'ASR-20260629-ABC': {
            status: 'confirmed',
            route: 'Ende → Labuan Bajo',
            date: '30 Juni 2026',
            time: '07:00 WIB',
            passengers: 2,
            vehicle: 'Toyota Hiace Commuter',
            driver: 'Yohanes K.',
            price: 'Rp 700.000',
            paid: true
        },
        'ASR-20260628-DEF': {
            status: 'completed',
            route: 'Ende → Danau Kelimutu',
            date: '28 Juni 2026',
            time: '04:30 WIB',
            passengers: 4,
            vehicle: 'Mitsubishi L300',
            driver: 'Petrus M.',
            price: 'Rp 400.000',
            paid: true
        },
        'ASR-20260630-GHI': {
            status: 'pending',
            route: 'Ende → Maumere',
            date: '01 Juli 2026',
            time: '08:00 WIB',
            passengers: 1,
            vehicle: 'Belum ditentukan',
            driver: 'Belum ditentukan',
            price: 'Rp 150.000',
            paid: false
        }
    };
    
    const booking = demoBookings[code];
    
    if (booking) {
        const statusColors = {
            'confirmed': 'bg-green-100 text-green-700',
            'pending': 'bg-yellow-100 text-yellow-700',
            'completed': 'bg-blue-100 text-blue-700',
            'cancelled': 'bg-red-100 text-red-700'
        };
        const statusLabels = {
            'confirmed': 'Terkonfirmasi',
            'pending': 'Menunggu Pembayaran',
            'completed': 'Selesai',
            'cancelled': 'Dibatalkan'
        };
        
        result.classList.remove('hidden');
        result.innerHTML = `
            <div class="flex items-center justify-between mb-4">
                <span class="font-mono text-sm text-gray-500">${code}</span>
                <span class="px-3 py-1 rounded-full text-xs font-bold ${statusColors[booking.status]}">${statusLabels[booking.status]}</span>
            </div>
            <div class="space-y-3">
                <div class="flex justify-between py-2 border-b border-gray-50">
                    <span class="text-gray-500">Rute</span>
                    <span class="font-medium">${booking.route}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-50">
                    <span class="text-gray-500">Tanggal & Waktu</span>
                    <span class="font-medium">${booking.date}, ${booking.time}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-50">
                    <span class="text-gray-500">Penumpang</span>
                    <span class="font-medium">${booking.passengers} orang</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-50">
                    <span class="text-gray-500">Kendaraan</span>
                    <span class="font-medium">${booking.vehicle}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-50">
                    <span class="text-gray-500">Supir</span>
                    <span class="font-medium">${booking.driver}</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-gray-500">Total</span>
                    <span class="font-bold text-blue-600">${booking.price}</span>
                </div>
            </div>
            ${!booking.paid ? '<a href="#" class="mt-4 block w-full py-3 bg-green-500 text-white text-center rounded-xl font-bold hover:bg-green-600">Bayar Sekarang</a>' : ''}
        `;
    } else {
        result.classList.remove('hidden');
        result.innerHTML = `
            <div class="text-center py-4">
                <p class="text-red-500 font-medium">Booking tidak ditemukan</p>
                <p class="text-gray-400 text-sm mt-1">Pastikan kode booking dan email benar</p>
            </div>
        `;
    }
}
</script>
@endsection
