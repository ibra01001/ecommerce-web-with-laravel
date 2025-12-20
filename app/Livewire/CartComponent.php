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
        $this->wilaya_id = session()->get('wilaya_id');
        
        if ($this->wilaya_id) {
            $wilaya = Wilaya::find($this->wilaya_id);
            $this->shipping_cost = $wilaya?->shipping_cost ?? 0;
        }
        
        $this->loadDiscount();
        $this->calculateTotal();
        $this->updateCartCount();
    }

    public function loadDiscount()
    {
        $discount = session()->get('discount');
        if ($discount) {
            $this->discountCode = $discount['code'];
            
            // Recalculate discount amount to ensure it's still valid
            $discountModel = Discount::where('code', $this->discountCode)
                ->active()
                ->first();
            
            if ($discountModel && $discountModel->isValid()) {
                $cartForDiscount = $this->formatCartForDiscount();
                $this->discountAmount = $discountModel->calculateDiscount($this->subtotal, $cartForDiscount);
                
                // Update session with recalculated amount
                session()->put('discount.amount', $this->discountAmount);
            } else {
                // Discount is no longer valid, remove it
                $this->removeDiscount();
            }
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
        return max(0, $this->subtotal - $this->discountAmount + $this->shipping_cost);
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
            
            // Recalculate discount if applied
            $this->recalculateDiscount();
            
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
            
            // Recalculate discount if applied
            $this->recalculateDiscount();
            
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
            
            // Recalculate discount if applied
            $this->recalculateDiscount();
            
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
            
            // Recalculate discount if applied
            $this->recalculateDiscount();
            
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

    /**
     * FIXED: Apply discount using the Discount model's methods
     */
    public function applyDiscount()
    {
        $this->clearMessages();
        
        if (empty($this->discountInput)) {
            $this->errorMessage = 'Please enter a discount code';
            return;
        }

        // Find the discount using the active scope
        $discount = Discount::where('code', strtoupper(trim($this->discountInput)))
            ->active()
            ->first();

        if (!$discount) {
            $this->errorMessage = 'Invalid or expired discount code';
            $this->discountInput = '';
            return;
        }

        // Check if discount is valid (additional validation)
        if (!$discount->isValid()) {
            $this->errorMessage = 'This discount code is not currently valid';
            $this->discountInput = '';
            return;
        }

        // Check if user/session can use this discount
        $userId = auth()->id();
        $sessionId = session()->getId();
        
        if (!$discount->canBeUsedBy($userId, $sessionId)) {
            $this->errorMessage = 'You have reached the usage limit for this discount code';
            $this->discountInput = '';
            return;
        }

        // CRITICAL: Format cart for discount validation
        $cartForDiscount = $this->formatCartForDiscount();

        // Check if discount applies to cart items
        if (!$discount->appliesTo($cartForDiscount)) {
            $this->errorMessage = 'This discount code does not apply to any items in your cart';
            $this->discountInput = '';
            return;
        }

        // Get subtotal
        $subtotal = $this->subtotal;

        // Check minimum purchase requirement
        if ($discount->min_purchase && $subtotal < $discount->min_purchase) {
            $this->errorMessage = 'Minimum purchase of ' . number_format((float) $discount->min_purchase, 0) . ' DA required for this discount';
            $this->discountInput = '';
            return;
        }

        // Calculate discount amount using the model's method
        $discountAmount = $discount->calculateDiscount($subtotal, $cartForDiscount);

        if ($discountAmount <= 0) {
            $this->errorMessage = 'This discount code cannot be applied to your cart';
            $this->discountInput = '';
            return;
        }

        // Save to session
        session()->put('discount', [
            'code' => $discount->code,
            'amount' => $discountAmount,
            'discount_id' => $discount->id,
        ]);

        $this->discountCode = $discount->code;
        $this->discountAmount = $discountAmount;
        $this->discountInput = '';
        $this->successMessage = 'Discount code applied successfully! You saved ' . number_format($discountAmount, 0) . ' DA';
        $this->calculateTotal();
    }

    /**
     * Recalculate discount when cart changes
     */
    private function recalculateDiscount()
    {
        if (!$this->discountCode) {
            return;
        }

        $discount = Discount::where('code', $this->discountCode)
            ->active()
            ->first();

        if (!$discount || !$discount->isValid()) {
            $this->removeDiscount();
            return;
        }

        $cartForDiscount = $this->formatCartForDiscount();
        $subtotal = $this->subtotal;
        
        // Check if discount still applies
        if (!$discount->appliesTo($cartForDiscount)) {
            $this->errorMessage = 'Discount no longer applies to cart items';
            $this->removeDiscount();
            return;
        }

        // Check minimum purchase
        if ($discount->min_purchase && $subtotal < $discount->min_purchase) {
            $this->errorMessage = 'Cart total is below minimum purchase requirement. Discount removed.';
            $this->removeDiscount();
            return;
        }

        // Recalculate discount amount
        $this->discountAmount = $discount->calculateDiscount($subtotal, $cartForDiscount);
        
        if ($this->discountAmount <= 0) {
            $this->removeDiscount();
        } else {
            session()->put('discount.amount', $this->discountAmount);
        }
    }

    /**
     * CRITICAL: Format cart data for discount model validation
     * The discount model expects: product_id, price, quantity
     */
    private function formatCartForDiscount()
    {
        $formattedCart = [];
        
        foreach ($this->cart as $id => $item) {
            $formattedCart[] = [
                'product_id' => $item['product_id'],
                'price' => $item['price'],
                'quantity' => $item['quantity']
            ];
        }
        
        return $formattedCart;
    }

    public function removeDiscount()
    {
        session()->forget('discount');
        $this->discountCode = null;
        $this->discountAmount = 0;
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

        $this->total = max(0, $itemsTotal - $this->discountAmount + $shipping);
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