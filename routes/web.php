<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SampleController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Public Shop Routes
Route::get('/', [ShopController::class, 'home'])->name('home');
Route::get('/products', [ShopController::class, 'products'])->name('products');
Route::get('/products/{category}', [ShopController::class, 'categoryProducts'])->name('products.category');
Route::get('/product/{product}', [ShopController::class, 'show'])->name('product.show');
Route::get('/samples', [SampleController::class, 'index'])->name('samples');
Route::post('/samples', [SampleController::class, 'store'])->name('samples.store');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/about', [ShopController::class, 'about'])->name('about');

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

// Admin Dashboard Routes
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Inventory Management
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory');
    Route::post('/inventory/import', [InventoryController::class, 'import'])->name('inventory.import');
    Route::get('/inventory/transactions', [InventoryController::class, 'transactions'])->name('inventory.transactions');
    Route::post('/inventory/transaction', [InventoryController::class, 'recordTransaction'])->name('inventory.transaction');
    Route::get('/inventory/areas', [InventoryController::class, 'areas'])->name('inventory.areas');
    
    // Product Management
    Route::resource('products', ProductController::class);
    
    // Order Management
    Route::resource('orders', OrderController::class);
    
    // Customer Relations
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers');
    Route::get('/messages', [CustomerController::class, 'messages'])->name('messages');
    Route::get('/reports/top-products', [CustomerController::class, 'topProducts'])->name('reports.top-products');
});

// Keep the old dashboard for compatibility
Route::get('dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
