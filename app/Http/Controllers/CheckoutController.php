<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Wilaya;

class CheckoutController extends Controller
{
    public function create()
    {
        // Check if cart exists and has items
        $cart = session('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Your cart is empty.');
        }

        $wilayas = Wilaya::orderBy('code')->get();
        $shipping_cost = 0;
        
        return view('checkout.billing-and-shipping', compact('wilayas', 'shipping_cost', 'cart'));
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

        // Validate stock availability for each item
        foreach ($cart as $cartKey => $item) {
            // Extract numeric product ID from cart key (e.g., "1_L" -> 1)
            $numericProductId = (int) explode('_', $cartKey)[0];
            
            $product = Product::find($numericProductId);
            
            if (!$product) {
                return redirect()->back()->withErrors([
                    'stock' => "Product {$item['name']} not found."
                ]);
            }

            // Check if taille_type exists and is valid
            if (!isset($item['taille_type'])) {
                return redirect()->back()->withErrors([
                    'stock' => "Size not selected for {$item['name']}."
                ]);
            }

            $sizeField = 'taille_' . strtoupper($item['taille_type']);
            
            // Check if the size field exists on the product
            if (!property_exists($product, $sizeField) && !isset($product->$sizeField)) {
                return redirect()->back()->withErrors([
                    'stock' => "Invalid size for {$item['name']}."
                ]);
            }

            // Check stock availability
            if ($product->$sizeField < $item['quantity']) {
                return redirect()->back()->withErrors([
                    'stock' => "Not enough stock for {$item['name']} in size {$item['taille_type']}. Only {$product->$sizeField} available."
                ]);
            }
        }

        $wilaya = Wilaya::where('name', $data['wilaya'])->first();
        $shipping_cost = $wilaya ? $wilaya->shipping_cost : 0;

        // Calculate totals
        $subtotal = 0;
        foreach ($cart as $cartKey => $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $order = Order::create([
            'user_id'       => Auth::id(),
            'first_name'    => $data['first_name'],
            'last_name'     => $data['last_name'],
            'phone'         => $data['phone'],
            'email'         => $data['email'],
            'wilaya'        => $data['wilaya'],
            'commune'       => $data['commune'],
            'address'       => $data['address'],
            'notes'         => $data['notes'] ?? null,
            'subtotal'      => $subtotal,
            'shipping_cost' => $shipping_cost,
            'total'         => $subtotal + $shipping_cost,
            'status'        => 'pending',
        ]);

        foreach ($cart as $cartKey => $item) {
            // Extract numeric product ID from cart key (e.g., "1_L" -> 1)
            $numericProductId = (int) explode('_', $cartKey)[0];
            
            $product = Product::findOrFail($numericProductId);
            
            // Reduce stock
            $sizeField = 'taille_' . strtoupper($item['taille_type']);
            $product->$sizeField -= $item['quantity'];
            $product->save();

            OrderItem::create([
                'order_id'    => $order->id,
                'product_id'  => $numericProductId, // Use numeric ID, not the composite key
                'name'        => $item['name'] ?? null,
                'image'       => $item['image'] ?? null,
                'price'       => $item['price'],
                'quantity'    => $item['quantity'],
                'taille_type' => $item['taille_type'],
            ]);
        }

        session()->forget('cart');
        
        return redirect()->route('order.thankyou', $order->id);
    }

    public function thankyou(Order $order)
    {
        return view('checkout.thankyou', compact('order'));
    }
}