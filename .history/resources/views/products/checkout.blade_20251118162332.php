@extends('layouts.app')
<style>
    /* CSS Variables for consistent theming */
:root {
  --color-primary: #007bff; /* A vibrant blue for primary actions/headers */
  --color-primary-dark: #0056b3;
  --color-primary-light: #e6f2ff; /* Light background for selected states */

  --color-success: #28a745; /* Green for success actions */
  --color-success-dark: #218838;

  --color-danger: #dc3545; /* Red for errors */
  --color-danger-light: #f8d7da;

  --color-text-dark: #343a40; /* Dark gray for main text */
  --color-text-medium: #6c757d; /* Medium gray for secondary text */
  --color-text-light: #f8f9fa; /* Light text on dark backgrounds */

  --color-background-page: #f4f7f6; /* Light background for the page */
  --color-background-card: #ffffff; /* White for cards */
  --color-background-light: #f0f2f5; /* Lighter background for subtle elements */

  --color-border-light: #e0e0e0; /* Light border for dividers */
  --color-border-medium: #ced4da; /* Medium border for inputs */
  --color-border-dark: #a0a0a0;

  --spacing-extra-small: 4px;
  --spacing-small: 8px;
  --spacing-medium: 16px;
  --spacing-large: 24px;
  --spacing-extra-large: 32px;

  --border-radius-small: 4px;
  --border-radius-medium: 8px;

  --shadow-light: 0 2px 4px rgba(0, 0, 0, 0.05);
  --shadow-medium: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Basic Reset & Body Styles */
/*body {*/
/*  margin: 0;*/
/*  font-family: "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;*/
/*  line-height: 1.6;*/
/*  color: var(--color-text-dark);*/
/*  background-color: var(--color-background-page);*/
/*  padding: var(--spacing-large);*/
/*  -webkit-font-smoothing: antialiased;*/
/*  -moz-osx-font-smoothing: grayscale;*/
/*}*/

/* Page Wrapper & Grid Layout */
.page-wrapper {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 var(--spacing-medium);
}

.checkout-grid {
  display: grid;
  grid-template-columns: 1fr; /* Single column on small screens */
  gap: var(--spacing-large);
}

@media (min-width: 768px) {
  .checkout-grid {
    grid-template-columns: 1fr 1fr; /* Two columns on larger screens */
  }
}

/* Card Styles */
.checkout-card {
  background-color: var(--color-background-card);
  border-radius: var(--border-radius-medium);
  border:1px dashed #ddd;
  overflow: hidden;
}

.checkout-header {
  padding:15px 10PX;
  border-bottom:1px solid #ddd;
}

.primary-header-bg {
     /*background-color: #f3f3f3f3;*/
  /*color: var(--color-text-light);*/
}

.card-title {
  margin: 0;
  font-size:16px; /* Slightly larger title */
  font-weight: 600;
  color:#032B45 !important;
}

.card-content {
  padding: var(--spacing-large);
}

/* Tab Buttons for Address Section */
.address-tabs {
  display: flex;
  margin-bottom: var(--spacing-large);
  border-bottom: 1px solid var(--color-border-light);
}

.tab-button {
  flex: 1;
  padding: 12px var(--spacing-medium);
  background-color: var(--color-background-light);
  border: none;
  border-bottom: 3px solid transparent;
  cursor: pointer;
  font-size: 1rem;
  font-weight: 500;
  color: var(--color-text-medium);
  transition: all 0.2s ease-in-out;
  text-align: center;
  border-top-left-radius: var(--border-radius-small);
  border-top-right-radius: var(--border-radius-small);
}

.tab-button:hover {
  background-color: var(--color-border-light);
}
.tab-button i{
    padding-left:10px;
}

.tab-button.active-tab {
  background-color: var(--color-background-card);
  border-bottom-color: var(--color-primary);
  color: var(--color-primary);
  font-weight: 600;
}

.address-section {
  display: none; /* Controlled by JavaScript */
}

.info-message {
  text-align: center;
  padding: var(--spacing-medium);
  color: var(--color-text-medium);
  font-style: italic;
  background-color: var(--color-background-light);
  border-radius: var(--border-radius-small);
  margin-top: var(--spacing-medium);
}

/* Form Group & Labels */
.form-field-group {
  margin-bottom: var(--spacing-medium);
}

.form-label {
  display: block;
  font-size: 0.9rem;
  font-weight: 500;
  color: var(--color-text-dark);
  margin-bottom: var(--spacing-small);
}

/* Form Controls (Inputs, Textareas) */
.form-input {
  display: block;
  width: 100%;
  padding: 10px 12px;
  font-size: 1rem;
  line-height: 1.5;
  color: var(--color-text-dark);
  background-color: var(--color-background-card);
  border: 1px solid var(--color-border-medium);
  border-radius: var(--border-radius-small);
  transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
  box-sizing: border-box;
}

.form-input:focus {
  border-color: var(--color-primary);
  outline: 0;
  box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25); /* Primary color with transparency */
}

