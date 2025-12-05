<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use App\Models\Product;
use App\Models\Category;
use App\Models\StockType;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'stockType'])->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

public function create()
{
    $categories = Category::all();
    $stockTypes = StockType::with('activeOptions')->where('is_active', true)->get();
    
    // Prepare stock types data for JavaScript
    $stockTypesJson = $stockTypes->map(function($type) {
        return [
            'id' => $type->id,
            'name' => $type->name,
            'display_type' => $type->display_type,
            'options' => $type->activeOptions->map(function($opt) {
                return [
                    'id' => $opt->id,
                    'label' => $opt->label,
                    'value' => $opt->value
                ];
            })->values()
        ];
    })->values();
    
    return view('admin.products.create', compact('categories', 'stockTypes', 'stockTypesJson'));
}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock_type_id' => 'required|exists:stock_types,id',
            'image' => 'nullable|image|max:2048',
            'stock' => 'required|array',
            'stock.*' => 'required|integer|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Handle image upload
            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('products', 'public');
            }

            // Create product
            $product = Product::create([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'category_id' => $validated['category_id'],
                'stock_type_id' => $validated['stock_type_id'],
                'price' => $validated['price'],
                'image' => $validated['image'] ?? null,
            ]);

            // Create stock entries for each option
            foreach ($validated['stock'] as $optionId => $quantity) {
                ProductStock::create([
                    'product_id' => $product->id,
                    'stock_type_option_id' => $optionId,
                    'quantity' => $quantity,
                ]);
            }

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Product created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            
            // Delete uploaded image if exists
            if (isset($validated['image'])) {
                Storage::disk('public')->delete($validated['image']);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create product: ' . $e->getMessage());
        }
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $stockTypes = StockType::active()->with('activeOptions')->get();
        $product->load(['stockType.options', 'stock.stockTypeOption']);
        
        return view('admin.products.edit', compact('product', 'categories', 'stockTypes'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock_type_id' => 'required|exists:stock_types,id',
            'image' => 'nullable|image|max:2048',
            'stock' => 'required|array',
            'stock.*' => 'required|integer|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Handle image upload
            if ($request->hasFile('image')) {
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }
                $validated['image'] = $request->file('image')->store('products', 'public');
            }

            // Update product
            $product->update([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'category_id' => $validated['category_id'],
                'stock_type_id' => $validated['stock_type_id'],
                'price' => $validated['price'],
                'image' => $validated['image'] ?? $product->image,
            ]);

            // If stock type changed, delete old stock entries
            if ($product->wasChanged('stock_type_id')) {
                $product->stock()->delete();
            }

            // Update or create stock entries
            foreach ($validated['stock'] as $optionId => $quantity) {
                ProductStock::updateOrCreate(
                    [
                        'product_id' => $product->id,
                        'stock_type_option_id' => $optionId,
                    ],
                    [
                        'quantity' => $quantity,
                    ]
                );
            }

            // Delete stock entries that are no longer needed
            $product->stock()
                ->whereNotIn('stock_type_option_id', array_keys($validated['stock']))
                ->delete();

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Product updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update product: ' . $e->getMessage());
        }
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted.');
    }
}