<div>
    <div class="container py-4">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4">Your Shopping Cart</h2>
               
                @if($isEmpty)
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Your cart is empty.
                        <a href="{{ route('home') }}" class="alert-link">Continue shopping</a>
                    </div>
                @else
                <div class="section py-4">
                    <div class="custom-container1">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-12">
                                <div class="table-responsive shop_cart_table">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="product-thumbnail"> </th>
                                                <th class="product-name">Product</th>
                                                <th class="product-price">Price</th>
                                                <th class="product-quantity">Quantity</th>
                                                <th class="product-subtotal">Total</th>
                                                <th class="product-remove">Remove</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($cartItems as $item)
                                                <tr wire:key="cart-{{ $item->id }}" data-cart-id="{{ $item->id }}">
                                                    <td class="product-thumbnail">
                                                        <a href="#">
                                                            @if($item->product->productImage && $item->productUnit->productimage->web_image_1 ||)
                                                                <img src="{{ asset('uploads/products/'.$item->productUnit->productimage->web_image_1) }}" alt="{{ $item->product_name }}">
                                                            @else
                                                                <img src="{{ asset('assets/images/placeholder.jpg') }}" alt="placeholder">
                                                            @endif
                                                        </a>
                                                    </td>
                                                    <td class="product-name" data-title="Product"><a href="#">{{ $item->product_name }}</a></td>
                                                    <td class="product-price" data-title="Price">₹{{ number_format($item->price, 2) }}</td>
                                                    <td class="product-quantity" data-title="Quantity">
                                                        <div class="quantity">
                                                            <input type="button" wire:click="decrementQuantity({{ $item->id }})" value="-" class="minus" data-cart-id="{{ $item->id }}">
                                                            <input type="text" 
                                                                   value="{{ $item->quantity }}"
                                                                   data-cart-id="{{ $item->id }}"
                                                                   title="Qty" class="qty quantity-input" size="4">
                                                            <input type="button" wire:click="incrementQuantity({{ $item->id }})" value="+" class="plus" data-cart-id="{{ $item->id }}">
                                                        </div>
                                                    </td>
                                                    <td class="product-subtotal" data-title="Total">₹{{ number_format($item->price * $item->quantity, 2) }}</td>
                                                    <td class="product-remove" data-title="Remove">
                                                        <a href="#" wire:click="removeItem({{ $item->id }})" class="remove-from-cart" data-cart-id="{{ $item->id }}" onclick="return confirm('Are you sure?')">
                                                            <i class="fa fa-times"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="6" class="px-0">
                                                    <div class="row g-0 align-items-center">
                                                        <div class="col-lg-6 col-md-6 mb-3 mb-md-0">
                                                            <div class="coupon field_form input-group">
                                                                <input type="text" value="" class="form-control form-control-sm" placeholder="Enter Coupon Code..">
                                                                <div class="input-group-append">
                                                                    <button class="btn btn-fill-out btn-sm" type="submit">Apply Coupon</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 text-start text-md-end">
                                                            <button class="btn btn-line-fill btn-sm" wire:click="loadCart">Update Cart</button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 h-100 my-auto">
                                <div class="border p-3 p-md-4 cart-total">
                                    <div class="heading_s1 mb-3">
                                        <h6>Cart Totals</h6>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td class="cart_total_label">Cart Subtotal</td>
                                                    <td class="cart_total_amount">₹{{ number_format($subtotal, 2) }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="cart_total_label">Total</td>
                                                    <td class="cart_total_amount"><strong>₹{{ number_format($subtotal, 2) }}</strong></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <a href="{{ route('checkout') }}" class="btn btn-fill-out">
                                        Proceed To CheckOut
                                    </a>
                                    <div class="mt-2 text-danger" style="font-size: 0.8rem;">
                                        <strong>Note:</strong> Don't make payment. The payment process is currently under testing.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function() {
    console.log("Cart Livewire JS loaded.");
    // No need for manual AJAX—Livewire handles updates reactively
});
</script>