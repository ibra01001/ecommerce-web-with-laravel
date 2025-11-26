<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class AdminCheckout extends Controller
{
    public function create()
    {
        return view('orders.index');
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

        // calculate totals
        $total = 0;
        foreach ($cart as $_ => $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        
        $order = Order::create([
            'user_id'    => Auth::id(),
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'phone'      => $data['phone'],
            'email'      => $data['email'],
            'wilaya'     => $data['wilaya'],
            'commune'    => $data['commune'],
            'address'    => $data['address'],
            'notes'      => $data['notes'] ?? null,
            'total'      => $total,
            'status'     => 'pending',
        ]);

        foreach ($cart as $productId => $item) {
            OrderItem::create([
                'order_id'   => $order->getKey(),
                'product_id' => $productId,
                'name'       => $item['name'] ?? null,
                'image'      => $item['image'] ,
                'price'      => $item['price'],
                'quantity'   => $item['quantity'],
                'taille_type'     => $item['taille_type'],
            ]);
        }

        session()->forget('cart');

        return redirect()->route('order.thankyou', $order->getKey());
    }

    public function thankyou(Order $order)
    {
        return view('checkout.thankyou', compact('order'));
    }

    
};

