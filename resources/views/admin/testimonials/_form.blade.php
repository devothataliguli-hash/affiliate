<div class="space-y-5">
    {{-- Name --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Name <span class="text-red-500">*</span></label>
        <input type="text" name="name" value="{{ old('name', $testimonial->name ?? '') }}" required
               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition"
               placeholder="e.g., Faraja M.">
        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Location --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
        <input type="text" name="location" value="{{ old('location', $testimonial->location ?? '') }}"
               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition"
               placeholder="e.g., Dar es Salaam">
        @error('location') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Content --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Testimonial Content <span class="text-red-500">*</span></label>
        <textarea name="content" rows="4" required
                  class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition"
                  placeholder="What the user said...">{{ old('content', $testimonial->content ?? '') }}</textarea>
        @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Profile Image --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Profile Image (Optional)</label>
        <input type="file" name="image" accept="image/*"
               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition">
        <p class="text-xs text-gray-500 mt-1">Recommended: square image, max 2MB.</p>
        
        @if(isset($testimonial) && $testimonial->image)
            <div class="mt-2 flex items-center">
                <img src="{{ asset('storage/' . $testimonial->image) }}" class="w-10 h-10 rounded-full object-cover mr-2">
                <span class="text-sm text-gray-600">Current image</span>
            </div>
        @endif
        @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Screenshot --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Payment Screenshot (Optional)</label>
        <input type="file" name="screenshot" accept="image/*"
               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition">
        <p class="text-xs text-gray-500 mt-1">Upload payment proof or WhatsApp screenshot.</p>
        
        @if(isset($testimonial) && $testimonial->screenshot)
            <div class="mt-2">
                <a href="{{ asset('storage/' . $testimonial->screenshot) }}" target="_blank" class="text-primary hover:underline text-sm">
                    <i class="fas fa-image mr-1"></i> View current screenshot
                </a>
            </div>
        @endif
        @error('screenshot') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Rating --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Rating (1-5)</label>
        <select name="rating" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition">
            @for($i=5; $i>=1; $i--)
                <option value="{{ $i }}" {{ old('rating', $testimonial->rating ?? 5) == $i ? 'selected' : '' }}>
                    {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                </option>
            @endfor
        </select>
        @error('rating') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Active Status --}}
    <div class="flex items-center">
        <input type="checkbox" name="is_active" id="is_active" value="1" 
               {{ old('is_active', $testimonial->is_active ?? true) ? 'checked' : '' }}
               class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
        <label for="is_active" class="ml-2 text-sm text-gray-700">Active (show on landing page)</label>
    </div>
</div>