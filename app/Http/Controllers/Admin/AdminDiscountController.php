<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDiscountController extends Controller
{
    public function index()
    {
        $discounts = Discount::latest()->paginate(20);
        return view('admin.discounts.index', compact('discounts'));
    }

    public function create()
    {
        $categories = Category::all();
        $products = Product::with('category')->get();
        return view('admin.discounts.create', compact('categories', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:discounts,code|max:50',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_purchase' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'per_user_limit' => 'nullable|integer|min:1',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after_or_equal:starts_at',
            'applies_to_all' => 'boolean',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'exists:categories,id',
            'product_ids' => 'nullable|array',
            'product_ids.*' => 'exists:products,id',
            'is_active' => 'boolean',
        ]);

        // Validation: percentage must be <= 100
        if ($validated['type'] === 'percentage' && $validated['value'] > 100) {
            return back()->withErrors(['value' => 'Percentage cannot exceed 100%'])->withInput();
        }

        $discount = Discount::create($validated);

        return redirect()->route('admin.discounts.index')
            ->with('success', 'Discount created successfully!');
    }

    public function show(Discount $discount)
    {
        // Load users with their usage information
        $usageData = DB::table('discount_user')
            ->where('discount_id', $discount->id)
            ->leftJoin('users', 'discount_user.user_id', '=', 'users.id')
            ->leftJoin('orders', 'discount_user.order_id', '=', 'orders.id')
            ->select(
                'discount_user.*',
                'users.name as user_name',
                'users.email as user_email',
                'orders.id as order_number',
                'orders.total as order_total'
            )
            ->orderBy('discount_user.used_at', 'desc')
            ->paginate(20);

        return view('admin.discounts.show', compact('discount', 'usageData'));
    }

    public function edit(Discount $discount)
    {
        $categories = Category::all();
        $products = Product::with('category')->get();
        return view('admin.discounts.edit', compact('discount', 'categories', 'products'));
    }

    public function update(Request $request, Discount $discount)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:discounts,code,' . $discount->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_purchase' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'per_user_limit' => 'nullable|integer|min:1',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after_or_equal:starts_at',
            'applies_to_all' => 'boolean',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'exists:categories,id',
            'product_ids' => 'nullable|array',
            'product_ids.*' => 'exists:products,id',
            'is_active' => 'boolean',
        ]);

        if ($validated['type'] === 'percentage' && $validated['value'] > 100) {
            return back()->withErrors(['value' => 'Percentage cannot exceed 100%'])->withInput();
        }

        $discount->update($validated);

        return redirect()->route('admin.discounts.index')
            ->with('success', 'Discount updated successfully!');
    }

    public function destroy(Discount $discount)
    {
        $discount->delete();
        
        return redirect()->route('admin.discounts.index')
            ->with('success', 'Discount deleted successfully!');
    }

    // Toggle active status
    public function toggleActive(Discount $discount)
    {
        $discount->update(['is_active' => !$discount->is_active]);
        
        return back()->with('success', 'Discount status updated!');
    }

    // Get usage statistics
    public function stats(Discount $discount)
    {
        // Get statistics directly from the pivot table
        $stats = [
            'total_usage' => DB::table('discount_user')
                ->where('discount_id', $discount->id)
                ->count(),
            
            'total_discount_given' => DB::table('discount_user')
                ->where('discount_id', $discount->id)
                ->sum('discount_amount'),
            
            'unique_users' => DB::table('discount_user')
                ->where('discount_id', $discount->id)
                ->whereNotNull('user_id')
                ->distinct('user_id')
                ->count(),
            
            'unique_sessions' => DB::table('discount_user')
                ->where('discount_id', $discount->id)
                ->whereNotNull('session_id')
                ->distinct('session_id')
                ->count(),
            
            'recent_uses' => DB::table('discount_user')
                ->where('discount_id', $discount->id)
                ->leftJoin('users', 'discount_user.user_id', '=', 'users.id')
                ->leftJoin('orders', 'discount_user.order_id', '=', 'orders.id')
                ->select(
                    'discount_user.*',
                    'users.name as user_name',
                    'users.email as user_email',
                    'orders.id as order_number',
                    'orders.total as order_total'
                )
                ->orderBy('discount_user.used_at', 'desc')
                ->limit(10)
                ->get(),
        ];

        return view('admin.discounts.stats', compact('discount', 'stats'));
    }
}