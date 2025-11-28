@extends('layouts.app')

@section('content')

<style>
   span.active {
    border-color: rgb(206, 27, 26) !important;
    background-color: #031B4E;
}
</style>

    <div class="bg-white page-title-mini py-3">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12">
                    <ol class="breadcrumb justify-content-md-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Pages</a></li>
                        <li class="breadcrumb-item active">Product Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <div class="main-content">
        @if($product->units->isNotEmpty())


            <livewire:product-show :slug="$product->slug" />
        @endif
    </div>
    <!-- Additional Info  Section -->



    @if($relatedProducts->isNotEmpty())
        <!-- Related Products Section -->
        <div class="section pt-5">
            <div class="heading_s1">
                <h3 class="mb-4">Related Products</h3>
            </div>
            <div class="product_slider carousel_slider owl-carousel owl-theme dot_style1" data-loop="true" data-margin="20"
                data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "991":{"items": "4"}}'>
                @foreach ($relatedProducts as $related)
                    @php
                        $productUnit = $related->units->first() ?? null;
                        $productImage = $productUnit && $productUnit->productimage ? $productUnit->productimage : null;
                        $imagePath = $productImage && $productImage->web_image_1
                            ? url('uploads/products/' . $productImage->web_image_1)
                            : asset('assets/images/placeholder.jpg');
                        $productId = $related->product_id ?? 0;
                        $productUnitId = $productUnit->product_unit_id ?? 0;
                        $productSlug = $related->slug ?? $productId;
                    @endphp
                    <div class="item">
                        <div class="product_wrap">
                            <div class="product_img">
                                <a href="{{ route('product.view', ['slug' => $productSlug, 'unit' => $productUnitId]) }}"
                                   data-product-id="{{ $productId }}"
                                   data-product-unit-id="{{ $productUnitId }}">
                                    <img src="{{ $imagePath }}" alt="{{ $related->product_name }}">
                                    <img class="product_hover_img" src="{{ $imagePath }}" alt="Hover Image">
                                </a>
                                @php
                                    // Use the global helper to get all product_unit_ids in wishlist for this user/session
                                    $wishlistItems = function_exists('getWishlistProductUnitItems') ? getWishlistProductUnitItems() : [];
                                    $inWishlist = in_array($productUnitId, $wishlistItems);
                                    @php
