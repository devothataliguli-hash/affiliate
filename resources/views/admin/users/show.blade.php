@extends('layouts.admin')

@section('title', 'User Details - ' . $user->name)

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-4">
    <div class="mb-5 md:mb-6">
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 text-sm font-medium transition-colors py-2 px-1 rounded-lg hover:bg-orange-50" style="color: #F57C00;">
            <i class="fas fa-arrow-left text-xs"></i> Back to Users
        </a>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        {{-- User Profile Card --}}
        <div class="rounded-xl shadow-md overflow-hidden" style="background-color: #FFFFFF;">
            <div class="p-6 text-center border-b" style="border-color: #F3F4F6;">
                <div class="w-24 h-24 mx-auto rounded-full flex items-center justify-center mb-4" style="background-color: #FFF3E0;">
                    <i class="fas fa-user text-3xl" style="color: #F57C00;"></i>
                </div>
                <h2 class="text-xl font-bold" style="color: #1F2937;">{{ $user->name }}</h2>
                @if($user->is_admin)
                    <span class="inline-block mt-1 text-xs font-semibold px-2 py-1 rounded-full" style="background-color: #FEF3C7; color: #92400E;">Administrator</span>
                @else
                    <span class="inline-block mt-1 text-xs font-semibold px-2 py-1 rounded-full" style="background-color: #D1FAE5; color: #065F46;">Regular User</span>
                @endif
            </div>
            <div class="p-5 space-y-3">
                <div class="flex items-center gap-3">
                    <i class="fas fa-envelope w-5" style="color: #6B7280;"></i>
                    <div>
                        <p class="text-xs" style="color: #6B7280;">Email</p>
                        <p class="text-sm" style="color: #1F2937;">{{ $user->email ?? 'Not provided' }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <i class="fas fa-phone-alt w-5" style="color: #6B7280;"></i>
                    <div>
                        <p class="text-xs" style="color: #6B7280;">Phone</p>
                        <p class="text-sm" style="color: #1F2937;">{{ $user->phone ?? 'Not provided' }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <i class="fab fa-whatsapp w-5" style="color: #6B7280;"></i>
                    <div>
                        <p class="text-xs" style="color: #6B7280;">WhatsApp</p>
                        <p class="text-sm" style="color: #1F2937;">{{ $user->whatsapp ?? 'Not provided' }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <i class="fas fa-map-marker-alt w-5" style="color: #6B7280;"></i>
                    <div>
                        <p class="text-xs" style="color: #6B7280;">Location</p>
                        <p class="text-sm" style="color: #1F2937;">{{ $user->location ?? 'Not provided' }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <i class="fas fa-calendar-alt w-5" style="color: #6B7280;"></i>
                    <div>
                        <p class="text-xs" style="color: #6B7280;">Member Since</p>
                        <p class="text-sm" style="color: #1F2937;">{{ $user->created_at->format('d F Y') }}</p>
                    </div>
                </div>
            </div>
            <div class="p-5 border-t flex gap-3" style="border-color: #F3F4F6;">
                <a href="{{ route('admin.users.edit', $user) }}" class="flex-1 text-center font-semibold px-4 py-2 rounded-lg transition hover:shadow-md" style="background-color: #F57C00; color: #FFFFFF;">
                    <i class="fas fa-edit mr-1"></i> Edit User
                </a>
                @if($user->id !== auth()->id())
                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="flex-1" onsubmit="return confirm('Delete this user?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full font-semibold px-4 py-2 rounded-lg transition hover:shadow-md" style="background-color: #FEE2E2; color: #DC2626;">
                        <i class="fas fa-trash mr-1"></i> Delete
                    </button>
                </form>
                @endif
            </div>
        </div>

        {{-- Payment Statistics --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="rounded-xl shadow-md overflow-hidden" style="background-color: #FFFFFF;">
                <div class="px-5 py-4 border-b" style="background: linear-gradient(135deg, #FFF3E0, #FFE0B2); border-color: #E5E7EB;">
                    <h2 class="font-bold text-lg" style="color: #1F2937;">Payment Summary</h2>
                </div>
                <div class="p-5">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                        <div class="text-center p-3 rounded-lg" style="background-color: #F9FAFB;">
                            <p class="text-2xl font-bold" style="color: #3B82F6;">{{ $paymentStats['total'] }}</p>
                            <p class="text-xs" style="color: #6B7280;">Total Payments</p>
                        </div>
                        <div class="text-center p-3 rounded-lg" style="background-color: #F9FAFB;">
                            <p class="text-2xl font-bold" style="color: #10B981;">{{ $paymentStats['approved'] }}</p>
                            <p class="text-xs" style="color: #6B7280;">Approved</p>
                        </div>
                        <div class="text-center p-3 rounded-lg" style="background-color: #F9FAFB;">
                            <p class="text-2xl font-bold" style="color: #F59E0B;">{{ $paymentStats['pending'] }}</p>
                            <p class="text-xs" style="color: #6B7280;">Pending</p>
                        </div>
                        <div class="text-center p-3 rounded-lg" style="background-color: #F9FAFB;">
                            <p class="text-2xl font-bold" style="color: #F57C00;">Tsh {{ number_format($paymentStats['total_amount']) }}</p>
                            <p class="text-xs" style="color: #6B7280;">Total Spent</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Enrolled Skills --}}
            <div class="rounded-xl shadow-md overflow-hidden" style="background-color: #FFFFFF;">
                <div class="px-5 py-4 border-b" style="border-color: #F3F4F6;">
                    <h2 class="font-bold text-lg" style="color: #1F2937;">Enrolled Skills</h2>
                </div>
                <div class="divide-y" style="border-color: #F3F4F6;">
                    @forelse($user->skills as $skill)
                    <div class="px-5 py-4 flex items-center justify-between">
                        <div>
                            <p class="font-semibold" style="color: #1F2937;">{{ $skill->name }}</p>
                            <p class="text-xs" style="color: #6B7280;">Enrolled: {{ $skill->pivot->created_at->format('d M Y') }}</p>
                        </div>
                        @if($skill->pivot->status === 'approved')
                            <span class="text-xs font-semibold px-2 py-1 rounded-full" style="background-color: #D1FAE5; color: #065F46;">Active</span>
                        @else
                            <span class="text-xs font-semibold px-2 py-1 rounded-full" style="background-color: #FEF3C7; color: #92400E;">Pending</span>
                        @endif
                    </div>
                    @empty
                    <div class="px-5 py-8 text-center">
                        <p class="text-sm" style="color: #6B7280;">No skills enrolled yet.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection