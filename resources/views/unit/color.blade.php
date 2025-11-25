@extends('layouts.commonMaster')
@section('layoutContent')

@section('title', 'All customers |')
<!-- Content wrapper -->
<div class="content-wrapper">
    <style>
        #color_code{
                width: 50px;
    height: 30px;
    margin: 0;
    padding: 4px;
        }
        .color-show{
           width: 30px !important;
    height: 20px !important;
    display: inline-block;
    border: 1.5px solid #000;
    text-align: center;
        }
        .color-row {
    display: flex;
}
div#colors {
    width: 67%;
    height: 30px;
    margin: 0;
    padding: 4px;
}
.color-wrapper {
    margin-right: 10px;
}

        </style>
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Unit List /</span> Color 
        </h4>

        <!-- customers List Table -->
        <div class="card">



            <div class="card-datatable table-responsive">
                <table id="color_table" class="datatables-customers table border-top">
                    <thead>
                        <tr>  
                            <th>#</th>
                            <th>Color Name</th>
                            <th>Color Code</th>
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
                    <h5 id="offcanvasEndLabel" class="offcanvas-title">Color</h5>
                    <button
                        type="button"
                        class="btn-close text-reset"
                        data-bs-dismiss="offcanvas"
                        aria-label="Close"
                        ></button>
                </div>
                <div class="offcanvas-body mb-auto mx-0 flex-grow-0">
                    <form class="ecommerce-customer-add pt-0" id="color-form" onsubmit="return false">

                      @csrf
                        <div class="ecommerce-customer-add-basic mb-3">

                            <div class="mb-3">
                                <label class="form-label" for="ecommerce-customer-add-name">Name*</label>
                                <input type="text" class="form-control" id="color_name"
                                       name="color_name"  required="" />
                            </div>

                        </div>
                      
                        <div class="ecommerce-customer-add-basic mb-3">

                         <div class="mb-3 d-flex align-items-center">
                            <label class="form-label me-3" for="ecommerce-customer-add-name">Color *</label>
                            <input type="color" class="form-control flex-grow-1" id="color_code" name="color_code" required />
                            <div id="colors"></div>
                            <input type="hidden" id="multiple_color" name="multiple_color" value="" required />
                            <div class="form-check form-switch m-1">
                            <input class="form-check-input" type="checkbox"  id="exampleCheckbox">
                            <label class="form-check-label" for="exampleCheckbox">Multiple Color</label>
                            </div>
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
                        <input type="hidden" id="m_color_id" name="m_color_id" value="0"> 
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
    
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <label class="form-label" for="ecommerce-customer-add-name">Multiple Color *</label>
        <div class="color-row">
        <div class="color-wrapper" id="cw1">
            <input type="color" class="color1" name="color1" id="color1" value="#ff0000">
        </div>
        <div class="color-wrapper" id="cw2">
            <input type="color" class="color2" name="color2" id="color2" value="#00ff00">
        </div>
        <div class="color-wrapper" id="cw3">
            <input type="color" class="color3" name="color3" id="color3" value="#0000ff">
        </div>
    </div>
     <div id="gradient">'</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" id="saveColorBtn" class="btn btn-primary">Save Color</button>
      </div>
    </div>
  </div>
</div>
<script>
  document.getElementById('exampleCheckbox').addEventListener('change', function() {
    if (this.checked) {
      $('#exampleModal').modal('show');
    } else {
        var colorCode = document.getElementById('colors');
        var colorCodeInput = document.getElementById('color_code');
        var multiplecolor = document.getElementById('multiple_color');
        colorCode.style.display = "none";
        colorCodeInput.style.display = "";
        multiplecolor.value = "";
       this.checked = false; 
      $('#exampleModal').modal('hide'); 
    }
  });
</script>

<script>
    var css = document.querySelector("h3");
    var color1 = document.querySelector(".color1");
    var color2 = document.querySelector(".color2");
    var color3 = document.querySelector(".color3");
    var body = document.getElementById("gradient");

    function setGradient() {
        body.style.background = "linear-gradient(to right, " + color1.value + ", " + color2.value + ", " + color3.value + ")";
        css.textContent = body.style.background + ";";
    }

    function randomGradient() {
        var x1 = Math.floor(Math.random() * 256);
        var y1 = Math.floor(Math.random() * 256);
        var z1 = Math.floor(Math.random() * 256);

        var x2 = Math.floor(Math.random() * 256);
        var y2 = Math.floor(Math.random() * 256);
        var z2 = Math.floor(Math.random() * 256);

        var x3 = Math.floor(Math.random() * 256);
        var y3 = Math.floor(Math.random() * 256);
        var z3 = Math.floor(Math.random() * 256);

        var bgColor1 = "rgb(" + x1 + "," + y1 + "," + z1 + ")";
        var bgColor2 = "rgb(" + x2 + "," + y2 + "," + z2 + ")";
        var bgColor3 = "rgb(" + x3 + "," + y3 + "," + z3 + ")";

        body.style.background = "linear-gradient(to right, " + bgColor1 + ", " + bgColor2 + ", " + bgColor3 + ")";
        css.textContent = body.style.background + ";";
    }

    color1.addEventListener("input", setGradient);
    color2.addEventListener("input", setGradient);
    color3.addEventListener("input", setGradient);
     $(document).ready(function () {
         var colorCode = document.getElementById('colors');
         colorCode.style.display = "none";
       setGradient();
     });
