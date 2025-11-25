@extends('layouts.commonMaster')
@section('layoutContent')

<!-- Content wrapper -->
<div class="content-wrapper">

    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Orders /</span>Cancel Request
        </h4>

        <!-- Order List Widget -->

        <div class="card mb-4">
            <div class="card-widget-separator-wrapper">
                <div class="card-body card-widget-separator">
                    <div class="row gy-4 gy-sm-1">
                        <div class="col-sm-6 col-lg-3 customInput"  type="button" data-type="all">
                            <div
                                class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-3 pb-sm-0">
                                <div>
                                    <h3 class="mb-2">{{isset($orders_count)?$orders_count:''}}</h3>
                                    <p class="mb-0">Total Request</p>
                                </div>
                                <div class="avatar me-sm-4">
                                    <span class="avatar-initial rounded bg-label-secondary">
                                        <i class="bx bx-calendar bx-sm"></i>
                                    </span>
                                </div>
                            </div>
                            <hr class="d-none d-sm-block d-lg-none me-4">
                        </div>
                         <div class="col-sm-6 col-lg-3 customInput"  type="button" data-type="accepted">
                            <div
                                class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0">
                                <div>
                                    <h3 class="mb-2">{{isset($accepted)?$accepted:''}}</h3>
                                    <p class="mb-0">Accepted</p>
                                </div>
                                <div class="avatar me-lg-4">
                                    <span class="avatar-initial rounded bg-label-secondary">
                                        <i class="bx bx-check-double bx-sm"></i>
                                    </span>
                                </div>
                            </div>
                            <hr class="d-none d-sm-block d-lg-none">
                        </div>

                        <div class="col-sm-6 col-lg-3 customInput"  type="button" data-type="rejected">
                            <div
                                class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                                <div>
                                    <h3 class="mb-2">{{isset($rejected)?$rejected:''}}</h3>
                                    <p class="mb-0">Rejected</p>
                                </div>
                                <div class="avatar me-sm-4">
                                    <span class="avatar-initial rounded bg-label-secondary">
                                        <i class="bx bx-wallet bx-sm"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!--
                        <div class="col-sm-6 col-lg-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h3 class="mb-2">32</h3>
                                    <p class="mb-0">Failed</p>
                                </div>
                                <div class="avatar">
                                    <span class="avatar-initial rounded bg-label-secondary">
                                        <i class="bx bx-error-alt bx-sm"></i>
                                    </span>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Order List Table -->
        <div class="card">
            <div class="card-datatable table-responsive">
                <table class="datatables-order table border-top">
                    <thead>
                        <div id="custom-heading" style="font-size: 22px;" class="d-flex justify-content-center pt-3">Total Requests</div>
                        <tr>
                            <th>Sl No</th>
                            <th>Image</th>
                            <th>Order Id</th>
                            <th class="text-nowrap">Ordered Time</th>
                            <th>Product</th>
                            <!--<th>Category</th>-->
                            <th>qty</th>
                            <th>price</th>
                            <!--<th>Size</th>-->
                            <!--<th>material</th>-->
                            <!--<th>method</th>-->
                            <th>User Name</th>
                            <th>Mobile No</th>
                            <!--<th>ALter Mobile No</th>-->
                            <th>Address</th>
                            <th>Cancelled Reason</th>
                            <th>actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>


    </div>

