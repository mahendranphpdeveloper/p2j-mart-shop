@extends('layouts.commonMaster')
@section('layoutContent')

@section('title', 'All customers |')

<!-- Content wrapper -->
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Attribute /</span> {{ $type }}
        </h4>

        <div class="card">
            <div class="card-datatable table-responsive">
                <table id="table_attribute" class="datatables-customers table border-top">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ $type }}</th>
                            <th>Order</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <!-- Offcanvas Form -->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="edit-model" aria-labelledby="offcanvasEndLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasEndLabel" class="offcanvas-title">{{ $type }}</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mb-auto mx-0 flex-grow-0">
        <form id="attribute_Form" onsubmit="return false">
            @csrf
            <div class="mb-3">
                <label class="form-label">{{ $type }} Name*</label>
                <input type="text" class="form-control" id="attribute_name" name="attribute_name" required />
            </div>
            <div class="mb-3">
                <label class="form-label">Order *</label>
                <input type="text" class="form-control onlynumber" id="web_order" name="web_order" required />
                <div class="form-text text-danger" id="order-info">Order between 1 to 8</div>
            </div>
            <div class="mb-3">
                <label class="form-label">Select status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="">Select Status</option>
                    <option value="0">Active</option>
                    <option value="1">Inactive</option>
                </select>
            </div>
            <div class="offcanvas-header align-self-end">
                <input type="hidden" name="id" id="m_attribute_id" value="0" />
                <button type="reset" class="btn bg-label-danger" data-bs-dismiss="offcanvas">Discard</button>
                <button type="submit" class="btn btn-primary" id="button_name">Add</button>
            </div>
        </form>
    </div>
</div>

        </div>
    </div>
</div>


<script>
let tableType = '{{ $type }}';
  let ta;
        var sno = 0;
        $(document).ready(function () {
            let tableType = '{{ $type }}';
            let fetchUrl = '{{ route("get-table-data") }}?table=' + tableType;
            ta = $("#table_attribute").DataTable({
                ajax: {
                    url: fetchUrl,
                    method: 'GET',
                },
                columns: [
                    {
                        className: "text-center",
                        'render': function (data, type, row) {
                            return `${++sno}`;
                        }
                    },
                    {data: tableType +"_name"},
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
                            return ` <button type="button" data-id="${row['m_'+tableType+'_id']}" class=" update_data btn mx-2  btn-icon btn-outline-primary">
                              <span class="tf-icons bx bx-pencil"></span>
                            </button><button type="button"  data-id="${row['m_'+tableType+'_id']}" class="btn delete  btn-icon btn-outline-danger">
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
                    searchPlaceholder: "Search Size"
                },
                buttons: [{
                        text: '<i class="bx bx-plus me-0 me-sm-1"></i>Add Size',
                        className: "update_data btn btn-primary ms-2 ",
                        attr: {
                            'data-id': '0'
                        }
                    }],

            });

              sno = 0;

        });

        $(document).on('click', '.update_data', function () {
    var Id = $(this).data('id');  // Get the ID of the clicked element
   

    $.ajax({
        url: "{{ route('getAttributeData') }}",  // Define the URL for the GET request
        method: 'GET',
        dataType: 'json',
        data: {
            id: Id,
            table: tableType,
            _token: '{{ csrf_token() }}',  // Include CSRF token for security
        },
        success: function (response) {
        
            if (Id == 0) {
                // If Id is 0, reset the form to prepare for adding new data
                $('#attribute_Form')[0].reset();
                $('#m_attribute_id').val(Id);
                $("#order-info").text('Order between 1 to ' + (response["count"] + 1));
                $('#web_order').val(response["count"] + 1);
                $("#button_name").text('Add');
            } else {
                // If Id is not 0, populate the form to update an existing entry
                $('#attribute_Form')[0].reset();
                $('#m_attribute_id').val(Id);
             
                // Dynamically set the attribute name based on tableType (assuming tableType is 'size')
                $('#attribute_name').val(response["data"][tableType + '_name'] ?? '');

                // Set the status and trigger a change event for any select-based UI
                $('#status').val(response["data"]["web_status"] ?? '').trigger("change");
                $('#web_order').val(response["data"]["web_order"]);

                $("#order-info").text('Order between 1 to ' + (response["count"]));
                $("#button_name").text('Update');
            }

            // Show the offcanvas modal for editing the data
            $("#edit-model").offcanvas('show');
        },
        error: function (error) {
            // Handle errors during the AJAX request
            console.error('Error fetching data:', error);
            alert('There was an error retrieving the data.');
        }
    });
});

// Only allow numeric input for the 'web_order' field (optional improvement)
$(document).on('input', '.onlynumber', function (e) {
    var value = $(this).val();
    if (/[^0-9]/g.test(value)) {
        $(this).val(value.replace(/[^0-9]/g, ''));
    }
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
                        url: '{{ route("deleteAttribute") }}',
                        method: 'POST',
                        dataType: 'json',
                        data: {
                            id: $(this).data('id'),
                            table: tableType,
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
        


</script>


@endsection
