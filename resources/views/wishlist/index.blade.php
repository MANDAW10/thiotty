<x-app-layout>
    <!-- Wishlist Header -->
    <header class="py-16 bg-white border-b border-slate-50 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full -translate-y-1/2 translate-x-1/2 blur-3xl"></div>
        <div class="container-custom relative z-10">
            <nav class="flex mb-6 text-[10px] font-black text-slate-400 uppercase tracking-widest gap-2">
                <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Accueil</a>
                <span class="opacity-20">/</span>
                <span class="text-slate-900">Mes Favoris</span>
            </nav>
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
                <div>
                    <h1 class="text-4xl md:text-6xl font-black text-slate-900 leading-tight">
                        Mes Favoris
                    </h1>
                    <p class="text-slate-500 font-medium max-w-lg mt-4">
                        Retrouvez ici tous les produits que vous avez aimés.
                    </p>
                </div>
                <div class="bg-slate-50 px-6 py-4 rounded-3xl border border-slate-100 flex items-center gap-4">
                    <span class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Coups de coeur :</span>
                    <span class="text-xl font-black text-primary">{{ $wishlists->count() }}</span>
                </div>
            </div>
        </div>
    </header>

    <div class="py-12 lg:py-24 bg-slate-50/30 min-h-[60vh]">
        <div class="container-custom">
            @if($wishlists->count() > 0)
                <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-10">
                    @foreach($wishlists as $wishlist)
                        @php $product = $wishlist->product; @endphp
                        <div class="product-card-lahad group bg-white rounded-[40px] overflow-hidden" x-data="{ removed: false }" x-show="!removed" x-transition:leave="transition ease-in duration-300 transform scale-95 opacity-0">
                            <div class="product-card-img h-64 relative overflow-hidden">
                                <a href="{{ route('shop.product', $product->slug) }}">
                                    <img src="{{ $product->image ?: 'https://images.unsplash.com/photo-1596733430284-f7437764b1a9?q=80&w=800&auto=format&fit=crop' }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
                                </a>
                                
                                <div class="absolute top-4 right-4 z-20">
                                    <button @click.prevent="
                                        fetch('{{ route('wishlist.toggle', $product) }}', {
                                            method: 'POST',
                                            headers: {
                                                'X-CSRF-TOKEN': document.querySelector('meta[name=&quot;csrf-token&quot;]').getAttribute('content'),
                                                'Accept': 'application/json'
                                            }
                                        }).then(res => res.json()).then(data => {
                                            removed = true;
                                            window.dispatchEvent(new CustomEvent('wishlist-updated', { detail: { count: data.count } }));
                                        })
                                    " class="w-8 h-8 rounded-full bg-primary text-white backdrop-blur-sm flex items-center justify-center transition-all shadow-lg hover:scale-110">
                                        <i class="fas fa-heart text-[10px]"></i>
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
                                    <h3 class="text-xl font-black text-slate-900 mb-3 truncate hover:text-primary transition-colors">
                                        {{ $product->name }}
                                    </h3>
                                </a>
                                <div class="flex items-end justify-between mt-6">
                                    <div>
                                        <div class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Prix</div>
                                        <div class="text-2xl font-black text-primary flex items-baseline gap-1">
                                            {{ number_format($product->price, 0, ',', ' ') }} 
                                            <span class="text-[10px] text-primary/60 uppercase">CFA</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('shop.product', $product->slug) }}" class="text-slate-300 hover:text-primary transition-colors">
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-20 bg-white rounded-[40px] border border-dashed border-slate-200">
                    <div class="w-20 h-20 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="far fa-heart text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-black text-slate-900 mb-2">Votre liste est vide</h3>
                    <p class="text-slate-400 font-medium mb-8">Vous n'avez pas encore ajouté de coups de coeur.</p>
                    <a href="{{ route('shop.index') }}" class="btn-lahad px-10 py-4 inline-block">
                        Explorer la boutique
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
