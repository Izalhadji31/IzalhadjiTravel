@extends('layouts.app')

@section('title', 'Rental Results')

@section('content')
<div class="page-header">
    <h1 class="page-title">Available Vehicles</h1>
    <p class="page-subtitle">{{ $searchParams['pickup_city'] }} → {{ $searchParams['dropoff_city'] }}</p>
</div>

<div class="mb-6">
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
            <div>
                <div class="text-gray-600">Pickup</div>
                <div class="font-medium">{{ \Carbon\Carbon::parse($searchParams['start_date'])->format('d M Y') }}</div>
                <div class="font-medium">{{ $searchParams['start_time'] }}</div>
            </div>
            <div>
                <div class="text-gray-600">Drop-off</div>
                <div class="font-medium">{{ \Carbon\Carbon::parse($searchParams['end_date'])->format('d M Y') }}</div>
                <div class="font-medium">{{ $searchParams['end_time'] }}</div>
            </div>
            <div>
                <div class="text-gray-600">Duration</div>
                <div class="font-medium">{{ $days }} day(s)</div>
                <div class="font-medium">{{ $hours }} hour(s)</div>
            </div>
            <div>
                <div class="text-gray-600">Rental Type</div>
                <div class="font-medium">{{ ucfirst($searchParams['rental_type']) }}</div>
            </div>
        </div>
    </div>
</div>

<!-- Results Summary -->
<div class="mb-6 flex items-center justify-between">
    <div class="text-sm text-gray-600">
        Found <span class="font-bold text-gray-900">{{ $availableArmadas->count() }}</span> vehicles
        @if(request()->has('compare'))
        <span class="ml-2 text-gray-500">| <span id="compare-count">0</span> selected for comparison</span>
        @endif
    </div>
    <div class="flex gap-2">
        <select class="px-3 py-2 border border-gray-200 rounded-lg text-sm" onchange="sortResults(this.value)">
            <option value="price-asc">Price: Low to High</option>
            <option value="price-desc">Price: High to Low</option>
            <option value="rating-desc">Rating: High to Low</option>
            <option value="rating-asc">Rating: Low to High</option>
        </select>
        @if($availableArmadas->count() > 1)
        <button type="button" class="px-3 py-2 border border-gray-200 rounded-lg text-sm bg-blue-50 text-blue-700 hover:bg-blue-100" onclick="toggleCompareMode()">
            Compare
        </button>
        @endif
    </div>
</div>

<!-- Compare Modal -->
<div id="compare-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 overflow-y-auto">
    <div class="min-h-screen px-4 py-8 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-xl max-w-6xl w-full">
            <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-2xl font-bold">Compare Vehicles</h2>
                <button type="button" onclick="closeCompareModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="p-6">
                <div id="compare-content" class="grid grid-cols-2 md:grid-cols-3 gap-6">
                    <!-- Comparison content will be injected here -->
                </div>
            </div>
            <div class="p-6 border-t border-gray-200 flex justify-end gap-3">
                <button type="button" onclick="closeCompareModal()" class="btn btn-secondary">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Compare Button (hidden by default) -->
<div id="compare-bar" class="hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-4 shadow-lg z-50">
    <div class="max-w-6xl mx-auto flex items-center justify-between">
        <div class="text-sm">
            <span class="font-medium" id="selected-count">0</span> vehicles selected
        </div>
        <button type="button" class="btn btn-primary" onclick="showCompareModal()">
            Compare Selected
        </button>
    </div>
</div>

