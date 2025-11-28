<?php


namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
class ProductUnitItems
{
    function getWishlistProductUnitItems()
    {
        $userId = Auth::id();
        $sessionId = session()->getId();

        // If no user or session, return empty
        if (! $userId && ! $sessionId) {
            return [];
        }

        // Fetch wishlist items based on login or session
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
