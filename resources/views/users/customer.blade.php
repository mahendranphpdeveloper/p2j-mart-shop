@extends('layouts.commonMaster')
@section('layoutContent')

@section('title', 'All customers |')
<!-- Content wrapper -->
<div class="content-wrapper">

    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
      <div class="d-flex justify-content-between">

        <div class="h4 py-3 mb-4">
          <span class="text-muted fw-light"> </span> All Customers
        </div>

        <div>
            <div class="alert alert-success d-none" id="successMessage"></div>
        </div>

        <div>

        </div>

      </div>
        <!-- customers List Table -->
        <div class="card">

            <div class="card-datatable table-responsive">
                <table class="datatables-customers table border-top">
                    <thead>
                        <tr>
                            <th></th>
                            <th> Name</th>
                            <th class="text-nowrap">Mobile No</th>
                            <th>Email</th>
                         
                              <th>Action</th>
                      
                        </tr>
                    </thead>
                </table>
            </div>
            <!-- Offcanvas to add new customer -->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEcommerceCustomerAdd"
                aria-labelledby="offcanvasEcommerceCustomerAddLabel">
                <div class="offcanvas-header">
                    <h5 id="offcanvasEcommerceCustomerAddLabel" class="offcanvas-title">Add Customer</h5>

                    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                      <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header">
                          <strong class="me-auto">Alert</strong>
                          <small></small>
                          <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body" id="toast-content">
                        <div class="alert alert-danger d-none" id="validationMessage"></div>

                        </div>
                      </div>
                    </div>

                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body mx-0 flex-grow-0">
                    <form class="ecommerce-customer-add pt-0" id="eCommerceCustomerAddForm" onsubmit="return false">
                      @csrf
                        <div class="ecommerce-customer-add-basic mb-3">
                            <h6 class="mb-3">Basic Information</h6>
                            <div class="mb-3">
                                <label class="form-label" for="name">Name*</label>
                                <input type="text" class="form-control" id="name"
                                    placeholder="Enter name" name="name" aria-label="Enter name" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="last_name">Last Name*</label>
                                <input type="text" class="form-control" id="last_name"
                                    placeholder="Enter last name" name="last_name" aria-label="Enter last name" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="email">Email*</label>
                                <input type="text" id="email" class="form-control"
                                    placeholder="Enter email" aria-label="Enter email"
                                    name="email" />
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="phonenumber">Mobile*</label>
                                <input type="text" id="phonenumber" class="form-control"
                                    placeholder="Enter mobile no" aria-label="Enter mobile no"
                                    name="phonenumber" />
                            </div>
                            <!-- <div class="mb-3">
                                <label class="form-label" for="password">Password</label>
                                <input type="password" id="password" class="form-control phone-mask"
                                    placeholder="Enter Password" name="password" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="confirm-password">Confirm Password</label>
                                <input type="password" id="password" class="form-control phone-mask"
                                    placeholder="Enter Password" name="password" />
                            </div> -->
                        </div>

                          <!-- Status -->
                          <div class="mb-4 ecommerce-select2-dropdown">
                              <label class="form-label">Select status</label>
                              <select id="status" class="select2 form-select" data-placeholder="Select Slider Status"
                                  name="status">
                                  <option value="">Select Status</option>
                                  <option selected value="Active">Active</option>
                                  <option value="Inactive">Inactive</option>
                              </select>
                           </div>


                        <!-- <div class="d-sm-flex mb-3 pt-3">
                            <div class="me-auto mb-2 mb-md-0">
                                <h6 class="mb-0">Use as a billing address?</h6>
                                <small class="text-muted">If you need more info, please check budget.</small>
                            </div>
                            <label class="switch m-auto pe-2">
                                <input type="checkbox" class="switch-input" />
                                <span class="switch-toggle-slider">
                                    <span class="switch-on"></span>
                                    <span class="switch-off"></span>
                                </span>
                            </label>
                        </div> -->

                        <input type="hidden" name="is_edit" id="edit-id" value="0">
                        <div class="pt-3">
                            <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Add</button>
                            <button type="reset" class="btn bg-label-danger"
                                data-bs-dismiss="offcanvas">Discard</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <!-- / Content -->
    <!-- <script src="{{ asset('assets/js/app-ecommerce-customer-all.js') }}"></script> -->
    <script>


