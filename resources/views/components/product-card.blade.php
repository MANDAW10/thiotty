@props(['product', 'wishlistMode' => false])
@php
    $inCompare = in_array($product->id, session('compare', []), true);
    $outOfStock = ($product->stock ?? 0) <= 0;
@endphp

<div class="product-card group bg-white rounded-none p-0 shadow-sm border border-slate-100 transition-all duration-300 hover:shadow-xl"
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
    <div class="relative aspect-square overflow-hidden bg-white border-b border-slate-50">
        <a href="{{ route('shop.product', $product->slug) }}" class="block w-full h-full">
            <img src="{{ $product->image_url }}" 
                 alt="{{ $product->display_name }}" 
                 class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105 {{ $outOfStock ? 'opacity-60 grayscale-[0.3]' : '' }}">
        </a>

        @if($outOfStock)
            <span class="absolute top-3 left-3 px-3 py-1 bg-slate-900 text-white text-[9px] font-black uppercase tracking-widest">{{ __('messages.out_of_stock') }}</span>
        @endif

        @if(!$wishlistMode)
        <div class="absolute bottom-0 inset-x-0 flex justify-center gap-1 p-2 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
            <button type="button" @click.prevent="$dispatch('open-quick-view', { url: '{{ route('shop.product.quick', $product) }}' })"
                    class="w-9 h-9 bg-white text-slate-700 flex items-center justify-center border border-slate-100 hover:bg-[var(--primary)] hover:text-white transition-colors shadow-sm"
                    title="{{ __('messages.quick_view') }}">
                <i class="fas fa-eye text-[11px]"></i>
            </button>
            <button type="button" @click.prevent="toggleCompare()"
                    :class="inCompare ? 'bg-[var(--caawogi-blue)] text-white' : 'bg-white text-slate-700'"
                    class="w-9 h-9 flex items-center justify-center border border-slate-100 hover:opacity-90 transition-colors shadow-sm"
                    title="{{ __('messages.compare_title') }}">
                <i class="fas fa-random text-[11px]"></i>
            </button>
        </div>

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

    <div class="p-5 flex flex-col items-center text-center">
        <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.3em] mb-2">
            {{ $product->category->display_name }}
        </p>
        
        <a href="{{ route('shop.product', $product->slug) }}" class="block mb-3 min-h-[48px] flex flex-col justify-center">
            <h3 class="text-[14px] font-extrabold text-slate-900 uppercase tracking-tight group-hover:text-[var(--primary)] transition-colors line-clamp-2 leading-tight">
                {{ $product->display_name }}
            </h3>
        </a>

        <div class="mb-5">
            <span class="text-lg font-black text-[var(--primary)]">
                {{ number_format($product->price, 0, ',', ' ') }} <span class="text-[11px] font-bold">CFA</span>
            </span>
        </div>
        
        <button @click.prevent="addToCart()" 
                class="w-full py-3.5 bg-[var(--primary)] text-white font-black text-[11px] uppercase tracking-[0.2em] hover:bg-slate-900 transition-all disabled:opacity-40 disabled:cursor-not-allowed"
                :disabled="cartLoading || {{ $outOfStock ? 'true' : 'false' }}">
            <span x-show="!cartLoading">{{ $outOfStock ? __('messages.out_of_stock') : 'Ajouter au Panier' }}</span>
            <span x-show="cartLoading"><i class="fas fa-circle-notch animate-spin"></i></span>
        </button>
    </div>
</div>
