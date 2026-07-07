@extends('layouts.app')

@section('title', 'Tambah Akun Baru')

@section('content')
<div class="mb-8">
    <a href="{{ route('admin.users') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors mb-4">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali ke Users
    </a>
    <h1 class="text-4xl font-bold text-gray-900 mb-2">Tambah Akun Baru</h1>
    <p class="text-gray-600">Buat akun admin, mitra, driver, atau customer langsung dari panel.</p>
</div>

@if ($errors->any())
<div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded-lg mb-6">
    <strong>Terdapat kesalahan:</strong>
    <ul class="mt-2 ml-4 list-disc">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="card max-w-2xl">
    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Nama -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                    placeholder="Nama lengkap">
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                    placeholder="email@example.com">
            </div>

            <!-- Password -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                <input type="password" name="password" required
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                    placeholder="Minimal 6 karakter">
            </div>

            <!-- Telepon -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Telepon</label>
                <input type="text" name="phone" value="{{ old('phone') }}" required
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                    placeholder="081234567890">
            </div>

            <!-- Role -->
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Role / Peran</label>
                <select name="role" required
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                    <option value="">-- Pilih Role --</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="partner" {{ old('role') == 'partner' ? 'selected' : '' }}>Mitra (Partner)</option>
                    <option value="driver" {{ old('role') == 'driver' ? 'selected' : '' }}>Driver (Sopir)</option>
                    <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>Customer (Pelanggan)</option>
                </select>
                <p class="text-xs text-gray-500 mt-1">Akun akan langsung aktif (status: approved) tanpa perlu persetujuan.</p>
            </div>
        </div>

        <div class="mt-8 flex items-center gap-3">
            <button type="submit"
                class="px-6 py-2.5 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors text-sm">
                Buat Akun
            </button>
            <a href="{{ route('admin.users') }}"
                class="px-6 py-2.5 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition-colors text-sm">
                Batal
            </a>
        </div>
    </form>
</div>

<div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4 text-sm text-blue-800">
    <strong>Catatan:</strong> Jika memilih role <strong>Driver (Sopir)</strong>, sistem otomatis akan membuat profile driver (SIM, status, dll). Untuk Mitra, profile mitra harus ditambahkan secara terpisah.
</div>
@endsection
