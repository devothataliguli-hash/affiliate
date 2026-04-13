<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ELLYPESA Dashboard')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        .bg-primary { background-color: #FF6F00; }
        .text-primary { color: #FF6F00; }
        .hover\:bg-primary-dark:hover { background-color: #E65100; }

        .sidebar-link {
            transition: all 0.2s ease;
        }
        .sidebar-link:hover {
            background-color: #FFF7ED;
            color: #FF6F00;
        }
        .sidebar-link.active {
            background-color: #FF6F00;
            color: white;
        }

        .dropdown-enter {
            opacity: 0;
            transform: translateY(-5px) scale(0.95);
        }
        .dropdown-enter-active {
            opacity: 1;
            transform: translateY(0) scale(1);
            transition: all 0.15s ease;
        }

        .sidebar-overlay {
            background: rgba(0,0,0,0.45);
            backdrop-filter: blur(2px);
        }
    </style>
</head>

<body class="bg-gray-50">

<div class="flex h-screen overflow-hidden">

    <!-- MOBILE OVERLAY -->
    <div id="sidebarOverlay" class="sidebar-overlay fixed inset-0 z-30 hidden lg:hidden"></div>

    <!-- SIDEBAR -->
    <aside id="sidebar"
        class="fixed lg:static inset-y-0 left-0 z-40 w-64 bg-white border-r border-gray-100 shadow-sm
        transform -translate-x-full lg:translate-x-0 transition-transform duration-300 flex flex-col">

        <!-- LOGO -->
        <div class="px-5 py-4 border-b flex items-center justify-between">
            <a href="{{ route('landing') }}" class="text-xl font-bold text-primary">
                ELLYPESA
            </a>

            <button id="closeSidebarBtn" class="lg:hidden text-gray-500">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- NAV -->
        <nav class="flex-1 px-3 py-5 space-y-1">

            <a href="{{ route('dashboard') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm text-gray-700
               {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-line w-5"></i> Dashboard
            </a>

            <a href="{{ route('user.skills') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm text-gray-700
               {{ request()->routeIs('user.skills') ? 'active' : '' }}">
                <i class="fas fa-graduation-cap w-5"></i> Skills
                <span class="ml-auto text-[10px] bg-gray-100 text-gray-600 px-2 py-1 rounded-full">LOCK</span>
            </a>

            <a href="{{ route('user.bonus') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm text-gray-700
               {{ request()->routeIs('user.bonus') ? 'active' : '' }}">
                <i class="fas fa-gift w-5"></i> Bonus
            </a>

        </nav>
    </aside>

    <!-- MAIN -->
    <div class="flex-1 flex flex-col overflow-hidden">

        <!-- TOP BAR -->
        <header class="bg-white border-b border-gray-100 px-4 lg:px-6 py-3 flex items-center justify-between">

            <!-- LEFT -->
            <div class="flex items-center gap-3">
                <button id="openSidebarBtn" class="lg:hidden text-gray-600">
                    <i class="fas fa-bars text-lg"></i>
                </button>

                <h1 class="text-base md:text-lg font-semibold text-gray-800">
                    @yield('page-title', 'Dashboard')
                </h1>
            </div>

            <!-- RIGHT -->
            <div class="flex items-center gap-3">

                <!-- NOTIFICATIONS -->
                <div x-data="{ open:false }" class="relative">

                    <button @click="open=!open" class="relative text-gray-600 hover:text-primary">
                        <i class="fas fa-bell text-lg"></i>
                        <span class="absolute -top-1 -right-1 w-4 h-4 text-[10px] bg-red-500 text-white rounded-full flex items-center justify-center">
                            2
                        </span>
                    </button>

                    <div x-show="open"
                         @click.away="open=false"
                         x-transition
                         class="absolute right-0 mt-2 w-72 bg-white border border-gray-100 rounded-xl shadow-lg z-50">

                        <div class="p-3 border-b text-sm font-semibold text-gray-800">
                            Notifications
                        </div>

                        <div class="p-2 space-y-1 text-sm">
                            <div class="p-2 rounded-lg hover:bg-gray-50">
                                📚 Somo jipya limeongezwa
                            </div>
                            <div class="p-2 rounded-lg hover:bg-gray-50">
                                🎁 Bonus mpya imeongezwa
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PROFILE -->
                <div x-data="{ open:false }" class="relative">

                    <button @click="open=!open" class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-orange-100 flex items-center justify-center text-orange-600">
                            <i class="fas fa-user text-sm"></i>
                        </div>
                        <span class="hidden sm:block text-sm text-gray-700 font-medium">
                            {{ Auth::user()->name }}
                        </span>
                    </button>

                    <div x-show="open"
                         @click.away="open=false"
                         x-transition
                         class="absolute right-0 mt-2 w-52 bg-white border border-gray-100 rounded-xl shadow-lg z-50">

                        <div class="p-3 border-b">
                            <p class="text-sm font-semibold">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500 truncate">
                                {{ Auth::user()->email ?? Auth::user()->phone }}
                            </p>
                        </div>

                        <div class="py-2 text-sm">
                            <a class="block px-3 py-2 hover:bg-gray-50" href="#">Profile</a>
                            <a class="block px-3 py-2 hover:bg-gray-50" href="#">Settings</a>
                        </div>

                        <div class="border-t p-2">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="w-full text-left text-red-600 px-3 py-2 hover:bg-red-50 rounded-lg">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </header>

        <!-- CONTENT -->
        <main class="flex-1 overflow-y-auto p-4 md:p-6">
            
            @if (session('success'))
                <div class="mb-4 bg-green-50 border border-green-100 text-green-700 px-4 py-3 rounded-xl text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 bg-red-50 border border-red-100 text-red-700 px-4 py-3 rounded-xl text-sm">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>

    </div>
</div>

<!-- ALPINE -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<!-- SIDEBAR -->
<script>
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');

    document.getElementById('openSidebarBtn')?.addEventListener('click', () => {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
    });

    document.getElementById('closeSidebarBtn')?.addEventListener('click', () => {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    });

    overlay?.addEventListener('click', () => {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    });
</script>

</body>
</html>