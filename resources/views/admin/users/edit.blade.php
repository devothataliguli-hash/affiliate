@extends('layouts.admin')

@section('title', 'Edit User - ' . $user->name)

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-4">
    <div class="mb-5 md:mb-6">
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 text-sm font-medium transition-colors py-2 px-1 rounded-lg hover:bg-orange-50" style="color: #F57C00;">
            <i class="fas fa-arrow-left text-xs"></i> Back to Users
        </a>
    </div>

    <div class="rounded-xl shadow-md overflow-hidden" style="background-color: #FFFFFF;">
        <div class="px-5 md:px-6 py-4 border-b" style="background: linear-gradient(135deg, #FFF3E0, #FFE0B2); border-color: #E5E7EB;">
            <h1 class="text-lg md:text-xl font-bold" style="color: #1F2937;">Edit User: {{ $user->name }}</h1>
            <p class="text-sm mt-0.5" style="color: #6B7280;">Update user information and permissions</p>
        </div>

        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="p-5 md:p-6">
            @csrf
            @method('PUT')

            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2" style="color: #374151;">Full Name *</label>
                <input type="text" name="name" class="w-full px-4 py-3 rounded-lg border transition-all focus:outline-none focus:ring-2" style="border-color: #D1D5DB; background-color: #FFFFFF; color: #1F2937;" value="{{ old('name', $user->name) }}" required>
                @error('name') <p class="text-xs mt-1" style="color: #DC2626;">{{ $message }}</p> @enderror
            </div>

            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2" style="color: #374151;">Email Address</label>
                <input type="email" name="email" class="w-full px-4 py-3 rounded-lg border transition-all focus:outline-none focus:ring-2" style="border-color: #D1D5DB; background-color: #FFFFFF; color: #1F2937;" value="{{ old('email', $user->email) }}">
                @error('email') <p class="text-xs mt-1" style="color: #DC2626;">{{ $message }}</p> @enderror
            </div>

            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2" style="color: #374151;">Phone Number</label>
                <input type="tel" name="phone" class="w-full px-4 py-3 rounded-lg border transition-all focus:outline-none focus:ring-2" style="border-color: #D1D5DB; background-color: #FFFFFF; color: #1F2937;" value="{{ old('phone', $user->phone) }}" pattern="[0-9]{10,15}">
                @error('phone') <p class="text-xs mt-1" style="color: #DC2626;">{{ $message }}</p> @enderror
            </div>

            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2" style="color: #374151;">WhatsApp Number</label>
                <input type="tel" name="whatsapp" class="w-full px-4 py-3 rounded-lg border transition-all focus:outline-none focus:ring-2" style="border-color: #D1D5DB; background-color: #FFFFFF; color: #1F2937;" value="{{ old('whatsapp', $user->whatsapp) }}">
                @error('whatsapp') <p class="text-xs mt-1" style="color: #DC2626;">{{ $message }}</p> @enderror
            </div>

            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2" style="color: #374151;">Location</label>
                <input type="text" name="location" class="w-full px-4 py-3 rounded-lg border transition-all focus:outline-none focus:ring-2" style="border-color: #D1D5DB; background-color: #FFFFFF; color: #1F2937;" value="{{ old('location', $user->location) }}" placeholder="e.g., Dar es Salaam, Tanzania">
                @error('location') <p class="text-xs mt-1" style="color: #DC2626;">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_admin" value="1" class="w-4 h-4 rounded" style="accent-color: #F57C00;" {{ $user->is_admin ? 'checked' : '' }} {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                    <span class="text-sm font-semibold" style="color: #374151;">Administrator Privileges</span>
                </label>
                @if($user->id === auth()->id())
                    <p class="text-xs mt-1" style="color: #F59E0B;">You cannot change your own admin status.</p>
                @endif
            </div>

            <div class="flex flex-wrap gap-3">
                <button type="submit" class="font-semibold px-6 py-2.5 rounded-lg transition hover:shadow-md active:scale-98" style="background-color: #F57C00; color: #FFFFFF;">Update User</button>
                <a href="{{ route('admin.users.index') }}" class="font-semibold px-6 py-2.5 rounded-lg transition hover:bg-gray-300 active:scale-98" style="background-color: #E5E7EB; color: #374151;">Cancel</a>
            </div>
        </form>
    </div>
</div>

<style>
    input:focus {
        outline: none;
        border-color: #F57C00;
        box-shadow: 0 0 0 3px rgba(245, 124, 0, 0.1);
    }
    
    button:active, a:active {
        transform: scale(0.98);
    }
    
    @media (max-width: 640px) {
        input, button {
            font-size: 16px;
        }
    }
</style>
@endsection