@extends('layouts.admin')

@section('title', 'Edit Content - ' . $content->title)

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-4">
    <div class="mb-5 md:mb-6">
        <a href="{{ route('admin.categories.contents.index', $category) }}" class="inline-flex items-center gap-2 text-sm font-medium transition-colors py-2 px-1 rounded-lg hover:bg-orange-50" style="color: #F57C00;">
            <i class="fas fa-arrow-left text-xs"></i> Back to Content
        </a>
    </div>
    
    <div class="rounded-xl shadow-md overflow-hidden" style="background-color: #FFFFFF;">
        <div class="px-5 md:px-6 py-4 border-b" style="background: linear-gradient(135deg, #FFF3E0, #c57a0a); border-color: #E5E7EB;">
            <h1 class="text-lg md:text-xl font-bold" style="color: #1F2937;">Edit Content: {{ $content->title }}</h1>
            <p class="text-sm mt-0.5" style="color: #6B7280;">Update learning material</p>
        </div>
        
        <form action="{{ route('admin.categories.contents.update', [$category, $content]) }}" method="POST" enctype="multipart/form-data" class="p-5 md:p-6">
            @csrf
            @method('PUT')
            
            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2" style="color: #374151;">Content Title *</label>
                <input type="text" name="title" class="w-full px-4 py-3 rounded-lg border transition-all focus:outline-none focus:ring-2" style="border-color: #D1D5DB; background-color: #FFFFFF; color: #1F2937;" value="{{ old('title', $content->title) }}" required>
                @error('title') <p class="text-xs mt-1" style="color: #DC2626;">{{ $message }}</p> @enderror
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
                <div>
                    <label class="block text-sm font-semibold mb-2" style="color: #374151;">Content Type</label>
                    <select name="type" class="w-full px-4 py-3 rounded-lg border" style="border-color: #D1D5DB; background-color: #F3F4F6; color: #6B7280;" disabled>
                        <option value="{{ $content->type }}">{{ ucfirst($content->type) }}</option>
                    </select>
                    <input type="hidden" name="type" value="{{ $content->type }}">
                    <p class="text-xs mt-1" style="color: #6B7280;">Content type cannot be changed after creation</p>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold mb-2" style="color: #374151;">Duration (minutes)</label>
                    <input type="number" name="duration" class="w-full px-4 py-3 rounded-lg border transition-all focus:outline-none focus:ring-2" style="border-color: #D1D5DB; background-color: #FFFFFF; color: #1F2937;" value="{{ old('duration', $content->duration) }}" placeholder="e.g., 15">
                </div>
            </div>
            
            @if($content->type == 'video')
            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2" style="color: #374151;">Video URL (YouTube or other)</label>
                <input type="url" name="video_url" class="w-full px-4 py-3 rounded-lg border transition-all focus:outline-none focus:ring-2" style="border-color: #D1D5DB; background-color: #FFFFFF; color: #1F2937;" value="{{ old('video_url', $content->video_url) }}" placeholder="https://www.youtube.com/embed/...">
                @if($content->video_url)
                    <p class="text-xs mt-1" style="color: #6B7280;">Current video URL: <span class="font-mono">{{ $content->video_url }}</span></p>
                @endif
            </div>
            
            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2" style="color: #374151;">Replace Video File (optional)</label>
                <input type="file" name="file" accept="video/*" class="w-full px-4 py-2 rounded-lg border transition-all" style="border-color: #D1D5DB; background-color: #F9FAFB; color: #1F2937;">
                @if($content->file_path)
                    <p class="text-xs mt-1" style="color: #059669;">Current file: {{ basename($content->file_path) }}</p>
                @endif
                @error('file') <p class="text-xs mt-1" style="color: #DC2626;">{{ $message }}</p> @enderror
            </div>
            @endif
            
            @if($content->type == 'audio')
            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2" style="color: #374151;">Audio URL</label>
                <input type="url" name="audio_url" class="w-full px-4 py-3 rounded-lg border transition-all focus:outline-none focus:ring-2" style="border-color: #D1D5DB; background-color: #FFFFFF; color: #1F2937;" value="{{ old('audio_url', $content->audio_url) }}" placeholder="https://example.com/audio.mp3">
            </div>
            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2" style="color: #374151;">Replace Audio File</label>
                <input type="file" name="file" accept="audio/*" class="w-full px-4 py-2 rounded-lg border transition-all" style="border-color: #D1D5DB; background-color: #F9FAFB; color: #1F2937;">
            </div>
            @endif
            
            @if($content->type == 'pdf')
            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2" style="color: #374151;">PDF URL</label>
                <input type="url" name="pdf_url" class="w-full px-4 py-3 rounded-lg border transition-all focus:outline-none focus:ring-2" style="border-color: #D1D5DB; background-color: #FFFFFF; color: #1F2937;" value="{{ old('pdf_url', $content->pdf_url) }}" placeholder="https://example.com/document.pdf">
            </div>
            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2" style="color: #374151;">Replace PDF File</label>
                <input type="file" name="file" accept=".pdf" class="w-full px-4 py-2 rounded-lg border transition-all" style="border-color: #D1D5DB; background-color: #F9FAFB; color: #1F2937;">
            </div>
            @endif
            
            @if($content->type == 'text')
            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2" style="color: #374151;">Article Content</label>
                <textarea name="text_content" rows="10" class="w-full px-4 py-3 rounded-lg border transition-all focus:outline-none focus:ring-2" style="border-color: #D1D5DB; background-color: #FFFFFF; color: #1F2937; font-family: monospace;">{{ old('text_content', $content->text_content) }}</textarea>
                @error('text_content') <p class="text-xs mt-1" style="color: #DC2626;">{{ $message }}</p> @enderror
            </div>
            @endif
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
                <div>
                    <label class="block text-sm font-semibold mb-2" style="color: #374151;">Display Order</label>
                    <input type="number" name="order" class="w-full px-4 py-3 rounded-lg border transition-all focus:outline-none focus:ring-2" style="border-color: #D1D5DB; background-color: #FFFFFF; color: #1F2937;" value="{{ old('order', $content->order) }}" placeholder="0">
                    <p class="text-xs mt-1" style="color: #6B7280;">Lower numbers appear first</p>
                </div>
                
                <div class="flex items-center mt-6">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_free_preview" value="1" class="w-4 h-4 rounded" style="accent-color: #F57C00;" {{ $content->is_free_preview ? 'checked' : '' }}>
                        <span class="text-sm font-semibold" style="color: #374151;">Free Preview (visible before purchase)</span>
                    </label>
                </div>
            </div>
            
            <div class="flex flex-wrap gap-3">
                <button type="submit" class="font-semibold px-6 py-2.5 rounded-lg transition hover:shadow-md active:scale-98" style="background-color: #F57C00; color: #FFFFFF;">Update Content</button>
                <a href="{{ route('admin.categories.contents.index', $category) }}" class="font-semibold px-6 py-2.5 rounded-lg transition hover:bg-gray-300 active:scale-98" style="background-color: #E5E7EB; color: #374151;">Cancel</a>
            </div>
        </form>
    </div>
</div>

<style>
    input:focus, textarea:focus, select:focus {
        outline: none;
        border-color: #F57C00;
        box-shadow: 0 0 0 3px rgba(245, 124, 0, 0.1);
    }
    
    button:active, a:active {
        transform: scale(0.98);
    }
    
    @media (max-width: 640px) {
        input, textarea, select, button {
            font-size: 16px;
        }
    }
</style>
@endsection