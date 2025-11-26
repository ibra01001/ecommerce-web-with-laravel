<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'taille_type' => 'required|string|in:S,M,L,XL,XXL'
        ]);

        $product = Product::findOrFail($id);
        $quantity = $request->input('quantity');
        $size = $request->input('taille_type');

        // Check stock for this specific size
        $sizeField = 'taille_' . $size;
        if ($product->$sizeField < $quantity) {
            return redirect()->back()->with('error', "Not enough stock for size {$size}. Only {$product->$sizeField} available.");
        }

        $cart = session()->get('cart', []);

        // Create unique key: productID + size
        $cartKey = $id . '_' . $size;

        if(isset($cart[$cartKey])) {
            $newQuantity = $cart[$cartKey]['quantity'] + $quantity;
            
            // Check if new quantity exceeds stock
            if ($product->$sizeField < $newQuantity) {
                return redirect()->back()->with('error', "Cannot add more. Only {$product->$sizeField} available for size {$size}.");
            }
            
            $cart[$cartKey]['quantity'] = $newQuantity;
        } else {
            $cart[$cartKey] = [
                'product_id' => $id,
                'name' => $product->name,
                'quantity' => $quantity,
                'price' => $product->price,
                'image' => $product->image,
                'taille_type' => $size
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    // UPDATE METHOD - ADD THIS
    public function update(Request $request, $cartKey)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = session()->get('cart', []);
        
        if (isset($cart[$cartKey])) {
            $quantity = $request->quantity;
            
            // Validate stock
            $product = Product::find($cart[$cartKey]['product_id']);
            
            if ($product) {
                $sizeField = 'taille_' . $cart[$cartKey]['taille_type'];
                
                if ($product->$sizeField < $quantity) {
                    return redirect()->back()->with('error', "Only {$product->$sizeField} available for this size.");
                }
            }
            
            $cart[$cartKey]['quantity'] = $quantity;
            session()->put('cart', $cart);
            
            return redirect()->back()->with('success', 'Cart updated successfully.');
        }

        return redirect()->back()->with('error', 'Item not found in cart.');
    }

    public function remove($cartKey)
    {
        $cart = session()->get('cart', []);
        
        if(isset($cart[$cartKey])) {
            unset($cart[$cartKey]);
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Product removed from cart.');
        }

        return redirect()->back()->with('error', 'Item not found in cart.');
    }

    // CLEAR METHOD - ADD THIS
    public function clear()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Cart cleared successfully.');
    }
}