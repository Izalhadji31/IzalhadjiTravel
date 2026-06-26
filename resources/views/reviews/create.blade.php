@extends('layouts.app')

@section('title', 'Write a Review')

@section('content')
<div class="max-w-2xl mx-auto py-8 px-4">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Write a Review</h1>
        <p class="text-gray-600">Share your experience for booking #{{ $booking->booking_code ?? $booking->id }}</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded">
                <p class="text-red-700 font-semibold mb-2">Please fix the errors:</p>
                <ul class="text-red-600 text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('bookings.review.store', $booking) }}" method="POST" class="space-y-6">
            @csrf

            <!-- Star Rating -->
            <div>
                <label class="block text-gray-700 font-medium mb-3">Your Rating</label>
                <div class="flex items-center gap-2" id="starRating">
                    @for ($i = 1; $i <= 5; $i++)
                        <button type="button" class="star-btn text-4xl transition-transform hover:scale-110 focus:outline-none" data-value="{{ $i }}">
                            <span class="text-gray-300 hover:text-yellow-400 star-icon" data-star="{{ $i }}">&#9733;</span>
                        </button>
                    @endfor
                </div>
                <input type="hidden" name="rating" id="ratingInput" value="{{ old('rating') }}" required>
                <p class="text-sm text-gray-500 mt-2" id="ratingText">Select a rating</p>
                @error('rating') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Comment -->
            <div>
                <label for="comment" class="block text-gray-700 font-medium mb-2">Your Comment (Optional)</label>
                <textarea name="comment" id="comment" rows="4" 
                          class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0064d2] transition-colors resize-none @error('comment') border-red-500 @enderror"
                          placeholder="Tell us about your experience...">{{ old('comment') }}</textarea>
                @error('comment') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Booking Info -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <p class="text-sm text-gray-700">
                    <strong>Booking:</strong> {{ $booking->booking_code ?? $booking->id }}<br>
                    <strong>Date:</strong> {{ $booking->created_at->format('d M Y') }}
                </p>
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 pt-4 border-t border-gray-200">
                <button type="submit" class="flex-1 bg-[#0064d2] text-white py-3 px-6 rounded-lg font-semibold hover:bg-[#0050a8] transition-colors">
                    Submit Review
                </button>
                <a href="{{ url()->previous() }}" class="flex-1 bg-gray-100 text-gray-700 py-3 px-6 rounded-lg font-semibold hover:bg-gray-200 transition-colors text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.star-icon');
    const input = document.getElementById('ratingInput');
    const text = document.getElementById('ratingText');
    const ratingLabels = ['', 'Poor', 'Fair', 'Good', 'Very Good', 'Excellent'];

    stars.forEach(function(star) {
        star.addEventListener('click', function() {
            const value = this.getAttribute('data-star');
            input.value = value;
            text.textContent = ratingLabels[value];
            updateStars(value);
        });

        star.addEventListener('mouseenter', function() {
            const value = this.getAttribute('data-star');
            highlightStars(value);
        });
    });

    document.getElementById('starRating').addEventListener('mouseleave', function() {
        const current = input.value || 0;
        updateStars(current);
    });

    function updateStars(value) {
        stars.forEach(function(s) {
            const starVal = s.getAttribute('data-star');
            if (starVal <= value) {
                s.classList.remove('text-gray-300');
                s.classList.add('text-yellow-400');
            } else {
                s.classList.remove('text-yellow-400');
                s.classList.add('text-gray-300');
            }
        });
    }

    function highlightStars(value) {
        stars.forEach(function(s) {
            const starVal = s.getAttribute('data-star');
            if (starVal <= value) {
                s.classList.remove('text-gray-300');
                s.classList.add('text-yellow-400');
            } else {
                s.classList.remove('text-yellow-400');
                s.classList.add('text-gray-300');
            }
        });
    }

    // Pre-fill if old value exists
    @if(old('rating'))
        updateStars({{ old('rating') }});
        text.textContent = ratingLabels[{{ old('rating') }}];
    @endif
});
</script>
@endsection
