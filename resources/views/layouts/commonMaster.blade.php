@php
    use App\Models\HeaderFooter;
    $header = HeaderFooter::where('id',1)->first();
@endphp
<!DOCTYPE html>

<html class="light-style layout-menu-fixed" data-theme="theme-default" data-assets-path="{{ asset('/assets') . '/' }}"
    data-base-url="{{url('/')}}" data-framework="laravel" data-template="vertical-menu-laravel-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>@yield('title') {{ env('APP_NAME'). ' Admin' }}</title>
    <meta name="description"
        content="{{ config('variables.templateDescription') ? config('variables.templateDescription') : '' }}" />
    <meta name="keywords"
        content="{{ config('variables.templateKeyword') ? config('variables.templateKeyword') : '' }}">
    <!-- laravel CRUD token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Canonical SEO -->
    <link rel="canonical" href="{{ config('variables.productPage') ? config('variables.productPage') : '' }}">
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href=" {{ asset('uploads/applogo/logo2.png') }}" />
   
<meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Include Styles -->
    @include('layouts/sections/styles')

    <!-- Include Scripts for customizer, helper, analytics, config -->
    @include('layouts/sections/scriptsIncludes')
</head>

<style>

.btn-primary {
    background-color: #1d83c5;
    border-color: #2bb1e6;
    box-shadow: 0 .125rem .25rem 0 rgba(105, 108, 255, .4);
    color: #fcfdfd;
}
    .layout-menu{

box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
transition: all 0.3s ease;
transform: translateY(0); /* Initial position */
}
.card{

box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
transition: all 0.3s ease;

}
    .layout-navbar{

box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
transition: all 0.3s ease;
transform: translateY(0); /* Initial position */
}
</style>

<body>

    <!-- Google Tag Manager (noscript) (Default ThemeSelection: GTM-5DDHKGP, PixInvent: GTM-5J3LMKC) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5DDHKGP" height="0" width="0"
            style="display: none; visibility: hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <!-- Layout Content -->
    <div class="layout-wrapper layout-content-navbar ">
        <div class="layout-container">

            <!-- Layout page -->
            <div class="layout-page">

                <!-- BEGIN: Navbar-->
                <!-- Navbar -->
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">

                    <!--  Brand demo (display only for navbar-full and hide on below xl) -->

                     <!-- ! Not required for layout-without-menu -->
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)" id="menuToggle">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">


                        <ul class="navbar-nav flex-row align-items-center ms-auto">



                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                            <a class="nav-link dropdown-toggle hide-arrow user-icon" href="javascript:void(0);"
   data-bs-toggle="dropdown">
   <i class="fas fa-user-circle"></i>
</a>

<!-- FontAwesome CDN (if not already included) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<style>
    .user-icon i {
        font-size: 24px; /* Adjust size */
        color: #333; /* Change color */
        transition: transform 0.3s ease-in-out;
    }
    .user-icon:hover i {
        transform: scale(1.1); /* Slight zoom effect */
        color: #007bff; /* Change color on hover */
    }
    .btn-info {
    background-color: #1d83c5;
    border-color: #03c3ec;
    box-shadow: 0 .125rem .25rem 0 rgba(13, 13, 14, 0.4);
    color: #fff;
    
}
.card {
    box-shadow: 0 4px 8px rgb(29 131 197 / 22%);
    transition: all 0.3s ease;
}
</style>

                                <ul class="dropdown-menu dropdown-menu-end">
                                      @auth
                                    <li>
                                        <a class="dropdown-item" href="{{route('settings.index')}}">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">

                                                </div>
                                                 <div class="flex-grow-1">
                            <span class="fw-medium d-block">
                                {{ Auth::user()->name ?? 'User' }}
                            </span>
                            <small class="text-muted">
                                {{ Auth::user()->role ?? 'Admin' }}
                            </small>
                        </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{route('settings.index')}}">
                                            <i class="bx bx-user me-2"></i>
                                            <span class="align-middle">My Profile</span>
                                        </a>
                                    </li>

                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{route('admin-logout')}}">
                                            <i class='bx bx-log-in me-2'></i>
                                            <span class="align-middle">Logout</span>
                                        </a>
                                    </li>
                                       @endauth
                                </ul>
                            </li>
                            <!--/ User -->
                        </ul>
                    </div>

                    <!-- Search Small Screens -->
                    <div class="navbar-search-wrapper search-input-wrapper  d-none">
                        <input type="text" class="form-control search-input container-xxl border-0"
                            placeholder="Search..." aria-label="Search...">
                        <i class="bx bx-x bx-sm search-toggler cursor-pointer"></i>
                    </div>

                </nav>
                <!-- / Navbar -->
                <!-- END: Navbar-->



                <!-- Side bar  -->

                @include('layouts/commonSidebar')
                <!--/ Side bar  -->


                <!-- Layout Content -->
                @yield('layoutContent')
                <!--/ Layout Content -->



                <!-- Include Scripts -->
                @include('layouts/sections/scripts')
                
        <script>
            // Get the menu toggle button and menu element
const menuToggle = document.getElementById('menuToggle');
const menu = document.getElementById('menu');

// Add event listener to toggle menu visibility
menuToggle.addEventListener('click', function () {
    if (menu.style.display === 'none' || menu.style.display === '') {
        menu.style.display = 'block'; // Show the menu
    } else {
        menu.style.display = 'none'; // Hide the menu
    }
});



        </script>




</body>

</html>
