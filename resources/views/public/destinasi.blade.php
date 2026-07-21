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
            <p class="text-blue-100 text-lg max-w-2xl mx-auto">{{ __('destinasi.subtitle') }}</p>
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
            <button onclick="filterKota('larantuka')" class="kota-btn px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-600 hover:bg-blue-50 hover:text-blue-600 transition-all" data-kota="larantuka">Larantuka</button>
            <button onclick="filterKota('maumere')" class="kota-btn px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-600 hover:bg-blue-50 hover:text-blue-600 transition-all" data-kota="maumere">Maumere</button>
            <button onclick="filterKota('mbay')" class="kota-btn px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-600 hover:bg-blue-50 hover:text-blue-600 transition-all" data-kota="mbay">Mbay</button>
            <button onclick="filterKota('bajawa')" class="kota-btn px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-600 hover:bg-blue-50 hover:text-blue-600 transition-all" data-kota="bajawa">Bajawa</button>
            <button onclick="filterKota('borong')" class="kota-btn px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-600 hover:bg-blue-50 hover:text-blue-600 transition-all" data-kota="borong">Borong</button>
            <button onclick="filterKota('ruteng')" class="kota-btn px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-600 hover:bg-blue-50 hover:text-blue-600 transition-all" data-kota="ruteng">Ruteng</button>
            <button onclick="filterKota('labuan-bajo')" class="kota-btn px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-600 hover:bg-blue-50 hover:text-blue-600 transition-all" data-kota="labuan-bajo">Labuan Bajo</button>
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
                    <h2 class="text-2xl font-bold text-gray-900">Ende</h2>
                    <p class="text-gray-500">Gerbang menuju Danau Kelimutu yang legendaris.</p>
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
                <a href="{{ route('public.destinasi.detail', 'pantai-ena-bara') }}" class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition group">
                    <div class="h-44 overflow-hidden"><img src="{{ asset('images/destinations/pantai-ena-bara.jpg') }}" alt="Pantai Ena Bara" class="w-full h-full object-cover group-hover:scale-105 transition-transform"></div>
                    <div class="p-4"><h4 class="font-bold text-gray-900">Pantai Ena Bara</h4><p class="text-gray-500 text-sm">Pantai pasir putih & sunset indah</p></div>
                </a>
            </div>
        </div>

        <!-- LARANTUKA SECTION -->
        <div class="kota-section mb-16" data-kota="larantuka">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-rose-500 to-rose-700 flex items-center justify-center text-white font-bold">L</div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Larantuka</h2>
                    <p class="text-gray-500">Kota yang dikenal dengan tradisi Semana Santa yang mendunia.</p>
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
            </div>
        </div>

        <!-- MAUMERE SECTION -->
        <div class="kota-section mb-16" data-kota="maumere">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-cyan-500 to-cyan-700 flex items-center justify-center text-white font-bold">Ma</div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Maumere</h2>
                    <p class="text-gray-500">Surga penyelaman, pantai eksotis, dan pesona laut yang memikat.</p>
                </div>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
                <a href="{{ route('public.destinasi.detail', 'teluk-maumere') }}" class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition group">
                    <div class="h-44 overflow-hidden"><img src="{{ asset('images/destinations/teluk-maumere.jpg') }}" alt="Teluk Maumere" class="w-full h-full object-cover group-hover:scale-105 transition-transform"></div>
                    <div class="p-4"><h4 class="font-bold text-gray-900">Teluk Maumere</h4><p class="text-gray-500 text-sm">Lokasi diving terbaik dunia dengan 30+ spot yang menawan</p></div>
                </a>
                <a href="{{ route('public.destinasi.detail', 'pantai-koka') }}" class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition group">
                    <div class="h-44 overflow-hidden"><img src="{{ asset('images/destinations/pantai-koka.jpg') }}" alt="Pantai Koka" class="w-full h-full object-cover group-hover:scale-105 transition-transform"></div>
                    <div class="p-4"><h4 class="font-bold text-gray-900">Pantai Koka</h4><p class="text-gray-500 text-sm">Pantai pasir hitam vulkanik dengan suasana tenang dan eksotis</p></div>
                </a>
                <a href="{{ route('public.destinasi.detail', 'museum-maumere') }}" class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition group">
                    <div class="h-44 overflow-hidden"><img src="{{ asset('images/destinations/museum-bikon-blewut.jpg') }}" alt="Museum Bikon" class="w-full h-full object-cover group-hover:scale-105 transition-transform"></div>
                    <div class="p-4"><h4 class="font-bold text-gray-900">Museum Bikon</h4><p class="text-gray-500 text-sm">Pusat wawasan sejarah dan budaya lokal yang menarik untuk dikunjungi</p></div>
                </a>
            </div>
        </div>

        <!-- MBAY (Nagekeo) SECTION -->
        <div class="kota-section mb-16" data-kota="mbay">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-700 flex items-center justify-center text-white font-bold">Ri</div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Mbay</h2>
                    <p class="text-gray-500">Wilayah pesisir dan alam yang kaya, mulai dari pantai, pulau kecil, hingga situs sejarah yang menarik.</p>
                </div>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
                <a href="{{ route('public.destinasi.detail', 'bunker-jepang-rane') }}" class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition group">
                    <div class="h-44 overflow-hidden"><img src="{{ asset('images/destinations/bunker-jepang-rane.jpg') }}" alt="Bunker Jepang Rane" class="w-full h-full object-cover group-hover:scale-105 transition-transform"></div>
                    <div class="p-4"><h4 class="font-bold text-gray-900">Bunker Jepang Rane</h4><p class="text-gray-500 text-sm">Sisa peninggalan sejarah perang yang menyimpan kisah masa lalu.</p></div>
                </a>
                <a href="{{ route('public.destinasi.detail', 'gunung-ebulobo') }}" class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition group">
                    <div class="h-44 overflow-hidden"><img src="{{ asset('images/destinations/gunung-ebulobo.jpeg') }}" alt="Gunung Ebulobo" class="w-full h-full object-cover group-hover:scale-105 transition-transform"></div>
                    <div class="p-4"><h4 class="font-bold text-gray-900">Gunung Ebulobo</h4><p class="text-gray-500 text-sm">Gunung yang menawarkan panorama alam luas dan pemandangan hijau yang memikat.</p></div>
                </a>
                <a href="{{ route('public.destinasi.detail', 'kampung-adat-kawa') }}" class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition group">
                    <div class="h-44 overflow-hidden"><img src="{{ asset('images/destinations/kampung-adat-kawa.jpg') }}" alt="Kampung Adat Kawa" class="w-full h-full object-cover group-hover:scale-105 transition-transform"></div>
                    <div class="p-4"><h4 class="font-bold text-gray-900">Kampung Adat Kawa</h4><p class="text-gray-500 text-sm">Kampung adat yang menyimpan budaya lokal dan suasana tradisional yang khas.</p></div>
                </a>
            </div>
        </div>

        <!-- BAJAWA SECTION -->
        <div class="kota-section mb-16" data-kota="bajawa">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-500 to-amber-700 flex items-center justify-center text-white font-bold">B</div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Bajawa</h2>
                    <p class="text-gray-500">Desa megalit kuno, pegunungan hijau, dan budaya Ngada yang khas.</p>
                </div>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
                <a href="{{ route('public.destinasi.detail', 'kampung-bena') }}" class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition group">
                    <div class="h-44 overflow-hidden"><img src="{{ asset('images/destinations/kampung-bena.jpg') }}" alt="Kampung Bena" class="w-full h-full object-cover group-hover:scale-105 transition-transform"></div>
                    <div class="p-4"><h4 class="font-bold text-gray-900">Kampung Bena</h4><p class="text-gray-500 text-sm">Desa adat dengan rumah megalit dan budaya Ngada yang khas</p></div>
                </a>
                <a href="{{ route('public.destinasi.detail', 'gunung-inerie') }}" class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition group">
                    <div class="h-44 overflow-hidden"><img src="{{ asset('images/destinations/gunung-inerie.jpg') }}" alt="Gunung Inerie" class="w-full h-full object-cover group-hover:scale-105 transition-transform"></div>
                    <div class="p-4"><h4 class="font-bold text-gray-900">Gunung Inerie</h4><p class="text-gray-500 text-sm">Gunung berapi aktif yang ideal untuk pendakian dan panorama sunrise</p></div>
                </a>
                <a href="{{ route('public.destinasi.detail', 'taman-laut-17-pulau') }}" class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition group">
                    <div class="h-44 overflow-hidden"><img src="{{ asset('images/destinations/taman-laut-17-pulau.png') }}" alt="Taman Laut 17 Pulau" class="w-full h-full object-cover group-hover:scale-105 transition-transform"></div>
                    <div class="p-4"><h4 class="font-bold text-gray-900">Taman Laut 17 Pulau</h4><p class="text-gray-500 text-sm">17 pulau kecil dengan pantai eksotis, snorkeling, dan pemandangan laut yang memesona</p></div>
                </a>
            </div>
        </div>

        <!-- BORONG (Manggarai Timur) SECTION -->
        <div class="kota-section mb-16" data-kota="borong">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-yellow-500 to-yellow-700 flex items-center justify-center text-white font-bold">BR</div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Borong</h2>
                    <p class="text-gray-500">Wilayah dengan panorama alam yang masih alami dan cocok untuk wisata alam dan petualangan.</p>
                </div>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
                <a href="{{ route('public.destinasi.detail', 'air-terjun-cunca-rede') }}" class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition group">
                    <div class="h-44 overflow-hidden"><img src="{{ asset('images/destinations/air-terjun-cunca-rede.jpg') }}" alt="Air Terjun Cunca Rede" class="w-full h-full object-cover group-hover:scale-105 transition-transform"></div>
                    <div class="p-4"><h4 class="font-bold text-gray-900">Air Terjun Cunca Rede</h4><p class="text-gray-500 text-sm">Air terjun dengan panorama hutan yang hijau dan suasana sejuk.</p></div>
                </a>
                <a href="{{ route('public.destinasi.detail', 'danau-rana-mese') }}" class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition group">
                    <div class="h-44 overflow-hidden"><img src="{{ asset('images/destinations/danau-rana-mese.jpg') }}" alt="Danau Rana Mese" class="w-full h-full object-cover group-hover:scale-105 transition-transform"></div>
                    <div class="p-4"><h4 class="font-bold text-gray-900">Danau Rana Mese</h4><p class="text-gray-500 text-sm">Danau pegunungan yang menyuguhkan pemandangan tenang dan eksotis.</p></div>
                </a>
                <a href="{{ route('public.destinasi.detail', 'savana-mausui') }}" class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition group">
                    <div class="h-44 overflow-hidden"><img src="{{ asset('images/destinations/savana-mausui.jpg') }}" alt="Savana Mausui" class="w-full h-full object-cover group-hover:scale-105 transition-transform"></div>
                    <div class="p-4"><h4 class="font-bold text-gray-900">Savana Mausui</h4><p class="text-gray-500 text-sm">Padang savana luas dengan panorama alam yang memukau.</p></div>
                </a>
            </div>
        </div>

        <!-- RUTENG SECTION -->
        <div class="kota-section mb-16" data-kota="ruteng">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-green-500 to-green-700 flex items-center justify-center text-white font-bold">R</div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Ruteng</h2>
                    <p class="text-gray-500">Desa di atas awan dan sawah terasering yang unik.</p>
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
            </div>
        </div>

        <!-- LABUAN BAJO SECTION -->
        <div class="kota-section mb-16" data-kota="labuan-bajo">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-teal-500 to-teal-700 flex items-center justify-center text-white font-bold">LB</div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Labuan Bajo</h2>
                    <p class="text-gray-500">Gerbang menuju Taman Nasional Komodo yang menjadi warisan dunia UNESCO.</p>
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
