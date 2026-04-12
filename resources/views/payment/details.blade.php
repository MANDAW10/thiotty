@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-12 px-4">
    <div class="max-w-4xl mx-auto">
        <!-- Back Link -->
        <a href="{{ route('payment.history') }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-medium mb-6">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Retour à l'historique
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Payment Status Card -->
                <div class="bg-white rounded-lg shadow-md p-8 mb-6">
                    <div class="flex items-start justify-between mb-6 pb-6 border-b border-slate-200">
                        <div>
                            <h1 class="text-3xl font-bold text-slate-900">Paiement #{{ $payment->id }}</h1>
                            <p class="text-slate-600 mt-1">Commande #{{ $payment->order_id }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-4xl font-bold text-slate-900">{{ number_format($payment->amount, 2) }} FCFA</p>
                            <p class="text-slate-600 text-sm mt-1">{{ $payment->created_at->format('d/m/Y à H:i') }}</p>
                        </div>
                    </div>

                    <!-- Status Section -->
                    <div class="mb-8">
                        <h2 class="text-lg font-semibold text-slate-900 mb-4">Statut du paiement</h2>
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-12 h-12 rounded-full @switch($payment->status)
                                @case('completed')
                                    bg-green-100
                                @break
                                @case('processing')
                                    bg-yellow-100
                                @break
                                @case('failed')
                                    bg-red-100
                                @break
                                @default
                                    bg-slate-100
                            @endswitch flex items-center justify-center">
                                @switch($payment->status)
                                    @case('completed')
                                        <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"/>
                                        </svg>
                                    @break
                                    @case('processing')
                                        <svg class="w-6 h-6 text-yellow-600 animate-spin" fill="currentColor" viewBox="0 0 24 24">
                                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"/>
                                        </svg>
                                    @break
                                    @case('failed')
                                        <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"/>
                                        </svg>
                                    @break
                                    @default
                                        <svg class="w-6 h-6 text-slate-600" fill="currentColor" viewBox="0 0 24 24">
                                            <circle cx="12" cy="12" r="1"/>
                                        </svg>
                                @endswitch
                            </div>
                            <div>
                                <p class="text-lg font-semibold text-slate-900">
                                    @switch($payment->status)
                                        @case('completed')
                                            Paiement effectué
                                        @break
                                        @case('processing')
                                            Traitement en cours
                                        @break
                                        @case('failed')
                                            Paiement échoué
                                        @break
                                        @case('pending')
                                            Paiement en attente
                                        @break
                                        @case('cancelled')
                                            Paiement annulé
                                        @break
                                    @endswitch
                                </p>
                                <p class="text-slate-600 text-sm">
                                    @if($payment->processed_at)
                                        Traité le {{ $payment->processed_at->format('d/m/Y à H:i') }}
                                    @else
                                        Initié le {{ $payment->created_at->format('d/m/Y à H:i') }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Details -->
                    <div class="mb-8">
                        <h2 class="text-lg font-semibold text-slate-900 mb-4">Détails du paiement</h2>
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm text-slate-500 mb-1">Méthode de paiement</p>
                                <p class="text-base font-semibold text-slate-900">
                                    @switch($payment->payment_method)
                                        @case('card')
                                            Carte bancaire
                                        @break
                                        @case('mobile')
                                            Portefeuille mobile
                                        @break
                                        @case('bank')
                                            Virement bancaire
                                        @break
                                        @case('cash')
                                            Paiement à la livraison
                                        @break
                                    @endswitch
                                </p>
                            </div>
                            @if($payment->gateway)
                                <div>
                                    <p class="text-sm text-slate-500 mb-1">Passerelle</p>
                                    <p class="text-base font-semibold text-slate-900 capitalize">{{ str_replace('_', ' ', $payment->gateway) }}</p>
                                </div>
                            @endif
                            @if($payment->transaction_id)
                                <div>
                                    <p class="text-sm text-slate-500 mb-1">ID de transaction</p>
                                    <p class="text-base font-mono text-slate-900 break-all">{{ $payment->transaction_id }}</p>
                                </div>
                            @endif
                            <div>
                                <p class="text-sm text-slate-500 mb-1">Montant</p>
                                <p class="text-base font-semibold text-slate-900">{{ number_format($payment->amount, 2) }} FCFA</p>
                            </div>
                        </div>
                    </div>

                    <!-- Metadata if available -->
                    @if($payment->metadata && count($payment->metadata) > 0)
                        <div>
                            <h2 class="text-lg font-semibold text-slate-900 mb-4">Informations supplémentaires</h2>
                            <div class="bg-slate-50 rounded-lg p-4 space-y-2">
                                @foreach($payment->metadata as $key => $value)
                                    <div class="flex justify-between">
                                        <span class="text-slate-600 capitalize">{{ str_replace('_', ' ', $key) }}:</span>
                                        <span class="text-slate-900 font-medium">{{ is_array($value) ? json_encode($value) : $value }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Order Item Card -->
                <div class="bg-white rounded-lg shadow-md p-8">
                    <h2 class="text-lg font-semibold text-slate-900 mb-4">Commande associée</h2>
                    <div class="space-y-3">
                        @foreach($payment->order->items as $item)
                            <div class="flex justify-between items-start p-3 bg-slate-50 rounded-lg">
                                <div class="flex-1">
                                    <p class="font-medium text-slate-900">{{ $item->product->name }}</p>
                                    <p class="text-sm text-slate-500">Quantité: {{ $item->quantity }}</p>
                                </div>
                                <p class="font-semibold text-slate-900">{{ number_format($item->price * $item->quantity, 2) }} FCFA</p>
                            </div>
                        @endforeach
                    </div>

                    <!-- Order Summary -->
                    <div class="mt-6 pt-6 border-t border-slate-200 space-y-2">
                        <div class="flex justify-between text-slate-600">
                            <span>Sous-total</span>
                            <span>{{ number_format($payment->amount - $payment->order->delivery_fee, 2) }} FCFA</span>
                        </div>
                        @if($payment->order->delivery_fee > 0)
                            <div class="flex justify-between text-slate-600">
                                <span>Frais de livraison</span>
                                <span>{{ number_format($payment->order->delivery_fee, 2) }} FCFA</span>
                            </div>
                        @endif
                        <div class="flex justify-between font-bold text-lg text-slate-900 pt-3">
                            <span>Total</span>
                            <span>{{ number_format($payment->amount, 2) }} FCFA</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Order Info Card -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Commande</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-slate-500 mb-1">Numéro</p>
                            <a href="{{ route('orders.show', $payment->order) }}" class="text-blue-600 hover:text-blue-700 font-semibold">
                                #{{ $payment->order_id }}
                            </a>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 mb-1">Statut</p>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700 capitalize">
                                {{ str_replace('_', ' ', $payment->order->status) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 mb-1">Date</p>
                            <p class="font-medium text-slate-900">{{ $payment->order->created_at->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Delivery Info Card -->
                @if($payment->order->deliveryZone)
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold text-slate-900 mb-4">Livraison</h3>
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm text-slate-500 mb-1">Adresse</p>
                                <p class="text-slate-900">{{ $payment->order->customer_address }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-slate-500 mb-1">Zone</p>
                                <p class="font-medium text-slate-900">{{ $payment->order->deliveryZone->name }}</p>
                            </div>
                            @if($payment->order->shipped_at)
                                <div>
                                    <p class="text-sm text-slate-500 mb-1">Expédié le</p>
                                    <p class="font-medium text-slate-900">{{ $payment->order->shipped_at->format('d/m/Y à H:i') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Contact Info Card -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Contact</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-slate-500 mb-1">Nom</p>
                            <p class="font-medium text-slate-900">{{ $payment->order->customer_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 mb-1">Téléphone</p>
                            <a href="tel:{{ $payment->order->customer_phone }}" class="text-blue-600 hover:text-blue-700 font-medium">
                                {{ $payment->order->customer_phone }}
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Actions</h3>
                    <div class="space-y-2">
                        <a href="{{ route('orders.show', $payment->order) }}" class="block text-center bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                            Voir la commande
                        </a>
                        <button onclick="window.print()" class="w-full text-center bg-slate-200 hover:bg-slate-300 text-slate-900 font-medium py-2 px-4 rounded-lg transition-colors">
                            Imprimer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .hidden-print {
            display: none;
        }
    }
</style>
@endsection
