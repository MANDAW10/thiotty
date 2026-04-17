<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected $instanceId;
    protected $token;
    protected $adminPhone;

    public function __construct()
    {
        $this->instanceId = env('WHATSAPP_ULTRAMSG_INSTANCE_ID');
        $this->token = env('WHATSAPP_ULTRAMSG_TOKEN');
        $this->adminPhone = env('ADMIN_PHONE_NUMBER', '221783577431');
    }

    /**
     * Send an automatic WhatsApp notification to the admin via UltraMsg.
     */
    public function sendOrderNotification($order)
    {
        if (empty($this->instanceId) || empty($this->token) || $this->instanceId === 'instanceXXXX') {
            Log::warning('Configuration UltraMsg manquante : le message automatique n\'a pas été envoyé.');
            return false;
        }

        try {
            $itemsText = "";
            foreach($order->items as $item) {
                $productName = $item->product ? $item->product->name : 'Produit supprimé';
                $itemsText .= "- " . $productName . " x " . $item->quantity . " (" . number_format($item->unit_price * $item->quantity, 0, ',', ' ') . " CFA)\n";
            }

            $message = "📦 *NOUVELLE COMMANDE THIOTTY !*\n\n"
                    . "🔖 *Réf:* #" . str_pad($order->id, 5, '0', STR_PAD_LEFT) . "\n"
                    . "👤 *Client:* " . $order->customer_name . "\n"
                    . "📞 *WhatsApp:* " . $order->customer_phone . "\n"
                    . "📍 *Zone:* " . ($order->deliveryZone->name ?? 'N/A') . " (+ " . number_format($order->delivery_fee, 0, ',', ' ') . " CFA)\n"
                    . "🏠 *Adresse:* " . $order->customer_address . "\n\n"
                    . "🛒 *ARTICLES:*\n" . $itemsText . "\n"
                    . "💰 *TOTAL À PAYER: " . number_format($order->total_amount, 0, ',', ' ') . " CFA*\n\n"
                    . "✨ *Mode:* " . strtoupper(str_replace('_', ' ', $order->payment_method)) . "\n"
                    . "🚀 *Statut:* " . ($order->payment_status === 'paid' ? 'Payé' : 'Paiement à la livraison');

            $response = Http::post("https://api.ultramsg.com/{$this->instanceId}/messages/chat", [
                'token' => $this->token,
                'to'    => $this->adminPhone,
                'body'  => $message,
            ]);

            if ($response->successful()) {
                Log::info('Message WhatsApp envoyé avec succès à l\'admin.');
                return true;
            }

            Log::error('Échec de l\'envoi WhatsApp UltraMsg : ' . $response->body());
            return false;

        } catch (\Exception $e) {
            Log::error('Erreur WhatsApp Service : ' . $e->getMessage());
            return false;
        }
    }
}
