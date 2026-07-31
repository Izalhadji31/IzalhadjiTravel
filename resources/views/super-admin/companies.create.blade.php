@extends('layouts.app')

@section('title', 'Create Company')

@section('content')
<div class="page-header">
    <h1 class="page-title">Create New Company</h1>
    <p class="page-subtitle">Add a new SaaS company</p>
</div>

<div class="card">
    <form method="POST" action="{{ route('super-admin.companies.store') }}">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium mb-2">Company Name</label>
                <input type="text" name="name" required class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">Slug</label>
                <input type="text" name="slug" required class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">Email</label>
                <input type="email" name="email" required class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">Phone</label>
                <input type="text" name="phone" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">Address</label>
                <input type="text" name="address" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">City</label>
                <input type="text" name="city" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">Province</label>
                <input type="text" name="province" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">Subscription Plan</label>
                <select name="subscription_plan" required class="w-full border rounded px-3 py-2">
                    <option value="starter">Starter</option>
                    <option value="professional">Professional</option>
                    <option value="enterprise">Enterprise</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">Max Users</label>
                <input type="number" name="max_users" required min="1" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">Max Vehicles</label>
                <input type="number" name="max_vehicles" required min="1" class="w-full border rounded px-3 py-2">
            </div>
        </div>
        <div class="mt-6">
            <button type="submit" class="btn btn-primary">Create Company</button>
            <a href="{{ route('super-admin.companies') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection