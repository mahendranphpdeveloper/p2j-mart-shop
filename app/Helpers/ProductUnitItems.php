<?php

namespace App\Helpers;

use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProductUnitItems
{
    public static function getWishlistProductUnitItems()
    {
        $userId = Auth::id();
        $sessionId = Session::getId();

        // If neither user nor session is available, return empty array
        if (!$userId && !$sessionId) {
            return [];
        }

        $query = Wishlist::query();

        if ($userId) {
            $query->where('user_id', $userId);
        } elseif ($sessionId) {
            $query->where('session_id', $sessionId);
        }

        return $query->pluck('product_unit_id')->toArray();
    }
}
