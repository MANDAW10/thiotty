<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $featuredProducts = Product::where('is_featured', true)->latest()->take(8)->get();
        $recentProducts = Product::latest()->take(8)->get();

        return view('welcome', compact('categories', 'featuredProducts', 'recentProducts'));
    }

    public function shop()
    {
        $products = Product::latest()->paginate(12);
        $categories = Category::all();
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
