<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{
    public function dashboard()
    {
        // Basic Counts
        $productsCount = Product::count();
        $categoriesCount = Category::count();
        $usersCount = User::where('is_admin', false)->count();
        $ordersCount = Order::count();

        // === PERFORMANCE METRICS ===
        // Revenue Metrics - ONLY COUNT COMPLETED ORDERS
        $totalRevenue = Order::where('status', 'completed')->sum('total');
        
        $todayRevenue = Order::where('status', 'completed')
            ->whereDate('created_at', today())
            ->sum('total');
        
        $thisWeekRevenue = Order::where('status', 'completed')
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->sum('total');
        
        $thisMonthRevenue = Order::where('status', 'completed')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total');
        
        $lastMonthRevenue = Order::where('status', 'completed')
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->sum('total');

        // Calculate revenue growth percentage
        $revenueGrowth = $lastMonthRevenue > 0 
            ? (($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100 
            : 0;

        // Order Metrics
        $averageOrderValue = Order::where('status', 'completed')->avg('total') ?? 0;
        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::where('status', 'confirmed')->count(); // Fixed: confirmed, not processing
        $completedOrders = Order::where('status', 'completed')->count();
        $todayOrders = Order::whereDate('created_at', today())->count();

        // Top Selling Products (Last 30 Days) - ONLY FROM COMPLETED ORDERS
$topSellingProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_sold'))
    ->whereHas('order', function($query) {
        $query->where('created_at', '>=', now()->subDays(30))
              ->where('status', 'completed');
    })
    ->whereHas('product') // only include items with an existing product
    ->groupBy('product_id')
    ->orderBy('total_sold', 'desc')
    ->take(5)
    ->with('product')
    ->get();

        // Low Stock Products (stock <= threshold and > 0)
        $lowStockProducts = Product::get()->filter(function ($product) {
            $totalStock = $product->total_stock;
            return $totalStock <= $product->low_stock_threshold && $totalStock > 0;
        });

        // Out of Stock Products
        $outOfStockProducts = Product::get()->filter(function ($product) {
            return $product->total_stock == 0;
        });

        // Get recent orders with customer name attribute
        $recentOrders = Order::latest()
            ->take(5)
            ->get()
            ->map(function ($order) {
                // Add customer_name attribute for dashboard view
                $order->customer_name = $order->first_name . ' ' . $order->last_name;
                $order->total_amount = $order->total;
                return $order;
            });

        // Get recent products
        $recentProducts = Product::with('category')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            // Basic counts
            'productsCount',
            'categoriesCount',
            'usersCount',
            'ordersCount',
            
            // Revenue metrics
            'totalRevenue',
            'todayRevenue',
            'thisWeekRevenue',
            'thisMonthRevenue',
            'revenueGrowth',
            
            // Order metrics
            'averageOrderValue',
            'pendingOrders',
            'processingOrders',
            'completedOrders',
            'todayOrders',
            
            // Top products
            'topSellingProducts',
            
            // Recent data
            'recentProducts',
            'recentOrders'
        ));
    }
}