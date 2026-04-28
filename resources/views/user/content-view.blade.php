@extends('layouts.user')

@section('title', $content->title)

@section('content')
<div class="max-w-7xl mx-auto px-2 sm:px-4">
    {{-- Navigation with better touch target --}}
    <div class="mb-4 md:mb-6">
        <a href="{{ route('user.skill.show', $skill->slug) }}" class="inline-flex items-center gap-2 text-sm font-medium transition-colors py-2 px-1 rounded-lg hover:bg-orange-50" style="color: #F57C00;">
            <i class="fas fa-arrow-left text-xs"></i> Back to {{ $skill->name }}
        </a>
    </div>
    
    {{-- Content Player - Improved contrast --}}
    <div class="rounded-xl shadow-md overflow-hidden" style="background-color: #FFFFFF;">
        <div class="p-4 md:p-5" style="background: linear-gradient(135deg, #1E293B, #0F172A);">
            <h1 class="text-lg md:text-xl font-bold" style="color: #F9FAFB;">{{ $content->title }}</h1>
            <p class="text-xs md:text-sm mt-1" style="color: #9CA3AF;">{{ $skill->name }} • {{ $content->category->name }}</p>
        </div>
        
        <div class="p-4 md:p-6">
            @if($content->type == 'video')
                @if($content->content_url)
                    <div class="aspect-video rounded-lg overflow-hidden" style="background-color: #000000;">
                        @if(str_contains($content->content_url, 'youtube.com') || str_contains($content->content_url, 'youtu.be'))
                            <iframe src="{{ str_replace('watch?v=', 'embed/', $content->content_url) }}" class="w-full h-full" frameborder="0" allowfullscreen></iframe>
                        @else
                            <video controls class="w-full h-full" poster="{{ asset('images/video-placeholder.jpg') }}">
                                <source src="{{ $content->content_url }}" type="video/mp4">
                                <p style="color: #FFFFFF;">Your browser does not support the video tag.</p>
                            </video>
                        @endif
                    </div>
                @else
                    <div class="aspect-video rounded-lg flex flex-col items-center justify-center gap-3" style="background-color: #F3F4F6;">
                        <i class="fas fa-video text-4xl md:text-5xl" style="color: #9CA3AF;"></i>
                        <p class="text-sm md:text-base" style="color: #6B7280;">Video content not available</p>
                    </div>
                @endif
                
            @elseif($content->type == 'audio')
                <div class="rounded-lg p-6" style="background-color: #F9FAFB;">
                    <div class="flex items-center justify-center mb-4">
                        <i class="fas fa-headphones text-4xl md:text-5xl" style="color: #F57C00;"></i>
                    </div>
                    @if($content->content_url)
                        <audio controls class="w-full">
                            <source src="{{ $content->content_url }}">
                            <p style="color: #6B7280;">Your browser does not support the audio element.</p>
                        </audio>
                    @endif
                </div>
                
            @elseif($content->type == 'pdf')
                @if($content->content_url)
                    <div class="text-center py-6">
                        <a href="{{ $content->content_url }}" target="_blank" class="inline-flex items-center gap-2 font-semibold px-5 py-3 rounded-lg transition-all hover:shadow-md" style="background-color: #F57C00; color: #FFFFFF;">
                            <i class="fas fa-download"></i> Download PDF
                        </a>
                        <p class="text-xs md:text-sm mt-3" style="color: #6B7280;">Click to download or view the PDF document.</p>
                    </div>
                @endif
                
            @elseif($content->type == 'text')
                <div class="prose prose-sm md:prose-base max-w-none" style="color: #374151; line-height: 1.6;">
                    {!! nl2br(e($content->text_content)) !!}
                </div>
            @endif
            
            @if($content->duration)
                <div class="mt-5 pt-3 border-t flex items-center gap-2 text-xs md:text-sm" style="border-color: #E5E7EB; color: #6B7280;">
                    <i class="far fa-clock"></i> Estimated time: {{ $content->duration }} minutes
                </div>
            @endif
        </div>
    </div>
    
    {{-- Navigation between contents - Mobile friendly --}}
    @php
        $contents = $content->category->contents;
        $currentIndex = $contents->search(function($item) use ($content) {
            return $item->id === $content->id;
        });
        $prevContent = $currentIndex > 0 ? $contents[$currentIndex - 1] : null;
        $nextContent = $currentIndex < $contents->count() - 1 ? $contents[$currentIndex + 1] : null;
    @endphp
    
    @if($prevContent || $nextContent)
    <div class="mt-6 flex flex-col sm:flex-row justify-between gap-3">
        @if($prevContent)
            <a href="{{ route('user.skill.content', [$skill->slug, $content->category->slug, $prevContent->id]) }}" class="inline-flex items-center gap-2 text-sm font-medium transition-colors py-2 px-3 rounded-lg hover:bg-orange-50 justify-center sm:justify-start" style="color: #F57C00;">
                <i class="fas fa-chevron-left text-xs"></i> Previous: {{ Str::limit($prevContent->title, 40) }}
            </a>
        @else
            <div></div>
        @endif
        
        @if($nextContent)
            <a href="{{ route('user.skill.content', [$skill->slug, $content->category->slug, $nextContent->id]) }}" class="inline-flex items-center gap-2 text-sm font-medium transition-colors py-2 px-3 rounded-lg hover:bg-orange-50 justify-center sm:justify-end" style="color: #F57C00;">
                Next: {{ Str::limit($nextContent->title, 40) }} <i class="fas fa-chevron-right text-xs"></i>
            </a>
        @endif
    </div>
    @endif
</div>

<style>
    /* Additional responsive touch improvements for content page */
    @media (max-width: 640px) {
        .prose {
            font-size: 0.95rem;
        }
        audio {
            width: 100%;
        }
        iframe {
            max-width: 100%;
        }
    }
    
    /* Better focus states for interactive elements */
    a:focus-visible, button:focus-visible {
        outline: 2px solid #F57C00;
        outline-offset: 2px;
        border-radius: 0.5rem;
    }
    
    /* Smooth transitions */
    .transition-all {
        transition-duration: 0.2s;
    }
</style>
@endsection