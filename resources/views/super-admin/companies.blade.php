@extends('layouts.app')

@section('title', 'Manage Companies')

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
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold" style="color: var(--trvl-navy);">Companies</h1>
            <p class="text-gray-500 mt-1">Manage all registered companies</p>
        </div>
        <a href="{{ route('super-admin.companies.create') }}" class="btn btn-primary inline-flex items-center gap-2" style="background: var(--trvl-blue);">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add Company
        </a>
    </div>

    <!-- Search & Filter -->
    <div class="card mb-6">
        <form method="GET" action="{{ route('super-admin.companies') }}" class="flex flex-wrap gap-4 items-center">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search by name or email..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:outline-none"
                    style="focus:ring-color: var(--trvl-blue); focus:border-color: var(--trvl-blue);">
            </div>
            <div>
                <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:outline-none">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                    <option value="trial" {{ request('status') === 'trial' ? 'selected' : '' }}>Trial</option>
                </select>
            </div>
            <button type="submit" class="btn" style="background: var(--trvl-blue); color: white;">
                Filter
            </button>
        </form>
    </div>

    <!-- Companies Table -->
    <div class="card">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="pb-3 text-xs font-semibold text-gray-500 uppercase">Company</th>
                        <th class="pb-3 text-xs font-semibold text-gray-500 uppercase">Email</th>
                        <th class="pb-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                        <th class="pb-3 text-xs font-semibold text-gray-500 uppercase">Users</th>
                        <th class="pb-3 text-xs font-semibold text-gray-500 uppercase">Plan</th>
                        <th class="pb-3 text-xs font-semibold text-gray-500 uppercase">Created</th>
                        <th class="pb-3 text-xs font-semibold text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($companies as $company)
                        <tr class="border-b border-gray-50 hover:bg-gray-50 transition-colors">
                            <td class="py-4">
                                <a href="{{ route('super-admin.companies.show', $company) }}" class="text-sm font-semibold hover:underline" style="color: var(--trvl-blue);">
                                    {{ $company->name }}
                                </a>
                            </td>
                            <td class="py-4 text-sm text-gray-600">{{ $company->email }}</td>
                            <td class="py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($company->status === 'active') bg-green-100 text-green-800
                                    @elseif($company->status === 'suspended') bg-red-100 text-red-800
                                    @elseif($company->status === 'trial') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($company->status) }}
                                </span>
                            </td>
                            <td class="py-4 text-sm text-gray-600">{{ $company->users()->count() }}</td>
                            <td class="py-4">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                    @if($company->subscription_plan === 'enterprise') bg-purple-100 text-purple-700
                                    @elseif($company->subscription_plan === 'professional') bg-blue-100 text-blue-700
                                    @else bg-gray-100 text-gray-700 @endif">
                                    {{ ucfirst($company->subscription_plan ?? 'starter') }}
                                </span>
                            </td>
                            <td class="py-4 text-sm text-gray-500">{{ $company->created_at->format('d M Y') }}</td>
                            <td class="py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('super-admin.companies.show', $company) }}"
                                       class="text-xs px-3 py-1 rounded-md border border-gray-300 hover:bg-gray-50 transition-colors">
                                        View
                                    </a>
                                    @if($company->status === 'active')
                                        <form method="POST" action="{{ route('super-admin.companies.suspend', $company) }}" class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="text-xs px-3 py-1 rounded-md text-white transition-colors"
                                                style="background: var(--trvl-orange);"
                                                onclick="return confirm('Suspend this company?')">
                                                Suspend
                                            </button>
                                        </form>
                                    @elseif($company->status === 'suspended')
                                        <form method="POST" action="{{ route('super-admin.companies.activate', $company) }}" class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="text-xs px-3 py-1 rounded-md bg-green-500 text-white transition-colors hover:bg-green-600"
                                                onclick="return confirm('Activate this company?')">
                                                Activate
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-gray-400">No companies found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $companies->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
