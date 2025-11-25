@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Order Details - #{{ $order->order_id }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Order Information -->
                        <div class="col-md-6">
                            <h4>Order Information</h4>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Order ID</th>
                                    <td>{{ $order->order_id }}</td>
                                </tr>
                                <tr>
                                    <th>Order Date</th>
                                    <td>{{ $order->created_at->format('d M Y h:i A') }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge badge-{{ $order->order_status == 'completed' ? 'success' : 'warning' }}">
                                            {{ ucfirst($order->order_status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Payment Status</th>
                                    <td>{{ ucfirst($order->payment_status) }}</td>
                                </tr>
                                <tr>
                                    <th>Total Amount</th>
                                    <td>₹{{ number_format($order->total_amount, 2) }}</td>
                                </tr>
                            </table>
                        </div>

                        <!-- Customer Information -->
                        <div class="col-md-6">
                            <h4>Customer Information</h4>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $order->user->name ?? 'Guest' }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $order->user->email ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Phone</th>
                                    <td>{{ $order->user->phone ?? $order->address->phone ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td>
                                        {{ $order->address->address ?? '' }}, 
                                        {{ $order->address->city ?? '' }}, 
                                        {{ $order->address->state ?? '' }} - 
                                        {{ $order->address->pincode ?? '' }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Product Information -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h4>Product Details</h4>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            @if($order->product->images->count() > 0)
                                                <img src="{{ asset('uploads/product/' . $order->product->images->first()->web_image_1) }}" 
                                                     class="img-fluid" alt="{{ $order->product->title }}">
                                            @else
                                                <img src="{{ asset('images/no-image.png') }}" 
                                                     class="img-fluid" alt="No Image">
                                            @endif
                                        </div>
                                        <div class="col-md-9">
                                            <h5>{{ $order->product->title ?? 'N/A' }}</h5>
                                            <p><strong>Category:</strong> {{ $order->product->category->title ?? 'N/A' }}</p>
                                            <p><strong>Quantity:</strong> {{ $order->quantity }}</p>
                                            <p><strong>Unit Price:</strong> ₹{{ number_format($order->total_amount / $order->quantity, 2) }}</p>
                                            <p><strong>Color:</strong> {{ $order->unit->color ?? 'N/A' }}</p>
                                            <p><strong>Material:</strong> {{ $order->unit->material ?? 'N/A' }}</p>
                                            <p><strong>Description:</strong> {{ $order->product->description ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Images Gallery -->
                    @if($order->product->images->count() > 0)
                    <div class="row mt-4">
                        <div class="col-12">
                            <h4>Product Images</h4>
                            <div class="row">
                                @foreach($order->product->images as $image)
                                <div class="col-md-2 col-4 mb-3">
                                    <img src="{{ asset('uploads/product/' . $image->web_image_1) }}" 
                                         class="img-thumbnail" 
                                         style="height: 120px; width: 100%; object-fit: cover;">
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="card-footer">
                    <a href="{{ route('orders.index') }}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection