<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel - ELLYPESA')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .bg-primary { background-color: #FF6F00; }
        .text-primary { color: #FF6F00; }
        .hover\:bg-primary-dark:hover { background-color: #E65100; }
        .sidebar-link { transition: all 0.2s ease; }
        .sidebar-link:hover { background-color: #FFF3E0; color: #FF6F00; }
        .sidebar-link.active { background-color: #FF6F00; color: white; }
        .sidebar-overlay { background-color: rgba(0,0,0,0.5); backdrop-filter: blur(2px); }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden relative">
        <div id="sidebarOverlay" class="sidebar-overlay fixed inset-0 z-30 hidden lg:hidden"></div>

        {{-- Sidebar --}}
        <aside id="sidebar" class="fixed lg:static inset-y-0 left-0 z-40 w-64 bg-white shadow-xl transform transition-transform duration-300 ease-in-out lg:transform-none -translate-x-full lg:translate-x-0 flex flex-col">
            <div class="p-5 border-b flex items-center justify-between">
                <a href="{{ route('landing') }}" class="text-2xl font-bold text-primary">ELLYPESA Admin</a>
                <button id="closeSidebarBtn" class="lg:hidden text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <nav class="flex-1 px-3 py-6 space-y-1 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" 
                   class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt w-5 h-5 mr-3"></i>
                    <span>Dashboard</span>
                </a>
                
                <a href="{{ route('admin.skills.index') }}" 
                   class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg {{ request()->routeIs('admin.skills.*') ? 'active' : '' }}">
                    <i class="fas fa-graduation-cap w-5 h-5 mr-3"></i>
                    <span>Skills Management</span>
                </a>
                
                <a href="{{ route('admin.user-skills.index') }}" 
                   class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg {{ request()->routeIs('admin.user-skills.*') ? 'active' : '' }}">
                    <i class="fas fa-user-check w-5 h-5 mr-3"></i>
                    <span>Approve Skills Access</span>
                </a>
                
                <a href="{{ route('admin.testimonials.index') }}" 
                   class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
                    <i class="fas fa-star w-5 h-5 mr-3"></i>
                    <span>Testimonials & Screenshots</span>
                </a>
                
                <a href="{{ route('admin.payments.index') }}" 
                   class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                    <i class="fas fa-money-bill w-5 h-5 mr-3"></i>
                    <span>Payments</span>
                </a>
            </nav>
            
            <div class="p-4 border-t">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="sidebar-link flex items-center w-full px-4 py-3 text-red-600 rounded-lg hover:bg-red-50">
                        <i class="fas fa-sign-out-alt w-5 h-5 mr-3"></i>
                        <span>Toka</span>
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white shadow-sm border-b border-gray-200 px-4 lg:px-6 py-3 flex items-center justify-between">
                <div class="flex items-center">
                    <button id="openSidebarBtn" class="lg:hidden text-gray-600 hover:text-primary mr-3">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <h1 class="text-xl font-semibold text-gray-800">@yield('page-title', 'Admin Dashboard')</h1>
                </div>
                <div class="flex items-center space-x-2 sm:space-x-4">
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                            <div class="w-8 h-8 bg-primary/10 rounded-full flex items-center justify-center text-primary">
                                <i class="fas fa-user-shield"></i>
                            </div>
                            <span class="hidden sm:inline text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down text-xs text-gray-400 hidden sm:block"></i>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500">Administrator</p>
                            </div>
                            <div class="border-t border-gray-100 py-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Toka
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-4 md:p-6 bg-gray-50">
                @if (session('success'))
                    <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                    </div>
                @endif
                
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const openBtn = document.getElementById('openSidebarBtn');
        const closeBtn = document.getElementById('closeSidebarBtn');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
            document.body.style.overflow = '';
        }

        openBtn?.addEventListener('click', openSidebar);
        closeBtn?.addEventListener('click', closeSidebar);
        overlay?.addEventListener('click', closeSidebar);

        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                closeSidebar();
            }
        });
    </script>
</body>
</html>