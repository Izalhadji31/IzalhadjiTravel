@extends('layouts.app')

@section('title', 'Super Admin Dashboard')

@section('content')
<div class="page-header">
    <h1 class="page-title">Super Admin Dashboard</h1>
    <p class="page-subtitle">Global SaaS Management</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="card">
        <div class="text-sm text-gray-600 mb-1">Total Companies</div>
        <div class="text-3xl font-bold">{{ \App\Models\Company::count() }}</div>
    </div>
    <div class="card">
        <div class="text-sm text-gray-600 mb-1">Total Users</div>
        <div class="text-3xl font-bold">{{ \App\Models\User::count() }}</div>
    </div>
    <div class="card">
        <div class="text-sm text-gray-600 mb-1">Active Companies</div>
        <div class="text-3xl font-bold">{{ \App\Models\Company::where('status', 'active')->count() }}</div>
    </div>
    <div class="card">
        <div class="text-sm text-gray-600 mb-1">Trial Companies</div>
        <div class="text-3xl font-bold">{{ \App\Models\Company::where('status', 'trial')->count() }}</div>
    </div>
</div>

<div class="card">
    <h2 class="text-xl font-bold mb-4">Recent Companies</h2>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b">
                    <th class="text-left py-3 px-4">Name</th>
                    <th class="text-left py-3 px-4">Email</th>
                    <th class="text-left py-3 px-4">Status</th>
                    <th class="text-left py-3 px-4">Plan</th>
                    <th class="text-left py-3 px-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach(\App\Models\Company::latest()->take(5)->get() as $company)
                <tr class="border-b">
                    <td class="py-3 px-4">{{ $company->name }}</td>
                    <td class="py-3 px-4">{{ $company->email }}</td>
                    <td class="py-3 px-4">
                        <span class="px-2 py-1 rounded text-xs {{ $company->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($company->status) }}
                        </span>
                    </td>
                    <td class="py-3 px-4">{{ ucfirst($company->subscription_plan) }}</td>
                    <td class="py-3 px-4">
                        <a href="{{ route('super-admin.companies.show', $company) }}" class="text-blue-600 hover:underline">View</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection