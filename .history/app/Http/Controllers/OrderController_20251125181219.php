<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\UserOrder;
use App\Models\OrderItem;
use App\Models\ProductImage;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use App\Models\Address;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Services\ShippingService;
use App\Http\Controllers\PaymentController;
use App\Models\Productunit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class OrderController extends Controller
{
    protected $shippingService;

    public function __construct(ShippingService $shippingService)
    {
        $this->shippingService = $shippingService;
    }

    public function store(Request $request)
    {
        try {
            if ($request->checkout_type === 'buy_now') {
                $validated = $this->validateBuyNowRequest($request);
            } else {
                $validated = $this->validateCartRequest($request);
            }
    
            $itemData = $this->prepareItemData($validated, $request->checkout_type);
    
            $orderId = 'ORD' . time() . Str::random(4);
            $subtotal = collect($itemData)->sum(fn($i) => $i['quantity'] * $i['unit_price']);
            $addressId = $validated['address_id'];
            $checkout_type = $validated['checkout_type'];
    
            // Shipping Cost
            if ($checkout_type === 'buy_now') {
                $shippingCost = $this->shippingService->calculateShippingCost(
                    $validated['product_id'],
                    $validated['quantity'],
                    $addressId
                );
            } else {
                $cartItemsForShipping = collect($itemData)->map(fn($i) => (object) [
                    'product_id' => $i['product_id'],
                    'quantity' => $i['quantity'],
                ]);
                $shippingCost = $this->shippingService->calculateCartShippingCost($cartItemsForShipping, $addressId);
            }
    
            // 1) Reserve Stock
            foreach ($itemData as $item) {
    
                // Get available stock
                if ($item['product_unit_id']) {
                    $unit = Productunit::find($item['product_unit_id']);
                    $available = $unit->stock ?? 0;
                } else {

                    
                    $product = Product::find($item['product_id']);
                    $available = $product->stock ?? 0;
                }
    
                // Check stock
                if ($item['quantity'] > $available) {
                    throw new \Exception("Not enough stock for product ID: " . $item['product_id']);
                }
    
                // Reserve stock for 10 minutes
                DB::table('stock_reservations')->insert([
                    'order_id' => $orderId,
                    'product_id' => $item['product_id'],
                    'product_unit_id' => $item['product_unit_id'],
                    'qty' => $item['quantity'],
                    'expires_at' => now()->addMinutes(10),
                    'status' => 'reserved',
                ]);
            }
    
            // 2) Create pending order
            $this->createOrderRecords(
                $itemData,
                $orderId,
                Auth::id(),
                session()->getId(),
                $addressId,
                $subtotal,
                $shippingCost,
                checkout_type
            );
    
            return redirect()->route('payment.initiate', [
                'order_id' => $orderId,
                'amount' => $subtotal + $shippingCost
            ]);
    
        } catch (\Exception $e) {
            Log::error('Order placement failed', ['error' => $e->getMessage()]);
            return back()->with('error', $e->getMessage());
        }
    }
    

    protected function validateBuyNowRequest(Request $request)
    {
        return $request->validate([
            'product_id' => 'required|integer|exists:product,product_id',
            'product_unit_id' => 'nullable|integer|exists:product_unit,product_unit_id',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'address_id' => 'required|integer',
            'checkout_type' => 'required|in:buy_now,cart'
        ]);
    }

    protected function validateCartRequest(Request $request)
    {
        return $request->validate([
            'products' => 'required|array',
            'products.*.product_id' => 'required|integer|exists:product,product_id',
            'products.*.product_unit_id' => 'nullable|integer|exists:product_unit,product_unit_id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
            'address_id' => 'required|integer',
            'checkout_type' => 'required|in:buy_now,cart'
        ]);
    }

    protected function prepareItemData($validated, $checkoutType)
    {
        if ($checkoutType === 'buy_now') {
            return [
                [
                    'product_id' => $validated['product_id'],
                    'product_unit_id' => $validated['product_unit_id'] ?? null,
                    'quantity' => $validated['quantity'],
                    'unit_price' => $validated['unit_price'],
                ]
            ];
        }

        $itemData = [];
        foreach ($validated['products'] as $item) {
            $itemData[] = [
                'product_id' => $item['product_id'],
                'product_unit_id' => $item['product_unit_id'] ?? null,
                'quantity' => $item['quantity'],
                'unit_price' => $item['price'],
            ];
        }
        return $itemData;
    }

    protected function createOrderRecords($itemData, $transactionId, $userId, $sessionId, $addressId, $subtotal, $shippingCost)
    {
        Log::info(print_r($itemData, true));

        // Lock and check stock for all items
        foreach ($itemData as $item) {
            $productUnit = \App\Models\Productunit::where('product_unit_id', $item['product_unit_id'])->lockForUpdate()->first();
            if (!$productUnit) {
                throw new \Exception("Product unit ID {$item['product_unit_id']} not found for Product ID {$item['product_id']}");
            }
            // Check stock (must be numeric and >= requested quantity)
            if (!is_numeric($productUnit->stock) || $productUnit->stock < $item['quantity']) {
                throw new \Exception("Insufficient stock for product ID {$item['product_id']} (unit {$item['product_unit_id']}): Available {$productUnit->stock}, Requested {$item['quantity']}");
            }
        }

        // Decrement stock for all items
        foreach ($itemData as $item) {
            \App\Models\Productunit::where('product_unit_id', $item['product_unit_id'])->decrement('stock', $item['quantity']);
        }

        // Create the main order record
        $order = UserOrder::create([
            'user_id' => $userId ?? 0,
            'address_id' => $addressId,
            'total_amount' => $subtotal,
            'shipping_cost' => $shippingCost,
            'transaction_id' => $transactionId,
            'session_id' => $sessionId,
            'payment_status' => 'pending',
            'order_status' => 'processing',
        ]);

        // Create order items
        foreach ($itemData as $item) {
            OrderItem::create([
                'order_id' => $order->order_id,
                'product_id' => $item['product_id'],
                'product_unit_id' => $item['product_unit_id'],
                'quantity' => $item['quantity'],
                'price' => $item['unit_price'],
            ]);
        }
    }

    public function success($orderId)
    {
        $order = UserOrder::with(['items.product', 'items.productUnit', 'address'])
            ->where('transaction_id', $orderId)
            ->firstOrFail();

        return view('orders.success', [
            'orderId' => $orderId,
            'order' => $order,
            'totalAmount' => $order->total_amount + $order->shipping_cost
        ]);
    }

    public function failure($orderId)
    {
        $order = UserOrder::with(['items.product', 'items.productUnit', 'address'])
            ->where('transaction_id', $orderId)
            ->firstOrFail();

        return view('orders.failure', [
            'orderId' => $orderId,
            'order' => $order
        ]);
    }

    public function showSuccess($order)
    {
        $sessionId = session()->getId();
        // This gets the specific order just placed
        $currentOrder = UserOrder::with(['items.product.product_image', 'items.productUnit', 'address'])
            ->where('transaction_id', $order)
            ->where(function ($query) use ($sessionId) {
                $query->where('user_id', Auth::id())
                      ->orWhere('session_id', $sessionId);
            })
            ->firstOrFail();
        // Show all orders for either the logged-in user or the guest session
        $allOrders = UserOrder::with(['items.product.product_image'])
            ->where(function ($query) use ($sessionId) {
                $query->where('user_id', Auth::id())
                      ->orWhere('session_id', $sessionId);
            })
            ->orderBy('created_at', 'desc')
            ->get();
        return view('orders.success', [
            'order' => $currentOrder,
            'allOrders' => $allOrders,
        ]);
    }

    public function index()
    {
        $orders = UserOrder::with(['items.product', 'items.productUnit', 'address'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function inde()
    {
        $wishlistItems = auth()->user()->wishlistItems()->with('product')->get();
        return view('my-account', compact('wishlistItems'));
    }

    public function cancel(Request $request, $order_id)
    {
        Log::info("Cancel request received", [
            'order_id' => $order_id,
            'user_id' => auth()->id(),
            'ip' => $request->ip(),
            'received_reason' => $request->input('cancel_reason')
        ]);
        try {
            DB::beginTransaction();
            $order = UserOrder::where('order_id', $order_id)
                        ->where('user_id', auth()->id())
                        ->firstOrFail();
            if (!in_array($order->order_status, ['processing', 'pending'])) {
                return response()->json([
                    'success' => false,
                    'error' => 'Order cannot be cancelled in its current status'
                ], 400);
            }
            $cancelReason = $request->input('cancel_reason');
            // Restore product unit stock for all items
            foreach ($order->items as $item) {
                if ($item->product_unit_id) {
                    $productUnit = \App\Models\Productunit::where('product_unit_id', $item->product_unit_id)->firstOrFail();
                    $productUnit->increment('stock', $item->quantity);
                    Log::info('Restored product unit stock', [
                        'product_unit_id' => $item->product_unit_id,
                        'quantity_restored' => $item->quantity,
                        'new_stock' => $productUnit->fresh()->stock
                    ]);
                }
            }
            // Update order status
            $updateResult = $order->update([
                'order_status' => 'cancelled',
                'cancel_order_reason' => $cancelReason,
                'cancelled_at' => now()
            ]);
            Log::info('Update order status', [
                'success' => $updateResult,
                'affected' => $order->wasChanged(),
                'order_id' => $order_id,
                'cancel_reason' => $cancelReason
            ]);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Order cancelled successfully'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            Log::error('Order or product not found during cancellation', [
                'order_id' => $order_id,
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'success' => false,
                'error' => 'Order or product not found'
            ], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Order cancellation failed: " . $e->getMessage(), [
                'order_id' => $order_id,
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'error' => 'Internal server error'
            ], 500);
        }
    }

    public function invoice($orderId)
    {
        $order = UserOrder::with(['items.product', 'items.productUnit', 'address'])
            ->where('order_id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();
        return view('orders.invoice', compact('order'));
    }
}
