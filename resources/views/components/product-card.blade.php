@props(['product', 'wishlistMode' => false])

<div class="product-card group bg-white rounded-none p-0 shadow-sm border border-slate-100 transition-all duration-300 hover:shadow-xl"
     x-data="{ 
        isFavorited: {{ $product->isFavoritedBy(Auth::user()) ? 'true' : 'false' }},
        wishlistLoading: false,
        cartLoading: false,
        toggleWishlist() {
            if ({{ Auth::check() ? 'false' : 'true' }}) {
                window.dispatchEvent(new CustomEvent('open-login'));
                return;
            }
            if (this.wishlistLoading) return;
            this.wishlistLoading = true;
            fetch('{{ route('wishlist.toggle', $product) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.json())
            .then(data => {
                this.isFavorited = (data.status === 'added');
                this.wishlistLoading = false;
                $dispatch('wishlist-updated', { count: data.count, id: {{ $product->id }}, status: data.status });
            }).catch(() => this.wishlistLoading = false);
        },
        addToCart(moveFromWishlist = false) {
            if (this.cartLoading) return;
            this.cartLoading = true;
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
            }).finally(() => this.cartLoading = false);
        }
     }">
    <!-- Image Header -->
    <div class="relative aspect-square overflow-hidden bg-white border-b border-slate-50">
        <a href="{{ route('shop.product', $product->slug) }}" class="block w-full h-full">
            <img src="{{ $product->image_url }}" 
                 alt="{{ $product->display_name }}" 
                 class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105">
        </a>

        @if(!$wishlistMode)
        <!-- Wishlist Toggle Button -->
        <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity">
            <button @click.prevent="toggleWishlist()" 
                    :class="isFavorited ? 'bg-[var(--primary)] text-white' : 'bg-white text-slate-400'"
                    class="w-8 h-8 rounded-none flex items-center justify-center transition-all shadow-md border border-slate-100"
                    :disabled="wishlistLoading">
                <i :class="isFavorited ? 'fas fa-heart' : 'far fa-heart'" class="text-[10px]"></i>
            </button>
        </div>
        @endif
    </div>

    <!-- Content -->
    <div class="p-4 flex flex-col items-center text-center">
        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-1">
            {{ $product->category->display_name }}
        </p>
        
        <a href="{{ route('shop.product', $product->slug) }}" class="block mb-2 min-h-[40px] flex flex-col justify-center">
            <h3 class="text-[13px] font-bold text-slate-800 uppercase tracking-tight group-hover:text-[var(--primary)] transition-colors line-clamp-2">
                {{ $product->display_name }}
            </h3>
        </a>

        <div class="mb-4">
            <span class="text-base font-black text-[var(--secondary)]">
                {{ number_format($product->price, 0, ',', ' ') }} <span class="text-[10px] font-bold">CFA</span>
            </span>
        </div>
        
        <button @click.prevent="addToCart()" 
                class="w-full py-2.5 bg-[var(--primary)] text-white font-bold text-[10px] uppercase tracking-widest hover:bg-[var(--primary-hover)] transition-colors disabled:opacity-50"
                :disabled="cartLoading">
            <span x-show="!cartLoading">Ajouter au panier</span>
            <span x-show="cartLoading"><i class="fas fa-circle-notch animate-spin"></i></span>
        </button>
    </div>
</div>
