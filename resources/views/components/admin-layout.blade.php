<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Thiotty Admin') }} - Administration</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        [x-cloak] { display: none !important; }
        .admin-sidebar-link.active {
            @apply bg-primary/10 text-primary pt-4 pb-4;
        }
        .admin-sidebar-link.active i {
            @apply text-primary;
        }
    </style>
</head>
    <body class="bg-[var(--bg-page)] text-[var(--text-main)] font-sans antialiased overflow-x-hidden transition-colors duration-300" 
          x-data="{ sidebarOpen: true, mobileMenuOpen: false }">
    
    <!-- Mobile Sidebar Backdrop -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-in-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in-out duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="mobileMenuOpen = false"
         class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[60] lg:hidden"></div>

    <!-- Mobile Sidebar Drawer -->
    <aside x-show="mobileMenuOpen"
           x-transition:enter="transition ease-in-out duration-300 transform"
           x-transition:enter-start="-translate-x-full"
           x-transition:enter-end="translate-x-0"
           x-transition:leave="transition ease-in-out duration-300 transform"
           x-transition:leave-start="translate-x-0"
           x-transition:leave-end="-translate-x-full"
           class="fixed inset-y-0 left-0 w-72 bg-[var(--bg-surface)] border-r border-[var(--border-main)] z-[70] lg:hidden flex flex-col">
        
        <!-- Mobile Logo Section -->
        <div class="p-6 flex items-center justify-between border-b border-[var(--border-main)]">
            <div class="flex items-center gap-3">
                <x-application-logo :minimal="true" class="h-8 w-auto" />
                <span class="text-xl font-black tracking-tight text-[var(--text-main)]">Admin</span>
            </div>
            <button @click="mobileMenuOpen = false" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-primary">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>

        <!-- Navigation Links (Copied from Desktop Sidebar for consistency) -->
        <nav class="flex-1 px-4 space-y-1.5 mt-6 overflow-y-auto custom-scrollbar">
            @php
                $navLinks = [
                    ['route' => 'admin.dashboard', 'icon' => 'fa-th-large', 'label' => 'Dashboard', 'pattern' => 'admin.dashboard'],
                    ['route' => 'admin.products.index', 'icon' => 'fa-box', 'label' => 'Produits', 'pattern' => 'admin.products.*'],
                    ['route' => 'admin.categories.index', 'icon' => 'fa-tags', 'label' => 'Catégories', 'pattern' => 'admin.categories.*'],
                    ['route' => 'admin.orders.index', 'icon' => 'fa-shopping-cart', 'label' => 'Commandes', 'pattern' => 'admin.orders.*'],
                    ['route' => 'admin.users.index', 'icon' => 'fa-users', 'label' => 'Utilisateurs', 'pattern' => 'admin.users.*'],
                    ['route' => 'admin.zones.index', 'icon' => 'fa-truck', 'label' => 'Zones', 'pattern' => 'admin.zones.*'],
                    ['route' => 'admin.gallery.index', 'icon' => 'fa-images', 'label' => 'Galerie', 'pattern' => 'admin.gallery.*'],
                    ['route' => 'admin.contacts.index', 'icon' => 'fa-envelope', 'label' => 'Messages', 'pattern' => 'admin.contacts.*'],
                    ['route' => 'admin.alerts.index', 'icon' => 'fa-bullhorn', 'label' => 'Alertes', 'pattern' => 'admin.alerts.*'],
                ];
            @endphp

            @foreach($navLinks as $link)
                <a href="{{ route($link['route']) }}" 
                   class="flex items-center gap-4 px-5 py-3.5 rounded-xl transition-all {{ request()->routeIs($link['pattern']) ? 'bg-[var(--primary)] text-white shadow-lg shadow-primary/20' : 'text-slate-400 hover:bg-[var(--bg-muted)] hover:text-[var(--text-main)]' }}">
                    <i class="fas {{ $link['icon'] }} w-5 shrink-0 text-sm"></i>
                    <span class="text-[11px] font-black uppercase tracking-widest truncate">{{ $link['label'] }}</span>
                </a>
            @endforeach

            <div class="pt-10 pb-6 px-2">
                <a href="{{ route('home') }}" target="_blank"
                   class="flex items-center gap-4 p-4 rounded-xl transition-all font-bold text-slate-400 hover:bg-[var(--bg-muted)] hover:text-[var(--text-main)] border border-dashed border-[var(--border-main)]">
                    <i class="fas fa-external-link-alt w-5 text-sm shrink-0"></i>
                    <span class="text-[10px] font-black uppercase tracking-widest truncate">Voir Boutique</span>
                </a>
            </div>
        </nav>

        <!-- User Info Mobile -->
        <div class="p-6 border-t border-[var(--border-main)] bg-[var(--bg-muted)]/30">
            <div class="flex items-center gap-4 bg-[var(--bg-surface)] p-3 rounded-2xl border border-[var(--border-main)]">
                <div class="w-8 h-8 bg-[var(--primary)]/10 text-[var(--primary)] rounded-lg flex items-center justify-center font-black text-xs">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-[11px] font-bold text-[var(--text-main)] truncate">{{ Auth::user()->name }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-slate-300 hover:text-red-500 transition-colors">
                        <i class="fas fa-power-off text-xs"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Desktop Sidebar -->
    <aside :class="sidebarOpen ? 'w-80' : 'w-24'" 
           class="fixed inset-y-0 left-0 bg-[var(--bg-surface)] border-r border-[var(--border-main)] z-50 transition-all duration-300 ease-in-out hidden lg:flex flex-col">
        <!-- Logo -->
        <div class="p-8 flex items-center gap-4">
            <x-application-logo :minimal="true" class="h-10 w-auto" />
            <span x-show="sidebarOpen" x-transition class="text-2xl font-black tracking-tight text-[var(--text-main)]">Administration</span>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-6 space-y-2 mt-8 overflow-y-auto custom-scrollbar">
            @foreach($navLinks as $link)
                <a href="{{ route($link['route']) }}" 
                   class="flex items-center gap-4 px-6 py-4 rounded-2xl transition-all {{ request()->routeIs($link['pattern']) ? 'bg-[var(--primary)] text-white shadow-lg shadow-primary/20' : 'text-slate-400 hover:bg-[var(--bg-muted)] hover:text-[var(--text-main)]' }}">
                    <i class="fas {{ $link['icon'] }} w-5 shrink-0"></i>
                    <span x-show="sidebarOpen" x-transition class="text-xs font-black uppercase tracking-widest truncate">{{ $link['label'] }}</span>
                </a>
            @endforeach

            <a href="{{ route('home') }}" target="_blank"
               class="admin-sidebar-link flex items-center gap-4 p-4 rounded-2xl transition-all font-bold text-slate-400 hover:bg-[var(--bg-muted)] hover:text-[var(--text-main)] mt-20">
                <i class="fas fa-external-link-alt w-5 text-xl shrink-0"></i>
                <span x-show="sidebarOpen" x-transition class="truncate">Voir Boutique</span>
            </a>
        </nav>

        <!-- User -->
        <div class="p-6 border-t border-[var(--border-main)]">
            <div class="flex items-center gap-4 bg-[var(--bg-muted)] p-4 rounded-3xl">
                <div class="w-10 h-10 bg-[var(--primary)]/10 text-[var(--primary)] rounded-xl flex items-center justify-center font-black">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div x-show="sidebarOpen" x-transition class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-[var(--text-main)] truncate">{{ Auth::user()->name }}</p>
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Administrateur</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" x-show="sidebarOpen" class="text-slate-300 hover:text-red-500 transition-colors">
                        <i class="fas fa-power-off"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main :class="sidebarOpen ? 'lg:ml-80' : 'lg:ml-24'" 
          class="min-h-screen transition-all duration-300 ease-in-out">
        
        <!-- Top Bar (Mobile/Tools) -->
        <header class="bg-[var(--bg-surface)]/80 backdrop-blur-md border-b border-[var(--border-main)] sticky top-0 z-40 px-6 lg:px-8 py-4 flex items-center justify-between transition-colors duration-300">
            <!-- Mobile Menu Toggle -->
            <button @click="mobileMenuOpen = true" class="lg:hidden w-10 h-10 flex items-center justify-center text-slate-400 hover:text-primary transition-colors">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Desktop Toggle -->
            <button @click="sidebarOpen = !sidebarOpen" class="hidden lg:flex w-10 h-10 items-center justify-center text-slate-400 hover:text-[var(--primary)] transition-colors">
                <i class="fas" :class="sidebarOpen ? 'fa-indent' : 'fa-outdent'"></i>
            </button>

            <div class="lg:hidden flex items-center gap-4">
                <x-application-logo :minimal="true" class="h-8 w-auto" />
                <span class="text-xl font-black tracking-tight text-[var(--text-main)] hidden xs:block">Admin</span>
            </div>
            
            <div class="flex items-center gap-4 lg:gap-6">
                <!-- Notifications/Search placeholder -->
                <div class="text-slate-400 font-bold text-[10px] md:text-xs uppercase tracking-widest hidden sm:block">
                    {{ now()->translatedFormat('d F Y') }}
                </div>
                <div class="w-px h-4 bg-[var(--border-main)] hidden sm:block"></div>
                <a href="{{ route('home') }}" class="text-[10px] font-black text-[var(--primary)] uppercase tracking-[0.2em] hover:underline">
                   <span class="hidden md:inline">Retour boutique</span>
                   <i class="fas fa-home md:hidden text-base"></i>
                </a>
            </div>
        </header>

        <div class="p-4 md:p-8">
            {{ $slot }}
        </div>
    </main>
</body>
</html>
