@extends('layouts.home')
@section('content')

<!-- START SECTION BREADCRUMB -->
<div class=" bg-white page-title-mini py-3">
    <div class="container"><!-- STRART CONTAINER -->
        <div class="row align-items-center">
            <div class="col-12">
                <ol class="breadcrumb justify-content-md-end">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Sign Up</li>
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
                                <h3>Create an Account</h3>
                            </div>
                            <form method="post">
                                <div class="form-group mb-3">
                                    <input type="text" required="" class="form-control" name="name" placeholder="Enter Your Name">
                                </div>
                                <div class="form-group mb-3">
                                    <input type="text" required="" class="form-control" name="email" placeholder="Enter Your Email">
                                </div>
                                <div class="form-group mb-3">
                                    <input class="form-control" required="" type="password" name="password" placeholder="Password">
                                </div>
                                <div class="form-group mb-3">
                                    <input class="form-control" required="" type="password" name="password" placeholder="Confirm Password">
                                </div>
                                <div class="login_footer form-group mb-3">
                                    <div class="chek-form">
                                        <div class="custome-checkbox">
                                            <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox2" value="">
                                            <label class="form-check-label" for="exampleCheckbox2"><span>I agree to terms &amp; Policy.</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="d-flex justify-content-center w-100">
                                      <button type="submit" class="btn btn-fill-out btn-block" name="register">Register</button>
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
                            <div class="form-note text-center">Already have an account? <a href="sign-in.php">Log in</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END LOGIN SECTION -->

</div>
<!-- END MAIN CONTENT -->

<?php include 'connect/footer.php' ?>