@extends('layouts.public')

@section('title', $destination['name'] . ' - ASR GO')

@section('meta')
<meta property="og:title" content="{{ $destination['name'] }} - ASR GO Travel">
<meta property="og:description" content="{{ $destination['short_desc'] }}">
<meta property="og:image" content="{{ $destination['gallery'][0] ?? $destination['image'] }}">
<meta property="og:type" content="website">
<meta name="description" content="{{ $destination['short_desc'] }}">
<meta name="keywords" content="{{ $destination['name'] }}, wisata {{ $destination['region'] }}, travel Flores, ASR GO">
@endsection

@section('content')
<!-- BREADCRUMB -->
<div class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
        <nav class="flex items-center gap-2 text-sm text-gray-500">
            <a href="/" class="hover:text-blue-600">Beranda</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="/public/destinasi" class="hover:text-blue-600">Destinasi</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-900 font-medium">{{ $destination['name'] }}</span>
        </nav>
    </div>
</div>

<!-- HERO -->
<div class="relative h-[50vh] min-h-[400px] max-h-[500px] overflow-hidden">
    <img src="{{ $destination['image'] }}" alt="{{ $destination['name'] }}" class="w-full h-full object-cover" id="hero-image">
    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
    <div class="absolute bottom-0 left-0 right-0 p-8 md:p-12">
        <div class="max-w-7xl mx-auto">
            <span class="bg-blue-600 text-white text-xs font-bold px-3 py-1.5 rounded-full mb-3 inline-block">📍 {{ $destination['region'] }}</span>
            <h1 class="text-3xl md:text-5xl font-extrabold text-white mb-3">{{ $destination['name'] }}</h1>
            <p class="text-white/80 text-lg max-w-2xl">{{ $destination['short_desc'] }}</p>
        </div>
    </div>
    <!-- Gallery trigger -->
    <button onclick="openLightbox()" class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm text-gray-800 px-4 py-2 rounded-lg text-sm font-medium hover:bg-white transition flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        Lihat Galeri ({{ count($destination['gallery'] ?? []) }})
    </button>
</div>

