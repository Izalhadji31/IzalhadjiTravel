@extends('layouts.app')

@section('title', 'Kelola Akun')

@section('content')
    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Kelola Akun</h1>
            <p class="text-gray-600">Atur semua akun pengguna dan setujui pendaftaran baru.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" 
           class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors text-sm shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Akun
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if(session('warning'))
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-800 px-4 py-3 rounded-lg mb-6">
            {{ session('warning') }}
        </div>
    @endif

    <!-- Users Table -->
    <div class="card overflow-hidden">
        <div class="card-header">Daftar Pengguna</div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Nama</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Email</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Telepon</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Role</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Tergabung</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                    <tr class="border-b border-gray-100 hover:bg-blue-50">
                        <td class="px-6 py-3 font-semibold text-gray-900">{{ $user->name }}</td>
                        <td class="px-6 py-3 text-gray-700">{{ $user->email }}</td>
                        <td class="px-6 py-3 text-gray-700">{{ $user->phone ?? '-' }}</td>
                        <td class="px-6 py-3">
                            @if ($user->role === 'admin')
                                <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-semibold">Admin</span>
                            @elseif ($user->role === 'partner')
                                <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-xs font-semibold">Partner</span>
                            @elseif ($user->role === 'driver')
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-semibold">Driver</span>
                            @else
                                <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-xs font-semibold">Pelanggan</span>
                            @endif
                        </td>
                        <td class="px-6 py-3">
                            @if ($user->status === 'pending')
                                <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-semibold">Pending</span>
                            @elseif ($user->status === 'approved')
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">Disetujui</span>
                            @elseif ($user->status === 'rejected')
                                <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-semibold">Ditolak</span>
                            @else
                                <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-xs font-semibold">{{ $user->status ?? 'N/A' }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-3 text-gray-700">{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-3">
                            @if ($user->status === 'pending')
                                <form action="{{ route('admin.users.approve', $user->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:text-green-800 text-sm font-medium">Setuju</button>
                                </form>
                                <span class="mx-1 text-gray-300">|</span>
                                <form action="{{ route('admin.users.reject', $user->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">Tolak</button>
                                </form>
                                <span class="mx-1 text-gray-300">|</span>
                            @endif
                            @if ($user->role !== 'admin')
                                <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Hapus user ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">Hapus</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">Tidak ada user ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if (method_exists($users, 'links'))
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $users->links() }}
        </div>
        @endif
    </div>
@endsection
