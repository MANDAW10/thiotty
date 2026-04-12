@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-12 px-4">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-slate-900 mb-2">Historique des paiements</h1>
            <p class="text-slate-600">Suivi de tous vos paiements et transactions</p>
        </div>

        @if($payments->count() > 0)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-slate-900">Commande</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-slate-900">Montant</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-slate-900">Méthode</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-slate-900">Statut</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-slate-900">Date</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-slate-900">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @foreach($payments as $payment)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4 text-sm text-slate-900 font-medium">
                                        <a href="{{ route('orders.show', $payment->order) }}" class="text-blue-600 hover:text-blue-700">
                                            #{{ $payment->order_id }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-semibold text-slate-900">
                                        {{ number_format($payment->amount, 2) }} FCFA
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-600">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium @switch($payment->payment_method)
                                            @case('card')
                                                bg-blue-100 text-blue-700
                                            @break
                                            @case('mobile')
                                                bg-green-100 text-green-700
                                            @break
                                            @case('bank')
                                                bg-purple-100 text-purple-700
                                            @break
                                            @case('cash')
                                                bg-amber-100 text-amber-700
                                            @break
                                            @default
                                                bg-slate-100 text-slate-700
                                        @endswitch">
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
                                                    À la livraison
                                                @break
                                            @endswitch
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium @switch($payment->status)
                                            @case('completed')
                                                bg-green-100 text-green-700
                                            @break
                                            @case('processing')
                                                bg-yellow-100 text-yellow-700
                                            @break
                                            @case('failed')
                                                bg-red-100 text-red-700
                                            @break
                                            @case('pending')
                                                bg-slate-100 text-slate-700
                                            @break
                                            @case('cancelled')
                                                bg-slate-200 text-slate-700
                                            @break
                                        @endswitch">
                                            <span class="inline-block w-2 h-2 rounded-full @switch($payment->status)
                                                @case('completed')
                                                    bg-green-500
                                                @break
                                                @case('processing')
                                                    bg-yellow-500
                                                @break
                                                @case('failed')
                                                    bg-red-500
                                                @break
                                                @default
                                                    bg-slate-400
                                            @endswitch"></span>
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
                                                @case('pending')
                                                    En attente
                                                @break
                                                @case('cancelled')
                                                    Annulé
                                                @break
                                            @endswitch
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-600">
                                        {{ $payment->created_at->format('d/m/Y à H:i') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <a href="{{ route('payment.details', $payment) }}" class="text-blue-600 hover:text-blue-700 font-medium">
                                            Détails
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-200">
                    {{ $payments->links() }}
                </div>
            </div>
        @else
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <p class="text-slate-600 text-lg mb-2">Aucun paiement encore</p>
                <p class="text-slate-500 mb-6">Vous n'avez pas encore effectué de paiement</p>
                <a href="{{ route('home') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition-colors">
                    Continuer vos achats
                </a>
            </div>
        @endif
    </div>
</div>

<style>
    .prose {
        @apply text-sm text-slate-600;
    }
</style>
@endsection
