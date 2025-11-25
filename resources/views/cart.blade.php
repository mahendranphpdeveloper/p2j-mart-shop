@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">Your Shopping Cart</h2>
            
            @if(empty($cartItems))
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Your cart is empty. 
                    <a href="{{ route('home') }}" class="alert-link">Continue shopping</a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cartItems as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="mr-3">
                                                @if($item->product->productImage && $item->product->productImage->web_image_1)
                                                    <img src="{{ asset('uploads/products/'.$item->product->productImage->web_image_1) }}" 
                                                         alt="{{ $item->product_name }}" 
                                                         width="80" class="img-thumbnail">
                                                @else
                                                    <img src="{{ asset('assets/images/placeholder.jpg') }}" 
                                                         width="80" class="img-thumbnail">
                                                @endif
                                            </div>
                                            <div>
                                                <h5>{{ $item->product_name }}</h5>
                                                <small class="text-muted">SKU: {{ $item->product->sku ?? 'N/A' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle">₹{{ number_format($item->price, 2) }}</td>
                                    <td class="align-middle">
                                        <div class="input-group" style="max-width: 120px;">
                                            <input type="number" class="form-control quantity-input" 
                                                   value="{{ $item->quantity }}" min="1" 
                                                   data-cart-id="{{ $item->id }}">
                                        </div>
                                    </td>
                                    <td class="align-middle">₹{{ number_format($item->price * $item->quantity, 2) }}</td>
                                    <td class="align-middle">
                                        <button class="btn btn-outline-danger btn-sm remove-from-cart" 
                                                data-cart-id="{{ $item->id }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-right"><strong>Subtotal:</strong></td>
                                <td colspan="2">₹{{ number_format($cartItems->sum(function($item) { return $item->price * $item->quantity; }), 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Continue Shopping
                        </a>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="{{ route('checkout') }}" class="btn btn-primary">
                            Proceed to Checkout <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

<script>
$(document).ready(function() {
    console.log("Cart page JS loaded.");

    // ✅ Quantity Update
    $(document).on('change', '.quantity-input', function() {
        const cartId = $(this).data('cart-id');
        const newQuantity = $(this).val();

        console.log("Updating quantity:", { cartId, newQuantity });

        $.ajax({
            url: '/update-cart',
            method: 'POST',
            data: {
                cart_id: cartId,
                quantity: newQuantity,
                _token: '{{ csrf_token() }}'
            },
            success: function() {
                console.log("Quantity updated successfully. Reloading page...");
                window.location.reload();
            },
            error: function(xhr) {
                console.error("Quantity update error:", xhr);
                alert('Error updating quantity: ' + (xhr.responseJSON?.message || 'Unknown error'));
            }
        });
    });

    // ✅ Remove Item From Cart
    $(document).on('click', '.remove-from-cart', function() {
        const cartId = $(this).data('cart-id');
        console.log("Remove button clicked. Cart ID:", cartId);

        if (!cartId) {
            console.warn("Cart ID missing on button.");
            alert("Missing cart ID.");
            return;
        }

        if (confirm('Are you sure you want to remove this item from your cart?')) {
            console.log("Confirmed. Sending AJAX request to remove...");

            $.ajax({
                url: '{{ route("cart.remove") }}',
                method: 'POST',
                data: {
                    cart_id: cartId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log("Remove response:", response);
                    if (response.success) {
                        console.log("Item removed successfully. Reloading page...");
                        window.location.reload();
                    } else {
                        console.warn("Remove failed:", response);
                        alert('Failed to remove item.');
                    }
                },
                error: function(xhr) {
                    console.error("Remove error:", xhr);
                    alert('Error removing item: ' + (xhr.responseJSON?.message || 'Unknown error'));
                }
            });
        } else {
            console.log("User cancelled item removal.");
        }
    });
});
</script>
