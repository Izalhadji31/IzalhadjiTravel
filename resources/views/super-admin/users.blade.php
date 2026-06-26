@extends('layouts.app')

@section('title', 'All Users')

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
        <h1 class="text-3xl font-bold" style="color: var(--trvl-navy);">All Users</h1>
        <p class="text-gray-500 mt-1">Users across all companies</p>
    </div>

    <!-- Filters -->
    <div class="card mb-6">
        <form method="GET" action="{{ route('super-admin.users') }}" class="flex flex-wrap gap-4 items-center">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search by name or email..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:outline-none"
                    style="focus:ring-color: var(--trvl-blue);">
            </div>
            <div>
                <select name="role" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:outline-none">
                    <option value="">All Roles</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="partner" {{ request('role') === 'partner' ? 'selected' : '' }}>Partner</option>
                    <option value="driver" {{ request('role') === 'driver' ? 'selected' : '' }}>Driver</option>
                    <option value="customer" {{ request('role') === 'customer' ? 'selected' : '' }}>Customer</option>
                </select>
            </div>
            <div>
                <select name="company" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:outline-none">
                    <option value="">All Companies</option>
                    @foreach(\App\Models\Company::orderBy('name')->get() as $comp)
                        <option value="{{ $comp->id }}" {{ request('company') == $comp->id ? 'selected' : '' }}>{{ $comp->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn text-white" style="background: var(--trvl-blue);">
                Filter
            </button>
        </form>
    </div>

    <!-- Users Table -->
    <div class="card">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="pb-3 text-xs font-semibold text-gray-500 uppercase">Name</th>
                        <th class="pb-3 text-xs font-semibold text-gray-500 uppercase">Email</th>
                        <th class="pb-3 text-xs font-semibold text-gray-500 uppercase">Company</th>
                        <th class="pb-3 text-xs font-semibold text-gray-500 uppercase">Role</th>
                        <th class="pb-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                        <th class="pb-3 text-xs font-semibold text-gray-500 uppercase">Joined</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr class="border-b border-gray-50 hover:bg-gray-50 transition-colors">
                            <td class="py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold"
                                         style="background: var(--trvl-blue);">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <span class="text-sm font-medium">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="py-4 text-sm text-gray-600">{{ $user->email }}</td>
                            <td class="py-4 text-sm">
                                @if($user->company)
                                    <a href="{{ route('super-admin.companies.show', $user->company) }}" class="hover:underline" style="color: var(--trvl-blue);">
                                        {{ $user->company->name }}
                                    </a>
                                @else
                                    <span class="text-gray-400">No Company</span>
                                @endif
                            </td>
                            <td class="py-4">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                    @if($user->role === 'admin') bg-red-100 text-red-700
                                    @elseif($user->role === 'driver') bg-blue-100 text-blue-700
                                    @elseif($user->role === 'partner') bg-green-100 text-green-700
                                    @else bg-gray-100 text-gray-700 @endif">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="py-4">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                    {{ ($user->is_active ?? true) ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ($user->is_active ?? true) ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="py-4 text-sm text-gray-500">{{ $user->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-gray-400">No users found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $users->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
