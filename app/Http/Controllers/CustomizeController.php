<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCustomization;
use App\Models\UserOrder; // Changed from UserOrders to UserOrder

class CustomizeController extends Controller
{
    public function index()
    {
        $customizedOrders = ProductCustomization::with([
                'product', 
                'user', 
                'userOrders' => function($query) {
                    $query->select('order_id', 'session_id', 'order_status', 'created_at');
                }
            ])
            ->leftJoin('user_orders', 'product_customizations.session_id', '=', 'user_orders.session_id')
            ->where(function($query) {
                $query->whereNotNull('custom_text')
                      ->orWhereNotNull('custom_image');
            })
            ->select(
                'product_customizations.*',
                'user_orders.order_id',
                'user_orders.order_status',
                'user_orders.created_at as order_date'
            )
            ->orderBy('product_customizations.created_at', 'desc')
            ->paginate(15);

        return view('admin-orders.customize-orders', compact('customizedOrders'));
    }
}