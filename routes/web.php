<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\PasswordRecoveryController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use Illuminate\Support\Facades\Route;

// Shop Routes
Route::get('/', [ShopController::class, 'index'])->name('home');
Route::get('/shop', [ShopController::class, 'shop'])->name('shop.index');
Route::get('/contact', function () {
    return view('contact');
})->name('contact');
Route::post('/contact', [\App\Http\Controllers\ShopController::class, 'contactStore'])->name('contact.store');
Route::get('/category/{category:slug}', [ShopController::class, 'category'])->name('shop.category');
Route::get('/product/{product:slug}', [ShopController::class, 'product'])->name('shop.product');
Route::get('/search', [ShopController::class, 'search'])->name('shop.search');
Route::get('/galerie', function () {
    $items = \App\Models\GalleryItem::latest()->get();
    return view('gallery', compact('items'));
})->name('gallery');

// Password Recovery (Two-Step Modal Flow)
Route::post('/password/verify-identity', [PasswordRecoveryController::class, 'verifyIdentity'])->name('password.verify-identity');
Route::post('/password/custom-reset', [PasswordRecoveryController::class, 'resetPassword'])->name('password.custom-reset');

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');

// Checkout Routes
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index')->middleware('auth');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store')->middleware('auth');
Route::get('/order/confirmation/{order}', [CheckoutController::class, 'confirmation'])->name('order.confirmation')->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // User Order History
    Route::get('/my-orders', [CheckoutController::class, 'history'])->name('orders.history');

    // Wishlist Routes
    Route::get('/favoris', [\App\Http\Controllers\WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/favoris/toggle/{product}', [\App\Http\Controllers\WishlistController::class, 'toggle'])->name('wishlist.toggle');
});

// Admin Routes
Route::middleware(['auth', 'can:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', AdminProductController::class);
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // NEW MODULES
    Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::post('/users/{user}/toggle-admin', [\App\Http\Controllers\Admin\UserController::class, 'toggleAdmin'])->name('users.toggle-admin');

    Route::resource('zones', \App\Http\Controllers\Admin\ZoneController::class);
    Route::resource('gallery', \App\Http\Controllers\Admin\GalleryController::class);

    Route::get('/contacts', [\App\Http\Controllers\Admin\ContactController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/{message}', [\App\Http\Controllers\Admin\ContactController::class, 'show'])->name('contacts.show');
    Route::post('/contacts/{message}/reply', [\App\Http\Controllers\Admin\ContactController::class, 'reply'])->name('contacts.reply');
    Route::delete('/contacts/{message}', [\App\Http\Controllers\Admin\ContactController::class, 'destroy'])->name('contacts.destroy');

    Route::get('/alerts', [\App\Http\Controllers\Admin\AlertController::class, 'index'])->name('alerts.index');
    Route::get('/alerts/create', [\App\Http\Controllers\Admin\AlertController::class, 'create'])->name('alerts.create');
    Route::post('/alerts', [\App\Http\Controllers\Admin\AlertController::class, 'store'])->name('alerts.store');
    Route::post('/alerts/{alert}/toggle', [\App\Http\Controllers\Admin\AlertController::class, 'toggle'])->name('alerts.toggle');
    Route::delete('/alerts/{alert}', [\App\Http\Controllers\Admin\AlertController::class, 'destroy'])->name('alerts.destroy');
});

require __DIR__.'/auth.php';
