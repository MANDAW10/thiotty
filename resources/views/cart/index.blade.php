<x-app-layout>
    <!-- Cart Header -->
    <header class="py-12 bg-white border-b border-slate-50">
        <div class="container-custom text-center">
            <nav class="flex justify-center mb-4 text-xs font-bold text-slate-400 uppercase tracking-widest gap-2">
                <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Accueil</a>
                <span>/</span>
                <span class="text-slate-900">Panier</span>
            </nav>
            <h1 class="text-3xl md:text-5xl font-black text-slate-900 leading-tight">
                Mon panier
            </h1>
        </div>
    </header>

    <div class="py-12 lg:py-20 bg-slate-50/30">
        <div class="container-custom">
            @if(count($cart) > 0)
                <div class="flex flex-col lg:flex-row gap-12">
                    <!-- Cart Items -->
                    <div class="w-full lg:w-2/3 space-y-4 md:space-y-6">
                        @foreach($cart as $id => $item)
                            <div class="bg-white rounded-[24px] md:rounded-[32px] p-4 md:p-8 flex items-center md:items-start lg:items-center gap-4 md:gap-8 border border-slate-100 shadow-sm transition-all hover:shadow-md">
                                <!-- Product Image -->
                                <div class="w-20 h-20 sm:w-24 sm:h-24 md:w-32 md:h-32 bg-slate-50 rounded-xl md:rounded-2xl overflow-hidden shrink-0 border border-slate-100">
                                    <img src="{{ $item['image'] ?? 'https://images.unsplash.com/photo-1596733430284-f7437764b1a9?q=80&w=400&auto=format&fit=crop' }}"
                                         alt="{{ $item['name'] }}"
                                         class="w-full h-full object-cover">
                                </div>

                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-col md:flex-row md:items-start justify-between gap-2 md:gap-4 mb-4 md:mb-6">
                                        <div class="min-w-0">
                                            <h3 class="text-base md:text-xl font-bold text-slate-900 mb-0.5 md:mb-1 truncate">{{ $item['name'] }}</h3>
                                            <p class="text-[9px] md:text-xs font-black text-primary uppercase tracking-widest leading-none">Article #{{ $id }}</p>
                                        </div>
                                        <div class="text-lg md:text-2xl font-black text-primary">
                                            {{ number_format($item['price'], 0, ',', ' ') }} <span class="text-[10px] md:text-xs opacity-50 uppercase tracking-tighter">CFA</span>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between gap-4 pt-4 md:pt-6 border-t border-slate-50/50">
                                        <!-- Quantity Selector -->
                                        <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center bg-slate-50 rounded-lg md:rounded-xl px-1.5 py-0.5 md:px-2 md:py-1 border border-slate-100">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" name="quantity" value="{{ $item['quantity'] - 1 }}" class="w-8 h-8 md:w-10 md:h-10 flex items-center justify-center text-slate-400 hover:text-primary transition-all">
                                                <i class="fas fa-minus text-[10px]"></i>
                                            </button>
                                            <input type="text" readonly value="{{ $item['quantity'] }}" class="w-8 md:w-12 text-center border-none bg-transparent font-black text-slate-900 text-sm md:text-lg focus:ring-0">
                                            <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}" class="w-8 h-8 md:w-10 md:h-10 flex items-center justify-center text-slate-400 hover:text-primary transition-all">
                                                <i class="fas fa-plus text-[10px]"></i>
                                            </button>
                                        </form>

                                        <!-- Delete Link -->
                                        <form action="{{ route('cart.remove', $id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-[10px] md:text-xs font-black text-red-400 uppercase tracking-widest hover:text-red-600 transition-colors flex items-center gap-1.5 md:gap-2">
                                                <i class="fas fa-trash-alt text-[9px] md:text-[10px]"></i>
                                                <span class="hidden xs:inline">Supprimer</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Summary Sidebar -->
                    <div class="w-full lg:w-1/3 mt-8 lg:mt-0">
                        <div class="bg-white rounded-[32px] md:rounded-[40px] p-6 sm:p-8 md:p-10 sticky top-40 border border-slate-100 shadow-xl shadow-slate-200/40">
                            <h3 class="text-xl font-bold text-slate-900 mb-6 md:mb-8 pb-4 border-b border-slate-50">Récapitulatif</h3>

                            <div class="space-y-4 mb-6 md:mb-8">
                                <div class="flex justify-between items-center text-sm font-bold text-slate-500">
                                    <span>Sous-total</span>
                                    <span class="text-slate-900">{{ number_format($total, 0, ',', ' ') }} CFA</span>
                                </div>
                                <div class="flex justify-between items-center text-sm font-bold text-slate-400 italic">
                                    <span>Livraison</span>
                                    <span class="text-primary text-[10px] uppercase tracking-widest">À calculer après validation</span>
                                </div>
                            </div>

                            <div class="pt-6 border-t-2 border-slate-50 mb-8 md:mb-10">
                                <div class="flex justify-between items-end">
                                    <div class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Total à payer</div>
                                    <div class="text-2xl md:text-3xl font-black text-primary">{{ number_format($total, 0, ',', ' ') }} <small class="text-xs uppercase">CFA</small></div>
                                </div>
                            </div>

                            <div class="space-y-4">
                                @auth
                                    <a href="{{ route('checkout.index') }}" class="btn-thiotty w-full py-4 md:py-5 text-base md:text-lg text-center block">
                                        Valider la commande
                                    </a>
                                @else
                                    <button type="button" @click="$dispatch('open-login')" class="btn-thiotty w-full py-4 md:py-5 text-base md:text-lg">
                                        Valider la commande
                                    </button>
                                @endauth
                                <a href="{{ route('shop.index') }}" class="flex items-center justify-center gap-2 text-[10px] md:text-xs font-black text-slate-400 uppercase tracking-widest hover:text-primary transition-colors">
                                    <i class="fas fa-arrow-left text-[8px] md:text-[10px]"></i> Continuer les achats
                                </a>
                            </div>

                            <div class="mt-8 md:mt-12 grid grid-cols-3 gap-4 text-center">
                                <div class="space-y-1.5 md:space-y-2">
                                    <div class="w-8 h-8 md:w-10 md:h-10 bg-slate-50 rounded-lg md:rounded-xl flex items-center justify-center mx-auto text-primary">
                                        <i class="fas fa-shield-alt text-sm"></i>
                                    </div>
                                    <p class="text-[7px] md:text-[8px] font-black uppercase text-slate-400">Sécurisé</p>
                                </div>
                                <div class="space-y-1.5 md:space-y-2">
                                    <div class="w-8 h-8 md:w-10 md:h-10 bg-slate-50 rounded-lg md:rounded-xl flex items-center justify-center mx-auto text-primary">
                                        <i class="fas fa-truck text-sm"></i>
                                    </div>
                                    <p class="text-[7px] md:text-[8px] font-black uppercase text-slate-400">Rapide</p>
                                </div>
                                <div class="space-y-1.5 md:space-y-2">
                                    <div class="w-8 h-8 md:w-10 md:h-10 bg-slate-50 rounded-lg md:rounded-xl flex items-center justify-center mx-auto text-primary">
                                        <i class="fas fa-redo text-sm"></i>
                                    </div>
                                    <p class="text-[7px] md:text-[8px] font-black uppercase text-slate-400">Garantie</p>
                                </div> </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-32 bg-white rounded-[40px] border-2 border-dashed border-slate-200">
                    <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-8 text-slate-200 shadow-xl shadow-slate-100">
                        <i class="fas fa-shopping-basket text-4xl"></i>
                    </div>
                    <h2 class="text-2xl font-black text-slate-900 mb-4">{{ __('messages.empty_cart') }}</h2>
                    <p class="text-slate-500 text-sm mb-12 max-w-xs mx-auto leading-relaxed">
                        {{ __('messages.empty_cart_text') }}
                    </p>
                    <a href="{{ route('shop.index') }}" class="btn-thiotty inline-flex px-12 py-5">
                        {{ __('messages.discover_products') }}
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
