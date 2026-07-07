@extends('layouts.app')

@section('content')
<div style="padding: 24px 32px; background-color: #f0f4f8; min-height: 100vh;">
    <!-- Page Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px;">
        <div>
            <h1 style="font-size: 26px; font-weight: 700; color: #1e3a5f; margin: 0; letter-spacing: -0.5px;">
                Manajemen Partner / Mitra
            </h1>
            <p style="font-size: 14px; color: #64748b; margin: 4px 0 0 0;">
                Kelola mitra, pencairan dana, dan penugasan armada
            </p>
        </div>
        @if(isset($partners))
        <div style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: #fff; padding: 10px 20px; border-radius: 8px; font-size: 14px; font-weight: 600; box-shadow: 0 2px 8px rgba(37,99,235,0.25);">
            Total Partners: {{ $partners->count() }}
        </div>
        @endif
    </div>

    <!-- Stats Summary Cards -->
    @if(isset($partners))
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 28px;">
        <div style="background: #fff; border-radius: 10px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); border-top: 3px solid #2563eb;">
            <div style="font-size: 12px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Total Armada</div>
            <div style="font-size: 28px; font-weight: 700; color: #1e3a5f; margin-top: 6px;">{{ $partners->sum('armadas_count') }}</div>
        </div>
        <div style="background: #fff; border-radius: 10px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); border-top: 3px solid #059669;">
            <div style="font-size: 12px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Total Pendapatan</div>
            <div style="font-size: 28px; font-weight: 700; color: #1e3a5f; margin-top: 6px;">Rp {{ number_format($partners->sum('total_earnings'), 0, ',', '.') }}</div>
        </div>
        <div style="background: #fff; border-radius: 10px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); border-top: 3px solid #d97706;">
            <div style="font-size: 12px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Pencairan Tertunda</div>
            <div style="font-size: 28px; font-weight: 700; color: #1e3a5f; margin-top: 6px;">Rp {{ number_format($partners->sum('pending_payouts'), 0, ',', '.') }}</div>
        </div>
        <div style="background: #fff; border-radius: 10px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); border-top: 3px solid #10b981;">
            <div style="font-size: 12px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Mitra Aktif</div>
            <div style="font-size: 28px; font-weight: 700; color: #1e3a5f; margin-top: 6px;">{{ $partners->where('is_active', true)->count() }}</div>
        </div>
    </div>
    @endif

    <!-- Partners Table -->
    <div style="background: #fff; border-radius: 12px; box-shadow: 0 1px 4px rgba(0,0,0,0.08); overflow: hidden;">
        <div style="padding: 18px 24px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
            <h2 style="font-size: 17px; font-weight: 600; color: #1e3a5f; margin: 0;">Semua Mitra</h2>
            <div style="font-size: 13px; color: #64748b;">
                Showing {{ isset($partners) ? $partners->count() : 0 }} entri
            </div>
        </div>

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; min-width: 950px;">
                <thead>
                    <tr style="background: #f8fafc;">
                        <th style="padding: 14px 16px; text-align: left; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.6px; border-bottom: 2px solid #e2e8f0;">No</th>
                        <th style="padding: 14px 16px; text-align: left; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.6px; border-bottom: 2px solid #e2e8f0;">Nama</th>
                        <th style="padding: 14px 16px; text-align: left; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.6px; border-bottom: 2px solid #e2e8f0;">Telepon</th>
                        <th style="padding: 14px 16px; text-align: left; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.6px; border-bottom: 2px solid #e2e8f0;">Kota</th>
                        <th style="padding: 14px 16px; text-align: center; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.6px; border-bottom: 2px solid #e2e8f0;">Armada</th>
                        <th style="padding: 14px 16px; text-align: right; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.6px; border-bottom: 2px solid #e2e8f0;">Total Pendapatan</th>
                        <th style="padding: 14px 16px; text-align: right; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.6px; border-bottom: 2px solid #e2e8f0;">Belum Dicairkan</th>
                        <th style="padding: 14px 16px; text-align: center; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.6px; border-bottom: 2px solid #e2e8f0;">Status</th>
                        <th style="padding: 14px 16px; text-align: center; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.6px; border-bottom: 2px solid #e2e8f0;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($partners as $index => $partner)
                    <tr style="border-bottom: 1px solid #f1f5f9; transition: background-color 0.15s;" onmouseover="this.style.backgroundColor='#f8fafc';" onmouseout="this.style.backgroundColor='transparent';">
                        <td style="padding: 14px 16px; font-size: 13px; color: #64748b; font-weight: 500;">{{ $index + 1 }}</td>
                        <td style="padding: 14px 16px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 14px; font-weight: 600; flex-shrink: 0;">
                                    {{ strtoupper(substr($partner->name, 0, 1)) }}
                                </div>
                                <span style="font-size: 14px; font-weight: 600; color: #1e3a5f;">{{ $partner->name }}</span>
                            </div>
                        </td>
                        <td style="padding: 14px 16px; font-size: 13px; color: #475569;">{{ $partner->phone }}</td>
                        <td style="padding: 14px 16px; font-size: 13px; color: #475569;">
                            <span style="display: inline-flex; align-items: center; gap: 4px;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                {{ $partner->city }}
                            </span>
                        </td>
                        <td style="padding: 14px 16px; text-align: center;">
                            <span style="display: inline-block; padding: 4px 10px; border-radius: 12px; font-size: 12px; font-weight: 600; background-color: #dbeafe; color: #1d4ed8;">
                                {{ $partner->armadas_count ?? 0 }}
                            </span>
                        </td>
                        <td style="padding: 14px 16px; text-align: right; font-size: 13px; font-weight: 600; color: #059669;">
                            Rp {{ number_format($partner->total_earnings ?? 0, 0, ',', '.') }}
                        </td>
                        <td style="padding: 14px 16px; text-align: right;">
                            @if(($partner->pending_payouts ?? 0) > 0)
                            <span style="font-size: 13px; font-weight: 600; color: #d97706;">
                                Rp {{ number_format($partner->pending_payouts, 0, ',', '.') }}
                            </span>
                            @else
                            <span style="font-size: 13px; color: #94a3b8;">—</span>
                            @endif
                        </td>
                        <td style="padding: 14px 16px; text-align: center;">
                            @if($partner->is_active)
                            <span style="display: inline-flex; align-items: center; gap: 5px; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; background-color: #d1fae5; color: #065f46;">
                                <span style="width: 6px; height: 6px; border-radius: 50%; background-color: #10b981;"></span>
                                Aktif
                            </span>
                            @else
                            <span style="display: inline-flex; align-items: center; gap: 5px; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; background-color: #fee2e2; color: #991b1b;">
                                <span style="width: 6px; height: 6px; border-radius: 50%; background-color: #ef4444;"></span>
                                Nonaktif
                            </span>
                            @endif
                        </td>
                        <td style="padding: 14px 16px; text-align: center;">
                            <div style="display: flex; gap: 6px; justify-content: center; align-items: center;">
                                @if(($partner->pending_payouts ?? 0) > 0)
                                <form action="{{ route('admin.partners.payout', $partner->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Process payout of Rp {{ number_format($partner->pending_payouts, 0, ',', '.') }} for {{ $partner->name }}?');">
                                    @csrf
                                    <button type="submit" style="display: inline-flex; align-items: center; gap: 4px; padding: 6px 12px; border: none; border-radius: 6px; font-size: 11px; font-weight: 600; cursor: pointer; background-color: #059669; color: #fff; transition: background-color 0.15s;" onmouseover="this.style.backgroundColor='#047857';" onmouseout="this.style.backgroundColor='#059669';" title="Process Payout">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                                        Payout
                                    </button>
                                </form>
                                @endif
                                <form action="{{ route('admin.partners.toggle-status', $partner->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" style="display: inline-flex; align-items: center; gap: 4px; padding: 6px 12px; border: none; border-radius: 6px; font-size: 11px; font-weight: 600; cursor: pointer; background-color: {{ $partner->is_active ? '#d97706' : '#2563eb' }}; color: #fff; transition: background-color 0.15s;" onmouseover="this.style.backgroundColor='{{ $partner->is_active ? '#b45309' : '#1d4ed8' }}';" onmouseout="this.style.backgroundColor='{{ $partner->is_active ? '#d97706' : '#2563eb' }}';" title="{{ $partner->is_active ? 'Deactivate Partner' : 'Activate Partner' }}">
                                        @if($partner->is_active)
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18.36 6.64a9 9 0 1 1-12.73 0"/><line x1="12" y1="2" x2="12" y2="12"/></svg>
                                        Deactivate
                                        @else
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                        Activate
                                        @endif
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" style="padding: 60px 20px; text-align: center;">
                            <div style="display: flex; flex-direction: column; align-items: center; gap: 12px;">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                <p style="font-size: 15px; font-weight: 600; color: #475569; margin: 0;">Tidak ada mitra ditemukan</p>
                                <p style="font-size: 13px; color: #94a3b8; margin: 0;">Mitra akan muncul di sini setelah mereka terdaftar di sistem.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if(isset($partners) && $partners->hasPages())
        <div style="padding: 16px 24px; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
            <div style="font-size: 13px; color: #64748b;">
                Menampilkan {{ $partners->firstItem() }} hingga {{ $partners->lastItem() }} dari {{ $partners->total() }} mitra
            </div>
            <div style="display: flex; gap: 4px;">
                {{ $partners->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