@if ($availableArmadas->count() > 0)
    <div class="space-y-4">
        @foreach ($availableArmadas as $armada)
        <div class="card" data-armada-id="{{ $armada->id }}" data-price="{{ $totalPrice }}" data-rating="{{ $armada->hasReviews() ? $armada->getAverageRating() : 0 }}">
            <div class="flex flex-col md:flex-row gap-6">
                <div class="md:w-1/3">
                    <div class="bg-gray-100 rounded-lg h-48 flex items-center justify-center relative">
                        <span class="text-4xl">🚗</span>
                        <label class="absolute top-2 right-2">
                            <input type="checkbox" class="compare-checkbox hidden" value="{{ $armada->id }}" onchange="updateCompareSelection()">
                            <div class="w-8 h-8 bg-white rounded-full border-2 border-gray-300 flex items-center justify-center cursor-pointer hover:border-blue-500 compare-checkbox-btn">
                                <svg class="w-4 h-4 text-blue-600 hidden check-icon" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </label>
                    </div>
                </div>
                <div class="md:w-2/3">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-xl font-bold">{{ $armada->vehicle_name ?? 'Vehicle' }}</h3>
                            <p class="text-gray-600">{{ $armada->plate_number }}</p>
                            @if ($vehicleType)
                            <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded mt-2">
                                {{ $vehicleType->name }} ({{ $vehicleType->capacity }} seats)
                            </span>
                            @endif
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-bold text-blue-600">Rp {{ number_format($totalPrice, 0, ',', '.') }}</div>
                            <div class="text-sm text-gray-600">for {{ $days }} day(s)</div>
                        </div>
                    </div>

                    <!-- Provider Info -->
                    @if ($armada->mitra)
                    <div class="bg-gray-50 rounded-lg p-3 mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-blue-600 font-bold">{{ substr($armada->mitra->name, 0, 1) }}</span>
                            </div>
                            <div class="flex-1">
                                <div class="font-medium text-gray-900">{{ $armada->mitra->name }}</div>
                                <div class="text-sm text-gray-600">Provider</div>
                            </div>
                            @if ($armada->mitra->is_active)
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-800">
                                Active
                            </span>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Rating & Reviews -->
                    @if ($armada->hasReviews())
                    <div class="bg-yellow-50 rounded-lg p-3 mb-4">
                        <div class="flex items-center gap-2">
                            <div class="flex items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    @if ($i <= floor($armada->getAverageRating()))
                                        <span class="text-yellow-500">★</span>
                                    @else
                                        <span class="text-gray-300">★</span>
                                    @endif
                                @endfor
                            </div>
                            <span class="font-medium text-gray-900">{{ number_format($armada->getAverageRating(), 1) }}</span>
                            <span class="text-sm text-gray-600">({{ $armada->getReviewCount() }} reviews)</span>
                        </div>
                    </div>
                    @else
                    <div class="bg-gray-100 rounded-lg p-3 mb-4">
                        <div class="text-sm text-gray-600">
                            No reviews yet
                        </div>
                    </div>
                    @endif

                    <!-- Vehicle Details -->
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mb-4 text-sm">
                        <div class="bg-blue-50 rounded-lg p-2">
                            <div class="text-gray-600 text-xs">Vehicle Type</div>
                            <div class="font-medium">{{ $armada->vehicle_type ?? 'Standard' }}</div>
                        </div>
                        <div class="bg-blue-50 rounded-lg p-2">
                            <div class="text-gray-600 text-xs">Seat Capacity</div>
                            <div class="font-medium">{{ $armada->seat_capacity ?? 'N/A' }} seats</div>
                        </div>
                        <div class="bg-blue-50 rounded-lg p-2">
                            <div class="text-gray-600 text-xs">Status</div>
                            <div class="font-medium capitalize">{{ $armada->status }}</div>
                        </div>
                    </div>

                    <!-- Price Breakdown -->
                    <div class="grid grid-cols-2 gap-4 mb-4 text-sm border-t border-gray-200 pt-4">
                        <div>
                            <span class="text-gray-600">Base Price:</span>
                            <span class="font-medium">Rp {{ number_format($basePrice, 0, ',', '.') }}/day</span>
                        </div>
                        @if ($driverFee > 0)
                        <div>
                            <span class="text-gray-600">Driver Fee:</span>
                            <span class="font-medium">Rp {{ number_format($driverFee, 0, ',', '.') }}</span>
                        </div>
                        @endif
                    </div>

                    <div class="flex gap-3">
                        <a href="{{ route('bookings.rental.create') }}?{{ http_build_query(array_merge($searchParams, ['armada_id' => $armada->id, 'total_price' => $totalPrice])) }}" class="btn btn-primary flex-1 text-center">Book This Vehicle</a>
                        <a href="{{ route('bookings.rental.search') }}" class="btn btn-secondary">Back to Search</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@else
    <div class="card text-center py-12">
        <div class="text-4xl mb-4">🚗</div>
        <h3 class="text-xl font-bold mb-2">No Vehicles Available</h3>
        <p class="text-gray-600 mb-6">Sorry, no vehicles are available for your selected dates and location.</p>
        <a href="{{ route('bookings.rental.search') }}" class="btn btn-primary">Try Different Dates</a>
    </div>
@endif

<script>
let compareMode = false;
let selectedArmadas = new Set();
let armadaData = {};

