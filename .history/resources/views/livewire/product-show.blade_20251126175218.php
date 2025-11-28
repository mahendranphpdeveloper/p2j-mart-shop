<div> {{-- Single root wrapper for entire component --}}
    <div class="main-content">
        @if($product->units->isNotEmpty() || $currentUnit)
            @php 
                $unit = $currentUnit ?? $product->units->first(); 
            @endphp

            {{-- NEW: Dynamic feedback message for auto-match (hidden by default) --}}
            <div id="variant-feedback" class="alert alert-info alert-dismissible fade show" role="alert" style="display: none;">
                <i class="fas fa-info-circle"></i> <span id="feedback-message"></span>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>

            <div class="section pt-5">
                <div class="custom-container1">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 mb-4 mb-md-0">
                            <div class="product-image">
                                <!-- Left Side: Thumbnail Gallery -->
                                <div id="pr_item_gallery">
                                    @if($currentImages->isNotEmpty())
                                        @foreach($currentImages as $image)
                                            @php
                                                $thumbnails = [];
                                                foreach (['web_image_1', 'web_image_2', 'web_image_3', 'web_image_4', 'web_image_5'] as $imgField) {
                                                    if (!empty($image->$imgField)) {
                                                        $thumbnails[] = $image->$imgField;
                                                    }
                                                }
                                            @endphp
                                            @foreach($thumbnails as $index => $thumb)
                                                @if($thumb)
                                                    <div class="item mb-2">
                                                        <div class="product_gallery_item"
                                                            data-image="{{ asset('uploads/products/' . $thumb) }}" style="cursor: pointer;"
                                                            wire:click="$set('mainImage', '{{ asset('uploads/products/' . $thumb) }}')">
                                                            <img src="{{ asset('uploads/products/' . $thumb) }}"
                                                                alt="product_thumb_{{ $index + 1 }}" class="img-fluid">
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                            
                                        @endforeach
                                    @else
                                        <div class="text-muted text-center">No Images Available</div>
                                    @endif
                                </div>

                                <!-- Main Product Image -->
                                <div class="product_img_box flex-grow-1">
                                    @if($currentImages->isNotEmpty() && $mainImage)
                                        <div class="zoom-container" style="position: relative; overflow: hidden;">
                                            <img id="mainProductImage"
                                                 src="{{ $mainImage }}" 
                                                 alt="product_main_img"
                                                 class="img-fluid zoom-image"
                                                 style="width: 100%; height: auto; cursor: zoom-in;"
                                                 data-zoom-image="{{ $mainImage }}">  
                                            <a href="#" class="product_img_zoom" title="Zoom" wire:click.prevent="zoomImage">
                                                <i class="fas fa-search-plus"></i>
                                            </a>
                                        </div>
                                    @else
                                        <div class="text-muted text-center">No Main Image</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Right Side: Product Info -->
                        <div class="col-lg-6 col-md-6">
                            <div class="pr_detail">
                                <div class="product_description">
                                    <h4 class="product_title"><a href="#">{{ $product->product_name }}</a></h4>

                                    <div class="product_price">
                                        @if($unit)
                                            <span class="price">₹{{ $unit->unit_price }}</span>
                                            <del>₹{{ $unit->mrp_price }}</del>
                                            <div class="on_sale">
                                                <span>
                                                    @php
                                                        $discount = round((($unit->mrp_price - $unit->unit_price) / $unit->mrp_price) * 100);
                                                    @endphp
                                                    {{ $discount }}% Off
                                                </span>
                                            </div>
                                        @else
                                            <span class="price">₹{{ $product->discount_price ?? $product->base_price }}</span>
                                        @endif

                                        <div class="rating_wrap">
                                            <div class="rating" wire:click="openPopup">
                                                <div class="product_rate" style="width:80%"></div>
                                            </div>
                                            <span class="rating_num">(21)</span>
                                        </div>
                                    </div>

                                    <div class="product_sort_info">
                                        <ul>
                                            @if($product->warranty)
                                                <li><i class="fas fa-shield-alt"></i> {{ $product->warranty }}</li>
                                            @endif

                                            @if($product->return_policy)
                                                <li><i class="fas fa-sync-alt"></i> {{ $product->return_policy }}</li>
                                            @endif

                                            @if($product->delivery_mode)
                                                <li><i class="fas fa-hand-holding-usd"></i> {{ $product->delivery_mode }}</li>
                                            @endif
                                        </ul>
                                    </div>

                                    <!-- Dynamic Attribute Selectors (replaces hard-coded color/size) -->
                                    @foreach($attributeOptions as $slug => $options)
                                        @if(!empty($options))
                                            <div class="pr_switch_wrap">
                                                <span class="switch_lable">{{ ucfirst($slug) }}</span>
                                                <div class="product_{{ $slug }}_switch">
                                                    @foreach($options as $option)
                                                        @php
                                                            $isSelected = ($selectedAttributes[$slug] ?? '') == $option->id;
                                                            $availableIds = $availableOptionIds[$slug] ?? [];
                                                            $isAvailable = in_array($option->id, $availableIds);
                                                            $opacity = $isAvailable ? 1 : 0.5;
                                                        @endphp
                                                        <span class="{{ $isSelected ? 'active' : '' }} {{ !$isAvailable ? 'unavailable' : '' }}"
                                                              wire:click="updateAttribute('{{ $slug }}', {{ $option->id }})"
                                                              style="
                                                                opacity: {{ $opacity }};
                                                                cursor: pointer;
                                                                margin-right: 5px; 
                                                                padding: 5px; 
                                                                border: 1px solid #ddd; 
                                                                border-radius: 3px;
                                                                @if($slug == 'color')
                                                                    background-color: {{ $option->color_code ?? '#ccc' }};
                                                                    min-width: 20px;
                                                                    min-height: 20px;
                                                                    display: inline-block;
                                                                    border: none;
                                                                @else
                                                                    background-color: transparent;  
                                                                    text-transform: uppercase; 
                                                                    display: inline-block;
                                                                    text-align: center;
                                                                    color: #687188 !important;
                                                                    padding: 4px;
                                                                    font-size: 14px;
                                                                    margin-bottom: 3px;
                                                                    border-width: 2px;
                                                                    border-style: solid;
                                                                    border-color: {{ $isSelected ? '#000' : 'rgb(221, 221, 221)' }};
                                                                    border-image: initial;
                                                                @endif
                                                              "
                                                              @if(!$isAvailable)title="Select to switch to a compatible variant"@endif>
                                                            @if($slug !== 'color')
                                                                {{ $option->name }}
                                                            @endif
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <hr>
                                <div class="cart_extra">
                                    <div class="cart-product-quantity">
                                        <div class="quantity">
                                            <input type="button" value="-" class="minus" wire:click="decrementQuantity">
                                            <input type="text" wire:model="quantity" name="quantity" value="{{ $quantity }}"
                                                title="Qty" class="qty" size="4">
                                            <input type="button" value="+" class="plus" wire:click="incrementQuantity">
                                        </div>
                                    </div>
                                    <div class="cart_btn d-flex flex-wrap align-items-center gap-2">

                                        <button class="btn btn-primary btn-shadow btn-lg d-flex align-items-center gap-2"
                                            type="button" wire:click="addToCart"
                                            data-product-id="{{ $product->product_id }}"
                                            data-product-unit-id="{{ $unit->product_unit_id }}"
                                            data-product-name="{{ $product->product_name }}"
                                            data-price="{{ $unit?->unit_price ?? 0 }}" data-quantity="{{ $quantity }}"
                                            style="min-width: 170px;">
                                            <i class="fa-solid fa-cart-shopping"></i>
                                            <span>Add to Cart</span>
                                        </button>
                                        
                                        <form class="d-inline-block" wire:submit.prevent="buyNow" style="margin-bottom: 0;">
                                            <input type="hidden" name="product_name" value="{{ $product->product_name }}">
                                            <input type="hidden" name="quantity" value="{{ $quantity }}">
                                            <input type="hidden" name="custom_text" value="{{ $customText }}">
                                            <input type="file" wire:model="customImage" name="custom_image"
                                                style="display: none;">
                                            <button type="submit"
                                                class="btn btn-outline-success btn-lg btn-shadow d-flex align-items-center gap-2"
                                                style="min-width: 140px;">
                                                <i class="fa fa-bolt"></i>
                                                <span>Buy Now</span>
                                            </button>
                                        </form>

                                        <a class="btn btn-light btn-circle btn-compare d-flex align-items-center justify-content-center"
                                           title="Compare" href="#" style="width: 45px; height: 45px; border-radius:50%;">
                                            <i class="icon-shuffle fs-5"></i>
                                        </a>
                                        <a class="btn btn-light btn-circle btn-wishlist d-flex align-items-center justify-content-center"
                                           title="Add to Wishlist" href="javascript:void(0);" wire:click="toggleWishlist"
                                           style="width: 45px; height: 45px; border-radius:50%;">
                                            <i class="fa-regular fa-heart fs-4 text-danger"></i>
                                        </a>
                                    </div>
                                </div>
                                <hr>

                                <div class="d-flex flex-column flex-sm-row justify-content-between">
                                  

                                    <div class="product_share">
                                        <span>Share:</span>
                                        <ul class="social_icons">
                                            <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                                            <li><a href="#"><i class="fa-brands fa-twitter"></i></a></li>
                                            <li><a href="#"><i class="fa-brands fa-google"></i></a></li>
                                            <li><a href="#"><i class="fa-brands fa-youtube"></i></a></li>
                                            <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            @if($product->customize == 1)
                                <!-- Customization Section -->
                                <div class="customization_section mt-4">
                                    <h5>Customize This Product</h5>

                                    @if($product->custom_type == 'text' || $product->custom_type == 'both')
                                        <div class="mb-3" id="text_customization">
                                            <label for="custom_text" class="form-label">Custom Text</label>
                                            <textarea class="form-control" wire:model="customText" id="custom_text"
                                                name="custom_text" rows="3"
                                                placeholder="Enter your custom text here">{{ $product->cust_text ?? '' }}</textarea>
                                        </div>
                                    @endif

                                    @if($product->custom_type == 'image' || $product->custom_type == 'both')
                                        <div class="mb-3" id="image_customization">
                                            <label for="custom_image" class="form-label">Upload Custom Image</label>
                                            <input type="file" class="form-control" wire:model="customImage" id="custom_image"
                                                name="custom_image">
                                            <small class="text-muted">Max file size: 5MB (JPG, PNG, GIF)</small>
                                        </div>
                                    @endif

                                    <div class="mb-3">
                                        <button class="btn btn-primary" wire:click="previewCustomization">Preview
                                            Customization</button>
                                    </div>

                                    <!-- Preview area -->
                                    @if($showPreview)
                                        <div id="customization_preview">
                                            <h6>Your Customization Preview</h6>
                                            <div class="border p-3 mb-3">
                                                @if($product->custom_type == 'text' || $product->custom_type == 'both')
                                                    <p wire:model="customText" id="preview_text">{{ $customText }}</p>
                                                @endif

                                                @if($product->custom_type == 'image' || $product->custom_type == 'both')
                                                    @if($customImage)
                                                        <img wire:model="customImage" id="preview_image"
                                                            src="{{ $customImage->temporaryUrl() }}" alt="Custom image preview"
                                                            style="max-width: 100%;">
                                                    @endif
                                                @endif
                                            </div>
                                            <button class="btn btn-success" wire:click="confirmCustomization">Confirm
                                                Customization</button>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Additional Info Section (wrapped inside root) -->
    <div class="custom-container1">
        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <div class="tab-style3">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="Additional-info-tab" data-bs-toggle="tab"
                                href="#Additional-info" role="tab" aria-controls="Additional-info"
                                aria-selected="true">Additional Info</a>
                        </li>
                    </ul>
                    <div class="tab-content shop_info_tab">
                        <div class="tab-pane fade show active" id="Additional-info" role="tabpanel"
                            aria-labelledby="Additional-info-tab">
                            <table class="table table-bordered">
                                <tr>
                                    <td>Description</td>
                                    <td>{{ $product->description ?? 'N/A' }}</td>
                                </tr>
                                @if($unit)
                                    {{-- Dynamic attributes display for additional info --}}
                                    @foreach($selectedAttributes as $slug => $selectedId)
                                        @php
                                            $selectedOption = collect($attributeOptions[$slug] ?? [])->firstWhere('id', $selectedId);
                                            $attrValue = $selectedOption?->name ?? 'N/A';
                                        @endphp
                                        <tr>
                                            <td>{{ ucfirst($slug) }}</td>
                                            <td>{{ $attrValue }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Optional: Add a second column here if needed for balance --}}
        </div>
    </div>
{{-- End of root wrapper --}}
</div>

