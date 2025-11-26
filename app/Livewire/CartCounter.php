<?php 
namespace App\Livewire;
use Livewire\Component;


class CartCounter extends Component
{
    public $cartCount = 0;
    

    protected $listeners = ['updateCartCount' => 'updateCartCount'];

    public function mount()
    {
        $this->updateCartCount();
    }

    public function updateCartCount()
    {
        $cart = session()->get('cart', []);
        $this->cartCount = collect($cart)->sum('quantity');
    }

    public function render()
    {
        return view('livewire.cart-counter');
    }
}
