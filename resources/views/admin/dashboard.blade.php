@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">Admin Dashboard</h1>
        <p class="text-gray-600">System administration and configuration</p>
    </div>

    <!-- Admin Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="card border-l-4 border-blue-600">
            <p class="text-gray-600 text-sm">Total Users</p>
            <p class="text-4xl font-bold text-blue-600 mt-2">1,245</p>
            <p class="text-gray-600 text-xs mt-2">Registered accounts</p>
        </div>
        <div class="card border-l-4 border-green-600">
            <p class="text-gray-600 text-sm">System Health</p>
            <p class="text-4xl font-bold text-green-600 mt-2">99.8%</p>
            <p class="text-green-600 text-xs mt-2">All systems operational</p>
        </div>
        <div class="card border-l-4 border-orange-600">
            <p class="text-gray-600 text-sm">Pending Issues</p>
            <p class="text-4xl font-bold text-orange-600 mt-2">5</p>
            <p class="text-gray-600 text-xs mt-2">Require attention</p>
        </div>
        <div class="card border-l-4 border-red-600">
            <p class="text-gray-600 text-sm">Failed Transactions</p>
            <p class="text-4xl font-bold text-red-600 mt-2">3</p>
            <p class="text-gray-600 text-xs mt-2">Last 24 hours</p>
        </div>
    </div>

    <!-- Admin Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="card">
            <h3 class="card-header">System Configuration</h3>
            <div class="space-y-3">
                <a href="{{ route('admin.users') }}" class="block px-4 py-3 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 4H9m6 16H9m6-7a1 1 0 11-2 0 1 1 0 012 0z"></path>
                    </svg>
                    Manage Users
                </a>
                <a href="{{ route('admin.settings') }}" class="block px-4 py-3 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    System Settings
                </a>
                <button class="w-full px-4 py-3 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors text-left">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0 4v2M7 11a2 2 0 11-4 0 2 2 0 014 0zm10-8a1 1 0 100-2 1 1 0 000 2z"></path>
                    </svg>
                    Clear Cache
                </button>
            </div>
        </div>

        <div class="card">
            <h3 class="card-header">Database & Backup</h3>
            <div class="space-y-3">
                <button class="w-full px-4 py-3 bg-green-50 text-green-600 rounded-lg hover:bg-green-100 transition-colors text-left">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Create Backup
                </button>
                <button class="w-full px-4 py-3 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors text-left">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Database Status
                </button>
                <button class="w-full px-4 py-3 bg-purple-50 text-purple-600 rounded-lg hover:bg-purple-100 transition-colors text-left">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    View Logs
                </button>
            </div>
        </div>
    </div>

    <!-- Recent System Activity -->
    <div class="card">
        <div class="card-header">System Activity Log</div>
        
        <div class="space-y-4">
            @for ($i = 1; $i <= 5; $i++)
            <div class="flex items-start pb-4 border-b border-gray-200 last:border-b-0">
                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-gray-900">User Activity: New Registration</p>
                    <p class="text-gray-600 text-sm">User ID #{{ rand(100, 9999) }} registered at 10:{{ rand(10, 59) }} AM</p>
                    <p class="text-gray-500 text-xs mt-1">{{ $i }} hour{{ $i > 1 ? 's' : '' }} ago</p>
                </div>
            </div>
            @endfor
        </div>
    </div>
@endsection
