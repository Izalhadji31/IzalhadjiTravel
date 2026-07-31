@extends('layouts.app')

@section('title', 'Tentang Kami - ASR GO')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <!-- Hero Section -->
        <div class="bg-blue-600 text-white py-16">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <h1 class="text-5xl font-bold mb-4">Tentang ASR GO</h1>
                <p class="text-xl text-blue-100">Layanan Transportasi Terpercaya di Pulau Flores</p>
            </div>
        </div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <!-- Company Profile -->
            <div class="mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Profil Perusahaan</h2>
                <div class="bg-white rounded-lg shadow-md p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-4">CV. Izalhadji Travel</h3>
                            <p class="text-gray-700 leading-relaxed mb-4">
                                Kami adalah perusahaan transportasi yang berpusat di Ende, Pulau Flores, Indonesia. 
                                Sejak didirikan, kami berkomitmen untuk memberikan layanan transportasi terbaik dengan 
                                harga yang terjangkau dan profesional.
                            </p>
                            <p class="text-gray-700 leading-relaxed mb-4">
                                ASR GO menawarkan dua layanan utama: Travel Antar Kota dan Sewa Kendaraan. 
                                Dengan armada modern dan driver berpengalaman, kami siap mengantarkan Anda ke destinasi 
                                dengan aman dan nyaman.
                            </p>
                            <p class="text-gray-700 leading-relaxed">
                                Kepercayaan pelanggan adalah prioritas utama kami. Oleh karena itu, kami terus berinovasi 
                                dan meningkatkan kualitas layanan untuk memenuhi harapan Anda.
                            </p>
                        </div>
                        <div>
                            <div class="bg-gradient-to-br from-blue-100 to-blue-50 rounded-lg p-8 h-full flex items-center justify-center">
                                <div class="text-center">
                                    <div class="text-6xl font-bold text-blue-600 mb-2">ASR</div>
                                    <p class="text-gray-600 font-semibold">GO</p>
                                    <p class="text-sm text-gray-500 mt-4">Transportasi Terpercaya</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vision & Mission -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-16">
                <!-- Vision -->
                <div class="bg-white rounded-lg shadow-md p-8">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-600 text-white">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 ml-4">Visi Kami</h3>
                    </div>
                    <p class="text-gray-700 leading-relaxed">
                        Menjadi layanan transportasi terdepan di Pulau Flores yang dipercaya oleh jutaan pelanggan 
                        dengan memberikan pengalaman perjalanan yang nyaman, aman, dan terjangkau.
                    </p>
                </div>

                <!-- Mission -->
                <div class="bg-white rounded-lg shadow-md p-8">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-green-600 text-white">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 ml-4">Misi Kami</h3>
                    </div>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <span class="text-green-600 mr-3">✓</span>
                            <span class="text-gray-700">Menyediakan layanan transportasi berkualitas tinggi</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-green-600 mr-3">✓</span>
                            <span class="text-gray-700">Menjaga kepuasan dan keselamatan pelanggan</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-green-600 mr-3">✓</span>
                            <span class="text-gray-700">Memberikan harga yang kompetitif dan transparan</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-green-600 mr-3">✓</span>
                            <span class="text-gray-700">Terus berinovasi dan berkembang</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Values -->
            <div class="bg-white rounded-lg shadow-md p-8 mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-8">Nilai-Nilai Kami</h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="text-center">
                        <div class="text-5xl mb-4">🤝</div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Integritas</h3>
                        <p class="text-gray-600">Jujur dan terpercaya dalam setiap transaksi</p>
                    </div>
                    <div class="text-center">
                        <div class="text-5xl mb-4">⭐</div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Kualitas</h3>
                        <p class="text-gray-600">Memberikan yang terbaik untuk pelanggan</p>
                    </div>
                    <div class="text-center">
                        <div class="text-5xl mb-4">🚀</div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Inovasi</h3>
                        <p class="text-gray-600">Selalu mencari cara baru untuk berkembang</p>
                    </div>
                    <div class="text-center">
                        <div class="text-5xl mb-4">❤️</div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Kepedulian</h3>
                        <p class="text-gray-600">Peduli terhadap pelanggan dan masyarakat</p>
                    </div>
                </div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-blue-600 text-white rounded-lg shadow-md p-6 text-center">
                    <p class="text-4xl font-bold mb-2">2010</p>
                    <p class="text-blue-100">Tahun Berdiri</p>
                </div>
                <div class="bg-green-600 text-white rounded-lg shadow-md p-6 text-center">
                    <p class="text-4xl font-bold mb-2">50+</p>
                    <p class="text-green-100">Kendaraan Armada</p>
                </div>
                <div class="bg-purple-600 text-white rounded-lg shadow-md p-6 text-center">
                    <p class="text-4xl font-bold mb-2">100K+</p>
                    <p class="text-purple-100">Pelanggan Puas</p>
                </div>
                <div class="bg-orange-600 text-white rounded-lg shadow-md p-6 text-center">
                    <p class="text-4xl font-bold mb-2">24/7</p>
                    <p class="text-orange-100">Layanan Pelanggan</p>
                </div>
            </div>
        </div>
    </div>
@endsection
