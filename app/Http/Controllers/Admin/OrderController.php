<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'deliveryZone'])->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,validated,preparing,shipping,arriving,delivered,cancelled',
            'payment_status' => 'required|in:pending,paid',
            'delivery_person_name' => 'nullable|string',
            'delivery_person_phone' => 'nullable|string',
            'estimated_delivery_time' => 'nullable|string',
        ]);

        $data = [
            'status' => $request->status,
            'payment_status' => $request->payment_status,
            'delivery_person_name' => $request->delivery_person_name,
            'delivery_person_phone' => $request->delivery_person_phone,
            'estimated_delivery_time' => $request->estimated_delivery_time,
        ];

        if ($request->status === 'shipping' && !$order->shipped_at) {
            $data['shipped_at'] = now();
        }

        $order->update($data);

        return back()->with('success', 'Statut de la commande #' . $order->id . ' et informations de suivi mis à jour.');
    }
}
