<x-app-layout>
    <!-- Checkout Header -->
    <header class="py-12 bg-white border-b border-slate-50">
        <div class="container-custom text-center">
            <nav class="flex justify-center mb-4 text-xs font-bold text-slate-400 uppercase tracking-widest gap-2">
                <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Accueil</a>
                <span>/</span>
                <a href="{{ route('cart.index') }}" class="hover:text-primary transition-colors">Panier</a>
                <span>/</span>
                <span class="text-slate-900">Paiement</span>
            </nav>
            <h1 class="text-3xl md:text-5xl font-black text-slate-900 leading-tight">
                Finalisation
            </h1>
        </div>
    </header>

    <div class="py-12 lg:py-20 bg-slate-50/30" x-data="{ 
        deliveryFee: 0,
        subtotal: {{ $subtotal }},
        updateFee(event) {
            const selected = event.target.options[event.target.selectedIndex];
            this.deliveryFee = parseFloat(selected.dataset.fee || 0);
        },
        number_format(number) {
            return new Intl.NumberFormat('fr-FR').format(number);
        }
    }">
        <div class="container-custom">
            <div class="flex flex-col lg:flex-row gap-12">
                <!-- Checkout Form -->
                <div class="w-full lg:w-2/3">
                    <form action="{{ route('checkout.store') }}" method="POST" class="space-y-8">
                        @csrf
                        
                        <!-- Section 1: Livraison -->
                        <div class="bg-white rounded-[32px] p-8 md:p-10 border border-slate-100 shadow-sm">
                            <div class="flex items-center gap-4 mb-10">
                                <span class="w-10 h-10 bg-primary text-white rounded-2xl flex items-center justify-center text-sm font-black shadow-lg shadow-primary/20">1</span>
                                <h3 class="text-xl font-bold text-slate-900">Informations de Livraison</h3>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label for="customer_name" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Nom complet</label>
                                    <input id="customer_name" name="customer_name" type="text" 
                                           class="w-full bg-slate-50 border-none rounded-xl py-4 px-6 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all" 
                                           value="{{ old('customer_name', auth()->user()->name) }}" required>
                                    <x-input-error :messages="$errors->get('customer_name')" class="mt-2" />
                                </div>
                                <div class="space-y-2">
                                    <label for="customer_phone" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Numéro WhatsApp</label>
                                    <input id="customer_phone" name="customer_phone" type="text" 
                                           class="w-full bg-slate-50 border-none rounded-xl py-4 px-6 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all" 
                                           placeholder="77 000 00 00" value="{{ old('customer_phone') }}" required>
                                    <x-input-error :messages="$errors->get('customer_phone')" class="mt-2" />
                                </div>
                                <div class="md:col-span-2 space-y-2">
                                    <label for="delivery_zone_id" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Zone de livraison</label>
                                    <div class="relative">
                                        <select id="delivery_zone_id" name="delivery_zone_id" @change="updateFee" 
                                                class="w-full bg-slate-50 border-none rounded-xl py-4 px-6 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all appearance-none cursor-pointer" required>
                                            <option value="" data-fee="0">Sélectionner une zone</option>
                                            @foreach($deliveryZones as $zone)
                                                <option value="{{ $zone->id }}" data-fee="{{ $zone->fee }}">{{ $zone->name }} (+ {{ number_format($zone->fee, 0, ',', ' ') }} CFA)</option>
                                            @endforeach
                                        </select>
                                        <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                            <i class="fas fa-chevron-down text-xs"></i>
                                        </div>
                                    </div>
                                    <x-input-error :messages="$errors->get('delivery_zone_id')" class="mt-2" />
                                </div>
                                <div class="md:col-span-2 space-y-2">
                                    <label for="customer_address" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Adresse précise</label>
                                    <textarea id="customer_address" name="customer_address" rows="3" 
                                              class="w-full bg-slate-50 border-none rounded-xl py-4 px-6 font-medium text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all" 
                                              placeholder="Appartement, rue, point de repère..." required>{{ old('customer_address') }}</textarea>
                                    <x-input-error :messages="$errors->get('customer_address')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Paiement -->
                        <div class="bg-white rounded-[32px] p-8 md:p-10 border border-slate-100 shadow-sm">
                            <div class="flex items-center gap-4 mb-10">
                                <span class="w-10 h-10 bg-primary text-white rounded-2xl flex items-center justify-center text-sm font-black shadow-lg shadow-primary/20">2</span>
                                <h3 class="text-xl font-bold text-slate-900">Mode de Paiement</h3>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                                <label class="relative block cursor-pointer group">
                                    <input type="radio" name="payment_method" value="cash" class="peer hidden" required checked>
                                    <div class="p-6 text-center border-2 border-slate-100 bg-white peer-checked:border-primary peer-checked:bg-primary/5 peer-checked:text-primary transition-all rounded-2xl hover:bg-slate-50">
                                        <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400 group-hover:text-primary transition-colors">
                                            <i class="fas fa-money-bill-wave text-xl"></i>
                                        </div>
                                        <span class="font-black block text-[10px] uppercase tracking-widest">Espèces</span>
                                    </div>
                                </label>
                                <label class="relative block cursor-pointer group">
                                    <input type="radio" name="payment_method" value="wave" class="peer hidden" required>
                                    <div class="p-6 text-center border-2 border-slate-100 bg-white peer-checked:border-primary peer-checked:bg-primary/5 peer-checked:text-primary transition-all rounded-2xl hover:bg-slate-50">
                                        <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400 group-hover:text-primary transition-colors">
                                            <i class="fas fa-mobile-alt text-xl"></i>
                                        </div>
                                        <span class="font-black block text-[10px] uppercase tracking-widest">Wave</span>
                                    </div>
                                </label>
                                <label class="relative block cursor-pointer group">
                                    <input type="radio" name="payment_method" value="orange_money" class="peer hidden" required>
                                    <div class="p-6 text-center border-2 border-slate-100 bg-white peer-checked:border-primary peer-checked:bg-primary/5 peer-checked:text-primary transition-all rounded-2xl hover:bg-slate-50">
                                        <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400 group-hover:text-primary transition-colors">
                                            <i class="fas fa-wallet text-xl"></i>
                                        </div>
                                        <span class="font-black block text-[10px] uppercase tracking-widest">Orange Money</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn-lahad w-full py-6 text-xl shadow-xl shadow-primary/20">
                            Confirmer pour <span x-text="number_format(subtotal + deliveryFee) + ' CFA'"></span>
                        </button>
                    </form>
                </div>

                <!-- Order Summary Sidebar -->
                <div class="w-full lg:w-1/3">
                    <div class="bg-white rounded-[40px] p-8 md:p-10 sticky top-40 border border-slate-100 shadow-xl shadow-slate-200/50">
                        <h3 class="text-xl font-bold text-slate-900 mb-8 pb-4 border-b border-slate-50">Ma Commande</h3>
                        
                        <div class="space-y-6 mb-10 max-h-[300px] overflow-y-auto pr-4 scrollbar-thin">
                            @foreach($cart as $id => $item)
                                <div class="flex items-center gap-4 group">
                                    <div class="w-14 h-14 bg-slate-50 rounded-xl overflow-hidden shrink-0 border border-slate-100">
                                        <img src="{{ $item['image'] ?? 'https://images.unsplash.com/photo-1596733430284-f7437764b1a9?q=80&w=200&auto=format&fit=crop' }}" 
                                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-xs font-bold text-slate-900 truncate mb-1">{{ $item['name'] }}</h4>
                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Qté: {{ $item['quantity'] }}</p>
                                    </div>
                                    <span class="text-xs font-black text-slate-900 whitespace-nowrap">{{ number_format($item['price'] * $item['quantity'], 0, ',', ' ') }} CFA</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="space-y-4 pt-8 border-t border-slate-50">
                            <div class="flex justify-between items-center text-sm font-bold text-slate-500">
                                <span>Sous-total</span>
                                <span class="text-slate-900">{{ number_format($subtotal, 0, ',', ' ') }} CFA</span>
                            </div>
                            <div class="flex justify-between items-center text-sm font-bold">
                                <span class="text-slate-500">Frais de livraison</span>
                                <span class="text-primary italic" x-text="'+ ' + number_format(deliveryFee) + ' CFA'"></span>
                            </div>
                            <div class="flex justify-between items-end pt-6 border-t-2 border-slate-50">
                                <span class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Total Global</span>
                                <span class="text-3xl font-black text-primary" x-text="number_format(subtotal + deliveryFee) + ' CFA'"></span>
                            </div>
                        </div>

                        <div class="mt-12 p-6 bg-slate-50/50 rounded-2xl border border-slate-100 border-dashed">
                            <div class="flex gap-4">
                                <i class="fas fa-info-circle text-primary text-lg mt-0.5"></i>
                                <p class="text-[9px] font-bold text-slate-500 leading-relaxed uppercase tracking-widest">
                                    Un conseiller Lahad Enterprise vous contactera par WhatsApp pour confirmer l'heure exacte de passage.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
