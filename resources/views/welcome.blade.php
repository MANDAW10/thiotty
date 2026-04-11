<x-app-layout>
    <!-- Immersive Cinematic Hero -->
    <!-- Sophisticated Split Hero -->
    <section class="relative py-12 lg:py-24 overflow-hidden bg-white">
        <!-- Decoration background -->
        <div class="absolute top-0 right-0 w-1/2 h-full bg-slate-50/50 -z-10 hidden lg:block"></div>
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-primary/5 rounded-full blur-[100px] -z-10"></div>

        <div class="container-custom relative z-10">
            <div class="grid lg:grid-cols-2 gap-16 lg:gap-24 items-center">
                
                <!-- Left Content -->
                <div class="text-center lg:text-left">
                    <!-- Premium Badge -->
                    <div class="fade-in mb-8 lg:mb-10">
                        <div class="inline-flex items-center gap-3 px-6 py-2.5 bg-primary/5 border border-primary/10 rounded-full">
                            <span class="w-1.5 h-1.5 bg-primary rounded-full animate-pulse shadow-[0_0_10px_rgba(255,87,34,0.8)]"></span>
                            <span class="text-[10px] sm:text-xs font-black text-primary uppercase tracking-[0.3em]">L'Art de l'Agriculture Sénégalaise</span>
                        </div>
                    </div>

                    <h1 class="fade-in text-5xl sm:text-7xl lg:text-8xl font-black text-slate-900 leading-[1.05] mb-8 lg:mb-10 serif-heading">
                        L'Excellence <br class="hidden lg:block">
                        <span class="italic-font text-primary underline decoration-primary/10 underline-offset-[12px]">Signature</span>
                    </h1>

                    <p class="fade-in text-lg sm:text-xl text-slate-500 font-medium mb-10 lg:mb-14 max-w-xl leading-relaxed lg:mx-0 mx-auto" style="animation-delay: 0.2s">
                        De nos pâturages à votre table. Découvrez la pureté des produits Thiotty, façonnés par la passion et l'innovation au cœur du Sénégal.
                    </p>

                    <div class="fade-in flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-6" style="animation-delay: 0.4s">
                        <a href="{{ route('shop.index') }}" class="btn-thiotty w-full sm:w-auto px-12 py-5 text-sm uppercase tracking-[0.2em] shadow-2xl">
                            Explorer la Collection
                        </a>
                        <a href="#categories" class="group flex items-center gap-4 text-xs font-black uppercase tracking-[0.3em] text-slate-900 hover:text-primary transition-all">
                            Découvrir les Univers
                            <i class="fas fa-arrow-right transform group-hover:translate-x-2 transition-transform"></i>
                        </a>
                    </div>
                </div>

                <!-- Right Visual -->
                <div class="fade-in relative" style="animation-delay: 0.3s">
                    <div class="relative z-10 rounded-[60px] overflow-hidden shadow-[0_40px_100px_-15px_rgba(0,0,0,0.2)] aspect-[4/5] lg:aspect-auto lg:h-[700px]">
                        <img src="{{ asset('img/banners/hero-main.png') }}" class="w-full h-full object-cover scale-105 animate-[slowZoom_20s_ease-in-out_infinite]" alt="Thiotty Vision">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/40 via-transparent to-transparent"></div>
                    </div>
                    
                    <!-- Floating Highlight -->
                    <div class="absolute -bottom-10 -right-10 w-48 h-48 bg-secondary/10 rounded-full blur-[80px] -z-10"></div>
                </div>

            </div>
        </div>
    </section>

    <!-- Luxury Category Grid (The Lookbook) -->
    <section id="categories" class="py-24 bg-white">
        <div class="container-custom">
            <div class="flex flex-col md:flex-row items-end justify-between mb-16 gap-6">
                <div class="max-w-xl">
                    <h2 class="text-xs font-black text-primary uppercase tracking-[0.4em] mb-4">Nos Univers</h2>
                    <h3 class="text-4xl md:text-5xl font-black text-slate-900 leading-tight serif-heading">
                        Parcourez nos <span class="italic-font">terroirs</span> d'exception.
                    </h3>
                </div>
                <div class="mb-2">
                    <div class="h-1 w-24 bg-primary/20 rounded-full"></div>
                </div>
            </div>

            <div class="bento-grid">
                @php
                    $catImages = [
                        'vaches'     => asset('img/categories/vaches.png'),
                        'chevaux'    => 'https://images.unsplash.com/photo-1553284965-83fd3e82fa5a?q=80&w=1000&auto=format&fit=crop',
                        'poulets'    => 'https://images.unsplash.com/photo-1548550023-2bdb3c5beed7?q=80&w=1000&auto=format&fit=crop',
                        'terroir'    => 'https://images.unsplash.com/photo-1464226184884-fa280b87c399?q=80&w=1000&auto=format&fit=crop',
                        'culture'    => 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=1000&auto=format&fit=crop',
                        'logistique' => 'https://images.unsplash.com/photo-1586528116311-ad86d7c7ce80?q=80&w=1000&auto=format&fit=crop',
                        'elevage'    => 'https://images.unsplash.com/photo-1547496502-affa22d38842?q=80&w=1000&auto=format&fit=crop'
                    ];

                    $slugs = ['vaches', 'chevaux', 'poulets', 'terroir', 'culture', 'logistique', 'elevage'];
                @endphp

                @foreach($categories->sortBy(fn($c) => array_search($c->slug, $slugs)) as $cat)
                    @php
                        $spanClass = '';
                        if($cat->slug === 'vaches') $spanClass = 'bento-span-2 bento-row-span-2';
                        elseif($cat->slug === 'chevaux') $spanClass = 'bento-span-2 bento-row-span-1';
                        else $spanClass = 'bento-span-1 bento-row-span-1';
                    @endphp

                    <a href="{{ route('shop.category', $cat->slug) }}" 
                       class="bento-item {{ $spanClass }} group hover-glare">
                        
                        <!-- Premium Badge -->
                        <div class="bento-badge">
                            {{ $cat->products_count }} Articles
                        </div>

                        <img src="{{ $catImages[$cat->slug] ?? 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=1000&auto=format&fit=crop' }}" 
                             class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" alt="{{ $cat->name }}">
                        
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/10 to-transparent"></div>
                        
                        <div class="absolute bottom-10 left-10 right-10 z-10 transform transition-transform duration-500 group-hover:-translate-y-4">
                            <div class="w-10 h-10 bg-white/10 backdrop-blur-md rounded-xl flex items-center justify-center text-white mb-4 border border-white/20">
                                <i class="{{ $cat->icon }} text-base"></i>
                            </div>
                            <h4 class="text-2xl md:text-3xl font-black text-white serif-heading mb-2">{{ $cat->name }}</h4>
                            <div class="flex items-center gap-3 opacity-0 group-hover:opacity-100 transition-all duration-500">
                                <span class="text-[9px] font-black text-primary uppercase tracking-[0.2em]">Découvrir la gamme</span>
                                <div class="w-8 h-[1px] bg-primary"></div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- The Thiotty Heritage (Storytelling) -->
    <section class="py-32 bg-slate-900 text-white overflow-hidden relative">
        <!-- Abstract Decoration -->
        <div class="absolute -top-64 -right-64 w-[600px] h-[600px] bg-primary/10 rounded-full blur-[120px]"></div>
        <div class="absolute -bottom-64 -left-64 w-[600px] h-[600px] bg-secondary/10 rounded-full blur-[120px]"></div>

        <div class="container-custom relative z-10">
            <div class="grid lg:grid-cols-2 gap-24 items-center">
                <div class="relative order-2 lg:order-1">
                    <div class="relative z-10 rounded-[60px] overflow-hidden shadow-2xl shadow-black/50 aspect-[4/5]">
                        <img src="https://images.unsplash.com/photo-1629904853716-f0bc54ea4813?q=80&w=1000&auto=format&fit=crop" class="w-full h-full object-cover" alt="Notre Passion">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent"></div>
                    </div>
                    <!-- Floating Stat Card -->
                    <div class="absolute -bottom-10 -right-10 md:right-10 bg-white p-10 rounded-[40px] shadow-2xl text-slate-900 border border-slate-100 hidden sm:block">
                        <p class="text-[10px] font-black text-primary uppercase tracking-[0.3em] mb-2">Impact Local</p>
                        <h4 class="text-4xl font-black serif-heading">+500</h4>
                        <p class="text-xs font-bold text-slate-400 mt-1 uppercase tracking-widest">Producteurs Partenaires</p>
                    </div>
                </div>

                <div class="order-1 lg:order-2">
                    <h2 class="text-xs font-black text-primary uppercase tracking-[0.4em] mb-6">Notre Héritage</h2>
                    <h3 class="text-5xl md:text-6xl font-black mb-10 leading-tight serif-heading">
                        La passion de la terre, <br>
                        <span class="italic-font text-primary">réinventée.</span>
                    </h3>
                    <p class="text-lg text-slate-400 font-medium leading-relaxed mb-12">
                        Depuis notre création, Thiotty Enterprise s'engage à transformer le paysage agricole sénégalais. En alliant savoir-faire ancestral et technologies de pointe, nous vous offrons le meilleur du terroir, sans compromis sur l'excellence.
                    </p>
                    
                    <div class="grid grid-cols-2 gap-12">
                        <div>
                            <div class="w-12 h-12 bg-white/5 rounded-2xl flex items-center justify-center text-primary mb-6 border border-white/10">
                                <i class="fas fa-certificate"></i>
                            </div>
                            <h4 class="text-sm font-black uppercase tracking-widest mb-3">Qualité Certifiée</h4>
                            <p class="text-xs text-slate-500 leading-relaxed font-bold">Protocoles de santé et d'hygiène stricts pour chaque produit.</p>
                        </div>
                        <div>
                            <div class="w-12 h-12 bg-white/5 rounded-2xl flex items-center justify-center text-primary mb-6 border border-white/10">
                                <i class="fas fa-leaf"></i>
                            </div>
                            <h4 class="text-sm font-black uppercase tracking-widest mb-3">100% Naturel</h4>
                            <p class="text-xs text-slate-500 leading-relaxed font-bold">Produits directs du producteur, garantis sans additifs chimiques.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Curated Product Gallery -->
    <section class="py-32 bg-slate-50/50">
        <div class="container-custom">
            <div class="flex flex-col md:flex-row items-center justify-between mb-20 gap-8">
                <div class="text-center md:text-left">
                    <h2 class="text-xs font-black text-primary uppercase tracking-[0.4em] mb-4">La Sélection</h2>
                    <h3 class="text-4xl md:text-5xl font-black text-slate-900 serif-heading">Récoltes du <span class="italic-font">Moment</span></h3>
                </div>
                <a href="{{ route('shop.index') }}" class="group flex items-center gap-4 text-xs font-black uppercase tracking-[0.3em] text-slate-900 hover:text-primary transition-all">
                    Voir toute la collection
                    <i class="fas fa-arrow-right transform group-hover:translate-x-2 transition-transform"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
                @foreach($featuredProducts as $product)
                    <div class="bg-white rounded-[48px] p-4 border border-slate-100 shadow-xl shadow-slate-200/50 group hover:-translate-y-2 transition-all duration-500">
                        <div class="aspect-[4/5] rounded-[40px] overflow-hidden relative mb-8">
                            <img src="{{ $product->image_url }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" alt="{{ $product->name }}">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/20 to-transparent"></div>
                            
                            <!-- Premium Wishlist -->
                            <div class="absolute top-6 right-6" x-data="{ isFavorited: false }">
                                <button @click.prevent="isFavorited = !isFavorited" 
                                        :class="isFavorited ? 'bg-primary text-white' : 'bg-white/80 text-primary backdrop-blur-md'"
                                        class="w-10 h-10 rounded-xl flex items-center justify-center transition-all shadow-lg active:scale-90">
                                    <i :class="isFavorited ? 'fas fa-heart' : 'far fa-heart'"></i>
                                </button>
                            </div>
                        </div>

                        <div class="px-4 pb-4">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.3em] mb-2">{{ $product->category->name }}</p>
                            <h4 class="text-xl font-black text-slate-900 mb-4 line-clamp-1 serif-heading">{{ $product->name }}</h4>
                            
                            <div class="flex items-center justify-between">
                                <div class="text-xl font-black text-primary">
                                    {{ number_format($product->price, 0, ',', ' ') }} 
                                    <span class="text-[10px] uppercase font-bold text-primary/60">CFA</span>
                                </div>
                                <form action="{{ route('cart.add', $product) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-10 h-10 bg-slate-900 text-white rounded-xl shadow-xl flex items-center justify-center hover:bg-primary transition-all active:scale-90">
                                        <i class="fas fa-plus text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Refined Testimonials Section -->
    <section class="py-24 bg-white overflow-hidden">
        <div class="container-custom">
            <div class="text-center mb-16">
                <h2 class="text-xs font-black uppercase tracking-[0.3em] text-primary mb-4">Distinction Thiotty</h2>
                <h3 class="text-4xl md:text-5xl font-black text-slate-900 serif-heading">La Confiance de <span class="italic-font underline decoration-primary/20 underline-offset-8">nos Clients</span></h3>
            </div>

            <div class="relative">
                <div class="flex animate-marquee py-12">
                    @php
                        $testimonials = [
                            ['name' => 'Pape Mandaw Dieng', 'role' => 'Éleveur Pro', 'text' => "L'excellence Thiotty est sans pareille. La qualité du bétail transforme mon exploitation au quotidien."],
                            ['name' => 'Abdou Lahad Geuye', 'role' => 'Gastronome', 'text' => "Un goût authentique retrouvé. Le lait frais de Thiotty est devenu un incontournable de mon petit-déjeuner."],
                            ['name' => 'Fatou Fall', 'role' => 'Restauratrice', 'text' => "Nos clients redemandent de la volaille Thiotty. La fraîcheur et la tendreté sont toujours au rendez-vous."]
                        ];
                    @endphp

                    @foreach(array_merge($testimonials, $testimonials) as $t)
                        <div class="flex-none w-[450px]">
                            <div class="bg-slate-50 p-12 rounded-[50px] border border-slate-100 flex flex-col h-full group hover:bg-white hover:shadow-2xl hover:shadow-slate-200/50 transition-all duration-500">
                                <div class="flex gap-1 mb-8 text-amber-500">
                                    <i class="fas fa-star text-[10px]"></i><i class="fas fa-star text-[10px]"></i><i class="fas fa-star text-[10px]"></i><i class="fas fa-star text-[10px]"></i><i class="fas fa-star text-[10px]"></i>
                                </div>
                                <p class="text-slate-600 font-medium italic leading-relaxed text-lg mb-10">"{{ $t['text'] }}"</p>
                                <div class="flex items-center gap-4 pt-8 border-t border-slate-200 mt-auto">
                                    <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center font-black text-primary text-xl">
                                        {{ substr($t['name'], 0, 1) }}
                                    </div>
                                    <div>
                                        <h4 class="font-black text-slate-900 text-sm uppercase tracking-widest">{{ $t['name'] }}</h4>
                                        <p class="text-[10px] font-bold text-primary uppercase mt-1">{{ $t['role'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <style>
        @keyframes slowZoom {
            0%, 100% { transform: scale(1.05); }
            50% { transform: scale(1.15); }
        }
    </style>
</x-app-layout>
