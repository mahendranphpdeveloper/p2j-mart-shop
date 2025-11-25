<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartComponent extends Component
{
    public $cartItems;
    public $isEmpty = true;
    public $subtotal = 0;

    /**
     * Mount method: Called when the component is initialized.
     */
    public function mount()
    {
        $this->loadCart();
    }

    /**
     * Loads cart items based on user authentication status.
     */
    public function loadCart()
    {
        $userId = Auth::id();
        $sessionId = Session::getId();

        if ($userId) {
            $this->cartItems = Cart::where('user_id', $userId)->get();
        } else {
            $this->cartItems = Cart::where('session_id', $sessionId)->get();
        }

        $this->isEmpty = $this->cartItems->isEmpty();
        $this->calculateSubtotal();
        $this->dispatchCartUpdated(); // Properly trigger CartCount component update
    }

    /**
     * Calculates the subtotal based on current cart items.
     */
    public function calculateSubtotal()
    {
        $this->subtotal = $this->cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });
    }

    /**
     * Updates the quantity for a specific cart item.
     * Validates minimum quantity of 1.
     */
    public function updateQuantity($cartId, $newQuantity)
    {
        $userId = Auth::id();
        $sessionId = Session::getId();

        $cartItem = Cart::where('id', $cartId)
            ->where(function ($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->first();

        if ($cartItem && $newQuantity >= 1) {
            $cartItem->quantity = $newQuantity;
            $cartItem->save();
            $this->loadCart();
            $this->dispatchCartUpdated();
        }
    }

    /**
     * Increments the quantity for a cart item.
     */
    public function incrementQuantity($cartId)
    {
        $cartItem = $this->cartItems->firstWhere('id', $cartId);
        if ($cartItem) {
            $this->updateQuantity($cartId, $cartItem->quantity + 1);
        }
    }

    /**
     * Decrements the quantity for a cart item (prevents going below 1).
     */
    public function decrementQuantity($cartId)
    {
        $cartItem = $this->cartItems->firstWhere('id', $cartId);
        if ($cartItem && $cartItem->quantity > 1) {
            $this->updateQuantity($cartId, $cartItem->quantity - 1);
        }
    }

    /**
     * Removes a cart item by ID.
     */
    public function removeItem($cartId)
    {
        $userId = Auth::id();
        $sessionId = Session::getId();

        Cart::where('id', $cartId)
            ->where(function ($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->delete();

        $this->loadCart();
        $this->dispatchCartUpdated();
    }

    /**
     * Dispatch browser event to trigger CartCount component.
     */
    public function dispatchCartUpdated()
    {
        $this->dispatch('cartUpdated');
    }

    /**
     * Renders the component view.
     */
    public function render()
    {
        return view('livewire.cart-component');
    }
}