@extends('layouts.commonMaster')
@section('layoutContent')

@section('title', 'All customers |')
<!-- Content wrapper -->
<div class="content-wrapper">

    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Unit List /</span> Material 
        </h4>

        <!-- customers List Table -->
        <div class="card">



            <div class="card-datatable table-responsive">
                <table id="matrial_table" class="datatables-customers table border-top">
                    <thead>
                        <tr>  
                            <th>#</th>
                            <th>Material Name</th>                                                      
                            <th>Order</th>
                            <th>Status</th> 
                            <th >Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <!-- Offcanvas to add new customer -->
            <div  class="offcanvas offcanvas-end"  tabindex="-1"   id="edit-model"   aria-labelledby="offcanvasEndLabel" >
                <div class="offcanvas-header">
                    <h5 id="offcanvasEndLabel" class="offcanvas-title">Material</h5>
                    <button
                        type="button"
                        class="btn-close text-reset"
                        data-bs-dismiss="offcanvas"
                        aria-label="Close"
                        ></button>
                </div>
                <div class="offcanvas-body mb-auto mx-0 flex-grow-0">
                    <form class="ecommerce-customer-add pt-0" id="metrial-form" onsubmit="return false">

                      @csrf
                        <div class="ecommerce-customer-add-basic mb-3">

                            <div class="mb-3">
                                <label class="form-label" for="ecommerce-customer-add-name">Name*</label>
                                <input type="text" class="form-control" id="material_name"
                                       name="material_name"  required="" />
                            </div>

                        </div>

                        <div class="ecommerce-customer-add-basic mb-3">

                            <div class="mb-3">
                                <label class="form-label" for="ecommerce-customer-add-name">Order *</label>
                                <input type="text" class="form-control onlynumber" id="web_order"
                                       name="web_order" required=""  />
                                <div id="order-info" class="form-text text-danger">Order between 1 to 8</div>
                            </div>

                        </div>

                        <div class="mb-3 ecommerce-select2-dropdown">
                            <label class="form-label">Select status</label>
                            <select id="status" class="select2 form-select" data-placeholder="Select Slider Status"  name="status" required="" >
                                <option value="">Select Category Status</option>
                                <option value="0">Active</option>
                                <option value="1">Inactive</option>
                            </select>
                        </div>



                </div>
                <div class="offcanvas-header align-self-end">
                    <div>
                        <input type="hidden" id="m_master_id" name="m_master_id" value="0"> 
                        <button type="reset" class="btn bg-label-danger"
                                data-bs-dismiss="offcanvas">Discard</button>
                        <button type="submit" id="button_name" class="btn btn-primary me-sm-3 me-1 data-submit">Add</button>
                    </div>
                </div>
                </form>  
            </div>
        </div>

    </div>
    <!-- / Content -->
    <script>
        let ta;
        var sno = 0;
        $(document).ready(function () {
            
            ta = $("#matrial_table").DataTable({
                ajax: {
                    url: '{{ route("get-material-table") }}',
                    method: 'GET',
                },
                columns: [
                    {
                        className: "text-center",
                        'render': function (data, type, row) {
                            return `${++sno}`;
                        }
                    },
                    {data: "material_name"},
                    {data: "web_order"},
                    {
                        className: "text-center",
                        'render': function (data, type, row) {
                            return `<span class="badge bg-label-${row['web_status'] == 1 ? 'danger' : 'success'}">${row['web_status'] == 1 ? 'Inactive' : 'Active'}</span>`;
                        }
                    },
                    {
                        className: "text-center",
                        'render': function (data, type, row) {
                            return ` <button type="button" data-id="${row['m_material_id']}" class=" update_data btn mx-2  btn-icon btn-outline-primary">
                              <span class="tf-icons bx bx-pencil"></span>
                            </button><button type="button"  data-id="${row['m_material_id']}" class="btn delete  btn-icon btn-outline-danger">
                              <span class="tf-icons bx bxs-trash"></span>
                            </button>`;
                        }
                    },
                ],

                // order: [2, "desc"],
                dom: '<"card-header d-flex flex-wrap py-0"<"me-5 ms-n2 pe-5"f><"d-flex justify-content-start justify-content-md-end align-items-baseline"<"dt-action-buttons d-flex align-items-start align-items-md-center justify-content-sm-center mb-3 mb-sm-0 gap-3"lB>>>t<"row mx-2"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',

                language: {
                    sLengthMenu: "_MENU_",
                    search: "",
                    searchPlaceholder: "Search Matrial"
                },
                buttons: [{
                        text: '<i class="bx bx-plus me-0 me-sm-1"></i>Add Matrial',
                        className: "update_data btn btn-primary ms-2 ",
                        attr: {
                            'data-id': '0'
                        }
                    }],

            });

              sno = 0;

        });


        $(document).on('click', '.delete', function () {
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
                        url: '{{ route("delete-material-table") }}',
                        method: 'POST',
                        dataType: 'json',
                        data: {
                            id: $(this).data('id'),
                            _token: '{{ csrf_token() }}',
                        },
                        success: function (response) {
                            if (response['error_code'] == 200)
                                ta.ajax.reload();
                        },
                        error: function (error) {
                            console.error('Error deleting item:', error);
                        }

                    });

                }
            });

        });

        $(document).on('click', '.update_data', function () {
            var Id = $(this).data('id');
            sno = 0;
            $.ajax({
                url: "{{ route('getMatrialData') }}",
                method: 'GET',
                dataType:'json',
                data: {
                    id: Id,
                    _token: '{{ csrf_token() }}',
                },
                success: function (response) {
                   if(Id == 0){
                        $('#metrial-form')[0].reset();
                    $('#m_master_id').val(Id);
                    $("#order-info").text('Order between 1 to '+(response["count"] + 1));                
                    $('#web_order').val( response["count"] + 1);
                    $("#button_name").text('Add');
                   }else{
                      $('#metrial-form')[0].reset();
                    $('#m_master_id').val(Id);
                    $('#material_name').val(response["data"]["material_name"]??'');
                    $('#status').val(response["data"]["web_status"]??'').trigger("change");                   
                    $('#web_order').val(response["data"]["web_order"]);
                     $("#order-info").text('Order between 1 to '+(response["count"])); 
                     $("#button_name").text('Update');
                   }
                   
                    $("#edit-model").offcanvas('show');
                },
                error: function (error) {
                    console.error('Error deleting item:', error);
                }

            });

        });


        $('#metrial-form').on('submit', function (e) {
            e.preventDefault();
             sno = 0;
            var form = this;
            var formData = new FormData(form);

            $.ajax({
                url: '{{ route("storeMatrial") }}',
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                cache: false, 
                dataType:"json",                 
                success: function (response) {
                    if (response["error_code"] ==200) {
                       $('#edit-model').offcanvas('hide'); 
                       ta.ajax.reload();
                    } else {
                        
                    }

                }
            });
        });

        $('.onlynumber').on('keypress', function (e) {
            var regex = new RegExp("^[Z0-9]+$");
            var key = String.fromCharCode(!e.charCode ? e.which : e.charCode);
            if (!regex.test(key)) {
                e.preventDefault();
                return false;
            }
        });
    </script>

    @endsection