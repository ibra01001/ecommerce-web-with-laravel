<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Get basic counts
        $productsCount = Product::query()->count();
        $categoriesCount = Category::query()->count();
        $usersCount = User::query()->count();
        $ordersCount = Order::query()->count();
        $recentProducts = Product::query()->latest()->take(6)->get();
        $recentOrders = Order::query()->latest()->take(6)->get();
        

        // Get recent products (overwriting previous $recentProducts)
        $recentProducts = Product::query()->latest()->take(120)->get();

        // Get products count by month (last 6 months)
        $monthlyProducts = Product::query()
            ->selectRaw('COUNT(*) as count, MONTH(created_at) as month')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')->get();

        // Get low stock products (assuming you add a stock field to products table)
        $lowStockProducts = Product::query()->where('stock', '<', 10)->take(5)->get();

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