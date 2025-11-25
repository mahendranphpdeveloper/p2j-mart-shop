@extends('layouts.home')
@section('content')


<div class=" bg-white page-title-mini py-3">
    <div class="container"><!-- STRART CONTAINER -->
        <div class="row align-items-center">
            <div class="col-12">
                <ol class="breadcrumb justify-content-md-end">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Pages</a></li>
                    <li class="breadcrumb-item active">Checkout Page</li>
                </ol>
            </div>
        </div>
    </div><!-- END CONTAINER-->
</div>
<!-- END SECTION BREADCRUMB -->

<section class="gi-checkout-section">
    <div class="custom-container1">
        <div class="row">

            <div class="col-lg-8">
                <div class="gi-checkout-wrap">
                    <div class="gi-checkout-block">
                        <div class="tab-container">
                            <div class="tab-label active" data-tab="current">
                                <i class="fas fa-home"></i>
                                <span>Current Address</span>
                            </div>
                            <div class="tab-label" data-tab="new">
                                <i class="fas fa-plus-circle"></i>
                                <span>Add New Address</span>
                            </div>
                        </div>

                        <!-- Existing Address -->
                        <div id="existing-addresses">
                            <div class="gi-existing-address">
                                <input type="radio" id="address1" class="mt-2" name="address" checked>
                                <label for="address1">
                                    <div class="gi-address-details">
                                        <p class="mb-1"><strong>John Doe</strong></p>
                                        <p class="mb-1">123 Main Street, Cityville, State 12345</p>
                                        <p class="mb-1">Country: USA</p>
                                        <p class="mb-1">Phone: +1 234 567 890</p>
                                    </div>
                                </label>
                            </div>

                            <div class="gi-check-order-btn">
                            <a class="btn btn-fill-out" href="#">Place Order</a>
                        </div>
                        </div>

                        <!-- New Address Form -->
                        <div id="new-address-form" style="display: none;">
                            <form id="address-form">

                                <!-- First Name & Last Name in One Row -->
                                <div class="row">
                                    <div class="col-md-6 gi-bill-wrap">
                                        <label>First Name*</label>
                                        <input type="text" name="firstname" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 gi-bill-wrap">
                                        <label>Last Name*</label>
                                        <input type="text" name="lastname" class="form-control" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="gi-bill-wrap">
                                            <label>Phone Number*</label>
                                            <div class="input-group">
                                                <input id="phone" type="tel" name="phone" class="form-control"
                                                 placeholder="Enter phone number" required style="width: 360px;">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <label>Email*</label>
                                        <input type="email" name="lastname" class="form-control" required>
                                    </div>
                                </div>

                                <!-- Phone Number with Country Code -->



                                <!-- Address -->
                                <div class="gi-bill-wrap">
                                    <label>Address*</label>
                                    <input type="text" name="address" class="form-control" required>
                                </div>

                                <!-- City & State in One Row -->
                                <div class="row">
                                    <div class="col-md-6 gi-bill-wrap">
                                        <label>City*</label>
                                        <input type="text" name="city" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 gi-bill-wrap">
                                        <label>State*</label>
                                        <input type="text" name="state" class="form-control">
                                    </div>
                                </div>

                                <!-- Post Code -->
                                <div class="row">
                                    <div class="col-md-6 gi-bill-wrap">
                                        <label>Country*</label>
                                        <input type="text" name="city" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 gi-bill-wrap">
                                        <label>Post Code*</label>
                                        <input type="text" name="state" class="form-control">
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-fill-out">Add Address</button>
                            </form>
                        </div>

                        
                    </div>
                </div>
            </div>
            <!-- Sidebar Order Summary -->
            <div class="col-lg-4">
                <div class="gi-sidebar-wrap">
                    <h3 class="gi-sidebar-title">Order Summary</h3>
                    <div class="gi-checkout-summary">
                        <div>
                            <span>Sub-Total</span>
                            <span>₹80.00</span>
                        </div>
                        <div>
                            <span>Shipping Cost</span>
                            <span>₹80.00</span>
                        </div>
                        <div class="gi-checkout-summary-total">
                            <span>Total Amount</span>
                            <span>₹160.00</span>
                        </div>
                    </div>
                </div>

                <div class="gi-sidebar-wrap">
                    <h3 class="gi-sidebar-title">Payment Method</h3>
                    <div class="gi-check-pay-img text-center">
                        <img src="assets/images/payment.png" alt="payment" width="100%">
                    </div>
                </div>
            </div>
            <!-- Checkout Content -->
        </div>
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const existingAddresses = document.getElementById("existing-addresses");
        const newAddressForm = document.getElementById("new-address-form");
        const tabExisting = document.querySelector(".tab-label[data-tab='current']");
        const tabNew = document.querySelector(".tab-label[data-tab='new']");

        tabExisting.addEventListener("click", function() {
            existingAddresses.style.display = "block";
            newAddressForm.style.display = "none";
            tabExisting.classList.add("active");
            tabNew.classList.remove("active");
        });

        tabNew.addEventListener("click", function() {
            existingAddresses.style.display = "none";
            newAddressForm.style.display = "block";
            tabNew.classList.add("active");
            tabExisting.classList.remove("active");
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var input = document.querySelector("#phone");
        var iti = window.intlTelInput(input, {
            initialCountry: "auto", // Auto-detect country
            geoIpLookup: function(callback) {
                fetch("https://ipapi.co/json")
                    .then(response => response.json())
                    .then(data => callback(data.country_code))
                    .catch(() => callback("US"));
            },
            separateDialCode: true, // Show dial code separately
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js"
        });
    });
</script>


<?php include 'connect/footer.php' ?>