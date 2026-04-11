@props(['product', 'canRemove' => false])

<div class="product-card group bg-white rounded-[48px] p-4 shadow-xl shadow-slate-200/50 border border-slate-50 transition-all duration-700 hover:-translate-y-2 hover:shadow-2xl hover:shadow-primary/5">
    <!-- Image Header -->
    <div class="relative aspect-square md:aspect-[4/5] rounded-[40px] overflow-hidden mb-6">
        <a href="{{ route('shop.product', $product->slug) }}">
            <img src="{{ $product->image_url }}" 
                 alt="{{ $product->name }}" 
                 class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
        </a>

        @if($canRemove)
        <!-- Quick Remove Button (Wishlist Only) -->
        <div class="absolute top-6 left-6 z-10" x-data="{ confirming: false }">
            <button @click.prevent="toggle()" 
                    class="w-8 h-8 rounded-full bg-slate-900/10 hover:bg-red-500 text-slate-900 hover:text-white backdrop-blur-md flex items-center justify-center transition-all shadow-sm hover:shadow-lg active:scale-95 group/remove">
                <i class="fas fa-times text-[10px] group-hover/remove:rotate-90 transition-transform duration-300"></i>
            </button>
        </div>
        @endif
        
        <!-- Wishlist Button -->
        <div class="absolute top-6 right-6" x-data="{ 
            isFavorited: {{ $product->isFavoritedBy(Auth::user()) ? 'true' : 'false' }},
            loading: false,
            toggle() {
                if ({{ Auth::check() ? 'false' : 'true' }}) {
                    window.dispatchEvent(new CustomEvent('open-login'));
                    return;
                }
                
                if (this.loading) return;
                this.loading = true;
                
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
                    this.loading = false;
                    $dispatch('wishlist-updated', { count: data.count, id: {{ $product->id }}, status: data.status });
                    $dispatch('add-toast', { 
                        message: this.isFavorited ? '{{ __("messages.added_to_wishlist") ?? "Ajouté aux favoris" }}' : '{{ __("messages.removed_from_wishlist") ?? "Retiré des favoris" }}', 
                        type: 'success' 
                    });
                })
                .catch(() => this.loading = false);
            }
        }">
            <button @click.prevent="toggle()" 
                    :class="isFavorited ? 'bg-primary text-white scale-110' : 'bg-white text-primary'"
                    class="w-11 h-11 rounded-full flex items-center justify-center transition-all shadow-lg active:scale-90 hover:scale-105"
                    :disabled="loading">
                <i :class="isFavorited ? 'fas fa-heart' : 'far fa-heart'" :class="loading && 'animate-pulse'"></i>
            </button>
        </div>
    </div>

    <!-- Content -->
    <div class="px-3 pb-4">
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-2">
            {{ $product->category->name }}
        </p>
        
        <a href="{{ route('shop.product', $product->slug) }}">
            <h3 class="serif-heading text-2xl font-bold text-slate-900 mb-6 group-hover:text-primary transition-colors line-clamp-1">
                {{ $product->name }}
            </h3>
        </a>

        <div class="flex items-center justify-between">
            <div class="flex flex-col">
                <span class="text-2xl font-black text-primary tracking-tighter">
                    {{ number_format($product->price, 0, ',', ' ') }}
                    <span class="text-[10px] uppercase font-bold text-primary/60 ml-0.5">CFA</span>
                </span>
            </div>
            
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
                <button type="submit" 
                        class="w-12 h-12 bg-slate-900 text-white rounded-full flex items-center justify-center shadow-xl shadow-slate-900/10 hover:bg-primary transition-all active:scale-95 group/btn overflow-hidden">
                    <i class="fas fa-plus text-sm group-hover/btn:rotate-90 transition-transform duration-300"></i>
                </button>
            </form>
        </div>
    </div>
</div>
