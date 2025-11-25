<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCate;
use App\Models\Categories;
use Illuminate\Http\Request;
use App\Models\FlatDiscount;
use App\Models\Slider;
use App\Models\Subcategories;
use App\Models\Contactus;
use App\Models\Contact;
use App\Models\MidSubcategory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Mail\VerifyEmail;
use Illuminate\Support\Facades\Mail;
use App\Models\Products;
use App\Models\Product;
use App\Models\Combo;
use Illuminate\Support\Facades\Session;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use PDF;
use App\Models\Productunit;
use App\Models\Subcategory;
use App\Models\User;
use App\Models\Wishlist;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Vinkla\Hashids\Facades\Hashids;
use App\Http\Controllers\CartController;
use App\Models\Bibliophile;
use App\Models\Address;
use App\Models\Cart;
use App\Models\UserOrder;
use App\Models\ProductImage;
use App\Models\Enquiry;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Http;

class Home extends Controller
{
    public function register()
    {
        return view('view.register');
    }

    public function registerUser(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phonenumber' => 'required|numeric',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->firstname . ' ' . ($request->lastname ?? ''),
            'email' => $request->email,
            'phonenumber' => $request->phonenumber,
            'city' => $request->city ?? '',
            'pincode' => $request->pincode ?? '',
            'verification_token' => Str::random(60),
            'password' => Hash::make($request->password),
        ]);

        // Send verification email
        Mail::to($user->email)->send(new VerifyEmail($user));

        // Explicitly ensure the user is not logged in after registration
        Auth::logout();

        // Store success message in session
        Session::flash('success', 'Registration successful! A verification email has been sent. Please check your inbox.');

        return redirect()->route('home');
    }

    public function login()
    {
        return view('view.login');
    }

    public function userLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Find the user
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return redirect()->back()
                ->with('error', 'Invalid email or password.')
                ->withInput();
        }

        // Check email verification
        if (!$user->email_verified_at) {
            Mail::to($user->email)->send(new VerifyEmail($user));

            return redirect()->back()
                ->with('info', 'Verification email sent. Please verify your email.')
                ->withInput();
        }

        // Login with Bibliophile guard
        Auth::guard('Bibliophile')->login($user);

        // Redirect based on cart session or home
        $cart = session()->get('cart', []);
        if (!empty($cart)) {
            return redirect()->route('checkout')->with('success', 'Login successful! Proceed to checkout.');
        }

        return redirect()->route('home')->with('success', 'Login successful!');
    }

    public function logout()
    {
        Auth::guard('Bibliophile')->logout();
        return redirect()->route('home')->with('success', 'Logged out successfully.');
    }

    public function wishlist()
    {
        $newproducts = Product::with(['category', 'midSubCategory', 'subCate'])
                        ->latest()
                        ->take(5)
                        ->get();

        $wishlistProducts = [];
        if (Auth::guard('Bibliophile')->check()) {
            $wishlistProducts = Wishlist::where('user_id', Auth::guard('Bibliophile')->id())
                ->with(['products.category', 'products.midSubCategory', 'products.subCate'])
                ->get();
        }

        return view('view.wishlist', compact('newproducts', 'wishlistProducts'));
    }

    public function cart()
    {
        $cart = session()->get('cart', []);

        if (!empty($cart)) {
            $firstProductId = array_key_first($cart);
            $firstProduct = Product::find($firstProductId);

            if ($firstProduct) {
                $similerCategory = Product::where('cate_id', $firstProduct->cate_id)
                                          ->where('id', '!=', $firstProduct->id)
                                          ->take(5)
                                          ->get();
            } else {
                $similerCategory = collect();
            }
        } else {
            $similerCategory = collect();
        }

        return view('view.cart', compact('similerCategory'));
    }

    public function userAccount()
    {
        try {
            $user = Auth::user();

            // Get paginated orders with required relations
            $orders = UserOrder::with([
                'items.product.category',
                'items.product.images',
                'items.productUnit.color',
                'items.productUnit.images',
                'items.customization',
                'user',
                'address'
            ])
                ->where('user_id', $user->id)
                ->latest()
                ->paginate(6);

            // Compute user initials
            $initials = '';
            if ($user && $user->name) {
                $names = explode(' ', $user->name);
                $initials = strtoupper(substr($names[0], 0, 1));
                if (count($names) > 1) {
                    $initials .= strtoupper(substr(end($names), 0, 1));
                }
            }

            // Fetch addresses
            $addresses = Address::where('user_id', $user->id)->get();

            // Prepare orders with enhanced item structure
            $enhancedOrders = clone $orders;
            $enhancedOrders->getCollection()->transform(function ($order) {
                $itemsRes = [];
                foreach ($order->items as $item) {
                    $image = 'no-image.png';
                    if (optional($item->product)->images->count() > 0) {
                        $image = $item->productImage->web_image_1 ?? 'no-image.png';
                    } elseif (optional($item->productUnit)->images->count() > 0) {
                        $image = $item->productImage->web_image_1 ?? 'no-image.png';
                    }
                    $imagePath = asset("uploads/products/" . $image);

                    // Handle customization image as base64
                    $customization = $item->customization;
                    $imageContent = null;
                    if ($customization && $customization->custom_image) {
                        $path = storage_path('app/public/' . ltrim($customization->custom_image, '/'));
                        if (file_exists($path)) {
                            $imageContent = base64_encode(file_get_contents($path));
                        }
                    }

                    // Handle dynamic attributes (other attributes) for this order item
                    $dynamicAttributes = [];
                    $product = $item->product;

                    if ($product && isset($product->subcategory_id)) {
                        $subcategory = \App\Models\SubCategory::find($product->subcategory_id);
                        $selectedAttributeIds = [];

                        $unit = $item->productUnit;
                        if ($unit) {
                            $unitAttributes = $unit->getAttributes();
                            foreach ($unitAttributes as $key => $value) {
                                if (preg_match('/^m_(.*)_id$/', $key, $matches) && !empty($value)) {
                                    $attributeSlug = $matches[1];
                                    $attribute = \App\Models\Attribute::where('attribute_slug', $attributeSlug)->first();
                                    if ($attribute) {
                                        $selectedAttributeIds[] = $attribute->id;
                                    }
                                }
                            }
                        }

                        if (!empty($selectedAttributeIds)) {
                            $attributes = \App\Models\Attribute::orderBy('display_order')
                                ->where('status', 'active')
                                ->where('attribute_slug', '!=', 'color')
                                ->whereIn('id', $selectedAttributeIds)
                                ->get();

                            foreach ($attributes as $attribute) {
                                $modelName = 'Unit' . \Illuminate\Support\Str::studly(\Illuminate\Support\Str::singular($attribute->attribute_slug));
                                $modelClass = "App\\Models\\$modelName";
                                if (class_exists($modelClass)) {
                                    $table = (new $modelClass)->getTable();
                                    $primaryKey = $table . '_id';
                                    $attrIdField = 'm_' . $attribute->attribute_slug . '_id';
                                    $attrValue = null;
                                    if ($unit && isset($unit->$attrIdField)) {
                                        $attrInstance = $modelClass::where($primaryKey, $unit->$attrIdField)->first();
                                        if ($attrInstance) {
                                            $possibleNameField = $attribute->attribute_slug . '_name';
                                            if (isset($attrInstance->$possibleNameField)) {
                                                $attrValue = $attrInstance->$possibleNameField;
                                            } elseif (isset($attrInstance->name)) {
                                                $attrValue = $attrInstance->name;
                                            } else {
                                                $attrValue = '';
                                            }
                                        }
                                    }
                                    $dynamicAttributes[] = [
                                        'name' => $attribute->attribute_name,
                                        'value' => $attrValue ?? '',
                                    ];
                                }
                            }
                        }
                    }

                    $preparedCustomization = $customization ? array_merge(
                        $customization->toArray(),
                        ['image_content' => $imageContent]
                    ) : null;

                    $itemsRes[] = [
                        'product_name' => optional($item->product)->product_name ?? 'N/A',
                        'category' => optional(optional($item->product)->subcategory)->title ?? 'N/A',
                        'quantity' => $item->quantity,
                        'price' => $item->price,
                        'color_code' => optional($item->productUnit->color)->color_code ?? '',
                        'image' => $imagePath,
                        'product' => $item->product,
                        'dynamic_attributes' => $dynamicAttributes,
                        'customization' => $preparedCustomization,
                    ];
                }
                $order->items_details = $itemsRes;
                return $order;
            });

            return view('view.my-account', [
                'user' => $user,
                'initials' => $initials,
                'orders' => $enhancedOrders,
                'totalOrders' => $orders->total(),
                'addresses' => $addresses,
            ]);
        } catch (\Exception $e) {
            // Optionally show an error page or flash error message.
            return redirect()->back()->with('error', 'Error loading account details: ' . $e->getMessage());
        }
    }

    public function downloadInvoice($orderId)
    {
        $order = UserOrder::with(['product', 'address'])
            ->where('order_id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('orders.invoice', compact('order'));
    }

    public function getProfileData()
    {
        $user = Auth::user();
        return view('view.my-account', compact('user'));
    }

    public function userAccountUpdate(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return redirect()->route('my-account')->with('success', 'Profile updated successfully!');
    }

    public function checkout()
    {
        try {
            Log::info('Checkout method called');

            $user = Auth::user();
            Log::info('Authenticated user:', ['user_id' => $user->id]);

            $cartItems = Cart::with(['product.images', 'product.units'])
                ->where('user_id', $user->id)
                ->get();
            Log::info('Cart items retrieved', ['count' => $cartItems->count()]);

            if ($cartItems->isEmpty()) {
                Log::warning('Cart is empty for user', ['user_id' => $user->id]);
                return redirect()->route('cart.view')
                    ->with('error', 'Your cart is empty');
            }

            $addresses = Address::where('user_id', $user->id)->get();
            Log::info('User addresses retrieved', ['count' => $addresses->count()]);

            $addressId = session()->get('selected_address_id');
            Log::info('Selected address ID from session', ['address_id' => $addressId]);

            $selectedAddress = $addressId ? Address::find($addressId) : null;
            Log::info('Selected address object', ['address' => $selectedAddress]);
            // Calculate subtotal
            $subtotal = $cartItems->sum(function ($item) {
                return $item->price * $item->quantity;
            });
            Log::info('Cart subtotal calculated', ['subtotal' => $subtotal]);

            // Calculate shipping cost if address selected
            $shippingCost = 0;
            if ($addressId) {
                Log::info('Calculating shipping cost for cart items');
                $shippingCost = app(\App\Services\ShippingService::class)
                    ->calculateCartShippingCost($cartItems, $addressId);
                Log::info('Shipping cost calculated', ['shippingCost' => $shippingCost]);
            }

            return view('products.checkout', [
                'checkoutType' => 'cart',
                'cartItems' => $cartItems,
                'user' => $user,
                'addresses' => $addresses,
                'product' => null,
                'quantity' => null,
                'sessionId' => session()->getId(),
                'shippingCost' => $shippingCost,
                'address_id' => $addressId,
                'selectedAddress' => $selectedAddress,
                'subtotal' => $subtotal
            ]);

        } catch (\Exception $e) {
            Log::error('Cart checkout failed: ' . $e->getMessage());
            return redirect()->route('cart.view')
                ->with('error', 'An error occurred during checkout');
        }
    }

    protected function getCartItems()
    {
        if (Auth::check()) {
            return Cart::with('product')->where('user_id', Auth::id())->get();
        }

        // Handle guest cart if needed (using session)
        return collect(Session::get('cart', []));
    }

    public function userorders()
    {
        $user = Auth::user();
    }

    public function success($order)
    {
        $order = UserOrder::findOrFail($order);
        return view('orders.success', compact('order'));
    }

    public function index()
    {
        $userId = Auth::id();
        $addresses = Address::where('user_id', $userId)->get();

        return view('my-account', compact('addresses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'pincode' => 'required',
            'type' => 'required',
        ]);

        Address::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'pincode' => $request->pincode,
            'type' => $request->type,
        ]);

        return redirect()->route('user.account')->with('success', 'Address added successfully!');
    }

    public function edit($id)
    {
        $address = Address::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return redirect()->route('user.account')->with('success', 'Address added successfully!');
    }

    public function update(Request $request, $id)
    {
        $address = Address::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'pincode' => 'required',
            'type' => 'required',
        ]);

        $address->update($request->only(['name', 'phone', 'address', 'city', 'state', 'pincode', 'type']));

        return redirect()->route('user.account')->with('success', 'Address added successfully!');
    }

    public function destroy($id)
    {
        $address = Address::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $address->delete();

        return redirect()->route('user.account')->with('success', 'Address added successfully!');
    }

    public function cancelOrder(Request $request, UserOrder $order)
    {
        Log::info('Cancel order request received', [
            'order_id' => $order->order_id,
            'user_id' => Auth::id(),
            'ip' => $request->ip(),
            'cancel_reason' => $request->input('cancel_reason')
        ]);

        if ($order->user_id !== Auth::id()) {
            Log::warning('Unauthorized cancel attempt', [
                'user_id' => Auth::id(),
                'order_id' => $order->order_id
            ]);
            return response()->json([
                'success' => false,
                'error' => 'Unauthorized attempt to cancel order'
            ], 403);
        }

        if (!in_array($order->order_status, ['pending', 'processing'])) {
            Log::warning('Order cannot be cancelled due to invalid status', [
                'order_id' => $order->order_id,
                'current_status' => $order->order_status
            ]);
            return response()->json([
                'success' => false,
                'error' => 'Order cannot be cancelled in its current status: ' . $order->order_status
            ], 400);
        }

        $validated = $request->validate([
            'cancel_reason' => 'required|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            // Validate order quantity
            if ($order->quantity <= 0) {
                Log::warning('Invalid order quantity for cancellation', [
                    'order_id' => $order->order_id,
                    'quantity' => $order->quantity
                ]);
                return response()->json([
                    'success' => false,
                    'error' => 'Invalid order quantity for cancellation'
                ], 400);
            }

            // Restore product quantity
            $product = Product::where('product_id', $order->product_id)->firstOrFail();
            $oldQuantity = $product->quantity ?? 0;
            $product->increment('quantity', $order->quantity);
            $product->refresh();
            Log::info('Restored product quantity', [
                'product_id' => $order->product_id,
                'quantity_restored' => $order->quantity,
                'old_quantity' => $oldQuantity,
                'new_quantity' => $product->quantity
            ]);

            // Update order status
            $order->update([
                'order_status' => 'cancelled',
                'cancel_order_reason' => $validated['cancel_reason'],
                'cancelled_at' => now()
            ]);

            Log::info('Order cancelled successfully', [
                'order_id' => $order->order_id,
                'cancel_reason' => $validated['cancel_reason']
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order cancelled successfully and quantity restored'
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            Log::error('Order or product not found during cancellation', [
                'order_id' => $order->order_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'error' => 'Order or product not found'
            ], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order cancellation failed', [
                'order_id' => $order->order_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'error' => 'Failed to cancel order: ' . $e->getMessage()
            ], 500);
        }
    }

    public function returnOrder(Request $request, UserOrder $order)
    {
        if ($order->user_id !== Auth::id()) {
            Log::warning('Unauthorized return attempt', [
                'user_id' => Auth::id(),
                'order_id' => $order->order_id
            ]);
            return response()->json([
                'success' => false,
                'error' => 'Unauthorized attempt to return order'
            ], 403);
        }

        if ($order->order_status !== 'delivered') {
            Log::warning('Order cannot be returned due to invalid status', [
                'order_id' => $order->order_id,
                'current_status' => $order->order_status
            ]);
            return response()->json([
                'success' => false,
                'error' => 'Order cannot be returned in its current status: ' . $order->order_status
            ], 400);
        }

        $validated = $request->validate([
            'return_reason' => 'required|string|max:255',
            'return_details' => 'nullable|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            $order->update([
                'order_status' => 'returned',
                '' => $validated['return_reason'],
                'return_details' => $validated['return_details'],
                'returned_at' => now()
            ]);

            Log::info('Return submitted successfully', [
                'order_id' => $order->order_id,
                'return_reason' => $validated['return_reason']
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Return request submitted successfully'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order return failed', [
                'order_id' => $order->order_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'error' => 'Failed to submit return request: ' . $e->getMessage()
            ], 500);
        }
    }

    public function contact()
    {
        $contact = Contact::first();
        return view('view.contact', compact('contact'));
    }

    public function storeEnquiry(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
            'g-recaptcha-response' => 'required|captcha'
        ]);

        try {
            $enquiry = Enquiry::create($validated);
            Log::info('Enquiry created successfully', ['id' => $enquiry->id]);
            return redirect()->route('contact')->with('success', 'Your enquiry has been submitted successfully!');
        } catch (\Exception $e) {
            Log::error('Failed to create enquiry', [
                'error' => $e->getMessage(),
                'data' => $validated
            ]);
            return back()->with('error', 'Failed to submit your enquiry. Please try again.');
        }
    }
}