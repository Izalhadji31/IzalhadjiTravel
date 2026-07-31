@extends('layouts.app')

@section('title', 'Add New Partner')

@section('content')
    <!-- Page Header -->
    <div class="page-header mb-8">
        <h1 class="page-title">Add New Partner</h1>
        <p class="page-subtitle">Register a new business partner.</p>
    </div>

    <div class="max-w-2xl">
        <div class="card">
            <!-- Form Header -->
            <div class="flex items-center space-x-3 mb-6 pb-4 border-b border-gray-200">
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3.414a2 2 0 01-2-2V7.414a2 2 0 012-2H9.586a2 2 0 012 2v11.172a2 2 0 01-.586 1.414L15 21z"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-gray-900">Partner Information</h2>
            </div>

            <!-- Form -->
            <form class="space-y-6">
                @csrf
                
                <!-- Partner Name -->
                <div class="form-group">
                    <label for="name" class="form-label">Partner Name</label>
                    <input 
                        type="text" 
                        id="name"
                        name="name"
                        placeholder="e.g., ABC Transport Company" 
                        class="form-input"
                        required
                    >
                </div>

                <!-- Contact Person -->
                <div class="form-group">
                    <label for="contact_person" class="form-label">Contact Person</label>
                    <input 
                        type="text" 
                        id="contact_person"
                        name="contact_person"
                        placeholder="e.g., John Manager" 
                        class="form-input"
                        required
                    >
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input 
                        type="email" 
                        id="email"
                        name="email"
                        placeholder="e.g., partner@example.com" 
                        class="form-input"
                        required
                    >
                </div>

                <!-- Phone -->
                <div class="form-group">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input 
                        type="tel" 
                        id="phone"
                        name="phone"
                        placeholder="e.g., +62 812-3456-7890" 
                        class="form-input"
                        required
                    >
                </div>

                <!-- Commission Rate -->
                <div class="form-group">
                    <label for="commission_rate" class="form-label">Commission Rate (%)</label>
                    <div class="relative">
                        <input 
                            type="number" 
                            id="commission_rate"
                            name="commission_rate"
                            placeholder="e.g., 15" 
                            class="form-input"
                            min="0"
                            max="100"
                            step="0.1"
                            required
                        >
                        <span class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-500">%</span>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex gap-3 pt-6 border-t border-gray-200">
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add Partner
                    </button>
                    <a href="{{ route('partners.index') }}" class="btn-secondary">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
