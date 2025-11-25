<form id="basic_form" class="needs-validation" novalidate onsubmit="return false">
    @csrf
    <div class="mb-3">
        <label class="form-label" for="ecommerce-product-name">Name</label>
        <input type="text" class="form-control" id="ecommerce-product-name" placeholder="Product title" value="{{ isset($product) && $product->product_name != null ? $product->product_name : '' }}" name="name" aria-label="Product title" required>
    </div>

    <!-- Description -->
    <div>
        <label class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description" required>{{ isset($product) && $product->description != null ? $product->description : '' }}</textarea>
    </div>

    <div class="mt-3 mb-3 col ecommerce-select2-dropdown">
        <label class="form-label mb-3">Collection <span class="text-muted">(Optional)</span></label>
        <div>
            <input type="radio" id="collection_none" name="collection" value="0" {{ isset($product) && $product->collection == 0 ? "checked" : "" }}>
            <label for="collection_none">None</label>
            &nbsp;&nbsp;

            <input type="radio" id="collection_trending" name="collection" value="1" {{ isset($product) && $product->collection == 1 ? "checked" : "" }}>
            <label for="collection_trending">Trending Collections</label>
            &nbsp;&nbsp;

            <input type="radio" id="collection_featured" name="collection" value="2" {{ isset($product) && $product->collection == 2 ? "checked" : "" }}>
            <label for="collection_featured">Featured Products</label>
            &nbsp;&nbsp;

            <input type="radio" id="collection_exclusive" name="collection" value="3" {{ isset($product) && $product->collection == 3 ? "checked" : "" }}>
            <label for="collection_exclusive">Exclusive Products</label>
        </div>

        <div class="mb-3 mt-4">
            <label class="form-label">Customize Product <span class="text-muted">(Optional)</span></label>
            <div>
                <input type="radio" id="customize_no" name="customize" value="0" {{ isset($product) && $product->customize == 0 ? 'checked' : '' }}>
                <label for="customize_no">No</label>
                &nbsp;&nbsp;
                <input type="radio" id="customize_yes" name="customize" value="1" {{ isset($product) && $product->customize == 1 ? 'checked' : '' }}>
                <label for="customize_yes">Yes</label>
            </div>
        </div>

        <div class="mb-3" id="customize_options_field" style="{{ isset($product) && $product->customize == 1 ? '' : 'display: none;' }}">
            <label class="form-label">Customization Type</label>
            <div>
                <input type="radio" id="custom_type_text" name="custom_type" value="text" {{ isset($product) && $product->custom_type == 'text' ? 'checked' : '' }}>
                <label for="custom_type_text">Text</label>
                &nbsp;&nbsp;
                <input type="radio" id="custom_type_image" name="custom_type" value="image" {{ isset($product) && $product->custom_type == 'image' ? 'checked' : '' }}>
                <label for="custom_type_image">Image</label>
                &nbsp;&nbsp;
                <input type="radio" id="custom_type_both" name="custom_type" value="both" {{ isset($product) && $product->custom_type == 'both' ? 'checked' : '' }}>
                <label for="custom_type_both">Both</label>
            </div>
        </div>

        {{-- <div class="mb-3" id="cust_description_field" style="{{ isset($product) && $product->customize == 1 ? '' : 'display: none;' }}">
            <label class="form-label" for="cust_description">Custom Description</label>
            <textarea class="form-control" id="cust_description" name="cust_description" placeholder="Enter custom product description">{{ isset($product) ? $product->cust_description : '' }}</textarea>
        </div> --}}
    </div>

    <div class="col-6">
        <label class="form-label" for="quantity">Quantity <span class="text-danger">*</span></label>
        <input type="number" class="form-control" value="{{ isset($product) && $product->quantity != null ? $product->quantity : '' }}" id="quantity" placeholder="Enter Quantity" name="quantity" aria-label="Quantity" required min="1">
    </div>

    <div class="row mb-3 mt-3 align-items-center">
        <div class="col-6">
            <label class="form-label" for="height">Height <span class="text-muted">(Optional)</span></label>
            <input type="number" class="form-control" value="{{ isset($product) && $product->height != null ? $product->height : '' }}" id="height" placeholder="Enter Height" name="height" aria-label="Height">
        </div>
        <div class="col-6 mt-4">
            <select class="select2 form-control" name="height_unit" id="height_unit">
                <option value="">Select Unit</option>
                <option value="mm" {{ isset($product) && $product->height_unit == 'mm' ? "selected='selected'" : '' }}>mm</option>
                <option value="cm" {{ isset($product) && $product->height_unit == 'cm' ? "selected='selected'" : '' }}>cm</option>
                <option value="in" {{ isset($product) && $product->height_unit == 'in' ? "selected='selected'" : '' }}>in</option>
                <option value="m" {{ isset($product) && $product->height_unit == 'm' ? "selected='selected'" : '' }}>m</option>
            </select>
            <div class="invalid-feedback" id="height-unit-error">Please select a unit for height.</div>
        </div>
        <div class="col-6">
            <label class="form-label" for="width">Width <span class="text-muted">(Optional)</span></label>
            <input type="text" class="form-control" value="{{ isset($product) && $product->width != null ? $product->width : '' }}" id="width" placeholder="Enter Width" name="width" aria-label="Width">
        </div>
        <div class="col-6 mt-4">
            <select class="select2 form-control" name="width_unit" id="width_unit">
                <option value="">Select Unit</option>
                <option value="mm" {{ isset($product) && $product->width_unit == 'mm' ? "selected='selected'" : '' }}>mm</option>
                <option value="cm" {{ isset($product) && $product->width_unit == 'cm' ? "selected='selected'" : '' }}>cm</option>
                <option value="in" {{ isset($product) && $product->width_unit == 'in' ? "selected='selected'" : '' }}>in</option>
                <option value="m" {{ isset($product) && $product->width_unit == 'm' ? "selected='selected'" : '' }}>m</option>
            </select>
            <div class="invalid-feedback" id="width-unit-error">Please select a unit for width.</div>
        </div>
        <div class="col-6">
            <label class="form-label" for="weight">Weight <span class="text-muted">(Optional)</span></label>
            <input type="text" class="form-control" value="{{ isset($product) && $product->weight != null ? $product->weight : '' }}" id="weight" placeholder="Enter Weight" name="weight" aria-label="Weight">
        </div>
        <div class="col-6 mt-4">
            <select class="select2 form-control" name="weight_unit" id="weight_unit">
                <option value="">Select Unit</option>
                <option value="g" {{ isset($product) && $product->weight_unit == 'g' ? "selected='selected'" : '' }}>g</option>
                <option value="kg" {{ isset($product) && $product->weight_unit == 'kg' ? "selected='selected'" : '' }}>kg</option>
            </select>
            <div class="invalid-feedback" id="weight-unit-error">Please select a unit for weight.</div>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label" for="warranty">Warranty</label>
        <input type="text" class="form-control" id="warranty" name="warranty" value="{{ isset($product) ? $product->warranty : '' }}" placeholder="e.g. 1 Year Manufacturer Warranty">
    </div>

    <div class="mb-3">
        <label class="form-label" for="return_policy">Return Policy</label>
        <input type="text" class="form-control" id="return_policy" name="return_policy" value="{{ isset($product) ? $product->return_policy : '' }}" placeholder="e.g. 10 Days Return Policy">
    </div>

    <div class="mb-3">
        <label class="form-label" for="delivery_mode">Delivery Mode</label>
        <input type="text" class="form-control" id="delivery_mode" name="delivery_mode" value="{{ isset($product) ? $product->delivery_mode : '' }}" placeholder="e.g. Home Delivery">
    </div>
    <div class="text-end"><button type="submit" class="btn btn-success">Save</button></div>
</form>