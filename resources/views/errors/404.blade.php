@extends('layouts.app')

@section('title', '404 - Halaman Tidak Ditemukan')

@section('content')
    <div class="min-h-screen bg-gradient-to-b from-blue-600 to-blue-800 flex items-center justify-center px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <!-- 404 Icon -->
            <div class="mb-8">
                <div class="text-9xl font-bold text-white opacity-20 mb-4">404</div>
            </div>

            <!-- Message -->
            <h1 class="text-5xl font-bold text-white mb-4">Oops! Halaman Tidak Ditemukan</h1>
            <p class="text-xl text-blue-100 mb-8">Maaf, halaman yang Anda cari tidak ada atau telah dipindahkan.</p>

            <!-- Illustration -->
            <div class="mb-12">
                <svg class="w-64 h-64 mx-auto text-blue-200 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                </svg>
            </div>

            <!-- Suggestions -->
            <div class="mb-12 bg-blue-700 bg-opacity-50 rounded-lg p-6 max-w-md mx-auto">
                <h2 class="text-white font-bold mb-4">Berikut yang bisa Anda lakukan:</h2>
                <ul class="text-blue-100 space-y-2 text-left">
                    <li>✓ Periksa kembali URL Anda</li>
                    <li>✓ Gunakan menu navigasi untuk menemukan halaman</li>
                    <li>✓ Kembali ke halaman sebelumnya</li>
                    <li>✓ Hubungi kami jika perlu bantuan</li>
                </ul>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('home') }}" class="inline-block bg-white hover:bg-gray-100 text-blue-600 font-bold py-3 px-6 rounded-lg transition-colors">
                    ← Kembali ke Home
                </a>
                <a href="{{ route('public.contact') }}" class="inline-block bg-blue-500 hover:bg-blue-400 text-white font-bold py-3 px-6 rounded-lg transition-colors">
                    💬 Hubungi Kami
                </a>
            </div>
        </div>
    </div>
@endsection
