<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - @yield('title', 'Dashboard') | {{ config('app.name') }}</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        /* Custom color variables for better contrast */
        :root {
            --admin-primary: #E65100;
            --admin-primary-light: #FFF3E0;
            --admin-sidebar-bg: #FFFFFF;
            --admin-text-dark: #1F2937;
            --admin-text-muted: #4B5563;
        }
        
        [x-cloak] { display: none !important; }
        
        /* Sidebar link styles */
        .sidebar-link { 
            transition: all 0.2s ease;
            border-radius: 0.75rem;
        }
        .sidebar-link.active { 
            background: linear-gradient(135deg, #F57C00, #E65100);
            color: white !important;
            box-shadow: 0 2px 8px rgba(245, 124, 0, 0.3);
        }
        .sidebar-link.active i { 
            color: white !important;
        }
        .sidebar-link:not(.active):hover {
            background-color: #FFF3E0;
            color: #E65100;
        }
        
        /* Mobile optimizations */
        @media (max-width: 768px) {
            .sidebar-link {
                padding: 12px 16px;
            }
            button, a {
                min-height: 44px;
            }
        }
        
        /* Focus states for accessibility */
        button:focus-visible, a:focus-visible, input:focus-visible {
            outline: 2px solid #F57C00;
            outline-offset: 2px;
            border-radius: 0.5rem;
        }
        
        /* Scrollbar styling */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #F1F1F1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb {
            background: #F57C00;
            border-radius: 10px;
        }
    </style>
    
    @stack('styles')
</head>
<body style="background-color: #F8FAFE;">
    
    <div x-data="{ sidebarOpen: false }" 
         x-init="sidebarOpen = window.innerWidth >= 1024" 
         @resize.window="sidebarOpen = window.innerWidth >= 1024"
         class="relative min-h-screen">
        
        {{-- Mobile Overlay with backdrop blur --}}
        <div x-show="sidebarOpen" 
             @click="sidebarOpen = false" 
             x-cloak 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black/60 backdrop-blur-sm z-20 lg:hidden"></div>
        
        {{-- Sidebar --}}
        <aside x-show="sidebarOpen" 
               x-cloak 
               x-transition:enter="transition ease-out duration-200"
               x-transition:enter-start="-translate-x-full"
               x-transition:enter-end="translate-x-0"
               x-transition:leave="transition ease-in duration-200"
               x-transition:leave-start="translate-x-0"
               x-transition:leave-end="-translate-x-full"
               class="fixed left-0 top-0 h-full w-72 shadow-xl z-30 overflow-y-auto"
               style="background-color: #FFFFFF;">
            
            <!-- Sidebar Header -->
            <div class="p-5 border-b" style="border-color: #F3F4F6;">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-2xl font-extrabold tracking-tight" style="color: #E65100;">ELLYPESA</span>
                        <p class="text-xs font-medium mt-1" style="color: #6B7280;">Admin Panel</p>
                    </div>
                    <button @click="sidebarOpen = false" class="p-2 rounded-lg transition-colors lg:hidden hover:bg-gray-100" style="color: #6B7280;">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
            </div>
            
         <!-- Navigation -->
<nav class="p-4 space-y-1.5">
    <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 transition-all {{ request()->routeIs('admin.dashboard') ? 'active shadow-sm' : '' }}" style="color: #374151;">
        <i class="fas fa-tachometer-alt w-5 text-lg"></i>
        <span class="font-medium">Dashboard</span>
    </a>
    
    <!-- Users Link - Add this -->
    <a href="{{ route('admin.users.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 transition-all {{ request()->routeIs('admin.users.*') ? 'active shadow-sm' : '' }}" style="color: #374151;">
        <i class="fas fa-users w-5 text-lg"></i>
        <span class="font-medium">Users</span>
    </a>
    
    <a href="{{ route('admin.skills.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 transition-all {{ request()->routeIs('admin.skills.*') ? 'active shadow-sm' : '' }}" style="color: #374151;">
        <i class="fas fa-book w-5 text-lg"></i>
        <span class="font-medium">Skills</span>
    </a>
    <a href="{{ route('admin.payments.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 transition-all {{ request()->routeIs('admin.payments.*') ? 'active shadow-sm' : '' }}" style="color: #374151;">
        <i class="fas fa-money-bill-wave w-5 text-lg"></i>
        <span class="font-medium">Payments</span>
        @php $pendingCount = \App\Models\Payment::where('status', 'pending')->count(); @endphp
        @if($pendingCount > 0)
            <span class="ml-auto text-xs font-bold px-2 py-0.5 rounded-full" style="background-color: #FEE2E2; color: #DC2626;">{{ $pendingCount }}</span>
        @endif
    </a>
    <a href="{{ route('admin.testimonials.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 transition-all {{ request()->routeIs('admin.testimonials.*') ? 'active shadow-sm' : '' }}" style="color: #374151;">
        <i class="fas fa-star w-5 text-lg"></i>
        <span class="font-medium">Testimonials</span>
    </a>
</nav>
            
            <!-- Logout Section -->
            <div class="absolute bottom-0 left-0 right-0 p-4 border-t" style="border-color: #F3F4F6; background-color: #FFFFFF;">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 px-4 py-3 w-full rounded-xl transition-all" style="background-color: #FEF2F2; color: #DC2626;">
                        <i class="fas fa-sign-out-alt w-5 text-lg"></i>
                        <span class="font-medium">Logout</span>
                    </button>
                </form>
            </div>
        </aside>
        
        {{-- Main Content --}}
        <div class="lg:ml-72 transition-all duration-200">
            <!-- Top Navbar -->
            <nav class="shadow-sm sticky top-0 z-10" style="background-color: #FFFFFF; border-bottom: 1px solid #F3F4F6;">
                <div class="px-4 py-3 flex justify-between items-center">
                    <button @click="sidebarOpen = true" class="p-2 rounded-lg transition-colors lg:hidden hover:bg-gray-100" style="color: #6B7280;">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    
                    <!-- Mobile brand -->
                    <div class="lg:hidden flex items-center">
                        <span class="text-lg font-bold tracking-tight" style="color: #E65100;">ELLYPESA</span>
                        <span class="text-xs ml-1 px-1.5 py-0.5 rounded" style="background-color: #FEF3C7; color: #92400E;">Admin</span>
                    </div>
                    
                    <div class="flex items-center gap-3 ml-auto">
                        <span class="text-sm font-medium hidden md:inline-block" style="color: #4B5563;">Welcome, {{ auth()->user()->name }}</span>
                        <div class="w-9 h-9 rounded-full flex items-center justify-center shadow-sm" style="background: linear-gradient(135deg, #F57C00, #E65100);">
                            <i class="fas fa-user-shield text-sm" style="color: #FFFFFF;"></i>
                        </div>
                    </div>
                </div>
            </nav>
            
            <!-- Page Content -->
            <main class="px-4 py-6 md:px-6 md:py-8 max-w-7xl mx-auto">
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
    
    <style>
        /* Smooth content animation */
        main > * {
            animation: fadeInUp 0.3s ease-out;
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
        
        /* Card hover effects */
        .stat-card {
            transition: all 0.2s ease;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        }
        
        /* Active scale feedback */
        button:active, a:active {
            transform: scale(0.98);
        }
    </style>
    
    @stack('scripts')
</body>
</html>