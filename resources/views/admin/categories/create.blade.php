@extends('layouts.admin')

@section('title', 'Add Category - ' . $skill->name)

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-4">
    <div class="mb-5 md:mb-6">
        <a href="{{ route('admin.skills.categories.index', $skill) }}" class="inline-flex items-center gap-2 text-sm font-medium transition-colors py-2 px-1 rounded-lg hover:bg-orange-50" style="color: #F57C00;">
            <i class="fas fa-arrow-left text-xs"></i> Back to Categories
        </a>
    </div>
    
    <div class="rounded-xl shadow-md overflow-hidden" style="background-color: #FFFFFF;">
        <div class="px-5 md:px-6 py-4 border-b" style="background: linear-gradient(135deg, #FFF3E0, #FFE0B2); border-color: #E5E7EB;">
            <h1 class="text-lg md:text-xl font-bold" style="color: #1F2937;">Add Category to: {{ $skill->name }}</h1>
            <p class="text-sm mt-0.5" style="color: #6B7280;">Create a new category to organize your content</p>
        </div>
        
        <form action="{{ route('admin.skills.categories.store', $skill) }}" method="POST" class="p-5 md:p-6">
            @csrf
            
            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2" style="color: #374151;">Category Name *</label>
                <input type="text" name="name" class="w-full px-4 py-3 rounded-lg border transition-all focus:outline-none focus:ring-2" style="border-color: #D1D5DB; background-color: #FFFFFF; color: #1F2937;" value="{{ old('name') }}" required placeholder="e.g., Introduction, Advanced Topics">
                @error('name') <p class="text-xs mt-1" style="color: #DC2626;">{{ $message }}</p> @enderror
            </div>
            
            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2" style="color: #374151;">Description</label>
                <textarea name="description" rows="3" class="w-full px-4 py-3 rounded-lg border transition-all focus:outline-none focus:ring-2" style="border-color: #D1D5DB; background-color: #FFFFFF; color: #1F2937;" placeholder="What will students learn in this category?">{{ old('description') }}</textarea>
                <p class="text-xs mt-1" style="color: #6B7280;">Optional but recommended for better organization</p>
                @error('description') <p class="text-xs mt-1" style="color: #DC2626;">{{ $message }}</p> @enderror
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-semibold mb-2" style="color: #374151;">Display Order</label>
                <input type="number" name="order" class="w-full px-4 py-3 rounded-lg border transition-all focus:outline-none focus:ring-2" style="border-color: #D1D5DB; background-color: #FFFFFF; color: #1F2937;" value="{{ old('order', 0) }}" placeholder="0">
                <p class="text-xs mt-1" style="color: #6B7280;">Lower numbers appear first. Categories with same order are sorted by name.</p>
                @error('order') <p class="text-xs mt-1" style="color: #DC2626;">{{ $message }}</p> @enderror
            </div>
            
            <div class="flex flex-wrap gap-3">
                <button type="submit" class="font-semibold px-6 py-2.5 rounded-lg transition hover:shadow-md active:scale-98" style="background-color: #F57C00; color: #FFFFFF;">Create Category</button>
                <a href="{{ route('admin.skills.categories.index', $skill) }}" class="font-semibold px-6 py-2.5 rounded-lg transition hover:bg-gray-300 active:scale-98" style="background-color: #E5E7EB; color: #374151;">Cancel</a>
            </div>
        </form>
    </div>
</div>

<style>
    input:focus, textarea:focus {
        outline: none;
        border-color: #F57C00;
        box-shadow: 0 0 0 3px rgba(245, 124, 0, 0.1);
    }
    
    button:active, a:active {
        transform: scale(0.98);
    }
    
    @media (max-width: 640px) {
        input, textarea, button {
            font-size: 16px;
        }
    }
</style>
@endsection