<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — Self Ordering</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        [x-cloak] { display: none !important; }
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.625rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.15s ease;
            color: #6b7280;
        }
        .sidebar-link:hover {
            background-color: #eef2ff;
            color: #4f46e5;
        }
        .sidebar-link.active {
            background-color: #4f46e5;
            color: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .sidebar-link i {
            width: 1.25rem;
            text-align: center;
            font-size: 1rem;
        }
        .sidebar-link.active i {
            color: white;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50 font-sans" x-data="{ sidebarOpen: true }">

<div class="flex h-screen overflow-hidden">

    {{-- Sidebar --}}
    <aside :class="sidebarOpen ? 'w-64' : 'w-0 -translate-x-full'"
           class="bg-white border-r border-gray-200 flex flex-col transition-all duration-300 overflow-hidden flex-shrink-0 z-20">

        {{-- Logo --}}
        <div class="flex items-center gap-3 px-6 py-5 border-b border-gray-100">
            <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
                <i class="fa-solid fa-utensils text-white text-sm"></i>
            </div>
            <span class="font-bold text-gray-800 text-lg">SelfOrder</span>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-4 mb-2">Menu Utama</p>

            <a href="{{ route('admin.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.index') ? 'active' : '' }}">
                <i class="fa-solid fa-gauge-high"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.menus.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.menus.*') ? 'active' : '' }}">
                <i class="fa-solid fa-bowl-food"></i>
                <span>Manajemen Menu</span>
            </a>

            <a href="{{ route('admin.users.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="fa-solid fa-users"></i>
                <span>Manajemen User</span>
            </a>

            <div class="pt-3 mt-3 border-t border-gray-100">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-4 mb-2">Operasional</p>
            </div>

            <a href="{{ route('kasir.index') }}"
               class="sidebar-link {{ request()->routeIs('kasir.*') ? 'active' : '' }}">
                <i class="fa-solid fa-cash-register"></i>
                <span>Kasir</span>
            </a>

            <a href="{{ route('kitchen.index') }}"
               class="sidebar-link {{ request()->routeIs('kitchen.*') ? 'active' : '' }}">
                <i class="fa-solid fa-fire-burner"></i>
                <span>Kitchen Display</span>
            </a>

            <a href="{{ route('kiosk') }}" target="_blank"
               class="sidebar-link">
                <i class="fa-solid fa-tablet-screen-button"></i>
                <span>Kiosk (Preview)</span>
            </a>
        </nav>

        {{-- User Info --}}
        <div class="border-t border-gray-100 px-4 py-4">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-indigo-100 rounded-full flex items-center justify-center">
                    <i class="fa-solid fa-user text-indigo-600 text-sm"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-800 truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email }}</p>
                </div>
            </div>
        </div>
    </aside>

    {{-- Main --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- Top Header --}}
        <header class="bg-white border-b border-gray-200 px-6 py-3 flex items-center justify-between flex-shrink-0">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = !sidebarOpen"
                        class="text-gray-500 hover:text-gray-700 transition-colors">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
                <div>
                    <h1 class="text-lg font-bold text-gray-800">@yield('page-title', 'Dashboard')</h1>
                    <p class="text-xs text-gray-400">@yield('page-subtitle', 'Home / Dashboard')</p>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <span class="text-sm text-gray-500">{{ now()->format('d M Y') }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="flex items-center gap-2 text-sm text-red-500 hover:text-red-700 font-medium transition-colors">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                    </button>
                </form>
            </div>
        </header>

        {{-- Content --}}
        <main class="flex-1 overflow-y-auto p-6">
            @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-4 flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-4 flex items-center gap-2">
                <i class="fa-solid fa-circle-xmark"></i> {{ session('error') }}
            </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

@stack('scripts')
</body>
</html>