<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Order details</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <div class="row">

                <div class="col-6">

                    <div>
                        <label class="fw-bold ">User Order Cancel Status: </label>
                        <p class="ms-2" id="order_status" ></p>
                    </div>
                    <div>
                        <label class="fw-bold ">Payment Status: </label>
                        <p class="ms-2" id="payment_status" ></p>
                    </div>
                    <div>
                        <label class="fw-bold ">Admin Rejected status: </label>
                        <p class="ms-2" id="admin_reject_order" ></p>
                    </div>
                    <div>
                        <label class="fw-bold ">User Reject Request: </label>
                        <p class="ms-2" id="user_reject_order" ></p>
                    </div>
                </div>
                <div class="col-6">
                     <div>
                        <label class="fw-bold ">Order Id: </label>
                        <p class="ms-2" id="order_id" ></p>
                    </div>
                    <div>
                        <label class="fw-bold ">Ordered Time: </label>
                        <p class="ms-2" id="ordered_time" ></p>
                    </div>

                    <div>
                        <label class="fw-bold ">User Address: </label>
                        <p class="ms-2" id="address" ></p>
                    </div>
                </div>
                <div class="col-4">
                     <div>
                        <label class="fw-bold ">Product name: </label>
                        <p class="ms-2" id="name" ></p>
                    </div>
                    <div>
                        <label class="fw-bold ">Category </label>
                        <p class="ms-2" id="category" ></p>
                    </div>
                </div>

                    <div class="col-4">

                    <div>
                        <label class="fw-bold ">Quantity </label>
                        <p class="ms-2" id="qty" ></p>
                    </div>
                    <div>
                        <label class="fw-bold ">Price </label>
                        <p class="ms-2" id="price" ></p>
                    </div>

                    </div>

                    <div class="col-4">
                    <div>
                        <label class="fw-bold ">Size </label>
                        <p class="ms-2" id="size" ></p>
                    </div>
                    <div>
                        <label class="fw-bold ">Color </label>
                        <p class="ms-2" id="color" ></p>
                    </div>
                    <div>
                        <label class="fw-bold ">Available Types </label>
                        <p class="ms-2" id="types" ></p>
                    </div>

                </div>

            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

    <!-- / Content -->
    <!-- <script src="{{asset('assets/js/app-ecommerce-order-list.js')}}"></script> -->
<script>
$(document).ready(function () {
    const table = $('.datatables-order').DataTable({
        processing: true,
        serverSide: false,
        data: {!! $orders->toJson() !!},
        columns: [
            {
                data: null,
                render: (data, type, row, meta) => meta.row + 1 // Serial Number
            },
            {
                data: null,
                render: data => {
                    const img = data?.product_image?.web_image_1;
    const basePath = "{{ asset("uploads/products/") }}"; // Laravel's asset() generates the base URL
    return img 
        ? `<img src="${basePath}/${img}" width="50" height="50">` 
        : 'No image';
                }
            },
            { data: 'order_id' },
            {
                data: 'created_at',
                render: data => new Date(data).toLocaleString()
            },
            {
                data: null,
                render: data => data.product?.product_name || 'N/A'
            },
            { data: 'quantity' },
            {
                data: 'total_amount',
                render: data => '₹' + parseFloat(data).toFixed(2)
            },
            {
                data: null,
                render: data => data.address?.name || 'N/A'
            },
            {
                data: null,
                render: data => data.address?.phone || 'N/A'
            },
            {
                data: null,
                render: data => {
                    const addr = data.address;
                    return addr
                        ? `${addr.address}, ${addr.city}, ${addr.state} - ${addr.pincode}`
                        : 'N/A';
                }
            },
            { data: 'cancel_order_reason' },
            {
                data: null,
                render: data =>
                    `<button class="btn btn-sm btn-primary view-details" data-id="${data.order_id}">View</button>`
            }
        ]
    });

    // Handle "View" button click
    $('.datatables-order').on('click', '.view-details', function () {
        const order = table.row($(this).closest('tr')).data();

        $('#order_status').text(order.order_status);
        $('#payment_status').text(order.payment_status);
        $('#order_id').text(order.order_id);
        $('#ordered_time').text(new Date(order.created_at).toLocaleString());

        const addr = order.address;
        if (addr) {
            $('#address').text(`${addr.address}, ${addr.city}, ${addr.state} - ${addr.pincode}`);
        }

        const product = order.product;
        if (product) {
            $('#name').text(product.product_name);
            $('#category').text(product.category?.name || 'N/A');
            $('#price').text('₹' + parseFloat(order.total_amount).toFixed(2));
            $('#image').html(`<img src="/storage/${product.image}" width="100">`);
        }

        $('#qty').text(order.quantity);
        $('#exampleModal').modal('show');
    });
});

</script>

    @endsection
