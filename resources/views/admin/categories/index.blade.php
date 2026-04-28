@extends('layouts.admin')

@section('title', 'Categories - ' . $skill->name)

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-4">
    {{-- Breadcrumb Navigation --}}
    <div class="flex flex-wrap items-center gap-2 text-xs md:text-sm mb-4" style="color: #6B7280;">
        <a href="{{ route('admin.skills.index') }}" class="hover:underline" style="color: #F57C00;">Skills</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span style="color: #4B5563;">{{ $skill->name }}</span>
        <i class="fas fa-chevron-right text-xs"></i>
        <span style="color: #4B5563;">Categories</span>
    </div>
    
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6 md:mb-8">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold" style="color: #1F2937;">Categories: {{ $skill->name }}</h1>
            <p class="text-base mt-1" style="color: #4B5563;">Manage categories and organize your content</p>
        </div>
        <a href="{{ route('admin.skills.categories.create', $skill) }}" class="inline-flex items-center justify-center gap-2 font-semibold px-5 py-2.5 rounded-lg transition hover:shadow-md active:scale-98" style="background-color: #F57C00; color: #FFFFFF;">
            <i class="fas fa-plus text-sm"></i> Add Category
        </a>
    </div>
    
    <div class="rounded-xl shadow-md overflow-hidden" style="background-color: #FFFFFF;">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[650px]">
                <thead style="background-color: #fdaf05; border-bottom: 1px solid #E5E7EB;">
                    <tr>
                        <th class="px-4 md:px-6 py-3 text-left text-xs font-bold uppercase tracking-wider" style="color: #6B7280;">#</th>
                        <th class="px-4 md:px-6 py-3 text-left text-xs font-bold uppercase tracking-wider" style="color: #6B7280;">Category Name</th>
                        <th class="px-4 md:px-6 py-3 text-left text-xs font-bold uppercase tracking-wider" style="color: #6B7280;">Contents</th>
                        <th class="px-4 md:px-6 py-3 text-left text-xs font-bold uppercase tracking-wider" style="color: #6B7280;">Order</th>
                        <th class="px-4 md:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color: #6B7280;">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y" style="border-color: #F3F4F6;">
                    @forelse($categories as $category)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 md:px-6 py-4 text-sm" style="color: #6B7280;">{{ $loop->iteration }}</td>
                        <td class="px-4 md:px-6 py-4">
                            <div>
                                <p class="font-semibold text-sm md:text-base" style="color: #1F2937;">{{ $category->name }}</p>
                                @if($category->description)
                                    <p class="text-xs mt-0.5" style="color: #6B7280;">{{ Str::limit($category->description, 60) }}</p>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 md:px-6 py-4">
                            <span class="text-xs font-semibold px-2 py-1 rounded-full" style="background-color: #EFF6FF; color: #2563EB;">{{ $category->contents_count }} Contents</span>
                        </td>
                        <td class="px-4 md:px-6 py-4 text-sm" style="color: #6B7280;">{{ $category->order }}</td>
                        <td class="px-4 md:px-6 py-4">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.categories.contents.index', $category) }}" class="transition hover:scale-110" style="color: #3B82F6;" title="Manage Content">
                                    <i class="fas fa-file-alt text-base"></i>
                                </a>
                                <a href="{{ route('admin.skills.categories.edit', [$skill, $category]) }}" class="transition hover:scale-110" style="color: #F57C00;" title="Edit">
                                    <i class="fas fa-edit text-base"></i>
                                </a>
                                <form action="{{ route('admin.skills.categories.destroy', [$skill, $category]) }}" method="POST" class="inline" onsubmit="return confirm('Delete this category? All content will be deleted.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="transition hover:scale-110" style="color: #DC2626;" title="Delete">
                                        <i class="fas fa-trash text-base"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 mb-3 rounded-full flex items-center justify-center" style="background-color: #F3F4F6;">
                                    <i class="fas fa-folder-open text-2xl" style="color: #9CA3AF;"></i>
                                </div>
                                <p class="text-base" style="color: #6B7280;">No categories yet. Click "Add Category" to get started.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    button:active, a:active {
        transform: scale(0.98);
    }
    
    @media (max-width: 640px) {
        .px-4 {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }
        .text-sm {
            font-size: 0.75rem;
        }
    }
</style>
@endsection