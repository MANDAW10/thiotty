# Guide d'Intégration API - Paiements Thiotty

Ce guide montre comment intégrer les passerelles réelles dans le PaymentController.

## 1️⃣ INTÉGRATION STRIPE (Cartes Bancaires)

### Installation
```bash
composer require stripe/stripe-php
```

### Configuration (.env)
```env
STRIPE_PUBLIC_KEY=pk_test_xxxxxxxxxxxxxxxx
STRIPE_SECRET_KEY=sk_test_xxxxxxxxxxxxxxxx
```

### Modification du PaymentController
```php
// Dans processCardPayment()
private function processCardPayment(Request $request, Payment $payment): array
{
    try {
        $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
        
        $token = $request->get('card_token');
        
        $charge = $stripe->charges->create([
            'amount' => (int)($payment->amount * 100), // En centimes
            'currency' => 'xof',
            'source' => $token,
            'description' => 'Commande #' . $payment->order_id,
            'metadata' => [
                'order_id' => $payment->order_id,
                'user_id' => $payment->user_id,
            ]
        ]);
        
        $payment->markAsCompleted($charge->id);
        return ['success' => true];
    } catch (\Stripe\Exception\CardException $e) {
        return ['success' => false, 'error' => $e->getMessage()];
    }
}
```

---

## 2️⃣ INTÉGRATION ORANGE MONEY (Sénégal)

### Configuration (.env)
```env
ORANGE_MONEY_API_URL=https://api.orange.com
ORANGE_MONEY_MERCHANT_ID=your_merchant_id
ORANGE_MONEY_API_KEY=your_api_key
```

### Modification du PaymentController
```php
private function processMobilePayment(Request $request, Payment $payment): array
{
    try {
        $phone = $request->get('phone_number');
        
        $client = new \GuzzleHttp\Client();
        $response = $client->post('https://api.orange.com/payment', [
            'headers' => [
                'Authorization' => 'Bearer ' . config('services.orange_money.api_key'),
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'merchant_id' => config('services.orange_money.merchant_id'),
                'reference' => 'CMD#' . $payment->order_id,
                'amount' => $payment->amount,
                'currency' => 'XOF',
                'customer_phone' => $phone,
                'callback_url' => route('payment.confirm'),
                'description' => 'Commande Thiotty #' . $payment->order_id,
            ]
        ]);
        
        $data = json_decode($response->getBody());
        
        $payment->update([
            'gateway' => 'orange_money',
            'transaction_id' => $data->transaction_id ?? null,
            'metadata' => [
                'phone' => $phone,
                'initiated_at' => now(),
            ]
        ]);
        
        // L'utilisateur recevra un prompt sur son téléphone
        return ['success' => true];
    } catch (\Exception $e) {
        return ['success' => false, 'error' => $e->getMessage()];
    }
}
```

---

## 3️⃣ INTÉGRATION WAVE/WARI (Afrique)

### Configuration (.env)
```env
WAVE_API_URL=https://api.wave.com
WAVE_API_KEY=your_wave_api_key
WAVE_BUSINESS_ID=your_business_id
```

### Modification du PaymentController
```php
private function processMobilePayment(Request $request, Payment $payment): array
{
    try {
        $phone = $request->get('phone_number');
        
        $client = new \GuzzleHttp\Client();
        $response = $client->post(config('services.wave.api_url') . '/graphql', [
            'headers' => [
                'Authorization' => 'Bearer ' . config('services.wave.api_key'),
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'query' => '
                    mutation {
                        paymentRequestSend(input: {
                            businessId: "' . config('services.wave.business_id') . '"
                            amount: ' . $payment->amount . '
                            currency: "XOF"
                            description: "Commande Thiotty #' . $payment->order_id . '"
                            phoneNumber: "' . $phone . '"
                            metadata: {
                                order_id: "' . $payment->order_id . '"
                            }
                        }) {
                            paymentRequest {
                                id
                                status
                            }
                        }
                    }
                '
            ]
        ]);
        
        $data = json_decode($response->getBody());
        
        $payment->update([
            'gateway' => 'wave',
            'transaction_id' => $data->data->paymentRequestSend->paymentRequest->id ?? null,
            'metadata' => ['phone' => $phone]
        ]);
        
        return ['success' => true];
    } catch (\Exception $e) {
        return ['success' => false, 'error' => $e->getMessage()];
    }
}
```

---

## 4️⃣ INTÉGRATION PAYPAL

### Installation
```bash
composer require paypal/paypal-checkout-sdk
```

### Configuration (.env)
```env
PAYPAL_CLIENT_ID=your_client_id
PAYPAL_CLIENT_SECRET=your_client_secret
PAYPAL_MODE=sandbox  # ou 'live' en production
```

