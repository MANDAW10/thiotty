<?php

namespace App\Http\Controllers;

use App\Mail\NewOrderNotification;
use App\Models\CartItem;
use App\Models\DeliveryZone;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Services\CartService;
use App\Services\TelegramService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function index(CartService $cartService)
    {
        $cart = $cartService->getItems();
        if (empty($cart)) {
            return redirect()->route('shop.index')->with('error', 'Votre panier est vide.');
        }

        $deliveryZones = DeliveryZone::all();
        $subtotal = array_sum(array_map(fn ($item) => $item['price'] * $item['quantity'], $cart));

        return view('checkout.index', compact('cart', 'deliveryZones', 'subtotal'));
    }

    public function store(Request $request, CartService $cartService)
    {
        $request->validate([
            'customer_name' => 'required|string',
            'customer_phone' => 'required|string',
            'customer_address' => 'required|string',
            'delivery_zone_id' => 'required|exists:delivery_zones,id',
            'payment_method' => 'required|in:cash,wave',
        ]);

        $cart = $cartService->getItems();
        if (empty($cart)) {
            return redirect()->route('shop.index');
        }

        // Check stock before proceeding
        foreach ($cart as $id => $details) {
            $product = \App\Models\Product::find($id);
            if (!$product || $product->stock < $details['quantity']) {
                $productName = $product ? $product->name : 'Un produit';
                return back()->with('error', "Stock insuffisant pour : {$productName}. Veuillez réduire la quantité.");
            }
        }

        $deliveryZone = DeliveryZone::find($request->delivery_zone_id);
        $subtotal = array_sum(array_map(fn ($item) => $item['price'] * $item['quantity'], $cart));
        $total = $subtotal + $deliveryZone->fee;

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => auth()->id(),
                'delivery_zone_id' => $deliveryZone->id,
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_address' => $request->customer_address,
                'total_amount' => $total,
                'delivery_fee' => $deliveryZone->fee,
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
            ]);

            foreach ($cart as $id => $details) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'quantity' => $details['quantity'],
                    'unit_price' => $details['price'],
                ]);

                \App\Models\Product::where('id', $id)->decrement('stock', $details['quantity']);
            }

            Payment::create([
                'order_id' => $order->id,
                'user_id' => auth()->id(),
                'amount' => $total,
                'payment_method' => $request->payment_method,
                'status' => 'pending',
            ]);

            DB::commit();

            // Envoi e-mail de notification admin pour toute nouvelle commande
            try {
                $order->load(['items.product', 'deliveryZone']);
                Mail::to('mandawdieng10@gmail.com')->send(new NewOrderNotification($order));
            } catch (\Exception $e) {
                Log::error('Erreur e-mail notification commande: ' . $e->getMessage());
            }

            // Si c'est en espèces (Paiement à la livraison), on confirme la commande immédiatement
            if ($request->payment_method === 'cash') {
                Session::forget('cart');
                if (auth()->check()) {
                    CartItem::where('user_id', auth()->id())->delete();
                }

                try {
                    $telegram = new \App\Services\TelegramService;
                    $telegram->sendOrderNotification($order);
                } catch (\Exception $e) {
                    Log::error('Erreur lors de l\'envoi de la notification Telegram: '.$e->getMessage());
                }

                return redirect()->route('order.confirmation', $order)->with('success', 'Commande passée avec succès ! Payer à la livraison.');
            }

            // Pour Wave et autres paiements, on redirige vers le paiement
            return redirect()->route('payment.show', $order)->with('info', 'Veuillez procéder au paiement pour valider votre commande.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Erreur lors de la commande : '.$e->getMessage());
        }
    }

    public function confirmation(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load(['items.product', 'deliveryZone']);

        // Generate WhatsApp message
        $itemsText = '';
        foreach ($order->items as $item) {
            $productName = $item->product ? $item->product->name : 'Produit supprimé';
            $itemsText .= '- '.$productName.' x '.$item->quantity.' ('.number_format($item->unit_price * $item->quantity, 0, ',', ' ')." CFA)\n";
        }

        $statusLine = $order->payment_status === 'paid'
            ? 'Payé / confirmé'
            : ($order->payment_method === 'cash' ? 'Paiement à la livraison' : 'Paiement en attente de confirmation');

        $message = "📦 *NOUVELLE COMMANDE THIOTTY !*\n\n"
                 .'🔖 *Réf:* #'.str_pad($order->id, 5, '0', STR_PAD_LEFT)."\n"
                 .'👤 *Client:* '.$order->customer_name."\n"
                 .'📞 *WhatsApp:* '.$order->customer_phone."\n"
                 .'📍 *Zone:* '.$order->deliveryZone->name.' (+ '.number_format($order->delivery_fee, 0, ',', ' ')." CFA)\n"
                 .'🏠 *Adresse:* '.$order->customer_address."\n\n"
                 ."🛒 *ARTICLES:*\n".$itemsText."\n"
                 .'💰 *TOTAL À PAYER: '.number_format($order->total_amount, 0, ',', ' ')." CFA*\n\n"
                 .'✨ *Mode:* '.strtoupper(str_replace('_', ' ', $order->payment_method))."\n"
                 .'🚀 *Statut:* '.$statusLine;

        $whatsappUrl = 'https://wa.me/221783577431?text='.urlencode($message);

        return view('checkout.confirmation', compact('order', 'whatsappUrl'));
    }

    public function history()
    {
        $orders = auth()->user()->orders()->latest()->get();

        return view('orders.history', compact('orders'));
    }
}
