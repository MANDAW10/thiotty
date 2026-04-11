<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();
        $featuredProducts = Product::where('is_featured', true)->latest()->take(8)->get();
        $recentProducts = Product::latest()->take(8)->get();

        return view('welcome', compact('categories', 'featuredProducts', 'recentProducts'));
    }

    public function shop(Request $request)
    {
        $query = Product::query();

        // Filter by Category
        if ($request->has('category') && $request->category != 'all') {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filter by Price Range
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        if ($sort == 'price_asc') $query->orderBy('price', 'asc');
        elseif ($sort == 'price_desc') $query->orderBy('price', 'desc');
        else $query->latest();

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::withCount('products')->get();
        
        return view('shop.index', compact('products', 'categories'));
    }

    public function category(Category $category)
    {
        $products = $category->products()->paginate(12);
        $categories = Category::all();
        return view('shop.index', compact('category', 'products', 'categories'));
    }

    public function product(Product $product)
    {
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();
            
        return view('shop.show', compact('product', 'relatedProducts'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $products = Product::where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->paginate(12);
            
        $categories = Category::all();
        return view('shop.index', compact('products', 'categories', 'query'));
    }

    public function contactStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        \App\Models\ContactMessage::create($request->all());

        return back()->with('success', 'Votre message a été envoyé avec succès. Nous vous répondrons dans les plus brefs délais.');
    }
}
