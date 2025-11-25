


<div class="main-content">
    @if($product->units->isNotEmpty())
    @php $unit = $product->units->first(); @endphp

    <div class="section pt-5">
        <div class="custom-container1">
            <div class="row">
                <div class="col-lg-6 col-md-6 mb-4 mb-md-0">
                    <div class="product-image">
                        <!-- Left Side: Thumbnail Gallery -->
                        <div id="pr_item_gallery">
                            @foreach($product->images as $img)
                                @foreach([$img->web_image_1,$img->web_image_2, $img->web_image_3, $img->web_image_4, $img->web_image_5] as $index => $thumb)
                                    <div class="item mb-2">
                                        @if($thumb)
                                            <div class="product_gallery_item"
                                                 data-image="{{ asset('uploads/products/' . $thumb) }}"
                                                 style="cursor: pointer;">
                                                <img src="{{ asset('uploads/products/' . $thumb) }}" alt="product_thumb_{{ $index + 2 }}" class="img-fluid">
                                            </div>
                                        @else
                                            <div class="product_gallery_item text-muted">
                                                
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            @endforeach
                        </div>

                        <!-- Main Product Image -->
                   <div class="product_img_box flex-grow-1">
                        @if($product->images->first() && $product->images->first()->web_image_1)
                            <div class="zoom-container" style="position: relative; overflow: hidden;">
                                <img id="mainProductImage"
                                     src="{{ asset('uploads/products/' . $product->images->first()->web_image_1) }}"
                                     alt="product_img1"
                                     class="img-fluid zoom-image"
                                     style="width: 100%; height: auto; cursor: zoom-in;"
                                     data-zoom-image="{{ asset('uploads/products/' . $product->images->first()->web_image_1) }}">
                                     
                                     <a href="#" class="product_img_zoom" title="Zoom">
                                        <i class="fas fa-search-plus"></i>
                                    </a>
                            </div>
                        @else
                            <div class="text-muted text-center">
                                No Main Image
                            </div>
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
                            @if($product->units->isNotEmpty())
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
                                            <div class="rating" onclick="openPopup()">
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


            <div class="pr_switch_wrap">
                <span class="switch_lable">Color</span>
                <div class="product_color_switch">
                    <span class="active" style="background-color: {{ $unit->color->colorzz ?? '#ccc' }}"></span>
                </div>
            </div>

            <div class="pr_switch_wrap">
                <span class="switch_lable">Size</span>
                <div class="product_size_switch">
                    <span>{{ $unit->size->size_name ?? 'N/A' }}</span>
                </div>
            </div>
        </div>
        <hr>
        <div class="cart_extra">
            <div class="cart-product-quantity">
                <div class="quantity">
                    <input type="button" value="-" class="minus">
                    <input type="text" name="quantity" value="1" title="Qty" class="qty" size="4">
                    <input type="button" value="+" class="plus">
                </div>
            </div>
            <div class="cart_btn">
             <button class="btn btn-fill-out btn-addtocart"
    type="button"
    data-product-id="{{ $product->product_id }}"
    data-product-name="{{ $product->product_name }}"
    data-price="{{ $unit->unit_price ?? 0 }}"
    data-quantity="1">
    <i class="fa-solid fa-cart-shopping"></i> Add to cart
</button>

                <a class="add_compare" href="#"><i class="icon-shuffle"></i></a>
                <a class="add_wishlist" href="javascript:void(0);" onclick="toggleWishlist(this)">
                    <i class="fa-regular fa-heart fs-4"></i>
                </a>
            </div>
        </div>
        <hr>

        <div class="d-flex flex-column flex-sm-row justify-content-between">
    <div class="buy-btn">
    <form id="buyNowForm" action="{{ route('products.checkout.initiate') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="product_name" value="{{ $product->product_name }}">
        <input type="hidden" name="quantity" value="1">
        <input type="hidden" name="custom_text" id="form_custom_text" value="">
        
        <!-- This will be the actual file input that gets submitted -->
        <input type="file" name="custom_image" id="form_custom_image" style="display: none;">
        
        <button type="submit" class="btn btn-fill-line">
            Buy Now
        </button>
    </form>
</div>

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
            <textarea class="form-control" id="custom_text" name="custom_text" 
                      rows="3" placeholder="Enter your custom text here">{{ $product->cust_text ?? '' }}</textarea>
        </div>
        @endif
        
        @if($product->custom_type == 'image' || $product->custom_type == 'both')
        <div class="mb-3" id="image_customization">
            <label for="custom_image" class="form-label">Upload Custom Image</label>
            <input type="file" class="form-control" id="custom_image" name="custom_image">
            <small class="text-muted">Max file size: 5MB (JPG, PNG, GIF)</small>
        </div>
        @endif
        
        <div class="mb-3">
            <button class="btn btn-primary" id="preview_customization">Preview Customization</button>
        </div>
        
        <!-- Preview area (hidden by default) -->
        <div id="customization_preview" style="display: none;">
            <h6>Your Customization Preview</h6>
            <div class="border p-3 mb-3">
                @if($product->custom_type == 'text' || $product->custom_type == 'both')
                <p id="preview_text"></p>
                @endif
                
                @if($product->custom_type == 'image' || $product->custom_type == 'both')
                <img id="preview_image" src="#" alt="Custom image preview" style="max-width: 100%; display: none;">
                @endif
            </div>
            <button class="btn btn-success" id="confirm_customization">Confirm Customization</button>
        </div>
    </div>
@endif
</div>

            </div>
        </div>
    </div>
    @endif
</div>
                            <!-- Additional Info  Section -->

     <div class="custom-container1">
         <div class="row">
         <div class="col-lg-6 col-sm-12">
            <div class="tab-style3">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="Additional-info-tab" data-bs-toggle="tab" href="#Additional-info" role="tab" aria-controls="Additional-info" aria-selected="true">Additional Info</a>
                    </li>
                </ul>
                <div class="tab-content shop_info_tab">
                    <div class="tab-pane fade show active" id="Additional-info" role="tabpanel" aria-labelledby="Additional-info-tab">
                    <table class="table table-bordered">
            <tr>
                <td>Description</td>
                <td>{{ $product->description ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Color</td>
                <td>{{ $unit->color->color_name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Size</td>
                <td>{{  $unit->size->size_name ?? 'N/A' }}</td>
            </tr>
            <!-- <tr>
                <td>Available Types</td>
                <td>{{ $unit->design->design_name ?? 'N/A' }}</td>
            </tr> -->
        </table>

            </div>
        </div>
    </div>
</div>
