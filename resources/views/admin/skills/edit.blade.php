@extends('layouts.admin')

@section('title', 'Edit ' . $skill->name)

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-4">
    <div class="mb-5 md:mb-6">
        <a href="{{ route('admin.skills.index') }}" class="inline-flex items-center gap-2 text-sm font-medium transition-colors py-2 px-1 rounded-lg hover:bg-orange-50" style="color: #F57C00;">
            <i class="fas fa-arrow-left text-xs"></i> Back to Skills
        </a>
    </div>
    
    <div class="rounded-xl shadow-md overflow-hidden" style="background-color: #FFFFFF;">
        <div class="px-5 md:px-6 py-4 border-b" style="background: linear-gradient(135deg, #FFF3E0, #FFE0B2); border-color: #E5E7EB;">
            <h1 class="text-lg md:text-xl font-bold" style="color: #1F2937;">Edit Skill: {{ $skill->name }}</h1>
            <p class="text-sm mt-0.5" style="color: #6B7280;">Update skill information and settings</p>
        </div>
        
        <form action="{{ route('admin.skills.update', $skill) }}" method="POST" class="p-5 md:p-6">
            @csrf
            @method('PUT')
            
            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2" style="color: #374151;">Skill Name *</label>
                <input type="text" name="name" class="w-full px-4 py-3 rounded-lg border transition-all focus:outline-none focus:ring-2" style="border-color: #D1D5DB; background-color: #FFFFFF; color: #1F2937;" value="{{ old('name', $skill->name) }}" required>
                @error('name') <p class="text-xs mt-1" style="color: #DC2626;">{{ $message }}</p> @enderror
            </div>
            
            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2" style="color: #374151;">Description</label>
                <textarea name="description" rows="4" class="w-full px-4 py-3 rounded-lg border transition-all focus:outline-none focus:ring-2" style="border-color: #D1D5DB; background-color: #FFFFFF; color: #1F2937;">{{ old('description', $skill->description) }}</textarea>
                @error('description') <p class="text-xs mt-1" style="color: #DC2626;">{{ $message }}</p> @enderror
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
                <div>
                    <label class="block text-sm font-semibold mb-2" style="color: #374151;">Price (Tsh) *</label>
                    <input type="number" name="price" class="w-full px-4 py-3 rounded-lg border transition-all focus:outline-none focus:ring-2" style="border-color: #D1D5DB; background-color: #FFFFFF; color: #1F2937;" value="{{ old('price', $skill->price) }}" required>
                    @error('price') <p class="text-xs mt-1" style="color: #DC2626;">{{ $message }}</p> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-semibold mb-2" style="color: #374151;">Icon (Font Awesome)</label>
                    <input type="text" name="icon" class="w-full px-4 py-3 rounded-lg border transition-all focus:outline-none focus:ring-2" style="border-color: #D1D5DB; background-color: #FFFFFF; color: #1F2937;" value="{{ old('icon', $skill->icon) }}" placeholder="fa-graduation-cap">
                    @error('icon') <p class="text-xs mt-1" style="color: #DC2626;">{{ $message }}</p> @enderror
                </div>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
                <div>
                    <label class="block text-sm font-semibold mb-2" style="color: #374151;">Color</label>
                    <div class="flex items-center gap-3">
                        <input type="color" name="color" class="h-10 w-16 border rounded-lg cursor-pointer" style="border-color: #D1D5DB;" value="{{ old('color', $skill->color) }}">
                        <span class="text-sm" style="color: #6B7280;">Theme color for this skill</span>
                    </div>
                    @error('color') <p class="text-xs mt-1" style="color: #DC2626;">{{ $message }}</p> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-semibold mb-2" style="color: #374151;">Display Order</label>
                    <input type="number" name="order" class="w-full px-4 py-3 rounded-lg border transition-all focus:outline-none focus:ring-2" style="border-color: #D1D5DB; background-color: #FFFFFF; color: #1F2937;" value="{{ old('order', $skill->order) }}">
                    @error('order') <p class="text-xs mt-1" style="color: #DC2626;">{{ $message }}</p> @enderror
                </div>
            </div>
            
            <div class="mb-6">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" class="w-4 h-4 rounded" style="accent-color: #F57C00;" {{ $skill->is_active ? 'checked' : '' }}>
                    <span class="text-sm font-semibold" style="color: #374151;">Active (visible to users)</span>
                </label>
            </div>
            
            <div class="flex flex-wrap gap-3">
                <button type="submit" class="font-semibold px-6 py-2.5 rounded-lg transition hover:shadow-md active:scale-98" style="background-color: #F57C00; color: #FFFFFF;">Update Skill</button>
                <a href="{{ route('admin.skills.index') }}" class="font-semibold px-6 py-2.5 rounded-lg transition hover:bg-gray-300 active:scale-98" style="background-color: #E5E7EB; color: #374151;">Cancel</a>
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