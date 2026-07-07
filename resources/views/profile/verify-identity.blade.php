@extends('layouts.app')

@section('title', 'Verifikasi Identitas - ASR GO')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto">
            <!-- Back Button -->
            <a href="{{ url()->previous() }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Verifikasi Identitas</h1>
                <p class="text-gray-600 mt-2">Lengkapi data identitas Anda untuk akses lebih mudah</p>
            </div>

            <div class="bg-white rounded-lg shadow-md p-8">
                @if (session('success'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <p class="text-green-700 font-semibold">{{ session('success') }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.upload-identity') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Tipe Identitas -->
                    <div>
                        <label class="block text-sm font-bold text-gray-900 mb-3">Tipe Identitas</label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="relative">
                                <input type="radio" name="identity_type" value="ktp" onchange="updateIdentityType('ktp')" 
                                       {{ old('identity_type') == 'ktp' ? 'checked' : '' }} class="sr-only">
                                <div class="cursor-pointer p-4 border-2 rounded-lg transition-all 
                                    {{ old('identity_type') == 'ktp' ? 'border-blue-600 bg-blue-50' : 'border-gray-300 bg-white hover:border-gray-400' }}">
                                    <div class="text-2xl mb-2">🪪</div>
                                    <p class="font-semibold text-gray-900">KTP</p>
                                    <p class="text-xs text-gray-600">Kartu Tanda Penduduk</p>
                                </div>
                            </label>
                            <label class="relative">
                                <input type="radio" name="identity_type" value="sim" onchange="updateIdentityType('sim')" 
                                       {{ old('identity_type') == 'sim' ? 'checked' : '' }} class="sr-only">
                                <div class="cursor-pointer p-4 border-2 rounded-lg transition-all 
                                    {{ old('identity_type') == 'sim' ? 'border-blue-600 bg-blue-50' : 'border-gray-300 bg-white hover:border-gray-400' }}">
                                    <div class="text-2xl mb-2">🚗</div>
                                    <p class="font-semibold text-gray-900">SIM</p>
                                    <p class="text-xs text-gray-600">Surat Izin Mengemudi</p>
                                </div>
                            </label>
                        </div>
                        @error('identity_type')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nomor Identitas -->
                    <div>
                        <label class="block text-sm font-bold text-gray-900 mb-2">Nomor Identitas</label>
                        <input type="text" name="identity_number" id="identity_number" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent @error('identity_number') border-red-600 @enderror"
                               placeholder="Masukkan nomor KTP atau SIM"
                               value="{{ old('identity_number') }}"
                               required>
                        @error('identity_number')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama di Identitas -->
                    <div>
                        <label class="block text-sm font-bold text-gray-900 mb-2">Nama (sesuai identitas)</label>
                        <input type="text" name="identity_name" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent @error('identity_name') border-red-600 @enderror"
                               placeholder="Nama lengkap sesuai KTP/SIM"
                               value="{{ old('identity_name') }}"
                               required>
                        @error('identity_name')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Lahir -->
                    <div>
                        <label class="block text-sm font-bold text-gray-900 mb-2">Tanggal Lahir</label>
                        <input type="date" name="date_of_birth" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent @error('date_of_birth') border-red-600 @enderror"
                               value="{{ old('date_of_birth') }}"
                               required>
                        @error('date_of_birth')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Alamat -->
                    <div>
                        <label class="block text-sm font-bold text-gray-900 mb-2">Alamat</label>
                        <textarea name="address" rows="3"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent @error('address') border-red-600 @enderror"
                                  placeholder="Alamat sesuai identitas"
                                  required>{{ old('address') }}</textarea>
                        @error('address')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Photo Identity -->
                    <div>
                        <label class="block text-sm font-bold text-gray-900 mb-2">Foto Identitas (Opsional)</label>
                        <div class="mt-2 border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:border-blue-600 hover:bg-blue-50 transition-colors" id="photo-drop-zone">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-2" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20a4 4 0 004 4h24a4 4 0 004-4V16a4 4 0 00-4-4h-8l-4-4z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                <circle cx="20" cy="24" r="3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></circle>
                                <path d="M26 20l6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                            <input type="file" name="identity_photo" id="identity_photo" accept="image/*" class="hidden" onchange="previewPhoto(event)">
                            <label for="identity_photo" class="cursor-pointer">
                                <p class="text-gray-600">Klik untuk upload atau drag & drop</p>
                                <p class="text-xs text-gray-500 mt-1">PNG, JPG maksimal 5MB</p>
                            </label>
                        </div>
                        <div id="photo-preview" class="mt-4 hidden">
                            <img id="preview-img" src="" alt="Preview" class="max-h-48 rounded-lg mx-auto">
                            <button type="button" onclick="removePhoto()" class="mt-2 text-red-600 hover:text-red-700 text-sm font-semibold">
                                Hapus foto
                            </button>
                        </div>
                        @error('identity_photo')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Info Box -->
                    <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <p class="text-sm text-gray-700 mb-2">
                            <strong>📝 Catatan Penting:</strong>
                        </p>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>✓ Data identitas Anda akan dijaga kerahasiaannya</li>
                            <li>✓ Verifikasi identitas akan mempercepat proses booking</li>
                            <li>✓ Foto identitas hanya digunakan untuk verifikasi</li>
                        </ul>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-4">
                        <a href="{{ route('profile.show') }}" class="flex-1 text-center bg-gray-200 hover:bg-gray-300 text-gray-900 font-bold py-2 px-4 rounded-lg transition-colors">
                            Batal
                        </a>
                        <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                            Simpan Identitas
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const photoDropZone = document.getElementById('photo-drop-zone');
        const photoInput = document.getElementById('identity_photo');

        photoDropZone.addEventListener('click', () => photoInput.click());
        photoDropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            photoDropZone.classList.add('border-blue-600', 'bg-blue-50');
        });
        photoDropZone.addEventListener('dragleave', () => {
            photoDropZone.classList.remove('border-blue-600', 'bg-blue-50');
        });
        photoDropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            photoDropZone.classList.remove('border-blue-600', 'bg-blue-50');
            if (e.dataTransfer.files.length) {
                photoInput.files = e.dataTransfer.files;
                previewPhoto({ target: { files: e.dataTransfer.files } });
            }
        });

        function previewPhoto(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-img').src = e.target.result;
                    document.getElementById('photo-preview').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        }

        function removePhoto() {
            document.getElementById('identity_photo').value = '';
            document.getElementById('photo-preview').classList.add('hidden');
        }

        function updateIdentityType(type) {
            const input = document.getElementById('identity_number');
            if (type === 'ktp') {
                input.placeholder = 'Masukkan nomor KTP (16 digit)';
                input.maxLength = 16;
            } else {
                input.placeholder = 'Masukkan nomor SIM (12 digit)';
                input.maxLength = 12;
            }
        }
    </script>
@endsection
