<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    protected $botToken;
    protected $chatId;

    public function __construct()
    {
        $this->botToken = config('services.telegram.token');
        $this->chatId = config('services.telegram.chat_id');
    }

    /**
     * Envoyer une notification automatique sur Telegram pour une nouvelle commande.
     */
    public function sendOrderNotification($order)
    {
        if (empty($this->botToken) || empty($this->chatId)) {
            Log::warning('Configuration Telegram manquante : le message automatique n\'a pas été envoyé.');
            return false;
        }

        try {
            $itemsText = "";
            foreach($order->items as $item) {
                // Ensure product name is bold and price is formatted
                $itemsText .= "• <b>" . ($item->product->name ?? 'Produit') . "</b> x" . $item->quantity . " (<code>" . number_format($item->unit_price * $item->quantity, 0, ',', ' ') . " XOF</code>)\n";
            }

            // Message formaté en HTML pour Telegram
            $message = "📦 <b>NOUVELLE COMMANDE - THIOTTY !</b>\n\n"
                    . "🔖 <b>Réf:</b> <code>#" . str_pad($order->id, 5, '0', STR_PAD_LEFT) . "</code>\n"
                    . "👤 <b>Client:</b> " . $order->customer_name . "\n"
                    . "📞 <b>WhatsApp:</b> <a href='https://wa.me/" . preg_replace('/[^0-9]/', '', $order->customer_phone) . "'>" . $order->customer_phone . "</a>\n"
                    . "📍 <b>Zone:</b> " . ($order->deliveryZone->name ?? 'N/A') . " (<code>+" . number_format($order->delivery_fee, 0, ',', ' ') . " CFA</code>)\n"
                    . "🏠 <b>Adresse:</b> " . $order->customer_address . "\n\n"
                    . "🛒 <b>ARTICLES:</b>\n" . $itemsText . "\n"
                    . "💰 <b>TOTAL À RÉCUPÉRER: " . number_format($order->total_amount, 0, ',', ' ') . " XOF</b>\n\n"
                    . "✨ <b>Mode:</b> " . strtoupper(str_replace('_', ' ', $order->payment_method)) . "\n"
                    . "🚀 <b>Statut:</b> " . ($order->payment_status === 'paid' ? 'Payé ✅' : 'Paiement à la livraison 🚛');

            $response = Http::post("https://api.telegram.org/bot{$this->botToken}/sendMessage", [
                'chat_id' => $this->chatId,
                'text'    => $message,
                'parse_mode' => 'HTML',
                'disable_web_page_preview' => true,
            ]);

            if ($response->successful()) {
                Log::info('Message Telegram envoyé avec succès à l\'admin.');
                return true;
            }

            Log::error('Échec de l\'envoi Telegram : ' . $response->body());
            return false;

        } catch (\Exception $e) {
            Log::error('Erreur Telegram Service : ' . $e->getMessage());
            return false;
        }
    }
}
