@extends('layouts.app')

@section('title', 'Audit Logs')

@section('content')
<div class="page-header">
    <h1 class="page-title">Audit Logs</h1>
    <p class="page-subtitle">View system activity and user actions</p>
</div>

<!-- Filters -->
<div class="card" style="margin-bottom: 1.5rem;">
    <form method="GET" action="{{ route('admin.audit-logs') }}" style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: flex-end;">
        <div>
            <label class="form-label">User</label>
            <select name="user_id" class="form-input" style="width: 180px;">
                <option value="all" {{ request('user_id') == 'all' ? 'selected' : '' }}>All Users</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="form-label">Action</label>
            <select name="action" class="form-input" style="width: 150px;">
                <option value="all" {{ request('action') == 'all' ? 'selected' : '' }}>All Actions</option>
                @foreach($actions as $action)
                    <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>{{ $action }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="form-label">Model</label>
            <select name="model" class="form-input" style="width: 180px;">
                <option value="all" {{ request('model') == 'all' ? 'selected' : '' }}>All Models</option>
                @foreach($models as $model)
                    <option value="{{ $model }}" {{ request('model') == $model ? 'selected' : '' }}>{{ class_basename($model) }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="form-label">From</label>
            <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-input">
        </div>
        <div>
            <label class="form-label">To</label>
            <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-input">
        </div>
        <button type="submit" class="btn btn-primary">Filter</button>
        <a href="{{ route('admin.audit-logs') }}" class="btn btn-secondary">Reset</a>
    </form>
</div>

<!-- Logs Table -->
<div class="card" style="padding: 0; overflow: hidden;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                <th style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; font-size: 0.85rem; color: #666;">Timestamp</th>
                <th style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; font-size: 0.85rem; color: #666;">User</th>
                <th style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; font-size: 0.85rem; color: #666;">Action</th>
                <th style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; font-size: 0.85rem; color: #666;">Model</th>
                <th style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; font-size: 0.85rem; color: #666;">IP Address</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logs as $log)
            <tr style="border-bottom: 1px solid #f3f4f6;">
                <td style="padding: 0.75rem 1rem; font-size: 0.9rem; color: #666; white-space: nowrap;">
                    {{ $log->created_at->format('d M Y H:i:s') }}
                </td>
                <td style="padding: 0.75rem 1rem; font-weight: 500;">
                    {{ $log->user?->name ?? 'System' }}
                </td>
                <td style="padding: 0.75rem 1rem;">
                    <span style="padding: 0.2rem 0.5rem; border-radius: 0.25rem; font-size: 0.8rem; font-weight: 500;
                        {{ str_contains($log->action, 'delete') ? 'background: #fef2f2; color: #dc2626;' : (str_contains($log->action, 'create') ? 'background: #ecfdf5; color: #059669;' : 'background: #eff6ff; color: #2563eb;') }}">
                        {{ $log->action }}
                    </span>
                </td>
                <td style="padding: 0.75rem 1rem; font-size: 0.9rem; color: #666;">
                    {{ class_basename($log->model_type) }} #{{ $log->model_id ? substr($log->model_id, 0, 8) : 'N/A' }}
                </td>
                <td style="padding: 0.75rem 1rem; font-size: 0.85rem; color: #999; font-family: monospace;">
                    {{ $log->ip_address ?? 'N/A' }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="padding: 2rem; text-align: center; color: #999;">No audit logs found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div style="margin-top: 1.5rem;">
    {{ $logs->links() }}
</div>
@endsection
