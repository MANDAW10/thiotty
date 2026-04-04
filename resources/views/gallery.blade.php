<x-app-layout>
    <!-- Gallery Hero -->
    <header class="py-16 lg:py-24 bg-white border-b border-slate-50 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-primary/5 rounded-full -translate-y-1/2 translate-x-1/2 blur-3xl opacity-50"></div>
        <div class="container-custom relative z-10 text-center">
            <nav class="flex justify-center mb-8 text-[10px] font-black text-slate-400 uppercase tracking-widest gap-2">
                <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Accueil</a>
                <span class="opacity-20">/</span>
                <span class="text-slate-900">Galerie</span>
            </nav>
            <h1 class="text-5xl md:text-7xl font-black text-slate-900 leading-tight mb-6">
                Notre <span class="text-primary italic italic-font">Vision</span>
            </h1>
            <p class="text-slate-500 font-medium max-w-2xl mx-auto text-lg leading-relaxed">
                Immersion au cœur de l'excellence agricole. Découvrez nos produits, nos élevages et l'engagement quotidien de Lahad Enterprise.
            </p>
        </div>
    </header>

    <!-- Gallery Grid -->
    <section class="py-20 lg:py-32 bg-[#FDFDFD]">
        <div class="container-custom">
            <!-- Filter Tabs (Visual Only for now) -->
            <div class="flex flex-wrap justify-center gap-4 mb-20">
                <button class="px-8 py-3 rounded-2xl bg-primary text-white font-black text-xs uppercase tracking-widest shadow-xl shadow-primary/20">Tout</button>
                <button class="px-8 py-3 rounded-2xl bg-white border border-slate-100 text-slate-400 hover:text-primary hover:border-primary/20 font-black text-xs uppercase tracking-widest transition-all">Élevage</button>
                <button class="px-8 py-3 rounded-2xl bg-white border border-slate-100 text-slate-400 hover:text-primary hover:border-primary/20 font-black text-xs uppercase tracking-widest transition-all">Terroir</button>
                <button class="px-8 py-3 rounded-2xl bg-white border border-slate-100 text-slate-400 hover:text-primary hover:border-primary/20 font-black text-xs uppercase tracking-widest transition-all">Culture</button>
            </div>

            <div class="columns-1 sm:columns-2 lg:columns-3 gap-4 sm:gap-10 space-y-4 sm:space-y-10">
                @forelse($items as $item)
                    <!-- Dynamic Image -->
                    <div class="fade-in group relative overflow-hidden rounded-[40px] bg-slate-100 shadow-sm hover:shadow-2xl transition-all duration-700" style="animation-delay: {{ $loop->index * 0.1 }}s">
                        <img src="{{ $item->image }}" class="w-full transition-transform duration-1000 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex flex-col justify-end p-10 text-left">
                            <span class="text-[9px] font-black text-primary uppercase tracking-widest mb-2">{{ $item->category }}</span>
                            <h4 class="text-white text-2xl font-black mb-2 leading-tight">{{ $item->title }}</h4>
                            @if($item->description)
                                <p class="text-white/60 text-sm font-medium">{{ $item->description }}</p>
                            @endif
                        </div>
                    </div>
                @empty
                    <!-- Placeholder if empty -->
                    @foreach(range(1, 6) as $i)
                        <div class="fade-in group relative overflow-hidden rounded-[40px] bg-slate-100 h-64 flex items-center justify-center">
                            <p class="text-slate-400 font-bold italic">En attente de visuels...</p>
                        </div>
                    @endforeach
                @endforelse
            </div>

            <!-- Call to Action -->
            <div class="mt-32 text-center fade-in" style="animation-delay: 0.6s">
                <h3 class="text-3xl font-black text-slate-900 mb-8">Inspiré par la <span class="text-primary italic">Galerie</span> ?</h3>
                <a href="{{ route('shop.index') }}" class="btn-lahad px-12 py-5 text-lg shadow-2xl shadow-primary/20">
                    Découvrir nos produits
                </a>
            </div>
        </div>
    </section>

    <!-- Custom CSS for Masonry and Animations (if not in app.css) -->
    <style>
        .italic-font { font-family: 'Outfit', sans-serif; font-style: italic; }
        .fade-in { animation: fadeIn 0.8s ease-out forwards; opacity: 0; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</x-app-layout>
