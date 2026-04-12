<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartService
{
    /**
     * Get all items in the cart (either from database or session).
     */
    public function getItems()
    {
        if (Auth::check()) {
            return Auth::user()->cartItems()
                ->whereHas('product') // Only get items that have a valid product
                ->with('product')
                ->get()
                ->mapWithKeys(function ($item) {
                    if (! $item->product) {
                        return [];
                    } // Double safety

                    return [$item->product_id => [
                        'id' => $item->product_id,
                        'name' => $item->product->name,
                        'quantity' => $item->quantity,
                        'price' => $item->product->selling_price,
                        'image' => $item->product->image_url,
                        'slug' => $item->product->slug,
                    ]];
                })
                ->filter() // Remove any empty arrays from failed product loads
                ->toArray();
        }

        return Session::get('cart', []);
    }

    /**
     * Add a product to the cart.
     */
    public function add(Product $product, $quantity = 1)
    {
        if (Auth::check()) {
            $cartItem = CartItem::where('user_id', Auth::id())
                ->where('product_id', $product->id)
                ->first();

            if ($cartItem) {
                $cartItem->increment('quantity', $quantity);
            } else {
                CartItem::create([
                    'user_id' => Auth::id(),
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                ]);
            }
        } else {
            $cart = Session::get('cart', []);
            $id = $product->id;

            if (isset($cart[$id])) {
                $cart[$id]['quantity'] += $quantity;
            } else {
                $cart[$id] = [
                    'id' => $product->id, // Store ID explicitly for easier migration
                    'name' => $product->name,
                    'quantity' => $quantity,
                    'price' => $product->selling_price,
                    'image' => $product->image_url,
                    'slug' => $product->slug,
                ];
            }
            Session::put('cart', $cart);
        }
    }

    /**
     * Update product quantity in the cart.
     */
    public function update(Product $product, $quantity)
    {
        if (Auth::check()) {
            if ($quantity <= 0) {
                $this->remove($product);
            } else {
                CartItem::updateOrCreate(
                    ['user_id' => Auth::id(), 'product_id' => $product->id],
                    ['quantity' => $quantity]
                );
            }
        } else {
            $cart = Session::get('cart', []);
            if (isset($cart[$product->id])) {
                if ($quantity <= 0) {
                    unset($cart[$product->id]);
                } else {
                    $cart[$product->id]['quantity'] = $quantity;
                }
                Session::put('cart', $cart);
            }
        }
    }

    /**
     * Remove a product from the cart.
     */
    public function remove(Product $product)
    {
        if (Auth::check()) {
            CartItem::where('user_id', Auth::id())
                ->where('product_id', $product->id)
                ->delete();
        } else {
            $cart = Session::get('cart', []);
            if (isset($cart[$product->id])) {
                unset($cart[$product->id]);
                Session::put('cart', $cart);
            }
        }
    }

    /**
     * Get the total count of unique items in the cart.
     */
    public function getCount()
    {
        return count($this->getItems());
    }

    /**
     * Migrate session cart to database for an authenticated user.
     */
    public function migrateSessionToUser()
    {
        if (! Auth::check()) {
            return;
        }

        $sessionCart = Session::get('cart', []);
        if (empty($sessionCart)) {
            return;
        }

        foreach ($sessionCart as $productId => $details) {
            // Validate that the product exists before migrating
            $productExists = Product::where('id', $productId)->exists();
            if (! $productExists) {
                continue;
            }

            $cartItem = CartItem::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->first();

            if ($cartItem) {
                $cartItem->increment('quantity', $details['quantity'] ?? 1);
            } else {
                CartItem::create([
                    'user_id' => Auth::id(),
                    'product_id' => $productId,
                    'quantity' => $details['quantity'] ?? 1,
                ]);
            }
        }

        // Clear session cart after migration
        Session::forget('cart');
    }

    /**
     * Get the total balance of the cart.
     */
    public function getTotalBalance()
    {
        $total = 0;
        foreach ($this->getItems() as $item) {
            $total += ($item['price'] * $item['quantity']);
        }

        return $total;
    }
}
