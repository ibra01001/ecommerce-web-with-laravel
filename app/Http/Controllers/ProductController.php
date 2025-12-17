<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Show all products with optional category filter and search
    public function index(Request $request)
    {
        // Get all categories for the filter menu
        $categories = Category::all();
        
        // Start building the query
        $query = Product::with(['category', 'images', 'stock.stockTypeOption']);
        
        // Category filter
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }
        
        // Search functionality
        if ($request->has('q') && $request->q != '') {
            $searchTerm = $request->q;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }
        
        // Order by newest first
        $query->orderBy('created_at', 'desc');
        
        // Paginate results and preserve query parameters
        $products = $query->paginate(12)->appends($request->query());
        
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
        $product = Product::with(['category', 'images', 'stockType', 'stock.stockTypeOption'])
            ->findOrFail($id);
        
        // Prepare images collection
        $images = $product->images->count() ? $product->images : collect();
        if($images->isEmpty() && $product->image) {
            $images = collect([(object)[
                'image_url' => asset('storage/' . $product->image), 
                'id' => 0
            ]]);
        }
        
        // Get related products from the same category that are in stock
        $relatedProducts = Product::with(['images', 'category', 'stock'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->whereHas('stock', function($query) {
                $query->where('quantity', '>', 0);
            })
            ->orWhere(function($query) use ($product) {
                $query->where('category_id', $product->category_id)
                      ->where('id', '!=', $product->id)
                      ->where('stock_type', 'total')
                      ->where('total_quantity', '>', 0);
            })
            ->orWhere(function($query) use ($product) {
                $query->where('category_id', $product->category_id)
                      ->where('id', '!=', $product->id)
                      ->where('stock_type', 'size-based')
                      ->whereRaw('(taille_S + taille_M + taille_L + taille_XL + taille_XXL) > 0');
            })
            ->inRandomOrder()
            ->limit(4)
            ->get();
        
        return view('products.show', compact('product', 'images', 'relatedProducts'));
    }

    // API endpoint for product options (for quick buy modal)
   public function getOptions($id)
{
    $product = Product::with(['stock.stockTypeOption'])->findOrFail($id);
    
    $options = [];
    
    // New dynamic stock system
    if ($product->usesDynamicStock()) {
        $stockOptions = $product->getAvailableStockOptions();
        foreach ($stockOptions as $option) {
            $options[] = [
                'id' => $option['id'],  // This is now the stock_type_option_id (integer)
                'label' => $option['label'],
                'quantity' => $option['quantity'],
                'in_stock' => $option['in_stock']
            ];
        }
        return response()->json(['options' => $options]);
    }
    
    // If product doesn't use dynamic stock, return empty (they shouldn't need options)
    return response()->json(['options' => []]);
}
    // Show edit form
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
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