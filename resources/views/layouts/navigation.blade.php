<header class="header-main" x-data="{ 
    showLogin: {{ $errors->hasAny('email', 'password') ? 'true' : 'false' }}, 
    showRegister: {{ $errors->hasAny('name', 'email', 'phone', 'password_confirmation') ? 'true' : 'false' }},
    showForgot: {{ session('status') ? 'true' : 'false' }},
    showProfile: {{ session('status') === 'profile-updated' || $errors->hasAny('name', 'email', 'phone', 'current_password', 'password') ? 'true' : 'false' }},
    showResetForm: {{ session('identity_verified') || $errors->has('password_reset_success') || $errors->has('reset_error') || $errors->hasAny('password', 'password_confirmation') && session('reset_user_id') ? 'true' : 'false' }},
    showMobileMenu: false,
    showSettings: false,
    theme: localStorage.getItem('lahad-theme') || 'light',
    accent: localStorage.getItem('lahad-accent') || '#E65100',
    accentRGB: localStorage.getItem('lahad-accent-rgb') || '230, 81, 0',
    wishlistCount: {{ Auth::check() ? Auth::user()->wishlists()->count() : 0 }},
    toggleTheme() {
        this.theme = this.theme === 'light' ? 'dark' : 'light';
        localStorage.setItem('lahad-theme', this.theme);
        if (this.theme === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    },
    setAccent(color, rgb) {
        this.accent = color;
        this.accentRGB = rgb;
        localStorage.setItem('lahad-accent', color);
        localStorage.setItem('lahad-accent-rgb', rgb);
        document.documentElement.style.setProperty('--primary', color);
        document.documentElement.style.setProperty('--shadow-color', rgb);
    },
    formatPhone(e) {
        let val = e.target.value.replace(/\D/g, '');
        if (val.length > 9) val = val.substring(0, 9);
        let formatted = '';
        if (val.length > 0) {
            formatted = val.substring(0, 2);
            if (val.length > 2) formatted += ' ' + val.substring(2, 5);
            if (val.length > 5) formatted += ' ' + val.substring(5, 7);
            if (val.length > 7) formatted += ' ' + val.substring(7, 9);
        }
        e.target.value = formatted;
    }
}" @wishlist-updated.window="wishlistCount = $event.detail.count" @open-login.window="showLogin = true">
    <div class="container-custom">
        <!-- Top Header: Logo, Search, Actions -->
        <div class="header-top">
            <div class="flex items-center gap-2 sm:gap-4">
                <button @click="showMobileMenu = true" class="md:hidden p-2 text-slate-500 hover:text-primary transition-colors">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <a href="{{ route('home') }}" class="group">
                    <x-application-logo class="h-6 sm:h-8 w-auto" />
                </a>
            </div>

            <!-- Search Bar -->
            <div class="search-bar-container hidden md:block">
                <form action="{{ route('shop.search') }}" method="GET">
                    <div class="relative">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="text" name="query" placeholder="Rechercher des produits, catégories..." class="search-input" value="{{ request('query') }}">
                    </div>
                </form>
            </div>

            <!-- Header Actions -->
            <div class="flex items-center gap-2 sm:gap-6">
                <!-- Location -->
                <div class="hidden lg:flex items-center gap-2 text-sm font-medium text-slate-600">
                    <i class="fas fa-map-marker-alt text-primary"></i>
                    <span>Dakar, Sénégal</span>
                </div>
                
                <!-- Notifications (Hidden on extra small) -->
                <button class="hidden sm:block relative p-2 text-slate-500 hover:text-primary transition-colors">
                    <i class="fas fa-bell text-xl"></i>
                    <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                </button>

                <!-- Settings (Hidden on mobile) -->
                <button @click="showSettings = true" class="hidden sm:block p-2 text-slate-500 hover:text-primary transition-colors hover:rotate-90 transition-transform duration-500">
                    <i class="fas fa-cog text-xl"></i>
                </button>

                <!-- Wishlist (Hidden on mobile) -->
                <a @auth href="{{ route('wishlist.index') }}" @else href="javascript:void(0)" @click="showLogin = true" @endauth 
                   class="hidden sm:block relative p-2 text-slate-500 hover:text-primary transition-colors group">
                    <i class="fas fa-heart text-xl"></i>
                    <span x-show="wishlistCount > 0" x-text="wishlistCount" class="absolute -top-1 -right-1 bg-primary text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full ring-2 ring-white"></span>
                </a>

                <!-- Cart -->
                <a href="{{ route('cart.index') }}" class="relative p-2 text-slate-500 hover:text-primary transition-colors group">
                    <i class="fas fa-shopping-cart text-xl"></i>
                    @php $cartCount = count(Session::get('cart', [])); @endphp
                    <span class="absolute -top-1 -right-1 bg-primary text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full ring-2 ring-white">
                        {{ $cartCount }}
                    </span>
                </a>

                <!-- Language Switcher (Hidden on mobile) -->
                <div class="hidden sm:flex items-center gap-2 bg-slate-50 p-1.5 rounded-2xl border border-slate-100">
                    <a href="{{ route('language.switch', 'en') }}" class="w-8 h-8 flex items-center justify-center rounded-xl text-[10px] font-black transition-all {{ app()->getLocale() == 'en' ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-slate-400 hover:text-primary hover:bg-white' }}">EN</a>
                    <a href="{{ route('language.switch', 'fr') }}" class="w-8 h-8 flex items-center justify-center rounded-xl text-[10px] font-black transition-all {{ app()->getLocale() == 'fr' ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-slate-400 hover:text-primary hover:bg-white' }}">FR</a>
                </div>

                <!-- User Profile / Inscription -->
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="p-1 rounded-full border-2 border-transparent hover:border-primary transition-all">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=E65100&color=fff" class="w-8 h-8 rounded-full">
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="px-4 py-2 border-b border-slate-50 text-xs text-slate-500">
                                {{ __('messages.profile_linked_as') ?? 'Connecté en tant que' }} <strong>{{ Auth::user()->name }}</strong>
                            </div>
                            <x-dropdown-link href="javascript:void(0)" @click="showProfile = true">{{ __('messages.profile') }}</x-dropdown-link>
                            @if(Auth::user()->is_admin)
                                <x-dropdown-link :href="route('admin.dashboard')" class="text-primary font-black">Administration</x-dropdown-link>
                            @endif
                            <x-dropdown-link :href="route('orders.history')">{{ __('messages.my_orders') }}</x-dropdown-link>
                            <div class="border-t border-slate-50"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-500">{{ __('messages.logout') }}</x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex items-center gap-1 sm:gap-2">
                        <button @click="showLogin = true" class="p-2 text-slate-500 hover:text-primary transition-colors">
                            <i class="fas fa-user-circle text-2xl"></i>
                        </button>
                        <button @click="showRegister = true" class="hidden sm:block btn-lahad py-2 px-6 text-sm">
                            {{ __('messages.register') }}
                        </button>
                    </div>
                @endauth
            </div>
        </div>

        <!-- Bottom Header: Navigation Links (Desktop Only) -->
        <div class="header-bottom hidden md:flex">
            <a href="{{ route('home') }}" class="nav-link-lahad {{ request()->routeIs('home') ? 'active' : '' }}">{{ __('messages.home') }}</a>
            <a href="{{ route('gallery') }}" class="nav-link-lahad {{ request()->routeIs('gallery') ? 'active' : '' }}">{{ __('messages.gallery') }}</a>
            @auth
                @if(Auth::user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}" class="nav-link-lahad text-primary border-primary">Administration</a>
                @endif
                <a href="{{ route('orders.history') }}" class="nav-link-lahad {{ request()->routeIs('orders.history') ? 'active' : '' }}">{{ __('messages.my_orders') }}</a>
                <a href="javascript:void(0)" @click="showProfile = true" class="nav-link-lahad {{ request()->routeIs('profile.edit') ? 'active' : '' }}">{{ __('messages.profile') }}</a>
            @endauth
            <a href="{{ route('shop.index') }}" class="nav-link-lahad {{ request()->routeIs('shop.index') ? 'active' : '' }}">{{ __('messages.shop') }}</a>
            <a href="{{ route('contact') }}" class="nav-link-lahad {{ request()->routeIs('contact') ? 'active' : '' }}">{{ __('messages.contact') }}</a>
        </div>
    </div>

    <!-- Mobile Navigation Drawer -->
    <div x-show="showMobileMenu" 
         class="fixed inset-0 z-[150] md:hidden"
         style="display: none;">
        <!-- Backdrop -->
        <div x-show="showMobileMenu" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="showMobileMenu = false"
             class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
        
        <!-- Drawer Content -->
        <div x-show="showMobileMenu"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full"
             class="absolute inset-y-0 left-0 w-[280px] bg-white shadow-2xl flex flex-col">
            
            <div class="p-6 border-b border-slate-50 flex justify-between items-center">
                <x-application-logo class="h-8 w-auto" />
                <button @click="showMobileMenu = false" class="text-slate-400 hover:text-primary transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <nav class="flex-1 overflow-y-auto p-6 space-y-2">
                <a href="{{ route('home') }}" class="flex items-center gap-4 p-4 rounded-2xl {{ request()->routeIs('home') ? 'bg-primary/5 text-primary' : 'text-slate-600 hover:bg-slate-50' }} font-bold transition-all">
                    <i class="fas fa-home w-5"></i>
                    <span>Accueil</span>
                </a>
                <a href="{{ route('gallery') }}" class="flex items-center gap-4 p-4 rounded-2xl {{ request()->routeIs('gallery') ? 'bg-primary/5 text-primary' : 'text-slate-600 hover:bg-slate-50' }} font-bold transition-all">
                    <i class="fas fa-images w-5"></i>
                    <span>Galerie</span>
                </a>
                <a href="{{ route('shop.index') }}" class="flex items-center gap-4 p-4 rounded-2xl {{ request()->routeIs('shop.index') ? 'bg-primary/5 text-primary' : 'text-slate-600 hover:bg-slate-50' }} font-bold transition-all">
                    <i class="fas fa-shop w-5"></i>
                    <span>Produits</span>
                </a>
                @auth
                    @if(Auth::user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-4 p-4 rounded-2xl bg-primary/5 text-primary font-black transition-all">
                            <i class="fas fa-shield-halved w-5"></i>
                            <span>Administration</span>
                        </a>
                    @endif
                    <a href="{{ route('orders.history') }}" class="flex items-center gap-4 p-4 rounded-2xl {{ request()->routeIs('orders.history') ? 'bg-primary/5 text-primary' : 'text-slate-600 hover:bg-slate-50' }} font-bold transition-all">
                        <i class="fas fa-box w-5"></i>
                        <span>Mes Commandes</span>
                    </a>
                    <button @click="showMobileMenu = false; showProfile = true" class="w-full flex items-center gap-4 p-4 rounded-2xl text-slate-600 hover:bg-slate-50 font-bold transition-all">
                        <i class="fas fa-user-circle w-5"></i>
                        <span>Mon Profil</span>
                    </button>
                @endauth
                <a href="{{ route('contact') }}" class="flex items-center gap-4 p-4 rounded-2xl {{ request()->routeIs('contact') ? 'bg-primary/5 text-primary' : 'text-slate-600 hover:bg-slate-50' }} font-bold transition-all">
                    <i class="fas fa-envelope w-5"></i>
                    <span>Contact</span>
                </a>

                <div class="sm:hidden border-t border-slate-50 pt-4 mt-4">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 px-4">Mes Raccourcis</p>
                    <a @auth href="{{ route('wishlist.index') }}" @else href="javascript:void(0)" @click="showMobileMenu = false; showLogin = true" @endauth 
                       class="flex items-center justify-between p-4 rounded-2xl text-slate-600 hover:bg-slate-50 font-bold transition-all">
                        <div class="flex items-center gap-4">
                            <i class="fas fa-heart w-5"></i>
                            <span>Liste de souhaits</span>
                        </div>
                        <span x-show="wishlistCount > 0" x-text="wishlistCount" class="bg-primary text-white text-[10px] px-2 py-0.5 rounded-full font-black"></span>
                    </a>
                    <button class="w-full flex items-center justify-between p-4 rounded-2xl text-slate-600 hover:bg-slate-50 font-bold transition-all">
                        <div class="flex items-center gap-4">
                            <i class="fas fa-bell w-5"></i>
                            <span>Notifications</span>
                        </div>
                        <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                    </button>
                    <button @click="showMobileMenu = false; showSettings = true" class="w-full flex items-center gap-4 p-4 rounded-2xl text-slate-600 hover:bg-slate-50 font-bold transition-all">
                        <i class="fas fa-palette w-5"></i>
                        <span>Réglages Thème</span>
                    </button>
                    <!-- Mobile Language Selection -->
                    <div class="flex items-center gap-3 p-4 bg-slate-50 rounded-2xl mt-4">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest flex-1">Langue / Language</p>
                        <a href="{{ route('language.switch', 'en') }}" class="w-10 h-10 flex items-center justify-center rounded-xl text-[10px] font-black transition-all {{ app()->getLocale() == 'en' ? 'bg-primary text-white' : 'bg-white text-slate-400 border border-slate-100' }}">EN</a>
                        <a href="{{ route('language.switch', 'fr') }}" class="w-10 h-10 flex items-center justify-center rounded-xl text-[10px] font-black transition-all {{ app()->getLocale() == 'fr' ? 'bg-primary text-white' : 'bg-white text-slate-400 border border-slate-100' }}">FR</a>
                    </div>
                </div>
            </nav>

            <div class="p-6 border-t border-slate-50">
                @guest
                    <div class="grid grid-cols-2 gap-3">
                        <button @click="showMobileMenu = false; showLogin = true" class="py-3 rounded-xl border border-slate-200 text-slate-600 font-bold text-xs uppercase tracking-widest hover:bg-slate-50 transition-all">Connexion</button>
                        <button @click="showMobileMenu = false; showRegister = true" class="btn-lahad py-3 rounded-xl text-xs">Inscription</button>
                    </div>
                @else
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full py-4 rounded-2xl bg-red-50 text-red-600 font-bold text-sm hover:bg-red-100 transition-all">
                            <i class="fas fa-power-off mr-2"></i> Déconnexion
                        </button>
                    </form>
                @endguest
            </div>
        </div>
    </div>

    <!-- Login Modal -->
    <div x-show="showLogin" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
         style="display: none;"
         @click.self="showLogin = false">
        
        <div x-show="showLogin"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             class="bg-white w-full max-w-md rounded-[40px] p-8 md:p-10 shadow-2xl relative max-h-[90vh] overflow-y-auto custom-scrollbar">
            
            <button @click="showLogin = false" class="absolute top-6 right-6 text-slate-300 hover:text-primary transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>

            <div class="mb-6 text-center">
                <div class="w-12 h-12 bg-primary/10 text-primary rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user text-xl"></i>
                </div>
                <h2 class="text-2xl font-black text-slate-900 mb-1">Bienvenue</h2>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest px-8">Accédez à votre compte <span class="text-primary">Lahad</span></p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                <div class="space-y-1">
                    <label for="modal_email" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Email</label>
                    <input id="modal_email" name="email" type="email" class="w-full bg-slate-50 border-none rounded-2xl py-3.5 px-6 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all" required autofocus>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="space-y-1">
                    <div class="flex justify-between items-center ml-1">
                        <label for="modal_password" class="text-[10px] font-black uppercase tracking-widest text-slate-400">Mot de passe</label>
                        <button type="button" @click="showLogin = false; showForgot = true" class="text-[9px] font-black text-primary uppercase tracking-widest hover:underline">Oublié ?</button>
                    </div>
                    <input id="modal_password" name="password" type="password" class="w-full bg-slate-50 border-none rounded-2xl py-3.5 px-6 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all" required>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <button type="submit" class="btn-lahad w-full py-4 text-base shadow-xl shadow-primary/10 text-white">Se Connecter</button>

                <div class="text-center pt-2">
                    <p class="text-xs font-bold text-slate-400">
                        Pas de compte ? 
                        <button type="button" @click="showLogin = false; showRegister = true" class="text-primary hover:underline ml-1 font-black">Inscrivez-vous</button>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <!-- Register Modal -->
    <div x-show="showRegister" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
         style="display: none;"
         @click.self="showRegister = false">
        
        <div x-show="showRegister"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             class="bg-white w-full max-w-md rounded-[40px] p-6 md:p-8 shadow-2xl relative max-h-[90vh] overflow-y-auto custom-scrollbar">
            
            <button @click="showRegister = false" class="absolute top-6 right-6 text-slate-300 hover:text-primary transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>

            <div class="mb-4 text-center sm:block hidden">
                <div class="w-10 h-10 bg-primary/10 text-primary rounded-xl flex items-center justify-center mx-auto mb-2">
                    <i class="fas fa-user-plus text-lg"></i>
                </div>
                <h2 class="text-xl font-black text-slate-900">Inscription</h2>
            </div>
            
            <div class="block sm:hidden mb-4 text-left px-2">
                <h2 class="text-xl font-black text-slate-900">Inscription</h2>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Rejoignez <span class="text-primary">Lahad</span></p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-2">
                @csrf
                <div class="grid grid-cols-2 gap-3">
                    <div class="space-y-1">
                        <label for="modal_reg_name" class="text-[9px] font-black uppercase tracking-widest text-slate-400 ml-1">Nom</label>
                        <input id="modal_reg_name" name="name" type="text" class="w-full bg-slate-50 border-none rounded-xl py-2 px-4 font-bold text-slate-900 text-sm focus:ring-2 focus:ring-primary/20 transition-all" required placeholder="Nom">
                    </div>
                    <div class="space-y-1">
                        <label for="modal_reg_phone" class="text-[9px] font-black uppercase tracking-widest text-slate-400 ml-1">Numéro</label>
                        <input id="modal_reg_phone" name="phone" type="tel" x-on:input="formatPhone($event)" class="w-full bg-slate-50 border-none rounded-xl py-2 px-4 font-bold text-slate-900 text-sm focus:ring-2 focus:ring-primary/20 transition-all font-sans" required placeholder="7x xxx xx">
                    </div>
                </div>
                
                <div class="space-y-1">
                    <label for="modal_reg_email" class="text-[9px] font-black uppercase tracking-widest text-slate-400 ml-1">Email</label>
                    <input id="modal_reg_email" name="email" type="email" class="w-full bg-slate-50 border-none rounded-xl py-2 px-4 font-bold text-slate-900 text-sm focus:ring-2 focus:ring-primary/20 transition-all" required placeholder="Email">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div class="space-y-1">
                        <label for="modal_reg_password" class="text-[9px] font-black uppercase tracking-widest text-slate-400 ml-1">Pass</label>
                        <input id="modal_reg_password" name="password" type="password" class="w-full bg-slate-50 border-none rounded-xl py-2 px-4 font-bold text-slate-900 text-sm focus:ring-2 focus:ring-primary/20 transition-all" required placeholder="****">
                    </div>
                    <div class="space-y-1">
                        <label for="modal_reg_confirm" class="text-[9px] font-black uppercase tracking-widest text-slate-400 ml-1">Confirmer</label>
                        <input id="modal_reg_confirm" name="password_confirmation" type="password" class="w-full bg-slate-50 border-none rounded-xl py-2 px-4 font-bold text-slate-900 text-sm focus:ring-2 focus:ring-primary/20 transition-all" required placeholder="****">
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="btn-lahad w-full py-3 text-sm shadow-xl shadow-primary/10 text-white">Continuer</button>
                </div>

                <div class="text-center pt-1">
                    <p class="text-[10px] font-bold text-slate-400">
                        Déjà inscrit ? 
                        <button type="button" @click="showRegister = false; showLogin = true" class="text-primary hover:underline ml-1 font-black">Connexion</button>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <!-- Forgot Password Modal -->
    <div x-show="showForgot" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
         style="display: none;"
         @click.self="showForgot = false">
        
        <div x-show="showForgot"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             class="bg-white w-full max-w-md rounded-[40px] p-8 md:p-10 shadow-2xl relative max-h-[90vh] overflow-y-auto custom-scrollbar">
            
            <button @click="showForgot = false" class="absolute top-6 right-6 text-slate-300 hover:text-primary transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>

            <div class="mb-6 text-center">
                <div class="w-12 h-12 bg-primary/10 text-primary rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-shield-halved text-xl"></i>
                </div>
                <h2 class="text-2xl font-black text-slate-900 mb-1">Mot de passe oublié</h2>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest px-8">Vérifiez votre identité pour réinitialiser</p>
            </div>

            @if (session('status'))
                <div class="mb-4 font-bold text-sm text-green-600 bg-green-50 p-4 rounded-2xl border border-green-100">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.verify-identity') }}" class="space-y-4">
                @csrf
                <div class="space-y-1">
                    <label for="forgot_email" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Email du compte</label>
                    <input id="forgot_email" name="email" type="email" class="w-full bg-slate-50 border-none rounded-2xl py-3 px-6 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all" value="{{ old('email') }}" required autofocus>
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>

                <div class="space-y-1">
                    <label for="forgot_phone" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Numéro de téléphone</label>
                    <input id="forgot_phone" name="phone" type="tel" x-on:input="formatPhone($event)" class="w-full bg-slate-50 border-none rounded-2xl py-3 px-6 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all font-sans" required placeholder="7x xxx xx xx">
                    <x-input-error :messages="$errors->get('phone')" class="mt-1" />
                </div>

                <x-input-error :messages="$errors->get('forgot_identity')" class="mt-1" />

                <div class="pt-4">
                    <button type="submit" class="btn-lahad w-full py-4 text-base shadow-xl shadow-primary/10 text-white">Vérifier mon identité</button>
                </div>
            </form>

            <div class="text-center pt-2">
                <button type="button" @click="showForgot = false; showLogin = true" class="text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-primary transition-colors">
                    Retour à la connexion
                </button>
            </div>
        </div>
    </div>

    <!-- Reset Password Modal (Step 2) -->
    <div x-show="showResetForm" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
         style="display: none;"
         @click.self="showResetForm = false">
        
        <div x-show="showResetForm"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             class="bg-white w-full max-w-md rounded-[40px] p-8 md:p-10 shadow-2xl relative">
            
            <button @click="showResetForm = false" class="absolute top-6 right-6 text-slate-300 hover:text-primary transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>

            <div class="mb-6 text-center">
                <div class="w-12 h-12 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-key-skeleton text-xl"></i>
                </div>
                <h2 class="text-2xl font-black text-slate-900 mb-1">Nouveau mot de passe</h2>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest px-8">Identité vérifiée ! Définissez votre nouveau secret</p>
            </div>

            @if (session('password_reset_success'))
                <div class="mb-4 text-center">
                    <div class="text-green-600 font-bold mb-4">
                        <i class="fas fa-check-circle text-4xl mb-2 block"></i>
                        {{ session('password_reset_success') }}
                    </div>
                    <button @click="showResetForm = false; showLogin = true" class="btn-lahad w-full py-4 text-white">Se connecter maintenant</button>
                </div>
            @else
                <form method="POST" action="{{ route('password.custom-reset') }}" class="space-y-4">
                    @csrf
                    <div class="space-y-1">
                        <label for="reset_password" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Nouveau mot de passe</label>
                        <input id="reset_password" name="password" type="password" class="w-full bg-slate-50 border-none rounded-2xl py-3 px-6 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all" required autofocus>
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>

                    <div class="space-y-1">
                        <label for="reset_password_confirmation" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Confirmer mot de passe</label>
                        <input id="reset_password_confirmation" name="password_confirmation" type="password" class="w-full bg-slate-50 border-none rounded-2xl py-3 px-6 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all font-sans" required>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                    </div>

                    <x-input-error :messages="$errors->get('reset_error')" class="mt-1" />

                    <div class="pt-4">
                        <button type="submit" class="btn-lahad w-full py-4 text-base shadow-xl shadow-primary/10 text-white">Réinitialiser le mot de passe</button>
                    </div>
                </form>
            @endif
        </div>
    </div>

    <!-- Profile Modal -->
    @auth
    <div x-show="showProfile" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
         style="display: none;"
         @click.self="showProfile = false">
        
        <div x-show="showProfile"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             class="bg-white w-full max-w-2xl rounded-[40px] p-6 md:p-8 shadow-2xl relative overflow-hidden flex flex-col max-h-[90vh]">
            
            <button @click="showProfile = false" class="absolute top-6 right-6 text-slate-300 hover:text-primary transition-colors z-10">
                <i class="fas fa-times text-xl"></i>
            </button>

            <div class="mb-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-primary/10 text-primary rounded-2xl flex items-center justify-center">
                        <i class="fas fa-user-gear text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-black text-slate-900">Mon Profil</h2>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Gérez vos informations et votre sécurité</p>
                    </div>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto pr-2 custom-scrollbar space-y-8 pb-4">
                <!-- Info Section -->
                <div class="bg-slate-50 rounded-3xl p-6 border border-slate-100">
                    @include('profile.partials.update-profile-information-form', ['user' => Auth::user()])
                </div>

                <!-- Password Section -->
                <div class="bg-slate-50 rounded-3xl p-6 border border-slate-100">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>
    </div>
    @endauth

    <!-- Theme Settings Modal -->
    <div x-show="showSettings" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[1001] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
         style="display: none;"
         @click.self="showSettings = false">
        
        <div x-show="showSettings"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 scale-95 translate-x-12"
             x-transition:enter-end="opacity-100 scale-100 translate-x-0"
             class="bg-[var(--bg-surface)] w-full max-w-sm rounded-[40px] p-8 md:p-10 shadow-2xl relative border border-[var(--border-main)]">
            
            <button @click="showSettings = false" class="absolute top-6 right-6 text-slate-300 hover:text-primary transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>

            <div class="mb-8 text-center">
                <div class="w-12 h-12 bg-primary/10 text-primary rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-palette text-xl"></i>
                </div>
                <h2 class="text-2xl font-black text-[var(--text-main)] mb-1">Apparence</h2>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest px-8">Personnalisez votre expérience</p>
            </div>

            <div class="space-y-8">
                <!-- Theme Select -->
                <div class="space-y-4">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Mode d'affichage</label>
                    <div class="grid grid-cols-2 gap-3">
                        <button @click="if(theme === 'dark') toggleTheme()" 
                                :class="theme === 'light' ? 'bg-primary text-white' : 'bg-[var(--bg-muted)] text-slate-400'"
                                class="flex flex-col items-center gap-2 p-4 rounded-2xl transition-all border border-transparent">
                            <i class="fas fa-sun text-lg"></i>
                            <span class="text-[10px] font-black uppercase tracking-widest">Clair</span>
                        </button>
                        <button @click="if(theme === 'light') toggleTheme()" 
                                :class="theme === 'dark' ? 'bg-primary text-white' : 'bg-[var(--bg-muted)] text-slate-400'"
                                class="flex flex-col items-center gap-2 p-4 rounded-2xl transition-all border border-transparent">
                            <i class="fas fa-moon text-lg"></i>
                            <span class="text-[10px] font-black uppercase tracking-widest">Sombre</span>
                        </button>
                    </div>
                </div>

                <!-- Color Select -->
                <div class="space-y-4">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Couleur d'accentuation</label>
                    <div class="grid grid-cols-4 gap-4">
                        <!-- Orange -->
                        <button @click="setAccent('#E65100', '230, 81, 0')" 
                                class="w-full aspect-square rounded-full flex items-center justify-center transition-all bg-[#E65100] hover:scale-110 shadow-lg shadow-orange-500/20"
                                :class="accent === '#E65100' ? 'ring-4 ring-orange-500/30' : ''">
                            <i x-show="accent === '#E65100'" class="fas fa-check text-white text-xs"></i>
                        </button>
                        <!-- Green -->
                        <button @click="setAccent('#1B5E20', '27, 94, 32')" 
                                class="w-full aspect-square rounded-full flex items-center justify-center transition-all bg-[#1B5E20] hover:scale-110 shadow-lg shadow-green-500/20"
                                :class="accent === '#1B5E20' ? 'ring-4 ring-green-500/30' : ''">
                            <i x-show="accent === '#1B5E20'" class="fas fa-check text-white text-xs"></i>
                        </button>
                        <!-- Blue -->
                        <button @click="setAccent('#0284c7', '2, 132, 199')" 
                                class="w-full aspect-square rounded-full flex items-center justify-center transition-all bg-[#0284c7] hover:scale-110 shadow-lg shadow-blue-500/20"
                                :class="accent === '#0284c7' ? 'ring-4 ring-blue-500/30' : ''">
                            <i x-show="accent === '#0284c7'" class="fas fa-check text-white text-xs"></i>
                        </button>
                        <!-- Purple -->
                        <button @click="setAccent('#7c3aed', '124, 58, 237')" 
                                class="w-full aspect-square rounded-full flex items-center justify-center transition-all bg-[#7c3aed] hover:scale-110 shadow-lg shadow-purple-500/20"
                                :class="accent === '#7c3aed' ? 'ring-4 ring-purple-500/30' : ''">
                            <i x-show="accent === '#7c3aed'" class="fas fa-check text-white text-xs"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="mt-10 pt-6 border-t border-[var(--border-main)] text-center text-[9px] font-black text-slate-400 uppercase tracking-widest">
                Interface Lahad v2.5 ✨
            </div>
        </div>
    </div>
</header>