@push('scripts')
    <script>
        // Listen for dispatched events
        window.addEventListener('wishlist-toggled', event => {
            // Handle wishlist toggle
            console.log('Wishlist toggled for product:', event.detail.productId);
        });

        window.addEventListener('add-to-cart', event => {
            // Handle add to cart
            console.log('Added to cart:', event.detail);
        });

        window.addEventListener('buy-now', event => {
            console.log('ffsdf');
            // Handle buy now event from Livewire (redirect to server checkout)
            const detail = event.detail;

            // Make a POST request to create/initiate checkout session
            fetch('/products/checkout/initiate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify(detail)
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(data => {
                if (data.success && data.session_id) {
                    window.location.href = `/products/checkout/${encodeURIComponent(data.session_id)}`;
                } else {
                    alert(data.message || "An error occurred. Could not initiate checkout.");
                }
            })
            .catch(error => {
                console.error("Buy Now Error:", error);
                alert(error.message || "Failed to initiate checkout.");
            });
        });

        window.addEventListener('open-rating-popup', event => {
            // Open rating modal
            console.log('Open rating popup');
        });

        // Handle auto-match event for frontend feedback
        window.addEventListener('attributes-auto-matched', event => {
            const feedbackEl = document.getElementById('variant-feedback');
            const messageEl = document.getElementById('feedback-message');
            const unitId = event.detail.unitId;
            const changedAttr = event.detail.changedAttr || null;

            let message = 'No exact match found. ';
            if (changedAttr) {
                message += `Switched to compatible variant including your selected ${changedAttr}.`;
            } else {
                message += `Showing closest variant (Unit ID: ${unitId}).`;
            }

            messageEl.textContent = message;

            // Show toast (Bootstrap alert)
            feedbackEl.style.display = 'block';
            const alert = new bootstrap.Alert(feedbackEl);
            setTimeout(() => {
                alert.close();
                feedbackEl.style.display = 'none';
            }, 5000); // Auto-hide after 5s
        });

        // Optional: Enhance quantity buttons with JS for smoother UX (if not using full JS lib)
        document.addEventListener('DOMContentLoaded', function() {
            const minusBtns = document.querySelectorAll('.minus');
            const plusBtns = document.querySelectorAll('.plus');
            const qtyInputs = document.querySelectorAll('.qty');

            minusBtns.forEach((btn, index) => {
                btn.addEventListener('click', () => {
                    if (parseInt(qtyInputs[index].value) > 1) {
                        qtyInputs[index].value = parseInt(qtyInputs[index].value) - 1;
                        // Trigger Livewire update if needed (but wire:click already handles)
                    }
                });
            });

            plusBtns.forEach((btn, index) => {
                btn.addEventListener('click', () => {
                    qtyInputs[index].value = parseInt(qtyInputs[index].value) + 1;
                });
            });
        });
    </script>
@endpush