@extends('layouts.admin')

@section('title', 'Testimonials & Screenshots - ELLYPESA')
@section('page-title', 'Testimonials Management')

@section('content')
<div x-data="testimonialManager()" x-init="init()" class="space-y-4">

    {{-- Toast Notification --}}
    <div x-show="toast.show" x-transition.duration.300ms
         class="fixed top-5 left-1/2 transform -translate-x-1/2 z-50 bg-gray-800 text-white px-5 py-2.5 rounded-lg shadow-lg flex items-center gap-2 text-sm"
         style="display: none;">
        <i :class="toast.type === 'success' ? 'fas fa-check-circle text-green-400' : 'fas fa-exclamation-triangle text-red-400'"></i>
        <span x-text="toast.message"></span>
        <button @click="toast.show = false" class="ml-2 text-gray-300 hover:text-white">&times;</button>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
        <div class="bg-white rounded-xl shadow border p-3">
            <p class="text-[10px] font-semibold text-gray-500 uppercase">Jumla</p>
            <p class="text-2xl font-bold text-gray-800">{{ $testimonials->total() }}</p>
        </div>
        <div class="bg-white rounded-xl shadow border p-3">
            <p class="text-[10px] font-semibold text-gray-500 uppercase">Inaonekana</p>
            <p class="text-2xl font-bold text-green-600">{{ $testimonials->where('is_active', true)->count() }}</p>
        </div>
        <div class="bg-white rounded-xl shadow border p-3">
            <p class="text-[10px] font-semibold text-gray-500 uppercase">Wastani</p>
            <p class="text-2xl font-bold text-primary">{{ number_format($testimonials->avg('rating') ?? 0, 1) }}</p>
        </div>
    </div>

    <div class="flex justify-end">
        <a href="{{ route('admin.testimonials.create') }}" class="bg-primary text-white px-3 py-2 rounded-lg text-xs flex items-center gap-1">
            <i class="fas fa-plus text-xs"></i> Ongeza Testimonial
        </a>
    </div>

    {{-- MOBILE VIEW --}}
    <div class="space-y-3 sm:hidden">
        @forelse($testimonials as $testimonial)
        <div class="bg-white p-3 rounded-xl shadow border">
            <div class="flex items-center gap-2 mb-2">
                @if($testimonial->image)
                    <img src="{{ asset('storage/' . $testimonial->image) }}" class="w-8 h-8 rounded-full object-cover">
                @else
                    <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-xs text-gray-500"></i>
                    </div>
                @endif
                <div>
                    <p class="text-sm font-semibold text-gray-800">{{ $testimonial->name }}</p>
                    <p class="text-[11px] text-gray-500">{{ $testimonial->location ?? '—' }}</p>
                </div>
            </div>
            <p class="text-xs text-gray-600 mb-2">{{ Str::limit($testimonial->content, 80) }}</p>
            <div class="flex justify-between items-center text-xs">
                <div class="flex text-yellow-400 gap-0.5">
                    @for($i=1; $i<=5; $i++)
                        <i class="fas fa-star {{ $i <= $testimonial->rating ? '' : 'text-gray-300' }}"></i>
                    @endfor
                </div>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold {{ $testimonial->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                    {{ $testimonial->is_active ? 'Inaonekana' : 'Haionekani' }}
                </span>
            </div>
            <div class="flex justify-end gap-3 mt-2 text-sm">
                <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="text-blue-600"><i class="fas fa-edit"></i></a>
                <button @click="confirmDelete({{ $testimonial->id }})" class="text-red-600"><i class="fas fa-trash"></i></button>
            </div>
        </div>
        @empty
        <div class="text-center text-gray-500 text-sm py-6">Hakuna testimonials bado.</div>
        @endforelse
    </div>

    {{-- DESKTOP TABLE --}}
    <div class="hidden sm:block bg-white rounded-xl shadow border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-2 text-xs">Mteja</th>
                        <th class="px-3 py-2 text-xs">Mahali</th>
                        <th class="px-3 py-2 text-xs">Maoni</th>
                        <th class="px-3 py-2 text-xs">Nyota</th>
                        <th class="px-3 py-2 text-xs">Picha</th>
                        <th class="px-3 py-2 text-xs">Hali</th>
                        <th class="px-3 py-2 text-xs text-center">Vitendo</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse($testimonials as $testimonial)
                    <tr id="testimonial-row-{{ $testimonial->id }}">
                        <td class="px-3 py-2 whitespace-nowrap">
                            <div class="flex items-center">
                                @if($testimonial->image)
                                    <img src="{{ asset('storage/' . $testimonial->image) }}" class="w-8 h-8 rounded-full mr-2">
                                @else
                                    <div class="w-8 h-8 bg-gray-100 rounded-full mr-2 flex items-center justify-center">
                                        <i class="fas fa-user text-xs text-gray-500"></i>
                                    </div>
                                @endif
                                <span class="font-semibold text-gray-800 text-sm">{{ $testimonial->name }}</span>
                            </div>
                        </td>
                        <td class="px-3 py-2 text-xs text-gray-600">{{ $testimonial->location ?? '—' }}</td>
                        <td class="px-3 py-2 max-w-xs"><p class="text-xs text-gray-700">{{ Str::limit($testimonial->content, 80) }}</p></td>
                        <td class="px-3 py-2">
                            <div class="flex text-yellow-400 text-xs gap-0.5">
                                @for($i=1; $i<=5; $i++)
                                    <i class="fas fa-star {{ $i <= $testimonial->rating ? '' : 'text-gray-300' }}"></i>
                                @endfor
                            </div>
                        </td>
                        <td class="px-3 py-2">
                            @if($testimonial->screenshot)
                                <a href="{{ asset('storage/' . $testimonial->screenshot) }}" target="_blank" class="text-primary text-xs">Angalia</a>
                            @else
                                <span class="text-gray-400 text-xs">—</span>
                            @endif
                        </td>
                        <td class="px-3 py-2">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold {{ $testimonial->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $testimonial->is_active ? 'Inaonekana' : 'Haionekani' }}
                            </span>
                        </td>
                        <td class="px-3 py-2 text-center">
                            <div class="flex justify-center space-x-2">
                                <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="text-blue-600"><i class="fas fa-edit"></i></a>
                                <button @click="confirmDelete({{ $testimonial->id }})" class="text-red-600"><i class="fas fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-3 py-6 text-center text-gray-500 text-sm">Hakuna testimonials bado.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-3 py-2 border-t bg-gray-50">{{ $testimonials->links() }}</div>
    </div>

    {{-- DELETE MODAL --}}
    <div x-show="deleteModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center px-4">
        <div class="fixed inset-0 bg-black/50" @click="deleteModalOpen = false"></div>
        <div class="bg-white rounded-xl shadow-lg max-w-sm w-full p-4 relative z-10">
            <h3 class="text-sm font-bold mb-2">Thibitisha Kufuta</h3>
            <p class="text-xs text-gray-600 mb-4">Una uhakika unataka kufuta testimonial hii?</p>
            <div class="flex justify-end gap-2">
                <button @click="deleteModalOpen = false" class="px-3 py-1 border text-xs rounded hover:bg-gray-50">Ghairi</button>
                <button @click="deleteTestimonial()" class="bg-red-600 text-white px-3 py-1 text-xs rounded hover:bg-red-700">Futa</button>
            </div>
        </div>
    </div>

</div>

<script>
function testimonialManager() {
    return {
        deleteModalOpen: false,
        deleteId: null,
        toast: { show: false, message: '', type: 'success' },

        confirmDelete(id) {
            this.deleteId = id;
            this.deleteModalOpen = true;
        },

        deleteTestimonial() {
            const url = `/admin/testimonials/${this.deleteId}`;
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            if (!token) {
                this.showToast('CSRF token not found. Please refresh the page.', 'error');
                return;
            }

            fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.text().then(text => { throw new Error(`Server responded with ${response.status}: ${text}`); });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    this.showToast('Testimonial imefutwa kikamilifu!', 'success');
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    this.showToast(data.message || 'Hitilafu imetokea', 'error');
                }
                this.deleteModalOpen = false;
            })
            .catch(error => {
                console.error('Delete error:', error);
                this.showToast('Hitilafu: ' + error.message, 'error');
                this.deleteModalOpen = false;
            });
        },

        showToast(message, type = 'success') {
            this.toast.message = message;
            this.toast.type = type;
            this.toast.show = true;
            setTimeout(() => { this.toast.show = false; }, 3000);
        }
    }
}
</script>
@endsection