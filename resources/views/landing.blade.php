{{-- resources/views/landing.blade.php --}}
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>ELLYPESA | Build Income, Grow Mindset & Become Confident</title>
    <meta name="description" content="Learn Digital Marketing, Entrepreneurship, and Team Performance with CEO ELLYPESA. Practical skills to build income and lead teams.">
    
    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    {{-- Alpine.js for mobile menu --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        /* Custom styles */
        .hero-overlay {
            background: linear-gradient(135deg, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.6) 100%);
        }
        .text-primary { color: #FF6F00; }
        .bg-primary { background-color: #FF6F00; }
        .bg-primary-dark { background-color: #E65100; }
        .border-primary { border-color: #FF6F00; }
        .hover\:bg-primary-dark:hover { background-color: #E65100; }
        .ring-primary { --tw-ring-color: #FF6F00; }
        html { scroll-behavior: smooth; }
        
        /* Card hover effects */
        .feature-card, .testimonial-card, .learn-card, .why-card {
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }
        .feature-card:hover, .learn-card:hover, .why-card:hover, .testimonial-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -12px rgba(0,0,0,0.15);
        }
        
        /* WhatsApp float button */
        .whatsapp-float {
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            transition: all 0.2s ease;
        }
        
        /* Loader overlay */
        #page-loader, #navigation-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: white;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.4s ease;
        }
        #navigation-loader {
            z-index: 10000;
        }
        
        /* Spinner animation */
        .spinner {
            width: 48px;
            height: 48px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #FF6F00;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Mobile text adjustments */
        @media (max-width: 640px) {
            h1 { font-size: 2rem !important; line-height: 1.3 !important; }
            h2 { font-size: 1.75rem !important; }
            .hero-buttons a { padding: 0.75rem 1.5rem !important; font-size: 1rem !important; }
        }
        
        /* Fade-in animation */
        .fade-up {
            animation: fadeUp 0.6s ease-out forwards;
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Language switcher button */
        .lang-btn {
            transition: all 0.2s;
        }
        .lang-btn.active {
            background-color: #FF6F00;
            color: white;
            border-color: #FF6F00;
        }
    </style>
</head>
<body class="bg-white text-gray-800 font-sans antialiased">

    {{-- PRELOADER on initial page load --}}
    <div id="page-loader">
        <div class="text-center px-6">
            <div class="w-32 h-32 rounded-full overflow-hidden mx-auto mb-5 border-4 border-primary shadow-xl">
                <img src="{{ asset('pro.jpeg') }}" alt="CEO ELLYPESA" class="w-full h-full object-cover">
            </div>
            <h3 class="text-2xl font-bold text-gray-800">CEO ELLYPESA</h3>
            <p class="text-primary font-semibold mt-1" data-i18n="mentor_tagline">Entrepreneur Mentor | Digital Strategist</p>
            <div class="spinner mt-5"></div>
            <p class="text-gray-600 mt-4 max-w-xs mx-auto" data-i18n="loader_bio">I help you build income through Digital Marketing, develop Entrepreneurship Skills, and improve Team Performance.</p>
        </div>
    </div>

    {{-- MAIN PAGE CONTENT --}}
    <div id="main-content" style="display: none;">
        
        {{-- Sticky WhatsApp Button --}}
        <a href="https://wa.me/255626549262?text=Habari%20ELLYPESA%2C%20napenda%20kujua%20zaidi%20kuhusu%20mafunzo%20yako." 
           target="_blank" 
           class="whatsapp-float fixed bottom-6 right-6 z-50 bg-green-500 text-white p-3 rounded-full shadow-lg hover:bg-green-600 transition-all duration-300 flex items-center justify-center w-12 h-12 md:w-auto md:h-auto md:px-5 md:py-3 md:rounded-full"
           aria-label="Chat on WhatsApp">
            <i class="fab fa-whatsapp text-xl md:mr-2"></i>
            <span class="hidden md:inline font-medium text-sm">0626 549 262</span>
        </a>

        {{-- Mobile Sticky CTA --}}
        <div class="fixed bottom-6 left-4 right-4 z-40 md:hidden">
            <a href="#signup" class="bg-primary hover:bg-primary-dark text-white font-bold py-3 px-5 rounded-xl shadow-xl text-center block transition-all duration-300 text-sm register-trigger">
                👉 JIUNGE SASA | ANZA SAFARI
            </a>
        </div>

        {{-- Navigation --}}
        <nav class="bg-white/90 backdrop-blur-sm shadow-sm sticky top-0 z-30 border-b border-gray-100" x-data="{ mobileMenuOpen: false }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center">
                        <span class="text-2xl font-bold text-primary">ELLYPESA</span>
                    </div>

                    {{-- Desktop Navigation --}}
                    <div class="hidden md:flex items-center space-x-5">
                        <a href="#overview" class="text-gray-700 hover:text-primary font-medium text-sm" data-i18n="nav_overview">Overview</a>
                        <a href="#learn" class="text-gray-700 hover:text-primary font-medium text-sm" data-i18n="nav_learn">Learn</a>
                        <a href="#why-choose" class="text-gray-700 hover:text-primary font-medium text-sm" data-i18n="nav_why">Why Us</a>
                        <a href="#testimonials" class="text-gray-700 hover:text-primary font-medium text-sm" data-i18n="nav_success">Success</a>
                        <a href="#team" class="text-gray-700 hover:text-primary font-medium text-sm" data-i18n="nav_team">Team Mgmt</a>
                    </div>

                    {{-- Desktop Auth & Language --}}
                    <div class="hidden md:flex items-center space-x-3">
                        {{-- Language Switcher --}}
                        <div class="flex space-x-1 bg-gray-100 rounded-full p-1">
                            <button class="lang-btn text-xs px-3 py-1 rounded-full transition font-medium active" data-lang="sw">SW</button>
                            <button class="lang-btn text-xs px-3 py-1 rounded-full transition font-medium" data-lang="en">EN</button>
                        </div>
                        @guest
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-primary font-medium px-3 py-2 rounded-lg text-sm register-trigger" data-i18n="login">Ingia</a>
                            <a href="{{ route('register') }}" class="bg-primary hover:bg-primary-dark text-white px-5 py-2 rounded-full font-semibold transition shadow-md text-sm register-trigger" data-i18n="register">Jisajili</a>
                        @else
                            <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-primary font-medium px-3 py-2 text-sm"><i class="fas fa-user mr-1"></i> Dashboard</a>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium px-3 py-2 text-sm"><i class="fas fa-sign-out-alt mr-1"></i> Toka</button>
                            </form>
                        @endguest
                    </div>

                    {{-- Mobile Hamburger --}}
                    <div class="md:hidden flex items-center space-x-3">
                        <div class="flex space-x-1 bg-gray-100 rounded-full p-1">
                            <button class="lang-btn text-xs px-2 py-1 rounded-full transition font-medium active" data-lang="sw">SW</button>
                            <button class="lang-btn text-xs px-2 py-1 rounded-full transition font-medium" data-lang="en">EN</button>
                        </div>
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
                     class="md:hidden absolute top-16 left-0 right-0 bg-white border-b border-gray-200 shadow-lg z-20">
                    <div class="px-4 py-3 space-y-1">
                        <a href="#overview" @click="mobileMenuOpen = false" class="block px-3 py-2 text-gray-700 hover:bg-gray-50 rounded-lg text-sm" data-i18n="nav_overview">Overview</a>
                        <a href="#learn" @click="mobileMenuOpen = false" class="block px-3 py-2 text-gray-700 hover:bg-gray-50 rounded-lg text-sm" data-i18n="nav_learn">What You'll Learn</a>
                        <a href="#why-choose" @click="mobileMenuOpen = false" class="block px-3 py-2 text-gray-700 hover:bg-gray-50 rounded-lg text-sm" data-i18n="nav_why">Why Choose CEO</a>
                        <a href="#testimonials" @click="mobileMenuOpen = false" class="block px-3 py-2 text-gray-700 hover:bg-gray-50 rounded-lg text-sm" data-i18n="nav_success">Ushuhuda</a>
                        <a href="#team" @click="mobileMenuOpen = false" class="block px-3 py-2 text-gray-700 hover:bg-gray-50 rounded-lg text-sm" data-i18n="nav_team">Team Performance</a>
                        <div class="border-t border-gray-200 my-2"></div>
                        @guest
                            <a href="{{ route('login') }}" @click="mobileMenuOpen = false" class="block px-3 py-2 text-gray-700 hover:bg-gray-50 rounded-lg register-trigger" data-i18n="login">Ingia</a>
                            <a href="{{ route('register') }}" @click="mobileMenuOpen = false" class="block px-3 py-2 bg-primary text-white text-center rounded-lg font-semibold register-trigger" data-i18n="register">Jisajili</a>
                        @else
                            <a href="{{ route('dashboard') }}" @click="mobileMenuOpen = false" class="block px-3 py-2 text-gray-700 rounded-lg">Dashboard</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-3 py-2 text-red-600 rounded-lg">Toka</button>
                            </form>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>

        {{-- Hero Section --}}
        <section class="relative min-h-[85vh] flex items-center justify-center text-white">
            <div class="absolute inset-0 z-0">
                <img src="https://images.pexels.com/photos/4491918/pexels-photo-4491918.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2" 
                     alt="Entrepreneur" class="w-full h-full object-cover object-center">
                <div class="absolute inset-0 hero-overlay"></div>
            </div>
            <div class="relative z-10 max-w-4xl mx-auto text-center px-4 sm:px-6 py-12 md:py-20">
                <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight mb-5" data-i18n="hero_title">
                    Build Income, Grow Mindset,<br> Become Confident
                </h1>
                <p class="text-lg md:text-2xl text-gray-100 mb-6 max-w-2xl mx-auto" data-i18n="hero_sub">
                    Master Digital Marketing, Entrepreneurship & Team Performance with <strong class="text-primary">CEO ELLYPESA</strong>
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center hero-buttons">
                    <a href="{{ route('register') }}" class="bg-primary hover:bg-primary-dark text-white font-bold py-3 px-6 md:py-4 md:px-8 rounded-full shadow-xl transition transform hover:scale-105 inline-flex items-center justify-center text-base register-trigger" data-i18n="hero_cta_start">
                        👉 START YOUR JOURNEY (Free)
                    </a>
                    <a href="#overview" class="bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white border border-white/40 font-semibold py-3 px-6 md:py-4 md:px-8 rounded-full transition inline-flex items-center justify-center text-base" data-i18n="hero_cta_discover">
                        Discover More <i class="fas fa-arrow-down ml-2"></i>
                    </a>
                </div>
                <p class="mt-5 text-sm text-gray-200">
                    <i class="fas fa-check-circle text-green-400 mr-1"></i> 
                    <span data-i18n="users_count_prefix">Already</span> {{ $totalUsers ?? '500' }}+ <span data-i18n="users_count_suffix">members earning with ELLYPESA</span>
                </p>
            </div>
        </section>

        {{-- Overview Section --}}
        <section id="overview" class="py-16 bg-white fade-up">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-10">
                    <span class="bg-primary/10 text-primary px-4 py-1 rounded-full text-sm font-semibold" data-i18n="overview_badge">The Challenge</span>
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mt-3" data-i18n="overview_title">From Zero Guidance to Real Results</h2>
                </div>
                <div class="grid md:grid-cols-2 gap-8 items-center">
                    <div class="bg-red-50 p-6 rounded-2xl border-l-4 border-red-400">
                        <i class="fas fa-frown text-red-500 text-3xl mb-3"></i>
                        <h3 class="text-xl font-bold text-gray-800 mb-2" data-i18n="problem_title">The Problem</h3>
                        <p class="text-gray-700" data-i18n="problem_text">Many people want online success and financial freedom but lack clear guidance, mentorship, and practical systems. They get stuck with theory and no real income.</p>
                    </div>
                    <div class="bg-green-50 p-6 rounded-2xl border-l-4 border-primary">
                        <i class="fas fa-lightbulb text-primary text-3xl mb-3"></i>
                        <h3 class="text-xl font-bold text-gray-800 mb-2" data-i18n="solution_title">CEO ELLYPESA's Solution</h3>
                        <p class="text-gray-700" data-i18n="solution_text">A clear, actionable path through Digital Marketing, Entrepreneurship Skills, and Team Performance. Practical knowledge, real support, and direction to succeed in the digital economy.</p>
                    </div>
                </div>
                <div class="mt-8 text-center bg-gray-50 p-6 rounded-xl">
                    <p class="text-gray-700 text-lg" data-i18n="overview_quote"><i class="fas fa-quote-left text-primary mr-2"></i> Practical knowledge, support, and direction to succeed in the digital economy — that's the ELLYPESA promise.</p>
                </div>
            </div>
        </section>

        {{-- What You Will Learn --}}
        <section id="learn" class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900" data-i18n="learn_title">What You Will Learn</h2>
                    <p class="text-gray-600 mt-2 text-lg" data-i18n="learn_sub">Practical skills that generate real income</p>
                </div>
                <div class="grid md:grid-cols-3 gap-6">
                    <div class="learn-card bg-white p-6 rounded-xl shadow-md border border-gray-100">
                        <div class="w-14 h-14 bg-primary/10 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-chart-line text-primary text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2" data-i18n="learn_dm_title">Digital Marketing</h3>
                        <p class="text-gray-600 mb-3" data-i18n="learn_dm_text">How to make money online using social media, affiliate marketing, and digital strategies — even with just your phone.</p>
                        <span class="text-primary text-sm font-semibold" data-i18n="learn_dm_tag">→ Build passive income</span>
                    </div>
                    <div class="learn-card bg-white p-6 rounded-xl shadow-md border border-gray-100">
                        <div class="w-14 h-14 bg-primary/10 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-store text-primary text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2" data-i18n="learn_ent_title">Entrepreneurship</h3>
                        <p class="text-gray-600 mb-3" data-i18n="learn_ent_text">How to build a business from scratch, manage small capital, and scale your ideas into sustainable income.</p>
                        <span class="text-primary text-sm font-semibold" data-i18n="learn_ent_tag">→ Start & grow your venture</span>
                    </div>
                    <div class="learn-card bg-white p-6 rounded-xl shadow-md border border-gray-100">
                        <div class="w-14 h-14 bg-primary/10 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-users text-primary text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2" data-i18n="learn_team_title">Team Performance</h3>
                        <p class="text-gray-600 mb-3" data-i18n="learn_team_text">How to lead, manage, and motivate teams to hit targets, boost sales, and create scalable success.</p>
                        <span class="text-primary text-sm font-semibold" data-i18n="learn_team_tag">→ Multiply your impact</span>
                    </div>
                </div>
            </div>
        </section>

        {{-- Why Choose CEO ELLYPESA --}}
        <section id="why-choose" class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-10">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900" data-i18n="why_title">Why Choose CEO ELLYPESA</h2>
                    <p class="text-gray-600 mt-2" data-i18n="why_sub">A mentor who delivers results, not just motivation</p>
                </div>
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="why-card bg-gray-50 p-5 rounded-xl text-center">
                        <i class="fas fa-graduation-cap text-primary text-3xl mb-3"></i>
                        <h3 class="font-bold text-lg" data-i18n="why_simple_title">Simple & Practical</h3>
                        <p class="text-gray-600 text-sm" data-i18n="why_simple_text">No fluff, only actionable lessons you can apply immediately.</p>
                    </div>
                    <div class="why-card bg-gray-50 p-5 rounded-xl text-center">
                        <i class="fas fa-road text-primary text-3xl mb-3"></i>
                        <h3 class="font-bold text-lg" data-i18n="why_step_title">Step-by-Step Guidance</h3>
                        <p class="text-gray-600 text-sm" data-i18n="why_step_text">From zero to income — clear roadmap with personal support.</p>
                    </div>
                    <div class="why-card bg-gray-50 p-5 rounded-xl text-center">
                        <i class="fas fa-headset text-primary text-3xl mb-3"></i>
                        <h3 class="font-bold text-lg" data-i18n="why_support_title">Real Support System</h3>
                        <p class="text-gray-600 text-sm" data-i18n="why_support_text">Active community, WhatsApp support, and mentor access.</p>
                    </div>
                    <div class="why-card bg-gray-50 p-5 rounded-xl text-center">
                        <i class="fas fa-chart-simple text-primary text-3xl mb-3"></i>
                        <h3 class="font-bold text-lg" data-i18n="why_results_title">Focus on Results</h3>
                        <p class="text-gray-600 text-sm" data-i18n="why_results_text">We measure success by your income growth, not theory.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Value Section (Dynamic Skills from DB) --}}
        <section id="value" class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-10">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900" data-i18n="value_title">Income Opportunities We Offer</h2>
                    <p class="text-gray-600" data-i18n="value_sub">Start with what fits your passion</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @forelse($featuredSkills as $skill)
                    <div class="feature-card bg-white p-6 rounded-xl shadow-md border border-gray-100">
                        <div class="text-primary text-3xl mb-3">
                            @if(str_contains(strtolower($skill->name), 'affiliate')) 💰
                            @elseif(str_contains(strtolower($skill->name), 'biashara')) 🛍️
                            @elseif(str_contains(strtolower($skill->name), 'online')) 📱
                            @elseif(str_contains(strtolower($skill->name), 'team')) 👥
                            @else 📚
                            @endif
                        </div>
                        <h3 class="text-lg font-bold mb-2">{{ $skill->name }}</h3>
                        <p class="text-gray-600 text-sm mb-3">{{ Str::limit($skill->description, 60) }}</p>
                        <span class="inline-block bg-primary/10 text-primary text-xs font-semibold px-2 py-1 rounded-full">
                            @if($skill->price == 0) Free @else Tsh {{ number_format($skill->price) }} @endif
                        </span>
                    </div>
                    @empty
                    <div class="feature-card bg-white p-6 rounded-xl shadow-md"><div class="text-primary text-3xl">💰</div><h3 class="font-bold">Affiliate Marketing</h3><p class="text-sm">Earn commissions by promoting products.</p></div>
                    <div class="feature-card bg-white p-6 rounded-xl shadow-md"><div class="text-primary text-3xl">🛍️</div><h3 class="font-bold">Small Business</h3><p class="text-sm">Start with low capital and grow.</p></div>
                    <div class="feature-card bg-white p-6 rounded-xl shadow-md"><div class="text-primary text-3xl">📱</div><h3 class="font-bold">Online Business</h3><p class="text-sm">Make money using your phone.</p></div>
                    <div class="feature-card bg-white p-6 rounded-xl shadow-md"><div class="text-primary text-3xl">👥</div><h3 class="font-bold">Team Building</h3><p class="text-sm">Build and lead winning teams.</p></div>
                    @endforelse
                </div>
            </div>
        </section>

        {{-- Testimonials Section --}}
        <section id="testimonials" class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-10">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900" data-i18n="testimonial_title">Success Stories</h2>
                    <p class="text-gray-600" data-i18n="testimonial_sub">Real people, real income transformations</p>
                </div>
                <div class="grid md:grid-cols-3 gap-6">
                    @forelse($testimonials as $testimonial)
                    <div class="testimonial-card bg-gray-50 p-5 rounded-xl shadow-sm">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center mr-3 overflow-hidden">
                                @if($testimonial->image) <img src="{{ asset('storage/' . $testimonial->image) }}" class="w-full h-full object-cover"> @else <i class="fas fa-user text-gray-500"></i> @endif
                            </div>
                            <div><h4 class="font-bold text-sm">{{ $testimonial->name }}</h4><p class="text-xs text-gray-500">{{ $testimonial->location ?? 'Tanzania' }}</p></div>
                        </div>
                        <p class="text-gray-700 text-sm mb-3">"{{ Str::limit($testimonial->content, 100) }}"</p>
                        <div class="text-yellow-400 text-xs">★★★★★</div>
                    </div>
                    @empty
                    <div class="testimonial-card bg-gray-50 p-5 rounded-xl"><div class="flex items-center"><div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center mr-3"><i class="fas fa-user"></i></div><div><h4 class="font-bold">Faraja M.</h4><p class="text-xs">Mbeya</p></div></div><p class="text-sm mt-2">"Started small business, now earning steady income weekly!"</p></div>
                    <div class="testimonial-card bg-gray-50 p-5 rounded-xl"><div class="flex items-center"><div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center mr-3"><i class="fas fa-user"></i></div><div><h4 class="font-bold">Juma K.</h4><p class="text-xs">Dodoma</p></div></div><p class="text-sm mt-2">"Online work changed my life, thank you ELLYPESA."</p></div>
                    <div class="testimonial-card bg-gray-50 p-5 rounded-xl"><div class="flex items-center"><div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center mr-3"><i class="fas fa-user"></i></div><div><h4 class="font-bold">Upendo N.</h4><p class="text-xs">Mwanza</p></div></div><p class="text-sm mt-2">"Team management training helped me lead 30+ members."</p></div>
                    @endforelse
                </div>
            </div>
        </section>

        {{-- Team Management Premium Section --}}
        <section id="team" class="py-16 bg-gradient-to-br from-gray-900 to-gray-800 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-10">
                    <div class="inline-block bg-primary/20 text-primary px-3 py-1 rounded-full text-xs font-semibold mb-2" data-i18n="team_badge">🔥 PREMIUM MASTERY</div>
                    <h2 class="text-2xl md:text-3xl font-bold" data-i18n="team_title">Team Performance & Leadership</h2>
                    <p class="text-gray-300 text-sm" data-i18n="team_sub">Unlock advanced strategies to lead, scale, and dominate</p>
                </div>
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
                    <div class="bg-gray-800/50 p-4 rounded-xl text-center"><i class="fas fa-crown text-primary text-2xl mb-2"></i><h3 class="font-bold" data-i18n="team_card1_title">Leadership</h3><p class="text-xs text-gray-300" data-i18n="team_card1_text">Inspire & guide teams</p></div>
                    <div class="bg-gray-800/50 p-4 rounded-xl text-center"><i class="fas fa-users text-primary text-2xl mb-2"></i><h3 class="font-bold" data-i18n="team_card2_title">Team Building</h3><p class="text-xs text-gray-300" data-i18n="team_card2_text">Attract top members</p></div>
                    <div class="bg-gray-800/50 p-4 rounded-xl text-center"><i class="fas fa-chart-line text-primary text-2xl mb-2"></i><h3 class="font-bold" data-i18n="team_card3_title">Sales Growth</h3><p class="text-xs text-gray-300" data-i18n="team_card3_text">Increase team revenue</p></div>
                    <div class="bg-gray-800/50 p-4 rounded-xl text-center"><i class="fas fa-fire text-primary text-2xl mb-2"></i><h3 class="font-bold" data-i18n="team_card4_title">Motivation</h3><p class="text-xs text-gray-300" data-i18n="team_card4_text">Drive performance</p></div>
                </div>
                <div class="grid md:grid-cols-2 gap-6 max-w-4xl mx-auto">
                    @forelse($teamSkills as $skill)
                    <div class="bg-gray-800/60 p-6 rounded-xl border border-gray-700">
                        <div class="flex justify-between items-start"><h3 class="text-xl font-bold">{{ $skill->name }}</h3><i class="fas fa-lock text-primary"></i></div>
                        <ul class="text-sm text-gray-300 my-3 space-y-1">
                            @php $points = explode(',', $skill->description ?? 'Advanced tactics,Real case studies'); @endphp
                            @foreach(array_slice($points,0,2) as $point)<li><i class="fas fa-check text-primary mr-1"></i> {{ trim($point) }}</li>@endforeach
                        </ul>
                        <div class="flex justify-between items-center mt-3"><span class="text-2xl font-bold text-primary">Tsh {{ number_format($skill->price) }}</span>@auth<a href="{{ route('user.payment.create', $skill->id) }}" class="bg-primary px-4 py-2 rounded-lg text-sm font-semibold register-trigger">Enroll</a>@else<a href="{{ route('register') }}" class="bg-primary px-4 py-2 rounded-lg text-sm register-trigger" data-i18n="team_enroll">Join to Access</a>@endauth</div>
                    </div>
                    @empty
                    <div class="bg-gray-800/60 p-6 rounded-xl"><div class="flex justify-between"><h3 class="font-bold">Team Building Mastery</h3><i class="fas fa-lock"></i></div><ul class="text-sm mt-2"><li><i class="fas fa-check text-primary"></i> Recruitment strategies</li><li><i class="fas fa-check text-primary"></i> Retention systems</li></ul><div class="flex justify-between mt-3"><span class="text-2xl font-bold text-primary">Tsh 20,000</span><a href="{{ route('register') }}" class="bg-primary px-4 py-2 rounded-lg text-sm register-trigger">Get Access</a></div></div>
                    <div class="bg-gray-800/60 p-6 rounded-xl"><div class="flex justify-between"><h3 class="font-bold">Performance Booster</h3><i class="fas fa-lock"></i></div><ul class="text-sm mt-2"><li><i class="fas fa-check text-primary"></i> Sales funnels</li><li><i class="fas fa-check text-primary"></i> Team communication</li></ul><div class="flex justify-between mt-3"><span class="text-2xl font-bold text-primary">Tsh 25,000</span><a href="{{ route('register') }}" class="bg-primary px-4 py-2 rounded-lg text-sm register-trigger">Get Access</a></div></div>
                    @endforelse
                </div>
                <p class="text-center text-gray-400 text-xs mt-6" data-i18n="team_footer">🔒 Premium content unlocks after payment. Register to begin.</p>
            </div>
        </section>

        {{-- About CEO Short Section --}}
        <section id="about" class="py-16 bg-white">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center gap-8">
                <div class="w-40 h-40 md:w-56 md:h-56 rounded-full overflow-hidden border-4 border-primary/30 shadow-xl">
                    <img src="{{ asset('pro.jpeg') }}" alt="CEO ELLYPESA" class="w-full h-full object-cover">
                </div>
                <div class="text-center md:text-left">
                    <h2 class="text-2xl font-bold">CEO <span class="text-primary">ELLYPESA</span></h2>
                    <p class="text-primary font-semibold" data-i18n="mentor_tagline">Entrepreneur Mentor | Digital Strategist</p>
                    <p class="text-gray-700 mt-3 max-w-lg" data-i18n="about_bio">I help people build income, grow ideas, and become strong leaders using practical skills. My purpose is to empower you with digital marketing, entrepreneurship, and team performance strategies that actually work in the real world.</p>
                    <div class="flex gap-2 mt-4 justify-center md:justify-start"><span class="bg-primary/10 text-primary px-3 py-1 rounded-full text-xs"><i class="fas fa-check"></i> 5+ Years Experience</span><span class="bg-primary/10 text-primary px-3 py-1 rounded-full text-xs"><i class="fas fa-check"></i> 500+ Students</span></div>
                </div>
            </div>
        </section>

        {{-- Call to Action + Bonus --}}
        <section id="signup" class="py-16 bg-gradient-to-r from-primary/10 to-primary/5">
            <div class="max-w-3xl mx-auto text-center px-4">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900" data-i18n="cta_title">Ready to Change Your Life?</h2>
                <p class="text-gray-700 mt-2 text-lg" data-i18n="cta_text">Join the ELLYPESA community today — learn, earn, and grow continuously.</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center mt-6">
                    <a href="{{ route('register') }}" class="bg-primary hover:bg-primary-dark text-white font-bold py-3 px-8 rounded-full shadow-lg transition transform hover:scale-105 register-trigger" data-i18n="cta_button_join">👉 JOIN NOW (FREE)</a>
                    <a href="{{ route('login') }}" class="border-2 border-primary text-primary hover:bg-primary hover:text-white font-bold py-3 px-8 rounded-full transition register-trigger" data-i18n="cta_button_login">Already a Member? Login</a>
                </div>
                <div class="mt-6 bg-yellow-50 p-4 rounded-xl inline-block">
                    <p class="text-gray-800"><i class="fas fa-gift text-primary mr-2"></i> <strong data-i18n="bonus_title">Bonus:</strong> <span data-i18n="bonus_text">Join the community and get instant access to weekly coaching + WhatsApp support group.</span></p>
                </div>
            </div>
        </section>

        {{-- WhatsApp CTA Bar --}}
        <section class="py-8 bg-primary text-white">
            <div class="max-w-4xl mx-auto text-center px-4">
                <i class="fab fa-whatsapp text-3xl mb-2"></i>
                <h3 class="text-xl font-bold" data-i18n="whatsapp_title">Need Help? Chat with us on WhatsApp</h3>
                <a href="https://wa.me/255626549262" target="_blank" class="inline-block bg-white text-primary px-6 py-2 rounded-full font-bold mt-3 shadow-md">0678 043 562 → Click to Message</a>
            </div>
        </section>

        {{-- Footer --}}
        <footer class="bg-gray-900 text-gray-400 py-8 text-center text-sm">
            <p>&copy; {{ date('Y') }} ELLYPESA. All rights reserved.</p>
            <p class="mt-1" data-i18n="footer_tagline">Build Income, Grow Mindset, Become Confident.</p>
        </footer>
    </div>

    {{-- JavaScript for Preloader, Language Switcher, and Register/Loader Trigger --}}
    <script>
        // ---------- Preloader on page load ----------
        window.addEventListener('load', function() {
            const loader = document.getElementById('page-loader');
            const mainContent = document.getElementById('main-content');
            setTimeout(function() {
                loader.style.opacity = '0';
                setTimeout(function() {
                    loader.style.display = 'none';
                    mainContent.style.display = 'block';
                    document.querySelectorAll('.fade-up').forEach(el => el.classList.add('fade-up'));
                }, 400);
            }, 1200);
        });

        // ---------- Show loader when clicking any register-trigger (register/login) ----------
        function showNavigationLoader() {
            // Create temporary loader if not exists
            let navLoader = document.getElementById('navigation-loader');
            if (!navLoader) {
                navLoader = document.createElement('div');
                navLoader.id = 'navigation-loader';
                navLoader.innerHTML = `
                    <div class="text-center px-6">
                        <div class="w-32 h-32 rounded-full overflow-hidden mx-auto mb-5 border-4 border-primary shadow-xl">
                            <img src="{{ asset('pro.jpeg') }}" alt="CEO ELLYPESA" class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">CEO ELLYPESA</h3>
                        <p class="text-primary font-semibold mt-1">Entrepreneur Mentor | Digital Strategist</p>
                        <div class="spinner mt-5"></div>
                        <p class="text-gray-600 mt-4 max-w-xs mx-auto">Loading, please wait...</p>
                    </div>
                `;
                document.body.appendChild(navLoader);
            }
            navLoader.style.display = 'flex';
            navLoader.style.opacity = '1';
        }

        // Attach to all elements with class 'register-trigger'
        document.addEventListener('click', function(e) {
            const target = e.target.closest('.register-trigger');
            if (target && (target.getAttribute('href') === '{{ route('register') }}' || target.getAttribute('href') === '{{ route('login') }}' || target.getAttribute('href') === '#signup' || target.classList.contains('register-trigger'))) {
                // Only trigger for actual links to register/login routes
                const href = target.getAttribute('href');
                if (href && (href.includes('register') || href.includes('login'))) {
                    e.preventDefault();
                    showNavigationLoader();
                    setTimeout(() => {
                        window.location.href = href;
                    }, 400);
                }
            }
        });

        // ---------- Language Switcher (Kiswahili / English) ----------
        const translations = {
            sw: {
                mentor_tagline: "Mjasiriamali Mentor | Mkakati wa Dijitali",
                loader_bio: "Ninakusaidia kupata kipato kupitia Masoko ya Dijitali, Kukuza Ujasiriamali, na Kuboresha Utendaji wa Timu.",
                nav_overview: "Muhtasari",
                nav_learn: "Jifunze",
                nav_why: "Kwa Nini Sisi",
                nav_success: "Mafanikio",
                nav_team: "Usimamizi wa Timu",
                login: "Ingia",
                register: "Jisajili",
                hero_title: "Jenga Kipato, Kuza Mtazamo,<br> Kuwa na Ujasiri",
                hero_sub: "Jua Masoko ya Dijitali, Ujasiriamali na Utendaji wa Timu na <strong class='text-primary'>CEO ELLYPESA</strong>",
                hero_cta_start: "👉 ANZA SAFARI YAKO (Bure)",
                hero_cta_discover: "Jifunze Zaidi <i class='fas fa-arrow-down ml-2'></i>",
                users_count_prefix: "Tayari",
                users_count_suffix: "wanachama wanapata kipato kupitia ELLYPESA",
                overview_badge: "Changamoto",
                overview_title: "Kutoka Bila Mwongozo hadi Matokeo Halisi",
                problem_title: "Tatizo",
                problem_text: "Watu wengi wanataka mafanikio ya mtandaoni na uhuru wa kifedha lakini wanakosa mwongozo, ushauri, na mifumo ya vitendo. Wanakwama kwenye nadharia bila kipato halisi.",
                solution_title: "Suluhisho la CEO ELLYPESA",
                solution_text: "Njia iliyo wazi na ya vitendo kupitia Masoko ya Dijitali, Ujuzi wa Ujasiriamali, na Utendaji wa Timu. Maarifa ya vitendo, msaada wa kweli, na mwelekeo wa kufanikiwa katika uchumi wa kidijitali.",
                overview_quote: "Maarifa ya vitendo, msaada, na mwelekeo wa kufanikiwa katika uchumi wa kidijitali — hiyo ni ahadi ya ELLYPESA.",
                learn_title: "Utajifunza Nini",
                learn_sub: "Ujuzi wa vitendo unaozalisha kipato halisi",
                learn_dm_title: "Masoko ya Dijitali",
                learn_dm_text: "Jinsi ya kutengeneza pesa mtandaoni kwa kutumia mitandao ya kijamii, uuzaji wa washirika, na mikakati ya kidijitali — hata kwa simu yako tu.",
                learn_dm_tag: "→ Jenga mapato passiv",
                learn_ent_title: "Ujasiriamali",
                learn_ent_text: "Jinsi ya kuanzisha biashara kutoka mwanzo, kudhibiti mtaji mdogo, na kupanua mawazo yako kuwa kipato endelevu.",
                learn_ent_tag: "→ Anza na kukuza biashara yako",
                learn_team_title: "Utendaji wa Timu",
                learn_team_text: "Jinsi ya kuongoza, kusimamia, na kuwahamasisha timu kufikia malengo, kuongeza mauzo, na kuunda mafanikio yanayoweza kupanuka.",
                learn_team_tag: "→ Zidisha athari yako",
                why_title: "Kwa Nini Uchague CEO ELLYPESA",
                why_sub: "Mentor anayetoa matokeo, si tu motisha",
                why_simple_title: "Rahisi na Vitendo",
                why_simple_text: "Hakuna mambo ya kujaza, tu masomo yanayoweza kutekelezwa mara moja.",
                why_step_title: "Mwongozo wa Hatua kwa Hatua",
                why_step_text: "Kutoka sifuri hadi kipato — ramani iliyo wazi yenye msaada wa kibinafsi.",
                why_support_title: "Mfumo Halisi wa Msaada",
                why_support_text: "Jumuiya hai, msaada wa WhatsApp, na upatikanaji wa mentor.",
                why_results_title: "Lengo ni Matokeo",
                why_results_text: "Tunapima mafanikio kwa ukuaji wa kipato chako, si nadharia.",
                value_title: "Fursa za Kipato Tunazotoa",
                value_sub: "Anza na kile kinacholingana na shauku yako",
                testimonial_title: "Hadithi za Mafanikio",
                testimonial_sub: "Watu halisi, mabadiliko halisi ya kipato",
                team_badge: "🔥 MASTARI YA PREMIUM",
                team_title: "Utendaji wa Timu na Uongozi",
                team_sub: "Fungua mikakati ya hali ya juu ya kuongoza, kupanua, na kutawala",
                team_card1_title: "Uongozi",
                team_card1_text: "Hamasisha na uongoze timu",
                team_card2_title: "Kujenga Timu",
                team_card2_text: "Vutia wanachama bora",
                team_card3_title: "Ukuaji wa Mauzo",
                team_card3_text: "Ongeza mapato ya timu",
                team_card4_title: "Motisha",
                team_card4_text: "Endesha utendaji bora",
                team_enroll: "Jiunge kupata",
                team_footer: "🔒 Maudhui ya premium yanafunguka baada ya malipo. Jisajili kuanza.",
                about_bio: "Ninawasaidia watu kujenga kipato, kukuza mawazo, na kuwa viongozi hodari kwa kutumia ujuzi wa vitendo. Lengo langu ni kukuwezesha kwa mikakati ya masoko ya dijitali, ujasiriamali, na utendaji wa timu ambayo inafanya kazi katika ulimwengu wa kweli.",
                cta_title: "Uko Tayari Kubadilisha Maisha Yako?",
                cta_text: "Jiunge na jumuiya ya ELLYPESA leo — jifunze, pata kipato, na kua kila siku.",
                cta_button_join: "👉 JIUNGE SASA (BURE)",
                cta_button_login: "Tayari una akaunti? Ingia",
                bonus_title: "Zawadi:",
                bonus_text: "Jiunge na jumuiya na upate upatikanaji wa haraka wa mafunzo ya kila wiki + kikundi cha msaada cha WhatsApp.",
                whatsapp_title: "Unahitaji Msaada? Ongea nasi kwenye WhatsApp",
                footer_tagline: "Jenga Kipato, Kuza Mtazamo, Kuwa na Ujasiri."
            },
            en: {
                mentor_tagline: "Entrepreneur Mentor | Digital Strategist",
                loader_bio: "I help you build income through Digital Marketing, develop Entrepreneurship Skills, and improve Team Performance.",
                nav_overview: "Overview",
                nav_learn: "Learn",
                nav_why: "Why Us",
                nav_success: "Success",
                nav_team: "Team Mgmt",
                login: "Login",
                register: "Register",
                hero_title: "Build Income, Grow Mindset,<br> Become Confident",
                hero_sub: "Master Digital Marketing, Entrepreneurship & Team Performance with <strong class='text-primary'>CEO ELLYPESA</strong>",
                hero_cta_start: "👉 START YOUR JOURNEY (Free)",
                hero_cta_discover: "Discover More <i class='fas fa-arrow-down ml-2'></i>",
                users_count_prefix: "Already",
                users_count_suffix: "members earning with ELLYPESA",
                overview_badge: "The Challenge",
                overview_title: "From Zero Guidance to Real Results",
                problem_title: "The Problem",
                problem_text: "Many people want online success and financial freedom but lack clear guidance, mentorship, and practical systems. They get stuck with theory and no real income.",
                solution_title: "CEO ELLYPESA's Solution",
                solution_text: "A clear, actionable path through Digital Marketing, Entrepreneurship Skills, and Team Performance. Practical knowledge, real support, and direction to succeed in the digital economy.",
                overview_quote: "Practical knowledge, support, and direction to succeed in the digital economy — that's the ELLYPESA promise.",
                learn_title: "What You Will Learn",
                learn_sub: "Practical skills that generate real income",
                learn_dm_title: "Digital Marketing",
                learn_dm_text: "How to make money online using social media, affiliate marketing, and digital strategies — even with just your phone.",
                learn_dm_tag: "→ Build passive income",
                learn_ent_title: "Entrepreneurship",
                learn_ent_text: "How to build a business from scratch, manage small capital, and scale your ideas into sustainable income.",
                learn_ent_tag: "→ Start & grow your venture",
                learn_team_title: "Team Performance",
                learn_team_text: "How to lead, manage, and motivate teams to hit targets, boost sales, and create scalable success.",
                learn_team_tag: "→ Multiply your impact",
                why_title: "Why Choose CEO ELLYPESA",
                why_sub: "A mentor who delivers results, not just motivation",
                why_simple_title: "Simple & Practical",
                why_simple_text: "No fluff, only actionable lessons you can apply immediately.",
                why_step_title: "Step-by-Step Guidance",
                why_step_text: "From zero to income — clear roadmap with personal support.",
                why_support_title: "Real Support System",
                why_support_text: "Active community, WhatsApp support, and mentor access.",
                why_results_title: "Focus on Results",
                why_results_text: "We measure success by your income growth, not theory.",
                value_title: "Income Opportunities We Offer",
                value_sub: "Start with what fits your passion",
                testimonial_title: "Success Stories",
                testimonial_sub: "Real people, real income transformations",
                team_badge: "🔥 PREMIUM MASTERY",
                team_title: "Team Performance & Leadership",
                team_sub: "Unlock advanced strategies to lead, scale, and dominate",
                team_card1_title: "Leadership",
                team_card1_text: "Inspire & guide teams",
                team_card2_title: "Team Building",
                team_card2_text: "Attract top members",
                team_card3_title: "Sales Growth",
                team_card3_text: "Increase team revenue",
                team_card4_title: "Motivation",
                team_card4_text: "Drive performance",
                team_enroll: "Join to Access",
                team_footer: "🔒 Premium content unlocks after payment. Register to begin.",
                about_bio: "I help people build income, grow ideas, and become strong leaders using practical skills. My purpose is to empower you with digital marketing, entrepreneurship, and team performance strategies that actually work in the real world.",
                cta_title: "Ready to Change Your Life?",
                cta_text: "Join the ELLYPESA community today — learn, earn, and grow continuously.",
                cta_button_join: "👉 JOIN NOW (FREE)",
                cta_button_login: "Already a Member? Login",
                bonus_title: "Bonus:",
                bonus_text: "Join the community and get instant access to weekly coaching + WhatsApp support group.",
                whatsapp_title: "Need Help? Chat with us on WhatsApp",
                footer_tagline: "Build Income, Grow Mindset, Become Confident."
            }
        };

        let currentLang = 'sw'; // default

        function setLanguage(lang) {
            currentLang = lang;
            document.querySelectorAll('[data-i18n]').forEach(el => {
                const key = el.getAttribute('data-i18n');
                if (translations[lang][key]) {
                   if (key === 'hero_title' || key === 'hero_sub' || key === 'hero_cta_discover' || key === 'hero_cta_start') {   // Handle HTML inside
                        el.innerHTML = translations[lang][key];
                    } else {
                        el.innerText = translations[lang][key];
                    }
                }
            });
            // Update active class on language buttons
            document.querySelectorAll('.lang-btn').forEach(btn => {
                if (btn.getAttribute('data-lang') === lang) {
                    btn.classList.add('active', 'bg-primary', 'text-white');
                    btn.classList.remove('bg-gray-200', 'text-gray-700');
                } else {
                    btn.classList.remove('active', 'bg-primary', 'text-white');
                    btn.classList.add('bg-gray-200', 'text-gray-700');
                }
            });
        }

        document.querySelectorAll('.lang-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const lang = btn.getAttribute('data-lang');
                setLanguage(lang);
            });
        });

        // Initialize with Swahili
        setLanguage('sw');
    </script>
</body>
</html>