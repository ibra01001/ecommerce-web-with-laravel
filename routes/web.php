<?php

use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\ProfileController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\Admin\AdminStockTypeController;
use App\Http\Controllers\Admin\AdminDiscountController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\Admin\AboutUsAdminController;
use App\Http\Controllers\Admin\AdminLogoAndThemeController;
use App\Http\Controllers\Admin\HeroHomeController;
use App\Http\Controllers\Admin\AdminFooterController;
use App\Http\Controllers\Admin\AdminFeaturesController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\Admin\AdminNewsletterController;
use App\Http\Controllers\ThemeController;   

Route::get('/', [HomeController::class, 'index'])->name('home');

// About Us public route
Route::get('/about-us', [AboutUsController::class, 'index'])->name('about-us');

// Admin Routes - PROTECTED by auth and admin middleware
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // Admin User Management Routes
    Route::resource('users', AdminUserController::class);

    // Products
    Route::resource('products', App\Http\Controllers\Admin\AdminProductController::class);

    // Categories
    Route::resource('categories', App\Http\Controllers\Admin\AdminCategoryController::class);

    // Orders
    Route::resource('orders', OrderController::class);
    Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])
        ->name('orders.updateStatus');

    // Logo and Theme Management
    Route::get('/appearance/settings', [AdminLogoAndThemeController::class, 'settings'])
        ->name('appearance.settings');

Route::post('/appearance/upload-light-logo', [AdminLogoAndThemeController::class, 'uploadLightLogo'])
    ->name('appearance.upload_Light_logo');

Route::post('/appearance/upload-dark-logo', [AdminLogoAndThemeController::class, 'uploadDarkLogo'])
    ->name('appearance.upload_Dark_logo');

Route::delete('/appearance/delete-logo', [AdminLogoAndThemeController::class, 'deleteLogo'])
    ->name('appearance.delete_logo');

    // Stock Types Management
    Route::resource('stock-types', AdminStockTypeController::class);
    Route::post('stock-types/{stockType}/options', [AdminStockTypeController::class, 'addOption'])
        ->name('stock-types.add-option');
    Route::put('stock-types/options/{option}', [AdminStockTypeController::class, 'updateOption'])
        ->name('stock-types.update-option');
    Route::delete('stock-types/options/{option}', [AdminStockTypeController::class, 'deleteOption'])
        ->name('stock-types.delete-option');
    Route::get('stock-types/{stockType}/options-json', [AdminStockTypeController::class, 'getOptions'])
        ->name('stock-types.get-options');

    // Discount Management
    Route::resource('discounts', AdminDiscountController::class);
    Route::post('discounts/{discount}/toggle', [AdminDiscountController::class, 'toggleActive'])
        ->name('discounts.toggle');
    Route::get('discounts/{discount}/stats', [AdminDiscountController::class, 'stats'])
        ->name('discounts.stats');

    // About Us Management
    Route::get('about-us/edit', [AboutUsAdminController::class, 'edit'])->name('about-us.edit');
    Route::put('about-us/update', [AboutUsAdminController::class, 'update'])->name('about-us.update');

    // Hero Home Section Management
    Route::get('hero-home/edit', [HeroHomeController::class, 'edit'])->name('hero-home.edit');
    Route::put('hero-home/update', [HeroHomeController::class, 'update'])->name('hero-home.update');

    // Footer Settings
    Route::get('/footer/edit', [AdminFooterController::class, 'edit'])->name('footer.edit');
    Route::put('/footer/update', [AdminFooterController::class, 'update'])->name('footer.update');

    Route::get('/features', [AdminFeaturesController::class, 'editFeatures'])->name('features.edit');
    Route::put('/features', [AdminFeaturesController::class, 'updateFeatures'])->name('features.update');

    // Feature Items
    Route::get('/features/items/create', [AdminFeaturesController::class, 'createItem'])->name('features.items.create');
    Route::post('/features/items', [AdminFeaturesController::class, 'storeItem'])->name('features.items.store');
    Route::get('/features/items/{item}/edit', [AdminFeaturesController::class, 'editItem'])->name('features.items.edit');
    Route::put('/features/items/{item}', [AdminFeaturesController::class, 'updateItem'])->name('features.items.update');
    Route::delete('/features/items/{item}', [AdminFeaturesController::class, 'deleteItem'])->name('features.items.delete');
    Route::post('/features/items/reorder', [AdminFeaturesController::class, 'reorderItems'])->name('features.items.reorder');

    // Brand Story
    Route::get('/brand-story', [AdminFeaturesController::class, 'editBrandStory'])->name('brand-story.edit');
    Route::put('/brand-story', [AdminFeaturesController::class, 'updateBrandStory'])->name('brand-story.update');
// Newsletter Management Routes
    Route::get('/newsletter', [AdminNewsletterController::class, 'index'])
    ->name('newsletter.index');

Route::delete('/newsletter/{id}', [AdminNewsletterController::class, 'delete'])
    ->name('newsletter.delete');

// Appearance / Themes
Route::get('/appearance/settings', [AdminLogoAndThemeController::class, 'settings'])
    ->name('appearance.settings');

Route::post('/appearance/themes', [AdminLogoAndThemeController::class, 'createTheme'])
    ->name('appearance.create_theme');

Route::put('/appearance/themes/{theme}', [AdminLogoAndThemeController::class, 'updateTheme'])
    ->name('appearance.update_theme');

Route::post('/appearance/themes/{theme}/activate', [AdminLogoAndThemeController::class, 'activateTheme'])
    ->name('appearance.activate_theme');

Route::delete('/appearance/themes/{theme}', [AdminLogoAndThemeController::class, 'deleteTheme'])
    ->name('appearance.delete_theme');

 Route::post('/themes/{id}/activate', [AdminLogoAndThemeController::class, 'activateTheme'])
        ->name('themes.activate');

});


// Authenticated User Routes (NOT admin)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Public Product Routes
Route::resource('products', ProductController::class);
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// API endpoint for getting product options (for quick buy modal)
Route::get('/api/products/{id}/options', [ProductController::class, 'getOptions'])->name('products.options');

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{cartKey}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{cartKey}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

//theme toggle route

Route::post('/theme/toggle', [App\Http\Controllers\ThemeController::class, 'toggle'])->name('theme.toggle');
Route::post('/theme/set-mode', [App\Http\Controllers\ThemeController::class, 'setMode'])->name('theme.setMode');

// Newsletter Subscription Route
Route::post('/newsletter/subscribe', [NewsletterController::class, 'store'])
    ->name('newsletter.subscribe');


// Discount Routes for Cart
Route::post('/cart/apply-discount', [CartController::class, 'applyDiscount'])->name('cart.apply-discount');
Route::post('/cart/remove-discount', [CartController::class, 'removeDiscount'])->name('cart.remove-discount');

// Checkout Routes
Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout.create');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/order/{order}/thankyou', [CheckoutController::class, 'thankyou'])->name('order.thankyou');

// Shipping Routes
Route::get('/checkout/shipping', [ShippingController::class, 'index'])->name('checkout.shipping');
Route::get('/checkout/communes/{wilaya_id}', [ShippingController::class, 'getCommunes']);

require __DIR__ . '/auth.php';