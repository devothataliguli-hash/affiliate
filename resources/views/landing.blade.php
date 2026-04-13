{{-- resources/views/landing.blade.php --}}
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ELLYPESA | Geuza Simu Yako Kuwa Kipato</title>
    <meta name="description" content="Jifunze Affiliate Marketing, Biashara Ndogo Ndogo, Online Business na Team Building na ELLYPESA.">
    
    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    {{-- Alpine.js for mobile menu toggle --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    {{-- Custom Styles --}}
    <style>
        .hero-overlay {
            background: linear-gradient(135deg, rgba(0,0,0,0.75) 0%, rgba(0,0,0,0.5) 100%);
        }
        .text-primary { color: #FF6F00; }
        .bg-primary { background-color: #FF6F00; }
        .bg-primary-dark { background-color: #E65100; }
        .border-primary { border-color: #FF6F00; }
        .hover\:bg-primary-dark:hover { background-color: #E65100; }
        .ring-primary { --tw-ring-color: #FF6F00; }
        html { scroll-behavior: smooth; }
        .testimonial-card { transition: transform 0.2s ease; }
        .testimonial-card:hover { transform: translateY(-4px); }
        .lock-icon { background: rgba(255,111,0,0.1); border-radius: 50%; padding: 8px; }
        .whatsapp-float {
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
    </style>
</head>
<body class="bg-white text-gray-800 font-sans antialiased">

    {{-- Sticky WhatsApp Button --}}
    <a href="https://wa.me/255678043562?text=Habari%20ELLYPESA%2C%20napenda%20kujua%20zaidi%20kuhusu%20mafunzo%20yako." 
       target="_blank" 
       class="whatsapp-float fixed bottom-6 right-6 z-50 bg-green-500 text-white p-4 rounded-full shadow-lg hover:bg-green-600 transition-all duration-300 flex items-center justify-center w-14 h-14 md:w-auto md:h-auto md:px-5 md:py-3 md:rounded-full"
       aria-label="Chat on WhatsApp">
        <i class="fab fa-whatsapp text-2xl md:mr-2"></i>
        <span class="hidden md:inline font-medium">0678 043 562</span>
    </a>

    {{-- Sticky Join Now Button (mobile) --}}
    <div class="fixed bottom-6 left-0 right-0 z-40 px-4 md:hidden">
        <a href="#signup" class="bg-primary hover:bg-primary-dark text-white font-bold py-4 px-6 rounded-xl shadow-xl text-center block transition-all duration-300 transform hover:scale-[1.02]">
            👉 JIUNGE SASA
        </a>
    </div>

    {{-- Navigation with Mobile Dropdown --}}
    <nav class="bg-white/90 backdrop-blur-sm shadow-sm sticky top-0 z-30 border-b border-gray-100" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                {{-- Logo --}}
                <div class="flex items-center">
                    <span class="text-2xl font-bold text-primary">ELLYPESA</span>
                </div>

                {{-- Desktop Navigation Links --}}
                <div class="hidden md:flex items-center space-x-6">
                    <a href="#value" class="text-gray-700 hover:text-primary font-medium">Thamani</a>
                    <a href="#how-it-works" class="text-gray-700 hover:text-primary font-medium">Jinsi Inavyofanya</a>
                    <a href="#testimonials" class="text-gray-700 hover:text-primary font-medium">Ushuhuda</a>
                    <a href="#about" class="text-gray-700 hover:text-primary font-medium">Kuhusu</a>
                    <a href="#team" class="text-gray-700 hover:text-primary font-medium">Team Management</a>
                </div>

                {{-- Desktop Auth Buttons --}}
                <div class="hidden md:flex items-center space-x-2">
                    @guest
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-primary font-medium px-3 py-2 rounded-lg border border-gray-300 hover:border-primary transition">
                            Ingia
                        </a>
                        <a href="{{ route('register') }}" class="bg-primary hover:bg-primary-dark text-white px-5 py-2 rounded-full font-semibold transition shadow-md">
                            Jisajili
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-primary font-medium px-3 py-2">
                            <i class="fas fa-user mr-1"></i> Dashboard
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-red-600 hover:text-red-800 font-medium px-3 py-2">
                                <i class="fas fa-sign-out-alt mr-1"></i> Toka
                            </button>
                        </form>
                    @endguest
                </div>

                {{-- Mobile Hamburger Button --}}
                <div class="md:hidden flex items-center">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-700 hover:text-primary focus:outline-none">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>

            {{-- Mobile Dropdown Menu --}}
            <div x-show="mobileMenuOpen" 
                 @click.away="mobileMenuOpen = false"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-2"
                 class="md:hidden absolute top-16 left-0 right-0 bg-white border-b border-gray-200 shadow-lg z-20">
                <div class="px-4 py-3 space-y-1">
                    <a href="#value" @click="mobileMenuOpen = false" class="block px-3 py-2 text-gray-700 hover:bg-gray-50 hover:text-primary rounded-lg">Thamani</a>
                    <a href="#how-it-works" @click="mobileMenuOpen = false" class="block px-3 py-2 text-gray-700 hover:bg-gray-50 hover:text-primary rounded-lg">Jinsi Inavyofanya</a>
                    <a href="#testimonials" @click="mobileMenuOpen = false" class="block px-3 py-2 text-gray-700 hover:bg-gray-50 hover:text-primary rounded-lg">Ushuhuda</a>
                    <a href="#about" @click="mobileMenuOpen = false" class="block px-3 py-2 text-gray-700 hover:bg-gray-50 hover:text-primary rounded-lg">Kuhusu</a>
                    <a href="#team" @click="mobileMenuOpen = false" class="block px-3 py-2 text-gray-700 hover:bg-gray-50 hover:text-primary rounded-lg">Team Management</a>
                    <div class="border-t border-gray-200 my-2"></div>
                    @guest
                        <a href="{{ route('login') }}" @click="mobileMenuOpen = false" class="block px-3 py-2 text-gray-700 hover:bg-gray-50 hover:text-primary rounded-lg">Ingia</a>
                        <a href="{{ route('register') }}" @click="mobileMenuOpen = false" class="block px-3 py-2 bg-primary text-white text-center rounded-lg font-semibold hover:bg-primary-dark">Jisajili</a>
                    @else
                        <a href="{{ route('dashboard') }}" @click="mobileMenuOpen = false" class="block px-3 py-2 text-gray-700 hover:bg-gray-50 hover:text-primary rounded-lg">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}" class="block">
                            @csrf
                            <button type="submit" class="w-full text-left px-3 py-2 text-red-600 hover:bg-red-50 rounded-lg">Toka</button>
                        </form>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    {{-- Hero Section --}}
    <section class="relative min-h-[90vh] flex items-center justify-center text-white">
        <div class="absolute inset-0 z-0">
            <img src="https://images.pexels.com/photos/4491918/pexels-photo-4491918.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2" 
                 alt="African entrepreneur" 
                 class="w-full h-full object-cover object-center">
            <div class="absolute inset-0 hero-overlay"></div>
        </div>
        
        <div class="relative z-10 max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8 py-20">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight mb-6">
                Geuza Simu Yako Kuwa<br class="hidden sm:block"> Chanzo Cha Kipato Halisi
            </h1>
            <p class="text-xl md:text-2xl text-gray-200 mb-8 max-w-3xl mx-auto">
                Jifunze Affiliate Marketing, Biashara Ndogo Ndogo, Online Business & Team Building — hata kama unaanza bila uzoefu, nina ELLYPESA.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" class="bg-primary hover:bg-primary-dark text-white text-lg font-bold py-4 px-10 rounded-full shadow-xl transition transform hover:scale-105 inline-flex items-center justify-center">
                    👉 ANZA SASA (Bure)
                </a>
                <a href="#value" class="bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white border border-white/40 text-lg font-semibold py-4 px-10 rounded-full transition inline-flex items-center justify-center">
                    Jifunze Zaidi <i class="fas fa-arrow-down ml-2"></i>
                </a>
            </div>
            <p class="mt-6 text-sm md:text-base text-gray-200">
                <i class="fas fa-check-circle text-green-400 mr-1"></i> 
                Tayari watu {{ $totalUsers ?? '500' }}+ wanapata kipato kupitia mfumo wa ELLYPESA
            </p>
        </div>
    </section>

    {{-- Value Section (Dynamic Skills) --}}
    <section id="value" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Unachopata Kutoka kwa ELLYPESA</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Thamani halisi na mafunzo ya kukufanya uwe na vyanzo vingi vya kipato</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @forelse($featuredSkills as $skill)
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition border border-gray-100">
                    <div class="text-primary text-4xl mb-4">
                        @if(str_contains(strtolower($skill->name), 'affiliate'))
                            💰
                        @elseif(str_contains(strtolower($skill->name), 'biashara'))
                            🛍️
                        @elseif(str_contains(strtolower($skill->name), 'online'))
                            📱
                        @elseif(str_contains(strtolower($skill->name), 'team'))
                            👥
                        @else
                            📚
                        @endif
                    </div>
                    <h3 class="text-xl font-bold mb-3">{{ $skill->name }}</h3>
                    <p class="text-gray-600 mb-4">{{ Str::limit($skill->description, 70) }}</p>
                    <div class="mt-2 inline-block bg-primary/10 text-primary text-sm font-semibold px-3 py-1 rounded-full">
                        @if($skill->price == 0)
                            Bure
                        @else
                            Tsh {{ number_format($skill->price) }}
                        @endif
                    </div>
                </div>
                @empty
                {{-- Fallback static cards if no skills in database --}}
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition border border-gray-100">
                    <div class="text-primary text-4xl mb-4">💰</div>
                    <h3 class="text-xl font-bold mb-3">Affiliate Marketing</h3>
                    <p class="text-gray-600 mb-4">Jifunze jinsi ya kupata commission kubwa kwa kuuza bidhaa za watu wengine.</p>
                    <div class="mt-2 inline-block bg-primary/10 text-primary text-sm font-semibold px-3 py-1 rounded-full">Kuanzia Tsh 0</div>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition border border-gray-100">
                    <div class="text-primary text-4xl mb-4">🛍️</div>
                    <h3 class="text-xl font-bold mb-3">Biashara Ndogo Ndogo</h3>
                    <p class="text-gray-600 mb-4">Jifunze kuanzisha biashara yenye mtaji mdogo na kuikuza kwa hatua.</p>
                    <div class="mt-2 inline-block bg-primary/10 text-primary text-sm font-semibold px-3 py-1 rounded-full">Anza kwa Tsh 10,000</div>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition border border-gray-100">
                    <div class="text-primary text-4xl mb-4">📱</div>
                    <h3 class="text-xl font-bold mb-3">Online Business</h3>
                    <p class="text-gray-600 mb-4">Jinsi ya kutengeneza pesa mtandaoni kupitia simu yako, muda wote.</p>
                    <div class="mt-2 inline-block bg-primary/10 text-primary text-sm font-semibold px-3 py-1 rounded-full">Pata Tsh 15,000+ / wiki</div>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition border border-gray-100">
                    <div class="text-primary text-4xl mb-4">👥</div>
                    <h3 class="text-xl font-bold mb-3">Team Building</h3>
                    <p class="text-gray-600 mb-4">Jenga timu yenye nguvu inayokuingizia kipato cha kudumu na tuzo.</p>
                    <div class="mt-2 inline-block bg-primary/10 text-primary text-sm font-semibold px-3 py-1 rounded-full">Premium</div>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- How It Works (Static) --}}
    <section id="how-it-works" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Jinsi Mfumo wa ELLYPESA Unavyofanya Kazi</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Hatua 4 rahisi kuanza safari yako ya uhuru wa kifedha</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="bg-primary/10 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-3xl font-bold text-primary">1</span>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Jisajili</h3>
                    <p class="text-gray-600">Fungua akaunti yako bure na upate ufikiaji wa mafunzo ya msingi.</p>
                </div>
                <div class="text-center">
                    <div class="bg-primary/10 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-3xl font-bold text-primary">2</span>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Jifunze</h3>
                    <p class="text-gray-600">Pitia mafunzo ya video na miongozo ya PDF kwa Kiswahili fasaha.</p>
                </div>
                <div class="text-center">
                    <div class="bg-primary/10 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-3xl font-bold text-primary">3</span>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Tekeleza</h3>
                    <p class="text-gray-600">Anza biashara yako ndogo, share link, au jenga timu kwa mwongozo.</p>
                </div>
                <div class="text-center">
                    <div class="bg-primary/10 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-3xl font-bold text-primary">4</span>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Pata Kipato</h3>
                    <p class="text-gray-600">Pokea malipo yako moja kwa moja na ukuze biashara yako.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Testimonials & Ushuhuda (Dynamic) --}}
    <section id="testimonials" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Ushuhuda wa Waliofanikiwa na ELLYPESA</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Hadithi za mafanikio kutoka kwa wanachama wetu</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse($testimonials as $testimonial)
                <div class="testimonial-card bg-white p-6 rounded-xl shadow-md border border-gray-100">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center text-gray-500 mr-3 overflow-hidden">
                            @if($testimonial->image)
                                <img src="{{ asset('storage/' . $testimonial->image) }}" alt="{{ $testimonial->name }}" class="w-full h-full object-cover">
                            @else
                                <i class="fas fa-user text-xl"></i>
                            @endif
                        </div>
                        <div>
                            <h4 class="font-bold">{{ $testimonial->name }}</h4>
                            <p class="text-sm text-gray-500">{{ $testimonial->location ?? 'Tanzania' }}</p>
                        </div>
                    </div>
                    <p class="text-gray-700 mb-4">"{{ $testimonial->content }}"</p>
                    <div class="text-yellow-400">
                        @for($i=1; $i<=5; $i++)
                            <i class="fas fa-star{{ $i > $testimonial->rating ? ' text-gray-300' : '' }}"></i>
                        @endfor
                    </div>
                </div>
                @empty
                {{-- Fallback testimonials if none in DB --}}
                <div class="testimonial-card bg-white p-6 rounded-xl shadow-md border border-gray-100">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center text-gray-500 mr-3">
                            <i class="fas fa-user text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold">Faraja M.</h4>
                            <p class="text-sm text-gray-500">Mbeya</p>
                        </div>
                    </div>
                    <p class="text-gray-700 mb-4">"Nilianza biashara ya vitenge kwa mtaji wa 10,000 tu, sasa nina wateja wengi na nimeanza kuajiri. Asante ELLYPESA kwa mwongozo."</p>
                    <div class="text-yellow-400">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                </div>
                <div class="testimonial-card bg-white p-6 rounded-xl shadow-md border border-gray-100">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center text-gray-500 mr-3">
                            <i class="fas fa-user text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold">Juma K.</h4>
                            <p class="text-sm text-gray-500">Dodoma</p>
                        </div>
                    </div>
                    <p class="text-gray-700 mb-4">"Nimekuwa nikitengeneza wastani wa 15,000 kwa wiki kwa kazi za online kama data entry na affiliate. Mafunzo ni rahisi kuelewa."</p>
                    <div class="text-yellow-400">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                </div>
                <div class="testimonial-card bg-white p-6 rounded-xl shadow-md border border-gray-100">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center text-gray-500 mr-3">
                            <i class="fas fa-user text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold">Upendo N.</h4>
                            <p class="text-sm text-gray-500">Mwanza</p>
                        </div>
                    </div>
                    <p class="text-gray-700 mb-4">"Team building imenisaidia sana. Nina timu ya watu 30 na kila mmoja anapata motisha. Asante ELLYPESA."</p>
                    <div class="text-yellow-400">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                </div>
                @endforelse
            </div>
            
            {{-- Screenshots display from testimonials --}}
            @php
                $screenshots = $testimonials->whereNotNull('screenshot')->take(2);
            @endphp
            @if($screenshots->isNotEmpty())
            <div class="mt-12 flex justify-center flex-wrap gap-4">
                @foreach($screenshots as $item)
                <div class="bg-white p-3 rounded-xl shadow-lg inline-block">
                    <a href="{{ asset('storage/' . $item->screenshot) }}" target="_blank">
                        <img src="{{ asset('storage/' . $item->screenshot) }}" alt="Screenshot" class="w-64 h-40 object-cover rounded">
                    </a>
                </div>
                @endforeach
            </div>
            @else
            {{-- Fallback screenshot placeholders --}}
            <div class="mt-12 flex justify-center flex-wrap gap-4">
                <div class="bg-white p-3 rounded-xl shadow-lg inline-block">
                    <div class="bg-gray-100 w-64 h-40 rounded flex items-center justify-center text-gray-400">
                        <i class="fas fa-image text-3xl"></i>
                        <span class="ml-2">Screenshot ya Malipo</span>
                    </div>
                </div>
                <div class="bg-white p-3 rounded-xl shadow-lg inline-block">
                    <div class="bg-gray-100 w-64 h-40 rounded flex items-center justify-center text-gray-400">
                        <i class="fas fa-image text-3xl"></i>
                        <span class="ml-2">Ushuhuda WhatsApp</span>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </section>

    {{-- About ELLYPESA (Static with profile image) --}}
    <section id="about" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center gap-12">
                <div class="md:w-1/2 flex justify-center">
                    <div class="w-72 h-72 rounded-full overflow-hidden border-4 border-primary/30 shadow-xl">
                        <img src="{{ asset('pro.jpeg') }}" alt="ELLYPESA Mentor" class="w-full h-full object-cover">
                    </div>
                </div>
                <div class="md:w-1/2">
                    <h2 class="text-3xl font-bold mb-4">Habari, mimi ni <span class="text-primary">ELLYPESA</span></h2>
                    <p class="text-lg text-gray-700 mb-4">
                        Nina zaidi ya miaka 5 ya uzoefu katika biashara ndogo ndogo, online business, na ujasiriamali. 
                        Nimewasaidia mamia ya watanzania kuanzisha vyanzo vyao vya kipato bila mtaji mkubwa.
                    </p>
                    <p class="text-lg text-gray-700 mb-6">
                        Utaalam wangu ni pamoja na: <strong>biashara ndogo ndogo (kuanzia Tsh 10,000)</strong>, 
                        <strong>kutengeneza pesa online (kama Tsh 15,000+/wiki)</strong>, na mbinu nyingine za kujiongezea kipato. 
                        Niko hapa kukuongoza hatua kwa hatua hadi ufikie uhuru wa kifedha.
                    </p>
                    <div class="flex flex-wrap gap-3">
                        <span class="bg-primary/10 text-primary px-4 py-2 rounded-full text-sm font-semibold"><i class="fas fa-check mr-1"></i> Biashara Ndogo</span>
                        <span class="bg-primary/10 text-primary px-4 py-2 rounded-full text-sm font-semibold"><i class="fas fa-check mr-1"></i> Online Business</span>
                        <span class="bg-primary/10 text-primary px-4 py-2 rounded-full text-sm font-semibold"><i class="fas fa-check mr-1"></i> Hustle Ideas</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Team Management (Premium Content with Dynamic Courses) --}}
    <section id="team" class="py-20 bg-gradient-to-br from-gray-900 to-gray-800 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14">
                <div class="inline-block bg-primary/20 text-primary px-4 py-1 rounded-full text-sm font-semibold mb-4">🔒 PREMIUM CONTENT</div>
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Mafunzo ya Team Management & Leadership</h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                    🧠 "Kama hujui kuongoza team, huwezi kukuza biashara"
                </p>
            </div>
            
            {{-- Four pillars (static) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 max-w-6xl mx-auto">
                <div class="bg-gray-800/50 backdrop-blur-sm p-6 rounded-2xl border border-gray-700 hover:border-primary/50 transition">
                    <div class="text-primary text-3xl mb-3"><i class="fas fa-crown"></i></div>
                    <h3 class="text-xl font-bold mb-3">Uongozi (Leadership)</h3>
                    <p class="text-gray-300 text-sm">Jifunze kuwa kiongozi bora anayeweza kuhamasisha na kusimamia timu kwa ufanisi.</p>
                </div>
                <div class="bg-gray-800/50 backdrop-blur-sm p-6 rounded-2xl border border-gray-700 hover:border-primary/50 transition">
                    <div class="text-primary text-3xl mb-3"><i class="fas fa-users"></i></div>
                    <h3 class="text-xl font-bold mb-3">Kujenga Timu (Team Building)</h3>
                    <p class="text-gray-300 text-sm">Mbinu za kuvutia, kuchagua na kuwahifadhi wanachama bora katika timu yako.</p>
                </div>
                <div class="bg-gray-800/50 backdrop-blur-sm p-6 rounded-2xl border border-gray-700 hover:border-primary/50 transition">
                    <div class="text-primary text-3xl mb-3"><i class="fas fa-chart-line"></i></div>
                    <h3 class="text-xl font-bold mb-3">Kuongeza Mauzo</h3>
                    <p class="text-gray-300 text-sm">Mikakati ya kuongeza mauzo na mapato ya timu nzima kwa kutumia mbinu za kisasa.</p>
                </div>
                <div class="bg-gray-800/50 backdrop-blur-sm p-6 rounded-2xl border border-gray-700 hover:border-primary/50 transition">
                    <div class="text-primary text-3xl mb-3"><i class="fas fa-fire"></i></div>
                    <h3 class="text-xl font-bold mb-3">Motisha ya Timu</h3>
                    <p class="text-gray-300 text-sm">Jinsi ya kuwapa motisha wanachama ili wawe na ari ya kufanya kazi na kufikia malengo.</p>
                </div>
            </div>

            {{-- Two main paid courses (Dynamic from $teamSkills) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto mt-12">
                @forelse($teamSkills as $skill)
                <div class="bg-gray-800/50 backdrop-blur-sm p-8 rounded-2xl border border-gray-700 hover:border-primary/50 transition">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-2xl font-bold">{{ $skill->name }}</h3>
                        <span class="lock-icon"><i class="fas fa-lock text-primary"></i></span>
                    </div>
                    @php
                        $points = $skill->description ? explode(',', $skill->description) : ['Mbinu za kina za kujifunza'];
                    @endphp
                    <ul class="space-y-2 text-gray-300 mb-6">
                        @foreach($points as $point)
                            @if(trim($point))
                            <li><i class="fas fa-check text-primary mr-2"></i> {{ trim($point) }}</li>
                            @endif
                        @endforeach
                    </ul>
                    <div class="flex items-center justify-between">
                        <span class="text-3xl font-bold text-primary">Tsh {{ number_format($skill->price) }}</span>
                        @auth
                            <a href="{{ route('user.payment.create', $skill->id ?? 1) }}" class="bg-primary hover:bg-primary-dark px-6 py-3 rounded-lg font-semibold transition">
                                Pata Sasa <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="bg-primary hover:bg-primary-dark px-6 py-3 rounded-lg font-semibold transition">
                                Pata Sasa <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        @endauth
                    </div>
                </div>
                @empty
                {{-- Fallback course cards --}}
                <div class="bg-gray-800/50 backdrop-blur-sm p-8 rounded-2xl border border-gray-700 hover:border-primary/50 transition">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-2xl font-bold">Kozi: Jinsi ya Kujenga Team Yenye Nguvu</h3>
                        <span class="lock-icon"><i class="fas fa-lock text-primary"></i></span>
                    </div>
                    <ul class="space-y-2 text-gray-300 mb-6">
                        <li><i class="fas fa-check text-primary mr-2"></i> Mbinu za kuvutia wanachama bora</li>
                        <li><i class="fas fa-check text-primary mr-2"></i> Kuweka malengo na kufuatilia</li>
                        <li><i class="fas fa-check text-primary mr-2"></i> Kuunda utamaduni wa timu</li>
                    </ul>
                    <div class="flex items-center justify-between">
                        <span class="text-3xl font-bold text-primary">Tsh 20,000</span>
                        <a href="{{ route('register') }}" class="bg-primary hover:bg-primary-dark px-6 py-3 rounded-lg font-semibold transition">
                            Pata Sasa <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
                <div class="bg-gray-800/50 backdrop-blur-sm p-8 rounded-2xl border border-gray-700 hover:border-primary/50 transition">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-2xl font-bold">Kozi: Mbinu za Kuongeza Performance ya Team</h3>
                        <span class="lock-icon"><i class="fas fa-lock text-primary"></i></span>
                    </div>
                    <ul class="space-y-2 text-gray-300 mb-6">
                        <li><i class="fas fa-check text-primary mr-2"></i> Kuongeza mauzo kwa timu kubwa</li>
                        <li><i class="fas fa-check text-primary mr-2"></i> Mawasiliano bora na migogoro</li>
                        <li><i class="fas fa-check text-primary mr-2"></i> Motisha na tija</li>
                    </ul>
                    <div class="flex items-center justify-between">
                        <span class="text-3xl font-bold text-primary">Tsh 25,000</span>
                        <a href="{{ route('register') }}" class="bg-primary hover:bg-primary-dark px-6 py-3 rounded-lg font-semibold transition">
                            Pata Sasa <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
                @endforelse
            </div>
            <p class="text-center text-gray-400 mt-8 text-sm">🔒 Kila somo linafunguka baada ya malipo. Jisajili kwanza ili kupata ufikiaji.</p>
        </div>
    </section>

    {{-- Quick Signup / Register CTA --}}
    <section id="signup" class="py-20 bg-white">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="bg-gray-50 rounded-2xl p-10 shadow-xl border border-gray-100">
                <h2 class="text-3xl font-bold text-gray-900 mb-3">Uko Tayari Kubadilisha Maisha Yako?</h2>
                <p class="text-xl text-gray-600 mb-6">Jiunge na ELLYPESA Community leo na upate ufikiaji wa mafunzo, miongozo, na msaada wa moja kwa moja.</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('register') }}" class="bg-primary hover:bg-primary-dark text-white text-lg font-bold py-4 px-10 rounded-full shadow-lg transition transform hover:scale-105">
                        👉 JISAIJILI SASA (BURE)
                    </a>
                    <a href="{{ route('login') }}" class="border-2 border-primary text-primary hover:bg-primary hover:text-white text-lg font-bold py-4 px-10 rounded-full transition">
                        Tayari Una Akaunti? Ingia
                    </a>
                </div>
                <p class="mt-4 text-sm text-gray-500">Baada ya kujisajili, utapata ufikiaji wa mafunzo ya msingi na utaunganishwa WhatsApp.</p>
            </div>
        </div>
    </section>

    {{-- WhatsApp Funnel CTA --}}
    <section class="py-12 bg-gradient-to-r from-primary to-primary-dark text-orange">
        <div class="max-w-4xl mx-auto text-center px-4">
            <i class="fab fa-whatsapp text-5xl mb-4"></i>
            <h3 class="text-2xl md:text-3xl font-bold mb-4">📲 Piga nasi WhatsApp kwa msaada wa haraka</h3>
            <a href="https://wa.me/255678043562?text=Habari%20ELLYPESA%2C%20nahitaji%20maelekezo%20zaidi." 
               target="_blank"
               class="inline-block bg-white text-primary hover:bg-gray-100 text-lg font-bold py-4 px-10 rounded-full shadow-lg transition transform hover:scale-105">
                0678 043 562 <i class="fab fa-whatsapp ml-2"></i>
            </a>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-gray-400 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="mb-2">&copy; {{ date('Y') }} ELLYPESA. Haki zote zimehifadhiwa.</p>
            <p class="text-sm">Geuza Simu Yako Kuwa Chanzo Cha Kipato Halisi.</p>
        </div>
    </footer>

    {{-- Smooth scroll script --}}
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href === "#" || href === "") return;
                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
    </script>
</body>
</html>