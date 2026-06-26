@php
    $toastType = $type ?? 'info';
    $toastMessage = $message ?? '';
    $toastId = 'toast-' . uniqid();

    $bgColors = [
        'success' => '#10b981',
        'error' => '#ef4444',
        'warning' => '#f59e0b',
        'info' => '#3b82f6',
    ];

    $icons = [
        'success' => '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>',
        'error' => '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>',
        'warning' => '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>',
        'info' => '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
    ];

    $bgColor = $bgColors[$toastType] ?? $bgColors['info'];
    $icon = $icons[$toastType] ?? $icons['info'];
@endphp

<div id="{{ $toastId }}" style="position: fixed; top: 1.5rem; right: 1.5rem; z-index: 9999; max-width: 380px; min-width: 280px; padding: 1rem 1.25rem; border-radius: 0.75rem; background: var(--trvl-card, #ffffff); border: 1px solid var(--trvl-border, #e5e7eb); box-shadow: 0 10px 40px rgba(0,0,0,0.15); display: flex; align-items: flex-start; gap: 0.75rem; animation: trvlToastSlideIn 0.4s cubic-bezier(0.16, 1, 0.3, 1); transform: translateX(120%); overflow: hidden;" role="alert" aria-live="assertive">
    <div style="flex-shrink: 0; width: 2.5rem; height: 2.5rem; border-radius: 50%; background: {{ $bgColor }}15; color: {{ $bgColor }}; display: flex; align-items: center; justify-content: center;">
        {!! $icon !!}
    </div>
    <div style="flex: 1; min-width: 0;">
        <div style="font-weight: 600; font-size: 0.9rem; color: var(--trvl-text, #1a1a1a); margin-bottom: 0.15rem; text-transform: capitalize;">{{ $toastType }}</div>
        <div style="font-size: 0.85rem; color: var(--trvl-gray-600, #6c757d); line-height: 1.4;">{{ $toastMessage }}</div>
    </div>
    <button onclick="document.getElementById('{{ $toastId }}').remove()" style="flex-shrink: 0; background: none; border: none; cursor: pointer; color: var(--trvl-gray-400, #999); padding: 0.25rem; border-radius: 0.25rem; transition: color 0.2s;" onmouseover="this.style.color='var(--trvl-text)'" onmouseout="this.style.color='var(--trvl-gray-400, #999)'">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
    </button>
    <div style="position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: {{ $bgColor }}30;">
        <div id="{{ $toastId }}-progress" style="height: 100%; background: {{ $bgColor }}; width: 100%; transition: width 5s linear;"></div>
    </div>
</div>

<script>
(function() {
    var toast = document.getElementById('{{ $toastId }}');
    if (!toast) return;

    requestAnimationFrame(function() {
        toast.style.transform = 'translateX(0)';
    });

    setTimeout(function() {
        var progress = document.getElementById('{{ $toastId }}-progress');
        if (progress) progress.style.width = '0%';
    }, 100);

    setTimeout(function() {
        toast.style.transition = 'transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.4s ease';
        toast.style.transform = 'translateX(120%)';
        toast.style.opacity = '0';
        setTimeout(function() { toast.remove(); }, 400);
    }, 5000);
})();
</script>
