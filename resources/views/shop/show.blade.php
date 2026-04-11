<x-app-layout>
    <!-- Product Detail Header -->
    <header class="py-12 bg-white border-b border-slate-50">
        <div class="container-custom">
            <nav class="flex flex-wrap items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">
                <a href="{{ route('home') }}" class="hover:text-primary transition-colors">{{ __('messages.home') }}</a>
                <span class="opacity-30">/</span>
                <a href="{{ route('shop.index') }}" class="hover:text-primary transition-colors">{{ __('messages.shop') }}</a>
                <span class="opacity-30">/</span>
                <a href="{{ route('shop.category', $product->category->slug) }}" class="hover:text-primary transition-colors">{{ $product->category->display_name }}</a>
                <span class="opacity-30">/</span>
                <span class="text-slate-900 truncate max-w-[150px] sm:max-w-none">{{ $product->display_name }}</span>
            </nav>
        </div>
    </header>

    <div class="py-12 lg:py-24 bg-white overflow-hidden">
        <div class="container-custom">
            <div class="grid lg:grid-cols-12 gap-12 lg:gap-20 items-start">
                
                <!-- Product Gallery Section (Col 1-7) -->
                <div class="lg:col-span-7 space-y-8 animate-fade-in-up">
                    <div class="relative group">
                        <!-- Main Image with "Glass" frame effect -->
                        <div class="aspect-[4/5] md:aspect-square rounded-[48px] overflow-hidden bg-slate-50 border-8 border-white shadow-2xl shadow-slate-200/50 transition-all duration-700 hover:shadow-primary/5">
                            <img src="{{ $product->image_url }}" 
                                 alt="{{ $product->display_name }}" 
                                 class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105">
                        </div>
                        
                        <!-- Floating Badges -->
                        <div class="absolute top-8 left-8 flex flex-col gap-3">
                            <span class="px-5 py-2 bg-white/80 backdrop-blur-md text-slate-900 text-[10px] font-black uppercase tracking-widest rounded-full shadow-lg border border-white/50">
                                {{ $product->category->display_name }}
                            </span>
                            @if($product->is_featured)
                            <span class="px-5 py-2 bg-primary text-white text-[10px] font-black uppercase tracking-widest rounded-full shadow-lg shadow-primary/20">
                                {{ __('messages.top_pick') }}
                            </span>
                            @endif
                        </div>

                        <!-- Zoom/Full Icon Hint -->
                        <button class="absolute bottom-8 right-8 w-14 h-14 bg-white/60 backdrop-blur-md rounded-full flex items-center justify-center text-slate-900 opacity-0 group-hover:opacity-100 transition-all duration-500 translate-y-4 group-hover:translate-y-0 shadow-xl border border-white/50">
                            <i class="fas fa-expand-alt"></i>
                        </button>
                    </div>

                    <!-- Thumbnails / Features grid -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-[#F8F9FA] p-6 rounded-[32px] border border-white shadow-sm hover:shadow-md transition-shadow">
                            <div class="w-10 h-10 bg-white rounded-xl shadow-sm flex items-center justify-center text-primary mb-4">
                                <i class="fas fa-seedling"></i>
                            </div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">{{ __('messages.quality') }}</p>
                            <p class="text-xs font-black text-slate-900">{{ __('messages.natural') }}</p>
                        </div>
                        <div class="bg-[#F8F9FA] p-6 rounded-[32px] border border-white shadow-sm hover:shadow-md transition-shadow delay-75">
                            <div class="w-10 h-10 bg-white rounded-xl shadow-sm flex items-center justify-center text-primary mb-4">
                                <i class="fas fa-truck-fast"></i>
                            </div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">{{ __('messages.delivery_label') }}</p>
                            <p class="text-xs font-black text-slate-900">{{ __('messages.express_24h') }}</p>
                        </div>
                        <div class="bg-[#F8F9FA] p-6 rounded-[32px] border border-white shadow-sm hover:shadow-md transition-shadow delay-150">
                            <div class="w-10 h-10 bg-white rounded-xl shadow-sm flex items-center justify-center text-primary mb-4">
                                <i class="fas fa-map-location-dot"></i>
                            </div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">{{ __('messages.origin') }}</p>
                            <p class="text-xs font-black text-slate-900">{{ $product->location ?: __('messages.senegal') }}</p>
                        </div>
                        <div class="bg-[#F8F9FA] p-6 rounded-[32px] border border-white shadow-sm hover:shadow-md transition-shadow delay-200">
                            <div class="w-10 h-10 bg-white rounded-xl shadow-sm flex items-center justify-center text-primary mb-4">
                                <i class="fas fa-shield-check"></i>
                            </div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">{{ __('messages.payment') }}</p>
                            <p class="text-xs font-black text-slate-900">{{ __('messages.secure') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Product Info & Buying Section (Col 8-12) -->
                <div class="lg:col-span-5 sticky top-32 animate-fade-in-up" style="animation-delay: 0.2s">
                    <div class="space-y-12">
                        <!-- Title & Rating -->
                        <div class="space-y-6">
                            <div class="flex items-center gap-3 bg-slate-50 w-fit px-4 py-2 rounded-full border border-slate-100">
                                <span class="flex items-center gap-1 text-amber-500 font-black text-[10px]">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </span>
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">4.9 (12 {{ __('messages.reviews') }})</span>
                            </div>
                            
                            <h1 class="text-4xl sm:text-5xl md:text-6xl font-black text-slate-900 leading-[1.1] tracking-tighter">
                                {{ $product->display_name }}<span class="text-primary italic">.</span>
                            </h1>
                        </div>

                        <!-- Price Section with Glass Effect -->
                        <div class="relative group">
                           <div class="absolute inset-0 bg-primary/20 blur-[60px] opacity-20 -z-10 group-hover:opacity-40 transition-opacity"></div>
                           <div class="bg-white/40 backdrop-blur-xl border border-white rounded-[40px] p-8 md:p-12 shadow-xl">
                               <div class="flex items-baseline gap-2 mb-8">
                                   <span class="text-5xl md:text-7xl font-black text-slate-900 tracking-tighter">{{ number_format($product->price, 0, ',', ' ') }}</span>
                                   <span class="text-xl font-black text-primary uppercase italic">CFA</span>
                               </div>

                               <p class="text-slate-500 text-lg leading-relaxed mb-10 font-medium">
                                   {{ $product->description ?: 'Ce produit exceptionnel est sélectionné avec soin par nos experts pour vous garantir une fraîcheur et une qualité inégalée.' }}
                               </p>

                               <div class="space-y-4">
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
                                       <button type="submit" class="w-full btn-thiotty py-6 text-base tracking-widest shadow-2xl shadow-primary/20 flex items-center justify-center gap-4 group/btn">
                                           <span>{{ __('messages.add_to_cart_detail') }}</span>
                                           <i class="fas fa-shopping-basket transition-transform group-hover/btn:-translate-y-1"></i>
                                       </button>
                                   </form>
                                   
                                   <div class="grid grid-cols-2 gap-4">
                                       <button @click="$dispatch('wishlist-toggle', { id: {{ $product->id }} })" class="flex items-center justify-center gap-3 py-4 bg-slate-50 hover:bg-slate-100 rounded-2xl text-[10px] font-black uppercase tracking-widest text-slate-600 transition-colors">
                                            <i class="far fa-heart text-base"></i> Favoris
                                       </button>
                                       <a href="https://wa.me/221783577431?text={{ urlencode('Bonjour, je souhaite commander : ' . $product->name) }}" target="_blank" class="flex items-center justify-center gap-3 py-4 bg-[#25D366]/5 hover:bg-[#25D366]/10 rounded-2xl text-[10px] font-black uppercase tracking-widest text-[#128C7E] transition-colors">
                                            <i class="fab fa-whatsapp text-base"></i> WhatsApp
                                       </a>
                                   </div>
                               </div>

                               @if($product->stock > 0 && $product->stock < 5)
                               <div class="mt-8 flex items-center gap-3 text-red-500 font-black text-[10px] uppercase tracking-widest animate-pulse">
                                   <i class="fas fa-fire-flame-curved"></i>
                                   {{ __('messages.only_x_left', ['count' => $product->stock]) }}
                               </div>
                               @endif
                           </div>
                        </div>

                        <!-- Mini Trust Row -->
                        <div class="flex items-center justify-between px-2">
                            <div class="flex items-center gap-3">
                                <div class="w-2 h-2 rounded-full bg-emerald-500 ring-4 ring-emerald-500/10"></div>
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest italic">{{ __('messages.in_stock') }}</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <i class="fas fa-lock text-[9px] text-slate-300"></i>
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest italic">{{ __('messages.ssl_secure') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Products -->
            @if($relatedProducts->count() > 0)
                <div class="mt-40 pt-24 border-t border-slate-50">
                    <div class="flex items-end justify-between mb-16">
                        <div class="space-y-4">
                            <p class="text-[10px] font-black text-primary uppercase tracking-[0.4em] leading-none">{{ __('messages.inspiration') }}</p>
                            <h2 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tighter">
                                {{ explode(':accent', __('messages.you_may_also_like'))[0] }} <span class="text-primary italic">{{ count(explode(':accent', __('messages.you_may_also_like'))) > 1 ? explode(':accent', __('messages.you_may_also_like'))[1] : '' }}</span>.
                            </h2>
                        </div>
                        <a href="{{ route('shop.index') }}" class="hidden md:flex items-center gap-3 text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-primary transition-colors group">
                            {{ __('messages.view_catalog') }} <i class="fas fa-chevron-right text-[8px] group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                        @foreach($relatedProducts as $related)
                            <div class="product-card-thiotty group bg-white p-4 rounded-[40px] border border-slate-50 hover:shadow-2xl hover:shadow-slate-200/50 transition-all duration-500">
                                <div class="product-card-img h-80 rounded-[32px] overflow-hidden relative mb-6">
                                    <a href="{{ route('shop.product', $related->slug) }}">
                                        <img src="{{ $related->image_url }}" 
                                             alt="{{ $related->name }}" 
                                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                    </a>
                                    
                                    <div class="absolute top-4 right-4 translate-x-12 group-hover:translate-x-0 transition-transform duration-500 opacity-0 group-hover:opacity-100">
                                         <form @submit.prevent="
                                            fetch('{{ route('cart.add', $related) }}', {
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
                                            <button type="submit" class="w-12 h-12 bg-white rounded-full shadow-xl flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-all transform active:scale-90">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </form>
                                    </div>

                                    <div class="absolute bottom-4 left-4 bg-white/60 backdrop-blur-md px-4 py-1.5 rounded-full text-[9px] font-black uppercase text-slate-900 border border-white/50">
                                        {{ $related->category->display_name }}
                                    </div>
                                </div>
                                
                                <div class="px-2 pb-2">
                                    <a href="{{ route('shop.product', $related->slug) }}">
                                        <h3 class="text-xl font-black text-slate-900 mb-2 truncate group-hover:text-primary transition-colors tracking-tighter">
                                            {{ $related->display_name }}
                                        </h3>
                                    </a>
                                    <div class="flex items-center justify-between">
                                        <div class="text-lg font-black text-slate-900 tracking-tighter">
                                            {{ number_format($related->price, 0, ',', ' ') }} <small class="text-[10px] italic opacity-30 font-black ml-1">CFA</small>
                                        </div>
                                        <div class="flex items-center gap-1 text-[10px] text-amber-500 font-black uppercase tracking-tighter">
                                            <i class="fas fa-star text-[9px]"></i>
                                            <span>4.9</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
