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

    @if(session('error'))
        <div class="container-custom mt-8">
            <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 font-bold flex items-center gap-3">
                <i class="fas fa-exclamation-circle text-xl"></i>
                <p>{{ session('error') }}</p>
            </div>
        </div>
    @endif


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
                        <div class="bg-white rounded-[32px] p-8 md:p-10 border border-slate-100 shadow-sm relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-full -translate-y-1/2 translate-x-1/2 blur-2xl"></div>
                            <div class="flex items-center gap-4 mb-10">
                                <span class="w-10 h-10 bg-primary text-white rounded-2xl flex items-center justify-center text-sm font-black shadow-lg shadow-primary/20">2</span>
                                <h3 class="text-xl font-bold text-slate-900">Mode de Paiement</h3>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 relative z-10" x-data="{ selectedMethod: 'cash' }">
                                <input type="hidden" name="payment_method" :value="selectedMethod">

                                <!-- Cash -->
                                <label class="flex flex-col items-center justify-center p-6 bg-white rounded-3xl border-2 cursor-pointer transition-all duration-300 text-center group"
                                       :class="selectedMethod === 'cash' ? 'border-[var(--primary)] shadow-lg shadow-[var(--primary)]/10 ring-4 ring-[var(--primary)]/10' : 'border-slate-100 hover:border-slate-200 bg-slate-50'">
                                    <input type="radio" value="cash" x-model="selectedMethod" class="sr-only">
                                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center mb-4 transition-colors duration-300"
                                         :class="selectedMethod === 'cash' ? 'bg-[var(--primary)] text-white' : 'bg-slate-100 text-slate-400 group-hover:bg-slate-200'">
                                        <i class="fas fa-hand-holding-dollar text-2xl"></i>
                                    </div>
                                    <h4 class="text-sm font-black uppercase tracking-widest text-slate-900 mb-1">À la livraison</h4>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Payer en espèces</p>
                                </label>

                                <!-- Wave -->
                                <label class="flex flex-col items-center justify-center p-6 bg-white rounded-3xl border-2 cursor-pointer transition-all duration-300 text-center group"
                                       :class="selectedMethod === 'wave' ? 'border-[#1ebff6] shadow-lg shadow-[#1ebff6]/10 ring-4 ring-[#1ebff6]/10' : 'border-slate-100 hover:border-slate-200 bg-slate-50'">
                                    <input type="radio" value="wave" x-model="selectedMethod" class="sr-only">
                                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center mb-4 transition-colors duration-300"
                                         :class="selectedMethod === 'wave' ? 'bg-[#1ebff6] text-white' : 'bg-slate-100 text-slate-400 group-hover:bg-slate-200'">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/cd/Wave_Mobile_Money_logo.png/640px-Wave_Mobile_Money_logo.png" alt="Wave" class="w-10 h-10 object-contain rounded-xl mix-blend-multiply" :class="selectedMethod === 'wave' ? 'brightness-200 grayscale contrast-100' : 'grayscale opacity-50'">
                                    </div>
                                    <h4 class="text-sm font-black uppercase tracking-widest text-[#1ebff6] mb-1">Wave Mobile</h4>
                                    <p class="text-[10px] font-bold text-[#1ebff6]/60 uppercase tracking-wider">Sécurisé & Rapide</p>
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn-thiotty w-full py-6 text-xl shadow-xl shadow-primary/20">
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
                                    Un conseiller Thiotty Enterprise vous contactera par WhatsApp pour confirmer l'heure exacte de passage.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
