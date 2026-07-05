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
            
            <!-- Search -->
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
            <button onclick="filterKota('all')" class="kota-btn active px-4 py-2 rounded-full text-sm font-medium bg-blue-600 text-white transition-all" data-kota="all">{{ __('destinasi.all') }}</button>
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
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center text-white font-bold text-lg">E</div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Kabupaten Ende</h2>
                    <p class="text-gray-500 text-sm">Ibu kota Kabupaten Ende — pusat sejarah dan danau tiga warna legendaris</p>
                </div>
            </div>

            <!-- Featured: Danau Kelimutu -->
            <div class="rounded-2xl overflow-hidden shadow-xl mb-6 bg-white">
                <div class="grid md:grid-cols-2">
                    <div class="relative h-64 md:h-auto">
                        <img src="https://images.unsplash.com/photo-1609137144813-7d9921338f24?w=800&q=80" alt="Danau Kelimutu" class="w-full h-full object-cover">
                        <div class="absolute top-4 left-4">
                            <span class="bg-orange-500 text-white text-xs font-bold px-3 py-1.5 rounded-full">{{ __('destinasi.most_popular') }}</span>
                        </div>
                    </div>
                    <div class="p-8 flex flex-col justify-center">
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Danau Kelimutu</h3>
                        <p class="text-gray-600 leading-relaxed mb-4">Tiga danau kawah di puncak Gunung Kelimutu (1.639 mdpl) yang warnanya berubah secara misterius. Tiwu Ata Mbupu (biru), Tiwu Nuwa Muri Koo Fai (hijau), dan Tiwu Ata Polo (merah) menyimpan mitos spiritual bagi suku Lio.</p>
                        <div class="grid grid-cols-2 gap-3 mb-4">
                            <div class="bg-blue-50 rounded-lg p-3">
                                <span class="text-xs text-blue-600 font-medium">Ketinggian</span>
                                <p class="font-bold text-gray-900">1.639 mdpl</p>
                            </div>
                            <div class="bg-green-50 rounded-lg p-3">
                                <span class="text-xs text-green-600 font-medium">Jarak dari Ende</span>
                                <p class="font-bold text-gray-900">51 km</p>
                            </div>
                            <div class="bg-amber-50 rounded-lg p-3">
                                <span class="text-xs text-amber-600 font-medium">Best Time</span>
                                <p class="font-bold text-gray-900">Sunrise (05:30)</p>
                            </div>
                            <div class="bg-purple-50 rounded-lg p-3">
                                <span class="text-xs text-purple-600 font-medium">Tiket Masuk</span>
                                <p class="font-bold text-gray-900">Rp 35.000</p>
                            </div>
                        </div>
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition text-sm">
                            Pesan Travel ke Ende
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Ende Lainnya -->
            <div class="grid md:grid-cols-3 gap-5">
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition group">
                    <div class="h-44 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1555400038-63f5ba517a47?w=500&q=80" alt="Rumah Bung Karno" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="p-4">
                        <h4 class="font-bold text-gray-900 mb-1">Rumah Bung Karno</h4>
                        <p class="text-gray-500 text-sm mb-2">Rumah tempat Ir. Soekarno diasingkan 1934-1938. Kini museum dengan koleksi foto dan barang bersejarah.</p>
                        <span class="text-xs text-blue-600 font-medium">🏛️ Sejarah & Museum</span>
                    </div>
                </div>
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition group">
                    <div class="h-44 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1432405972618-c6b0cfba8b03?w=500&q=80" alt="Air Terjun Ogi" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="p-4">
                        <h4 class="font-bold text-gray-900 mb-1">Air Terjun Ogi</h4>
                        <p class="text-gray-500 text-sm mb-2">Air terjun setinggi 30 meter di tengah hutan tropis. Air jernih dan suasana sejuk sepanjang tahun.</p>
                        <span class="text-xs text-blue-600 font-medium">💧 Alam & Waterfall</span>
                    </div>
                </div>
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition group">
                    <div class="h-44 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1552733407-5d5c46c3bb3b?w=500&q=80" alt="Pantai Ende" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="p-4">
                        <h4 class="font-bold text-gray-900 mb-1">Pantai Ende</h4>
                        <p class="text-gray-500 text-sm mb-2">Pantai pasir hitam dengan latar Gunung Kelimutu. Tempat sempurna menikmati sunset.</p>
                        <span class="text-xs text-blue-600 font-medium">🏖️ Pantai & Sunset</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- LABUAN BAJO SECTION -->
        <div class="kota-section mb-16" data-kota="labuan-bajo">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-teal-500 to-teal-700 flex items-center justify-center text-white font-bold text-lg">LB</div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Labuan Bajo</h2>
                    <p class="text-gray-500 text-sm">Gerbang Taman Nasional Komodo — salah satu destinasi super prioritas Indonesia</p>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-5 mb-6">
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition group">
                    <div class="h-52 overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1570789210967-2cac24afeb00?w=600&q=80" alt="Pulau Komodo" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        <div class="absolute top-3 right-3"><span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">UNESCO WHS</span></div>
                    </div>
                    <div class="p-5">
                        <h4 class="font-bold text-lg text-gray-900 mb-2">Pulau Komodo</h4>
                        <p class="text-gray-500 text-sm mb-3">Habitat asli komodo dengan 3.000+ ekor. Trekking bersama ranger untuk melihat kadal purba raksasa di alam liar.</p>
                        <div class="flex items-center gap-3 text-xs text-gray-500">
                            <span>🐉 3.000+ Komodo</span>
                            <span>📍 247 km dari Ende</span>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition group">
                    <div class="h-52 overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1559128010-7c1ad6e1b6a5?w=600&q=80" alt="Pulau Padar" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="p-5">
                        <h4 class="font-bold text-lg text-gray-900 mb-2">Pulau Padar</h4>
                        <p class="text-gray-500 text-sm mb-3">Bukit ikonik dengan tiga teluk berwarna. Hiking 30 menit ke puncak untuk panorama yang Instagram-worthy.</p>
                        <div class="flex items-center gap-3 text-xs text-gray-500">
                            <span>📸 Spot Foto Terbaik</span>
                            <span>📍 247 km dari Ende</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid md:grid-cols-3 gap-5">
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition group">
                    <div class="h-40 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1552733407-5d5c46c3bb3b?w=500&q=80" alt="Pink Beach" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="p-4">
                        <h4 class="font-bold text-gray-900 text-sm mb-1">Pink Beach</h4>
                        <p class="text-gray-500 text-xs">Pantai pasir merah muda — salah satu dari 7 di dunia</p>
                    </div>
                </div>
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition group">
                    <div class="h-40 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=500&q=80" alt="Manta Point" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="p-4">
                        <h4 class="font-bold text-gray-900 text-sm mb-1">Manta Point</h4>
                        <p class="text-gray-500 text-xs">Berenang bersama pari manta raksasa</p>
                    </div>
                </div>
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition group">
                    <div class="h-40 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1546026423-cc4642628d2b?w=500&q=80" alt="Kanawa Island" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="p-4">
                        <h4 class="font-bold text-gray-900 text-sm mb-1">Pulau Kanawa</h4>
                        <p class="text-gray-500 text-xs">Pulau eksotis dengan air biru toska jernih</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- RUTENG SECTION -->
        <div class="kota-section mb-16" data-kota="ruteng">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-green-500 to-green-700 flex items-center justify-center text-white font-bold text-lg">R</div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Ruteng & Manggarai</h2>
                    <p class="text-gray-500 text-sm">Desa tradisional di atas awan dan sawah berbentuk jaring laba-laba</p>
                </div>
            </div>

            <div class="rounded-2xl overflow-hidden shadow-xl mb-6 bg-white">
                <div class="grid md:grid-cols-2">
                    <div class="relative h-64 md:h-auto order-2 md:order-1">
                        <img src="https://images.unsplash.com/photo-1528181304800-259b08848526?w=800&q=80" alt="Wae Rebo" class="w-full h-full object-cover">
                    </div>
                    <div class="p-8 flex flex-col justify-center order-1 md:order-2">
                        <span class="text-xs font-bold text-amber-600 mb-2">🏆 UNESCO Asia-Pacific Heritage Award 2012</span>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Desa Wae Rebo</h3>
                        <p class="text-gray-600 leading-relaxed mb-4">Desa terpencil di ketinggian 1.200 mdpl dengan 7 rumah kerucut tradisional (Mbaru Niang). Untuk sampai ke sini, Anda harus trekking 4-5 menit melalui hutan tropis dan lembah.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500">
                            <span>🏔️ 1.200 mdpl</span>
                            <span>🚶 4.5 km trekking</span>
                            <span>📍 198 km dari Ende</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-5">
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition group">
                    <div class="h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=600&q=80" alt="Sawah Lingko" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="p-5">
                        <h4 class="font-bold text-lg text-gray-900 mb-2">Sawah Lingko</h4>
                        <p class="text-gray-500 text-sm">Sawah berbentuk jaring laba-laba — sistem pembagian tanah adat Manggarai yang unik. Terbaik dilihat dari Bukit Teletubbies.</p>
                    </div>
                </div>
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition group">
                    <div class="h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1432405972618-c6b0cfba8b03?w=600&q=80" alt="Goa Batu Cermin" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="p-5">
                        <h4 class="font-bold text-lg text-gray-900 mb-2">Goa Batu Cermin</h4>
                        <p class="text-gray-500 text-sm">Goa kristal dengan dinding batu yang memantulkan cahaya matahari. Fenomena geologi langka di Manggarai.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- BAJAWA SECTION -->
        <div class="kota-section mb-16" data-kota="bajawa">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-500 to-amber-700 flex items-center justify-center text-white font-bold text-lg">B</div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Bajawa & Ngada</h2>
                    <p class="text-gray-500 text-sm">Desa megalitikum kuno dan sumber air panas alami</p>
                </div>
            </div>

            <div class="grid md:grid-cols-3 gap-5">
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition group md:col-span-2">
                    <div class="h-56 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?w=800&q=80" alt="Kampung Bena" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="p-5">
                        <h4 class="font-bold text-lg text-gray-900 mb-2">Kampung Bena</h4>
                        <p class="text-gray-500 text-sm mb-2">Desa adat Ngada dengan 9 rumah tradisional dan kompleks megalit. Terletak di lereng Gunung Inerie, menawarkan panorama spektakuler.</p>
                        <span class="text-xs text-blue-600 font-medium">⛰️ 85 km dari Ende</span>
                    </div>
                </div>
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition group">
                    <div class="h-40 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=500&q=80" alt="Air Panas Soa" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="p-4">
                        <h4 class="font-bold text-gray-900 text-sm mb-1">Air Panas Soa</h4>
                        <p class="text-gray-500 text-xs">Sumber air panas alami di dekat Bajawa</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- MAUMERE SECTION -->
        <div class="kota-section mb-16" data-kota="maumere">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-cyan-500 to-cyan-700 flex items-center justify-center text-white font-bold text-lg">M</div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Maumere & Sikka</h2>
                    <p class="text-gray-500 text-sm">Surga diving dengan terumbu karang terbaik dunia</p>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-5">
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition group">
                    <div class="h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=600&q=80" alt="Teluk Maumere" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="p-5">
                        <h4 class="font-bold text-lg text-gray-900 mb-2">Teluk Maumere</h4>
                        <p class="text-gray-500 text-sm">Disebut sebagai salah satu lokasi diving terbaik dunia oleh Conservation International. 30+ spot diving dengan biodiversitas laut tertinggi.</p>
                    </div>
                </div>
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition group">
                    <div class="h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1546026423-cc4642628d2b?w=600&q=80" alt="Pulau Babi" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="p-5">
                        <h4 class="font-bold text-lg text-gray-900 mb-2">Pulau Babi</h4>
                        <p class="text-gray-500 text-sm">Snorkeling di sekitar Pulau Babi dengan air jernih dan ikan warna-warni. Populer untuk liveaboard trip.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIUNG SECTION -->
        <div class="kota-section mb-16" data-kota="riung">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-700 flex items-center justify-center text-white font-bold text-lg">Ri</div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Riung & Nagekeo</h2>
                    <p class="text-gray-500 text-sm">17 pulau surga dengan kelelawar raksasa</p>
                </div>
            </div>

            <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition group">
                <div class="h-56 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1546026423-cc4642628d2b?w=1200&q=80" alt="Taman Laut 17 Pulau" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                </div>
                <div class="p-6">
                    <h4 class="font-bold text-xl text-gray-900 mb-2">Taman Laut 17 Pulau</h4>
                    <p class="text-gray-500 text-sm mb-3">Kepulauan dengan 17 pulau kecil yang tersebar di Teluk Riung. Snorkeling, berenamg dengan kelelawar raksasa (kalong) di Pulau Ontoloe, dan melihat komodo kerdil.</p>
                    <div class="flex items-center gap-4 text-xs text-gray-500">
                        <span>🏝️ 17 Pulau</span>
                        <span>🦇 Kelelawar Raksasa</span>
                        <span>📍 125 km dari Ende</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- LARANTUKA SECTION -->
        <div class="kota-section mb-16" data-kota="larantuka">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-rose-500 to-rose-700 flex items-center justify-center text-white font-bold text-lg">L</div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Larantuka & Lembata</h2>
                    <p class="text-gray-500 text-sm">Kota dengan tradisi Semana Santa yang mendunia</p>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-5">
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition group">
                    <div class="h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1555400038-63f5ba517a47?w=600&q=80" alt="Kota Larantuka" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="p-5">
                        <h4 class="font-bold text-lg text-gray-900 mb-2">Kota Larantuka</h4>
                        <p class="text-gray-500 text-sm">Ibu kota Kabupaten Flores Timur. Tradisi Semana Santa (Minggu Suci) menarik wisatawan dari seluruh dunia setiap tahun.</p>
                    </div>
                </div>
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition group">
                    <div class="h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1552733407-5d5c46c3bb3b?w=600&q=80" alt="Gunung Ile Ape" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="p-5">
                        <h4 class="font-bold text-lg text-gray-900 mb-2">Gunung Ile Ape</h4>
                        <p class="text-gray-500 text-sm">Gunung berapi aktif di dekat Larantuka. Pendakian menawarkan pemandangan danau kawah dan laut Flores.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA BOTTOM -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-2xl p-8 md:p-12 text-center">
            <h3 class="text-2xl md:text-3xl font-bold text-white mb-3">{{ __('home.cta_title') }}</h3>
            <p class="text-blue-100 mb-6 max-w-xl mx-auto">{{ __('home.cta_desc') }}</p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('login') }}" class="px-8 py-3.5 bg-white text-blue-700 rounded-xl font-bold hover:bg-blue-50 transition shadow-lg">
                    {{ __('home.cta_book') }}
                </a>
                <a href="{{ route('public.travel') }}" class="px-8 py-3.5 bg-blue-500/30 text-white border border-blue-300/30 rounded-xl font-bold hover:bg-blue-500/50 transition">
                    Lihat Jadwal Travel
                </a>
            </div>
        </div>

    </div>
</div>

<script>
function filterKota(kota) {
    // Update button styles
    document.querySelectorAll('.kota-btn').forEach(btn => {
        if (btn.dataset.kota === kota) {
            btn.classList.remove('bg-gray-100', 'text-gray-600');
            btn.classList.add('bg-blue-600', 'text-white');
        } else {
            btn.classList.add('bg-gray-100', 'text-gray-600');
            btn.classList.remove('bg-blue-600', 'text-white');
        }
    });

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
document.getElementById('searchDest').addEventListener('input', function(e) {
    const query = e.target.value.toLowerCase();
    document.querySelectorAll('.kota-section').forEach(section => {
        const text = section.textContent.toLowerCase();
        section.style.display = text.includes(query) ? 'block' : 'none';
    });
});
</script>
@endsection
