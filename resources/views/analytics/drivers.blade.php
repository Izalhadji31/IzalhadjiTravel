@extends('layouts.app')

@section('title', 'Driver Performance')

@section('content')
    <!-- Page Header -->
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Driver Performance</h1>
            <p class="text-gray-600">Monitor driver metrics and ratings</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('analytics.drivers.export-csv') }}" 
               class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                📥 Export CSV
            </a>
        </div>
    </div>

    <!-- Performance Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="card">
            <p class="text-gray-600 text-sm">Top Performer</p>
            <p class="text-2xl font-bold text-blue-600 mt-2">Budi Santoso</p>
            <p class="text-yellow-500 text-sm mt-2">★★★★★ 4.95</p>
        </div>
        <div class="card">
            <p class="text-gray-600 text-sm">Avg Rating</p>
            <p class="text-4xl font-bold text-green-600 mt-2">4.7</p>
            <p class="text-gray-600 text-sm mt-2">Out of 5.0</p>
        </div>
        <div class="card">
            <p class="text-gray-600 text-sm">Total Trips</p>
            <p class="text-4xl font-bold text-blue-600 mt-2">2,450</p>
            <p class="text-gray-600 text-sm mt-2">All drivers combined</p>
        </div>
        <div class="card">
            <p class="text-gray-600 text-sm">Safety Score</p>
            <p class="text-4xl font-bold text-green-600 mt-2">98.5%</p>
            <p class="text-gray-600 text-sm mt-2">Excellent</p>
        </div>
    </div>

    <!-- Driver Leaderboard -->
    <div class="card">
        <div class="card-header">Top Drivers by Rating</div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Rank</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Driver Name</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Trips</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Rating</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Revenue</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 1; $i <= 10; $i++)
                    <tr class="border-b border-gray-100 hover:bg-blue-50">
                        <td class="px-6 py-3 font-bold text-gray-900">#{{ $i }}</td>
                        <td class="px-6 py-3 text-gray-700">Driver {{ $i }}</td>
                        <td class="px-6 py-3 text-gray-700">{{ rand(100, 500) }}</td>
                        <td class="px-6 py-3">
                            <span class="text-yellow-500">★★★★★</span>
                            <span class="ml-1 font-semibold text-gray-900">{{ number_format(rand(40, 50) / 10, 2) }}</span>
                        </td>
                        <td class="px-6 py-3 font-bold text-green-600">${{ rand(5000, 25000) }}</td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
@endsection
