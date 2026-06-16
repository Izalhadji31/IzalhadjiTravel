@extends('layouts.app')

@section('title', 'Kontak - ASR GO')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 mb-3">Hubungi Kami</h1>
                <p class="text-xl text-gray-600">Kami siap membantu Anda 24/7</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
                <!-- Contact Info Cards -->
                <div class="bg-white rounded-lg shadow-md p-8">
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-green-600 text-white">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 ml-4">WhatsApp</h3>
                    </div>
                    <p class="text-gray-600 mb-4">Hubungi kami melalui WhatsApp untuk respons cepat</p>
                    <a href="https://wa.me/62821234567890?text=Halo%20ASR%20GO" 
                       target="_blank"
                       class="inline-flex items-center text-green-600 hover:text-green-700 font-semibold">
                        +62 821 234 567 890
                        <svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </a>
                </div>

                <div class="bg-white rounded-lg shadow-md p-8">
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-600 text-white">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 ml-4">Email</h3>
                    </div>
                    <p class="text-gray-600 mb-4">Kirimkan pertanyaan melalui email</p>
                    <a href="mailto:info@asrgo.com" class="inline-flex items-center text-blue-600 hover:text-blue-700 font-semibold break-all">
                        info@asrgo.com
                        <svg class="w-4 h-4 ml-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </a>
                </div>

                <div class="bg-white rounded-lg shadow-md p-8">
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-red-600 text-white">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 ml-4">Kantor</h3>
                    </div>
                    <p class="text-gray-600 mb-4">Kunjungi kantor kami langsung</p>
                    <p class="text-gray-700 font-semibold">
                        Jl. Veteran No. 45<br>
                        Ende, Flores 86312<br>
                        NTT, Indonesia
                    </p>
                </div>
            </div>

            <!-- Contact Form & Map -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Contact Form -->
                <div class="bg-white rounded-lg shadow-md p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Kirim Pesan</h2>

                    @if (session('success'))
                        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                            <p class="text-green-700 font-semibold">{{ session('success') }}</p>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('public.contact.submit') }}" class="space-y-6">
                        @csrf

                        <div>
                            <label class="block text-sm font-bold text-gray-900 mb-2">Nama</label>
                            <input type="text" name="name" required 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent @error('name') border-red-600 @enderror"
                                   placeholder="Nama lengkap Anda"
                                   value="{{ old('name') }}">
                            @error('name')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-900 mb-2">Email</label>
                            <input type="email" name="email" required 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent @error('email') border-red-600 @enderror"
                                   placeholder="email@contoh.com"
                                   value="{{ old('email') }}">
                            @error('email')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-900 mb-2">Nomor Telepon</label>
                            <input type="tel" name="phone" required 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent @error('phone') border-red-600 @enderror"
                                   placeholder="08xxxxxxxxxx"
                                   value="{{ old('phone') }}">
                            @error('phone')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-900 mb-2">Subjek</label>
                            <input type="text" name="subject" required 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent @error('subject') border-red-600 @enderror"
                                   placeholder="Topik pertanyaan Anda"
                                   value="{{ old('subject') }}">
                            @error('subject')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-900 mb-2">Pesan</label>
                            <textarea name="message" required rows="5"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent @error('message') border-red-600 @enderror"
                                      placeholder="Tulis pesan Anda di sini...">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-colors">
                            Kirim Pesan
                        </button>
                    </form>
                </div>

                <!-- Map -->
                <div class="bg-white rounded-lg shadow-md p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Lokasi Kami</h2>
                    <div class="w-full h-96 rounded-lg overflow-hidden border border-gray-300">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3945.2479999999997!2d121.67384!3d-8.833333!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2c3c3c3c3c3c3c3d%3A0x0!2sEnde%2C%20East%20Nusa%20Tenggara!5e0!3m2!1sen!2sid!4v1234567890"
                                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                        <p class="text-sm text-gray-700 mb-2">
                            <strong>Jam Operasional:</strong>
                        </p>
                        <p class="text-gray-600">Senin - Minggu: 06:00 - 22:00 WIT</p>
                        <p class="text-gray-600">Pelayanan darurat tersedia 24 jam</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
