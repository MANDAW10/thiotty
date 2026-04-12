<x-app-layout>
    <!-- CAAWOGI 1:1 HERO SECTION (TWO-COLUMN INDUSTRIAL) -->
    <section class="relative bg-white pt-2 sm:pt-4">
        <div class="container-custom px-2 sm:px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 sm:gap-4">
                <!-- LEFT: VIANDE DE BOEUF -->
                <a href="{{ route('shop.index', ['category' => 'agro-alimentaire']) }}" class="relative group h-[400px] md:h-[550px] overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1607623814075-e41dfee430ef?q=80&w=2000&auto=format&fit=crop" class="w-full h-full object-cover transition-transform duration-[3000ms] group-hover:scale-110" alt="Viande de Boeuf">
                    <div class="absolute inset-0 bg-black/20 group-hover:bg-black/10 transition-colors"></div>
                    <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-8">
                        <h2 class="text-3xl md:text-5xl font-black text-white uppercase tracking-tight mb-6">VIANDE DE BOEUF</h2>
                        <span class="inline-block px-8 py-4 bg-[var(--primary)] text-white font-black text-[11px] uppercase tracking-widest hover:bg-white hover:text-[var(--primary)] transition-all">
                            Voir Plus
                        </span>
                    </div>
                </a>

                <!-- RIGHT: POULET DE CHAIR -->
                <a href="{{ route('shop.index', ['category' => 'volaille']) }}" class="relative group h-[400px] md:h-[550px] overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1548550023-2bdb3c5beed7?q=80&w=2000&auto=format&fit=crop" class="w-full h-full object-cover transition-transform duration-[3000ms] group-hover:scale-110" alt="Poulet de Chair">
                    <div class="absolute inset-0 bg-black/20 group-hover:bg-black/10 transition-colors"></div>
                    <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-8">
                        <h2 class="text-3xl md:text-5xl font-black text-white uppercase tracking-tight mb-6">POULET DE CHAIR</h2>
                        <span class="inline-block px-8 py-4 bg-[var(--primary)] text-white font-black text-[11px] uppercase tracking-widest hover:bg-white hover:text-[var(--primary)] transition-all">
                            Voir Plus
                        </span>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- CAAWOGI FEATURES SECTION -->
    <section class="py-12 border-b border-slate-100 bg-white">
        <div class="container-custom">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="flex flex-col items-center text-center group">
                    <div class="w-16 h-16 bg-slate-50 flex items-center justify-center text-[var(--primary)] text-2xl mb-4 group-hover:bg-[var(--primary)] group-hover:text-white transition-all">
                        <i class="fas fa-truck-fast"></i>
                    </div>
                    <h3 class="text-[11px] font-black uppercase tracking-widest text-slate-800">Livraison Express</h3>
                    <p class="text-[9px] font-bold text-slate-400 uppercase mt-1 tracking-tighter">Sénégal & Sous-région</p>
                </div>
                <div class="flex flex-col items-center text-center group">
                    <div class="w-16 h-16 bg-slate-50 flex items-center justify-center text-[var(--primary)] text-2xl mb-4 group-hover:bg-[var(--primary)] group-hover:text-white transition-all">
                        <i class="fas fa-shield-halved"></i>
                    </div>
                    <h3 class="text-[11px] font-black uppercase tracking-widest text-slate-800">Qualité Certifiée</h3>
                    <p class="text-[9px] font-bold text-slate-400 uppercase mt-1 tracking-tighter">Contrôles Stricts</p>
                </div>
                <div class="flex flex-col items-center text-center group">
                    <div class="w-16 h-16 bg-slate-50 flex items-center justify-center text-[var(--primary)] text-2xl mb-4 group-hover:bg-[var(--primary)] group-hover:text-white transition-all">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h3 class="text-[11px] font-black uppercase tracking-widest text-slate-800">Produits Bio</h3>
                    <p class="text-[9px] font-bold text-slate-400 uppercase mt-1 tracking-tighter">Héritage Terroir</p>
                </div>
                <div class="flex flex-col items-center text-center group">
                    <div class="w-16 h-16 bg-slate-50 flex items-center justify-center text-[var(--primary)] text-2xl mb-4 group-hover:bg-[var(--primary)] group-hover:text-white transition-all">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3 class="text-[11px] font-black uppercase tracking-widest text-slate-800">Support Client</h3>
                    <p class="text-[9px] font-bold text-slate-400 uppercase mt-1 tracking-tighter">Assistance 24/7</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Meilleures ventes (type Caawogi) -->
    <section class="py-20 bg-[var(--light-bg)] border-y border-slate-100">
        <div class="container-custom">
            <div class="text-center max-w-3xl mx-auto mb-14">
                <h2 class="text-3xl md:text-4xl font-black text-slate-900 uppercase tracking-tight mb-4">{{ __('messages.best_sellers_title') }}</h2>
                <p class="text-slate-500 text-sm md:text-base font-medium leading-relaxed">{{ __('messages.best_sellers_intro') }}</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 md:gap-6">
                @foreach($bestSellers->take(6) as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
            <div class="mt-12 text-center">
                <a href="{{ route('shop.index') }}" class="inline-flex px-12 py-4 bg-[var(--primary)] text-white font-black text-[11px] uppercase tracking-widest hover:bg-slate-900 transition-colors">
                    {{ __('messages.shop') }}
                </a>
            </div>
        </div>
    </section>

    <!-- Blocs valeurs (NOS CATÉGORIES / promesses) -->
    <section class="py-16 bg-white">
        <div class="container-custom">
            <h2 class="text-center text-2xl md:text-3xl font-black uppercase tracking-tight text-slate-900 mb-12">{{ __('messages.our_universes') }}</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="border border-slate-100 p-8 bg-slate-50/50 hover:border-[var(--primary)]/30 transition-colors">
                    <div class="w-14 h-14 bg-[var(--primary)]/10 text-[var(--primary)] flex items-center justify-center text-xl mb-6"><i class="fas fa-cow"></i></div>
                    <h3 class="text-lg font-black uppercase text-slate-900 mb-3">{{ __('messages.vaches') }}</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">{{ __('messages.quality_text') }}</p>
                </div>
                <div class="border border-slate-100 p-8 bg-slate-50/50 hover:border-[var(--primary)]/30 transition-colors">
                    <div class="w-14 h-14 bg-[var(--caawogi-blue)]/15 text-[var(--caawogi-blue)] flex items-center justify-center text-xl mb-6"><i class="fas fa-shield-halved"></i></div>
                    <h3 class="text-lg font-black uppercase text-slate-900 mb-3">{{ __('messages.quality_certified') }}</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">{{ __('messages.trust_secure_pay_desc') }}</p>
                </div>
                <div class="border border-slate-100 p-8 bg-slate-50/50 hover:border-[var(--primary)]/30 transition-colors">
                    <div class="w-14 h-14 bg-[var(--secondary)]/20 text-amber-700 flex items-center justify-center text-xl mb-6"><i class="fas fa-handshake"></i></div>
                    <h3 class="text-lg font-black uppercase text-slate-900 mb-3">{{ __('messages.client_trust') }}</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">{{ __('messages.trust_refund_desc') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CAAWOGI SPLIT SECTION (IMAGE + GRID) -->
    <section class="py-20 bg-white overflow-hidden">
        <div class="container-custom">
            <div class="flex flex-col lg:flex-row gap-0 border border-slate-100">
                <!-- Left: Big Image -->
                <div class="lg:w-2/5 relative h-[450px] lg:h-auto overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1548550023-2bdb3c5beed7?q=80&w=2000&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover" alt="Héritage Terroir">
                    <div class="absolute inset-x-0 bottom-0 p-10 bg-gradient-to-t from-slate-900/80 to-transparent">
                        <h2 class="text-3xl font-black text-white uppercase tracking-tight leading-tight">
                            Découvrez le pouvoir de la beauté naturelle
                        </h2>
                        <a href="{{ route('shop.index') }}" class="inline-block mt-8 px-10 py-4 bg-[var(--primary)] text-white font-black text-[11px] uppercase tracking-widest hover:bg-white hover:text-slate-900 transition-all">
                            Voir la Boutique
                        </a>
                    </div>
                </div>
                <!-- Right: Product Grid -->
                <div class="lg:w-3/5 p-8 lg:p-12 bg-slate-50">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($featuredProducts->skip(4)->take(3) as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CAAWOGI VEDETTE SECTION (REFINED) -->
    <section class="py-24 bg-white">
        <div class="container-custom">
            <div class="flex flex-col items-center mb-16 text-center">
                <h3 class="text-4xl md:text-5xl font-black text-[var(--caawogi-blue)] uppercase tracking-tight mb-6">Produits en vedette</h3>
                <p class="text-slate-400 text-sm md:text-base max-w-2xl font-medium">
                    Chez Thiotty, nous mettons en avant des produits de qualité, pensés pour répondre à vos besoins au quotidien.
                </p>
                <div class="h-1.5 w-24 bg-[var(--caawogi-blue)] mt-8"></div>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-8">
                @foreach($featuredProducts->take(8) as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>

            <div class="mt-20 text-center">
                <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-6 px-16 py-6 bg-slate-900 text-white font-black text-[12px] uppercase tracking-widest hover:bg-[var(--primary)] transition-all">
                    Explorer Notre Boutique
                </a>
            </div>
        </div>
    </section>

    <!-- CAAWOGI ICON BAR (TRUST BAR) -->
    <section class="py-12 border-y border-slate-100 bg-[#F9F9F9]">
        <div class="container-custom">
            <div class="flex flex-wrap items-center justify-around gap-12 opacity-40">
                <i class="fas fa-star text-3xl hover:opacity-100 transition-opacity"></i>
                <i class="fas fa-gem text-3xl hover:opacity-100 transition-opacity"></i>
                <i class="fas fa-leaf text-3xl hover:opacity-100 transition-opacity"></i>
                <i class="fas fa-phone-flip text-3xl hover:opacity-100 transition-opacity"></i>
                <i class="fas fa-envelope text-3xl hover:opacity-100 transition-opacity"></i>
                <i class="fas fa-crown text-3xl hover:opacity-100 transition-opacity"></i>
            </div>
        </div>
    </section>

    <!-- Newsletter + confiance -->
    <section class="py-20 bg-white border-t border-slate-100">
        <div class="container-custom grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <h3 class="text-3xl font-black uppercase text-slate-900 mb-2">{{ __('messages.newsletter_title') }}</h3>
                <p class="text-slate-500 mb-6 font-medium">{{ __('messages.newsletter_subtitle') }}</p>
                @if(session('newsletter_ok'))
                    <p class="text-green-600 font-bold text-sm mb-4">{{ __('messages.newsletter_success') }}</p>
                @endif
                <form action="{{ route('newsletter.subscribe') }}" method="POST" class="flex flex-col sm:flex-row gap-3">
                    @csrf
                    <input type="email" name="email" required placeholder="{{ __('messages.newsletter_placeholder') }}"
                           class="flex-1 px-5 py-4 border border-slate-200 text-sm font-bold focus:ring-2 focus:ring-[var(--primary)] focus:border-transparent outline-none"
                           value="{{ old('email') }}">
                    <button type="submit" class="px-8 py-4 bg-[var(--primary)] text-white font-black text-[11px] uppercase tracking-widest hover:bg-slate-900 transition-colors">
                        {{ __('messages.newsletter_cta') }}
                    </button>
                </form>
                @error('email')
                    <p class="text-red-500 text-xs font-bold mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="grid sm:grid-cols-2 gap-6">
                <div class="p-6 border border-slate-100 bg-[var(--light-bg)]">
                    <i class="fas fa-truck-fast text-[var(--primary)] text-xl mb-3"></i>
                    <h4 class="font-black text-xs uppercase tracking-widest text-slate-900 mb-2">{{ __('messages.trust_free_shipping') }}</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">{{ __('messages.trust_free_shipping_desc') }}</p>
                </div>
                <div class="p-6 border border-slate-100 bg-[var(--light-bg)]">
                    <i class="fas fa-lock text-[var(--caawogi-blue)] text-xl mb-3"></i>
                    <h4 class="font-black text-xs uppercase tracking-widest text-slate-900 mb-2">{{ __('messages.trust_secure_pay') }}</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">{{ __('messages.trust_secure_pay_desc') }}</p>
                </div>
                <div class="p-6 border border-slate-100 bg-[var(--light-bg)]">
                    <i class="fas fa-headset text-[var(--secondary)] text-xl mb-3"></i>
                    <h4 class="font-black text-xs uppercase tracking-widest text-slate-900 mb-2">{{ __('messages.trust_support') }}</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">{{ __('messages.trust_support_desc') }}</p>
                </div>
                <div class="p-6 border border-slate-100 bg-[var(--light-bg)]">
                    <i class="fas fa-rotate-left text-slate-700 text-xl mb-3"></i>
                    <h4 class="font-black text-xs uppercase tracking-widest text-slate-900 mb-2">{{ __('messages.trust_refund') }}</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">{{ __('messages.trust_refund_desc') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CAAWOGI MASSIVE BRAND BANNER -->
    <section class="relative h-[500px] flex items-center overflow-hidden">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=2000&auto=format&fit=crop" class="w-full h-full object-cover" alt="Héritage Thiotty">
            <div class="absolute inset-0 bg-[var(--primary)]/80 mix-blend-multiply"></div>
        </div>
        <div class="container-custom relative z-10 text-center text-white">
            <h2 class="text-4xl md:text-7xl font-black uppercase tracking-tight mb-8">L'EXCELLENCE À<br>PORTÉE DE MAIN</h2>
            <p class="text-lg md:text-xl font-medium mb-12 max-w-3xl mx-auto text-white/80">
                Thiotty Enterprise s'engage pour une agriculture moderne, durable et respectueuse de l'environnement au Sénégal.
            </p>
            <a href="{{ route('gallery') }}" class="inline-flex items-center gap-4 px-12 py-5 border-2 border-white text-white font-black text-[11px] uppercase tracking-widest hover:bg-white hover:text-[var(--primary)] transition-all">
                VOIR NOTRE HISTOIRE
            </a>
        </div>
    </section>

    <!-- CATEGORIES GRID (INDUSTRIAL) -->
    <section class="py-24 bg-slate-50">
        <div class="container-custom">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($categories->take(3) as $cat)
                    <a href="{{ route('shop.category', $cat->slug) }}" class="relative group h-[350px] overflow-hidden border border-slate-200">
                        <img src="{{ $cat->image_url }}" class="absolute inset-0 w-full h-full object-cover grayscale brightness-75 transition-all duration-700 group-hover:grayscale-0 group-hover:scale-110" alt="{{ $cat->display_name }}">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent"></div>
                        <div class="absolute bottom-10 left-10">
                            <h4 class="text-3xl font-black text-white uppercase tracking-tight mb-4">{{ $cat->display_name }}</h4>
                            <div class="h-1 w-12 bg-[var(--primary)] group-hover:w-full transition-all duration-500"></div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
</x-app-layout>
