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
        if (Auth::guard('Bibliophile')->check()) {
            $this->wishlistCount = $count ?? Wishlist::where('user_id', Auth::guard('Bibliophile')->id())->count();
        } else {
            $this->wishlistCount = 0;
        }
    }

    public function render()
    {
        return view('livewire.wishlist-count');
    }
}