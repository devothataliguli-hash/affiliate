@extends('layouts.admin')

@section('title', 'Payment Details - ELLYPESA')
@section('page-title', 'Payment Details')

@section('content')
<div x-data="paymentDetail()" x-init="init()" class="max-w-5xl mx-auto space-y-5">

    {{-- Toast --}}
    <div x-show="toast.show" x-transition.duration.300ms
         class="fixed top-5 left-1/2 transform -translate-x-1/2 z-50 bg-gray-800 text-white px-5 py-2.5 rounded-lg shadow-lg flex items-center gap-2 text-sm"
         style="display: none;">
        <i :class="toast.type === 'success' ? 'fas fa-check-circle text-green-400' : 'fas fa-exclamation-triangle text-red-400'"></i>
        <span x-text="toast.message"></span>
        <button @click="toast.show = false" class="ml-2 text-gray-300 hover:text-white">&times;</button>
    </div>

    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <div>
                <h2 class="text-lg font-semibold text-gray-800">Transaction #{{ $payment->id }}</h2>
                <p class="text-sm text-gray-500">{{ $payment->created_at->format('F d, Y h:i A') }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.payments.index') }}" class="text-primary hover:underline text-sm">
                    <i class="fas fa-arrow-left mr-1"></i> Back
                </a>
                @if($payment->status == 'pending')
                <button @click="confirmDelete" class="text-red-600 hover:text-red-800 text-sm">
                    <i class="fas fa-trash mr-1"></i> Delete
                </button>
                @endif
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Payment Info --}}
                <div>
                    <h3 class="font-semibold text-gray-800 mb-3 flex items-center gap-2"><i class="fas fa-credit-card text-primary"></i> Payment Information</h3>
                    <dl class="space-y-3">
                        <div class="flex flex-wrap">
                            <dt class="w-32 text-sm text-gray-500">Amount:</dt>
                            <dd class="text-sm font-medium">Tsh {{ number_format($payment->amount) }}</dd>
                        </div>
                        <div class="flex flex-wrap">
                            <dt class="w-32 text-sm text-gray-500">Method:</dt>
                            <dd class="text-sm">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</dd>
                        </div>
                        <div class="flex flex-wrap">
                            <dt class="w-32 text-sm text-gray-500">Transaction ID:</dt>
                            <dd class="text-sm">{{ $payment->transaction_id ?? '—' }}</dd>
                        </div>
                        <div class="flex flex-wrap items-center">
                            <dt class="w-32 text-sm text-gray-500">Status:</dt>
                            <dd>
                                <select x-model="status" @change="updateStatus" class="text-xs rounded-full px-2 py-1 font-semibold border-0"
                                        :class="statusSelectClass(status)">
                                    <option value="pending">Pending</option>
                                    <option value="completed">Completed</option>
                                    <option value="failed">Failed</option>
                                </select>
                            </dd>
                        </div>
                    </dl>
                </div>

                {{-- User Info --}}
                <div>
                    <h3 class="font-semibold text-gray-800 mb-3 flex items-center gap-2"><i class="fas fa-user text-primary"></i> User Information</h3>
                    <dl class="space-y-3">
                        <div class="flex flex-wrap">
                            <dt class="w-32 text-sm text-gray-500">Name:</dt>
                            <dd class="text-sm font-medium">{{ $payment->user->name }}</dd>
                        </div>
                        <div class="flex flex-wrap">
                            <dt class="w-32 text-sm text-gray-500">Email:</dt>
                            <dd class="text-sm">{{ $payment->user->email ?? '—' }}</dd>
                        </div>
                        <div class="flex flex-wrap">
                            <dt class="w-32 text-sm text-gray-500">Phone:</dt>
                            <dd class="text-sm">{{ $payment->user->phone ?? '—' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            @if($payment->skill)
            <div class="mt-6 pt-6 border-t">
                <h3 class="font-semibold text-gray-800 mb-3"><i class="fas fa-graduation-cap text-primary mr-2"></i>Purchased Skill</h3>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="flex flex-wrap">
                        <dt class="w-32 text-sm text-gray-500">Skill Name:</dt>
                        <dd class="text-sm">{{ $payment->skill->name }}</dd>
                    </div>
                    <div class="flex flex-wrap">
                        <dt class="w-32 text-sm text-gray-500">Price:</dt>
                        <dd class="text-sm">Tsh {{ number_format($payment->skill->price) }}</dd>
                    </div>
                </dl>
            </div>
            @endif

            @if($payment->notes)
            <div class="mt-6 pt-6 border-t">
                <h3 class="font-semibold text-gray-800 mb-2">Notes</h3>
                <p class="text-sm text-gray-600 bg-gray-50 p-3 rounded-lg">{{ $payment->notes }}</p>
            </div>
            @endif
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    <div x-show="deleteModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center px-4">
        <div class="fixed inset-0 bg-black/50" @click="deleteModalOpen = false"></div>
        <div class="bg-white rounded-xl shadow-lg max-w-sm w-full p-4 relative z-10">
            <h3 class="text-sm font-bold mb-2">Thibitisha Kufuta</h3>
            <p class="text-xs text-gray-600 mb-4">Una uhakika unataka kufuta malipo haya?</p>
            <div class="flex justify-end gap-2">
                <button @click="deleteModalOpen = false" class="px-3 py-1 border text-xs rounded">Ghairi</button>
                <button @click="deletePayment" class="bg-red-600 text-white px-3 py-1 text-xs rounded">Futa</button>
            </div>
        </div>
    </div>

</div>

<script>
function paymentDetail() {
    return {
        status: '{{ $payment->status }}',
        deleteModalOpen: false,
        toast: { show: false, message: '', type: 'success' },

        updateStatus() {
            fetch('{{ route("admin.payments.status", $payment) }}', {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ status: this.status })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    this.showToast('Status updated successfully!');
                    // Update the page's displayed status badge if needed
                } else {
                    this.showToast(data.message || 'Update failed', 'error');
                    this.status = '{{ $payment->status }}'; // revert
                }
            })
            .catch(() => this.showToast('Network error', 'error'));
        },

        confirmDelete() { this.deleteModalOpen = true; },

        deletePayment() {
            fetch('{{ route("admin.payments.destroy", $payment) }}', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    window.location.href = '{{ route("admin.payments.index") }}';
                } else {
                    this.showToast(data.message || 'Cannot delete', 'error');
                    this.deleteModalOpen = false;
                }
            })
            .catch(() => this.showToast('Delete failed', 'error'));
        },

        statusSelectClass(status) {
            return {
                'pending': 'bg-yellow-100 text-yellow-800',
                'completed': 'bg-green-100 text-green-800',
                'failed': 'bg-red-100 text-red-800'
            }[status] || '';
        },

        showToast(msg, type) {
            this.toast.message = msg;
            this.toast.type = type;
            this.toast.show = true;
            setTimeout(() => { this.toast.show = false; }, 3000);
        }
    }
}
</script>
@endsection