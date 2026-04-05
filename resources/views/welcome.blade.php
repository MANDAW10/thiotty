<x-app-layout>
    <!-- Hero Section -->
    <section class="py-12 lg:py-20 overflow-hidden">
        <div class="container-custom relative z-10 py-6 lg:py-0">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <div class="fade-in text-center lg:text-left">
                    <div class="inline-flex items-center gap-3 px-4 py-2 bg-primary/5 rounded-full mb-6 lg:mb-8">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
                        </span>
                        <span class="text-[10px] font-black text-primary uppercase tracking-widest leading-none">Agriculture 4.0 Sénégal</span>
                    </div>
                    
                    <h1 class="text-3xl sm:text-5xl md:text-6xl lg:text-7xl font-black text-slate-900 leading-[1.1] mb-6 lg:mb-8">
                        L'Excellence <br class="hidden lg:block">
                        <span class="text-primary italic-font">Agricole</span> Au <br class="hidden lg:block">
                        Sénégal.
                    </h1>
                    <p class="text-base sm:text-lg text-slate-500 mb-8 lg:mb-10 max-w-lg mx-auto lg:mx-0 leading-relaxed">
                        Découvrez les meilleurs produits locaux. Viandes, lait frais, fromages artisanaux, yaourt et aliments pour bétail.
                    </p>
                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                        <a href="{{ route('shop.index') }}" class="btn-lahad w-full sm:w-auto px-10 py-4">
                            Explorer les produits
                        </a>
                        <a href="#" class="btn-lahad-outline w-full sm:w-auto px-10 py-4">
                            Nous contacter
                        </a>
                    </div>
                </div>

                <!-- Hero Graphic: Location Card -->
                <div class="fade-in group" style="animation-delay: 0.2s">
                    <div class="relative bg-teal-50/50 rounded-[40px] aspect-[4/3] flex items-center justify-center border border-teal-100 overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-teal-500/5 to-transparent"></div>
                        <div class="relative z-10 text-center">
                            <div class="w-16 h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center mx-auto mb-4 text-primary animate-bounce">
                                <i class="fas fa-map-marker-alt text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-secondary mb-2">Où nous trouver</h3>
                            <p class="text-slate-500 text-sm">Dakar, Sénégal</p>
                        </div>
                        
                        <!-- Abstract shapes for flair -->
                        <div class="absolute -top-12 -right-12 w-48 h-48 bg-primary/5 rounded-full blur-3xl"></div>
                        <div class="absolute -bottom-12 -left-12 w-48 h-48 bg-secondary/5 rounded-full blur-3xl"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-16 bg-slate-50/30">
        <div class="container-custom">
            <div class="flex items-center justify-between mb-10">
                <h2 class="text-2xl font-black text-slate-900">Catégories</h2>
                <div class="h-1 w-20 bg-secondary rounded-full"></div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-6">
                @foreach($categories as $cat)
                    <a href="{{ route('shop.category', $cat->slug) }}" class="category-card group fade-in" style="animation-delay: {{ $loop->index * 0.05 }}s">
                        <div class="category-icon">
                            <i class="{{ $cat->icon }} text-2xl"></i>
                        </div>
                        <p class="text-xs font-black text-slate-900 leading-tight uppercase tracking-widest">{{ $cat->name }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="py-20">
        <div class="container-custom">
            <div class="flex items-center justify-between mb-12">
                <h2 class="text-2xl font-black text-slate-900">Produits à proximité</h2>
                <a href="{{ route('shop.index') }}" class="px-6 py-2 border-2 border-secondary/20 text-secondary text-sm font-bold rounded-lg hover:bg-secondary hover:text-white transition-all">
                    Voir tout
                </a>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-8">
                @foreach($featuredProducts as $product)
                    <div class="product-card-lahad group fade-in" style="animation-delay: {{ $loop->index * 0.1 }}s">
                        <div class="product-card-img">
                            <a href="{{ route('shop.product', $product->slug) }}">
                                <img src="{{ $product->image ?: 'https://images.unsplash.com/photo-1596733430284-f7437764b1a9?q=80&w=800&auto=format&fit=crop' }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                            </a>
                            
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
                        
                        <div class="p-6">
                            <a href="{{ route('shop.product', $product->slug) }}">
                                <h3 class="text-lg font-bold text-slate-900 mb-3 truncate hover:text-primary transition-colors">
                                    {{ $product->name }}
                                </h3>
                            </a>
                            
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-2 text-xs text-slate-400 font-bold uppercase tracking-widest">
                                    <i class="fas fa-map-marker-alt text-primary"></i>
                                    <span>{{ $product->location ?: 'Dakar' }}</span>
                                </div>
                                <div class="flex items-center gap-1 text-xs text-amber-500 font-bold">
                                    <i class="fas fa-star text-[10px]"></i>
                                    <span>{{ number_format($product->rating ?: 4.8, 1) }}</span>
                                </div>
                            </div>

                            <div class="text-2xl font-black text-primary">
                                {{ number_format($product->price, 0, ',', ' ') }} 
                                <span class="text-xs text-primary/60 font-bold ml-1 uppercase">CFA</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    <!-- Testimonials Section -->
    <section class="py-24 bg-slate-50/50 overflow-hidden">
        <div class="container-custom">
            <div class="text-center mb-16">
                <h2 class="text-xs font-black uppercase tracking-[0.3em] text-primary mb-4">Avis Clients</h2>
                <h3 class="text-4xl md:text-5xl font-black text-slate-900">La Voix de nos <span class="italic-font text-primary underline decoration-primary/20 underline-offset-8">Clients</span></h3>
            </div>

            <!-- Horizontal Scroll Container -->
            <div class="flex overflow-x-auto gap-8 pb-12 no-scrollbar scroll-snap-x snap-mandatory -mx-4 px-4">
                @php
                    $testimonials = [
                        [
                            'name' => 'Pape Mandaw Dieng',
                            'role' => 'Éleveur Professionnel',
                            'text' => 'Une plateforme révolutionnaire pour nous ! La qualité du bétail est tout simplement exceptionnelle. Thiotty est devenu mon partenaire numéro 1.',
                            'stars' => 5
                        ],
                        [
                            'name' => 'Abdou Lahad Geuye',
                            'role' => 'Client Fidèle',
                            'text' => 'Le lait frais livré directement à domicile au petit matin... Un pur bonheur pour toute la famille. Service et qualité irréprochables.',
                            'stars' => 5
                        ],
                        [
                            'name' => 'Fallou Geuye',
                            'role' => 'Entrepreneur Agricole',
                            'text' => 'Enfin une solution sérieuse pour l\'achat d\'aliments de bétail. Les prix sont compétitifs et la livraison est toujours ponctuelle.',
                            'stars' => 5
                        ],
                        [
                            'name' => 'Khoudosse Geuye',
                            'role' => 'Particulier',
                            'text' => 'Très impressionné par le professionnalisme de l\'équipe. Les produits sont authentiques et le service client est toujours à l\'écoute.',
                            'stars' => 5
                        ]
                    ];
                @endphp

                @foreach($testimonials as $t)
                    <div class="flex-none w-[320px] md:w-[400px] snap-center">
                        <div class="bg-white p-10 rounded-[40px] border border-slate-100 shadow-xl shadow-slate-200/50 h-full flex flex-col group hover:-translate-y-2 transition-all duration-500">
                            <div class="flex gap-1 mb-6 text-amber-400">
                                @for($i = 0; $i < $t['stars']; $i++)
                                    <i class="fas fa-star text-xs"></i>
                                @endfor
                            </div>
                            
                            <p class="text-slate-600 font-medium leading-relaxed mb-10 flex-1 italic">
                                "{{ $t['text'] }}"
                            </p>

                            <div class="flex items-center gap-4 pt-6 border-t border-slate-50">
                                <div class="w-14 h-14 rounded-2xl overflow-hidden ring-4 ring-primary/5">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($t['name']) }}&background=E65100&color=fff&bold=true" 
                                         class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <h4 class="font-black text-slate-900 uppercase tracking-widest text-xs">{{ $t['name'] }}</h4>
                                    <p class="text-[10px] font-bold text-primary mt-1">{{ $t['role'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Scroll Indicator (Dots) -->
            <div class="flex justify-center gap-2 mt-4 lg:hidden">
                <div class="w-8 h-1 bg-primary rounded-full"></div>
                <div class="w-2 h-1 bg-slate-200 rounded-full"></div>
                <div class="w-2 h-1 bg-slate-200 rounded-full"></div>
            </div>
        </div>
    </section>
</x-app-layout>
