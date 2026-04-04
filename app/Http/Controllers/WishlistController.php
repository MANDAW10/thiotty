<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Auth::user()->wishlists()->with('product')->latest()->get();
        return view('wishlist.index', compact('wishlists'));
    }

    public function toggle(Product $product)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'unauthenticated'], 401);
        }

        $user = Auth::user();
        $wishlist = Wishlist::where('user_id', $user->id)
                            ->where('product_id', $product->id)
                            ->first();

        if ($wishlist) {
            $wishlist->delete();
            $status = 'removed';
        } else {
            Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);
            $status = 'added';
        }

        return response()->json([
            'status' => $status,
            'count' => $user->wishlists()->count(),
        ]);
    }
}
