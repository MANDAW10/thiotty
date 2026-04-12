<x-app-layout>
    <!-- CAAWOGI 1:1 HERO SECTION (TWO-COLUMN INDUSTRIAL) -->
    <section class="relative bg-white pt-2 sm:pt-4">
        <div class="container-custom px-2 sm:px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 sm:gap-4">
                <!-- LEFT: VIANDE DE BOEUF -->
                <a href="{{ route('shop.index', ['category' => 'agro-alimentaire']) }}" class="relative group h-[400px] md:h-[550px] overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1544025162-d76694265da4?q=80&w=2000&auto=format&fit=crop" class="w-full h-full object-cover transition-transform duration-[3000ms] group-hover:scale-110" alt="Viande de Boeuf">
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

    <!-- CAAWOGI POPULAR PRODUCTS -->
    <section class="py-24 bg-white">
        <div class="container-custom">
            <div class="flex flex-col items-center mb-16">
                <h2 class="text-[12px] font-black text-[var(--primary)] uppercase tracking-[0.4em] mb-4">La Sélection</h2>
                <h3 class="text-3xl md:text-5xl font-black text-slate-900 uppercase tracking-tight">Produits Populaires</h3>
                <div class="h-1.5 w-24 bg-[var(--primary)] mt-6"></div>
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
