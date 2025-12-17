<?php

namespace App\Http\Controllers;


use App\Models\StockTypeOption;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Discount;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return view('cart.index', compact('cart', 'total'));
    }
 
   public function add(Request $request, $id)
{
    $product = Product::with(['stockType', 'stock.stockTypeOption'])->findOrFail($id);
    
    // Validate request
    $validated = $request->validate([
        'quantity' => 'required|integer|min:1',
        'stock_option_id' => 'nullable|integer',
    ]);

    $requestedQty = $validated['quantity'];

    // Handle dynamic stock products
    if ($product->usesDynamicStock()) {
        // Check if stock option is required
        if ($product->stockType->display_type !== 'none' && empty($validated['stock_option_id'])) {
            return redirect()->back()->with('error', 'Please select an option');
        }

        // Get the stock option
        if (!empty($validated['stock_option_id'])) {
            $stockOption = StockTypeOption::findOrFail($validated['stock_option_id']);
            
            // Verify it belongs to this product's stock type
            if ($stockOption->stock_type_id !== $product->stock_type_id) {
                return redirect()->back()->with('error', 'Invalid stock option');
            }

            // Get the product stock for this option
            $productStock = ProductStock::where('product_id', $product->id)
                ->where('stock_type_option_id', $stockOption->id)
                ->first();

            if (!$productStock) {
                return redirect()->back()->with('error', 'Stock information not found');
            }

            $stockLabel = $stockOption->label;
            $stockOptionId = $stockOption->id;
            $availableStock = $productStock->quantity;
        } else {
            // "One Size" product with dynamic stock (display_type = 'none')
            $stockOption = $product->stockType->options()->first();
            
            if (!$stockOption) {
                return redirect()->back()->with('error', 'Stock option not found');
            }

            $productStock = ProductStock::where('product_id', $product->id)
                ->where('stock_type_option_id', $stockOption->id)
                ->first();

            if (!$productStock) {
                return redirect()->back()->with('error', 'Stock information not found');
            }

            $stockLabel = 'One Size';
            $stockOptionId = $stockOption->id;
            $availableStock = $productStock->quantity;
        }

        // Create unique cart key
        $cartKey = $id . '-' . $stockOptionId;
        $cart = session()->get('cart', []);

        // Calculate quantity already in cart for this item
        $qtyInCart = isset($cart[$cartKey]) ? $cart[$cartKey]['quantity'] : 0;
        $totalQtyNeeded = $qtyInCart + $requestedQty;

        // Check if total quantity exceeds available stock
        if ($totalQtyNeeded > $availableStock) {
            $remaining = $availableStock - $qtyInCart;
            if ($remaining <= 0) {
                return redirect()->back()->with('error', "No more stock available for {$stockLabel}. You already have the maximum quantity in your cart.");
            }
            return redirect()->back()->with('error', "Only {$remaining} more available for {$stockLabel}. You already have {$qtyInCart} in your cart.");
        }

        // Check if enough stock is available for the requested quantity
        if ($availableStock < $requestedQty) {
            return redirect()->back()->with('error', "Not enough stock available for {$stockLabel}. Only {$availableStock} available.");
        }

        if (isset($cart[$cartKey])) {
            // Item already in cart, increase quantity
            $cart[$cartKey]['quantity'] = $totalQtyNeeded;
        } else {
            // Add new item to cart
            $cart[$cartKey] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => (float)$product->price,
                'quantity' => $requestedQty,
                'stock_option_id' => $stockOptionId,
                'stock_label' => $stockLabel,
                'image' => $product->image,
                'max_stock' => $availableStock, // Store max stock for validation
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart!');
    }

    // Handle legacy total stock products
    $availableStock = $product->total_stock;
    $cartKey = $id . '-default';
    $cart = session()->get('cart', []);

    // Calculate quantity already in cart
    $qtyInCart = isset($cart[$cartKey]) ? $cart[$cartKey]['quantity'] : 0;
    $totalQtyNeeded = $qtyInCart + $requestedQty;

    // Check if total quantity exceeds available stock
    if ($totalQtyNeeded > $availableStock) {
        $remaining = $availableStock - $qtyInCart;
        if ($remaining <= 0) {
            return redirect()->back()->with('error', 'No more stock available. You already have the maximum quantity in your cart.');
        }
        return redirect()->back()->with('error', "Only {$remaining} more available. You already have {$qtyInCart} in your cart.");
    }

    if ($availableStock < $requestedQty) {
        return redirect()->back()->with('error', "Not enough stock available. Only {$availableStock} available.");
    }

    if (isset($cart[$cartKey])) {
        $cart[$cartKey]['quantity'] = $totalQtyNeeded;
    } else {
        $cart[$cartKey] = [
            'product_id' => $product->id,
            'name' => $product->name,
            'price' => (float)$product->price,
            'quantity' => $requestedQty,
            'stock_option_id' => null,
            'stock_label' => 'One Size',
            'image' => $product->image,
            'max_stock' => $availableStock, // Store max stock
        ];
    }

    session()->put('cart', $cart);
    return redirect()->back()->with('success', 'Product added to cart!');
}

    public function update(Request $request, $cartKey)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$cartKey])) {
            $product = Product::find($cart[$cartKey]['product_id']);
            
            if ($product) {
                // Check stock based on type
                if ($product->usesDynamicStock() && !empty($cart[$cartKey]['stock_option_id'])) {
                    $productStock = ProductStock::where('product_id', $product->id)
                        ->where('stock_type_option_id', $cart[$cartKey]['stock_option_id'])
                        ->first();
                    
                    if ($productStock && $validated['quantity'] > $productStock->quantity) {
                        return redirect()->back()->with('error', 'Not enough stock for ' . $cart[$cartKey]['stock_label']);
                    }
                } else {
                    if ($validated['quantity'] > $product->total_stock) {
                        return redirect()->back()->with('error', 'Not enough stock available');
                    }
                }
                
                $cart[$cartKey]['quantity'] = $validated['quantity'];
                session()->put('cart', $cart);
                
                return redirect()->back()->with('success', 'Cart updated successfully!');
            }
        }

        return redirect()->back()->with('error', 'Item not found in cart');
    }

    public function remove($cartKey)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$cartKey])) {
            unset($cart[$cartKey]);
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Item removed from cart');
        }

        return redirect()->back()->with('error', 'Item not found in cart');
    }

    public function clear()
    {
        session()->forget('cart');
        session()->forget('discount');
        return redirect()->back()->with('success', 'Cart cleared successfully!');
    }

    // Apply discount code
    public function applyDiscount(Request $request)
    {
        $request->validate([
            'code' => 'required|string'
        ]);

        $code = strtoupper(trim($request->code));
        $discount = Discount::where('code', $code)->first();

        if (!$discount) {
            return back()->with('error', 'Invalid discount code.');
        }

        if (!$discount->isValid()) {
            return back()->with('error', 'This discount code has expired or is no longer valid.');
        }

        $userId = auth()->id();
        $sessionId = session()->getId();

        if (!$discount->canBeUsedBy($userId)) {
            return back()->with('error', 'You have already used this discount code the maximum number of times.');
        }

        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return back()->with('error', 'Your cart is empty.');
        }

        if (!$discount->appliesTo($cart)) {
            return back()->with('error', 'This discount does not apply to items in your cart.');
        }

        // Calculate subtotal
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $discountAmount = $discount->calculateDiscount($subtotal);

        if ($discountAmount <= 0) {
            if ($discount->min_purchase) {
                $minPurchase = (float)$discount->min_purchase;
                return back()->with('error', "Minimum purchase of " . number_format($minPurchase, 2) . " DA required.");
            }
            return back()->with('error', 'This discount cannot be applied to your cart.');
        }

        // Store discount in session
        session()->put('discount', [
            'id' => $discount->id,
            'code' => $discount->code,
            'type' => $discount->type,
            'value' => (float)$discount->value,
            'amount' => $discountAmount,
        ]);

        return back()->with('success', "Discount code '{$code}' applied! You saved " . number_format($discountAmount, 2) . " DA");
    }

    // Remove discount
    public function removeDiscount()
    {
        session()->forget('discount');
        return back()->with('success', 'Discount removed.');
    }

    // Helper to get cart totals with discount
    public static function getCartTotals()
    {
        $cart = session()->get('cart', []);
        $discount = session()->get('discount');

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $discountAmount = 0;
        if ($discount) {
            $discountAmount = $discount['amount'] ?? 0;
        }

        $shipping = session()->get('shipping_cost', 0);
        $total = $subtotal - $discountAmount + $shipping;

        return [
            'subtotal' => $subtotal,
            'discount' => $discountAmount,
            'shipping' => $shipping,
            'total' => max($total, 0),
        ];
    }
}