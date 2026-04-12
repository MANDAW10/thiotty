<header class="header-main" x-data="{ 
    showLogin: {{ ($errors->any() && !old('name') && !old('phone') && !session('identity_verified') && !session('reset_user_id')) ? 'true' : 'false' }}, 
    showRegister: {{ (!Auth::check() && $errors->any() && (old('name') || old('phone'))) ? 'true' : 'false' }},
    showForgot: {{ session('status') && !str_contains(session('status'), 'profile') ? 'true' : 'false' }},
    showProfile: {{ (Auth::check() && ($errors->any() || session('status') === 'profile-updated')) ? 'true' : 'false' }},
    showResetForm: {{ (session('identity_verified') || session('reset_user_id') || $errors->has('password_reset_success') || $errors->has('reset_error')) ? 'true' : 'false' }},
    showMobileMenu: false,
    showSettings: false,
    accent: '#2B7A0B',
    wishlistCount: {{ Auth::check() ? Auth::user()->wishlists()->count() : 0 }},
    cartCount: {{ app(\App\Services\CartService::class)->getCount() }},
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
}" @wishlist-updated.window="wishlistCount = $event.detail.count" @cart-updated.window="cartCount = $event.detail.count" @open-login.window="showLogin = true">

    <!-- LEVEL 1: Top Bar (Contact Info) -->
    <div class="bg-[var(--primary)] text-white py-2 hidden md:block border-b border-white/10">
        <div class="container-custom flex justify-between items-center text-[10px] font-bold uppercase tracking-widest">
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-2">
                    <i class="fas fa-phone-alt"></i>
                    <span>+221 78 357 74 31</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-envelope"></i>
                    <span>contact@thiotty.com</span>
                </div>
            </div>
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-2">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Dakar, Sénégal</span>
                </div>
                <div class="flex items-center bg-white/10 rounded-none p-1 border border-white/20">
                    <a href="{{ route('language.switch', 'fr') }}" class="px-2 py-0.5 {{ App::getLocale() == 'fr' ? 'bg-white text-[var(--primary)]' : 'text-white' }}">FR</a>
                    <a href="{{ route('language.switch', 'en') }}" class="px-2 py-0.5 {{ App::getLocale() == 'en' ? 'bg-white text-[var(--primary)]' : 'text-white' }}">EN</a>
                </div>
            </div>
        </div>
    </div>

    <!-- LEVEL 2: Middle Bar (Brand & Search) -->
    <div class="bg-white py-6 md:py-8 border-b border-[var(--border-main)]">
        <div class="container-custom flex items-center justify-between gap-8 md:gap-12">
            <!-- Logo -->
            <div class="flex items-center gap-4 min-w-fit">
                <button @click="showMobileMenu = true" class="md:hidden p-2 text-slate-500 hover:text-primary transition-colors">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <a href="{{ route('home') }}" class="block">
                    <x-application-logo class="h-8 sm:h-12 w-auto" />
                </a>
            </div>

            <!-- Search Bar (Centered) -->
            <div class="flex-1 hidden md:block max-w-2xl mx-auto">
                <form action="{{ route('shop.search') }}" method="GET" class="relative group">
                    <input type="text" name="query" placeholder="{{ __('messages.search_placeholder') }}" 
                           class="w-full h-[50px] border border-[var(--border-main)] rounded-none px-6 py-3 text-sm focus:ring-1 focus:ring-[var(--primary)] focus:border-[var(--primary)] transition-all outline-none">
                    <button type="submit" class="absolute right-0 top-0 h-full w-[60px] bg-[var(--primary)] text-white hover:bg-[var(--primary-hover)] transition-colors">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-2 sm:gap-6 min-w-fit">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-3 p-2 group">
                                <i class="fas fa-user text-xl text-slate-400 group-hover:text-[var(--primary)] transition-colors"></i>
                                <div class="hidden lg:block text-left">
                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Mon Compte</p>
                                    <p class="text-[11px] font-bold text-slate-800 leading-none">{{ Auth::user()->name }}</p>
                                </div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link href="javascript:void(0)" @click="showProfile = true">{{ __('messages.profile') }}</x-dropdown-link>
                            @if(Auth::user()->is_admin)
                                <x-dropdown-link :href="route('admin.dashboard')" class="text-primary font-black">Administration</x-dropdown-link>
                            @endif
                            <x-dropdown-link :href="route('orders.index')">{{ __('messages.my_orders') }}</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-500">{{ __('messages.logout') }}</x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <button @click="showLogin = true" class="flex items-center gap-3 p-2 group">
                        <i class="fas fa-user-circle text-2xl text-slate-400 group-hover:text-[var(--primary)] transition-colors"></i>
                        <div class="hidden lg:block text-left">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Connexion</p>
                            <p class="text-[11px] font-bold text-slate-800 leading-none">S'identifier</p>
                        </div>
                    </button>
                @endauth

                <!-- Wishlist -->
                <a @auth href="{{ route('wishlist.index') }}" @else href="javascript:void(0)" @click="showLogin = true" @endauth 
                   class="relative p-2 group">
                    <i class="fas fa-heart text-xl text-slate-400 group-hover:text-[var(--primary)] transition-colors"></i>
                    <span x-show="wishlistCount > 0" x-text="wishlistCount" class="absolute -top-1 -right-1 bg-[var(--primary)] text-white text-[9px] font-bold w-4 h-5 flex items-center justify-center"></span>
                </a>

                <!-- Cart -->
                <a href="{{ route('cart.index') }}" class="relative p-2 group">
                    <div class="flex items-center gap-3">
                        <div class="relative">
                            <i class="fas fa-shopping-basket text-xl text-slate-400 group-hover:text-[var(--primary)] transition-colors"></i>
                            <span x-show="cartCount > 0" x-text="cartCount" class="absolute -top-1 -right-1 bg-[var(--primary)] text-white text-[9px] font-bold w-4 h-5 flex items-center justify-center"></span>
                        </div>
                        <div class="hidden lg:block text-left">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Mon Panier</p>
                            <p class="text-[11px] font-bold text-slate-800 leading-none">Panier</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- LEVEL 3: Bottom Bar (Navigation Menu) -->
    <div class="bg-[var(--primary)] hidden md:block">
        <div class="container-custom">
            <nav class="flex items-center">
                <a href="{{ route('home') }}" class="px-8 py-4 text-[13px] font-bold uppercase tracking-widest text-white hover:bg-white/10 transition-colors border-r border-white/10 {{ request()->routeIs('home') ? 'bg-white/20' : '' }}">
                    {{ __('messages.home') }}
                </a>
                <a href="{{ route('shop.index') }}" class="px-8 py-4 text-[13px] font-bold uppercase tracking-widest text-white hover:bg-white/10 transition-colors border-r border-white/10 {{ request()->routeIs('shop.index') ? 'bg-white/20' : '' }}">
                    {{ __('messages.shop') }}
                </a>
                <a href="{{ route('gallery') }}" class="px-8 py-4 text-[13px] font-bold uppercase tracking-widest text-white hover:bg-white/10 transition-colors border-r border-white/10 {{ request()->routeIs('gallery') ? 'bg-white/20' : '' }}">
                    {{ __('messages.gallery') }}
                </a>
                <a href="{{ route('contact') }}" class="px-8 py-4 text-[13px] font-bold uppercase tracking-widest text-white hover:bg-white/10 transition-colors border-r border-white/10 {{ request()->routeIs('contact') ? 'bg-white/20' : '' }}">
                    {{ __('messages.contact') }}
                </a>
                @auth
                    <a href="{{ route('orders.index') }}" class="px-8 py-4 text-[13px] font-bold uppercase tracking-widest text-white hover:bg-white/10 transition-colors border-r border-white/10">
                        {{ __('messages.my_orders') }}
                    </a>
                @endauth
                <div class="ml-auto flex items-center gap-4 text-white text-[10px] font-bold uppercase tracking-[0.2em] opacity-80">
                    <i class="fas fa-shipping-fast"></i>
                    <span>Livraison rapide partout au Sénégal</span>
                </div>
            </nav>
        </div>
    </div>

    <!-- Mobile Navigation Drawer -->
    <div x-show="showMobileMenu" class="fixed inset-0 z-[150] md:hidden" style="display: none;">
        <div @click="showMobileMenu = false" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
        <div x-show="showMobileMenu" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
             class="absolute inset-y-0 left-0 w-[280px] bg-white flex flex-col border-r border-slate-50">
            <div class="p-6 border-b border-slate-50 flex justify-between items-center bg-[var(--primary)]">
                <x-application-logo class="h-8 w-auto brightness-0 invert" />
                <button @click="showMobileMenu = false" class="text-white">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            <nav class="flex-1 overflow-y-auto p-0">
                <a href="{{ route('home') }}" class="flex items-center gap-4 p-5 border-b border-slate-100 text-[12px] font-bold uppercase tracking-widest text-slate-700">
                    <i class="fas fa-home w-5 text-[var(--primary)]"></i> Accueil
                </a>
                <a href="{{ route('shop.index') }}" class="flex items-center gap-4 p-5 border-b border-slate-100 text-[12px] font-bold uppercase tracking-widest text-slate-700">
                    <i class="fas fa-shopping-bag w-5 text-[var(--primary)]"></i> Boutique
                </a>
                <a href="{{ route('gallery') }}" class="flex items-center gap-4 p-5 border-b border-slate-100 text-[12px] font-bold uppercase tracking-widest text-slate-700">
                    <i class="fas fa-images w-5 text-[var(--primary)]"></i> Galerie
                </a>
                <a href="{{ route('contact') }}" class="flex items-center gap-4 p-5 border-b border-slate-100 text-[12px] font-bold uppercase tracking-widest text-slate-700">
                    <i class="fas fa-envelope w-5 text-[var(--primary)]"></i> Contact
                </a>
            </nav>
        </div>
    </div>
