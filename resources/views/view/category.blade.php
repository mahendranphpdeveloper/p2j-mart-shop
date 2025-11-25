@extends('layouts.home')
@section('content')

<div class="category-banner-section"> 
    <div class="category-banner-content">
        <img src="{{ asset('images/category/banner-image-4.jpg') }}" alt="Banner Image">
    </div>
</div>


<section class="category-page">

    <!-- START SECTION BREADCRUMB -->
<div class="page-title-mini py-1">
    <div class="container-fluid"><!-- START CONTAINER -->
        <div class="row align-items-center w-100">
            <div class="col-md-6 d-flex">
                <h2 class="breadcrumb-title">All Categories</h2>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb justify-content-md-end">
                    <li class="breadcrumb-item text-white"><a href="#">Home</a></li>
                    <li class="breadcrumb-item text-white"><a href="#">Categories</a></li>
                </ol>
            </div>
        </div>
    </div><!-- END CONTAINER-->
</div>
<!-- END SECTION BREADCRUMB -->



@foreach($categories as $cat)
    <h2 class="category-title">{{ $cat->title }}</h2>

    @if($cat->subcategories->count())
        <div class="swiper-container category-swiper mb-5 position-relative">
            <div class="swiper-wrapper">
            @foreach($cat->subcategories as $sub)
    <div class="swiper-slide category-slide">
        <a href="{{ route('subcategory.products', $sub->id) }}">
            <img src="{{ asset($sub->image) }}" alt="{{ $sub->title }}" class="img-fluid">
            <p class="text-center mt-2">{{ $sub->title }}</p>
        </a>
    </div>
@endforeach

            </div>

            <!-- Swiper Navigation Buttons -->
            <div class="swiper-button-next category-button-next"></div>
            <div class="swiper-button-prev category-button-prev"></div>
        </div>
    @else
        <p class="text-muted">No subcategories found under {{ $cat->title }}.</p>
    @endif
@endforeach


</section>



<!-- Swiper JS (Ensure this is included in your page) -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var swiper = new Swiper('.category-swiper', {
            slidesPerView: 5, // Show 5 products at a time
            spaceBetween: 10,
            loop: true,
            autoplay: {
                delay: 3000, // Auto-slide every 3 seconds
                disableOnInteraction: false, // Keeps autoplay working even after manual interaction
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                1200: { slidesPerView: 6 }, // Large screens: Show 3 products
                992: { slidesPerView: 4 },  // Medium screens: Show 3 products
                768: { slidesPerView: 3 },  // Tablets: Show 2 products
                576: { slidesPerView: 2 },  // Small devices: Show 1 product
                0: { slidesPerView: 1 }     // Mobile: Show 1 product
            }
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var swiper = new Swiper('.ads-category-swiper', {
            slidesPerView: 4, // Show 3 products by default
            spaceBetween: 15,
            loop: true,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: ".category-button-next",
                prevEl: ".category-button-prev",
            },
            breakpoints: {
                1200: { slidesPerView: 4 }, // Large screens: Show 3 products
                992: { slidesPerView: 3 },  // Medium screens: Show 3 products
                768: { slidesPerView: 2 },  // Tablets: Show 2 products
                576: { slidesPerView: 1 },  // Small devices: Show 1 product
                0: { slidesPerView: 1 }     // Mobile: Show 1 product
            }
        });
    });
</script>

@endsection

