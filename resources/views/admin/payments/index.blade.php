@extends('layouts.admin')

@section('title', 'Payments')
@section('page-title', 'Payment Transactions')

@section('content')
<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Skill</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($payments as $payment)
            <tr>
                <td class="px-6 py-4">{{ $payment->user->name }}</td>
                <td class="px-6 py-4">{{ $payment->skill->name ?? 'N/A' }}</td>
                <td class="px-6 py-4">Tsh {{ number_format($payment->amount) }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 text-xs rounded-full 
                        @if($payment->status == 'completed') bg-green-100 text-green-800
                        @elseif($payment->status == 'pending') bg-yellow-100 text-yellow-800
                        @else bg-red-100 text-red-800 @endif">
                        {{ ucfirst($payment->status) }}
                    </span>
                </td>
                <td class="px-6 py-4">{{ $payment->created_at->format('M d, Y') }}</td>
                <td class="px-6 py-4">
                    <a href="{{ route('admin.payments.show', $payment) }}" class="text-primary hover:underline">View</a>
                    @if($payment->status == 'pending')
                        <form action="{{ route('admin.payments.complete', $payment) }}" method="POST" class="inline ml-2">
                            @csrf
                            <button type="submit" class="text-green-600 hover:text-green-800">Mark Completed</button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="px-6 py-4">
        {{ $payments->links() }}
    </div>
</div>
@endsection