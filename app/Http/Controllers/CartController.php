<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cart = $this->cartService->getItems();
        $total = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
        
        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Product $product)
    {
        $this->cartService->add($product);
        $cart = $this->cartService->getItems();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Produit ajouté au panier !',
                'count' => count($cart)
            ]);
        }

        return back()->with('success', 'Produit ajouté au panier !');
    }

    public function update(Request $request, Product $product)
    {
        if ($request->quantity > 0) {
            $this->cartService->update($product, $request->quantity);
            return back()->with('success', 'Panier mis à jour !');
        }

        return back()->with('error', 'Quantité invalide.');
    }

    public function remove(Product $product)
    {
        $this->cartService->remove($product);
        return back()->with('success', 'Produit retiré du panier.');
    }
}
