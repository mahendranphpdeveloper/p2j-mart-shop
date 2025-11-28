<?php

use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

if (! function_exists('getWishlistProductUnitItems')) {
    /**
     * Return wishlist product unit ids for the current user or session.
     */
    function getWishlistProductUnitItems()
    {
        $userId = Auth::id();
        $sessionId = session()->getId();

        if (! $userId && ! $sessionId) {
            return [];
        }

        return Wishlist::where(function ($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->pluck('product_unit_id')
            ->toArray();
    }
}
