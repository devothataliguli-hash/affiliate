@extends('layouts.admin')

@section('title', 'Manage Skills - ELLYPESA')
@section('page-title', 'Skills Management')

@section('content')
<div class="mb-4 flex justify-end">
    <a href="{{ route('admin.skills.create') }}" class="bg-primary hover:bg-primary-dark text-white px-4 py-2 rounded-lg">
        <i class="fas fa-plus mr-2"></i> Add New Skill
    </a>
</div>

<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($skills as $skill)
            <tr>
                <td class="px-6 py-4">{{ $skill->name }}</td>
                <td class="px-6 py-4">Tsh {{ number_format($skill->price) }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 text-xs rounded-full {{ $skill->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $skill->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <a href="{{ route('admin.skills.edit', $skill) }}" class="text-blue-600 hover:text-blue-800 mr-3">Edit</a>
                    <form action="{{ route('admin.skills.destroy', $skill) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="px-6 py-4">
        {{ $skills->links() }}
    </div>
</div>
@endsection