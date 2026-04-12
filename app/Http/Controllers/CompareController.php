<?php

namespace App\Http\Controllers;

use App\Models\Product;

class CompareController extends Controller
{
    public function index()
    {
        $ids = array_values(array_unique(session('compare', [])));
        $products = collect($ids)
            ->map(fn (int $id) => Product::with('category')->find($id))
            ->filter();

        return view('compare.index', ['products' => $products]);
    }

    public function toggle(Product $product)
    {
        $ids = array_values(session('compare', []));
        $pos = array_search($product->id, $ids, true);

        if ($pos !== false) {
            unset($ids[$pos]);
            $ids = array_values($ids);
            $inCompare = false;
        } else {
            if (count($ids) >= 4) {
                array_shift($ids);
            }
            $ids[] = $product->id;
            $inCompare = true;
        }

        session(['compare' => $ids]);

        if (request()->wantsJson()) {
            return response()->json([
                'count' => count($ids),
                'in_compare' => $inCompare,
            ]);
        }

        return back();
    }
}
