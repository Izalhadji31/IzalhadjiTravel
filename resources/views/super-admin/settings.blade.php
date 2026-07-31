@extends('layouts.app')

@section('title', 'Super Admin Settings')

@section('content')
<div class="page-header">
    <h1 class="page-title">Super Admin Settings</h1>
    <p class="page-subtitle">Global platform settings</p>
</div>

<div class="card">
    <form method="POST" action="{{ route('super-admin.settings.update') }}">
        @csrf
        <div class="space-y-6">
            <div>
                <h3 class="text-lg font-bold mb-4">Revenue Sharing Settings</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Admin Percentage (%)</label>
                        <input type="number" name="admin_percentage" value="30" class="w-full border rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Mitra Percentage (%)</label>
                        <input type="number" name="mitra_percentage" value="50" class="w-full border rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Driver Percentage (%)</label>
                        <input type="number" name="driver_percentage" value="20" class="w-full border rounded px-3 py-2">
                    </div>
                </div>
            </div>
            <div>
                <h3 class="text-lg font-bold mb-4">Platform Settings</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Platform Name</label>
                        <input type="text" name="platform_name" value="ASR GO" class="w-full border rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Support Email</label>
                        <input type="email" name="support_email" value="support@asrgo.com" class="w-full border rounded px-3 py-2">
                    </div>
                </div>
            </div>
            <div>
                <h3 class="text-lg font-bold mb-4">Subscription Settings</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Starter Monthly Fee</label>
                        <input type="number" name="starter_fee" value="200000" class="w-full border rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Professional Monthly Fee</label>
                        <input type="number" name="professional_fee" value="500000" class="w-full border rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Enterprise Monthly Fee</label>
                        <input type="number" name="enterprise_fee" value="1000000" class="w-full border rounded px-3 py-2">
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-6">
            <button type="submit" class="btn btn-primary">Save Settings</button>
        </div>
    </form>
</div>
@endsection