@extends('layouts.app')

@section('content')
<div style="padding: 24px; background-color: #f0f4f8; min-height: 100vh; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    
    <!-- Page Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1 style="font-size: 26px; font-weight: 700; color: #1e3a5f; margin: 0;">Driver / Sopir Management</h1>
            <p style="font-size: 14px; color: #6b7c93; margin: 4px 0 0 0;">Manage and monitor all registered drivers in the system</p>
        </div>
        <div style="display: flex; gap: 10px;">
            <span style="background-color: #2563eb; color: #fff; padding: 8px 16px; border-radius: 6px; font-size: 13px; font-weight: 600;">
                Total Drivers: {{ $drivers->count() }}
            </span>
            <span style="background-color: #16a34a; color: #fff; padding: 8px 16px; border-radius: 6px; font-size: 13px; font-weight: 600;">
                Active: {{ $drivers->whereIn('status', ['available', 'busy'])->count() }}
            </span>
        </div>
    </div>

    <!-- Stats Cards -->
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px;">
        <div style="background: #fff; border-radius: 10px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); border-left: 4px solid #22c55e;">
            <div style="font-size: 12px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">Available</div>
            <div style="font-size: 28px; font-weight: 700; color: #16a34a;">{{ $drivers->where('status', 'available')->count() }}</div>
        </div>
        <div style="background: #fff; border-radius: 10px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); border-left: 4px solid #f97316;">
            <div style="font-size: 12px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">On Trip</div>
            <div style="font-size: 28px; font-weight: 700; color: #ea580c;">{{ $drivers->where('status', 'busy')->count() }}</div>
        </div>
        <div style="background: #fff; border-radius: 10px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); border-left: 4px solid #9ca3af;">
            <div style="font-size: 12px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">Offline</div>
            <div style="font-size: 28px; font-weight: 700; color: #4b5563;">{{ $drivers->where('status', 'offline')->count() }}</div>
        </div>
        <div style="background: #fff; border-radius: 10px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); border-left: 4px solid #ef4444;">
            <div style="font-size: 12px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">On Leave</div>
            <div style="font-size: 28px; font-weight: 700; color: #dc2626;">{{ $drivers->where('status', 'on_leave')->count() }}</div>
        </div>
    </div>

    <!-- Filter Section -->
    <div style="background: #fff; border-radius: 10px; padding: 20px; margin-bottom: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
        <div style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
            <div style="font-size: 14px; font-weight: 600; color: #374151;">Filters:</div>
            
            <input type="text" id="searchFilter" placeholder="Search name or phone..." 
                   style="padding: 8px 14px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 13px; width: 220px; outline: none;"
                   onkeydown="if(event.key==='Enter') applyFilters()">
            
            <select id="statusFilter" style="padding: 8px 14px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 13px; background: #fff; outline: none; cursor: pointer;">
                <option value="">All Statuses</option>
                <option value="available">Available</option>
                <option value="busy">Busy</option>
                <option value="offline">Offline</option>
                <option value="on_leave">On Leave</option>
            </select>
            
            <select id="armadaFilter" style="padding: 8px 14px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 13px; background: #fff; outline: none; cursor: pointer;">
                <option value="">All Armadas</option>
                @foreach($drivers->pluck('armada.name')->unique()->filter() as $armadaName)
                    <option value="{{ strtolower($armadaName) }}">{{ $armadaName }}</option>
                @endforeach
            </select>
            
            <button onclick="applyFilters()" style="padding: 8px 18px; background-color: #2563eb; color: #fff; border: none; border-radius: 6px; font-size: 13px; font-weight: 600; cursor: pointer;">
                Apply
            </button>
            <button onclick="resetFilters()" style="padding: 8px 18px; background-color: #f3f4f6; color: #374151; border: 1px solid #d1d5db; border-radius: 6px; font-size: 13px; font-weight: 600; cursor: pointer;">
                Reset
            </button>
        </div>
    </div>

    <!-- Drivers Table -->
    <div style="background: #fff; border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse;" id="driversTable">
            <thead>
                <tr style="background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%);">
                    <th style="padding: 14px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #fff; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap;">#</th>
                    <th style="padding: 14px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #fff; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap;">Name</th>
                    <th style="padding: 14px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #fff; text-transform: uppercase; letter-spacing: 0.5px; white-space:nowrap;">Phone</th>
                    <th style="padding: 14px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #fff; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap;">SIM Number</th>
                    <th style="padding: 14px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #fff; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap;">Armada</th>
                    <th style="padding: 14px 16px; text-align: center; font-size: 12px; font-weight: 600; color: #fff; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap;">Status</th>
                    <th style="padding: 14px 16px; text-align: center; font-size: 12px; font-weight: 600; color: #fff; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap;">Rating</th>
                    <th style="padding: 14px 16px; text-align: center; font-size: 12px; font-weight: 600; color: #fff; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap;">Total Trips</th>
                    <th style="padding: 14px 16px; text-align: right; font-size: 12px; font-weight: 600; color: #fff; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap;">Earnings (Balance)</th>
                    <th style="padding: 14px 16px; text-align: center; font-size: 12px; font-weight: 600; color: #fff; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap;">Actions</th>
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
                            $statusStyles = [
                                'available' => ['bg' => '#dcfce7', 'text' => '#16a34a', 'dot' => '#22c55e'],
                                'busy' => ['bg' => '#ffedd5', 'text' => '#ea580c', 'dot' => '#f97316'],
                                'offline' => ['bg' => '#f3f4f6', 'text' => '#4b5563', 'dot' => '#9ca3af'],
                                'on_leave' => ['bg' => '#fee2e2', 'text' => '#dc2626', 'dot' => '#ef4444'],
                            ];
                            $style = $statusStyles[$driver->status] ?? ['bg' => '#f3f4f6', 'text' => '#4b5563', 'dot' => '#9ca3af'];
                            $statusLabel = str_replace('_', ' ', ucwords($driver->status));
                        @endphp
                        <span style="display: inline-flex; align-items: center; gap: 6px; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; background-color: {{ $style['bg'] }}; color: {{ $style['text'] }};">
                            <span style="width: 7px; height: 7px; border-radius: 50%; background-color: {{ $style['dot'] }}; display: inline-block;"></span>
                            {{ $statusLabel }}
                        </span>
                    </td>
                    
                    <td style="padding: 14px 16px; text-align: center;">
                        <div style="display: inline-flex; align-items: center; gap: 4px; font-size: 13px; font-weight: 600; color: #1f2937;">
                            <span style="color: #f59e0b;">&#9733;</span>
                            {{ number_format($driver->rating ?? 0, 1) }}
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
                                <button onclick="approveDriver({{ $driver->id }})" 
                                        style="padding: 6px 12px; background-color: #16a34a; color: #fff; border: none; border-radius: 5px; font-size: 11px; font-weight: 600; cursor: pointer; transition: background-color 0.2s;"
                                        onmouseover="this.style.backgroundColor='#15803d';"
                                        onmouseout="this.style.backgroundColor='#16a34a';"
                                        title="Approve / Activate this driver">
                                    ✓ Approve
                                </button>
                            @else
                                <button 
                                        style="padding: 6px 12px; background-color: #2563eb; color: #fff; border: none; border-radius: 5px; font-size: 11px; font-weight: 600; cursor: pointer; transition: background-color 0.2s;"
                                        onmouseover="this.style.backgroundColor='#1d4ed8';"
                                        onmouseout="this.style.backgroundColor='#2563eb';"
                                        title="View driver details">
                                    ☰ Details
                                </button>
                            @endif
                            <button onclick="viewDetails({{ $driver->id }})" 
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
                        <div style="font-size: 16px; font-weight: 600; color: #6b7280;">No drivers found</div>
                        <div style="font-size: 13px; color: #9ca3af; margin-top: 4px;">Drivers will appear here once they register in the system.</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <!-- Pagination -->
        @if($drivers->hasPages())
        <div style="padding: 16px 20px; border-top: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center;">
            <div style="font-size: 13px; color: #6b7280;">
                Showing {{ $drivers->firstItem() }} to {{ $drivers->lastItem() }} of {{ $drivers->total() }} drivers
            </div>
            <div style="display: flex; gap: 8px;">
                {{ $drivers->links() }}
            </div>
        </div>
        @endif
    </div>

    <!-- Footer Info -->
    <div style="margin-top: 16px; text-align: center; font-size: 12px; color: #9ca3af;">
        Last updated: {{ now()->format('d M Y H:i') }} • Driver Management System • ASR GO
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
    if (confirm('Are you sure you want to approve/activate this driver?')) {
        alert('Driver #' + id + ' has been activated successfully.');
        // window.location.href = '/admin/drivers/' + id + '/approve';
    }
}

function viewDetails(id) {
    alert('View details for Driver #' + id);
    // window.location.href = '/admin/drivers/' + id;
}
</script>
@endsection