### Modification du PaymentController
```php
private function processCardPayment(Request $request, Payment $payment): array
{
    try {
        $environment = new \PayPalCheckoutSdk\Core\SandboxEnvironment(
            config('services.paypal.client_id'),
            config('services.paypal.client_secret')
        );
        
        $client = new \PayPalCheckoutSdk\Core\PayPalHttpClient($environment);
        
        $order = new \PayPalCheckoutSdk\Orders\OrdersCreateRequest();
        $order->headers["prefer"] = "return=representation";
        $order->body = [
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "reference_id" => "cmd_" . $payment->order_id,
                "amount" => [
                    "value" => (string)$payment->amount,
                    "currency_code" => "XOF"
                ]
            ]],
            "application_context" => [
                "cancel_url" => route('payment.show', $payment->order),
                "return_url" => route('payment.confirm'),
                "shipping_preference" => "NO_SHIPPING"
            ]
        ];
        
        $response = $client->execute($order);
        
        $payment->update([
            'gateway' => 'paypal',
            'transaction_id' => $response->result->id,
            'status' => 'processing'
        ]);
        
        return ['success' => true, 'redirect' => $response->result->links[1]->href];
    } catch (\Exception $e) {
        return ['success' => false, 'error' => $e->getMessage()];
    }
}
```

---

## 5️⃣ INTÉGRATION PAYTECH (Sénégal et Afrique)

### Configuration (.env)
```env
PAYTECH_API_URL=https://www.paytech.sn/api/v1/send-money
PAYTECH_API_KEY=your_api_key
PAYTECH_SECRET=your_secret
```

### Modification du PaymentController
```php
private function processMobilePayment(Request $request, Payment $payment): array
{
    try {
        $phone = $request->get('phone_number');
        
        $params = [
            'phone_number' => $phone,
            'amount' => (string)$payment->amount,
            'currency' => 'XOF',
            'description' => 'Commande Thiotty #' . $payment->order_id,
            'customer_name' => $payment->order->customer_name,
            'api_key' => config('services.paytech.api_key'),
            'api_secret' => config('services.paytech.secret'),
            'return_url' => route('payment.confirm'),
            'cancel_url' => route('payment.show', $payment->order),
        ];
        
        $client = new \GuzzleHttp\Client();
        $response = $client->post(config('services.paytech.api_url'), [
            'form_params' => $params
        ]);
        
        $data = json_decode($response->getBody());
        
        $payment->update([
            'gateway' => 'paytech',
            'transaction_id' => $data->token ?? null,
            'status' => 'processing'
        ]);
        
        return ['success' => true, 'redirect' => $data->link ?? null];
    } catch (\Exception $e) {
        return ['success' => false, 'error' => $e->getMessage()];
    }
}
```

---

## 🔗 WEBHOOKS - Recevoir les confirmations

Ajoutez une route webhook dans `routes/web.php`:

```php
Route::post('/webhook/payment', [PaymentController::class, 'webhook'])->name('webhook.payment');
```

Puis dans le PaymentController:

```php
public function webhook(Request $request)
{
    $gateway = $request->get('gateway'); // stripe, orange_money, etc.
    $transactionId = $request->get('transaction_id');
    
    $payment = Payment::where('transaction_id', $transactionId)->first();
    
    if (!$payment) {
        return response()->json(['error' => 'Payment not found'], 404);
    }
    
    // Vérifier la signature (dépends de la passerelle)
    if ($this->verifyWebhookSignature($gateway, $request)) {
        $status = $request->get('status');
        
        if ($status === 'completed' || $status === 'success') {
            $payment->markAsCompleted($transactionId);
        } elseif ($status === 'failed') {
            $payment->markAsFailed('Webhook: ' . $request->get('reason'));
        }
    }
    
    return response()->json(['success' => true]);
}
```

---

## 📧 ENVOI D'EMAILS

Créez une notification:

```bash
php artisan make:notification PaymentConfirmed
```

Puis modifiez le PaymentController:

```php
use App\Notifications\PaymentConfirmed;

// Dans markAsCompleted():
Notification::send($payment->user, new PaymentConfirmed($payment));
```

---

## 💡 CONSEILS

1. **Testez d'abord en sandbox** avant de passer en production
2. **Sécurisez vos clés API** dans .env
3. **Loggez tous les paiements** pour l'audit
4. **Validez les montants** côté serveur
5. **Gérez les erreurs** avec des logs détaillés
6. **Testez les webhooks** avec des outils comme Ngrok ou RequestBin
7. **Cryptez les données sensibles** en base de données (cartes bancaires, tokens)

---

## 🚀 DÉPLOIEMENT

1. Générez les clés de production dans le dashboard de chaque passerelle
2. Configurez les variables d'environnement sur le serveur
3. Testez les webhooks en production
4. Activez les logs de traçabilité
5. Configurez les emails d'alerte pour paiements échoués

---

## 📊 TESTING

```bash
# Test d'une transaction
php artisan tinker

>>> $payment = Payment::first();
>>> $payment->markAsCompleted('TXN_123456');

# Vérifier les logs
tail -f storage/logs/laravel.log
```

---

**Besoin d'aide?** Consultez la documentation officielle de chaque passerelle:
- Stripe: https://stripe.com/docs
- PayPal: https://developer.paypal.com
- Orange Money: https://orangesenegal.com/api
- Wave: https://wave.com/developers
- Paytech: https://www.paytech.sn/docs
