<?php

namespace App\Http\Controllers;

use App\Models\Productunit;
use App\Models\StockReservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Contactus;
use App\Mail\RequestAccept;
use App\Mail\RequestReject;
use App\Mail\OrderReject;
use App\Mail\ReadyForShipping;
use App\Mail\ReturnAccept;
use Illuminate\Support\Facades\Auth;
use App\Mail\ReturnReject;
use App\Models\Orders as ModelsOrders;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Vinkla\Hashids\Facades\Hashids;
use App\Models\Gst;
use App\Models\Category;
use App\Models\UserOrder;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Address;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Auth\Events\Failed;
use Illuminate\Support\Facades\View;


use Yajra\DataTables\DataTables;

class Orders extends Controller
{

    // In your controller (e.g., DashboardController.php)
    public function index()
    {
        // Get counts for each order status
        $orderCounts = DB::table('user_orders')
            ->selectRaw('COUNT(*) as total_count')
            ->selectRaw('SUM(CASE WHEN order_status = "processing" THEN 1 ELSE 0 END) as processing_count')
            ->selectRaw('SUM(CASE WHEN order_status = "shipped" THEN 1 ELSE 0 END) as shipped_count')
            ->selectRaw('SUM(CASE WHEN order_status = "delivered" THEN 1 ELSE 0 END) as delivered_count')
            ->selectRaw('SUM(CASE WHEN order_status = "cancelled" THEN 1 ELSE 0 END) as cancelled_count')
            ->selectRaw('SUM(CASE WHEN order_status = "returned" THEN 1 ELSE 0 END) as returned_count')
            ->first();

        return view('admin-orders.orders', [
            'orders_count' => $orderCounts->total_count,
            'orders_pending' => $orderCounts->processing_count,
            'orders_shipped' => $orderCounts->shipped_count,
            'orders_accepted' => $orderCounts->shipped_count + $orderCounts->delivered_count,
            'admin_rejected' => $orderCounts->cancelled_count + $orderCounts->returned_count
            'orders_returned_REQUESTED' => $orderCounts->returned_count,
            'orders_returned_aproved' => $orderCounts->returned_count,
            'orders_returned_rejected' => $orderCounts->returned_count,
        ]);
    }

    public function create()
    {
        //
    }
    public function view($id)
    {
        $gst = Gst::findOrFail($id); // Fetch the GST record
        return view('admin.view', compact('gst')); // Return a view to display the GST details
    }

    public function gst()
    {
        $gst = Gst::all(); // Fetch all rows from the gst table
        $categories = Category::pluck('title', 'title'); // Fetch category titles
        return view('admin.gst', compact('gst', 'categories'));
    }


    public function store(Request $request)
    {
        $statuses = $request->input('gst_status', []);
        $percentages = $request->input('gst_percentage', []);
        $categories = $request->input('category_name', []);

        foreach ($statuses as $index => $status) {
            if (!empty($categories[$index]) || !empty($percentages[$index])) {
                Gst::create([
                    'gst_status' => $status,
                    'gst_percentage' => $percentages[$index] ?? null,
                    'category_name' => $categories[$index] ?? null,
                ]);
            }
        }

        return redirect()->back()->with('success', 'GST details added successfully!');
    }

    public function shows($id)
    {
        $gst = GST::findOrFail($id);
        return view('admin.view', compact('gst'));
    }


    public function edits($id)
    {
        $gst = Gst::findOrFail($id); // Fetch the GST record for editing
        $categories = Category::pluck('title', 'title');
        return view('admin.edit', compact('gst', 'categories')); // Return a view for editing the GST details
    }

    public function updates(Request $request, $id)
    {
        $request->validate([
            'gst_status' => 'required|boolean',
            'gst_percentage' => 'required|numeric',
            'category_name' => 'required|string|max:255',
        ]);

        $gst = GST::findOrFail($id);
        $gst->update([
            'gst_status' => $request->gst_status,
            'gst_percentage' => $request->gst_percentage,
            'category_name' => $request->category_name,
        ]);

        return redirect()->route('gst')->with('success', 'GST updated successfully.');
    }




