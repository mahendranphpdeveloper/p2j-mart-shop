@extends('layouts.app')

@section('content')
<!-- Font Awesome CDN -->
<link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
/>

<link rel="stylesheet" href="{{ asset('/home/css/style.css') }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
        /* Modern UI Variables */
        :root {
            --user-login-primary: #1d83c5;
            --user-login-primary-dark: #5512ee;
            --user-login-secondary: #5512ee;
            --user-login-light: #f8f9fa;
            --user-login-dark: #212529;
            --user-login-gray: #6c757d;
            --user-login-border: #e0e0e0;
            --user-login-success: #4cc9f0;
            --user-login-error: #f72585;
        }

body, *:not(i):not([class^="fa"]):not([class*=" fa-"]) {
  font-family: 'Inter', sans-serif !important;
}

        /* Base Styles */
        .user-login-body {
            /*font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;*/
            background-color: #f5f7ff;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            color: var(--user-login-dark);
        }

        .user-login-container {
            max-width: 1200px;
            width: 100%;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            display: flex;
            min-height: 600px;
        }

        /* Form Section */
  .user-login-form-section {
    padding: 30px 60px;
    width: 50%;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

        .user-login-header {
            margin-bottom: 20px;
            text-align: center;
        }

        .user-login-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 8px;
           
        }

        .user-login-subtitle {
            color: var(--user-login-gray);
            font-size: 0.9rem;
        }

        /* Social Login */
        .user-login-social-btn {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            border: 1px solid var(--user-login-border);
            background: white;
            color: var(--user-login-dark);
            transition: all 0.3s ease;
            margin-bottom: 30px;
        }

        .user-login-social-btn:hover {
            background: #f8f9fa;
            border-color: var(--user-login-primary);
        }

        .user-login-social-btn i {
            font-size: 1.2rem;
        }

        /* Divider */
        .user-login-divider {
            display: flex;
            align-items: center;
            margin: 20px 0;
            color: var(--user-login-gray);
            font-size: 0.8rem;
        }

        .user-login-divider::before,
        .user-login-divider::after {
            content: "";
            flex: 1;
            border-bottom: 1px solid var(--user-login-border);
        }

        .user-login-divider::before {
            margin-right: 10px;
        }

        .user-login-divider::after {
            margin-left: 10px;
        }

        /* Form Elements */
        .user-login-form-group {
            margin-bottom: 20px;
        }

        .user-login-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            text-align:center;
             color: var(--user-login-dark);
            font-size: 0.9rem;.
    width: 100%;
    padding: 12px;
    border-radius: 8px;
    font-weight: 500;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
  
  
    transition: all 0.3s ease;
   
}
        

        .user-login-input {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid var(--user-login-border);
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.3s;
        }

        .user-login-input:focus {
            outline: none;
            border-color: var(--user-login-primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
        }

        .user-login-submit-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(to right, var(--user-login-primary), var(--user-login-primary-dark));
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
        }

        .user-login-submit-btn:hover {
            opacity: 0.9;
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.2);
        }

        /* Image Section */
        .user-login-image-section {
            width: 50%;
          background-color: rgba(0, 0, 0, 0.1); /* Adjust opacity here */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            color: white;
            position: relative;
            overflow: hidden;
        }
.user-login-image-section::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.6); /* almost invisible layer */
  z-index: 0;
}

        .user-login-image-content {
            z-index: 2;
            text-align: center;
            max-width: 80%;
        }

        .user-login-image-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 20px;
            color:#fff;
        }

        .user-login-image-subtitle {
            font-size: 1rem;
            opacity: 0.9;
            margin-bottom: 30px;
            color:#fff;
        }

        .user-login-image-bg {
            position: absolute;
            width: 100%;
            height: 100%;
            background: url('https://images.unsplash.com/photo-1551434678-e076c223a692?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') center/cover;
            opacity: 0.1;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .user-login-container {
                flex-direction: column;
            }
            .user-login-form-section,
            .user-login-image-section {
                width: 100%;
            }
            .user-login-image-section {
                padding: 40px 20px;
                order: -1;
            }
            .user-login-form-section {
                padding: 40px;
            }
        }

        @media (max-width: 576px) {
            .user-login-form-section {
                padding: 30px 20px;
            }
        }
        .user-login-message-container {
    margin-bottom: 24px;
    animation: user-login-message-fade 0.3s ease-out;
}

