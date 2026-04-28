@extends('layouts.admin')

@section('title', 'Add Testimonial')

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-4">
    <div class="mb-5 md:mb-6">
        <a href="{{ route('admin.testimonials.index') }}" class="inline-flex items-center gap-2 text-sm font-medium transition-colors py-2 px-1 rounded-lg hover:bg-orange-50" style="color: #F57C00;">
            <i class="fas fa-arrow-left text-xs"></i> Back to Testimonials
        </a>
    </div>
    
    <div class="rounded-xl shadow-md overflow-hidden" style="background-color: #FFFFFF;">
        <div class="px-5 md:px-6 py-4 border-b" style="background: linear-gradient(135deg, #FFF3E0, #FFE0B2); border-color: #E5E7EB;">
            <h1 class="text-lg md:text-xl font-bold" style="color: #1F2937;">Add New Testimonial</h1>
            <p class="text-sm mt-0.5" style="color: #6B7280;">Share student success stories on your platform</p>
        </div>
        
        <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data" class="p-5 md:p-6">
            @csrf
            
            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2" style="color: #374151;">Student Name *</label>
                <input type="text" name="name" class="w-full px-4 py-3 rounded-lg border transition-all focus:outline-none focus:ring-2" style="border-color: #D1D5DB; background-color: #FFFFFF; color: #1F2937;" value="{{ old('name') }}" required>
                @error('name') <p class="text-xs mt-1" style="color: #DC2626;">{{ $message }}</p> @enderror
            </div>
            
            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2" style="color: #374151;">Email</label>
                <input type="email" name="email" class="w-full px-4 py-3 rounded-lg border transition-all focus:outline-none focus:ring-2" style="border-color: #D1D5DB; background-color: #FFFFFF; color: #1F2937;" value="{{ old('email') }}">
                <p class="text-xs mt-1" style="color: #6B7280;">Optional, for contact purposes</p>
                @error('email') <p class="text-xs mt-1" style="color: #DC2626;">{{ $message }}</p> @enderror
            </div>
            
            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2" style="color: #374151;">Location</label>
                <input type="text" name="location" class="w-full px-4 py-3 rounded-lg border transition-all focus:outline-none focus:ring-2" style="border-color: #D1D5DB; background-color: #FFFFFF; color: #1F2937;" value="{{ old('location') }}" placeholder="e.g., Dar es Salaam, Tanzania">
                @error('location') <p class="text-xs mt-1" style="color: #DC2626;">{{ $message }}</p> @enderror
            </div>
            
            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2" style="color: #374151;">Testimonial Content *</label>
                <textarea name="content" rows="4" class="w-full px-4 py-3 rounded-lg border transition-all focus:outline-none focus:ring-2" style="border-color: #D1D5DB; background-color: #FFFFFF; color: #1F2937;" required>{{ old('content') }}</textarea>
                <p class="text-xs mt-1" style="color: #6B7280;">Share what the student said about their learning experience</p>
                @error('content') <p class="text-xs mt-1" style="color: #DC2626;">{{ $message }}</p> @enderror
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
                <div>
                    <label class="block text-sm font-semibold mb-2" style="color: #374151;">Rating (1-5)</label>
                    <select name="rating" class="w-full px-4 py-3 rounded-lg border transition-all focus:outline-none focus:ring-2" style="border-color: #D1D5DB; background-color: #FFFFFF; color: #1F2937;">
                        <option value="5" selected>★★★★★ (5) - Excellent</option>
                        <option value="4">★★★★☆ (4) - Very Good</option>
                        <option value="3">★★★☆☆ (3) - Good</option>
                        <option value="2">★★☆☆☆ (2) - Fair</option>
                        <option value="1">★☆☆☆☆ (1) - Poor</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold mb-2" style="color: #374151;">Display Order</label>
                    <input type="number" name="order" class="w-full px-4 py-3 rounded-lg border transition-all focus:outline-none focus:ring-2" style="border-color: #D1D5DB; background-color: #FFFFFF; color: #1F2937;" value="{{ old('order', 0) }}">
                    <p class="text-xs mt-1" style="color: #6B7280;">Lower numbers appear first on the website</p>
                </div>
            </div>
            
            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2" style="color: #374151;">Profile Image</label>
                <input type="file" name="image" accept="image/*" class="w-full px-4 py-2 rounded-lg border transition-all" style="border-color: #D1D5DB; background-color: #F9FAFB; color: #1F2937;">
                <p class="text-xs mt-1" style="color: #6B7280;">Recommended: 200x200 pixels, JPG or PNG format. Max 2MB.</p>
                @error('image') <p class="text-xs mt-1" style="color: #DC2626;">{{ $message }}</p> @enderror
            </div>
            
            <div class="mb-6">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" class="w-4 h-4 rounded" style="accent-color: #F57C00;" checked>
                    <span class="text-sm font-semibold" style="color: #374151;">Active (show on website immediately)</span>
                </label>
            </div>
            
            <div class="flex flex-wrap gap-3">
                <button type="submit" class="font-semibold px-6 py-2.5 rounded-lg transition hover:shadow-md active:scale-98" style="background-color: #F57C00; color: #FFFFFF;">Add Testimonial</button>
                <a href="{{ route('admin.testimonials.index') }}" class="font-semibold px-6 py-2.5 rounded-lg transition hover:bg-gray-300 active:scale-98" style="background-color: #E5E7EB; color: #374151;">Cancel</a>
            </div>
        </form>
    </div>
</div>

<style>
    input:focus, select:focus, textarea:focus {
        outline: none;
        border-color: #F57C00;
        box-shadow: 0 0 0 3px rgba(245, 124, 0, 0.1);
    }
    
    button:active, a:active {
        transform: scale(0.98);
    }
    
    @media (max-width: 640px) {
        input, select, textarea, button {
            font-size: 16px;
        }
    }
</style>
@endsection