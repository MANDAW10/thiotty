<x-app-layout>
    <div class="py-16 bg-white min-h-screen" x-data="{ showFilters: false }">
        <div class="container-custom">
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-16 gap-8">
                <div class="space-y-4">
                    <nav class="flex text-[10px] font-black text-slate-300 uppercase tracking-widest gap-2 mb-2 transition-all">
                        <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Accueil</a>
                        <span>/</span>
                        <span class="text-slate-900">Boutique</span>
                    </nav>
                    <h1 class="text-5xl md:text-7xl font-black text-slate-900 leading-[0.9] tracking-tighter">
                        Nos <span class="text-primary italic">Produits</span>.
                    </h1>
                </div>
                
                <div class="flex items-center gap-4 w-full md:w-auto">
                    <!-- Mobile Filter Button -->
                    <button @click="showFilters = true" class="md:hidden flex-1 flex items-center justify-center gap-3 py-4 bg-slate-50 rounded-2xl text-[10px] font-black uppercase tracking-widest text-slate-600 border border-slate-100">
                        <i class="fas fa-sliders-h"></i> Filtrer
                    </button>
                    
                    <!-- Search Indicator (if searched) -->
                    @if(isset($query) && $query)
                        <div class="hidden md:flex items-center gap-4 bg-primary/5 px-6 py-4 rounded-2xl border border-primary/10">
                             <p class="text-[10px] font-black text-primary uppercase tracking-widest">Résultats pour : <b>"{{ $query }}"</b></p>
                             <a href="{{ route('shop.index') }}" class="text-slate-400 hover:text-red-500 transition-colors"><i class="fas fa-times"></i></a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
                
                <!-- Sidebar Filters (Desktop) -->
                <aside class="hidden lg:block lg:col-span-3 space-y-12 h-fit sticky top-32">
                    <!-- Categories -->
                    <div class="space-y-6">
                        <h3 class="text-[10px] font-black text-slate-300 uppercase tracking-[0.3em] pl-4 border-l-4 border-primary">Collections</h3>
                        <div class="space-y-2">
                             <a href="{{ route('shop.index') }}" 
                                class="flex items-center justify-between group p-3 px-4 rounded-xl transition-all {{ !request('category') || request('category') == 'all' ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-slate-500 hover:bg-slate-50' }}">
                                <span class="text-[11px] font-black uppercase tracking-widest">Tout voir</span>
                                <span class="text-[10px] font-bold opacity-60">({{ \App\Models\Product::count() }})</span>
                            </a>
                            @foreach($categories as $cat)
                                <a href="{{ route('shop.index', ['category' => $cat->slug] + request()->except('category', 'page')) }}" 
                                   class="flex items-center justify-between group p-3 px-4 rounded-xl transition-all {{ request('category') == $cat->slug ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-slate-500 hover:bg-slate-50' }}">
                                    <span class="text-[11px] font-black uppercase tracking-widest truncate">{{ $cat->name }}</span>
                                    <span class="text-[10px] font-bold {{ request('category') == $cat->slug ? 'opacity-100' : 'opacity-30' }}">({{ $cat->products_count }})</span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Price Filter -->
                    <div class="space-y-6 pt-10 border-t border-slate-50">
                        <h3 class="text-[10px] font-black text-slate-300 uppercase tracking-[0.3em] pl-4 border-l-4 border-primary">Budget</h3>
                        <form action="{{ route('shop.index') }}" method="GET" class="space-y-6">
                             @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                             
                             <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-1.5">
                                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Min</label>
                                    <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="0" class="w-full bg-slate-50 border-none rounded-xl py-3 px-4 text-xs font-black focus:ring-2 focus:ring-primary/20">
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Max</label>
                                    <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="50k+" class="w-full bg-slate-50 border-none rounded-xl py-3 px-4 text-xs font-black focus:ring-2 focus:ring-primary/20">
                                </div>
                             </div>
                             
                             <button type="submit" class="w-full py-4 bg-slate-900 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-primary transition-all">
                                Appliquer le filtre
                             </button>
                        </form>
                    </div>

                    <!-- Quick Help Card -->
                    <div class="bg-primary shadow-2xl shadow-primary/30 rounded-[40px] p-8 text-white relative overflow-hidden group mt-20">
                        <div class="relative z-10 text-center">
                            <i class="fab fa-whatsapp text-4xl mb-4 group-hover:scale-110 transition-transform"></i>
                            <h4 class="text-xl font-black mb-4 leading-tight">Besoin d'aide ?</h4>
                            <p class="text-[10px] font-bold text-white/70 mb-8 uppercase tracking-widest leading-relaxed">Nos experts vous conseillent directement sur WhatsApp.</p>
                            <a href="https://wa.me/221783577431" target="_blank" class="block w-full py-3 bg-white text-primary rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:shadow-xl transition-all">
                                Nous contacter
                            </a>
                        </div>
                        <div class="absolute -bottom-10 -right-10 text-[120px] font-black text-white/5 opacity-20 pointer-events-none italic select-none tracking-tighter">Help.</div>
                    </div>
                </aside>

                <!-- Products Grid (Lg Col 4-12) -->
                <main class="lg:col-span-9 animate-fade-in-up">
                    <!-- Category Pills (Mobile Only) -->
                    <div class="md:hidden flex overflow-x-auto gap-3 py-4 mb-8 custom-scrollbar hide-scrollbar scroll-smooth px-2">
                        <a href="{{ route('shop.index') }}" 
                           class="shrink-0 px-6 py-3 rounded-full text-[10px] font-black uppercase tracking-widest transition-all {{ !request('category') ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'bg-slate-50 text-slate-500 border border-slate-100' }}">
                            Tout voir
                        </a>
                        @foreach($categories as $cat)
                            <a href="{{ route('shop.index', ['category' => $cat->slug] + request()->except('category', 'page')) }}" 
                               class="shrink-0 px-6 py-3 rounded-full text-[10px] font-black uppercase tracking-widest transition-all {{ request('category') == $cat->slug ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'bg-slate-50 text-slate-500 border border-slate-100' }}">
                                {{ $cat->name }}
                            </a>
                        @endforeach
                    </div>

                    <!-- Grid Header: Sorting -->
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-12 px-2 gap-4">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest italic">
                            Affichage de {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} sur {{ $products->total() }} articles
                        </p>
                        
                        <div class="flex items-center gap-4 w-full sm:w-auto">
                            <label class="hidden sm:block text-[10px] font-black text-slate-300 uppercase tracking-widest">Trier par :</label>
                            <select onchange="window.location.href = this.value" class="w-full sm:w-auto bg-slate-50 border-none rounded-xl py-2 pl-4 pr-10 text-[10px] font-black uppercase tracking-widest focus:ring-2 focus:ring-primary/20 transition-all cursor-pointer">
                                <option value="{{ request()->fullUrlWithQuery(['sort' => 'latest']) }}" {{ request('sort') == 'latest' ? 'selected' : '' }}>Nouveautés</option>
                                <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Prix croissant</option>
                                <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Prix décroissant</option>
                            </select>
                        </div>
                    </div>

                    @if($products->isEmpty())
                        <div class="bg-[#FCFCFC] rounded-[40px] p-24 text-center border border-slate-100 mt-12">
                             <div class="w-20 h-20 bg-slate-50 rounded-3xl flex items-center justify-center text-slate-200 mx-auto mb-8">
                                <i class="fas fa-search text-3xl"></i>
                             </div>
                             <h2 class="text-2xl font-black text-slate-900 mb-2">Aucun résultat trouvé.</h2>
                             <p class="text-slate-400 font-bold uppercase tracking-widest text-[10px]">Essayez de modifier vos filtres de recherche.</p>
                             <a href="{{ route('shop.index') }}" class="mt-10 inline-block text-[10px] font-black text-primary uppercase tracking-[0.3em] hover:underline">Réinitialiser tout</a>
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-8 sm:gap-12">
                            @foreach($products as $product)
                                <x-product-card :product="$product" />
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-24 pt-12 border-t border-slate-50">
                            {{ $products->links() }}
                        </div>
                    @endif
                </main>
            </div>
        </div>
    </div>

    <!-- Mobile Filter Drawer -->
    <div x-show="showFilters" class="fixed inset-0 z-[1000] md:hidden" style="display: none;">
        <!-- Backdrop -->
        <div x-show="showFilters" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" @click="showFilters = false" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
        
        <!-- Drawer -->
        <div x-show="showFilters" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="translate-y-full" x-transition:enter-end="translate-y-0" class="absolute inset-x-0 bottom-0 max-h-[90vh] bg-white rounded-t-[48px] shadow-2xl p-8 flex flex-col">
            <div class="h-1.5 w-12 bg-slate-100 rounded-full mx-auto mb-10"></div>
            <div class="flex justify-between items-center mb-10">
                <h3 class="text-2xl font-black tracking-tighter">Filtrer & Trier</h3>
                <button @click="showFilters = false" class="w-10 h-10 bg-slate-50 rounded-full flex items-center justify-center text-slate-400">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto space-y-10 custom-scrollbar pr-2">
                <!-- Sorting (Mobile) -->
                <div class="space-y-4">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-4 border-l-4 border-primary">Trier par</p>
                    <div class="grid grid-cols-1 gap-2">
                         <a href="{{ request()->fullUrlWithQuery(['sort' => 'latest']) }}" class="flex items-center justify-between p-4 rounded-2xl {{ request('sort') == 'latest' || !request('sort') ? 'bg-primary text-white' : 'bg-slate-50 text-slate-600' }} font-bold text-xs uppercase tracking-widest transition-all">
                             Nouveautés @if(request('sort') == 'latest' || !request('sort')) <i class="fas fa-check"></i> @endif
                         </a>
                         <a href="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}" class="flex items-center justify-between p-4 rounded-2xl {{ request('sort') == 'price_asc' ? 'bg-primary text-white' : 'bg-slate-50 text-slate-600' }} font-bold text-xs uppercase tracking-widest transition-all">
                             Prix croissant @if(request('sort') == 'price_asc') <i class="fas fa-check"></i> @endif
                         </a>
                         <a href="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}" class="flex items-center justify-between p-4 rounded-2xl {{ request('sort') == 'price_desc' ? 'bg-primary text-white' : 'bg-slate-50 text-slate-600' }} font-bold text-xs uppercase tracking-widest transition-all">
                             Prix décroissant @if(request('sort') == 'price_desc') <i class="fas fa-check"></i> @endif
                         </a>
                    </div>
                </div>

                <!-- Categories (Mobile) -->
                <div class="space-y-4">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-4 border-l-4 border-primary">Categories</p>
                    <div class="flex flex-wrap gap-2">
                         <a href="{{ route('shop.index') }}" class="px-6 py-3 rounded-full text-[10px] font-black uppercase tracking-widest transition-all {{ !request('category') ? 'bg-primary text-white' : 'bg-slate-50 text-slate-500 border border-slate-100' }}">Toutes</a>
                         @foreach($categories as $cat)
                            <a href="{{ route('shop.index', ['category' => $cat->slug] + request()->except('category', 'page')) }}" class="px-6 py-3 rounded-full text-[10px] font-black uppercase tracking-widest transition-all {{ request('category') == $cat->slug ? 'bg-primary text-white' : 'bg-slate-50 text-slate-500 border border-slate-100' }}">
                                {{ $cat->name }}
                            </a>
                         @endforeach
                    </div>
                </div>

                <!-- Price (Mobile) -->
                <div class="space-y-6 pt-4">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-4 border-l-4 border-primary">Fourchette de prix</p>
                    <form action="{{ route('shop.index') }}" method="GET" class="space-y-6">
                         @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                         @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
                         
                         <div class="grid grid-cols-2 gap-4">
                            <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min" class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-xs font-black">
                            <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max" class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-xs font-black">
                         </div>
                         
                         <button type="submit" class="w-full py-5 bg-primary text-white rounded-3xl text-xs font-black uppercase tracking-widest shadow-xl shadow-primary/20">
                             Voir les articles
                         </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
