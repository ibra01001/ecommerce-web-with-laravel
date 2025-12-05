<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductStock;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Wilaya;
use App\Models\Commune;

class CheckoutController extends Controller
{
    public function create()
    {
        $cart = session('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Your cart is empty.');
        }

        $wilayas = Wilaya::orderBy('code')->get();
        $communes = Commune::orderBy('name')->get();
        $shipping_cost = 0;
        
        return view('checkout.billing-and-shipping', compact('wilayas', 'communes', 'shipping_cost', 'cart'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:120',
            'last_name'  => 'required|string|max:120',
            'phone'      => ['required','digits:10'],
            'email'      => 'required|email',
            'wilaya'     => 'required|string|max:120',
            'commune'    => 'required|string|max:120',
            'address'    => 'required|string|max:255',
            'notes'      => 'nullable|string|max:1000',
            'coupon_code' => 'nullable|string',
        ]);

        $cart = session('cart', []);
        
        if (empty($cart)) {
            return redirect()->back()->withErrors(['cart' => 'Your cart is empty.']);
        }

        DB::beginTransaction();
        
        try {
            // Validate stock availability
            foreach ($cart as $cartKey => $item) {
                $product = Product::find($item['product_id']);
                
                if (!$product) {
                    throw new \Exception("Product {$item['name']} not found.");
                }

                if ($item['stock_option_id']) {
                    // New dynamic stock system
                    $productStock = ProductStock::where('product_id', $product->id)
                        ->where('stock_type_option_id', $item['stock_option_id'])
                        ->lockForUpdate()
                        ->first();

                    if (!$productStock || $productStock->quantity < $item['quantity']) {
                        throw new \Exception("Not enough stock for {$item['name']} ({$item['stock_label']}). Only {$productStock->quantity} available.");
                    }
                } else {
                    // Old system fallback
                    if ($product->stock_type === 'size-based') {
                        $size = str_replace('old_', '', $item['stock_option_id']);
                        $sizeField = 'taille_' . strtoupper($size);
                        
                        if ($product->$sizeField < $item['quantity']) {
                            throw new \Exception("Not enough stock for {$item['name']} in size {$size}. Only {$product->$sizeField} available.");
                        }
                    } else {
                        if ($product->total_quantity < $item['quantity']) {
                            throw new \Exception("Not enough stock for {$item['name']}. Only {$product->total_quantity} available.");
                        }
                    }
                }
            }

            $wilaya = Wilaya::where('name', $data['wilaya'])->first();
            $shipping_cost = $wilaya ? $wilaya->shipping_cost : 0;

            // Calculate subtotal
            $subtotal = 0;
            foreach ($cart as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }

            // Apply discount if coupon exists
            $discount_amount = 0;
            $coupon_code = null;
            if (!empty($data['coupon_code'])) {
                // Add your coupon validation logic here
                // For now, this is a placeholder
                $coupon_code = $data['coupon_code'];
                // $discount_amount = calculate discount based on coupon
            }

            // Create order
            $order = Order::create([
                'user_id'         => Auth::id(),
                'first_name'      => $data['first_name'],
                'last_name'       => $data['last_name'],
                'phone'           => $data['phone'],
                'email'           => $data['email'],
                'wilaya'          => $data['wilaya'],
                'commune'         => $data['commune'],
                'address'         => $data['address'],
                'notes'           => $data['notes'] ?? null,
                'subtotal'        => $subtotal,
                'discount_amount' => $discount_amount,
                'coupon_code'     => $coupon_code,
                'shipping_cost'   => $shipping_cost,
                'total'           => $subtotal - $discount_amount + $shipping_cost,
                'status'          => Order::STATUS_PENDING,
            ]);

            // Create order items and update stock
            foreach ($cart as $cartKey => $item) {
                $product = Product::findOrFail($item['product_id']);
                
                // Reduce stock
                if ($item['stock_option_id']) {
                    $productStock = ProductStock::where('product_id', $product->id)
                        ->where('stock_type_option_id', $item['stock_option_id'])
                        ->first();
                    
                    $productStock->decreaseStock($item['quantity']);
                } else {
                    // Old system
                    if ($product->stock_type === 'size-based') {
                        $size = str_replace('old_', '', $item['stock_option_id']);
                        $sizeField = 'taille_' . strtoupper($size);
                        $product->$sizeField -= $item['quantity'];
                    } else {
                        $product->total_quantity -= $item['quantity'];
                    }
                    $product->save();
                }

                // Create order item
                OrderItem::create([
                    'order_id'    => $order->id,
                    'product_id'  => $item['product_id'],
                    'name'        => $item['name'],
                    'image'       => $item['image'],
                    'price'       => $item['price'],
                    'quantity'    => $item['quantity'],
                    'taille_type' => $item['stock_label'],
                ]);
            }

            DB::commit();

            // Clear cart
            session()->forget('cart');
            
            return redirect()->route('order.thankyou', $order->id);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->withErrors(['stock' => $e->getMessage()])
                ->withInput();
        }
    }

    public function thankyou(Order $order)
    {
        return view('checkout.thankyou', compact('order'));
    }
}