/* Custom Radio Button Styling for Address Selection */
.custom-radio-input {
  position: absolute;
  opacity: 0;
  width: 0;
  height: 0;
}

.address-option-label {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: space-between;

  background-color: var(--color-background-light);
  padding: var(--spacing-medium);
  border-radius: var(--border-radius-small);
  cursor: pointer;
  transition: all 0.2s ease-in-out;
  position: relative;
  line-height: 1.1;
}

.address-option-label:hover {
  background-color: var(--color-border-light);
}

.custom-radio-input:checked + .address-option-label {
  border-color: var(--color-primary);
  background-color: var(--color-primary-light);
}

.custom-radio-input:checked + .address-option-label::after {
  content: "✓";
  position: absolute;
  top: var(--spacing-small);
  right: var(--spacing-small);
  font-size: 1.2rem;
  color: var(--color-primary);
}

/* Action Buttons */
.action-button {
  display: inline-block;
  padding: 12px 20px;
  font-size: 1rem;
  font-weight: 500;
  line-height: 1.5;
  text-align: center;
  white-space: nowrap;
  cursor: pointer;
  user-select: none;
  border: 1px solid transparent;
  border-radius: var(--border-radius-small);
  transition: all 0.2s ease-in-out;
}

.action-button.full-width {
  width: 100%;
}

/* Primary Button */
.primary-button {
  color: var(--color-text-light);
  background-color: var(--color-primary);
  border-color: var(--color-primary);
}

.primary-button:hover {
  background-color: var(--color-primary-dark);
  border-color: var(--color-primary-dark);
}

/* Success Button */
.success-button {
color:#032b45;
  background-color:#fff ;
  border-color: #032b45;
}

.success-button:hover {
  background-color:#032b45 ;
  color:#fff;
  border-color: var(--color-success-dark);
}

/* Disabled Button */
.action-button:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

/* Alert Messages */
.alert-message {
  padding: var(--spacing-medium);
  border-radius: var(--border-radius-small);
  border: 1px solid transparent;
}

.alert-danger {
  color: var(--color-danger);
  background-color: var(--color-danger-light);
  border-color: var(--color-danger);
}

.alert-message ul {
  margin: 0;
  padding-left: var(--spacing-large);
}

/* Product Item in Order Summary */
.product-summary-item {
  display: flex;
  align-items: center;
}

.product-image-container {
  width: 90px; /* Slightly smaller image */
  height: 90px;
  margin-right: var(--spacing-medium);
  flex-shrink: 0;
  border-radius: var(--border-radius-small);
  overflow: hidden;
  border: 1px solid var(--color-border-light);
}

.product-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.image-placeholder {
  width: 100%;
  height: 100%;
  background-color: var(--color-background-light);
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--color-text-medium);
  font-size: 2rem;
}

.product-name {
  font-size: 1.1rem;
  font-weight: 600;
  margin: 0 0 var(--spacing-extra-small) 0;
}

.product-meta {
  font-size: 0.9rem;
  color: var(--color-text-medium);
  margin: 0 0 var(--spacing-extra-small) 0;
}

/* Order Summary Breakdown */
.order-summary-breakdown {
  border-top: 1px solid var(--color-border-light);
  padding-top: var(--spacing-medium);
}

