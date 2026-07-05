@extends('layouts.public')

@section('title', __('testimoni.title') . ' - ASR GO')

@section('meta')
<meta name="description" content="Testimoni dari traveler yang sudah menggunakan layanan ASR GO Travel di Flores, NTT">
<meta property="og:title" content="Testimoni Traveler - ASR GO">
<meta property="og:description" content="Apa kata mereka tentang pengalaman travel bersama ASR GO">
@endsection

@section('content')
<!-- HERO -->
<div style="background: linear-gradient(135deg, #0a1a40 0%, #1e3a8a 50%, #3b82f6 100%); padding: 5rem 0;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4">{{ __('testimoni.title') }}</h1>
        <p class="text-blue-100 text-lg max-w-2xl mx-auto">{{ __('testimoni.subtitle') }}</p>
        
        <!-- Stats -->
        <div class="grid grid-cols-3 gap-6 max-w-lg mx-auto mt-10">
            <div>
                <p class="text-3xl font-extrabold text-white">500+</p>
                <p class="text-blue-200 text-sm">{{ __('testimoni.stats_travelers') }}</p>
            </div>
            <div>
                <p class="text-3xl font-extrabold text-white">4.9</p>
                <p class="text-blue-200 text-sm">{{ __('testimoni.stats_rating') }}</p>
            </div>
            <div>
                <p class="text-3xl font-extrabold text-white">98%</p>
                <p class="text-blue-200 text-sm">{{ __('testimoni.stats_satisfied') }}</p>
            </div>
        </div>
    </div>
</div>

<!-- FILTER -->
<div class="bg-white border-b sticky top-0 z-30 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
        <div class="flex items-center gap-2 overflow-x-auto">
            <button onclick="filterTesti('all')" class="testi-filter active px-4 py-2 rounded-full text-sm font-medium bg-blue-600 text-white" data-filter="all">{{ __('testimoni.all') }}</button>
            <button onclick="filterTesti('travel')" class="testi-filter px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-600 hover:bg-blue-50" data-filter="travel">{{ __('testimoni.travel') }}</button>
            <button onclick="filterTesti('rental')" class="testi-filter px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-600 hover:bg-blue-50" data-filter="rental">{{ __('testimoni.rental') }}</button>
            <button onclick="filterTesti('airport')" class="testi-filter px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-600 hover:bg-blue-50" data-filter="airport">{{ __('testimoni.airport') }}</button>
        </div>
    </div>
</div>

