@extends('layouts.app')

@section('title', 'Dashboard - ASR GO')

@section('content')
<div style="padding: 2rem;">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 3rem;">
        <!-- Card: Total Spent -->
        <div style="background: white; border: 1px solid #e5e7eb; border-radius: 0.75rem; padding: 1.5rem;">
            <p style="color: #6b7280; font-weight: 600; margin: 0 0 0.5rem 0; font-size: 0.85rem;">Total Pengeluaran</p>
            <h3 style="font-size: 1.75rem; font-weight: 700; color: #2563eb; margin: 0; margin-bottom: 0.5rem;">
                Rp. {{ number_format($totalSpent, 0, ',', '.') }}
            </h3>
            <p style="color: #9ca3af; margin: 0; font-size: 0.85rem;">Dari semua perjalanan</p>
        </div>

        <!-- Card: Total Trips -->
        <div style="background: white; border: 1px solid #e5e7eb; border-radius: 0.75rem; padding: 1.5rem;">
            <p style="color: #6b7280; font-weight: 600; margin: 0 0 0.5rem 0; font-size: 0.85rem;">Total Perjalanan</p>
            <h3 style="font-size: 1.75rem; font-weight: 700; color: #10b981; margin: 0; margin-bottom: 0.5rem;">
                {{ $totalTrips }}
            </h3>
            <p style="color: #9ca3af; margin: 0; font-size: 0.85rem;">Perjalanan selesai</p>
        </div>

        <!-- Card: Rating -->
        <div style="background: white; border: 1px solid #e5e7eb; border-radius: 0.75rem; padding: 1.5rem;">
            <p style="color: #6b7280; font-weight: 600; margin: 0 0 0.5rem 0; font-size: 0.85rem;">Rating Anda</p>
            <h3 style="font-size: 1.75rem; font-weight: 700; color: #f59e0b; margin: 0; margin-bottom: 0.5rem;">
                {{ Auth::user()->rating ?? 0 }}
            </h3>
            <p style="color: #9ca3af; margin: 0; font-size: 0.85rem;">Rating dari driver</p>
        </div>
    </div>

    <h2 style="font-size: 1.25rem; font-weight: 700; color: #1f2937; margin-bottom: 1.5rem;">Perjalanan Terbaru</h2>

    <div style="background: white; border: 1px solid #e5e7eb; border-radius: 0.75rem; overflow: hidden;">
        @if($bookings->count() > 0)
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background: #f8fafc; border-bottom: 2px solid #e5e7eb;">
                    <tr>
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: #1f2937;">Kode Booking</th>
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: #1f2937;">Rute</th>
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: #1f2937;">Harga</th>
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: #1f2937;">Status</th>
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: #1f2937;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $booking)
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <td style="padding: 1rem; color: #1f2937;">{{ $booking->booking_code }}</td>
                            <td style="padding: 1rem; color: #1f2937;">
                                @if($booking->route)
                                    {{ $booking->route->fromLocation->name ?? '-' }} → {{ $booking->route->toLocation->name ?? '-' }}
                                @else
                                    -
                                @endif
                            </td>
                            <td style="padding: 1rem; color: #2563eb; font-weight: 600;">Rp. {{ number_format($booking->final_price, 0, ',', '.') }}</td>
                            <td style="padding: 1rem;">
                                <span style="
                                    padding: 0.25rem 0.75rem;
                                    border-radius: 0.25rem;
                                    font-weight: 600;
                                    font-size: 0.85rem;
                                    @if($booking->status == 'confirmed') background: #d1fae5; color: #065f46; 
                                    @elseif($booking->status == 'pending') background: #fef3c7; color: #92400e;
                                    @elseif($booking->status == 'completed') background: #dbeafe; color: #0c4a6e;
                                    @else background: #fee2e2; color: #7f1d1d;
                                    @endif
                                ">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td style="padding: 1rem;">
                                <a href="/bookings/travel/{{ $booking->id }}" style="color: #2563eb; text-decoration: none; font-weight: 600; font-size: 0.9rem;">
                                    Lihat Detail →
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="padding: 1rem; text-align: center; border-top: 1px solid #e5e7eb;">
                {{ $bookings->links() }}
            </div>
        @else
            <div style="padding: 2rem; text-align: center; color: #6b7280;">
                <p style="font-size: 3rem; margin-bottom: 1rem;">📭</p>
                <p style="font-size: 1.1rem; margin: 0;">Belum ada perjalanan</p>
                <p style="font-size: 0.9rem; margin-top: 0.5rem;">Mulai pesan perjalanan Anda sekarang!</p>
                <a href="/public/travel" class="btn-primary" style="display: inline-block; margin-top: 1rem;">Pesan Sekarang</a>
            </div>
        @endif
    </div>
</div>
@endsection