    public function destroys($id)
    {
        $gst = Gst::findOrFail($id); // Find the GST record
        $gst->delete(); // Delete the GST record
        return redirect()->route('gst')->with('success', 'GST record deleted successfully!');
    }


    public function get(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json(['error' => 'Invalid request'], 400);
        }

        $draw = intval($request->input('draw'));
        $start = intval($request->input('start'));
        $length = intval($request->input('length'));
        $order_column = $request->input('order.0.column') ? 'order_id' : 'order_id';
        $order_dir = $request->input('order.0.dir', 'desc');
        $search_value = $request->input('search.value');
        $order_type = $request->input('order_type', 'all'); // Get order type from request

        // Base query with eager loading for order items (removed undefined material relationship)
        $query = UserOrder::with([
            'items.product.category',
            'items.product.images',
            'items.productUnit.color',
            'user',
            'address'
        ]);

        // Apply order type filter based on items
        if ($order_type === 'customized') {
            $query->whereHas('items.product', function ($q) {
                $q->where('customize', 1);
            });
        } elseif ($order_type === 'regular') {
            $query->whereHas('items.product', function ($q) {
                $q->where('customize', 0);
            });
        }

        // Total records count
        $totalRecords = $query->count();

        // Filter if search is present
        if (!empty($search_value)) {
            $query->where(function ($q) use ($search_value) {
                $q->whereHas('items.product', function ($subQ) use ($search_value) {
                    $subQ->where('product_name', 'like', "%{$search_value}%");
                })->orWhereHas('items.product.category', function ($subQ) use ($search_value) {
                    $subQ->where('title', 'like', "%{$search_value}%");
                })->orWhereHas('user', function ($subQ) use ($search_value) {
                    $subQ->where('name', 'like', "%{$search_value}%");
                })->orWhere('order_id', 'like', "%{$search_value}%");
            });
        }

        $filteredRecords = $query->count();

        // Apply ordering, pagination
        $orders = $query
            ->orderBy($order_column, $order_dir)
            ->skip($start)
            ->take($length)
            ->get();

