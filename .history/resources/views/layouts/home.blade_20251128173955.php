@include('layouts.header')

 
    $userId = Auth::id();
    $sessionId = session()->getId();

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
 


@yield('content')

@include('layouts.footer')