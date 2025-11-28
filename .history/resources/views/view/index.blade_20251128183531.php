@extends('layouts.home')

@section('styles')
  <!-- Owl Carousel CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />
@endsection

@section('content')
  <main>

    <!-- START SECTION BANNER -->
    <div class="mt-4 staggered-animation-wrap">
      <div class="custom-container">
        <div class="row">
          <div class="col-lg-3 col-md-4 col-sm-6 col-3">
            <div class="categories_wrap d-block d-lg-block">
              <button type="button" data-bs-toggle="collapse" data-bs-target="#navCatContent" aria-expanded="false"
                class="categories_btn">
                <i class="fa-solid fa-bars"></i><span>All Categories </span>
              </button>
              <div id="navCatContent" class="nav_cat navbar nav collapse">
                <ul>
                  @foreach($categories as $index => $category)
                    @if($category->status === 'active')
                      @if($index < 7) {{-- First 7 categories with dropdown --}}
                        <li class="dropdown dropdown-mega-menu">
                          <a class="dropdown-item nav-link dropdown-toggler" href="#" data-bs-toggle="dropdown">
                            <img src="{{ asset($category->image) }}" alt="{{ $category->title }}" />
                            <span class="ps-3">{{ $category->title }}</span>
                          </a>

                          {{-- Dropdown with Subcategories --}}
                          @if($category->subcategories && $category->subcategories->count())
                            <div class="dropdown-menu p-2" style="min-width: 250px; max-width: 350px;">
                              <div class="d-flex w-100">
                                <!-- Subcategories List -->
                                <div class="flex-grow-1">
                                  <div class="pe-2"> <!-- Reduced right padding -->
                                    @foreach ($category->subcategories->sortByDesc('updated_at') as $sub)
                                      <a class="dropdown-item d-block py-2 px-2 text-truncate border-bottom"
                                        href="{{ route('subcategory.products', $sub->id) }}">
                                        {{ $sub->title }}
                                      </a>
                                    @endforeach
                                  </div>
                                </div>

                                <!-- Promo Banner - Now with proper button alignment -->
                                <div class="border-start ps-2 d-flex flex-column" style="width: 120px;">
                                  <div class="flex-grow-1 mb-2"> <!-- Image container with bottom margin -->
                                    <img class="category-img" src="{{ asset($category->image) }}" alt="{{ $category->title }}" />
                                  </div>
                                  <div class="pb-1"> <!-- Button container -->
                                    <a href="{{ route('category.products', $category->id) }}"
                                      class="btn btn-sm btn-outline-primary w-100">
                                      View All
                                    </a>
                                  </div>
                                </div>
                              </div>
                            </div>
                          @endif
                        </li>
                      @endif
                    @endif
                  @endforeach

                  <!-- More Categories Section for categories beyond 7 -->
                  <li>
                    <ul class="more_slide_open">
                      @foreach($categories as $index => $category)
                        @if($category->status === 'active' && $index >= 7)
                          <li>
                            <a class="dropdown-item nav-link nav_item" href="{{ route('category.products', $category->id) }}">
                              <img src="{{ asset($category->image) }}" alt="{{ $category->title }}" />
                              <span class="ps-3">{{ $category->title }}</span>
                            </a>
                          </li>
                        @endif
                      @endforeach
                    </ul>
                  </li>
                </ul>
                @if($categories->count() > 7)
                  <div class="more_categories">More Categories</div>
                @endif
              </div>
            </div>
          </div>
          <div class="col-lg-7">
            <div class="banner_section shop_el_slider">
              <div id="carouselExampleControls" class="carousel slide carousel-fade light_arrow" data-bs-ride="carousel">

                <div class="carousel-inner">
                  @foreach($sliders as $index => $slider)
                    <div class="carousel-item background_bg {{ $index == 0 ? 'active' : '' }}"
                      style="background-image: url('{{ asset('uploads/sliders/' . $slider->image) }}'); background-size: cover; background-position: center;">

                      <div class="banner_slide_content banner_content_inner">
                        <div class="col-lg-8 col-10">
                          <div class="banner_content3 overflow-hidden">
                            <h5 class="mb-3 staggered-animation font-weight-light" data-animation="slideInLeft"
                              data-animation-delay="0.5s">
                              {{ $slider->title }}
                            </h5>
                            <h2 class="staggered-animation" data-animation="slideInLeft" data-animation-delay="1s">
                              {{ $slider->content }}
                            </h2>
                            <h4 class="staggered-animation mb-4 product-price" data-animation="slideInLeft"
                              data-animation-delay="1.2s">
                              {{-- If you want to show price or discount info, add extra columns --}}
                            </h4>
                            <a class="btn btn-fill-line btn-radius staggered-animation text-uppercase" href="#"
                              data-animation="slideInLeft" data-animation-delay="1.5s">Shop Now</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  @endforeach
                </div>

                <ol class="carousel-indicators indicators_style3">
                  @foreach($sliders as $index => $slider)
                    <li data-bs-target="#carouselExampleControls" data-bs-slide-to="{{ $index }}"
                      class="{{ $index == 0 ? 'active' : '' }}"></li>
                  @endforeach
                </ol>
              </div>
            </div>

          </div>
          @if($banners->count())
            @php
              $banner = $banners->first();
            @endphp
            <div class="col-lg-2 d-none d-lg-block">
              {{-- First Banner --}}
              <div class="shop_banner2 el_banner1">
                <a href="#" class="hover_effect1">
                  <div class="el_title text_white">
                    <h6>{{ $banner->content }}</h6>
                    <span>25% off</span>
                  </div>
                  <div class="el_img">
                    <img src="{{ asset('uploads/banner/' . $banner->image) }}" alt="Banner 1" />
                  </div>
                </a>
              </div>

              {{-- Second Banner --}}
              <div class="shop_banner2 el_banner2">
                <a href="#" class="hover_effect1">
                  <div class="el_title text_white">
                    <h6>{{ $banner->content2 }}</h6>
                    <span><u>25% off</u></span>
                  </div>
                  <div class="el_img">
                    <img src="{{ asset('uploads/banner/' . $banner->image2) }}" alt="Banner 2" />
                  </div>
                </a>
              </div>
            </div>
          @endif


        </div>
      </div>
    </div>

    @if(isset($productsByCategory['first_three']))
      @foreach ($productsByCategory['first_three'] as $categoryTitle => $gifts)
        <div class="category-section mb-4">
          <div class="section small_pt small_pb">
            <div class="custom-container">
              <div class="row">
                <div class="col-xl-9">
                  <div class="row">
                    <div class="col-12">
                      <div class="heading_tab_header">
                        <div class="heading_s2">
                          <h4>{{ $categoryTitle }}</h4>
                        </div>
                        <div class="view_all">
                          <a href="#" class="text_default">
                            <i class="fa-solid fa-eye"></i>
                            <span>View All</span>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-12">
                      <div class="product_slider carousel_slider owl-carousel owl-theme dot_style1" data-margin="20"
                        data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "991":{"items": "4"}}'>

                        @foreach ($gifts as $gift)
                          @php
                            $productUnit = $gift->productUnit ?? null;
                            $productImage = $productUnit && $productUnit->productimage ? $productUnit->productimage : null;
                            $imagePath = $productImage && $productImage->web_image_1
                              ? url('uploads/products/' . $productImage->web_image_1)
                              : asset('assets/images/placeholder.jpg');
                            $productId = $gift->product_id ?? 0;
                            $productUnitId = $productUnit->product_unit_id ?? 0;
                            // Use slug, fallback to productId if no slug
                            $productSlug = $gift->slug ?? $productId;
                          @endphp
                          <div class="item">
                            <div class="product_wrap">
                              <div class="product_img">
                                <a href="{{ route('product.view', ['slug' => $productSlug, 'unit' => $productUnitId]) }}"
                                   data-product-id="{{ $productId }}"
                                   data-product-unit-id="{{ $productUnitId }}">
                                  <img src="{{ $imagePath }}" alt="{{ $gift->product_name }}">
                                  <img class="product_hover_img" src="{{ $imagePath }}" alt="Hover Image">
                                </a>
                                <div class="wishlist_btn">
                                  @php
                                     
                                    $wishlistItems = App\Helpers\ProductUnitItems::getWishlistProductUnitItems();
                                    $inWishlist = in_array($productUnitId, $wishlistItems);
                                  @endphp
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
                                <h6 class="product_title" title="{{ $gift->product_name }}">
                                  {{ \Illuminate\Support\Str::limit($gift->product_name, 32, '...') }}
                               
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
                                       data-product-name="{{ $gift->product_name }}"
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
                                    {{ $gift->description ?? 'Exclusive product from ' . ($categoryTitle ?? 'our store') }}
                                  </p>
                                </div>
                              </div>
                            </div>
                          </div>
                        @endforeach

                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-xl-3 d-none d-xl-block">
                  <div class="sale-banner">
                    <a class="hover_effect1" href="#">
                      <img src="{{ asset('assets/images/shop_banner_im.png') }}" alt="shop_banner_img">
                    </a>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      @endforeach
    @endif

    {{-- Cards --}}


    <div class="section pb_20 small_pt">
      <div class="custom-container">
        <div class="row">
          {{-- Card 1 --}}
          <div class="col-md-4">
            <div class="sale-banner mb-3 mb-md-4">
              <a class="hover_effect1" href="{{ $card->link_1 ?? '#' }}">
                <div class="position-relative d-inline-block w-100">
                  <img src="{{ asset('uploads/banners/' . $card->image_1) }}"
                    alt="{{ $card->card_1_title_1 ?? 'Card 1' }}" class="img-fluid w-100" />
                  <div class="position-absolute top-50 start-0 translate-middle-y p-3">
                    <h4 class="mb-1 text-white">{{ $card->card_1_title_1 }}</h4>
                    <p class="mb-0 text-white">{{ $card->card_1_title_2 }}</p>
                    <a href="{{ $card->link_1 ?? '#' }}" class="btn btn-outline-light btn-sm">View Collection</a>
                  </div>
                </div>
              </a>
            </div>
          </div>

          {{-- Card 2 --}}
          <div class="col-md-4">
            <div class="sale-banner mb-3 mb-md-4">
              <a class="hover_effect1" href="{{ $card->link_2 ?? '#' }}">
                <div class="position-relative d-inline-block w-100">
                  <img src="{{ asset('uploads/banners/' . $card->image_2) }}"
                    alt="{{ $card->card_2_title_1 ?? 'Card 2' }}" class="img-fluid w-100" />
                  <div class="position-absolute top-50 start-0 translate-middle-y p-3">
                    <h4 class="mb-1 text-white">{{ $card->card_2_title_1 }}</h4>
                    <p class="mb-0 text-white">{{ $card->card_2_title_2 }}</p>
                    <a href="{{ $card->link_2 ?? '#' }}" class="btn btn-outline-light btn-sm">View Collection</a>
                  </div>
                </div>
              </a>
            </div>
          </div>

          {{-- Card 3 --}}
          <div class="col-md-4">
            <div class="sale-banner mb-3 mb-md-4">
              <a class="hover_effect1" href="{{ $card->link_3 ?? '#' }}">
                <div class="position-relative d-inline-block w-100">
                  <img src="{{ asset('uploads/banners/' . $card->image_3) }}"
                    alt="{{ $card->card_3_title_1 ?? 'Card 3' }}" class="img-fluid w-100" />
                  <div class="position-absolute top-50 start-0 translate-middle-y p-3">
                    <h4 class="mb-1 text-white">{{ $card->card_3_title_1 }}</h4>
                    <p class="mb-0 text-white">{{ $card->card_3_title_2 }}</p>
                    <a href="{{ $card->link_3 ?? '#' }}" class="btn btn-outline-light btn-sm">View Collection</a>
                  </div>
                </div>
              </a>
            </div>
          </div>

        </div>
      </div>
    </div>

    <!-- END SECTION BANNER -->

    <!--<section class="gift-section py-5">-->
    <!--  <div class="container">-->
    <!--    <div class="text-center mb-4">-->
    <!--      <h2 class="gift-sec-title">Exclusive Gift Collection</h2>-->
    <!--      <p class="gift-sec-content">Find the perfect gifts for your loved ones with our unique and thoughtful selections.</p>-->
    <!--    </div>-->
    <!--    <div class="row">-->
    <!--      <div class="col-lg-3 col-md-6 col-sm-12 mb-4">-->
    <!--        <div class="gift-card text-center p-3">-->
    <!--          <img src="assets/images/person-1.jpg" alt="Gift 1" class="img-fluid mb-3">-->
    <!--          <h4 class="gift-card-title">Personalized gift</h4>-->
    <!--          <p class="gift-card-text">A beautiful and thoughtful present for any occasion.</p>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--      <div class="col-lg-3 col-md-6 col-sm-12 mb-4">-->
    <!--        <div class="gift-card text-center p-3">-->
    <!--          <img src="assets/images/person-2.jpg" alt="Gift 2" class="img-fluid mb-3">-->
    <!--          <h4 class="gift-card-title">Personalized gift</h4>-->
    <!--          <p class="gift-card-text">Perfect for making memories with loved ones.</p>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--      <div class="col-lg-3 col-md-6 col-sm-12 mb-4">-->
    <!--        <div class="gift-card text-center p-3">-->
    <!--          <img src="assets/images/person-3.jpg" alt="Gift 3" class="img-fluid mb-3">-->
    <!--          <h4 class="gift-card-title">Personalized gift</h4>-->
    <!--          <p class="gift-card-text">A timeless gift to <br>cherish forever.</p>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--      <div class="col-lg-3 col-md-6 col-sm-12 mb-4">-->
    <!--        <div class="gift-card text-center p-3">-->
    <!--          <img src="assets/images/person-4.jpg" alt="Gift 4" class="img-fluid mb-3">-->
    <!--          <h4 class="gift-card-title">Personalized gift</h4>-->
    <!--          <p class="gift-card-text">A special surprise for someone dear to you.</p>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--    </div>-->
    <!--    <div class="row">-->
    <!--      <div class="col-lg-3 col-md-6 col-sm-12 mb-4">-->
    <!--        <div class="gift-card text-center p-3">-->
    <!--          <img src="assets/images/person-5.jpg" alt="Gift 1" class="img-fluid mb-3">-->
    <!--          <h4 class="gift-card-title">Personalized gift</h4>-->
    <!--          <p class="gift-card-text">A beautiful and thoughtful present for any occasion.</p>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--      <div class="col-lg-3 col-md-6 col-sm-12 mb-4">-->
    <!--        <div class="gift-card text-center p-3">-->
    <!--          <img src="assets/images/perosn-6.jpg" alt="Gift 2" class="img-fluid mb-3">-->
    <!--          <h4 class="gift-card-title">Personalized gift</h4>-->
    <!--          <p class="gift-card-text">Perfect for making memories with loved ones.</p>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--      <div class="col-lg-3 col-md-6 col-sm-12 mb-4">-->
    <!--        <div class="gift-card text-center p-3">-->
    <!--          <img src="assets/images/person-7.jpg" alt="Gift 3" class="img-fluid mb-3">-->
    <!--          <h4 class="gift-card-title">Personalized gift</h4>-->
    <!--          <p class="gift-card-text">A timeless gift to <br>cherish forever.</p>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--      <div class="col-lg-3 col-md-6 col-sm-12 mb-4">-->
    <!--        <div class="gift-card text-center p-3">-->
    <!--          <img src="assets/images/person-4.jpg" alt="Gift 4" class="img-fluid mb-3">-->
    <!--          <h4 class="gift-card-title">Personalized gift</h4>-->
    <!--          <p class="gift-card-text">A special surprise for someone dear to you.</p>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--    </div>-->
    <!--    <div class="d-flex justify-content-center align-items-center"><a class="btn btn-outline-secondary px-2 py-2">View all..</a></div>-->
    <!--  </div>-->
    <!--</section>-->


    {{-- Next 2 Categories --}}
    @foreach ($productsByCategory['next_two'] as $categoryTitle => $gifts)
      <div class="category-section mb-4">
        <div class="section small_pt small_pb">
          <div class="custom-container">
            <div class="row">
              <div class="col-xl-9">
                <div class="row">
                  <div class="col-12">
                    <div class="heading_tab_header">
                      <div class="heading_s2">
                        <h4>{{ $categoryTitle }}</h4>
                      </div>
                      <div class="view_all">
                        <a href="#" class="text_default">
                          <i class="fa-solid fa-eye"></i>
                          <span>View All</span>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-12">
                    <div class="product_slider carousel_slider owl-carousel owl-theme dot_style1" data-margin="20"
                      data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "991":{"items": "4"}}'>

                      @foreach ($gifts as $gift)
                        <div class="item">
                          <div class="product_wrap">
                            <div class="product_img">
                              <a href="{{ route('subcategory.products', $gift->subcategory_id) }}">
                                @if ($gift->productImage && $gift->productImage->web_image_1)
                                  <img src="{{ url('uploads/products/' . $gift->productImage->web_image_1) }}"
                                    alt="Product Image">
                                  <img class="product_hover_img"
                                    src="{{ url('uploads/products/' . $gift->productImage->web_image_1) }}" alt="Hover Image">
                                @else
                                  <img src="{{ asset('assets/images/placeholder.jpg') }}" alt="{{ $gift->product_name }}">
                                  <img class="product_hover_img" src="{{ asset('assets/images/placeholder.jpg') }}"
                                    alt="{{ $gift->product_name }}">
                                @endif
                              </a>

                              <div class="wishlist_btn">
                                <a href="javascript:void(0);" class="wishlist-btn" data-product-id="{{ $gift->product_id }}">
                                  <i class="fa-regular fa-heart"></i>
                                </a>
                              </div>
                            </div>

                            <div class="product_info">
                              <h6 class="product_title">{{ $gift->product_name }}</h6>

                              <div class="product_price">
                                <span class="price">₹{{ $gift->productUnit->unit_price ?? '0.00' }}</span>
                                @if (!empty($gift->productUnit->mrp_price))
                                  <del>₹{{ $gift->productUnit->mrp_price }}</del>
                                @endif

                                @if (!empty($gift->productUnit->unit_price) && !empty($gift->productUnit->mrp_price))
                                  @php
                                    $discount = 100 - ($gift->productUnit->unit_price / $gift->productUnit->mrp_price * 100);
                                  @endphp
                                  <div class="on_sale">
                                    <span>{{ round($discount) }}% Off</span>

                                    <div class="add_to_cart">
                                      <a href="javascript:void(0);" class="add-to-cart-btn"
                                        data-product-id="{{ $gift->product_id }}" data-product-name="{{ $gift->product_name }}"
                                        data-price="{{ $gift->productUnit->unit_price ?? 0 }}" data-quantity="1">
                                        <i class="fa-solid fa-cart-shopping"></i>
                                        <span class="cart-text">Add to Cart</span>
                                      </a>
                                    </div>
                                  </div>
                                @endif
                              </div>

                              <div class="rating_wrap">
                                <div class="rating">
                                  <div class="product_rate" style="width: 68%"></div>
                                </div>
                                <span class="rating_num">(15)</span>
                              </div>

                              <div class="pr_desc">
                                <p>
                                  Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim.
                                  Nullam id varius nunc.
                                </p>
                              </div>
                            </div>
                          </div>
                        </div>
                      @endforeach

                    </div>
                  </div>
                </div>
              </div>

              <div class="col-xl-3 d-none d-xl-block">
                <div class="sale-banner">
                  <a class="hover_effect1" href="#">
                    <img src="{{ asset('assets/images/shop_banner_im.png') }}" alt="shop_banner_img">
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    @endforeach



    <!-- START SECTION SUBSCRIBE NEWSLETTER -->
    <div class="section bg_default small_pt small_pb">
      <div class="custom-container">
        <div class="row align-items-center">
          <div class="col-md-6">
            <div class="newsletter_text text_white">

              <h3>Contact Us now</h3>
              <p>Explore Our Products Today to get unbelievable Discounts!!</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="d-flex justify-content-center align-items-center">

              <button type="submit" class="btn btn-dark btn-radius" name="submit" value="Submit">
                Explore Our Products
              </button>

            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- START SECTION SUBSCRIBE NEWSLETTER -->
    </div>

    <!--static Page Code -->

    <!--<div class="container-fluid mt-4">-->
    <!--  <div class="row">-->
    <!-- Product Column -->
    <!--    <div class="col-md-4 mb-4">-->
    <!--      <div class="product-column">-->
    <!--        <h5>Featured Products</h5>-->
    <!--        <a href="#" class="view-all">View All</a>-->
    <!--        <div class="swiper mySwiper">-->
    <!--          <div class="swiper-wrapper">-->
    <!--            <div class="swiper-slide">-->
    <!--              <div class="row g-4 feature-row">-->
    <!--                <div class="col-lg-6 product-card">-->
    <!--                  <img src="assets/images/item25.jpg" alt="Product" />-->
    <!--                  <div class="d-flex justify-content-between">-->
    <!--                    <p>Product</p>-->
    <!--                    <span>35% Off</span>-->
    <!--                  </div>-->
    <!--                </div>-->
    <!--                <div class="col-lg-6 product-card">-->
    <!--                  <img src="assets/images/item24.jpg" alt="Product" />-->
    <!--                  <div class="d-flex justify-content-between">-->
    <!--                    <p>Product</p>-->
    <!--                    <span>35% Off</span>-->
    <!--                  </div>-->
    <!--                </div>-->
    <!--                <div class="col-lg-6 product-card">-->
    <!--                  <img src="assets/images/item23.jpg" alt="Product" />-->
    <!--                  <div class="d-flex justify-content-between">-->
    <!--                    <p>Product</p>-->
    <!--                    <span>35% Off</span>-->
    <!--                  </div>-->
    <!--                </div>-->
    <!--                <div class="col-lg-6 product-card">-->
    <!--                  <img src="assets/images/item22.jpg" alt="Product" />-->
    <!--                  <div class="d-flex justify-content-between">-->
    <!--                    <p>Product</p>-->
    <!--                    <span>35% Off</span>-->
    <!--                  </div>-->
    <!--                </div>-->
    <!--              </div>-->

    <!--            </div>-->
    <!--            <div class="swiper-slide">-->
    <!--              <div class="row g-4 feature-row">-->
    <!--                <div class="col-lg-6 product-card">-->
    <!--                  <img src="assets/images/item21.jpg" alt="Product" />-->
    <!--                  <div class="d-flex justify-content-between">-->
    <!--                    <p>Product</p>-->
    <!--                    <span>35% Off</span>-->
    <!--                  </div>-->
    <!--                </div>-->
    <!--                <div class="col-lg-6 product-card">-->
    <!--                  <img src="assets/images/item20.jpg" alt="Product" />-->
    <!--                  <div class="d-flex justify-content-between">-->
    <!--                    <p>Product</p>-->
    <!--                    <span>35% Off</span>-->
    <!--                  </div>-->
    <!--                </div>-->

    <!--                <div class="col-lg-6 product-card">-->
    <!--                  <img src="assets/images/item19.jpg" alt="Product" />-->
    <!--                  <div class="d-flex justify-content-between">-->
    <!--                    <p>Product</p>-->
    <!--                    <span>35% Off</span>-->
    <!--                  </div>-->
    <!--                </div>-->
    <!--                <div class="col-lg-6 product-card">-->
    <!--                  <img src="assets/images/item18.jpg" alt="Product" />-->
    <!--                  <div class="d-flex justify-content-between">-->
    <!--                    <p>Product</p>-->
    <!--                    <span>35% Off</span>-->
    <!--                  </div>-->
    <!--                </div>-->
    <!--              </div>-->
    <!--            </div>-->
    <!--          </div>-->
    <!--          <div class="swiper-pagination"></div>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--    </div>-->
    <!--    <div class="col-md-4 mb-4">-->
    <!--      <div class="product-column">-->
    <!--        <h5>Trending Collections</h5>-->
    <!--        <a href="#" class="view-all">View All</a>-->
    <!--        <div class="swiper mySwiper">-->
    <!--          <div class="swiper-wrapper">-->
    <!--            <div class="swiper-slide">-->
    <!--              <div class="row g-4 feature-row">-->
    <!--                <div class="col-lg-6 product-card">-->
    <!--                  <img src="assets/images/item17.jpg" alt="Product" />-->
    <!--                  <div class="d-flex justify-content-between">-->
    <!--                    <p>Product</p>-->
    <!--                    <span>35% Off</span>-->
    <!--                  </div>-->
    <!--                </div>-->
    <!--                <div class="col-lg-6 product-card">-->
    <!--                  <img src="assets/images/item16.jpg" alt="Product" />-->
    <!--                  <div class="d-flex justify-content-between">-->
    <!--                    <p>Product</p>-->
    <!--                    <span>35% Off</span>-->
    <!--                  </div>-->
    <!--                </div>-->
    <!--                <div class="col-lg-6 product-card">-->
    <!--                  <img src="assets/images/item14.jpg" alt="Product" />-->
    <!--                  <div class="d-flex justify-content-between">-->
    <!--                    <p>Product</p>-->
    <!--                    <span>35% Off</span>-->
    <!--                  </div>-->
    <!--                </div>-->
    <!--                <div class="col-lg-6 product-card">-->
    <!--                  <img src="assets/images/item13.jpg" alt="Product" />-->
    <!--                  <div class="d-flex justify-content-between">-->
    <!--                    <p>Product</p>-->
    <!--                    <span>35% Off</span>-->
    <!--                  </div>-->
    <!--                </div>-->
    <!--              </div>-->
    <!--            </div>-->
    <!--            <div class="swiper-slide">-->
    <!--              <div class="row g-4 feature-row">-->
    <!--                <div class="col-lg-6 product-card">-->
    <!--                  <img src="assets/images/item12.jpg" alt="Product" />-->
    <!--                  <div class="d-flex justify-content-between">-->
    <!--                    <p>Product</p>-->
    <!--                    <span>35% Off</span>-->
    <!--                  </div>-->
    <!--                </div>-->
    <!--                <div class="col-lg-6 product-card">-->
    <!--                  <img src="assets/images/item11.jpg" alt="Product" />-->
    <!--                  <div class="d-flex justify-content-between">-->
    <!--                    <p>Product</p>-->
    <!--                    <span>35% Off</span>-->
    <!--                  </div>-->
    <!--                </div>-->
    <!--                <div class="col-lg-6 product-card">-->
    <!--                  <img src="assets/images/item10.jpg" alt="Product" />-->
    <!--                  <div class="d-flex justify-content-between">-->
    <!--                    <p>Product</p>-->
    <!--                    <span>35% Off</span>-->
    <!--                  </div>-->
    <!--                </div>-->
    <!--                <div class="col-lg-6 product-card">-->
    <!--                  <img src="assets/images/item9.jpg" alt="Product" />-->
    <!--                  <div class="d-flex justify-content-between">-->
    <!--                    <p>Product</p>-->
    <!--                    <span>35% Off</span>-->
    <!--                  </div>-->
    <!--                </div>-->
    <!--              </div>-->
    <!--            </div>-->
    <!--          </div>-->
    <!--          <div class="swiper-pagination"></div>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--    </div>-->
    <!--    <div class="col-md-4 mb-4">-->
    <!--      <div class="product-column">-->
    <!--        <h5>Exclusive Products</h5>-->
    <!--        <a href="#" class="view-all">View All</a>-->
    <!--        <div class="swiper mySwiper">-->
    <!--          <div class="swiper-wrapper">-->
    <!--            <div class="swiper-slide">-->
    <!--              <div class="row g-4 feature-row">-->
    <!--                <div class="col-lg-6 product-card">-->
    <!--                  <img src="assets/images/item8.jpg" alt="Product" />-->
    <!--                  <div class="d-flex justify-content-between">-->
    <!--                    <p>Product</p>-->
    <!--                    <span>35% Off</span>-->
    <!--                  </div>-->
    <!--                </div>-->
    <!--                <div class="col-lg-6 product-card">-->
    <!--                  <img src="assets/images/item7.jpg" alt="Product" />-->
    <!--                  <div class="d-flex justify-content-between">-->
    <!--                    <p>Product</p>-->
    <!--                    <span>35% Off</span>-->
    <!--                  </div>-->
    <!--                </div>-->
    <!--                <div class="col-lg-6 product-card">-->
    <!--                  <img src="assets/images/item6.jpg" alt="Product" />-->
    <!--                  <div class="d-flex justify-content-between">-->
    <!--                    <p>Product</p>-->
    <!--                    <span>35% Off</span>-->
    <!--                  </div>-->
    <!--                </div>-->
    <!--                <div class="col-lg-6 product-card">-->
    <!--                  <img src="assets/images/item5.jpg" alt="Product" />-->
    <!--                  <div class="d-flex justify-content-between">-->
    <!--                    <p>Product</p>-->
    <!--                    <span>35% Off</span>-->
    <!--                  </div>-->
    <!--                </div>-->
    <!--              </div>-->
    <!--            </div>-->
    <!--            <div class="swiper-slide">-->
    <!--              <div class="row g-4 feature-row">-->
    <!--                <div class="col-lg-6 product-card">-->
    <!--                  <img src="assets/images/item4.jpg" alt="Product" />-->
    <!--                  <div class="d-flex justify-content-between">-->
    <!--                    <p>Product</p>-->
    <!--                    <span>35% Off</span>-->
    <!--                  </div>-->
    <!--                </div>-->
    <!--                <div class="col-lg-6 product-card">-->
    <!--                  <img src="assets/images/item3.jpg" alt="Product" />-->
    <!--                  <div class="d-flex justify-content-between">-->
    <!--                    <p>Product</p>-->
    <!--                    <span>35% Off</span>-->
    <!--                  </div>-->
    <!--                </div>-->
    <!--                <div class="col-lg-6 product-card">-->
    <!--                  <img src="assets/images/item2.jpg" alt="Product" />-->
    <!--                  <div class="d-flex justify-content-between">-->
    <!--                    <p>Product</p>-->
    <!--                    <span>35% Off</span>-->
    <!--                  </div>-->
    <!--                </div>-->
    <!--                <div class="col-lg-6 product-card">-->
    <!--                  <img src="assets/images/item1.jpg" alt="Product" />-->
    <!--                  <div class="d-flex justify-content-between">-->
    <!--                    <p>Product</p>-->
    <!--                    <span>35% Off</span>-->
    <!--                  </div>-->
    <!--                </div>-->
    <!--              </div>-->
    <!--            </div>-->
    <!--          </div>-->
    <!--          <div class="swiper-pagination"></div>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--    </div>-->
    <!-- Add more columns following the same structure -->
    <!--  </div>-->
    <!--</div>-->

    <!--dynamic Page Code -->

    <!--<div class="container-fluid mt-4">-->
    <!--  <div class="row">-->

    <!--    {{-- Featured Products (collection = 2) --}}-->
    <!--    <div class="col-md-4 mb-4">-->
    <!--      <div class="product-column">-->
    <!--        <h5>Featured Products</h5>-->
    <!--        <a href="#" class="view-all">View All</a>-->
    <!--        <div class="swiper mySwiper">-->
    <!--          <div class="swiper-wrapper h-auto">-->
    <!--            @foreach($featuredProducts->chunk(4) as $group)-->
    <!--              <div class="swiper-slide">-->
    <!--                <div class="row g-4 feature-row">-->
    <!--                  @foreach($group as $product)-->
    <!--                    <div class="col-lg-6 product-card">-->
    <!--                      <img src="{{ $product->productImage && $product->productImage->web_image_1 ? asset('uploads/products/' . $product->productImage->web_image_1) : asset('assets/images/no-image.jpg') }}" alt="{{ $product->product_name }}" />-->
    <!--                      <div class="d-flex justify-content-between">-->
    <!--                        <p>{{ $product->product_name }}</p>-->
    <!--                        <span>35% Off</span>-->
    <!--                      </div>-->
    <!--                    </div>-->
    <!--                  @endforeach-->
    <!--                </div>-->
    <!--              </div>-->
    <!--            @endforeach-->
    <!--          </div>-->
    <!--          <div class="swiper-pagination"></div>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--    </div>-->

    <!--    {{-- Trending Collections (collection = 1) --}}-->
    <!--    <div class="col-md-4 mb-4">-->
    <!--      <div class="product-column">-->
    <!--        <h5>Trending Collections</h5>-->
    <!--        <a href="#" class="view-all">View All</a>-->
    <!--        <div class="swiper mySwiper">-->
    <!--          <div class="swiper-wrapper h-auto">-->
    <!--            @foreach($trendingProducts->chunk(4) as $group)-->
    <!--              <div class="swiper-slide">-->
    <!--                <div class="row g-4 feature-row">-->
    <!--                  @foreach($group as $product)-->
    <!--                    <div class="col-lg-6 product-card">-->
    <!--                      <img src="{{ $product->productImage && $product->productImage->web_image_1 ? asset('uploads/products/' . $product->productImage->web_image_1) : asset('assets/images/no-image.jpg') }}" alt="{{ $product->product_name }}" />-->
    <!--                      <div class="d-flex justify-content-between">-->
    <!--                        <p>{{ $product->product_name }}</p>-->
    <!--                        <span>35% Off</span>-->
    <!--                      </div>-->
    <!--                    </div>-->
    <!--                  @endforeach-->
    <!--                </div>-->
    <!--              </div>-->
    <!--            @endforeach-->
    <!--          </div>-->
    <!--          <div class="swiper-pagination"></div>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--    </div>-->

    <!--    {{-- Exclusive Products (collection = 3) --}}-->
    <!--    <div class="col-md-4 mb-4">-->
    <!--      <div class="product-column">-->
    <!--        <h5>Exclusive Products</h5>-->
    <!--        <a href="#" class="view-all">View All</a>-->
    <!--        <div class="swiper mySwiper">-->
    <!--          <div class="swiper-wrapper h-auto">-->
    <!--            @foreach($exclusiveProducts->chunk(4) as $group)-->
    <!--              <div class="swiper-slide">-->
    <!--                <div class="row g-4 feature-row">-->
    <!--                  @foreach($group as $product)-->
    <!--                    <div class="col-lg-6 product-card">-->
    <!--                      <img src="{{ $product->productImage && $product->productImage->web_image_1 ? asset('uploads/products/' . $product->productImage->web_image_1) : asset('assets/images/no-image.jpg') }}" alt="{{ $product->product_name }}" />-->
    <!--                      <div class="d-flex justify-content-between">-->
    <!--                        <p>{{ $product->product_name }}</p>-->
    <!--                        <span>35% Off</span>-->
    <!--                      </div>-->
    <!--                    </div>-->
    <!--                  @endforeach-->
    <!--                </div>-->
    <!--              </div>-->
    <!--            @endforeach-->
    <!--          </div>-->
    <!--          <div class="swiper-pagination"></div>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--    </div>-->

    <!--  </div>-->
    <!--</div>-->
    <!--below both codes are working properly need to update the styel and test in the admin Page to upload the extra adat in each -->

    <div class="container-fluid mt-4">
      <div class="row">

        {{-- Featured Products (collection = 2) --}}
        <div class="col-md-4 mb-4">
          <div class="product-column">
            <h5>Featured Products</h5>
            <a href="#" class="view-all">View All</a>
            <div class="swiper featuredSwiper">
              <div class="swiper-wrapper h-auto">
                @if($featuredProducts->count() > 0)
                  @foreach($featuredProducts->chunk(4) as $group)
                    <div class="swiper-slide">
                      <div class="row g-4 feature-row">
                        @foreach($group as $product)
                          <div class="col-lg-6 product-card">
                            <img
                              src="{{ $product->productImage && $product->productImage->web_image_1 ? asset('uploads/products/' . $product->productImage->web_image_1) : asset('assets/images/no-image.jpg') }}"
                              alt="{{ $product->product_name }}" />
                            <div class="d-flex justify-content-between">
                              <p>{{ $product->product_name }}</p>
                              <span>35% Off</span>
                            </div>
                          </div>
                        @endforeach
                      </div>
                    </div>
                  @endforeach
                @else
                  <div class="swiper-slide">
                    <div class="row g-4 feature-row">
                      <div class="col-12">
                        <p>No featured products available</p>
                      </div>
                    </div>
                  </div>
                @endif
              </div>
              <div class="swiper-pagination"></div>
            </div>
          </div>
        </div>

        {{-- Trending Collections (collection = 1) --}}
        <div class="col-md-4 mb-4">
          <div class="product-column">
            <h5>Trending Collections</h5>
            <a href="#" class="view-all">View All</a>
            <div class="swiper trendingSwiper">
              <div class="swiper-wrapper h-auto">
                @if($trendingProducts->count() > 0)
                  @foreach($trendingProducts->chunk(4) as $group)
                    <div class="swiper-slide">
                      <div class="row g-4 feature-row">
                        @foreach($group as $product)
                          <div class="col-lg-6 product-card">
                            <img
                              src="{{ $product->productImage && $product->productImage->web_image_1 ? asset('uploads/products/' . $product->productImage->web_image_1) : asset('assets/images/no-image.jpg') }}"
                              alt="{{ $product->product_name }}" />
                            <div class="d-flex justify-content-between">
                              <p>{{ $product->product_name }}</p>
                              <span>35% Off</span>
                            </div>
                          </div>
                        @endforeach
                      </div>
                    </div>
                  @endforeach
                @else
                  <div class="swiper-slide">
                    <div class="row g-4 feature-row">
                      <div class="col-12">
                        <p>No trending products available</p>
                      </div>
                    </div>
                  </div>
                @endif
              </div>
              <div class="swiper-pagination"></div>
            </div>
          </div>
        </div>

        {{-- Exclusive Products (collection = 3) --}}
        <div class="col-md-4 mb-4">
          <div class="product-column">
            <h5>Exclusive Products</h5>
            <a href="#" class="view-all">View All</a>
            <div class="swiper exclusiveSwiper">
              <div class="swiper-wrapper h-auto">
                @if($exclusiveProducts->count() > 0)
                  @foreach($exclusiveProducts->chunk(4) as $group)
                    <div class="swiper-slide">
                      <div class="row g-4 feature-row">
                        @foreach($group as $product)
                          <div class="col-lg-6 product-card">
                            <img
                              src="{{ $product->productImage && $product->productImage->web_image_1 ? asset('uploads/products/' . $product->productImage->web_image_1) : asset('assets/images/no-image.jpg') }}"
                              alt="{{ $product->product_name }}" />
                            <div class="d-flex justify-content-between">
                              <p>{{ $product->product_name }}</p>
                              <span>35% Off</span>
                            </div>
                          </div>
                        @endforeach
                      </div>
                    </div>
                  @endforeach
                @else
                  <div class="swiper-slide">
                    <div class="row g-4 feature-row">
                      <div class="col-12">
                        <p>No exclusive products available</p>
                      </div>
                    </div>
                  </div>
                @endif
              </div>
              <div class="swiper-pagination"></div>
            </div>
          </div>
        </div>

      </div>
    </div>


    <!--<div class="container-fluid mt-4">-->
    <!--  <div class="row">-->

    <!--    {{-- Featured Products (collection = 2) --}}-->
    <!--    <div class="col-md-4 mb-4">-->
    <!--      <div class="product-column">-->
    <!--        <h5>Featured Products</h5>-->
    <!--        <a href="#" class="view-all">View All</a>-->
    <!--        <div class="swiper mySwiper">-->
    <!--          <div class="swiper-wrapper">-->
    <!--            @php $chunks = $featuredProducts->chunk(4); @endphp-->
    <!--            @foreach ($chunks as $group)-->
    <!--              <div class="swiper-slide">-->
    <!--                <div class="row g-4 feature-row">-->
    <!--                  @foreach ($group as $product)-->
    <!--                    <div class="col-lg-6 product-card">-->
    <!--                      <img src="{{ $product->productImage && $product->productImage->web_image_1 ? asset('uploads/products/' . $product->productImage->web_image_1) : asset('assets/images/no-image.jpg') }}" alt="{{ $product->product_name }}">-->
    <!--                      <div class="d-flex justify-content-between">-->
    <!--                        <p>{{ $product->product_name }}</p>-->
    <!--                        <span>35% Off</span>-->
    <!--                      </div>-->
    <!--                    </div>-->
    <!--                  @endforeach-->
    <!--                </div>-->
    <!--              </div>-->
    <!--            @endforeach-->
    <!--          </div>-->
    <!--          <div class="swiper-pagination"></div>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--    </div>-->

    <!--    {{-- Trending Collections (collection = 1) --}}-->
    <!--    <div class="col-md-4 mb-4">-->
    <!--      <div class="product-column">-->
    <!--        <h5>Trending Collections</h5>-->
    <!--        <a href="#" class="view-all">View All</a>-->
    <!--        <div class="swiper mySwiper">-->
    <!--          <div class="swiper-wrapper">-->
    <!--            @php $chunks = $trendingProducts->chunk(4); @endphp-->
    <!--            @foreach ($chunks as $group)-->
    <!--              <div class="swiper-slide">-->
    <!--                <div class="row g-4 feature-row">-->
    <!--                  @foreach ($group as $product)-->
    <!--                    <div class="col-lg-6 product-card">-->
    <!--                      <img src="{{ $product->productImage && $product->productImage->web_image_1 ? asset('uploads/products/' . $product->productImage->web_image_1) : asset('assets/images/no-image.jpg') }}" alt="{{ $product->product_name }}">-->
    <!--                      <div class="d-flex justify-content-between">-->
    <!--                        <p>{{ $product->product_name }}</p>-->
    <!--                        <span>35% Off</span>-->
    <!--                      </div>-->
    <!--                    </div>-->
    <!--                  @endforeach-->
    <!--                </div>-->
    <!--              </div>-->
    <!--            @endforeach-->
    <!--          </div>-->
    <!--          <div class="swiper-pagination"></div>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--    </div>-->

    <!--    {{-- Exclusive Products (collection = 3) --}}-->
    <!--    <div class="col-md-4 mb-4">-->
    <!--      <div class="product-column">-->
    <!--        <h5>Exclusive Products</h5>-->
    <!--        <a href="#" class="view-all">View All</a>-->
    <!--        <div class="swiper mySwiper">-->
    <!--          <div class="swiper-wrapper">-->
    <!--            @php $chunks = $exclusiveProducts->chunk(4); @endphp-->
    <!--            @foreach ($chunks as $group)-->
    <!--              <div class="swiper-slide">-->
    <!--                <div class="row g-4 feature-row">-->
    <!--                  @foreach ($group as $product)-->
    <!--                    <div class="col-lg-6 product-card">-->
    <!--                      <img src="{{ $product->productImage && $product->productImage->web_image_1 ? asset('uploads/products/' . $product->productImage->web_image_1) : asset('assets/images/no-image.jpg') }}" alt="{{ $product->product_name }}">-->
    <!--                      <div class="d-flex justify-content-between">-->
    <!--                        <p>{{ $product->product_name }}</p>-->
    <!--                        <span>35% Off</span>-->
    <!--                      </div>-->
    <!--                    </div>-->
    <!--                  @endforeach-->
    <!--                </div>-->
    <!--              </div>-->
    <!--            @endforeach-->
    <!--          </div>-->
    <!--          <div class="swiper-pagination"></div>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--    </div>-->

    <!--  </div>-->
    <!--</div>-->


    <!-- END SECTION SHOP -->

    <!-- START SECTION BANNER -->


    <!-- END SECTION BANNER -->


    <!-- START SECTION SHOP -->

    <!-- END SECTION SHOP -->

    <!-- START SECTION SHOP -->

    <!-- END SECTION SHOP -->

    <!-- START SECTION CLIENT LOGO -->

    <!-- END SECTION CLIENT LOGO -->




    <!-- END MAIN CONTENT -->
    {{-- Remaining Categories --}}
    @foreach ($productsByCategory['remaining'] as $categoryTitle => $gifts)
      <div class="category-section mb-4">
        <div class="section small_pt small_pb">
          <div class="custom-container">
            <div class="row">
              <div class="col-xl-9">
                <div class="row">
                  <div class="col-12">
                    <div class="heading_tab_header">
                      <div class="heading_s2">
                        <h4>{{ $categoryTitle }}</h4>
                      </div>
                      <div class="view_all">
                        <a href="#" class="text_default">
                          <i class="fa-solid fa-eye"></i>
                          <span>View All</span>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-12">
                    <div class="product_slider carousel_slider owl-carousel owl-theme dot_style1" data-margin="20"
                      data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "991":{"items": "4"}}'>

                      @foreach ($gifts as $gift)
                        <div class="item">
                          <div class="product_wrap">
                            <div class="product_img">
                              <a href="{{ route('subcategory.products', $gift->subcategory_id) }}">
                                @if ($gift->productImage && $gift->productImage->web_image_1)
                                  <img src="{{ url('uploads/products/' . $gift->productImage->web_image_1) }}"
                                    alt="Product Image">
                                  <img class="product_hover_img"
                                    src="{{ url('uploads/products/' . $gift->productImage->web_image_1) }}" alt="Hover Image">
                                @else
                                  <img src="{{ asset('assets/images/placeholder.jpg') }}" alt="{{ $gift->product_name }}">
                                  <img class="product_hover_img" src="{{ asset('assets/images/placeholder.jpg') }}"
                                    alt="{{ $gift->product_name }}">
                                @endif
                              </a>

                              <div class="wishlist_btn">
                                <a href="javascript:void(0);" class="wishlist-btn" data-product-id="{{ $gift->product_id }}">
                                  <i class="fa-regular fa-heart"></i>
                                </a>
                              </div>
                            </div>

                            <div class="product_info">
                              <h6 class="product_title">{{ $gift->product_name }}</h6>

                              <div class="product_price">
                                <span class="price">₹{{ $gift->productUnit->unit_price ?? '0.00' }}</span>
                                @if (!empty($gift->productUnit->mrp_price))
                                  <del>₹{{ $gift->productUnit->mrp_price }}</del>
                                @endif

                                @if (!empty($gift->productUnit->unit_price) && !empty($gift->productUnit->mrp_price))
                                  @php
                                    $discount = 100 - ($gift->productUnit->unit_price / $gift->productUnit->mrp_price * 100);
                                  @endphp
                                  <div class="on_sale">
                                    <span>{{ round($discount) }}% Off</span>

                                    <div class="add_to_cart">
                                      <a href="javascript:void(0);" class="add-to-cart-btn"
                                        data-product-id="{{ $gift->product_id }}"
                                        data-product-unit-id="{{ $gift->productUnit->product_unit_id ?? '' }}"
                                        data-product-name="{{ $gift->product_name }}"
                                        data-price="{{ $gift->productUnit->unit_price ?? 0 }}"
                                        data-quantity="1">
                                        <i class="fa-solid fa-cart-shopping"></i>
                                        <span class="cart-text">Add to Cart</span>
                                      </a>
                                    </div>
                                  </div>
                                @endif
                              </div>

                              <div class="rating_wrap">
                                <div class="rating">
                                  <div class="product_rate" style="width: 68%"></div>
                                </div>
                                <span class="rating_num">(15)</span>
                              </div>

                              <div class="pr_desc">
                                <p>
                                  Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim.
                                  Nullam id varius nunc.
                                </p>
                              </div>
                            </div>
                          </div>
                        </div>
                      @endforeach

                    </div>
                  </div>
                </div>
              </div>

              <div class="col-xl-3 d-none d-xl-block">
                <div class="sale-banner">
                  <a class="hover_effect1" href="#">
                    <img src="{{ asset('assets/images/shop_banner_im.png') }}" alt="shop_banner_img">
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    @endforeach

  </main>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  // ----------- Cart Add Handler -----------
  const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
  addToCartButtons.forEach(button => {
    button.addEventListener('click', function (event) {
      event.preventDefault();

      const productId = this.dataset.productId;
      const productUnitId = this.dataset.productUnitId || ''; // ensure we include unit
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
          alert('Product added to cart successfully!');
          updateCartCount();
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

  // Update cart count from proper cart count endpoint
  function updateCartCount() {
    fetch("{{ route('cart.getCount') }}")
      .then(response => response.json())
      .then(data => {
        // The backend returns { cart_count: X }
        let count = data.cart_count ?? data.count;
        const cartCountElement = document.querySelector('.cart-count');
        if (cartCountElement && typeof count !== "undefined") {
          cartCountElement.textContent = count > 0 ? count : '';
        }
      })
      .catch(error => {
        console.error('Error fetching cart count:', error);
      });
  }

  updateCartCount();

  // ----------- Wishlist Handler -----------
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
        // Expected format: { count: X }
        const countElement = document.querySelector('.wishlist-count');
        if (countElement && typeof data.count !== 'undefined') {
          countElement.textContent = data.count > 0 ? data.count : '';
        }
      });
  }

  updateWishlistCount();
});
</script>
<!--<script>-->
<!--  document.addEventListener("DOMContentLoaded", function () {-->
<!--    const togglers = document.querySelectorAll(".dropdown-toggler");-->

<!--    togglers.forEach((toggler) => {-->
<!--      toggler.addEventListener("click", function (e) {-->
<!--        e.preventDefault();-->
<!--        const menu = this.closest(".dropdown").querySelector(".dropdown-menu");-->
<!--        if (menu) {-->
<!--          menu.classList.toggle("show");-->
<!--        }-->
<!--      });-->
<!--    });-->
<!--  });-->
<!--</script>-->