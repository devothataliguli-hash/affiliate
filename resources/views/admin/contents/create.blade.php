@extends('layouts.admin')

@section('title', 'Add Content - ' . $category->name)

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-4">
    <div class="mb-5 md:mb-6">
        <a href="{{ route('admin.categories.contents.index', $category) }}" class="inline-flex items-center gap-2 text-sm font-medium transition-colors py-2 px-1 rounded-lg hover:bg-orange-50" style="color: #F57C00;">
            <i class="fas fa-arrow-left text-xs"></i> Back to Content
        </a>
    </div>
    
    <div class="rounded-xl shadow-md overflow-hidden" style="background-color: #FFFFFF;">
        <div class="px-5 md:px-6 py-4 border-b" style="background: linear-gradient(135deg, #FFF3E0, #b36d05); border-color: #E5E7EB;">
            <h1 class="text-lg md:text-xl font-bold" style="color: #1F2937;">Add Content to: {{ $category->name }}</h1>
            <p class="text-sm mt-0.5" style="color: #6B7280;">Upload new learning material</p>
        </div>
        
        <form action="{{ route('admin.categories.contents.store', $category) }}" method="POST" enctype="multipart/form-data" class="p-5 md:p-6">
            @csrf
            
            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2" style="color: #374151;">Content Title *</label>
                <input type="text" name="title" class="w-full px-4 py-3 rounded-lg border transition-all focus:outline-none focus:ring-2" style="border-color: #D1D5DB; background-color: #FFFFFF; color: #1F2937;" value="{{ old('title') }}" required placeholder="e.g., Introduction to the Course">
                @error('title') <p class="text-xs mt-1" style="color: #DC2626;">{{ $message }}</p> @enderror
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
                <div>
                    <label class="block text-sm font-semibold mb-2" style="color: #374151;">Content Type *</label>
                    <select name="type" id="contentType" class="w-full px-4 py-3 rounded-lg border transition-all focus:outline-none focus:ring-2" style="border-color: #D1D5DB; background-color: #FFFFFF; color: #1F2937;" required>
                        <option value="">Select Type</option>
                        <option value="video" {{ old('type') == 'video' ? 'selected' : '' }}>📹 Video</option>
                        <option value="audio" {{ old('type') == 'audio' ? 'selected' : '' }}>🎵 Audio</option>
                        <option value="pdf" {{ old('type') == 'pdf' ? 'selected' : '' }}>📄 PDF Document</option>
                        <option value="text" {{ old('type') == 'text' ? 'selected' : '' }}>📝 Text / Article</option>
                    </select>
                    @error('type') <p class="text-xs mt-1" style="color: #DC2626;">{{ $message }}</p> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-semibold mb-2" style="color: #374151;">Duration (minutes)</label>
                    <input type="number" name="duration" class="w-full px-4 py-3 rounded-lg border transition-all focus:outline-none focus:ring-2" style="border-color: #D1D5DB; background-color: #FFFFFF; color: #1F2937;" value="{{ old('duration') }}" placeholder="e.g., 15">
                    <p class="text-xs mt-1" style="color: #6B7280;">Estimated time to complete</p>
                </div>
            </div>
            
            {{-- Video Fields --}}
            <div id="videoFields" class="mb-5" style="display: none;">
                <label class="block text-sm font-semibold mb-2" style="color: #374151;">Video Upload or URL</label>
                <div class="space-y-3">
                    <div class="rounded-lg border-2 border-dashed p-4 text-center transition" style="border-color: #D1D5DB; background-color: #F9FAFB;">
                        <input type="file" name="file" accept="video/*" class="w-full text-sm" style="color: #4B5563;">
                        <p class="text-xs mt-2" style="color: #6B7280;">MP4, AVI, MOV (Max 100MB)</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="flex-1 h-px" style="background-color: #E5E7EB;"></div>
                        <span class="text-xs" style="color: #9CA3AF;">OR</span>
                        <div class="flex-1 h-px" style="background-color: #E5E7EB;"></div>
                    </div>
                    <input type="url" name="video_url" placeholder="YouTube or Video URL" class="w-full px-4 py-3 rounded-lg border transition-all focus:outline-none focus:ring-2" style="border-color: #D1D5DB; background-color: #FFFFFF; color: #1F2937;">
                </div>
                @error('file') <p class="text-xs mt-1" style="color: #DC2626;">{{ $message }}</p> @enderror
                @error('video_url') <p class="text-xs mt-1" style="color: #DC2626;">{{ $message }}</p> @enderror
            </div>
            
            {{-- Audio Fields --}}
            <div id="audioFields" class="mb-5" style="display: none;">
                <label class="block text-sm font-semibold mb-2" style="color: #374151;">Audio Upload or URL</label>
                <div class="space-y-3">
                    <div class="rounded-lg border-2 border-dashed p-4 text-center" style="border-color: #D1D5DB; background-color: #F9FAFB;">
                        <input type="file" name="file" accept="audio/*" class="w-full text-sm" style="color: #4B5563;">
                        <p class="text-xs mt-2" style="color: #6B7280;">MP3, WAV, OGG (Max 20MB)</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="flex-1 h-px" style="background-color: #E5E7EB;"></div>
                        <span class="text-xs" style="color: #9CA3AF;">OR</span>
                        <div class="flex-1 h-px" style="background-color: #E5E7EB;"></div>
                    </div>
                    <input type="url" name="audio_url" placeholder="Audio URL" class="w-full px-4 py-3 rounded-lg border transition-all focus:outline-none focus:ring-2" style="border-color: #D1D5DB; background-color: #FFFFFF; color: #1F2937;">
                </div>
                @error('file') <p class="text-xs mt-1" style="color: #DC2626;">{{ $message }}</p> @enderror
                @error('audio_url') <p class="text-xs mt-1" style="color: #DC2626;">{{ $message }}</p> @enderror
            </div>
            
            {{-- PDF Fields --}}
            <div id="pdfFields" class="mb-5" style="display: none;">
                <label class="block text-sm font-semibold mb-2" style="color: #374151;">PDF Upload or URL</label>
                <div class="space-y-3">
                    <div class="rounded-lg border-2 border-dashed p-4 text-center" style="border-color: #D1D5DB; background-color: #F9FAFB;">
                        <input type="file" name="file" accept=".pdf" class="w-full text-sm" style="color: #4B5563;">
                        <p class="text-xs mt-2" style="color: #6B7280;">PDF files only (Max 10MB)</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="flex-1 h-px" style="background-color: #E5E7EB;"></div>
                        <span class="text-xs" style="color: #9CA3AF;">OR</span>
                        <div class="flex-1 h-px" style="background-color: #E5E7EB;"></div>
                    </div>
                    <input type="url" name="pdf_url" placeholder="PDF URL" class="w-full px-4 py-3 rounded-lg border transition-all focus:outline-none focus:ring-2" style="border-color: #D1D5DB; background-color: #FFFFFF; color: #1F2937;">
                </div>
                @error('file') <p class="text-xs mt-1" style="color: #DC2626;">{{ $message }}</p> @enderror
                @error('pdf_url') <p class="text-xs mt-1" style="color: #DC2626;">{{ $message }}</p> @enderror
            </div>
            
            {{-- Text Fields --}}
            <div id="textFields" class="mb-5" style="display: none;">
                <label class="block text-sm font-semibold mb-2" style="color: #374151;">Article Content</label>
                <textarea name="text_content" rows="10" class="w-full px-4 py-3 rounded-lg border transition-all focus:outline-none focus:ring-2" style="border-color: #D1D5DB; background-color: #FFFFFF; color: #1F2937; font-family: monospace;" placeholder="Write your article content here...">{{ old('text_content') }}</textarea>
                @error('text_content') <p class="text-xs mt-1" style="color: #DC2626;">{{ $message }}</p> @enderror
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
                <div>
                    <label class="block text-sm font-semibold mb-2" style="color: #374151;">Display Order</label>
                    <input type="number" name="order" class="w-full px-4 py-3 rounded-lg border transition-all focus:outline-none focus:ring-2" style="border-color: #D1D5DB; background-color: #FFFFFF; color: #1F2937;" value="{{ old('order', 0) }}" placeholder="0">
                    <p class="text-xs mt-1" style="color: #6B7280;">Lower numbers appear first in the list</p>
                </div>
                
                <div class="flex items-center mt-6">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_free_preview" value="1" class="w-4 h-4 rounded" style="accent-color: #F57C00;" {{ old('is_free_preview') ? 'checked' : '' }}>
                        <span class="text-sm font-semibold" style="color: #374151;">Free Preview (visible before purchase)</span>
                    </label>
                </div>
            </div>
            
            <div class="flex flex-wrap gap-3">
                <button type="submit" class="font-semibold px-6 py-2.5 rounded-lg transition hover:shadow-md active:scale-98" style="background-color: #F57C00; color: #FFFFFF;">Add Content</button>
                <a href="{{ route('admin.categories.contents.index', $category) }}" class="font-semibold px-6 py-2.5 rounded-lg transition hover:bg-gray-300 active:scale-98" style="background-color: #E5E7EB; color: #374151;">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
    const contentType = document.getElementById('contentType');
    const videoFields = document.getElementById('videoFields');
    const audioFields = document.getElementById('audioFields');
    const pdfFields = document.getElementById('pdfFields');
    const textFields = document.getElementById('textFields');
    
    function toggleFields() {
        const type = contentType.value;
        videoFields.style.display = 'none';
        audioFields.style.display = 'none';
        pdfFields.style.display = 'none';
        textFields.style.display = 'none';
        
        if (type === 'video') videoFields.style.display = 'block';
        else if (type === 'audio') audioFields.style.display = 'block';
        else if (type === 'pdf') pdfFields.style.display = 'block';
        else if (type === 'text') textFields.style.display = 'block';
    }
    
    contentType.addEventListener('change', toggleFields);
    toggleFields();
</script>

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