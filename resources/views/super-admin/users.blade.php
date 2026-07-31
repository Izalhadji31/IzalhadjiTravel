@extends('layouts.app')

@section('title', 'All Users')

@section('content')
<div class="page-header">
    <h1 class="page-title">All Users</h1>
    <p class="page-subtitle">Global user management</p>
</div>

<div class="card">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b">
                    <th class="text-left py-3 px-4">Name</th>
                    <th class="text-left py-3 px-4">Email</th>
                    <th class="text-left py-3 px-4">Role</th>
                    <th class="text-left py-3 px-4">Company</th>
                    <th class="text-left py-3 px-4">Status</th>
                    <th class="text-left py-3 px-4">Created</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr class="border-b">
                    <td class="py-3 px-4 font-medium">{{ $user->name }}</td>
                    <td class="py-3 px-4">{{ $user->email }}</td>
                    <td class="py-3 px-4">
                        <span class="px-2 py-1 rounded text-xs bg-blue-100 text-blue-800">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td class="py-3 px-4">{{ $user->company ? $user->company->name : '-' }}</td>
                    <td class="py-3 px-4">
                        @if($user->is_active)
                            <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-800">Active</span>
                        @else
                            <span class="px-2 py-1 rounded text-xs bg-red-100 text-red-800">Inactive</span>
                        @endif
                    </td>
                    <td class="py-3 px-4">{{ $user->created_at->format('d M Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $users->links() }}
</div>
@endsection