@include('layouts.header')

@php
    // Get all wishlist product_unit_id items for current user or session, always as an array
    $userId = Auth::id();
    $sessionId = session()->getId();

    $wishlistproductunitItems = [];

    if ($userId || $sessionId) {
        $wishlistproductunitItems = \App\Models\Wishlist::where(function ($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->pluck('product_unit_id')
            ->toArray();
    }
@endphp

@yield('content')

@include('layouts.footer')