// Store armada data for comparison
@foreach ($availableArmadas as $armada)
armadaData[{{ $armada->id }}] = {
    id: {{ $armada->id }},
    name: '{{ $armada->vehicle_name ?? 'Vehicle' }}',
    plate: '{{ $armada->plate_number }}',
    type: '{{ $armada->vehicle_type ?? 'Standard' }}',
    capacity: {{ $armada->seat_capacity ?? 'N/A' }},
    status: '{{ $armada->status }}',
    price: {{ $totalPrice }},
    rating: {{ $armada->hasReviews() ? $armada->getAverageRating() : 0 }},
    reviewCount: {{ $armada->getReviewCount() }},
    mitra: @if($armada->mitra) {
        name: '{{ $armada->mitra->name }}',
        active: {{ $armada->mitra->is_active ? 'true' : 'false' }}
    } @else null @endif
};
@endforeach

function toggleCompareMode() {
    compareMode = !compareMode;
    const checkboxes = document.querySelectorAll('.compare-checkbox');
    const checkboxBtns = document.querySelectorAll('.compare-checkbox-btn');
    
    checkboxes.forEach(cb => {
        cb.disabled = !compareMode;
    });
    
    checkboxBtns.forEach(btn => {
        btn.style.display = compareMode ? 'flex' : 'none';
    });
    
    if (!compareMode) {
        selectedArmadas.clear();
        checkboxes.forEach(cb => cb.checked = false);
        updateCompareSelection();
    }
}

function updateCompareSelection() {
    const checkboxes = document.querySelectorAll('.compare-checkbox:checked');
    selectedArmadas.clear();
    checkboxes.forEach(cb => selectedArmadas.add(cb.value));
    
    const count = selectedArmadas.size;
    document.getElementById('selected-count').textContent = count;
    
    const compareBar = document.getElementById('compare-bar');
    if (count > 0) {
        compareBar.classList.remove('hidden');
    } else {
        compareBar.classList.add('hidden');
    }
}

function showCompareModal() {
    if (selectedArmadas.size < 2) {
        alert('Please select at least 2 vehicles to compare');
        return;
    }
    
    const compareContent = document.getElementById('compare-content');
    compareContent.innerHTML = '';
    
    selectedArmadas.forEach(id => {
        const armada = armadaData[id];
        if (!armada) return;
        
        const card = document.createElement('div');
        card.className = 'border border-gray-200 rounded-lg p-4';
        card.innerHTML = `
            <div class="mb-4">
                <div class="bg-gray-100 rounded-lg h-32 flex items-center justify-center mb-3">
                    <span class="text-3xl">🚗</span>
                </div>
                <h3 class="font-bold text-lg">${armada.name}</h3>
                <p class="text-sm text-gray-600">${armada.plate}</p>
            </div>
            
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">Price:</span>
                    <span class="font-medium">Rp ${armada.price.toLocaleString('id-ID')}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Rating:</span>
                    <span class="font-medium">${armada.rating.toFixed(1)} (${armada.reviewCount} reviews)</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Type:</span>
                    <span class="font-medium">${armada.type}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Capacity:</span>
                    <span class="font-medium">${armada.capacity} seats</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Status:</span>
                    <span class="font-medium capitalize">${armada.status}</span>
                </div>
                ${armada.mitra ? `
                <div class="flex justify-between">
                    <span class="text-gray-600">Provider:</span>
                    <span class="font-medium">${armada.mitra.name}</span>
                </div>
                ` : ''}
            </div>
            
            <a href="{{ route('bookings.rental.create') }}?{{ http_build_query($searchParams) }}&armada_id=${armada.id}&total_price=${armada.price}" class="btn btn-primary w-full mt-4 text-center">
                Book This Vehicle
            </a>
        `;
        compareContent.appendChild(card);
    });
    
    document.getElementById('compare-modal').classList.remove('hidden');
}

function closeCompareModal() {
    document.getElementById('compare-modal').classList.add('hidden');
}

function sortResults(sortBy) {
    const resultsContainer = document.querySelector('.space-y-4');
    const results = Array.from(resultsContainer.children);
    
    results.sort((a, b) => {
        const aPrice = parseFloat(a.dataset.price);
        const bPrice = parseFloat(b.dataset.price);
        const aRating = parseFloat(a.dataset.rating);
        const bRating = parseFloat(b.dataset.rating);
        
        switch(sortBy) {
            case 'price-asc':
                return aPrice - bPrice;
            case 'price-desc':
                return bPrice - aPrice;
            case 'rating-desc':
                return bRating - aRating;
            case 'rating-asc':
                return aRating - bRating;
            default:
                return 0;
        }
    });
    
    results.forEach(result => resultsContainer.appendChild(result));
}

// Initialize
document.querySelectorAll('.compare-checkbox-btn').forEach(btn => {
    btn.style.display = 'none';
});
</script>
@endsection