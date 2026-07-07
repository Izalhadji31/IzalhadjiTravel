@extends('layouts.app')

@section('title', 'Edit Profil')

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
        <h1 class="text-4xl font-bold text-gray-900 mb-2">Edit Profil</h1>
        <p class="text-gray-600">Perbarui informasi akun Anda.</p>
    </div>

    <div class="max-w-2xl">
        <!-- Profile Photo Section -->
        <div class="card mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Foto Profil</h3>
            
            <div class="flex items-center gap-6">
                <!-- Current Photo -->
                <div class="flex-shrink-0">
                    @if(auth()->user()->photo)
                        <img src="{{ asset('storage/' . auth()->user()->photo) }}" 
                             alt="Profile Photo" 
                             class="w-24 h-24 rounded-full object-cover border-4 border-blue-100"
                             id="currentPhoto">
                    @else
                        <div class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center border-4 border-blue-100" id="currentPhoto">
                            <span class="text-white font-bold text-3xl">
                                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                            </span>
                        </div>
                    @endif
                </div>

                <!-- Upload Controls -->
                <div class="flex-1">
                    <form action="{{ route('profile.upload-photo') }}" method="POST" enctype="multipart/form-data" id="photoForm">
                        @csrf
                        <div class="mb-3">
                            <label class="text-gray-700 font-medium text-sm">Upload Foto Baru</label>
                            <input type="file" name="photo" id="photoInput" accept="image/jpeg,image/png,image/webp" 
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                            <p class="text-xs text-gray-500 mt-1">JPG, PNG, or WebP. Max 2MB.</p>
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="btn-primary text-sm">Upload Foto</button>
                            @if(auth()->user()->photo)
                                <button type="button" onclick="removePhoto()" class="btn-secondary text-sm text-red-600 hover:bg-red-50">Hapus Foto</button>
                            @endif
                        </div>
                    </form>
                    @if(auth()->user()->photo)
                        <form action="{{ route('profile.remove-photo') }}" method="POST" id="removePhotoForm" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- Personal Information -->
        <div class="card">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pribadi</h3>
            
            <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-gray-700 font-medium text-sm">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" 
                               class="w-full mt-2 px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600">
                        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="text-gray-700 font-medium text-sm">Email</label>
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" 
                               class="w-full mt-2 px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600">
                        @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label class="text-gray-700 font-medium text-sm">Nomor Telepon</label>
                    <input type="tel" name="phone" value="{{ old('phone', auth()->user()->phone) }}" 
                           class="w-full mt-2 px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600">
                    @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="text-gray-700 font-medium text-sm">Alamat</label>
                    <input type="text" name="address" value="{{ old('address', auth()->user()->address) }}" 
                           placeholder="Masukkan alamat" 
                           class="w-full mt-2 px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600">
                    @error('address')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-gray-700 font-medium text-sm">Kota</label>
                        <input type="text" name="city" value="{{ old('city', auth()->user()->city) }}" 
                               class="w-full mt-2 px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600">
                        @error('city')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="text-gray-700 font-medium text-sm">Negara</label>
                        <input type="text" name="country" value="{{ old('country', auth()->user()->country ?? 'Indonesia') }}" 
                               class="w-full mt-2 px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600">
                        @error('country')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="flex gap-3 pt-6 border-t border-gray-200">
                    <button type="submit" class="btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('profile.show') }}" class="btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function removePhoto() {
            if (confirm('Yakin ingin menghapus foto profil?')) {
                document.getElementById('removePhotoForm').submit();
            }
        }

        // Preview image before upload
        document.getElementById('photoInput')?.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const currentPhoto = document.getElementById('currentPhoto');
                    if (currentPhoto.tagName === 'IMG') {
                        currentPhoto.src = e.target.result;
                    } else {
                        // Replace div with img
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'w-24 h-24 rounded-full object-cover border-4 border-blue-100';
                        img.id = 'currentPhoto';
                        currentPhoto.replaceWith(img);
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
