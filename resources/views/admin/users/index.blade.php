@extends('layouts.admin')

@section('title', 'Manage Users')

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-4">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6 md:mb-8">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold" style="color: #1F2937;">Registered Users</h1>
            <p class="text-base mt-1" style="color: #4B5563;">Manage and monitor all platform users</p>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="rounded-xl shadow-sm p-4 border-l-4" style="background-color: #FFFFFF; border-left-color: #3B82F6;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium" style="color: #6B7280;">Total Users</p>
                    <p class="text-2xl font-bold mt-1" style="color: #1F2937;">{{ $totalUsers }}</p>
                </div>
                <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background-color: #EFF6FF;">
                    <i class="fas fa-users text-xl" style="color: #3B82F6;"></i>
                </div>
            </div>
        </div>

        <div class="rounded-xl shadow-sm p-4 border-l-4" style="background-color: #FFFFFF; border-left-color: #10B981;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium" style="color: #6B7280;">New This Week</p>
                    <p class="text-2xl font-bold mt-1" style="color: #1F2937;">{{ $newThisWeek }}</p>
                </div>
                <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background-color: #D1FAE5;">
                    <i class="fas fa-calendar-week text-xl" style="color: #10B981;"></i>
                </div>
            </div>
        </div>

        <div class="rounded-xl shadow-sm p-4 border-l-4" style="background-color: #FFFFFF; border-left-color: #F59E0B;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium" style="color: #6B7280;">Administrators</p>
                    <p class="text-2xl font-bold mt-1" style="color: #1F2937;">{{ $totalAdmins }}</p>
                </div>
                <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background-color: #FEF3C7;">
                    <i class="fas fa-user-shield text-xl" style="color: #F59E0B;"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Search and Filter Bar --}}
    <div class="rounded-xl shadow-sm mb-6 p-4" style="background-color: #FFFFFF;">
        <form method="GET" class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-[180px]">
                <label class="block text-xs font-semibold mb-1" style="color: #6B7280;">Search</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Name, email or phone..." class="w-full px-3 py-2 rounded-lg border focus:outline-none focus:ring-2" style="border-color: #D1D5DB;">
            </div>
            <div>
                <label class="block text-xs font-semibold mb-1" style="color: #6B7280;">User Type</label>
                <select name="type" class="px-3 py-2 rounded-lg border focus:outline-none focus:ring-2" style="border-color: #D1D5DB;">
                    <option value="">All Users</option>
                    <option value="user" {{ request('type') == 'user' ? 'selected' : '' }}>Regular Users</option>
                    <option value="admin" {{ request('type') == 'admin' ? 'selected' : '' }}>Administrators</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold mb-1" style="color: #6B7280;">Sort By</label>
                <select name="sort" class="px-3 py-2 rounded-lg border focus:outline-none focus:ring-2" style="border-color: #D1D5DB;">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest First</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
                    <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name (Z-A)</option>
                </select>
            </div>
            <div>
                <button type="submit" class="px-4 py-2 rounded-lg font-semibold transition hover:shadow-md" style="background-color: #F57C00; color: #FFFFFF;">
                    <i class="fas fa-search mr-1"></i> Filter
                </button>
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2 rounded-lg font-semibold transition inline-block" style="background-color: #E5E7EB; color: #374151;">
                    <i class="fas fa-undo-alt mr-1"></i> Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Users Table --}}
    <div class="rounded-xl shadow-md overflow-hidden" style="background-color: #FFFFFF;">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[700px]">
                <thead style="background-color: #F9FAFB; border-bottom: 1px solid #E5E7EB;">
                    <tr>
                        <th class="px-4 md:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color: #6B7280;">User</th>
                        <th class="px-4 md:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color: #6B7280;">Contact</th>
                        <th class="px-4 md:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color: #6B7280;">Role</th>
                        <th class="px-4 md:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color: #6B7280;">Joined</th>
                        <th class="px-4 md:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color: #6B7280;">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y" style="border-color: #F3F4F6;">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 md:px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0" style="background-color: #FFF3E0;">
                                    <i class="fas fa-user text-sm" style="color: #F57C00;"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-sm md:text-base" style="color: #1F2937;">{{ $user->name }}</p>
                                    @if($user->email)
                                        <p class="text-xs" style="color: #6B7280;">{{ $user->email }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-4 md:px-6 py-4 text-sm" style="color: #4B5563;">
                            @if($user->phone)
                                <div><i class="fas fa-phone-alt text-xs mr-1" style="color: #6B7280;"></i> {{ $user->phone }}</div>
                            @else
                                <span class="text-gray-400">No phone</span>
                            @endif
                            @if($user->location)
                                <div class="text-xs mt-0.5" style="color: #6B7280;"><i class="fas fa-map-marker-alt text-xs mr-1"></i> {{ $user->location }}</div>
                            @endif
                        </td>
                        <td class="px-4 md:px-6 py-4">
                            @if($user->is_admin)
                                <span class="text-xs font-semibold px-2 py-1 rounded-full" style="background-color: #FEF3C7; color: #92400E;">Administrator</span>
                            @else
                                <span class="text-xs font-semibold px-2 py-1 rounded-full" style="background-color: #D1FAE5; color: #065F46;">User</span>
                            @endif
                        </td>
                        <td class="px-4 md:px-6 py-4 text-sm" style="color: #6B7280;">
                            {{ $user->created_at->format('d M Y') }}
                            <div class="text-xs">{{ $user->created_at->diffForHumans() }}</div>
                        </td>
                        <td class="px-4 md:px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.users.show', $user) }}" class="transition hover:scale-110" style="color: #3B82F6;" title="View Details">
                                    <i class="fas fa-eye text-base"></i>
                                </a>
                                <a href="{{ route('admin.users.edit', $user) }}" class="transition hover:scale-110" style="color: #F57C00;" title="Edit">
                                    <i class="fas fa-edit text-base"></i>
                                </a>
                                @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Delete this user? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="transition hover:scale-110" style="color: #DC2626;" title="Delete">
                                        <i class="fas fa-trash text-base"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 mb-3 rounded-full flex items-center justify-center" style="background-color: #F3F4F6;">
                                    <i class="fas fa-users text-2xl" style="color: #9CA3AF;"></i>
                                </div>
                                <p class="text-base" style="color: #6B7280;">No users found.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $users->links() }}
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
    
    .pagination {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 0.5rem;
    }
    
    .pagination .page-item .page-link {
        padding: 0.5rem 0.75rem;
        border-radius: 0.5rem;
        transition: all 0.2s;
        color: #4B5563;
        background-color: #FFFFFF;
        border: 1px solid #E5E7EB;
    }
    
    .pagination .page-item.active .page-link {
        background-color: #F57C00;
        border-color: #F57C00;
        color: #FFFFFF;
    }
</style>
@endsection