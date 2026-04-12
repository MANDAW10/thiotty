<x-app-layout>
    <!-- Product Detail Header (Simplified) -->
    <header class="py-8 bg-slate-50 border-b border-slate-100">
        <div class="container-custom">
            <nav class="flex flex-wrap items-center gap-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-0">
                <a href="{{ route('home') }}" class="hover:text-[var(--primary)] transition-colors">{{ __('messages.home') }}</a>
                <span class="opacity-30">/</span>
                <a href="{{ route('shop.index') }}" class="hover:text-[var(--primary)] transition-colors">{{ __('messages.shop') }}</a>
                <span class="opacity-30">/</span>
                <a href="{{ route('shop.category', $product->category->slug) }}" class="hover:text-[var(--primary)] transition-colors">{{ $product->category->display_name }}</a>
                <span class="opacity-30">/</span>
                <span class="text-slate-900 truncate max-w-[150px] sm:max-w-none">{{ $product->display_name }}</span>
            </nav>
        </div>
    </header>

    <div class="py-12 lg:py-24 bg-white min-h-screen">
        <div class="container-custom">
            <div class="grid lg:grid-cols-12 gap-12 lg:gap-20 items-start">
                
                <!-- Product Gallery Section (Col 1-7) -->
                <div class="lg:col-span-7 space-y-8">
                    <div class="relative group bg-slate-50 border border-slate-100 p-0">
                        <div class="aspect-square overflow-hidden bg-white">
                            <img src="{{ $product->image_url }}" 
                                 alt="{{ $product->display_name }}" 
                                 class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105">
                        </div>
                        
                        <!-- Badges (Structured) -->
                        <div class="absolute top-0 left-0 flex flex-col gap-0">
                            <span class="px-6 py-3 bg-[var(--primary)] text-white text-[10px] font-black uppercase tracking-widest">
                                {{ $product->category->display_name }}
                            </span>
                            @if($product->is_featured)
                            <span class="px-6 py-3 bg-[var(--secondary)] text-white text-[10px] font-black uppercase tracking-widest">
                                {{ __('messages.top_pick') }}
                            </span>
                            @endif
                        </div>
                    </div>

                    <!-- Industrial Features Grid -->
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-0 border border-slate-100">
                        <div class="p-8 border-r border-b lg:border-b-0 border-slate-100 text-center bg-slate-50">
                            <div class="text-[var(--primary)] mb-4"><i class="fas fa-seedling text-xl"></i></div>
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">{{ __('messages.quality') }}</p>
                            <p class="text-xs font-black text-slate-800 uppercase tracking-tight">{{ __('messages.natural') }}</p>
                        </div>
                        <div class="p-8 border-r border-b lg:border-b-0 border-slate-100 text-center bg-slate-50">
                            <div class="text-[var(--primary)] mb-4"><i class="fas fa-truck-fast text-xl"></i></div>
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">{{ __('messages.delivery_label') }}</p>
                            <p class="text-xs font-black text-slate-800 uppercase tracking-tight">{{ __('messages.express_24h') }}</p>
                        </div>
                        <div class="p-8 border-r border-slate-100 text-center bg-slate-50">
                            <div class="text-[var(--primary)] mb-4"><i class="fas fa-map-location-dot text-xl"></i></div>
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">{{ __('messages.origin') }}</p>
                            <p class="text-xs font-black text-slate-800 uppercase tracking-tight">{{ $product->location ?: __('messages.senegal') }}</p>
                        </div>
                        <div class="p-8 text-center bg-slate-50">
                            <div class="text-[var(--primary)] mb-4"><i class="fas fa-shield-check text-xl"></i></div>
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">{{ __('messages.payment') }}</p>
                            <p class="text-xs font-black text-slate-800 uppercase tracking-tight">{{ __('messages.secure') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Product Buying Section (Col 8-12) -->
                <div class="lg:col-span-5 sticky top-36">
                    <div class="space-y-12 border-l-8 border-[var(--primary)] pl-12 py-4">
                        <div class="space-y-4">
                            <div class="flex items-center gap-3">
                                <div class="flex text-[var(--secondary)] text-xs">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fa{{ $i <= round($product->average_rating) ? 's' : 'r' }} fa-star"></i>
                                    @endfor
                                </div>
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">({{ $product->reviews_count }} avis)</span>
                            </div>
                            <h1 class="text-4xl md:text-6xl font-black text-slate-800 uppercase tracking-tight leading-[1.1]">
                                {{ $product->display_name }}
                            </h1>
                        </div>

                        <div class="space-y-8">
                            <div class="flex items-baseline gap-3">
                                <span class="text-6xl font-black text-[var(--secondary)] tracking-tighter">{{ number_format($product->price, 0, ',', ' ') }}</span>
                                <span class="text-xl font-bold text-slate-400 uppercase">CFA</span>
                            </div>

                            <p class="text-slate-600 text-lg leading-relaxed font-medium">
                                {{ $product->description ?: 'Ce produit de qualité industrielle supérieure est disponible pour vos besoins agricoles et d\'élevage.' }}
                            </p>

                            <div class="space-y-4 pt-8">
                                <form @submit.prevent="
                                    fetch('{{ route('cart.add', $product) }}', {
                                        method: 'POST',
                                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                                    })
                                    .then(r => r.json())
                                    .then(data => {
                                        if(data.success) {
                                            $dispatch('cart-updated', { count: data.count });
                                            $dispatch('add-toast', { message: data.message, type: 'success' });
                                        }
                                    })
                                ">
                                    @csrf
                                    <button type="submit" class="w-full py-6 bg-[var(--primary)] text-white text-base font-black uppercase tracking-widest hover:bg-[var(--primary-hover)] transition-all flex items-center justify-center gap-4">
                                        <span>{{ __('messages.add_to_cart_detail') }}</span>
                                        <i class="fas fa-shopping-basket"></i>
                                    </button>
                                </form>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <button @click="$dispatch('wishlist-toggle', { id: {{ $product->id }} })" class="flex items-center justify-center gap-3 py-4 bg-slate-50 border border-slate-100 text-[10px] font-black uppercase tracking-widest text-slate-600 hover:bg-white transition-all">
                                         <i class="far fa-heart"></i> Favoris
                                    </button>
                                    <a href="https://wa.me/221783577431?text={{ urlencode('Bonjour, je souhaite commander : ' . $product->name) }}" target="_blank" class="flex items-center justify-center gap-3 py-4 bg-[#25D366] text-white text-[10px] font-black uppercase tracking-widest hover:bg-[#128C7E] transition-all">
                                         <i class="fab fa-whatsapp"></i> Order Status
                                    </a>
                                </div>
                            </div>

                            <div class="pt-8 border-t border-slate-100">
                                <div class="flex items-center gap-4 mb-2">
                                    <i class="fas fa-check-circle text-[var(--primary)]"></i>
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ __('messages.in_stock') }}</span>
                                </div>
                                <div class="flex items-center gap-4">
                                    <i class="fas fa-shield-alt text-[var(--primary)]"></i>
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ __('messages.ssl_secure') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reviews & Customer Feedback Section -->
            <div class="mt-32 border-t border-slate-100 pt-24">
                <div class="grid lg:grid-cols-12 gap-16">
                    <!-- Left: Review Summary -->
                    <div class="lg:col-span-4 space-y-12">
                        <div class="border-l-4 border-[var(--primary)] pl-6">
                            <h2 class="text-3xl font-black text-slate-800 uppercase tracking-tight mb-2">Avis Clients</h2>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Retours d'expérience sur ce produit</p>
                        </div>

                        <div class="bg-slate-50 p-10 border border-slate-100 flex flex-col items-center text-center">
                            <span class="text-7xl font-black text-slate-900 tracking-tighter mb-4">{{ $product->average_rating }}</span>
                            <div class="flex text-[var(--secondary)] text-lg mb-6 tracking-widest">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fa{{ $i <= round($product->average_rating) ? 's' : 'r' }} fa-star"></i>
                                @endfor
                            </div>
                            <p class="text-[11px] font-black text-slate-500 uppercase tracking-widest">Sur {{ $product->reviews_count }} avis vérifiés</p>
                        </div>

                        @auth
                            <div class="space-y-6 pt-6" x-data="{ openForm: false }">
                                <button @click="openForm = !openForm" class="w-full py-5 bg-slate-900 text-white text-[11px] font-black uppercase tracking-widest hover:bg-[var(--primary)] transition-all">
                                    Laisser un Avis
                                </button>

                                <div x-show="openForm" x-transition class="p-8 bg-white border-2 border-slate-100 shadow-xl" style="display: none;">
                                    <form action="{{ route('reviews.store', $product) }}" method="POST" class="space-y-6">
                                        @csrf
                                        <div class="space-y-2">
                                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Votre Note</label>
                                            <div class="flex flex-row-reverse justify-end gap-2 text-2xl" x-data="{ hovered: 0, selected: 5 }">
                                                <input type="hidden" name="rating" :value="selected">
                                                <template x-for="i in [5,4,3,2,1]">
                                                    <i class="cursor-pointer transition-colors"
                                                       :class="(hovered >= i || selected >= i) ? 'fas fa-star text-[var(--secondary)]' : 'far fa-star text-slate-200'"
                                                       @mouseenter="hovered = i"
                                                       @mouseleave="hovered = 0"
                                                       @click="selected = i"></i>
                                                </template>
                                            </div>
                                        </div>
                                        <div class="space-y-2">
                                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Commentaire</label>
                                            <textarea name="comment" rows="4" class="w-full bg-slate-50 border-none p-4 font-bold text-slate-900 focus:ring-2 focus:ring-[var(--primary)]/20 transition-all text-sm uppercase placeholder:text-slate-300" placeholder="PARTAGEZ VOTRE EXPÉRIENCE..."></textarea>
                                        </div>
                                        <button type="submit" class="w-full py-4 bg-[var(--primary)] text-white text-[11px] font-black uppercase tracking-widest shadow-lg shadow-[var(--primary)]/20 hover:scale-[1.02] transition-all">
                                            Publier mon Avis
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <div class="p-8 bg-slate-50 border border-slate-100 flex flex-col items-center text-center gap-4">
                                <i class="fas fa-lock text-slate-300"></i>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Connectez-vous pour laisser un avis sur ce produit.</p>
                                <button @click="$dispatch('open-login')" class="text-[10px] font-black text-[var(--primary)] uppercase tracking-widest border-b-2 border-[var(--primary)] hover:opacity-70 transition-opacity">Se Connecter</button>
                            </div>
                        @endauth
                    </div>

                    <!-- Right: Review List -->
                    <div class="lg:col-span-8">
                        @php
                            $approvedReviews = $product->reviews()->where('is_approved', true)->latest()->get();
                        @endphp

                        @if($approvedReviews->count() > 0)
                            <div class="space-y-8">
                                @foreach($approvedReviews as $review)
                                    <div class="bg-white p-8 sm:p-12 border border-slate-50 shadow-sm relative group overflow-hidden">
                                        <div class="absolute top-0 right-0 p-8 opacity-5 group-hover:opacity-10 transition-opacity">
                                            <i class="fas fa-quote-right text-6xl"></i>
                                        </div>
                                        
                                        <div class="flex items-center gap-4 mb-6">
                                            <div class="w-10 h-10 bg-[var(--primary)] text-white font-black flex items-center justify-center text-xs">
                                                {{ substr($review->user->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <h4 class="text-xs font-black text-slate-900 uppercase tracking-widest">{{ $review->user->name }}</h4>
                                                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">{{ $review->created_at->format('d M Y') }}</p>
                                            </div>
                                            <div class="ml-auto flex text-[var(--secondary)] text-[10px]">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fa{{ $i <= $review->rating ? 's' : 'r' }} fa-star"></i>
                                                @endfor
                                            </div>
                                        </div>

                                        <p class="text-sm font-bold text-slate-600 leading-relaxed uppercase tracking-tight">
                                            {{ $review->comment ?: "Ce client n'a pas laissé de message mais a attribué une note de " . $review->rating . " étoiles." }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="h-full flex flex-col items-center justify-center bg-slate-50/50 border-2 border-dashed border-slate-100 p-20 text-center">
                                <div class="w-20 h-20 bg-white rounded-none flex items-center justify-center text-slate-200 mb-6 shadow-sm">
                                    <i class="far fa-star text-4xl"></i>
                                </div>
                                <h3 class="text-xl font-black text-slate-800 uppercase tracking-tight mb-2">Aucun avis pour le moment</h3>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Soyez le premier à partager votre expérience avec la communauté.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Related Products Section -->
            @if($relatedProducts->count() > 0)
                <div class="mt-32 pt-24 border-t border-slate-100">
                    <div class="mb-16 border-l-4 border-[var(--primary)] pl-6">
                        <h2 class="text-3xl font-black text-slate-800 uppercase tracking-tight">
                            {{ __('messages.you_may_also_like') }}
                        </h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-0 border-t border-l border-slate-100">
                        @foreach($relatedProducts as $related)
                            <div class="border-r border-b border-slate-100 p-4 bg-white hover:bg-slate-50 transition-colors">
                                <x-product-card :product="$related" />
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
