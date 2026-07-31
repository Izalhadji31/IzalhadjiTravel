@extends('layouts.app')

@section('title', 'Companies Management')

@section('content')
<div class="page-header">
    <h1 class="page-title">Companies Management</h1>
    <p class="page-subtitle">Manage all SaaS companies</p>
</div>

<div class="flex justify-between items-center mb-6">
    <div class="search-box">
        <svg style="width: 1rem; height: 1rem; color: #999;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        <input type="text" placeholder="Search companies...">
    </div>
    <a href="{{ route('super-admin.companies.create') }}" class="btn btn-primary">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 1rem; height: 1rem;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Add Company
    </a>
</div>

<div class="card">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b">
                    <th class="text-left py-3 px-4">Name</th>
                    <th class="text-left py-3 px-4">Email</th>
                    <th class="text-left py-3 px-4">City</th>
                    <th class="text-left py-3 px-4">Status</th>
                    <th class="text-left py-3 px-4">Plan</th>
                    <th class="text-left py-3 px-4">Users</th>
                    <th class="text-left py-3 px-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($companies as $company)
                <tr class="border-b">
                    <td class="py-3 px-4 font-medium">{{ $company->name }}</td>
                    <td class="py-3 px-4">{{ $company->email }}</td>
                    <td class="py-3 px-4">{{ $company->city }}</td>
                    <td class="py-3 px-4">
                        <span class="px-2 py-1 rounded text-xs {{ $company->status === 'active' ? 'bg-green-100 text-green-800' : ($company->status === 'trial' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst($company->status) }}
                        </span>
                    </td>
                    <td class="py-3 px-4">{{ ucfirst($company->subscription_plan) }}</td>
                    <td class="py-3 px-4">{{ $company->users()->count() }}</td>
                    <td class="py-3 px-4">
                        <div class="flex gap-2">
                            <a href="{{ route('super-admin.companies.show', $company) }}" class="text-blue-600 hover:underline">View</a>
                            <a href="{{ route('super-admin.companies.update', $company) }}" class="text-green-600 hover:underline">Edit</a>
                            @if($company->status === 'active')
                                <form action="{{ route('super-admin.companies.suspend', $company) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-red-600 hover:underline">Suspend</button>
                                </form>
                            @else
                                <form action="{{ route('super-admin.companies.activate', $company) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:underline">Activate</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $companies->links() }}
</div>
@endsection