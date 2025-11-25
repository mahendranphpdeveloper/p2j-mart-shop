@extends('layouts.commonMaster')
@section('layoutContent')
    @php
        $url = url()->current();
        $url = basename($url);

    @endphp
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .img-thumbs {
            background: #eee;
            border: 1px solid #ccc;
            border-radius: 0.25rem;
            margin: 1.5rem 0;
            padding: 0.75rem;
        }

        .img-thumbs-hidden {
            display: none;
        }

        .wrapper-thumb {
            position: relative;
            display: inline-block;
            margin: 1rem 0;
            justify-content: space-around;
        }

        .img-preview-thumb {
            background: #fff;
            border: 1px solid none;
            border-radius: 0.25rem;
            box-shadow: 0.125rem 0.125rem 0.0625rem rgba(0, 0, 0, 0.12);
            margin-right: 1rem;
            max-width: 140px;
            padding: 0.25rem;
        }

        .remove-btn {
            position: absolute;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: .7rem;
            top: -5px;
            right: 10px;
            width: 20px;
            height: 20px;
            background: white;
            border-radius: 10px;
            font-weight: bold;
            cursor: pointer;
        }

        .remove-btn:hover {
            box-shadow: 0px 0px 3px grey;
            transition: all .3s ease-in-out;
        }

        .custom-table {
            font-size: 15px !important;
        }

        .custom-border {
            border: none;
            background: none;
        }

        .table-responsive-new {
            overflow-x: auto;
        }

        .table-responsive-new::-webkit-scrollbar {
            width: 12px;
            /* Adjust the width as needed */
            height: 12px;
            /* Adjust the height as needed */
            background-color: #fdf9f9;
            /* Set the background color */
        }

        .dataTables_info,
        .dataTables_paginate {
            /*float: left;*/
            display: none;
        }
    </style>
    <!-- Content wrapper -->
    <div class="content-wrapper">

        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">

            <h4 class="py-3 mb-4">
                <span class="text-muted fw-light"> </span> Product List
            </h4>

            @if(session()->has('message'))
                <div class="alert btn-danger">{{$message}}</div>
            @endif
            <!-- Product List Widget -->

            <div class="card mb-4">
                <div class="card-widget-separator-wrapper">
                    <div class="card-body card-widget-separator">
                        <div class="row gy-4 gy-sm-1">
                            <div class="col-sm-6 col-lg-4">
                                <div
                                    class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-3 pb-sm-0">
                                    <div>
                                        <h6 class="mb-2">Total Products</h6>
                                        <h4 class="mb-2">{{isset($total_count) ? $total_count : ''}}</h4>
                                    </div>
                                    <div class="avatar me-sm-4">
                                        <span class="avatar-initial rounded bg-label-secondary">
                                            <i class="bx bx-store-alt bx-sm"></i>
                                        </span>
                                    </div>
                                </div>
                                <hr class="d-none d-sm-block d-lg-none me-4">
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <div
                                    class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0">
                                    <div>
                                        <h6 class="mb-2">Active Products</h6>
                                        <h4 class="mb-2">{{isset($products_count) ? $products_count : ''}}</h4>
                                        <!-- <p class="mb-0"><span class="text-muted me-2">21k orders</span><span
                                                class="badge bg-label-success">+12.4%</span></p> -->
                                    </div>
                                    <div class="avatar me-lg-4">
                                        <span class="avatar-initial rounded bg-label-secondary">
                                            <i class="bx bx-laptop bx-sm"></i>
                                        </span>
                                    </div>
                                </div>
                                <hr class="d-none d-sm-block d-lg-none">
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <div
                                    class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                                    <div>
                                        <h6 class="mb-2">Out of Stock</h6>
                                        <h4 class="mb-2">{{isset($products_out_of_stock) ? $products_out_of_stock : ''}}</h4>
                                        <!-- <p class="mb-0 text-muted">6k orders</p> -->
                                    </div>
                                    <div class="avatar me-sm-4">
                                        <span class="avatar-initial rounded bg-label-secondary">
                                            <i class="bx bx-gift bx-sm"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-sm-6 col-lg-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-2">Affiliate</h6>
                                        <h4 class="mb-2"></h4>
                                    </div>
                                    <div class="avatar">
                                        <span class="avatar-initial rounded bg-label-secondary">
                                            <i class="bx bx-wallet bx-sm"></i>
                                        </span>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product List Table -->
            <div class="card">
                <div class="card-header">
                    <div class="d-flex">
                        <div class="card-title">Filter</div>
                        <div class="position-absolute end-0 mb-3 me-4">

                            <a href="{{route('productadd', ['subcategory_id' => $url])}}">
                                <button class=" btn btn-primary" tabindex="0" aria-controls="DataTables_Table_0"
                                    type="button">

                                    <span><i class="bx bx-plus me-0 me-sm-1"></i>Add Products</span>
                                </button>
                            </a>
                        </div>
                    </div>
                    <div class="dt-buttons">
                        <div>
                            <div class="alert alert-danger d-none" id="validationMessage">
                            </div>
                            <div>
                                <div class="alert alert-success d-none" id="successMessage">
                                </div>

                            </div>
                            <div class="d-flex justify-content-between align-items-center row py-3 gap-3 gap-md-0">
                                <div class="col-md-4 product_status"></div>
                                <div class="col-md-4 product_category"></div>
                                <div class="col-md-4 product_stock"></div>
                            </div>
                        </div>
                        <div class="card-datatable table-responsive">
                            <table class="table  theme-table table-product" id="get_products">
                                <thead>
                                    <tr>
                                        <th class="custom-table" style="width:5% important;">Sort Order</th>
                                        <th class="custom-table" style="width:5% important;">Product Name</th>
                                        <th class="custom-table" style="width:15% important;">Category</th>
                                        <!--<th class="custom-table" style="width:5% important;">BASE PRICE (M.R.P)</th>-->
                                        <!--<th class="custom-table" style="width:15% important;">Discount Price</th>-->
                                        <th class="custom-table" style="width:10% important;">Status</th>
                                        <th class="custom-table" style="width:10% important;">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @php $i = 0 @endphp
                                    @foreach($products as $product)
                                        <tr>
                                            <td style="width:5% important;">{{++$i}}</th>
                                            <td class="custom-table" style="width:5% important;">{{$product->product_name}}</td>
                                            <td class="custom-table" style="width:15% important;">{{$product->name}}</td>
                                            <!--<td class="custom-table" style="width:5% important;">{{$product->web_price}}.00</td>-->
                                            <!--<td class="custom-table" style="width:15% important;">{{$product->web_discount_price}}.00</td>-->
                                            <td class="custom-table" style="width:10% important;"><span
                                                    class="badge bg-label-{{ $product->web_status == 1 ? 'danger' : 'success'}}">{{$product->web_status == 1 ? 'Inactive' : 'Active'}}</span>
                                            </td>
                                            <td class="custom-table d-flex" style="width:10% important;">
                                                <a href="{{route('productadd', ['subcategory_id' => $product->subcategory_id, 'pid' => $product->product_id])}}"
                                                    type="button" data-id="{{$product->product_id}}"
                                                    class=" update_data btn mx-2  btn-icon btn-outline-primary">
                                                    <span class="tf-icons bx bx-pencil"></span>
                                                </a><button type="button" data-id="{{$product->product_id}}"
                                                    class="btn delete  btn-icon btn-outline-danger">
                                                    <span class="tf-icons bx bxs-trash"></span>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>


                </div>







                <!-- / Content -->

                <!-- <script src="{{ asset('assets/js/app-ecommerce-product-list.js') }}"></script> -->

                <script>

                    function updateColor() {
                        const colorPicker = document.getElementById("picker");
                        const colorDisplay = document.getElementById("colorDisplay");
                        const colorCode = document.getElementById("codeValue");

                        const selectedColor = colorPicker.value;
                        colorDisplay.style.backgroundColor = selectedColor;
                        colorCode.innerText = `Color Code: ${selectedColor}`;
                    }

                    var quill = new Quill('#product-description', {
                        modules: {
                            toolbar: [
                                [{
                                    header: [1, 2, false]
                                }],
                                ['bold', 'italic', 'underline'],
                                ['image', 'code-block']
                            ]
                        },
                        placeholder: 'Compose an epic...',
                        theme: 'snow' // or 'bubble'
                    });
                    quill.on('text-change', function () {

                        var descriptionContent = quill.root.innerHTML;
                        $('#description').val(descriptionContent);
                    });

                    $(document).ready(function () {

                        $('.delete-btn').click(function () {
                            $(this).closest('[data-repeater-item]').remove();
                        });

                        var repeater = $(".repeater-default").repeater({
                            initval: 1,
                        });

                        // jQuery(".drag").sortable({
                        // 		axis: "y",
                        // 		cursor: "pointer",
                        // 		opacity: 0.5,
                        // 		placeholder: "row-dragging",
                        // 		delay: 150,
                        // 		update: function (event, ui) {
                        // 			// console.log("repeaterVal");
                        // 			console.log(repeater.repeaterVal());
                        // 			// console.log("serializeArray");
                        // 			console.log($("form").serializeArray());
                        // 		},
                        // 	}).disableSelection();




                        $('#upload-img').change(function (event) {
                            var imgPreview = $('#img-preview');
                            var totalFiles = event.target.files.length;

                            if (totalFiles) {
                                imgPreview.removeClass('img-thumbs-hidden');
                            }

                            for (var i = 0; i < totalFiles; i++) {
                                var wrapper = $('<div>').addClass('wrapper-thumb');
                                var removeBtn = $('<span>').addClass('remove-btn').text('x');
                                var img = $('<img>').addClass('img-preview-thumb').attr('src', URL.createObjectURL(event.target.files[i]));

                                wrapper.append(img).append(removeBtn);
                                imgPreview.append(wrapper);
                            }

                            $('.remove-btn').click(function () {

                                $(this).parent('.wrapper-thumb').remove();
                            });
                        });
                    });

                    $(document).on('click', '.remove-btn', function () {

                        var image = $(this).closest('.wrapper-thumb').data('image');
                        var productId = $(this).siblings('.product-id').val();

                        $.ajax({
                            url: '{{ route("remove.image") }}',
                            method: 'POST',
                            data: {
                                image: image,
                                id: productId,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function (response) {
                                $('.wrapper-thumb[data-image="' + image + '"]').remove();
                            },
                            error: function (xhr, status, error) {

                            }
                        });
                    });

                    $(function () {
                        fetchTable();
                    });
                    let table = $('#get_products');
                    function fetchTable() {

                        table.DataTable().clear().destroy();
                        dTable = table.DataTable({

                            serverSide: true,
                            processing: false,
                            pageLength: 10,
                            info: true,
                            paging: true,
                            searching: true,
                            buttons: [],
                            ajax: {
                                url: '{{ route("get-products-table") }}',
                                type: 'POST',
                                dataType: 'json',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    catId: '{{isset($cat[0]->id) ? $cat[0]->id : ''}}',
                                },
                            },
                            aoColumnDefs: [{
                                bSortable: false,
                                aTargets: 'all'
                            }],
                            columns: [{
                                data: 'sort_order',
                                sortable: false
                            },
                            {
                                data: 'image',
                                sortable: false
                            },
                            {
                                data: 'name',
                                sortable: false
                            },
                            {
                                data: 'category',
                                sortable: false
                            },
                            {
                                data: 'quantity',
                                sortable: false
                            },
                            {
                                data: 'price',
                                sortable: false
                            },
                            {
                                data: 'discount_price',
                                sortable: false
                            },
                            {
                                data: 'varient',
                                sortable: false
                            },
                            {
                                data: 'collection',
                                sortable: false
                            },
                            {
                                data: 'in_stock',
                                sortable: false
                            },
                            {
                                data: 'video_url',
                                sortable: false
                            },
                            {
                                data: 'status',
                                sortable: false
                            },
                            {
                                data: 'description',
                                sortable: false
                            },
                            {
                                data: 'action',
                                sortable: false
                            },
                            ]
                        });
                    }

                    $('#get_products tbody').on('change', 'input.sort_order, input.name, input.quantity, input.price, input.tags, select.category, select.feature, select.status,input.video-url ', function () {

                        var rowData = dTable.row($(this).closest('tr')).data();
                        var fieldName = $(this).attr('name');
                        var old_value = $(this).attr('value');
                        var updatedValue = $(this).val();

                        var isSort = $(this).hasClass('sort_order');
                        update(isSort, fieldName, updatedValue, rowData['id'], old_value, rowData['cat_id']);
                    });

                    function updateDesc(id, desc) {

                        quill.clipboard.dangerouslyPasteHTML(desc);
                        $('#description').val(quill.root.innerHTML);
                        $('#pro-id').val(id);

                        $('#descForm #updateButton').on('click', function (e) {

                            var id = $('#pro-id').val();
                            var desc = $('#description').val();

                            $.ajax({
                                url: '{{route('update-product')}}',
                                method: "POST",
                                data: {
                                    id: id,
                                    name: "description",
                                    value: desc,
                                    _token: '{{csrf_token()}}',
                                },
                                success: function (response) {
                                    $('#descModal').modal('hide');

                                    if (response.success) {

                                        $('#validationMessage').addClass('d-none');
                                        $('#successMessage').removeClass('d-none');
                                        $('#successMessage').text(response.success);
                                        setTimeout(function () {
                                            $('#successMessage').addClass('d-none');
                                            fetchTable();
                                        }, 2000);
                                    } else {
                                        $('#validationMessage').removeClass('d-none');
                                        $('#validationMessage').text('Failed to update description');
                                        setTimeout(function () {
                                            $('#validationMessage').addClass('d-none');
                                            fetchTable();
                                        }, 3000);
                                    }
                                },
                            });

                        });
                    }


                    function update(isSort, fieldName, updatedValue, id, old_value, cat_id) {

                        var requestData = {
                            id: id,
                            name: fieldName,
                            value: updatedValue,
                            category: cat_id,
                            _token: '{{csrf_token()}}',
                        };

                        // If it's a sort operation, include old_sort in the data object
                        if (isSort) {
                            requestData['old_sort'] = old_value;
                        }

                        $.ajax({
                            url: '{{route('update-product')}}',
                            method: "POST",
                            data: requestData,
                            success: function (response) {

                                if (response.error) {
                                    $('#successMessage').addClass('d-none');
                                    $('#validationMessage').removeClass('d-none');
                                    $('#validationMessage').text(response.error);
                                    setTimeout(function () {
                                        $('#validationMessage').addClass('d-none');
                                        fetchTable();
                                    }, 3000);
                                }

                                if (response.success) {
                                    $('#validationMessage').addClass('d-none');
                                    $('#successMessage').removeClass('d-none');
                                    $('#successMessage').text(response.success);
                                    setTimeout(function () {
                                        $('#successMessage').addClass('d-none');
                                        fetchTable();
                                    }, 1700);
                                }

                            },
                            error: function (xhr, status, error) {

                                alert('Failed to save data');
                            }
                        });
                    }

                    function updateVarients(id, variants = null, height = null, height_unit = null, width = null, width_unit = null, weight = null, weight_unit = null) {
                        // Set dimension fields
                        if (height !== 'null') $('#height').val(height);
                        if (height_unit !== 'null') $('#height-unit').val(height_unit);
                        if (width !== 'null') $('#width').val(width);
                        if (width_unit !== 'null') $('#width-unit').val(width_unit);
                        if (weight !== 'null') $('#weight').val(weight);
                        if (weight_unit !== 'null') $('#weight-unit').val(weight_unit);

                        $('#var-pro-id').val(id);

                        // Generate dimension fields HTML
                        var dimensionFields = `
            <div class="row mb-3 mt-3 align-items-center">
                <div class="col-6">
                    <label class="form-label" for="height">Height <span class="text-muted">(Optional)</span></label>
                    <input type="number" class="form-control" id="height" name="height" value="${height !== 'null' ? height : ''}" placeholder="Enter Height" aria-label="Height">
                </div>
                <div class="col-6 mt-4">
                    <select class="form-control" name="height_unit" id="height-unit">
                        <option value="">Select Unit</option>
                        <option value="mm" ${height_unit === 'mm' ? 'selected' : ''}>mm</option>
                        <option value="cm" ${height_unit === 'cm' ? 'selected' : ''}>cm</option>
                        <option value="in" ${height_unit === 'in' ? 'selected' : ''}>in</option>
                        <option value="m" ${height_unit === 'm' ? 'selected' : ''}>m</option>
                    </select>
                    <div class="invalid-feedback" id="height-unit-error">Please select a unit for height.</div>
                </div>
                <div class="col-6">
                    <label class="form-label" for="width">Width <span class="text-muted">(Optional)</span></label>
                    <input type="text" class="form-control" id="width" name="width" value="${width !== 'null' ? width : ''}" placeholder="Enter Width" aria-label="Width">
                </div>
                <div class="col-6 mt-4">
                    <select class="form-control" name="width_unit" id="width-unit">
                        <option value="">Select Unit</option>
                        <option value="mm" ${width_unit === 'mm' ? 'selected' : ''}>mm</option>
                        <option value="cm" ${width_unit === 'cm' ? 'selected' : ''}>cm</option>
                        <option value="in" ${width_unit === 'in' ? 'selected' : ''}>in</option>
                        <option value="m" ${width_unit === 'm' ? 'selected' : ''}>m</option>
                    </select>
                    <div class="invalid-feedback" id="width-unit-error">Please select a unit for width.</div>
                </div>
                <div class="col-6">
                    <label class="form-label" for="weight">Weight <span class="text-muted">(Optional)</span></label>
                    <input type="text" class="form-control" id="weight" name="weight" value="${weight !== 'null' ? weight : ''}" placeholder="Enter Weight" aria-label="Weight">
                </div>
                <div class="col-6 mt-4">
                    <select class="form-control" name="weight_unit" id="weight-unit">
                        <option value="">Select Unit</option>
                        <option value="g" ${weight_unit === 'g' ? 'selected' : ''}>g</option>
                        <option value="kg" ${weight_unit === 'kg' ? 'selected' : ''}>kg</option>
                    </select>
                    <div class="invalid-feedback" id="weight-unit-error">Please select a unit for weight.</div>
                </div>
            </div>
        `;

                        // Generate variant fields
                        var repeaterList = document.getElementById('repeater');
                        repeaterList.innerHTML = dimensionFields; // Add dimension fields first

                        if (variants && Array.isArray(variants)) {
                            variants.forEach(function (variant, index) {
                                var repeaterItem = document.createElement('div');
                                repeaterItem.setAttribute('data-repeater-item', '');

                                var variantFields = `
                    <div class="form-group">
                        <div class="d-flex align-items-center custom-align mb-3">
                            <div>
                                <label class="control-label">Select</label>
                                <select name="variant[${index}][name]" class="form-control">
                                    <option value="">Select</option>
                                    <option value="size" ${variant.name === 'size' ? 'selected' : ''}>Size</option>
                                    <option value="color" ${variant.name === 'color' ? 'selected' : ''}>Color</option>
                                </select>
                            </div>
                            <div>
                                <label class="control-label">Value</label>
                                <input type="text" name="variant[${index}][value]" value="${variant.value}" class="form-control"/>
                            </div>
                            <div>
                                <label class="control-label">Price</label>
                                <input type="text" name="variant[${index}][price]" value="${variant.price}" class="form-control"/>
                            </div>
                            <div class="mt-4">
                                <span data-repeater-delete="" class="form-control btn btn-danger btn-sm delete-btn">
                                    <span class="glyphicon glyphicon-remove"></span> Delete
                                </span>
                            </div>
                        </div>
                    </div>
                `;

                                repeaterItem.innerHTML = variantFields;
                                repeaterList.appendChild(repeaterItem);
                            });
                        }

                        // Validation function
                        function validateUnit(inputId, unitId, errorId) {
                            const inputVal = $(`#${inputId}`).val().trim();
                            const unitVal = $(`#${unitId}`).val();
                            const errorField = $(`#${errorId}`);

                            if (inputVal && !unitVal) {
                                $(`#${unitId}`).addClass('is-invalid');
                                errorField.show();
                                return false;
                            } else {
                                $(`#${unitId}`).removeClass('is-invalid');
                                errorField.hide();
                                return true;
                            }
                        }

                        // Real-time validation on input change
                        $('#height, #width, #weight').on('input', function () {
                            const inputId = this.id;
                            const unitId = `${inputId}-unit`;
                            const errorId = `${inputId}-unit-error`;
                            validateUnit(inputId, unitId, errorId);
                        });

                        // Real-time validation on unit change
                        $('#height-unit, #width-unit, #weight-unit').on('change', function () {
                            const unitId = this.id;
                            const inputId = unitId.replace('-unit', '');
                            const errorId = `${inputId}-unit-error`;
                            validateUnit(inputId, unitId, errorId);
                        });

                        // Form submission validation
                        $('#variantUpdate #uploadButton').on('click', function (e) {
                            var isValid = true;

                            // Reset previous validation states
                            $('#variantUpdate').find('.is-invalid').removeClass('is-invalid');
                            $('#variantUpdate').find('.invalid-feedback').hide();

                            // Validate height
                            if (!validateUnit('height', 'height-unit', 'height-unit-error')) {
                                isValid = false;
                            }

                            // Validate width
                            if (!validateUnit('width', 'width-unit', 'width-unit-error')) {
                                isValid = false;
                            }

                            // Validate weight
                            if (!validateUnit('weight', 'weight-unit', 'weight-unit-error')) {
                                isValid = false;
                            }

                            if (!isValid) {
                                e.preventDefault();
                                const firstInvalid = $('#variantUpdate').find('.is-invalid').first();
                                if (firstInvalid.length) {
                                    $('html, body').animate({
                                        scrollTop: firstInvalid.offset().top - 100
                                    }, 500);
                                }
                                return false;
                            }

                            // Proceed with AJAX submission
                            var form = $('#variantUpdate');
                            var formData = new FormData($('#variantUpdate')[0]);
                            formData.append('id', id);

                            $.ajax({
                                url: '{{ route("update-product-variants") }}',
                                method: "POST",
                                data: formData,
                                contentType: false,
                                processData: false,
                                success: function (data) {
                                    if (data.success) {
                                        $('#variantModal').modal('hide');
                                        $('#validationMessage').addClass('d-none');
                                        $('#successMessage').removeClass('d-none');
                                        $('#successMessage').text(data.success);
                                        setTimeout(function () {
                                            $('#successMessage').addClass('d-none');
                                            fetchTable();
                                        }, 2000);
                                    } else {
                                        $('#successMessage').addClass('d-none');
                                        $('#validationMessage').removeClass('d-none');
                                        $('#validationMessage').text('Failed to update variants');
                                        setTimeout(function () {
                                            $('#validationMessage').addClass('d-none');
                                        }, 3000);
                                    }
                                    $('#variantUpdate')[0].reset();
                                },
                                error: function (error) {
                                    $('#successMessage').addClass('d-none');
                                    $('#validationMessage').removeClass('d-none');
                                    $('#validationMessage').text('Error updating variants');
                                    setTimeout(function () {
                                        $('#validationMessage').addClass('d-none');
                                    }, 3000);
                                }
                            });
                        });
                    }

                    function imageuploads(id, images) {
                        var imgPreviewDiv = document.getElementById('img-preview');
                        imgPreviewDiv.innerHTML = '';

                        var imagesArray = JSON.parse(images);
                        imagesArray.forEach(function (image) {
                            var wrapperDiv = document.createElement('div');
                            wrapperDiv.classList.add('wrapper-thumb');
                            wrapperDiv.dataset.image = image;

                            var img = document.createElement('img');
                            img.src = '/uploads/products/' + image;
                            img.classList.add('img-preview-thumb');

                            var removeBtn = document.createElement('span');
                            removeBtn.classList.add('remove-btn');
                            removeBtn.textContent = 'x';

                            var productIdInput = document.createElement('input');
                            productIdInput.type = 'hidden';
                            productIdInput.classList.add('product-id');
                            productIdInput.value = id;

                            wrapperDiv.appendChild(img);
                            wrapperDiv.appendChild(removeBtn);
                            wrapperDiv.appendChild(productIdInput);

                            imgPreviewDiv.appendChild(wrapperDiv);
                        });



                        $('#uploadButton').on('click', function (e) {

                            var form = $('#imageUpload');
                            var formData = new FormData($('#imageUpload')[0]);
                            formData.append('id', id);
                            $.ajax({
                                url: '{{route('update-product-image')}}',
                                method: "POST",
                                data: formData,
                                contentType: false,
                                processData: false,
                                success: function (data) {

                                    if (data.success) {

                                        $('#uploadModal').modal('hide');
                                        $('#validationMessage').addClass('d-none');
                                        $('#successMessage').removeClass('d-none');
                                        $('#successMessage').text(data.success);
                                        setTimeout(function () {
                                            $('#successMessage').addClass('d-none');
                                            fetchTable();
                                        }, 2000);
                                    }
                                    $('#imageUpload')[0].reset();
                                },
                                error: function (error) {

                                }

                            });

                        });
                    }
                </script>

                <script>
                    $(document).ready(function () {

                        function submitEditForm() {
                            document.getElementById('editForm').submit();
                        }

                        $('.delete').on('click', function (event) {

                            event.preventDefault();
                            Swal.fire({
                                title: 'Are you sure?',
                                text: 'You won\'t be able to revert this!',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#3085d6',
                                confirmButtonText: 'Yes, delete it!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // window.location.href = event.target.href;

                                    $.ajax({
                                        url: '{{ route("delete-product-table") }}',
                                        method: 'POST',
                                        dataType: 'json',
                                        data: {
                                            id: $(this).data('id'),
                                            _token: '{{ csrf_token() }}',
                                        },
                                        success: function (response) {
                                            if (response['error_code'] == 200) {
                                                Swal.fire({
                                                    title: 'Deleted!',
                                                    text: 'The product has been deleted.',
                                                    icon: 'success',
                                                    timer: 1500,
                                                    showConfirmButton: false
                                                }).then(() => {
                                                    location.reload();
                                                });
                                            }
                                        },
                                        error: function (error) {

                                        }

                                    });


                                }
                            });
                        });

                        var table = $('.datatables').DataTable({
                            lengthChange: false,
                            buttons: ['copy', 'excel', 'pdf', 'colvis']
                        });

                        table.buttons().container()
                            .appendTo('#example_wrapper .col-md-6:eq(0)');
                    });
                </script>


@endsection