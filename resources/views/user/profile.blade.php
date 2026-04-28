@extends('layouts.user')

@section('title', 'My Profile')

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-4">
    <div class="mb-6 md:mb-8">
        <h1 class="text-2xl md:text-3xl font-bold" style="color: #1F2937;">My Profile</h1>
        <p class="text-base mt-1" style="color: #4B5563;">Update your personal information</p>
    </div>
    
    <div class="rounded-xl shadow-md p-5 md:p-7" style="background-color: #FFFFFF;">
        <form action="{{ route('user.profile.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-5">
                <label for="name" class="block text-sm font-semibold mb-2" style="color: #374151;">Full Name</label>
                <input type="text" 
                       name="name" 
                       id="name" 
                       class="w-full px-4 py-3 rounded-lg border transition-all focus:outline-none focus:ring-2"
                       style="border-color: #D1D5DB; background-color: #FFFFFF; color: #1F2937;"
                       value="{{ old('name', $user->name) }}"
                       required>
                @error('name')
                    <p class="text-xs mt-1" style="color: #DC2626;">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-5">
                <label for="email" class="block text-sm font-semibold mb-2" style="color: #374151;">Email Address</label>
                <input type="email" 
                       name="email" 
                       id="email" 
                       class="w-full px-4 py-3 rounded-lg border transition-all focus:outline-none focus:ring-2"
                       style="border-color: #D1D5DB; background-color: #FFFFFF; color: #1F2937;"
                       value="{{ old('email', $user->email) }}"
                       required>
                @error('email')
                    <p class="text-xs mt-1" style="color: #DC2626;">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-5">
                <label for="phone" class="block text-sm font-semibold mb-2" style="color: #374151;">Phone Number</label>
                <input type="tel" 
                       name="phone" 
                       id="phone" 
                       class="w-full px-4 py-3 rounded-lg border transition-all focus:outline-none focus:ring-2"
                       style="border-color: #D1D5DB; background-color: #FFFFFF; color: #1F2937;"
                       value="{{ old('phone', $user->phone) }}"
                       placeholder="e.g., 0765 289 993">
                @error('phone')
                    <p class="text-xs mt-1" style="color: #DC2626;">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-5">
                <label for="whatsapp" class="block text-sm font-semibold mb-2" style="color: #374151;">WhatsApp Number</label>
                <input type="tel" 
                       name="whatsapp" 
                       id="whatsapp" 
                       class="w-full px-4 py-3 rounded-lg border transition-all focus:outline-none focus:ring-2"
                       style="border-color: #D1D5DB; background-color: #FFFFFF; color: #1F2937;"
                       value="{{ old('whatsapp', $user->whatsapp) }}"
                       placeholder="e.g., 0765 289 993">
                <p class="text-xs mt-1" style="color: #6B7280;">For support and notifications</p>
                @error('whatsapp')
                    <p class="text-xs mt-1" style="color: #DC2626;">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label for="location" class="block text-sm font-semibold mb-2" style="color: #374151;">Location</label>
                <input type="text" 
                       name="location" 
                       id="location" 
                       class="w-full px-4 py-3 rounded-lg border transition-all focus:outline-none focus:ring-2"
                       style="border-color: #D1D5DB; background-color: #FFFFFF; color: #1F2937;"
                       value="{{ old('location', $user->location) }}"
                       placeholder="e.g., Dar es Salaam, Tanzania">
                @error('location')
                    <p class="text-xs mt-1" style="color: #DC2626;">{{ $message }}</p>
                @enderror
            </div>
            
            <button type="submit" class="w-full font-semibold py-3 rounded-lg transition-all hover:shadow-md active:scale-98" style="background-color: #F57C00; color: #FFFFFF;">
                Update Profile
            </button>
        </form>
    </div>
</div>

<style>
    input:focus {
        outline: none;
        border-color: #F57C00;
        box-shadow: 0 0 0 3px rgba(245, 124, 0, 0.1);
    }
    
    button:active {
        transform: scale(0.98);
    }
    
    @media (max-width: 640px) {
        input, button {
            font-size: 16px;
        }
    }
</style>
@endsection