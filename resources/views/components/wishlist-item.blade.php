@props(['product'])

<div class="wishlist-item group bg-white rounded-[32px] md:rounded-[40px] p-4 md:p-8 flex items-center gap-4 md:gap-8 border border-slate-100 shadow-sm transition-all hover:shadow-xl hover:shadow-slate-200/50"
     x-data="{ 
        wishlistLoading: false,
        cartLoading: false,
        toggleWishlist() {
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
                this.wishlistLoading = false;
                $dispatch('wishlist-updated', { count: data.count, id: {{ $product->id }}, status: data.status });
                $dispatch('add-toast', { 
                    message: data.status === 'added' ? 'Ajouté aux favoris' : 'Retiré des favoris', 
                    type: 'success' 
                });
            }).catch(() => this.wishlistLoading = false);
        },
        addToCart() {
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
                    this.toggleWishlist(); // Auto-remove from wishlist (Transfer)
                    $dispatch('add-toast', { message: 'Produit transféré dans votre panier !', type: 'success' });
                }
            }).finally(() => this.cartLoading = false);
        }
     }">
    
    <!-- Product Image -->
    <div class="w-20 h-20 md:w-32 md:h-32 bg-slate-50 rounded-2xl overflow-hidden shrink-0 border border-slate-100">
        <a href="{{ route('shop.product', $product->slug) }}">
            <img src="{{ $product->image_url }}" 
                 alt="{{ $product->name }}" 
                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
        </a>
    </div>

    <!-- Content Area -->
    <div class="flex-1 min-w-0">
        <div class="flex flex-col md:flex-row md:items-start justify-between gap-2 md:gap-4 mb-4 md:mb-6">
            <div class="min-w-0">
                <a href="{{ route('shop.product', $product->slug) }}">
                    <h3 class="text-base md:text-xl font-black text-slate-900 mb-0.5 md:mb-1 truncate hover:text-primary transition-colors">
                        {{ $product->name }}
                    </h3>
                </a>
                <p class="text-[9px] md:text-xs font-black text-primary uppercase tracking-widest leading-none">
                    {{ $product->category->name }}
                </p>
            </div>
            <div class="text-lg md:text-2xl font-black text-primary">
                {{ number_format($product->price, 0, ',', ' ') }} 
                <span class="text-[10px] md:text-xs opacity-50 uppercase tracking-tighter">CFA</span>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-4 border-t border-slate-50/50">
            <!-- Action Buttons -->
            <div class="flex items-center gap-4">
                <button @click.prevent="addToCart()" 
                        class="flex-1 sm:flex-none py-2.5 md:py-3 px-6 bg-slate-900 text-white rounded-xl md:rounded-2xl font-black text-[9px] md:text-[10px] uppercase tracking-widest hover:bg-primary transition-all active:scale-95 flex items-center justify-center gap-2"
                        :disabled="cartLoading">
                    <i class="fas fa-shopping-basket" :class="cartLoading && 'animate-bounce'"></i>
                    <span>Mettre au panier</span>
                </button>

                <button @click.prevent="toggleWishlist()" 
                        class="text-[9px] md:text-[10px] font-black text-red-400 uppercase tracking-widest hover:text-red-600 transition-colors flex items-center gap-2"
                        :disabled="wishlistLoading">
                    <i class="fas fa-trash-alt" :class="wishlistLoading && 'animate-spin'"></i>
                    <span>Retirer</span>
                </button>
            </div>

            <a href="{{ route('shop.product', $product->slug) }}" class="hidden sm:flex items-center gap-2 text-[10px] font-black text-slate-300 hover:text-primary transition-all group/link">
                Voir détails
                <i class="fas fa-arrow-right transition-transform group-hover/link:translate-x-1"></i>
            </a>
        </div>
    </div>
</div>
