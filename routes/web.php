<?php

use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\Admin\AdminStockTypeController;
use App\Http\Controllers\Admin\AdminDiscountController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('/products', App\Http\Controllers\Admin\AdminProductController::class);
    Route::resource('/categories', App\Http\Controllers\Admin\AdminCategoryController::class);
    Route::resource('/orders', OrderController::class);
    
    Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])
        ->name('orders.updateStatus');
    
    // Stock Types Management
    Route::resource('stock-types', AdminStockTypeController::class);
    
    // Stock Type Options Management
    Route::post('stock-types/{stockType}/options', [AdminStockTypeController::class, 'addOption'])
        ->name('stock-types.add-option');
    Route::put('stock-types/options/{option}', [AdminStockTypeController::class, 'updateOption'])
        ->name('stock-types.update-option');
    Route::delete('stock-types/options/{option}', [AdminStockTypeController::class, 'deleteOption'])
        ->name('stock-types.delete-option');
    
    // AJAX endpoint to get stock type options
    Route::get('stock-types/{stockType}/options-json', [AdminStockTypeController::class, 'getOptions'])
        ->name('stock-types.get-options');
    
    // Discount Management
    Route::resource('discounts', AdminDiscountController::class);
    Route::post('discounts/{discount}/toggle', [AdminDiscountController::class, 'toggleActive'])
        ->name('discounts.toggle');
    Route::get('discounts/{discount}/stats', [AdminDiscountController::class, 'stats'])
        ->name('discounts.stats');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('products', ProductController::class);
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// Cart routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{cartKey}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{cartKey}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Discount routes for cart
Route::post('/cart/apply-discount', [CartController::class, 'applyDiscount'])->name('cart.apply-discount');
Route::post('/cart/remove-discount', [CartController::class, 'removeDiscount'])->name('cart.remove-discount');

// Checkout routes
Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout.create');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/order/{order}/thankyou', [CheckoutController::class, 'thankyou'])->name('order.thankyou');

// Shipping routes
Route::get('/checkout/shipping', [ShippingController::class, 'index'])->name('checkout.shipping');
Route::get('/checkout/communes/{wilaya_id}', [ShippingController::class, 'getCommunes']);

require __DIR__.'/auth.php';