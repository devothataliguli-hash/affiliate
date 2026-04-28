<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ELLYPESA LMS') - {{ config('app.name') }}</title>
    
    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        /* Custom color variables for better contrast */
        :root {
            --primary-dark: #E65100;
            --primary-main: #F57C00;
            --primary-light: #FFE0B2;
            --gray-bg: #F9FAFB;
            --card-white: #FFFFFF;
            --text-dark: #1F2937;
            --text-muted: #4B5563;
            --success-bg: #ECFDF5;
            --success-text: #065F46;
            --error-bg: #FEF2F2;
            --error-text: #991B1B;
        }
        
        [x-cloak] { display: none !important; }
        
        /* Smooth transitions */
        .transition-all { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        
        /* Card hover effect - subtle and accessible */
        .card-hover:hover { 
            transform: translateY(-3px); 
            box-shadow: 0 12px 24px -8px rgba(0,0,0,0.12);
        }
        
        /* Sidebar active link - high contrast */
        .sidebar-link.active { 
            background-color: var(--primary-main); 
            color: white !important;
            font-weight: 500;
        }
        .sidebar-link.active i { 
            color: white !important;
        }
        
        /* Enhanced focus states for accessibility */
        button:focus-visible, a:focus-visible {
            outline: 2px solid var(--primary-main);
            outline-offset: 2px;
            border-radius: 0.5rem;
        }
        
        /* Better tap targets on mobile */
        @media (max-width: 768px) {
            button, .sidebar-link, a {
                min-height: 48px;
            }
            .sidebar-link {
                padding: 12px 16px;
            }
        }
        
        /* Scrollbar styling */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #F1F1F1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb {
            background: #D1D5DB;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #9CA3AF;
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-[#F8FAFE] font-sans antialiased" style="background-color: #F8FAFE;">
    
    {{-- Mobile Sidebar Toggle with improved state management --}}
    <div x-data="{ sidebarOpen: false, isMobile: window.innerWidth < 768 }" 
         @resize.window="isMobile = window.innerWidth < 768; if(window.innerWidth >= 768) sidebarOpen = true"
         x-init="sidebarOpen = !isMobile; isMobile = window.innerWidth < 768" 
         class="relative min-h-screen">
        
        {{-- Mobile Overlay with improved backdrop blur --}}
        <div x-show="sidebarOpen && isMobile" 
             @click="sidebarOpen = false" 
             x-cloak 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black/60 backdrop-blur-sm z-20"></div>
        
        {{-- Sidebar with improved contrast and spacing --}}
        <aside x-show="sidebarOpen" 
               x-cloak 
               x-transition:enter="transition ease-out duration-200"
               x-transition:enter-start="-translate-x-full"
               x-transition:enter-end="translate-x-0"
               x-transition:leave="transition ease-in duration-200"
               x-transition:leave-start="translate-x-0"
               x-transition:leave-end="-translate-x-full"
               class="fixed left-0 top-0 h-full w-80 bg-white shadow-2xl z-30 overflow-y-auto"
               style="background-color: #FFFFFF;">
            
            <!-- Sidebar Header with brand -->
            <div class="p-5 border-b border-gray-100 bg-gradient-to-r from-orange-50 to-white">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-2xl font-extrabold tracking-tight" style="color: #E65100;">ELLYPESA</span>
                        <p class="text-xs font-medium mt-1" style="color: #6B7280;">Learning Management System</p>
                    </div>
                    <button @click="sidebarOpen = false" class="text-gray-500 hover:text-gray-700 transition-colors md:hidden p-2 rounded-full hover:bg-gray-100">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            
            <!-- Navigation with better visual hierarchy -->
            <nav class="p-4 space-y-1.5">
                <a href="{{ route('user.dashboard') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl transition-all group {{ request()->routeIs('user.dashboard') ? 'active shadow-sm' : 'hover:bg-orange-50' }}" style="color: #374151;">
                    <i class="fas fa-tachometer-alt w-5 text-lg {{ request()->routeIs('user.dashboard') ? 'text-white' : 'text-orange-600 group-hover:text-orange-700' }}"></i>
                    <span class="font-medium">Dashboard</span>
                </a>
                <a href="{{ route('user.my-skills') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl transition-all group {{ request()->routeIs('user.my-skills') ? 'active shadow-sm' : 'hover:bg-orange-50' }}" style="color: #374151;">
                    <i class="fas fa-graduation-cap w-5 text-lg {{ request()->routeIs('user.my-skills') ? 'text-white' : 'text-orange-600 group-hover:text-orange-700' }}"></i>
                    <span class="font-medium">My Skills</span>
                </a>
                <a href="{{ route('user.payments.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl transition-all group {{ request()->routeIs('user.payments.*') ? 'active shadow-sm' : 'hover:bg-orange-50' }}" style="color: #374151;">
                    <i class="fas fa-money-bill-wave w-5 text-lg {{ request()->routeIs('user.payments.*') ? 'text-white' : 'text-orange-600 group-hover:text-orange-700' }}"></i>
                    <span class="font-medium">Payments</span>
                </a>
                <a href="{{ route('user.profile.edit') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl transition-all group {{ request()->routeIs('user.profile.*') ? 'active shadow-sm' : 'hover:bg-orange-50' }}" style="color: #374151;">
                    <i class="fas fa-user w-5 text-lg {{ request()->routeIs('user.profile.*') ? 'text-white' : 'text-orange-600 group-hover:text-orange-700' }}"></i>
                    <span class="font-medium">Profile</span>
                </a>
                <a href="https://wa.me/255626549262?text=Habari%20ELLYPESA%2C%20nahitaji%20msaada" target="_blank" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl transition-all group hover:bg-green-50" style="color: #374151;">
                    <i class="fab fa-whatsapp w-5 text-lg text-emerald-600 group-hover:text-emerald-700"></i>
                    <span class="font-medium">WhatsApp Support</span>
                </a>
            </nav>
            
            <!-- Logout section with improved positioning -->
            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-100 bg-white/95 backdrop-blur-sm">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 px-4 py-3 w-full rounded-xl transition-all bg-red-50 hover:bg-red-100" style="color: #DC2626;">
                        <i class="fas fa-sign-out-alt w-5 text-lg"></i>
                        <span class="font-medium">Logout</span>
                    </button>
                </form>
            </div>
        </aside>
        
        {{-- Main Content Area --}}
        <div class="md:ml-80 transition-all duration-200">
            {{-- Top Navbar with improved contrast --}}
            <nav class="bg-white shadow-sm sticky top-0 z-10 border-b border-gray-100">
                <div class="px-4 py-3 flex justify-between items-center">
                    <button @click="sidebarOpen = true" class="text-gray-600 hover:text-orange-600 transition-colors md:hidden p-2 rounded-lg hover:bg-orange-50">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    
                    <!-- Mobile brand on small screens -->
                    <div class="md:hidden flex items-center">
                        <span class="text-lg font-bold tracking-tight" style="color: #E65100;">ELLYPESA</span>
                    </div>
                    
                    <div class="flex items-center gap-3 ml-auto">
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-gray-50 transition-colors" style="color: #1F2937;">
                                <div class="w-9 h-9 bg-gradient-to-br from-orange-500 to-orange-700 rounded-full flex items-center justify-center shadow-sm">
                                    <i class="fas fa-user text-white text-sm"></i>
                                </div>
                                <span class="hidden sm:inline font-medium text-sm">{{ auth()->user()->name }}</span>
                                <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                            </button>
                            
                            <div x-show="open" 
                                 @click.away="open = false" 
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-100"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-20">
                                <a href="{{ route('user.profile.edit') }}" class="block px-4 py-2.5 text-sm hover:bg-orange-50 transition-colors" style="color: #374151;">
                                    <i class="fas fa-user-circle mr-2 text-orange-600"></i> My Profile
                                </a>
                                <div class="border-t border-gray-100 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2.5 text-sm hover:bg-red-50 transition-colors" style="color: #DC2626;">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
            
            {{-- Page Content with improved spacing and readability --}}
            <main class="px-4 py-6 md:px-8 md:py-8 max-w-7xl mx-auto">
                @if(session('success'))
                    <div class="mb-6 p-4 rounded-xl shadow-sm flex items-start gap-3 border-l-4" style="background-color: #ECFDF5; border-left-color: #059669;">
                        <i class="fas fa-check-circle text-emerald-600 mt-0.5"></i>
                        <span style="color: #065F46; font-weight: 500;">{{ session('success') }}</span>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="mb-6 p-4 rounded-xl shadow-sm flex items-start gap-3 border-l-4" style="background-color: #FEF2F2; border-left-color: #DC2626;">
                        <i class="fas fa-exclamation-triangle text-red-600 mt-0.5"></i>
                        <span style="color: #991B1B; font-weight: 500;">{{ session('error') }}</span>
                    </div>
                @endif
                
                @yield('content')
            </main>
        </div>
    </div>
    
    {{-- WhatsApp Float Button with improved accessibility --}}
    <a href="https://wa.me/255626549262?text=Habari%20ELLYPESA%2C%20nahitaji%20msaada" 
       target="_blank" 
       rel="noopener noreferrer"
       class="fixed bottom-6 right-6 bg-gradient-to-r from-emerald-500 to-green-600 text-white p-3 rounded-full shadow-xl hover:shadow-2xl transition-all z-40 flex items-center justify-center w-14 h-14 hover:scale-105 active:scale-95"
       aria-label="Contact us on WhatsApp for support">
        <i class="fab fa-whatsapp text-2xl"></i>
    </a>
    
    @stack('scripts')
</body>
</html>

<!-- Additional responsive styles that work within the component context -->
<style>
    /* Extra responsive improvements */
    @media (max-width: 480px) {
        main {
            padding-left: 1rem !important;
            padding-right: 1rem !important;
        }
        .text-2xl {
            font-size: 1.25rem !important;
        }
        .gap-3 {
            gap: 0.75rem;
        }
    }
    
    /* Improve touch target sizes for mobile */
    @media (hover: none) and (pointer: coarse) {
        button, .sidebar-link, a[href], [role="button"] {
            cursor: pointer;
            touch-action: manipulation;
        }
    }
    
    /* Better contrast for text selection */
    ::selection {
        background-color: #F57C00;
        color: white;
    }
    
    /* Smooth content reveal */
    main > * {
        animation: fadeInUp 0.4s ease-out;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Card styles for better readability */
    .card {
        background-color: white;
        border-radius: 1rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        transition: all 0.2s ease;
    }
    
    /* Improved focus ring */
    *:focus-visible {
        outline: 2px solid #F57C00;
        outline-offset: 2px;
        border-radius: 0.375rem;
    }
</style>