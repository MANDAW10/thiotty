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
        $total = array_sum(array_map(fn ($item) => $item['price'] * $item['quantity'], $cart));

        return view('cart.index', compact('cart', 'total'));
    }

    /**
     * JSON pour le panier latéral (style vitrine type Caawogi).
     */
    public function summary()
    {
        return response()->json([
            'items' => array_values($this->cartService->getItems()),
            'count' => $this->cartService->getCount(),
            'total' => $this->cartService->getTotalBalance(),
        ]);
    }

    public function add(Request $request, Product $product)
    {
        $qtyToAdd = $request->input('quantity', 1);

        // Simple stock check - won't exceed max available
        $items = collect($this->cartService->getItems());
        $currentInCart = isset($items[$product->id]) ? $items[$product->id]['quantity'] : 0;
        
        if ($currentInCart + $qtyToAdd > $product->stock) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stock disponible atteint.',
                    'count' => count($items),
                ]);
            }
            return back()->with('error', 'Stock insuffisant pour ce produit.');
        }

        $this->cartService->add($product, $qtyToAdd);
        $cart = $this->cartService->getItems();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Produit ajouté au panier !',
                'count' => count($cart),
            ]);
        }

        return back()->with('success', 'Produit ajouté au panier !');
    }

    public function update(Request $request, Product $product)
    {
        if ($request->quantity > $product->stock) {
            return back()->with('error', 'Quantité demandée supérieure au stock disponible.');
        }

        if ($request->quantity > 0) {
            $this->cartService->update($product, $request->quantity);

            return back()->with('success', 'Panier mis à jour !');
        }

        return back()->with('error', 'Quantité invalide.');
    }

    public function remove(Product $product)
    {
        $this->cartService->remove($product);

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'count' => $this->cartService->getCount(),
                'total' => $this->cartService->getTotalBalance(),
                'items' => array_values($this->cartService->getItems()),
            ]);
        }

        return back()->with('success', 'Produit retiré du panier.');
    }
}
