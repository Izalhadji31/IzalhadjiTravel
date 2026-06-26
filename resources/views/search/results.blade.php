@extends('layouts.app')

@section('title', 'Search Results')

@section('content')
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">Search Results</h1>
        <p class="text-gray-600">
            @if($query)
                Results for "{{ $query }}" ({{ $results->count() }} found)
            @else
                Enter a search term to find routes, vehicles, drivers, or partners
            @endif
        </p>
    </div>

    @if($query && $results->count() > 0)
        <div class="space-y-3">
            @foreach($results as $result)
                <a href="{{ $result['url'] }}" class="card flex items-center gap-4 hover:border-blue-300 transition-all group">
                    <div class="flex-shrink-0">
                        @php
                            $badgeColors = [
                                'blue' => 'bg-blue-100 text-blue-700',
                                'green' => 'bg-green-100 text-green-700',
                                'purple' => 'bg-purple-100 text-purple-700',
                                'orange' => 'bg-orange-100 text-orange-700',
                            ];
                            $colorClass = $badgeColors[$result['badge_color']] ?? 'bg-gray-100 text-gray-700';
                        @endphp
                        <span class="inline-block px-3 py-1.5 rounded-lg text-xs font-semibold {{ $colorClass }}">
                            {{ $result['badge'] }}
                        </span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-gray-900 group-hover:text-blue-600 transition-colors">{{ $result['title'] }}</h3>
                        <p class="text-sm text-gray-500">{{ $result['subtitle'] }}</p>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            @endforeach
        </div>
    @elseif($query)
        <div class="card text-center py-16">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <h3 class="text-lg font-semibold text-gray-700 mb-2">No results found</h3>
            <p class="text-gray-500">Try different keywords or check your spelling.</p>
        </div>
    @endif
@endsection
