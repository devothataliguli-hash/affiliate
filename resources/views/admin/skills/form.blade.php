{{-- resources/views/admin/skills/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Add New Skill')
@section('page-title', 'Add New Skill')

@section('content')
<div class="max-w-3xl mx-auto">
    <form action="{{ route('admin.skills.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-md p-6">
        @csrf
        @include('admin.skills._form')
        <div class="mt-6">
            <button type="submit" class="bg-primary hover:bg-primary-dark text-white px-6 py-2 rounded-lg">Save Skill</button>
            <a href="{{ route('admin.skills.index') }}" class="ml-3 text-gray-600 hover:text-gray-800">Cancel</a>
        </div>
    </form>
</div>
@endsection