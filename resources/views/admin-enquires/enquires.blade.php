@extends('layouts.commonMaster')

@section('layoutContent')
<!-- Content wrapper -->
<div class="content-wrapper">

    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light"></span>Enquires List
        </h4>

        <!-- Order List Widget -->

        <div class="card mb-4">
            <div class="card-widget-separator-wrapper">
                <div class="card-body card-widget-separator">
                    <div class="row gy-4 gy-sm-1">
                        <div class="col-sm-6 col-lg-3">
                            <div
                                class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-3 pb-sm-0">
                                <div>
                                    <h3 class="mb-2">{{isset($enq_count)?$enq_count:''}}</h3>
                                    <p class="mb-0">Total Enquires</p>
                                </div>
                                <div class="avatar me-sm-4">
                                    <span class="avatar-initial rounded bg-label-secondary">
                                        <i class="bx bx-calendar bx-sm"></i>
                                    </span>
                                </div>
                            </div>
                            <hr class="d-none d-sm-block d-lg-none me-4">
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Order List Table -->
        <div class="card">
            <div class="card-datatable table-responsive">
                <table class="datatables-enquires table border-top">
                    <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Message</th>

                        </tr>
                    </thead>
                </table>
            </div>
        </div>


    </div>
    <!-- / Content -->
    <!-- <script src="{{asset('assets/js/app-ecommerce-order-list.js')}}"></script> -->
    <script>


$(document).ready(function() {
        $('.datatables-enquires').DataTable({
            "processing": true,
            "serverSide": false,
            "ajax": {
                "url": "{{route('get.enquires')}}",
                "type": "GET"
            },
            "columns": [
                { "data": "id" },
                { "data": "name" },
                { "data": "phone" },
                { "data": "email" },
                { "data": "message" },
           ],
            "buttons": [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    });


</script>
@endsection