<x-app-layout>
    <div class="py-24 bg-white">
        <div class="max-w-4xl mx-auto px-6 lg:px-8">
            <!-- Header Section -->
            <div class="mb-16 border-b border-slate-50 pb-12">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
                    <div>
                        <nav class="flex text-[10px] font-black text-slate-300 uppercase tracking-widest gap-2 mb-6 transition-all hover:text-primary">
                            <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Accueil</a>
                            <span>/</span>
                            <a href="{{ route('orders.index') }}" class="hover:text-primary transition-colors">Commandes</a>
                            <span>/</span>
                            <span class="text-slate-900">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
                        </nav>
                        <h1 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tighter mb-4 leading-tight">Détails <span class="text-primary italic">Commande</span>.</h1>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Référence : #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }} — Passée le {{ $order->created_at->format('d/m/Y') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest mb-2 leading-none">Total Réglé</p>
                        <p class="text-4xl font-black text-slate-900 leading-none tracking-tighter">{{ number_format($order->total_amount, 0, ',', ' ') }} <small class="text-xs italic opacity-20 font-black">XOF</small></p>
                    </div>
                </div>
            </div>

            <!-- Status Timeline -->
            <div class="bg-[#FCFCFC] rounded-[40px] p-10 md:p-16 mb-16 border border-slate-100 relative overflow-hidden group">
                <div class="flex flex-col md:flex-row justify-between items-center relative z-10 gap-12">
                    @php
                        $statuses = [
                            ['key' => 'pending', 'label' => 'En attente', 'icon' => 'fa-clock'],
                            ['key' => 'validated', 'label' => 'Validée', 'icon' => 'fa-check-circle'],
                            ['key' => 'delivered', 'label' => 'Livrée', 'icon' => 'fa-truck'],
                        ];
                        $currentStep = array_search($order->status, array_column($statuses, 'key'));
                        if ($currentStep === false && $order->status !== 'cancelled') $currentStep = 0;
                    @endphp

                    @foreach($statuses as $index => $status)
                        <div class="flex flex-col items-center text-center relative w-full md:w-1/3">
                            <div class="w-20 h-20 rounded-3xl flex items-center justify-center mb-6 transition-all duration-500 border-2
                                @if($index <= $currentStep && $order->status !== 'cancelled') bg-primary text-white border-white shadow-xl shadow-primary/20 scale-110 @else bg-slate-50 text-slate-300 border-white shadow-sm @endif
                                @if($order->status == 'cancelled') bg-red-50 text-red-300 @endif">
                                <i class="fas {{ $status['icon'] }} text-2xl"></i>
                            </div>
                            <p class="text-[10px] font-black uppercase tracking-widest 
                                @if($index <= $currentStep && $order->status !== 'cancelled') text-primary @else text-slate-400 @endif">
                                {{ $status['label'] }}
                            </p>

                            @if($index < count($statuses) - 1)
                                <div class="hidden md:block absolute top-10 left-[60%] w-[80%] h-0.5 bg-slate-50">
                                    <div class="h-full bg-primary transition-all duration-1000 ease-out" 
                                         style="width: {{ $index < $currentStep ? '100%' : '0%' }}"></div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
                <!-- Background decoration -->
                <div class="absolute -bottom-10 -right-10 text-[180px] font-black text-slate-100 opacity-20 pointer-events-none italic select-none tracking-tighter">Status.</div>
            </div>

            <!-- Order Details Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-16">
                <!-- Items list -->
                <div class="flex flex-col gap-6">
                    <h3 class="text-[10px] font-black text-slate-300 uppercase tracking-[0.3em] mb-4 border-l-4 border-primary pl-4">Articles Commandés</h3>
                    <div class="space-y-6">
                        @foreach($order->items as $item)
                            <div class="flex items-center gap-6 group">
                                <div class="w-16 h-16 bg-slate-50 rounded-2xl flex-shrink-0 flex items-center justify-center text-slate-300 border border-slate-100 group-hover:bg-primary/5 transition-colors">
                                    @if($item->product && $item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover rounded-2xl">
                                    @else
                                        <i class="fas fa-box text-xl"></i>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-black text-slate-900 group-hover:text-primary transition-colors">{{ $item->product->name ?? 'Produit Supprimé' }}</h4>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">{{ $item->quantity }} x {{ number_format($item->unit_price, 0, ',', ' ') }} CFA</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-black text-slate-900">{{ number_format($item->unit_price * $item->quantity, 0, ',', ' ') }} CFA</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Shipping / Summary -->
                <div class="flex flex-col gap-10">
                    <div class="bg-slate-50 rounded-[32px] p-10 border border-white shadow-sm">
                        <h3 class="text-[10px] font-black text-slate-300 uppercase tracking-[0.3em] mb-8 leading-none">Informations de Livraison</h3>
                        <div class="space-y-6">
                            <div>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1 leading-none">Adresse</p>
                                <p class="text-sm font-black text-slate-800 leading-relaxed">{{ $order->customer_address }}</p>
                            </div>
                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1 leading-none">Zone</p>
                                    <p class="text-sm font-black text-slate-800">{{ $order->deliveryZone->name ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1 leading-none">Frais</p>
                                    <p class="text-sm font-black text-slate-800">{{ number_format($order->delivery_fee, 0, ',', ' ') }} CFA</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-900 rounded-[32px] p-10 text-white shadow-2xl shadow-primary/20">
                         <div class="flex justify-between items-center">
                            <p class="text-[10px] font-black text-primary uppercase tracking-[0.3em]">Total de la Commande</p>
                            <p class="text-3xl font-black text-white tracking-tighter">{{ number_format($order->total_amount, 0, ',', ' ') }} <small class="text-[10px] italic opacity-50 ml-1">XOF</small></p>
                         </div>
                    </div>
                </div>
            </div>

            <div class="pt-12 border-t border-slate-50 flex flex-col md:flex-row justify-between items-center gap-8">
                <a href="{{ route('orders.index') }}" class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] hover:text-primary transition-colors">
                    <i class="fas fa-arrow-left mr-3"></i> Retour à mes commandes
                </a>
                <div class="flex gap-4">
                    <a href="{{ route('contact') }}" class="px-8 py-4 bg-slate-50 text-slate-600 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-100 transition-colors">Support Technique</a>
                    <a href="{{ route('shop.index') }}" class="px-8 py-4 bg-primary text-white rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-primary/20 hover:-translate-y-1 transition-all duration-300">Reprendre le Shopping</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
