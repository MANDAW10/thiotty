<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\DeliveryZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
        if (empty($cart)) return redirect()->route('shop.index')->with('error', 'Votre panier est vide.');

        $deliveryZones = DeliveryZone::all();
        $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));

        return view('checkout.index', compact('cart', 'deliveryZones', 'subtotal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string',
            'customer_phone' => 'required|string',
            'customer_address' => 'required|string',
            'delivery_zone_id' => 'required|exists:delivery_zones,id',
            'payment_method' => 'required|in:cash,wave,orange_money',
        ]);

        $cart = Session::get('cart', []);
        if (empty($cart)) return redirect()->route('shop.index');

        $deliveryZone = DeliveryZone::find($request->delivery_zone_id);
        $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
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
            }

            DB::commit();
            Session::forget('cart');

            return redirect()->route('order.confirmation', $order)->with('success', 'Commande passée avec succès !');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de la commande : ' . $e->getMessage());
        }
    }

    public function confirmation(Order $order)
    {
        $order->load(['items.product', 'deliveryZone']);
        
        // Generate WhatsApp message
        $itemsText = "";
        foreach($order->items as $item) {
            $itemsText .= "- " . $item->product->name . " x " . $item->quantity . " (" . number_format($item->unit_price * $item->quantity, 0, ',', ' ') . " CFA)\n";
        }

        $message = "📦 *NOUVELLE COMMANDE THIOTTY !*\n\n"
                 . "🔖 *Réf:* #" . str_pad($order->id, 5, '0', STR_PAD_LEFT) . "\n"
                 . "👤 *Client:* " . $order->customer_name . "\n"
                 . "📞 *WhatsApp:* " . $order->customer_phone . "\n"
                 . "📍 *Zone:* " . $order->deliveryZone->name . " (+ " . number_format($order->delivery_fee, 0, ',', ' ') . " CFA)\n"
                 . "🏠 *Adresse:* " . $order->customer_address . "\n\n"
                 . "🛒 *ARTICLES:*\n" . $itemsText . "\n"
                 . "💰 *TOTAL À PAYER: " . number_format($order->total_amount, 0, ',', ' ') . " CFA*\n\n"
                 . "✨ *Mode:* " . strtoupper(str_replace('_', ' ', $order->payment_method)) . "\n"
                 . "🚀 *Statut:* Paiement à la livraison";

        $whatsappUrl = "https://wa.me/221783577431?text=" . urlencode($message);

        return view('checkout.confirmation', compact('order', 'whatsappUrl'));
    }

    public function history()
    {
        $orders = auth()->user()->orders()->latest()->get();
        return view('orders.history', compact('orders'));
    }
}
