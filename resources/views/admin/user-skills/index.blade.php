@extends('layouts.admin')

@section('title', 'Approve Skill Access')
@section('page-title', 'Approve User Skill Access')

@section('content')
<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Skill</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Requested</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($userSkills as $us)
            <tr>
                <td class="px-6 py-4">
                    <p class="font-medium">{{ $us->user_name }}</p>
                    <p class="text-sm text-gray-500">{{ $us->email ?? $us->phone }}</p>
                </td>
                <td class="px-6 py-4">{{ $us->skill_name }}</td>
                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($us->created_at)->diffForHumans() }}</td>
                <td class="px-6 py-4">
                    @if($us->is_approved)
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">Approved</span>
                    @else
                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs">Pending</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    @if(!$us->is_approved)
                        <form action="{{ route('admin.user-skills.approve', $us->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-green-600 hover:text-green-800 mr-2">Approve</button>
                        </form>
                        <form action="{{ route('admin.user-skills.reject', $us->id) }}" method="POST" class="inline" onsubmit="return confirm('Reject this request?')">
                            @csrf
                            <button type="submit" class="text-red-600 hover:text-red-800">Reject</button>
                        </form>
                    @else
                        <span class="text-gray-400">Approved {{ \Carbon\Carbon::parse($us->approved_at)->diffForHumans() }}</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="px-6 py-4">
        {{ $userSkills->links() }}
    </div>
</div>
@endsection