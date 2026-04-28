@extends('layouts.admin')

@section('title', 'Content - ' . $category->name)

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-4">
    {{-- Breadcrumb Navigation --}}
    <div class="flex flex-wrap items-center gap-2 text-xs md:text-sm mb-4" style="color: #6B7280;">
        <a href="{{ route('admin.skills.index') }}" class="hover:underline" style="color: #F57C00;">Skills</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <a href="{{ route('admin.skills.categories.index', $category->skill) }}" class="hover:underline" style="color: #F57C00;">{{ $category->skill->name }}</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span style="color: #4B5563;">{{ $category->name }}</span>
        <i class="fas fa-chevron-right text-xs"></i>
        <span style="color: #4B5563;">Content</span>
    </div>
    
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6 md:mb-8">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold" style="color: #1F2937;">Content: {{ $category->name }}</h1>
            <p class="text-base mt-1" style="color: #4B5563;">Manage lessons and learning materials</p>
        </div>
        <a href="{{ route('admin.categories.contents.create', $category) }}" class="inline-flex items-center justify-center gap-2 font-semibold px-5 py-2.5 rounded-lg transition hover:shadow-md active:scale-98" style="background-color: #F57C00; color: #FFFFFF;">
            <i class="fas fa-plus text-sm"></i> Add Content
        </a>
    </div>
    
    <div class="rounded-xl shadow-md overflow-hidden" style="background-color: #FFFFFF;">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[700px]">
                <thead style="background-color: #F9FAFB; border-bottom: 1px solid #E5E7EB;">
                    <tr>
                        <th class="px-4 md:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color: #6B7280;">#</th>
                        <th class="px-4 md:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color: #6B7280;">Title</th>
                        <th class="px-4 md:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color: #6B7280;">Type</th>
                        <th class="px-4 md:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color: #6B7280;">Preview</th>
                        <th class="px-4 md:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color: #6B7280;">Duration</th>
                        <th class="px-4 md:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color: #6B7280;">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y" style="border-color: #F3F4F6;">
                    @forelse($contents as $content)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 md:px-6 py-4 text-sm" style="color: #6B7280;">{{ $loop->iteration }}</td>
                        <td class="px-4 md:px-6 py-4">
                            <p class="font-semibold text-sm md:text-base" style="color: #1F2937;">{{ $content->title }}</p>
                        </td>
                        <td class="px-4 md:px-6 py-4">
                            @if($content->type == 'video')
                                <span class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-1 rounded-full" style="background-color: #FEF2F2; color: #DC2626;">
                                    <i class="fas fa-video text-xs"></i> Video
                                </span>
                            @elseif($content->type == 'audio')
                                <span class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-1 rounded-full" style="background-color: #F3E8FF; color: #9333EA;">
                                    <i class="fas fa-headphones text-xs"></i> Audio
                                </span>
                            @elseif($content->type == 'pdf')
                                <span class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-1 rounded-full" style="background-color: #FFF7ED; color: #EA580C;">
                                    <i class="fas fa-file-pdf text-xs"></i> PDF
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-1 rounded-full" style="background-color: #EFF6FF; color: #2563EB;">
                                    <i class="fas fa-file-alt text-xs"></i> Text
                                </span>
                            @endif
                        </td>
                        <td class="px-4 md:px-6 py-4">
                            @if($content->is_free_preview)
                                <span class="text-xs font-semibold px-2 py-1 rounded-full" style="background-color: #D1FAE5; color: #065F46;">Free Preview</span>
                            @else
                                <span class="text-xs font-semibold px-2 py-1 rounded-full" style="background-color: #F3F4F6; color: #6B7280;">Locked</span>
                            @endif
                        </td>
                        <td class="px-4 md:px-6 py-4 text-sm" style="color: #6B7280;">{{ $content->duration ? $content->duration . ' min' : '-' }}</td>
                        <td class="px-4 md:px-6 py-4">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.categories.contents.edit', [$category, $content]) }}" class="transition hover:scale-110" style="color: #F57C00;" title="Edit">
                                    <i class="fas fa-edit text-base"></i>
                                </a>
                                <form action="{{ route('admin.categories.contents.destroy', [$category, $content]) }}" method="POST" class="inline" onsubmit="return confirm('Delete this content?')">
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
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 mb-3 rounded-full flex items-center justify-center" style="background-color: #F3F4F6;">
                                    <i class="fas fa-file-alt text-2xl" style="color: #9CA3AF;"></i>
                                </div>
                                <p class="text-base" style="color: #6B7280;">No content yet. Click "Add Content" to upload lessons.</p>
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