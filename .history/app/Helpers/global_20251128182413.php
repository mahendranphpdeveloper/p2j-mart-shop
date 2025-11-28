<?php

use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

if (! function_exists('getWishlistProductUnitItems')) {
    /**
     * Get product_unit_ids from Wishlist for the current user or session.
     *
     * @return array
     */
    function getWishlistProductUnitItems()
    {
        $userId = Auth::id();
        $sessionId = session()->getId();

        // If neither user nor session is available, return empty array
        if (is_null($userId) && empty($sessionId)) {
            return [];
        }

        // Fetch wishlist items based on user login or session
        return Wishlist::where(function ($query) use ($userId, $sessionId) {
                if (!is_null($userId)) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->pluck('product_unit_id')
            ->toArray();
    }
}
