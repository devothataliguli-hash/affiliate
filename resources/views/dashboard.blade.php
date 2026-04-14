@extends('layouts.app')

@section('title', 'Dashboard - ELLYPESA')
@section('page-title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-8">

    {{-- AVAILABLE TRAININGS SECTION (MOVED TO TOP) --}}
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-gray-50 px-4 sm:px-6 py-4 border-b border-gray-100">
            <h3 class="text-xl font-bold text-gray-800">📚 Mafunzo Yanayopatikana</h3>
            <p class="text-gray-500 text-sm mt-1">Chagua kategoria yako, kisha bonyeza "Jisajili" kwenye mafunzo unayotaka.</p>
        </div>
        
        <div class="p-4 sm:p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                {{-- Category 1: Affiliate / Digital Marketing --}}
                <div class="bg-gray-50 rounded-xl overflow-hidden shadow-sm border border-gray-200 transition hover:shadow-md">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-4 sm:px-5 py-4 text-white">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-chart-line text-2xl"></i>
                            <div>
                                <h4 class="font-bold text-base sm:text-lg">Digital Marketing & Affiliate</h4>
                                <p class="text-xs text-blue-100 mt-0.5">Jifunze kutengeneza pesa mtandaoni</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 space-y-3 max-h-96 overflow-y-auto">
                        @forelse($categorizedSkills['affiliate'] as $skill)
                            <div class="bg-white rounded-lg p-3 shadow-sm hover:shadow transition">
                                <div class="flex justify-between items-start gap-2">
                                    <div class="flex-1">
                                        <h5 class="font-semibold text-gray-800 text-sm">{{ $skill->name }}</h5>
                                        <p class="text-xs text-gray-500 mt-1">{{ Str::limit($skill->description, 60) }}</p>
                                    </div>
                                    <span class="text-xs font-bold whitespace-nowrap px-2 py-1 rounded-full
                                        {{ $skill->price == 0 ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">
                                        @if($skill->price == 0) Bure @else Tsh {{ number_format($skill->price) }} @endif
                                    </span>
                                </div>
                                @if(in_array($skill->id, $enrolledIds))
                                    <div class="mt-2 flex items-center gap-1 text-xs text-green-600">
                                        <i class="fas fa-check-circle"></i>
                                        <span>Umeshasajili</span>
                                    </div>
                                @else
                                    <form action="{{ route('user.skills.enroll', $skill->id) }}" method="POST" class="mt-3">
                                        @csrf
                                        <button type="submit" class="w-full text-center bg-primary hover:bg-primary-dark text-white text-xs font-medium px-3 py-2 rounded-lg transition">
                                            Jisajili Sasa
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-6 text-gray-400 text-sm">
                                <i class="fas fa-info-circle text-2xl mb-2 opacity-40 block"></i>
                                Hakuna mafunzo bado. Yanayojiri hivi karibuni.
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Category 2: Entrepreneurship --}}
                <div class="bg-gray-50 rounded-xl overflow-hidden shadow-sm border border-gray-200 transition hover:shadow-md">
                    <div class="bg-gradient-to-r from-green-500 to-green-600 px-4 sm:px-5 py-4 text-white">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-store text-2xl"></i>
                            <div>
                                <h4 class="font-bold text-base sm:text-lg">Entrepreneurship</h4>
                                <p class="text-xs text-green-100 mt-0.5">Anzisha na kukuza biashara yako</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 space-y-3 max-h-96 overflow-y-auto">
                        @forelse($categorizedSkills['entrepreneurship'] as $skill)
                            <div class="bg-white rounded-lg p-3 shadow-sm hover:shadow transition">
                                <div class="flex justify-between items-start gap-2">
                                    <div class="flex-1">
                                        <h5 class="font-semibold text-gray-800 text-sm">{{ $skill->name }}</h5>
                                        <p class="text-xs text-gray-500 mt-1">{{ Str::limit($skill->description, 60) }}</p>
                                    </div>
                                    <span class="text-xs font-bold whitespace-nowrap px-2 py-1 rounded-full
                                        {{ $skill->price == 0 ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">
                                        @if($skill->price == 0) Bure @else Tsh {{ number_format($skill->price) }} @endif
                                    </span>
                                </div>
                                @if(in_array($skill->id, $enrolledIds))
                                    <div class="mt-2 flex items-center gap-1 text-xs text-green-600">
                                        <i class="fas fa-check-circle"></i>
                                        <span>Umeshasajili</span>
                                    </div>
                                @else
                                    <form action="{{ route('user.skills.enroll', $skill->id) }}" method="POST" class="mt-3">
                                        @csrf
                                        <button type="submit" class="w-full text-center bg-primary hover:bg-primary-dark text-white text-xs font-medium px-3 py-2 rounded-lg transition">
                                            Jisajili Sasa
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-6 text-gray-400 text-sm">
                                <i class="fas fa-info-circle text-2xl mb-2 opacity-40 block"></i>
                                Hakuna mafunzo bado. Yanayojiri hivi karibuni.
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Category 3: Team Management --}}
                <div class="bg-gray-50 rounded-xl overflow-hidden shadow-sm border border-gray-200 transition hover:shadow-md">
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-4 sm:px-5 py-4 text-white">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-users text-2xl"></i>
                            <div>
                                <h4 class="font-bold text-base sm:text-lg">Team Management</h4>
                                <p class="text-xs text-purple-100 mt-0.5">Uongozi, motisha na utendaji wa timu</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 space-y-3 max-h-96 overflow-y-auto">
                        @forelse($categorizedSkills['team_management'] as $skill)
                            <div class="bg-white rounded-lg p-3 shadow-sm hover:shadow transition">
                                <div class="flex justify-between items-start gap-2">
                                    <div class="flex-1">
                                        <h5 class="font-semibold text-gray-800 text-sm">{{ $skill->name }}</h5>
                                        <p class="text-xs text-gray-500 mt-1">{{ Str::limit($skill->description, 60) }}</p>
                                    </div>
                                    <span class="text-xs font-bold whitespace-nowrap px-2 py-1 rounded-full
                                        {{ $skill->price == 0 ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">
                                        @if($skill->price == 0) Bure @else Tsh {{ number_format($skill->price) }} @endif
                                    </span>
                                </div>
                                @if(in_array($skill->id, $enrolledIds))
                                    <div class="mt-2 flex items-center gap-1 text-xs text-green-600">
                                        <i class="fas fa-check-circle"></i>
                                        <span>Umeshasajili</span>
                                    </div>
                                @else
                                    <form action="{{ route('user.skills.enroll', $skill->id) }}" method="POST" class="mt-3">
                                        @csrf
                                        <button type="submit" class="w-full text-center bg-primary hover:bg-primary-dark text-white text-xs font-medium px-3 py-2 rounded-lg transition">
                                            Jisajili Sasa
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-6 text-gray-400 text-sm">
                                <i class="fas fa-info-circle text-2xl mb-2 opacity-40 block"></i>
                                Hakuna mafunzo bado. Yanayojiri hivi karibuni.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MY COURSES + STATS (2-COLUMN GRID) --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- MY COURSES SECTION (left, 2/3 width) --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gray-50 px-4 sm:px-6 py-4 border-b border-gray-100 flex justify-between items-center flex-wrap gap-2">
                    <h3 class="font-semibold text-gray-800">📖 Programu Zako</h3>
                    <span class="text-xs bg-orange-100 text-orange-600 px-3 py-1 rounded-full">
                        {{ $stats['total_enrolled'] }} Jumla
                    </span>
                </div>
                <div class="p-4 sm:p-6">
                    @if($enrolledSkills->isEmpty())
                        <div class="text-center py-10 text-gray-500">
                            <i class="fas fa-graduation-cap text-5xl mb-3 opacity-30"></i>
                            <p>Bado hujajisajili kwenye mafunzo yoyote.</p>
                            <p class="text-sm mt-1">Chagua mafunzo kutoka sehemu ya juu ya ukurasa.</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($enrolledSkills as $skill)
                            <div class="border border-gray-100 rounded-xl p-4 hover:shadow-sm transition">
                                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-2">
                                    <div class="flex-1">
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
                                            {{ Str::limit($skill->description, 80) }}
                                        </p>
                                    </div>
                                    <span class="text-xs px-2 py-1 rounded self-start whitespace-nowrap
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

                                {{-- Progress bar placeholder --}}
                                <div class="mt-3 w-full bg-gray-100 rounded-full h-2">
                                    <div class="bg-orange-500 h-2 rounded-full" style="width: {{ $skill->pivot->is_approved ? rand(10, 80) : 0 }}%"></div>
                                </div>

                                @if($skill->pivot->is_approved)
                                    <a href="{{ route('user.learn', $skill->id) }}" class="text-xs text-orange-600 font-medium mt-3 inline-block hover:underline">
                                        Endelea kujifunza →
                                    </a>
                                @else
                                    <p class="text-xs text-gray-400 mt-3">
                                        <i class="fas fa-info-circle mr-1"></i> Admin atakapothibitisha utaweza kuendelea
                                    </p>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- STATS CARD (right, 1/3 width) --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gray-50 px-4 sm:px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-800">📊 Muhtasari</h3>
            </div>
            <div class="p-4 sm:p-6 space-y-5">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600">
                        <i class="fas fa-book text-xl"></i>
                    </div>
                    <div>
                        <p class="font-bold text-2xl text-gray-800">{{ $stats['total_enrolled'] }}</p>
                        <p class="text-xs text-gray-500">Kozi zote ulizojisajili</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center text-green-600">
                        <i class="fas fa-check-circle text-xl"></i>
                    </div>
                    <div>
                        <p class="font-bold text-2xl text-gray-800">{{ $stats['approved'] }}</p>
                        <p class="text-xs text-gray-500">Zilizothibitishwa na kufunguliwa</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-yellow-100 flex items-center justify-center text-yellow-600">
                        <i class="fas fa-clock text-xl"></i>
                    </div>
                    <div>
                        <p class="font-bold text-2xl text-gray-800">{{ $stats['pending'] }}</p>
                        <p class="text-xs text-gray-500">Zinazosubiri uthibitisho / malipo</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- RESOURCES SECTION --}}
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-gray-50 px-4 sm:px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-800">📌 Rasilimali Zinazosaidia</h3>
        </div>
        <div class="p-4 sm:p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="border border-gray-100 rounded-xl p-4 hover:shadow-md transition flex items-start gap-4">
                    <i class="fas fa-file-pdf text-red-500 text-2xl"></i>
                    <div>
                        <h4 class="font-medium text-gray-800">Affiliate Guide PDF</h4>
                        <p class="text-xs text-gray-500 mt-1">Mwongozo kamili wa kuanza affiliate marketing</p>
                        <a href="#" class="text-xs text-orange-600 mt-2 inline-block font-medium">Pakua Sasa →</a>
                    </div>
                </div>
                <div class="border border-gray-100 rounded-xl p-4 hover:shadow-md transition flex items-start gap-4">
                    <i class="fab fa-whatsapp text-green-500 text-2xl"></i>
                    <div>
                        <h4 class="font-medium text-gray-800">WhatsApp Support Group</h4>
                        <p class="text-xs text-gray-500 mt-1">Pata msaada, maswali na motisha kutoka kwa wenzako</p>
                        <a href="https://wa.me/255626549262" target="_blank" class="text-xs text-orange-600 mt-2 inline-block font-medium">Jiunge Sasa →</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection