<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Afficher le formulaire de paiement pour une commande
     */
    public function show(Order $order)
    {
        // Vérifier que l'utilisateur est propriétaire de la commande
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Récupérer les paiements précédents s'ils existent
        $payment = $order->payment;

        return view('payment.show', compact('order', 'payment'));
    }

    /**
     * Initier un paiement
     */
    public function initiate(Request $request, Order $order)
    {
        // Vérifier l'authentification
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        // Vérifier que l'utilisateur est propriétaire
        if ($order->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Valider les données
        $validated = $request->validate([
            'payment_method' => 'required|in:card,mobile,bank,cash',
            'amount' => 'required|numeric|min:0.01',
        ]);

        // Vérifier que le montant correspond à la commande
        if ((float) $validated['amount'] !== (float) $order->total_amount) {
            return response()->json([
                'error' => 'Le montant ne correspond pas à la commande'
            ], 422);
        }

        // Créer ou mettre à jour le paiement
        $payment = Payment::updateOrCreate(
            [
                'order_id' => $order->id,
                'user_id' => Auth::id(),
            ],
            [
                'amount' => $validated['amount'],
                'payment_method' => $validated['payment_method'],
                'status' => 'pending',
            ]
        );

        $payment->markAsProcessing();

        return response()->json([
            'success' => true,
            'payment' => $payment,
            'message' => 'Paiement initialisé avec succès',
        ]);
    }

    /**
     * Traiter le paiement via une passerelle (Stripe, PayPal, etc.)
     */
    public function process(Request $request, Order $order)
    {
        if (!Auth::check() || $order->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $payment = $order->payment;
        if (!$payment) {
            return response()->json(['error' => 'Payment not found'], 404);
        }

        try {
            // Ici, vous intégrerez votre passerelle de paiement
            // Exemple : Stripe, PayPal, Orange Money, Wave, etc.

            $paymentMethod = $request->get('payment_method', 'card');

            switch ($paymentMethod) {
                case 'card':
                    $result = $this->processCardPayment($request, $payment);
                    break;
                case 'mobile':
                    $result = $this->processMobilePayment($request, $payment);
                    break;
                case 'bank':
                    $result = $this->processBankPayment($request, $payment);
                    break;
                case 'cash':
                    $result = $this->processCashPayment($payment);
                    break;
                default:
                    return response()->json(['error' => 'Invalid payment method'], 422);
            }

            if ($result['success']) {
                return response()->json([
                    'success' => true,
                    'payment' => $payment->refresh(),
                    'message' => 'Paiement traité avec succès',
                    'redirect' => route('order.confirmation', $order),
                ]);
            } else {
                $payment->markAsFailed($result['error'] ?? 'Payment processing failed');
                return response()->json([
                    'success' => false,
                    'error' => $result['error'] ?? 'Erreur lors du traitement du paiement',
                ], 422);
            }
        } catch (\Exception $e) {
            Log::error('Payment error: ' . $e->getMessage());
            $payment->markAsFailed($e->getMessage());

            return response()->json([
                'success' => false,
                'error' => 'Une erreur s\'est produite lors du traitement du paiement',
            ], 500);
        }
    }

    /**
     * Paiement par carte bancaire (simulé ou via Stripe)
     */
    private function processCardPayment(Request $request, Payment $payment): array
    {
        $request->validate([
            'card_token' => 'required|string',
        ]);

        try {
            // TODO: Intégrer Stripe ou autre passerelle
            // Pour maintenant, on simule un succès

            $payment->markAsCompleted('card_' . uniqid());
            return ['success' => true];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Paiement mobile (Orange Money, Wave, etc.)
     */
    private function processMobilePayment(Request $request, Payment $payment): array
    {
        $request->validate([
            'phone_number' => 'required|string',
        ]);

        try {
            // TODO: Intégrer Orange Money API, Wave API, etc.
            // Pour maintenant, on marque comme en traitement

            $payment->update([
                'gateway' => 'mobile_money',
                'metadata' => [
                    'phone' => $request->get('phone_number'),
                    'initiated_at' => now(),
                ]
            ]);

            return ['success' => true];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Paiement par virement bancaire
     */
    private function processBankPayment(Request $request, Payment $payment): array
    {
        try {
            // Le paiement par virement nécessite une vérification manuelle
            $payment->update([
                'status' => 'pending',
                'gateway' => 'bank_transfer',
                'metadata' => [
                    'awaiting_verification' => true,
                    'initiated_at' => now(),
                ]
            ]);

            return ['success' => true];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Paiement en espèces (à la livraison)
     */
    private function processCashPayment(Payment $payment): array
    {
        try {
            // Pour le paiement en espèces, on marque comme en attente de livraison
            $payment->update([
                'status' => 'pending',
                'gateway' => 'cash_on_delivery',
            ]);

            $payment->order->update([
                'payment_status' => 'pending',
                'status' => 'awaiting_payment',
            ]);

            return ['success' => true];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Confirmer le paiement (webhook depuis la passerelle)
     */
    public function confirm(Request $request)
    {
        $transactionId = $request->get('transaction_id');

        if (!$transactionId) {
            return response()->json(['error' => 'Transaction ID required'], 422);
        }

        $payment = Payment::where('transaction_id', $transactionId)->first();

        if (!$payment) {
            return response()->json(['error' => 'Payment not found'], 404);
        }

        $payment->markAsCompleted($transactionId);

        return response()->json([
            'success' => true,
            'payment' => $payment,
            'order' => $payment->order,
        ]);
    }

    /**
     * Annuler un paiement
     */
    public function cancel(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $payment = $order->payment;

        if ($payment && !$payment->isCompleted()) {
            $payment->update(['status' => 'cancelled']);
            $order->update(['payment_status' => 'cancelled']);
        }

        return redirect()->route('orders.show', $order)
            ->with('message', 'Paiement annulé');
    }

    /**
     * Afficher l'historique des paiements de l'utilisateur
     */
    public function history()
    {
        $payments = Auth::user()->payments()
            ->with('order')
            ->latest()
            ->paginate(15);

        return view('payment.history', compact('payments'));
    }

    /**
     * Afficher les détails d'un paiement
     */
    public function details(Payment $payment)
    {
        if ($payment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return view('payment.details', compact('payment'));
    }
}