$(document).ready(function() {


       const o = $('.datatables-customers').DataTable({
            "processing": true,
            "serverSide": false,
            "ajax": {
                "url": "{{route('get.customers')}}",
                "type": "GET"
            },
            "columns": [
                { "data": "si_no" },
                { "data": "name" },
                { "data": "phone_no" },
                { "data": "email" },
            
                { "data": "action" }
           
           ],
           dom: '<"card-header d-flex flex-wrap py-0"<"me-5 ms-n2 pe-5"f><"d-flex justify-content-start justify-content-md-end align-items-baseline"<"dt-action-buttons d-flex align-items-start align-items-md-center justify-content-sm-center mb-3 mb-sm-0 gap-3"lB>>>t<"row mx-2"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            "buttons": [
         
            ]
        });


    const toast = new bootstrap.Toast($('#liveToast'));
            var Count = 1;
            function clearFormData(count) {
                toast.hide();
                $('#eCommerceCustomerAddForm')[0].reset();
                $('#edit-id').val(0);
                $('#offcanvasEcommerceCustomerAdd').offcanvas('show');

            }

            $('#eCommerceCustomerAddForm').on('submit', function (e) {
                e.preventDefault();

                var form = this;
                var formData = new FormData(form);

                $.ajax({
                    url: '{{ route("users.store") }}',
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false, beforeSend: function () {
                        $(form).find('span.error-text').text('');
                    },
                    success: function (response) {
                        if (response.success) {
                            $('#offcanvasEcommerceCustomerAdd').offcanvas('hide');

                            $('#validationMessage').addClass('d-none');
                            $('#successMessage').removeClass('d-none');
                            $('#successMessage').text(response.success);
                            setTimeout(function(){
                            $('#successMessage').addClass('d-none');
                                o.ajax.reload();
                            },2000);
                        } else {
                                    console.log(response);
                                //   $('#offcanvasEcommerceCustomerAdd').offcanvas('hide');
                                $('#validationMessage').removeClass('d-none');
                                $('#validationMessage').text('');
                                const toast = new bootstrap.Toast($('#liveToast'), {
                                        autohide: false,
                                        delay: 10000
                                    });
                                    toast.show()
                                    $('#validationMessage').append(response.error);
                                $.each(response[0], function( index, value ) {

                                    // toast.show()
                                    const errorMessageElement = $('<p>').attr('id', `${index}`).text(`${value}`);
                                    $('#validationMessage').append(errorMessageElement);

                                    });
                                }
                    }
                });
            });

            $('.datatables-customers').on('click', '.delete', function () {

                var Id = $(this).data('id');
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
                            url: '{{ route("users.destroy",["user"=>':id']) }}'.replace(':id',Id),
                            method: 'DELETE',
                            data: {
                                id: Id,
                                _token: '{{ csrf_token() }}',
                            },
                            success: function (response) {
                                console.log('Item deleted successfully');
                                o.ajax.reload();
                            },
                            error: function (error) {
                                console.error('Error deleting item:', error);
                            }

                        });

                    }
                });

            });

            $('.datatables-customers').on('click', '.edit', function () {
                var Id = $(this).data('id');
                toast.hide();

                $.ajax({
                    url: "{{ route('users.show',['user'=>':id']) }}".replace(':id', Id),
                    method: 'GET',
                    data: {
                        id: Id,
                        _token: '{{ csrf_token() }}',
                    },
                    success: function (response) {

                        $('#offcanvasEcommerceCustomerAdd').offcanvas('show');
                        $('#edit-id').val(response[0].id);
                        $('#name').val(response[0].name);
                        $('#last_name').val(response[0].last_name);
                        $('#email').val(response[0].email);
                        $('#phonenumber').val(response[0].phonenumber);
                        $('#status').val(response[0].status);

                        // o.ajax.reload();
                    },
                    error: function (error) {
                        console.error('Error deleting item:', error);
                    }

                });

            });

});


</script>
    @endsection
