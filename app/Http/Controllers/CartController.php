<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Models\Product;
use App\Models\Productunit;

class CartController extends Controller
{
   public function addToCart(Request $request)
    {
        Log::info($request->all());
        Log::info('ghfghg');
        try {
            $validatedData = $request->validate([
                'product_id' => 'required|integer|exists:product,product_id',
                'product_unit_id' => 'required|integer|exists:product_unit,product_unit_id',
                'price' => 'required|numeric|min:0',
                'quantity' => 'required|integer|min:1',
            ]);
    
            $product = Product::with('units')->find(id: $validatedData['product_id']);
            $productUnit = Productunit::where('product_unit_id', $validatedData['product_unit_id'])->first();
            Log::info($productUnit);
            if (!$product) {
                return response()->json(['success' => false, 'message' => 'Product not found.'], 404);
            }
    
            $userId = auth()->id();
            $sessionId = Session::getId();
    
            // Check if product already exists in cart
            $existingCartItem = Cart::where('product_id', $product->product_id)->where('product_unit_id', $productUnit->product_unit_id )
                ->where(function($query) use ($userId, $sessionId) {
                    $query->where('user_id', $userId)
                          ->orWhere('session_id', $sessionId);
                })
                ->first();
    
            if ($existingCartItem) {
                // Update quantity if already exists
                $existingCartItem->quantity += $validatedData['quantity'];
                $existingCartItem->save();
            } else {
                // Create new cart item
                $cartItem = new Cart();
                $cartItem->user_id = $userId;
                $cartItem->session_id = $userId ? null : $sessionId;
                $cartItem->product_unit_id = $productUnit->product_unit_id;
                $cartItem->product_id = $product->product_id;
                $cartItem->product_name = $product->product_name;
                $cartItem->price = $validatedData['price'];
                $cartItem->quantity = $validatedData['quantity'];
                $cartItem->save();
            }
    
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart',
                'count' => $this->getCartCount($userId, $sessionId)
            ]);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error adding to cart: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error adding product to cart. Please try again.'
            ], 500);
        }
    }
    
    

    public function cartCount()
    {
        Log::info('cartCount method called');
    
        $user_id = Auth::id();
        $session_id = session()->getId();
    
        Log::info('User or session data in cartCount', ['user_id' => $user_id, 'session_id' => $session_id]);
    
        $cartQuery = Cart::query();
        if ($user_id) {
            $cartQuery->where('user_id', $user_id);
        } else {
            $cartQuery->where('session_id', $session_id);
        }
    
        $cartCount = $cartQuery->sum('quantity');
        Log::info('Total cart count', ['cart_count' => $cartCount]);
    
        return $cartCount;
    }
    

  public function viewCart()
{
    try {
        $userId = auth()->id();
        $sessionId = Session::getId();
        
        Log::debug('Loading cart for:', ['user_id' => $userId, 'session_id' => $sessionId]);

     

        if ($userId) {
            $cartItems =  Cart::where('user_id',$userId)->get();           
          

        } else {
           
            $cartItems =  Cart::where('session_id',$sessionId)->get();
        }

     
        
   
    
        
        return view('view.cart', [
            'cartItems' => $cartItems,
            'isEmpty' => $cartItems->isEmpty()
        ]);

    } catch (\Exception $e) {
        Log::error('Error loading cart: ' . $e->getMessage(), [
            'trace' => $e->getTraceAsString()
        ]);
        return view('view.cart', [
            'cartItems' => collect(),
            'isEmpty' => true
        ]);
    }
}

    // In CartController.php
    public function getCartCount()
    {
        Log::info('getCartCount method called');
    
        // Check if the user is logged in or if it's a guest using session_id
        $user_id = Auth::id();
        $session_id = session()->getId();
    
        Log::info('User or session data in getCartCount', ['user_id' => $user_id, 'session_id' => $session_id]);
    
        $cartQuery = Cart::query();
    
        // Check cart based on user or session
        if ($user_id) {
            $cartQuery->where('user_id', $user_id);
        } else {
            $cartQuery->where('session_id', $session_id);
        }
    
        $cartCount = $cartQuery->sum('quantity');
        Log::info('Total cart count in getCartCount', ['cart_count' => $cartCount]);
    
        return response()->json(['cart_count' => $cartCount]);
    }
    
  public function update(Request $request)
{
    Log::info('update method called', ['request_data' => $request->all()]);
    try {
        $validatedData = $request->validate([
            'cart_id' => 'required|integer|exists:carts,id', // Updated to 'carts'
            'quantity' => 'required|integer|min:1',
        ]);

        Log::debug('Validated data', ['cart_id' => $validatedData['cart_id'], 'quantity' => $validatedData['quantity']]);

        $cartItem = Cart::find($validatedData['cart_id']);
        if (!$cartItem) {
            Log::warning('Cart item not found', ['cart_id' => $validatedData['cart_id']]);
            return response()->json([
                'success' => false,
                'message' => 'Cart item not found.'
            ], 404);
        }

        $cartItem->quantity = $validatedData['quantity'];
        $cartItem->save();
        Log::info('Cart item updated', ['cart_id' => $cartItem->id, 'new_quantity' => $cartItem->quantity]);

        $userId = auth()->id();
        $sessionId = Session::getId();
        $cartQuery = Cart::query();
        if ($userId) {
            $cartQuery->where('user_id', $userId);
        } else {
            $cartQuery->where('session_id', $sessionId);
        }
        $cartItems = $cartQuery->get();
        $subtotal = $cartItems->sum(function($item) {
            return $item->price * $item->quantity;
        });

        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully.',
            'subtotal' => number_format($subtotal, 2),
            'item_total' => number_format($cartItem->price * $cartItem->quantity, 2),
            'quantity' => $cartItem->quantity,
            'cart_count' => $cartItems->sum('quantity')
        ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
        Log::error('Validation error in update', ['errors' => $e->errors()]);
        return response()->json([
            'success' => false,
            'message' => 'Validation error',
            'errors' => $e->errors()
        ], 422);
    } catch (\Exception $e) {
        Log::error('Error in update', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        return response()->json([
            'success' => false,
            'message' => 'Error updating cart: ' . $e->getMessage()
        ], 500);
    }
}
 public function removeFromCart(Request $request)
    {
        $cartItemId = $request->input('cart_id'); // Consistent with view
        $cartItem = Cart::find($cartItemId);
    
        if ($cartItem) {
            $cartItem->delete();
            return response()->json(['success' => true]);
        }
    
        return response()->json([
            'success' => false,
            'message' => 'Failed to remove item from cart.'
        ], 400);
    } 
    
}
