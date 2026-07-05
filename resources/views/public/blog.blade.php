@extends('layouts.public')

@section('title', __('blog.title') . ' - ASR GO')

@section('content')
<!-- HERO SECTION -->
<section class="trvl-hero relative" style="min-height: auto; padding: 2.5rem 0 2rem;">
    <div class="trvl-hero-orb trvl-hero-orb-1"></div>
    <div class="trvl-hero-orb trvl-hero-orb-2"></div>
    <div class="trvl-container relative z-10">
        <div class="text-center">
            <div class="trvl-hero-badge">
                <span class="pulse-dot"></span>
                {{ __('blog.badge') }}
            </div>
            <h1 class="trvl-hero-title">
                {{ __('blog.title') }}
            </h1>
            <p class="trvl-hero-subtitle mx-auto">
                {{ __('blog.subtitle') }}
            </p>
        </div>
    </div>
</section>

<!-- BLOG LISTING -->
<section class="trvl-section trvl-section-bg">
    <div class="trvl-container">
        <!-- Category Filter -->
        @php
            $currentCategory = request('category');
            $categories = \App\Models\CmsPage::where('is_published', true)
                ->whereIn('type', ['blog', 'page'])
                ->select('type')
                ->distinct()
                ->pluck('type');
        @endphp
        <div class="flex flex-wrap items-center gap-3 mb-10 trvl-reveal">
            <span class="text-sm font-semibold" style="color:var(--trvl-gray-600);">{{ __('blog.category_label') }}</span>
            <a href="{{ route('public.blog') }}" 
               class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ !$currentCategory ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600' }}">
                {{ __('blog.category_all') }}
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('public.blog', ['category' => $cat]) }}" 
                   class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ $currentCategory === $cat ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600' }}">
                    {{ $cat === 'blog' ? __('blog.category_blog') : __('blog.category_page') }}
                </a>
            @endforeach
        </div>

        @php
            $query = \App\Models\CmsPage::where('is_published', true)
                ->whereIn('type', ['blog', 'page'])
                ->orderBy('created_at', 'desc');
            if ($currentCategory) {
                $query->where('type', $currentCategory);
            }
            $articles = $query->paginate(12);
        @endphp

        @if($articles->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($articles as $article)
                    @php
                        $previewText = strip_tags($article->content ?? '');
                        $previewText = mb_substr($previewText, 0, 200);
                        if (mb_strlen(strip_tags($article->content ?? '')) > 200) {
                            $previewText .= '...';
                        }
                        $publishDate = $article->published_at ?? $article->created_at;
                    @endphp
                    <a href="{{ route('public.blog.detail', $article->slug) }}" class="trvl-route-card group text-decoration-none" style="cursor:pointer;">
                        <div class="trvl-route-card-img" style="background:linear-gradient(135deg, var(--trvl-navy) 0%, var(--trvl-blue) 50%, #60a5fa 100%); height:12rem; display:flex; align-items:center; justify-content:center;">
                            @if($article->image_url)
                                <img src="{{ $article->image_url }}" alt="{{ $article->title }}" class="w-full h-full object-cover" loading="lazy">
                            @else
                                <svg class="w-16 h-16 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                </svg>
                            @endif
                        </div>
                        <div class="trvl-route-card-body">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-xs font-medium px-2.5 py-1 rounded-full" 
                                      style="background:var(--trvl-blue-light); color:var(--trvl-blue);">
                                    {{ $article->type === 'blog' ? __('blog.category_blog') : __('blog.category_article') }}
                                </span>
                                <span class="text-xs" style="color:var(--trvl-gray-500);">
                                    {{ $publishDate instanceof \Carbon\Carbon ? $publishDate->isoFormat('D MMM YYYY') : date('d M Y', strtotime($publishDate)) }}
                                </span>
                            </div>
                            <h3 class="font-bold text-base mb-2" style="color:var(--trvl-gray-900); line-height:1.4;">
                                {{ $article->title }}
                            </h3>
                            <p class="text-sm leading-relaxed" style="color:var(--trvl-gray-600);">
                                {{ $previewText }}
                            </p>
                            <div class="mt-auto pt-3">
                                <span class="inline-flex items-center gap-1 text-sm font-semibold" style="color:var(--trvl-blue);">
                                    {{ __('blog.read_more') }}
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-10">
                {{ $articles->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-16 trvl-reveal">
                <svg class="w-20 h-20 mx-auto mb-6" style="color:var(--trvl-gray-400);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                </svg>
                <h3 class="text-xl font-bold mb-2" style="color:var(--trvl-gray-700);">{{ __('blog.empty') }}</h3>
                <p style="color:var(--trvl-gray-500);">{{ __('blog.empty_desc') }}</p>
            </div>
        @endif
    </div>
</section>

<style>
.dark .trvl-route-card-body h3,
.dark .trvl-route-card-body .font-bold {
    color: var(--trvl-gray-100) !important;
}
.dark .trvl-route-card-body p {
    color: var(--trvl-gray-400) !important;
}
.dark .bg-gray-100 {
    background-color: var(--trvl-gray-200) !important;
}
.dark .text-gray-600 {
    color: var(--trvl-gray-400) !important;
}
</style>
@endsection
