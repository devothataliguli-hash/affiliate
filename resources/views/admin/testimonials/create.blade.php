@extends('layouts.admin')

@section('title', 'Add Testimonial - ELLYPESA')
@section('page-title', 'Add Testimonial / Screenshot')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">New Testimonial</h2>
            <p class="text-sm text-gray-500 mt-1">Add user feedback, profile image, and payment screenshot.</p>
        </div>
        
        <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @include('admin.testimonials._form')
            
            <div class="mt-6 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.testimonials.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Cancel
                </a>
                <button type="submit" class="bg-primary hover:bg-primary-dark text-white px-6 py-2 rounded-lg transition">
                    <i class="fas fa-save mr-2"></i> Save Testimonial
                </button>
            </div>
        </form>
    </div>
</div>
@endsection