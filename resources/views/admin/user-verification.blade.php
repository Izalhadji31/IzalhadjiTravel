@extends('layouts.app')

@section('title', 'Verifikasi User - Admin')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Verifikasi User</h1>
                <p class="text-gray-600 mt-2">Kelola verifikasi identitas pengguna</p>
            </div>

            <!-- Tabs -->
            <div class="mb-6 flex gap-4 border-b border-gray-200">
                <a href="?status=pending" class="px-4 py-2 border-b-2 {{ request('status', 'pending') == 'pending' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-600 hover:text-gray-900' }} font-semibold transition-colors">
                    ⏳ Pending ({{ $pending_count ?? 0 }})
                </a>
                <a href="?status=verified" class="px-4 py-2 border-b-2 {{ request('status') == 'verified' ? 'border-green-600 text-green-600' : 'border-transparent text-gray-600 hover:text-gray-900' }} font-semibold transition-colors">
                    ✅ Terverifikasi ({{ $verified_count ?? 0 }})
                </a>
                <a href="?status=rejected" class="px-4 py-2 border-b-2 {{ request('status') == 'rejected' ? 'border-red-600 text-red-600' : 'border-transparent text-gray-600 hover:text-gray-900' }} font-semibold transition-colors">
                    ❌ Ditolak ({{ $rejected_count ?? 0 }})
                </a>
            </div>

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <p class="text-green-700 font-semibold">{{ session('success') }}</p>
                </div>
            @endif

            <!-- Users Table -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">User</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Identitas</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tanggal Verifikasi</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($users as $user)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                <span class="text-blue-600 font-semibold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-900">{{ $user->name }}</p>
                                                <p class="text-xs text-gray-600">{{ $user->phone ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $user->email }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($user->identityVerification)
                                            <div class="text-sm">
                                                <p class="font-semibold text-gray-900">
                                                    {{ $user->identityVerification->id_type == 'KTP' ? 'KTP' : 'SIM' }}
                                                </p>
                                                <p class="text-gray-600">
                                                    {{ $user->identityVerification->id_number }}
                                                </p>
                                                <p class="text-xs text-gray-500 mt-1">
                                                    Nama: {{ $user->identityVerification->full_name }}
                                                </p>
                                            </div>
                                        @else
                                            <p class="text-sm text-gray-500">Belum ada</p>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold
                                            @if ($user->identityVerification?->status == 'verified')
                                                bg-green-100 text-green-800
                                            @elseif ($user->identityVerification?->status == 'rejected')
                                                bg-red-100 text-red-800
                                            @else
                                                bg-yellow-100 text-yellow-800
                                            @endif">
                                            @if ($user->identityVerification?->status == 'verified')
                                                ✅ Terverifikasi
                                            @elseif ($user->identityVerification?->status == 'rejected')
                                                ❌ Ditolak
                                            @else
                                                ⏳ Pending
                                            @endif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $user->identityVerification?->verified_at?->format('d M Y') ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <div class="flex gap-2">
                                            @if ($user->identityVerification?->status == 'pending')
                                                <button data-action="verify" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}"
                                                        class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white rounded transition-colors text-xs font-semibold btn-action">
                                                    Verifikasi
                                                </button>
                                                <button data-action="reject" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}"
                                                        class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded transition-colors text-xs font-semibold btn-action">
                                                    Tolak
                                                </button>
                                            @elseif ($user->identityVerification?->status == 'verified')
                                                <button data-action="reject" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}"
                                                        class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded transition-colors text-xs font-semibold btn-action">
                                                    Batalkan Verifikasi
                                                </button>
                                            @else
                                                <button data-action="verify" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}"
                                                        class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white rounded transition-colors text-xs font-semibold btn-action">
                                                    Verifikasi Ulang
                                                </button>
                                            @endif
                                            @if ($user->identityVerification?->id_image_path)
                                                <button data-action="photo" data-photo-url="{{ asset('storage/' . $user->identityVerification->id_image_path) }}"
                                                        class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded transition-colors text-xs font-semibold btn-action">
                                                    📸 Lihat Foto
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                        Tidak ada data user
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Verify Modal -->
    <div id="verifyModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 px-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Verifikasi User</h2>
            <p id="verifyUserName" class="text-gray-600 mb-6"></p>
            
            <form id="verifyForm" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-gray-900 mb-2">Catatan (Opsional)</label>
                    <textarea name="notes" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent" placeholder="Catatan verifikasi..."></textarea>
                </div>
                
                <div class="flex gap-3">
                    <button type="button" onclick="closeVerifyModal()" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-900 font-bold py-2 px-4 rounded-lg transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                        ✅ Verifikasi
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 px-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Tolak Verifikasi</h2>
            <p id="rejectUserName" class="text-gray-600 mb-6"></p>
            
            <form id="rejectForm" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-gray-900 mb-2">Alasan Penolakan</label>
                    <select name="rejection_reason" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-600 focus:border-transparent">
                        <option value="">-- Pilih Alasan --</option>
                        <option value="invalid_document">Dokumen tidak valid</option>
                        <option value="unclear_photo">Foto tidak jelas</option>
                        <option value="expired_document">Dokumen expired</option>
                        <option value="name_mismatch">Nama tidak sesuai</option>
                        <option value="other">Lainnya</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-900 mb-2">Keterangan Tambahan</label>
                    <textarea name="rejection_notes" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-600 focus:border-transparent" placeholder="Jelaskan alasan penolakan..."></textarea>
                </div>
                
                <div class="flex gap-3">
                    <button type="button" onclick="closeRejectModal()" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-900 font-bold py-2 px-4 rounded-lg transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                        ❌ Tolak
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Photo Modal -->
    <div id="photoModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 px-4">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold text-gray-900">Foto Identitas</h2>
                <button onclick="closePhotoModal()" class="text-gray-600 hover:text-gray-900 text-2xl">×</button>
            </div>
            <img id="photoImage" src="" alt="Foto Identitas" class="w-full rounded-lg">
        </div>
    </div>

    <script>
        let currentUserId = null;

        function openVerifyModal(userId, userName) {
            currentUserId = userId;
            document.getElementById('verifyUserName').textContent = `Verifikasi user: ${userName}`;
            document.getElementById('verifyForm').action = `/admin/users/${userId}/verify`;
            document.getElementById('verifyModal').classList.remove('hidden');
        }

        function closeVerifyModal() {
            document.getElementById('verifyModal').classList.add('hidden');
        }

        function openRejectModal(userId, userName) {
            currentUserId = userId;
            document.getElementById('rejectUserName').textContent = `Tolak verifikasi user: ${userName}`;
            document.getElementById('rejectForm').action = `/admin/users/${userId}/reject-verification`;
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }

        function openPhotoModal(photoUrl) {
            document.getElementById('photoImage').src = photoUrl;
            document.getElementById('photoModal').classList.remove('hidden');
        }

        function closePhotoModal() {
            document.getElementById('photoModal').classList.add('hidden');
        }

        // Handle action buttons with data attributes
        document.querySelectorAll('.btn-action').forEach(button => {
            button.addEventListener('click', function() {
                const action = this.dataset.action;
                const userId = this.dataset.userId;
                const userName = this.dataset.userName;
                const photoUrl = this.dataset.photoUrl;

                if (action === 'verify') {
                    openVerifyModal(userId, userName);
                } else if (action === 'reject') {
                    openRejectModal(userId, userName);
                } else if (action === 'photo') {
                    openPhotoModal(photoUrl);
                }
            });
        });

        // Close modal on outside click
        document.getElementById('verifyModal').addEventListener('click', function(e) {
            if (e.target === this) closeVerifyModal();
        });
        document.getElementById('rejectModal').addEventListener('click', function(e) {
            if (e.target === this) closeRejectModal();
        });
        document.getElementById('photoModal').addEventListener('click', function(e) {
            if (e.target === this) closePhotoModal();
        });
    </script>
@endsection
