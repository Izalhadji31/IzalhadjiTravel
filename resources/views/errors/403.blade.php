@extends('layouts.app')

@section('title', '403 - Akses Ditolak')

@section('content')
    <div class="min-h-screen bg-gradient-to-b from-red-600 to-red-800 flex items-center justify-center px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <!-- 403 Icon -->
            <div class="mb-8">
                <div class="text-9xl font-bold text-white opacity-20 mb-4">403</div>
            </div>

            <!-- Message -->
            <h1 class="text-5xl font-bold text-white mb-4">Akses Ditolak</h1>
            <p class="text-xl text-red-100 mb-8">Anda tidak memiliki izin untuk mengakses halaman ini.</p>

            <!-- Illustration -->
            <div class="mb-12">
                <svg class="w-64 h-64 mx-auto text-red-200 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>

            <!-- Explanation -->
            <div class="mb-12 bg-red-700 bg-opacity-50 rounded-lg p-6 max-w-md mx-auto">
                <h2 class="text-white font-bold mb-4">Mengapa saya melihat ini?</h2>
                <ul class="text-red-100 space-y-2 text-left text-sm">
                    <li>✓ Anda tidak memiliki role atau permission yang sesuai</li>
                    <li>✓ Akun Anda mungkin belum terverifikasi</li>
                    <li>✓ Akses terbatas untuk halaman admin</li>
                    <li>✓ Konten ini hanya untuk member tertentu</li>
                </ul>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @auth
                    <a href="{{ route('dashboard') }}" class="inline-block bg-white hover:bg-gray-100 text-red-600 font-bold py-3 px-6 rounded-lg transition-colors">
                        ← Kembali ke Dashboard
                    </a>
                @else
                    <a href="{{ route('home') }}" class="inline-block bg-white hover:bg-gray-100 text-red-600 font-bold py-3 px-6 rounded-lg transition-colors">
                        ← Kembali ke Home
                    </a>
                    <a href="{{ route('login') }}" class="inline-block bg-red-500 hover:bg-red-400 text-white font-bold py-3 px-6 rounded-lg transition-colors">
                        🔐 Login
                    </a>
                @endauth
                <a href="{{ route('public.contact') }}" class="inline-block bg-red-500 hover:bg-red-400 text-white font-bold py-3 px-6 rounded-lg transition-colors">
                    💬 Hubungi Kami
                </a>
            </div>
        </div>
    </div>
@endsection
