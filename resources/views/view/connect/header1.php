<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta content="Anil z" name="author" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta
        name="description"
        content="P2J Mart is built for sell Fashion Products, Shoes, Bags, Cosmetics, Clothes, Sunglasses, Furniture, Kids Products, Electronics, Stationery Products and Sporting Goods." />
    <meta
        name="keywords"
        content="ecommerce, electronics store, Fashion store, furniture store,  bootstrap 4, clean, minimal, modern, online store, responsive, retail, shopping, ecommerce store" />

    <!-- SITE TITLE -->
    <title>P2jMart</title>
    <!-- Favicon Icon -->
  <!-- Favicon -->
<link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/logo.jpg') }}" />

<!-- Animation CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}" />

<!-- Latest Bootstrap min CSS -->
<link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" />

<!-- Google Font -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Quattrocento:wght@400;700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

<!-- Icon Font CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/themify-icons.css') }}" />

<!-- Owl Carousel CSS -->
<link rel="stylesheet" href="{{ asset('assets/owlcarousel/css/owl.carousel.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/owlcarousel/css/owl.theme.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/owlcarousel/css/owl.theme.default.min.css') }}" />

<!-- Magnific Popup CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}" />

<!-- Slick CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/slick-theme.css') }}" />

<!-- jQuery UI CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}" />

<!-- intl-tel-input CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css" />

<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet" />

<!-- Style CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}" />



