@extends('layouts.app')

@section('title', $skill->name . ' - ELLYPESA')
@section('page-title', $skill->name)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    
    {{-- Video Section --}}
    @if($skill->video_url)
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="aspect-w-16 aspect-h-9">
            @if(str_contains($skill->video_url, 'youtube.com') || str_contains($skill->video_url, 'youtu.be'))
                @php
                    // Extract YouTube video ID
                    preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $skill->video_url, $matches);
                    $videoId = $matches[1] ?? '';
                @endphp
                @if($videoId)
                <iframe src="https://www.youtube.com/embed/{{ $videoId }}" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen
                        class="w-full h-64 md:h-96"></iframe>
                @else
                <div class="p-4">
                    <a href="{{ $skill->video_url }}" target="_blank" class="text-primary hover:underline">
                        <i class="fas fa-external-link-alt mr-2"></i>Tazama Video
                    </a>
                </div>
                @endif
            @elseif(str_contains($skill->video_url, 'vimeo.com'))
                @php
                    preg_match('/vimeo\.com\/(\d+)/', $skill->video_url, $matches);
                    $videoId = $matches[1] ?? '';
                @endphp
                @if($videoId)
                <iframe src="https://player.vimeo.com/video/{{ $videoId }}" 
                        frameborder="0" 
                        allow="autoplay; fullscreen; picture-in-picture" 
                        allowfullscreen
                        class="w-full h-64 md:h-96"></iframe>
                @else
                <div class="p-4">
                    <a href="{{ $skill->video_url }}" target="_blank" class="text-primary hover:underline">
                        <i class="fas fa-external-link-alt mr-2"></i>Tazama Video
                    </a>
                </div>
                @endif
            @else
                {{-- Direct video file --}}
                <video controls class="w-full h-64 md:h-96">
                    <source src="{{ $skill->video_url }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            @endif
        </div>
    </div>
    @endif

    {{-- Notes Section --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">📝 Maelezo na Mafunzo</h2>
        
        @if($skill->notes)
            <div class="prose prose-sm max-w-none text-gray-700">
                {!! nl2br(e($skill->notes)) !!}
            </div>
        @else
            <p class="text-gray-500">Hakuna maelezo ya ziada kwa sasa.</p>
        @endif
    </div>

    {{-- Resources (Optional) --}}
    <div class="bg-gray-50 rounded-2xl p-6 text-center">
        <p class="text-sm text-gray-600">
            <i class="fas fa-question-circle mr-1"></i> 
            Una swali? Wasiliana nasi kupitia 
            <a href="https://wa.me/255678043562" target="_blank" class="text-primary hover:underline">WhatsApp</a>
        </p>
    </div>
</div>
@endsection