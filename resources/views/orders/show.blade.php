<x-app-layout>
    <div class="py-24 bg-white min-h-screen">
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
                        <h1 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tighter mb-4 leading-tight">Suivi <span class="text-primary italic">Live</span>.</h1>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Référence : #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }} — Passée le {{ $order->created_at->format('d/m/Y') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest mb-2 leading-none text-right">Montant Total</p>
                        <p class="text-4xl font-black text-slate-900 leading-none tracking-tighter">{{ number_format($order->total_amount, 0, ',', ' ') }} <small class="text-xs italic opacity-20 font-black">XOF</small></p>
                    </div>
                </div>
            </div>

            <!-- Uber-Style Tracking Visualization -->
            <div class="bg-[#FCFCFC] rounded-[48px] p-8 md:p-16 mb-16 border border-slate-100 relative overflow-hidden group shadow-2xl shadow-slate-200/50">

                <!-- ETA Notification -->
                @if($order->status == 'shipping' || $order->status == 'arriving')
                <div class="mb-12 flex items-center gap-6 bg-white p-6 rounded-[32px] border border-primary/10 shadow-xl shadow-primary/5 animate-fade-in-up">
                    <div class="w-16 h-16 bg-primary text-white rounded-2xl flex items-center justify-center text-2xl shadow-lg shadow-primary/20 animate-pulse">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-[10px] font-black text-primary uppercase tracking-widest mb-1">Arrivée prévue</p>
                        <h3 class="text-2xl font-black text-slate-900 tracking-tighter">{{ $order->estimated_delivery_time ?: '15-25 minutes' }}</h3>
                    </div>
                    <div class="hidden md:block">
                        <span class="px-5 py-2 bg-green-50 text-green-600 text-[10px] font-black uppercase tracking-widest rounded-full border border-green-100">En route</span>
                    </div>
                </div>
                @endif

                <!-- Animated Transit Path (Uber Style) -->
                <div class="relative py-12 mb-12">
                    <!-- The Background Line -->
                    <div class="absolute top-1/2 left-0 w-full h-1 bg-slate-100 -translate-y-1/2 rounded-full overflow-hidden">
                        @php
                            $progressMap = [
                                'pending' => 5,
                                'validated' => 20,
                                'preparing' => 45,
                                'shipping' => 70,
                                'arriving' => 90,
                                'delivered' => 100,
                                'cancelled' => 0
                            ];
                            $progress = $progressMap[$order->status] ?? 5;
                        @endphp
                        <div class="h-full bg-primary transition-all duration-1000 ease-out" style="width: {{ $progress }}%"></div>
                    </div>

                    <!-- The Thiotty Truck Icon (Moves with progress) -->
                    <div class="absolute top-1/2 -translate-y-[80%] transition-all duration-1000 ease-out flex flex-col items-center gap-2"
                         style="left: calc({{ $progress }}% - 30px)">
                        <div class="w-16 h-10 bg-slate-900 rounded-lg shadow-2xl flex items-center justify-center relative overflow-hidden group/truck">
                            <i class="fas fa-truck text-white text-xl translate-x-[-2px]"></i>
                            <div class="absolute -bottom-1 left-2 flex gap-1">
                                <div class="w-3 h-3 bg-slate-700 rounded-full border-2 border-slate-900"></div>
                                <div class="w-3 h-3 bg-slate-700 rounded-full border-2 border-slate-900 ml-4"></div>
                            </div>
                            <!-- Tail lights effect -->
                            <div class="absolute right-0 top-1/2 -translate-y-1/2 w-1 h-4 bg-primary/40 blur-[2px]"></div>
                        </div>
                        <span class="text-[8px] font-black uppercase tracking-widest text-primary bg-primary/10 px-2 py-0.5 rounded-md whitespace-nowrap">Thiotty Truck</span>
                    </div>

                    <!-- Key Milestones -->
                    <div class="flex justify-between items-center relative z-10">
                        @php
                            $steps = [
                                ['status' => 'pending', 'icon' => 'fa-clipboard-list', 'label' => 'Reçue'],
                                ['status' => 'preparing', 'icon' => 'fa-box-open', 'label' => 'Préparation'],
                                ['status' => 'shipping', 'icon' => 'fa-route', 'label' => 'En route'],
                                ['status' => 'delivered', 'icon' => 'fa-house-chimney-check', 'label' => 'Livrée'],
                            ];
                            $currentIdx = 0;
                            foreach($steps as $idx => $s) {
                                if ($order->status == $s['status']) $currentIdx = $idx;
                            }
                            // Special cases for intermediate statuses
                            if ($order->status == 'validated') $currentIdx = 0;
                            if ($order->status == 'arriving') $currentIdx = 2;
                        @endphp

                        @foreach($steps as $index => $step)
                            <div class="flex flex-col items-center">
                                <div class="w-12 h-12 rounded-2xl flex items-center justify-center border-2 transition-all duration-500
                                    @if($order->status == $step['status'] || ($progress >= $progressMap[$step['status']])) bg-white border-primary text-primary shadow-lg shadow-primary/10 scale-110 z-20 @else bg-slate-50 border-white text-slate-300 @endif">
                                    <i class="fas {{ $step['icon'] }} text-sm"></i>
                                </div>
                                <p class="mt-4 text-[9px] font-black uppercase tracking-widest leading-none
                                    @if($order->status == $step['status'] || ($progress >= $progressMap[$step['status']])) text-slate-900 @else text-slate-300 @endif">
                                    {{ $step['label'] }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Status Contextual Message -->
                <div class="text-center mt-12">
                    <h4 class="text-lg font-black text-slate-900 mb-2">
                        @if($order->status == 'pending') Nous avons bien reçu votre commande !
                        @elseif($order->status == 'validated') Votre commande a été validée par nos équipes.
                        @elseif($order->status == 'preparing') Nous préparons vos produits avec le plus grand soin.
                        @elseif($order->status == 'shipping') Votre livreur est en route vers votre adresse.
                        @elseif($order->status == 'arriving') Le livreur est dans votre quartier, préparez-vous !
                        @elseif($order->status == 'delivered') Commande livrée. Merci de votre confiance !
                        @elseif($order->status == 'cancelled') Commande annulée.
                        @endif
                    </h4>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest italic">Dernière mise à jour : {{ $order->updated_at->format('H:i') }}</p>
                </div>
            </div>

            <!-- Delivery Person Card -->
            @if($order->delivery_person_name)
            <div class="bg-slate-900 rounded-[40px] p-8 md:p-12 text-white mb-16 shadow-2xl shadow-primary/20 relative overflow-hidden animate-fade-in-up">
                 <div class="relative z-10 flex flex-col md:flex-row items-center gap-10">
                    <div class="w-24 h-24 bg-primary/20 rounded-[32px] flex items-center justify-center border border-primary/30 relative">
                        <i class="fas fa-user-tie text-4xl text-primary"></i>
                        <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-green-500 rounded-full border-4 border-slate-900 flex items-center justify-center">
                            <i class="fas fa-check text-[10px]"></i>
                        </div>
                    </div>
                    <div class="flex-1 text-center md:text-left space-y-2">
                        <p class="text-[10px] font-black text-primary uppercase tracking-[0.3em]">Votre Livreur Thiotty</p>
                        <h3 class="text-3xl font-black tracking-tighter">{{ $order->delivery_person_name }}</h3>
                        <p class="text-slate-400 font-medium text-sm">Professionnel certifié — +100 livraisons réussies</p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto">
                        @if($order->delivery_person_phone)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->delivery_person_phone) }}?text=Bonjour {{ $order->delivery_person_name }}, je vous contacte pour ma commande Thiotty #{{ $order->id }}"
                           target="_blank"
                           class="flex-1 flex items-center justify-center gap-4 bg-white text-slate-900 px-8 py-5 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-primary hover:text-white transition-all group">
                           <i class="fab fa-whatsapp text-lg text-green-500 group-hover:text-white"></i> Contacter
                        </a>
                        @endif
                    </div>
                 </div>
                 <!-- Background abstract -->
                 <div class="absolute -bottom-10 -right-10 text-[120px] font-black text-white/5 opacity-10 pointer-events-none italic select-none tracking-tighter">Livreur.</div>
            </div>
            @endif

            <!-- Order Details (Summary) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-16">
                <!-- Items list -->
                <div class="flex flex-col gap-6">
                    <h3 class="text-[10px] font-black text-slate-300 uppercase tracking-[0.3em] mb-4 border-l-4 border-primary pl-4">Récapitulatif Articles</h3>
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
                                    <h4 class="text-sm font-black text-slate-900 group-hover:text-primary transition-colors text-slate-900">{{ $item->product->name ?? 'Produit Thiotty' }}</h4>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">{{ $item->quantity }} x {{ number_format($item->unit_price, 0, ',', ' ') }} CFA</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-black text-slate-900">{{ number_format($item->unit_price * $item->quantity, 0, ',', ' ') }} CFA</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Info Column -->
                <div class="space-y-10">
                    <div class="bg-slate-50 rounded-[32px] p-10 border border-white shadow-sm">
                        <h3 class="text-[10px] font-black text-slate-300 uppercase tracking-[0.3em] mb-8 leading-none">Destination</h3>
                        <div class="space-y-6">
                            <div>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1 leading-none">Adresse de livraison</p>
                                <p class="text-sm font-black text-slate-800 leading-relaxed">{{ $order->customer_address }}</p>
                            </div>
                            <div class="flex items-center gap-4 py-4 border-t border-slate-200/50 mt-4">
                                <div class="w-10 h-10 bg-white rounded-xl shadow-sm flex items-center justify-center text-primary">
                                    <i class="fas fa-location-dot"></i>
                                </div>
                                <div>
                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Zone de livraison</p>
                                    <p class="text-xs font-black text-slate-900">{{ $order->deliveryZone->name ?? 'Dakar' }} (+{{ number_format($order->delivery_fee, 0, ',', ' ') }})</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Status Card -->
                    <div class="bg-white rounded-[32px] p-10 border border-slate-200 shadow-sm">
                        <h3 class="text-[10px] font-black text-slate-300 uppercase tracking-[0.3em] mb-8 leading-none">Statut du paiement</h3>
                        <div class="space-y-6">
                            @php
                                $payment = $order->payment;
                                $payment_status = $payment ? $payment->status : $order->payment_status;
                            @endphp

                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white font-black
                                    @if($payment_status === 'paid' || ($payment && $payment->isCompleted())) bg-green-500
                                    @elseif($payment_status === 'processing' || ($payment && $payment->isProcessing())) bg-yellow-500
                                    @elseif($payment_status === 'failed' || ($payment && $payment->isFailed())) bg-red-500
                                    @else bg-slate-300
                                    @endif">
                                    <i class="fas @if($payment_status === 'paid' || ($payment && $payment->isCompleted())) fa-check-circle @elseif($payment_status === 'processing' || ($payment && $payment->isProcessing())) fa-hourglass @elseif($payment_status === 'failed' || ($payment && $payment->isFailed())) fa-times-circle @else fa-circle-notch @endif"></i>
                                </div>
                                <div>
                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Mode de paiement</p>
                                    <p class="text-xs font-black text-slate-900">
                                        @if($order->payment_method === 'cash')
                                            À la livraison
                                        @elseif($order->payment_method === 'wave')
                                            Wave / Wari
                                        @elseif($order->payment_method === 'orange_money')
                                            Orange Money
                                        @else
                                            {{ ucfirst($order->payment_method) }}
                                        @endif
                                    </p>
                                </div>
                            </div>

                            @if(!($payment_status === 'paid' || ($payment && $payment->isCompleted())))
                                <a href="{{ route('payment.show', $order) }}" class="w-full mt-6 inline-block text-center bg-primary hover:bg-primary/90 text-white px-6 py-4 rounded-xl font-black text-[10px] uppercase tracking-[0.3em] transition-all shadow-lg shadow-primary/20">
                                    <i class="fas fa-credit-card mr-2"></i> Procéder au paiement
                                </a>
                            @else
                                <div class="mt-6 p-4 bg-green-50 rounded-xl border border-green-200 text-center">
                                    <p class="text-xs font-black text-green-700">✓ Paiement effectué avec succès</p>
                                    @if($payment && $payment->transaction_id)
                                        <p class="text-[9px] text-green-600 mt-2">ID: {{ $payment->transaction_id }}</p>
                                    @endif
                                </div>
                            @endif

                            @if($payment && $payment->isFailed())
                                <div class="mt-6 p-4 bg-red-50 rounded-xl border border-red-200">
                                    <p class="text-xs font-black text-red-700 mb-3">⚠️ Paiement échoué</p>
                                    <a href="{{ route('payment.show', $order) }}" class="w-full text-center bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-black text-[10px] uppercase tracking-widest transition-colors">
                                        Réessayer
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="flex justify-between items-center px-4">
                        <a href="{{ route('orders.index') }}" class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] hover:text-primary transition-colors">
                            <i class="fas fa-arrow-left mr-3"></i> Retour
                        </a>
                        <button onclick="window.print()" class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] hover:text-primary transition-colors">
                            <i class="fas fa-print mr-3"></i> Imprimer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
