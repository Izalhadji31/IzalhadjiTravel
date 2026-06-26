@extends('layouts.app')

@section('title', 'My Refunds')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">My Refund Requests</h1>
        <p class="text-gray-600">Track your refund request status</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($refunds as $refund)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-mono text-gray-900">#{{ substr($refund->id, 0, 8) }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800 capitalize">{{ $refund->type }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm font-semibold text-gray-900">Rp {{ number_format($refund->amount, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            @if($refund->status === 'pending')
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                            @elseif($refund->status === 'approved')
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Approved</span>
                            @else
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">Rejected</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $refund->created_at->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">No refund requests found.</td>
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
@endsection
