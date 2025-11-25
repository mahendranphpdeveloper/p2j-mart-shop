@extends('layouts.app')

@section('title', 'Enter Phone Number')

@section('content')

<style>
    /* Modern UI Variables */
    :root {
        --user-login-register-primary: #1d83c5;
        --user-login-register-primary-dark: #5512ee;
        --user-login-register-secondary: #5512ee;
        --user-login-register-light: #f8f9fa;
        --user-login-register-dark: #212529;
        --user-login-register-gray: #6c757d;
        --user-login-register-border: #e0e0e0;
        --user-login-register-success: #4cc9f0;
        --user-login-register-error: #f72585;
    }

    /* Base Styles */
    .user-login-register-body {
        font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        margin: 0;
        padding: 0;
        color: var(--user-login-register-dark);
        background-color: #f5f9ff;
    }

    .user-login-register-container {
        display: flex;
        min-height: calc(100vh - 60px);
        max-width: 1200px;
        margin: 30px auto;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    /* Image Column */
    .user-login-register-image-column {
        flex: 1;
        background: linear-gradient(135deg, var(--user-login-register-primary), var(--user-login-register-primary-dark));
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px;
        position: relative;
        overflow: hidden;
    }

    .user-login-register-image-content {
        max-width: 80%;
        text-align: center;
        color: white;
        z-index: 2;
    }

    .user-login-register-image {
        max-width: 100%;
        height: 300px;
        margin-bottom: 30px;
        object-fit: contain;
    }

    .user-login-register-image-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 15px;
        color: #fff;
    }

    .user-login-register-image-subtitle {
        font-size: 1rem;
        opacity: 0.9;
        color: #fff;
    }

    .user-login-register-image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('https://images.unsplash.com/photo-1551434678-e076c223a692?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') center/cover;
        opacity: 0.1;
    }

    /* Form Column */
    .user-login-register-form-column {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 60px;
        background-color: white;
    }

    .user-login-register-form-container {
        width: 100%;
        max-width: 400px;
    }

    /* Form Elements */
    .user-login-register-form-header {
        margin-bottom: 30px;
        text-align: center;
    }

    .user-login-register-form-title {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 10px;
        color: var(--user-login-register-dark);
    }

    .user-login-register-form-subtitle {
        color: var(--user-login-register-gray);
        font-size: 1rem;
    }

    .user-login-register-form-group {
        margin-bottom: 25px;
    }

    .user-login-register-label {
        display: block;
        margin-bottom: 10px;
        font-weight: 500;
        font-size: 0.95rem;
        color: var(--user-login-register-dark);
    }

    .user-login-register-input {
        width: 100%;
        padding: 14px 16px;
        border: 1px solid var(--user-login-register-border);
        border-radius: 8px;
        font-size: 0.95rem;
        transition: all 0.3s;
    }

    .user-login-register-input:focus {
        outline: none;
        border-color: var(--user-login-register-primary);
        box-shadow: 0 0 0 3px rgba(29, 131, 197, 0.1);
    }

    .user-login-register-input.is-invalid {
        border-color: var(--user-login-register-error);
    }

    .user-login-register-invalid-feedback {
        color: var(--user-login-register-error);
        font-size: 0.85rem;
        margin-top: 6px;
        display: block;
    }

    /* Button Styles */
    .user-login-register-btn {
        width: 100%;
        padding: 14px;
        background: linear-gradient(to right, var(--user-login-register-primary), var(--user-login-register-primary-dark));
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s;
    }

    .user-login-register-btn:hover {
        opacity: 0.95;
        transform: translateY(-1px);
        box-shadow: 0 5px 15px rgba(29, 131, 197, 0.2);
    }

    /* Link Styles */
    .user-login-register-back-link {
        display: block;
        text-align: center;
        margin-top: 20px;
        color: var(--user-login-register-primary);
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s;
    }

    .user-login-register-back-link:hover {
        color: var(--user-login-register-primary-dark);
        text-decoration: underline;
    }

    /* Error Message */
    .user-login-register-alert {
        padding: 14px 16px;
        background-color: #fff5f5;
        border: 1px solid #fed7d7;
        border-radius: 8px;
        color: var(--user-login-register-error);
        margin-bottom: 25px;
        font-size: 0.95rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .user-login-register-container {
            flex-direction: column;
            margin: 15px;
            min-height: auto;
        }
        
        .user-login-register-image-column {
            padding: 40px 20px;
            border-radius: 16px 16px 0 0;
        }
        
        .user-login-register-form-column {
            padding: 40px 20px;
            border-radius: 0 0 16px 16px;
        }
        
        .user-login-register-image {
            height: 200px;
        }
    }
</style>

<div class="user-login-register-body">
    <div class="user-login-register-container">
        <!-- Image Column -->
        <div class="user-login-register-image-column">
            <div class="user-login-register-image-overlay"></div>
            <div class="user-login-register-image-content">
                <img src="https://cdn-icons-png.flaticon.com/512/2991/2991148.png" alt="Mobile verification" class="user-login-register-image">
                <h2 class="user-login-register-image-title">Complete Your Profile</h2>
                <p class="user-login-register-image-subtitle">Just one more step to join our community</p>
            </div>
        </div>

        <!-- Form Column -->
        <div class="user-login-register-form-column">
            <div class="user-login-register-form-container">
                @if (session('error'))
                    <div class="user-login-register-alert">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="user-login-register-alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="user-login-register-form-header">
                    <h2 class="user-login-register-form-title">Phone Verification</h2>
                    <p class="user-login-register-form-subtitle">We need your phone number to complete your Google login</p>
                </div>

                <form action="{{ route('google.phone.submit') }}" method="POST" class="user-login-register-form">
                    @csrf

                    <input type="hidden" name="email" value="{{ $googleUser['email'] }}">
                    <input type="hidden" name="name" value="{{ $googleUser['name'] }}">
                    <input type="hidden" name="google_id" value="{{ $googleUser['google_id'] }}">

                    <div class="user-login-register-form-group">
                        <label for="phone" class="user-login-register-label">Phone Number</label>
                        <input 
                            type="tel" 
                            name="phone" 
                            id="phone" 
                            class="user-login-register-input @error('phone') is-invalid @enderror" 
                            value="{{ old('phone') }}" 
                            required
                            placeholder="Enter phone with country code (e.g. +1 1234567890)"
                            pattern="^\+[0-9]{1,3}[0-9]{4,14}$"
                        >
                        @error('phone')
                            <span class="user-login-register-invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="text-muted">Format: +[country code][number] (e.g. +911234567890)</small>
                    </div>

                    <button type="submit" class="user-login-register-btn">Verify Phone Number</button>
                </form>

                <a href="{{ route('login.user') }}" class="user-login-register-back-link">Back to login</a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const phoneInput = document.getElementById('phone');
    phoneInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/[^\d+]/g, '');
        if (value.startsWith('+')) {
            value = '+' + value.substring(1).replace(/\+/g, '');
        } else {
            value = value.replace(/\+/g, '');
            if (value) value = '+' + value;
        }
        e.target.value = value;
    });
});
</script>

@endsection