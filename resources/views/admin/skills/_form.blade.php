<div class="space-y-5">
    {{-- Skill Name --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Skill Name <span class="text-red-500">*</span></label>
        <input type="text" name="name" value="{{ old('name', $skill->name ?? '') }}" required
               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition"
               placeholder="e.g., Affiliate Marketing Basics">
        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Description --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
        <textarea name="description" rows="3" 
                  class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition"
                  placeholder="Brief description of what users will learn">{{ old('description', $skill->description ?? '') }}</textarea>
        @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Price --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Price (Tsh) <span class="text-red-500">*</span></label>
        <input type="number" name="price" value="{{ old('price', $skill->price ?? 0) }}" step="0.01" min="0" required
               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition"
               placeholder="0 for free, or enter amount">
        @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Video URL --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Video URL (YouTube, Vimeo, etc.)</label>
        <input type="url" name="video_url" value="{{ old('video_url', $skill->video_url ?? '') }}"
               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition"
               placeholder="https://youtube.com/watch?v=... or https://vimeo.com/...">
        <p class="text-xs text-gray-500 mt-1">Leave empty if uploading a video file instead.</p>
        @error('video_url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Video File Upload --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">OR Upload Video File</label>
        <input type="file" name="video_file" accept="video/mp4,video/quicktime,video/x-msvideo" 
               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition">
        <p class="text-xs text-gray-500 mt-1">Max size: 20MB. Supported: MP4, MOV, AVI.</p>
        
        @if(isset($skill) && $skill->video_url && !filter_var($skill->video_url, FILTER_VALIDATE_URL))
            <div class="mt-2 p-2 bg-gray-50 rounded border flex items-center">
                <i class="fas fa-video text-primary mr-2"></i>
                <span class="text-sm">Current video: <a href="{{ $skill->video_url }}" target="_blank" class="text-primary hover:underline">View</a></span>
            </div>
        @endif
        @error('video_file') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Notes / Rich Content --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Notes / Course Content</label>
        <textarea name="notes" rows="8" 
                  class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition"
                  placeholder="You can use HTML for formatting. Write the full lesson content here.">{{ old('notes', $skill->notes ?? '') }}</textarea>
        <p class="text-xs text-gray-500 mt-1">HTML allowed. This will be displayed to users who purchase the skill.</p>
        @error('notes') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Active Status --}}
    <div class="flex items-center">
        <input type="checkbox" name="is_active" id="is_active" value="1" 
               {{ old('is_active', $skill->is_active ?? true) ? 'checked' : '' }}
               class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
        <label for="is_active" class="ml-2 text-sm text-gray-700">Active (visible to users)</label>
    </div>
</div>