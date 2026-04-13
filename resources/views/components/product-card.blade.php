@props(['product', 'wishlistMode' => false])
@php
    $inCompare = in_array($product->id, session('compare', []), true);
    $outOfStock = ($product->stock ?? 0) <= 0;
@endphp

<div class="product-card group relative bg-white transition-all duration-300"
     x-data="{ 
        isFavorited: {{ $product->isFavoritedBy(Auth::user()) ? 'true' : 'false' }},
        inCompare: {{ $inCompare ? 'true' : 'false' }},
        wishlistLoading: false,
        cartLoading: false,
        compareLoading: false,
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
        toggleCompare() {
            if (this.compareLoading) return;
            this.compareLoading = true;
            fetch('{{ route('compare.toggle', $product) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(r => r.json())
            .then(d => {
                this.inCompare = d.in_compare;
                this.compareLoading = false;
                $dispatch('compare-updated', { count: d.count });
            }).catch(() => this.compareLoading = false);
        },
        addToCart() {
            if (this.cartLoading || {{ $outOfStock ? 'true' : 'false' }}) return;
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
    
    <!-- Image Area with Icons on Hover -->
    <div class="relative aspect-[4/3] md:aspect-square overflow-hidden mb-6">
        <a href="{{ route('shop.product', $product->slug) }}" class="block w-full h-full">
            <img src="{{ $product->image_url }}" 
                 alt="{{ $product->display_name }}" 
                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105 {{ $outOfStock ? 'opacity-60 grayscale-[0.3]' : '' }}">
        </a>

        @if($outOfStock)
            <span class="absolute top-0 right-0 px-3 py-1.5 bg-slate-900 text-white text-[9px] font-black uppercase tracking-widest z-10">Épuisé</span>
        @endif

        <!-- CAAWOGI Hover Icons Bar (Expanded) -->
        <div class="absolute bottom-0 inset-x-0 bg-white shadow-xl flex items-center justify-between py-4 px-8 translate-y-12 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300 z-10">
            <!-- Add to Cart -->
            <button @click.prevent="addToCart()" 
                    class="text-slate-800 hover:text-[#206B13] transition-all transform hover:scale-110"
                    title="Ajouter au Panier">
                <i x-show="!cartLoading" class="fas fa-shopping-basket text-[18px]"></i>
                <i x-show="cartLoading" class="fas fa-circle-notch animate-spin text-[18px]"></i>
            </button>

            <div class="w-[1.5px] h-5 bg-slate-100"></div>

            <!-- Wishlist -->
            <button @click.prevent="toggleWishlist()" 
                    :class="isFavorited ? 'text-[#206B13]' : 'text-slate-800 hover:text-[#206B13]'"
                    class="transition-all transform hover:scale-110"
                    title="Favoris">
                <i :class="isFavorited ? 'fas fa-heart' : 'far fa-heart'" class="text-[17px]"></i>
            </button>

            <div class="w-[1.5px] h-5 bg-slate-100"></div>

            <!-- Compare -->
            <button @click.prevent="toggleCompare()"
                    :class="inCompare ? 'text-[#206B13]' : 'text-slate-800 hover:text-[#206B13]'"
                    class="transition-all transform hover:scale-110"
                    title="Comparer">
                <i class="fas fa-random text-[17px]"></i>
            </button>

            <div class="w-[1.5px] h-5 bg-slate-100"></div>

            <!-- Quick View -->
            <button @click.prevent="$dispatch('open-quick-view', { url: '{{ route('shop.product.quick', $product) }}' })"
                    class="text-slate-800 hover:text-[#206B13] transition-all transform hover:scale-110"
                    title="Aperçu rapide">
                <i class="fas fa-eye text-[18px]"></i>
            </button>
        </div>
    </div>

    <!-- Product Details -->
    <div class="text-center px-2 pb-6">
        <a href="{{ route('shop.product', $product->slug) }}" class="block mb-2 group-hover:translate-x-1 transition-transform">
            <h3 class="text-[13px] md:text-[15px] font-black text-slate-900 uppercase tracking-widest leading-tight hover:text-[#206B13] transition-colors">
                {{ $product->display_name }}
            </h3>
        </a>

        <!-- Stars Rating -->
        <div class="flex justify-center gap-1 mb-3">
            @php
                $rating = round($product->average_rating ?? 5);
            @endphp
            @for($i = 1; $i <= 5; $i++)
                <i class="fas fa-star text-[10px] {{ $i <= $rating ? 'text-amber-400' : 'text-slate-200' }}"></i>
            @endfor
        </div>

        <div class="">
            @if($product->has_sale)
                <div class="flex flex-col items-center">
                    <span class="text-[14px] font-black text-[#206B13]">CFA {{ number_format($product->selling_price, 0, ',', ' ') }}</span>
                    <span class="text-[10px] text-slate-300 line-through font-bold mt-1">{{ number_format($product->price, 0, ',', ' ') }} CFA</span>
                </div>
            @else
                <span class="text-[14px] font-black text-[#206B13] uppercase tracking-wider">
                    CFA {{ number_format($product->price, 0, ',', ' ') }}
                </span>
            @endif
        </div>
    </div>
</div>