.summary-line {
  display: flex;
  justify-content: space-between;
  font-size: 0.95rem;
  color: var(--color-text-dark);
}

.total-line {
  font-weight: 700;
  font-size: 1.3rem;
  margin-top: var(--spacing-medium);
  padding-top: var(--spacing-small);
  border-top: 1px dashed var(--color-border-light); /* Subtle dashed line for total */
}

/* Utility Spacing Classes (minimal, for specific needs) */
.spacing-bottom-small {
  margin-bottom: var(--spacing-small);
}
.spacing-bottom-medium {
  margin-bottom: var(--spacing-medium);
}
.spacing-bottom-large {
  margin-bottom: var(--spacing-large);
}
.spacing-top-small {
  margin-top: var(--spacing-small);
}
.spacing-top-medium {
  margin-top: var(--spacing-medium);
}
.spacing-top-large {
  margin-top: var(--spacing-large);
}
.text-bold {
  font-weight: 700;
}

</style>
@section('content')
<div class="container py-5">
    <!-- Flash Messages -->
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="page-wrapper">
        <div class="checkout-grid">
            <!-- Left Column - Address Form -->
            <div class="checkout-column">
                <div class="checkout-card">
                    <div class="checkout-header primary-header-bg">
                        <h4 class="card-title">Shipping Address</h4>
                    </div>
                    <div class="card-content">
                        <div class="address-tabs">
                            <button type="button" id="tab-existing-address" class="tab-button" onclick="toggleAddressSection('existing')">Shipping Address<i class="fa-solid fa-truck-fast"></i></button>
                            <button type="button" id="tab-add-new-address" class="tab-button" onclick="toggleAddressSection('new')">Add New Address <i class="fa-regular fa-address-book"></i></button>
                        </div>

                        <div id="address-list-section" class="address-section">
                            @if($user && $addresses->isNotEmpty())
                                <!-- Address Selection Form -->
                                <form method="POST" action="{{ route('address.select') }}" id="addressSelectionForm">
                                    @csrf
                                    @foreach($addresses as $key => $address)
                                        <div class="form-field-group spacing-bottom-medium">
                                            <input type="radio" name="selected_address"
                                                   value="{{ $address->id }}" id="address-{{ $address->id }}" {{ $key === 0 ? 'checked' : '' }}
                                                   class="custom-radio-input">
                                            <label for="address-{{ $address->id }}" class="address-option-label">
                                                <strong class="text-bold">{{ $address->name }}</strong><br>
                                                {{ $address->phone }}<br>
                                                {{ $address->address_line1 }}{{ $address->address_line2 }}<br>
                                                {{ $address->city }}, {{ $address->state }} - {{ $address->zipcode }}<br>
                                                {{ $address->country }}
                                            </label>
                                        </div>
                                    @endforeach
                                    <button type="submit" class="action-button primary-button full-width spacing-bottom-medium">Use Selected Address</button>
                                </form>
                            @else
                                <p class="info-message">No addresses found. Please add a new address.</p>
                            @endif
                        </div>

                        <div id="new-address-section" class="address-section">
                            <!-- New Address Form -->
                            <form method="POST" action="{{ route('addresses.store') }}" id="newAddressForm">
                                @csrf
                                @isset($product)
                                    <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                                @endisset
                                <input type="hidden" name="session_id" value="{{ $sessionId ?? '' }}">
                                <input type="hidden" name="quantity" value="{{ $quantity ?? 1 }}">

                                <div class="form-field-group spacing-bottom-medium">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="name" class="form-input" required>
                                </div>
                                <div class="form-field-group spacing-bottom-medium">
                                    <label class="form-label">Phone</label>
                                    <input type="text" name="phone" class="form-input" required>
                                </div>
                                <div class="form-field-group spacing-bottom-medium">
                                    <label class="form-label">Address</label>
                                    <textarea name="address" class="form-input" rows="2" required></textarea>
                                </div>
                                <div class="form-field-group spacing-bottom-medium">
                                    <label class="form-label">City</label>
                                    <input type="text" name="city" class="form-input" required>
                                </div>
                                <div class="form-field-group spacing-bottom-medium">
                                    <label class="form-label">Pincode</label>
                                    <input type="text" name="pincode" class="form-input" required>
                                </div>
                                <div class="form-field-group spacing-bottom-medium">
                                    <label class="form-label">State</label>
                                    <input type="text" name="state" class="form-input" required>
                                </div>
                                <button type="submit" class="action-button primary-button full-width">
                                    Save Address
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Order Summary -->
            <div class="checkout-column">
                <div class="checkout-card">
                    <div class="checkout-header primary-header-bg">
                        <h4 class="card-title">Order Summary</h4>
                    </div>
                    <div class="card-content">
                        @if($errors->any())
                            <div class="alert-message alert-danger spacing-bottom-medium">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if($checkoutType === 'buy_now')
                            @php
                                $unit_price = $product->units->first()->unit_price ?? ($product->discount_price ?? $product->base_price);
                                $unit_id = $product->units->first()->id ?? null;
                                $resolvedAddressId = $address_id ?? session('selected_address_id');
                            @endphp
                            <form action="{{ route('place.order') }}" method="POST" id="checkoutForm">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                                <input type="hidden" name="product_unit_id" value="{{ $unit_id }}">
                                <input type="hidden" name="quantity" value="{{ $quantity }}">
                                <input type="hidden" id="order_address_id" name="address_id" value="{{ $resolvedAddressId }}">
                                <input type="hidden" name="unit_price" value="{{ $unit_price }}">
                                <input type="hidden" name="session_id" value="{{ session()->getId() }}">
                                <input type="hidden" name="checkout_type" value="buy_now">
                                <div class="product-summary-item spacing-bottom-medium">
                                    <div class="product-image-container">
                                        @if($product->images->first()?->web_image_1)
                                            <img src="{{ asset('uploads/products/' . $product->images->first()->web_image_1) }}"
                                                 alt="{{ $product->product_name }}"
                                                 class="product-image">
                                        @else
                                            <div class="image-placeholder">
                                                <span class="placeholder-icon">📦</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="product-details">
                                        <h5 class="product-name">{{ $product->product_name }}</h5>
                                        <p class="product-meta">Quantity: {{ $quantity }}</p>
                                        <p class="product-meta">Price: ₹{{ number_format($unit_price) }}</p>
                                    </div>
                                </div>
                                <div class="order-summary-breakdown spacing-top-medium">
                                    <div class="summary-line spacing-bottom-small">
                                        <span>Subtotal:</span>
                                        <span>₹{{ number_format($unit_price * $quantity) }}</span>
                                    </div>
                                   <div class="summary-line spacing-bottom-small">
                                        @if(isset($shippingCost))
                                            <span><strong>Shipping Cost:</strong></span>
                                            <span>₹{{ number_format($shippingCost, 2) }}</span>
                                        @endif
                                    </div>
                                    <div class="summary-line total-line">
                                        <span>Total:</span>
                                        <span>₹{{ number_format($unit_price * $quantity + $shippingCost, 2) }}</span>
                                    </div>
                                </div>
                                <button type="submit" class="action-button success-button full-width spacing-top-medium" id="placeOrderBtn" disabled>Place Order <i class="fa-solid fa-shop"></i></button>
                            </form>
                        @else
                            @php
                                $resolvedAddressId = $address_id ?? session('selected_address_id');

                            @endphp
                            <form action="{{ route('place.order') }}" method="POST" id="cartCheckoutForm">
                                @csrf
                                <input type="hidden" id="cart_address_id" name="address_id" value="{{ $resolvedAddressId }}">
                                <input type="hidden" name="session_id" value="{{ session()->getId() }}">
                                <input type="hidden" name="checkout_type" value="cart">
                                @foreach($cartItems as $item)
                                    <div class="product-summary-item spacing-bottom-medium">
                                        <div class="product-image-container">
                                            @if($item->productUnit->productimage->web_image_1)
                                                <img src="{{ asset('uploads/products/' . $item->productUnit->productimage->web_image_1) }}"
                                                     alt="{{ $item->product->product_name }}"  class="product-image">
                                            @else
                                                <div class="image-placeholder">
                                                    <span class="placeholder-icon">📦</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="product-details">
                                            <h5 class="product-name">{{ $item->product->product_name }}</h5>
                                            <p class="product-meta">Quantity: {{ $item->quantity }}</p>
                                            <p class="product-meta">Price: ₹{{ number_format($item->price) }}</p>
                                            <input type="hidden" name="products[{{ $item->product_unit_id }}][product_id]" value="{{ $item->product_id }}">
                                            <input type="hidden" name="products[{{ $item->product_unit_id }}][product_unit_id]" value="{{ $item->product_unit_id }}">
                                            <input type="hidden" name="products[{{ $item->product_unit_id }}][quantity]" value="{{ $item->quantity }}">
                                            <input type="hidden" name="products[{{ $item->product_unit_id }}][price]" value="{{ $item->price }}">
                                        </div>
                                    </div>
                                @endforeach
                                @php
                                    $subtotal = $cartItems->sum(fn($item) => $item->price * $item->quantity);
                                @endphp
                                <div class="order-summary-breakdown spacing-top-medium">
                                    <div class="summary-line spacing-bottom-small">
                                        <span><i class="fa-solid fa-money-check"></i> Subtotal:</span>
                                        <span>₹{{ number_format($subtotal) }}</span>
                                    </div>
                                    <div class="summary-line spacing-bottom-small">
                                        @if(isset($shippingCost))
                                            <span><strong><i class="fa-solid fa-truck-fast"></i> Shipping Cost:</strong></span>
                                            <span>₹{{ number_format($shippingCost, 2) }}</span>
                                        @endif
                                    </div>
                                    <div class="summary-line total-line">
                                        <span>Total:</span>
                                        <span>
                                            @if($resolvedAddressId)
                                                ₹{{ number_format($subtotal + $shippingCost, 2) }}
                                            @else
                                                ₹{{ number_format($subtotal) }} + shipping
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <button type="submit" class="action-button success-button full-width spacing-top-medium" id="cartPlaceOrderBtn" disabled>Place Order <i class="fa-solid fa-cart-shopping"></i></button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
        function toggleAddressSection(section) {
            const existingSection = document.getElementById('address-list-section');
            const newSection = document.getElementById('new-address-section');
            const tabExisting = document.getElementById('tab-existing-address');
            const tabNew = document.getElementById('tab-add-new-address');

            if (section === 'existing') {
                existingSection.style.display = 'block';
                newSection.style.display = 'none';
                tabExisting.classList.add('active-tab');
                tabNew.classList.remove('active-tab');
            } else if (section === 'new') {
                existingSection.style.display = 'none';
                newSection.style.display = 'block';
                tabExisting.classList.remove('active-tab');
                tabNew.classList.add('active-tab');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const hasAddresses = {{ $addresses->isNotEmpty() ? 'true' : 'false' }};
            const urlParams = new URLSearchParams(window.location.search);
            const showNewAddressFormFlag = urlParams.get('show_new_address_form');

            if (showNewAddressFormFlag === 'true') {
                toggleAddressSection('new');
            } else if (hasAddresses) {
                toggleAddressSection('existing');
            } else {
                toggleAddressSection('new'); // Default to showing new address form if no addresses
            }
        });
    </script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM fully loaded');

        const checkoutForm = document.getElementById('checkoutForm');
        const cartCheckoutForm = document.getElementById('cartCheckoutForm');
      

        if (checkoutForm) {
            console.log('checkoutForm found');
            checkoutForm.addEventListener('submit', function() {
                console.log('checkoutForm submitted');
                const submitButton = this.querySelector('button[type="submit"]');
                console.log('checkout submitButton:', submitButton);
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Processing...';
            });
        }

        if (cartCheckoutForm) {
            console.log('cartCheckoutForm found');
            cartCheckoutForm.addEventListener('submit', function() {
                console.log('cartCheckoutForm submitted');
                const submitButton = this.querySelector('button[type="submit"]');
                console.log('cart submitButton:', submitButton);
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Processing...';
            });
        }

        const successAlert = document.querySelector('.alert-success');
        console.log('successAlert:', successAlert);
        if (successAlert) {
            setTimeout(() => {
                console.log('Hiding success alert after 3 seconds');
                successAlert.classList.remove('show');
            }, 3000);
        }

        const addressSelectionForm = document.getElementById('addressSelectionForm');
        const newAddressForm = document.getElementById('newAddressForm');
        const placeOrderBtn = document.getElementById('placeOrderBtn');
        const cartPlaceOrderBtn = document.getElementById('cartPlaceOrderBtn');
        const orderAddressId = document.getElementById('order_address_id');
        const cartAddressId = document.getElementById('cart_address_id');

        console.log('Forms and buttons:', {
            addressSelectionForm, newAddressForm, placeOrderBtn, cartPlaceOrderBtn, orderAddressId, cartAddressId
        });

        if (addressSelectionForm) {
            console.log('addressSelectionForm found');
            addressSelectionForm.addEventListener('submit', function(e) {
                e.preventDefault();
                console.log('addressSelectionForm submitted');

                const selectedAddress = document.querySelector('input[name="selected_address"]:checked')?.value;
                console.log('Selected address:', selectedAddress);

                if (orderAddressId) orderAddressId.value = selectedAddress;
                if (cartAddressId) cartAddressId.value = selectedAddress;

                if (placeOrderBtn) placeOrderBtn.disabled = false;
                if (cartPlaceOrderBtn) cartPlaceOrderBtn.disabled = false;

                fetch(this.action, {
                    method: 'POST',
                    body: new FormData(this),
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                }).then(response => {
                    console.log('Address selection response:', response);
                    if (response.ok) {
                        return response.json();
                    }
                    throw new Error('Network response was not ok.');
                }).then(data => {
                    console.log('Address selection data:', data);
                    if (data.success) {
                        const alertDiv = document.createElement('div');
                        alertDiv.className = 'alert alert-success alert-dismissible fade show';
                        alertDiv.setAttribute('role', 'alert');
                        alertDiv.innerHTML = `
                            Address selected successfully!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        `;
                        this.parentNode.insertBefore(alertDiv, this.nextSibling);

                        setTimeout(() => {
                            console.log('Auto-dismiss selected address success alert');
                            alertDiv.classList.remove('show');
                        }, 3000);
                    }
                }).catch(error => {
                    console.error('Address selection error:', error);
                });
            });
        }

        if (newAddressForm) {
            console.log('newAddressForm found');
            newAddressForm.addEventListener('submit', function(e) {
                e.preventDefault();
                console.log('newAddressForm submitted');

                // Remove any existing alerts to prevent duplicates
                const existingAlert = newAddressForm.parentNode.querySelector('.alert');
                if (existingAlert) {
                    existingAlert.remove();
                }

                // Disable the submit button to prevent multiple submissions
                const submitButton = newAddressForm.querySelector('button[type="submit"]');
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Saving...';

                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                if (!csrfToken) {
                    console.error('CSRF token not found');
                    const errorAlert = document.createElement('div');
                    errorAlert.className = 'alert alert-danger alert-dismissible fade show';
                    errorAlert.setAttribute('role', 'alert');
                    errorAlert.innerHTML = `
                        CSRF token not found. Please refresh the page and try again.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    `;
                    newAddressForm.parentNode.insertBefore(errorAlert, newAddressForm);
                    submitButton.disabled = false;
                    submitButton.innerHTML = '<i class="fas fa-save me-2"></i>Save Address';
                    return;
                }

                fetch(this.action, {
                    method: 'POST',
                    body: new FormData(this),
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json' // Ensure server knows we expect JSON
                    }
                })
                    .then(response => {
                        console.log('New address response:', response);
                        if (!response.ok) {
                            if (response.status === 422) {
                                return response.json().then(data => {
                                    throw new Error(JSON.stringify(data.errors));
                                });
                            }
                            throw new Error('Network response was not ok: ' + response.statusText);
                        }
                        return response.json();
                        window.reload
                    })
                    .then(data => {
                        console.log('New address data:', data);
                        if (data.success && data.address_id) {
                            // Update address ID in checkout forms
                            if (orderAddressId) orderAddressId.value = data.address_id;
                            if (cartAddressId) cartAddressId.value = data.address_id;

                            // Enable place order buttons
                            if (placeOrderBtn) placeOrderBtn.disabled = false;
                            if (cartPlaceOrderBtn) cartPlaceOrderBtn.disabled = false;

                            // Create and display success alert
                            const alertDiv = document.createElement('div');
                            alertDiv.className = 'alert alert-success alert-dismissible fade show';
                            alertDiv.setAttribute('role', 'alert');
                            alertDiv.innerHTML = `
                                ${data.message || 'Address saved successfully!'}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            `;
                            newAddressForm.parentNode.insertBefore(alertDiv, newAddressForm);

                            // Auto-dismiss after 3 seconds
                            setTimeout(() => {
                                console.log('Auto-dismiss new address success alert');
                                alertDiv.classList.remove('show');
                                setTimeout(() => alertDiv.remove(), 500); // Remove after fade-out animation
                            }, 3000);

                            // Reset the form
                            newAddressForm.reset();

                            // Hide the form if addresses exist
                            if (document.querySelector('.address-radio')) {
                                newAddressForm.style.display = 'none';
                                console.log('Hiding newAddressForm since addresses exist');
                            }

                            // Dynamically add the new address to the selection form
                            if (addressSelectionForm && data.address) {
                                const addressContainer = addressSelectionForm.querySelector('.card.mb-3')?.parentNode;
                                if (addressContainer) {
                                    const newAddressCard = document.createElement('div');
                                    newAddressCard.className = 'card mb-3';
                                    newAddressCard.innerHTML = `
                                        <div class="card-body">
                                            <label class="d-block">
                                                <input type="radio" name="selected_address" value="${data.address_id}" class="address-radio" checked>
                                                <strong>${data.address.name}</strong><br>
                                                ${data.address.phone}<br>
                                                ${data.address.address_line1}, ${data.address.address_line2 || ''}<br>
                                                ${data.address.city}, ${data.address.state} - ${data.address.zipcode}<br>
                                                ${data.address.country}
                                            </label>
                                        </div>
                                    `;
                                    addressContainer.insertBefore(newAddressCard, addressContainer.firstChild);

                                    // Remove the oldest address if more than 3 exist
                                    const addressCards = addressContainer.querySelectorAll('.card.mb-3');
                                    if (addressCards.length > 3) {
                                        addressContainer.removeChild(addressContainer.lastChild);
                                    }
                                }
                            }
                        } else {
                            throw new Error(data.message || 'Failed to save address.');
                        }
                    })
                    .catch(error => {
                        console.error('New address error:', error);
                        let errorMessage = 'Failed to save address. Please try again.';
                        try {
                            const errors = JSON.parse(error.message);
                            errorMessage = Object.values(errors).flat().join('<br>');
                        } catch (e) {
                            errorMessage = error.message || errorMessage;
                        }

                        // Display error alert
                        const errorAlert = document.createElement('div');
                        errorAlert.className = 'alert alert-danger alert-dismissible fade show';
                        errorAlert.setAttribute('role', 'alert');
                        errorAlert.innerHTML = `
                            ${errorMessage}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        `;
                        newAddressForm.parentNode.insertBefore(errorAlert, newAddressForm);

                        // Auto-dismiss error after 5 seconds
                        setTimeout(() => {
                            errorAlert.classList.remove('show');
                            setTimeout(() => errorAlert.remove(), 500);
                        }, 5000);
                    })
                    .finally(() => {
                        // Re-enable the submit button
                        submitButton.disabled = false;
                        submitButton.innerHTML = '<i class="fas fa-save me-2"></i>Save Address';
                    });
            });
        }

        if ((orderAddressId && orderAddressId.value) || (cartAddressId && cartAddressId.value)) {
            console.log('Address ID already set');
            if (placeOrderBtn) placeOrderBtn.disabled = false;
            if (cartPlaceOrderBtn) cartPlaceOrderBtn.disabled = false;
        }
    });
</script>
@endsection