        // Prepare data rows
        $data = [];
        foreach ($orders as $key => $order) {
            $showShipButton = !in_array($order->order_status, ['shipped', 'delivered', 'cancelled']);
            $showCancelButton = !in_array($order->order_status, ['cancelled', 'shipped', 'delivered']);
            $showDeliverButton = $order->order_status === 'shipped';

            // Prepare items for expandable row and view modal
            $items = [];
            foreach ($order->items as $item) {
                $image = 'no-image.png';
                if ($item->product && $item->product->images && $item->product->images->count() > 0) {
                    $image = $item->product->images->first()->web_image_1 ?? 'no-image.png';
                } elseif ($item->productUnit && method_exists($item->productUnit, 'images') && $item->productUnit->images && $item->productUnit->images->count() > 0) {
                    $image = $item->productUnit->images->first()->web_image_1 ?? 'no-image.png';
                }
                $imagePath = asset("uploads/products/" . $image);

                $items[] = [
                    'product_name' => $item->product->product_name ?? 'N/A',
                    'category' => optional($item->product->category)->title ?? 'N/A',
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'color' => optional($item->productUnit->color)->color_name ?? '',
                    'material' => optional($item->productUnit?->material ?? null)->material_name ?? '',
                    'image' => $imagePath,
                    'product' => $item->product, // For customization check
                    'customization' => $item->customization ?? null, // Assuming relation exists on OrderItem; fallback to null
                ];
            }

            $totalOrderAmount = $order->total_amount + $order->shipping_cost;

            $data[] = [
                'DT_RowIndex' => $start + $key + 1,
                'order_id' => $order->order_id,
                'user_name' => $order->user->name ?? 'Guest',
                'mobile' => $order->user->phone ?? 'N/A',
                'address' => $order->address ? ($order->address->full_address ?? $order->address->address_line1 ?? 'Address not available') : 'Address not available',
                'payment_status' => ucfirst(strtolower($order->payment_status)),
                'order_status' => ucfirst(strtolower($order->order_status)),
                'return_status' => $order->return_status ?? null,
                'return_reason' => $order->return_reason ?? null,
                'return_details' => $order->return_details ?? null,
                'total_amount' => $totalOrderAmount,
                'items' => $items,
                'actions' => '
                <div class="btn-group" role="group">
                    <button class="btn btn-sm btn-info btn-view-order" data-id="' . $order->order_id . '">
                        <i class="fas fa-eye"></i> View
                    </button>
                    ' . (
                        // Only show Ship button if showShipButton is true AND payment_status is 'success'
                        ($showShipButton && strtolower($order->payment_status) == 'success')
                        ? '<button class="btn btn-sm btn-primary shipOrderBtn" data-id="' . $order->order_id . '">
                            <i class="fas fa-truck"></i> Ship
                        </button>'
                        : ''
                    ) . '
                    ' . ($showDeliverButton ? '
                    <button class="btn btn-sm btn-success deliverOrderBtn" data-id="' . $order->order_id . '">
                        <i class="fas fa-check"></i> Deliver
                    </button>' : '') . '
                    ' . ($showCancelButton ? '
                    <button class="btn btn-sm btn-danger cancelOrderBtn" data-id="' . $order->order_id . '">
                        <i class="fas fa-times"></i> Cancel
                    </button>' : '') . '
                    <button class="btn btn-sm btn-success downloadInvoiceBtn" data-id="' . $order->order_id . '">
                        <i class="fas fa-file-invoice"></i> Invoice
                    </button>
                </div>
            ',
            ];
        }

        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data,
        ]);
    }

    /**
     * Process an admin action to approve or reject a return request for an order.
     */
    public function processReturnAction(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|integer|exists:user_orders,order_id',
            'action'   => 'required|string|in:approved,cancelled',
        ]);

        $orderId = $validated['order_id'];
        $action = $validated['action'];

        $order = UserOrder::where('order_id', $orderId)->first();

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found.'], 404);
        }

        // Determine allowed transitions:
        // - From 'requested' you can go to 'approved' or 'cancelled'
        // - From 'cancelled' you can go to 'approved'
        // - From 'approved' you can go to 'cancelled'
        $current = strtolower($order->return_status);
        $allowed = false;

        if ($current === 'requested' && in_array($action, ['approved', 'cancelled'])) {
            $allowed = true;
        } elseif ($current === 'cancelled' && $action === 'approved') {
            $allowed = true;
        } elseif ($current === 'approved' && $action === 'cancelled') {
            $allowed = true;
        }

        if (!$allowed) {
            return response()->json([
                'success' => false,
                'message' => 'Return request cannot be updated. Current status: ' . $order->return_status
            ], 400);
        }

        $order->return_status = $action;
        $order->save();

        // Optionally send notification/event here

        $msgMap = [
            'approved' => 'approved',
            'cancelled' => 'rejected'
        ];

        return response()->json([
            'success' => true,
            'message' => 'Return request ' . ($msgMap[$action] ?? $action) . ' successfully.',
            'order_id' => $order->order_id,
            'return_status' => $order->return_status,
        ]);
    }
    public function viewOrders($id)
    {
        try {
            // Eager load relevant relations, similar to get() method
            $order = UserOrder::with([
                'items.product.category',
                'items.product.images',
                'items.productUnit.color',
                'items.productUnit.images',
                'items.customization',
                'user',
                'address'
            ])->findOrFail($id);

            // Prepare items array with full details, including base64 image for customizations
            $items = [];
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
                // Handle dynamic attributes (other attributes) for this order item, based on the subcategory's selected attributes.
                $dynamicAttributes = [];
                $product = $item->product;

                if ($product && isset($product->subcategory_id)) {
                    // Fetch the subcategory to get selected attributes
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
                                // Table and PK follow: table = m_[slug], pk = m_[slug]_id
                                $table = (new $modelClass)->getTable();
                                $primaryKey = $table . '_id';
                                $attrIdField = 'm_' . $attribute->attribute_slug . '_id';
                                $attrValue = null;
                                if ($unit && isset($unit->$attrIdField)) {
                                    $attrInstance = $modelClass::where($primaryKey, $unit->$attrIdField)->first();
                                    // Only get 'name' field if available, otherwise return empty string
                                    if ($attrInstance) {
                                        // Figure out the likely name field for the table (e.g. material_name, design_name, etc)
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
           

                $items[] = [
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


            return response()->json([
                'success' => true,
                'order' => array_merge($order->toArray(), ['items' => $items]),
                'user' => $order->user,
                'address' => $order->address,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching order: ' . $e->getMessage()], 500);
        }
    }
    public function ship(Request $request)
    {
        $request->validate([
            'order_id' => 'required|integer|exists:user_orders,order_id',
            'tracking_id' => 'required|string',
            'tracking_link' => 'required|url',
        ]);

        return DB::transaction(function () use ($request) {
            $id = $request->input('order_id');
            $updateData = [
                'tracking_id' => $request->input('tracking_id'),
                'tracking_link' => $request->input('tracking_link'),
                'order_status' => 'shipped',
                'updated_at' => now(),
            ];

            $status = DB::table('user_orders')
                ->where('order_id', $id)
                ->whereNotIn('order_status', ['shipped', 'cancelled']) // Optional: prevent re-shipping
                ->update($updateData);

            if (!$status) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order could not be shipped (maybe already shipped or cancelled)'
                ], 400);
            }

            $user_order = DB::table('user_orders')->where('order_id', $id)->first();
            $user = DB::table('users')->where('id', $user_order->user_id)->first();

            try {
                Mail::to($user->email)->send(new ReadyForShipping([
                    'order_id' => $id,
                    'tracking_id' => $updateData['tracking_id'],
                    'tracking_link' => $updateData['tracking_link'],
                ]));
            } catch (\Exception $e) {
                // Log email error but still return success since the order was shipped
                \Log::error("Shipping email failed for order {$id}: " . $e->getMessage());
            }

            return response()->json(['success' => true]);
        });
    }


    public function cancel(Request $request)
    {
        $orderId = $request->input('order_id');
        \Log::info('Cancel order request received in Orders@cancel', [
            'order_id' => $orderId,
            'requested_by_user_id' => $request->user() ? $request->user()->id : null,
            'ip' => $request->ip(),
            'input' => $request->all()
        ]);

        $request->validate([
            'order_id' => 'required|exists:user_orders,order_id'
        ]);

        try {
            $order = UserOrder::where('order_id', $orderId)->first();

            if (!$order) {              
                return response()->json(['success' => false, 'message' => 'Order not found'], 404);
            }

            // "Release" reserved stock, if any (mimicking PaymentsController)
            $expiredReservations = StockReservation::where('status', 'confirmed')
                ->where('order_id', $order->transaction_id)
                ->get();

            foreach ($expiredReservations as $reservation) {
                $reservation->status = 'released';
                $reservation->save();

                if ($reservation->product_unit_id && $reservation->qty > 0) {
                    $productUnit = Productunit::where('product_unit_id', $reservation->product_unit_id)->first();
                    if ($productUnit) {
                        $productUnit->increment('stock', $reservation->qty);
                    }
                }
            }

            // Actually mark the order as cancelled
            $order->cancel('Cancelled by admin');

         
            return response()->json([
                'success' => true,
                'message' => 'Order cancelled successfully and stock released where applicable.'
            ]);
        } catch (\Exception $e) {
         
            return response()->json(['success' => false, 'error' => 'Failed to cancel order'], 500);
        }
    }


    // In your Orders controller
    public function downloadInvoice($orderId)
    {
        $order = UserOrder::with(['user', 'product', 'address'])->findOrFail($orderId);

        return view('admin-orders.invoices', compact('order'));
    }


    public function CancelRequest(Request $request)
    {
        \Log::info('Starting CancelRequest method');

        $cancelledOrders = UserOrder::with(['product', 'address', 'productImage'])
            ->whereNotNull('cancel_order_reason')
            ->orderBy('created_at', 'DESC');

        \Log::info('Base query built', ['count' => $cancelledOrders->count()]);

        $orders_count = $cancelledOrders->count();
        $accepted = (clone $cancelledOrders)->where('order_status', 'cancelled')->count();
        $rejected = (clone $cancelledOrders)->where('order_status', 'processing')->count();

        \Log::info('Counts calculated', [
            'total' => $orders_count,
            'accepted' => $accepted,
            'rejected' => $rejected
        ]);

        // Get the actual orders data with relationships
        $orders = $cancelledOrders->get();

        \Log::info('Orders data loaded', [
            'count' => $orders->count(),
            'first_order' => $orders->first() ? $orders->first()->toArray() : null,
            'first_order_image' => $orders->first() && $orders->first()->productImage
                ? $orders->first()->productImage->toArray()
                : 'No image data'
        ]);

        // Dump the first order's image data to the log
        if ($orders->isNotEmpty()) {
            $firstOrder = $orders->first();
            \Log::debug('First order details:', [
                'order_id' => $firstOrder->id,
                'has_product_image' => $firstOrder->relationLoaded('productImage'),
                'product_image' => $firstOrder->productImage ? $firstOrder->productImage->toArray() : null
            ]);
        }

        return view('admin-orders.cancel-request', compact('orders_count', 'accepted', 'rejected', 'orders'));
    }


    public function getOrderDetails($id)
    {
        $order = DB::table('user_orders')
            ->join('addresses', 'addresses.id', '=', 'user_orders.address_id')
            ->where('user_orders.id', $id)
            ->select(
                'user_orders.*',
                'addresses.address',
                'addresses.city',
                'addresses.state',
                'addresses.pincode'
            )
            ->first();

        return response()->json($order);
    }

    public function helpSupport()
    {
        $total_help_requests = DB::table('user_order_help')->count();
        return view('admin-orders.help-support', compact('total_help_requests'));
    }


    public function getOrdersHelp()
    {
        $gethelp = DB::table('user_order_help')
            ->join('user_orders', 'user_orders.order_id', '=', 'user_order_help.order_table_id')
            ->select(
                'user_order_help.id',
                'user_order_help.help_text as help_support',
                'user_order_help.created_at',
                'user_orders.order_id'
            )
            ->orderBy('user_order_help.id', 'desc')
            ->get();

        return response()->json(['data' => $gethelp]);
    }


    public function updatePaymentStatus(Request $request)
    {
        $orderId = $request->input('order_id');
        $status = strtolower($request->input('status'));

        $order = UserOrder::where('order_id', $orderId)->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ]);
        }

        try {
            if ($status === 'failed') {
                $reservations = StockReservation::where('status', 'confirmed')
                    ->where('order_id', $order->transaction_id)
                    ->get();

                $this->updateStockForReservations($reservations, 'released');
                $order->payment_status = $status;
                $order->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Your changes were saved successfully'
                ]);
            }

            if ($status === 'success') {
                $reservations = StockReservation::whereIn('status', ['released', 'reserved'])
                    ->where('order_id', $order->transaction_id)
                    ->get();

                $this->updateStockForReservations($reservations, 'confirmed');
                $order->payment_status = $status;
                $order->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Your changes were saved successfully'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Invalid payment status provided'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    private function updateStockForReservations($reservations, string $newStatus)
    {
        foreach ($reservations as $reservation) {
            if ($reservation->product_unit_id && $reservation->qty > 0) {
                $productUnit = Productunit::where('product_unit_id', $reservation->product_unit_id)->first();

                if (!$productUnit) {
                    throw new \Exception('Product Unit not found for ID: ' . $reservation->product_unit_id);
                }

                if ($newStatus === 'released') {
                    $productUnit->increment('stock', $reservation->qty);
                } elseif ($newStatus === 'confirmed') {
                    if ($productUnit->stock == 0) {
                        throw new \Exception('Stock not available for Product Unit ID: ' . $reservation->product_unit_id);
                    }
                    if ($reservation->qty > $productUnit->stock) {
                        throw new \Exception(
                            'Requested quantity (' . $reservation->qty . ') not available for Product Unit ID: ' .
                            $reservation->product_unit_id . '. Available: ' . $productUnit->stock
                        );
                    }
                    $productUnit->decrement('stock', $reservation->qty);
                }
            }

            $reservation->status = $newStatus;
            $reservation->save();
        }
    }

}
