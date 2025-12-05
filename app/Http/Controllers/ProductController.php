<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Show all products with optional category filter
public function index(Request $request)
{
    // Get all categories for the filter menu
    $categories = Category::all();
    
    // Get products with optional category filtering and pagination
    $products = Product::with('category')
        ->when($request->category, function($query, $categoryId) {
            $query->where('category_id', $categoryId);
        })
        ->paginate(12) // Change from ->get() to ->paginate(12)
        ->appends($request->query()); // Preserve query parameters
    
    return view('products.index', compact('products', 'categories'));
}

    // Show create product form
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    // Store product
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock_type' => 'required|in:size-based,total',
            'total_quantity' => 'required_if:stock_type,total|nullable|integer|min:0',
            'taille_S' => 'required_if:stock_type,size-based|nullable|integer|min:0',
            'taille_M' => 'required_if:stock_type,size-based|nullable|integer|min:0',
            'taille_L' => 'required_if:stock_type,size-based|nullable|integer|min:0',
            'taille_XL' => 'required_if:stock_type,size-based|nullable|integer|min:0',
            'taille_XXL' => 'required_if:stock_type,size-based|nullable|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Set default values based on stock_type
        if ($validated['stock_type'] === 'total') {
            $validated['taille_S'] = 0;
            $validated['taille_M'] = 0;
            $validated['taille_L'] = 0;
            $validated['taille_XL'] = 0;
            $validated['taille_XXL'] = 0;
        } else {
            $validated['total_quantity'] = 0;
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        Product::create($validated);

        return redirect()->route('products.index')
            ->with('success', 'Product added successfully!');
    }

    // Show single product with related products
    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        
        // Get related products from the same category
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where(function($query) {
                $query->where('stock_type', 'total')
                    ->where('total_quantity', '>', 0)
                    ->orWhere(function($q) {
                        $q->where('stock_type', 'size-based')
                          ->whereRaw('(taille_S + taille_M + taille_L + taille_XL + taille_XXL) > 0');
                    });
            })
            ->limit(4)
            ->get();
        
        return view('products.show', compact('product', 'relatedProducts'));
    }

    // Update product
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock_type' => 'required|in:size-based,total',
            'total_quantity' => 'required_if:stock_type,total|nullable|integer|min:0',
            'taille_S' => 'required_if:stock_type,size-based|nullable|integer|min:0',
            'taille_M' => 'required_if:stock_type,size-based|nullable|integer|min:0',
            'taille_L' => 'required_if:stock_type,size-based|nullable|integer|min:0',
            'taille_XL' => 'required_if:stock_type,size-based|nullable|integer|min:0',
            'taille_XXL' => 'required_if:stock_type,size-based|nullable|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($validated['stock_type'] === 'total') {
            $validated['taille_S'] = 0;
            $validated['taille_M'] = 0;
            $validated['taille_L'] = 0;
            $validated['taille_XL'] = 0;
            $validated['taille_XXL'] = 0;
        } else {
            $validated['total_quantity'] = 0;
        }

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image) {
                \Storage::disk('public')->delete($product->image);
            }
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        $product->update($validated);

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully!');
    }

    // Delete product
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Delete image if exists
        if ($product->image) {
            \Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully!');
    }
}