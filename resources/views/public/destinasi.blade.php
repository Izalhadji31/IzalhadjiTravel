@extends('layouts.public')

@section('title', __('destinasi.title') . ' - ASR GO')

@section('content')
<!-- HERO DESTINASI -->
<div style="background: linear-gradient(135deg, #0a1a40 0%, #0f2460 25%, #1e3a8a 55%, #1d4ed8 80%, #3b82f6 100%); padding: 4rem 0; position: relative; overflow: hidden;">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-10 right-10 w-96 h-96 rounded-full" style="background: radial-gradient(circle, white 0%, transparent 70%);"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center">
            <h1 class="text-4xl lg:text-5xl font-extrabold text-white mb-4">{{ __('destinasi.title') }}</h1>
            <p class="text-blue-100 text-lg max-w-2xl mx-auto">Jelajahi 21+ destinasi wisata terbaik Pulau Flores dari Ende hingga Larantuka</p>
            <div class="mt-8 max-w-xl mx-auto">
                <div class="relative">
                    <input type="text" id="searchDest" placeholder="{{ __('destinasi.search_placeholder') }}" 
                           class="w-full px-5 py-4 pr-12 rounded-xl bg-white/95 backdrop-blur text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-300 shadow-lg">
                    <svg class="absolute right-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- KOTA NAVIGATION -->
<div class="bg-white border-b border-gray-100 sticky top-0 z-40 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-1 py-3 overflow-x-auto scrollbar-hide">
            <button onclick="filterKota('all')" class="kota-btn active px-4 py-2 rounded-full text-sm font-medium bg-blue-600 text-white transition-all" data-kota="all">Semua</button>
            <button onclick="filterKota('ende')" class="kota-btn px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-600 hover:bg-blue-50 hover:text-blue-600 transition-all" data-kota="ende">Ende</button>
            <button onclick="filterKota('labuan-bajo')" class="kota-btn px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-600 hover:bg-blue-50 hover:text-blue-600 transition-all" data-kota="labuan-bajo">Labuan Bajo</button>
            <button onclick="filterKota('ruteng')" class="kota-btn px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-600 hover:bg-blue-50 hover:text-blue-600 transition-all" data-kota="ruteng">Ruteng</button>
            <button onclick="filterKota('bajawa')" class="kota-btn px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-600 hover:bg-blue-50 hover:text-blue-600 transition-all" data-kota="bajawa">Bajawa</button>
            <button onclick="filterKota('maumere')" class="kota-btn px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-600 hover:bg-blue-50 hover:text-blue-600 transition-all" data-kota="maumere">Maumere</button>
            <button onclick="filterKota('riung')" class="kota-btn px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-600 hover:bg-blue-50 hover:text-blue-600 transition-all" data-kota="riung">Riung</button>
            <button onclick="filterKota('larantuka')" class="kota-btn px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-600 hover:bg-blue-50 hover:text-blue-600 transition-all" data-kota="larantuka">Larantuka</button>
        </div>
    </div>
</div>