print_r(  $wishlistproductunitItems);      
@endphp
                                @endphp
                                <div class="wishlist_btn">
                                    <a href="javascript:void(0);"
                                       class="wishlist-btn{{ $inWishlist ? ' active' : '' }}"
                                       data-product-id="{{ $productId }}"
                                       data-product-unit-id="{{ $productUnitId }}"
                                       title="{{ $inWishlist ? 'Remove from Wishlist' : 'Add to Wishlist' }}">
                                        @if($inWishlist)
                                            <i class="fa-solid fa-heart"></i>
                                        @else
                                            <i class="fa-regular fa-heart"></i>
                                        @endif
                                    </a>
                                </div>
                            </div>
                            <div class="product_info">
                                <h6 class="product_title" title="{{ $related->product_name }}">
                                    {{ \Illuminate\Support\Str::limit($related->product_name, 32, '...') }}
                                </h6>
                                <div class="product_price">
                                    <span class="price">
                                        ₹{{ isset($productUnit->unit_price) ? number_format($productUnit->unit_price, 2) : '0.00' }}
                                    </span>
                                    @if (!empty($productUnit->mrp_price))
                                        <del>₹{{ number_format($productUnit->mrp_price, 2) }}</del>
                                    @endif
                                    @if (!empty($productUnit->unit_price) && !empty($productUnit->mrp_price) && $productUnit->mrp_price > 0)
                                        @php
                                            $discount = 100 - ($productUnit->unit_price / $productUnit->mrp_price * 100);
                                        @endphp
                                        <div class="on_sale">
                                            <span>{{ round($discount) }}% Off</span>
                                        </div>
                                    @endif
                                    <div class="add_to_cart mt-2">
                                        <a href="javascript:void(0);"
                                           class="add-to-cart-btn"
                                           data-product-id="{{ $productId }}"
                                           data-product-unit-id="{{ $productUnitId }}"
                                           data-product-name="{{ $related->product_name }}"
                                           data-price="{{ $productUnit->unit_price ?? 0 }}" data-quantity="1">
                                            <i class="fa-solid fa-cart-shopping"></i>
                                            <span class="cart-text">Add to Cart</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="rating_wrap">
                                    <div class="rating">
                                        <div class="product_rate" style="width: 68%"></div>
                                    </div>
                                    <span class="rating_num">(15)</span>
                                </div>
                                <div class="pr_desc">
                                    <p class="mb-0 text-truncate" style="max-width: 200px;">
                                        {{ $related->description ?? 'Exclusive product from our store' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    </div>

    </div>


    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Thumbnail Click Script -->
    <script>
        $(document).ready(function () {
            $('.product_gallery_item').on('click', function () {
                var newImage = $(this).data('image');
                $('#mainProductImage').attr('src', newImage);
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            $('#buyNowForm').on('submit', function (e) {
                var productSlug = $('input[name="product_name"]').val();

                if (!productSlug) {
                    console.error('Product name  is missing');
                    e.preventDefault();
                    alert('Please select a valid product.');
                    return false;
                }

                // Add loading state
                $(this).find('button[type="submit"]')
                    .prop('disabled', true)
                    .html('<i class="fa-solid fa-spinner fa-spin"></i> Processing...');
            });
        });
    </script>

    <script>
        // Simple hover zoom
        document.addEventListener('DOMContentLoaded', function () {
            const image = document.getElementById('mainProductImage');

            // Option 1: Simple hover zoom
            image.addEventListener('mousemove', function (e) {
                const container = this.parentElement;
                const containerRect = container.getBoundingClientRect();
                const x = e.clientX - containerRect.left;
                const y = e.clientY - containerRect.top;

                const xPercent = x / containerRect.width * 100;
                const yPercent = y / containerRect.height * 100;

                this.style.transformOrigin = `${xPercent}% ${yPercent}%`;
                this.style.transform = 'scale(2)';
            });

            image.addEventListener('mouseleave', function () {
                this.style.transform = 'scale(1)';
            });

            // Option 2: For more advanced zoom (lens style), you can use a library like elevateZoom
        });

        document.addEventListener('DOMContentLoaded', function () {
            console.log("DOM loaded - Add to Cart script initialized");

            const addToCartButtons = document.querySelectorAll('.btn-addtocart');
            console.log("Total buttons found:", addToCartButtons.length);

            addToCartButtons.forEach(button => {
                button.addEventListener('click', function (event) {
                    event.preventDefault();
                    console.log("Add to Cart clicked");
                    // Print all data attributes of the clicked button for debugging
                    console.log('All data:', this.dataset);

  
                    const productId = this.dataset.productId;
                    const productUnitId = this.dataset.productUnitId;
                    const productName = this.dataset.productName;
                    const price = this.dataset.price;
                    const quantity = this.dataset.quantity;

             

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
                            product_name: productName,
                            price: price,
                            quantity: quantity
                        }),
                    })
                        .then(response => {
                            console.log("Fetch status:", response.status);
                            if (!response.ok) {
                                return response.json().then(err => { throw err; });
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log("Server Response:", data);
                            if (data.success) {
                                alert('Product added to cart successfully!');
                                updateCartCount();
                            } else {
                                alert(data.message || 'Error adding product to cart');
                            }
                        })
                        .catch(error => {
                            console.error('Catch Error:', error);
                            alert(error.message || 'Validation or network error occurred.');
                        });
                });
            });

            function updateCartCount() {
                console.log("Updating cart count...");
                fetch('/cart/count')
                    .then(response => response.json())
                    .then(data => {
                        console.log("Cart count data:", data);
                        if (data.count !== undefined) {
                            const cartCountElement = document.querySelector('.cart-count');
                            if (cartCountElement) {
                                cartCountElement.textContent = data.count;
                                console.log("Cart count updated");
                            }
                        }
                    })
                    .catch(error => {
                        console.error("Error fetching cart count:", error);
                    });
            }

            updateCartCount(); // Initial cart count
        });


        document.addEventListener('DOMContentLoaded', function () {
            const wishlistButtons = document.querySelectorAll('.wishlist-btn');

            wishlistButtons.forEach(button => {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    const productId = this.dataset.productId;
                    const productUnitId = this.dataset.productUnitId || null;
                        fetch("{{ route('wishlist.add') }}", {
                            method: "POST",
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },                            
                            body: JSON.stringify({ 
                                product_id: productId, 
                                product_unit_id: productUnitId 
                                })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                alert("Added to wishlist!");
                                updateWishlistCount();
                            } else {
                                alert(data.message || "Error");
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            alert("Error adding to wishlist");
                        });
                });
            });

            function updateWishlistCount() {
                fetch("{{ route('wishlist.count') }}")
                    .then(res => res.json())
                    .then(data => {
                        const countElement = document.querySelector('.wishlist-count');
                        if (countElement && data.count !== undefined) {
                            countElement.textContent = data.count;
                        }
                    });
            }

            updateWishlistCount();
        });


        //customization

        document.addEventListener('DOMContentLoaded', function () {
            console.log('DOM fully loaded and parsed');

            // Elements
            const previewBtn = document.getElementById('preview_customization');
            const confirmBtn = document.getElementById('confirm_customization');
            const customText = document.getElementById('custom_text');
            const customImage = document.getElementById('custom_image');
            const previewText = document.getElementById('preview_text');
            const previewImage = document.getElementById('preview_image');
            const previewSection = document.getElementById('customization_preview');
            const buyNowForm = document.getElementById('buyNowForm');
            const formCustomText = document.getElementById('form_custom_text');
            const formCustomImage = document.getElementById('form_custom_image');

            console.log('All elements fetched');

            // Preview customization
            if (previewBtn) {
                console.log('Preview button found');
                previewBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    console.log('Preview button clicked');

                    // Handle text preview if text customization is enabled
                    if (customText) {
                        console.log('Custom text value:', customText.value);
                        if (previewText) {
                            previewText.textContent = customText.value || 'No custom text provided';
                        }
                    }

                    // Handle image preview if image customization is enabled
                    if (customImage) {
                        if (customImage.files && customImage.files[0]) {
                            console.log('Custom image file selected:', customImage.files[0].name);
                            const reader = new FileReader();
                            reader.onload = function (e) {
                                if (previewImage) {
                                    previewImage.src = e.target.result;
                                    previewImage.style.display = 'block';
                                    console.log('Preview image updated');
                                }
                            };
                            reader.readAsDataURL(customImage.files[0]);
                        } else if (previewImage) {
                            console.log('No custom image selected');
                            previewImage.style.display = 'none';
                        }
                    }

                    previewSection.style.display = 'block';
                    console.log('Preview section shown');
                });
            }

            // Confirm customization
            if (confirmBtn) {
                console.log('Confirm button found');
                confirmBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    console.log('Confirm button clicked');

                    if (formCustomText && customText) {
                        formCustomText.value = customText.value;
                        console.log('Custom text copied to form:', formCustomText.value);
                    }

                    if (formCustomImage && customImage && customImage.files && customImage.files[0]) {
                        console.log('Transferring file to hidden input:', customImage.files[0].name);
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(customImage.files[0]);
                        formCustomImage.files = dataTransfer.files;
                        console.log('File transferred to hidden form input');
                    }

                    alert('Customization confirmed! Click Buy Now to proceed.');
                });
            }

            // Handle form submission
            if (buyNowForm) {
                console.log('Buy Now form found');
                buyNowForm.addEventListener('submit', function (e) {
                    console.log('Buy Now form submitting');
                    const customizeSection = document.querySelector('.customization_section');

                    if (customizeSection) {
                        console.log('Customization section present');
                        let isValid = true;

                        // Validate based on customization type
                        if (customText && !customText.value && (!customImage || !customImage.files || !customImage.files[0])) {
                            // Check if both fields are empty when required
                            if (document.querySelector('#text_customization') && document.querySelector('#image_customization')) {
                                e.preventDefault();
                                console.warn('No customization entered — blocking submission');
                                alert('This product requires customization. Please add custom text or image before proceeding.');
                                isValid = false;
                            }
                            // Check if text field is empty when required
                            else if (document.querySelector('#text_customization') && !customText.value) {
                                e.preventDefault();
                                console.warn('No custom text entered — blocking submission');
                                alert('This product requires custom text. Please add your custom text before proceeding.');
                                isValid = false;
                            }
                            // Check if image is not uploaded when required
                            else if (document.querySelector('#image_customization') && (!customImage.files || !customImage.files[0])) {
                                e.preventDefault();
                                console.warn('No custom image uploaded — blocking submission');
                                alert('This product requires a custom image. Please upload your image before proceeding.');
                                isValid = false;
                            }
                        }

                        if (isValid) {
                            console.log('Customization valid — proceeding with submission');
                        }
                    } else {
                        console.log('No customization required');
                    }
                });
            }
        });

    </script>
@endsection