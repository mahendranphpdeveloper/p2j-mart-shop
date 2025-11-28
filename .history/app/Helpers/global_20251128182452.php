<?php

use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

/**
 * Get the product unit IDs from the current user's or session's wishlist.
 *
 * @return array
 */
function getWishlistProductUnitItems()
{
    $userId = Auth::id();
    $sessionId = session()->getId();

    if (!$userId && !$sessionId) {
        return [];
    }

    $wishlistQuery = Wishlist::query();
    if ($userId) {
        $wishlistQuery->where('user_id', $userId);
    } else {
        $wishlistQuery->where('session_id', $sessionId);
    }

    return $wishlistQuery->pluck('product_unit_id')->toArray();
}
