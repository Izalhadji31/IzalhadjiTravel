@extends('layouts.app')

@section('title', 'Super Admin Dashboard')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<style>
    :root {
        --trvl-blue: #0064d2;
        --trvl-navy: #0a1628;
        --trvl-orange: #ff6b00;
    }
</style>

<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold" style="color: var(--trvl-navy);">Super Admin Dashboard</h1>
        <p class="text-gray-500 mt-1">Global SaaS management overview</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Companies -->
        <div class="card" style="border-left: 4px solid var(--trvl-blue);">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Companies</p>
                    <p class="text-3xl font-bold mt-1" style="color: var(--trvl-navy);">{{ $totalCompanies }}</p>
                </div>
                <div class="w-12 h-12 rounded-lg flex items-center justify-center" style="background: rgba(0,100,210,0.1);">
                    <svg class="w-6 h-6" style="color: var(--trvl-blue);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Users -->
        <div class="card" style="border-left: 4px solid var(--trvl-orange);">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Users</p>
                    <p class="text-3xl font-bold mt-1" style="color: var(--trvl-navy);">{{ $totalUsers }}</p>
                </div>
                <div class="w-12 h-12 rounded-lg flex items-center justify-center" style="background: rgba(255,107,0,0.1);">
                    <svg class="w-6 h-6" style="color: var(--trvl-orange);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="card" style="border-left: 4px solid #10b981;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Revenue</p>
                    <p class="text-3xl font-bold mt-1" style="color: var(--trvl-navy);">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                </div>
                <div class="w-12 h-12 rounded-lg flex items-center justify-center" style="background: rgba(16,185,129,0.1);">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Active Companies -->
        <div class="card" style="border-left: 4px solid #8b5cf6;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Active Companies</p>
                    <p class="text-3xl font-bold mt-1" style="color: var(--trvl-navy);">{{ $activeCompanies }}</p>
                </div>
                <div class="w-12 h-12 rounded-lg flex items-center justify-center" style="background: rgba(139,92,246,0.1);">
                    <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Company Subscriptions -->
        <div class="card">
            <h3 class="text-lg font-semibold mb-4" style="color: var(--trvl-navy);">Companies by Subscription Plan</h3>
            @forelse($companySubscriptions as $sub)
                <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                    <div class="flex items-center gap-3">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if($sub->subscription_plan === 'enterprise') bg-purple-100 text-purple-800
                            @elseif($sub->subscription_plan === 'professional') bg-blue-100 text-blue-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ ucfirst($sub->subscription_plan ?? 'Free') }}
                        </span>
                    </div>
                    <span class="text-lg font-bold" style="color: var(--trvl-blue);">{{ $sub->count }}</span>
                </div>
            @empty
                <p class="text-gray-500 text-sm">No subscription data available.</p>
            @endforelse
        </div>

        <!-- Monthly Revenue Trend -->
        <div class="card">
            <h3 class="text-lg font-semibold mb-4" style="color: var(--trvl-navy);">Monthly Revenue Trend</h3>
            @if($monthlyRevenue->count() > 0)
                <div class="space-y-3">
                    @php $maxRevenue = $monthlyRevenue->max('total') ?: 1; @endphp
                    @foreach($monthlyRevenue as $item)
                        <div class="flex items-center gap-3">
                            <span class="text-xs text-gray-500 w-20 flex-shrink-0">
                                {{ \Carbon\Carbon::parse($item->month)->format('M Y') }}
                            </span>
                            <div class="flex-1 bg-gray-100 rounded-full h-6 overflow-hidden">
                                <div class="h-full rounded-full flex items-center pl-2 text-xs text-white font-medium"
                                     style="width: {{ ($item->total / $maxRevenue) * 100 }}%; background: var(--trvl-blue); min-width: 2%;">
                                    Rp {{ number_format($item->total, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-sm">No revenue data available.</p>
            @endif
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="card">
        <h3 class="text-lg font-semibold mb-4" style="color: var(--trvl-navy);">Recent Transactions</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="pb-3 text-xs font-semibold text-gray-500 uppercase">User</th>
                        <th class="pb-3 text-xs font-semibold text-gray-500 uppercase">Amount</th>
                        <th class="pb-3 text-xs font-semibold text-gray-500 uppercase">Method</th>
                        <th class="pb-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                        <th class="pb-3 text-xs font-semibold text-gray-500 uppercase">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentTransactions as $transaction)
                        <tr class="border-b border-gray-50">
                            <td class="py-3 text-sm">{{ $transaction->user->name ?? 'N/A' }}</td>
                            <td class="py-3 text-sm font-medium">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                            <td class="py-3 text-sm">{{ ucfirst($transaction->payment_method) }}</td>
                            <td class="py-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            </td>
                            <td class="py-3 text-sm text-gray-500">{{ $transaction->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-gray-400">No recent transactions</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
