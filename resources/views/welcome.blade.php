<x-app-layout>
    <!-- INDUSTRIAL HERO SECTION -->
    <section class="relative h-[600px] lg:h-[750px] overflow-hidden bg-slate-100">
        <img src="{{ asset('img/banners/hero-agro.png') }}" class="absolute inset-0 w-full h-full object-cover" alt="Thiotty Industry">
        <div class="absolute inset-0 bg-slate-900/40"></div>
        
        <div class="container-custom relative h-full flex items-center z-10">
            <div class="max-w-3xl">
                <div class="inline-block bg-[var(--primary)] text-white px-4 py-1.5 text-[10px] font-bold uppercase tracking-[0.3em] mb-6 border-l-4 border-[var(--secondary)]">
                    {{ __('messages.art_agriculture') }}
                </div>
                <h1 class="text-4xl md:text-7xl font-black text-white leading-[1.1] mb-8 uppercase tracking-tight">
                    {{ __('messages.excellence_signature') }}
                </h1>
                <p class="text-lg md:text-xl text-white/90 font-medium mb-12 max-w-xl leading-relaxed">
                    {{ __('messages.hero_text') }}
                </p>
                <div class="flex flex-col sm:flex-row items-center gap-6">
                    <a href="{{ route('shop.index') }}" class="w-full sm:w-auto px-10 py-5 bg-[var(--primary)] text-white font-bold text-sm uppercase tracking-widest hover:bg-[var(--primary-hover)] transition-all flex items-center justify-center gap-3">
                        {{ __('messages.explore_collection') }}
                        <i class="fas fa-chevron-right text-[10px]"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- SPOTLIGHT: AGRO-ALIMENTAIRE -->
    <section class="relative h-[600px] flex items-center overflow-hidden">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1595113316349-9fa4ee24f884?q=80&w=2000&auto=format&fit=crop" class="w-full h-full object-cover" alt="Agro-Alimentaire">
            <div class="absolute inset-0 bg-slate-900/60"></div>
        </div>
        <div class="container-custom relative z-10">
            <div class="max-w-2xl">
                <div class="inline-block bg-[var(--primary)] text-white px-4 py-1.5 text-[10px] font-black uppercase tracking-[0.3em] mb-6 border-l-4 border-[var(--secondary)]">
                    Transformation
                </div>
                <h2 class="text-4xl md:text-6xl font-black text-white leading-tight uppercase tracking-tight mb-8">
                    Agro-<span class="text-[var(--primary)]">Alimentaire</span>
                </h2>
                <p class="text-white/70 text-lg mb-12 font-medium">
                    De la terre à la table, nous garantissons une traçabilité totale et une qualité nutritionnelle irréprochable. Nos produits locaux sont transformés avec les plus hautes normes industrielles.
                </p>
                <a href="{{ route('shop.index', ['category' => 'agro-alimentaire']) }}" class="inline-flex items-center gap-6 bg-white text-slate-900 px-10 py-5 font-black text-[11px] uppercase tracking-widest hover:bg-[var(--primary)] hover:text-white transition-all group">
                    Explorer la gamme <i class="fas fa-chevron-right transition-transform group-hover:translate-x-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- SPOTLIGHT: VOLAILLE (Alternating) -->
    <section class="relative h-[600px] flex items-center overflow-hidden">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1548550023-2bdb3c5beed7?q=80&w=2000&auto=format&fit=crop" class="w-full h-full object-cover" alt="Volaille">
            <div class="absolute inset-0 bg-slate-100/90"></div>
        </div>
        <div class="container-custom relative z-10 flex justify-end text-right">
            <div class="max-w-2xl">
                <div class="inline-block bg-[var(--primary)] text-white px-4 py-1.5 text-[10px] font-black uppercase tracking-[0.3em] mb-6 border-r-4 border-[var(--secondary)]">
                    Aviculture Moderne
                </div>
                <h2 class="text-4xl md:text-6xl font-black text-slate-900 leading-tight uppercase tracking-tight mb-8">
                    Filière <span class="text-[var(--primary)]">Volaille</span>
                </h2>
                <p class="text-slate-500 text-lg mb-12 font-medium">
                    Une production avicole rigoureuse pour une viande saine et savoureuse. Nos installations respectent le bien-être animal et les protocoles sanitaires les plus stricts.
                </p>
                <div class="flex justify-end">
                    <a href="{{ route('shop.index', ['category' => 'volaille']) }}" class="inline-flex items-center gap-6 bg-slate-900 text-white px-10 py-5 font-black text-[11px] uppercase tracking-widest hover:bg-[var(--primary)] transition-all group">
                        Découvrir la sélection <i class="fas fa-chevron-right transition-transform group-hover:translate-x-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- SPOTLIGHT: ÉLEVAGE -->
    <section class="relative h-[600px] flex items-center overflow-hidden">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=2000&auto=format&fit=crop" class="w-full h-full object-cover" alt="Élevage">
            <div class="absolute inset-0 bg-slate-900/60"></div>
        </div>
        <div class="container-custom relative z-10">
            <div class="max-w-2xl">
                <div class="inline-block bg-[var(--primary)] text-white px-4 py-1.5 text-[10px] font-black uppercase tracking-[0.3em] mb-6 border-l-4 border-[var(--secondary)]">
                    Bétail d'Excellence
                </div>
                <h2 class="text-4xl md:text-6xl font-black text-white leading-tight uppercase tracking-tight mb-8">
                    Notre <span class="text-[var(--primary)]">Élevage</span>
                </h2>
                <p class="text-white/70 text-lg mb-12 font-medium">
                    Le Gobra et nos races locales sont au coeur de notre héritage. Un élevage en plein air, nourri au terroir pour une expérience gustative authentique.
                </p>
                <a href="{{ route('shop.index', ['category' => 'elevage']) }}" class="inline-flex items-center gap-6 bg-white text-slate-900 px-10 py-5 font-black text-[11px] uppercase tracking-widest hover:bg-[var(--primary)] hover:text-white transition-all group">
                    Voir les produits <i class="fas fa-chevron-right transition-transform group-hover:translate-x-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- GALLERY TEASER (Replacing About) -->
    <section class="py-24 bg-white overflow-hidden">
        <div class="container-custom">
            <div class="flex flex-col md:flex-row items-end justify-between mb-16 gap-8">
                <div class="border-l-8 border-[var(--primary)] pl-8">
                    <h2 class="text-[12px] font-black text-[var(--primary)] uppercase tracking-[0.4em] mb-2">Notre Univers</h2>
                    <h3 class="text-4xl font-black text-slate-800 uppercase tracking-tight">Immersion Visuelle</h3>
                </div>
                <a href="{{ route('gallery') }}" class="text-[11px] font-bold uppercase tracking-widest text-[var(--primary)] border-b-2 border-[var(--primary)] pb-2 hover:text-slate-900 hover:border-slate-900 transition-all">
                    Voir toute la gallerie
                </a>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-0 border border-slate-100 bg-slate-100">
                <div class="aspect-square relative overflow-hidden group">
                    <img src="https://images.unsplash.com/photo-1543160732-23700b1b13b1?q=80&w=800&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover grayscale brightness-75 group-hover:grayscale-0 group-hover:scale-110 transition-all duration-700">
                </div>
                <div class="aspect-square relative overflow-hidden group">
                    <img src="https://images.unsplash.com/photo-1464226184884-fa280b87c399?q=80&w=800&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover grayscale brightness-75 group-hover:grayscale-0 group-hover:scale-110 transition-all duration-700">
                </div>
                <div class="aspect-square relative overflow-hidden group">
                    <img src="https://images.unsplash.com/photo-1548550023-2bdb3c5beed7?q=80&w=800&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover grayscale brightness-75 group-hover:grayscale-0 group-hover:scale-110 transition-all duration-700">
                </div>
                <div class="aspect-square relative overflow-hidden group">
                    <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=800&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover grayscale brightness-75 group-hover:grayscale-0 group-hover:scale-110 transition-all duration-700">
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
