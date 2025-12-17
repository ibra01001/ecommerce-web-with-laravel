<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\Discount;
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
        ]);

        $cart = session('cart', []);
        
        if (empty($cart)) {
            return redirect()->back()->withErrors(['cart' => 'Your cart is empty.']);
        }

        DB::beginTransaction();
        
        try {
            // ONLY VALIDATE stock availability - DON'T DEDUCT IT YET
            foreach ($cart as $cartKey => $item) {
                $product = Product::find($item['product_id']);
                
                if (!$product) {
                    throw new \Exception("Product {$item['name']} not found.");
                }

                if ($item['stock_option_id']) {
                    // New dynamic stock system
                    $productStock = ProductStock::where('product_id', $product->id)
                        ->where('stock_type_option_id', $item['stock_option_id'])
                        ->first();

                    if (!$productStock || $productStock->quantity < $item['quantity']) {
                        $available = $productStock ? $productStock->quantity : 0;
                        throw new \Exception("Not enough stock for {$item['name']} ({$item['stock_label']}). Only {$available} available.");
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

            // Get discount from session (applied in cart)
            $discount = session('discount', []);
            $discount_amount = $discount['amount'] ?? 0;
            $coupon_code = $discount['code'] ?? null;
            $discount_id = $discount['id'] ?? null;

            // Validate discount one more time before creating order
            if ($discount_id) {
                $discountModel = Discount::find($discount_id);
                
                if ($discountModel) {
                    // Check if discount is still valid
                    if (!$discountModel->isValid()) {
                        session()->forget('discount');
                        throw new \Exception("The discount code has expired or is no longer valid.");
                    }

                    // Check usage limits again
                    $userId = Auth::id();
                    $sessionId = session()->getId();
                    
                    if (!$discountModel->canBeUsedBy($userId, $sessionId)) {
                        session()->forget('discount');
                        throw new \Exception("You have already used this discount code the maximum number of times.");
                    }
                }
            }

            // Create order with PENDING status
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
                'discount_id'     => $discount_id,
                'discount_amount' => $discount_amount,
                'coupon_code'     => $coupon_code,
                'shipping_cost'   => $shipping_cost,
                'total'           => $subtotal - $discount_amount + $shipping_cost,
                'status'          => Order::STATUS_PENDING, // Order starts as PENDING
            ]);

            // Create order items WITHOUT reducing stock
            foreach ($cart as $cartKey => $item) {
                OrderItem::create([
                    'order_id'         => $order->id,
                    'product_id'       => $item['product_id'],
                    'name'             => $item['name'],
                    'image'            => $item['image'],
                    'price'            => $item['price'],
                    'quantity'         => $item['quantity'],
                    'taille_type'      => $item['stock_label'],
                    'stock_option_id'  => $item['stock_option_id'], // Store this for later stock deduction
                ]);
            }

            // RECORD DISCOUNT USAGE
            if ($discount_id && $discount_amount > 0) {
                $discountModel = Discount::find($discount_id);
                if ($discountModel) {
                    $userId = Auth::id();
                    $sessionId = session()->getId();
                    
                    $discountModel->recordUsage(
                        $userId ?: null, 
                        $order->id, 
                        $discount_amount, 
                        $userId ? null : $sessionId
                    );
                }
            }

            DB::commit();

            // Clear cart and discount from session
            session()->forget('cart');
            session()->forget('discount');
            session()->forget('shipping_cost');
            
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