<!-- CONTENT -->
<div class="bg-gray-50 py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- ENDE SECTION -->
        <div class="kota-section mb-16" data-kota="ende">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center text-white font-bold">E</div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Kota Ende</h2>
                    <p class="text-gray-500">Kota Pancasila, gerbang menuju Danau Kelimutu legendaris</p>
                </div>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
                <a href="{{ route('public.destinasi.detail', 'danau-kelimutu') }}" class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition group">
                    <div class="h-44 overflow-hidden"><img src="{{ asset('images/destinations/danau-kelimutu.jpg') }}" alt="Danau Kelimutu" class="w-full h-full object-cover group-hover:scale-105 transition-transform"></div>
                    <div class="p-4"><h4 class="font-bold text-gray-900">Danau Kelimutu</h4><p class="text-gray-500 text-sm">Tiga danau kawah warna-warni di atas awan</p></div>
                </a>
                <a href="{{ route('public.destinasi.detail', 'rumah-bung-karno') }}" class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition group">
                    <div class="h-44 overflow-hidden"><img src="{{ asset('images/destinations/rumah-bung-karno.jpg') }}" alt="Rumah Bung Karno" class="w-full h-full object-cover group-hover:scale-105 transition-transform"></div>
                    <div class="p-4"><h4 class="font-bold text-gray-900">Rumah Bung Karno</h4><p class="text-gray-500 text-sm">Situs bersejarah perjuangan nasional</p></div>
                </a>
                <a href="{{ route('public.destinasi.detail', 'air-terjun-ogi') }}" class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition group">
                    <div class="h-44 overflow-hidden"><img src="{{ asset('images/destinations/air-terjun-ogi.jpg') }}" alt="Air Terjun Ogi" class="w-full h-full object-cover group-hover:scale-105 transition-transform"></div>
                    <div class="p-4"><h4 class="font-bold text-gray-900">Air Terjun Ogi</h4><p class="text-gray-500 text-sm">Air terjun di hutan tropis lebat</p></div>
                </a>
                <a href="{{ route('public.destinasi.detail', 'pantai-ena-bara') }}" class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition group">
                    <div class="h-44 overflow-hidden"><img src="{{ asset('images/destinations/pantai-ena-bara.jpg') }}" alt="Pantai Ena Bara" class="w-full h-full object-cover group-hover:scale-105 transition-transform"></div>
                    <div class="p-4"><h4 class="font-bold text-gray-900">Pantai Ena Bara</h4><p class="text-gray-500 text-sm">Pantai pasir putih & sunset indah</p></div>
                </a>
            </div>
        </div>

        <!-- LABUAN BAJO SECTION -->
        <div class="kota-section mb-16" data-kota="labuan-bajo">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-teal-500 to-teal-700 flex items-center justify-center text-white font-bold">LB</div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Labuan Bajo</h2>
                    <p class="text-gray-500">Gerbang Taman Nasional Komodo UNESCO World Heritage</p>
                </div>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
                <a href="{{ route('public.destinasi.detail', 'pulau-komodo') }}" class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition group">
                    <div class="h-44 overflow-hidden"><img src="{{ asset('images/destinations/pulau-komodo.avif') }}" alt="Pulau Komodo" class="w-full h-full object-cover group-hover:scale-105 transition-transform"></div>
                    <div class="p-4"><h4 class="font-bold text-gray-900">Pulau Komodo</h4><p class="text-gray-500 text-sm">Habitat komodo raksasa prasejarah</p></div>
                </a>
                <a href="{{ route('public.destinasi.detail', 'pulau-padar') }}" class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition group">
                    <div class="h-44 overflow-hidden"><img src="{{ asset('images/destinations/pulau-padar.avif') }}" alt="Pulau Padar" class="w-full h-full object-cover group-hover:scale-105 transition-transform"></div>
                    <div class="p-4"><h4 class="font-bold text-gray-900">Pulau Padar</h4><p class="text-gray-500 text-sm">Tiga teluk berwarna dari puncak bukit</p></div>
                </a>
                <a href="{{ route('public.destinasi.detail', 'pink-beach') }}" class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition group">
                    <div class="h-44 overflow-hidden"><img src="{{ asset('images/destinations/pink-beach.avif') }}" alt="Pink Beach" class="w-full h-full object-cover group-hover:scale-105 transition-transform"></div>
                    <div class="p-4"><h4 class="font-bold text-gray-900">Pink Beach</h4><p class="text-gray-500 text-sm">Pantai pasir merah muda 1 dari 7 dunia</p></div>
                </a>
            </div>
        </div>

        <!-- RUTENG SECTION -->
        <div class="kota-section mb-16" data-kota="ruteng">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-green-500 to-green-700 flex items-center justify-center text-white font-bold">R</div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Ruteng & Manggarai</h2>
                    <p class="text-gray-500">Desa di atas awan dan sawah jaring laba-laba</p>
                </div>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
                <a href="{{ route('public.destinasi.detail', 'wae-rebo') }}" class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition group md:col-span-2 lg:col-span-1">
                    <div class="h-44 overflow-hidden"><img src="{{ asset('images/destinations/wae-rebo.jpg') }}" alt="Wae Rebo" class="w-full h-full object-cover group-hover:scale-105 transition-transform"></div>
                    <div class="p-4"><h4 class="font-bold text-gray-900">Wae Rebo</h4><p class="text-gray-500 text-sm">UNESCO Heritage Award 2012, di atas awan 1.200 m</p></div>
                </a>
                <a href="{{ route('public.destinasi.detail', 'gua-liang-bua') }}" class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition group">
                    <div class="h-44 overflow-hidden"><img src="{{ asset('images/destinations/gua-liang-bua.jpeg') }}" alt="Gua Liang Bua" class="w-full h-full object-cover group-hover:scale-105 transition-transform"></div>
                    <div class="p-4"><h4 class="font-bold text-gray-900">Gua Liang Bua</h4><p class="text-gray-500 text-sm">Gua stalaktit & stalagmit kelelawar</p></div>
                </a>
                <a href="{{ route('public.destinasi.detail', 'sawah-lodok-spiderman') }}" class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition group">
                    <div class="h-44 overflow-hidden"><img src="{{ asset('images/destinations/sawah-lodok-spiderman.jpg') }}" alt="Sawah Spiderman" class="w-full h-full object-cover group-hover:scale-105 transition-transform"></div>
                    <div class="p-4"><h4 class="font-bold text-gray-900">Sawah Spiderman</h4><p class="text-gray-500 text-sm">Persawahan terasering pola unik</p></div>
                </a>
                <a href="{{ route('public.destinasi.detail', 'taman-wisata-alam-ruteng') }}" class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition group">
                    <div class="h-44 overflow-hidden"><img src="{{ asset('images/destinations/taman-wisata-alam-ruteng.jpg') }}" alt="Taman Wisata Alam Ruteng" class="w-full h-full object-cover group-hover:scale-105 transition-transform"></div>
                    <div class="p-4"><h4 class="font-bold text-gray-900">Taman Wisata Alam</h4><p class="text-gray-500 text-sm">Trek hiking hutan tropis</p></div>
                </a>
            </div>
        </div>

        <!-- BAJAWA SECTION -->
        <div class="kota-section mb-16" data-kota="bajawa">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-500 to-amber-700 flex items-center justify-center text-white font-bold">B</div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Bajawa & Ngada</h2>
                    <p class="text-gray-500">Desa megalit kuno dan Gunung Inerie aktif</p>
                </div>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
                <a href="{{ route('public.destinasi.detail', 'kampung-bena') }}" class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition group">
                    <div class="h-44 overflow-hidden"><img src="{{ asset('images/destinations/kampung-bena.jpg') }}" alt="Kampung Bena" class="w-full h-full object-cover group-hover:scale-105 transition-transform"></div>
                    <div class="p-4"><h4 class="font-bold text-gray-900">Kampung Bena</h4><p class="text-gray-500 text-sm">Desa adat dengan 9 rumah megalit</p></div>
                </a>
                <a href="{{ route('public.destinasi.detail', 'gunung-inerie') }}" class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition group">
                    <div class="h-44 overflow-hidden"><img src="{{ asset('images/destinations/gunung-inerie.jpg') }}" alt="Gunung Inerie" class="w-full h-full object-cover group-hover:scale-105 transition-transform"></div>
                    <div class="p-4"><h4 class="font-bold text-gray-900">Gunung Inerie</h4><p class="text-gray-500 text-sm">Gunung berapi 2.245 m trekking</p></div>
                </a>
            </div>
        </div>

        <!-- MAUMERE SECTION -->
        <div class="kota-section mb-16" data-kota="maumere">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-cyan-500 to-cyan-700 flex items-center justify-center text-white font-bold">Ma</div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Maumere & Sikka</h2>
                    <p class="text-gray-500">Surga diving dengan terumbu karang terbaik dunia</p>
                </div>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
                <a href="{{ route('public.destinasi.detail', 'teluk-maumere') }}" class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition group">
                    <div class="h-44 overflow-hidden"><img src="{{ asset('images/destinations/teluk-maumere.jpg') }}" alt="Teluk Maumere" class="w-full h-full object-cover group-hover:scale-105 transition-transform"></div>
                    <div class="p-4"><h4 class="font-bold text-gray-900">Teluk Maumere</h4><p class="text-gray-500 text-sm">Lokasi diving terbaik dunia 30+ spot</p></div>
                </a>
                <a href="{{ route('public.destinasi.detail', 'pantai-koka') }}" class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition group">
                    <div class="h-44 overflow-hidden"><img src="{{ asset('images/destinations/pantai-koka.jpg') }}" alt="Pantai Koka" class="w-full h-full object-cover group-hover:scale-105 transition-transform"></div>
                    <div class="p-4"><h4 class="font-bold text-gray-900">Pantai Koka</h4><p class="text-gray-500 text-sm">Pantai pasir hitam vulkanik</p></div>
                </a>
            </div>
        </div>

        <!-- RIUNG SECTION -->
        <div class="kota-section mb-16" data-kota="riung">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-700 flex items-center justify-center text-white font-bold">Ri</div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Riung & Nagekeo</h2>
                    <p class="text-gray-500">17 pulau dengan kelelawar raksasa</p>
                </div>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
                <a href="{{ route('public.destinasi.detail', 'taman-laut-17-pulau') }}" class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition group">
                    <div class="h-44 overflow-hidden"><img src="{{ asset('images/destinations/taman-laut-17-pulau.jpg') }}" alt="Taman Laut 17 Pulau" class="w-full h-full object-cover group-hover:scale-105 transition-transform"></div>
                    <div class="p-4"><h4 class="font-bold text-gray-900">Taman Laut 17 Pulau</h4><p class="text-gray-500 text-sm">Kelelawar raksasa & snorkeling</p></div>
                </a>
                <a href="{{ route('public.destinasi.detail', 'pulau-kinde') }}" class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition group">
                    <div class="h-44 overflow-hidden"><img src="{{ asset('images/destinations/pulau-kinde.jpg') }}" alt="Pulau Kinde" class="w-full h-full object-cover group-hover:scale-105 transition-transform"></div>
                    <div class="p-4"><h4 class="font-bold text-gray-900">Pulau Kinde</h4><p class="text-gray-500 text-sm">Snorkeling terbaik di Riung</p></div>
                </a>
            </div>
        </div>

        <!-- LARANTUKA SECTION -->
        <div class="kota-section mb-16" data-kota="larantuka">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-rose-500 to-rose-700 flex items-center justify-center text-white font-bold">L</div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Larantuka</h2>
                    <p class="text-gray-500">Kota dengan tradisi Semana Santa mendunia</p>
                </div>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
                <a href="{{ route('public.destinasi.detail', 'benteng-lohayong') }}" class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition group">
                    <div class="h-44 overflow-hidden"><img src="{{ asset('images/destinations/benteng-lohayong.jpg') }}" alt="Benteng Lohayong" class="w-full h-full object-cover group-hover:scale-105 transition-transform"></div>
                    <div class="p-4"><h4 class="font-bold text-gray-900">Benteng Lohayong</h4><p class="text-gray-500 text-sm">Benteng Portugis abad ke-16</p></div>
                </a>
                <a href="{{ route('public.destinasi.detail', 'bukit-fatima') }}" class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition group">
                    <div class="h-44 overflow-hidden"><img src="{{ asset('images/destinations/bukit-fatima.jpeg') }}" alt="Bukit Fatima" class="w-full h-full object-cover group-hover:scale-105 transition-transform"></div>
                    <div class="p-4"><h4 class="font-bold text-gray-900">Bukit Fatima</h4><p class="text-gray-500 text-sm">Patung Maria & tempat ziarah</p></div>
                </a>
                <a href="{{ route('public.destinasi.detail', 'pantai-watotena') }}" class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition group">
                    <div class="h-44 overflow-hidden"><img src="{{ asset('images/destinations/pantai-watotena.jpg') }}" alt="Pantai Watotena" class="w-full h-full object-cover group-hover:scale-105 transition-transform"></div>
                    <div class="p-4"><h4 class="font-bold text-gray-900">Pantai Watotena</h4><p class="text-gray-500 text-sm">Pantai terindah di Larantuka</p></div>
                </a>
                <a href="{{ route('public.destinasi.detail', 'semana-santa-larantuka') }}" class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition group">
                    <div class="h-44 overflow-hidden"><img src="{{ asset('images/destinations/semana-santa-flotim.jpg') }}" alt="Semana Santa" class="w-full h-full object-cover group-hover:scale-105 transition-transform"></div>
                    <div class="p-4"><h4 class="font-bold text-gray-900">Semana Santa</h4><p class="text-gray-500 text-sm">Tradisi Paskah 400+ tahun</p></div>
                </a>
            </div>
        </div>

    </div>
</div>

<script>
function filterKota(kota) {
    // Update button states
    document.querySelectorAll('.kota-btn').forEach(btn => {
        btn.classList.remove('active', 'bg-blue-600', 'text-white');
        btn.classList.add('bg-gray-100', 'text-gray-600');
    });
    document.querySelector(`[data-kota="${kota}"]`).closest('.kota-btn').classList.add('active', 'bg-blue-600', 'text-white');
    
    // Show/hide sections
    document.querySelectorAll('.kota-section').forEach(section => {
        if (kota === 'all' || section.dataset.kota === kota) {
            section.style.display = 'block';
        } else {
            section.style.display = 'none';
        }
    });
}

// Search functionality
document.getElementById('searchDest').addEventListener('keyup', (e) => {
    const query = e.target.value.toLowerCase();
    document.querySelectorAll('.kota-section').forEach(section => {
        let found = false;
        section.querySelectorAll('a').forEach(card => {
            const text = card.textContent.toLowerCase();
            if (text.includes(query)) {
                card.style.display = 'block';
                found = true;
            } else {
                card.style.display = 'none';
            }
        });
        section.style.display = found ? 'block' : 'none';
    });
});
</script>
@endsection
