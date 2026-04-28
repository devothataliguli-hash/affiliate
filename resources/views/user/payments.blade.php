@extends('layouts.user')

@section('title', 'My Payments')

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-4">
    <div class="mb-6 md:mb-8">
        <h1 class="text-2xl md:text-3xl font-bold" style="color: #1F2937;">Payment History</h1>
        <p class="text-base mt-1" style="color: #4B5563;">Track your payment requests and approvals</p>
    </div>
    
    @if($payments->count() > 0)
        <div class="rounded-xl shadow-md overflow-hidden" style="background-color: #FFFFFF;">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[500px]">
                    <thead style="background-color: #F9FAFB; border-bottom: 1px solid #E5E7EB;">
                        <tr>
                            <th class="px-4 md:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color: #6B7280;">Transaction ID</th>
                            <th class="px-4 md:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color: #6B7280;">Skill</th>
                            <th class="px-4 md:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color: #6B7280;">Amount</th>
                            <th class="px-4 md:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color: #6B7280;">Status</th>
                            <th class="px-4 md:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color: #6B7280;">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y" style="border-color: #F3F4F6;">
                        @foreach($payments as $payment)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 md:px-6 py-3 text-xs md:text-sm font-mono" style="color: #4B5563;">{{ $payment->transaction_id }}</td>
                            <td class="px-4 md:px-6 py-3 text-xs md:text-sm font-medium" style="color: #1F2937;">{{ $payment->skill->name }}</td>
                            <td class="px-4 md:px-6 py-3 text-xs md:text-sm font-semibold" style="color: #F57C00;">Tsh {{ number_format($payment->amount) }}</td>
                            <td class="px-4 md:px-6 py-3">
                                @if($payment->status == 'approved')
                                    <span class="text-xs font-semibold px-2 py-1 rounded-full" style="background-color: #D1FAE5; color: #065F46;">✓ Approved</span>
                                @elseif($payment->status == 'pending')
                                    <span class="text-xs font-semibold px-2 py-1 rounded-full" style="background-color: #FEF3C7; color: #92400E;">⏳ Pending</span>
                                @elseif($payment->status == 'rejected')
                                    <span class="text-xs font-semibold px-2 py-1 rounded-full" style="background-color: #FEE2E2; color: #991B1B;">✗ Rejected</span>
                                @else
                                    <span class="text-xs font-semibold px-2 py-1 rounded-full" style="background-color: #F3F4F6; color: #6B7280;">{{ ucfirst($payment->status) }}</span>
                                @endif
                            </td>
                            <td class="px-4 md:px-6 py-3 text-xs md:text-sm" style="color: #6B7280;">{{ $payment->created_at->format('d M Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="mt-5">
            {{ $payments->links() }}
        </div>
    @else
        <div class="rounded-xl shadow-md p-8 text-center" style="background-color: #FFFFFF;">
            <div class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center" style="background-color: #F3F4F6;">
                <i class="fas fa-receipt text-2xl" style="color: #9CA3AF;"></i>
            </div>
            <h3 class="text-lg font-semibold mb-2" style="color: #1F2937;">No Payments Yet</h3>
            <p class="mb-5" style="color: #6B7280;">You haven't made any payment requests. Start by purchasing a skill!</p>
            <a href="{{ route('user.dashboard') }}" class="inline-block font-semibold px-6 py-2.5 rounded-lg transition hover:shadow-md" style="background-color: #F57C00; color: #FFFFFF;">
                Browse Skills
            </a>
        </div>
    @endif
    
    {{-- M-Pesa Instructions with improved contrast --}}
    <div class="mt-8 rounded-xl p-5 md:p-6 border" style="background-color: #EFF6FF; border-color: #BFDBFE;">
        <div class="flex items-start gap-3">
            <i class="fas fa-info-circle text-xl mt-0.5" style="color: #2563EB;"></i>
            <div class="flex-1">
                <h3 class="font-semibold mb-2 text-base md:text-lg" style="color: #1E3A8A;">How to Complete Your Payment</h3>
                <p class="text-sm mb-2" style="color: #1E40AF;">To make a payment via M-Pesa:</p>
                <ol class="text-sm space-y-1.5 list-decimal list-inside" style="color: #1E3A8A;">
                    <li>Go to M-Pesa on your phone</li>
                    <li>Select "Lipa na M-Pesa"</li>
                    <li>Enter Business Number: <strong style="color: #F57C00;">0765289993</strong> (Elias Shamlamba)</li>
                    <li>Enter the amount shown for your selected skill</li>
                    <li>Enter your M-Pesa PIN to complete the transaction</li>
                    <li>Your payment will be approved within 24 hours</li>
                </ol>
                <p class="text-xs mt-4" style="color: #2563EB;">
                    <i class="fas fa-phone"></i> Need help? Contact us on WhatsApp: <strong>0626 549 262</strong>
                </p>
            </div>
        </div>
    </div>
</div>

<style>
    /* Mobile table improvements */
    @media (max-width: 640px) {
        table {
            font-size: 12px;
        }
        th, td {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
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