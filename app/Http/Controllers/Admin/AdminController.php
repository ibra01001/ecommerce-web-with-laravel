<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\Order;

class AdminController extends Controller
{
   public function dashboard()
{
    // Get counts
    $productsCount = Product::count();
    $categoriesCount = Category::count();
    $usersCount = User::count();
    $ordersCount = Order::count(); 

    // Get recent products
    $recentProducts = Product::with('category')
        ->latest()
        ->take(5)
        ->get();

    // Get recent orders
    $recentOrders = Order::with('user')
        ->latest()
        ->take(5)
        ->get();

    // Monthly product creation stats
    $monthlyProducts = Product::selectRaw('COUNT(*) as count, MONTH(created_at) as month')
        ->whereYear('created_at', date('Y'))
        ->groupBy('month')
        ->get();

    // ⭐ FIXED: Low-stock products using dynamic accessor (not SQL query)
    $lowStockProducts = Product::get()               // fetch all
        ->sortBy('total_stock')                      // sort by accessor
        ->filter(fn ($product) => $product->total_stock < 10) // filter by accessor
        ->take(5);                                   // limit results

    return view('admin.dashboard', compact(
        'productsCount',
        'categoriesCount',
        'usersCount',
        'ordersCount',
        'recentProducts',
        'recentOrders',
        'monthlyProducts',
        'lowStockProducts'
    ));
}

}
