<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class CartCount extends Component
{
    protected $listeners = ['cartUpdated' => 'render'];

    public function render()
    {
        $user_id = Auth::id();
        $session_id = session()->getId();

        $cartQuery = Cart::query();
        if ($user_id) {
            $cartQuery->where('user_id', $user_id);
        } else {
            $cartQuery->where('session_id', $session_id);
        }

        $cartCount = $cartQuery->sum('quantity');

        return view('livewire.cart-count', [
            'cartCount' => $cartCount,
        ]);
    }
}
