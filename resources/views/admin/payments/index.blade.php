@extends('layouts.admin')

@section('title', 'Payments - ELLYPESA')
@section('page-title', 'Payment Transactions')

@section('content')
<div class="space-y-5">

    {{-- Stats Cards --}}
    @php
        $totalAmount = $payments->sum('amount');
        $completedCount = $payments->where('status', 'completed')->count();
        $pendingCount = $payments->where('status', 'pending')->count();
    @endphp

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow border p-4">
            <p class="text-xs text-gray-500 uppercase">Jumla ya Malipo</p>
            <p class="text-2xl font-bold text-gray-800">{{ $payments->total() }}</p>
        </div>
        <div class="bg-white rounded-xl shadow border p-4">
            <p class="text-xs text-gray-500 uppercase">Jumla ya Kiasi</p>
            <p class="text-2xl font-bold text-primary">Tsh {{ number_format($totalAmount) }}</p>
        </div>
        <div class="bg-white rounded-xl shadow border p-4">
            <p class="text-xs text-gray-500 uppercase">Imekamilika</p>
            <p class="text-2xl font-bold text-green-600">{{ $completedCount }}</p>
        </div>
        <div class="bg-white rounded-xl shadow border p-4">
            <p class="text-xs text-gray-500 uppercase">Inasubiri</p>
            <p class="text-2xl font-bold text-yellow-600">{{ $pendingCount }}</p>
        </div>
    </div>

    {{-- Search Form --}}
    <div class="bg-white p-4 rounded-xl shadow border">
        <form method="GET" action="{{ route('admin.payments.index') }}" class="flex flex-col md:flex-row gap-3">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by user or skill..." 
                       class="w-full px-4 py-2 border rounded-lg text-sm">
            </div>
            <div class="w-full md:w-48">
                <select name="status" class="w-full px-4 py-2 border rounded-lg text-sm">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
            </div>
            <button type="submit" class="bg-primary text-white px-4 py-2 rounded-lg text-sm">Filter</button>
            <a href="{{ route('admin.payments.index') }}" class="bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-lg text-sm text-center">
                Reset
            </a>
        </form>
    </div>

    {{-- Mobile Cards --}}
    <div class="space-y-3 md:hidden">
        @forelse($payments as $payment)
        <div class="bg-white p-4 rounded-xl shadow border">
            <div class="flex justify-between items-start">
                <div>
                    <p class="font-semibold text-gray-800">{{ $payment->user->name ?? '—' }}</p>
                    <p class="text-xs text-gray-500">{{ $payment->skill->name ?? 'General Payment' }}</p>
                </div>
                <span class="px-2 py-1 text-xs rounded-full font-semibold
                    @if($payment->status == 'completed') bg-green-100 text-green-800
                    @elseif($payment->status == 'pending') bg-yellow-100 text-yellow-800
                    @else bg-red-100 text-red-800 @endif">
                    {{ ucfirst($payment->status) }}
                </span>
            </div>
            <div class="mt-2 flex justify-between items-end">
                <div>
                    <p class="text-lg font-bold text-primary">Tsh {{ number_format($payment->amount) }}</p>
                    <p class="text-xs text-gray-400">{{ $payment->created_at->format('M d, Y') }}</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.payments.show', $payment) }}" class="text-blue-600 text-sm"><i class="fas fa-eye"></i></a>
                    @if($payment->status == 'pending')
                    <form action="{{ route('admin.payments.destroy', $payment) }}" method="POST" onsubmit="return confirm('Delete this payment?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 text-sm"><i class="fas fa-trash"></i></button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="text-center text-gray-500 py-6">No payments found.</div>
        @endforelse
    </div>

    {{-- Desktop Table --}}
    <div class="hidden md:block bg-white rounded-xl shadow border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Skill</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse($payments as $payment)
                    <tr>
                        <td class="px-4 py-3 whitespace-nowrap text-sm">{{ $payment->user->name ?? '—' }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm">{{ $payment->skill->name ?? '—' }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">Tsh {{ number_format($payment->amount) }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded-full font-semibold
                                @if($payment->status == 'completed') bg-green-100 text-green-800
                                @elseif($payment->status == 'pending') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $payment->created_at->format('M d, Y') }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('admin.payments.show', $payment) }}" class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($payment->status == 'pending')
                                <form action="{{ route('admin.payments.destroy', $payment) }}" method="POST" onsubmit="return confirm('Delete this payment?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-500">No payments found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-t bg-gray-50">
            {{ $payments->appends(request()->query())->links() }}
        </div>
    </div>

</div>
@endsection