</script>
<script>
document.getElementById('saveColorBtn').addEventListener('click', function(event) {
    event.preventDefault();
     
    var color1Value = document.getElementById('color1').value;
    var color2Value = document.getElementById('color2').value;
    var color3Value = document.getElementById('color3').value;
    var colorCodeInput = document.getElementById('color_code');
    var colorCode = document.getElementById('colors');
    var multiplecolor = document.getElementById('multiple_color');

    var hexColor1 = rgbToHex(color1Value);
    var hexColor2 = rgbToHex(color2Value);
    var hexColor3 = rgbToHex(color3Value);
    if (hexColor1 === null || hexColor2 === null || hexColor3 === null) {
        console.log = "Invalid RGB color values. Please enter valid RGB values.";
        return;
    }
    colorCodeInput.style.display = "none";
    colorCode.style.display = "";
    colorCode.style.background = "linear-gradient(to right, " + hexColor1 + ", " + hexColor2 + ", " + hexColor3 + ")";
    multiplecolor.value = hexColor1 + "," + hexColor2 + "," + hexColor3;
    $('#exampleModal').modal('hide');
});

function rgbToHex(rgb) {
    var r = parseInt(rgb.substring(1, 3), 16);
    var g = parseInt(rgb.substring(3, 5), 16);
    var b = parseInt(rgb.substring(5, 7), 16);
    if (isNaN(r) || isNaN(g) || isNaN(b) || r < 0 || r > 255 || g < 0 || g > 255 || b < 0 || b > 255) {
        return null; 
    }

    var hexR = r.toString(16).padStart(2, '0');
    var hexG = g.toString(16).padStart(2, '0');
    var hexB = b.toString(16).padStart(2, '0');
    return '#' + hexR + hexG + hexB;
}
</script>
    <script>
        let ta;
        var sno = 0;
        $(document).ready(function () {
            
            ta = $("#color_table").DataTable({
                ajax: {
                    url: '{{ route("get-color-table") }}',
                    method: 'GET',
                },
                columns: [
                    {
                        className: "text-center",
                        'render': function (data, type, row) {
                            return `${++sno}`;
                        }
                    },
                    {data: "color_name"},
                     {
                        className: "text-center",
                        'render': function (data, type, row) {
                            return `<span class="color-show" style="background:${row["color_code"]}"></span>`;
                        }
                    },
                     
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
                            return ` <button type="button" data-id="${row['m_color_id']}" class=" update_data btn mx-2  btn-icon btn-outline-primary">
                              <span class="tf-icons bx bx-pencil"></span>
                            </button><button type="button"  data-id="${row['m_color_id']}" class="btn delete  btn-icon btn-outline-danger">
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
                    searchPlaceholder: "Search Color"
                },
                buttons: [{
                        text: '<i class="bx bx-plus me-0 me-sm-1"></i>Add Color',
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
                        url: '{{ route("delete-color-table") }}',
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
                url: "{{ route('getColorData') }}",
                method: 'GET',
                dataType:'json',
                data: {
                    id: Id,
                    _token: '{{ csrf_token() }}',
                },
                success: function (response) {
                   if(Id == 0){
                        $('#color-form')[0].reset();
                    $('#m_color_id').val(Id);
                    $("#order-info").text('Order between 1 to '+(response["count"] + 1));                
                    $('#web_order').val( response["count"] + 1);
                    $("#button_name").text('Add');
                   }else{
                      $('#color-form')[0].reset();
                    $('#m_color_id').val(Id);
                    $('#color_name').val(response["data"]["color_name"]??'');
                      $('#color_code').val(response["data"]["color_code"]??'');
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


        $('#color-form').on('submit', function (e) {
            e.preventDefault();
             sno = 0;
            var form = this;
            var formData = new FormData(form);

            $.ajax({
                url: '{{ route("storeColor") }}',
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