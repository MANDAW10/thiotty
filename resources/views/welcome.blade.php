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

    <!-- CATEGORY GRID (CLEAN INDUSTRIAL) -->
    <section id="categories" class="py-24 bg-white border-b border-slate-100">
        <div class="container-custom">
            <div class="flex flex-col md:flex-row items-center justify-between mb-16 border-l-8 border-[var(--primary)] pl-8">
                <div>
                    <h2 class="text-[12px] font-black text-[var(--primary)] uppercase tracking-[0.4em] mb-2">{{ __('messages.our_universes') }}</h2>
                    <h3 class="text-3xl md:text-5xl font-black text-slate-800 uppercase tracking-tight">
                        {{ __('messages.browse_terroir') }}
                    </h3>
                </div>
                <div class="hidden md:block">
                    <a href="{{ route('shop.index') }}" class="text-[11px] font-bold uppercase tracking-widest text-slate-400 hover:text-[var(--primary)] transition-colors border-b-2 border-slate-100 pb-2">
                        {{ __('messages.explore_all') }}
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-0 border border-slate-100">
                @foreach($categories->take(4) as $cat)
                    <a href="{{ route('shop.category', $cat->slug) }}" class="group relative aspect-square overflow-hidden border border-slate-100">
                        <img src="{{ $cat->image_url }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" alt="{{ $cat->display_name }}">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/20 to-transparent"></div>
                        <div class="absolute bottom-10 left-10 right-10 z-20">
                            <h4 class="text-2xl font-black text-white uppercase tracking-tight mb-2">{{ $cat->display_name }}</h4>
                            <div class="h-1 w-12 bg-[var(--primary)] group-hover:w-full transition-all duration-500"></div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CORE PRODUCTS SECTION -->
    <section class="py-24 bg-slate-50">
        <div class="container-custom">
            <div class="text-center mb-16">
                <h2 class="text-[12px] font-black text-[var(--primary)] uppercase tracking-[0.4em] mb-4">{{ __('messages.the_selection') }}</h2>
                <h3 class="text-3xl md:text-5xl font-black text-slate-800 uppercase tracking-tight">{{ __('messages.harvest_of_moment') }}</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($featuredProducts as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>

            <div class="mt-16 text-center">
                <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-4 px-12 py-5 border-2 border-[var(--primary)] text-[var(--primary)] font-black text-[11px] uppercase tracking-widest hover:bg-[var(--primary)] hover:text-white transition-all">
                    {{ __('messages.view_collection') }}
                </a>
            </div>
        </div>
    </section>

    <!-- IMPACT SECTION -->
    <section class="py-24 bg-[var(--primary)] text-white overflow-hidden relative">
        <div class="container-custom">
            <div class="grid lg:grid-cols-2 gap-20 items-center">
                <div>
                    <h2 class="text-[12px] font-black text-white/60 uppercase tracking-[0.4em] mb-6">{{ __('messages.our_heritage') }}</h2>
                    <h3 class="text-4xl md:text-6xl font-black mb-10 leading-tight uppercase tracking-tight">
                        {{ __('messages.passion_label') }}
                    </h3>
                    <p class="text-lg text-white/80 font-medium leading-relaxed mb-12">
                        {{ __('messages.heritage_text') }}
                    </p>
                    <div class="flex items-center gap-12">
                        <div>
                            <p class="text-5xl font-black mb-2 tracking-tighter text-[var(--secondary)]">500+</p>
                            <p class="text-[11px] font-bold text-white/60 uppercase tracking-widest">{{ __('messages.partner_producers') }}</p>
                        </div>
                        <div>
                            <p class="text-5xl font-black mb-2 tracking-tighter text-[var(--secondary)]">100%</p>
                            <p class="text-[11px] font-bold text-white/60 uppercase tracking-widest">{{ __('messages.local_impact') }}</p>
                        </div>
                    </div>
                </div>
                <div class="relative hidden lg:block">
                    <img src="https://images.unsplash.com/photo-1629904853716-f0bc54ea4813?q=80&w=1000&auto=format&fit=crop" class="w-full grayscale brightness-75 hover:grayscale-0 transition-all duration-700" alt="Agro Structure">
                    <div class="absolute -bottom-6 -right-6 p-10 bg-white text-slate-900 border-l-[10px] border-[var(--primary)] shadow-2xl">
                        <p class="text-4xl font-black tracking-tighter leading-none mb-2">PRODUIT</p>
                        <p class="text-base font-bold text-slate-400 uppercase tracking-widest">SÉLECTIONNÉ</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
