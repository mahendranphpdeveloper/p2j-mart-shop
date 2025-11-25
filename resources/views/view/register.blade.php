@extends('layouts.app')

@section('content')
<link rel="stylesheet" id="main_style" href="{{ asset('/home/css/style.css') }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    @if(session('error'))
        Swal.fire({
            icon: 'warning', // Warning icon
            title: 'Oops...',
            text: '{{ session('error') }}', // Display the error message
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        });
    @endif
</script>
<ul class="breadcrumb pt-5">
    <li><a href="{{ route('home') }}">Home</a></li>
 
    <li>Register Page</li>
</ul>

<!-- Breadcrumb end -->

<!-- Register section -->
<section class="gi-register padding-tb-40">
    <div class="container">
        <div class="section-title-2">
            <h2 class="gi-title">Register<span></span></h2>
            <p>Join us to explore and share inspiring Christian books, devotionals, and spiritual resources.</p>
        </div>

        <div class="row">
            <div class="gi-register-wrapper">
                <div class="gi-register-container">
                    <div class="gi-register-form">
                        <form action="{{ route('register.user') }}" method="post" id="registrationForm">
                            @csrf
                            <span class="gi-register-wrap gi-register-half">
                                <label>First Name*</label>
                                <input type="text" name="firstname" value="{{ session('google_name') ?? old('name') }}" placeholder="Enter your first name" required>
                                @error('firstname')
                                    <small style="color: red;">{{ $message }}</small>
                                @enderror
                            </span>
                        
                            <span class="gi-register-wrap gi-register-half">
                                <label>Last Name</label>
                                <input type="text" name="lastname" value="{{ old('lastname') }}" placeholder="Enter your last name">
                                @error('lastname')
                                    <small style="color: red;">{{ $message }}</small>
                                @enderror
                            </span>
                        
                            <span class="gi-register-wrap gi-register-half">
                                <label>Email*</label>
                                <input type="email" name="email" value="{{ session('google_email') ?? old('email') }}" placeholder="Enter your email" required>
                                @error('email')
                                    <small style="color: red;">{{ $message }}</small>
                                @enderror
                            </span>
                        
                            <span class="gi-register-wrap gi-register-half">
                                <label>Phone Number*</label>
                                <input type="text" name="phonenumber" value="{{ old('phonenumber') }}" placeholder="Enter your phone number" required>
                                @error('phonenumber')
                                    <small style="color: red;">{{ $message }}</small>
                                @enderror
                            </span>
                        
                            <span class="gi-register-wrap gi-register-half">
                                <label>City</label>
                                <input type="text" name="city" value="{{ old('city') }}" placeholder="Enter your City">
                            </span>
                        
                            <span class="gi-register-wrap gi-register-half">
                                <label>Post Code</label>
                                <input type="text" name="postalcode" value="{{ old('postalcode') }}" placeholder="Post Code">
                            </span>
                        
                            <span class="gi-register-wrap gi-register-half">
                                <label>Password*</label>
                                <div style="position: relative; display: flex; align-items: center;">
                                    <input type="password" id="password" name="password" placeholder="Enter your password" required style="padding-right: 35px; width: 100%;">
                                    <span onclick="togglePassword()" style="position: absolute; right: 10px; cursor: pointer;">
                                        <i id="eyeIcon" class="fa fa-eye"></i>
                                    </span>
                                </div>
                                @error('password')
                                    <small style="color: red;">{{ $message }}</small>
                                @enderror
                            </span>
                        
                            <span class="gi-register-wrap gi-register-half">
                                <label>Confirm Password*</label>
                                <div style="position: relative; display: flex; align-items: center;">
                                    <input type="password" id="confirm_password" name="password_confirmation" placeholder="Confirm your password" required style="padding-right: 35px; width: 100%;" onkeyup="validatePassword()">
                                    <span onclick="toggleConfirmPassword()" style="position: absolute; right: 10px; cursor: pointer;">
                                        <i id="eyeIconConfirm" class="fa fa-eye"></i>
                                    </span>
                                </div>
                                <small id="password_error" style="color: red; display: none;">Passwords do not match!</small>
                            </span>
                            
                            <span class="gi-register-wrap gi-register-btn">
                                <span>Already have an account?<a href="{{ route('login.user') }}">Login</a></span>
                                <button class="gi-btn-1" type="submit">Register</button>
                            </span>
                        </form>
                        
                        <input type="text" name="name" value="{{ old('name', session('google_name')) }}">
<input type="email" name="email" value="{{ old('email', session('google_email')) }}">
<input type="hidden" name="google_id" value="{{ old('google_id', session('google_id')) }}">

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const password = document.getElementById("password");
        const confirmPassword = document.getElementById("confirm_password");
        const errorText = document.getElementById("password_error");
        const form = document.querySelector("form");

        function validateForm(event) {
            let isValid = true;

            // Check password length
            if (password.value.length < 6) {
                errorText.style.display = "block";
                errorText.textContent = "Password must be at least 6 characters!";
                isValid = false;
            }
            // Check if passwords match
            else if (password.value !== confirmPassword.value) {
                errorText.style.display = "block";
                errorText.textContent = "Passwords do not match!";
                isValid = false;
            }
            // If everything is valid
            else {
                errorText.style.display = "none";
            }

            // Prevent form submission if validation fails
            if (!isValid) {
                event.preventDefault(); // Stop the form from submitting
            }

            return isValid;
        }

        // Attach the validation function to the form's submit event
        form.addEventListener("submit", validateForm);

        // Real-time validation as the user types
        password.addEventListener("input", function() {
            if (password.value.length < 6) {
                errorText.style.display = "block";
                errorText.textContent = "Password must be at least 6 characters!";
            } else if (password.value !== confirmPassword.value) {
                errorText.style.display = "block";
                errorText.textContent = "Passwords do not match!";
            } else {
                errorText.style.display = "none";
            }
        });

        confirmPassword.addEventListener("input", function() {
            if (password.value !== confirmPassword.value) {
                errorText.style.display = "block";
                errorText.textContent = "Passwords do not match!";
            } else {
                errorText.style.display = "none";
            }
        });
    });
</script>
<script>
    function togglePassword() {
        var passwordField = document.getElementById("password");
        var eyeIcon = document.getElementById("eyeIcon");
        
        if (passwordField.type === "password") {
            passwordField.type = "text";
            eyeIcon.classList.remove("fa-eye");
            eyeIcon.classList.add("fa-eye-slash");
        } else {
            passwordField.type = "password";
            eyeIcon.classList.remove("fa-eye-slash");
            eyeIcon.classList.add("fa-eye");
        }
    }
</script>
<script>
    function toggleConfirmPassword() {
        var confirmPasswordField = document.getElementById("confirm_password");
        var eyeIconConfirm = document.getElementById("eyeIconConfirm");
        
        if (confirmPasswordField.type === "password") {
            confirmPasswordField.type = "text";
            eyeIconConfirm.classList.remove("fa-eye");
            eyeIconConfirm.classList.add("fa-eye-slash");
        } else {
            confirmPasswordField.type = "password";
            eyeIconConfirm.classList.remove("fa-eye-slash");
            eyeIconConfirm.classList.add("fa-eye");
        }
    }

    function validatePassword() {
        var password = document.getElementById("password").value;
        var confirmPassword = document.getElementById("confirm_password").value;
        var errorText = document.getElementById("password_error");

        if (password !== confirmPassword) {
            errorText.style.display = "block";
        } else {
            errorText.style.display = "none";
        }
    }
</script>

@endsection
