@extends('layouts.app')

@section('title', 'Drivers Management')

@section('content')
    <!-- Page Header -->
    <div class="page-header mb-8 flex justify-between items-start">
        <div>
            <h1 class="page-title">Drivers Management</h1>
            <p class="page-subtitle">Manage and track your drivers performance.</p>
        </div>
        <a href="{{ route('drivers.create') }}" class="btn-primary">
            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add Driver
        </a>
    </div>

    <!-- Driver Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Drivers</p>
                    <p class="text-3xl font-bold text-blue-600 mt-2">45</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">On Duty</p>
                    <p class="text-3xl font-bold text-amber-600 mt-2">18</p>
                </div>
                <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m7 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Available</p>
                    <p class="text-3xl font-bold text-emerald-600 mt-2">23</p>
                </div>
                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m0 0l-2-1m2 1v2.5M14 4l-2 1m0 0L10 4m2 1v2.5"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Avg Rating</p>
                    <p class="text-3xl font-bold text-yellow-600 mt-2">4.8</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Drivers Grid -->
    <div class="grid-responsive">
        @for ($i = 1; $i <= 5; $i++)
        <div class="card hover:shadow-lg transition-shadow duration-200">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Driver {{ $i }}</h3>
                    <p class="text-sm text-gray-600 mt-1">License: <strong>DL-{{ rand(100000, 999999) }}</strong></p>
                </div>
                <span class="badge badge-success">Available</span>
            </div>

            <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-lg h-24 flex items-center justify-center mb-4">
                <svg class="w-12 h-12 text-amber-600" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                </svg>
            </div>

            <div class="space-y-2 mb-4 pb-4 border-b border-gray-200 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">Phone:</span>
                    <span class="font-medium text-gray-900">+628123456{{ $i }}000</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Vehicle:</span>
                    <span class="font-medium text-gray-900">Toyota Avanza</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Rating:</span>
                    <div class="flex items-center">
                        <span class="text-yellow-500 text-lg">★★★★★</span>
                        <span class="ml-1 font-medium text-gray-900">4.9</span>
                    </div>
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
