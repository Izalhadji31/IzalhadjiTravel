@extends('layouts.app')

@section('title', 'Global Analytics')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<style>
    :root {
        --trvl-blue: #0064d2;
        --trvl-navy: #0a1628;
        --trvl-orange: #ff6b00;
    }
    .bar-chart-container { display: flex; align-items: flex-end; gap: 8px; height: 280px; padding-top: 20px; }
    .bar-wrapper { display: flex; flex-direction: column; align-items: center; flex: 1; min-width: 0; }
    .bar { width: 100%; max-width: 60px; border-radius: 6px 6px 0 0; transition: all 0.3s; position: relative; cursor: pointer; min-height: 4px; }
    .bar:hover { opacity: 0.8; transform: scaleY(1.02); }
    .bar-label { font-size: 0.65rem; color: #888; margin-top: 8px; text-align: center; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 80px; }
    .bar-value { font-size: 0.6rem; color: #555; margin-bottom: 4px; font-weight: 600; }
</style>

<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold" style="color: var(--trvl-navy);">Global Analytics</h1>
        <p class="text-gray-500 mt-1">Platform-wide revenue and performance metrics</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Revenue by Company Chart -->
        <div class="card">
            <h3 class="text-lg font-semibold mb-6" style="color: var(--trvl-navy);">Revenue by Company</h3>
            @php $maxRevenue = $revenueByCompany->max('revenue') ?: 1; @endphp
            @if($revenueByCompany->count() > 0)
                <div class="bar-chart-container">
                    @foreach($revenueByCompany as $item)
                        <div class="bar-wrapper">
                            <div class="bar-value">Rp {{ number_format($item['revenue'] / 1000000, 1) }}M</div>
                            <div class="bar"
                                 style="height: {{ ($item['revenue'] / $maxRevenue) * 240 }}px; background: {{ $loop->index % 2 === 0 ? 'var(--trvl-blue)' : 'var(--trvl-orange)' }};">
                            </div>
                            <div class="bar-label" title="{{ $item['name'] }}">{{ $item['name'] }}</div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-400 text-center py-12">No revenue data available</p>
            @endif
        </div>

        <!-- Revenue Table -->
        <div class="card">
            <h3 class="text-lg font-semibold mb-4" style="color: var(--trvl-navy);">Revenue Breakdown</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="pb-3 text-xs font-semibold text-gray-500 uppercase">#</th>
                            <th class="pb-3 text-xs font-semibold text-gray-500 uppercase">Company</th>
                            <th class="pb-3 text-xs font-semibold text-gray-500 uppercase text-right">Revenue</th>
                            <th class="pb-3 text-xs font-semibold text-gray-500 uppercase text-right">Share</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $totalRev = $revenueByCompany->sum('revenue') ?: 1; @endphp
                        @forelse($revenueByCompany as $index => $item)
                            <tr class="border-b border-gray-50">
                                <td class="py-3 text-sm text-gray-400">{{ $index + 1 }}</td>
                                <td class="py-3 text-sm font-medium">{{ $item['name'] }}</td>
                                <td class="py-3 text-sm font-medium text-right">Rp {{ number_format($item['revenue'], 0, ',', '.') }}</td>
                                <td class="py-3 text-sm text-right">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium"
                                          style="background: rgba(0,100,210,0.1); color: var(--trvl-blue);">
                                        {{ number_format(($item['revenue'] / $totalRev) * 100, 1) }}%
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-gray-400">No data available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Top Mitras -->
        <div class="card">
            <h3 class="text-lg font-semibold mb-4" style="color: var(--trvl-navy);">Top Mitras (Global)</h3>
            <div class="space-y-3">
                @forelse($topMitras as $mitra)
                    <div class="flex items-center justify-between py-2">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold"
                                 style="background: var(--trvl-orange);">
                                {{ $loop->index + 1 }}
                            </div>
                            <div>
                                <p class="text-sm font-medium">{{ $mitra->name }}</p>
                                <p class="text-xs text-gray-400">{{ $mitra->company->name ?? 'No Company' }}</p>
                            </div>
                        </div>
                        <span class="text-sm font-semibold" style="color: var(--trvl-blue);">
                            Rp {{ number_format($mitra->revenue_sharings_sum_mitra_amount ?? 0, 0, ',', '.') }}
                        </span>
                    </div>
                @empty
                    <p class="text-gray-400 text-center py-8">No mitra data available</p>
                @endforelse
            </div>
        </div>

        <!-- Payment Methods Distribution -->
        <div class="card">
            <h3 class="text-lg font-semibold mb-4" style="color: var(--trvl-navy);">Payment Methods</h3>
            <div class="space-y-4">
                @php $totalPayments = $paymentMethods->sum('count') ?: 1; @endphp
                @forelse($paymentMethods as $method)
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm font-medium">{{ ucfirst(str_replace('_', ' ', $method->payment_method)) }}</span>
                            <span class="text-xs text-gray-500">{{ $method->count }} txns</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
                            <div class="h-full rounded-full"
                                 style="width: {{ ($method->count / $totalPayments) * 100 }}%; background: var(--trvl-blue); min-width: 2%;">
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Rp {{ number_format($method->total, 0, ',', '.') }}</p>
                    </div>
                @empty
                    <p class="text-gray-400 text-center py-8">No payment data available</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
