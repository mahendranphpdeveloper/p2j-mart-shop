<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta content="Anil z" name="author" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="description"
        content="P2J Mart is built for sell Fashion Products, Shoes, Bags, Cosmetics, Clothes, Sunglasses, Furniture, Kids Products, Electronics, Stationery Products and Sporting Goods." />
    <meta name="keywords"
        content="ecommerce, electronics store, Fashion store, furniture store,  bootstrap 4, clean, minimal, modern, online store, responsive, retail, shopping, ecommerce store" />

    <!-- SITE TITLE -->
    <title>P2jMart</title>
    <!-- Favicon Icon -->
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/logo.jpg') }}" />

    <!-- Animation CSS -->
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}" />

    <!-- Latest Bootstrap min CSS -->
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}" />

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Quattrocento:wght@400;700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">

    <!-- Icon Font CSS -->
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/themify-icons.css') }}" />

    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="{{ asset('owlcarousel/css/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('owlcarousel/css/owl.theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('owlcarousel/css/owl.theme.default.min.css') }}" />

    <!-- Magnific Popup CSS -->
    <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}" />

    <!-- Slick CSS -->
    <link rel="stylesheet" href="{{ asset('css/slick.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/slick-theme.css') }}" />

    <!-- jQuery UI CSS -->
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}" />

    <!-- intl-tel-input CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css" />

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet" />

    <!-- Style CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}" />

    <style>

        
        .user-menu-wrapper {
            position: relative;
        }

        .user-menu {
            position: relative;
            cursor: pointer;
        }

        .user-dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            min-width: 160px;
            background-color: #fff;
            border: 1px solid #ddd;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 999;
            display: none;
            padding: 10px 0;
            border-radius: 5px;
        }

        .user-dropdown-menu a {
            display: block;
            padding: 8px 16px;
            color: #333;
            text-decoration: none;
            transition: background-color 0.2s;
        }

        .user-dropdown-menu a:hover {
            background-color: #f5f5f5;
        }

        /* Show dropdown on hover */
        .user-menu:hover .user-dropdown-menu {
            display: block;
            max-width: 250px;
        }

        .dropdown-user-email {
            word-wrap: break-word;
            white-space: normal;
            overflow-wrap: break-word;
            max-width: 100%;
            display: block;
        }
    </style>


</head>


@php
    
    $userId = Auth::id();
    $sessionId = session()->getId();

    if ($userId || $sessionId) {
        $wishlistItems = \App\Models\Wishlist::where(function ($query) use ($userId, $sessionId) {
            if ($userId) {
                $query->where('user_id', $userId);
            } else {
                $query->where('session_id', $sessionId);
            }
        })
        ->pluck('product_unit_id')
        ->toArray();
    }
    
@endphp


<body>

    <!-- LOADER -->
    <!-- <div class="preloader">
    <div class="lds-ellipsis">
        <span></span>
        <span></span>
        <span></span>
    </div>
</div> -->
    <!-- END LOADER -->

    <!-- Home Popup Section -->
    <!-- <div class="modal fade subscribe_popup" id="onload-popup" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="ion-ios-close-empty"></i></span>
                </button>
                <div class="row g-0">
                    <div class="col-sm-5">
                    	<div class="background_bg h-100" data-img-src="assets/images/popup_img.jpg"></div>
                    </div>
                    <div class="col-sm-7">
                        <div class="popup_content">
                            <div class="popup-text">
                                <div class="heading_s4">
                                    <h4>Subscribe and Get 25% Discount!</h4>
                                </div>
                                <p>Subscribe to the newsletter to receive updates about new products.</p>
                            </div>
                            <form method="post">
                            	<div class="form-group mb-3">
                                	<input name="email" required type="email" class="form-control rounded-0" placeholder="Enter Your Email">
                                </div>
                                <div class="form-group mb-3">
                                	<button class="btn btn-fill-line btn-block text-uppercase rounded-0" title="Subscribe" type="submit">Subscribe</button>
                                </div>
                            </form>
                            <div class="chek-form">
                                <div class="custome-checkbox">
                                    <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox3" value="">
                                    <label class="form-check-label" for="exampleCheckbox3"><span>Don't show this popup again!</span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    	</div>
    </div>
