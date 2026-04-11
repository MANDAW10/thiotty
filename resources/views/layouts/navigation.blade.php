<header class="header-main" x-data="{ 
    showLogin: {{ ($errors->any() && !old('name') && !old('phone') && !session('identity_verified') && !session('reset_user_id')) ? 'true' : 'false' }}, 
    showRegister: {{ (!Auth::check() && $errors->any() && (old('name') || old('phone'))) ? 'true' : 'false' }},
    showForgot: {{ session('status') && !str_contains(session('status'), 'profile') ? 'true' : 'false' }},
    showProfile: {{ (Auth::check() && ($errors->any() || session('status') === 'profile-updated')) ? 'true' : 'false' }},
    showResetForm: {{ (session('identity_verified') || session('reset_user_id') || $errors->has('password_reset_success') || $errors->has('reset_error')) ? 'true' : 'false' }},
    showMobileMenu: false,
    showSettings: false,
    accent: localStorage.getItem('thiotty-accent') || '{{ Auth::user()->accent_color ?? "#FF5722" }}',
    accentRGB: localStorage.getItem('thiotty-accent-rgb') || '{{ Auth::user()->accent_rgb ?? "255, 87, 34" }}',
    wishlistCount: {{ Auth::check() ? Auth::user()->wishlists()->count() : 0 }},
    cartCount: {{ app(\App\Services\CartService::class)->getCount() }},
    setAccent(color, rgb) {
        this.accent = color;
        this.accentRGB = rgb;
        localStorage.setItem('thiotty-accent', color);
        localStorage.setItem('thiotty-accent-rgb', rgb);
        document.documentElement.style.setProperty('--primary', color);
        document.documentElement.style.setProperty('--shadow-color', rgb);
        
        @auth
        fetch('{{ route('profile.theme.update') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ accent_color: color, accent_rgb: rgb })
        });
        @endauth
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
}" @wishlist-updated.window="wishlistCount = $event.detail.count" @cart-updated.window="cartCount = $event.detail.count" @open-login.window="showLogin = true">
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
                        <input type="text" name="query" placeholder="{{ __('messages.search_placeholder') }}" class="search-input" value="{{ request('query') }}">
                    </div>
                </form>
            </div>

            <!-- Header Actions -->
            <div class="flex items-center gap-2 sm:gap-6">
                <!-- Language Switcher (Desktop) -->
                <div class="hidden lg:flex items-center bg-slate-100 rounded-full p-1 border border-slate-200">
                    <a href="{{ route('language.switch', 'fr') }}" 
                       class="px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full transition-all {{ App::getLocale() == 'fr' ? 'bg-white text-primary shadow-sm' : 'text-slate-400 hover:text-slate-600' }}">
                        FR
                    </a>
                    <a href="{{ route('language.switch', 'en') }}" 
                       class="px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full transition-all {{ App::getLocale() == 'en' ? 'bg-white text-primary shadow-sm' : 'text-slate-400 hover:text-slate-600' }}">
                        EN
                    </a>
                </div>

                <!-- Location -->
                <div class="hidden lg:flex items-center gap-2 text-sm font-medium text-slate-600">
                    <i class="fas fa-map-marker-alt text-primary"></i>
                    <span>{{ __('messages.dakar_senegal') }}</span>
                </div>
                

                <!-- Settings (Theme) - Hidden on mobile, moved to drawer -->
                <button @click="showSettings = true" class="hidden md:flex p-2 text-slate-500 hover:text-primary transition-colors group">
                    <i class="fas fa-cog text-xl transition-transform group-hover:rotate-90"></i>
                </button>

                <!-- Wishlist -->
                <a @auth href="{{ route('wishlist.index') }}" @else href="javascript:void(0)" @click="showLogin = true" @endauth 
                   class="relative p-2 text-slate-500 hover:text-primary transition-colors group">
                    <i class="fas fa-heart text-xl"></i>
                    <span x-show="wishlistCount > 0" x-text="wishlistCount" class="absolute -top-1 -right-1 bg-primary text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full ring-2 ring-white"></span>
                </a>

                <a href="{{ route('cart.index') }}" class="relative p-2 text-slate-500 hover:text-primary transition-colors group">
                    <i class="fas fa-shopping-cart text-xl"></i>
                    <span x-show="cartCount > 0" x-text="cartCount" class="absolute -top-1 -right-1 bg-primary text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full ring-2 ring-white">
                    </span>
                </a>


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
                                {{ __('messages.profile_linked_as') }} <strong>{{ Auth::user()->name }}</strong>
                            </div>
                            <x-dropdown-link href="javascript:void(0)" @click="showProfile = true">{{ __('messages.profile') }}</x-dropdown-link>
                            @if(Auth::user()->is_admin)
                                <x-dropdown-link :href="route('admin.dashboard')" class="text-primary font-black">Administration</x-dropdown-link>
                            @endif
                            <x-dropdown-link :href="route('orders.index')">{{ __('messages.my_orders') }}</x-dropdown-link>
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
                        <button @click="showRegister = true" class="hidden sm:block btn-thiotty py-2 px-6 text-sm">
                            {{ __('messages.register') }}
                        </button>
                    </div>
                @endauth
            </div>
        </div>

        <!-- Bottom Header: Navigation Links (Desktop Only) -->
        <div class="header-bottom hidden md:flex">
            <a href="{{ route('home') }}" class="nav-link-thiotty {{ request()->routeIs('home') ? 'active' : '' }}">{{ __('messages.home') }}</a>
            <a href="{{ route('gallery') }}" class="nav-link-thiotty {{ request()->routeIs('gallery') ? 'active' : '' }}">{{ __('messages.gallery') }}</a>
            @auth
                @if(Auth::user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}" class="nav-link-thiotty text-primary border-primary">Administration</a>
                @endif
                <a href="{{ route('orders.index') }}" class="nav-link-thiotty {{ request()->routeIs('orders.index') ? 'active' : '' }}">{{ __('messages.my_orders') }}</a>
                <a href="javascript:void(0)" @click="showProfile = true" class="nav-link-thiotty {{ request()->routeIs('profile.edit') ? 'active' : '' }}">{{ __('messages.profile') }}</a>
            @endauth
            <a href="{{ route('shop.index') }}" class="nav-link-thiotty {{ request()->routeIs('shop.index') ? 'active' : '' }}">{{ __('messages.shop') }}</a>
            <a href="{{ route('contact') }}" class="nav-link-thiotty {{ request()->routeIs('contact') ? 'active' : '' }}">{{ __('messages.contact') }}</a>
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
             class="absolute inset-y-0 left-0 w-[280px] bg-white shadow-2xl flex flex-col border-r border-slate-50">
            
            <div class="p-6 border-b border-slate-50 flex justify-between items-center">
                <x-application-logo class="h-8 w-auto" />
                <button @click="showMobileMenu = false" class="w-10 h-10 bg-slate-50 rounded-full flex items-center justify-center text-slate-400 hover:text-primary transition-colors">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>

            <nav class="flex-1 overflow-y-auto p-6 space-y-2">
                <a href="{{ route('home') }}" class="flex items-center gap-4 p-4 rounded-2xl {{ request()->routeIs('home') ? 'bg-primary/5 text-primary' : 'text-slate-600 hover:bg-slate-50' }} font-bold transition-all">
                    <i class="fas fa-home w-5"></i>
                    <span>{{ __('messages.home') }}</span>
                </a>
                <a href="{{ route('gallery') }}" class="flex items-center gap-4 p-4 rounded-2xl {{ request()->routeIs('gallery') ? 'bg-primary/5 text-primary' : 'text-slate-600 hover:bg-slate-50' }} font-bold transition-all">
                    <i class="fas fa-images w-5"></i>
                    <span>{{ __('messages.gallery') }}</span>
                </a>
                <a href="{{ route('shop.index') }}" class="flex items-center gap-4 p-4 rounded-2xl {{ request()->routeIs('shop.index') ? 'bg-primary/5 text-primary' : 'text-slate-600 hover:bg-slate-50' }} font-bold transition-all">
                    <i class="fas fa-shop w-5"></i>
                    <span>{{ __('messages.shop') }}</span>
                </a>
                @auth
                    @if(Auth::user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-4 p-4 rounded-2xl bg-primary/5 text-primary font-black transition-all">
                            <i class="fas fa-shield-halved w-5"></i>
                            <span>{{ __('messages.admin_nav') }}</span>
                        </a>
                    @endif
                    <a href="{{ route('orders.index') }}" class="flex items-center gap-4 p-4 rounded-2xl {{ request()->routeIs('orders.index') ? 'bg-primary/5 text-primary' : 'text-slate-600 hover:bg-slate-50' }} font-bold transition-all">
                        <i class="fas fa-box w-5"></i>
                        <span>{{ __('messages.my_orders') }}</span>
                    </a>
                    <button @click="showMobileMenu = false; showProfile = true" class="w-full flex items-center gap-4 p-4 rounded-2xl text-slate-600 hover:bg-slate-50 font-bold transition-all">
                        <i class="fas fa-user-circle w-5"></i>
                        <span>{{ __('messages.profile') }}</span>
                    </button>
                @endauth
                <a href="{{ route('contact') }}" class="flex items-center gap-4 p-4 rounded-2xl {{ request()->routeIs('contact') ? 'bg-primary/5 text-primary' : 'text-slate-600 hover:bg-slate-50' }} font-bold transition-all">
                    <i class="fas fa-envelope w-5"></i>
                    <span>{{ __('messages.contact') }}</span>
                </a>

                <div class="sm:hidden border-t border-slate-50 pt-4 mt-4">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 px-4">{{ __('messages.my_shortcuts') }}</p>
                    <a @auth href="{{ route('wishlist.index') }}" @else href="javascript:void(0)" @click="showMobileMenu = false; showLogin = true" @endauth 
                       class="flex items-center justify-between p-4 rounded-2xl text-slate-600 hover:bg-slate-50 font-bold transition-all">
                        <div class="flex items-center gap-4">
                            <i class="fas fa-heart w-5 text-red-400"></i>
                            <span>{{ __('messages.wishlist_nav') }}</span>
                        </div>
                        <span x-show="wishlistCount > 0" x-text="wishlistCount" class="bg-primary text-white text-[10px] px-2 py-0.5 rounded-full font-black"></span>
                    </a>

                    <button @click="showMobileMenu = false; showSettings = true" class="w-full flex items-center gap-4 p-4 rounded-2xl text-slate-600 hover:bg-slate-50 font-bold transition-all">
                        <i class="fas fa-palette w-5 text-amber-500"></i>
                        <span>{{ __('messages.customization') }}</span>
                    </button>

                    <!-- Language Switcher (Mobile) -->
                    <div class="mt-6 px-4">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Langue / Language</p>
                        <div class="flex items-center gap-2 p-1 bg-slate-50 rounded-2xl border border-slate-100">
                            <a href="{{ route('language.switch', 'fr') }}" 
                               class="flex-1 text-center py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ App::getLocale() == 'fr' ? 'bg-white text-primary shadow-sm ring-1 ring-slate-100' : 'text-slate-400' }}">
                                Français
                            </a>
                            <a href="{{ route('language.switch', 'en') }}" 
                               class="flex-1 text-center py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ App::getLocale() == 'en' ? 'bg-white text-primary shadow-sm ring-1 ring-slate-100' : 'text-slate-400' }}">
                                English
                            </a>
                        </div>
                    </div>
                 </div>
            </nav>

            <div class="p-6 border-t border-slate-50">
                @guest
                    <div class="grid grid-cols-2 gap-4">
                        <button @click="showMobileMenu = false; showLogin = true" class="py-4 rounded-2xl border border-slate-200 text-slate-600 font-bold text-[10px] uppercase tracking-widest hover:bg-slate-50 transition-all">{{ __('messages.login') }}</button>
                        <button @click="showMobileMenu = false; showRegister = true" class="btn-thiotty py-4 rounded-2xl text-[10px]">{{ __('messages.register') }}</button>
                    </div>
                @else
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full py-4 rounded-2xl bg-red-50 text-red-600 font-bold text-sm hover:bg-red-100 transition-all">
                            <i class="fas fa-power-off mr-2"></i> {{ __('messages.logout') }}
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
