@extends('layouts.app')

@section('title', 'Manage Users')

@section('content')
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">User Management</h1>
        <p class="text-gray-600">Manage system users and permissions</p>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8 border border-blue-100">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <input type="text" placeholder="Search users..." class="px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600">
            <select class="px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600">
                <option>All Roles</option>
                <option>Admin</option>
                <option>Manager</option>
                <option>User</option>
            </select>
            <select class="px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600">
                <option>All Status</option>
                <option>Active</option>
                <option>Inactive</option>
            </select>
            <button class="btn-primary">Search</button>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card overflow-hidden">
        <div class="card-header">User Directory</div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Name</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Email</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Role</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Joined</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 1; $i <= 8; $i++)
                    <tr class="border-b border-gray-100 hover:bg-blue-50">
                        <td class="px-6 py-3 font-semibold text-gray-900">User {{ $i }}</td>
                        <td class="px-6 py-3 text-gray-700">user{{ $i }}@asrgo.com</td>
                        <td class="px-6 py-3">
                            @if ($i == 1)
                                <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-semibold">Admin</span>
                            @elseif ($i == 2)
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-semibold">Manager</span>
                            @else
                                <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-xs font-semibold">User</span>
                            @endif
                        </td>
                        <td class="px-6 py-3">
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">Active</span>
                        </td>
                        <td class="px-6 py-3 text-gray-700">Jan {{ $i }}, 2026</td>
                        <td class="px-6 py-3">
                            <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Edit</a>
                            <span class="mx-2 text-gray-300">|</span>
                            <a href="#" class="text-red-600 hover:text-red-800 text-sm font-medium">Delete</a>
                        </td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
@endsection
