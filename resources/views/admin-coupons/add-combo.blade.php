@extends('layouts.commonMaster')

@section('layoutContent')

<div class="container mt-4">

    @if(session('success'))
    <div aria-live="polite" aria-atomic="true" class="position-relative">
        <div class="toast-container top-0 end-0 p-3">
            <div class="bs-toast toast show bg-success" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <i class='bx bx-bell me-2'></i>
                    <div class="me-auto fw-medium">Message</div>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    {{ session('success') }}
                </div>
            </div>
        </div>
    </div>
    @endif
    @section('title', 'Add Combo |')
<style>
    input#totalPrice {
    background: #d9dee34f;
}
</style>
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-body">
                <div class="text-end mt-4 d-flex justify-content-between">
                    <h4 class="card-title">Add Combo</h4>
                    <div>
                        <a href="{{ route('combo.index') }}" class="btn btn-success">Back</a>
                        <button type="button" class="btn btn-primary" id="saveComboBtn" disabled>Save Combo (0)</button>
                    </div>
                </div>
                <div class="row mb-4">
                <div class="col-md-6"> 
    <label for="category">Category</label>
    <select name="category_title" id="category" class="form-control" required>
    <option value="">Select Category</option>
</select>
</div>

                    <div class="col-md-6">
                        <label for="subcategory">Subcategory</label>
                        <select name="subcategory_id" id="subcategory" class="form-control" required>
    <option value="">Select Subcategory</option>
</select>

                    </div>
                </div>

                <!-- Products Table -->
                <div class="table-responsive">
                    <table class="table table-bordered" id="productsTable">
                        <thead>
                            <tr>
                                <th>Select</th>
                                <th>Product Image</th>
                                <th>Product Name</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Products will be populated here dynamically -->
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Modal for Combo Details -->
<div class="modal fade" id="comboModal" tabindex="-1" aria-labelledby="comboModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="comboModalLabel">Combo Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="comboForm" action="{{ route('store.combo') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="comboName">Combo Name</label>
                        <input type="text" name="name" id="comboName" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="selectedProducts">Selected Products</label>
                        <ul id="selectedProductsList" class="list-group">

                        </ul>
                    </div>
                    <div class="form-group mb-1">
                        <label for="totalPrice">Total Price</label>
                        <input type="text" id="totalPrice" name="totalPrice" class="form-control" readonly>
                    </div>
                    <div class="form-group mb-1">
                        <label for="comboPrice">Offer Price</label>
                        <input type="number" name="offer_price" id="comboPrice" class="form-control" required>
                    </div>
                    <input type="hidden" name="product_ids[]" id="productIds">
                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-primary">Save Combo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $.ajax({
        url: '/get-category-titles',
        method: 'GET',
        success: function(titles) {
            titles.forEach(function(title) {
                $('#category').append(`<option value="${title}">${title}</option>`);
            });
        },
        error: function() {
            alert('Failed to load categories.');
        }
    });
});
</script>



<script>
    $(document).ready(function() {
        let selectedProducts = [];
        let totalPrice = 0;
        $('#comboForm').on('submit', function(event) {
            if (selectedProducts.length < 2) {
                alert('Please select at least 2 products to create a combo.');
                event.preventDefault(); 
            }
        });
        $('#category').change(function() {
            var categoryId = $(this).val();
            var url = `{{ route('getSubcategories', ['categoryId' => ':id']) }}`.replace(':id', categoryId);
            $.ajax({
                url: url,
                type: 'GET',
                success: function(data) {
                    $('#subcategory').empty();
                    $('#subcategory').append('<option value="">Select Subcategory</option>');
                    $.each(data, function(key, value) {
                        $('#subcategory').append('<option value="' + value.id + '">' + value.subcategory_name + '</option>');
                    });
                }
            });
        });

        // Fetch products when subcategory changes
        $('#subcategory').change(function() {
            var subcategoryId = $(this).val();
            var url = `{{ route('getProducts', ['subcategoryId' => ':id']) }}`.replace(':id', subcategoryId);
            $.ajax({
                url: url,
                type: 'GET',
                success: function(data) {
                    $('#productsTable tbody').empty();
                    $.each(data, function(key, value) {
                        // Decode the JSON images array and use the first image
                        let images = JSON.parse(value.images);
                        let firstImage = images.length > 0 ? images[0] : 'default-image.jpg'; // Fallback to a default image if no image is available

                        $('#productsTable tbody').append(`
                            <tr>
                                <td>
                                    <input type="checkbox" class="productCheckbox" value="${value.id}" data-price="${value.price}" data-name="${value.name}" data-image="${firstImage}">
                                </td>
                                <td>
                                    <img src="{{ asset('/') }}${firstImage}" alt="${value.name}" width="50" height="50">
                                </td>
                                <td>${value.name}</td>
                                <td>${value.price}</td>
                            </tr>
                        `);
                    });
                }
            });
        });

        // Handle product selection
        $(document).on('change', '.productCheckbox', function() {
            let productId = $(this).val();
            let productPrice = parseFloat($(this).data('price'));
            let productName = $(this).data('name');
            let productImage = $(this).data('image');

            if ($(this).is(':checked')) {
                selectedProducts.push({ id: productId, price: productPrice, name: productName, image: productImage });
                totalPrice += productPrice;
            } else {
                selectedProducts = selectedProducts.filter(product => product.id !== productId);
                totalPrice -= productPrice;
            }

            // Update the Save Combo button text with the count of selected products
            $('#saveComboBtn').text(`Save Combo (${selectedProducts.length})`);

            // Enable/disable Save Combo button
            if (selectedProducts.length > 0) {
                $('#saveComboBtn').prop('disabled', false);
            } else {
                $('#saveComboBtn').prop('disabled', true);
            }
        });

        // Open modal and populate selected products
        $('#saveComboBtn').click(function() {
            $('#selectedProductsList').empty();
            selectedProducts.forEach(product => {
                $('#selectedProductsList').append(`
                    <li class="list-group-item">
                        <img src="{{ asset('/') }}${product.image}" alt="${product.name}" width="50" height="50">
                        ${product.name} - Rs. ${product.price}
                    </li>
                `);
            });

            $('#totalPrice').val(totalPrice.toFixed(2));
            $('#productIds').val(selectedProducts.map(product => product.id).join(','));

            $('#comboModal').modal('show');
        });
    });
</script>

<script>
$('#category').on('change', function () {
    let categoryTitle = $(this).val();
    $('#subcategory').html('<option value="">Select Subcategory</option>');

    if (categoryTitle) {
        $.ajax({
            url: `/get-subcategories/${categoryTitle}`,
            type: 'GET',
            success: function (subcategories) {
                console.log("Loaded subcategories:", subcategories);
                subcategories.forEach(function (sub) {
                    $('#subcategory').append(`<option value="${sub.id}">${sub.title}</option>`);
                });
            },
            error: function (xhr) {
                console.error("AJAX Error:", xhr.responseText);
                alert('Failed to load subcategories.');
            }
        });
    }
});

</script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection