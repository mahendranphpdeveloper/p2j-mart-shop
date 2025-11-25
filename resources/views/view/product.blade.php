@extends('layouts.home')
@section('content')

<!-- START SECTION BREADCRUMB -->
<div class=" bg-white page-title-mini py-3">
    <div class="container"><!-- STRART CONTAINER -->
        <div class="row align-items-center">
            <div class="col-12">
                <ol class="breadcrumb justify-content-md-end">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Pages</a></li>
                    <li class="breadcrumb-item active">Product Detail</li>
                </ol>
            </div>
        </div>
    </div><!-- END CONTAINER-->
</div>
<!-- END SECTION BREADCRUMB -->


<!-- START MAIN CONTENT -->
<div class="main_content">

    <!-- START SECTION SHOP -->
    <div class="section pt-5">
        <div class="custom-container1">
            <div class="row">
                <div class="col-lg-6 col-md-6 mb-4 mb-md-0">
                    <div class="product-image">
                        <!-- Left Side: Thumbnail Gallery -->
                        <div id="pr_item_gallery">
                            <div class="item">
                                <a href="#" class="product_gallery_item active" data-image="assets/images/product_img1.jpg" data-zoom-image="assets/images/product_img1.jpg">
                                    <img src="assets/images/product_small_img1.jpg" alt="product_small_img1">
                                </a>
                            </div>
                            <div class="item">
                                <a href="#" class="product_gallery_item" data-image="assets/images/product_img1-2.jpg" data-zoom-image="assets/images/product_img1-2.jpg">
                                    <img src="assets/images/product_small_img2.jpg" alt="product_small_img2">
                                </a>
                            </div>
                            <div class="item">
                                <a href="#" class="product_gallery_item" data-image="assets/images/product_img1-4.jpg" data-zoom-image="assets/images/product_img1-4.jpg">
                                    <img src="assets/images/product_small_img4.jpg" alt="product_small_img4">
                                </a>
                            </div>
                            <div class="item">
                                <a href="#" class="product_gallery_item " data-image="assets/images/product_img1-2.jpg" data-zoom-image="assets/images//product_img1-2.jpg">
                                    <img src="assets/images/product_small_img2.jpg" alt="product_small_img1">
                                </a>
                            </div>
                            <div class="item">
                                <a href="#" class="product_gallery_item " data-image="assets/images/product_img1-4.jpg" data-zoom-image="assets/images/product_img1-4.jpg">
                                    <img src="assets/images/product_small_img4.jpg" alt="product_small_img1">
                                </a>
                            </div>
                            <div class="item">
                                <a href="#" class="product_gallery_item " data-image="assets/images/product_img1-2.jpg" data-zoom-image="assets/images//product_img1-2.jpg">
                                    <img src="assets/images/product_small_img2.jpg" alt="product_small_img1">
                                </a>
                            </div>
                        </div>

                        <!-- Main Product Image (Right Side) -->
                        <div class="product_img_box">
                            <img id="product_img" src="assets/images/product_img1.jpg" data-zoom-image="assets/images/product_img1.jpg" alt="product_img1">
                            <a href="#" class="product_img_zoom" title="Zoom">
                                <i class="fas fa-search-plus"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6">
                    <div class="pr_detail">
                        <div class="product_description">
                            <h4 class="product_title"><a href="#">Blue Dress For Woman</a></h4>
                            <div class="product_price">
                                <span class="price">₹450.00</span>
                                <del>₹750.25</del>
                                <div class="on_sale">
                                    <span>35% Off</span>
                                </div>
                                <div class="rating_wrap">
                                    <div class="rating" onclick="openPopup()">
                                        <div class="product_rate" style="width:80%"></div>
                                    </div>
                                    <span class="rating_num">(21)</span>
                                </div>
                            </div>

                            <!-- <div class="pr_desc">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                            </div> -->
                            <div class="product_sort_info">
                                <ul>
                                    <li><i class="fas fa-shield-alt"></i> 1 Year AL Jazeera Brand Warranty</li>
                                    <li><i class="fas fa-sync-alt"></i>30 Day Return Policy</span></li>
                                    <li><i class="fas fa-hand-holding-usd"></i>Cash on Delivery available</li>
                                </ul>

                            </div>
                            <div class="pr_switch_wrap">
                                <span class="switch_lable">Color</span>
                                <div class="product_color_switch">
                                    <span class="active" data-color="#87554B"></span>
                                    <span data-color="#333333"></span>
                                    <span data-color="#DA323F"></span>
                                </div>
                            </div>
                            <div class="pr_switch_wrap">
                                <span class="switch_lable">Size</span>
                                <div class="product_size_switch">
                                    <span>xs</span>
                                    <span>s</span>
                                    <span>m</span>
                                    <span>l</span>
                                    <span>xl</span>
                                </div>
                            </div>
                        </div>
                        <hr />
                        <div class="cart_extra">
                            <div class="cart-product-quantity">
                                <div class="quantity">
                                    <input type="button" value="-" class="minus">
                                    <input type="text" name="quantity" value="1" title="Qty" class="qty" size="4">
                                    <input type="button" value="+" class="plus">
                                </div>
                            </div>
                            <div class="cart_btn">
                                <button class="btn btn-fill-out btn-addtocart" type="button"><i class="fa-solid fa-cart-shopping"></i> Add to cart</button>
                                <a class="add_compare" href="#"><i class="icon-shuffle"></i></a>
                                <a class="add_wishlist" href="javascriptvoid:(0)" onclick="toggleWishlist(this)">
                                    <i class="fa-regular fa-heart fs-4"></i>
                                </a>
                            </div>
                        </div>
                        <hr />
                        <!-- <ul class="product-meta">
                            <li>SKU: <a href="#">BE45VGRT</a></li>
                            <li>Category: <a href="#">Clothing</a></li>
                            <li>Tags: <a href="#" rel="tag">Cloth</a>, <a href="#" rel="tag">printed</a> </li>
                        </ul> -->
                        <div class="d-flex flex-column flex-sm-row justify-content-between">
                            <div class="buy-btn ">
                                <button class="btn btn-fill-line view-cart" type="button">Buy Now</button>
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
                </div>
            </div>

        </div>

        <div class="custom-container1">
            <div class="row">
                <div class="col-12">
                    <div class="large_divider clearfix"></div>
                </div>
            </div>
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
                                        <td>Capacity</td>
                                        <td>5 Kg</td>
                                    </tr>
                                    <tr>
                                        <td>Color</td>
                                        <td>Black, Brown, Red</td>
                                    </tr>
                                    <tr>
                                        <td>Water Resistant</td>
                                        <td>Yes</td>
                                    </tr>
                                    <tr>
                                        <td>Material</td>
                                        <td>Artificial Leather</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="small_divider"></div>
                    <div class="divider"></div>
                    <div class="medium_divider"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="heading_s1">
                        <h3>Releted Products</h3>
                    </div>
                    <div
                        class="product_slider carousel_slider owl-carousel owl-theme dot_style1"
                        data-loop="true"
                        data-margin="20"
                        data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "991":{"items": "4"}}'>
                        <div class="item">
                            <div class="product_wrap">
                                <div class="product_img">
                                    <a href="#">
                                        <img src="assets/images/gift-1.jpg" alt="el_img2" />
                                        <img class="product_hover_img" src="assets/images/gift-1.jpg" alt="el_hover_img2" />
                                    </a>
                                    <!-- Wishlist Button (Top Right Corner) -->
                                    <div class="wishlist_btn add_wishlist">
                                        <a href="javascriptvoid:(0)" onclick="toggleWishlist(this)"><i class="fa-regular fa-heart"></i></a>
                                    </div>
                                </div>
                                <div class="product_info">
                                    <h6 class="product_title">
                                        <a href="#">Maxi</a>
                                    </h6>
                                    <div class="product_price">
                                        <span class="price">₹1500.00</span>
                                        <del>₹2500.00</del>
                                        <div class="on_sale">
                                            <span>25% Off</span>
                                            <!-- Cart Icon - Aligned with "25% Off" -->
                                            <div class="wishlist_btn add_wishlist">
                                                <a href="javascriptvoid:(0)" onclick="toggleWishlist(this)"><i class="fa-regular fa-heart"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="rating_wrap">
                                        <div class="rating">
                                            <div class="product_rate" style="width: 68%"></div>
                                        </div>
                                        <span class="rating_num">(15)</span>
                                    </div>
                                    <div class="pr_desc">
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="product_wrap">
                                <div class="product_img">
                                    <a href="#">
                                        <img src="assets/images/gift-2.jpg" alt="el_img2" />
                                        <img class="product_hover_img" src="assets/images/gift-2.jpg" alt="el_hover_img2" />
                                    </a>

                                    <!-- Wishlist Button (Top Right Corner) -->
                                    <div class="wishlist_btn add_wishlist">
                                        <a href="javascriptvoid:(0)" onclick="toggleWishlist(this)"><i class="fa-regular fa-heart"></i></a>
                                    </div>
                                </div>
                                <div class="product_info">
                                    <h6 class="product_title">
                                        <a href="#">Maxi</a>
                                    </h6>
                                    <div class="product_price">
                                        <span class="price">₹1500.00</span>
                                        <del>₹2500.00</del>
                                        <div class="on_sale">
                                            <span>25% Off</span>
                                            <!-- Cart Icon - Aligned with "25% Off" -->
                                            <div class="add_to_cart">
                                                <a href="#"><i class="fa-solid fa-cart-shopping"></i>Add to Cart</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="rating_wrap">
                                        <div class="rating">
                                            <div class="product_rate" style="width: 68%"></div>
                                        </div>
                                        <span class="rating_num">(15)</span>
                                    </div>
                                    <div class="pr_desc">
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="product_wrap">
                                <div class="product_img">
                                    <a href="#">
                                        <img src="assets/images/gift-3.jpg" alt="el_img2" />
                                        <img class="product_hover_img" src="assets/images/gift-3.jpg" alt="el_hover_img2" />
                                    </a>
                                    <!-- Wishlist Button (Top Right Corner) -->
                                    <div class="wishlist_btn add_wishlist">
                                        <a href="javascriptvoid:(0)" onclick="toggleWishlist(this)"><i class="fa-regular fa-heart"></i></a>
                                    </div>
                                </div>
                                <div class="product_info">
                                    <h6 class="product_title">
                                        <a href="#">Maxi</a>
                                    </h6>
                                    <div class="product_price">
                                        <span class="price">₹1500.00</span>
                                        <del>₹2500.00</del>
                                        <div class="on_sale">
                                            <span>25% Off</span>
                                            <!-- Cart Icon - Aligned with "25% Off" -->
                                            <div class="add_to_cart">
                                                <a href="#"><i class="fa-solid fa-cart-shopping"></i>Add to Cart</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="rating_wrap">
                                        <div class="rating">
                                            <div class="product_rate" style="width: 68%"></div>
                                        </div>
                                        <span class="rating_num">(15)</span>
                                    </div>
                                    <div class="pr_desc">
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="product_wrap">
                                <div class="product_img">
                                    <a href="#">
                                        <img src="assets/images/gift-4.jpg" alt="el_img2" />
                                        <img class="product_hover_img" src="assets/images/gift-4.jpg" alt="el_hover_img2" />
                                    </a>

                                    <!-- Wishlist Button (Top Right Corner) -->
                                    <div class="wishlist_btn add_wishlist">
                                        <a href="javascriptvoid:(0)" onclick="toggleWishlist(this)"><i class="fa-regular fa-heart"></i></a>
                                    </div>
                                </div>
                                <div class="product_info">
                                    <h6 class="product_title">
                                        <a href="#">Maxi</a>
                                    </h6>
                                    <div class="product_price">
                                        <span class="price">₹1500.00</span>
                                        <del>₹2500.00</del>
                                        <div class="on_sale">
                                            <span>25% Off</span>

                                            <!-- Cart Icon - Aligned with "25% Off" -->
                                            <div class="add_to_cart">
                                                <a href="#"><i class="fa-solid fa-cart-shopping"></i>Add to Cart</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="rating_wrap">
                                        <div class="rating">
                                            <div class="product_rate" style="width: 68%"></div>
                                        </div>
                                        <span class="rating_num">(15)</span>
                                    </div>
                                    <div class="pr_desc">
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="product_wrap">
                                <div class="product_img">
                                    <a href="#">
                                        <img src="assets/images/gift-5.jpg" alt="el_img2" />
                                        <img class="product_hover_img" src="assets/images/gift-5.jpg" alt="el_hover_img2" />
                                    </a>

                                    <!-- Wishlist Button (Top Right Corner) -->
                                    <div class="wishlist_btn add_wishlist">
                                        <a href="javascriptvoid:(0)" onclick="toggleWishlist(this)"><i class="fa-regular fa-heart"></i></a>
                                    </div>
                                </div>
                                <div class="product_info">
                                    <h6 class="product_title">
                                        <a href="#">Maxi</a>
                                    </h6>
                                    <div class="product_price">
                                        <span class="price">₹1500.00</span>
                                        <del>₹2500.00</del>
                                        <div class="on_sale">
                                            <span>25% Off</span>
                                            <!-- Cart Icon - Aligned with "25% Off" -->
                                            <div class="add_to_cart">
                                                <a href="#"><i class="fa-solid fa-cart-shopping"></i>Add to Cart</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="rating_wrap">
                                        <div class="rating">
                                            <div class="product_rate" style="width: 68%"></div>
                                        </div>
                                        <span class="rating_num">(15)</span>
                                    </div>
                                    <div class="pr_desc">
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="product_wrap">
                                <div class="product_img">
                                    <a href="#">
                                        <img src="assets/images/gift-6.jpg" alt="el_img2" />
                                        <img class="product_hover_img" src="assets/images/gift-6.jpg" alt="el_hover_img2" />
                                    </a>
                                    <!-- Wishlist Button (Top Right Corner) -->
                                    <div class="wishlist_btn add_wishlist">
                                        <a href="javascriptvoid:(0)" onclick="toggleWishlist(this)"><i class="fa-regular fa-heart"></i></a>
                                    </div>
                                </div>
                                <div class="product_info">
                                    <h6 class="product_title">
                                        <a href="#">Maxi</a>
                                    </h6>
                                    <div class="product_price">
                                        <span class="price">₹1500.00</span>
                                        <del>₹2500.00</del>
                                        <div class="on_sale">
                                            <span>25% Off</span>

                                            <!-- Cart Icon - Aligned with "25% Off" -->
                                            <div class="add_to_cart">
                                                <a href="#"><i class="fa-solid fa-cart-shopping"></i>Add to Cart</a>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="rating_wrap">
                                        <div class="rating">
                                            <div class="product_rate" style="width: 68%"></div>
                                        </div>
                                        <span class="rating_num">(15)</span>
                                    </div>
                                    <div class="pr_desc">
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END SECTION SHOP -->

    <!-- popup section -->

    <div class="product-review" id="popup">
        <div class="review-content">
            <span class="close-btn" onclick="closePopup()">&times;</span>
            <h2>Product Reviews</h2>
            <div id="reviews">
                <div class="review-item">
                    <div class="review-icon">J</div>
                    <div class="review-text">
                        <div class="review-author">John Doe</div>
                        <span class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </span>
                        - Great product! Highly recommend.
                    </div>
                </div>
            </div>
            <div class="button-container">
                <button onclick="toggleReviewForm()" class="btn btn-fill-out">Add Review</button>
                <button onclick="closePopup()" class="btn btn-fill-line1">Close</button>
            </div>
            <div class="review-form" id="reviewForm">
                <div class="star-rating" id="starRating">
                    <i class="far fa-star" onclick="rate(1)"></i>
                    <i class="far fa-star" onclick="rate(2)"></i>
                    <i class="far fa-star" onclick="rate(3)"></i>
                    <i class="far fa-star" onclick="rate(4)"></i>
                    <i class="far fa-star" onclick="rate(5)"></i>
                </div>
                <textarea id="newReview" class="form-control" placeholder="Write your review here..."></textarea><br>
                <button onclick="addReview()" class="btn btn-fill-out">Submit</button>
            </div>
        </div>
    </div>

</div>
<!-- END MAIN CONTENT -->

<?php include "connect/footer.php" ?>