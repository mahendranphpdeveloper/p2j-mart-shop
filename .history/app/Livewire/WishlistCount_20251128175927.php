<?php

namespace App\Livewire;

use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class WishlistCount extends Component
{
    public $wishlistCount = 0;

    protected $listeners = ['wishlistUpdated' => 'updateWishlistCount'];

    public function mount()
    {
        $this->updateWishlistCount();
    }

    public function updateWishlistCount($count = null)
    {
        $userId = Auth::id();
        $sessionId = session()->getId();

        if ($count !== null) {
            $this->wishlistCount = $count;
            return;
        }

        $wishlistproductunitItems = [];

        if ($userId || $sessionId) {
            $wishlistproductunitItems = Wishlist::where(function ($query) use ($userId, $sessionId) {
                    if ($userId) {
                        $query->where('user_id', $userId);
                    } else {
                        $query->where('session_id', $sessionId);
                    }
                })
                ->pluck('product_unit_id')
                ->toArray();
        }

        $this->wishlistCount = count($wishlistproductunitItems);
    }

    public function render()
    {
        return view('livewire.wishlist-count');
    }
}