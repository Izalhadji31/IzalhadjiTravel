@extends('layouts.app')

@section('title', 'System Settings')

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
        <h1 class="text-3xl font-bold" style="color: var(--trvl-navy);">System Settings</h1>
        <p class="text-gray-500 mt-1">Global platform configuration</p>
    </div>

    <form method="POST" action="{{ route('super-admin.settings.update') }}">
        @csrf
        @method('PUT')

        <!-- General Settings -->
        <div class="card mb-6">
            <h3 class="text-lg font-semibold mb-4" style="color: var(--trvl-navy);">General Settings</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="platform_name" class="block text-sm font-medium text-gray-700 mb-2">Platform Name</label>
                    <input type="text" id="platform_name" name="platform_name"
                        value="{{ old('platform_name', config('app.name', 'ASR GO')) }}"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:outline-none"
                        style="focus:ring-color: var(--trvl-blue);">
                </div>
                <div>
                    <label for="support_email" class="block text-sm font-medium text-gray-700 mb-2">Support Email</label>
                    <input type="email" id="support_email" name="support_email"
                        value="{{ old('support_email', config('mail.from.address', 'support@asrgo.id')) }}"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:outline-none"
                        style="focus:ring-color: var(--trvl-blue);">
                </div>
                <div>
                    <label for="default_timezone" class="block text-sm font-medium text-gray-700 mb-2">Default Timezone</label>
                    <select id="default_timezone" name="default_timezone"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:outline-none">
                        <option value="Asia/Jakarta" {{ old('default_timezone', 'Asia/Jakarta') === 'Asia/Jakarta' ? 'selected' : '' }}>Asia/Jakarta (WIB)</option>
                        <option value="Asia/Makassar" {{ old('default_timezone') === 'Asia/Makassar' ? 'selected' : '' }}>Asia/Makassar (WITA)</option>
                        <option value="Asia/Jayapura" {{ old('default_timezone') === 'Asia/Jayapura' ? 'selected' : '' }}>Asia/Jayapura (WIT)</option>
                    </select>
                </div>
                <div>
                    <label for="currency" class="block text-sm font-medium text-gray-700 mb-2">Currency</label>
                    <select id="currency" name="currency"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:outline-none">
                        <option value="IDR" {{ old('currency', 'IDR') === 'IDR' ? 'selected' : '' }}>IDR - Indonesian Rupiah</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Commission Settings -->
        <div class="card mb-6">
            <h3 class="text-lg font-semibold mb-4" style="color: var(--trvl-navy);">Commission & Revenue Sharing</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="platform_commission" class="block text-sm font-medium text-gray-700 mb-2">Platform Commission (%)</label>
                    <input type="number" id="platform_commission" name="platform_commission"
                        value="{{ old('platform_commission', 10) }}" min="0" max="100" step="0.1"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:outline-none"
                        style="focus:ring-color: var(--trvl-blue);">
                    <p class="text-xs text-gray-400 mt-1">Percentage taken from each transaction</p>
                </div>
                <div>
                    <label for="mitra_share" class="block text-sm font-medium text-gray-700 mb-2">Default Mitra Share (%)</label>
                    <input type="number" id="mitra_share" name="mitra_share"
                        value="{{ old('mitra_share', 70) }}" min="0" max="100" step="0.1"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:outline-none"
                        style="focus:ring-color: var(--trvl-blue);">
                    <p class="text-xs text-gray-400 mt-1">Default share for mitras from commission pool</p>
                </div>
                <div>
                    <label for="driver_share" class="block text-sm font-medium text-gray-700 mb-2">Default Driver Share (%)</label>
                    <input type="number" id="driver_share" name="driver_share"
                        value="{{ old('driver_share', 30) }}" min="0" max="100" step="0.1"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:outline-none"
                        style="focus:ring-color: var(--trvl-blue);">
                    <p class="text-xs text-gray-400 mt-1">Default share for drivers from commission pool</p>
                </div>
                <div>
                    <label for="late_fee_percentage" class="block text-sm font-medium text-gray-700 mb-2">Late Cancellation Fee (%)</label>
                    <input type="number" id="late_fee_percentage" name="late_fee_percentage"
                        value="{{ old('late_fee_percentage', 15) }}" min="0" max="100" step="0.1"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:outline-none"
                        style="focus:ring-color: var(--trvl-blue);">
                </div>
            </div>
        </div>

        <!-- Subscription Limits -->
        <div class="card mb-6">
            <h3 class="text-lg font-semibold mb-4" style="color: var(--trvl-navy);">Default Subscription Limits</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2" style="color: var(--trvl-blue);">Starter</label>
                    <div class="space-y-3">
                        <div>
                            <label for="starter_max_users" class="block text-xs text-gray-500 mb-1">Max Users</label>
                            <input type="number" id="starter_max_users" name="starter_max_users"
                                value="{{ old('starter_max_users', 5) }}" min="1"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:outline-none">
                        </div>
                        <div>
                            <label for="starter_max_vehicles" class="block text-xs text-gray-500 mb-1">Max Vehicles</label>
                            <input type="number" id="starter_max_vehicles" name="starter_max_vehicles"
                                value="{{ old('starter_max_vehicles', 3) }}" min="1"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:outline-none">
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2" style="color: var(--trvl-orange);">Professional</label>
                    <div class="space-y-3">
                        <div>
                            <label for="pro_max_users" class="block text-xs text-gray-500 mb-1">Max Users</label>
                            <input type="number" id="pro_max_users" name="pro_max_users"
                                value="{{ old('pro_max_users', 25) }}" min="1"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:outline-none">
                        </div>
                        <div>
                            <label for="pro_max_vehicles" class="block text-xs text-gray-500 mb-1">Max Vehicles</label>
                            <input type="number" id="pro_max_vehicles" name="pro_max_vehicles"
                                value="{{ old('pro_max_vehicles', 15) }}" min="1"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:outline-none">
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2 text-purple-600">Enterprise</label>
                    <div class="space-y-3">
                        <div>
                            <label for="ent_max_users" class="block text-xs text-gray-500 mb-1">Max Users</label>
                            <input type="number" id="ent_max_users" name="ent_max_users"
                                value="{{ old('ent_max_users', 100) }}" min="1"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:outline-none">
                        </div>
                        <div>
                            <label for="ent_max_vehicles" class="block text-xs text-gray-500 mb-1">Max Vehicles</label>
                            <input type="number" id="ent_max_vehicles" name="ent_max_vehicles"
                                value="{{ old('ent_max_vehicles', 50) }}" min="1"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:outline-none">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notification Settings -->
        <div class="card mb-6">
            <h3 class="text-lg font-semibold mb-4" style="color: var(--trvl-navy);">Notification Settings</h3>
            <div class="space-y-4">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="email_notifications" value="1"
                        {{ old('email_notifications', true) ? 'checked' : '' }}
                        class="w-4 h-4 rounded border-gray-300"
                        style="accent-color: var(--trvl-blue);">
                    <span class="text-sm text-gray-700">Enable email notifications for all companies</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="sms_notifications" value="1"
                        {{ old('sms_notifications', false) ? 'checked' : '' }}
                        class="w-4 h-4 rounded border-gray-300"
                        style="accent-color: var(--trvl-blue);">
                    <span class="text-sm text-gray-700">Enable SMS notifications</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="auto_suspend_overdue" value="1"
                        {{ old('auto_suspend_overdue', true) ? 'checked' : '' }}
                        class="w-4 h-4 rounded border-gray-300"
                        style="accent-color: var(--trvl-blue);">
                    <span class="text-sm text-gray-700">Auto-suspend companies with overdue payments</span>
                </label>
            </div>
        </div>

        <!-- Maintenance Mode -->
        <div class="card mb-6">
            <h3 class="text-lg font-semibold mb-4" style="color: var(--trvl-navy);">Maintenance</h3>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-700">Maintenance Mode</p>
                    <p class="text-xs text-gray-400">When enabled, only admin users can access the platform</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="maintenance_mode" value="1"
                        {{ old('maintenance_mode', false) ? 'checked' : '' }}
                        class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:ring-2 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                </label>
            </div>
        </div>

        <!-- Submit -->
        <div class="flex items-center gap-4">
            <button type="submit" class="btn text-white px-6 py-2.5 rounded-lg" style="background: var(--trvl-blue);">
                Save Settings
            </button>
            <a href="{{ route('super-admin.dashboard') }}" class="btn btn-secondary px-6 py-2.5 rounded-lg">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
