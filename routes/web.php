<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AlertController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ZoneController;
use App\Http\Controllers\Auth\PasswordRecoveryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CompareController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\WishlistController;
use App\Models\GalleryItem;
use App\Models\User;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

$deploySetupGate = static function (Request $request): void {
    $token = config('app.deploy_setup_token');
    if (! is_string($token) || $token === '' || ! hash_equals($token, (string) $request->query('token', ''))) {
        abort(404);
    }
};

// Language Switch Route
Route::get('/language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

// EMERGENCY FINAL ADMIN SETUP (TEMPORARY) — requires ?token= matching DEPLOY_SETUP_TOKEN
Route::get('/setup-final-admin', function (Request $request) use ($deploySetupGate) {
    $deploySetupGate($request);
    try {
        // Create Admin
        User::updateOrCreate(
            ['email' => 'admin@thiotty.com'],
            [
                'name' => 'Adama Thiotty',
                'password' => Hash::make('thiotty2026'),
                'is_admin' => true,
            ]
        );

        // Seed Categories and Products
        Artisan::call('db:seed', ['--force' => true]);

        return "Boutique configurée ! <br>✅ Compte Admin : <b>admin@thiotty.com</b> (Pass: thiotty2026) <br>✅ Catégories & Produits insérés ! <br><a href='/login'>Aller à la connexion</a>";
    } catch (\Exception $e) {
        return 'Erreur : '.$e->getMessage();
    }
});

// Update Premium Visuals (One-time run)
Route::get('/update-visuals', function (Request $request) use ($deploySetupGate) {
    $deploySetupGate($request);
    try {
        (new CategorySeeder)->run();
        (new ProductSeeder)->run();

        return '✨ Visuels Premium activés avec succès ! <br>Les images haute définition sont maintenant opérationnelles sur toute la plateforme.';
    } catch (\Exception $e) {
        return 'Erreur lors de la mise à jour : '.$e->getMessage();
    }
});

// Run migrations (one-time / after deploy) — requires ?token= matching DEPLOY_SETUP_TOKEN
Route::get('/sync-setup', function (Request $request) use ($deploySetupGate) {
    $deploySetupGate($request);
    try {
        Artisan::call('migrate', ['--force' => true]);

        return '✨ Synchronisation Universelle activée ! <br>✅ Base de données mise à jour. <br>✅ Panier & Thème persistants opérationnels.';
    } catch (\Exception $e) {
        return "Erreur lors de l'activation : ".$e->getMessage();
    }
});

// Shop Routes
Route::get('/', [ShopController::class, 'index'])->name('home');
Route::get('/shop', [ShopController::class, 'shop'])->name('shop.index');
Route::get('/contact', function () {
    return view('contact');
})->name('contact');
Route::post('/contact', [ShopController::class, 'contactStore'])->name('contact.store');
Route::get('/category/{category:slug}', [ShopController::class, 'category'])->name('shop.category');
Route::get('/product/{product:slug}/quick', [ShopController::class, 'productQuick'])->name('shop.product.quick');
Route::get('/product/{product:slug}', [ShopController::class, 'product'])->name('shop.product');
Route::get('/search', [ShopController::class, 'search'])->name('shop.search');
Route::post('/newsletter', [ShopController::class, 'newsletterSubscribe'])->name('newsletter.subscribe');

// ═══════════════════════════════════════════
// SEO : Sitemap XML dynamique
// ═══════════════════════════════════════════
Route::get('/sitemap.xml', function () {
    $products   = \App\Models\Product::where('stock', '>', 0)->latest()->get();
    $categories = \App\Models\Category::all();

    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

    // Pages statiques
    $staticPages = [
        ['url' => url('/'),               'priority' => '1.0', 'freq' => 'daily'],
        ['url' => route('shop.index'),    'priority' => '0.9', 'freq' => 'daily'],
        ['url' => route('about'),         'priority' => '0.6', 'freq' => 'monthly'],
        ['url' => route('blog.index'),    'priority' => '0.7', 'freq' => 'weekly'],
        ['url' => url('/contact'),        'priority' => '0.5', 'freq' => 'monthly'],
    ];

    foreach ($staticPages as $page) {
        $xml .= "  <url>\n";
        $xml .= "    <loc>{$page['url']}</loc>\n";
        $xml .= "    <changefreq>{$page['freq']}</changefreq>\n";
        $xml .= "    <priority>{$page['priority']}</priority>\n";
        $xml .= "  </url>\n";
    }

    // Pages catégories
    foreach ($categories as $cat) {
        $url = route('shop.category', $cat->slug);
        $xml .= "  <url>\n";
        $xml .= "    <loc>{$url}</loc>\n";
        $xml .= "    <changefreq>weekly</changefreq>\n";
        $xml .= "    <priority>0.8</priority>\n";
        $xml .= "  </url>\n";
    }

    // Pages produits
    foreach ($products as $product) {
        $url     = route('shop.product', $product->slug);
        $lastmod = $product->updated_at->toAtomString();
        $xml .= "  <url>\n";
        $xml .= "    <loc>{$url}</loc>\n";
        $xml .= "    <lastmod>{$lastmod}</lastmod>\n";
        $xml .= "    <changefreq>weekly</changefreq>\n";
        $xml .= "    <priority>0.7</priority>\n";
        $xml .= "  </url>\n";
    }

    $xml .= '</urlset>';

    return response($xml, 200)->header('Content-Type', 'application/xml');
})->name('sitemap');

Route::get('/a-propos', function () {
    return view('about');
})->name('about');
Route::get('/blog', function () {
    return view('blog');
})->name('blog.index');

Route::get('/galerie', function () {
    // Auto-seed if empty for a seamless experience
    if (GalleryItem::count() === 0) {
        $items = [
            ['image' => 'https://images.unsplash.com/photo-1543160732-23700b1b13b1?q=80&w=1200&auto=format&fit=crop', 'title' => 'Majesté Gobra', 'category' => 'Élevage', 'description' => 'Notre troupeau de zébus Gobra pur-sang sous le soleil du Sénégal.'],
            ['image' => 'https://images.unsplash.com/photo-1464226184884-fa280b87c399?q=80&w=1200&auto=format&fit=crop', 'title' => 'Récolte du Matin', 'category' => 'Terroir', 'description' => 'Des produits frais, bio et locaux cueillis chaque jour pour votre table.'],
            ['image' => 'https://images.unsplash.com/photo-1548550023-2bdb3c5beed7?q=80&w=1200&auto=format&fit=crop', 'title' => 'Innovation Avicole', 'category' => 'Culture', 'description' => 'Nos installations modernes garantissent une hygiène et une santé optimales.'],
            ['image' => 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=1200&auto=format&fit=crop', 'title' => 'Pâturages de Liberté', 'category' => 'Élevage', 'description' => 'Un élevage en plein air pour une qualité de viande et de lait incomparable.'],
            ['image' => 'https://images.unsplash.com/photo-1586528116311-ad86d7c7ce80?q=80&w=1200&auto=format&fit=crop', 'title' => 'Fraîcheur Garantie', 'category' => 'Logistique', 'description' => 'Notre flotte logistique assure une livraison express en moins de 24h.'],
            ['image' => 'https://images.unsplash.com/photo-1559114066-d5993c3bf08c?q=80&w=1200&auto=format&fit=crop', 'title' => 'L\'Or de Casamance', 'category' => 'Terroir', 'description' => 'Un miel pur et artisanal, pilier de notre engagement pour le terroir.'],
        ];

        foreach ($items as $item) {
            GalleryItem::updateOrCreate(['title' => $item['title']], $item);
        }
    }

    $items = GalleryItem::latest()->get();

    return view('gallery', compact('items'));
})->name('gallery');

// Password Recovery (Two-Step Modal Flow)
Route::post('/password/verify-identity', [PasswordRecoveryController::class, 'verifyIdentity'])->name('password.verify-identity');
Route::post('/password/custom-reset', [PasswordRecoveryController::class, 'resetPassword'])->name('password.custom-reset');

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/cart/summary', [CartController::class, 'summary'])->name('cart.summary');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::get('/comparer', [CompareController::class, 'index'])->name('compare.index');
Route::post('/compare/toggle/{product}', [CompareController::class, 'toggle'])->name('compare.toggle');
Route::patch('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');

// Checkout Routes
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index')->middleware('auth');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store')->middleware('auth');
Route::get('/order/confirmation/{order}', [CheckoutController::class, 'confirmation'])->name('order.confirmation')->middleware('auth');

// Payment Routes
Route::middleware('auth')->group(function () {
    Route::get('/payment/{order}', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/payment/{order}/initiate', [PaymentController::class, 'initiate'])->name('payment.initiate');
    Route::post('/payment/{order}/process', [PaymentController::class, 'process'])->name('payment.process');
    Route::get('/payment/{order}/otp', [PaymentController::class, 'otpShow'])->name('payment.otp');
    Route::post('/payment/{order}/otp/verify', [PaymentController::class, 'otpVerify'])->name('payment.otp.verify');
    Route::get('/payment/callback/wave/{payment}', [PaymentController::class, 'waveCallback'])->name('payment.callback.wave');
    Route::get('/payment/{order}/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
    Route::get('/payment/history', [PaymentController::class, 'history'])->name('payment.history');
    Route::get('/payment/details/{payment}', [PaymentController::class, 'details'])->name('payment.details');
});

// Payment Webhook (public, no auth)
Route::post('/payment/confirm', [PaymentController::class, 'confirm'])->name('payment.confirm');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/theme', [ProfileController::class, 'updateTheme'])->name('profile.theme.update');

    // User Order History
    Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/my-orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    // Wishlist Routes
    Route::get('/favoris', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/favoris/toggle/{product}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::post('/favoris/clear', [WishlistController::class, 'clear'])->name('wishlist.clear');

    Route::post('/product/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});

// Admin Routes
Route::middleware(['auth', 'can:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', AdminProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // NEW MODULES
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users/{user}/toggle-admin', [UserController::class, 'toggleAdmin'])->name('users.toggle-admin');

    Route::resource('zones', ZoneController::class);
    Route::resource('gallery', GalleryController::class);

    Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/{message}', [ContactController::class, 'show'])->name('contacts.show');
    Route::post('/contacts/{message}/reply', [ContactController::class, 'reply'])->name('contacts.reply');
    Route::delete('/contacts/{message}', [ContactController::class, 'destroy'])->name('contacts.destroy');

    Route::get('/alerts', [AlertController::class, 'index'])->name('alerts.index');
    Route::get('/alerts/create', [AlertController::class, 'create'])->name('alerts.create');
    Route::post('/alerts', [AlertController::class, 'store'])->name('alerts.store');
    Route::post('/alerts/{alert}/toggle', [AlertController::class, 'toggle'])->name('alerts.toggle');
    Route::delete('/alerts/{alert}', [AlertController::class, 'destroy'])->name('alerts.destroy');

    Route::resource('slides', \App\Http\Controllers\Admin\SlideController::class);
    Route::get('/reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
    Route::patch('/reviews/{review}/approve', [AdminReviewController::class, 'approve'])->name('reviews.approve');
    Route::delete('/reviews/{review}', [AdminReviewController::class, 'destroy'])->name('reviews.delete');
});

require __DIR__.'/auth.php';
