<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Product;
use App\Models\UserOrder;
use App\Models\Productunit;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    /**
     * Display checkout page with product details
     */
    public function index(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = $user ? $user->id : null;
            $sessionId = session()->getId();
            
            // Retrieve product data from session for "Buy Now"
            $productData = Session::get('buy_now_product.' . $sessionId);
            
            // Retrieve cart items for "Proceed to Checkout"
            $cartItems = $this->getCartItems($userId, $sessionId);

            // If coming from Buy Now
            if ($productData) {
                $product = Product::with(['units', 'images'])
                    ->where('product_id', $productData['product_id'])
                    ->firstOrFail();
                    
                $quantity = $productData['quantity'];
                
                return view('products.checkout', [
                    'product' => $product,
                    'quantity' => $quantity,
                    'sessionId' => $sessionId,
                    'user' => $user,
                    'addresses' => $this->getUserAddresses($userId, $sessionId),
                    'orders' => $this->getUserOrders($userId),
                    'checkoutType' => 'buy_now' // Add this to distinguish checkout types
                ]);
            } 
            // If coming from Cart
            elseif ($cartItems->isNotEmpty()) {
                return view('products.checkout', [
                    'cartItems' => $cartItems,
                    'user' => $user,
                    'addresses' => $this->getUserAddresses($userId, $sessionId),
                    'orders' => $this->getUserOrders($userId),
                    'checkoutType' => 'cart' // Add this to distinguish checkout types
                ]);
            } 
            else {
                return redirect()->route('home')->with('error', 'No items selected for checkout');
            }

        } catch (\Exception $e) {
            Log::error('Checkout error: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'Error loading checkout page');
        }
    }

    protected function getCartItems($userId, $sessionId)
    {
        $cartItems = collect();

        if ($userId) {
            $cartItems = Cart::with(['product', 'productUnit'])->where('user_id', $userId)->get();
        } else {
            $cartSession = Session::get('cart', []);
            if (!empty($cartSession) && is_array($cartSession)) {
                $productIds = array_column($cartSession, 'product_id');
                $products = Product::with('images')->whereIn('product_id', $productIds)->get()->keyBy('product_id');
                $unitIds = array_column($cartSession, 'product_unit_id');
                $units = Productunit::whereIn('product_unit_id', array_filter($unitIds))->get()->keyBy('product_unit_id');

                $cartItems = collect($cartSession)->map(function ($item) use ($products, $units) {
                    $product = $products->get($item['product_id']);
                    $productUnit = $units->get($item['product_unit_id']);

                    return (object) [
                        'id' => $item['id'] ?? null,
                        'product_id' => $item['product_id'],
                        'product_unit_id' => $item['product_unit_id'] ?? null,
                        'quantity' => $item['quantity'],
                        'price' => $item['price'] ?? 0,
                        'product' => $product,
                        'productUnit' => $productUnit,
                    ];
                })->filter(function ($item) {
                    return $item->product !== null;
                });
            }
        }

        return $cartItems;
    }
    
    protected function getUserAddresses($userId, $sessionId)
    {
        if ($userId) {
            return Address::where('user_id', $userId)->get();
        } else {
            return Address::where('session_id', $sessionId)->get();
        }
    }
    
    protected function getUserOrders($userId)
    {
        return $userId ? UserOrder::where('user_id', $userId)->paginate(10) : collect();
    }

    /**
     * Store new shipping address
     */
    public function storeAddress(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'pincode' => 'required|string|max:10',
        ]);

        try {
            $addressData = [
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'address_line1' => $validated['address'],
                'address_line2' => $request->input('address_line2', ''),
                'city' => $validated['city'],
                'state' => $validated['state'],
                'zipcode' => $validated['pincode'],
                'country' => 'India',
            ];

            if (auth()->check()) {
                $addressData['user_id'] = auth()->id();
            } else {
                $addressData['session_id'] = session()->getId();
            }

            Address::create($addressData);

            return redirect()->back()->with('success', 'Address saved successfully!');

        } catch (\Exception $e) {
            Log::error('Address store error: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to save address. Please try again.');
        }
    }
}