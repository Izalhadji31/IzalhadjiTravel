@extends('layouts.app')

@section('title', 'System Settings')

@section('content')
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">Pengaturan Sistem</h1>
        <p class="text-gray-600">Konfigurasi pengaturan dan preferensi aplikasi</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Settings Menu -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-md border border-blue-100 overflow-hidden">
                <nav class="space-y-1 p-4">
                    <a href="#" class="block px-4 py-2 bg-blue-50 text-blue-600 rounded-lg font-medium">Umum</a>
                    <a href="#" class="block px-4 py-2 text-gray-600 hover:bg-gray-50 rounded-lg">Email</a>
                    <a href="#" class="block px-4 py-2 text-gray-600 hover:bg-gray-50 rounded-lg">Pembayaran</a>
                    <a href="#" class="block px-4 py-2 text-gray-600 hover:bg-gray-50 rounded-lg">Keamanan</a>
                    <a href="#" class="block px-4 py-2 text-gray-600 hover:bg-gray-50 rounded-lg">Integrasi</a>
                </nav>
            </div>
        </div>

        <!-- Settings Content -->
        <div class="lg:col-span-2">
            <div class="card mb-6">
                <h3 class="card-header">Pengaturan Umum</h3>
                
                <div class="space-y-6">
                    <div>
                        <label class="text-gray-700 font-medium">Nama Aplikasi</label>
                        <input type="text" value="ASR GO" class="w-full mt-2 px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600">
                    </div>
                    <div>
                        <label class="text-gray-700 font-medium">URL Aplikasi</label>
                        <input type="url" value="https://asrgo.example.com" class="w-full mt-2 px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600">
                    </div>
                    <div>
                        <label class="text-gray-700 font-medium">Email Dukungan</label>
                        <input type="email" value="support@asrgo.id" class="w-full mt-2 px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600">
                    </div>
                    <div>
                        <label class="text-gray-700 font-medium">Timezone</label>
                        <select class="w-full mt-2 px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600">
                            <option selected>Asia/Jakarta</option>
                            <option>Asia/Bangkok</option>
                            <option>Asia/Singapore</option>
                        </select>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" id="maintenance" class="w-4 h-4 text-blue-600 rounded">
                        <label for="maintenance" class="ml-2 text-gray-700 font-medium">Mode Pemeliharaan</label>
                    </div>
                    <div>
                        <button class="btn-primary">Simpan Perubahan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
