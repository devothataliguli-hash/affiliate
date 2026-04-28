@extends('layouts.user')

@section('title', $skill->name)

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-4">
    {{-- Skill Header --}}
    <div class="rounded-xl shadow-md p-5 md:p-6 mb-6" style="background-color: #FFFFFF;">
        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
            <div class="flex-1">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0" style="background: {{ $skill->color }}20;">
                        <i class="fas {{ $skill->icon ?? 'fa-graduation-cap' }} text-2xl" style="color: {{ $skill->color }};"></i>
                    </div>
                    <h1 class="text-xl md:text-2xl lg:text-3xl font-bold" style="color: #1F2937;">{{ $skill->name }}</h1>
                </div>
                <p class="text-sm md:text-base leading-relaxed" style="color: #4B5563;">{{ $skill->description }}</p>
            </div>
            
            @if(!$isPurchased && !$isPending)
                <a href="{{ route('user.payments.create', $skill) }}" class="text-center font-semibold px-5 py-2.5 rounded-full transition hover:shadow-md self-start md:self-center whitespace-nowrap" style="background-color: #F57C00; color: #FFFFFF;">
                    Purchase · Tsh {{ number_format($skill->price) }}
                </a>
            @elseif($isPending)
                <span class="text-center font-semibold px-5 py-2.5 rounded-full whitespace-nowrap" style="background-color: #FEF3C7; color: #92400E;">
                    ⏳ Payment Pending Approval
                </span>
            @elseif($isPurchased)
                <span class="text-center font-semibold px-5 py-2.5 rounded-full whitespace-nowrap" style="background-color: #D1FAE5; color: #065F46;">
                    ✓ Access Granted
                </span>
            @endif
        </div>
    </div>
    
    {{-- Categories and Content --}}
    @if($skill->categories->count() > 0)
        @foreach($skill->categories as $category)
        <div class="rounded-xl shadow-md overflow-hidden mb-6" style="background-color: #FFFFFF;">
            <div class="px-5 md:px-6 py-4 border-b" style="background-color: #F9FAFB; border-color: #E5E7EB;">
                <h2 class="text-lg md:text-xl font-bold" style="color: #1F2937;">{{ $category->name }}</h2>
                @if($category->description)
                    <p class="text-sm mt-1" style="color: #6B7280;">{{ $category->description }}</p>
                @endif
            </div>
            <div class="divide-y" style="border-color: #F3F4F6;">
                @foreach($category->contents as $content)
                <div class="p-4 md:p-5 transition-all hover:bg-gray-50">
                    @if($isPurchased || $content->is_free_preview)
                        <a href="{{ route('user.skill.content', [$skill->slug, $category->slug, $content->id]) }}" class="flex items-center justify-between group">
                            <div class="flex items-center gap-3 flex-1">
                                @if($content->type == 'video')
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0" style="background-color: #FFF3E0;">
                                        <i class="fas fa-video text-sm" style="color: #F57C00;"></i>
                                    </div>
                                @elseif($content->type == 'audio')
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0" style="background-color: #FFF3E0;">
                                        <i class="fas fa-headphones text-sm" style="color: #F57C00;"></i>
                                    </div>
                                @elseif($content->type == 'pdf')
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0" style="background-color: #FEF2F2;">
                                        <i class="fas fa-file-pdf text-sm" style="color: #DC2626;"></i>
                                    </div>
                                @else
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0" style="background-color: #EFF6FF;">
                                        <i class="fas fa-file-alt text-sm" style="color: #2563EB;"></i>
                                    </div>
                                @endif
                                
                                <div class="flex-1">
                                    <h3 class="font-semibold text-sm md:text-base transition" style="color: #1F2937;">{{ $content->title }}</h3>
                                    @if($content->duration)
                                        <span class="text-xs" style="color: #6B7280;"><i class="far fa-clock mr-1"></i>{{ $content->duration }} min</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-2 ml-2">
                                @if($content->is_free_preview)
                                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full" style="background-color: #D1FAE5; color: #065F46;">Free Preview</span>
                                @endif
                                <i class="fas fa-play-circle transition text-lg md:text-xl" style="color: #F57C00;"></i>
                            </div>
                        </a>
                    @else
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3 flex-1">
                                @if($content->type == 'video')
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0" style="background-color: #F3F4F6;">
                                        <i class="fas fa-video text-sm" style="color: #9CA3AF;"></i>
                                    </div>
                                @elseif($content->type == 'audio')
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0" style="background-color: #F3F4F6;">
                                        <i class="fas fa-headphones text-sm" style="color: #9CA3AF;"></i>
                                    </div>
                                @elseif($content->type == 'pdf')
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0" style="background-color: #F3F4F6;">
                                        <i class="fas fa-file-pdf text-sm" style="color: #9CA3AF;"></i>
                                    </div>
                                @else
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0" style="background-color: #F3F4F6;">
                                        <i class="fas fa-file-alt text-sm" style="color: #9CA3AF;"></i>
                                    </div>
                                @endif
                                
                                <div>
                                    <h3 class="font-semibold text-sm md:text-base" style="color: #9CA3AF;">{{ $content->title }}</h3>
                                    @if($content->duration)
                                        <span class="text-xs" style="color: #D1D5DB;"><i class="far fa-clock mr-1"></i>{{ $content->duration }} min</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-2 ml-2">
                                @if($content->is_free_preview)
                                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full" style="background-color: #D1FAE5; color: #065F46;">Free Preview</span>
                                @endif
                                <i class="fas fa-lock text-sm" style="color: #D1D5DB;"></i>
                            </div>
                        </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    @else
        <div class="rounded-xl shadow-md p-8 text-center" style="background-color: #FFFFFF;">
            <div class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center" style="background-color: #F3F4F6;">
                <i class="fas fa-folder-open text-2xl" style="color: #9CA3AF;"></i>
            </div>
            <p class="text-base" style="color: #6B7280;">No content available yet. Check back soon!</p>
        </div>
    @endif
    
    {{-- Purchase Prompt for Unlocked Content --}}
    @if(!$isPurchased && !$isPending && $skill->price > 0)
        <div class="rounded-xl p-6 md:p-8 text-center" style="background: linear-gradient(135deg, #FFF3E0, #FFE0B2);">
            <h3 class="text-lg md:text-xl font-bold mb-2" style="color: #1F2937;">Unlock Full Access</h3>
            <p class="text-sm md:text-base mb-5" style="color: #4B5563;">Purchase this skill to access all content including videos, PDFs, and more.</p>
            <a href="{{ route('user.payments.create', $skill) }}" class="inline-block font-semibold px-8 py-3 rounded-lg transition-all hover:shadow-md active:scale-98" style="background-color: #F57C00; color: #FFFFFF;">
                Purchase Now · Tsh {{ number_format($skill->price) }}
            </a>
        </div>
    @endif
</div>

<style>
    .group:hover .fa-play-circle {
        transform: scale(1.1);
        transition: transform 0.2s ease;
    }
    
    button:active, a:active {
        transform: scale(0.98);
    }
    
    @media (max-width: 640px) {
        .rounded-xl {
            border-radius: 0.75rem;
        }
        .px-5 {
            padding-left: 1rem;
            padding-right: 1rem;
        }
    }
    
    /* Focus states for accessibility */
    a:focus-visible, button:focus-visible {
        outline: 2px solid #F57C00;
        outline-offset: 2px;
        border-radius: 0.5rem;
    }
</style>
@endsection