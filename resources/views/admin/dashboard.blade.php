@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-2 sm:px-3">
    {{-- Welcome Section --}}
    <div class="mb-6 md:mb-8">
        <h1 class="text-2xl md:text-3xl font-bold" style="color: #1F2937;">Welcome, {{ auth()->user()->name }}!</h1>
        <p class="text-base mt-1" style="color: #4B5563;">Here's what's happening with your platform today.</p>
    </div>
    
    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-5 mb-9">
       <div class="stat-card w-1000 max-w-[900px] rounded-xl shadow-sm p-2 md:p-5 border-l-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm font-medium" style="color: #242527;">Total Users</p>
                    <p class="text-2xl md:text-3xl font-bold mt-1" style="color: #1F2937;">{{ $totalUsers }}</p>
                </div>
                <div class="w-10 h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center" style="background-color: #EFF6FF;">
                    <i class="fas fa-users text-xl md:text-2xl" style="color: #3B82F6;"></i>
                </div>
            </div>
        </div>
        
        <div class="stat-card rounded-xl shadow-sm p-4 md:p-5 border-l-4 transition-all hover:shadow-md" style="background-color: #FFFFFF; border-left-color: #10B981;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm font-medium" style="color: #6B7280;">Total Skills</p>
                    <p class="text-2xl md:text-3xl font-bold mt-1" style="color: #1F2937;">{{ $totalSkills }}</p>
                </div>
                <div class="w-10 h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center" style="background-color: #D1FAE5;">
                    <i class="fas fa-book text-xl md:text-2xl" style="color: #10B981;"></i>
                </div>
            </div>
        </div>
        
        <div class="stat-card rounded-xl shadow-sm p-4 md:p-5 border-l-4 transition-all hover:shadow-md" style="background-color: #FFFFFF; border-left-color: #8B5CF6;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm font-medium" style="color: #6B7280;">Total Payments</p>
                    <p class="text-2xl md:text-3xl font-bold mt-1" style="color: #1F2937;">{{ $totalPayments }}</p>
                </div>
                <div class="w-10 h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center" style="background-color: #EDE9FE;">
                    <i class="fas fa-money-bill-wave text-xl md:text-2xl" style="color: #8B5CF6;"></i>
                </div>
            </div>
        </div>
        
        <div class="stat-card rounded-xl shadow-sm p-4 md:p-5 border-l-4 transition-all hover:shadow-md" style="background-color: #FFFFFF; border-left-color: #EF4444;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm font-medium" style="color: #6B7280;">Pending Payments</p>
                    <p class="text-2xl md:text-3xl font-bold mt-1" style="color: #DC2626;">{{ $pendingPayments }}</p>
                </div>
                <div class="w-10 h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center" style="background-color: #FEE2E2;">
                    <i class="fas fa-clock text-xl md:text-2xl" style="color: #EF4444;"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="grid lg:grid-cols-2 gap-5 md:gap-6">
        {{-- Recent Payments (Limited to 3) --}}
        <div class="rounded-xl shadow-sm overflow-hidden" style="background-color: #FFFFFF;">
            <div class="px-5 md:px-6 py-4 border-b flex justify-between items-center" style="border-color: #F3F4F6;">
                <h2 class="font-bold text-base md:text-lg" style="color: #1F2937;">Recent Payments</h2>
                <a href="{{ route('admin.payments.index') }}" class="text-sm font-medium hover:underline transition inline-flex items-center gap-1" style="color: #F57C00;">
                    View All <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>
            <div class="divide-y" style="border-color: #F3F4F6;">
                @forelse($recentPayments->take(3) as $payment)
                <div class="px-5 md:px-6 py-4 flex items-center justify-between flex-wrap gap-3">
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-sm md:text-base truncate" style="color: #1F2937;">{{ $payment->user->name }}</p>
                        <p class="text-xs md:text-sm" style="color: #6B7280;">{{ $payment->skill->name }} • {{ $payment->created_at->diffForHumans() }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-sm md:text-base" style="color: #F57C00;">Tsh {{ number_format($payment->amount) }}</p>
                        @if($payment->status == 'pending')
                            <span class="text-xs font-semibold px-2 py-0.5 rounded-full" style="background-color: #FEF3C7; color: #92400E;">Pending</span>
                        @elseif($payment->status == 'approved')
                            <span class="text-xs font-semibold px-2 py-0.5 rounded-full" style="background-color: #D1FAE5; color: #065F46;">Approved</span>
                        @elseif($payment->status == 'rejected')
                            <span class="text-xs font-semibold px-2 py-0.5 rounded-full" style="background-color: #FEE2E2; color: #991B1B;">Rejected</span>
                        @endif
                    </div>
                </div>
                @empty
                <div class="px-6 py-8 text-center">
                    <div class="w-12 h-12 mx-auto mb-3 rounded-full flex items-center justify-center" style="background-color: #F3F4F6;">
                        <i class="fas fa-receipt text-xl" style="color: #9CA3AF;"></i>
                    </div>
                    <p class="text-sm" style="color: #6B7280;">No payments yet</p>
                </div>
                @endforelse
            </div>
        </div>
        
        {{-- Recent Users (Limited to 3) --}}
        <div class="rounded-xl shadow-sm overflow-hidden" style="background-color: #FFFFFF;">
            <div class="px-5 md:px-6 py-4 border-b flex justify-between items-center" style="border-color: #F3F4F6;">
                <h2 class="font-bold text-base md:text-lg" style="color: #1F2937;">Recent Users</h2>
             <a href="{{ route('admin.users.index') ?? '#' }}" class="text-sm font-medium hover:underline transition inline-flex items-center gap-1" style="color: #F57C00;">
                    View All <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>
            <div class="divide-y" style="border-color: #F3F4F6;">
                @forelse($recentUsers->take(3) as $user)
                <div class="px-5 md:px-6 py-4 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0" style="background-color: #FFF3E0;">
                        <i class="fas fa-user text-sm" style="color: #F57C00;"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-sm md:text-base truncate" style="color: #1F2937;">{{ $user->name }}</p>
                        <p class="text-xs md:text-sm truncate" style="color: #6B7280;">{{ $user->email }} • Joined {{ $user->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                @empty
                <div class="px-6 py-8 text-center">
                    <div class="w-12 h-12 mx-auto mb-3 rounded-full flex items-center justify-center" style="background-color: #F3F4F6;">
                        <i class="fas fa-users text-xl" style="color: #9CA3AF;"></i>
                    </div>
                    <p class="text-sm" style="color: #6B7280;">No users yet</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
    
    {{-- Quick Actions --}}
    <div class="mt-8 grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4">
        <a href="{{ route('admin.skills.create') }}" class="rounded-xl p-4 text-center transition-all hover:shadow-lg active:scale-98" style="background: linear-gradient(135deg, #3B82F6, #2563EB); color: #FFFFFF;">
            <i class="fas fa-plus-circle text-xl md:text-2xl mb-2 block"></i>
            <p class="font-semibold text-sm md:text-base">Add New Skill</p>
        </a>
        <a href="{{ route('admin.payments.index') }}" class="rounded-xl p-4 text-center transition-all hover:shadow-lg active:scale-98" style="background: linear-gradient(135deg, #8B5CF6, #7C3AED); color: #FFFFFF;">
            <i class="fas fa-money-check text-xl md:text-2xl mb-2 block"></i>
            <p class="font-semibold text-sm md:text-base">Manage Payments</p>
            @if($pendingPayments > 0)
                <span class="inline-block mt-1 text-xs font-bold px-2 py-0.5 rounded-full" style="background-color: #EF4444; color: #FFFFFF;">{{ $pendingPayments }} Pending</span>
            @endif
        </a>
        <a href="{{ route('admin.testimonials.create') }}" class="rounded-xl p-4 text-center transition-all hover:shadow-lg active:scale-98" style="background: linear-gradient(135deg, #10B981, #059669); color: #FFFFFF;">
            <i class="fas fa-star text-xl md:text-2xl mb-2 block"></i>
            <p class="font-semibold text-sm md:text-base">Add Testimonial</p>
        </a>
        <a href="{{ route('admin.skills.index') }}" class="rounded-xl p-4 text-center transition-all hover:shadow-lg active:scale-98" style="background: linear-gradient(135deg, #F59E0B, #D97706); color: #FFFFFF;">
            <i class="fas fa-edit text-xl md:text-2xl mb-2 block"></i>
            <p class="font-semibold text-sm md:text-base">Manage Skills</p>
        </a>
    </div>
</div>

<style>
    /* Card hover effects */
    .stat-card {
        transition: all 0.2s ease;
    }
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    }
    
    /* Active scale feedback */
    button:active, a:active {
        transform: scale(0.98);
    }
    
    /* Smooth content animation */
    main > * {
        animation: fadeInUp 0.3s ease-out;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @media (max-width: 640px) {
        .rounded-xl {
            border-radius: 0.75rem;
        }
    }
</style>
@endsection