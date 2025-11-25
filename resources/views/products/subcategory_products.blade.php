@extends('layouts.app')

@section('content')

<div class="bg-white page-title-mini py-3">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12">
                <ol class="breadcrumb justify-content-md-end">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Pages</a></li>
                    <li class="breadcrumb-item active">Products Page</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="main-content">
    <section class="section pt-3">
        <div class="custon-container">

            @if($products->isEmpty())
                <p>No products found in this subcategory.</p>
            @else
                <div class="row">
                    <!-- Sidebar -->
                    <div class="col-lg-3 order-lg-first mt-4 pt-2 mt-lg-0 pt-lg-0">
                        <div class="sidebar d-none d-lg-block" id="filterSidebar">

                            <!-- Categories -->
                            <div class="widget mb-4">
                                <h5 class="widget_title">Categories</h5>
                                <ul class="widget_categories list-unstyled">
                                    @forelse($categories as $category)
                                        <li>
                                            <a href="{{ route('category.products', ['slug' => $category->category_slug]) }}">
                                                <span class="categories_name">{{ $category->title }}</span>
                                                <span class="categories_num">({{ $category->products_count }})</span>
                                            </a>
                                        </li>
                                    @empty
                                        <li><span>No categories found.</span></li>
                                    @endforelse
                                </ul>
                            </div>

                            <!-- Price Filter -->
                            <div class="widget mb-4">
                                <h5 class="widget_title">Filter</h5>
                                <div class="filter_price">
                                    <div id="price_filter" data-min="0" data-max="10000" data-min-value="50" data-max-value="5000" data-price-sign="₹"></div>
                                    <div class="price_range mt-2">
                                        <span>Price: <span id="flt_price"></span></span>
                                        <input type="hidden" id="price_first">
                                        <input type="hidden" id="price_second">
                                    </div>
                                </div>
                            </div>

                            <!-- Brand Filter -->
                            <div class="widget mb-4">
                                <h5 class="widget_title">Brand</h5>
                                <ul class="list_brand list-unstyled">
                                    @foreach(['New Arrivals', 'Lighting', 'Tables', 'Chairs', 'Accessories'] as $brand)
                                        <li>
                                            <div class="custome-checkbox">
                                                <input class="form-check-input" type="checkbox" name="brand[]" id="{{ $brand }}">
                                                <label class="form-check-label" for="{{ $brand }}"><span>{{ $brand }}</span></label>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <!-- Size Filter -->
                            <div class="product_size_switch">
                                <h5 class="mb-3">Size</h5>
                                @php $activeSize = request('size'); @endphp
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($sizes as $size)
                                        @php $isUsed = in_array($size->size_name, $usedSizes); @endphp
                                        <a href="{{ route('subcategory.products', ['id' => $subcategory->id, 'size' => $size->size_name]) }}"
                                            class="badge px-3 py-2 {{ $activeSize === $size->size_name ? 'bg-primary text-white' : ($isUsed ? 'bg-light text-dark border border-secondary' : 'bg-secondary text-white') }}"
                                            style="cursor:pointer; font-size: 14px;">
                                            {{ strtoupper($size->size_name) }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Product Grid -->
                    <div class="col-md-9">
                        <div class="row align-items-center mb-4 pb-1">
                            <div class="col-12">
                                <div class="product_header d-flex justify-content-between align-items-center">
                                    <div class="custom_select">
                                        <select class="form-control form-control-sm">
                                            <option value="order">Default sorting</option>
                                            <option value="popularity">Sort by popularity</option>
                                            <option value="date">Sort by newness</option>
                                            <option value="price">Sort by price: low to high</option>
                                            <option value="price-desc">Sort by price: high to low</option>
                                        </select>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <a href="javascript:;" class="shorting_icon grid active"><i class="ti-view-grid"></i></a>
                                        <a href="javascript:;" class="shorting_icon list"><i class="ti-layout-list-thumb"></i></a>
                                        <select class="form-control form-control-sm">
                                            <option value="">Showing</option>
                                            <option value="9">9</option>
                                            <option value="12">12</option>
                                            <option value="18">18</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            @foreach($products as $product)
                                <div class="col-lg-3 col-md-4 col-sm-12 mb-4">
                                    <div class="product">
                                        <div class="product_img">
                                            <a href="{{ route('product.view', $product->slug) }}">
                                            @if ($product->productImage && $product->productImage->web_image_1)
                        <img src="{{ url('uploads/products/' . $product->productImage->web_image_1) }}" alt="Product Image">
                        <img class="product_hover_img" src="{{ url('uploads/products/' . $product->productImage->web_image_1) }}" alt="Product Hover Image">
                      @else
                        <img src="assets/images/placeholder.jpg" alt="No Image">
                        <img class="product_hover_img" src="assets/images/placeholder.jpg" alt="No Image">
                      @endif
                                           <div class="wishlist_btn">
                    <a href="javascript:void(0);" class="wishlist-btn" data-product-id="{{ $product->product_id }}">
                        <i class="fa-regular fa-heart"></i>
                    </a>
                </div>
            </div>
                                        <div class="product_info">
                                            <h6 class="product_title">
                                                <a href="{{ route('product.view', $product->slug) }}">{{ $product->product_name }}</a>
                                            </h6>

                                            @php
                                                $unit = $product->units->first();
                                                $discount = 0;
                                                if ($unit && $unit->mrp_price > 0) {
                                                    $discount = round((($unit->mrp_price - $unit->unit_price) / $unit->mrp_price) * 100);
                                                }
                                            @endphp

                                            @if($unit)
                                                <div class="product_price">
                                                    <span class="price">₹{{ $unit->unit_price }}</span>
                                                    <del>₹{{ $unit->mrp_price }}</del>
                                                    <div class="on_sale">
                                                        @if($discount > 0)
                                                            <span>{{ $discount }}% Off</span>
                                                        @endif
                                                         <div class="cart_btn">
    <button class="btn btn-fill-out btn-addtocart add-to-cart-btn"
        type="button"
        data-product-id="{{ $product->product_id }}"
        data-product-name="{{ $product->product_name }}"
        data-price="{{ $unit->unit_price ?? 0 }}"
        data-quantity="1">
        <i class="fa-solid fa-cart-shopping"></i>
        <span class="cart-text">Add to Cart</span>
    </button>
</div>
                                                    </div>
                                                </div>
                                            @else
                                                <p class="text-danger">No unit pricing found</p>
                                            @endif

                                            <div class="rating_wrap">
                                                <div class="rating">
                                                    <div class="product_rate" style="width: 68%"></div>
                                                </div>
                                                <span class="rating_num">(15)</span>
                                            </div>

                                            <div class="pr_desc">
                                                <p>{{ Str::limit(strip_tags($product->description), 100, '...') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            @endif

        </div>
    </section>
</div>

@endsection

<script>  document.addEventListener('DOMContentLoaded', function () {
    console.log("DOM loaded - Add to Cart script initialized");

    const addToCartButtons = document.querySelectorAll('.btn-addtocart');
    console.log("Total buttons found:", addToCartButtons.length);

    addToCartButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            console.log("Add to Cart clicked");

            const productId = this.dataset.productId;
            const productName = this.dataset.productName;
            const price = this.dataset.price;
            const quantity = this.dataset.quantity;

            console.log("Product ID:", productId);
            console.log("Product Name:", productName);
            console.log("Price:", price);
            console.log("Quantity:", quantity);

            fetch("{{ route('cart.add') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    product_id: productId,
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

            fetch("{{ route('wishlist.add') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ product_id: productId })
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
</script>
