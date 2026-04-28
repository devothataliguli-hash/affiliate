@extends('layouts.admin')

@section('title', 'Manage Testimonials')

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-4">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6 md:mb-8">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold" style="color: #1F2937;">Testimonials</h1>
            <p class="text-base mt-1" style="color: #4B5563;">Manage student success stories</p>
        </div>
        <a href="{{ route('admin.testimonials.create') }}" class="inline-flex items-center justify-center gap-2 font-semibold px-5 py-2.5 rounded-lg transition hover:shadow-md active:scale-98" style="background-color: #F57C00; color: #FFFFFF;">
            <i class="fas fa-plus text-sm"></i> Add Testimonial
        </a>
    </div>
    
    <div class="grid x1:grid-cols-2 lg:grid-cols-3 gap-5 md:gap-6">
        @forelse($testimonials as $testimonial)
        <div class="rounded-xl shadow-md overflow-hidden transition-all hover:shadow-lg" style="background-color: #FFFFFF;">
            <div class="p-5">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center overflow-hidden flex-shrink-0" style="background-color: #FFF3E0;">
                            @if($testimonial->image)
                                <img src="{{ asset('storage/' . $testimonial->image) }}" class="w-full h-full object-cover">
                            @else
                                <i class="fas fa-user text-xl" style="color: #F57C00;"></i>
                            @endif
                        </div>
                        <div>
                            <h3 class="font-bold text-base md:text-lg" style="color: #1F2937;">{{ $testimonial->name }}</h3>
                            <p class="text-xs" style="color: #6B7280;">{{ $testimonial->location ?? 'Student' }}</p>
                        </div>
                    </div>
                    @if($testimonial->is_active)
                        <span class="text-xs font-semibold px-2 py-1 rounded-full" style="background-color: #D1FAE5; color: #065F46;">Active</span>
                    @else
                        <span class="text-xs font-semibold px-2 py-1 rounded-full" style="background-color: #F3F4F6; color: #6B7280;">Inactive</span>
                    @endif
                </div>
                
                <p class="text-sm italic leading-relaxed mb-3" style="color: #4B5563;">"{{ Str::limit($testimonial->content, 100) }}"</p>
                
                <div class="flex items-center justify-between flex-wrap gap-2">
                    <div class="text-xs md:text-sm" style="color: #FBBF24;">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $testimonial->rating) <i class="fas fa-star"></i> @else <i class="far fa-star"></i> @endif
                        @endfor
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="transition hover:scale-110" style="color: #F57C00;">
                            <i class="fas fa-edit text-base"></i>
                        </a>
                        <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST" class="inline" onsubmit="return confirm('Delete this testimonial?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="transition hover:scale-110" style="color: #DC2626;">
                                <i class="fas fa-trash text-base"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full rounded-xl shadow-md p-8 text-center" style="background-color: #FFFFFF;">
            <div class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center" style="background-color: #F3F4F6;">
                <i class="fas fa-star text-2xl" style="color: #9CA3AF;"></i>
            </div>
            <p class="text-base" style="color: #6B7280;">No testimonials yet. Click "Add Testimonial" to get started.</p>
        </div>
        @endforelse
    </div>
    
    @if($testimonials->hasPages())
    <div class="mt-6">
        {{ $testimonials->links() }}
    </div>
    @endif
</div>

<style>
    button:active, a:active {
        transform: scale(0.98);
    }
    
    @media (max-width: 640px) {
        .rounded-xl {
            border-radius: 0.75rem;
        }
    }
</style>
@endsection