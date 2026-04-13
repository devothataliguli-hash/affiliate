@extends('layouts.admin')

@section('title', 'Testimonials & Screenshots - ELLYPESA')
@section('page-title', 'Testimonials Management')

@section('content')
<div class="mb-4 flex justify-between items-center">
    <p class="text-sm text-gray-600">Manage testimonials and payment screenshots displayed on the landing page.</p>
    <a href="{{ route('admin.testimonials.create') }}" class="bg-primary hover:bg-primary-dark text-white px-4 py-2 rounded-lg transition">
        <i class="fas fa-plus mr-2"></i> Add New Testimonial
    </a>
</div>

<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Location</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rating</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Screenshot</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($testimonials as $testimonial)
            <tr>
                <td class="px-6 py-4">
                    <div class="flex items-center">
                        @if($testimonial->image)
                            <img src="{{ asset('storage/' . $testimonial->image) }}" class="w-8 h-8 rounded-full mr-2 object-cover">
                        @else
                            <div class="w-8 h-8 bg-gray-200 rounded-full mr-2 flex items-center justify-center">
                                <i class="fas fa-user text-gray-400 text-xs"></i>
                            </div>
                        @endif
                        <span class="font-medium">{{ $testimonial->name }}</span>
                    </div>
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ $testimonial->location ?? '—' }}</td>
                <td class="px-6 py-4">
                    <div class="flex text-yellow-400">
                        @for($i=1; $i<=5; $i++)
                            <i class="fas fa-star {{ $i <= $testimonial->rating ? '' : 'text-gray-300' }} text-xs"></i>
                        @endfor
                    </div>
                </td>
                <td class="px-6 py-4">
                    @if($testimonial->screenshot)
                        <a href="{{ asset('storage/' . $testimonial->screenshot) }}" target="_blank" class="text-primary hover:underline text-sm">
                            <i class="fas fa-image mr-1"></i> View
                        </a>
                    @else
                        <span class="text-gray-400 text-sm">—</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 text-xs rounded-full {{ $testimonial->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $testimonial->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="text-blue-600 hover:text-blue-800 mr-3 text-sm">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST" class="inline" onsubmit="return confirm('Delete this testimonial?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                    <i class="fas fa-star text-3xl mb-2 opacity-50"></i>
                    <p>No testimonials found. Click "Add New Testimonial" to create one.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-6 py-4 border-t">
        {{ $testimonials->links() }}
    </div>
</div>
@endsection