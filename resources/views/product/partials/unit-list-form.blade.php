<form id="unit_form" class="needs-validation" novalidate onsubmit="return false">
    @csrf
    <div class="row d-flex justify-content-center badge bg-label-secondary">
        <div class="col-md-2">
            <label class="form-label" for="basic-default-fullname">Size</label>
            <select id="product_size" class="select2 form-select" data-placeholder="Select Size" name="product_size" required="">
                <option value="">Select</option>
                @foreach($UnitSize as $_size)
                    <option value="{{ $_size->m_size_id }}">{{ $_size->size_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label" for="basic-default-fullname">Unit Price</label>
            <input type="number" class="form-control" id="unit_price" placeholder="Price" name="unit_price">
        </div>
        <div class="col-md-2">
            <label class="form-label" for="basic-default-fullname">MRP</label>
            <input type="number" class="form-control" id="mrp_price" placeholder="Price" name="mrp_price">
        </div>
        <div class="col-md-2">
            <label class="form-label" for="basic-default-fullname">Available Types</label>
            <select id="product_material" class="select2 form-select" data-placeholder="Select Material" name="product_material" required="">
                <option value="">Select</option>
                @foreach($UnitMatrial as $_matriale)
                    <option value="{{ $_matriale->m_material_id }}">{{ $_matriale->material_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label" for="basic-default-fullname">Design</label>
            <select id="product_design" class="select2 form-select" data-placeholder="Select Design" name="product_design" required="">
                <option value="">Select</option>
                @foreach($UnitDesign as $_design)
                    <option value="{{ $_design->m_design_id }}">{{ $_design->design_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <label class="form-label d-block" for="basic-default-fullname">Color</label>
            <div class="custom-dropdown form-control ">
                <div class="dropdown-selected" id="dropdown-selected">
                    <span>Select</span>
                    <div>▾</div>
                </div>
                <div class="dropdown-options" id="dropdown-options">
                    <!-- Options will be added dynamically -->
                </div>
            </div>
            <select id="product_color" class="select2 " data-placeholder="Select Color" name="product_color" required="" style="display: none;">
                <option value="">Select</option>
                <!-- Options will be added dynamically -->
            </select>
        </div>

        {{-- <div class="col-md-2">
            <label class="form-label" for="basic-default-fullname">Products Stock</label>
            <input type="number" class="form-control" min="0" id="product_stock" name="product_stock" required="">
        </div> --}}
        <div class="col-md-2  d-flex align-items-center" style="margin-top: 16px;">
            <input id="unit_id" type="hidden" value="0">
            <button type="submit" class="btn btn-success mx-2">Save</button>
            <button type="reset" onclick="$(this).addClass('d-none');$('#unit_id').val(0); " id="unitreset" class="btn btn-danger d-none">close</button>
        </div>
    </div>
</form>

<div class="card-datatable table-responsive mt-3">
    <table id="unitlist_table" class="datatables-customers table border-top">
        <thead>
            <tr>
                <th>#</th>
                <th>Size</th>
                <th>Unit Price</th>
                <th>MRP</th>
                <th>Material</th>
                <th>Design</th>
                <th>Color</th>
                {{-- <th>Stock</th> --}}
                <th>Action</th>
            </tr>
        </thead>
    </table>
</div>