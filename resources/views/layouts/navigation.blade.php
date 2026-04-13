@php
    $categoriesMenu = \App\Models\Category::with('children')->whereNull('parent_id')->get();
@endphp
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
    compareCount: {{ count(session('compare', [])) }},
    showCartDrawer: false,
    cartDrawerItems: [],
    cartDrawerTotal: 0,
    quickViewOpen: false,
    quickViewLoading: false,
    quickViewProduct: null,
    loadCartDrawer() {
        fetch('{{ route('cart.summary') }}', { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }})
            .then(r => r.json())
            .then(d => { this.cartDrawerItems = d.items; this.cartDrawerTotal = d.total; this.cartCount = d.count; });
    },
    removeCartItem(id) {
        fetch('{{ url('/cart/remove') }}/' + id, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        }).then(r => r.json()).then(d => {
            this.cartDrawerItems = d.items;
            this.cartDrawerTotal = d.total;
            this.cartCount = d.count;
        });
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
}" @wishlist-updated.window="wishlistCount = $event.detail.count" @cart-updated.window="cartCount = $event.detail.count; if(showCartDrawer) loadCartDrawer()" @compare-updated.window="compareCount = $event.detail.count" @open-login.window="showLogin = true" @open-quick-view.window="quickViewOpen = true; quickViewLoading = true; quickViewProduct = null; fetch($event.detail.url, { headers: { 'Accept': 'application/json' } }).then(r => r.json()).then(d => { quickViewProduct = d; quickViewLoading = false; }).catch(() => { quickViewLoading = false; })">

    <div class="hidden md:block bg-slate-900 text-white">
        <div class="container-custom flex justify-between items-center py-2.5 text-[9px] font-black uppercase tracking-[0.2em]">
            <a href="{{ route('contact') }}" class="text-white/60 hover:text-white transition-colors">{{ __('messages.privacy_terms') }}</a>
        </div>
    </div>

    <!-- MOBILE HEADER (Small screens only) -->
    <div class="md:hidden bg-white border-b border-slate-100 py-4 px-4 flex justify-between items-center sticky top-0 z-[100]">
        <button @click="showMobileMenu = true" class="text-slate-600">
            <i class="fas fa-bars text-xl"></i>
        </button>
        <a href="{{ route('home') }}">
            <x-application-logo class="h-8 w-auto" />
        </a>
        <button type="button" @click="showCartDrawer = true; loadCartDrawer()" class="relative text-slate-600">
            <i class="fas fa-shopping-basket text-xl"></i>
            <span x-show="cartCount > 0" x-text="cartCount" class="absolute -top-2 -right-2 bg-[var(--primary)] text-white text-[8px] font-bold w-4 h-4 flex items-center justify-center rounded-full"></span>
        </button>
    </div>

    <!-- LEVEL 2: Middle Bar (Logo, Search & Contact) -->
    <div class="bg-white py-6 md:py-8 border-b border-slate-100 hidden md:block">
        <div class="container-custom flex items-center justify-between gap-12">
            <!-- Logo -->
            <div class="min-w-fit">
                <a href="{{ route('home') }}" class="block">
                    <x-application-logo class="h-10 w-auto" />
                </a>
            </div>

            <!-- Segmented Search Bar -->
            <!-- LEVEL 2: UNIFIED INDUSTRIAL SEARCH BAR -->
            <div class="flex-1 max-w-2xl">
                <form action="{{ route('shop.search') }}" method="GET" class="flex items-center bg-slate-50 border border-slate-200 focus-within:border-[#206B13] focus-within:bg-white transition-all duration-300">
                    
                    <!-- Category Selection (Left) -->
                    <div class="relative min-w-[180px] border-r border-slate-200">
                        <select name="category" 
                                class="w-full pl-5 pr-8 bg-transparent border-none text-[10px] font-black uppercase tracking-widest text-slate-500 focus:ring-0 cursor-pointer py-4">
                            <option value="">{{ __('messages.all_categories') }}</option>
                            @foreach(App\Models\Category::all() as $cat)
                                <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>
                                    {{ $cat->display_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Input Field (Center) -->
                    <input type="text" name="query" value="{{ request('query') }}" 
                           placeholder="Rechercher un produit..."
                           class="flex-1 px-5 py-4 bg-transparent border-none text-sm font-bold text-slate-900 placeholder:text-slate-300 focus:ring-0 outline-none">
                    
                    <!-- Search Button (Right) -->
                    <button type="submit" class="px-8 flex items-center justify-center text-slate-400 hover:text-[#206B13] transition-colors">
                        <i class="fas fa-search text-lg"></i>
                    </button>
                </form>
            </div>


            <!-- Contact Blocks -->
            <div class="flex items-center gap-10 min-w-fit">
                <!-- Phone -->
                <div class="contact-header-block">
                    <i class="fas fa-phone-alt"></i>
                    <div class="flex flex-col">
                        <span class="label">Appelez Nous</span>
                        <span class="value">+221 78 357 74 31</span>
                    </div>
                </div>
                <!-- Email -->
                <div class="contact-header-block">
                    <i class="far fa-envelope"></i>
                    <div class="flex flex-col">
                        <span class="label">Envoyez mail</span>
                        <span class="value">contact@thiotty.com</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- LEVEL 3: Bottom Bar (Nav Menu & Actions) -->
    <div class="bg-white border-b border-slate-100 hidden md:block">
        <div class="container-custom flex items-center justify-between h-[60px]">
            <!-- Main Menu (Industrial Style) -->
            <nav class="flex items-center h-full flex-wrap gap-x-1">
                <!-- ACCUEIL -->
                <a href="{{ route('home') }}" class="nav-link-blocky {{ request()->routeIs('home') ? 'active' : '' }} font-black uppercase tracking-[0.15em] text-[10px]">
                    {{ __('messages.home') }}
                </a>

                @foreach($categoriesMenu as $parent)
                    <div class="relative h-full group" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                        <a href="{{ route('shop.index', ['category' => $parent->slug]) }}" 
                           class="nav-link-blocky flex items-center gap-2 {{ request('category') == $parent->slug ? 'active' : '' }} font-black uppercase tracking-[0.15em] text-[10px]">
                            {{ $parent->name }}
                            @if($parent->children->count())
                                <i class="fas fa-chevron-down text-[8px] transition-transform" :class="open ? 'rotate-180' : ''"></i>
                            @endif
                        </a>
                        @if($parent->children->count())
                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 translate-y-2"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 class="absolute top-full left-0 w-56 bg-white border-t-2 border-[var(--primary)] shadow-2xl z-50 py-3"
                                 style="display: none;">
                                @foreach($parent->children as $child)
                                    <a href="{{ route('shop.index', ['category' => $child->slug]) }}" class="block px-6 py-3 text-[10px] font-black uppercase tracking-widest text-slate-600 hover:text-[var(--primary)] hover:bg-slate-50 transition-colors">
                                        {{ $child->name }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach

                <!-- AUTRES -->
                <a href="{{ route('gallery') }}" class="nav-link-blocky {{ request()->routeIs('gallery') ? 'active' : '' }} font-black uppercase tracking-[0.15em] text-[10px]">
                    Galerie
                </a>
                <a href="{{ route('contact') }}" class="nav-link-blocky {{ request()->routeIs('contact') ? 'active' : '' }} font-black uppercase tracking-[0.15em] text-[10px]">
                    {{ __('messages.contact') }}
                </a>
            </nav>

            <!-- Action Icons & Auth -->
            <div class="flex items-center gap-8 h-full pl-6">
                <!-- Wishlist -->
                <a @auth href="{{ route('wishlist.index') }}" @else href="javascript:void(0)" @click="showLogin = true" @endauth 
                   class="relative group">
                    <i class="far fa-heart nav-action-icon"></i>
                    <span x-show="wishlistCount > 0" x-text="wishlistCount" class="absolute -top-3 -right-2 bg-[var(--primary)] text-white text-[8px] font-bold w-4 h-4 flex items-center justify-center rounded-full"></span>
                </a>

                <a href="{{ route('compare.index') }}" class="relative group" title="{{ __('messages.compare_title') }}">
                    <i class="fas fa-random nav-action-icon"></i>
                    <span x-show="compareCount > 0" x-text="compareCount" class="absolute -top-3 -right-2 bg-[var(--caawogi-blue)] text-white text-[8px] font-bold min-w-[1rem] h-4 px-0.5 flex items-center justify-center rounded-full"></span>
                </a>

                <button type="button" @click="showCartDrawer = true; loadCartDrawer()" class="flex items-center gap-3 group text-left">
                    <div class="relative">
                        <i class="fas fa-shopping-basket nav-action-icon"></i>
                        <span x-show="cartCount > 0" x-text="cartCount" class="absolute -top-3 -right-2 bg-[var(--primary)] text-white text-[8px] font-bold w-4 h-4 flex items-center justify-center rounded-full"></span>
                    </div>
                    <span class="text-[11px] font-black uppercase tracking-widest text-slate-800 hidden lg:inline">
                        CFA <span x-text="new Intl.NumberFormat('fr-FR').format(cartDrawerTotal || {{ app(\App\Services\CartService::class)->getTotalBalance() }})">0</span>
                    </span>
                </button>

                <!-- Auth -->
                <div class="h-4 w-[1px] bg-slate-200"></div>

                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-2 text-[11px] font-black uppercase tracking-widest hover:text-primary transition-colors">
                                <span>{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down text-[8px]"></i>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link href="javascript:void(0)" @click="showProfile = true">{{ __('messages.profile') }}</x-dropdown-link>
                            @if(Auth::user()->is_admin)
                                <x-dropdown-link :href="route('admin.dashboard')">{{ __('messages.admin_nav') }}</x-dropdown-link>
                            @endif
                            <x-dropdown-link :href="route('orders.index')">{{ __('messages.my_orders') }}</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-500">{{ __('messages.logout') }}</x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <button @click="showLogin = true" class="text-[11px] font-black uppercase tracking-[0.1em] hover:text-primary transition-colors">
                        CONNEXION / INSCRIPTION
                    </button>
                @endauth
            </div>
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
                <!-- ACCUEIL -->
                <a href="{{ route('home') }}" class="flex items-center gap-4 p-5 border-b border-slate-100 text-[12px] font-bold uppercase tracking-widest text-slate-700">
                    <i class="fas fa-home w-5 text-[var(--primary)]"></i> Accueil
                </a>

                @foreach($categoriesMenu as $parent)
                    <div x-data="{ open: false }">
                        <button @click="open = !open" class="w-full flex items-center justify-between p-5 border-b border-slate-100 text-[12px] font-bold uppercase tracking-widest text-slate-700">
                            <span class="flex items-center gap-4">
                                <i class="fas {{ $parent->icon ?? 'fa-folder' }} w-5 text-[var(--primary)]"></i> 
                                {{ $parent->name }}
                            </span>
                            @if($parent->children->count())
                                <i class="fas fa-chevron-down text-[10px] transition-transform" :class="open ? 'rotate-180' : ''"></i>
                            @endif
                        </button>
                        @if($parent->children->count())
                            <div x-show="open" x-collapse class="bg-slate-50 border-b border-slate-100">
                                @foreach($parent->children as $child)
                                    <a href="{{ route('shop.index', ['category' => $child->slug]) }}" class="block p-4 pl-14 text-[11px] font-bold text-slate-500 uppercase tracking-widest hover:text-[var(--primary)] transition-colors">
                                        {{ $child->name }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach

                <!-- AUTRES -->
                <a href="{{ route('gallery') }}" class="flex items-center gap-4 p-5 border-b border-slate-100 text-[12px] font-bold uppercase tracking-widest text-slate-700">
                    <i class="fas fa-images w-5 text-[var(--primary)]"></i> Galerie
                </a>
                <a href="{{ route('contact') }}" class="flex items-center gap-4 p-5 border-b border-slate-100 text-[12px] font-bold uppercase tracking-widest text-slate-700">
                    <i class="fas fa-envelope w-5 text-[var(--primary)]"></i> Contact
                </a>
            </nav>
        </div>
    </div>

    <!-- Panier latéral (type vitrine) -->
    <div x-show="showCartDrawer" class="fixed inset-0 z-[1200] md:justify-end flex" style="display: none;">
        <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" @click="showCartDrawer = false"></div>
        <div x-show="showCartDrawer" x-transition:enter="transition transform ease-out duration-300" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
             class="relative ml-auto w-full max-w-md h-full bg-white shadow-2xl flex flex-col border-l border-slate-100">
            <div class="flex items-center justify-between p-5 border-b border-slate-100 bg-slate-50">
                <h2 class="text-sm font-black uppercase tracking-widest text-slate-900">{{ __('messages.cart_drawer_title') }}</h2>
                <button type="button" @click="showCartDrawer = false" class="text-slate-400 hover:text-slate-900"><i class="fas fa-times text-lg"></i></button>
            </div>
            <div class="flex-1 overflow-y-auto p-5 space-y-4 custom-scrollbar">
                <p x-show="cartDrawerItems.length === 0" class="text-center text-slate-500 text-sm font-medium py-12">{{ __('messages.cart_drawer_empty') }}</p>
                <template x-for="item in cartDrawerItems" :key="item.id">
                    <div class="flex gap-3 border-b border-slate-100 pb-4">
                        <a :href="'/product/' + item.slug" class="w-20 h-20 shrink-0 border border-slate-100 bg-slate-50 overflow-hidden">
                            <img :src="item.image" :alt="item.name" class="w-full h-full object-cover">
                        </a>
                        <div class="flex-1 min-w-0">
                            <a :href="'/product/' + item.slug" class="font-black text-xs uppercase text-slate-900 line-clamp-2 hover:text-[var(--primary)]" x-text="item.name"></a>
                            <p class="text-[10px] text-slate-500 mt-1"><span x-text="item.quantity"></span> × <span x-text="new Intl.NumberFormat('fr-FR').format(item.price)"></span> CFA</p>
                            <button type="button" @click="removeCartItem(item.id)" class="text-[10px] font-black uppercase text-red-500 mt-2 hover:underline">{{ __('messages.remove_line') }}</button>
                        </div>
                    </div>
                </template>
            </div>
            <div class="p-5 border-t border-slate-100 space-y-3 bg-slate-50">
                <div class="flex justify-between text-sm font-black uppercase tracking-widest">
                    <span>Total</span>
                    <span class="text-[var(--primary)]">CFA <span x-text="new Intl.NumberFormat('fr-FR').format(cartDrawerTotal)"></span></span>
                </div>
                <a href="{{ route('cart.index') }}" class="block w-full text-center py-3.5 bg-white border-2 border-slate-200 text-slate-900 font-black text-[10px] uppercase tracking-widest hover:border-[var(--primary)] transition-colors">{{ __('messages.cart_drawer_view') }}</a>
                @auth
                <a href="{{ route('checkout.index') }}" class="block w-full text-center py-3.5 bg-[var(--primary)] text-white font-black text-[10px] uppercase tracking-widest hover:bg-slate-900 transition-colors">{{ __('messages.cart_drawer_checkout') }}</a>
                @else
                <button type="button" @click="showCartDrawer = false; showLogin = true" class="w-full py-3.5 bg-[var(--primary)] text-white font-black text-[10px] uppercase tracking-widest hover:bg-slate-900 transition-colors">{{ __('messages.cart_drawer_checkout') }}</button>
                @endauth
            </div>
        </div>
    </div>

    <!-- Aperçu rapide -->
    <div x-show="quickViewOpen" class="fixed inset-0 z-[1200] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" style="display: none;" @click.self="quickViewOpen = false">
        <div class="bg-white w-full max-w-lg max-h-[90vh] overflow-y-auto shadow-2xl relative custom-scrollbar" @click.stop>
            <button type="button" @click="quickViewOpen = false" class="absolute top-4 right-4 z-10 text-slate-400 hover:text-slate-900"><i class="fas fa-times text-xl"></i></button>
            <div x-show="quickViewLoading" class="p-16 flex justify-center text-[var(--primary)]"><i class="fas fa-circle-notch fa-spin text-3xl"></i></div>
            <div x-show="!quickViewLoading && quickViewProduct">
                <div class="aspect-square bg-slate-50">
                    <img :src="quickViewProduct.image" :alt="quickViewProduct.name" class="w-full h-full object-cover">
                </div>
                <div class="p-6 space-y-3">
                    <p class="text-[10px] font-black uppercase tracking-widest text-[var(--primary)]" x-text="quickViewProduct.category"></p>
                    <h3 class="text-xl font-black uppercase text-slate-900" x-text="quickViewProduct.name"></h3>
                    <div class="space-y-1">
                        <p x-show="quickViewProduct.has_sale" class="text-sm text-slate-400 line-through font-bold">CFA <span x-text="new Intl.NumberFormat('fr-FR').format(quickViewProduct.price)"></span></p>
                        <p class="text-2xl font-black text-[var(--primary)]">CFA <span x-text="new Intl.NumberFormat('fr-FR').format(quickViewProduct.selling_price)"></span></p>
                    </div>
                    <p class="text-sm text-slate-600 leading-relaxed" x-text="quickViewProduct.description"></p>
                    <p class="text-xs font-bold text-green-600" x-show="quickViewProduct.stock > 0">{{ __('messages.in_stock') }} : <span x-text="quickViewProduct.stock"></span></p>
                    <p class="text-xs font-bold text-red-500" x-show="quickViewProduct.stock <= 0">{{ __('messages.out_of_stock') }}</p>
                    <div class="flex flex-wrap gap-3 pt-2">
                        <a :href="quickViewProduct.url" class="flex-1 min-w-[140px] text-center py-3 bg-slate-900 text-white font-black text-[10px] uppercase tracking-widest hover:bg-[var(--primary)] transition-colors">{{ __('messages.view_items') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.navigation-modals')


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
