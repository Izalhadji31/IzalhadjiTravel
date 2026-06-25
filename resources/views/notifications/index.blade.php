@extends('layouts.app')

@section('title', 'Notifikasi')

@section('content')
<style>
    .notification-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #f3f4f6;
        transition: background 0.2s;
        cursor: pointer;
        text-decoration: none;
        color: inherit;
    }
    .notification-item:last-child { border-bottom: none; }
    .notification-item:hover { background: #f9fafb; }
    .notification-item.unread { background: #eff6ff; }
    .notification-item.unread:hover { background: #dbeafe; }
    
    .notification-icon {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .notification-icon svg { width: 1.25rem; height: 1.25rem; }
    .notification-icon.booking { background: #dbeafe; color: #2563eb; }
    .notification-icon.payment { background: #dcfce7; color: #16a34a; }
    .notification-icon.system { background: #f3f4f6; color: #6b7280; }
    
    .notification-content { flex: 1; min-width: 0; }
    .notification-title { font-weight: 600; font-size: 0.95rem; color: #111; margin: 0; }
    .notification-message { font-size: 0.875rem; color: #666; margin: 0.25rem 0 0 0; line-height: 1.4; }
    .notification-meta { display: flex; align-items: center; gap: 0.75rem; margin-top: 0.5rem; }
    .notification-time { font-size: 0.8rem; color: #999; }
    .notification-badge {
        font-size: 0.7rem;
        font-weight: 600;
        padding: 0.125rem 0.5rem;
        border-radius: 9999px;
        background: #dbeafe;
        color: #2563eb;
    }
    
    .notification-delete {
        opacity: 0;
        transition: opacity 0.2s;
        background: none;
        border: none;
        color: #999;
        cursor: pointer;
        padding: 0.25rem;
        border-radius: 0.25rem;
    }
    .notification-delete:hover { color: #ef4444; background: #fef2f2; }
    .notification-item:hover .notification-delete { opacity: 1; }
    
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }
    .empty-state svg { width: 4rem; height: 4rem; color: #d1d5db; margin-bottom: 1rem; }
    .empty-state h3 { font-size: 1.125rem; font-weight: 600; color: #666; margin: 0; }
    .empty-state p { font-size: 0.9rem; color: #999; margin: 0.5rem 0 0 0; }
    
    .mark-all-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: #f3f4f6;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        color: #333;
        cursor: pointer;
        transition: all 0.2s;
    }
    .mark-all-btn:hover { background: #e5e7eb; }
    
    .notification-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
    }
    
    .notification-count {
        font-size: 0.875rem;
        color: #666;
        font-weight: 500;
    }
    
    .notification-list {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 0.625rem;
        overflow: hidden;
    }
    
    .pagination-wrapper {
        margin-top: 1.5rem;
    }
</style>

<div class="page-header">
    <div class="notification-header">
        <div>
            <h1 class="page-title">Notifikasi</h1>
            @if($unreadCount > 0)
                <p class="notification-count">{{ $unreadCount }} belum dibaca</p>
            @endif
        </div>
        @if($unreadCount > 0)
            <form method="POST" action="{{ route('notifications.read-all') }}" style="margin: 0;">
                @csrf
                <button type="submit" class="mark-all-btn">
                    <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Tandai Semua Dibaca
                </button>
            </form>
        @endif
    </div>
</div>

@if($notifications->count() > 0)
    <div class="notification-list">
        @foreach($notifications as $notification)
            <a href="{{ route('notifications.read', $notification) }}" 
               class="notification-item @if(!$notification->is_read) unread @endif">
                
                {{-- Icon based on type --}}
                <div class="notification-icon {{ $notification->type ?? 'system' }}">
                    @if($notification->type === 'booking')
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    @elseif($notification->type === 'payment')
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    @else
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    @endif
                </div>
                
                <div class="notification-content">
                    <p class="notification-title">{{ $notification->title }}</p>
                    <p class="notification-message">{{ Str::limit($notification->message, 120) }}</p>
                    <div class="notification-meta">
                        <span class="notification-time">{{ $notification->sent_at ? $notification->sent_at->diffForHumans() : $notification->created_at->diffForHumans() }}</span>
                        @if(!$notification->is_read)
                            <span class="notification-badge">Baru</span>
                        @endif
                    </div>
                </div>
                
                <form method="POST" action="{{ route('notifications.destroy', $notification) }}" 
                      onclick="event.preventDefault(); event.stopPropagation(); if(confirm('Hapus notifikasi ini?')) this.submit();"
                      style="margin: 0; display: flex; align-items: center;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="notification-delete" title="Hapus">
                        <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </form>
            </a>
        @endforeach
    </div>
    
    <div class="pagination-wrapper">
        {{ $notifications->links() }}
    </div>
@else
    <div class="empty-state">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
        </svg>
        <h3>Belum ada notifikasi</h3>
        <p>Anda akan melihat notifikasi di sini ketika ada aktivitas baru.</p>
    </div>
@endif
@endsection
