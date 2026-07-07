@extends('layouts.app')

@section('title', 'Review Moderation')

@section('content')
<div style="padding: 24px; background-color: #f1f5f9; min-height: 100vh;">
    <!-- Page Header -->
    <div style="margin-bottom: 24px;">
        <h1 style="font-size: 24px; font-weight: 700; color: #1e293b; margin: 0;">Moderasi Ulasan</h1>
        <p style="font-size: 14px; color: #64748b; margin: 4px 0 0 0;">Setujui atau tolak ulasan pelanggan</p>
    </div>

    <!-- Stats Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px; margin-bottom: 24px;">
        <div style="background: #ffffff; border-radius: 8px; padding: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); border-left: 4px solid #3b82f6;">
            <div style="font-size: 12px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Total Ulasan</div>
            <div style="font-size: 28px; font-weight: 700; color: #3b82f6; margin-top: 4px;">{{ $totalReviews }}</div>
        </div>
        <div style="background: #ffffff; border-radius: 8px; padding: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); border-left: 4px solid #f59e0b;">
            <div style="font-size: 12px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Pending</div>
            <div style="font-size: 28px; font-weight: 700; color: #f59e0b; margin-top: 4px;">{{ $pendingReviews }}</div>
        </div>
        <div style="background: #ffffff; border-radius: 8px; padding: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); border-left: 4px solid #22c55e;">
            <div style="font-size: 12px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Rata-rata Rating</div>
            <div style="font-size: 28px; font-weight: 700; color: #22c55e; margin-top: 4px;">{{ $avgRating ? number_format($avgRating, 1) : 'N/A' }} <span style="font-size: 14px; color: #64748b;">/ 5</span></div>
        </div>
    </div>

    <!-- Main Card -->
    <div style="background: #ffffff; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); overflow: hidden;">
        <!-- Filter Bar -->
        <div style="padding: 16px 20px; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
            <div style="display: flex; align-items: center; gap: 4px; flex-wrap: wrap;">
                <a href="{{ route('admin.reviews') }}" style="display: inline-block; padding: 6px 14px; border-radius: 6px; font-size: 13px; font-weight: 500; text-decoration: none; transition: all 0.15s; {{ $status === '' ? 'background-color: #2563eb; color: #ffffff;' : 'background-color: #f1f5f9; color: #475569;' }}">Semua</a>
                <a href="{{ route('admin.reviews', ['status' => 'pending']) }}" style="display: inline-block; padding: 6px 14px; border-radius: 6px; font-size: 13px; font-weight: 500; text-decoration: none; transition: all 0.15s; {{ $status === 'pending' ? 'background-color: #f59e0b; color: #ffffff;' : 'background-color: #f1f5f9; color: #475569;' }}">Pending</a>
                <a href="{{ route('admin.reviews', ['status' => 'approved']) }}" style="display: inline-block; padding: 6px 14px; border-radius: 6px; font-size: 13px; font-weight: 500; text-decoration: none; transition: all 0.15s; {{ $status === 'approved' ? 'background-color: #22c55e; color: #ffffff;' : 'background-color: #f1f5f9; color: #475569;' }}">Disetujui</a>
                <a href="{{ route('admin.reviews', ['status' => 'rejected']) }}" style="display: inline-block; padding: 6px 14px; border-radius: 6px; font-size: 13px; font-weight: 500; text-decoration: none; transition: all 0.15s; {{ $status === 'rejected' ? 'background-color: #ef4444; color: #ffffff;' : 'background-color: #f1f5f9; color: #475569;' }}">Ditolak</a>
            </div>
            <div style="font-size: 13px; color: #64748b;">
                Total: <strong style="color: #1e293b;">{{ $reviews->total() }}</strong> reviews
            </div>
        </div>

        <!-- Table -->
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f8fafc;">
                        <th style="padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #e2e8f0;">Pengulas</th>
                        <th style="padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #e2e8f0;">Booking</th>
                        <th style="padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #e2e8f0;">Rating</th>
                        <th style="padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #e2e8f0;">Komentar</th>
                        <th style="padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #e2e8f0;">Tanggal</th>
                        <th style="padding: 12px 16px; text-align: center; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #e2e8f0;">Status</th>
                        <th style="padding: 12px 16px; text-align: center; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #e2e8f0;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reviews as $review)
                    <tr style="border-bottom: 1px solid #f1f5f9; transition: background-color 0.15s;" onmouseover="this.style.backgroundColor='#f8fafc';" onmouseout="this.style.backgroundColor='transparent';">
                        <td style="padding: 12px 16px; font-size: 13px; color: #1e293b;">
                            <div style="font-weight: 600;">{{ $review->user->name ?? 'Unknown' }}</div>
                            <div style="font-size: 11px; color: #64748b;">{{ $review->user->email ?? '' }}</div>
                        </td>
                        <td style="padding: 12px 16px; font-size: 13px; color: #475569;">
                            @if($review->booking)
                                <div>#{{ $review->booking->booking_code ?? $review->booking->id }}</div>
                                <div style="font-size: 11px; color: #64748b;">
                                    {{ $review->booking->route->origin_city ?? '' }} → {{ $review->booking->route->destination_city ?? '' }}
                                </div>
                            @else
                                <span style="color: #94a3b8;">N/A</span>
                            @endif
                        </td>
                        <td style="padding: 12px 16px;">
                            <div style="display: flex; gap: 1px;">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <svg style="width: 14px; height: 14px; color: #f59e0b;" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @else
                                        <svg style="width: 14px; height: 14px; color: #d1d5db;" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endif
                                @endfor
                            </div>
                        </td>
                        <td style="padding: 12px 16px; font-size: 13px; color: #475569; max-width: 220px;">
                            <div style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $review->comment }}">
                                {{ $review->comment ?? '-' }}
                            </div>
                        </td>
                        <td style="padding: 12px 16px; font-size: 13px; color: #475569;">
                            {{ $review->created_at ? $review->created_at->format('d M Y H:i') : '-' }}
                        </td>
                        <td style="padding: 12px 16px; text-align: center;">
                            @php $s = $review->status ?? 'pending'; @endphp
                            <span style="display: inline-block; padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 600; text-transform: capitalize;
                                {{ $s === 'pending' ? 'background-color:#fef3c7;color:#92400e;' : '' }}
                                {{ $s === 'approved' ? 'background-color:#dcfce7;color:#166534;' : '' }}
                                {{ $s === 'rejected' ? 'background-color:#fee2e2;color:#991b1b;' : '' }}">
                                {{ ucfirst($s) }}
                            </span>
                        </td>
                        <td style="padding: 12px 16px; text-align: center;">
                            <div style="display: flex; gap: 6px; justify-content: center; align-items: center;">
                                @if($s === 'pending')
                                <form action="{{ route('admin.reviews.approve', $review->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" style="padding: 6px 12px; border-radius: 4px; font-size: 11px; font-weight: 600; background-color: #22c55e; color: #ffffff; border: none; cursor: pointer; transition: background-color 0.15s; display: inline-flex; align-items: center; gap: 4px;" onmouseover="this.style.backgroundColor='#16a34a';" onmouseout="this.style.backgroundColor='#22c55e';">
                                        <svg style="width: 12px; height: 12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        Approve
                                    </button>
                                </form>
                                <form action="{{ route('admin.reviews.reject', $review->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Tolak ulasan ini?');" style="padding: 6px 12px; border-radius: 4px; font-size: 11px; font-weight: 600; background-color: #ef4444; color: #ffffff; border: none; cursor: pointer; transition: background-color 0.15s; display: inline-flex; align-items: center; gap: 4px;" onmouseover="this.style.backgroundColor='#dc2626';" onmouseout="this.style.backgroundColor='#ef4444';">
                                        <svg style="width: 12px; height: 12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        Tolak
                                    </button>
                                </form>
                                @elseif($s === 'approved')
                                <span style="font-size: 11px; color: #166534; font-weight: 500;">✓ Disetujui</span>
                                @else
                                <span style="font-size: 11px; color: #991b1b; font-weight: 500;">✕ Ditolak</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="padding: 48px 16px; text-align: center; color: #94a3b8; font-size: 14px;">
                            <div style="font-size: 40px; margin-bottom: 8px;">📝</div>
            Tidak ada ulasan untuk filter ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Footer with Pagination -->
        <div style="padding: 12px 20px; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; font-size: 13px; color: #64748b; flex-wrap: wrap; gap: 8px;">
            <span>Menampilkan {{ $reviews->firstItem() ?? 0 }} - {{ $reviews->lastItem() ?? 0 }} dari {{ $reviews->total() }} ulasan</span>
            <div style="display: flex; gap: 4px;">
                {{ $reviews->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
