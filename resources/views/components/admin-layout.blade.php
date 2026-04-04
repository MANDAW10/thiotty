<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Lahad Admin') }} - Administration</title>

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
<body class="bg-[var(--bg-page)] text-[var(--text-main)] font-sans antialiased overflow-x-hidden transition-colors duration-300" x-data="{ sidebarOpen: true }">
    
    <!-- Admin Sidebar -->
    <aside :class="sidebarOpen ? 'w-80' : 'w-24'" 
           class="fixed inset-y-0 left-0 bg-[var(--bg-surface)] border-r border-[var(--border-main)] z-50 transition-all duration-300 ease-in-out hidden lg:flex flex-col">
        
        <!-- Logo -->
        <div class="p-8 flex items-center gap-4">
            <x-application-logo :minimal="true" class="h-10 w-auto" />
            <span x-show="sidebarOpen" x-transition class="text-2xl font-black tracking-tight text-[var(--text-main)]">Administration</span>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-6 space-y-2 mt-8">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center gap-4 px-6 py-4 rounded-2xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-[var(--primary)] text-white shadow-lg shadow-primary/20' : 'text-slate-400 hover:bg-[var(--bg-muted)] hover:text-[var(--text-main)]' }}">
                    <i class="fas fa-th-large w-5 shrink-0"></i>
                    <span x-show="sidebarOpen" x-transition class="text-xs font-black uppercase tracking-widest truncate">Dashboard</span>
                </a>

                <!-- Produits -->
                <a href="{{ route('admin.products.index') }}" 
                   class="flex items-center gap-4 px-6 py-4 rounded-2xl transition-all {{ request()->routeIs('admin.products.*') ? 'bg-[var(--primary)] text-white shadow-lg shadow-primary/20' : 'text-slate-400 hover:bg-[var(--bg-muted)] hover:text-[var(--text-main)]' }}">
                    <i class="fas fa-box w-5 shrink-0"></i>
                    <span x-show="sidebarOpen" x-transition class="text-xs font-black uppercase tracking-widest truncate">Produits</span>
                </a>

                <!-- Commandes -->
                <a href="{{ route('admin.orders.index') }}" 
                   class="flex items-center gap-4 px-6 py-4 rounded-2xl transition-all {{ request()->routeIs('admin.orders.*') ? 'bg-[var(--primary)] text-white shadow-lg shadow-primary/20' : 'text-slate-400 hover:bg-[var(--bg-muted)] hover:text-[var(--text-main)]' }}">
                    <i class="fas fa-shopping-cart w-5 shrink-0"></i>
                    <span x-show="sidebarOpen" x-transition class="text-xs font-black uppercase tracking-widest truncate">Commandes</span>
                </a>

                <!-- Utilisateurs -->
                <a href="{{ route('admin.users.index') }}" 
                   class="flex items-center gap-4 px-6 py-4 rounded-2xl transition-all {{ request()->routeIs('admin.users.*') ? 'bg-[var(--primary)] text-white shadow-lg shadow-primary/20' : 'text-slate-400 hover:bg-[var(--bg-muted)] hover:text-[var(--text-main)]' }}">
                    <i class="fas fa-users w-5 shrink-0"></i>
                    <span x-show="sidebarOpen" x-transition class="text-xs font-black uppercase tracking-widest truncate">Utilisateurs</span>
                </a>

                <!-- Zones de Livraison -->
                <a href="{{ route('admin.zones.index') }}" 
                   class="flex items-center gap-4 px-6 py-4 rounded-2xl transition-all {{ request()->routeIs('admin.zones.*') ? 'bg-[var(--primary)] text-white shadow-lg shadow-primary/20' : 'text-slate-400 hover:bg-[var(--bg-muted)] hover:text-[var(--text-main)]' }}">
                    <i class="fas fa-truck w-5 shrink-0"></i>
                    <span x-show="sidebarOpen" x-transition class="text-xs font-black uppercase tracking-widest truncate">Zones</span>
                </a>

                <!-- Galerie -->
                <a href="{{ route('admin.gallery.index') }}" 
                   class="flex items-center gap-4 px-6 py-4 rounded-2xl transition-all {{ request()->routeIs('admin.gallery.*') ? 'bg-[var(--primary)] text-white shadow-lg shadow-primary/20' : 'text-slate-400 hover:bg-[var(--bg-muted)] hover:text-[var(--text-main)]' }}">
                    <i class="fas fa-images w-5 shrink-0"></i>
                    <span x-show="sidebarOpen" x-transition class="text-xs font-black uppercase tracking-widest truncate">Galerie</span>
                </a>

                <!-- Messages -->
                <a href="{{ route('admin.contacts.index') }}" 
                   class="flex items-center gap-4 px-6 py-4 rounded-2xl transition-all {{ request()->routeIs('admin.contacts.*') ? 'bg-[var(--primary)] text-white shadow-lg shadow-primary/20' : 'text-slate-400 hover:bg-[var(--bg-muted)] hover:text-[var(--text-main)]' }}">
                    <i class="fas fa-envelope w-5 shrink-0"></i>
                    <span x-show="sidebarOpen" x-transition class="text-xs font-black uppercase tracking-widest truncate">Messages</span>
                </a>

                <!-- Alertes -->
                <a href="{{ route('admin.alerts.index') }}" 
                   class="flex items-center gap-4 px-6 py-4 rounded-2xl transition-all {{ request()->routeIs('admin.alerts.*') ? 'bg-[var(--primary)] text-white shadow-lg shadow-primary/20' : 'text-slate-400 hover:bg-[var(--bg-muted)] hover:text-[var(--text-main)]' }}">
                    <i class="fas fa-bullhorn w-5 shrink-0"></i>
                    <span x-show="sidebarOpen" x-transition class="text-xs font-black uppercase tracking-widest truncate">Alertes</span>
                </a>

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
        <header class="bg-[var(--bg-surface)]/80 backdrop-blur-md border-b border-[var(--border-main)] sticky top-0 z-40 px-8 py-4 flex items-center justify-between transition-colors duration-300">
            <button @click="sidebarOpen = !sidebarOpen" class="hidden lg:flex w-10 h-10 items-center justify-center text-slate-400 hover:text-[var(--primary)] transition-colors">
                <i class="fas" :class="sidebarOpen ? 'fa-indent' : 'fa-outdent'"></i>
            </button>
            <div class="lg:hidden flex items-center gap-4">
                <x-application-logo :minimal="true" class="h-8 w-auto" />
                <span class="text-xl font-black tracking-tight text-[var(--text-main)]">Admin</span>
            </div>
            
            <div class="flex items-center gap-6">
                <!-- Notifications/Search placeholder -->
                <div class="text-slate-400 font-bold text-sm hidden md:block">
                    {{ now()->translatedFormat('d F Y') }}
                </div>
                <div class="w-px h-6 bg-[var(--border-main)] hidden md:block"></div>
                <a href="{{ route('home') }}" class="text-xs font-black text-[var(--primary)] uppercase tracking-widest hover:underline">
                    Retour boutique
                </a>
            </div>
        </header>

        <div class="p-8">
            {{ $slot }}
        </div>
    </main>

    <!-- Mobile Drawer (Optional) -->
    <!-- Could add a slide-over for mobile admin if needed -->
</body>
</html>
