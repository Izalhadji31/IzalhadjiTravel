@extends('layouts.app')

@section('title', 'Revenue Analytics')

@section('content')
    <!-- Page Header -->
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Revenue Analytics</h1>
            <p class="text-gray-600">Track your earnings and revenue streams</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('analytics.revenue.export-csv', ['start_date' => $startDate, 'end_date' => $endDate]) }}" 
               class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                📥 Export CSV
            </a>
        </div>
    </div>

    <!-- Key Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="card">
            <p class="text-gray-600 text-sm">Total Revenue</p>
            <p class="text-4xl font-bold text-blue-600 mt-2">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            <p class="text-gray-600 text-sm mt-2">Period: {{ date('d M Y', strtotime($startDate)) }} - {{ date('d M Y', strtotime($endDate)) }}</p>
        </div>
        <div class="card">
            <p class="text-gray-600 text-sm">Travel Revenue</p>
            <p class="text-4xl font-bold text-blue-600 mt-2">Rp {{ number_format($travelRevenue, 0, ',', '.') }}</p>
        </div>
        <div class="card">
            <p class="text-gray-600 text-sm">Rental Revenue</p>
            <p class="text-4xl font-bold text-purple-600 mt-2">Rp {{ number_format($rentalRevenue, 0, ',', '.') }}</p>
        </div>
        <div class="card">
            <p class="text-gray-600 text-sm">Revenue Sharing Entries</p>
            <p class="text-4xl font-bold text-green-600 mt-2">{{ $revenueSharing->count() }}</p>
        </div>
    </div>

    <!-- Revenue Sharing Detail -->
    <div class="card">
        <div class="card-header">Revenue Sharing Details</div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Date</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Booking ID</th>
                        <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">Admin Share</th>
                        <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">Mitra Share</th>
                        <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">Driver Share</th>
                        <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($revenueSharing as $share)
                    <tr class="border-b border-gray-100 hover:bg-blue-50">
                        <td class="px-6 py-3 text-gray-700">{{ $share->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-3 text-gray-700">{{ $share->booking_id }}</td>
                        <td class="px-6 py-3 text-right text-gray-700">Rp {{ number_format($share->admin_share, 0, ',', '.') }}</td>
                        <td class="px-6 py-3 text-right text-gray-700">Rp {{ number_format($share->mitra_share, 0, ',', '.') }}</td>
                        <td class="px-6 py-3 text-right text-gray-700">Rp {{ number_format($share->driver_share, 0, ',', '.') }}</td>
                        <td class="px-6 py-3 text-right font-bold text-green-600">
                            Rp {{ number_format($share->admin_share + $share->mitra_share + $share->driver_share, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada data revenue sharing</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
            <div class="card-header">Revenue by Source</div>
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="font-medium text-gray-700">Travel Bookings</span>
                        <span class="text-blue-600 font-bold">60%</span>
                    </div>
                    <div class="w-full bg-blue-100 rounded-full h-3">
                        <div class="bg-blue-600 h-3 rounded-full" style="width: 60%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="font-medium text-gray-700">Rental Bookings</span>
                        <span class="text-purple-600 font-bold">35%</span>
                    </div>
                    <div class="w-full bg-purple-100 rounded-full h-3">
                        <div class="bg-purple-600 h-3 rounded-full" style="width: 35%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="font-medium text-gray-700">Partner Commission</span>
                        <span class="text-green-600 font-bold">5%</span>
                    </div>
                    <div class="w-full bg-green-100 rounded-full h-3">
                        <div class="bg-green-600 h-3 rounded-full" style="width: 5%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="card">
        <div class="card-header">Recent Transactions</div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Date</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Type</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Source</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Amount</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 1; $i <= 8; $i++)
                    <tr class="border-b border-gray-100 hover:bg-blue-50">
                        <td class="px-6 py-3 text-gray-700">May {{ $i }}, 2026</td>
                        <td class="px-6 py-3"><span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm">Travel</span></td>
                        <td class="px-6 py-3 text-gray-700">Booking #TB00{{ $i }}</td>
                        <td class="px-6 py-3 font-bold text-green-600">+${{ rand(150, 400) }}.00</td>
                        <td class="px-6 py-3"><span class="text-green-600 text-sm">Completed</span></td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
@endsection
