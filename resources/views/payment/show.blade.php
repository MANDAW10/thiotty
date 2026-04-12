@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-12 px-4">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-slate-900 mb-2">Paiement sécurisé</h1>
            <p class="text-slate-600">Commande #{{ $order->id }} • {{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y à H:i') }}</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left: Payment Methods -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md p-8 mb-6">
                    <!-- Order Summary -->
                    <div class="mb-8 pb-8 border-b border-slate-200">
                        <h2 class="text-lg font-semibold text-slate-900 mb-4">Récapitulatif de la commande</h2>
                        <div class="space-y-3">
                            @foreach($order->items as $item)
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center gap-3 flex-1">
                                        @if($item->product->image)
                                            <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="w-12 h-12 object-cover rounded">
                                        @endif
                                        <div>
                                            <p class="text-slate-900 font-medium">{{ $item->product->name }}</p>
                                            <p class="text-sm text-slate-500">Qty: {{ $item->quantity }}</p>
                                        </div>
                                    </div>
                                    <p class="text-slate-900 font-semibold">{{ number_format($item->price * $item->quantity, 2) }} FCFA</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Pricing Breakdown -->
                    <div class="space-y-3 mb-8 pb-8 border-b border-slate-200">
                        <div class="flex justify-between text-slate-600">
                            <span>Sous-total</span>
                            <span>{{ number_format($order->total_amount - $order->delivery_fee, 2) }} FCFA</span>
                        </div>
                        @if($order->delivery_fee > 0)
                            <div class="flex justify-between text-slate-600">
                                <span>Frais de livraison</span>
                                <span>{{ number_format($order->delivery_fee, 2) }} FCFA</span>
                            </div>
                        @endif
                        <div class="flex justify-between text-lg font-bold text-slate-900 pt-3">
                            <span>Total à payer</span>
                            <span class="text-{{ custom color class }}">{{ number_format($order->total_amount, 2) }} FCFA</span>
                        </div>
                    </div>

                    <!-- Payment Methods -->
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900 mb-6">Méthode de paiement</h2>

                        <form id="paymentForm" @submit.prevent="handlePayment" class="space-y-4">
                            @csrf
                            <input type="hidden" name="amount" value="{{ $order->total_amount }}">

                            <!-- Card Payment -->
                            <label class="relative flex items-center p-4 border-2 border-slate-200 rounded-lg cursor-pointer hover:border-blue-400 transition-colors" @click="selectedMethod = 'card'">
                                <input type="radio" name="payment_method" value="card" v-model="selectedMethod" class="w-4 h-4">
                                <div class="flex-1 ml-4">
                                    <p class="font-semibold text-slate-900">Carte bancaire</p>
                                    <p class="text-sm text-slate-500">Visa, Mastercard, American Express</p>
                                </div>
                                <svg class="w-8 h-8 text-blue-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20 8H4V6h16m0 8H4v-2h16m0 8H4v-2h16z"/>
                                </svg>
                            </label>

                            <!-- Mobile Money Payment -->
                            <label class="relative flex items-center p-4 border-2 border-slate-200 rounded-lg cursor-pointer hover:border-green-400 transition-colors" @click="selectedMethod = 'mobile'">
                                <input type="radio" name="payment_method" value="mobile" v-model="selectedMethod" class="w-4 h-4">
                                <div class="flex-1 ml-4">
                                    <p class="font-semibold text-slate-900">Portefeuille mobile</p>
                                    <p class="text-sm text-slate-500">Orange Money, Wave, Wari, etc.</p>
                                </div>
                                <svg class="w-8 h-8 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V7l-5-5zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v3z"/>
                                </svg>
                            </label>

                            <!-- Bank Transfer -->
                            <label class="relative flex items-center p-4 border-2 border-slate-200 rounded-lg cursor-pointer hover:border-purple-400 transition-colors" @click="selectedMethod = 'bank'">
                                <input type="radio" name="payment_method" value="bank" v-model="selectedMethod" class="w-4 h-4">
                                <div class="flex-1 ml-4">
                                    <p class="font-semibold text-slate-900">Virement bancaire</p>
                                    <p class="text-sm text-slate-500">Virement direct depuis votre banque</p>
                                </div>
                                <svg class="w-8 h-8 text-purple-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M21 8a2 2 0 0 0-1-1.72l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16V8z"/>
                                </svg>
                            </label>

                            <!-- Cash on Delivery -->
                            <label class="relative flex items-center p-4 border-2 border-slate-200 rounded-lg cursor-pointer hover:border-amber-400 transition-colors" @click="selectedMethod = 'cash'">
                                <input type="radio" name="payment_method" value="cash" v-model="selectedMethod" class="w-4 h-4">
                                <div class="flex-1 ml-4">
                                    <p class="font-semibold text-slate-900">Paiement à la livraison</p>
                                    <p class="text-sm text-slate-500">Payez directement au livreur</p>
                                </div>
                                <svg class="w-8 h-8 text-amber-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"/>
                                </svg>
                            </label>

                            <!-- Dynamic Form Fields based on selected method -->
                            <transition name="fade">
                                <div v-if="selectedMethod === 'card'" class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                                    <p class="text-sm text-slate-600 mb-4">Les informations de carte sont traitées de manière sécurisée.</p>
                                    <div class="space-y-3">
                                        <input type="text" placeholder="Numéro de carte" class="w-full px-4 py-2 border border-slate-200 rounded-lg" name="card_token">
                                        <div class="grid grid-cols-2 gap-3">
                                            <input type="text" placeholder="MM/AA" class="px-4 py-2 border border-slate-200 rounded-lg">
                                            <input type="text" placeholder="CVV" class="px-4 py-2 border border-slate-200 rounded-lg">
                                        </div>
                                    </div>
                                </div>

                                <div v-if="selectedMethod === 'mobile'" class="mt-6 p-4 bg-green-50 rounded-lg border border-green-200">
                                    <p class="text-sm text-slate-600 mb-4">Entrez votre numéro de téléphone pour recevoir une demande de paiement.</p>
                                    <input type="tel" placeholder="Numéro de téléphone" class="w-full px-4 py-2 border border-slate-200 rounded-lg" name="phone_number" pattern="[0-9+\-\s]{10,}">
                                </div>

                                <div v-if="selectedMethod === 'bank'" class="mt-6 p-4 bg-purple-50 rounded-lg border border-purple-200">
                                    <p class="text-sm text-slate-600 mb-4">Les détails du virement bancaire seront affichés après validation.</p>
                                    <div class="space-y-2 text-sm">
                                        <p><strong>Banque:</strong> Le détail sera fourni</p>
                                        <p><strong>Référence:</strong> Commande #{{ $order->id }}</p>
                                    </div>
                                </div>

                                <div v-if="selectedMethod === 'cash'" class="mt-6 p-4 bg-amber-50 rounded-lg border border-amber-200">
                                    <p class="text-sm text-slate-600">Vous devrez payer <strong>{{ number_format($order->total_amount, 2) }} FCFA</strong> au livreur à la réception de votre colis.</p>
                                </div>
                            </transition>

                            <!-- Security Notice -->
                            <div class="mt-8 p-4 bg-green-50 rounded-lg border border-green-200">
                                <div class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/>
                                    </svg>
                                    <div>
                                        <p class="font-semibold text-green-900 text-sm">Paiement sécurisé</p>
                                        <p class="text-xs text-green-700">Vos données sont chiffrées et protégées avec le protocole SSL 256-bit.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" :disabled="!selectedMethod || isProcessing" class="w-full mt-8 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 disabled:from-slate-400 disabled:to-slate-500 text-white font-bold py-3 px-6 rounded-lg transition-all duration-200 flex items-center justify-center gap-2">
                                <span v-if="!isProcessing">Procéder au paiement</span>
                                <span v-if="isProcessing">Traitement en cours...</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right: Delivery Info -->
            <div>
                <!-- Delivery Information -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Livraison</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-slate-500">Nom du client</p>
                            <p class="font-medium text-slate-900">{{ $order->customer_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500">Téléphone</p>
                            <p class="font-medium text-slate-900">{{ $order->customer_phone }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500">Adresse</p>
                            <p class="font-medium text-slate-900">{{ $order->customer_address }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500">Zone de livraison</p>
                            <p class="font-medium text-slate-900">{{ $order->deliveryZone->name ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Current Status -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Statut du paiement</h3>
                    @if($payment)
                        <div class="space-y-2">
                            <div class="flex items-center gap-2">
                                <span class="inline-block w-3 h-3 rounded-full @if($payment->isCompleted()) bg-green-500 @elseif($payment->isProcessing()) bg-yellow-500 @elseif($payment->isFailed()) bg-red-500 @else bg-slate-300 @endif"></span>
                                <span class="font-medium text-slate-900">
                                    @switch($payment->status)
                                        @case('completed')
                                            Payé
                                        @break
                                        @case('processing')
                                            En traitement
                                        @break
                                        @case('failed')
                                            Échoué
                                        @break
                                        @default
                                            En attente
                                    @endswitch
                                </span>
                            </div>
                            @if($payment->transaction_id)
                                <p class="text-sm text-slate-500">ID: {{ $payment->transaction_id }}</p>
                            @endif
                        </div>
                    @else
                        <p class="text-slate-500">Pas encore de paiement enregistré</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Simple Vue-like reactive behavior (if Vue not available, fallback to vanilla JS)
    const paymentForm = {
        selectedMethod: 'card',
        isProcessing: false,

        handlePayment() {
            this.isProcessing = true;

            const formData = new FormData(document.getElementById('paymentForm'));
            formData.append('payment_method', this.selectedMethod);

            fetch('{{ route("payment.process", $order) }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = data.redirect || '{{ route("order.confirmation", $order) }}';
                } else {
                    alert('Erreur: ' + (data.error || 'Une erreur s\'est produite'));
                    this.isProcessing = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Une erreur s\'est produite');
                this.isProcessing = false;
            });
        }
    };

    // Add event listeners
    const form = document.getElementById('paymentForm');
    if (form) {
        const radios = form.querySelectorAll('input[name="payment_method"]');
        radios.forEach(radio => {
            radio.addEventListener('change', (e) => {
                paymentForm.selectedMethod = e.target.value;
            });
        });

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            paymentForm.handlePayment();
        });
    }
</script>
@endsection
