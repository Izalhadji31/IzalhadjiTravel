@extends('layouts.app')

@section('content')
<div style="padding: 24px; background-color: #f1f5f9; min-height: 100vh;">
    <!-- Page Header -->
    <div style="margin-bottom: 24px;">
        <h1 style="font-size: 24px; font-weight: 700; color: #1e293b; margin: 0;">Booking Management</h1>
        <p style="font-size: 14px; color: #64748b; margin: 4px 0 0 0;">Manage all travel and rental bookings</p>
    </div>

    <!-- Stats Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px; margin-bottom: 24px;">
        <div style="background: #ffffff; border-radius: 8px; padding: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); border-left: 4px solid #f59e0b;">
            <div style="font-size: 12px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Pending</div>
            <div style="font-size: 28px; font-weight: 700; color: #f59e0b; margin-top: 4px;">{{ $travelBookings->where('status', 'pending')->count() + $rentalBookings->where('status', 'pending')->count() }}</div>
        </div>
        <div style="background: #ffffff; border-radius: 8px; padding: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); border-left: 4px solid #3b82f6;">
            <div style="font-size: 12px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Confirmed</div>
            <div style="font-size: 28px; font-weight: 700; color: #3b82f6; margin-top: 4px;">{{ $travelBookings->where('status', 'confirmed')->count() + $rentalBookings->where('status', 'confirmed')->count() }}</div>
        </div>
        <div style="background: #ffffff; border-radius: 8px; padding: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); border-left: 4px solid #f97316;">
            <div style="font-size: 12px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Departed</div>
            <div style="font-size: 28px; font-weight: 700; color: #f97316; margin-top: 4px;">{{ $travelBookings->where('status', 'departed')->count() + $rentalBookings->where('status', 'departed')->count() }}</div>
        </div>
        <div style="background: #ffffff; border-radius: 8px; padding: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); border-left: 4px solid #22c55e;">
            <div style="font-size: 12px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Completed</div>
            <div style="font-size: 28px; font-weight: 700; color: #22c55e; margin-top: 4px;">{{ $travelBookings->where('status', 'completed')->count() + $rentalBookings->where('status', 'completed')->count() }}</div>
        </div>
        <div style="background: #ffffff; border-radius: 8px; padding: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); border-left: 4px solid #ef4444;">
            <div style="font-size: 12px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Cancelled</div>
            <div style="font-size: 28px; font-weight: 700; color: #ef4444; margin-top: 4px;">{{ $travelBookings->where('status', 'cancelled')->count() + $rentalBookings->where('status', 'cancelled')->count() }}</div>
        </div>
    </div>

    <!-- Main Card -->
    <div style="background: #ffffff; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); overflow: hidden;">
        <!-- Filter Bar -->
        <div style="padding: 16px 20px; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
            <div style="display: flex; align-items: center; gap: 4px; flex-wrap: wrap;">
                <a href="{{ route('admin.bookings') }}" style="display: inline-block; padding: 6px 14px; border-radius: 6px; font-size: 13px; font-weight: 500; text-decoration: none; transition: all 0.15s; {{ request('status') === null || request('status') === '' ? 'background-color: #2563eb; color: #ffffff;' : 'background-color: #f1f5f9; color: #475569; hover:background-color: #e2e8f0;' }}">All</a>
                <a href="{{ route('admin.bookings', ['status' => 'pending']) }}" style="display: inline-block; padding: 6px 14px; border-radius: 6px; font-size: 13px; font-weight: 500; text-decoration: none; transition: all 0.15s; {{ request('status') === 'pending' ? 'background-color: #f59e0b; color: #ffffff;' : 'background-color: #f1f5f9; color: #475569;' }}">Pending</a>
                <a href="{{ route('admin.bookings', ['status' => 'confirmed']) }}" style="display: inline-block; padding: 6px 14px; border-radius: 6px; font-size: 13px; font-weight: 500; text-decoration: none; transition: all 0.15s; {{ request('status') === 'confirmed' ? 'background-color: #3b82f6; color: #ffffff;' : 'background-color: #f1f5f9; color: #475569;' }}">Confirmed</a>
                <a href="{{ route('admin.bookings', ['status' => 'departed']) }}" style="display: inline-block; padding: 6px 14px; border-radius: 6px; font-size: 13px; font-weight: 500; text-decoration: none; transition: all 0.15s; {{ request('status') === 'departed' ? 'background-color: #f97316; color: #ffffff;' : 'background-color: #f1f5f9; color: #475569;' }}">Departed</a>
                <a href="{{ route('admin.bookings', ['status' => 'completed']) }}" style="display: inline-block; padding: 6px 14px; border-radius: 6px; font-size: 13px; font-weight: 500; text-decoration: none; transition: all 0.15s; {{ request('status') === 'completed' ? 'background-color: #22c55e; color: #ffffff;' : 'background-color: #f1f5f9; color: #475569;' }}">Completed</a>
                <a href="{{ route('admin.bookings', ['status' => 'cancelled']) }}" style="display: inline-block; padding: 6px 14px; border-radius: 6px; font-size: 13px; font-weight: 500; text-decoration: none; transition: all 0.15s; {{ request('status') === 'cancelled' ? 'background-color: #ef4444; color: #ffffff;' : 'background-color: #f1f5f9; color: #475569;' }}">Cancelled</a>
            </div>
            <div style="font-size: 13px; color: #64748b;">
                Total: <strong style="color: #1e293b;">{{ $travelBookings->count() + $rentalBookings->count() }}</strong> bookings
            </div>
        </div>

        <!-- Table -->
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f8fafc;">
                        <th style="padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #e2e8f0;">Code</th>
                        <th style="padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #e2e8f0;">Customer</th>
                        <th style="padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #e2e8f0;">Type</th>
                        <th style="padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #e2e8f0;">Route / Vehicle</th>
                        <th style="padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #e2e8f0;">Date</th>
                        <th style="padding: 12px 16px; text-align: right; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #e2e8f0;">Price</th>
                        <th style="padding: 12px 16px; text-align: center; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #e2e8f0;">Status</th>
                        <th style="padding: 12px 16px; text-align: center; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #e2e8f0;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $status = request('status', '');
                        $filteredTravel = $status ? $travelBookings->where('status', $status) : $travelBookings;
                        $filteredRental = $status ? $rentalBookings->where('status', $status) : $rentalBookings;
                    @endphp

                    @forelse($filteredTravel as $booking)
                    <tr style="border-bottom: 1px solid #f1f5f9; transition: background-color 0.15s;" onmouseover="this.style.backgroundColor='#f8fafc';" onmouseout="this.style.backgroundColor='transparent';">
                        <td style="padding: 12px 16px; font-size: 13px; font-weight: 600; color: #2563eb;">{{ $booking->booking_code ?? $booking->kode_booking ?? '#' . $booking->id }}</td>
                        <td style="padding: 12px 16px; font-size: 13px; color: #1e293b;">{{ $booking->customer->name ?? $booking->nama_pelanggan ?? '-' }}</td>
                        <td style="padding: 12px 16px;">
                            <span style="display: inline-block; padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: 600; background-color: #dbeafe; color: #1d4ed8;">Travel</span>
                        </td>
                        <td style="padding: 12px 16px; font-size: 13px; color: #475569;">{{ $booking->route ?? $booking->rute ?? ($booking->origin ?? '') . ' → ' . ($booking->destination ?? '') }}</td>
                        <td style="padding: 12px 16px; font-size: 13px; color: #475569;">{{ isset($booking->date) ? \Carbon\Carbon::parse($booking->date)->format('d M Y') : (isset($booking->tanggal) ? \Carbon\Carbon::parse($booking->tanggal)->format('d M Y') : '-') }}</td>
                        <td style="padding: 12px 16px; font-size: 13px; font-weight: 600; color: #1e293b; text-align: right;">Rp {{ number_format($booking->price ?? $booking->harga ?? 0, 0, ',', '.') }}</td>
                        <td style="padding: 12px 16px; text-align: center;">
                            @php $s = $booking->status; @endphp
                            <span style="display: inline-block; padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 600; text-transform: capitalize;
                                {{ $s === 'pending' ? 'background-color:#fef3c7;color:#92400e;' : '' }}
                                {{ $s === 'confirmed' ? 'background-color:#dbeafe;color:#1e40af;' : '' }}
                                {{ $s === 'departed' ? 'background-color:#ffedd5;color:#9a3412;' : '' }}
                                {{ $s === 'completed' ? 'background-color:#dcfce7;color:#166534;' : '' }}
                                {{ $s === 'cancelled' ? 'background-color:#fee2e2;color:#991b1b;' : '' }}">
                                {{ ucfirst($s) }}
                            </span>
                        </td>
                        <td style="padding: 12px 16px; text-align: center;">
                            <div style="display: flex; gap: 6px; justify-content: center; align-items: center;">
                                @php
                                    $bookingType = $booking->number_of_seats !== null ? 'travel' : 'rental';
                                @endphp
                                <a href="{{ route('admin.bookings.show', ['type' => $bookingType, 'id' => $booking->id]) }}" style="padding: 4px 10px; border-radius: 4px; font-size: 11px; font-weight: 600; background-color: #64748b; color: #ffffff; border: none; cursor: pointer; text-decoration: none; transition: background-color 0.15s; display: inline-flex; align-items: center; gap: 3px;" onmouseover="this.style.backgroundColor='#475569';" onmouseout="this.style.backgroundColor='#64748b';">
                                    <svg style="width: 12px; height: 12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    View
                                </a>
                                @if($s === 'pending')
                                <button type="button" onclick="openArmadaModal('{{ route('admin.bookings.approve', ['type' => $bookingType, 'id' => $booking->id]) }}')" style="padding: 4px 10px; border-radius: 4px; font-size: 11px; font-weight: 600; background-color: #3b82f6; color: #ffffff; border: none; cursor: pointer; transition: background-color 0.15s;" onmouseover="this.style.backgroundColor='#2563eb';" onmouseout="this.style.backgroundColor='#3b82f6';">Approve</button>
                                @endif
                                @if($s === 'confirmed' || $s === 'departed')
                                <form action="{{ route('admin.bookings.complete', ['type' => $bookingType, 'id' => $booking->id]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" style="padding: 4px 10px; border-radius: 4px; font-size: 11px; font-weight: 600; background-color: #22c55e; color: #ffffff; border: none; cursor: pointer; transition: background-color 0.15s;" onmouseover="this.style.backgroundColor='#16a34a';" onmouseout="this.style.backgroundColor='#22c55e';">Complete</button>
                                </form>
                                @endif
                                @if($s !== 'cancelled' && $s !== 'completed')
                                <form action="{{ route('admin.bookings.cancel', ['type' => $bookingType, 'id' => $booking->id]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Are you sure you want to cancel this booking?');" style="padding: 4px 10px; border-radius: 4px; font-size: 11px; font-weight: 600; background-color: #ef4444; color: #ffffff; border: none; cursor: pointer; transition: background-color 0.15s;" onmouseover="this.style.backgroundColor='#dc2626';" onmouseout="this.style.backgroundColor='#ef4444';">Cancel</button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    @if($filteredRental->isEmpty())
                    <tr>
                        <td colspan="8" style="padding: 48px 16px; text-align: center; color: #94a3b8; font-size: 14px;">
                            <div style="font-size: 40px; margin-bottom: 8px;">📋</div>
                            No bookings found for this filter.
                        </td>
                    </tr>
                    @endif
                    @endforelse

                    @forelse($filteredRental as $booking)
                    <tr style="border-bottom: 1px solid #f1f5f9; transition: background-color 0.15s;" onmouseover="this.style.backgroundColor='#f8fafc';" onmouseout="this.style.backgroundColor='transparent';">
                        <td style="padding: 12px 16px; font-size: 13px; font-weight: 600; color: #2563eb;">{{ $booking->booking_code ?? $booking->kode_booking ?? '#' . $booking->id }}</td>
                        <td style="padding: 12px 16px; font-size: 13px; color: #1e293b;">{{ $booking->customer->name ?? $booking->nama_pelanggan ?? '-' }}</td>
                        <td style="padding: 12px 16px;">
                            <span style="display: inline-block; padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: 600; background-color: #e0e7ff; color: #4338ca;">Rental</span>
                        </td>
                        <td style="padding: 12px 16px; font-size: 13px; color: #475569;">{{ $booking->vehicle->name ?? $booking->kendaraan->nama ?? ($booking->vehicle ?? '-') }}</td>
                        <td style="padding: 12px 16px; font-size: 13px; color: #475569;">{{ isset($booking->date) ? \Carbon\Carbon::parse($booking->date)->format('d M Y') : (isset($booking->tanggal) ? \Carbon\Carbon::parse($booking->tanggal)->format('d M Y') : '-') }}</td>
                        <td style="padding: 12px 16px; font-size: 13px; font-weight: 600; color: #1e293b; text-align: right;">Rp {{ number_format($booking->price ?? $booking->harga ?? 0, 0, ',', '.') }}</td>
                        <td style="padding: 12px 16px; text-align: center;">
                            @php $s = $booking->status; @endphp
                            <span style="display: inline-block; padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 600; text-transform: capitalize;
                                {{ $s === 'pending' ? 'background-color:#fef3c7;color:#92400e;' : '' }}
                                {{ $s === 'confirmed' ? 'background-color:#dbeafe;color:#1e40af;' : '' }}
                                {{ $s === 'departed' ? 'background-color:#ffedd5;color:#9a3412;' : '' }}
                                {{ $s === 'completed' ? 'background-color:#dcfce7;color:#166534;' : '' }}
                                {{ $s === 'cancelled' ? 'background-color:#fee2e2;color:#991b1b;' : '' }}">
                                {{ ucfirst($s) }}
                            </span>
                        </td>
                        <td style="padding: 12px 16px; text-align: center;">
                            <div style="display: flex; gap: 6px; justify-content: center; align-items: center;">
                                @php
                                    $bookingType = $booking->number_of_seats !== null ? 'travel' : 'rental';
                                @endphp
                                <a href="{{ route('admin.bookings.show', ['type' => $bookingType, 'id' => $booking->id]) }}" style="padding: 4px 10px; border-radius: 4px; font-size: 11px; font-weight: 600; background-color: #64748b; color: #ffffff; border: none; cursor: pointer; text-decoration: none; transition: background-color 0.15s; display: inline-flex; align-items: center; gap: 3px;" onmouseover="this.style.backgroundColor='#475569';" onmouseout="this.style.backgroundColor='#64748b';">
                                    <svg style="width: 12px; height: 12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    View
                                </a>
                                @if($s === 'pending')
                                <button type="button" onclick="openArmadaModal('{{ route('admin.bookings.approve', ['type' => $bookingType, 'id' => $booking->id]) }}')" style="padding: 4px 10px; border-radius: 4px; font-size: 11px; font-weight: 600; background-color: #3b82f6; color: #ffffff; border: none; cursor: pointer; transition: background-color 0.15s;" onmouseover="this.style.backgroundColor='#2563eb';" onmouseout="this.style.backgroundColor='#3b82f6';">Approve</button>
                                @endif
                                @if($s === 'confirmed' || $s === 'departed')
                                <form action="{{ route('admin.bookings.complete', ['type' => $bookingType, 'id' => $booking->id]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" style="padding: 4px 10px; border-radius: 4px; font-size: 11px; font-weight: 600; background-color: #22c55e; color: #ffffff; border: none; cursor: pointer; transition: background-color 0.15s;" onmouseover="this.style.backgroundColor='#16a34a';" onmouseout="this.style.backgroundColor='#22c55e';">Complete</button>
                                </form>
                                @endif
                                @if($s !== 'cancelled' && $s !== 'completed')
                                <form action="{{ route('admin.bookings.cancel', ['type' => $bookingType, 'id' => $booking->id]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Are you sure you want to cancel this booking?');" style="padding: 4px 10px; border-radius: 4px; font-size: 11px; font-weight: 600; background-color: #ef4444; color: #ffffff; border: none; cursor: pointer; transition: background-color 0.15s;" onmouseover="this.style.backgroundColor='#dc2626';" onmouseout="this.style.backgroundColor='#ef4444';">Cancel</button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    @if($filteredTravel->isEmpty())
                    <tr>
                        <td colspan="8" style="padding: 48px 16px; text-align: center; color: #94a3b8; font-size: 14px;">
                            <div style="font-size: 40px; margin-bottom: 8px;">📋</div>
                            No bookings found for this filter.
                        </td>
                    </tr>
                    @endif
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Footer -->
        <div style="padding: 12px 20px; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; font-size: 13px; color: #64748b;">
            <span>Showing {{ $filteredTravel->count() + $filteredRental->count() }} of {{ $travelBookings->count() + $rentalBookings->count() }} bookings</span>
            <span>Last updated: {{ now()->format('d M Y H:i') }}</span>
        </div>
    </div>
