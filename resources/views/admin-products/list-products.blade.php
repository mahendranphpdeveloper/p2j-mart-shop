@extends('layouts.commonMaster')
@section('layoutContent')


<!-- Content wrapper -->
<div class="content-wrapper">

    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">eCommerce /</span> Product List 1
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
                                    <h4 class="mb-2">{{isset($total_count)?$total_count:''}}</h4>
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
                                    <h4 class="mb-2">{{isset($products_count)?$products_count:''}}</h4>
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
                                    <h4 class="mb-2">{{isset($products_out_of_stock)?$products_out_of_stock:''}}</h4>
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
                <h5 class="card-title">Filter</h5>
                <div class="d-flex justify-content-between align-items-center row py-3 gap-3 gap-md-0">
                    <div class="col-md-4 product_status"></div>
                    <div class="col-md-4 product_category"></div>
                    <div class="col-md-4 product_stock"></div>
                </div>
            </div>
            <div class="card-datatable table-responsive">
                <table class="datatables-products table border-top">
                    <thead>
                        <tr>
                            <!-- <th></th> -->
                            <th>
                                <input type="checkbox" class="form-check-input">
                            </th>
                            <th>product</th>
                            <th>category</th>
                            <th>In stock</th>
                            <th>price</th>
                            <th>qty</th>
                            <!-- <th>sku</th> -->
                            <th>status</th>
                            <th class="text-center">actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td><input type="checkbox" class="form-check-input"></td>
                            <td>
                                <div class="d-flex justify-content-start align-items-center product-name">
                                    <div class="avatar-wrapper">
                                        <div class="avatar avatar me-2 rounded-2 bg-label-secondary">
                                            <img src="{{asset('uploads/products').'/'.$product->images}}" alt=""
                                                class="rounded-2">
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <h6 class="text-body text-nowrap mb-0">{{$product->name}}</h6>
                                    </div>
                                </div>
                            </td>
                            <td>{{$product->category}}</td>
                            <td>{{($product->in_stock=="true") ? 'Available':'Not Available'}}</td>
                            <td>{{$product->base_price}}</td>
                            <td>{{$product->qty}}</td>
                            <td>{{$product->status}}</td>
                            <td>
                                <div class="d-flex justify-content-around">
                                    <a href="{{route('products.edit',['product'=>$product->id])}}"
                                        class="edit pe-3 btn btn-info" id="edit">Edit</a>
                                    <a href="{{route('admin-delete-products',['id'=> $product->id])}}"
                                        class="delete pe-3 btn btn-danger text-white" id="delete">Delete</a>
                                </div>
                                <!-- {{$product->id}} -->
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
        $(document).ready(function () {

            var table = $('.datatables').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf', 'colvis']
            });

            table.buttons().container()
                .appendTo('#example_wrapper .col-md-6:eq(0)');
        
         $('.delete').on('click', function () {
            sno = 0;
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

                    $.ajax({
                        url: '{{ route("delete-product-table") }}',
                        method: 'POST',
                        dataType: 'json',
                        data: {
                            id: $(this).data('id'),
                            _token: '{{ csrf_token() }}',
                        },
                        success: function (response) {
                            if (response['error_code'] == 200)
                               location.reload();
                        },
                        error: function (error) {
                            console.error('Error deleting item:', error);
                        }

                    });

                }
            });

        });
        });
       
    </script>


    @endsection