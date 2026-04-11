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
            return Auth::user()->cartItems()->with('product')->get()->mapWithKeys(function ($item) {
                return [$item->product_id => [
                    'id' => $item->product_id,
                    'name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                    'image' => $item->product->image_url,
                    'slug' => $item->product->slug
                ]];
            })->toArray();
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
                    'quantity' => $quantity
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
                    'price' => $product->price,
                    'image' => $product->image_url,
                    'slug' => $product->slug
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
        if (!Auth::check()) return;

        $sessionCart = Session::get('cart', []);
        if (empty($sessionCart)) return;

        foreach ($sessionCart as $productId => $details) {
            $cartItem = CartItem::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->first();

            if ($cartItem) {
                // If exists in DB, add quantities
                $cartItem->increment('quantity', $details['quantity']);
            } else {
                // If not in DB, create it
                CartItem::create([
                    'user_id' => Auth::id(),
                    'product_id' => $productId,
                    'quantity' => $details['quantity']
                ]);
            }
        }

        // Clear session cart after migration
        Session::forget('cart');
    }
}