</div> -->
    <!-- End Screen Load Popup Section -->

    <!-- START HEADER -->
    <header class="header_wrap fixed-top header_with_topbar">
        <div class="top-header light_skin bg-custom  d-block">
            <div class="custom-container1">
                <div class="row align-items-center">
                    <div class="col-6">
                        <div class="header_topbar_info">
                            <div class="header_offer">
                                <span>{{ $headerFooter->title_1 ?? '' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div
                            class="social-container d-flex align-items-center justify-content-center justify-content-md-end">
                            <a class="text-white  d-block d-lg-none">
                                <i class="fa-solid fa-truck"></i> <!-- Truck icon for mobile -->
                            </a>

                            <a class="text-white border-end d-none d-lg-block pe-3">
                                <span>{{ $headerFooter->title_2 ?? '' }}</span>
                            </a>

                            <a class="text-white px-3 d-block d-lg-none border-end ">
                                <i class="fa-solid fa-headset"></i> <!-- Headset icon for mobile -->
                            </a>

                            <a href="{{ route('contact') }}" class="text-white px-3 d-none d-lg-block">
                                <span>{{ $headerFooter->helpline_name ?? '' }}</span>
                            </a>

                            <!--    {{ $headerFooter->helpline_no ?? '' }}   -->

                            <!-- Social Links -->
                            <a href="{{ $headerFooter->facebook_link }}" target="_blank">
                                <i class="fa-brands fa-facebook-f text-white ps-2 pe-2"></i>
                            </a>
                            <a href="{{ $headerFooter->twitter_link }}" target="_blank">
                                <i class="fa-brands fa-x-twitter text-white pe-2 "></i>
                            </a>
                            <a href="{{ $headerFooter->linkedin_link }}" target="_blank">
                                <i class="fa-brands fa-youtube text-white pe-2 "></i>
                            </a>
                            <a href="#" target="_blank">
                                <i class="fa-brands fa-instagram text-white ps-2 pe-2"></i>
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bottom_header dark_skin main_menu_uppercase header-1-bottom">
            <div class="custom-container1">
                <nav class="navbar navbar-expand-lg">
                    <a class="navbar-brand" href="{{ route('home') }}">
                        <!-- Logo -->
                        @if($headerFooter && $headerFooter->image)
                            <img src="{{ asset('uploads/logo/' . $headerFooter->image) }}" alt="Logo"
                                style="width: 100px !important; height: 80px !important" alt="logo" />
                        @endif
                    </a>

                    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                        <div>
                            <ul class="navbar-nav">
                                <li>
                                    <a class="nav-link nav_item" href="{{ route('home') }}">Home</a>
                                </li>
                                <li>
                                    <a class="nav-link nav_item" href="{{ route('category') }}">Products</a>
                                </li>
                                <li>
                                    <a class="nav-link nav_item" href="{{ route('customize') }}">Customized Products</a>
                                </li>
                                <li>
                                    <a class="nav-link nav_item" href="{{ route('contact') }}">Contact Us</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- <div class="search-container">
                        <input
                            class="form-control header1-search-box"
                            placeholder="Search Product..."
                            required=""
                            type="text" />
                        <i class="fas fa-search search-icon"></i>
                     
                    </div> -->
                    <!-- Product Search Form -->
                    <div class="product_search_form rounded_input">
                        <form>
                            <div class="input-group">
                                <input class="form-control" placeholder="Search Product..." required type="text" />
                                <button type="submit" class="search_btn2">
                                    <i class="fa fa-search search-icon"></i>
                                </button>
                            </div>
                        </form>
                    </div>


                    <!-- User Section -->
                    <div class="d-flex gap-4 align-items-center">
                        @php
                            $user = Auth::user();
                        @endphp

                        <div class="user-menu-wrapper">
                            @if ($user)
                                <div class="gi-header-btn gi-header-user gi-user-toggle user-menu" title="Account">
                                    <div class="header-icon nav-link py-0">
                                        <i class="fa-regular fa-user fs-5"></i>
                                    </div>
                                    <div class="gi-btn-desc">
                                        @auth
                                            <span class="gi-btn-title ">
                                                {{ Str::limit(Auth::user()->email, 8, '...') }}
                                            </span>
                                        @else
                                            <span class="gi-btn-stitle">Profile</span>
                                        @endauth
                                    </div>

                                    <!-- Dropdown on hover -->
                                    <div class="user-dropdown-menu p-3">
                                        <div class="dropdown-user-email mb-3">
                                            {{ $user->email }}
                                        </div>
                                        <a href="{{ route('user.account') }}">My Account</a>

                                        <a href="{{ route('logout.user') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>
                                    </div>
                                </div>

                                <!-- Hidden Logout Form -->
                                <form id="logout-form" action="{{ route('logout.user') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            @else
                                <a href="{{ route('login.user') }}" class="gi-header-btn gi-header-user gi-user-toggle"
                                    title="Login">
                                    <div class="header-icon nav-link">
                                        <i class="fa-regular fa-user fs-5"></i>
                                    </div>
                                </a>
                            @endif
                        </div>


                        <!-- Wishlist -->
                        <!-- Wishlist Icon -->
                        <a href="{{ route('wishlist') }}" class="gi-header-btn position-relative gi-wish-toggle"
                              title="Wishlist">
                            <div class="header-icon position-relative">
                                <i class="fa-regular fa-heart fs-5"></i>
                                <!-- Wishlist Count Badge -->
                                <span class="wishlist-count count-badge" id="wishlist-count">
                                    {{-- Will be populated via JavaScript --}}
                                </span>
                            </div>
                        </a>
                        <!-- Cart  -->
                        <a href="{{ route('cart.view') }}" class="gi-header-btn position-relative gi-cart-toggle"
                            title="cart">
                            <div class="header-icon position-relative">
                                <i class="fa-solid fa-bag-shopping fs-5"></i>

                                <livewire:cart-count />
                            </div>
                        </a>

                        <div class="categories_wrap ">
                            <button type="button" data-bs-toggle="collapse" data-bs-target="#navCatContent"
                                aria-expanded="false" class="categories_btn d-block d-lg-none ">
                                <i class="fa-solid fa-bars"></i>
                            </button>
                            <div id="navCatContent" class="nav_cat navbar nav collapse">
                                <ul>
                                    @foreach($categories as $index => $category)
                                        @if($category->status === 'active')
                                            @if($index < 7) {{-- First 7 categories with dropdown --}}
                                                <li class="dropdown dropdown-mega-menu">
                                                    <a class="dropdown-item nav-link dropdown-toggler" href="#"
                                                        data-bs-toggle="dropdown">
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
                                                                    <div class="flex-grow-1 mb-2">
                                                                        <!-- Image container with bottom margin -->
                                                                        <img class="category-img" src="{{ asset($category->image) }}"
                                                                            alt="{{ $category->title }}" />
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
                                                        <a class="dropdown-item nav-link nav_item"
                                                            href="{{ route('category.products', $category->id) }}">
                                                            <img src="{{ asset($category->image) }}"
                                                                alt="{{ $category->title }}" />
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

    </header>
    <!-- END HEADER -->