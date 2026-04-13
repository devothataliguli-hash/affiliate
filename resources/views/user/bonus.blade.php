@extends('layouts.app')

@section('title', 'Bonus & Summary - ELLYPESA')
@section('page-title', 'Muhtasari')

@section('content')
<div class="max-w-6xl mx-auto space-y-5">

    <!-- HEADER -->
    <div>
        <h1 class="text-xl md:text-2xl font-bold text-gray-900">
            Muhtasari Wako
        </h1>
        <p class="text-sm text-gray-600 mt-1">
            Fuatilia maendeleo yako na tazama takwimu muhimu.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        <!-- LEFT COLUMN - STATS CARDS -->
        <div class="lg:col-span-2 space-y-5">

            <!-- QUICK STATS -->
            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-5">
                <h3 class="font-semibold text-gray-900 mb-4">
                    📊 Takwimu Zako
                </h3>
                
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <div class="bg-gray-50 rounded-xl p-4 text-center">
                        <p class="text-2xl font-bold text-gray-800">{{ $enrolledSkills->count() }}</p>
                        <p class="text-xs text-gray-500">Skills Zote</p>
                    </div>
                    <div class="bg-green-50 rounded-xl p-4 text-center">
                        <p class="text-2xl font-bold text-green-700">{{ $approvedCount }}</p>
                        <p class="text-xs text-gray-600">Zilizoidhinishwa</p>
                    </div>
                    <div class="bg-orange-50 rounded-xl p-4 text-center">
                        <p class="text-2xl font-bold text-orange-700">{{ $enrolledSkills->count() - $approvedCount }}</p>
                        <p class="text-xs text-gray-600">Zinasubiri</p>
                    </div>
                </div>
            </div>

            <!-- SPENDING SUMMARY -->
            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-5 text-center">
                <h3 class="font-semibold text-gray-900 mb-2">
                    💰 Jumla ya Matumizi
                </h3>
                <p class="text-xs text-gray-500">Kiasi ulicholipa kwa skills</p>
                <p class="text-3xl font-bold text-primary mt-2">
                    Tsh {{ number_format($totalSpent) }}
                </p>
                <p class="text-xs text-gray-500 mt-2">
                    @if($totalSpent > 0)
                        Umewekeza kwenye maendeleo yako!
                    @else
                        Bado hujalipia skill yoyote.
                    @endif
                </p>
            </div>

            <!-- ENROLLED SKILLS LIST -->
            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-5">
                <h3 class="font-semibold text-gray-900 mb-4">
                    📚 Skills Zako
                </h3>
                
                @if($enrolledSkills->isEmpty())
                    <p class="text-gray-500 text-sm text-center py-4">Bado hujajisajili kwenye skill yoyote.</p>
                @else
                    <div class="space-y-3">
                        @foreach($enrolledSkills as $skill)
                        <div class="flex items-center justify-between border-b border-gray-100 pb-3 last:border-0 last:pb-0">
                            <div>
                                <p class="font-medium text-gray-800">{{ $skill->name }}</p>
                                <p class="text-xs text-gray-500">
                                    @if($skill->pivot->is_approved)
                                        <span class="text-green-600"><i class="fas fa-check-circle mr-1"></i> Imethibitishwa</span>
                                    @else
                                        <span class="text-yellow-600"><i class="fas fa-clock mr-1"></i> Inasubiri</span>
                                    @endif
                                </p>
                            </div>
                            <span class="text-sm text-gray-600">
                                {{ $skill->price > 0 ? 'Tsh '.number_format($skill->price) : 'Bure' }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- RIGHT COLUMN - GOALS & LEADERBOARD -->
        <div class="space-y-5">

            <!-- LEADERBOARD (static) -->
            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-5">
                <h3 class="font-semibold text-gray-900 mb-4">
                    🏅 Wanaoongoza
                </h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between items-center">
                        <span class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-yellow-400 text-white text-xs flex items-center justify-center font-bold">1</span>
                            Amina J.
                        </span>
                        <span class="text-primary font-semibold">Tsh 45,000</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-gray-300 text-white text-xs flex items-center justify-center font-bold">2</span>
                            Juma K.
                        </span>
                        <span class="text-primary font-semibold">Tsh 32,000</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-orange-400 text-white text-xs flex items-center justify-center font-bold">3</span>
                            Faraja M.
                        </span>
                        <span class="text-primary font-semibold">Tsh 28,000</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-gray-200 text-gray-700 text-xs flex items-center justify-center font-bold">4</span>
                            {{ $user->name }}
                        </span>
                        <span class="text-primary font-semibold">Tsh {{ number_format($totalSpent) }}</span>
                    </div>
                </div>
                <p class="text-xs text-gray-400 mt-3 text-center">*Wanaoongoza kwa matumizi</p>
            </div>

            <!-- GOALS -->
            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-5">
                <h3 class="font-semibold text-gray-900 mb-4">
                    🎯 Malengo Yako
                </h3>
                <div class="space-y-4 text-sm">
                    <!-- Goal 1: Skills -->
                    <div>
                        <div class="flex justify-between text-xs mb-1 text-gray-600">
                            <span>Jisajili Skills {{ $skillsGoal }}</span>
                            <span>{{ $skillsProgress }}/{{ $skillsGoal }}</span>
                        </div>
                        <div class="w-full bg-gray-100 h-2 rounded-full">
                            <div class="bg-primary h-2 rounded-full" style="width:{{ $skillsPercent }}%"></div>
                        </div>
                    </div>

                    <!-- Goal 2: Referrals (placeholder) -->
                    <div>
                        <div class="flex justify-between text-xs mb-1 text-gray-600">
                            <span>Waalike Marafiki {{ $referralGoal }}</span>
                            <span>{{ $referralProgress }}/{{ $referralGoal }}</span>
                        </div>
                        <div class="w-full bg-gray-100 h-2 rounded-full">
                            <div class="bg-primary h-2 rounded-full" style="width:{{ $referralPercent }}%"></div>
                        </div>
                    </div>

                    <!-- Goal 3: Spending -->
                    <div>
                        <div class="flex justify-between text-xs mb-1 text-gray-600">
                            <span>Wekeza Tsh {{ number_format($incomeGoal) }}</span>
                            <span>{{ number_format($incomeProgress) }}</span>
                        </div>
                        <div class="w-full bg-gray-100 h-2 rounded-full">
                            <div class="bg-primary h-2 rounded-full" style="width:{{ $incomePercent }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection