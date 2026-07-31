@extends('layouts.app')

@section('title', 'Company Details')

@section('content')
<div class="page-header">
    <h1 class="page-title">{{ $company->name }}</h1>
    <p class="page-subtitle">Company Management</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="card">
        <div class="text-sm text-gray-600 mb-1">Total Users</div>
        <div class="text-3xl font-bold">{{ $stats['total_users'] }}</div>
    </div>
    <div class="card">
        <div class="text-sm text-gray-600 mb-1">Total Mitras</div>
        <div class="text-3xl font-bold">{{ $stats['total_mitras'] }}</div>
    </div>
    <div class="card">
        <div class="text-sm text-gray-600 mb-1">Total Vehicles</div>
        <div class="text-3xl font-bold">{{ $stats['total_vehicles'] }}</div>
    </div>
    <div class="card">
        <div class="text-sm text-gray-600 mb-1">Total Revenue</div>
        <div class="text-3xl font-bold">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</div>
    </div>
</div>

<div class="card mb-6">
    <h2 class="text-xl font-bold mb-4">Company Information</h2>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <div class="text-sm text-gray-600">Email</div>
            <div class="font-medium">{{ $company->email }}</div>
        </div>
        <div>
            <div class="text-sm text-gray-600">Phone</div>
            <div class="font-medium">{{ $company->phone }}</div>
        </div>
        <div>
            <div class="text-sm text-gray-600">City</div>
            <div class="font-medium">{{ $company->city }}</div>
        </div>
        <div>
            <div class="text-sm text-gray-600">Status</div>
            <div class="font-medium">{{ ucfirst($company->status) }}</div>
        </div>
        <div>
            <div class="text-sm text-gray-600">Subscription Plan</div>
            <div class="font-medium">{{ ucfirst($company->subscription_plan) }}</div>
        </div>
        <div>
            <div class="text-sm text-gray-600">Subscription Period</div>
            <div class="font-medium">{{ $company->subscription_start_date->format('d M Y') }} - {{ $company->subscription_end_date->format('d M Y') }}</div>
        </div>
    </div>
</div>

<div class="flex gap-4">
    <a href="{{ route('super-admin.companies') }}" class="btn btn-secondary">Back to Companies</a>
    <a href="{{ route('super-admin.companies.update', $company) }}" class="btn btn-primary">Edit Company</a>
</div>
@endsection