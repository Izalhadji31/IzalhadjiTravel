@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">Edit Profile</h1>
        <p class="text-gray-600">Update your account information</p>
    </div>

    <div class="max-w-2xl">
        <div class="card">
            <h3 class="card-header">Personal Information</h3>
            
            <form class="space-y-6">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-gray-700 font-medium">First Name</label>
                        <input type="text" value="John" class="w-full mt-2 px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600">
                    </div>
                    <div>
                        <label class="text-gray-700 font-medium">Last Name</label>
                        <input type="text" value="Doe" class="w-full mt-2 px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600">
                    </div>
                </div>

                <div>
                    <label class="text-gray-700 font-medium">Email Address</label>
                    <input type="email" value="john.doe@asrgo.com" class="w-full mt-2 px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600">
                </div>

                <div>
                    <label class="text-gray-700 font-medium">Phone Number</label>
                    <input type="tel" value="+62 812-3456-7890" class="w-full mt-2 px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600">
                </div>

                <div>
                    <label class="text-gray-700 font-medium">Address</label>
                    <input type="text" placeholder="Enter your address" class="w-full mt-2 px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-gray-700 font-medium">City</label>
                        <input type="text" value="Jakarta" class="w-full mt-2 px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600">
                    </div>
                    <div>
                        <label class="text-gray-700 font-medium">Country</label>
                        <input type="text" value="Indonesia" class="w-full mt-2 px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600">
                    </div>
                </div>

                <div class="flex gap-3 pt-6 border-t border-gray-200">
                    <button type="submit" class="btn-primary">Save Changes</button>
                    <a href="{{ route('profile.show') }}" class="btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