</header>


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
             class="bg-white w-full max-w-sm rounded-[40px] p-8 md:p-10 shadow-2xl relative max-h-[90vh] overflow-y-auto custom-scrollbar"
             x-data="{ showPass: false, loading: false }">
            
            <button @click="showLogin = false" class="absolute top-6 right-6 text-slate-300 hover:text-primary transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>

            <div class="mb-10 text-center">
                <div class="w-12 h-12 bg-primary/10 text-primary rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-primary/10">
                    <i class="fas fa-user text-xl"></i>
                </div>
                <h2 class="text-2xl font-black text-slate-900 mb-1">{{ __('messages.welcome_back') }}</h2>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em]">{{ __('messages.access_account') }} <span class="text-primary font-black">Thiotty</span></p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-6" @submit="loading = true">
                @csrf
                <div class="space-y-1.5">
                    <label for="modal_email" class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">{{ __('messages.email') }}</label>
                    <input id="modal_email" name="email" type="email" 
                           class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 font-bold text-slate-900 text-base md:text-sm focus:ring-2 focus:ring-primary/20 transition-all placeholder:text-slate-300" 
                           placeholder="votre@email.com"
                           required autofocus shadow-none>
                </div>

                <div class="space-y-1.5">
                    <div class="flex justify-between items-center ml-1">
                        <label for="modal_password" class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-400">{{ __('messages.password') }}</label>
                        <button type="button" @click="showLogin = false; showForgot = true" class="text-[9px] font-black text-primary uppercase tracking-widest hover:underline">{{ __('messages.forgot_password') }}</button>
                    </div>
                    <div class="relative group">
                        <input id="modal_password" name="password" :type="showPass ? 'text' : 'password'" 
                               class="w-full bg-slate-50 border-none rounded-2xl py-4 pl-6 pr-12 font-bold text-slate-900 text-base md:text-sm focus:ring-2 focus:ring-primary/20 transition-all placeholder:text-slate-300" 
                               placeholder="••••••••"
                               required>
                        <button type="button" @click="showPass = !showPass" class="absolute inset-y-0 right-0 pr-5 flex items-center text-slate-400 hover:text-primary transition-colors">
                            <i class="fas" :class="showPass ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="btn-thiotty w-full py-4 text-base shadow-xl shadow-primary/10 text-white relative overflow-hidden group" :disabled="loading">
                        <span x-show="!loading">{{ __('messages.login_btn') }}</span>
                        <span x-show="loading" class="flex items-center justify-center gap-3" style="display: none;">
                            <svg class="animate-spin h-5 w-5 text-white" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                    </button>
                </div>

                <div class="text-center pt-2">
                    <p class="text-[11px] font-bold text-slate-400">
                        {{ __('messages.no_account') }} 
                        <button type="button" @click="showLogin = false; showRegister = true" class="text-primary hover:underline ml-1 font-black">{{ __('messages.register_now') }}</button>
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
             class="bg-white w-full max-w-md rounded-[40px] p-8 md:p-10 shadow-2xl relative max-h-[90vh] overflow-y-auto custom-scrollbar"
             x-data="{ showPass: false, showConfirm: false, loading: false }">
            
            <button @click="showRegister = false" class="absolute top-6 right-6 text-slate-300 hover:text-primary transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>

            <div class="mb-8 text-center">
                <div class="w-12 h-12 bg-primary/10 text-primary rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-primary/10">
                    <i class="fas fa-user-plus text-xl"></i>
                </div>
                <h2 class="text-2xl font-black text-slate-900 mb-1">{{ __('messages.register_title') }}</h2>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em]">{{ __('messages.join_family') }}</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-4" @submit="loading = true">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label for="modal_reg_name" class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">{{ __('messages.full_name') }}</label>
                        <input id="modal_reg_name" name="name" type="text" 
                               class="w-full bg-slate-50 border-none rounded-xl py-3 px-5 font-bold text-slate-900 text-base md:text-xs focus:ring-2 focus:ring-primary/20 transition-all placeholder:text-slate-300" 
                               required placeholder="{{ __('messages.full_name') }}" value="{{ old('name') }}">
                    </div>
                    <div class="space-y-1.5">
                        <label for="modal_reg_phone" class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">{{ __('messages.phone_number') }}</label>
                        <div class="relative flex items-center">
                            <span class="absolute left-3 text-[10px] font-black text-primary bg-primary/10 px-1.5 py-0.5 rounded-md">+221</span>
                            <input id="modal_reg_phone" name="phone" type="tel" x-on:input="formatPhone($event)" 
                                   class="w-full bg-slate-50 border-none rounded-xl py-3 pl-14 pr-4 font-bold text-slate-900 text-base md:text-xs focus:ring-2 focus:ring-primary/20 transition-all font-sans placeholder:text-slate-300" 
                                   required placeholder="7x xxx xx" value="{{ old('phone') }}">
                        </div>
                    </div>
                </div>
                
                <div class="space-y-1.5">
                    <label for="modal_reg_email" class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Email</label>
                    <input id="modal_reg_email" name="email" type="email" 
                           class="w-full bg-slate-50 border-none rounded-xl py-3 px-5 font-bold text-slate-900 text-base md:text-xs focus:ring-2 focus:ring-primary/20 transition-all placeholder:text-slate-300" 
                           required placeholder="votre@email.com" value="{{ old('email') }}">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label for="modal_reg_password" class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">{{ __('messages.password') }}</label>
                        <div class="relative group">
                            <input id="modal_reg_password" name="password" :type="showPass ? 'text' : 'password'" 
                                   class="w-full bg-slate-50 border-none rounded-xl py-3 pl-5 pr-10 font-bold text-slate-900 text-base md:text-xs focus:ring-2 focus:ring-primary/20 transition-all placeholder:text-slate-300" 
                                   required placeholder="••••">
                            <button type="button" @click="showPass = !showPass" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-300 hover:text-primary transition-colors">
                                <i class="fas text-[10px]" :class="showPass ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                    </div>
                    <div class="space-y-1.5">
                        <label for="modal_reg_confirm" class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">{{ __('messages.confirm_password') }}</label>
                        <div class="relative group">
                            <input id="modal_reg_confirm" name="password_confirmation" :type="showConfirm ? 'text' : 'password'" 
                                   class="w-full bg-slate-50 border-none rounded-xl py-3 pl-5 pr-10 font-bold text-slate-900 text-base md:text-xs focus:ring-2 focus:ring-primary/20 transition-all placeholder:text-slate-300" 
                                   required placeholder="••••">
                            <button type="button" @click="showConfirm = !showConfirm" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-300 hover:text-primary transition-colors">
                                <i class="fas text-[10px]" :class="showConfirm ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="btn-thiotty w-full py-4 text-sm shadow-xl shadow-primary/10 text-white relative overflow-hidden group" :disabled="loading">
                        <span x-show="!loading">{{ __('messages.continue') }}</span>
                        <span x-show="loading" class="flex items-center justify-center gap-3" style="display: none;">
                            <svg class="animate-spin h-4 w-4 text-white" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                    </button>
                </div>

                <div class="text-center pt-2">
                    <p class="text-[11px] font-bold text-slate-400">
                        {{ __('messages.already_registered') }} 
                        <button type="button" @click="showRegister = false; showLogin = true" class="text-primary hover:underline ml-1 font-black">{{ __('messages.login') }}</button>
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
                <h2 class="text-2xl font-black text-slate-900 mb-1">{{ __('messages.forgot_password') }}</h2>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest px-8">{{ __('messages.forgot_text') }}</p>
            </div>

            @if (session('status'))
                <div class="mb-4 font-bold text-sm text-green-600 bg-green-50 p-4 rounded-2xl border border-green-100">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.verify-identity') }}" class="space-y-4">
                @csrf
                <div class="space-y-1">
                    <label for="forgot_email" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">{{ __('messages.email') }}</label>
                    <input id="forgot_email" name="email" type="email" class="w-full bg-slate-50 border-none rounded-2xl py-3 px-6 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all" value="{{ old('email') }}" required autofocus>
                </div>

                <div class="space-y-1">
                    <label for="forgot_phone" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">{{ __('messages.phone_number') }}</label>
                    <input id="forgot_phone" name="phone" type="tel" x-on:input="formatPhone($event)" class="w-full bg-slate-50 border-none rounded-2xl py-3 px-6 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all font-sans" required placeholder="7x xxx xx xx">
                    <x-input-error :messages="$errors->get('phone')" class="mt-1" />
                </div>

                <x-input-error :messages="$errors->get('forgot_identity')" class="mt-1" />

                <div class="pt-4">
                    <button type="submit" class="btn-thiotty w-full py-4 text-base shadow-xl shadow-primary/10 text-white">{{ __('messages.verify_identity') }}</button>
                </div>
            </form>

            <div class="text-center pt-2">
                <button type="button" @click="showForgot = false; showLogin = true" class="text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-primary transition-colors">
                    {{ __('messages.back_to_login') }}
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
                <h2 class="text-2xl font-black text-slate-900 mb-1">{{ __('messages.reset_password') }}</h2>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest px-8">{{ __('messages.reset_text') }}</p>
            </div>

            @if (session('password_reset_success'))
                <div class="mb-4 text-center">
                    <div class="text-green-600 font-bold mb-4">
                        <i class="fas fa-check-circle text-4xl mb-2 block"></i>
                        {{ session('password_reset_success') }}
                    </div>
                    <button @click="showResetForm = false; showLogin = true" class="btn-thiotty w-full py-4 text-white">Se connecter maintenant</button>
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
                        <button type="submit" class="btn-thiotty w-full py-4 text-base shadow-xl shadow-primary/10 text-white">{{ __('messages.reset_btn') }}</button>
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
                        <h2 class="text-2xl font-black text-slate-900">{{ __('messages.profile') }}</h2>
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
    <!-- Settings Modal (Theme Only) -->
    <div x-show="showSettings" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[200] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
         style="display: none;"
         @click.self="showSettings = false">
        
        <div x-show="showSettings"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             class="bg-white w-full max-w-md rounded-[40px] p-8 shadow-2xl relative overflow-hidden">
            
            <button @click="showSettings = false" class="absolute top-6 right-6 text-slate-300 hover:text-primary transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>

            <div class="mb-8">
                <div class="flex items-center gap-4 mb-2">
                    <div class="w-10 h-10 bg-primary/10 text-primary rounded-xl flex items-center justify-center">
                        <i class="fas fa-palette text-lg"></i>
                    </div>
                    <h2 class="text-2xl font-black text-slate-900 tracking-tight">{{ __('messages.customization') }}</h2>
                </div>
            </div>

            <div class="space-y-6">
                <div class="grid grid-cols-3 gap-4">
                    <!-- Thiotty Orange -->
                    <button @click="setAccent('#FF5722', '255, 87, 34')" 
                            class="group relative flex flex-col items-center gap-3 p-4 rounded-3xl transition-all border-2"
                            :class="accent === '#FF5722' ? 'border-primary bg-primary/5' : 'border-slate-50 bg-slate-50/50 hover:border-slate-200'">
                        <div class="w-10 h-10 rounded-full shadow-lg" style="background-color: #FF5722"></div>
                        <span class="text-[9px] font-black uppercase tracking-widest" :class="accent === '#FF5722' ? 'text-primary' : 'text-slate-400'">Thiotty</span>
                        <div x-show="accent === '#FF5722'" class="absolute -top-1 -right-1 w-5 h-5 bg-primary text-white rounded-full flex items-center justify-center text-[8px] border-2 border-white shadow-sm">
                            <i class="fas fa-check"></i>
                        </div>
                    </button>

                    <!-- Emerald -->
                    <button @click="setAccent('#10B981', '16, 185, 129')" 
                            class="group relative flex flex-col items-center gap-3 p-4 rounded-3xl transition-all border-2"
                            :class="accent === '#10B981' ? 'border-primary bg-primary/5' : 'border-slate-50 bg-slate-50/50 hover:border-slate-200'">
                        <div class="w-10 h-10 rounded-full shadow-lg" style="background-color: #10B981"></div>
                        <span class="text-[9px] font-black uppercase tracking-widest" :class="accent === '#10B981' ? 'text-primary' : 'text-slate-400'">Naturel</span>
                        <div x-show="accent === '#10B981'" class="absolute -top-1 -right-1 w-5 h-5 bg-primary text-white rounded-full flex items-center justify-center text-[8px] border-2 border-white shadow-sm">
                            <i class="fas fa-check"></i>
                        </div>
                    </button>

                    <!-- Indigo -->
                    <button @click="setAccent('#4F46E5', '79, 70, 229')" 
                            class="group relative flex flex-col items-center gap-3 p-4 rounded-3xl transition-all border-2"
                            :class="accent === '#4F46E5' ? 'border-primary bg-primary/5' : 'border-slate-50 bg-slate-50/50 hover:border-slate-200'">
                        <div class="w-10 h-10 rounded-full shadow-lg" style="background-color: #4F46E5"></div>
                        <span class="text-[9px] font-black uppercase tracking-widest" :class="accent === '#4F46E5' ? 'text-primary' : 'text-slate-400'">Royal</span>
                        <div x-show="accent === '#4F46E5'" class="absolute -top-1 -right-1 w-5 h-5 bg-primary text-white rounded-full flex items-center justify-center text-[8px] border-2 border-white shadow-sm">
                            <i class="fas fa-check"></i>
                        </div>
                    </button>

                    <!-- Rose -->
                    <button @click="setAccent('#E11D48', '225, 29, 72')" 
                            class="group relative flex flex-col items-center gap-3 p-4 rounded-3xl transition-all border-2"
                            :class="accent === '#E11D48' ? 'border-primary bg-primary/5' : 'border-slate-50 bg-slate-50/50 hover:border-slate-200'">
                        <div class="w-10 h-10 rounded-full shadow-lg" style="background-color: #E11D48"></div>
                        <span class="text-[9px] font-black uppercase tracking-widest" :class="accent === '#E11D48' ? 'text-primary' : 'text-slate-400'">Élégant</span>
                        <div x-show="accent === '#E11D48'" class="absolute -top-1 -right-1 w-5 h-5 bg-primary text-white rounded-full flex items-center justify-center text-[8px] border-2 border-white shadow-sm">
                            <i class="fas fa-check"></i>
                        </div>
                    </button>

                    <!-- Amber -->
                    <button @click="setAccent('#D97706', '217, 119, 6')" 
                            class="group relative flex flex-col items-center gap-3 p-4 rounded-3xl transition-all border-2"
                            :class="accent === '#D97706' ? 'border-primary bg-primary/5' : 'border-slate-50 bg-slate-50/50 hover:border-slate-200'">
                        <div class="w-10 h-10 rounded-full shadow-lg" style="background-color: #D97706"></div>
                        <span class="text-[9px] font-black uppercase tracking-widest" :class="accent === '#D97706' ? 'text-primary' : 'text-slate-400'">Chaud</span>
                        <div x-show="accent === '#D97706'" class="absolute -top-1 -right-1 w-5 h-5 bg-primary text-white rounded-full flex items-center justify-center text-[8px] border-2 border-white shadow-sm">
                            <i class="fas fa-check"></i>
                        </div>
                    </button>

                    <!-- Slate -->
                    <button @click="setAccent('#475569', '71, 85, 105')" 
                            class="group relative flex flex-col items-center gap-3 p-4 rounded-3xl transition-all border-2"
                            :class="accent === '#475569' ? 'border-primary bg-primary/5' : 'border-slate-50 bg-slate-50/50 hover:border-slate-200'">
                        <div class="w-10 h-10 rounded-full shadow-lg" style="background-color: #475569"></div>
                        <span class="text-[9px] font-black uppercase tracking-widest" :class="accent === '#475569' ? 'text-primary' : 'text-slate-400'">Minimal</span>
                        <div x-show="accent === '#475569'" class="absolute -top-1 -right-1 w-5 h-5 bg-primary text-white rounded-full flex items-center justify-center text-[8px] border-2 border-white shadow-sm">
                            <i class="fas fa-check"></i>
                        </div>
                    </button>
                </div>

                <div class="mt-8 p-6 bg-slate-50 rounded-[32px] border border-slate-100 flex items-center gap-5 translate-y-2">
                    <div class="p-3 bg-white rounded-2xl shadow-sm text-primary">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <p class="text-[10px] leading-relaxed font-bold text-slate-500 uppercase tracking-widest">
                        La couleur sélectionnée s'appliquera instantanément à tous les boutons et éléments d'interaction du site.
                    </p>
                </div>
            </div>
        </div>
    </div>
</header>