.user-login-message {
    display: flex;
    align-items: center;
    padding: 14px 16px;
    background-color: #f0f7ff;
    border: 1px solid #d0e3ff;
    border-radius: 8px;
    color: #1a73e8;
    font-size: 14px;
    line-height: 1.5;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.user-login-message-icon {
    width: 20px;
    height: 20px;
    margin-right: 12px;
    flex-shrink: 0;
}

.user-login-message-content {
    flex-grow: 1;
    padding-right: 8px;
}

.user-login-message-close {
    background: none;
    border: none;
    padding: 0;
    cursor: pointer;
    color: #5f99f7;
    opacity: 0.7;
    transition: opacity 0.2s;
    display: flex;
    align-items: center;
}

.user-login-message-close:hover {
    opacity: 1;
}
.email-icon{
       color: var(--user-login-dark); 
       font-size: 1.2rem;
}
@keyframes user-login-message-fade {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
    </style>
<div class="user-login-body">
    <div class="user-login-container">
        <!-- Form Section -->
        <div class="user-login-form-section">
            <div class="user-login-header">
                <h1 class="user-login-title">Welcome Back</h1>
                <p class="user-login-subtitle">Sign in to access your account</p>
            </div>

            <!-- Google Login -->
            <a href="{{ route('login.google') }}" class="user-login-social-btn">
                <i class="fab fa-google"></i> Login  with Google
            </a>

            <div class="user-login-divider">OR</div>
      
            <!-- OTP Login Form -->
            <form method="POST" action="{{ session('otp') ? route('login.verifyOtp') : route('login.sendOtp') }}" class="user-login-form">
                @csrf

              @if(session('message'))
    <div class="user-login-message-container">
        <div class="user-login-message">
            <svg class="user-login-message-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <path d="M12 16v-4"></path>
                <path d="M12 8h.01"></path>
            </svg>
            <div class="user-login-message-content">
                {{ session('message') }}
            </div>
            <button class="user-login-message-close">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
    </div>
@endif

                <div class="user-login-form-group">
                   
                    <label for="email" class="user-login-label"> <span class="email-icon"><i class="fa-regular fa-envelope"></i></span>  Login With Email </label>
                    <input type="email" id="email" name="email" class="user-login-input" 
                           value="{{ old('email', session('email')) }}" required 
                           {{ session('otp') ? 'readonly' : '' }} 
                           placeholder="Enter your email">
                </div>

                @if(session('otp'))
                    <div class="user-login-form-group">
                        <label for="otp" class="user-login-label">Verification Code</label>
                        <input type="text" id="otp" name="otp" class="user-login-input"  value=" {{ session('otp')}}"
                               required placeholder="Enter 6-digit OTP">
                    </div>
                @endif

                <button type="submit" class="user-login-submit-btn">
                    {{ session('otp') ? 'Verify OTP' : 'Send Verification Code' }}
                </button>
            </form>
        </div>

        <!-- Image Section -->
        <div class="user-login-image-section">
            <div class="user-login-image-bg"></div>
            <div class="user-login-image-content">
                <h2 class="user-login-image-title">Secure Authentication</h2>
                <p class="user-login-image-subtitle">
                    We use industry-standard OTP verification to ensure your account stays secure
                </p>
            </div>
        </div>
    </div>

    <!-- SweetAlert Notifications -->
    <script>
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "{{ session('success') }}",
                confirmButtonColor: 'var(--user-login-primary)'
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{{ session('error') }}',
                confirmButtonColor: 'var(--user-login-primary)'
            });
        @endif

        @if($errors->any()))
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonColor: 'var(--user-login-primary)'
            });
        @endif
    </script>
</div>
@endsection
