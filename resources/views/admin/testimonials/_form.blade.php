<div class="w-full">

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 w-full">

        {{-- Name --}}
        <div class="w-full">
            <label class="block text-[10px] font-semibold text-gray-500 uppercase mb-1">
                Jina la Mteja <span class="text-red-500">*</span>
            </label>
            <input type="text" name="name" value="{{ old('name', $testimonial->name ?? '') }}" required
                   class="w-full px-2.5 py-1.5 text-xs border border-gray-300 rounded-md focus:ring-1 focus:ring-primary focus:border-primary"
                   placeholder="e.g., Faraja M.">
            @error('name') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Location --}}
        <div class="w-full">
            <label class="block text-[10px] font-semibold text-gray-500 uppercase mb-1">
                Mahali
            </label>
            <input type="text" name="location" value="{{ old('location', $testimonial->location ?? '') }}"
                   class="w-full px-2.5 py-1.5 text-xs border border-gray-300 rounded-md focus:ring-1 focus:ring-primary"
                   placeholder="e.g., Dar es Salaam">
            @error('location') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Rating --}}
        <div class="w-full">
            <label class="block text-[10px] font-semibold text-gray-500 uppercase mb-1">
                Nyota (1–5)
            </label>
            <select name="rating"
                    class="w-full px-2.5 py-1.5 text-xs border border-gray-300 rounded-md focus:ring-1 focus:ring-primary">
                @for($i=5; $i>=1; $i--)
                    <option value="{{ $i }}" {{ old('rating', $testimonial->rating ?? 5) == $i ? 'selected' : '' }}>
                        {{ $i }} Nyota
                    </option>
                @endfor
            </select>
            @error('rating') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Active --}}
        <div class="flex items-center mt-2 sm:mt-0 w-full">
            <label class="flex items-center">
                <input type="checkbox" name="is_active" value="1"
                       {{ old('is_active', $testimonial->is_active ?? true) ? 'checked' : '' }}
                       class="w-3.5 h-3.5 text-primary border-gray-300 rounded focus:ring-primary">
                <span class="ml-2 text-xs text-gray-600">
                    Inaonekana
                </span>
            </label>
        </div>

        {{-- Content (FULL WIDTH) --}}
        <div class="sm:col-span-2 lg:col-span-3 w-full">
            <label class="block text-[10px] font-semibold text-gray-500 uppercase mb-1">
                Ushuhuda <span class="text-red-500">*</span>
            </label>
            <textarea name="content" rows="2" required
                      class="w-full px-2.5 py-1.5 text-xs border border-gray-300 rounded-md focus:ring-1 focus:ring-primary"
                      placeholder="Maoni ya mteja...">{{ old('content', $testimonial->content ?? '') }}</textarea>
            @error('content') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Profile Image --}}
        <div class="w-full">
            <label class="block text-[10px] font-semibold text-gray-500 uppercase mb-1">
                Picha ya Profaili
            </label>
            <input type="file" name="image" accept="image/*"
                   class="w-full text-xs border border-gray-300 rounded-md file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-xs file:bg-gray-100 hover:file:bg-gray-200">
            <p class="text-[10px] text-gray-400 mt-1">Max 2MB</p>

            @if(isset($testimonial) && $testimonial->image)
                <div class="mt-2 flex items-center gap-2">
                    <img src="{{ asset('storage/' . $testimonial->image) }}" class="w-7 h-7 rounded-full object-cover">
                    <span class="text-[10px] text-gray-500">Picha ya sasa</span>
                </div>
            @endif

            @error('image') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Screenshot --}}
        <div class="w-full">
            <label class="block text-[10px] font-semibold text-gray-500 uppercase mb-1">
                Screenshot
            </label>
            <input type="file" name="screenshot" accept="image/*"
                   class="w-full text-xs border border-gray-300 rounded-md file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-xs file:bg-gray-100 hover:file:bg-gray-200">
            <p class="text-[10px] text-gray-400 mt-1">Uthibitisho</p>

            @if(isset($testimonial) && $testimonial->screenshot)
                <div class="mt-2">
                    <a href="{{ asset('storage/' . $testimonial->screenshot) }}" target="_blank"
                       class="text-primary text-[10px]">
                        <i class="fas fa-image mr-1"></i> Angalia
                    </a>
                </div>
            @endif

            @error('screenshot') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
        </div>

    </div>

</div>