</div>

<!-- Armada Selection Modal -->
<div id="armadaModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100; align-items: center; justify-content: center;">
    <div style="background: #ffffff; border-radius: 8px; padding: 24px; max-width: 440px; width: 90%; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
        <h3 style="font-size: 18px; font-weight: 600; color: #1e293b; margin: 0 0 8px 0;">Assign Armada</h3>
        <p style="font-size: 13px; color: #64748b; margin: 0 0 16px 0;">Select an available armada to assign before confirming this booking:</p>
        <form id="armadaApproveForm" method="POST">
            @csrf
            <select name="armada_id" id="armadaSelect" style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 13px; color: #1e293b; background-color: #ffffff; margin-bottom: 16px;">
                <option value="">-- Select Available Armada --</option>
                @php
                    $availableArmadas = \App\Models\Armada::where('status', 'tersedia')->orderBy('plate_number')->get();
                @endphp
                @forelse($availableArmadas as $armada)
                <option value="{{ $armada->id }}">{{ $armada->plate_number }} — {{ $armada->driver_name }} ({{ $armada->vehicle_type }}, {{ $armada->seat_capacity }} seats)</option>
                @empty
                <option value="" disabled>No armadas currently available</option>
                @endforelse
            </select>
            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" onclick="closeArmadaModal()" style="padding: 8px 16px; border-radius: 6px; font-size: 13px; font-weight: 500; background-color: #f1f5f9; color: #475569; border: none; cursor: pointer;">Cancel</button>
                <button type="submit" style="padding: 8px 16px; border-radius: 6px; font-size: 13px; font-weight: 600; background-color: #3b82f6; color: #ffffff; border: none; cursor: pointer;">Confirm & Approve</button>
            </div>
        </form>
    </div>
</div>

<script>
let currentApproveUrl = '';
function openArmadaModal(url) {
    currentApproveUrl = url;
    document.getElementById('armadaModal').style.display = 'flex';
}
function closeArmadaModal() {
    document.getElementById('armadaModal').style.display = 'none';
    document.getElementById('armadaApproveForm').reset();
}
document.getElementById('armadaModal').addEventListener('click', function(e) {
    if (e.target === this) closeArmadaModal();
});
document.getElementById('armadaApproveForm').addEventListener('submit', function(e) {
    const armadaId = document.getElementById('armadaSelect').value;
    if (!armadaId) {
        alert('Please select an armada to assign before approving.');
        e.preventDefault();
        return;
    }
    this.action = currentApproveUrl;
});
</script>
@endsection
