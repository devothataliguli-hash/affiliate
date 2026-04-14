@extends('layouts.admin')

@section('title', 'Admin Dashboard - ELLYPESA')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">
    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Jumla ya Watumiaji</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalUsers ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-users text-blue-600 text-lg"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Jumla ya Skills</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalSkills ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-graduation-cap text-green-600 text-lg"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Pending Approvals</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $pendingApprovals ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-600 text-lg"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Revenue</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">Tsh {{ number_format($totalPayments ?? 0) }}</p>
                </div>
                <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center">
                    <i class="fas fa-money-bill text-primary text-lg"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Activity Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Recent Users --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-semibold text-gray-800">Watumiaji Wapya</h3>
                <span class="text-xs text-gray-400">Wiki hii</span>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($recentUsers ?? [] as $user)
                <div class="px-6 py-3 flex items-center justify-between hover:bg-gray-50">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center text-gray-600 text-xs font-bold">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-medium text-gray-800 text-sm">{{ $user->name }}</p>
                            <p class="text-xs text-gray-500">{{ $user->email ?? $user->phone ?? 'No contact' }}</p>
                        </div>
                    </div>
                    <span class="text-xs text-gray-400">{{ $user->created_at->diffForHumans() }}</span>
                </div>
                @empty
                <div class="px-6 py-8 text-center text-gray-400 text-sm">Hakuna watumiaji wapya</div>
                @endforelse
            </div>
        </div>

        {{-- Recent Payments --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-semibold text-gray-800">Malipo ya Hivi Karibuni</h3>
                <span class="text-xs text-gray-400">Hivi karibuni</span>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($recentPayments ?? [] as $payment)
                <div class="px-6 py-3 flex items-center justify-between hover:bg-gray-50">
                    <div>
                        <p class="font-medium text-gray-800 text-sm">{{ $payment->user->name ?? 'Unknown' }}</p>
                        <p class="text-xs text-gray-500">Tsh {{ number_format($payment->amount) }}</p>
                    </div>
                    <div class="text-right">
                        <span class="inline-block px-2 py-1 text-xs rounded-full 
                            {{ $payment->status === 'completed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ ucfirst($payment->status) }}
                        </span>
                        <p class="text-xs text-gray-400 mt-1">{{ $payment->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                @empty
                <div class="px-6 py-8 text-center text-gray-400 text-sm">Hakuna malipo ya hivi karibuni</div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Optional: Quick Actions or Chart Placeholder --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-semibold text-gray-800 mb-3">Haraka</h3>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.skills.index') }}" class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg text-sm hover:bg-primary-dark">
                <i class="fas fa-plus mr-2"></i> Ongeza Skill
            </a>
            <a href="{{ route('admin.user-skills.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-50">
                <i class="fas fa-check-circle mr-2"></i> Thibitisha Skills
            </a>
            <a href="{{ route('admin.testimonials.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-50">
                <i class="fas fa-star mr-2"></i> Usimamizi wa Testimonial
            </a>
        </div>
    </div>
</div>
@endsection