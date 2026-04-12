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
                @php
                    $avg = $product->average_rating;
                    $fullStars = $avg ? (int) floor($avg) : 0;
                    $outOfStock = ($product->stock ?? 0) <= 0;
                @endphp
                <div class="lg:col-span-5 sticky top-36" x-data="{
                    isFavorited: {{ $product->isFavoritedBy(Auth::user()) ? 'true' : 'false' }},
                    wishlistLoading: false,
                    toggleWishlist() {
                        if ({{ Auth::check() ? 'false' : 'true' }}) { window.dispatchEvent(new CustomEvent('open-login')); return; }
                        if (this.wishlistLoading) return;
                        this.wishlistLoading = true;
                        fetch('{{ route('wishlist.toggle', $product) }}', {
                            method: 'POST',
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                        }).then(r => r.json()).then(d => {
                            this.isFavorited = (d.status === 'added');
                            this.wishlistLoading = false;
                            $dispatch('wishlist-updated', { count: d.count });
                            $dispatch('add-toast', { message: d.status === 'added' ? '{{ __('messages.add_to_wishlist_success') }}' : '{{ __('messages.remove_from_wishlist_success') }}', type: 'success' });
                        }).catch(() => this.wishlistLoading = false);
                    }
                }">
                    <div class="space-y-12 border-l-8 border-[var(--primary)] pl-12 py-4">
                        <div class="space-y-4">
                            <div class="flex items-center gap-1 text-amber-500">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star text-xs {{ $i <= $fullStars ? '' : 'opacity-20' }}"></i>
                                @endfor
                                @if($avg)
                                    <span class="text-slate-400 text-[10px] font-bold ml-2">({{ $avg }}/5 — {{ $reviews->count() }} {{ __('messages.reviews') }})</span>
                                @endif
                            </div>
                            <h1 class="text-4xl md:text-6xl font-black text-slate-800 uppercase tracking-tight leading-[1.1]">
                                {{ $product->display_name }}
                            </h1>
                        </div>

                        <div class="space-y-8">
                            <div class="flex flex-wrap items-baseline gap-3">
                                @if($product->has_sale)
                                    <span class="text-2xl font-black text-slate-300 line-through tracking-tight">{{ number_format($product->price, 0, ',', ' ') }} CFA</span>
                                @endif
                                <span class="text-6xl font-black text-[var(--secondary)] tracking-tighter">{{ number_format($product->selling_price, 0, ',', ' ') }}</span>
                                <span class="text-xl font-bold text-slate-400 uppercase">CFA</span>
                            </div>

                            @if($outOfStock)
                                <p class="text-red-600 font-black text-sm uppercase tracking-widest">{{ __('messages.out_of_stock') }}</p>
                            @endif

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
                                    <button type="submit" @if($outOfStock) disabled @endif class="w-full py-6 bg-[var(--primary)] text-white text-base font-black uppercase tracking-widest hover:bg-[var(--primary-hover)] transition-all flex items-center justify-center gap-4 disabled:opacity-40 disabled:cursor-not-allowed">
                                        <span>{{ __('messages.add_to_cart_detail') }}</span>
                                        <i class="fas fa-shopping-basket"></i>
                                    </button>
                                </form>

                                <div class="grid grid-cols-2 gap-4">
                                    <button type="button" @click="toggleWishlist()" :disabled="wishlistLoading"
                                            class="flex items-center justify-center gap-3 py-4 border text-[10px] font-black uppercase tracking-widest transition-all"
                                            :class="isFavorited ? 'bg-[var(--primary)] border-[var(--primary)] text-white' : 'bg-slate-50 border-slate-100 text-slate-600 hover:bg-white'">
                                        <i :class="isFavorited ? 'fas fa-heart' : 'far fa-heart'"></i> {{ __('messages.favorites') }}
                                    </button>
                                    <a href="https://wa.me/221783577431?text={{ urlencode('Bonjour, je souhaite commander : ' . $product->name) }}" target="_blank" class="flex items-center justify-center gap-3 py-4 bg-[#25D366] text-white text-[10px] font-black uppercase tracking-widest hover:bg-[#128C7E] transition-all">
                                        <i class="fab fa-whatsapp"></i> WhatsApp
                                    </a>
                                </div>
                            </div>

                            <div class="pt-8 border-t border-slate-100 space-y-2">
                                <div class="flex items-center gap-4">
                                    <i class="fas fa-check-circle text-[var(--primary)]"></i>
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                        @if($outOfStock) {{ __('messages.out_of_stock') }} @else {{ __('messages.in_stock') }} ({{ $product->stock }}) @endif
                                    </span>
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

            <!-- Avis clients -->
            <div class="mt-24 pt-16 border-t border-slate-100">
                <h2 class="text-2xl font-black text-slate-900 uppercase tracking-tight mb-8">{{ __('messages.reviews_section_title') }}</h2>

                @if(session('review_success'))
                    <p class="mb-6 text-green-600 font-bold text-sm">{{ session('review_success') }}</p>
                @endif
                @if(session('review_error'))
                    <p class="mb-6 text-red-600 font-bold text-sm">{{ session('review_error') }}</p>
                @endif

                @auth
                    @if($userReview)
                        <div class="mb-10 p-6 bg-slate-50 border border-slate-100 rounded-none">
                            <p class="text-sm font-bold text-slate-700">{{ __('messages.your_review') }} : <span class="text-amber-500">{{ $userReview->rating }}/5</span></p>
                            <p class="text-slate-600 text-sm mt-2">{{ $userReview->body ?: '—' }}</p>
                            <p class="text-[10px] font-black text-slate-400 uppercase mt-2">
                                @if($userReview->is_approved) {{ __('messages.review_visible') }} @else {{ __('messages.review_pending') }} @endif
                            </p>
                            <form action="{{ route('reviews.destroy', $userReview) }}" method="POST" class="mt-4" onsubmit="return confirm('{{ __('messages.review_delete_confirm') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-[10px] font-black uppercase text-red-500 hover:underline">{{ __('messages.remove_line') }}</button>
                            </form>
                        </div>
                    @else
                        <form action="{{ route('reviews.store', $product) }}" method="POST" class="mb-12 max-w-xl space-y-4">
                            @csrf
                            <div>
                                <label class="text-[10px] font-black uppercase text-slate-400">{{ __('messages.review_rating') }}</label>
                                <select name="rating" required class="mt-1 w-full bg-slate-50 border border-slate-100 py-3 px-4 font-bold">
                                    @for($r = 5; $r >= 1; $r--)
                                        <option value="{{ $r }}">{{ $r }} / 5</option>
                                    @endfor
                                </select>
                            </div>
                            <div>
                                <label class="text-[10px] font-black uppercase text-slate-400">{{ __('messages.review_comment') }}</label>
                                <textarea name="body" rows="4" class="mt-1 w-full bg-slate-50 border border-slate-100 py-3 px-4 font-medium text-sm" placeholder="..."></textarea>
                            </div>
                            <button type="submit" class="px-8 py-3 bg-[var(--primary)] text-white text-[11px] font-black uppercase tracking-widest hover:bg-slate-900 transition-colors">{{ __('messages.review_submit') }}</button>
                        </form>
                    @endif
                @else
                    <p class="mb-10 text-slate-500 text-sm font-medium">{{ __('messages.review_login_prompt') }}</p>
                @endauth

                <div class="space-y-6">
                    @forelse($reviews as $rev)
                        <div class="border-b border-slate-100 pb-6">
                            <div class="flex items-center gap-2 text-amber-500 mb-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star text-[10px] {{ $i <= $rev->rating ? '' : 'opacity-20' }}"></i>
                                @endfor
                                <span class="text-slate-800 font-black text-sm ml-2">{{ $rev->user?->name ?? 'Client' }}</span>
                            </div>
                            @if($rev->body)
                                <p class="text-slate-600 text-sm leading-relaxed">{{ $rev->body }}</p>
                            @endif
                            <p class="text-[10px] text-slate-400 mt-2">{{ $rev->created_at->translatedFormat('d M Y') }}</p>
                        </div>
                    @empty
                        <p class="text-slate-400 text-sm font-medium">{{ __('messages.reviews_empty') }}</p>
                    @endforelse
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
