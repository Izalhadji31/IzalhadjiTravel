@extends('layouts.app')

@section('title', 'Bookings Report')

@section('content')
    <!-- Page Header -->
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Bookings Report</h1>
            <p class="text-gray-600">Analyze booking patterns and trends</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('analytics.bookings.export-csv', ['start_date' => $startDate, 'end_date' => $endDate]) }}" 
               class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                📥 Export CSV
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8 border border-blue-100">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <input type="date" class="px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600">
            <input type="date" class="px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600">
            <select class="px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600">
                <option>All Types</option>
                <option>Travel</option>
                <option>Rental</option>
            </select>
            <select class="px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600">
                <option>All Status</option>
                <option>Completed</option>
                <option>Pending</option>
            </select>
            <button class="btn-primary">Filter</button>
        </div>
    </div>

    <!-- Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="card">
            <p class="text-gray-600 text-sm">Total Bookings</p>
            <p class="text-4xl font-bold text-blue-600 mt-2">1,234</p>
            <p class="text-green-600 text-sm mt-2">↑ 12% growth</p>
        </div>
        <div class="card">
            <p class="text-gray-600 text-sm">Completion Rate</p>
            <p class="text-4xl font-bold text-green-600 mt-2">94.2%</p>
            <p class="text-gray-600 text-sm mt-2">High quality</p>
        </div>
        <div class="card">
            <p class="text-gray-600 text-sm">Avg Booking Value</p>
            <p class="text-4xl font-bold text-blue-600 mt-2">$285</p>
            <p class="text-gray-600 text-sm mt-2">Per transaction</p>
        </div>
        <div class="card">
            <p class="text-gray-600 text-sm">Cancellation Rate</p>
            <p class="text-4xl font-bold text-red-600 mt-2">5.8%</p>
            <p class="text-gray-600 text-sm mt-2">Below average</p>
        </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="card">
            <div class="card-header">Booking Trends</div>
            <div class="h-64 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-lg flex items-center justify-center">
                <p class="text-gray-500">📈 Trend Chart</p>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Booking Distribution</div>
            <div class="h-64 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-lg flex items-center justify-center">
                <p class="text-gray-500">📊 Distribution Chart</p>
            </div>
        </div>
    </div>
@endsection
