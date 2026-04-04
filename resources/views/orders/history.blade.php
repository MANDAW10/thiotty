<x-app-layout>
    <!-- History Header -->
    <header class="py-12 bg-white border-b border-slate-50">
        <div class="container-custom text-center">
            <nav class="flex justify-center mb-4 text-xs font-bold text-slate-400 uppercase tracking-widest gap-2">
                <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Accueil</a>
                <span>/</span>
                <span class="text-slate-900">Mes Commandes</span>
            </nav>
            <h1 class="text-3xl md:text-5xl font-black text-slate-900 leading-tight">
                Historique
            </h1>
        </div>
    </header>

    <div class="py-12 lg:py-20 bg-slate-50/30">
        <div class="container-custom">
            @if($orders->count() > 0)
                <div class="space-y-12">
                    @foreach($orders as $order)
                        <div class="bg-white rounded-[40px] p-8 md:p-12 border border-slate-100 shadow-sm transition-all hover:shadow-xl hover:shadow-slate-200/50">
                            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-10 gap-8">
                                <div>
                                    <div class="flex flex-wrap items-center gap-4 mb-4">
                                        <h3 class="text-2xl font-black text-slate-900">Commande #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h3>
                                        <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest
                                            @if($order->status == 'pending') bg-orange-100 text-orange-600 
                                            @elseif($order->status == 'validated' || $order->status == 'delivered') bg-green-100 text-green-600
                                            @else bg-slate-100 text-slate-600 @endif">
                                            {{ $order->status }}
                                        </span>
                                    </div>
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">
                                        Effectuée le {{ $order->created_at->translatedFormat('d F Y') }}
                                    </p>
                                </div>
                                <div class="flex flex-wrap gap-4">
                                    <div class="px-6 py-3 bg-slate-50 rounded-2xl border border-slate-100 text-xs font-bold text-slate-500">
                                        <i class="fas fa-wallet mr-2 opacity-50"></i>
                                        Paiement: <span class="text-slate-900">{{ $order->payment_status == 'paid' ? 'Payé' : 'À la livraison' }}</span>
                                    </div>
                                    <a href="https://wa.me/221773004050" class="btn-lahad-outline py-3 px-6 text-xs">
                                        <i class="fab fa-whatsapp mr-2"></i> Support
                                    </a>
                                </div>
                            </div>

                            <!-- Order Items -->
                            <div class="space-y-6 mb-10 border-y border-slate-50 py-10">
                                @foreach($order->items as $item)
                                    <div class="flex items-center justify-between gap-6">
                                        <div class="flex items-center gap-6">
                                            <div class="w-16 h-16 bg-slate-50 rounded-2xl overflow-hidden shrink-0 border border-slate-100">
                                                <img src="{{ $item->product->image ?? 'https://images.unsplash.com/photo-1596733430284-f7437764b1a9?q=80&w=200&auto=format&fit=crop' }}" class="w-full h-full object-cover">
                                            </div>
                                            <div>
                                                <h4 class="text-lg font-bold text-slate-900 mb-1">{{ $item['product_name'] ?? $item->product->name }}</h4>
                                                <p class="text-xs font-bold text-slate-400">
                                                    {{ number_format($item->unit_price, 0, ',', ' ') }} CFA <span class="mx-2 opacity-50">×</span> {{ $item->quantity }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="text-xl font-black text-slate-900">
                                            {{ number_format($item->quantity * $item->unit_price, 0, ',', ' ') }} <small class="text-[10px] opacity-40 uppercase">CFA</small>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="flex flex-col md:flex-row justify-between items-end md:items-center">
                                <div class="order-2 md:order-1">
                                    <div class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Total payé</div>
                                    <div class="text-4xl font-black text-primary leading-none">
                                        {{ number_format($order->total_amount, 0, ',', ' ') }} <small class="text-xs uppercase">CFA</small>
                                    </div>
                                </div>
                                <div class="order-1 md:order-2 mb-6 md:mb-0">
                                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center text-slate-200">
                                        <i class="fas fa-truck-loading text-3xl"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-32 bg-white rounded-[40px] border-2 border-dashed border-slate-200">
                    <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-8 text-slate-200 shadow-xl shadow-slate-100">
                        <i class="fas fa-receipt text-4xl"></i>
                    </div>
                    <h2 class="text-2xl font-black text-slate-900 mb-4">Aucune commande trouvée</h2>
                    <p class="text-slate-500 text-sm mb-12 max-w-xs mx-auto leading-relaxed">
                        Vous n'avez pas encore passé de commande chez Lahad Enterprise.
                    </p>
                    <a href="{{ route('shop.index') }}" class="btn-lahad inline-flex px-12 py-5">
                        Faire ma première commande
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
