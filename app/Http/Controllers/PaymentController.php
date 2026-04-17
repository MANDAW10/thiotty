<?php

namespace App\Http\Controllers;

use App\Mail\OtpVerificationMail;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    /**
     * Afficher le formulaire de paiement pour une commande
     */
    public function show(Order $order)
    {
        // Vérifier que l'utilisateur est propriétaire de la commande
        if ($order->user_id != Auth::id()) {
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
        if ($order->user_id != Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Valider les données
        $validated = $request->validate([
            'payment_method' => 'required|in:card,mobile,bank,cash,wave',
            'amount' => 'required|numeric|min:0.01',
        ]);

        // Vérifier que le montant correspond à la commande (évite les écarts de précision flottante)
        if (round((float) $validated['amount'], 2) !== round((float) $order->total_amount, 2)) {
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
        if (!Auth::check() || $order->user_id != Auth::id()) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
            abort(403, 'Unauthorized');
        }

        $payment = $order->payment;
        if (!$payment) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Payment not found'], 404);
            }

            return back()->with('error', 'Aucun paiement associé à cette commande.');
        }

        try {
            // Ici, vous intégrerez votre passerelle de paiement
            // Exemple : Stripe, PayPal, Orange Money, Wave, etc.

            $paymentMethod = $request->get('payment_method', 'card');

            switch ($paymentMethod) {
                case 'card':
                    $result = $this->processCardPayment($request, $payment);
                    break;
                case 'wave':
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
                    if ($request->wantsJson()) {
                        return response()->json(['error' => 'Invalid payment method'], 422);
                    }

                    return back()->with('error', 'Mode de paiement non pris en charge.');
            }

            if ($result['success']) {
                if (!empty($result['require_otp'])) {
                    // Si une validation OTP Thiotty est requise, on redirige directement SANS confirmer la commande.
                    return redirect($result['redirect']);
                }

                // IMPORTANT SÉCURITÉ: Vider le panier et valider la commande (Telegram) SEULEMENT APRÈS soumission de la preuve de paiement.
                \Illuminate\Support\Facades\Session::forget('cart');
                if (\Illuminate\Support\Facades\Auth::check()) {
                    \App\Models\CartItem::where('user_id', \Illuminate\Support\Facades\Auth::id())->delete();
                }

                try {
                    $order->load(['items.product', 'deliveryZone']);
                    $telegram = new \App\Services\TelegramService;
                    $telegram->sendOrderNotification($order);
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Erreur lors de l\'envoi de la notification Telegram Post-Paiement: '.$e->getMessage());
                }

                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => true,
                        'payment' => $payment->refresh(),
                        'message' => 'Paiement traité avec succès',
                        'redirect' => $result['redirect'] ?? route('order.confirmation', $order),
                    ]);
                }
                
                if (isset($result['redirect']) && substr($result['redirect'], 0, 4) === 'http') {
                    // Redirection externe (Wave officielle si existante)
                    return redirect()->away($result['redirect']);
                }
                
                return redirect()->route('order.confirmation', $order)->with('success', 'Paiement soumis avec succès. Votre commande est en cours de validation.');
            } else {
                $payment->markAsFailed($result['error'] ?? 'Payment processing failed');
                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'error' => $result['error'] ?? 'Erreur lors du traitement du paiement',
                    ], 422);
                }
                return back()->with('error', $result['error'] ?? 'Erreur lors du traitement du paiement');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Payment error: ' . $e->getMessage());
            $payment->markAsFailed($e->getMessage());

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Une erreur s\'est produite lors du traitement du paiement',
                ], 500);
            }
            return back()->with('error', 'Une erreur s\'est produite lors du traitement du paiement');
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
     * Paiement Wave manuel : enregistre l'ID, génère un OTP et l'envoie par email
     */
    private function processMobilePayment(Request $request, Payment $payment): array
    {
        $request->validate([
            'wave_transaction_id' => 'required|string|min:4',
        ]);

        try {
            $transactionId = $request->input('wave_transaction_id');
            $order = $payment->order;

            // 1. Générer et stocker l'OTP
            $otpCode   = (string) rand(100000, 999999);
            $otpExpiry = now()->addMinutes(10)->toISOString();

            $payment->update([
                'gateway'        => 'wave_manual',
                'transaction_id' => $transactionId,
                'status'         => 'pending_otp',
                'metadata'       => array_merge((array) ($payment->metadata ?? []), [
                    'thiotty_otp'    => $otpCode,
                    'otp_expires_at' => $otpExpiry,
                    'submitted_at'   => now()->toISOString(),
                ]),
            ]);

            // 2. Envoyer l'OTP par email
            $order->load('user');
            $userEmail = $order->user->email
                      ?? Auth::user()->email
                      ?? null;

            if ($userEmail) {
                try {
                    Mail::to($userEmail)->send(new OtpVerificationMail(
                        $otpCode,
                        str_pad($order->id, 5, '0', STR_PAD_LEFT),
                        $order->customer_name
                    ));
                    Log::info("[OTP Wave] Code envoyé avec succès à {$userEmail} pour commande #{$order->id}");
                } catch (\Exception $e) {
                    Log::error('[OTP Wave] ÉCHEC envoi email : ' . $e->getMessage());
                }
            }

            // 3. Rediriger vers la page de saisie OTP (require_otp = true empêche de vider le panier)
            return [
                'success'     => true,
                'require_otp' => true,
                'redirect'    => route('payment.otp', $order),
            ];

        } catch (\Exception $e) {
            Log::error('Wave manual error: ' . $e->getMessage());
            return ['success' => false, 'error' => 'Erreur lors de la soumission de la preuve de paiement.'];
        }
    }

    /**
     * Callback automatique Wave → Génère et envoie l'OTP par email
     */
    public function waveCallback(Request $request, Payment $payment)
    {
        // Vérifier que l'utilisateur est bien le propriétaire
        if (!Auth::check() || $payment->user_id !== Auth::id()) {
            abort(403, 'Accès non autorisé.');
        }

        $order = $payment->order;

        // Si déjà validé, aller directement à la confirmation
        if ($payment->status === 'completed') {
            return redirect()->route('order.confirmation', $order)->with('success', 'Votre commande est déjà confirmée !');
        }

        // Générer le code OTP Thiotty
        $otpCode  = (string) rand(100000, 999999);
        $otpExpiry = now()->addMinutes(10)->toISOString();

        // Enregistrer l'OTP dans les métadonnées du paiement
        $payment->update([
            'status'   => 'pending_otp',
            'gateway'  => 'wave_auto',
            'metadata' => array_merge((array) ($payment->metadata ?? []), [
                'thiotty_otp'    => $otpCode,
                'otp_expires_at' => $otpExpiry,
                'wave_callback_at' => now()->toISOString(),
            ]),
        ]);

        $order->update(['payment_status' => 'pending', 'status' => 'pending']);

        // Envoyer l'OTP par email automatiquement - récupération robuste
        $order->load('user');
        $userEmail = $order->user->email
                  ?? Auth::user()->email
                  ?? null;

        Log::info("[OTP Callback] Commande #{$order->id} | email : " . ($userEmail ?? 'AUCUN'));

        if ($userEmail) {
            try {
                Mail::to($userEmail)->send(new OtpVerificationMail(
                    $otpCode,
                    str_pad($order->id, 5, '0', STR_PAD_LEFT),
                    $order->customer_name
                ));
                Log::info("[OTP Callback] Code envoyé avec succès à {$userEmail} pour commande #{$order->id}");
            } catch (\Exception $e) {
                Log::error("[OTP Callback] ÉCHEC envoi email : " . $e->getMessage());
            }
        } else {
            Log::warning("[OTP Callback] AUCUN email trouvé pour commande #{$order->id}.");
        }

        // Rediriger vers la page de saisie du code OTP
        return redirect()->route('payment.otp', $order)
            ->with('success', '✅ Paiement Wave reçu ! Un code de validation a été envoyé à votre adresse email.');
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
        if ($order->user_id != Auth::id()) {
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
        if ($payment->user_id != Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return view('payment.details', compact('payment'));
    }

    /**
     * Interface de saisie OTP
     */
    public function otpShow(Order $order)
    {
        if ($order->user_id != Auth::id()) abort(403);
        $payment = $order->payment;
        if (!$payment || $payment->status !== 'pending_otp') {
            return redirect()->route('orders.show', $order);
        }

        return view('payment.otp', compact('order', 'payment'));
    }

    /**
     * Vérification de l'OTP
     */
    public function otpVerify(Request $request, Order $order)
    {
        if ($order->user_id != Auth::id()) abort(403);
        $payment = $order->payment;
        if (!$payment || $payment->status !== 'pending_otp') {
            return redirect()->route('orders.show', $order);
        }

        $request->validate(['otp_code' => 'required|string']);
        $metadata = $payment->metadata ?? [];
        $expectedOtp  = $metadata['thiotty_otp'] ?? null;
        $otpExpiresAt = $metadata['otp_expires_at'] ?? null;

        // Vérification de l'expiration (10 minutes)
        if ($otpExpiresAt && now()->isAfter($otpExpiresAt)) {
            return back()->with('error', 'Ce code a expiré. Veuillez recommencer le processus de paiement.');
        }

        if (!$expectedOtp || $request->input('otp_code') !== $expectedOtp) {
            return back()->with('error', 'Le code de validation est incorrect. Veuillez vérifier votre email.');
        }

        // OTP vérifié : marquer le paiement comme complété (commande payée + confirmée, aligné avec le reste de l'app)
        $txnId = $payment->transaction_id ?: ('wave_otp_'.$order->id);
        $payment->markAsCompleted($txnId);
        $order->refresh();

        \Illuminate\Support\Facades\Session::forget('cart');
        if (\Illuminate\Support\Facades\Auth::check()) {
            \App\Models\CartItem::where('user_id', \Illuminate\Support\Facades\Auth::id())->delete();
        }

        try {
            $order->load(['items.product', 'deliveryZone']);
            $telegram = new \App\Services\TelegramService;
            $telegram->sendOrderNotification($order);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Erreur Telegram après OTP: '.$e->getMessage());
        }

        return redirect()->route('order.confirmation', $order)->with('success', 'Paiement vérifié avec succès. Votre commande est validée.');
    }
}
