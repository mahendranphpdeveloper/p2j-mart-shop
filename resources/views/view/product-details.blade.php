@extends('layouts.app') <!-- Or your base layout -->

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Product Images -->
        <div class="col-md-6">
            <div class="product-gallery">
                @if($product->productImages->count() > 0)
                    <div class="main-image mb-3">
                        <img src="{{ asset('storage/'.$product->productImages[0]->image_path) }}" 
                             alt="{{ $product->name }}" 
                             class="img-fluid w-100">
                    </div>
                    <div class="thumbnail-container d-flex">
                        @foreach($product->productImages as $image)
                            <div class="thumbnail mr-2">
                                <img src="{{ asset('storage/'.$image->image_path) }}" 
                                     alt="{{ $product->name }}" 
                                     class="img-thumbnail" style="width: 80px; cursor: pointer;">
                            </div>
                        @endforeach
                    </div>
                @else
                    <img src="{{ asset('assets/images/default-product.jpg') }}" 
                         alt="Default Product" 
                         class="img-fluid w-100">
                @endif
            </div>
        </div>

        <!-- Product Details -->
        <div class="col-md-6">
            <h1 class="product-title">{{ $product->name }}</h1>
            
            <div class="product-meta mb-3">
                @if($product->category)
                    <span class="category">Category: {{ $product->category->name }}</span>
                @endif
                <span class="sku">SKU: {{ $product->sku ?? 'N/A' }}</span>
            </div>

            <div class="product-price mb-3">
                <span class="price h4">₹{{ number_format($product->price, 2) }}</span>
                @if($product->original_price)
                    <span class="original-price text-muted ml-2">
                        <del>₹{{ number_format($product->original_price, 2) }}</del>
                    </span>
                @endif
            </div>

            <div class="product-description mb-4">
                {!! $product->description !!}
            </div>

            <!-- Order Details Section -->
            <div class="order-details card mb-4">
                <div class="card-header">
                    <h5>Order Information</h5>
                </div>
                <div class="card-body">
                    @if(request()->has('order_id'))
                        @php
                            $order = \App\Models\UserOrder::with(['address'])
                                        ->where('order_id', request('order_id'))
                                        ->where('user_id', auth()->id())
                                        ->first();
                        @endphp
                        
                        @if($order)
                            <ul class="list-unstyled">
                                <li><strong>Order ID:</strong> ORD-{{ $order->order_id }}</li>
                                <li><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y') }}</li>
                                <li><strong>Status:</strong> 
                                    <span class="badge 
                                        {{ $order->order_status == 'completed' ? 'badge-success' : 
                                           ($order->order_status == 'pending' ? 'badge-warning' : 'badge-danger') }}">
                                        {{ ucfirst($order->order_status) }}
                                    </span>
                                </li>
                                <li><strong>Quantity:</strong> {{ $order->quantity }}</li>
                                <li><strong>Total Paid:</strong> ₹{{ number_format($order->total_amount, 2) }}</li>
                                @if($order->address)
                                    <li><strong>Shipping Address:</strong> 
                                        {{ $order->address->address_line1 }}, 
                                        {{ $order->address->city }}, 
                                        {{ $order->address->state }} - 
                                        {{ $order->address->pincode }}
                                    </li>
                                @endif
                            </ul>
                        @else
                            <p>No order information available for this product.</p>
                        @endif
                    @else
                        <p>Viewing product details. Order information will be shown when accessed from an order.</p>
                    @endif
                </div>
            </div>

            <!-- Add to Cart Button -->
            <form action="{{ route('cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                
                @if($product->units->count() > 0)
                    <div class="form-group mb-3">
                        <label for="unit">Select Unit:</label>
                        <select name="unit_id" id="unit" class="form-control">
                            @foreach($product->units as $unit)
                                <option value="{{ $unit->id }}">
                                    {{ $unit->name }} (₹{{ number_format($unit->price, 2) }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif
                
                <div class="form-group mb-3">
                    <label for="quantity">Quantity:</label>
                    <input type="number" name="quantity" id="quantity" 
                           class="form-control" value="1" min="1">
                </div>
                
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-shopping-cart"></i> Add to Cart
                </button>
            </form>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <div class="row mt-5">
            <div class="col-12">
                <h3>Related Products</h3>
            </div>
            @foreach($relatedProducts as $related)
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card h-100">
                        <a href="{{ route('product.view', $related->slug) }}">
                            @if($related->productImages->count() > 0)
                                <img src="{{ asset('storage/'.$related->productImages[0]->image_path) }}" 
                                     class="card-img-top" 
                                     alt="{{ $related->name }}">
                            @else
                                <img src="{{ asset('assets/images/default-product.jpg') }}" 
                                     class="card-img-top" 
                                     alt="Default Product">
                            @endif
                        </a>
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="{{ route('product.view', $related->slug) }}">
                                    {{ $related->name }}
                                </a>
                            </h5>
                            <p class="card-text">₹{{ number_format($related->price, 2) }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    // Thumbnail click handler
    $(document).ready(function() {
        $('.thumbnail img').click(function() {
            const newSrc = $(this).attr('src');
            $('.main-image img').attr('src', newSrc);
        });
    });
</script>
@endsection