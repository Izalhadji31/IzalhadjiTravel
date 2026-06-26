@extends('layouts.app')

@section('title', 'My Bookings')

@section('content')
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">My Bookings</h1>
        <p class="text-gray-600">Semua pemesanan Anda dalam satu tempat</p>
    </div>

    <!-- Tab Filter -->
    <div class="flex gap-2 mb-6 flex-wrap">
        @php
            $tabs = [
                ['key' => 'all', 'label' => 'Semua'],
                ['key' => 'pending', 'label' => 'Pending'],
                ['key' => 'confirmed', 'label' => 'Confirmed'],
                ['key' => 'completed', 'label' => 'Completed'],
                ['key' => 'cancelled', 'label' => 'Cancelled'],
            ];
        @endphp
        @foreach($tabs as $tab)
            <a href="{{ route('bookings.index', ['status' => $tab['key']]) }}" 
               class="px-4 py-2 rounded-lg font-medium text-sm transition-all
               @if($status === $tab['key'])
                   bg-blue-600 text-white shadow-md
               @else
                   bg-gray-100 text-gray-700 hover:bg-gray-200
               @endif">
                {{ $tab['label'] }}
            </a>
        @endforeach
    </div>

    <!-- Bookings Table -->
    <div class="card overflow-hidden">
        @if($bookings->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600">Tipe</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600">Kode</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600">Detail</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600">Tanggal</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600">Total</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                            <tr class="border-b border-gray-100 hover:bg-blue-50 transition-colors cursor-pointer" 
                                onclick="window.location='{{ $booking->show_route }}'">
                                <td class="py-3 px-4">
                                    @php
                                        $badgeColors = [
                                            'travel' => 'bg-blue-100 text-blue-700',
                                            'rental' => 'bg-green-100 text-green-700',
                                            'airport_transfer' => 'bg-purple-100 text-purple-700',
                                        ];
                                        $colorClass = $badgeColors[$booking->type] ?? 'bg-gray-100 text-gray-700';
                                    @endphp
                                    <span class="inline-block px-2.5 py-1 rounded-full text-xs font-semibold {{ $colorClass }}">
                                        {{ $booking->type_label }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="font-mono text-sm font-medium text-gray-900">{{ $booking->booking_code ?? '-' }}</span>
                                </td>
                                <td class="py-3 px-4 text-sm text-gray-700">{{ Str::limit($booking->detail, 40) }}</td>
                                <td class="py-3 px-4 text-sm text-gray-600">
                                    @if(is_object($booking->date) && method_exists($booking->date, 'format'))
                                        {{ $booking->date->format('d M Y') }}
                                    @else
                                        {{ \Carbon\Carbon::parse($booking->date)->format('d M Y') }}
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-sm font-semibold text-gray-900">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                <td class="py-3 px-4">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-700',
                                            'confirmed' => 'bg-blue-100 text-blue-700',
                                            'completed' => 'bg-green-100 text-green-700',
                                            'cancelled' => 'bg-red-100 text-red-700',
                                        ];
                                        $statusColor = $statusColors[$booking->status] ?? 'bg-gray-100 text-gray-700';
                                    @endphp
                                    <span class="inline-block px-2.5 py-1 rounded-full text-xs font-semibold capitalize {{ $statusColor }}">
                                        {{ $booking->status }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6 flex justify-center">
                {{ $pagination->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Belum ada pemesanan</h3>
                <p class="text-gray-500 mb-4">Anda belum memiliki pemesanan dengan status ini.</p>
                <a href="{{ route('bookings.travel.create') }}" class="btn-primary">Buat Pemesanan Baru</a>
            </div>
        @endif
    </div>
@endsection
