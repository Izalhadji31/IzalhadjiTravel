@extends('layouts.public')

@section('title', $page->title ?? 'Halaman - ASR GO')

@section('content')
<div style="background: var(--trvl-bg); min-height: 80vh; padding: 3rem 0;">
    <div class="trvl-container">
        <div style="max-width: 800px; margin: 0 auto;">
            <h1 style="font-size: 2rem; font-weight: 800; color: var(--trvl-text); margin-bottom: 0.5rem;">
                {{ $page->title }}
            </h1>
            <div style="width: 60px; height: 3px; background: var(--trvl-blue); margin-bottom: 2rem; border-radius: 2px;"></div>

            <div style="background: var(--trvl-card); border: 1px solid var(--trvl-border); border-radius: var(--trvl-radius-lg); padding: 2rem; box-shadow: var(--trvl-shadow-sm);">
                <div style="color: var(--trvl-text); line-height: 1.75; font-size: 0.95rem;">
                    {!! $page->content !!}
                </div>
            </div>

            @if($page->updated_at)
            <p style="margin-top: 1.5rem; font-size: 0.8rem; color: var(--trvl-gray-500);">
                Terakhir diperbarui: {{ $page->updated_at->format('d F Y') }}
            </p>
            @endif
        </div>
    </div>
</div>
@endsection
