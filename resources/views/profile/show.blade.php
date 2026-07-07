@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
    <!-- Back Button -->
    <a href="{{ url()->previous() }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors mb-4">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali
    </a>
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">Profil Saya</h1>
        <p class="text-gray-600">Lihat dan kelola informasi akun Anda.</p>
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
                    <a href="{{ route('profile.edit') }}" class="flex-1 btn-primary text-sm">Edit Profil</a>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="card mt-6">
                <h4 class="font-semibold text-gray-900 mb-4">Status Akun</h4>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 text-sm">Kelengkapan Profil</span>
                        <div class="w-20 bg-gray-200 rounded-full h-2">
                            <div class="bg-green-600 h-2 rounded-full" style="width: 85%"></div>
                        </div>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 text-sm">Verifikasi</span>
                        <span class="text-xs font-medium text-green-600">Terverifikasi</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 text-sm">Akun Sejak</span>
                        <span class="text-xs font-medium text-gray-900">{{ auth()->user()->created_at?->format('M Y') ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Account Information -->
        <div class="lg:col-span-2">
            <div class="card mb-6">
                <h3 class="card-header">Informasi Akun</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-gray-600 text-sm font-medium">Nama Lengkap</label>
                        <p class="text-gray-900 font-medium mt-1">{{ auth()->user()->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-gray-600 text-sm font-medium">Email</label>
                        <p class="text-gray-900 font-medium mt-1">{{ auth()->user()->email ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-gray-600 text-sm font-medium">Nomor Telepon</label>
                        <p class="text-gray-900 font-medium mt-1">{{ auth()->user()->phone ?? 'Belum diisi' }}</p>
                    </div>
                    <div>
                        <label class="text-gray-600 text-sm font-medium">Tipe Akun</label>
                        <p class="text-gray-900 font-medium mt-1">{{ ucfirst(auth()->user()->role ?? 'customer') }}</p>
                    </div>
                    <div>
                        <label class="text-gray-600 text-sm font-medium">Identitas</label>
                        <p class="text-gray-900 font-medium mt-1">{{ auth()->user()->identity_number ?? 'Belum diisi' }}</p>
                    </div>
                    <div>
                        <label class="text-gray-600 text-sm font-medium">Anggota Sejak</label>
                        <p class="text-gray-900 font-medium mt-1">{{ auth()->user()->created_at?->format('d M Y') ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <h3 class="card-header">Pengaturan Keamanan</h3>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center pb-4 border-b border-gray-200">
                        <div>
                            <p class="font-semibold text-gray-900">Autentikasi Dua Faktor</p>
                            <p class="text-sm text-gray-600">Tambah keamanan ekstra untuk akun Anda</p>
                        </div>
                        <button class="btn-secondary text-sm">Aktifkan</button>
                    </div>
                    <div class="flex justify-between items-center pb-4 border-b border-gray-200">
                        <div>
                            <p class="font-semibold text-gray-900">Ganti Password</p>
                            <p class="text-sm text-gray-600">Perbarui password Anda secara berkala</p>
                        </div>
                        <a href="{{ route('password.request') }}" class="btn-secondary text-sm">Ganti</a>
                    </div>
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="font-semibold text-gray-900">Manajemen Sesi</p>
                            <p class="text-sm text-gray-600">Lihat dan kelola sesi aktif</p>
                        </div>
                        <button class="btn-secondary text-sm">Lihat Sesi</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
