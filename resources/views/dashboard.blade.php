@extends('layouts.app')

@section('title', 'Dashboard - ELLYPESA')
@section('page-title', 'Dashboard')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    {{-- WELCOME CARD --}}
    <div class="bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-2xl p-5 shadow-md">
        <h2 class="text-sm sm:text-base md:text-lg font-semibold">
            Karibu {{ $user->name }} 👋 — 
            <span class="font-normal text-white/90">Endelea na safari yako ya kujenga kipato chako.</span>
        </h2>
    </div>

    {{-- MAIN GRID --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        {{-- COURSES SECTION --}}
        <div class="lg:col-span-2 space-y-4">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-semibold text-gray-800">Programu Zako</h3>
                    <span class="text-xs bg-orange-100 text-orange-600 px-3 py-1 rounded-full">
                        {{ $stats['total_enrolled'] }} Jumla
                    </span>
                </div>

                @if($enrolledSkills->isEmpty())
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-graduation-cap text-4xl mb-2 opacity-40"></i>
                        <p>Bado hujajisajili kwenye skill yoyote.</p>
                        <a href="{{ route('user.skills') }}" class="text-primary text-sm mt-2 inline-block">Chagua Skill →</a>
                    </div>
                @else
                    @foreach($enrolledSkills as $skill)
                    <div class="border border-gray-100 rounded-xl p-4 mb-4 last:mb-0">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="font-medium text-gray-800">
                                    @if($skill->price > 0)
                                        @if($skill->pivot->is_approved)
                                            <i class="fas fa-check-circle text-green-500 mr-1"></i>
                                        @else
                                            <i class="fas fa-clock text-yellow-500 mr-1"></i>
                                        @endif
                                    @endif
                                    {{ $skill->name }}
                                </h4>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ Str::limit($skill->description, 60) }}
                                </p>
                            </div>
                            <span class="text-xs px-2 py-1 rounded 
                                @if($skill->pivot->is_approved) 
                                    bg-green-100 text-green-600 
                                @else 
                                    bg-yellow-100 text-yellow-600 
                                @endif">
                                @if($skill->pivot->is_approved)
                                    Imethibitishwa
                                @else
                                    Inasubiri Uthibitisho
                                @endif
                            </span>
                        </div>

                        {{-- Progress bar (placeholder for now) --}}
                        <div class="mt-3 w-full bg-gray-100 rounded-full h-2">
                            <div class="bg-orange-500 h-2 rounded-full" style="width: {{ $skill->pivot->is_approved ? rand(10, 80) : 0 }}%"></div>
                        </div>

                        @if($skill->pivot->is_approved)
                            <a href="#" class="text-xs text-orange-600 font-medium mt-3 inline-block">
                                Endelea kujifunza →
                            </a>
                        @else
                            <p class="text-xs text-gray-400 mt-3">
                                <i class="fas fa-info-circle mr-1"></i> Admin atakapothibitisha utaweza kuendelea
                            </p>
                        @endif
                    </div>
                    @endforeach
                @endif
            </div>
        </div>

        {{-- STATS SECTION --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <h3 class="font-semibold text-gray-800 mb-4">Muhtasari</h3>

            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600">
                        <i class="fas fa-book"></i>
                    </div>
                    <div>
                        <p class="font-bold text-gray-800">{{ $stats['total_enrolled'] }}</p>
                        <p class="text-xs text-gray-500">Kozi zote</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center text-green-600">
                        <i class="fas fa-check"></i>
                    </div>
                    <div>
                        <p class="font-bold text-gray-800">{{ $stats['approved'] }}</p>
                        <p class="text-xs text-gray-500">Zilizothibitishwa</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-yellow-100 flex items-center justify-center text-yellow-600">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <p class="font-bold text-gray-800">{{ $stats['pending'] }}</p>
                        <p class="text-xs text-gray-500">Zinazosubiri</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- RESOURCES (static for now) --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <h3 class="font-semibold text-gray-800 mb-4">
            📌 Rasilimali
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="border border-gray-100 rounded-xl p-4 hover:shadow-sm transition">
                <div class="flex gap-3">
                    <i class="fas fa-file-pdf text-red-500 mt-1"></i>
                    <div>
                        <h4 class="font-medium text-gray-800 text-sm">
                            Affiliate Guide PDF
                        </h4>
                        <p class="text-xs text-gray-500">
                            Mwongozo kamili wa kuanza
                        </p>
                        <a href="#" class="text-xs text-orange-600 mt-2 inline-block">
                            Pakua →
                        </a>
                    </div>
                </div>
            </div>

            <div class="border border-gray-100 rounded-xl p-4 hover:shadow-sm transition">
                <div class="flex gap-3">
                    <i class="fab fa-whatsapp text-green-500 mt-1"></i>
                    <div>
                        <h4 class="font-medium text-gray-800 text-sm">
                            WhatsApp Group
                        </h4>
                        <p class="text-xs text-gray-500">
                            Pata msaada na motisha
                        </p>
                        <a href="https://wa.me/255678043562" target="_blank" class="text-xs text-orange-600 mt-2 inline-block">
                            Jiunge →
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection