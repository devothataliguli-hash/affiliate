@extends('layouts.admin')

@section('title', 'Admin Dashboard - ELLYPESA')
@section('page-title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 mr-4">
                <i class="fas fa-users text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Jumla ya Watumiaji</p>
                <p class="text-2xl font-bold">{{ $totalUsers }}</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600 mr-4">
                <i class="fas fa-graduation-cap text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Jumla ya Skills</p>
                <p class="text-2xl font-bold">{{ $totalSkills }}</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center text-yellow-600 mr-4">
                <i class="fas fa-clock text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Pending Approvals</p>
                <p class="text-2xl font-bold">{{ $pendingApprovals }}</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center text-primary mr-4">
                <i class="fas fa-money-bill text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Total Revenue</p>
                <p class="text-2xl font-bold">Tsh {{ number_format($totalPayments) }}</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl shadow-md p-6">
        <h3 class="font-bold text-lg mb-4">Watumiaji Wapya</h3>
        <div class="space-y-3">
            @foreach($recentUsers as $user)
            <div class="flex items-center justify-between py-2 border-b">
                <div>
                    <p class="font-medium">{{ $user->name }}</p>
                    <p class="text-sm text-gray-500">{{ $user->email ?? $user->phone }}</p>
                </div>
                <span class="text-sm text-gray-400">{{ $user->created_at->diffForHumans() }}</span>
            </div>
            @endforeach
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-md p-6">
        <h3 class="font-bold text-lg mb-4">Malipo ya Hivi Karibuni</h3>
        <div class="space-y-3">
            @foreach($recentPayments as $payment)
            <div class="flex items-center justify-between py-2 border-b">
                <div>
                    <p class="font-medium">{{ $payment->user->name }}</p>
                    <p class="text-sm text-gray-500">Tsh {{ number_format($payment->amount) }} - {{ $payment->status }}</p>
                </div>
                <span class="text-sm text-gray-400">{{ $payment->created_at->diffForHumans() }}</span>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection