@extends('layouts.admin')

@section('title', 'Edit Testimonial - ELLYPESA')
@section('page-title', 'Edit Testimonial')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Edit: {{ $testimonial->name }}</h2>
            <p class="text-sm text-gray-500 mt-1">Update testimonial details or replace images.</p>
        </div>
        
        <form action="{{ route('admin.testimonials.update', $testimonial) }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')
            @include('admin.testimonials._form')
            
            <div class="mt-6 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.testimonials.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Cancel
                </a>
                <button type="submit" class="bg-primary hover:bg-primary-dark text-white px-6 py-2 rounded-lg transition">
                    <i class="fas fa-save mr-2"></i> Update Testimonial
                </button>
            </div>
        </form>
    </div>
</div>
@endsection