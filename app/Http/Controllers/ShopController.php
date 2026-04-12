<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ShopController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();
        $featuredProducts = Product::where('is_featured', true)->latest()->take(8)->get();
        $recentProducts = Product::latest()->take(8)->get();

        $bestSellerIds = DB::table('order_items')
            ->select('product_id', DB::raw('SUM(quantity) as qty'))
            ->groupBy('product_id')
            ->orderByDesc('qty')
            ->limit(8)
            ->pluck('product_id');

        if ($bestSellerIds->isEmpty()) {
            $bestSellers = Product::with('category')->latest()->take(8)->get();
        } else {
            $byId = Product::with('category')->whereIn('id', $bestSellerIds)->get()->keyBy('id');
            $bestSellers = $bestSellerIds->map(fn ($id) => $byId->get($id))->filter();
        }

        return view('welcome', compact('categories', 'featuredProducts', 'recentProducts', 'bestSellers'));
    }

    public function shop(Request $request)
    {
        $query = Product::query();

        // Filter by Category
        if ($request->has('category') && $request->category != 'all') {
            $query->whereHas('category', function ($q) use ($request) {
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
        if ($sort == 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($sort == 'price_desc') {
            $query->orderBy('price', 'desc');
        } else {
            $query->latest();
        }

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

        $reviews = $product->reviews()
            ->where('is_approved', true)
            ->with('user:id,name')
            ->latest()
            ->take(30)
            ->get();

        $userReview = auth()->check()
            ? $product->reviews()->where('user_id', auth()->id())->first()
            : null;

        return view('shop.show', compact('product', 'relatedProducts', 'reviews', 'userReview'));
    }

    /**
     * Données JSON pour la fenêtre « aperçu rapide » (type vitrine).
     */
    public function productQuick(Product $product)
    {
        return response()->json([
            'id' => $product->id,
            'slug' => $product->slug,
            'name' => $product->display_name,
            'price' => (float) $product->price,
            'sale_price' => $product->sale_price !== null ? (float) $product->sale_price : null,
            'selling_price' => (float) $product->selling_price,
            'has_sale' => (bool) $product->has_sale,
            'image' => $product->image_url,
            'description' => Str::limit(strip_tags((string) $product->description), 280),
            'stock' => (int) $product->stock,
            'url' => route('shop.product', $product),
            'category' => $product->category?->display_name ?? '',
        ]);
    }

    public function newsletterSubscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ]);

        ContactMessage::create([
            'name' => 'Newsletter',
            'email' => $validated['email'],
            'subject' => 'Inscription newsletter',
            'message' => '—',
        ]);

        return redirect()->route('home')->with('newsletter_ok', true);
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

        ContactMessage::create($request->all());

        return back()->with('success', 'Votre message a été envoyé avec succès. Nous vous répondrons dans les plus brefs délais.');
    }
}