</head>

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
                                <span>Free Shipping Over ₹500</span>
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
                                Track your order
                            </a>

                            <a class="text-white px-3 d-block d-lg-none border-end ">
                                <i class="fa-solid fa-headset"></i> <!-- Headset icon for mobile -->
                            </a>
                            <a class="text-white px-3 d-none d-lg-block">
                                Need support?
                            </a>
                            <i class="fa-brands fa-instagram text-white ps-2 pe-2"></i>
                            <i class="fa-brands fa-whatsapp text-white pe-2"></i>
                            <i class="fa-brands fa-youtube text-white pe-2 "></i>
                            <i class="fa-brands fa-x-twitter text-white pe-2 "></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bottom_header dark_skin main_menu_uppercase header-1-bottom">
            <div class="custom-container1">
                <nav class="navbar navbar-expand-lg">
                    <a class="navbar-brand" href="index.php">
                        <img class="logo_dark w-25" src="assets/images/logo1.png"
                            style="width: 100px !important; height: 80px !important"
                            alt="logo" />
                    </a>


                    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                        <div>
                            <ul class="navbar-nav">
                                <li>
                                    <a class="nav-link nav_item" href="index.php">Home</a>
                                </li>

                                <li class="dropdown">
                                    <a
                                        data-bs-toggle=""
                                        class="nav-link "
                                        href="category.php">Products</a>
                                </li>
                                <li>
                                    <a class="nav-link nav_item" href="electrical.php">Customized Products</a>
                                </li>

                                <li>
                                    <a class="nav-link nav_item" href="contact.php">Contact Us</a>
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
                    <div class="product_search_form rounded_input">
                        <form>
                            <div class="input-group">
                                <input
                                    class="form-control"
                                    placeholder="Search Product..."
                                    required=""
                                    type="text" />
                                <button type="submit" class="search_btn2">
                                    <i class="fa fa-search search-icon "></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="d-flex align-items-center">
                        <ul class="navbar-nav attr-nav align-items-center">
                            <li>
                                <a href="sign-in.php" class="nav-link"><i class="fa-regular fa-user"></i></a>
                            </li>
                            <li>
                                <a href="wishlist.php" class="nav-link"><i class="fa-regular fa-heart"></i><span class="wishlist_count">10</span></a>
                            </li>
                            <li class="dropdown cart_dropdown">
                                <a class="nav-link cart_trigger" href="#" data-bs-toggle="dropdown">
                                    <i class="fa-solid fa-bag-shopping"></i>
                                    <span class="cart_count">2</span>
                                    <!-- <span class="amount"><span class="currency_symbol">₹</span>159.00</span> -->
                                </a>
                                <div class="cart_box cart_right dropdown-menu dropdown-menu-right">
                                    <ul class="cart_list">
                                        <li>
                                            <a href="#" class="item_remove"><i class="fa-regular fa-circle-xmark"></i></a>
                                            <a href="#"><img src="assets/images/item1.jpg" alt="cart_thumb1" />Variable product 001</a>
                                            <span class="cart_quantity">1 x <span class="cart_amount">
                                                    <span class="price_symbole">₹</span>78.00</span>
                                            </span>
                                        </li>
                                        <li>
                                            <a href="#" class="item_remove"><i class="fa-regular fa-circle-xmark"></i></a>
                                            <a href="#"><img src="assets/images/item10.jpg" alt="cart_thumb2" />Ornare sed consequat</a>
                                            <span class="cart_quantity">1 x <span class="cart_amount">
                                                    <span class="price_symbole">₹</span>81.00</span>
                                            </span>
                                        </li>
                                    </ul>
                                    <div class="cart_footer">
                                        <p class="cart_total">
                                            <strong>Subtotal:</strong>
                                            <span class="cart_price"><span class="price_symbole">₹</span>159.00</span>
                                        </p>
                                        <p class="cart_buttons">
                                            <a href="cart.php" class="btn btn-fill-line view-cart">View Cart</a>
                                            <a href="checkout.php" class="btn btn-fill-out checkout">Checkout</a>
                                        </p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="d-flex align-items-center">
                            <div class="pr_search_icon">
                                <a href="javascript:;" class="nav-link pr_search_trigger" id="searchToggle">
                                    <i class="fa-solid fa-magnifying-glass " id="searchIcon"></i>
                                </a>
                            </div>
                            <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-expanded="false">
                                <span><i class="fa-solid fa-bars"></i></span>
                            </button> -->
                            <div class="categories_wrap">
                        <button
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#navCatContent"
                            aria-expanded="false"
                            class="categories_btn-header">
                            <i class="fa-solid fa-bars"></i><span></span>
                        </button>
                        <div id="navCatContent" class="nav_cat navbar nav collapse">
                            <ul>
                                <li class="dropdown dropdown-mega-menu">
                                    <a
                                        class="dropdown-item nav-link dropdown-toggler"
                                        href="electrical.php"
                                        data-bs-toggle="dropdown"><img src="./assets/images/flaticons/plugin.png" alt="electrical" /><span class="ps-3">Electrical</span></a>
                                    <div class="dropdown-menu">
                                        <ul class="mega-menu d-lg-flex">
                                            <li class="mega-menu-col col-lg-7">
                                                <ul class="d-lg-flex">
                                                    <li class="mega-menu-col col-lg-6">
                                                        <ul>
                                                            <!-- <li class="dropdown-header">Featured Item</li> -->
                                                            <li>
                                                                <a
                                                                    class="dropdown-item nav-link nav_item"
                                                                    href="electrical.php">Submenu-1</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    class="dropdown-item nav-link nav_item"
                                                                    href="category.php">Submenu-2</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    class="dropdown-item nav-link nav_item"
                                                                    href="#">Submenu-3</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    class="dropdown-item nav-link nav_item"
                                                                    href="#">Submenu-4</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    class="dropdown-item nav-link nav_item"
                                                                    href="#">Submenu-5</a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li class="mega-menu-col col-lg-6">
                                                        <ul>
                                                            <!-- <li class="dropdown-header">Popular Item</li> -->
                                                            <li>
                                                                <a
                                                                    class="dropdown-item nav-link nav_item"
                                                                    href="#">Submenu-1</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    class="dropdown-item nav-link nav_item"
                                                                    href="#">Submenu-2</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    class="dropdown-item nav-link nav_item"
                                                                    href="#">Submenu-3</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    class="dropdown-item nav-link nav_item"
                                                                    href="#">Submenu-4</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    class="dropdown-item nav-link nav_item"
                                                                    href="#">Submenu-5</a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="mega-menu-col col-lg-5">
                                                <div class="header-banner2">
                                                    <img
                                                        src="assets/images/menu_banner7.jpg"
                                                        alt="menu_banner" />
                                                    <div class="banne_info">
                                                        <h6>20% Off</h6>
                                                        <h4>Electricals</h4>
                                                        <a href="#">Shop now</a>
                                                    </div>
                                                </div>
                                                <div class="header-banner2">
                                                    <img
                                                        src="assets/images/menu_banner8.jpg"
                                                        alt="menu_banner" />
                                                    <div class="banne_info">
                                                        <h6>15% Off</h6>
                                                        <h4>Electric Items</h4>
                                                        <a href="#">Shop now</a>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="dropdown dropdown-mega-menu">
                                    <a
                                        class="dropdown-item nav-link dropdown-toggler"
                                        href="#"
                                        data-bs-toggle="dropdown"><img src="./assets/images/flaticons/responsive.png" alt="electrical" />
                                        <span class="ps-3">Electronics</span></a>
                                    <div class="dropdown-menu">
                                        <ul class="mega-menu d-lg-flex">
                                            <li class="mega-menu-col col-lg-7">
                                                <ul class="d-lg-flex">
                                                    <li class="mega-menu-col col-lg-6">
                                                        <ul>
                                                            <li class="dropdown-header">Featured Item</li>
                                                            <li>
                                                                <a
                                                                    class="dropdown-item nav-link nav_item"
                                                                    href="#">Submenu-1</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    class="dropdown-item nav-link nav_item"
                                                                    href="#">Submenu-2</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    class="dropdown-item nav-link nav_item"
                                                                    href="#">Submenu-3</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    class="dropdown-item nav-link nav_item"
                                                                    href="#">Submenu-4</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    class="dropdown-item nav-link nav_item"
                                                                    href="#">Submenu-5</a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li class="mega-menu-col col-lg-6">
                                                        <ul>
                                                            <li class="dropdown-header">Popular Item</li>
                                                            <li>
                                                                <a
                                                                    class="dropdown-item nav-link nav_item"
                                                                    href="#">Submenu-1</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    class="dropdown-item nav-link nav_item"
                                                                    href="#">Submenu-2</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    class="dropdown-item nav-link nav_item"
                                                                    href="#">Submenu-3</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    class="dropdown-item nav-link nav_item"
                                                                    href="#">Submenu-4</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    class="dropdown-item nav-link nav_item"
                                                                    href="#">Submenu-5</a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="mega-menu-col col-lg-5">
                                                <div class="header-banner2">
                                                    <a href="#"><img
                                                            src="assets/images/menu_banner6.jpg"
                                                            alt="menu_banner" /></a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="dropdown dropdown-mega-menu">
                                    <a
                                        class="dropdown-item nav-link dropdown-toggler"
                                        href="#"
                                        data-bs-toggle="dropdown"><img src="./assets/images/flaticons/jewellery.png" alt="electrical" />
                                        <span class="ps-3">Fashion Jewellery</span></a>
                                    <div class="dropdown-menu">
                                        <ul class="mega-menu d-lg-flex">
                                            <li class="mega-menu-col col-lg-12">
                                                <ul class="d-lg-flex">
                                                    <li class="mega-menu-col col-lg-6">
                                                        <ul>
                                                            <li class="dropdown-header">Featured Item</li>
                                                            <li>
                                                                <a
                                                                    class="dropdown-item nav-link nav_item"
                                                                    href="#">Submenu-1</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    class="dropdown-item nav-link nav_item"
                                                                    href="#">Submenu-2</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    class="dropdown-item nav-link nav_item"
                                                                    href="#">Submenu-3</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    class="dropdown-item nav-link nav_item"
                                                                    href="#">Submenu-4</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    class="dropdown-item nav-link nav_item"
                                                                    href="#">Submenu-5</a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li class="mega-menu-col col-lg-6">
                                                        <ul>
                                                            <li class="dropdown-header">Popular Item</li>
                                                            <li>
                                                                <a
                                                                    class="dropdown-item nav-link nav_item"
                                                                    href="#">Submenu-1</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    class="dropdown-item nav-link nav_item"
                                                                    href="#">Submenu-2</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    class="dropdown-item nav-link nav_item"
                                                                    href="#">Submenu-3</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    class="dropdown-item nav-link nav_item"
                                                                    href="#">Submenu-4</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    class="dropdown-item nav-link nav_item"
                                                                    href="#">Submenu-5</a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="dropdown dropdown-mega-menu">
                                    <a
                                        class="dropdown-item nav-link dropdown-toggler"
                                        href="#"
                                        data-bs-toggle="dropdown"><img src="assets/images/flaticons/furnitures.png" alt="furniture" />
                                        <span class="ps-3">Furniture</span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul class="mega-menu d-lg-flex">
                                            <li class="mega-menu-col col-lg-12">
                                                <ul class="d-lg-flex">
                                                    <li class="mega-menu-col col-lg-6">
                                                        <ul>
                                                            <li class="dropdown-header">Featured Item</li>
                                                            <li>
                                                                <a
                                                                    class="dropdown-item nav-link nav_item"
                                                                    href="#">Submenu-1</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    class="dropdown-item nav-link nav_item"
                                                                    href="#">Submenu-2</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    class="dropdown-item nav-link nav_item"
                                                                    href="#">Submenu-3</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    class="dropdown-item nav-link nav_item"
                                                                    href="#">Submenu-4</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    class="dropdown-item nav-link nav_item"
                                                                    href="#">Submenu-5</a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li class="mega-menu-col col-lg-6">
                                                        <ul>
                                                            <li class="dropdown-header">Popular Item</li>
                                                            <li>
                                                                <a
                                                                    class="dropdown-item nav-link nav_item"
                                                                    href="#">Submenu-1</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    class="dropdown-item nav-link nav_item"
                                                                    href="#">Submenu-2</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    class="dropdown-item nav-link nav_item"
                                                                    href="#">Submenu-3</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    class="dropdown-item nav-link nav_item"
                                                                    href="#">Submenu-4</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    class="dropdown-item nav-link nav_item"
                                                                    href="#">Submenu-5</a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li>
                                    <a class="dropdown-item nav-link nav_item" href="#"><img src="assets/images/flaticons/gift.png" alt="gift items" />
                                        <span class="ps-3">Gift items</span></a>
                                </li>
                                <li>
                                    <a class="dropdown-item nav-link nav_item" href="#"><img src="assets/images/flaticons/patient.png" alt="Health and personal care" />
                                        <span class="ps-3">Health and personal care</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item nav-link nav_item" href="#"><img src="assets/images/flaticons/kitchen.png" alt="Home And Kitchen" />
                                        <span class="ps-3">Home And Kitchen</span></a>
                                </li>
                                <li>
                                    <a class="dropdown-item nav-link nav_item" href="#"><img src="assets/images/flaticons/configuration.png" alt="Hardware products" />
                                        <span class="ps-3">Hardware products</span></a>
                                </li>
                                <li>
                                    <a class="dropdown-item nav-link nav_item" href="#"><img src="assets/images/flaticons/pet-supplies.png" alt="Pet supplies" />
                                        <span class="ps-3">Pet supplies</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item nav-link nav_item" href="#"><img src="assets/images/flaticons/stationary.png" alt="Stationery" />
                                        <span class="ps-3">Stationery</span>
                                    </a>
                                </li>
                                <li>
                                    <ul class="more_slide_open">
                                        <li>
                                            <a class="dropdown-item nav-link nav_item" href="#"><img src="assets/images/flaticons/dumbbell.png" alt="Sports and fitness" />
                                                <span class="ps-3">Sports and fitness</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item nav-link nav_item" href="#"><img src="assets/images/flaticons/console.png" alt="Toys and Game" />
                                                <span class="ps-3">Toys and Games</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item nav-link nav_item" href="#"><img src="assets/images/flaticons/wristwatch.png" alt="Watches" />
                                                <span class="ps-3">Watches</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <div class="more_categories">More Categories</div>
                        </div>
                    </div>

                        </div>
                    </div>


               
                </nav>

            </div>

        </div>
    </header>
    <!-- END HEADER -->