@extends('layouts.user')

@section('title', 'Purchase ' . $skill->name)

@section('content')
<div class="max-w-4xl mx-auto px-3 sm:px-4">
    <div class="mb-5 md:mb-6">
        <a href="{{ route('user.dashboard') }}" class="inline-flex items-center gap-2 text-sm font-medium transition-colors py-2 px-1 rounded-lg hover:bg-orange-50" style="color: #F57C00;">
            <i class="fas fa-arrow-left text-xs"></i> Back to Dashboard
        </a>
    </div>
    
    <div class="rounded-xl shadow-md overflow-hidden" style="background-color: #FFFFFF;">
        <div class="p-5 md:p-7" style="background: linear-gradient(135deg, #F57C00, #E65100);">
            <h1 class="text-xl md:text-2xl font-bold" style="color: #FFFFFF;">Purchase: {{ $skill->name }}</h1>
            <p class="text-sm md:text-base mt-1" style="color: #FFE0B2;">Complete your payment to unlock full access</p>
        </div>
        
        <div class="p-5 md:p-7">
            <div class="mb-6">
                <div class="flex justify-between items-center pb-3 border-b" style="border-color: #E5E7EB;">
                    <span class="text-sm md:text-base" style="color: #6B7280;">Skill</span>
                    <span class="font-semibold text-sm md:text-base" style="color: #1F2937;">{{ $skill->name }}</span>
                </div>
                <div class="flex justify-between items-center pt-3">
                    <span class="text-sm md:text-base" style="color: #6B7280;">Price</span>
                    <span class="font-bold text-xl md:text-2xl" style="color: #F57C00;">Tsh {{ number_format($skill->price) }}</span>
                </div>
            </div>
            
            <form action="{{ route('user.payments.store', $skill) }}" method="POST">
                @csrf
                
                <div class="mb-6">
                    <label for="phone_number" class="block text-sm font-semibold mb-2" style="color: #374151;">
                        M-Pesa Phone Number
                    </label>
                    <input type="tel" 
                           name="phone_number" 
                           id="phone_number" 
                           class="w-full px-4 py-3 rounded-lg border transition-all focus:outline-none focus:ring-2"
                           style="border-color: #D1D5DB; background-color: #FFFFFF; color: #1F2937;"
                           placeholder="e.g., 0765 289 993"
                           value="{{ old('phone_number', auth()->user()->phone) }}"
                           required>
                    <p class="text-xs mt-1" style="color: #6B7280;">Enter the phone number you use for M-Pesa</p>
                    @error('phone_number')
                        <p class="text-xs mt-1" style="color: #DC2626;">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="rounded-lg p-4 mb-6 border" style="background-color: #FFFBEB; border-color: #FDE68A;">
                    <div class="flex gap-3">
                        <i class="fas fa-info-circle mt-0.5" style="color: #D97706;"></i>
                        <div class="text-sm" style="color: #92400E;">
                            <p class="font-semibold mb-1">Payment Instructions:</p>
                            <p>1. Send <strong style="color: #F57C00;">Tsh {{ number_format($skill->price) }}</strong> to <strong>0765 289 993</strong> (Elias Shamlamba)</p>
                            <p>2. Enter your phone number above</p>
                            <p>3. Click "Submit Payment Request"</p>
                            <p class="mt-2 text-xs" style="color: #B45309;">Your access will be granted after admin approval (within 24 hours)</p>
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="w-full font-bold py-3 rounded-lg transition-all hover:shadow-md active:scale-98" style="background-color: #F57C00; color: #FFFFFF;">
                    Submit Payment Request
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    @media (max-width: 640px) {
        input, button {
            font-size: 16px;
        }
    }
    
    button:active {
        transform: scale(0.98);
    }
    
    input:focus {
        outline: none;
        border-color: #F57C00;
        box-shadow: 0 0 0 3px rgba(245, 124, 0, 0.1);
    }
</style>
@endsection