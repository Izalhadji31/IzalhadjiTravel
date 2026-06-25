@extends('layouts.app')

@section('content')
<div style="padding: 24px; background-color: #f1f5f9; min-height: 100vh;">
    <!-- Page Header -->
    <div style="margin-bottom: 24px;">
        <h1 style="font-size: 24px; font-weight: 700; color: #1e293b; margin: 0;">Manajemen Voucher</h1>
        <p style="font-size: 14px; color: #64748b; margin: 4px 0 0 0;">Kelola kode promo dan diskon</p>
    </div>

    <!-- Add Voucher Form -->
    <div style="background: #fff; border-radius: 8px; padding: 24px; margin-bottom: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
        <h3 style="font-size: 16px; font-weight: 600; margin: 0 0 16px 0;">Buat Voucher Baru</h3>
        <form action="{{ route('admin.vouchers.store') }}" method="POST">
            @csrf
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 4px;">Kode Voucher *</label>
                    <input type="text" name="code" required style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; text-transform: uppercase;" placeholder="PROMO50">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 4px;">Tipe *</label>
                    <select name="type" required style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;">
                        <option value="percentage">Persentase (%)</option>
                        <option value="fixed">Potong Nominal (Rp)</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 4px;">Nilai *</label>
                    <input type="number" name="value" required min="1" style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;" placeholder="50">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 4px;">Max Diskon (Rp)</label>
                    <input type="number" name="max_discount" style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;" placeholder="100000">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 4px;">Batas Penggunaan</label>
                    <input type="number" name="usage_limit" style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;" placeholder="100">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 4px;">Berlaku Dari *</label>
                    <input type="date" name="valid_from" required style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 4px;">Berlaku Sampai *</label>
                    <input type="date" name="valid_until" required style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;">
                </div>
            </div>
            <div style="margin-top: 12px;">
                <label style="display: block; font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 4px;">Deskripsi</label>
                <input type="text" name="description" style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;" placeholder="Promo akhir pekan diskon 50%">
            </div>
            <div style="margin-top: 16px;">
                <button type="submit" style="padding: 8px 24px; background-color: #2563eb; color: #fff; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; font-size: 14px;">Simpan Voucher</button>
            </div>
        </form>
    </div>

    <!-- Vouchers Table -->
    <div style="background: #fff; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background-color: #f8fafc;">
                    <th style="padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; border-bottom: 2px solid #e2e8f0;">Kode</th>
                    <th style="padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; border-bottom: 2px solid #e2e8f0;">Tipe</th>
                    <th style="padding: 12px 16px; text-align: right; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; border-bottom: 2px solid #e2e8f0;">Nilai</th>
                    <th style="padding: 12px 16px; text-align: center; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; border-bottom: 2px solid #e2e8f0;">Penggunaan</th>
                    <th style="padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; border-bottom: 2px solid #e2e8f0;">Berlaku</th>
                    <th style="padding: 12px 16px; text-align: center; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; border-bottom: 2px solid #e2e8f0;">Status</th>
                    <th style="padding: 12px 16px; text-align: center; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; border-bottom: 2px solid #e2e8f0;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($vouchers as $voucher)
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 12px 16px; font-size: 13px; font-weight: 700; color: #2563eb; text-transform: uppercase;">{{ $voucher->code }}</td>
                    <td style="padding: 12px 16px;">
                        <span style="display: inline-block; padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: 600;
                            {{ $voucher->type === 'percentage' ? 'background-color:#dbeafe;color:#1e40af;' : 'background-color:#dcfce7;color:#166534;' }}">
                            {{ $voucher->type === 'percentage' ? '%' : 'Rp' }}
                        </span>
                    </td>
                    <td style="padding: 12px 16px; font-size: 13px; font-weight: 600; color: #1e293b; text-align: right;">
                        {{ $voucher->type === 'percentage' ? $voucher->value . '%' : 'Rp ' . number_format($voucher->value, 0, ',', '.') }}
                    </td>
                    <td style="padding: 12px 16px; font-size: 13px; color: #475569; text-align: center;">
                        {{ $voucher->used_count }} / {{ $voucher->usage_limit ?? 'unlimited' }}
                    </td>
                    <td style="padding: 12px 16px; font-size: 12px; color: #475569;">
                        {{ $voucher->valid_from->format('d M Y') }} - {{ $voucher->valid_until->format('d M Y') }}
                    </td>
                    <td style="padding: 12px 16px; text-align: center;">
                        @if($voucher->isValid())
                        <span style="display: inline-block; padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 600; background-color:#dcfce7;color:#166534;">Aktif</span>
                        @else
                        <span style="display: inline-block; padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 600; background-color:#fee2e2;color:#991b1b;">Expired</span>
                        @endif
                    </td>
                    <td style="padding: 12px 16px; text-align: center;">
                        <form action="{{ route('admin.vouchers.destroy', $voucher->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus voucher ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" style="padding: 4px 10px; border-radius: 4px; font-size: 11px; font-weight: 600; background-color: #fee2e2; color: #991b1b; border: none; cursor: pointer;">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="padding: 48px 16px; text-align: center; color: #94a3b8; font-size: 14px;">
                        <div style="font-size: 40px; margin-bottom: 8px;">🎫</div>
                        Belum ada voucher. Buat voucher pertama Anda.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
