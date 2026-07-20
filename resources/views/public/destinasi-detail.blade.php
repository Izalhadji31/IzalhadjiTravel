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
            <a href="/" class="hover:text-blue-600">{{ __('destinasi_detail.breadcrumb_home') }}</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="/public/destinasi" class="hover:text-blue-600">{{ __('destinasi_detail.breadcrumb_destinations') }}</a>
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
            <span class="bg-blue-600 text-white text-xs font-bold px-3 py-1.5 rounded-full mb-3 inline-block">
                <svg class="w-3.5 h-3.5 inline mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                {{ $destination['region'] }}
            </span>
            <h1 class="text-3xl md:text-5xl font-extrabold text-white mb-3">{{ $destination['name'] }}</h1>
            <p class="text-white/80 text-lg max-w-2xl">{{ $destination['short_desc'] }}</p>
        </div>
    </div>
    <!-- Gallery trigger -->
    <button onclick="openLightbox()" class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm text-gray-800 px-4 py-2 rounded-lg text-sm font-medium hover:bg-white transition flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        {{ __('destinasi_detail.view_gallery') }} ({{ count($destination['gallery'] ?? []) }})
    </button>
</div>

<!-- CONTENT -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Deskripsi -->
            <div class="bg-white rounded-2xl p-6 shadow-sm">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ __('destinasi_detail.about_title') }} {{ $destination['name'] }}</h2>
                <div class="prose text-gray-600 leading-relaxed">
                    {!! $destination['full_desc'] !!}
                </div>
            </div>

            <!-- Info Praktis -->
            <div class="bg-white rounded-2xl p-6 shadow-sm">
                <h3 class="text-xl font-bold text-gray-900 mb-4">{{ __('destinasi_detail.practical_info') }}</h3>
                <div class="grid sm:grid-cols-2 gap-4">
                    @foreach($destination['info'] ?? [] as $info)
                    @php
                        $iconSvg = '';
                        $label = $info['label'] ?? '';
                        if (strpos($label, 'Lokasi') !== false) $iconSvg = '<svg class=\"w-5 h-5 text-blue-600\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z\"/><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M15 11a3 3 0 11-6 0 3 3 0 016 0z\"/></svg>';
                        elseif (strpos($label, 'Jarak') !== false) $iconSvg = '<svg class=\"w-5 h-5 text-green-600\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4\"/></svg>';
                        elseif (strpos($label, 'Best Time') !== false || strpos($label, 'Jam') !== false) $iconSvg = '<svg class=\"w-5 h-5 text-amber-600\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z\"/></svg>';
                        elseif (strpos($label, 'Tiket') !== false || strpos($label, 'Retribusi') !== false) $iconSvg = '<svg class=\"w-5 h-5 text-purple-600\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z\"/></svg>';
                        elseif (strpos($label, 'Durasi') !== false) $iconSvg = '<svg class=\"w-5 h-5 text-indigo-600\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z\"/></svg>';
                        elseif (strpos($label, 'Ketinggian') !== false) $iconSvg = '<svg class=\"w-5 h-5 text-cyan-600\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z\"/></svg>';
                        elseif (strpos($label, 'Populasi') !== false) $iconSvg = '<svg class=\"w-5 h-5 text-emerald-600\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z\"/></svg>';
                        elseif (strpos($label, 'Status') !== false) $iconSvg = '<svg class=\"w-5 h-5 text-amber-600\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z\"/></svg>';
                        elseif (strpos($label, 'Warna') !== false) $iconSvg = '<svg class=\"w-5 h-5 text-pink-600\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01\"/></svg>';
                        elseif (strpos($label, 'Snorkeling') !== false) $iconSvg = '<svg class=\"w-5 h-5 text-blue-600\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M15.536 7.464A5 5 0 0117.95 11H12l-6.364 6.364A9 9 0 1115.536 7.464z\"/><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M12 8v4l3 3\"/></svg>';
                        elseif (strpos($label, 'Diving') !== false) $iconSvg = '<svg class=\"w-5 h-5 text-cyan-600\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z\"/><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M12 6v6l4 2\"/></svg>';
                        elseif (strpos($label, 'Biodiversitas') !== false) $iconSvg = '<svg class=\"w-5 h-5 text-green-600\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z\"/></svg>';
                        elseif (strpos($label, 'Trekking') !== false) $iconSvg = '<svg class=\"w-5 h-5 text-orange-600\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M13 7l5 5m0 0l-5 5m5-5H6\"/></svg>';
                        elseif (strpos($label, 'Kategori') !== false) $iconSvg = '<svg class=\"w-5 h-5 text-gray-600\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4\"/></svg>';
                        elseif (strpos($label, 'Cocok') !== false) $iconSvg = '<svg class=\"w-5 h-5 text-emerald-600\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z\"/></svg>';
                        else $iconSvg = '<svg class=\"w-5 h-5 text-blue-600\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z\"/></svg>';
                    @endphp
                    <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-xl">
                        <span class="flex-shrink-0 w-8 h-8 flex items-center justify-center">{!! $iconSvg !!}</span>
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
                <h3 class="text-xl font-bold text-gray-900 mb-4">{{ __('destinasi_detail.highlights') }}</h3>
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
                <h3 class="text-xl font-bold text-gray-900 mb-4">{{ __('destinasi_detail.gallery') }}</h3>
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
                    <span class="text-sm text-gray-500">{{ __('destinasi_detail.starting_from') }}</span>
                    <p class="text-3xl font-extrabold text-blue-600">Rp {{ number_format($destination['price_start'] ?? 150000) }}</p>
                    <span class="text-xs text-gray-400">{{ __('destinasi_detail.per_person_trip') }}</span>
                </div>
                <a href="{{ route('public.travel') }}" class="block w-full py-3.5 bg-blue-600 text-white text-center rounded-xl font-bold hover:bg-blue-700 transition mb-3">
                    {{ __('destinasi_detail.book_travel') }}
                </a>
                    <a href="tel:+6283156408078" class="block w-full py-3.5 bg-blue-600 text-white text-center rounded-xl font-bold hover:bg-blue-700 transition flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        Hubungi Call Center
                    </a>
            </div>

            <!-- Destinasi Sekitar -->
            @if(!empty($nearby))
            <div class="bg-white rounded-2xl p-6 shadow-sm">
                <h4 class="font-bold text-gray-900 mb-4">{{ __('destinasi_detail.nearby') }}</h4>
                <div class="space-y-3">
                    @foreach($nearby as $n)
                    <a href="/public/destinasi/{{ $n['slug'] }}" class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition">
                        <img src="{{ $n['image'] }}" alt="{{ $n['name'] }}" class="w-14 h-14 rounded-lg object-cover">
                        <div>
                            <p class="font-medium text-gray-900 text-sm">{{ $n['name'] }}</p>
                            <p class="text-xs text-gray-500">
                                <svg class="w-3 h-3 inline mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                {{ $n['region'] }}
                            </p>
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
