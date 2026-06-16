@extends('layouts.app')

@section('title', 'Partners Management')

@section('content')
    <!-- Page Header -->
    <div class="page-header mb-8 flex justify-between items-start">
        <div>
            <h1 class="page-title">Partners Management</h1>
            <p class="page-subtitle">Manage business partners and affiliates.</p>
        </div>
        <a href="{{ route('partners.create') }}" class="btn-primary">
            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add Partner
        </a>
    </div>

    <!-- Partners Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Partners</p>
                    <p class="text-3xl font-bold text-purple-600 mt-2">28</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 10H9m6 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Active</p>
                    <p class="text-3xl font-bold text-emerald-600 mt-2">24</p>
                </div>
                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Revenue</p>
                    <p class="text-3xl font-bold text-emerald-600 mt-2">$245K</p>
                </div>
                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Partners Cards -->
    <div class="grid-responsive">
        @for ($i = 1; $i <= 6; $i++)
        <div class="card hover:shadow-lg transition-shadow duration-200">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold mr-4">
                    {{ chr(64 + $i) }}
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Partner {{ $i }}</h3>
                    <p class="text-sm text-gray-600">Premium Partner</p>
                </div>
            </div>

            <div class="space-y-2 mb-4 pb-4 border-b border-gray-200 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">Contact:</span>
                    <span class="font-medium text-gray-900">+628123456{{ $i }}00</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">City:</span>
                    <span class="font-medium text-gray-900">Jakarta</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Commission:</span>
                    <span class="font-bold text-purple-600">15%</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Total Revenue:</span>
                    <span class="font-bold text-emerald-600">$12,500</span>
                </div>
            </div>

            <div class="flex gap-2">
                <a href="#" class="flex-1 px-3 py-2 bg-blue-50 text-blue-600 rounded-lg font-medium hover:bg-blue-100 text-center text-sm transition-colors">Details</a>
                <a href="#" class="flex-1 px-3 py-2 bg-red-50 text-red-600 rounded-lg font-medium hover:bg-red-100 text-center text-sm transition-colors">Delete</a>
            </div>
        </div>
        @endfor
    </div>
@endsection
