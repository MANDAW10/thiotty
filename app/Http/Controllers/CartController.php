<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
        $total = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
        
        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Product $product)
    {
        $cart = Session::get('cart', []);
        $id = $product->id;

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image,
                "slug" => $product->slug
            ];
        }

        Session::put('cart', $cart);
        return back()->with('success', 'Produit ajouté au panier !');
    }

    public function update(Request $request, Product $product)
    {
        $cart = Session::get('cart', []);
        $id = $product->id;

        if (isset($cart[$id]) && $request->quantity > 0) {
            $cart[$id]['quantity'] = $request->quantity;
            Session::put('cart', $cart);
            return back()->with('success', 'Panier mis à jour !');
        }

        return back()->with('error', 'Quantité invalide.');
    }

    public function remove(Product $product)
    {
        $cart = Session::get('cart', []);
        $id = $product->id;

        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
        }

        return back()->with('success', 'Produit retiré du panier.');
    }
}
