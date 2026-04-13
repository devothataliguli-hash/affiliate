@extends('layouts.admin')

@section('title', 'Payment Details - ELLYPESA')
@section('page-title', 'Payment Details')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <div>
                <h2 class="text-lg font-semibold text-gray-800">Transaction #{{ $payment->id }}</h2>
                <p class="text-sm text-gray-500">{{ $payment->created_at->format('F d, Y h:i A') }}</p>
            </div>
            <a href="{{ route('admin.payments.index') }}" class="text-primary hover:underline text-sm">
                <i class="fas fa-arrow-left mr-1"></i> Back to Payments
            </a>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Payment Info --}}
                <div>
                    <h3 class="font-semibold text-gray-800 mb-3">Payment Information</h3>
                    <dl class="space-y-2">
                        <div class="flex">
                            <dt class="w-32 text-sm text-gray-500">Amount:</dt>
                            <dd class="text-sm font-medium">Tsh {{ number_format($payment->amount) }}</dd>
                        </div>
                        <div class="flex">
                            <dt class="w-32 text-sm text-gray-500">Method:</dt>
                            <dd class="text-sm">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</dd>
                        </div>
                        <div class="flex">
                            <dt class="w-32 text-sm text-gray-500">Transaction ID:</dt>
                            <dd class="text-sm">{{ $payment->transaction_id ?? '—' }}</dd>
                        </div>
                        <div class="flex">
                            <dt class="w-32 text-sm text-gray-500">Status:</dt>
                            <dd>
                                <span class="px-2 py-1 text-xs rounded-full 
                                    @if($payment->status == 'completed') bg-green-100 text-green-800
                                    @elseif($payment->status == 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </dd>
                        </div>
                    </dl>
                </div>
                
                {{-- User Info --}}
                <div>
                    <h3 class="font-semibold text-gray-800 mb-3">User Information</h3>
                    <dl class="space-y-2">
                        <div class="flex">
                            <dt class="w-32 text-sm text-gray-500">Name:</dt>
                            <dd class="text-sm font-medium">{{ $payment->user->name }}</dd>
                        </div>
                        <div class="flex">
                            <dt class="w-32 text-sm text-gray-500">Email:</dt>
                            <dd class="text-sm">{{ $payment->user->email ?? '—' }}</dd>
                        </div>
                        <div class="flex">
                            <dt class="w-32 text-sm text-gray-500">Phone:</dt>
                            <dd class="text-sm">{{ $payment->user->phone ?? '—' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
            
            {{-- Skill Info --}}
            @if($payment->skill)
            <div class="mt-6 pt-6 border-t">
                <h3 class="font-semibold text-gray-800 mb-3">Purchased Skill</h3>
                <dl class="space-y-2">
                    <div class="flex">
                        <dt class="w-32 text-sm text-gray-500">Skill Name:</dt>
                        <dd class="text-sm">{{ $payment->skill->name }}</dd>
                    </div>
                    <div class="flex">
                        <dt class="w-32 text-sm text-gray-500">Price:</dt>
                        <dd class="text-sm">Tsh {{ number_format($payment->skill->price) }}</dd>
                    </div>
                </dl>
            </div>
            @endif
            
            {{-- Notes --}}
            @if($payment->notes)
            <div class="mt-6 pt-6 border-t">
                <h3 class="font-semibold text-gray-800 mb-3">Notes</h3>
                <p class="text-sm text-gray-600 bg-gray-50 p-3 rounded-lg">{{ $payment->notes }}</p>
            </div>
            @endif
            
            {{-- Actions --}}
            <div class="mt-6 pt-6 border-t flex justify-end space-x-3">
                @if($payment->status == 'pending')
                    <form action="{{ route('admin.payments.complete', $payment) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm transition">
                            <i class="fas fa-check-circle mr-2"></i> Mark as Completed
                        </button>
                    </form>
                @endif
                
                <button onclick="openStatusModal()" class="border border-gray-300 hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-lg text-sm transition">
                    <i class="fas fa-edit mr-2"></i> Update Status
                </button>
            </div>
        </div>
    </div>
    
    {{-- Status Update Modal (simple inline form) --}}
    <div id="statusModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-4 p-6">
            <h3 class="text-lg font-semibold mb-4">Update Payment Status</h3>
            <form action="{{ route('admin.payments.update', $payment) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Status</label>
                    <select name="status" class="w-full px-4 py-2 border rounded-lg">
                        <option value="pending" {{ $payment->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="completed" {{ $payment->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="failed" {{ $payment->status == 'failed' ? 'selected' : '' }}>Failed</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Notes</label>
                    <textarea name="notes" rows="2" class="w-full px-4 py-2 border rounded-lg">{{ $payment->notes }}</textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeStatusModal()" class="px-4 py-2 border rounded-lg">Cancel</button>
                    <button type="submit" class="bg-primary hover:bg-primary-dark text-white px-4 py-2 rounded-lg">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openStatusModal() {
        document.getElementById('statusModal').classList.remove('hidden');
    }
    function closeStatusModal() {
        document.getElementById('statusModal').classList.add('hidden');
    }
    // Close on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeStatusModal();
    });
</script>
@endsection