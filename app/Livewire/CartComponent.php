<?php

namespace App\Livewire;

use App\Models\Wilaya;
use App\Models\Discount;
use Livewire\Component;

class CartComponent extends Component
{
    public $cart = [];
    public $total = 0;
    public $cartCount = 0;
    public $wilaya_id = null;
    public $wilayas = [];
    public $shipping_cost = 0;
    
    // Discount properties
    public $discountInput = '';
    public $discountCode = null;
    public $discountAmount = 0;
    public $errorMessage = null;
    public $successMessage = null;

    public function mount()
    {
        $this->cart = session()->get('cart', []);
        $this->wilayas = Wilaya::orderBy('code')->get();
        $this->loadDiscount();
        $this->calculateTotal();
        $this->updateCartCount();
    }

    public function loadDiscount()
    {
        $discount = session()->get('discount');
        if ($discount) {
            $this->discountCode = $discount['code'];
            $this->discountAmount = $discount['amount'];
        }
    }

    public function updatedWilayaId($value)
    {
        $wilaya = Wilaya::find($value);
        if ($wilaya) {
            $this->shipping_cost = $wilaya->shipping_cost;
            session()->put('wilaya_id', $value);
            session()->put('shipping_cost', $wilaya->shipping_cost);
        }
        $this->calculateTotal();
    }

    public function getSubtotalProperty()
    {
        return collect($this->cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
    }

    public function getTotalProperty()
    {
        return $this->subtotal - $this->discountAmount + $this->shipping_cost;
    }

    public function updateCartCount()
    {
        $this->cartCount = collect($this->cart)->sum('quantity');
    }

   public function increaseQuantity($id)
{
    if (isset($this->cart[$id])) {
        $newQuantity = $this->cart[$id]['quantity'] + 1;
        
        // Validate stock
        if (!$this->validateStock($id, $newQuantity)) {
            return;
        }
        
        $this->cart[$id]['quantity'] = $newQuantity;
        session()->put('cart', $this->cart);
        $this->calculateTotal();
        $this->updateCartCount();
        $this->dispatch('updateCartCount');
        $this->clearMessages();
    }
}

public function decreaseQuantity($id)
{
    if (isset($this->cart[$id]) && $this->cart[$id]['quantity'] > 1) {
        $this->cart[$id]['quantity']--;
        session()->put('cart', $this->cart);
        $this->calculateTotal();
        $this->updateCartCount();
        $this->dispatch('updateCartCount');
        $this->clearMessages();
    }
}

public function updateQuantity($id, $quantity)
{
    if (isset($this->cart[$id])) {
        $quantity = max(1, (int) $quantity);
        
        // Validate stock
        if (!$this->validateStock($id, $quantity)) {
            // Reset to previous quantity
            $this->render();
            return;
        }
        
        $this->cart[$id]['quantity'] = $quantity;
        session()->put('cart', $this->cart);
        $this->calculateTotal();
        $this->updateCartCount();
        $this->dispatch('updateCartCount');
        $this->clearMessages();
    }
}

private function validateStock($cartKey, $requestedQty)
{
    $item = $this->cart[$cartKey];
    $product = \App\Models\Product::with(['stockType', 'stock.stockTypeOption'])->find($item['product_id']);
    
    if (!$product) {
        $this->errorMessage = 'Product not found';
        return false;
    }

    $availableStock = 0;

    // Check dynamic stock
    if ($product->usesDynamicStock() && isset($item['stock_option_id'])) {
        $productStock = \App\Models\ProductStock::where('product_id', $product->id)
            ->where('stock_type_option_id', $item['stock_option_id'])
            ->first();
        
        if ($productStock) {
            $availableStock = $productStock->quantity;
        }
    } else {
        // Legacy stock
        $availableStock = $product->total_stock;
    }

    if ($requestedQty > $availableStock) {
        $this->errorMessage = "Only {$availableStock} available for {$item['stock_label']}";
        return false;
    }

    return true;
}
    public function removeItem($id)
    {
        if (isset($this->cart[$id])) {
            unset($this->cart[$id]);
            session()->put('cart', $this->cart);
            $this->calculateTotal();
            $this->updateCartCount();
            $this->dispatch('updateCartCount');
            $this->successMessage = 'Item removed from cart';
            
            // Clear discount if cart is empty
            if (empty($this->cart)) {
                session()->forget('discount');
                $this->discountCode = null;
                $this->discountAmount = 0;
            }
        }
    }

    public function applyDiscount()
    {
        $this->clearMessages();
        
        if (empty($this->discountInput)) {
            $this->errorMessage = 'Please enter a discount code';
            return;
        }

        $code = Discount::where('code', strtoupper($this->discountInput))
            ->where('is_active', true)
            ->first();

        if (!$code) {
            $this->errorMessage = 'Invalid discount code';
            $this->discountInput = '';
            return;
        }

        // Check if code has expired
        if ($code->expires_at && $code->expires_at < now()) {
            $this->errorMessage = 'This discount code has expired';
            $this->discountInput = '';
            return;
        }

        // Check usage limit
        if ($code->max_uses && $code->times_used >= $code->max_uses) {
            $this->errorMessage = 'This discount code has reached its usage limit';
            $this->discountInput = '';
            return;
        }

        // Calculate discount
        $subtotal = $this->subtotal;
        
        if ($code->type === 'percentage') {
            $discountAmount = ($subtotal * $code->value) / 100;
        } else {
            $discountAmount = $code->value;
        }

        // Ensure discount doesn't exceed subtotal
        $discountAmount = min($discountAmount, $subtotal);

        // Save to session
        session()->put('discount', [
            'code' => $code->code,
            'amount' => $discountAmount,
            'discount_code_id' => $code->id,
        ]);

        $this->discountCode = $code->code;
        $this->discountAmount = $discountAmount;
        $this->discountInput = '';
        $this->successMessage = 'Discount code applied successfully!';
        $this->calculateTotal();
    }

    public function removeDiscount()
    {
        session()->forget('discount');
        $this->discountCode = null;
        $this->discountAmount = 0;
        $this->successMessage = 'Discount code removed';
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $itemsTotal = collect($this->cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        $shipping = 0;
        if ($this->wilaya_id) {
            $wilaya = Wilaya::find($this->wilaya_id);
            $shipping = $wilaya?->shipping_cost ?? 0;
            $this->shipping_cost = $shipping;
        }

        $this->total = $itemsTotal - $this->discountAmount + $shipping;
    }

    private function clearMessages()
    {
        $this->errorMessage = null;
        $this->successMessage = null;
    }

    public function render()
    {
        return view('livewire.cart-component');
    }
}