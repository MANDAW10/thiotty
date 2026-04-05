<x-app-layout>
    <!-- Shop Header -->
    <header class="py-16 bg-white border-b border-slate-50 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full -translate-y-1/2 translate-x-1/2 blur-3xl"></div>
        <div class="container-custom relative z-10">
            <nav class="flex mb-6 text-[10px] font-black text-slate-400 uppercase tracking-widest gap-2">
                <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Accueil</a>
                <span class="opacity-20">/</span>
                <span class="text-slate-900">Boutique</span>
            </nav>
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
                <div>
                    <h1 class="text-4xl md:text-6xl font-black text-slate-900 leading-tight">
                        {{ isset($category) ? $category->name : (isset($query) ? 'Résultats pour : '.$query : 'Le Catalogue') }}
                    </h1>
                    <p class="text-slate-500 font-medium max-w-lg mt-4">
                        Découvrez notre sélection premium de produits agricoles et d'élevage, directement sélectionnés pour vous.
                    </p>
                </div>
                <div class="bg-slate-50 px-6 py-4 rounded-3xl border border-slate-100 flex items-center gap-4">
                    <span class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Articles dispos :</span>
                    <span class="text-xl font-black text-primary">{{ $products->total() }}</span>
                </div>
            </div>
        </div>
    </header>

    <div class="py-12 lg:py-24 bg-slate-50/30">
        <div class="container-custom">
            <div class="flex flex-col lg:flex-row gap-16">
                <!-- Sidebar -->
                <aside class="w-full lg:w-1/4 space-y-12">
                    <!-- Search Widget -->
                    <div class="bg-white p-8 rounded-[32px] border border-slate-100 shadow-sm">
                        <h3 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-6 flex items-center gap-2">
                            <i class="fas fa-search text-[10px]"></i> Votre recherche
                        </h3>
                        <form action="{{ route('shop.search') }}" method="GET">
                            <div class="relative">
                                <input type="text" name="query" value="{{ $query ?? '' }}" placeholder="Ex: Boeuf, Mouton..." 
                                       class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-sm font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all placeholder:text-slate-300">
                                <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 w-10 h-10 bg-primary text-white rounded-xl shadow-lg shadow-primary/20 flex items-center justify-center hover:scale-105 transition-all">
                                    <i class="fas fa-arrow-right text-xs"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Categories Widget -->
                    <div class="bg-white p-6 lg:p-8 rounded-[32px] border border-slate-100 shadow-sm relative z-20">
                        <h3 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-6 lg:mb-8">Univers Lahad</h3>
                        
                        <!-- Mobile View: Horizontal Scroll -->
                        <div class="flex lg:hidden overflow-x-auto pb-4 gap-4 no-scrollbar -mx-2 px-2">
                            <a href="{{ route('shop.index') }}" class="flex-none flex items-center gap-3 px-6 py-3 rounded-2xl transition-all {{ !isset($category) ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'bg-slate-50 text-slate-600' }}">
                                <span class="text-xs font-black uppercase tracking-widest whitespace-nowrap">Tout voir</span>
                            </a>
                            @foreach($categories as $cat)
                                <a href="{{ route('shop.category', $cat->slug) }}" class="flex-none flex items-center gap-3 px-6 py-3 rounded-2xl transition-all {{ (isset($category) && $category->id == $cat->id) ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'bg-slate-50 text-slate-600' }}">
                                    <i class="{{ $cat->icon }} text-xs"></i>
                                    <span class="text-xs font-black uppercase tracking-widest whitespace-nowrap">{{ $cat->name }}</span>
                                </a>
                            @endforeach
                        </div>

                        <!-- Desktop View: Vertical Stack -->
                        <div class="hidden lg:flex flex-col gap-3">
                            <a href="{{ route('shop.index') }}" class="flex items-center gap-4 p-4 rounded-2xl transition-all group {{ !isset($category) ? 'bg-primary text-white shadow-xl shadow-primary/20' : 'bg-slate-50 text-slate-600 hover:bg-slate-100' }}">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-all {{ !isset($category) ? 'bg-white/10' : 'bg-white text-primary shadow-sm group-hover:bg-primary group-hover:text-white' }}">
                                    <i class="fas fa-th-large text-sm"></i>
                                </div>
                                <span class="text-sm font-black uppercase tracking-widest">Tout voir</span>
                            </a>
                            @foreach($categories as $cat)
                                <a href="{{ route('shop.category', $cat->slug) }}" class="flex items-center justify-between p-4 rounded-2xl transition-all group {{ (isset($category) && $category->id == $cat->id) ? 'bg-primary text-white shadow-xl shadow-primary/20' : 'bg-slate-50 text-slate-600 hover:bg-slate-100' }}">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-all {{ (isset($category) && $category->id == $cat->id) ? 'bg-white/10' : 'bg-white text-primary shadow-sm group-hover:bg-primary group-hover:text-white' }}">
                                            <i class="{{ $cat->icon }} text-sm"></i>
                                        </div>
                                        <span class="text-sm font-black uppercase tracking-widest">{{ $cat->name }}</span>
                                    </div>
                                    <span class="text-[10px] font-black opacity-30 group-hover:opacity-100">{{ $cat->products_count ?? $cat->products()->count() }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Support Card -->
                    <div class="bg-secondary rounded-[40px] p-10 text-white shadow-2xl shadow-secondary/20 relative overflow-hidden group">
                        <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/5 rounded-full blur-2xl group-hover:bg-white/10 transition-all"></div>
                        <h4 class="text-xl font-bold mb-4 relative z-10">Besoin d'aide ?</h4>
                        <p class="text-sm text-white/70 mb-8 leading-relaxed relative z-10">Nos experts sont disponibles pour vous conseiller sur vos achats.</p>
                        <a href="https://wa.me/221770000000" class="flex items-center justify-center gap-3 bg-white text-secondary py-4 rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-slate-100 transition-all shadow-xl">
                            <i class="fab fa-whatsapp text-lg"></i> WhatsApp
                        </a>
                    </div>
                </aside>

                <!-- Product Grid -->
                <main class="w-full lg:w-3/4">
                    @if($products->count() > 0)
                        <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-10">
                            @foreach($products as $product)
                                <div class="product-card-lahad group fade-in" style="animation-delay: {{ $loop->index * 0.1 }}s">
                                    <div class="product-card-img">
                                        <a href="{{ route('shop.product', $product->slug) }}">
                                            <img src="{{ $product->image ?: 'https://images.unsplash.com/photo-1596733430284-f7437764b1a9?q=80&w=800&auto=format&fit=crop' }}" 
                                                 alt="{{ $product->name }}" 
                                                 class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
                                        </a>
                                        <div class="absolute top-4 left-4 z-20">
                                            <span class="bg-white/90 backdrop-blur px-3 py-1 rounded-full text-[9px] font-black uppercase text-slate-900 tracking-widest shadow-sm">
                                                Nouveau
                                            </span>
                                        </div>
                                        <div class="absolute top-4 right-4 z-20" x-data="{ 
                                            isFavorited: {{ (Auth::check() && $product->isFavoritedBy(Auth::user())) ? 'true' : 'false' }},
                                            async toggleFavorite() {
                                                @if(!Auth::check())
                                                    this.$dispatch('open-login');
                                                    return;
                                                @endif
                                                
                                                try {
                                                    const response = await fetch('{{ route('wishlist.toggle', $product) }}', {
                                                        method: 'POST',
                                                        headers: {
                                                            'X-CSRF-TOKEN': document.querySelector('meta[name=&quot;csrf-token&quot;]').getAttribute('content'),
                                                            'Accept': 'application/json'
                                                        }
                                                    });
                                                    const data = await response.json();
                                                    if (data.status) {
                                                        this.isFavorited = data.status === 'added';
                                                        window.dispatchEvent(new CustomEvent('wishlist-updated', { detail: { count: data.count } }));
                                                    }
                                                } catch (e) {
                                                    console.error('Error toggling favorite', e);
                                                }
                                            }
                                        }">
                                            <button @click.prevent="toggleFavorite()" 
                                                    :class="isFavorited ? 'bg-primary text-white' : 'bg-white/90 text-slate-400 hover:text-primary'"
                                                    class="w-8 h-8 rounded-full backdrop-blur-sm flex items-center justify-center transition-all shadow-sm">
                                                <i class="fas fa-heart text-[10px]" :class="isFavorited ? 'fas' : 'far'"></i>
                                            </button>
                                        </div>
                                        <form action="{{ route('cart.add', $product) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="product-card-btn-add">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </form>
                                    </div>
                                    <div class="p-8">
                                        <div class="flex items-center gap-2 mb-4">
                                            <span class="text-[9px] font-black uppercase tracking-widest text-primary bg-primary/5 px-2 py-1 rounded-md">
                                                {{ $product->category->name }}
                                            </span>
                                        </div>
                                        <a href="{{ route('shop.product', $product->slug) }}">
                                            <h3 class="text-base sm:text-xl font-black text-slate-900 mb-2 sm:mb-3 line-clamp-2 min-h-[2.5rem] sm:min-h-[3.5rem] hover:text-primary transition-colors">
                                                {{ $product->name }}
                                            </h3>
                                        </a>
                                        <div class="flex items-center justify-between mb-8 pb-6 border-b border-slate-50">
                                            <div class="flex items-center gap-2 text-[10px] text-slate-400 font-bold uppercase tracking-widest">
                                                <i class="fas fa-map-marker-alt text-primary/40"></i>
                                                <span>{{ $product->location ?: 'Dakar' }}</span>
                                            </div>
                                            <div class="flex items-center gap-1 text-[10px] text-amber-500 font-black tracking-widest">
                                                <i class="fas fa-star text-[8px]"></i>
                                                <span>{{ number_format($product->rating ?: 4.8, 1) }}</span>
                                            </div>
                                        </div>
                                        <div class="flex items-end justify-between">
                                            <div>
                                                <div class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Prix unitaire</div>
                                                <div class="text-2xl font-black text-primary flex items-baseline gap-1">
                                                    {{ number_format($product->price, 0, ',', ' ') }} 
                                                    <span class="text-[10px] text-primary/60 uppercase">CFA</span>
                                                </div>
                                            </div>
                                            <div class="text-slate-300 group-hover:text-primary transition-colors">
                                                <i class="fas fa-chevron-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-20">
                            {{ $products->links() }}
                        </div>
                    @else
                        <div class="text-center py-40 bg-white rounded-[60px] border border-slate-100 shadow-sm">
                            <div class="w-32 h-32 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-10 text-slate-200 shadow-inner">
                                <i class="fas fa-search text-5xl"></i>
                            </div>
                            <h3 class="text-2xl font-black text-slate-900 mb-4">Aucun produit trouvé</h3>
                            <p class="text-slate-500 max-w-sm mx-auto mb-12">Nous n'avons pas trouvé de résultats correspondant à vos critères de recherche.</p>
                            <a href="{{ route('shop.index') }}" class="btn-lahad inline-flex px-12 py-5">
                                Réinitialiser les filtres
                            </a>
                        </div>
                    @endif
                </main>
            </div>
        </div>
    </div>
</x-app-layout>
