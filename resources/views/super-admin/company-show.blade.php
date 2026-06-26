@extends('layouts.app')

@section('title', 'Company Details')

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
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('super-admin.companies') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h1 class="text-3xl font-bold" style="color: var(--trvl-navy);">{{ $company->name }}</h1>
        </div>
        <div class="flex items-center gap-3 mt-2">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                @if($company->status === 'active') bg-green-100 text-green-800
                @elseif($company->status === 'suspended') bg-red-100 text-red-800
                @elseif($company->status === 'trial') bg-yellow-100 text-yellow-800
                @else bg-gray-100 text-gray-800 @endif">
                {{ ucfirst($company->status) }}
            </span>
            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                @if($company->subscription_plan === 'enterprise') bg-purple-100 text-purple-700
                @elseif($company->subscription_plan === 'professional') bg-blue-100 text-blue-700
                @else bg-gray-100 text-gray-700 @endif">
                {{ ucfirst($company->subscription_plan ?? 'starter') }} Plan
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Company Info -->
        <div class="card lg:col-span-2">
            <h3 class="text-lg font-semibold mb-4" style="color: var(--trvl-navy);">Company Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-gray-500 uppercase font-semibold">Email</p>
                    <p class="text-sm mt-1">{{ $company->email }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase font-semibold">Phone</p>
                    <p class="text-sm mt-1">{{ $company->phone ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase font-semibold">Address</p>
                    <p class="text-sm mt-1">{{ $company->address ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase font-semibold">City / Province</p>
                    <p class="text-sm mt-1">{{ $company->city ?? 'N/A' }}, {{ $company->province ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase font-semibold">Max Users</p>
                    <p class="text-sm mt-1">{{ $company->max_users ?? 'Unlimited' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase font-semibold">Max Vehicles</p>
                    <p class="text-sm mt-1">{{ $company->max_vehicles ?? 'Unlimited' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase font-semibold">Created</p>
                    <p class="text-sm mt-1">{{ $company->created_at->format('d M Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase font-semibold">Admin User</p>
                    <p class="text-sm mt-1">{{ $company->adminUser->name ?? 'Not assigned' }}</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-3 mt-6 pt-4 border-t border-gray-200">
                @if($company->status === 'active')
                    <form method="POST" action="{{ route('super-admin.companies.suspend', $company) }}" class="inline">
                        @csrf
                        <button type="submit" class="btn text-white px-4 py-2 rounded-lg text-sm"
                            style="background: var(--trvl-orange);"
                            onclick="return confirm('Are you sure you want to suspend this company?')">
                            Suspend Company
                        </button>
                    </form>
                @elseif($company->status === 'suspended')
                    <form method="POST" action="{{ route('super-admin.companies.activate', $company) }}" class="inline">
                        @csrf
                        <button type="submit" class="btn bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm"
                            onclick="return confirm('Are you sure you want to activate this company?')">
                            Activate Company
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Stats -->
        <div class="space-y-4">
            <div class="card" style="border-left: 4px solid var(--trvl-blue);">
                <p class="text-xs text-gray-500 uppercase font-semibold">Total Users</p>
                <p class="text-2xl font-bold mt-1" style="color: var(--trvl-navy);">{{ $stats['total_users'] }}</p>
            </div>
            <div class="card" style="border-left: 4px solid var(--trvl-orange);">
                <p class="text-xs text-gray-500 uppercase font-semibold">Total Mitras</p>
                <p class="text-2xl font-bold mt-1" style="color: var(--trvl-navy);">{{ $stats['total_mitras'] }}</p>
            </div>
            <div class="card" style="border-left: 4px solid #10b981;">
                <p class="text-xs text-gray-500 uppercase font-semibold">Total Vehicles</p>
                <p class="text-2xl font-bold mt-1" style="color: var(--trvl-navy);">{{ $stats['total_vehicles'] }}</p>
            </div>
            <div class="card" style="border-left: 4px solid #8b5cf6;">
                <p class="text-xs text-gray-500 uppercase font-semibold">Total Bookings</p>
                <p class="text-2xl font-bold mt-1" style="color: var(--trvl-navy);">{{ $stats['total_bookings'] }}</p>
            </div>
            <div class="card" style="border-left: 4px solid #f59e0b;">
                <p class="text-xs text-gray-500 uppercase font-semibold">Total Revenue</p>
                <p class="text-2xl font-bold mt-1" style="color: var(--trvl-navy);">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <!-- Users List -->
    <div class="card">
        <h3 class="text-lg font-semibold mb-4" style="color: var(--trvl-navy);">Users in this Company</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="pb-3 text-xs font-semibold text-gray-500 uppercase">Name</th>
                        <th class="pb-3 text-xs font-semibold text-gray-500 uppercase">Email</th>
                        <th class="pb-3 text-xs font-semibold text-gray-500 uppercase">Role</th>
                        <th class="pb-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                        <th class="pb-3 text-xs font-semibold text-gray-500 uppercase">Joined</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($company->users as $user)
                        <tr class="border-b border-gray-50">
                            <td class="py-3 text-sm font-medium">{{ $user->name }}</td>
                            <td class="py-3 text-sm text-gray-600">{{ $user->email }}</td>
                            <td class="py-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                    @if($user->role === 'admin') bg-red-100 text-red-700
                                    @elseif($user->role === 'driver') bg-blue-100 text-blue-700
                                    @elseif($user->role === 'partner') bg-green-100 text-green-700
                                    @else bg-gray-100 text-gray-700 @endif">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="py-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                    {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="py-3 text-sm text-gray-500">{{ $user->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-gray-400">No users found in this company</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
