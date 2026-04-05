<x-app-layout>
    <div class="py-24 flex items-center justify-center min-h-[80vh] bg-white relative overflow-hidden">
        <div class="max-w-3xl mx-auto px-6 text-center reveal-zenith relative z-10 w-full">
            <div class="relative w-32 h-32 mx-auto mb-16">
                <div class="absolute inset-0 bg-primary/10 rounded-full animate-ping opacity-20"></div>
                <div class="relative w-full h-full bg-white rounded-3xl shadow-xl flex items-center justify-center text-primary border-2 border-slate-50 scale-110">
                    <i class="fas fa-check-circle text-6xl"></i>
                </div>
            </div>
            
            <h1 class="text-4xl md:text-6xl font-black text-slate-900 leading-tight mb-8 tracking-tighter">
                Commande <span class="text-primary italic">Confirmée</span>.
            </h1>
            <p class="text-xl text-slate-500 mb-16 max-w-lg mx-auto leading-relaxed font-bold uppercase tracking-widest opacity-30 border-y border-slate-50 py-10">
                Référence : #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
            </p>

            <div class="bg-[#FCFCFC] rounded-3xl p-10 lg:p-16 shadow-sm text-left mb-16 relative overflow-hidden border border-slate-100 group">
                <h3 class="text-2xl font-black text-slate-900 mb-12 border-b border-slate-50 pb-6 uppercase tracking-tighter">Détails de l'Expédition</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 relative z-10">
                    <div>
                        <p class="text-[9px] font-black text-slate-300 uppercase tracking-widest mb-4 leading-none">Client</p>
                        <p class="text-xl font-black text-slate-900">{{ $order->customer_name }}</p>
                        <p class="text-slate-400 font-bold italic mt-1">{{ $order->customer_phone }}</p>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-slate-300 uppercase tracking-widest mb-4 leading-none">Livraison</p>
                        <p class="text-xl font-black text-slate-900">{{ $order->deliveryZone->name }}</p>
                        <p class="text-slate-400 font-bold italic mt-1">{{ $order->customer_address }}</p>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-slate-300 uppercase tracking-widest mb-4 leading-none">Mode</p>
                        <p class="text-sm font-black text-slate-900 uppercase tracking-widest">{{ str_replace('_', ' ', $order->payment_method) }}</p>
                        <div class="inline-flex items-center gap-3 mt-4 px-4 py-1.5 bg-primary/10 rounded-lg">
                            <div class="w-1.5 h-1.5 bg-primary rounded-full animate-pulse"></div>
                            <span class="text-[9px] text-primary font-black uppercase tracking-widest">{{ $order->payment_status == 'paid' ? 'Payé' : 'En attente' }}</span>
                        </div>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest mb-4 leading-none text-right">Total Transféré</p>
                        <p class="text-4xl font-black text-slate-900 text-right leading-none">{{ number_format($order->total_amount, 0, ',', ' ') }} <small class="text-xs italic opacity-20 ml-2 font-black">Xof</small></p>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row justify-center gap-6 relative z-10 w-full max-w-lg mx-auto">
                <a href="{{ $whatsappUrl }}" target="_blank" class="w-full flex items-center justify-center gap-4 px-10 py-6 bg-[#25D366] text-white rounded-[24px] font-black shadow-xl shadow-[#25D366]/30 hover:bg-[#128C7E] transition-all text-sm uppercase tracking-widest active:scale-95 animate-button-pulse">
                    <i class="fab fa-whatsapp text-2xl"></i> Finaliser sur WhatsApp
                </a>
                <a href="{{ route('shop.index') }}" class="w-full sm:w-auto px-10 py-6 bg-slate-100 text-slate-500 rounded-[24px] font-black text-xs uppercase tracking-widest hover:bg-slate-200 transition-all text-center">
                    Retour Boutique
                </a>
            </div>

            <style>
                @keyframes button-pulse {
                    0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.4); }
                    70% { transform: scale(1.02); box-shadow: 0 0 0 15px rgba(37, 211, 102, 0); }
                    100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(37, 211, 102, 0); }
                }
                .animate-button-pulse {
                    animation: button-pulse 2s infinite;
                }
            </style>
        </div>
    </div>
</x-app-layout>
