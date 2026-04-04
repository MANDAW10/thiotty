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
            'status' => 'required|in:pending,validated,delivered,cancelled',
            'payment_status' => 'required|in:pending,paid',
        ]);

        $order->update([
            'status' => $request->status,
            'payment_status' => $request->payment_status,
        ]);

        return back()->with('success', 'Statut de la commande #'.$order->id.' mis à jour.');
    }
}
