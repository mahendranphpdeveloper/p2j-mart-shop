@extends('layouts.app')
@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4">Your Wishlist</h2>

                @if($wishlistItems->isEmpty())
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Your wishlist is empty.
                        <a href="{{ route('home') }}" class="alert-link">Continue shopping</a>
                    </div>
                @else
                    <div class="section py-4">
                        <div class="custom-container1">
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive shop_cart_table">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th class="product-thumbnail">&nbsp;</th>
                                                    <th class="product-name">Product</th>
                                                    <th class="product-price">Price</th>
                                                    <th class="product-add-cart">Add to Cart</th>
                                                    <th class="product-remove">Remove</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($wishlistItems as $item)
                                                    @php
                                                        // Use relationships eager-loaded from WishlistController@index
                                                        $product = $item->product;
                                                        $productUnit = $item->productUnit;

                                                        // Determine image (prefer unit's image, then product's, then placeholder)
                                                        $unitProductImage = $productUnit && property_exists($productUnit, 'productimage') && $productUnit->productimage && $productUnit->productimage->web_image_1
                                                            ? $productUnit->productimage->web_image_1 : null;
                                                        $mainProductImage = $product && $product->productImage && $product->productImage->web_image_1
                                                            ? $product->productImage->web_image_1 : null;
                                                        $imagePath = $unitProductImage
                                                            ? url('uploads/products/' . $unitProductImage)
                                                            : ($mainProductImage ? url('uploads/products/' . $mainProductImage) : asset('assets/images/placeholder.jpg'));

                                                        $productId = $product ? ($product->product_id ?? 0) : 0;
                                                        $productUnitId = $productUnit ? ($productUnit->product_unit_id ?? 0) : 0;
                                                        $productName = $product ? ($product->product_name ?? '') : '';
                                                        $productSlug = $product && isset($product->slug) ? $product->slug : $productId;
                                                        $productUrl = route('product.view', ['slug' => $productSlug, 'unit' => $productUnitId]);
                                                        $unitPrice = $productUnit && isset($productUnit->unit_price) ? $productUnit->unit_price : 0;
                                                    @endphp
                                                    <tr>
                                                        <td class="product-thumbnail">
                                                            <a href="{{ $productUrl }}"
                                                               data-product-id="{{ $productId }}"
                                                               data-product-unit-id="{{ $productUnitId }}">
                                                                <img src="{{ $imagePath }}" alt="{{ $productName ?: 'Product' }}">
                                                            </a>
                                                        </td>
                                                        <td class="product-name" data-title="Product">
                                                            <strong>{{ $productName ?: 'Product' }}</strong><br />
                                                        </td>
                                                        <td class="product-price" data-title="Price">
                                                            @if($unitPrice)
                                                                ₹{{ number_format($unitPrice, 2) }}
                                                            @else
                                                                Price not available
                                                            @endif
                                                        </td>
                                                        <td class="product-add-cart" data-title="Add to Cart">
                                                          <div class="add_to_cart">
                                                            <a href="javascript:void(0);" class="add-to-cart-btn"
                                                              data-product-id="{{ $productId }}"
                                                              data-product-unit-id="{{ $productUnitId }}"
                                                              data-product-name="{{ $productName }}"
                                                              data-price="{{ $unitPrice }}"
                                                              data-quantity="1"
                                                              data-wishlist-id="{{ $item->id }}"
                                                            >
                                                              <i class="fa-solid fa-cart-shopping"></i>
                                                              <span class="cart-text">Add to Cart</span>
                                                            </a>
                                                          </div>
                                                        </td>
                                                        <td class="product-remove" data-title="Remove">
                                                            <a href="#" class="remove-from-wishlist"
                                                                data-wishlist-id="{{ $item->id }}">
                                                                <i class="fa fa-times"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <a href="{{ route('home') }}" class="btn btn-fill-out mt-4">Continue Shopping</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
        addToCartButtons.forEach(button => {
          button.addEventListener('click', function (event) {
            event.preventDefault();
            // Ensure correct product details from wishlist row
            const productId = this.dataset.productId;
            const productUnitId = this.dataset.productUnitId;
            const productName = this.dataset.productName;
            const price = this.dataset.price;
            const quantity = this.dataset.quantity;
            const wishlistId = this.dataset.wishlistId; // new

            if (!productId || !productUnitId) {
              alert('Invalid product information.');
              return;
            }

            // First, add to cart
            fetch("{{ route('cart.add') }}", {
              method: "POST",
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
              },
              body: JSON.stringify({
                product_id: productId,
                product_unit_id: productUnitId,
                price: price,
                quantity: quantity
              }),
            })
              .then(response => {
                if (!response.ok) {
                  return response.json().then(err => { throw err; });
                }
                return response.json();
              })
              .then(data => {
                if (data.success) {
                  // After successful add to cart, remove from wishlist
                  if (wishlistId) {
                    fetch("{{ route('wishlist.remove') }}", {
                      method: "POST",
                      headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                      },
                      body: JSON.stringify({
                        wishlist_id: wishlistId
                      })
                    })
                    .then(resp => resp.json())
                    .then(wishlistResponse => {
                      if (wishlistResponse.success) {
                        alert('Product added to cart and removed from wishlist!');
                        updateCartCount();
                        // Optionally, remove the row from DOM without reload:
                        // this.closest('tr').remove();
                        
                      } else {
                        alert('Added to cart, but failed to remove from wishlist: ' + (wishlistResponse.message || 'Error'));
                        updateCartCount();
                     
                      }
                    })
                    .catch(err => {
                      alert('Added to cart, but error removing from wishlist.');
                      updateCartCount();
                  
                    });
                  } else {
                    alert('Product added to cart successfully!');
                    updateCartCount();
                  }
                } else {
                  alert(data.message || 'Error adding product to cart');
                }
              })
              .catch(error => {
                console.error('Error:', error);
                alert(error.message || 'An error occurred while adding to cart.');
              });
          });
        });

        function updateCartCount() {
          fetch('/cart/count')
            .then(response => response.json())
            .then(data => {
              if (data.count !== undefined) {
                const cartCountElement = document.querySelector('.cart-count');
                if (cartCountElement) {
                  cartCountElement.textContent = data.count;
                }
              }
            })
            .catch(error => {
              console.error('Error fetching cart count:', error);
            });
        }

        updateCartCount();
      });

      $(document).ready(function () {
        $(document).on('click', '.remove-from-wishlist', function (e) {
          e.preventDefault();
          const wishlistId = $(this).data('wishlist-id');

          if (!confirm('Are you sure you want to remove this item from your wishlist?')) {
            return;
          }

          $.ajax({
            url: '{{ route("wishlist.remove") }}',
            method: 'POST',
            data: {
              wishlist_id: wishlistId,
              _token: '{{ csrf_token() }}'
            },
            success: function (response) {
              if (response.success) {
           
                window.location.reload();
              } else {
                const errorMsg = 'Failed to remove item: ' + (response.message || 'Unknown error');
                alert(errorMsg);
              }
            },
            error: function (xhr) {
              const errorMsg = 'Error removing item: ' + (xhr.responseJSON?.message || 'Unknown error');
              alert(errorMsg);
            }
          });
        });
      });

    </script>
@endsection