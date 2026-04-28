@extends('layouts.user')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-2 sm:px-4">
    {{-- Welcome Section with better contrast --}}
    <div class="mb-6 md:mb-8">
        <h1 class="text-2xl md:text-3xl font-bold" style="color: #1F2937;">Welcome back, {{ auth()->user()->name }}!</h1>
        <p class="text-base mt-1" style="color: #4B5563;">Continue your learning journey and build your skills.</p>
    </div>
    
    {{-- Stats Cards - Improved contrast and mobile layout --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-5 mb-8">
        <div class="rounded-xl shadow-sm p-4 border transition-all hover:shadow-md" style="background-color: #FFFFFF; border-color: #E5E7EB;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm font-medium" style="color: #6B7280;">Active Skills</p>
                    <p class="text-2xl md:text-3xl font-bold mt-1" style="color: #1F2937;">{{ $mySkills->count() }}</p>
                </div>
                <div class="w-10 h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center" style="background-color: #FFF3E0;">
                    <i class="fas fa-graduation-cap text-xl md:text-2xl" style="color: #F57C00;"></i>
                </div>
            </div>
        </div>
        
        <div class="rounded-xl shadow-sm p-4 border transition-all hover:shadow-md" style="background-color: #FFFFFF; border-color: #E5E7EB;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm font-medium" style="color: #6B7280;">Pending</p>
                    <p class="text-2xl md:text-3xl font-bold mt-1" style="color: #D97706;">{{ $pendingSkills->count() }}</p>
                </div>
                <div class="w-10 h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center" style="background-color: #FEF3C7;">
                    <i class="fas fa-clock text-xl md:text-2xl" style="color: #D97706;"></i>
                </div>
            </div>
        </div>
        
        <div class="rounded-xl shadow-sm p-4 border transition-all hover:shadow-md" style="background-color: #FFFFFF; border-color: #E5E7EB;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm font-medium" style="color: #6B7280;">Payments Made</p>
                    <p class="text-2xl md:text-3xl font-bold mt-1" style="color: #059669;">{{ auth()->user()->payments()->where('status', 'approved')->count() }}</p>
                </div>
                <div class="w-10 h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center" style="background-color: #D1FAE5;">
                    <i class="fas fa-money-bill-wave text-xl md:text-2xl" style="color: #059669;"></i>
                </div>
            </div>
        </div>
        
        <div class="rounded-xl shadow-sm p-4 border transition-all hover:shadow-md" style="background-color: #FFFFFF; border-color: #E5E7EB;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm font-medium" style="color: #6B7280;">Available Skills</p>
                    <p class="text-2xl md:text-3xl font-bold mt-1" style="color: #F57C00;">{{ $skills->count() }}</p>
                </div>
                <div class="w-10 h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center" style="background-color: #FFF3E0;">
                    <i class="fas fa-book text-xl md:text-2xl" style="color: #F57C00;"></i>
                </div>
            </div>
        </div>
    </div>
    
    {{-- My Skills Section --}}
    @if($mySkills->count() > 0)
    <div class="mb-10">
        <div class="flex justify-between items-center mb-4 flex-wrap gap-2">
            <h2 class="text-xl md:text-2xl font-bold" style="color: #1F2937;">My Active Skills</h2>
            <a href="{{ route('user.my-skills') }}" class="text-sm font-medium hover:underline transition" style="color: #F57C00;">View All →</a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
            @foreach($mySkills->take(3) as $skill)
            <a href="{{ route('user.skill.show', $skill->slug) }}" class="rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all transform hover:-translate-y-1" style="background-color: #FFFFFF;">
                <div class="h-28 md:h-32 flex items-center justify-center" style="background: linear-gradient(135deg, {{ $skill->color }}20, {{ $skill->color }}08);">
                    <i class="fas {{ $skill->icon ?? 'fa-graduation-cap' }} text-4xl md:text-5xl" style="color: {{ $skill->color }};"></i>
                </div>
                <div class="p-4 md:p-5">
                    <h3 class="font-bold text-base md:text-lg mb-1" style="color: #1F2937;">{{ $skill->name }}</h3>
                    <p class="text-sm" style="color: #6B7280; line-height: 1.4;">{{ Str::limit($skill->description, 70) }}</p>
                    <div class="mt-3 flex items-center justify-between">
                        <span class="text-xs font-semibold px-2 py-1 rounded-full" style="background-color: #D1FAE5; color: #065F46;">✓ Enrolled</span>
                        <span class="text-sm font-medium transition group-hover:translate-x-1" style="color: #F57C00;">Continue →</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif
    
    {{-- Available Skills Section --}}
    <div class="mb-10">
        <h2 class="text-xl md:text-2xl font-bold mb-4" style="color: #1F2937;">Available Skills to Learn</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
            @foreach($skills as $skill)
            @php $isPurchased = $skill->isPurchasedBy(auth()->user()); @endphp
            @if(!$isPurchased && !$skill->isPendingFor(auth()->user()))
            <div class="rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all" style="background-color: #FFFFFF;">
                <div class="h-28 md:h-32 relative flex items-center justify-center" style="background: linear-gradient(135deg, {{ $skill->color }}20, {{ $skill->color }}08);">
                    <i class="fas {{ $skill->icon ?? 'fa-graduation-cap' }} text-4xl md:text-5xl" style="color: {{ $skill->color }};"></i>
                    @if($skill->price > 0)
                    <span class="absolute top-2 right-2 text-xs font-bold px-2 py-1 rounded-full" style="background-color: #F57C00; color: #FFFFFF;">Tsh {{ number_format($skill->price) }}</span>
                    @else
                    <span class="absolute top-2 right-2 text-xs font-bold px-2 py-1 rounded-full" style="background-color: #10B981; color: #FFFFFF;">FREE</span>
                    @endif
                </div>
                <div class="p-4 md:p-5">
                    <h3 class="font-bold text-base md:text-lg mb-1" style="color: #1F2937;">{{ $skill->name }}</h3>
                    <p class="text-sm mb-3" style="color: #6B7280; line-height: 1.4;">{{ Str::limit($skill->description, 70) }}</p>
                    <a href="{{ route('user.payments.create', $skill) }}" class="block text-center font-semibold py-2.5 px-3 rounded-lg transition-all hover:shadow-md" style="background-color: #F57C00; color: #FFFFFF;">
                        @if($skill->price > 0)
                            Purchase · Tsh {{ number_format($skill->price) }}
                        @else
                            Enroll Now
                        @endif
                    </a>
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>
    
    {{-- Testimonials Section --}}
    @if($testimonials->count() > 0)
    <div class="mt-10 md:mt-12">
        <h2 class="text-xl md:text-2xl font-bold mb-4 text-center" style="color: #1F2937;">What Our Students Say</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
            @foreach($testimonials as $testimonial)
            <div class="rounded-xl shadow-md p-5 transition-all hover:shadow-lg" style="background-color: #FFFFFF;">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0" style="background-color: #FFF3E0;">
                        @if($testimonial->image)
                            <img src="{{ asset('storage/' . $testimonial->image) }}" class="w-full h-full object-cover rounded-full">
                        @else
                            <i class="fas fa-user text-lg" style="color: #F57C00;"></i>
                        @endif
                    </div>
                    <div>
                        <h4 class="font-bold text-sm md:text-base" style="color: #1F2937;">{{ $testimonial->name }}</h4>
                        <p class="text-xs" style="color: #6B7280;">{{ $testimonial->location ?? 'Student' }}</p>
                    </div>
                </div>
                <p class="text-sm italic leading-relaxed" style="color: #4B5563;">"{{ Str::limit($testimonial->content, 100) }}"</p>
                <div class="mt-2 text-xs md:text-sm" style="color: #FBBF24;">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $testimonial->rating) <i class="fas fa-star"></i> @else <i class="far fa-star"></i> @endif
                    @endfor
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection