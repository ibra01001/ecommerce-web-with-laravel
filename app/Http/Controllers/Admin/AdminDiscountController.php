<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDiscountController extends Controller
{
    public function index()
    {
        $discounts = Discount::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.discounts.index', compact('discounts'));
    }

    public function toggleActive(Discount $discount)
    {
        $discount->update([
            'is_active' => !$discount->is_active
        ]);

        $status = $discount->is_active ? 'activated' : 'deactivated';
        
        return redirect()->route('admin.discounts.index')
            ->with('success', "Discount '{$discount->code}' has been {$status} successfully.");
    }

    public function create()
    {
        $categories = Category::all();
        $products = Product::with('category')->get();
        return view('admin.discounts.create', compact('categories', 'products'));
    }

    public function store(Request $request)
    {
        // FIXED: Custom validation based on applies_to_all
        $rules = [
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
            'applies_to_all' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ];

        // FIXED: Only require category/product IDs if NOT applying to all
        if (!$request->has('applies_to_all')) {
            $rules['category_ids'] = 'required_without:product_ids|array';
            $rules['category_ids.*'] = 'exists:categories,id';
            $rules['product_ids'] = 'required_without:category_ids|array';
            $rules['product_ids.*'] = 'exists:products,id';
        } else {
            $rules['category_ids'] = 'nullable|array';
            $rules['category_ids.*'] = 'exists:categories,id';
            $rules['product_ids'] = 'nullable|array';
            $rules['product_ids.*'] = 'exists:products,id';
        }

        $validated = $request->validate($rules);

        $validated['code'] = strtoupper($validated['code']);
        $validated['applies_to_all'] = $request->has('applies_to_all');
        $validated['is_active'] = $request->has('is_active');

        // FIXED: Clear category_ids and product_ids if applies_to_all is true
        if ($validated['applies_to_all']) {
            $validated['category_ids'] = null;
            $validated['product_ids'] = null;
        }

        Discount::create($validated);

        return redirect()->route('admin.discounts.index')
            ->with('success', 'Discount created successfully.');
    }

    public function show(Discount $discount)
    {
        $usageData = DB::table('discount_user')
            ->leftJoin('users', 'discount_user.user_id', '=', 'users.id')
            ->leftJoin('orders', 'discount_user.order_id', '=', 'orders.id')
            ->where('discount_user.discount_id', '=', $discount->id)
            ->select(
                'discount_user.*',
                'users.name as user_name',
                'users.email as user_email',
                'orders.id as order_number',
                'orders.total as order_total'
            )
            ->orderBy('discount_user.used_at', 'desc')
            ->get();

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
        // FIXED: Custom validation based on applies_to_all
        $rules = [
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
            'applies_to_all' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ];

        // FIXED: Only require category/product IDs if NOT applying to all
        if (!$request->has('applies_to_all')) {
            $rules['category_ids'] = 'required_without:product_ids|array';
            $rules['category_ids.*'] = 'exists:categories,id';
            $rules['product_ids'] = 'required_without:category_ids|array';
            $rules['product_ids.*'] = 'exists:products,id';
        } else {
            $rules['category_ids'] = 'nullable|array';
            $rules['category_ids.*'] = 'exists:categories,id';
            $rules['product_ids'] = 'nullable|array';
            $rules['product_ids.*'] = 'exists:products,id';
        }

        $validated = $request->validate($rules);

        $validated['code'] = strtoupper($validated['code']);
        $validated['applies_to_all'] = $request->has('applies_to_all');
        $validated['is_active'] = $request->has('is_active');

        // FIXED: Clear category_ids and product_ids if applies_to_all is true
        if ($validated['applies_to_all']) {
            $validated['category_ids'] = null;
            $validated['product_ids'] = null;
        }

        $discount->update($validated);

        return redirect()->route('admin.discounts.index')
            ->with('success', 'Discount updated successfully.');
    }

    public function destroy(Discount $discount)
    {
        $discount->delete();

        return redirect()->route('admin.discounts.index')
            ->with('success', 'Discount deleted successfully.');
    }
}