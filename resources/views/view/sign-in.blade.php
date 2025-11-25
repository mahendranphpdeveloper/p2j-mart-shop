@extends('layouts.home')
@section('content')

<!-- START SECTION BREADCRUMB -->
<div class=" bg-white page-title-mini py-3">
    <div class="container"><!-- STRART CONTAINER -->
        <div class="row align-items-center">
            <div class="col-12">
                <ol class="breadcrumb justify-content-md-end">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Sign in</li>
                </ol>
            </div>
        </div>
    </div><!-- END CONTAINER-->
</div>
<!-- END SECTION BREADCRUMB -->


<!-- START MAIN CONTENT -->
<div class="main_content">

    <!-- START LOGIN SECTION -->
    <div class="login_register_wrap section py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-md-10">
                    <div class="login_wrap">
                        <div class="padding_eight_all bg-white">
                            <div class="heading_s1">
                                <h3>Login</h3>
                            </div>
                            <form method="post">
                                <div class="form-group mb-3">
                                    <input type="text" required="" class="form-control" name="email" placeholder="Your Email">
                                </div>
                                <div class="form-group mb-3">
                                    <input class="form-control" required="" type="password" name="password" placeholder="Password">
                                </div>
                                <div class="login_footer form-group mb-3">
                                    <div class="chek-form">
                                        <div class="custome-checkbox">
                                            <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox1" value="">
                                            <label class="form-check-label" for="exampleCheckbox1"><span>Remember me</span></label>
                                        </div>
                                    </div>
                                    <a href="#">Forgot password?</a>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="d-flex justify-content-center w-100">
                                    <button type="submit" class="btn btn-fill-out btn-block" name="login">Log in</button>
                                    </div>
                                   
                                </div>
                            </form>
                            <div class="different_login">
                                <span> or</span>
                            </div>
                            <ul class="btn-login list_none text-center">
                                <!-- <li><a href="#" class="btn btn-facebook"><i class="fa-brands fa-facebook-f"></i> Facebook</a></li> -->
                                <li><a href="#" class="btn btn-google"><i class="fa-brands fa-google"></i> Google</a></li>
                            </ul>

                            <div class="form-note text-center">Don't Have an Account? <a href="signup.php">Sign up now</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END LOGIN SECTION -->

</div>
<!-- END MAIN CONTENT -->


