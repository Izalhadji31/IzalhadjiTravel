@extends('layouts.app')

@section('title', 'Refund Requests')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Refund Requests</h1>
        <p class="text-gray-600">Manage and process customer refund requests</p>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <p class="text-sm text-gray-600">Pending</p>
            <p class="text-2xl font-bold text-yellow-600">{{ $refunds->where('status', 'pending')->count() }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <p class="text-sm text-gray-600">Approved</p>
            <p class="text-2xl font-bold text-green-600">{{ $refunds->where('status', 'approved')->count() }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <p class="text-sm text-gray-600">Rejected</p>
            <p class="text-2xl font-bold text-red-600">{{ $refunds->where('status', 'rejected')->count() }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Booking</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Reason</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($refunds as $refund)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-900 font-mono">
                            #{{ substr($refund->id, 0, 8) }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $refund->user->name ?? 'N/A' }}</div>
                            <div class="text-sm text-gray-500">{{ $refund->user->email ?? '' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800 capitalize">
                                {{ $refund->type }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                            Rp {{ number_format($refund->amount, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate" title="{{ $refund->reason }}">
                            {{ Str::limit($refund->reason, 50) }}
                        </td>
                        <td class="px-6 py-4">
                            @if($refund->status === 'pending')
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                            @elseif($refund->status === 'approved')
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Approved</span>
                            @else
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">Rejected</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $refund->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if($refund->status === 'pending')
                                <div class="flex gap-2 justify-end">
                                    <form action="{{ route('admin.refunds.approve', $refund) }}" method="POST" onsubmit="return confirm('Approve this refund?')">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 bg-green-600 text-white text-xs font-semibold rounded-lg hover:bg-green-700 transition-colors">
                                            Approve
                                        </button>
                                    </form>
                                    <button onclick="showRejectModal('{{ $refund->id }}')" class="px-3 py-1.5 bg-red-600 text-white text-xs font-semibold rounded-lg hover:bg-red-700 transition-colors">
                                        Reject
                                    </button>
                                </div>
                            @else
                                <span class="text-xs text-gray-400">
                                    {{ $refund->status === 'approved' ? 'Approved' : 'Rejected' }}
                                    @if($refund->processed_at)
                                        <br>{{ $refund->processed_at->format('d M Y') }}
                                    @endif
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <p class="text-gray-500">No refund requests found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($refunds->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $refunds->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-4 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Reject Refund</h3>
        <form id="rejectForm" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Rejection Reason</label>
                <textarea name="rejection_reason" rows="3" required
                          class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-red-500 transition-colors resize-none"
                          placeholder="Explain why the refund is rejected..."></textarea>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-red-600 text-white py-2 px-4 rounded-lg font-semibold hover:bg-red-700 transition-colors">
                    Reject Refund
                </button>
                <button type="button" onclick="hideRejectModal()" class="flex-1 bg-gray-100 text-gray-700 py-2 px-4 rounded-lg font-semibold hover:bg-gray-200 transition-colors">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function showRejectModal(refundId) {
    const modal = document.getElementById('rejectModal');
    const form = document.getElementById('rejectForm');
    form.action = '/admin/refunds/' + refundId + '/reject';
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function hideRejectModal() {
    const modal = document.getElementById('rejectModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
</script>
@endsection
