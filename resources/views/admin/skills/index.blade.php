@extends('layouts.admin')

@section('title', 'Manage Skills')

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-4">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6 md:mb-8">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold" style="color: #1F2937;">Skills Management</h1>
            <p class="text-base mt-1" style="color: #4B5563;">Create and manage learning skills</p>
        </div>
        <a href="{{ route('admin.skills.create') }}" class="inline-flex items-center justify-center gap-2 font-semibold px-5 py-2.5 rounded-lg transition hover:shadow-md active:scale-98" style="background-color: #F57C00; color: #FFFFFF;">
            <i class="fas fa-plus text-sm"></i> Add New Skill
        </a>
    </div>
    
    <div class="rounded-xl shadow-md overflow-hidden" style="background-color: #FFFFFF;">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[700px]">
                <thead style="background-color: #F9FAFB; border-bottom: 1px solid #E5E7EB;">
                    <tr>
                        <th class="px-4 md:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color: #6B7280;">#</th>
                        <th class="px-4 md:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color: #6B7280;">Skill</th>
                        <th class="px-4 md:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color: #6B7280;">Price</th>
                        <th class="px-4 md:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color: #6B7280;">Categories</th>
                        <th class="px-4 md:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color: #6B7280;">Status</th>
                        <th class="px-4 md:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color: #6B7280;">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y" style="border-color: #F3F4F6;">
                    @forelse($skills as $skill)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 md:px-6 py-4 text-sm" style="color: #6B7280;">{{ $loop->iteration }}</td>
                        <td class="px-4 md:px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0" style="background: {{ $skill->color }}20;">
                                    <i class="fas {{ $skill->icon ?? 'fa-graduation-cap' }}" style="color: {{ $skill->color }};"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-sm md:text-base" style="color: #1F2937;">{{ $skill->name }}</p>
                                    <p class="text-xs" style="color: #6B7280;">{{ Str::limit($skill->description, 50) }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 md:px-6 py-4">
                            @if($skill->price > 0)
                                <span class="font-semibold text-sm" style="color: #F57C00;">Tsh {{ number_format($skill->price) }}</span>
                            @else
                                <span class="text-sm font-semibold" style="color: #10B981;">Free</span>
                            @endif
                        </td>
                        <td class="px-4 md:px-6 py-4">
                            <span class="text-xs font-semibold px-2 py-1 rounded-full" style="background-color: #EFF6FF; color: #2563EB;">{{ $skill->categories_count }} Categories</span>
                        </td>
                        <td class="px-4 md:px-6 py-4">
                            @if($skill->is_active)
                                <span class="text-xs font-semibold px-2 py-1 rounded-full" style="background-color: #D1FAE5; color: #065F46;">Active</span>
                            @else
                                <span class="text-xs font-semibold px-2 py-1 rounded-full" style="background-color: #F3F4F6; color: #6B7280;">Inactive</span>
                            @endif
                        </td>
                        <td class="px-4 md:px-6 py-4">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.skills.categories.index', $skill) }}" class="transition hover:scale-110" style="color: #3B82F6;" title="Manage Categories">
                                    <i class="fas fa-folder-open text-base"></i>
                                </a>
                                <a href="{{ route('admin.skills.edit', $skill) }}" class="transition hover:scale-110" style="color: #F57C00;" title="Edit">
                                    <i class="fas fa-edit text-base"></i>
                                </a>
                                <form action="{{ route('admin.skills.destroy', $skill) }}" method="POST" class="inline" onsubmit="return confirm('Delete this skill? All categories and content will be deleted.')">
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
                                    <i class="fas fa-book text-2xl" style="color: #9CA3AF;"></i>
                                </div>
                                <p class="text-base" style="color: #6B7280;">No skills found. Click "Add New Skill" to get started.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    @if($skills->hasPages())
    <div class="mt-6">
        {{ $skills->links() }}
    </div>
    @endif
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