<!-- CONTENT -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Deskripsi -->
            <div class="bg-white rounded-2xl p-6 shadow-sm">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Tentang {{ $destination['name'] }}</h2>
                <div class="prose text-gray-600 leading-relaxed">
                    {!! $destination['full_desc'] !!}
                </div>
            </div>

            <!-- Info Praktis -->
            <div class="bg-white rounded-2xl p-6 shadow-sm">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Info Praktis</h3>
                <div class="grid sm:grid-cols-2 gap-4">
                    @foreach($destination['info'] ?? [] as $info)
                    <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-xl">
                        <span class="text-xl">{{ $info['icon'] }}</span>
                        <div>
                            <span class="text-xs text-gray-500 font-medium">{{ $info['label'] }}</span>
                            <p class="font-semibold text-gray-900">{{ $info['value'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Highlights -->
            <div class="bg-white rounded-2xl p-6 shadow-sm">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Yang Akan Anda Nikmati</h3>
                <div class="grid sm:grid-cols-2 gap-3">
                    @foreach($destination['highlights'] ?? [] as $h)
                    <div class="flex items-center gap-2 text-gray-700">
                        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>{{ $h }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Gallery Grid -->
            <div class="bg-white rounded-2xl p-6 shadow-sm">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Galeri Foto</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                    @foreach($destination['gallery'] ?? [] as $idx => $img)
                    <div onclick="openLightboxAt({{ $idx }})" class="aspect-square rounded-xl overflow-hidden cursor-pointer hover:opacity-90 transition group relative">
                        <img src="{{ $img }}" alt="{{ $destination['name'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                        @if($idx == 2 && count($destination['gallery'] ?? []) > 3)
                        <div class="absolute inset-0 bg-black/50 flex items-center justify-center text-white font-bold text-lg">+{{ count($destination['gallery'] ?? []) - 3 }} foto</div>
                        @endif
                    </div>
                    @if($idx >= 2) @break @endif
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Booking Card -->
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 sticky top-4">
                <div class="text-center mb-4">
                    <span class="text-sm text-gray-500">Mulai dari</span>
                    <p class="text-3xl font-extrabold text-blue-600">Rp {{ number_format($destination['price_start'] ?? 150000) }}</p>
                    <span class="text-xs text-gray-400">per orang / trip</span>
                </div>
                <a href="/public/travel?destination={{ urlencode($destination['region']) }}" class="block w-full py-3.5 bg-blue-600 text-white text-center rounded-xl font-bold hover:bg-blue-700 transition mb-3">
                    Pesan Travel ke Sini
                </a>
                <a href="https://wa.me/6281234567890?text=Halo ASR GO, saya ingin tanya tentang travel ke {{ urlencode($destination['name']) }}" 
                   class="block w-full py-3.5 bg-green-500 text-white text-center rounded-xl font-bold hover:bg-green-600 transition flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    Chat WhatsApp
                </a>
            </div>

            <!-- Destinasi Sekitar -->
            @if(!empty($nearby))
            <div class="bg-white rounded-2xl p-6 shadow-sm">
                <h4 class="font-bold text-gray-900 mb-4">Destinasi Terdekat</h4>
                <div class="space-y-3">
                    @foreach($nearby as $n)
                    <a href="/public/destinasi/{{ $n['slug'] }}" class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition">
                        <img src="{{ $n['image'] }}" alt="{{ $n['name'] }}" class="w-14 h-14 rounded-lg object-cover">
                        <div>
                            <p class="font-medium text-gray-900 text-sm">{{ $n['name'] }}</p>
                            <p class="text-xs text-gray-500">📍 {{ $n['region'] }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- LIGHTBOX MODAL -->
<div id="lightbox" class="fixed inset-0 z-50 bg-black/95 hidden items-center justify-center" onclick="closeLightbox(event)">
    <button onclick="closeLightbox(event, true)" class="absolute top-4 right-4 text-white/80 hover:text-white z-50">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
    </button>
    <button onclick="prevImage(event)" class="absolute left-4 top-1/2 -translate-y-1/2 text-white/80 hover:text-white bg-white/10 rounded-full p-2">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    </button>
    <button onclick="nextImage(event)" class="absolute right-4 top-1/2 -translate-y-1/2 text-white/80 hover:text-white bg-white/10 rounded-full p-2">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    </button>
    <img id="lightbox-img" src="" alt="" class="max-w-[90vw] max-h-[85vh] object-contain rounded-lg">
    <div id="lightbox-counter" class="absolute bottom-4 left-1/2 -translate-x-1/2 text-white/70 text-sm"></div>
</div>

<script>
const gallery = {{ json_encode($destination['gallery'] ?? []) }};
let currentImg = 0;

function openLightbox() { openLightboxAt(0); }
function openLightboxAt(idx) {
    currentImg = idx;
    document.getElementById('lightbox-img').src = gallery[currentImg];
    document.getElementById('lightbox-counter').textContent = (currentImg + 1) + ' / ' + gallery.length;
    document.getElementById('lightbox').classList.remove('hidden');
    document.getElementById('lightbox').classList.add('flex');
    document.body.style.overflow = 'hidden';
}
function closeLightbox(e, force) {
    if (force || e.target.id === 'lightbox') {
        document.getElementById('lightbox').classList.add('hidden');
        document.getElementById('lightbox').classList.remove('flex');
        document.body.style.overflow = '';
    }
}
function prevImage(e) { e.stopPropagation(); currentImg = (currentImg - 1 + gallery.length) % gallery.length; updateLightbox(); }
function nextImage(e) { e.stopPropagation(); currentImg = (currentImg + 1) % gallery.length; updateLightbox(); }
function updateLightbox() {
    document.getElementById('lightbox-img').src = gallery[currentImg];
    document.getElementById('lightbox-counter').textContent = (currentImg + 1) + ' / ' + gallery.length;
}
document.addEventListener('keydown', e => {
    if (document.getElementById('lightbox').classList.contains('hidden')) return;
    if (e.key === 'Escape') closeLightbox(e, true);
    if (e.key === 'ArrowLeft') prevImage(e);
    if (e.key === 'ArrowRight') nextImage(e);
});
</script>
@endsection
