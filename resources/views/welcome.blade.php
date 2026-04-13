<x-app-layout>
    <!-- PREMIUM DYNAMIC HERO SLIDER (ALPINJS) -->
    <section class="relative bg-white overflow-hidden shadow-sm"
             x-data="{
                activeSlide: 0,
                slides: @js($slides),
                next() { this.activeSlide = (this.activeSlide + 1) % this.slides.length },
                start() { if(this.slides.length > 1) setInterval(() => this.next(), 6500) }
             }"
             x-init="start()">

        <!-- Slides Container -->
        <div class="relative h-[550px] md:h-[850px] w-full bg-slate-100">
            <template x-for="(slide, index) in slides" :key="index">
                <div x-show="activeSlide === index"
                     x-transition:enter="transition ease-out duration-1000"
                     x-transition:enter-start="opacity-0 scale-105"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-800"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="absolute inset-0 w-full h-full">

                    <img :src="slide.image_url" :alt="slide.title" class="w-full h-full object-cover">
                    <!-- Overlay with Text -->
                    <div class="absolute inset-0 bg-slate-900/20 flex flex-col justify-center px-10 md:px-24">
                        <div class="max-w-3xl"
                             x-show="activeSlide === index"
                             x-transition:enter="transition ease-out delay-500 duration-1000"
                             x-transition:enter-start="opacity-0 translate-y-10"
                             x-transition:enter-end="opacity-100 translate-y-0">
                            <h2 class="text-4xl md:text-7xl font-black text-white uppercase tracking-tight leading-[1.1] mb-6 drop-shadow-2xl" x-text="slide.title"></h2>
                            <p class="text-base md:text-2xl text-white/95 font-medium mb-10 drop-shadow-xl max-w-xl" x-text="slide.subtitle"></p>
                            <a :href="slide.button_url || '/shop'"
                               class="inline-block bg-[#206B13] hover:bg-[#1a550f] text-white px-10 py-5 rounded-full text-xs font-black uppercase tracking-[0.2em] transition-all transform hover:scale-105 shadow-xl"
                               x-text="slide.button_text || 'Voir Boutique'">
                            </a>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <!-- DOUBLE WAVE LAYER (THE "GAME") -->
        <div class="absolute bottom-[-2px] left-0 w-full overflow-hidden leading-[0] z-20">
            <!-- Semi-transparent Wave -->
            <svg class="absolute bottom-0 left-0 w-full h-[80px] md:h-[150px] opacity-40 translate-y-2 md:translate-y-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5,73.84-4.36,147.54,16.88,218.2,35.26,69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" fill="#ffffff"></path>
            </svg>
            <!-- Solid White Wave -->
            <svg class="relative block w-full h-[60px] md:h-[120px]" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V120H0V95.8C58.42,86.36,125.17,92.32,185.06,94.75,232,96.53,276.7,65.34,321.39,56.44Z" fill="#ffffff"></path>
            </svg>
        </div>

        <!-- Floating Chat Icon (as requested in the image) -->
        <div class="fixed bottom-10 right-10 z-[100] group">
            <a href="https://wa.me/221770000000" target="_blank" class="w-16 h-16 md:w-20 md:h-20 bg-[#0099D9] text-white rounded-full shadow-2xl flex items-center justify-center transition-all group-hover:scale-110 group-hover:rotate-12 border-4 border-white/20">
                <i class="far fa-comment-dots text-3xl md:text-4xl"></i>
            </a>
            <div class="absolute right-24 top-1/2 -translate-y-1/2 bg-white px-6 py-3 rounded-2xl border border-slate-100 shadow-2xl opacity-0 translate-x-10 group-hover:opacity-100 group-hover:translate-x-0 transition-all pointer-events-none whitespace-nowrap">
                <p class="text-xs font-black text-slate-900 uppercase tracking-[0.2em]">Parler avec nous ?</p>
                <div class="absolute right-[-8px] top-1/2 -translate-y-1/2 w-4 h-4 bg-white rotate-45 border-r border-t border-slate-100"></div>
            </div>
        </div>

        <!-- Slider Pagination Dots -->
        <div class="absolute bottom-32 left-1/2 -translate-x-1/2 z-20 flex gap-3">
            <template x-for="(slide, index) in slides" :key="index">
                <button @click="activeSlide = index"
                        class="w-3 h-3 rounded-full transition-all border-2 border-white shadow-sm"
                        :class="activeSlide === index ? 'bg-white w-10' : 'bg-white/30 hover:bg-white/50'"></button>
            </template>
        </div>
    </section>

    <!-- CAAWOGI 1:1 HERO SECTION (TWO-COLUMN INDUSTRIAL) -->
    <section class="relative bg-white pt-2 sm:pt-4">
        <div class="container-custom px-2 sm:px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 sm:gap-4">
                <!-- LEFT: VIANDE DE BOEUF -->
                <a href="{{ route('shop.index', ['category' => 'agro-alimentaire']) }}" class="relative group h-[400px] md:h-[550px] overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?q=80&w=2000&auto=format&fit=crop" class="w-full h-full object-cover transition-transform duration-[3000ms] group-hover:scale-110" alt="Viande de Boeuf">
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

    <!-- CATÉGORIES PRINCIPALES -->
    <section class="py-16 bg-white">
        <div class="container-custom">
            <h2 class="text-center text-2xl md:text-3xl font-black uppercase tracking-tight text-slate-900 mb-12">{{ __('messages.our_universes') }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ route('shop.index', ['category' => 'chevaux']) }}" class="group block relative overflow-hidden rounded-3xl shadow-xl">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/75 via-slate-950/20 to-transparent"></div>
                    <img src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?q=80&w=1600&auto=format&fit=crop" alt="Chevaux" class="w-full h-[420px] object-cover transition-transform duration-1000 group-hover:scale-105">
                    <div class="absolute inset-0 flex flex-col justify-end p-8">
                        <span class="text-xs font-semibold uppercase tracking-[0.35em] text-white/80 mb-3">Catégorie</span>
                        <h3 class="text-3xl font-black uppercase text-white tracking-tight">Chevaux</h3>
                        <span class="mt-6 inline-flex items-center gap-2 text-xs font-black uppercase tracking-[0.35em] text-white">
                            Voir plus
                            <i class="fas fa-arrow-right text-sm"></i>
                        </span>
                    </div>
                </a>
                <a href="{{ route('shop.index', ['category' => 'agro-alimentaire']) }}" class="group block relative overflow-hidden rounded-3xl shadow-xl">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/75 via-slate-950/20 to-transparent"></div>
                    <img src="https://images.unsplash.com/photo-1506086679524-6f6f3d5b5db7?q=80&w=1600&auto=format&fit=crop" alt="Agro-Alimentaire" class="w-full h-[420px] object-cover transition-transform duration-1000 group-hover:scale-105">
                    <div class="absolute inset-0 flex flex-col justify-end p-8">
                        <span class="text-xs font-semibold uppercase tracking-[0.35em] text-white/80 mb-3">Catégorie</span>
                        <h3 class="text-3xl font-black uppercase text-white tracking-tight">Agro-Alimentaire</h3>
                        <span class="mt-6 inline-flex items-center gap-2 text-xs font-black uppercase tracking-[0.35em] text-white">
                            Voir plus
                            <i class="fas fa-arrow-right text-sm"></i>
                        </span>
                    </div>
                </a>
                <a href="{{ route('shop.index', ['category' => 'volaille']) }}" class="group block relative overflow-hidden rounded-3xl shadow-xl">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/75 via-slate-950/20 to-transparent"></div>
                    <img src="https://images.unsplash.com/photo-1498654896293-37aacf113fd9?q=80&w=1600&auto=format&fit=crop" alt="Volaille" class="w-full h-[420px] object-cover transition-transform duration-1000 group-hover:scale-105">
                    <div class="absolute inset-0 flex flex-col justify-end p-8">
                        <span class="text-xs font-semibold uppercase tracking-[0.35em] text-white/80 mb-3">Catégorie</span>
                        <h3 class="text-3xl font-black uppercase text-white tracking-tight">Volaille</h3>
                        <span class="mt-6 inline-flex items-center gap-2 text-xs font-black uppercase tracking-[0.35em] text-white">
                            Voir plus
                            <i class="fas fa-arrow-right text-sm"></i>
                        </span>
                    </div>
                </a>
            </div>
        </div>
    </section>


    <!-- CAAWOGI VEDETTE SECTION (REFINED) -->
    <section class="py-24 bg-white">
        <div class="container-custom">
            <div class="flex flex-col items-center mb-20 text-center">
                <h3 class="text-3xl md:text-4xl font-black text-[#5BC0DE] mb-5">Produits en vedette</h3>
                <p class="text-slate-800 text-[15px] md:text-base max-w-3xl font-medium leading-relaxed">
                    Chez <strong>Thiotty</strong>, nous mettons en avant des produits de qualité, pensés pour répondre à vos besoins au quotidien.
                </p>
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
