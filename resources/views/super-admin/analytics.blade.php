@extends('layouts.app')

@section('title', 'Global Analytics')

@section('content')
<div class="page-header">
    <h1 class="page-title">Global Analytics</h1>
    <p class="page-subtitle">Platform-wide analytics and metrics</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="card">
        <h2 class="text-xl font-bold mb-4">Revenue by Company</h2>
        <div class="space-y-4">
            @foreach($revenueByCompany as $item)
            <div class="flex justify-between items-center">
                <span>{{ $item['name'] }}</span>
                <span class="font-bold">Rp {{ number_format($item['revenue'], 0, ',', '.') }}</span>
            </div>
            @endforeach
        </div>
    </div>
    <div class="card">
        <h2 class="text-xl font-bold mb-4">Top Mitras</h2>
        <div class="space-y-4">
            @foreach($topMitras as $mitra)
            <div class="flex justify-between items-center">
                <span>{{ $mitra->name }}</span>
                <span class="font-bold">Rp {{ number_format($mitra->revenue_sharings_sum_mitra_amount, 0, ',', '.') }}</span>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="card">
    <h2 class="text-xl font-bold mb-4">Payment Methods Distribution</h2>
    <div class="space-y-4">
        @foreach($paymentMethods as $method)
        <div class="flex justify-between items-center">
            <span>{{ ucfirst($method->payment_method) }}</span>
            <div class="text-right">
                <div class="font-bold">{{ $method->count }} transactions</div>
                <div class="text-sm text-gray-600">Rp {{ number_format($method->total, 0, ',', '.') }}</div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection