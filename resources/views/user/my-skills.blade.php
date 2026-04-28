@extends('layouts.user')

@section('title', 'My Skills')

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-4">
    <div class="mb-6 md:mb-8">
        <h1 class="text-2xl md:text-3xl font-bold" style="color: #1F2937;">My Skills</h1>
        <p class="text-base mt-1" style="color: #4B5563;">Track your learning progress and access your enrolled courses</p>
    </div>
    
    {{-- Active Skills --}}
    @if($mySkills->count() > 0)
        <div class="mb-10">
            <h2 class="text-lg md:text-xl font-bold mb-4 flex items-center gap-2" style="color: #1F2937;">
                <i class="fas fa-check-circle" style="color: #059669;"></i>
                Active Skills ({{ $mySkills->count() }})
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
                @foreach($mySkills as $skill)
                <div class="rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all transform hover:-translate-y-1" style="background-color: #FFFFFF;">
                    <div class="h-28 md:h-32 flex items-center justify-center" style="background: linear-gradient(135deg, {{ $skill->color }}20, {{ $skill->color }}08);">
                        <i class="fas {{ $skill->icon ?? 'fa-graduation-cap' }} text-4xl md:text-5xl" style="color: {{ $skill->color }};"></i>
                    </div>
                    <div class="p-4 md:p-5">
                        <h3 class="font-bold text-base md:text-lg mb-1" style="color: #1F2937;">{{ $skill->name }}</h3>
                        <p class="text-sm mb-3" style="color: #6B7280; line-height: 1.4;">{{ Str::limit($skill->description, 70) }}</p>
                        
                        <div class="flex items-center justify-between flex-wrap gap-2">
                            <span class="text-xs font-semibold px-2 py-1 rounded-full" style="background-color: #D1FAE5; color: #065F46;">
                                <i class="fas fa-check-circle text-xs mr-1"></i> Enrolled
                            </span>
                            <a href="{{ route('user.skill.show', $skill->slug) }}" class="text-sm font-semibold hover:underline transition flex items-center gap-1" style="color: #F57C00;">
                                Continue Learning <i class="fas fa-arrow-right text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="rounded-xl shadow-md p-8 text-center mb-8" style="background-color: #FFFFFF;">
            <div class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center" style="background-color: #FEF3C7;">
                <i class="fas fa-book-open text-2xl" style="color: #D97706;"></i>
            </div>
            <h3 class="text-lg font-semibold mb-2" style="color: #1F2937;">No Skills Enrolled Yet</h3>
            <p class="mb-5" style="color: #6B7280;">You haven't purchased any skills yet. Start your learning journey today!</p>
            <a href="{{ route('user.dashboard') }}" class="inline-block font-semibold px-6 py-2.5 rounded-lg transition hover:shadow-md" style="background-color: #F57C00; color: #FFFFFF;">
                Browse Available Skills
            </a>
        </div>
    @endif
    
    {{-- Pending Skills --}}
    @if($pendingSkills->count() > 0)
        <div class="mb-10">
            <h2 class="text-lg md:text-xl font-bold mb-4 flex items-center gap-2" style="color: #1F2937;">
                <i class="fas fa-clock" style="color: #D97706;"></i>
                Pending Approval ({{ $pendingSkills->count() }})
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
                @foreach($pendingSkills as $skill)
                <div class="rounded-xl shadow-md overflow-hidden border-l-4" style="background-color: #FFFFFF; border-left-color: #F59E0B;">
                    <div class="p-4 md:p-5">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h3 class="font-bold text-base md:text-lg" style="color: #1F2937;">{{ $skill->name }}</h3>
                                <p class="text-sm mt-1" style="color: #6B7280; line-height: 1.4;">{{ Str::limit($skill->description, 60) }}</p>
                            </div>
                            <i class="fas fa-hourglass-half text-xl ml-2" style="color: #F59E0B;"></i>
                        </div>
                        <div class="mt-4 rounded-lg p-3" style="background-color: #FFFBEB;">
                            <div class="flex items-center gap-2 text-sm" style="color: #92400E;">
                                <i class="fas fa-info-circle"></i>
                                <span>Waiting for payment confirmation</span>
                            </div>
                            <p class="text-xs mt-2" style="color: #6B7280;">
                                Amount: <strong style="color: #F57C00;">Tsh {{ number_format($skill->price) }}</strong>
                            </p>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('user.payments.index') }}" class="text-sm font-medium hover:underline transition" style="color: #F57C00;">
                                View Payment Status →
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

<style>
    @media (max-width: 640px) {
        .rounded-xl {
            border-radius: 0.75rem;
        }
    }
</style>
@endsection