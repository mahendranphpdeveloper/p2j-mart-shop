@extends('layouts/adminLogin')

@section('title', 'Login')

<!-- @section('page-style')

<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection -->
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;900&display=swap');

    input {
        caret-color: red;
    }

    body {
        margin: 0;
        width: 100vw;
        height: 100vh;
        background: #ecf0f3;
        display: flex;
        align-items: center;
        
        justify-content: center;
        place-items: center;
        overflow: hidden;
        font-family: poppins;
    }

    .container {
        position: relative;
        width: 350px;
        height: 500px;
        z-index: 9999;
        border-radius: 20px;
        padding: 40px;
        box-sizing: border-box;
        background: #ecf0f3;
        box-shadow: 14px 14px 20px #cbced1, -14px -14px 20px white;
    }

    .brand-logo {
        height: 100px;
        width: 100px;
        background: url("{{ asset('uploads/applogo/newlogo.png') }}") no-repeat center center;
        background-size: cover;
        margin: auto;
        border-radius: 50%;
        box-sizing: border-box;
        box-shadow: 7px 7px 10px #cbced1, -7px -7px 10px white;
    }

    .brand-title {
        margin-top: 10px;
        font-weight: 900;
        text-align: center;
        font-size: 1.8rem;
        color: #1DA1F2;
        letter-spacing: 1px;
    }

    .inputs {
        text-align: left;
        margin-top: 30px;
    }

    label,
    input,
    button {
        display: block;
        width: 100%;
        padding: 0;
        border: none;
        outline: none;
        box-sizing: border-box;
    }

    label {
        margin-bottom: 4px;
    }

    label:nth-of-type(2) {
        margin-top: 12px;
    }

    input::placeholder {
        color: gray;
    }

    input {
        background: #ecf0f3;
        padding: 10px;
        padding-left: 20px;
        height: 50px;
        font-size: 14px;
        border-radius: 50px;
        box-shadow: inset 6px 6px 6px #cbced1, inset -6px -6px 6px white;
    }

    button {
        color: white;
        margin-top: 20px;
        background: #1DA1F2;
        height: 40px;
        border-radius: 20px;
        cursor: pointer;
        font-weight: 900;
        box-shadow: 6px 6px 6px #cbced1, -6px -6px 6px white;
        transition: 0.5s;
    }

    button:hover {
        box-shadow: none;
    }

    a {
        position: absolute;
        font-size: 8px;
        bottom: 4px;
        right: 4px;
        text-decoration: none;
        color: black;
        background: yellow;
        border-radius: 10px;
        padding: 2px;
    }

    h1 {
        position: absolute;
        top: 0;
        left: 0;
    }
    .authentication-wrapper.authentication-basic .authentication-inner:after {
    bottom: -71px !important;
    content: " ";
    height: 240px;
    left: -97px !important;
    position: absolute;
    width: 243px;
}
</style>

@section('layoutContent')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
          
         
                        <!-- Logo -->
                     
                        <!-- /Logo -->

                        <form id="formAuthentication" class="mb-3" action="{{ route('check-login') }}" method="POST">
                            @csrf


                            <div class="container">
                                <div class="brand-logo"></div>
                                <div class="brand-title">P2j MART</div>
                                <div class="inputs">
                                    <label>EMAIL</label>

                                    <input type="text" placeholder="example@test.com" id="email" name="email"
                                        placeholder="Enter your username" value="{{ old('email') }}" required autofocus>
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <label>PASSWORD</label>
                                    <input type="password" class="mb-4"  id="password" name="password" placeholder="············"
                                        required>
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <div style="display: flex; justify-content: center; align-items: center; ">
                                        <button type="submit"  style="border-radius: 16px; width: 120px; ">LOGIN</button>
                                    </div>
                                </div>
                             
                            </div>

                        </form>

                 
            </div>
            <!-- /Register -->
        </div>
    </div>
    </div>
@endsection

@if (session('error'))
    <div aria-live="polite" aria-atomic="true" class="position-relative" id="toast-container" style="display:none;">
        <div class="toast-container top-0 end-0 p-3">
            <div class="bs-toast toast show bg-danger" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <i class='bx bx-bell me-2'></i>
                    <div class="me-auto fw-medium">Message</div>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    {{ session('error') }}
                </div>
            </div>
        </div>
    </div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function () {

        var toastContainer = document.getElementById('toast-container');
        if (toastContainer) {
            toastContainer.style.display = 'block';
            var toastElement = toastContainer.querySelector('.toast');
            var toast = new bootstrap.Toast(toastElement);
            toast.show();
        }
    });
</script>