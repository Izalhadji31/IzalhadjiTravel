@extends('layouts.app')

@section('title', 'Routes Management')

@section('content')
    <div class="page-header mb-8 flex justify-between items-start">
        <div>
            <h1 class="page-title">Routes Management</h1>
            <p class="page-subtitle">Manage all travel and rental routes for your business.</p>
        </div>
        <a href="{{ route('routes.create') }}" class="btn-primary">
            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add Route
        </a>
    </div>

    <form method="GET" action="{{ route('routes.index') }}" class="card mb-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search routes..."
                class="form-input"
            >
            <select name="type" class="form-select">
                <option value="all">All Types</option>
                <option value="travel" @selected(request('type') === 'travel')>Travel</option>
                <option value="rental" @selected(request('type') === 'rental')>Rental</option>
                <option value="both" @selected(request('type') === 'both')>Both</option>
            </select>
            <div></div>
            <button type="submit" class="btn-primary w-full">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                Search
            </button>
        </div>
    </form>

    <div class="grid-responsive mb-8">
        @forelse ($routes as $route)
            <div class="card hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ $route->name }}</h3>
                        <p class="text-sm text-gray-600 mt-1 flex items-center">
                            <span class="inline-block w-2 h-2 bg-blue-500 rounded-full mr-2"></span>
                            {{ ucfirst($route->route_type) }} Route
                        </p>
                    </div>
                    <span class="badge {{ $route->is_active ? 'badge-success' : 'badge-gray' }}">
                        {{ $route->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>

                <div class="space-y-3 mb-4 pb-4 border-b border-gray-200">
                    <div class="flex items-center text-gray-600">
                        <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 003 16.382V5.618a1 1 0 011.553-.894L9 7.882"></path>
                        </svg>
                        <span class="text-sm">Distance: <strong>{{ $route->distance_km ?? 0 }} km</strong></span>
                    </div>
                    <div class="flex items-center text-gray-600">
                        <svg class="w-4 h-4 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"></path>
                        </svg>
                        <span class="text-sm">From <strong>{{ $route->origin_city ?? '-' }}</strong> to <strong>{{ $route->destination_city ?? '-' }}</strong></span>
                    </div>
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('routes.edit', $route) }}" class="flex-1 px-3 py-2 bg-blue-50 text-blue-600 rounded-lg font-medium hover:bg-blue-100 transition-colors text-sm text-center">Edit</a>
                    <form method="POST" action="{{ route('routes.destroy', $route) }}" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-3 py-2 bg-red-50 text-red-600 rounded-lg font-medium hover:bg-red-100 transition-colors text-sm">Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="card col-span-full text-center text-gray-600">
                No routes found.
            </div>
        @endforelse
    </div>
@endsection
