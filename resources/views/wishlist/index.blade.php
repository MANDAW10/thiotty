<x-app-layout>
    <!-- Wishlist Header -->
    <header class="py-16 bg-white border-b border-slate-50 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full -translate-y-1/2 translate-x-1/2 blur-3xl"></div>
        <div class="container-custom relative z-10">
            <nav class="flex mb-6 text-[10px] font-black text-slate-400 uppercase tracking-widest gap-2">
                <a href="{{ route('home') }}" class="hover:text-primary transition-colors">{{ __('messages.home') }}</a>
                <span class="opacity-20">/</span>
                <span class="text-slate-900">{{ __('messages.my_favorites') }}</span>
            </nav>
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
                <div>
                    <h1 class="text-4xl md:text-6xl font-black text-slate-900 leading-tight">
                        {{ __('messages.my_favorites') }}
                    </h1>
                    <p class="text-slate-500 font-medium max-w-lg mt-4">
                        {{ __('messages.wishlist_desc') }}
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row items-center gap-3">
                    <div class="bg-slate-50 px-6 py-4 rounded-3xl border border-slate-100 flex items-center gap-4">
                        <span class="text-[10px] font-black uppercase text-slate-400 tracking-widest">{{ __('messages.favorites_count') }} :</span>
                        <span class="text-xl font-black text-primary">{{ $wishlists->count() }}</span>
                    </div>
                    <button x-data="{ loading: false }" 
                            @click="if(confirm('{{ __('messages.clear_wishlist_confirm') }}')) {
                                loading = true;
                                fetch('{{ route('wishlist.clear') }}', {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Accept': 'application/json'
                                    }
                                })
                                .then(res => res.json())
                                .then(data => {
                                    $dispatch('wishlist-cleared');
                                    $dispatch('wishlist-updated', { count: 0 });
                                    $dispatch('add-toast', { message: data.message, type: 'success' });
                                })
                                .finally(() => loading = false);
                            }"
                            class="py-4 px-6 rounded-3xl bg-red-50 text-red-600 font-bold text-[10px] uppercase tracking-widest hover:bg-red-100 transition-all border border-red-100 flex items-center gap-2"
                            :class="loading && 'opacity-50 pointer-events-none'">
                        <i class="fas fa-trash-alt" :class="loading && 'animate-spin'"></i>
                        {{ __('messages.clear_all') }}
                    </button>
                </div>
            </div>
        </div>
    </header>

    <div class="py-12 lg:py-24 bg-slate-50/30 min-h-[60vh]">
        <div class="container-custom">
            @if($wishlists->count() > 0)
                <div class="flex flex-col gap-4 md:gap-6">
                    @foreach($wishlists as $wishlist)
                        @php $product = $wishlist->product; @endphp
                        <div x-data="{ removed: false }" x-show="!removed" x-transition:leave="transition ease-in duration-300 transform scale-95 opacity-0"
                             @wishlist-updated.window="if($event.detail.id === {{ $product->id }} && $event.detail.status === 'removed') removed = true"
                             @wishlist-cleared.window="removed = true">
                            <x-wishlist-item :product="$product" />
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-20 bg-white rounded-[40px] border border-dashed border-slate-200">
                    <div class="w-20 h-20 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="far fa-heart text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-black text-slate-900 mb-2">{{ __('messages.wishlist_empty') }}</h3>
                    <p class="text-slate-400 font-medium mb-8">{{ __('messages.wishlist_empty_desc') }}</p>
                    <a href="{{ route('shop.index') }}" class="btn-thiotty px-10 py-4 inline-block">
                        {{ __('messages.explorer_boutique') ?? __('messages.view_catalog') }}
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
