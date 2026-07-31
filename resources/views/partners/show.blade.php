@extends('layouts.app')

@section('content')
<div style="max-width: 1100px; margin: 30px auto; padding: 0 20px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <!-- Page Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <div>
            <h1 style="margin: 0; font-size: 28px; color: #1e293b; font-weight: 700;">Partner Detail</h1>
            <p style="margin: 5px 0 0; color: #64748b; font-size: 14px;">View partner information and associated fleet</p>
        </div>
        <div>
            <a href="{{ route('partners.edit', $partner) }}" style="display: inline-block; padding: 10px 20px; background-color: #2563eb; color: #fff; text-decoration: none; border-radius: 6px; font-size: 14px; font-weight: 600; transition: background-color 0.2s;">Edit Partner</a>
            <a href="{{ route('partners.index') }}" style="display: inline-block; padding: 10px 20px; background-color: #f1f5f9; color: #334155; text-decoration: none; border-radius: 6px; font-size: 14px; font-weight: 600; margin-left: 8px; transition: background-color 0.2s;">Back to List</a>
        </div>
    </div>

    <!-- Partner Info Card -->
    <div style="background: #fff; border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); padding: 30px; margin-bottom: 30px; border: 1px solid #e2e8f0;">
        <h2 style="margin: 0 0 20px; font-size: 18px; color: #1e293b; font-weight: 600; border-bottom: 2px solid #2563eb; padding-bottom: 10px;">General Information</h2>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 12px; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 5px;">Name</label>
                <div style="font-size: 16px; color: #1e293b; font-weight: 500;">{{ $partner->name }}</div>
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 12px; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 5px;">Email</label>
                <div style="font-size: 16px; color: #1e293b;">{{ $partner->email }}</div>
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 12px; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 5px;">Phone</label>
                <div style="font-size: 16px; color: #1e293b;">{{ $partner->phone }}</div>
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 12px; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 5px;">City</label>
                <div style="font-size: 16px; color: #1e293b;">{{ $partner->city }}</div>
            </div>
            <div style="margin-bottom: 15px; grid-column: 1 / -1;">
                <label style="display: block; font-size: 12px; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 5px;">Address</label>
                <div style="font-size: 16px; color: #1e293b;">{{ $partner->address }}</div>
            </div>
        </div>
    </div>

    <!-- Bank Info Card -->
    <div style="background: #fff; border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); padding: 30px; margin-bottom: 30px; border: 1px solid #e2e8f0;">
        <h2 style="margin: 0 0 20px; font-size: 18px; color: #1e293b; font-weight: 600; border-bottom: 2px solid #2563eb; padding-bottom: 10px;">Bank Information</h2>
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 12px; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 5px;">Bank Name</label>
                <div style="font-size: 16px; color: #1e293b;">{{ $partner->bank_name ?? '-' }}</div>
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 12px; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 5px;">Bank Account</label>
                <div style="font-size: 16px; color: #1e293b;">{{ $partner->bank_account ?? '-' }}</div>
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 12px; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 5px;">Bank Holder</label>
                <div style="font-size: 16px; color: #1e293b;">{{ $partner->bank_holder ?? '-' }}</div>
            </div>
        </div>
    </div>

    <!-- Financial Info Card -->
    <div style="background: #fff; border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); padding: 30px; margin-bottom: 30px; border: 1px solid #e2e8f0;">
        <h2 style="margin: 0 0 20px; font-size: 18px; color: #1e293b; font-weight: 600; border-bottom: 2px solid #2563eb; padding-bottom: 10px;">Financial & Status</h2>
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 12px; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 5px;">Status</label>
                <div>
                    @if($partner->is_active)
                        <span style="display: inline-block; padding: 4px 12px; background-color: #dcfce7; color: #166534; border-radius: 20px; font-size: 13px; font-weight: 600;">Active</span>
                    @else
                        <span style="display: inline-block; padding: 4px 12px; background-color: #fef2f2; color: #991b1b; border-radius: 20px; font-size: 13px; font-weight: 600;">Inactive</span>
                    @endif
                </div>
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 12px; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 5px;">Revenue Share</label>
                <div style="font-size: 16px; color: #1e293b; font-weight: 600;">{{ $partner->revenue_share_percentage }}%</div>
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 12px; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 5px;">Total Earnings</label>
                <div style="font-size: 20px; color: #059669; font-weight: 700;">Rp {{ number_format($partner->total_earnings, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    <!-- Armadas Table -->
    <div style="background: #fff; border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); padding: 30px; border: 1px solid #e2e8f0;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 style="margin: 0; font-size: 18px; color: #1e293b; font-weight: 600; border-bottom: 2px solid #2563eb; padding-bottom: 10px; flex: 1;">Armada List</h2>
            <span style="background-color: #eff6ff; color: #2563eb; padding: 4px 12px; border-radius: 20px; font-size: 13px; font-weight: 600; margin-left: 15px;">{{ $partner->armadas->count() }} vehicles</span>
        </div>

        @if($partner->armadas->count() > 0)
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                <thead>
                    <tr style="background-color: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                        <th style="padding: 12px 16px; text-align: left; font-weight: 600; color: #475569; text-transform: uppercase; font-size: 12px; letter-spacing: 0.5px;">No</th>
                        <th style="padding: 12px 16px; text-align: left; font-weight: 600; color: #475569; text-transform: uppercase; font-size: 12px; letter-spacing: 0.5px;">Plate Number</th>
                        <th style="padding: 12px 16px; text-align: left; font-weight: 600; color: #475569; text-transform: uppercase; font-size: 12px; letter-spacing: 0.5px;">Vehicle Type</th>
                        <th style="padding: 12px 16px; text-align: center; font-weight: 600; color: #475569; text-transform: uppercase; font-size: 12px; letter-spacing: 0.5px;">Seat Capacity</th>
                        <th style="padding: 12px 16px; text-align: center; font-weight: 600; color: #475569; text-transform: uppercase; font-size: 12px; letter-spacing: 0.5px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($partner->armadas as $index => $armada)
                    <tr style="border-bottom: 1px solid #f1f5f9; transition: background-color 0.15s;" onmouseover="this.style.backgroundColor='#f8fafc';" onmouseout="this.style.backgroundColor='transparent';">
                        <td style="padding: 12px 16px; color: #64748b;">{{ $index + 1 }}</td>
                        <td style="padding: 12px 16px; color: #1e293b; font-weight: 600;">{{ $armada->plate_number }}</td>
                        <td style="padding: 12px 16px; color: #334155;">{{ $armada->vehicle_type }}</td>
                        <td style="padding: 12px 16px; text-align: center; color: #334155;">{{ $armada->seat_capacity }}</td>
                        <td style="padding: 12px 16px; text-align: center;">
                            @if($armada->status == 'active')
                                <span style="display: inline-block; padding: 3px 10px; background-color: #dcfce7; color: #166534; border-radius: 12px; font-size: 12px; font-weight: 600;">Active</span>
                            @elseif($armada->status == 'maintenance')
                                <span style="display: inline-block; padding: 3px 10px; background-color: #fef3c7; color: #92400e; border-radius: 12px; font-size: 12px; font-weight: 600;">Maintenance</span>
                            @else
                                <span style="display: inline-block; padding: 3px 10px; background-color: #f1f5f9; color: #64748b; border-radius: 12px; font-size: 12px; font-weight: 600;">{{ ucfirst($armada->status) }}</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div style="text-align: center; padding: 40px 20px; color: #94a3b8;">
            <p style="margin: 0; font-size: 15px;">No armadas registered for this partner.</p>
        </div>
        @endif
    </div>
</div>
@endsection
