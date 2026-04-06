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
                        <a href="{{ route('shop.index') }}" class="btn-thiotty w-full sm:w-auto px-10 py-4">
                            Explorer les produits
                        </a>
                        <a href="#" class="btn-thiotty-outline w-full sm:w-auto px-10 py-4">
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

    <!-- Features Section -->
    <section class="py-12 border-y border-slate-100 bg-white">
        <div class="container-custom">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <!-- Feature 1: Payment -->
                <div class="flex items-center gap-6 group">
                    <div class="w-14 h-14 bg-primary/10 text-primary rounded-2xl flex items-center justify-center shrink-0 transition-transform group-hover:scale-110">
                        <i class="fas fa-hand-holding-dollar text-xl"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-1">Paiement à la Livraison</h4>
                        <p class="text-xs text-slate-500 font-medium">Commandez l'esprit tranquille, payez à réception.</p>
                    </div>
                </div>

                <!-- Feature 2: Delivery -->
                <div class="flex items-center gap-6 group">
                    <div class="w-14 h-14 bg-secondary/10 text-secondary rounded-2xl flex items-center justify-center shrink-0 transition-transform group-hover:scale-110">
                        <i class="fas fa-truck-fast text-xl"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-1">Livraison Express</h4>
                        <p class="text-xs text-slate-500 font-medium">Vos produits livrés chez vous en 24h à Dakar.</p>
                    </div>
                </div>

                <!-- Feature 3: Quality -->
                <div class="flex items-center gap-6 group">
                    <div class="w-14 h-14 bg-amber-100 text-amber-600 rounded-2xl flex items-center justify-center shrink-0 transition-transform group-hover:scale-110">
                        <i class="fas fa-award text-xl"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-1">Qualité Bio & Fraiche</h4>
                        <p class="text-xs text-slate-500 font-medium">Des produits direct du producteur au client.</p>
                    </div>
                </div>
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

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 sm:gap-8">
                @foreach($featuredProducts as $product)
                    <div class="product-card-thiotty group fade-in" style="animation-delay: {{ $loop->index * 0.1 }}s">
                        <div class="product-card-img">
                            <a href="{{ route('shop.product', $product->slug) }}">
                                <img src="{{ $product->image_url }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                            </a>
                            
                            <!-- Big Heart Wishlist Icon -->
                            <div class="absolute top-3 right-3 sm:top-4 sm:right-4 z-20" x-data="{ 
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
                                        :class="isFavorited ? 'bg-white text-primary shadow-lg' : 'bg-white/80 text-slate-400 hover:text-primary'"
                                        class="w-10 h-10 sm:w-8 sm:h-8 rounded-full backdrop-blur-sm flex items-center justify-center transition-all shadow-sm group/heart">
                                    <i class="text-xs sm:text-[10px]" :class="isFavorited ? 'fas fa-heart scale-125' : 'far fa-heart group-hover/heart:scale-110 transition-transform'"></i>
                                </button>
                            </div>

                            <!-- Desktop Floating Button (Hidden on Mobile) -->
                            <form action="{{ route('cart.add', $product) }}" method="POST" class="hidden sm:block">
                                @csrf
                                <button type="submit" class="product-card-btn-add">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </form>
                        </div>
                        
                        <div class="p-4 sm:p-6">
                            <a href="{{ route('shop.product', $product->slug) }}">
                                <h3 class="text-base sm:text-lg font-black text-slate-900 mb-2 sm:mb-3 line-clamp-2 hover:text-primary transition-colors min-h-[3rem] sm:min-h-0">
                                    {{ $product->name }}
                                </h3>
                            </a>
                            
                            <!-- Secondary Info (Hidden on Mobile) -->
                            <div class="hidden sm:flex items-center justify-between mb-4">
                                <div class="flex items-center gap-2 text-xs text-slate-400 font-bold uppercase tracking-widest">
                                    <i class="fas fa-map-marker-alt text-primary"></i>
                                    <span>{{ $product->location ?: 'Dakar' }}</span>
                                </div>
                                <div class="flex items-center gap-1 text-xs text-amber-500 font-bold">
                                    <i class="fas fa-star text-[10px]"></i>
                                    <span>{{ number_format($product->rating ?: 4.8, 1) }}</span>
                                </div>
                            </div>

                            <div class="text-xl sm:text-2xl font-black text-primary mb-5 sm:mb-0">
                                {{ number_format($product->price, 0, ',', ' ') }} 
                                <span class="text-[10px] sm:text-xs text-primary/60 font-bold ml-1 uppercase">CFA</span>
                            </div>

                            <!-- Mobile Action Button (Hidden on Desktop) -->
                            <form action="{{ route('cart.add', $product) }}" method="POST" class="sm:hidden mt-4">
                                @csrf
                                <button type="submit" class="w-full bg-primary/5 hover:bg-primary text-primary hover:text-white py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all active:scale-95 flex items-center justify-center gap-2 border border-primary/10">
                                    <i class="fas fa-shopping-basket"></i> Ajouter
                                </button>
                            </form>
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

            <!-- Infinite Auto-Scroll Marquee -->
            <div class="relative mt-4">
                <div class="flex animate-marquee py-12">
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

                    <!-- First Set -->
                    @foreach($testimonials as $t)
                        <div class="flex-none w-[320px] md:w-[400px]">
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

                    <!-- Duplicate Set for Seamless Loop -->
                    @foreach($testimonials as $t)
                        <div class="flex-none w-[320px] md:w-[400px]">
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

                <!-- Gradient Fade Edges -->
                <div class="absolute inset-y-0 left-0 w-20 bg-gradient-to-r from-slate-50/50 to-transparent z-10 pointer-events-none"></div>
                <div class="absolute inset-y-0 right-0 w-20 bg-gradient-to-l from-slate-50/50 to-transparent z-10 pointer-events-none"></div>
            </div>
        </div>
    </section>
    <!-- Delivery Animation Section -->
    <section class="py-20 bg-white overflow-hidden border-t border-slate-50">
        <div class="container-custom">
            <div class="relative h-32 md:h-48 flex items-center">
                <!-- Decorative Road -->
                <div class="absolute inset-x-0 top-1/2 -translate-y-1/2 h-0.5 border-t-2 border-dashed border-slate-200 w-full z-0"></div>
                
                <!-- Icons -->
                <div class="absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-white pr-4">
                    <div class="w-12 h-12 md:w-16 md:h-16 bg-primary/10 text-primary rounded-2xl flex items-center justify-center shadow-lg shadow-primary/5">
                        <i class="fas fa-warehouse text-xl md:text-2xl"></i>
                    </div>
                </div>
                
                <div class="absolute right-0 top-1/2 -translate-y-1/2 z-10 bg-white pl-4">
                    <div class="w-12 h-12 md:w-16 md:h-16 bg-secondary/10 text-secondary rounded-2xl flex items-center justify-center shadow-lg shadow-secondary/5">
                        <i class="fas fa-house-chimney text-xl md:text-2xl"></i>
                    </div>
                    <!-- Tooltip -->
                    <div class="absolute -top-12 right-0 bg-secondary text-white text-[10px] font-black uppercase tracking-widest px-4 py-2 rounded-xl whitespace-nowrap shadow-xl">
                        Chez vous en 24h 🚀
                    </div>
                </div>

                <!-- Animated Truck -->
                <div class="animate-delivery absolute z-20 top-1/2 -translate-y-1/2 mt-[-10px] md:mt-[-20px]">
                    <div class="relative">
                        <img src="{{ asset('img/gallery/truck.png') }}" 
                             alt="Thiotty Delivery" 
                             class="w-24 md:w-48 h-auto object-contain transition-transform">
                        <!-- Speed effect lines -->
                        <div class="absolute -left-8 top-1/2 -translate-y-1/2 flex flex-col gap-1 opacity-20">
                            <div class="w-6 h-0.5 bg-primary rounded-full"></div>
                            <div class="w-4 h-0.5 bg-primary rounded-full ml-2"></div>
                            <div class="w-5 h-0.5 bg-primary rounded-full"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-12">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.4em]">Livraison Express Thiotty Enterprise</p>
            </div>
        </div>
    </section>
</x-app-layout>
