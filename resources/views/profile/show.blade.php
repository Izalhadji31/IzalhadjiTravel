@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">My Profile</h1>
        <p class="text-gray-600">View and manage your account information</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Card -->
        <div class="lg:col-span-1">
            <div class="card text-center">
                @if(auth()->user()->photo)
                    <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="{{ auth()->user()->name }}" class="w-24 h-24 rounded-full mx-auto mb-4 object-cover border-4 border-blue-100">
                @else
                <div class="w-24 h-24 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-white font-bold text-4xl">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}{{ strtoupper(substr(explode(' ', auth()->user()->name ?? 'User')[1] ?? '', 0, 1)) }}</span>
                </div>
                @endif
                <h3 class="text-2xl font-bold text-gray-900">{{ auth()->user()->name ?? 'User' }}</h3>
                <p class="text-gray-600 mt-1">{{ auth()->user()->role ?? 'Customer' }}</p>
                <p class="text-blue-600 font-medium mt-2">{{ auth()->user()->email ?? 'N/A' }}</p>
                
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="grid grid-cols-3 gap-4 text-center mb-6">
                        <div>
                            <p class="text-2xl font-bold text-blue-600">{{ auth()->user()->travelBookings()->count() ?? 0 }}</p>
                            <p class="text-xs text-gray-600 mt-1">Travel Books</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-green-600">{{ auth()->user()->rentalBookings()->count() ?? 0 }}</p>
                            <p class="text-xs text-gray-600 mt-1">Rentals</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-purple-600">4.8</p>
                            <p class="text-xs text-gray-600 mt-1">Rating</p>
                        </div>
                    </div>
                </div>

                <div class="flex gap-2 mt-6">
                    <a href="{{ route('profile.edit') }}" class="flex-1 btn-primary text-sm">Edit Profile</a>
                    <button class="flex-1 btn-secondary text-sm">Download</button>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="card mt-6">
                <h4 class="font-semibold text-gray-900 mb-4">Account Status</h4>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 text-sm">Profile Completion</span>
                        <div class="w-20 bg-gray-200 rounded-full h-2">
                            <div class="bg-green-600 h-2 rounded-full" style="width: 85%"></div>
                        </div>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 text-sm">Verification</span>
                        <span class="text-xs font-medium text-green-600">Verified ✓</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 text-sm">Account Since</span>
                        <span class="text-xs font-medium text-gray-900">{{ auth()->user()->created_at?->format('M Y') ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Account Information -->
        <div class="lg:col-span-2">
            <div class="card mb-6">
                <h3 class="card-header">Account Information</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-gray-600 text-sm font-medium">Full Name</label>
                        <p class="text-gray-900 font-medium mt-1">{{ auth()->user()->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-gray-600 text-sm font-medium">Email Address</label>
                        <p class="text-gray-900 font-medium mt-1">{{ auth()->user()->email ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-gray-600 text-sm font-medium">Phone Number</label>
                        <p class="text-gray-900 font-medium mt-1">{{ auth()->user()->phone ?? 'Not set' }}</p>
                    </div>
                    <div>
                        <label class="text-gray-600 text-sm font-medium">Account Type</label>
                        <p class="text-gray-900 font-medium mt-1">{{ ucfirst(auth()->user()->role ?? 'customer') }}</p>
                    </div>
                    <div>
                        <label class="text-gray-600 text-sm font-medium">Identification</label>
                        <p class="text-gray-900 font-medium mt-1">{{ auth()->user()->identity_number ?? 'Not set' }}</p>
                    </div>
                    <div>
                        <label class="text-gray-600 text-sm font-medium">Member Since</label>
                        <p class="text-gray-900 font-medium mt-1">{{ auth()->user()->created_at?->format('M d, Y') ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <h3 class="card-header">Security Settings</h3>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center pb-4 border-b border-gray-200">
                        <div>
                            <p class="font-semibold text-gray-900">Two-Factor Authentication</p>
                            <p class="text-sm text-gray-600">Add extra security to your account</p>
                        </div>
                        <button class="btn-secondary text-sm">Enable</button>
                    </div>
                    <div class="flex justify-between items-center pb-4 border-b border-gray-200">
                        <div>
                            <p class="font-semibold text-gray-900">Change Password</p>
                            <p class="text-sm text-gray-600">Update your password regularly</p>
                        </div>
                        <a href="{{ route('password.request') }}" class="btn-secondary text-sm">Change</a>
                    </div>
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="font-semibold text-gray-900">Session Management</p>
                            <p class="text-sm text-gray-600">View and manage active sessions</p>
                        </div>
                        <button class="btn-secondary text-sm">View Sessions</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
                </div>
            </div>
        </div>
    </div>
@endsection
