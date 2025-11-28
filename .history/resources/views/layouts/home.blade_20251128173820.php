@include('layouts.header')

@php
    
    $userId = Auth::id();
    $sessionId = session()->getId();

    if ($userId || $sessionId) {
             = \App\Models\Wishlist::where(function ($query) use ($userId, $sessionId) {
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