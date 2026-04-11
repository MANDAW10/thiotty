<x-admin-layout>
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 md:mb-12 gap-6">
        <div>
            <h1 class="text-2xl md:text-3xl font-black text-slate-900 mb-2">Gestion des Commandes</h1>
            <nav class="flex text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-widest gap-2">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-primary transition-colors">Admin</a>
                <span>/</span>
                <span class="text-slate-900">Commandes</span>
            </nav>
        </div>
        <div class="w-full sm:w-auto">
            <div class="bg-white px-6 py-3 rounded-2xl border border-slate-100 shadow-sm text-[10px] md:text-xs font-bold text-slate-500 text-center">
                Total: <span class="text-slate-900 font-black ml-2">{{ $orders->total() }}</span>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-8 p-4 bg-green-50 border border-green-100 rounded-2xl text-green-600 font-bold text-sm flex items-center gap-3 fade-in">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-[40px] border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">
                        <th class="p-4 md:p-8 whitespace-nowrap">ID & Date</th>
                        <th class="p-4 md:p-8 whitespace-nowrap">Client</th>
                        <th class="p-4 md:p-8 whitespace-nowrap">Paiement</th>
                        <th class="p-4 md:p-8 whitespace-nowrap">Suivi Livraison</th>
                        <th class="p-4 md:p-8 text-right whitespace-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 font-bold text-slate-600">
                    @foreach($orders as $order)
                        <tr id="order-{{ $order->id }}" class="hover:bg-slate-50/50 transition-colors">
                            <td class="p-4 md:p-8">
                                <div class="text-primary font-black mb-1">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</div>
                                <div class="text-[10px] text-slate-400 uppercase tracking-widest">{{ $order->created_at->format('d/m/Y H:i') }}</div>
                            </td>
                            <td class="p-4 md:p-8">
                                <div class="text-slate-900">{{ $order->customer_name }}</div>
                                <div class="text-[10px] text-slate-400 flex items-center gap-2 mt-1 italic">
                                    {{ $order->customer_phone }} — {{ $order->deliveryZone?->name ?? 'Zone inconnue' }}
                                </div>
                            </td>
                            <td class="p-4 md:p-8">
                                <div class="text-slate-900 mb-2">{{ number_format($order->total_amount, 0, ',', ' ') }} <small class="text-[10px] opacity-40">CFA</small></div>
                                <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="{{ $order->status }}">
                                    <select name="payment_status" onchange="this.form.submit()" 
                                            class="text-[9px] font-black uppercase tracking-widest px-3 py-1.5 rounded-full border-none cursor-pointer focus:ring-0
                                            @if($order->payment_status == 'pending') bg-red-100 text-red-600 @else bg-green-100 text-green-600 @endif">
                                        <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Non-Payé</option>
                                        <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Payé</option>
                                    </select>
                                </form>
                            </td>
                            <td class="p-4 md:p-8">
                                <div x-data="{ open: false }" class="space-y-4">
                                    <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="payment_status" value="{{ $order->payment_status }}">
                                        <div class="relative max-w-[160px]">
                                            <select name="status" onchange="this.form.submit()" 
                                                    class="w-full bg-slate-50 border-none rounded-xl py-2.5 px-4 text-xs font-bold text-slate-600 appearance-none cursor-pointer hover:bg-slate-100 transition-colors focus:ring-1 focus:ring-primary/20 shadow-sm">
                                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>En attente</option>
                                                <option value="validated" {{ $order->status == 'validated' ? 'selected' : '' }}>Validée</option>
                                                <option value="preparing" {{ $order->status == 'preparing' ? 'selected' : '' }}>En préparation</option>
                                                <option value="shipping" {{ $order->status == 'shipping' ? 'selected' : '' }}>En livraison</option>
                                                <option value="arriving" {{ $order->status == 'arriving' ? 'selected' : '' }}>Arrivée imminente</option>
                                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Livrée</option>
                                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Annulée</option>
                                            </select>
                                        </div>
                                    </form>

                                    <!-- Tracking Info Toggle -->
                                    <button @click="open = !open" class="text-[9px] font-black uppercase text-primary tracking-widest hover:underline flex items-center gap-2">
                                        <i class="fas fa-truck-fast"></i>
                                        <span x-text="open ? 'Masquer détails' : 'Détails Livreur'"></span>
                                    </button>

                                    <div x-show="open" x-transition class="mt-4 p-4 bg-slate-50 rounded-2xl space-y-4 border border-slate-100">
                                        <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="space-y-3">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="{{ $order->status }}">
                                            <input type="hidden" name="payment_status" value="{{ $order->payment_status }}">
                                            
                                            <div class="space-y-1">
                                                <label class="text-[8px] font-black uppercase text-slate-400 tracking-widest pl-1">Nom Livreur</label>
                                                <input type="text" name="delivery_person_name" value="{{ $order->delivery_person_name }}" placeholder="Ex: Modou" class="w-full bg-white border-none rounded-lg py-2 px-3 text-[10px] font-bold focus:ring-1 focus:ring-primary/20">
                                            </div>
                                            <div class="space-y-1">
                                                <label class="text-[8px] font-black uppercase text-slate-400 tracking-widest pl-1">Tél Livreur</label>
                                                <input type="text" name="delivery_person_phone" value="{{ $order->delivery_person_phone }}" placeholder="7x xxx xx xx" class="w-full bg-white border-none rounded-lg py-2 px-3 text-[10px] font-bold focus:ring-1 focus:ring-primary/20">
                                            </div>
                                            <div class="space-y-1">
                                                <label class="text-[8px] font-black uppercase text-slate-400 tracking-widest pl-1">Délai (ETA)</label>
                                                <input type="text" name="estimated_delivery_time" value="{{ $order->estimated_delivery_time }}" placeholder="Ex: 15-20 min" class="w-full bg-white border-none rounded-lg py-2 px-3 text-[10px] font-bold focus:ring-1 focus:ring-primary/20">
                                            </div>
                                            <button type="submit" class="w-full py-2 bg-slate-900 text-white rounded-lg text-[9px] font-black uppercase tracking-widest hover:bg-primary transition-all">Enregistrer</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                            <td class="p-8 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->customer_phone) }}" 
                                       target="_blank"
                                       class="w-10 h-10 bg-green-500 text-white rounded-xl inline-flex items-center justify-center hover:shadow-lg hover:shadow-green-500/20 active:scale-95 transition-all">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
            <div class="px-8 py-6 bg-slate-50/50 border-t border-slate-50 flex items-center justify-between">
                <div class="text-[10px] font-black uppercase text-slate-400 tracking-widest">
                    Page {{ $orders->currentPage() }} sur {{ $orders->lastPage() }}
                </div>
                <div class="flex items-center gap-2">
                    @if($orders->onFirstPage())
                        <span class="px-4 py-2 bg-slate-100 text-slate-300 rounded-lg text-[10px] font-black uppercase tracking-widest cursor-not-allowed">
                            <i class="fas fa-chevron-left mr-2"></i> Précédent
                        </span>
                    @else
                        <a href="{{ $orders->previousPageUrl() }}" class="px-4 py-2 bg-white border border-slate-100 text-slate-600 hover:text-primary hover:border-primary rounded-lg text-[10px] font-black uppercase tracking-widest transition-all shadow-sm">
                            <i class="fas fa-chevron-left mr-2"></i> Précédent
                        </a>
                    @endif

                    @if($orders->hasMorePages())
                        <a href="{{ $orders->nextPageUrl() }}" class="px-4 py-2 bg-slate-900 border border-slate-900 text-white hover:bg-primary hover:border-primary rounded-lg text-[10px] font-black uppercase tracking-widest transition-all shadow-lg active:scale-95">
                            Suivant <i class="fas fa-chevron-right ml-2"></i>
                        </a>
                    @else
                        <span class="px-4 py-2 bg-slate-100 text-slate-300 rounded-lg text-[10px] font-black uppercase tracking-widest cursor-not-allowed">
                            Suivant <i class="fas fa-chevron-right ml-2"></i>
                        </span>
                    @endif
                </div>
            </div>
        @endif
    </div>
</x-admin-layout>
