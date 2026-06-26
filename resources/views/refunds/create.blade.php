@extends('layouts.app')

@section('title', 'Request Refund')

@section('content')
<div class="max-w-2xl mx-auto py-8 px-4">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Request a Refund</h1>
        <p class="text-gray-600">Submit a refund request for your booking</p>
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

        <!-- Refund Summary -->
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6">
            <h3 class="font-semibold text-gray-900 mb-3">Refund Summary</h3>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">Booking ID</span>
                    <span class="font-medium">{{ $bookingModel->booking_code ?? $bookingModel->id }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Booking Type</span>
                    <span class="font-medium capitalize">{{ $bookingType }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Refund Amount</span>
                    <span class="font-bold text-lg text-[#0064d2]">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <form action="{{ route('bookings.refund.store', $bookingModel) }}" method="POST" class="space-y-6">
            @csrf

            <!-- Reason -->
            <div>
                <label for="reason" class="block text-gray-700 font-medium mb-2">Reason for Refund</label>
                <textarea name="reason" id="reason" rows="4" required
                          class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0064d2] transition-colors resize-none @error('reason') border-red-500 @enderror"
                          placeholder="Please explain why you are requesting a refund...">{{ old('reason') }}</textarea>
                @error('reason') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Notice -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <p class="text-sm text-yellow-800">
                    <strong>Note:</strong> Refund requests will be reviewed by our admin team. Processing may take 3-5 business days.
                </p>
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 pt-4 border-t border-gray-200">
                <button type="submit" class="flex-1 bg-red-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-red-700 transition-colors">
                    Submit Refund Request
                </button>
                <a href="{{ url()->previous() }}" class="flex-1 bg-gray-100 text-gray-700 py-3 px-6 rounded-lg font-semibold hover:bg-gray-200 transition-colors text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
