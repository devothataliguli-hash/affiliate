@extends('layouts.app')

@section('title', 'Skills - ELLYPESA')
@section('page-title', 'Skills')

@section('content')
<div class="max-w-6xl mx-auto space-y-5">

    <!-- HEADER -->
    <div>
        <h1 class="text-xl md:text-2xl font-bold text-gray-900">
            Skills & Mafunzo
        </h1>
        <p class="text-sm text-gray-600 mt-1">
            Chagua skills zako. Free au premium zimepangiliwa vizuri.
        </p>
    </div>

    <!-- GRID -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

        @forelse($skills as $skill)
            @php
                $isEnrolled = in_array($skill->id, $enrolledSkillIds);
                $isApproved = in_array($skill->id, $approvedSkillIds);
                $isPending = in_array($skill->id, $pendingSkillIds);
                $isFree = $skill->price == 0;
            @endphp

            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden hover:shadow-md transition">
                {{-- Top color bar --}}
                <div class="h-1.5 {{ $isFree ? 'bg-green-500' : 'bg-orange-500' }}"></div>

                <div class="p-4 space-y-3">
                    {{-- Icon and Price Badge --}}
                    <div class="flex justify-between items-center">
                        <div class="w-10 h-10 rounded-xl {{ $isFree ? 'bg-green-100 text-green-600' : 'bg-orange-100 text-orange-600' }} flex items-center justify-center">
                            @if(str_contains(strtolower($skill->name), 'affiliate'))
                                <i class="fas fa-chart-line"></i>
                            @elseif(str_contains(strtolower($skill->name), 'biashara'))
                                <i class="fas fa-store"></i>
                            @elseif(str_contains(strtolower($skill->name), 'online'))
                                <i class="fas fa-globe"></i>
                            @elseif(str_contains(strtolower($skill->name), 'team'))
                                <i class="fas fa-users"></i>
                            @elseif(str_contains(strtolower($skill->name), 'mauzo'))
                                <i class="fas fa-chart-bar"></i>
                            @elseif(str_contains(strtolower($skill->name), 'motivation') || str_contains(strtolower($skill->name), 'mindset'))
                                <i class="fas fa-fire"></i>
                            @else
                                <i class="fas fa-graduation-cap"></i>
                            @endif
                        </div>

                        <span class="text-xs px-2 py-1 rounded-full font-semibold {{ $isFree ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-600' }}">
                            @if($isFree)
                                FREE
                            @else
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-lock text-[10px]"></i> 
                                    {{ number_format($skill->price) }}
                                </span>
                            @endif
                        </span>
                    </div>

                    {{-- Skill Name --}}
                    <h3 class="font-semibold text-gray-900">
                        {{ $skill->name }}
                    </h3>

                    {{-- Description --}}
                    <p class="text-xs text-gray-600 leading-relaxed">
                        {{ Str::limit($skill->description, 70) }}
                    </p>

                    {{-- Action Button based on enrollment status --}}
                    @if($isEnrolled)
                        @if($isApproved)
                           <a href="{{ route('user.learn', $skill) }}" class="w-full bg-green-500 hover:bg-green-600 text-white text-sm font-semibold py-2.5 rounded-xl transition active:scale-95 text-center block">
    Endelea Kujifunza
</a>
                        @else
                            <button disabled class="w-full bg-gray-200 text-gray-500 text-sm font-semibold py-2.5 rounded-xl cursor-not-allowed text-center">
                                <i class="fas fa-clock mr-1"></i> Inasubiri Uthibitisho
                            </button>
                        @endif
                    @else
                        @if($isFree)
                            <form action="{{ route('user.skills.enroll', $skill) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white text-sm font-semibold py-2.5 rounded-xl transition active:scale-95">
                                    Anza Kujifunza
                                </button>
                            </form>
                        @else
                            <a href="{{ route('user.payment.create', $skill) }}" class="w-full border border-orange-500 text-orange-600 hover:bg-orange-500 hover:text-white text-sm font-semibold py-2.5 rounded-xl transition active:scale-95 text-center block">
                                Lipia Sasa
                            </a>
                        @endif
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12 text-gray-500">
                <i class="fas fa-graduation-cap text-5xl mb-3 opacity-40"></i>
                <p>Hakuna skills zinazopatikana kwa sasa.</p>
            </div>
        @endforelse

    </div>
</div>
@endsection