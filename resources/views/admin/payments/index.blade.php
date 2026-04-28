@extends('layouts.admin')

@section('title', 'Manage Payments')

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-4">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6 md:mb-8">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold" style="color: #1F2937;">Payment Requests</h1>
            <p class="text-base mt-1" style="color: #4B5563;">Approve or reject payment requests from users</p>
        </div>
    </div>
    
    {{-- Status Filter Tabs --}}
    <div class="flex flex-wrap gap-2 mb-6">
        <a href="?status=pending" class="px-4 py-2 rounded-lg text-sm font-semibold transition-all hover:shadow-md" style="{{ request('status') == 'pending' ? 'background-color: #F59E0B; color: #FFFFFF;' : 'background-color: #F3F4F6; color: #374151;' }}">
            Pending ({{ $pendingCount }})
        </a>
        <a href="?status=approved" class="px-4 py-2 rounded-lg text-sm font-semibold transition-all hover:shadow-md" style="{{ request('status') == 'approved' ? 'background-color: #10B981; color: #FFFFFF;' : 'background-color: #F3F4F6; color: #374151;' }}">
            Approved
        </a>
        <a href="?status=rejected" class="px-4 py-2 rounded-lg text-sm font-semibold transition-all hover:shadow-md" style="{{ request('status') == 'rejected' ? 'background-color: #EF4444; color: #FFFFFF;' : 'background-color: #F3F4F6; color: #374151;' }}">
            Rejected
        </a>
        <a href="{{ route('admin.payments.index') }}" class="px-4 py-2 rounded-lg text-sm font-semibold transition-all hover:bg-gray-300" style="background-color: #E5E7EB; color: #374151;">
            All
        </a>
    </div>
    
    <div class="rounded-xl shadow-md overflow-hidden" style="background-color: #FFFFFF;">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[800px]">
                <thead style="background-color: #F9FAFB; border-bottom: 1px solid #E5E7EB;">
                    <tr>
                        <th class="px-4 md:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color: #6B7280;">Date</th>
                        <th class="px-4 md:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color: #6B7280;">User</th>
                        <th class="px-4 md:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color: #6B7280;">Skill</th>
                        <th class="px-4 md:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color: #6B7280;">Phone</th>
                        <th class="px-4 md:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color: #6B7280;">Amount</th>
                        <th class="px-4 md:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color: #6B7280;">Transaction ID</th>
                        <th class="px-4 md:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color: #6B7280;">Status</th>
                        <th class="px-4 md:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color: #6B7280;">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y" style="border-color: #F3F4F6;">
                    @forelse($payments as $payment)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 md:px-6 py-4 text-xs md:text-sm" style="color: #6B7280;">{{ $payment->created_at->format('d M Y') }}</td>
                        <td class="px-4 md:px-6 py-4">
                            <div>
                                <p class="font-semibold text-sm md:text-base" style="color: #1F2937;">{{ $payment->user->name }}</p>
                                <p class="text-xs" style="color: #6B7280;">{{ $payment->user->email }}</p>
                            </div>
                        </td>
                        <td class="px-4 md:px-6 py-4">
                            <span class="text-xs md:text-sm" style="color: #4B5563;">{{ $payment->skill->name }}</span>
                        </td>
                        <td class="px-4 md:px-6 py-4">
                            <span class="text-xs md:text-sm font-mono" style="color: #4B5563;">{{ $payment->phone_number }}</span>
                        </td>
                        <td class="px-4 md:px-6 py-4">
                            <span class="font-bold text-sm md:text-base" style="color: #F57C00;">Tsh {{ number_format($payment->amount) }}</span>
                        </td>
                        <td class="px-4 md:px-6 py-4">
                            <code class="text-xs bg-gray-100 px-2 py-1 rounded" style="color: #4B5563; background-color: #F3F4F6;">{{ $payment->transaction_id }}</code>
                        </td>
                        <td class="px-4 md:px-6 py-4">
                            @if($payment->status == 'approved')
                                <span class="text-xs font-semibold px-2 py-1 rounded-full" style="background-color: #D1FAE5; color: #065F46;">✓ Approved</span>
                            @elseif($payment->status == 'pending')
                                <span class="text-xs font-semibold px-2 py-1 rounded-full" style="background-color: #FEF3C7; color: #92400E;">⏳ Pending</span>
                            @else
                                <span class="text-xs font-semibold px-2 py-1 rounded-full" style="background-color: #FEE2E2; color: #991B1B;">✗ Rejected</span>
                            @endif
                        </td>
                        <td class="px-4 md:px-6 py-4">
                            @if($payment->status == 'pending')
                                <div class="flex flex-wrap items-center gap-2">
                                    <form action="{{ route('admin.payments.approve', $payment) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="font-semibold px-3 py-1.5 rounded-lg text-xs md:text-sm transition-all hover:shadow-md active:scale-95" style="background-color: #10B981; color: #FFFFFF;">
                                            Approve
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.payments.reject', $payment) }}" method="POST" class="inline" onsubmit="return confirm('Reject this payment? User will lose access.')">
                                        @csrf
                                        <button type="submit" class="font-semibold px-3 py-1.5 rounded-lg text-xs md:text-sm transition-all hover:shadow-md active:scale-95" style="background-color: #EF4444; color: #FFFFFF;">
                                            Reject
                                        </button>
                                    </form>
                                </div>
                            @else
                                <span class="text-sm" style="color: #9CA3AF;">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 mb-3 rounded-full flex items-center justify-center" style="background-color: #F3F4F6;">
                                    <i class="fas fa-receipt text-2xl" style="color: #9CA3AF;"></i>
                                </div>
                                <p class="text-base" style="color: #6B7280;">No payments found.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    @if($payments->hasPages())
    <div class="mt-6">
        {{ $payments->links() }}
    </div>
    @endif
</div>

<style>
    button:active, a:active {
        transform: scale(0.98);
    }
    
    @media (max-width: 640px) {
        .px-4 {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }
        .text-sm {
            font-size: 0.75rem;
        }
        .rounded-lg {
            border-radius: 0.5rem;
        }
    }
    
    /* Pagination styling */
    .pagination {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 0.5rem;
    }
    
    .pagination .page-item .page-link {
        padding: 0.5rem 0.75rem;
        border-radius: 0.5rem;
        transition: all 0.2s;
        color: #4B5563;
        background-color: #FFFFFF;
        border: 1px solid #E5E7EB;
    }
    
    .pagination .page-item.active .page-link {
        background-color: #F57C00;
        border-color: #F57C00;
        color: #FFFFFF;
    }
    
    .pagination .page-item .page-link:hover {
        background-color: #FFF3E0;
        border-color: #F57C00;
        color: #F57C00;
    }
</style>
@endsection