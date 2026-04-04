<x-app-layout>
    <!-- Product Detail Header -->
    <header class="py-12 bg-white border-b border-slate-50">
        <div class="container-custom">
            <nav class="flex mb-4 text-xs font-bold text-slate-400 uppercase tracking-widest gap-2">
                <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Accueil</a>
                <span>/</span>
                <a href="{{ route('shop.index') }}" class="hover:text-primary transition-colors">Boutique</a>
                <span>/</span>
                <a href="{{ route('shop.category', $product->category->slug) }}" class="hover:text-primary transition-colors">{{ $product->category->name }}</a>
                <span>/</span>
                <span class="text-slate-900">{{ $product->name }}</span>
            </nav>
        </div>
    </header>

    <div class="py-12 lg:py-20">
        <div class="container-custom">
            <div class="grid lg:grid-cols-2 gap-16 items-start">
                <!-- Product Gallery -->
                <div class="fade-in">
                    <div class="aspect-square rounded-[40px] overflow-hidden bg-slate-50 border border-slate-100 group">
                        <img src="{{ $product->image ?: 'https://images.unsplash.com/photo-1596733430284-f7437764b1a9?q=80&w=1200&auto=format&fit=crop' }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                    </div>
                </div>

                <!-- Product Info -->
                <div class="fade-in" style="animation-delay: 0.1s">
                    <div class="space-y-10">
                        <div>
                            <div class="flex items-center gap-4 mb-6">
                                <span class="px-4 py-1.5 bg-secondary/10 text-secondary text-[10px] font-black uppercase tracking-widest rounded-lg">
                                    {{ $product->category->name }}
                                </span>
                                <div class="flex items-center gap-1 text-sm text-amber-500 font-bold">
                                    <i class="fas fa-star"></i>
                                    <span>{{ number_format($product->rating ?: 4.8, 1) }}</span>
                                    <span class="text-slate-300 font-medium ml-1">(24 avis)</span>
                                </div>
                            </div>
                            
                            <h1 class="text-4xl md:text-5xl font-black text-slate-900 leading-tight mb-6">{{ $product->name }}</h1>
                            
                            <div class="flex items-center gap-4 text-sm font-semibold text-slate-500">
                                <i class="fas fa-map-marker-alt text-primary"></i>
                                <span>Origine : {{ $product->location ?: 'Dakar, Sénégal' }}</span>
                            </div>
                        </div>

                        <div class="text-4xl font-black text-primary">
                            {{ number_format($product->price, 0, ',', ' ') }} 
                            <span class="text-lg text-primary/60 font-bold ml-1 uppercase">CFA</span>
                        </div>

                        <div class="prose prose-slate prose-lg text-slate-500 max-w-none">
                            <p>{{ $product->description }}</p>
                        </div>

                        <!-- Stats/Features -->
                        <div class="grid grid-cols-2 gap-6 p-8 bg-slate-50 rounded-3xl">
                            <div class="space-y-1">
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Stock disponible</p>
                                <p class="text-xl font-bold text-slate-900">{{ $product->stock }} Unités</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Livraison</p>
                                <p class="text-xl font-bold text-slate-900 flex items-center gap-2">
                                    <i class="fas fa-truck-fast text-primary"></i> 24h - 48h
                                </p>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4">
                            <form action="{{ route('cart.add', $product) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" class="w-full btn-lahad py-5 text-lg">
                                    Ajouter au panier <i class="fas fa-shopping-basket ml-2"></i>
                                </button>
                            </form>
                            <a href="https://wa.me/221773004050" class="btn-lahad-outline py-5 px-8">
                                <i class="fab fa-whatsapp text-2xl text-[#25D366]"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Products -->
            @if($relatedProducts->count() > 0)
                <div class="mt-32 pt-20 border-t border-slate-100">
                    <div class="flex items-center justify-between mb-12">
                        <h2 class="text-2xl font-black text-slate-900">Articles similaires</h2>
                        <a href="{{ route('shop.index') }}" class="text-sm font-bold text-primary hover:underline">Voir tout le catalogue</a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                        @foreach($relatedProducts as $related)
                            <div class="product-card-lahad group">
                                <div class="product-card-img">
                                    <a href="{{ route('shop.product', $related->slug) }}">
                                        <img src="{{ $related->image ?: 'https://images.unsplash.com/photo-1596733430284-f7437764b1a9?q=80&w=800&auto=format&fit=crop' }}" 
                                             alt="{{ $related->name }}" 
                                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                    </a>
                                    <form action="{{ route('cart.add', $related) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="product-card-btn-add">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </form>
                                </div>
                                <div class="p-6">
                                    <a href="{{ route('shop.product', $related->slug) }}">
                                        <h3 class="text-lg font-bold text-slate-900 mb-3 truncate hover:text-primary transition-colors">
                                            {{ $related->name }}
                                        </h3>
                                    </a>
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center gap-2 text-xs text-slate-400 font-bold uppercase tracking-widest">
                                            <i class="fas fa-map-marker-alt text-primary"></i>
                                            <span>{{ $related->location ?: 'Dakar' }}</span>
                                        </div>
                                        <div class="flex items-center gap-1 text-xs text-amber-500 font-bold">
                                            <i class="fas fa-star text-[10px]"></i>
                                            <span>{{ number_format($related->rating ?: 4.8, 1) }}</span>
                                        </div>
                                    </div>
                                    <div class="text-2xl font-black text-primary">
                                        {{ number_format($related->price, 0, ',', ' ') }} 
                                        <span class="text-xs text-primary/60 font-bold ml-1 uppercase">CFA</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
