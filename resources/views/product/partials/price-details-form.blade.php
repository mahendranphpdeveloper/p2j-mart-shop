<form id="price_form" class="needs-validation" novalidate onsubmit="return false">
    @csrf
    <div class="mb-3">
        <label class="form-label" for="product-price">Base Price (M.R.P)</label>
        <input type="number" class="form-control" id="product-price" placeholder="Price" name="base_price" value="{{ isset($product) && $product->web_price != null ? $product->web_price : '' }}" aria-label="Product price" required="">
    </div>

    {{-- Discounted Price (Commented Out in Original) --}}
    {{-- <div class="mb-3">
        <label class="form-label" for="discount-price">Discounted Price</label>
        <input type="number" class="form-control" id="discount-price" placeholder="Discounted Price" name="discount_price" aria-label="Product discounted price" value="{{ isset($product) && $product->web_discount_price != null ? $product->web_discount_price : '' }}" required="">
    </div> --}}

    {{-- In stock (Commented Out in Original) --}}
    {{-- <div class="mb-3 col ecommerce-select2-dropdown">
        <label class="form-label mb-1" for="status-org">In Stock</label>
        <select id="stock" class="select2 form-select" data-placeholder="Select Status" name="in_stock" required="">
            <option value="0" {{ isset($product) && $product->web_status == 0 ? "selected='selected'" : "" }}>Available</option>
            <option value="1" {{ isset($product) && $product->web_status == 1 ? "selected='selected'" : "" }}>Not Available</option>
        </select>
    </div> --}}

    <div class="mb-3 col ecommerce-select2-dropdown">
        <label class="form-label mb-1" for="collection">Collection</label>
        <select id="collection" class="select2 form-select" data-placeholder="Collection" name="collection">
            <option selected value="0" {{ isset($product) && $product->collection == 0 ? "selected='selected'" : "" }}>None</option>
            <option value="1" {{ isset($product) && $product->collection == 1 ? "selected='selected'" : "" }}>Trending collections</option>
        </select>
    </div>
    <div class="text-end"><button type="submit" class="btn btn-success">Save</button></div>
</form>