<!-- TESTIMONI GRID -->
<div class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            @php
            $testimonials = [
                ['name' => 'Sarah Wijaya', 'from' => 'Jakarta', 'avatar' => 'https://i.pravatar.cc/100?img=1', 'rating' => 5, 'service' => 'travel', 'route' => 'Ende → Labuan Bajo', 'date' => '2 minggu lalu', 'text' => 'Pengalaman travel yang luar biasa! Supirnya sangat ramah dan berpengalaman. Mobil bersih dan AC dingin. Pemandangan Flores dari Ende ke Labuan Bajo bikin takjib. Pasti pakai ASR GO lagi!'],
                ['name' => 'Budi Santoso', 'from' => 'Surabaya', 'avatar' => 'https://i.pravatar.cc/100?img=3', 'rating' => 5, 'service' => 'rental', 'route' => 'Rental di Maumere', 'date' => '1 bulan lalu', 'text' => 'Rental mobil di ASR GO sangat terjangkau. Kondisi mobil prima, dan saya bisa explore Teluk Maumere dengan bebas. Proses booking mudah dan cepat.'],
                ['name' => 'Maria Gomes', 'from' => 'Kupang', 'avatar' => 'https://i.pravatar.cc/100?img=5', 'rating' => 5, 'service' => 'travel', 'route' => 'Ende → Kelimutu', 'date' => '3 minggu lalu', 'text' => 'Sunrise di Kelimutu magical! ASR GO antar jam 4 pagi dan kami sampai di puncak tepat waktu. Terima kasih untuk pelayanan yang excellent!'],
                ['name' => 'David Chen', 'from' => 'Singapura', 'avatar' => 'https://i.pravatar.cc/100?img=8', 'rating' => 5, 'service' => 'airport', 'route' => 'Airport Transfer', 'date' => '1 minggu lalu', 'text' => 'Airport transfer service was outstanding! Driver was punctual, car was clean, and the price was very reasonable. Highly recommended for international travelers.'],
                ['name' => 'Rina Kusuma', 'from' => 'Yogyakarta', 'avatar' => 'https://i.pravatar.cc/100?img=9', 'rating' => 4, 'service' => 'travel', 'route' => 'Ende → Bajawa', 'date' => '2 bulan lalu', 'text' => 'Perjalanan ke Bajawa nyaman. Satu-satunya catatan: jalan berkelok tapi supirnya hati-hati. Overall sangat puas dengan layanan ASR GO.'],
                ['name' => 'Ahmad Rizky', 'from' => 'Bali', 'avatar' => 'https://i.pravatar.cc/100?img=11', 'rating' => 5, 'service' => 'rental', 'route' => 'Rental di Ende', 'date' => '1 bulan lalu', 'text' => 'Sewa mobil untuk 3 hari explore Ende. Danau Kelimutu, Pantai Ende, Rumah Bung Karno — semua bisa dikunjungi dengan mudah. Mobil irit dan nyaman.'],
                ['name' => 'Lisa Tanaka', 'from' => 'Tokyo', 'avatar' => 'https://i.pravatar.cc/100?img=16', 'rating' => 5, 'service' => 'travel', 'route' => 'Labuan Bajo → Komodo', 'date' => '5 hari lalu', 'text' => 'The trip to Komodo Island was amazing! ASR GO made everything seamless from pickup to drop-off. The driver knew all the best spots for photos.'],
                ['name' => 'Hendrik Paul', 'from' => 'Maumere', 'avatar' => 'https://i.pravatar.cc/100?img=12', 'rating' => 5, 'service' => 'airport', 'route' => 'Airport Transfer', 'date' => '3 hari lalu', 'text' => 'Transfer dari Bandara Wai Oti ke kota Maumere cepat dan murah. Supir sudah menunggu dengan plangan nama. Sangat profesional!'],
                ['name' => 'Dewi Lestari', 'from' => 'Bandung', 'avatar' => 'https://i.pravatar.cc/100?img=20', 'rating' => 5, 'service' => 'travel', 'route' => 'Ende → Wae Rebo', 'date' => '1 bulan lalu', 'text' => 'Trekking ke Wae Rebo pengalaman sekali seumur hidup! ASR GO antar sampai base camp dan jemput lagi. Pelayanan top banget.'],
            ];
            @endphp

            @foreach($testimonials as $t)
            <div class="testi-card bg-white rounded-2xl p-6 shadow-sm hover:shadow-md transition" data-service="{{ $t['service'] }}">
                <!-- Header -->
                <div class="flex items-center gap-3 mb-4">
                    <img src="{{ $t['avatar'] }}" alt="{{ $t['name'] }}" class="w-12 h-12 rounded-full object-cover">
                    <div>
                        <p class="font-bold text-gray-900">{{ $t['name'] }}</p>
                        <p class="text-xs text-gray-500">{{ $t['from'] }}</p>
                    </div>
                    <span class="ml-auto text-xs text-gray-400">{{ $t['date'] }}</span>
                </div>
                <!-- Rating -->
                <div class="flex items-center gap-1 mb-3">
                    @for($i = 0; $i < 5; $i++)
                    <svg class="w-4 h-4 {{ $i < $t['rating'] ? 'text-yellow-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                    <span class="text-xs text-gray-500 ml-2">{{ $t['route'] }}</span>
                </div>
                <!-- Text -->
                <p class="text-gray-600 text-sm leading-relaxed">{{ $t['text'] }}</p>
                <!-- Badge -->
                <div class="mt-4 pt-3 border-t border-gray-100">
                    <span class="text-xs font-medium px-2.5 py-1 rounded-full {{ $t['service'] == 'travel' ? 'bg-blue-50 text-blue-600' : ($t['service'] == 'rental' ? 'bg-green-50 text-green-600' : 'bg-purple-50 text-purple-600') }}">
                        {{ $t['service'] == 'travel' ? '🚐 Travel' : ($t['service'] == 'rental' ? '🚗 Rental' : '✈️ Airport Transfer') }}
                    </span>
                </div>
            </div>
            @endforeach

        </div>

        <!-- CTA -->
        <div class="text-center mt-12">
            <p class="text-gray-500 mb-4">{{ __('testimoni.cta_text') }}</p>
            <a href="/public/travel" class="inline-flex items-center gap-2 px-8 py-3.5 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition shadow-lg">
                {{ __('testimoni.cta_button') }}
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
            </a>
        </div>
    </div>
</div>

<script>
function filterTesti(type) {
    document.querySelectorAll('.testi-filter').forEach(btn => {
        if (btn.dataset.filter === type) {
            btn.classList.remove('bg-gray-100', 'text-gray-600');
            btn.classList.add('bg-blue-600', 'text-white');
        } else {
            btn.classList.add('bg-gray-100', 'text-gray-600');
            btn.classList.remove('bg-blue-600', 'text-white');
        }
    });
    document.querySelectorAll('.testi-card').forEach(card => {
        card.style.display = (type === 'all' || card.dataset.service === type) ? 'block' : 'none';
    });
}
</script>
@endsection
