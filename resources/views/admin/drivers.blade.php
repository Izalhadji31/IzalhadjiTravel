@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-100 p-6 font-sans">
    
    <!-- Page Header -->
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Manajemen Driver / Sopir</h1>
            <p class="mt-1 text-sm text-slate-500">Kelola dan pantau semua driver yang terdaftar di sistem</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <span class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white">
                Total Drivers: {{ $drivers->count() }}
            </span>
            <span class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white">
                Active: {{ $drivers->whereIn('status', ['available', 'busy'])->count() }}
            </span>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="mb-6 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-xl border-l-4 border-emerald-500 bg-white p-5 shadow-sm">
            <div class="text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-500">Tersedia</div>
            <div class="mt-2 text-2xl font-bold text-emerald-600">{{ $drivers->where('status', 'available')->count() }}</div>
        </div>
        <div class="rounded-xl border-l-4 border-orange-500 bg-white p-5 shadow-sm">
            <div class="text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-500">Sedang Bertugas</div>
            <div class="mt-2 text-2xl font-bold text-orange-600">{{ $drivers->where('status', 'busy')->count() }}</div>
        </div>
        <div class="rounded-xl border-l-4 border-slate-400 bg-white p-5 shadow-sm">
            <div class="text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-500">Offline</div>
            <div class="mt-2 text-2xl font-bold text-slate-600">{{ $drivers->where('status', 'offline')->count() }}</div>
        </div>
        <div class="rounded-xl border-l-4 border-red-500 bg-white p-5 shadow-sm">
            <div class="text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-500">On Leave</div>
            <div class="mt-2 text-2xl font-bold text-red-600">{{ $drivers->where('status', 'on_leave')->count() }}</div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="mb-5 rounded-xl bg-white p-5 shadow-sm">
        <div class="flex flex-wrap items-center gap-3">
            <div class="text-sm font-semibold text-slate-700">Filter:</div>
            
            <input type="text" id="searchFilter" placeholder="Cari nama atau telepon..." 
                   class="w-56 rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                   onkeydown="if(event.key==='Enter') applyFilters()">
            
            <select id="statusFilter" class="rounded-md border border-slate-300 bg-white px-3 py-2 text-sm outline-none cursor-pointer">
                <option value="">Semua Status</option>
                <option value="available">Tersedia</option>
                <option value="busy">Sibuk</option>
                <option value="offline">Offline</option>
                <option value="on_leave">Cuti</option>
            </select>
            
            <select id="armadaFilter" class="rounded-md border border-slate-300 bg-white px-3 py-2 text-sm outline-none cursor-pointer">
                <option value="">Semua Armada</option>
                @foreach($drivers->pluck('armada.name')->unique()->filter() as $armadaName)
                    <option value="{{ strtolower($armadaName) }}">{{ $armadaName }}</option>
                @endforeach
            </select>
            
            <button onclick="applyFilters()" class="rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white">
                Terapkan
            </button>
            <button onclick="resetFilters()" class="rounded-md border border-slate-300 bg-slate-50 px-4 py-2 text-sm font-semibold text-slate-700">
                Reset
            </button>
        </div>
    </div>

    <!-- Drivers Table -->
    <div class="overflow-hidden rounded-xl bg-white shadow-sm">
        <table style="width: 100%; border-collapse: collapse;" id="driversTable">
            <thead>
                <tr style="background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%);">
                    <th style="padding: 14px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #fff; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap;">#</th>
                    <th style="padding: 14px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #fff; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap;">Nama</th>
                    <th style="padding: 14px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #fff; text-transform: uppercase; letter-spacing: 0.5px; white-space:nowrap;">Telepon</th>
                    <th style="padding: 14px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #fff; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap;">No. SIM</th>
                    <th style="padding: 14px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #fff; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap;">Armada</th>
                    <th style="padding: 14px 16px; text-align: center; font-size: 12px; font-weight: 600; color: #fff; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap;">Status</th>
                    <th style="padding: 14px 16px; text-align: center; font-size: 12px; font-weight: 600; color: #fff; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap;">Rating</th>
                    <th style="padding: 14px 16px; text-align: center; font-size: 12px; font-weight: 600; color: #fff; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap;">Total Trip</th>
                    <th style="padding: 14px 16px; text-align: right; font-size: 12px; font-weight: 600; color: #fff; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap;">Saldo</th>
                    <th style="padding: 14px 16px; text-align: center; font-size: 12px; font-weight: 600; color: #fff; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($drivers as $index => $driver)
                <tr style="border-bottom: 1px solid #e5e7eb; transition: background-color 0.15s;" 
                    onmouseover="this.style.backgroundColor='#f8fafc';" 
                    onmouseout="this.style.backgroundColor='transparent';"
                    data-status="{{ $driver->status }}"
                    data-armada="{{ strtolower($driver->armada->name ?? '') }}">
                    
                    <td style="padding: 14px 16px; font-size: 13px; color: #6b7280; font-weight: 500;">{{ $index + 1 }}</td>
                    
                    <td style="padding: 14px 16px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, #2563eb, #7c3aed); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 14px; font-weight: 700; flex-shrink: 0;">
                                {{ strtoupper(substr($driver->name, 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-size: 14px; font-weight: 600; color: #1f2937;">{{ $driver->name }}</div>
                            </div>
                        </div>
                    </td>
                    
                    <td style="padding: 14px 16px; font-size: 13px; color: #4b5563;">{{ $driver->phone }}</td>
                    
                    <td style="padding: 14px 16px; font-size: 13px; color: #4b5563; font-family: 'Courier New', monospace;">{{ $driver->sim_number }}</td>
                    
                    <td style="padding: 14px 16px;">
                        <span style="font-size: 13px; font-weight: 500; color: #1e3a5f;">{{ $driver->armada->name ?? '-' }}</span>
                        @if($driver->armada && $driver->armada->vehicle_type)
                            <div style="font-size: 11px; color: #9ca3af; margin-top: 2px;">{{ $driver->armada->vehicle_type }}</div>
                        @endif
                    </td>
                    
                    <td style="padding: 14px 16px; text-align: center;">
                        @php
                            $statusClass = match($driver->status) {
                                'available' => 'bg-emerald-100 text-emerald-700',
                                'busy' => 'bg-orange-100 text-orange-700',
                                'offline' => 'bg-slate-100 text-slate-700',
                                'on_leave' => 'bg-red-100 text-red-700',
                                default => 'bg-slate-100 text-slate-700',
                            };
                            $statusLabel = str_replace('_', ' ', ucwords($driver->status));
                        @endphp
                        <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-[12px] font-semibold {{ $statusClass }}">
                            <span class="inline-block h-2 w-2 rounded-full bg-current"></span>
                            {{ $statusLabel }}
                        </span>
                    </td>
                    
                    <td style="padding: 14px 16px; text-align: center;">
                        <div style="display: inline-flex; align-items: center; gap: 4px; font-size: 13px; font-weight: 600; color: #1f2937;">
                            <span style="color: #f59e0b;">&#9733;</span>
                            @php
                                $avgRating = \App\Models\Review::where('rated_user_id', $driver->id)->avg('rating');
                            @endphp
                            {{ number_format($avgRating ?? $driver->rating ?? 0, 1) }}
                        </div>
                        <div style="font-size: 11px; color: #9ca3af; margin-top: 2px;">
                            {{ \App\Models\Review::where('rated_user_id', $driver->id)->count() }} ulasan
                        </div>
                    </td>
                    
                    <td style="padding: 14px 16px; text-align: center; font-size: 13px; font-weight: 600; color: #1f2937;">
                        {{ number_format($driver->total_trips ?? 0) }}
                    </td>
                    
                    <td style="padding: 14px 16px; text-align: right;">
                        <div style="font-size: 14px; font-weight: 700; color: #059669;">Rp {{ number_format($driver->balance ?? 0, 0, ',', '.') }}</div>
                    </td>
                    
                    <td style="padding: 14px 16px; text-align: center;">
                        <div style="display: flex; gap: 6px; justify-content: center;">
                            @if($driver->status == 'offline' || $driver->status == 'on_leave')
                                <button data-driver-id="{{ $driver->id }}"
                                        onclick="approveDriver(parseInt(this.dataset.driverId, 10))"
                                        style="padding: 6px 12px; background-color: #16a34a; color: #fff; border: none; border-radius: 5px; font-size: 11px; font-weight: 600; cursor: pointer; transition: background-color 0.2s;"
                                        onmouseover="this.style.backgroundColor='#15803d';"
                                        onmouseout="this.style.backgroundColor='#16a34a';"
                                        title="Setujui / Aktifkan driver ini">
                                    ✓ Setujui
                                </button>
                            @else
                                <button data-driver-id="{{ $driver->id }}"
                                        onclick="viewDetails(parseInt(this.dataset.driverId, 10))"
                                        style="padding: 6px 12px; background-color: #2563eb; color: #fff; border: none; border-radius: 5px; font-size: 11px; font-weight: 600; cursor: pointer; transition: background-color 0.2s;"
                                        onmouseover="this.style.backgroundColor='#1d4ed8';"
                                        onmouseout="this.style.backgroundColor='#2563eb';"
                                        title="Lihat detail driver">
                                    ☰ Detail
                                </button>
                            @endif
                            <button data-driver-id="{{ $driver->id }}"
                                    onclick="viewDetails(parseInt(this.dataset.driverId, 10))"
                                    style="padding: 6px 12px; background-color: #f3f4f6; color: #374151; border: 1px solid #d1d5db; border-radius: 5px; font-size: 11px; font-weight: 600; cursor: pointer; transition: background-color 0.2s;"
                                    onmouseover="this.style.backgroundColor='#e5e7eb';"
                                    onmouseout="this.style.backgroundColor='#f3f4f6';"
                                    title="Quick view">
                                👁
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" style="padding: 60px 20px; text-align: center;">
                        <div style="font-size: 48px; margin-bottom: 12px; opacity: 0.3;">🚗</div>
                        <div style="font-size: 16px; font-weight: 600; color: #6b7280;">Tidak ada driver ditemukan</div>
                        <div style="font-size: 13px; color: #9ca3af; margin-top: 4px;">Driver akan muncul di sini setelah mereka mendaftar di sistem.</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <!-- Pagination -->
        @if($drivers->hasPages())
        <div class="flex flex-wrap items-center justify-between gap-3 border-t border-slate-200 px-5 py-4 text-sm text-slate-500">
            <div>
                Menampilkan {{ $drivers->firstItem() }} hingga {{ $drivers->lastItem() }} dari {{ $drivers->total() }} driver
            </div>
            <div class="flex gap-2">
                {{ $drivers->links() }}
            </div>
        </div>
        @endif
    </div>

    <!-- Footer Info -->
    <div class="mt-4 text-center text-xs text-slate-400">
        Last updated: {{ now()->format('d M Y H:i') }} • Sistem Manajemen Driver • ASR GO
    </div>
</div>

<script>
function applyFilters() {
    var searchTerm = document.getElementById('searchFilter').value.toLowerCase();
    var statusFilter = document.getElementById('statusFilter').value;
    var armadaFilter = document.getElementById('armadaFilter').value;
    var rows = document.getElementById('driversTable').getElementsByTagName('tbody')[0].getElementsByTagName('tr');

    for (var i = 0; i < rows.length; i++) {
        var row = rows[i];
        var nameCell = row.cells[1] ? row.cells[1].textContent.toLowerCase() : '';
        var phoneCell = row.cells[2] ? row.cells[2].textContent.toLowerCase() : '';
        var status = row.getAttribute('data-status') || '';
        var armada = row.getAttribute('data-armada') || '';

        var matchSearch = !searchTerm || nameCell.indexOf(searchTerm) > -1 || phoneCell.indexOf(searchTerm) > -1;
        var matchStatus = !statusFilter || status === statusFilter;
        var matchArmada = !armadaFilter || armada === armadaFilter;

        row.style.display = (matchSearch && matchStatus && matchArmada) ? '' : 'none';
    }
}

function resetFilters() {
    document.getElementById('searchFilter').value = '';
    document.getElementById('statusFilter').value = '';
    document.getElementById('armadaFilter').value = '';
    applyFilters();
}

function approveDriver(id) {
    if (confirm('Yakin ingin menyetujui/mengaktifkan driver ini?')) {
        alert('Driver #' + id + ' berhasil diaktifkan.');
        // window.location.href = '/admin/drivers/' + id + '/approve';
    }
}

function viewDetails(id) {
    alert('View details for Driver #' + id);
    // window.location.href = '/admin/drivers/' + id;
}
</script>
@endsection
