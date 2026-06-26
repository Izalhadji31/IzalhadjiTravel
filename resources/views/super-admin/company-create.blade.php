@extends('layouts.app')

@section('title', 'Create Company')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<style>
    :root {
        --trvl-blue: #0064d2;
        --trvl-navy: #0a1628;
        --trvl-orange: #ff6b00;
    }
</style>

<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('super-admin.companies') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h1 class="text-3xl font-bold" style="color: var(--trvl-navy);">Create New Company</h1>
        </div>
        <p class="text-gray-500">Add a new company to the platform</p>
    </div>

    <div class="card">
        <form method="POST" action="{{ route('super-admin.companies.store') }}">
            @csrf

            <!-- Name & Slug -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Company Name <span class="text-red-500">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:outline-none"
                        style="focus:ring-color: var(--trvl-blue); focus:border-color: var(--trvl-blue);"
                        required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">Slug <span class="text-red-500">*</span></label>
                    <input type="text" id="slug" name="slug" value="{{ old('slug') }}"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:outline-none"
                        style="focus:ring-color: var(--trvl-blue);"
                        placeholder="e.g. my-company"
                        required>
                    @error('slug')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Email & Phone -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:outline-none"
                        style="focus:ring-color: var(--trvl-blue);"
                        required>
                    @error('email')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:outline-none"
                        style="focus:ring-color: var(--trvl-blue);">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Address -->
            <div class="mb-6">
                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                <textarea id="address" name="address" rows="3"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:outline-none"
                    style="focus:ring-color: var(--trvl-blue);">{{ old('address') }}</textarea>
                @error('address')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- City & Province -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700 mb-2">City</label>
                    <input type="text" id="city" name="city" value="{{ old('city') }}"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:outline-none"
                        style="focus:ring-color: var(--trvl-blue);">
                </div>
                <div>
                    <label for="province" class="block text-sm font-medium text-gray-700 mb-2">Province</label>
                    <input type="text" id="province" name="province" value="{{ old('province') }}"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:outline-none"
                        style="focus:ring-color: var(--trvl-blue);">
                </div>
            </div>

            <!-- Subscription & Limits -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div>
                    <label for="subscription_plan" class="block text-sm font-medium text-gray-700 mb-2">Subscription Plan <span class="text-red-500">*</span></label>
                    <select id="subscription_plan" name="subscription_plan"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:outline-none"
                        style="focus:ring-color: var(--trvl-blue);"
                        required>
                        <option value="starter" {{ old('subscription_plan') === 'starter' ? 'selected' : '' }}>Starter</option>
                        <option value="professional" {{ old('subscription_plan') === 'professional' ? 'selected' : '' }}>Professional</option>
                        <option value="enterprise" {{ old('subscription_plan') === 'enterprise' ? 'selected' : '' }}>Enterprise</option>
                    </select>
                    @error('subscription_plan')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="max_users" class="block text-sm font-medium text-gray-700 mb-2">Max Users <span class="text-red-500">*</span></label>
                    <input type="number" id="max_users" name="max_users" value="{{ old('max_users', 10) }}" min="1"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:outline-none"
                        style="focus:ring-color: var(--trvl-blue);"
                        required>
                    @error('max_users')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="max_vehicles" class="block text-sm font-medium text-gray-700 mb-2">Max Vehicles <span class="text-red-500">*</span></label>
                    <input type="number" id="max_vehicles" name="max_vehicles" value="{{ old('max_vehicles', 5) }}" min="1"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:outline-none"
                        style="focus:ring-color: var(--trvl-blue);"
                        required>
                    @error('max_vehicles')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit -->
            <div class="flex items-center gap-4 pt-4 border-t border-gray-200">
                <button type="submit" class="btn text-white px-6 py-2.5 rounded-lg" style="background: var(--trvl-blue);">
                    Create Company
                </button>
                <a href="{{ route('super-admin.companies') }}" class="btn btn-secondary px-6 py-2.5 rounded-lg">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
