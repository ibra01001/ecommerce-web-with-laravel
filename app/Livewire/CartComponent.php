<?php

namespace App\Livewire;

use App\Models\Wilaya;
use Livewire\Component;

class CartComponent extends Component
{
    public $cart = [];
    public $total = 0;
    public $cartCount = 0;

    public $wilaya_id = null;
    public $wilayas = [];
    public $shipping_cost = 0;

    public function mount()
    {
        $this->cart = session()->get('cart', []);
        $this->wilayas = Wilaya::orderBy('code')->get();

        $this->calculateTotal();
        $this->updateCartCount();
    }

    public function updatedWilayaId($value)
    {
        $wilaya = Wilaya::find($value);

       
        $this->calculateTotal();
    }

    public function getTotalWithShippingProperty()
    {
        return $this->total + $this->shipping_cost;
    }

    public function updateCartCount()
    {
        $this->cartCount = collect($this->cart)->sum('quantity');
    }

    public function updateQuantity($id, $quantity)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = max(1, (int) $quantity);
            session()->put('cart', $cart);
            $this->cart = $cart;

            $this->calculateTotal();
            $this->updateCartCount();
            $this->dispatch('updateCartCount');
        }
    }

    public function removeItem($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            $this->cart = $cart;

            $this->calculateTotal();
            $this->updateCartCount();
            $this->dispatch('updateCartCount');
        }
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

    $this->total = $itemsTotal + $shipping;
}


    public function render()
    {
        return view('livewire.cart-component', 
        );

    }
}
