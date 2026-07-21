@extends('layouts.public')

@section('title', ($article->title ?? 'Artikel') . ' - ASR GO')

@section('meta')
    <meta name="description" content="{{ strip_tags(mb_substr($article->content ?? '', 0, 160)) }}">
    @if($article->image_url)
        <meta property="og:image" content="{{ $article->image_url }}">
    @endif
    <meta property="og:title" content="{{ $article->title }} - ASR GO">
    <meta property="og:description" content="{{ strip_tags(mb_substr($article->content ?? '', 0, 160)) }}">
@endsection

@section('content')
<!-- HERO SECTION -->
<section class="trvl-hero relative" style="min-height: auto; padding: 2.5rem 0 2rem;">
    <div class="trvl-hero-orb trvl-hero-orb-1"></div>
    <div class="trvl-hero-orb trvl-hero-orb-2"></div>
    <div class="trvl-container relative z-10">
        <div class="max-w-4xl">
            <div class="trvl-hero-badge" style="margin-bottom:0.75rem;">
                <span class="pulse-dot"></span>
                {{ $article->type === 'blog' ? __('blog.type_blog') : __('blog.type_article') }}
            </div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-white leading-tight mb-3">
                {{ $article->title }}
            </h1>
            <div class="flex items-center gap-4 text-sm" style="color:rgba(191,219,254,0.8);">
                <span>
                    {{ $article->published_at ? $article->published_at->isoFormat('D MMMM YYYY') : $article->created_at->isoFormat('D MMMM YYYY') }}
                </span>
                <span class="w-1 h-1 rounded-full" style="background:rgba(255,255,255,0.4);"></span>
                <span>{{ __('blog.published') }}</span>
            </div>
        </div>
    </div>
</section>

<!-- CONTENT -->
<section class="trvl-section trvl-section-bg">
    <div class="trvl-container">
        <div class="max-w-4xl mx-auto">
            @if($article->image_url)
                <div class="rounded-2xl overflow-hidden mb-8 shadow-lg">
                    <img src="{{ $article->image_url }}" alt="{{ $article->title }}" class="w-full h-auto object-cover" style="max-height: 420px;">
                </div>
            @endif

            <article class="prose prose-lg max-w-none" style="color:var(--trvl-gray-800);">
                {!! $article->content ?? '' !!}
            </article>

            <div class="mt-10 pt-8 border-t" style="border-color:var(--trvl-border);">
                <a href="{{ route('public.blog') }}" class="inline-flex items-center gap-2 text-sm font-semibold px-5 py-2.5 rounded-xl transition-all" 
                   style="background:var(--trvl-blue); color:white; text-decoration:none;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    {{ __('blog.back_to_blog') }}
                </a>
            </div>
        </div>
    </div>
</section>

<style>
.dark .prose {
    color: var(--trvl-gray-200) !important;
}
.dark .prose h1,
.dark .prose h2,
.dark .prose h3,
.dark .prose h4,
.dark .prose strong {
    color: var(--trvl-gray-100) !important;
}
.dark .prose a {
    color: #60a5fa !important;
}
.dark .prose blockquote {
    color: var(--trvl-gray-300) !important;
    border-left-color: var(--trvl-blue) !important;
}
.prose img {
    border-radius: 12px;
    max-width: 100%;
    height: auto;
}
.prose p {
    line-height: 1.8;
    margin-bottom: 1.25rem;
}
</style>
@endsection
