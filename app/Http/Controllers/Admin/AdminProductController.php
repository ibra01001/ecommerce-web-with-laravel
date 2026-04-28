<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\StockType;
use App\Models\ProductImage;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'stockType', 'images'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $stockTypes = StockType::with('activeOptions')->get();

        return view('admin.products.create', compact('categories', 'stockTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock_type_id' => 'required|exists:stock_types,id',
            'stock' => 'nullable|array',
            'stock.*' => 'nullable|integer|min:0',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        DB::beginTransaction();

        try {
            // Create the product
            $product = Product::create([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'category_id' => $validated['category_id'],
                'price' => $validated['price'],
                'stock_type_id' => $validated['stock_type_id'],
            ]);

            // Handle stock creation
            if (isset($validated['stock']) && is_array($validated['stock'])) {
                foreach ($validated['stock'] as $optionId => $quantity) {
                    ProductStock::create([
                        'product_id' => $product->id,
                        'stock_type_option_id' => $optionId,
                        'quantity' => $quantity ?? 0,
                    ]);
                }
            }

            // Handle image uploads
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {
                    $path = $image->store('products', 'public');

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'sort_order' => $index + 1,
                        'is_primary' => $index === 0,
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Product created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create product: ' . $e->getMessage()]);
        }
    }

    public function show(Product $product)
    {
        $product->load(['category', 'stockType', 'images', 'stock.stockTypeOption']);

        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $stockTypes = StockType::with('activeOptions')->get();

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
            'stock' => 'nullable|array',
            'stock.*' => 'nullable|integer|min:0',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'nullable|exists:product_images,id',
        ]);

        DB::beginTransaction();

        try {
            // Update basic product info
            $product->update([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'category_id' => $validated['category_id'],
                'price' => $validated['price'],
                'stock_type_id' => $validated['stock_type_id'],
            ]);

            // Handle stock updates
            if (isset($validated['stock']) && is_array($validated['stock'])) {
                foreach ($validated['stock'] as $optionId => $quantity) {
                    ProductStock::updateOrCreate(
                        [
                            'product_id' => $product->id,
                            'stock_type_option_id' => $optionId,
                        ],
                        [
                            'quantity' => $quantity ?? 0,
                        ]
                    );
                }
            }

            // Handle image deletions
            if ($request->has('delete_images') && is_array($request->delete_images)) {
                foreach ($request->delete_images as $imageId) {
                    $image = ProductImage::where('id', $imageId)
                        ->where('product_id', $product->id)
                        ->first();

                    if ($image) {
                        if (Storage::disk('public')->exists($image->image_path)) {
                            Storage::disk('public')->delete($image->image_path);
                        }
                        $image->delete();
                    }
                }

                // Set new primary if needed
                if (!$product->images()->where('is_primary', true)->exists()) {
                    $firstImage = $product->images()->first();
                    if ($firstImage) {
                        $firstImage->update(['is_primary' => true]);
                    }
                }
            }

            // Handle new image uploads
            if ($request->hasFile('images')) {
                $existingImagesCount = $product->images()->count();
                $sortOrder = $product->images()->max('sort_order') ?? 0;

                foreach ($request->file('images') as $index => $image) {
                    $path = $image->store('products', 'public');
                    $isPrimary = ($existingImagesCount === 0 && $index === 0);

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'sort_order' => ++$sortOrder,
                        'is_primary' => $isPrimary,
                    ]);

                    $existingImagesCount++;
                }
            }

            DB::commit();

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Product updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to update product: ' . $e->getMessage()]);
        }
    }

    public function destroy(Product $product)
    {
        DB::beginTransaction();

        try {
            // Delete all product images
            foreach ($product->images as $image) {
                if (Storage::disk('public')->exists($image->image_path)) {
                    Storage::disk('public')->delete($image->image_path);
                }
                $image->delete();
            }

            // Delete legacy image if exists
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            // Delete product stock records
            $product->stock()->delete();

            // Delete the product
            $product->delete();

            DB::commit();

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Product deleted successfully!');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withErrors(['error' => 'Failed to delete product: ' . $e->getMessage()]);
        }
    }

    /**
     * Delete multiple products
     */
    public function destroyMultiple(Request $request)
    {
        $ids = json_decode($request->input('product_ids', '[]'), true);

        if (!is_array($ids)) {
            $ids = [];
        }

        DB::beginTransaction();

        try {
            $products = Product::whereIn('id', $ids)->get();

            foreach ($products as $product) {
                // Delete all product images
                foreach ($product->images as $image) {
                    if (Storage::disk('public')->exists($image->image_path)) {
                        Storage::disk('public')->delete($image->image_path);
                    }
                    $image->delete();
                }

                // Delete legacy image if exists
                if ($product->image && Storage::disk('public')->exists($product->image)) {
                    Storage::disk('public')->delete($product->image);
                }

                // Delete product stock records
                $product->stock()->delete();

                // Delete the product
                $product->delete();
            }

            DB::commit();

            return back()->with('success', count($ids) . ' product(s) deleted successfully');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors(['error' => 'Failed to delete products: ' . $e->getMessage()]);
        }
    }
}