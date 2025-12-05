# Dynamic Stock Type System - Migration Guide

## Overview
This guide will help you migrate from the hardcoded stock system to the new dynamic stock type system.

## Step-by-Step Migration

### 1. Run Migrations

```bash
php artisan migrate
```

This will create:
- `stock_types` table
- `stock_type_options` table
- `product_stock` table
- Add `stock_type_id` column to `products` table

### 2. Seed Default Stock Types

```bash
php artisan db:seed --class=StockTypeSeeder
```

This creates default stock types:
- Clothing Sizes (S, M, L, XL, XXL)
- Shoe Sizes (EU 35-45)
- One Size
- Dumbbell Weights (example)

### 3. Migrate Existing Products (Optional)

If you have existing products, run this artisan command to migrate them:

```bash
php artisan migrate:products-to-dynamic-stock
```

**Or manually via Tinker:**

```bash
php artisan tinker
```

```php
// Get the clothing sizes stock type
$clothingSizes = App\Models\StockType::where('name', 'Clothing Sizes')->first();
$oneSize = App\Models\StockType::where('name', 'One Size')->first();

// Migrate size-based products
$sizeBased = App\Models\Product::where('stock_type', 'size-based')->get();

foreach ($sizeBased as $product) {
    $product->stock_type_id = $clothingSizes->id;
    $product->save();
    
    // Create stock entries for each size
    $sizes = ['S', 'M', 'L', 'XL', 'XXL'];
    foreach ($sizes as $size) {
        $option = $clothingSizes->options()->where('label', $size)->first();
        $sizeField = 'taille_' . $size;
        
        App\Models\ProductStock::create([
            'product_id' => $product->id,
            'stock_type_option_id' => $option->id,
            'quantity' => $product->$sizeField ?? 0,
        ]);
    }
}

// Migrate total-stock products
$totalStock = App\Models\Product::where('stock_type', 'total')->get();

foreach ($totalStock as $product) {
    $product->stock_type_id = $oneSize->id;
    $product->save();
    
    $option = $oneSize->options()->first();
    
    App\Models\ProductStock::create([
        'product_id' => $product->id,
        'stock_type_option_id' => $option->id,
        'quantity' => $product->total_quantity ?? 0,
    ]);
}
```

### 4. Update Navigation (Optional)

Add link to stock types management in your admin sidebar/navigation:

```blade
<a href="{{ route('admin.stock-types.index') }}">
    <x-heroicon-o-squares-2x2 class="w-5 h-5" />
    Stock Types
</a>
```

### 5. Clean Up Old Columns (After Testing)

Once you've confirmed everything works, you can drop the old columns:

```bash
php artisan make:migration remove_old_stock_columns_from_products
```

```php
public function up(): void
{
    Schema::table('products', function (Blueprint $table) {
        $table->dropColumn([
            'stock_type',
            'total_quantity',
            'taille_S',
            'taille_M',
            'taille_L',
            'taille_XL',
            'taille_XXL',
        ]);
    });
}
```

## Testing Checklist

- [ ] Create a new stock type in admin
- [ ] Add options to the stock type
- [ ] Create a product using the new stock type
- [ ] Add product to cart from frontend
- [ ] Complete checkout process
- [ ] Verify stock was deducted correctly
- [ ] Test editing stock quantities
- [ ] Test deleting stock type (should prevent if used)
- [ ] Test all display types (grid, dropdown, color-swatch, none)

## Backward Compatibility

The system maintains backward compatibility during migration:
- Old products still work through the `Product::getTotalStockAttribute()` method
- Cart and checkout controllers handle both old and new systems
- You can migrate products gradually

## Creating Custom Stock Types

### Example 1: T-Shirt Colors
1. Go to Admin → Stock Types → Create
2. Name: "T-Shirt Colors"
3. Display Type: "Color Swatch"
4. Add options:
   - Red (#FF0000)
   - Blue (#0000FF)
   - Black (#000000)

### Example 2: Bottle Sizes
1. Name: "Bottle Sizes"
2. Display Type: "Dropdown"
3. Add options:
   - 250ml
   - 500ml
   - 750ml
   - 1L

### Example 3: Ring Sizes
1. Name: "Ring Sizes"
2. Display Type: "Dropdown"
3. Add options:
   - Size 5
   - Size 6
   - Size 7
   - Size 8

## Troubleshooting

**Problem:** Stock not updating after order
- **Solution:** Check that `ProductStock::decreaseStock()` is being called in checkout

**Problem:** Old products show 0 stock
- **Solution:** Run the migration script to transfer old stock data

**Problem:** Can't delete stock type
- **Solution:** Ensure no products are using it, or reassign products first

## Support

If you encounter issues during migration:
1. Check Laravel logs: `storage/logs/laravel.log`
2. Verify database migrations completed successfully
3. Ensure all relationships are loaded in queries using `->with()`