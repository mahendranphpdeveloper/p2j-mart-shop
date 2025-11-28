<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class WishlistController extends Controller
{

  public function index()
  {
      $userId = Auth::id();
      $sessionId = Session::getId();

      // Eager-load the relationships as per Wishlist model:
      // - product (Wishlist belongsTo Product)
      // - productUnit (Wishlist hasOneThrough ProductUnit via Product, based on product_id)
      // - product.productImage (for main product image)
      // - productUnit.productimage (for unit image if any)
      $wishlistItems = Wishlist::with([
              'product',
              'product.productImage',      // main product image per Product model
              'productUnit',
              'productUnit.productimage',  // unit image per Productunit model
          ])
          ->where(function ($query) use ($userId, $sessionId) {
              if ($userId) {
                  $query->where('user_id', $userId);
              } else {
                  $query->where('session_id', $sessionId);
              }
          })
          ->get();

      // Log::info(print_r($wishlistItems, true)); // Fixed to prevent unwanted output; logging removed for production
      return view('view.wishlist', compact('wishlistItems'));
  }


  public function add(Request $request)
  {
      $request->validate([
          'product_id' => 'required|integer|exists:product,product_id',
          'product_unit_id' => 'nullable|integer'
      ]);

      $productId = $request->input('product_id');
      $productUnitId = $request->input('product_unit_id', null);
      $userId = Auth::id();
      $sessionId = Session::getId();

      // Check if already in wishlist (by product + unit if unit provided, otherwise just product)
      $query = Wishlist::where('product_id', $productId);
      if ($productUnitId) {
          $query->where('product_unit_id', $productUnitId);
      }
      $query->where(function ($query) use ($userId, $sessionId) {
          $query->when($userId, fn($q) => $q->where('user_id', $userId))
                ->when(!$userId, fn($q) => $q->where('session_id', $sessionId));
      });

      $exists = $query->exists();

      if ($exists) {
          return response()->json([
              'success' => false,
              'message' => 'Already in wishlist',
              'count' => $this->getWishlistCount($userId, $sessionId)
          ]);
      }

      Wishlist::create([
          'product_id' => $productId,
          'product_unit_id' => $productUnitId,
          'user_id' => $userId,
          'session_id' => $userId ? null : $sessionId
      ]);

      return response()->json([
          'success' => true,
          'message' => 'Added to wishlist',
          'count' => $this->getWishlistCount($userId, $sessionId)
      ]);
  }


private function getWishlistCount($userId, $sessionId)
{
    return Wishlist::where(function ($query) use ($userId, $sessionId) {
        $query->when($userId, fn($q) => $q->where('user_id', $userId))
              ->when(!$userId, fn($q) => $q->where('session_id', $sessionId));
    })->count();
}

public function remove(Request $request)
{
    \Log::info("Entered WishlistController@remove");

    $wishlistId = $request->input('wishlist_id');
    $userId = Auth::id();
    $sessionId = Session::getId();

    \Log::info("Received wishlist_id: {$wishlistId}");
    \Log::info("User ID: " . ($userId ?? 'null'));
    \Log::info("Session ID: " . $sessionId);

    // Try to find the item for logged-in user or session user
    $item = Wishlist::where('id', $wishlistId)
        ->where(function ($query) use ($userId, $sessionId) {
            if ($userId) {
                $query->where('user_id', $userId);
            } else {
                $query->where('session_id', $sessionId);
            }
        })
        ->first();

    if ($item) {
        \Log::info("Wishlist item found: ID {$item->id}. Deleting...");
        $item->delete();
        return response()->json(['success' => true]);
    } else {
        \Log::warning("Wishlist item NOT found or not owned by user/session.");
    }

    return response()->json(['success' => false, 'message' => 'Item not found']);
}



    public function count()
    {
        $userId = Auth::id();
        $sessionId = Session::getId();

        $count = Wishlist::where(function ($query) use ($userId, $sessionId) {
            $query->when($userId, fn($q) => $q->where('user_id', $userId))
                  ->when(!$userId, fn($q) => $q->where('session_id', $sessionId));
        })->count();

        return response()->json(['count' => $count]);
    }
}

