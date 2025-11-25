@extends('layouts.commonMaster')
@section('layoutContent')
@section('title', 'All Products |')

    <style>
        @charset "UTF-8";

        .bootstrap-tagsinput {
            margin: 0;
            width: 100%;
            padding: 0.5rem 0.75rem 0;
            font-size: 1rem;
            line-height: 1.25;
            transition: border-color 0.15s ease-in-out;
        }

        .bootstrap-tagsinput.has-focus {
            background-color: #681320;
            border-color: #5cb3fd;
        }

        .bootstrap-tagsinput .label-info {
            display: inline-block;
            background-color: #681320;
            padding: 0 0.4em 0.15em;
            border-radius: 0.25rem;
            margin-bottom: 0.4em;
        }

        .bootstrap-tagsinput input {
            margin-bottom: 0.5em;
        }

        .bootstrap-tagsinput .tag [data-role=remove]:after {
            content: "×";
            padding: 1px 2px;
        }

        .addalert {
            border: 1px solid red !important;
        }

        .color-show {
            display: inline-block;
            width: 15px;
            height: 15px;
            border-radius: 3px;
            border: 1px solid #000000;
            margin-right: 5px;
        }

        .image-content {
            display: flex;
            width: 150px;
            height: 100px;
            border: 1px solid #bdc6d2;
            border-radius: 10px;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            background: #e1e5ec;
            position: relative;
        }

        .image-content img {
            position: absolute;
            width: 100%;
            height: 100%;
        }

        .image-content span {
            position: absolute;
            z-index: 99999;
            right: -10px;
            top: -10px;
            border-radius: 50%;
            background: red;
            color: #fff;
            width: 25px;
            height: 25px;
            padding: 0px 1px 0px 5px;
            cursor: pointer;
        }

        .image-content span i {
            font-size: 15px;
        }

        .image-content label {
            width: 100% !important;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .image-content label i {
            font-weight: 1000;
            font-size: 20px;
        }

        .bootstrap-tagsinput {
            border: 1px solid #b8b3b3;
            border-radius: 5px;
        }

        .bootstrap-tagsinput input {
            border: none;
            outline: none;
        }

        .bootstrap-tagsinput .label-info {
            color: #fff
        }

        ul.nav.nav-tabs.nav-fill {
            display: flex;
            flex-wrap: nowrap;
            flex-wrap: nowrap;
        }

        button.nav-link {
            padding: 10px 3px !important;
        }

        .sm-del-btn {
            position: absolute;
            right: -6px;
            top: 23px;
            background-color: red;
            color: #fff;
            padding: 4px 6px;
            font-size: 8px !important;
            border-radius: 4px;
            box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
            cursor: pointer;
            z-index: 1;
        }

        .alert-success {
            background-color: #e8fadf;
            border-color: #d4f5c3;
            color: #71dd37;
            padding: 8px 22px;
        }
    </style>
    <style>
        /* styles for the custom dropdown */
        .custom-dropdown {
            position: relative;
            display: inline-block;
            width: 150px;
            line-height: inherit;
            text-transform: capitalize;
        }

        .dropdown-selected {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 5px;
            /*border: 1px solid #ccc;*/
            cursor: pointer;
            font-size: 16px;
        }

        .dropdown-selected span {
            display: flex;
            align-items: center;
        }

        .dropdown-options {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            border: 1px solid #ccc;
            border-top: none;
            background-color: #fff;
            z-index: 10;
            max-height: 280px;
            overflow: auto;
        }

        .dropdown-option {
            padding: 5px;
            display: flex;
            align-items: center;
            cursor: pointer;
            font-size: 13px;
            text-transform: none;
        }

        .dropdown-option:hover {
            background-color: #f0f0f0;
        }

        .color-show {
            display: inline-block;
            width: 15px;
            height: 15px;
            border-radius: 3px;
            border: 1px solid #000000;
            margin-right: 5px;
        }

        .dropdown-options::-webkit-scrollbar {
            width: 0;
            height: 0;
        }

        /* Hide scrollbar for Firefox */
        .dropdown-options {
            scrollbar-width: none;
            /* Firefox */
            -ms-overflow-style: none;
            /* Internet Explorer 10+ */
        }

        .dropdown-options.visible {
            display: block !important;
        }
    </style>
    <!-- Content wrapper -->
    <div class="content-wrapper">

        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">

            <div class="py-3 mb-4">
                <span class="text-muted fw-light">
                    <h4> Products /
                </span><span> Add Product</span></h4>
                <div class="d-none val-message alert alert-success position-absolute">
                    Your changes saved successfully
                </div>
                <div class="d-flex justify-content-end">
                    <a href="{{route('products.show', ['product' => $_GET['subcategory_id']])}}"
                        class=" btn btn-secondary">Back</a>
                </div>
            </div>

            <div class="app-ecommerce">

                <div class="row">

                    <!-- First column-->
                    <div class="col-12 col-lg-12">
                        <!-- Product Information -->
                        <div class="col-xl-12 mt-2">

                            <div class="nav-align-top   mb-4">

                                <ul class="nav nav-tabs nav-fill" role="tablist">

                                    <li class="nav-item">
                                        <button type="button" class="nav-link d-flex justify-content-between active"
                                            role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-home"
                                            aria-controls="navs-justified-home" aria-selected="true">
                                            <div class="col-md-10"> <i class="tf-icons bx bx-receipt"></i> Basic Details
                                            </div>
                                            <div class="col-md-2">
                                                <span
                                                    class="badge rounded-pill d-none  basic_detail_alert badge-center ml-3 h-px-20 w-px-20 bg-label-danger">
                                                    <i style="font-weight: 600;" class='bx bx-x'></i>
                                                </span>
                                                <span
                                                    class="badge rounded-pill {{isset($product) && $product->step1 == 1 ? '' : 'd-none'}} basic_detail_alert badge-center ml-3 h-px-20 w-px-20 bg-label-success">
                                                    <i style="font-weight: 600;" class='bx bx-check'></i>
                                                </span>
                                            </div>
                                        </button>
                                    </li>

                                    <!--<li class="nav-item">-->
                                    <!--    <button-->
                                    <!--        type="button"-->
                                    <!--        class="nav-link"-->
                                    <!--        role="tab"-->
                                    <!--        data-bs-toggle="tab"-->
                                    <!--        data-bs-target="#navs-justified-profile"-->
                                    <!--        aria-controls="navs-justified-profile"-->
                                    <!--        aria-selected="false" {{isset($product) && $product->step1 ==1  ?"":"disabled"}}-->
                                    <!--        >-->
                                    <!--        <div class="col-md-10"> <i class="tf-icons bx bx-purchase-tag"></i> Price Details</div>-->
                                    <!--        <div class="col-md-2">-->
                                    <!--            <span class="badge rounded-pill {{(!isset($product)?'d-none':(($product->step2 == 1)?'d-none':''))}} price_detail_alert badge-center ml-3 h-px-20 w-px-20 bg-label-danger">-->
                                    <!--                <i style="font-weight: 600;" class='bx bx-x'></i>-->
                                    <!--            </span>-->
                                    <!--            <span class="badge rounded-pill {{(!isset($product)?'d-none':(($product->step2 != 1)?'d-none':''))}} price_detail_alert badge-center ml-3 h-px-20 w-px-20 bg-label-success">-->
                                    <!--                <i style="font-weight: 600;" class='bx bx-check'></i>-->
                                    <!--            </span>-->
                                    <!--        </div>-->

                                    <!--    </button>-->
                                    <!--</li>-->

                                    <li class="nav-item">
                                        <button type="button" class="nav-link d-flex justify-content-between" role="tab"
                                            data-bs-toggle="tab" data-bs-target="#navs-justified-messages"
                                            aria-controls="navs-justified-messages" aria-selected="false" {{ (isset($product) && $product->step2 == 1) || (isset($product->step4) && $product->step4 == 1) ? "" : "disabled" }}>

                                            <div class="col-md-10"> <i class="tf-icons bx bx-code-alt"></i> Unit List</div>
                                            <div class="col-md-2">
                                                <span
                                                    class="badge rounded-pill {{(!isset($product) ? 'd-none' : (($product->step3 == 1) || (isset($product->step4) && $product->step4 == 1) ? 'd-none' : ''))}} unit_detail_alert badge-center ml-3 h-px-20 w-px-20 bg-label-danger">
                                                    <i style="font-weight: 600;" class='bx bx-x'></i>
                                                </span>
                                                <span
                                                    class="badge rounded-pill {{(!isset($product) ? 'd-none' : (($product->step2 != 1) || (isset($product->step4) && $product->step4 != 1) ? 'd-none' : ''))}} unit_detail_alert badge-center ml-3 h-px-20 w-px-20 bg-label-success">
                                                    <i style="font-weight: 600;" class='bx bx-check'></i>
                                                </span>
                                            </div>

                                        </button>
                                    </li>

                                    <li class="nav-item">
                                        <button type="button" class="nav-link d-flex justify-content-between step-3 "
                                            role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-image"
                                            aria-controls="navs-justified-image" aria-selected="false" {{isset($product) && $product->step4 == 1 ? "" : "disabled"}}>

                                            <div class="col-md-10"> <i class="tf-icons bx bx-image-add"></i> Images Details
                                            </div>
                                            <div class="col-md-2">
                                                <span
                                                    class="badge rounded-pill {{(!isset($product) ? 'd-none' : (($product->step4 == 1) ? 'd-none' : ''))}} image_detail_alert badge-center ml-3 h-px-20 w-px-20 bg-label-danger">
                                                    <i style="font-weight: 600;" class='bx bx-x'></i>
                                                </span>
                                                <span
                                                    class="badge rounded-pill {{(!isset($product) ? 'd-none' : (($product->step4 != 1) ? 'd-none' : ''))}} image_detail_alert badge-center ml-3 h-px-20 w-px-20 bg-label-success">
                                                    <i style="font-weight: 600;" class='bx bx-check'></i>
                                                </span>
                                            </div>

                                        </button>
                                    </li>

                                    <li class="nav-item">
                                        <button type="button" class="nav-link d-flex justify-content-between" role="tab"
                                            data-bs-toggle="tab" data-bs-target="#navs-justified-meta-title"
                                            aria-controls="navs-justified-meta-title" aria-selected="false"
                                            {{isset($product) && $product->step4 == 1 ? "" : "disabled"}}>
                                            <div class="col-md-10"> <i class="tf-icons bx bx-key"></i> Meta Title</div>
                                            <div class="col-md-2">
                                                <!-- <span class="badge rounded-pill {{(!isset($product)?'d-none':(($product->step5 != 1)?'d-none':''))}} key_detail_alert badge-center ml-3 h-px-20 w-px-20 bg-label-danger">
                                                    <i style="font-weight: 600;" class='bx bx-x'></i>
                                                </span> -->
                                                <span
                                                    class="badge rounded-pill {{(!isset($product) ? 'd-none' : (($product->step4 != 1) ? 'd-none' : ''))}} meta_title badge-center ml-3 h-px-20 w-px-20 bg-label-success">
                                                    <i style="font-weight: 600;" class='bx bx-check'></i>
                                                </span>
                                            </div>

                                        </button>
                                    </li>

                                    <li class="nav-item">
                                        <button type="button" class="nav-link d-flex justify-content-between" role="tab"
                                            data-bs-toggle="tab" data-bs-target="#navs-justified-keypoint"
                                            aria-controls="navs-justified-keypoint" aria-selected="false"
                                            {{isset($product->step4) && $product->step4 == 1 ? "" : "disabled"}}>
                                            <div class="col-md-10"> <i class="tf-icons bx bx-key"></i> Key Words</div>
                                            <div class="col-md-2">
                                                <!-- <span class="badge rounded-pill {{(!isset($product)?'d-none':(($product->step5 != 1)?'d-none':''))}} key_detail_alert badge-center ml-3 h-px-20 w-px-20 bg-label-danger">
                                                    <i style="font-weight: 600;" class='bx bx-x'></i>
                                                </span> -->
                                                <span
                                                    class="badge rounded-pill {{(!isset($product) ? 'd-none' : (($product->step5 != 1) ? 'd-none' : ''))}} key_detail_alert badge-center ml-3 h-px-20 w-px-20 bg-label-success">
                                                    <i style="font-weight: 600;" class='bx bx-check'></i>
                                                </span>
                                            </div>

                                        </button>
                                    </li>

                                    <li class="nav-item">
                                        <button type="button" class="nav-link d-flex justify-content-between" role="tab"
                                            data-bs-toggle="tab" data-bs-target="#navs-justified-meta-description"
                                            aria-controls="navs-justified-meta-description" aria-selected="false"
                                            {{isset($product) && $product->step4 == 1 ? "" : "disabled"}}>
                                            <div class="col-md-10"> <i class="tf-icons bx bx-edit"></i>Description</div>
                                            <div class="col-md-2">
                                                <!-- <span class="badge rounded-pill {{(!isset($product)?'d-none':(($product->step5 != 1)?'d-none':''))}} key_detail_alert badge-center ml-3 h-px-20 w-px-20 bg-label-danger">
                                                    <i style="font-weight: 600;" class='bx bx-x'></i>
                                                </span> -->
                                                <span
                                                    class="badge rounded-pill {{(!isset($product) ? 'd-none' : (($product->step4 != 1) ? 'd-none' : ''))}} meta_desc  badge-center ml-3 h-px-20 w-px-20 bg-label-success">
                                                    <i style="font-weight: 600;" class='bx bx-check'></i>
                                                </span>
                                            </div>

                                        </button>
                                    </li>

                                </ul>

                                <div class="tab-content">

                                    <div class="tab-pane fade show active" id="navs-justified-home" role="tabpanel">
                                        <input id="project_id" value="{{(isset($_GET["pid"])) ? $_GET["pid"] : 0}}"
                                            type="hidden">
                                        <input id="category_id"
                                            value="{{(isset($_GET["subcategory_id"])) ? $_GET["subcategory_id"] : 0}}"
                                            type="hidden">
                                        <form id="basic_form" class="needs-validation" novalidate onsubmit="return false">
                                            @csrf
                                            <div class="mb-3">
                                                <label class="form-label" for="ecommerce-product-name">Name</label>
                                                <input type="text" class="form-control" id="ecommerce-product-name"
                                                    placeholder="Product title"
                                                    value="{{isset($product) && $product->product_name != null ? $product->product_name : ""}}"
                                                    name="name" aria-label="Product title" required>
                                            </div>

                                            <!-- Description -->
                                            <div>
                                                <label class="form-label">Description</label>

                                                <textarea class="form-control" id="description" name="description"
                                                    required>{{isset($product) && $product->description != null ? $product->description : ""}}</textarea>

                                            </div>
                                            <div class="mt-3 mb-3 col ecommerce-select2-dropdown">

                                                <label class="form-label mb-3">Collection <span
                                                        class="text-muted">(Optional)</span></label>



                                                <div>
                                                    <input type="radio" id="collection_none" name="collection" value="0" {{ isset($product) && $product->collection == 0 ? "checked" : "" }}>
                                                    <label for="collection_none">None</label>
                                                    &nbsp;&nbsp;

                                                    <input type="radio" id="collection_trending" name="collection" value="1"
                                                        {{ isset($product) && $product->collection == 1 ? "checked" : "" }}>
                                                    <label for="collection_trending">Trending Collections</label>
                                                    &nbsp;&nbsp;

                                                    <input type="radio" id="collection_featured" name="collection" value="2"
                                                        {{ isset($product) && $product->collection == 2 ? "checked" : "" }}>
                                                    <label for="collection_featured">Featured Products</label>
                                                    &nbsp;&nbsp;

                                                    <input type="radio" id="collection_exclusive" name="collection"
                                                        value="3" {{ isset($product) && $product->collection == 3 ? "checked" : "" }}>
                                                    <label for="collection_exclusive">Exclusive Products</label>
                                                </div>


                                                <div class="mb-3 mt-4">
                                                    <label class="form-label">Customize Product <span
                                                            class="text-muted">(Optional)</span></label>
                                                    <div>
                                                        <input type="radio" id="customize_no" name="customize" value="0" {{ isset($product) && $product->customize == 0 ? 'checked' : '' }}>
                                                        <label for="customize_no">No</label>
                                                        &nbsp;&nbsp;
                                                        <input type="radio" id="customize_yes" name="customize" value="1" {{ isset($product) && $product->customize == 1 ? 'checked' : '' }}>
                                                        <label for="customize_yes">Yes</label>
                                                    </div>
                                                </div>

                                                <div class="mb-3" id="customize_options_field"
                                                    style="{{ isset($product) && $product->customize == 1 ? '' : 'display: none;' }}">
                                                    <label class="form-label">Customization Type</label>
                                                    <div>
                                                        <input type="radio" id="custom_type_text" name="custom_type"
                                                            value="text" {{ isset($product) && $product->custom_type == 'text' ? 'checked' : '' }}>
                                                        <label for="custom_type_text">Text</label>
                                                        &nbsp;&nbsp;
                                                        <input type="radio" id="custom_type_image" name="custom_type"
                                                            value="image" {{ isset($product) && $product->custom_type == 'image' ? 'checked' : '' }}>
                                                        <label for="custom_type_image">Image</label>
                                                        &nbsp;&nbsp;
                                                        <input type="radio" id="custom_type_both" name="custom_type"
                                                            value="both" {{ isset($product) && $product->custom_type == 'both' ? 'checked' : '' }}>
                                                        <label for="custom_type_both">Both</label>
                                                    </div>
                                                </div>

                                                <!--<div class="mb-3" id="cust_description_field" style="{{ isset($product) && $product->customize == 1 ? '' : 'display: none;' }}">-->
                                                <!--    <label class="form-label" for="cust_description">Custom Description</label>-->
                                                <!--    <textarea class="form-control" id="cust_description" name="cust_description"-->
                                                <!--              placeholder="Enter custom product description">{{ isset($product) ? $product->cust_description : '' }}</textarea>-->
                                                <!--</div>-->
                                            </div>

                                            <div class="col-6">
                                                <label class="form-label" for="quantity">Quantity <span
                                                        class="text-danger">*</span></label>
                                                <input type="number" class="form-control"
                                                    value="{{ isset($product) && $product->quantity != null ? $product->quantity : '' }}"
                                                    id="quantity" placeholder="Enter Quantity" name="quantity"
                                                    aria-label="Quantity" required min="1">
                                            </div>

                                            <div class="row mb-3 mt-3 align-items-center">
                                                <div class="col-6">
                                                    <label class="form-label" for="height">Height <span
                                                            class="text-muted">(Optional)</span></label>
                                                    <input type="number" class="form-control"
                                                        value="{{ isset($product) && $product->height != null ? $product->height : '' }}"
                                                        id="height" placeholder="Enter Height" name="height"
                                                        aria-label="Height">
                                                </div>
                                                <div class="col-6 mt-4">
                                                    <select class="select2 form-control" name="height_unit"
                                                        id="height_unit">
                                                        <option value="">Select Unit</option>
                                                        <option value="mm" {{ isset($product) && $product->height_unit == 'mm' ? "selected='selected'" : '' }}>mm</option>
                                                        <option value="cm" {{ isset($product) && $product->height_unit == 'cm' ? "selected='selected'" : '' }}>cm</option>
                                                        <option value="in" {{ isset($product) && $product->height_unit == 'in' ? "selected='selected'" : '' }}>in</option>
                                                        <option value="m" {{ isset($product) && $product->height_unit == 'm' ? "selected='selected'" : '' }}>m</option>
                                                    </select>
                                                    <div class="invalid-feedback" id="height-unit-error">Please select a
                                                        unit for height.</div>
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label" for="width">Width <span
                                                            class="text-muted">(Optional)</span></label>
                                                    <input type="text" class="form-control"
                                                        value="{{ isset($product) && $product->width != null ? $product->width : '' }}"
                                                        id="width" placeholder="Enter Width" name="width"
                                                        aria-label="Width">
                                                </div>
                                                <div class="col-6 mt-4">
                                                    <select class="select2 form-control" name="width_unit" id="width_unit">
                                                        <option value="">Select Unit</option>
                                                        <option value="mm" {{ isset($product) && $product->width_unit == 'mm' ? "selected='selected'" : '' }}>mm</option>
                                                        <option value="cm" {{ isset($product) && $product->width_unit == 'cm' ? "selected='selected'" : '' }}>cm</option>
                                                        <option value="in" {{ isset($product) && $product->width_unit == 'in' ? "selected='selected'" : '' }}>in</option>
                                                        <option value="m" {{ isset($product) && $product->width_unit == 'm' ? "selected='selected'" : '' }}>m</option>
                                                    </select>
                                                    <div class="invalid-feedback" id="width-unit-error">Please select a unit
                                                        for width.</div>
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label" for="weight">Weight <span
                                                            class="text-muted">(Optional)</span></label>
                                                    <input type="text" class="form-control"
                                                        value="{{ isset($product) && $product->weight != null ? $product->weight : '' }}"
                                                        id="weight" placeholder="Enter Weight" name="weight"
                                                        aria-label="Weight">
                                                </div>
                                                <div class="col-6 mt-4">
                                                    <select class="select2 form-control" name="weight_unit"
                                                        id="weight_unit">
                                                        <option value="">Select Unit</option>
                                                        <option value="g" {{ isset($product) && $product->weight_unit == 'g' ? "selected='selected'" : '' }}>g</option>
                                                        <option value="kg" {{ isset($product) && $product->weight_unit == 'kg' ? "selected='selected'" : '' }}>kg</option>
                                                    </select>
                                                    <div class="invalid-feedback" id="weight-unit-error">Please select a
                                                        unit for weight.</div>
                                                </div>
                                            </div>


                                            <div class="mb-3">
                                                <label class="form-label" for="warranty">Warranty</label>
                                                <input type="text" class="form-control" id="warranty" name="warranty"
                                                    value="{{ isset($product) ? $product->warranty : '' }}"
                                                    placeholder="e.g. 1 Year Manufacturer Warranty">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label" for="return_policy">Return Policy</label>
                                                <input type="text" class="form-control" id="return_policy"
                                                    name="return_policy"
                                                    value="{{ isset($product) ? $product->return_policy : '' }}"
                                                    placeholder="e.g. 10 Days Return Policy">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label" for="delivery_mode">Delivery Mode</label>
                                                <input type="text" class="form-control" id="delivery_mode"
                                                    name="delivery_mode"
                                                    value="{{ isset($product) ? $product->delivery_mode : '' }}"
                                                    placeholder="e.g. Home Delivery">
                                            </div>
                                            <div class="text-end"><button type="submit"
                                                    class="btn btn-success">Save</button></div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="navs-justified-profile" role="tabpanel">
                                        <form id="price_form" class="needs-validation" novalidate onsubmit="return false">
                                            @csrf
                                            <div class="mb-3">
                                                <label class="form-label" for="product-price">Base Price (M.R.P)</label>
                                                <input type="number" class="form-control" id="product-price"
                                                    placeholder="Price" name="base_price"
                                                    value="{{isset($product) && $product->web_price != null ? $product->web_price : ""}}"
                                                    aria-label="Product price" required="">
                                            </div>
                                            <!-- Discounted Price -->
                                            <!--<div class="mb-3">-->
                                            <!--    <label class="form-label" for="discount-price">Discounted-->
                                            <!--        Price</label>-->
                                            <!--    <input type="number" class="form-control" id="discount-price"-->
                                            <!--           placeholder="Discounted Price" name="discount_price"-->
                                            <!--           aria-label="Product discounted price"-->
                                            <!--           value="{{isset($product) && $product->web_discount_price != null ?$product->web_discount_price :""}}" required="">-->
                                            <!--</div>-->


                                            <!-- In stock -->
                                            <!--<div class="mb-3 col ecommerce-select2-dropdown">-->
                                            <!--    <label class="form-label mb-1" for="status-org">In Stock-->
                                            <!--    </label>-->
                                            <!--    <select id="stock" class="select2 form-select" data-placeholder="Select Status"-->
                                            <!--            name="in_stock" required="">-->

                                            <!--        <option value="0" {{isset($product) && $product->web_status == 0 ?"selected='selected'":""}} >Available</option>-->
                                            <!--        <option value="1" {{isset($product) && $product->web_status == 1 ?"selected='selected'":""}} >Not Available</option>-->
                                            <!--    </select>-->
                                            <!--</div>-->

                                            <div class="mb-3 col ecommerce-select2-dropdown">
                                                <label class="form-label mb-1" for="collection">Collection
                                                </label>
                                                <select id="collection" class="select2 form-select"
                                                    data-placeholder="Collection" name="collection">
                                                    <option selected value="0" {{isset($product) && $product->collection == 0 ? "selected='selected'" : ""}}>None</option>
                                                    <option value="1" {{isset($product) && $product->collection == 1 ? "selected='selected'" : ""}}>Trending collections</option>
                                                </select>
                                            </div>
                                            <div class="text-end"><button type="submit"
                                                    class="btn btn-success">Save</button></div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="navs-justified-messages" role="tabpanel">
                                        <div class="alert alert-danger" role="alert" style="display: none">
                                            tast msg text
                                        </div>
                                        <form id="unit_form" class="needs-validation" novalidate onsubmit="return false">
                                            @csrf
                                            <div class="row d-flex justify-content-center badge bg-label-secondary">
                                               
                                                <div class="col-md-2">
                                                    <label class="form-label" for="basic-default-fullname">Unit
                                                        Price</label>
                                                    <input type="number" class="form-control" id="unit_price"
                                                        placeholder="Price" name="unit_price">
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="form-label" for="basic-default-fullname">MRP</label>
                                                    <input type="number" class="form-control" id="mrp_price"
                                                        placeholder="Price" name="mrp_price">
                                                </div>
                                           
                                               
                                                <!-- <div class="col-md-2">
                                                    <label class="form-label" for="basic-default-fullname">Color</label>
                                                    <select id="product_color" class="select2 form-select" data-placeholder="Select Color"
                                                            name="product_color" required="">
                                                        <option value="">Select</option>
                                                        @foreach($UnitColor as $_color)
                                                        <option value="{{$_color->m_color_id}}" > {{$_color->color_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div> -->


                                                <div class="col-md-2">
                                                    <label class="form-label d-block"
                                                        for="basic-default-fullname">Color</label>
                                                    <div class="custom-dropdown form-control ">
                                                        <div class="dropdown-selected" id="dropdown-selected">
                                                            <span>Select</span>
                                                            <div>▾</div>
                                                        </div>
                                                        <div class="dropdown-options" id="dropdown-options">
                                                            <!-- Options will be added dynamically -->
                                                        </div>
                                                    </div>
                                                    <select id="product_color" class="select2 "
                                                        data-placeholder="Select Color" name="m_color_id" required=""
                                                        style="display: none;">
                                                        <option value="">Select</option>
                                                        <!-- Options will be added dynamically -->
                                                    </select>
                                                </div>
                                                @if (isset($dynamicAttributes) && count($dynamicAttributes) > 0)
                                                @foreach($dynamicAttributes as $dynamic)
                                                    @php
                                                        $attribute = $dynamic['attribute'];
                                                        $options = $dynamic['options'];
                                                        $attribute_slug = $attribute['attribute_slug'] ?? $attribute->attribute_slug ?? '';
                                                        $attribute_name = $attribute['attribute_name'] ?? $attribute->attribute_name ?? '';
                                                        $attribute_label = ucwords(str_replace('_', ' ', $attribute_name));
                                                    @endphp
                                                    <div class="col-md-2 mb-3">
                                                        <label class="form-label d-block" for="unit_{{ $attribute_slug }}">{{ $attribute_label }}</label>
                                                        <select class="form-control" name="m_{{ $attribute_slug }}_id" id="unit_{{ $attribute_slug }}">
                                                            <option value="">Select</option>
                                                            @foreach($options as $option)
                                                                @php
                                                                    // Determine ID and label per attribute type
                                                                    // Priority: standard names, fallback to 1st string/int found
                                                                    $option_id = '';
                                                                    $option_label = '';
                                                                    
                                                                    // Guess key for ID based on slug
                                                                    $slug = $attribute_slug ?? '';
                                                                    if ($slug === 'design' && isset($option->m_design_id)) {
                                                                        $option_id = $option->m_design_id;
                                                                        $option_label = $option->design_name ?? '';
                                                                    } elseif ($slug === 'size' && isset($option->m_size_id)) {
                                                                        $option_id = $option->m_size_id;
                                                                        $option_label = $option->size_name ?? '';
                                                                    } elseif ($slug === 'material' && isset($option->m_material_id)) {
                                                                        $option_id = $option->m_material_id;
                                                                        $option_label = $option->material_name ?? '';
                                                                    } elseif ($slug === 'unit' && isset($option->id)) {
                                                                        $option_id = $option->id;
                                                                        $option_label = $option->name ?? '';
                                                                    }
                                                                    // Try more heuristics/fallbacks
                                                                    if (!$option_id) {
                                                                        // Try to grab any property ending "_id"
                                                                        foreach ($option->getAttributes() as $key => $val) {
                                                                            if (str_ends_with($key, '_id')) {
                                                                                $option_id = $val;
                                                                            }
                                                                            if (!$option_label && (str_ends_with($key, '_name') || $key === 'name' || $key === 'title')) {
                                                                                $option_label = $val;
                                                                            }
                                                                        }
                                                                    }
                                                                    // If still missing, try first two scalars
                                                                    if (!$option_id || !$option_label) {
                                                                        $found_id = false; $found_label = false;
                                                                        foreach ($option->getAttributes() as $val) {
                                                                            if (!$found_id && (is_int($val) || is_string($val))) {
                                                                                $option_id = $option_id ?: $val;
                                                                                $found_id = true;
                                                                            } elseif (!$found_label && (is_string($val) || is_numeric($val)) && $val !== $option_id) {
                                                                                $option_label = $option_label ?: $val;
                                                                                $found_label = true;
                                                                            }
                                                                            if ($found_id && $found_label) break;
                                                                        }
                                                                    }
                                                                    // Capitalize label
                                                                    $option_label = ucwords(str_replace('_', ' ', $option_label));
                                                                @endphp
                                                                <option value="{{ $option_id }}">{{ $option_label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @endforeach
                                            @endif




                                                <div class="col-md-2">
                                                  <label class="form-label" for="basic-default-fullname">Products Stock</label>
                                                    <input type="number" class="form-control" min="0" id="product_stock" name="stock" required="">
                                                </div>
                                                <div class="col-md-2  d-flex align-items-center" style="margin-top: 16px;">
                                                    <input id="unit_id" type="hidden" value="0">
                                                    {{-- <input id="copy_unit_id" name="copy_unit_id"  type="hidden" value="0"> --}}
                                                    <button type="submit" class="btn btn-success mx-2">Save</button>
                                                    <button type="reset"
                                                        {{-- onclick="$(this).addClass('d-none');$('#unit_id').val(0); " --}}
                                                        id="unitreset" class="btn btn-danger ">close</button>
                                                </div>
                                        </form>
                                    </div>
                                    <div class="card-datatable table-responsive mt-3">
                                        <table id="unitlist_table" class="datatables-customers table border-top">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Unit Price</th>
                                                    <th>MRP</th>
                                                    <th>Color</th>
                                                    @foreach($dynamicAttributes as $dynamicAttribute)
                                                        <th>{{ ucwords(str_replace('_', ' ', $dynamicAttribute['attribute']->attribute_slug)) }}</th>
                                                    @endforeach
                                                     <th>Stock</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="navs-justified-image" role="tabpanel">
                                    <div class="demo-inline-spacing mt-3">
                                        <div class="list-group" id="image-view-content">



                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade " id="navs-justified-keypoint" role="tabpanel">
                                    <label>Meta Keyword</label>
                                    <input type="text" class="form-control mb-2" value="" id="keypoint"
                                        data-role="tagsinput" />
                                    <div class="mt-1 small text-muted">Use , and Enter key to add multiple titles </div>
                                    <!--<div class="text-end mt-1" ><button type="submit" id="keypointsave" class="btn btn-success">Save</button></div>-->

                                </div>

                                <div class="tab-pane fade " id="navs-justified-meta-title" role="tabpanel">
                                    <label>Meta title</label>
                                    <input type="text" class="form-control mb-2" value="" id="metatitle" />

                                    <!--<div class="text-end mt-1" ><button type="submit" id="savemetatitle" class="btn btn-success">Save</button></div>-->

                                </div>

                                <div class="tab-pane fade " id="navs-justified-meta-description" role="tabpanel">
                                    <label>Meta description</label>
                                    <input type="text" class="form-control mb-2" value="" id="metadescription" />
                                    <!--<div class="text-end mt-2" ><button type="submit" id="savemetadescription" class="btn btn-success">Save</button></div>-->

                                </div>

                            </div>

                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>
    </div>
    <!-- / Content -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.js"></script>

    <script src="{{ asset('assets/vendor/bootstrap-tagsinput.js') }}" type="text/javascript"></script>

    <script>

        $('#unit_form').on('reset', function () {
            $('#unit_id').val(0);
            $('#product_color').val('');
            $('#dropdown-selected span').text('Select');
            $('#navs-justified-messages .alert.alert-danger')
            .hide()
            // $('#unitreset').addClass('d-none');
        });
    </script>

    <script>

        $(document).ready(function () {
            // Function to validate a single input-unit pair
            function validateUnit(inputId, unitId, errorId) {
                const inputVal = $(`#${inputId}`).val().trim();
                const unitVal = $(`#${unitId}`).val();
                const errorField = $(`#${errorId}`);

                if (inputVal && !unitVal) {
                    $(`#${unitId}`).addClass('is-invalid');
                    errorField.show();
                    return false;
                } else {
                    $(`#${unitId}`).removeClass('is-invalid');
                    errorField.hide();
                    return true;
                }
            }

            // Real-time validation on input change
            $('#height, #width, #weight').on('input', function () {
                const inputId = this.id;
                const unitId = `${inputId}_unit`;
                const errorId = `${inputId}-unit-error`;
                validateUnit(inputId, unitId, errorId);
            });

            // Real-time validation on unit change
            $('#height_unit, #width_unit, #weight_unit').on('change', function () {
                const unitId = this.id;
                const inputId = unitId.replace('_unit', '');
                const errorId = `${inputId}-unit-error`;
                validateUnit(inputId, unitId, errorId);
            });

            // Form submission validation
            $('#basic_form').submit(function (e) {
                var form1 = $(this);
                var isValid = true;

                // Reset previous validation states
                form1.find('.is-invalid').removeClass('is-invalid');
                form1.find('.invalid-feedback').hide();

                // Validate height
                if (!validateUnit('height', 'height_unit', 'height-unit-error')) {
                    isValid = false;
                }

                // Validate width
                if (!validateUnit('width', 'width_unit', 'width-unit-error')) {
                    isValid = false;
                }

                // Validate weight
                if (!validateUnit('weight', 'weight_unit', 'weight-unit-error')) {
                    isValid = false;
                }

                // Standard form validation for required fields
                form1.find(':input').each(function () {
                    if (!$(this)[0].checkValidity()) {
                        $(this).addClass('is-invalid');
                        isValid = false;
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    e.stopPropagation();
                    return false;
                }

                // Proceed with AJAX submission
                e.preventDefault();
                var data = $(this).serialize() + "&pid=" + $("#project_id").val() + "&subcategory_id=" + $("#category_id").val();

                $.ajax({
                    url: '{{ route("storebasicdetails") }}',
                    type: "POST",
                    data: data,
                    dataType: 'json',
                }).done(function (res) {
                    if (res["error_code"] == 200) {
                        $("#project_id").val(res["product_id"]);
                        $('[data-bs-target="#navs-justified-messages"]').prop('disabled', false).click();
                        $('.price_detail_alert.bg-label-success').removeClass("d-none");
                        $('.val-message').removeClass('d-none');
                        setTimeout(function () {
                            $('.val-message').addClass('d-none');
                        }, 2000);
                    }
                }).fail(function () {
                    // Handle failure
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const customDropdown = document.getElementById('custom-dropdown');
            const selected = document.getElementById('dropdown-selected');
            const optionsContainer = document.getElementById('dropdown-options');
            const selectElement = document.getElementById('product_color');

            // Example dynamic data
            const data = [
                @foreach($UnitColor as $_color)

                    { value: '{{$_color->m_color_id}}', text: '{{$_color->color_name}}', color: '{{$_color->color_code}}' },
                @endforeach
            // Add more options as needed
        ];


            // Function to toggle the dropdown visibility
            selected.addEventListener('click', (event) => {
                optionsContainer.classList.toggle('visible');
                event.stopPropagation(); // Prevent the click event from bubbling up
            });

            // Function to hide the dropdown when clicking outside
            document.addEventListener('click', () => {
                optionsContainer.classList.remove('visible');
            });

            // Function to hide the dropdown on scroll
            window.addEventListener('scroll', () => {
                optionsContainer.classList.remove('visible');
            });


            // Function to add options to the dropdown and the hidden select element
            data.forEach(item => {
                const option = document.createElement('div');
                option.classList.add('dropdown-option');
                option.dataset.value = item.value;

                const colorBox = document.createElement('div');
                colorBox.classList.add('color-show');
                colorBox.style.background = item.color;

                const optionText = document.createElement('span');
                optionText.textContent = item.text;

                option.appendChild(colorBox);
                option.appendChild(optionText);

                option.addEventListener('click', () => {
                    selected.innerHTML = `<span>${colorBox.outerHTML} ${item.text}</span><div>&#9662;</div>`;
                    selectElement.value = item.value; // Update the hidden select element's value
                    optionsContainer.style.display = 'none';
                });

                optionsContainer.appendChild(option);

                // Add the corresponding option to the hidden select element
                const selectOption = document.createElement('option');
                selectOption.value = item.value;
                selectOption.textContent = item.text;
                selectElement.appendChild(selectOption);
            });
        });

    </script>

    <script>
        var productKeyPoint = {!! json_encode($productkeypoint) !!};

        var keys = productKeyPoint.map(function (item) {
            return item.key;
        });
        $('#keypoint').val(keys);
        // Meta title
        var metatitle = {!! json_encode($metatitle) !!};
        var metatitle = metatitle.map(function (item) {
            return item.title;
        });
        $('#metatitle').val(metatitle);
        //Meta Description

        var metadescription = {!! json_encode($metadescription) !!};
        var metadescription = metadescription.map(function (item) {
            return item.description;
        });
        $('#metadescription').val(metadescription);

    </script>
    <script>

        let ta;
        var pid = 0;
        $('#keypoint').tagsinput({
            trimValue: true,
            confirmKeys: [13, 44],
            focusClass: 'my-focus-class'
        });
        $('#basic_form').submit(function (e) {

            var form1 = $(this);
            form1.find(':input').each(function () {
                if (!$(this)[0].checkValidity()) {
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });
            if (!form1[0].checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            } else {
                let self = $(this);
                e.preventDefault(); // prevent default submit behavior
                self.prop('disabled', true);
                var data = $(this).serialize() + "&pid=" + $("#project_id").val() + "&subcategory_id=" + $("#category_id").val(); // get form data

                $.ajax({
                    url: '{{ route("storebasicdetails") }}',
                    type: "POST",
                    data: data,
                    dataType: 'json',
                }).done(function (res) {
                    if (res["error_code"] == 200) {
                        $("#project_id").val(res["product_id"]);
                        // $("#project_id").val(res["product_id"]);

                        // $('[data-bs-target="#navs-justified-profile"]').prop('disabled', false).click();

                        // $('.basic_detail_alert.bg-label-success').removeClass("d-none");

                        // $('.basic_detail_alert.bg-label-danger').addClass("d-none");

                        // $('.val-message').removeClass('d-none');

                        // setTimeout(function(){

                        //     $('.val-message').addClass('d-none');

                        //   }, 2000);



                        $('[data-bs-target="#navs-justified-messages"]').prop('disabled', false).click();

                        $('.price_detail_alert.bg-label-success').removeClass("d-none");

                        // $('.price_detail_alert.bg-label-danger').removeClass("d-none");
                        $('.val-message').removeClass('d-none');
                        setTimeout(function () {
                            $('.val-message').addClass('d-none');
                        }, 2000);
                    } else {

                    }


                }).fail(function () {

                })
            }
        });
        $('#price_form').submit(function (e) {

            var form1 = $(this);
            form1.find(':input').each(function () {
                if (!$(this)[0].checkValidity()) {
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });
            if (!form1[0].checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            } else {
                let self = $(this);
                e.preventDefault(); // prevent default submit behavior
                self.prop('disabled', true);
                var data = $(this).serialize() + "&pid=" + $("#project_id").val(); // get form data

                $.ajax({
                    url: '{{ route("pricebasicdetails") }}',
                    type: "POST",
                    data: data,
                    dataType: 'json',
                }).done(function (res) {
                    if (res["error_code"] == 200) {
                        $('[data-bs-target="#navs-justified-messages"]').prop('disabled', false).click();
                        $('.price_detail_alert.bg-label-success').removeClass("d-none");
                        // $('.price_detail_alert.bg-label-danger').removeClass("d-none");
                        $('.val-message').removeClass('d-none');
                        setTimeout(function () {
                            $('.val-message').addClass('d-none');
                        }, 2000);
                        unitList();

                    } else {

                    }


                }).fail(function () {

                })
            }
        });
        $('#unit_form').submit(function (e) {
           
            var form1 = $(this);
            form1.find(':input').each(function () {
                if (!$(this)[0].checkValidity()) {
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });
            if (!form1[0].checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            } else {
                let self = $(this);
                e.preventDefault(); // prevent default submit behavior
                self.prop('disabled', true);
                var data = $(this).serialize() + "&pid=" + $("#project_id").val() + "&uid=" + $("#unit_id").val(); // get form data
                console.log(data);
                $.ajax({
                    url: '{{ route("storeUnitdetails") }}',
                    type: "POST",
                    data: data,
                    dataType: 'json',
                }).done(function (res) {

                    if (res["error_code"] == 200) {
                        sno = 0;
                        unitList();
                        try {
                            ta.ajax.reload();
                        } catch (r) { }

                        $('[data-bs-target="#navs-justified-image"]').prop('disabled', false);
                        $('.unit_detail_alert.bg-label-success').removeClass("d-none");
                        $('.unit_detail_alert.bg-label-danger').addClass("d-none");
                        // Hide the info alert and clear its content after success
                        $('#navs-justified-messages .alert.alert-danger')
                            .hide()
                            .text('');
                    } else if (res["error_code"] == 409) {
                        // Show error message in the .alert.alert-danger div (visible)
                        $('#navs-justified-messages .alert.alert-danger')
                            .show()
                            .text(res.message || "A unit with the same attributes already exists for this product.");
                        $('.unit_detail_alert.bg-label-success').addClass("d-none");
                        $('.unit_detail_alert.bg-label-danger').addClass("d-none");
                    } else {
                        $('#navs-justified-messages .alert.alert-danger')
                            .show()
                            .text(res.message || "Something went wrong. Please try again.");
                        $('.unit_detail_alert.bg-label-success').addClass("d-none");
                        $('.unit_detail_alert.bg-label-danger').addClass("d-none");
                    }

                }).fail(function () {
                    // Network or unexpected error: show message in .alert.alert-danger div
                    $('#navs-justified-messages .alert.alert-danger')
                        .show()
                        .text("Network error. Please try again.");
                    $('.unit_detail_alert.bg-label-success').addClass("d-none");
                    $('.unit_detail_alert.bg-label-danger').addClass("d-none");
                })
            }
        });
        $(document).ready(function () {

            pid = $("#project_id").val();
            unitList();
            //                                                         $.ajax({
            //                                                                url: '{{ route("deleteProductImages") }}',
            //                                                                type: "POST",
            //                                                                data: {'pid': $("#project_id").val(),
            //                                                                        _token: '{{ csrf_token() }}'
            //                                                                       },
            //                                                                dataType: 'json',
            //                                                            }).done(function (res) {
            //                                                                if (res["error_code"] == 200) {
            //
            //                                                                } else {
            //
            //                                                                }
            //
            //
            //                                                            }).fail(function () {
            //
            //                                                            })
        });
        function unitList() {
            sno = 0;
            ta = $("#unitlist_table").DataTable({
                ajax: {
                    url: '{{ route("getUnitList") }}',
                    method: 'POST',
                    data: {
                        'pid': $("#project_id").val(),
                        _token: '{{ csrf_token() }}'
                    },
                    dataSrc: function (res) {
                        console.log('getUnitList response:', res); // responce console log
                        return res.data || [];
                    }
                },
                columns: [
                    {
                        className: "text-center",
                        render: function (data, type, row, meta) {
                            return (meta.row + 1);
                        }
                    },
                  
                    {
                        className: "text-center",
                        render: function (data, type, row) {
                            return `<span class="color-show-price">₹ ${row['unit_price'] !== undefined && row['unit_price'] !== null ? row['unit_price'] : ''}</span>`;
                        }
                    },
                    // MRP Price column
                    {
                        className: "text-center",
                        render: function (data, type, row) {
                            return `<span class="color-show-mrp-price">${(row['mrp_price'] !== undefined && row['mrp_price'] !== null && row['mrp_price'] !== '' && !isNaN(row['mrp_price'])) ? '₹ ' + row['mrp_price'] : ''}</span>`;
                        }
                    },
                    // Color display column
                    {
                        className: "text-center",
                        render: function (data, type, row) {
                            let colorName = row['color_name'] !== undefined && row['color_name'] !== null ? row['color_name'] : '';
                            let colorCode = row['color_code'] !== undefined && row['color_code'] !== null ? row['color_code'] : '#transparent';
                            return `<span class="color-show" style="background:${colorCode}"></span>${colorName}`;
                        }
                    },
                    // Serial No. column
                    
                    // Dynamic attribute columns
                    @foreach($dynamicAttributes as $dynamicAttribute)
                        { 
                            data: "{{ $dynamicAttribute['attribute']->attribute_slug }}_name",
                            className: "text-center"
                        },
                    @endforeach

                    {data: "stock"},
                    // Actions column
                    {
                        className: "text-end w-20",
                        render: function (data, type, row) {
                            // Safely fallback to blank if any param is missing for copyData
                            const sizeId = row['m_size_id'] !== undefined ? `'${row['m_size_id']}'` : "''";
                            const unitPrice = row['unit_price'] !== undefined ? `'${row['unit_price']}'` : "''";
                            const mrpPrice = row['mrp_price'] !== undefined ? `'${row['mrp_price']}'` : "''";
                            const materialId = row['m_material_id'] !== undefined ? `'${row['m_material_id']}'` : "''";
                            const designId = row['m_design_id'] !== undefined ? `'${row['m_design_id']}'` : "''";
                            const colorId = row['m_color_id'] !== undefined ? `'${row['m_color_id']}'` : "''";
                            const productUnitId = row['product_unit_id'] !== undefined ? row['product_unit_id'] : '';
                            const colorName = row['color_name'] !== undefined ? row['color_name'] : '';
                            const qty = row['stock'] !== undefined ? row['stock'] : '';

                            // Build dynamic attribute data-* props for update button
                            let dynamicAttrs = '';
                            let dynamicArray = [];
                            @foreach($dynamicAttributes as $dynamicAttribute)
                                dynamicAttrs += ` data-{{ $dynamicAttribute['attribute']->attribute_slug }}="${row['m_{{ $dynamicAttribute['attribute']->attribute_slug }}_id'] !== undefined ? row['m_{{ $dynamicAttribute['attribute']->attribute_slug }}_id'] : ''}"`;
                                dynamicArray.push(row['m_{{ $dynamicAttribute['attribute']->attribute_slug }}_id'] !== undefined ? row['m_{{ $dynamicAttribute['attribute']->attribute_slug }}_id'] : '');
                            @endforeach

                            return `
                                <button 
                                    type="button" 
                                    class="copy_data btn btn-icon btn-outline-warning"
                                    onclick="copyData(${productUnitId},${sizeId},${unitPrice},${mrpPrice},${materialId},${designId},${colorId}, ${JSON.stringify(dynamicArray)},${qty})">
                                    <i class='bx bx-copy-alt'></i>
                                </button>
                                <button
                                    type="button"
                                    data-qty="${qty}"
                                    data-mrp-price="${row['mrp_price'] !== undefined ? row['mrp_price'] : ''}"
                                    data-price="${row['unit_price'] !== undefined ? row['unit_price'] : ''}"
                                    data-id="${productUnitId}"
                                    data-color="${row['m_color_id']}"
                                    data-colorname="${colorName}"
                                    ${dynamicAttrs}
                                    class="update_data btn mx-2 btn-icon btn-outline-primary"
                                >
                                    <span class="tf-icons bx bx-pencil"></span>
                                </button>
                                <button 
                                    type="button" 
                                    data-id="${productUnitId}" 
                                    class="btn delete unitdelete btn-icon btn-outline-danger"
                                >
                                    <span class="tf-icons bx bxs-trash"></span>
                                </button>
                            `;
                        }
                    }
                ],
                language: {
                    sLengthMenu: "_MENU_",
                    search: "",
                    searchPlaceholder: "Search Matrial"
                },
                "lengthChange": false,
                "pageLength": 10,
                "searching": false,
                destroy: true


            });
        }

        $(document).on("change", ".product_upload", function () {
            //
            var file = this.files[0];
            if (!file) {

                return;
            }
            var content = $(this).data('content');

            
            // Debug log
            console.log("File selected for upload:", file);
            console.log("Data attributes:",
                "content:", content,
                "imageunit:", $(this).data('imageunit'),
                "imagecount:", $(this).data('imagecount'),
                "project_id:", $("#project_id").val()
            );

            var process_bar = $(`.${content} .progress-bar`);
            process_bar.html('0%').css('width', '0%');


            var formData = new FormData();
            formData.append('product_images', file);
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('imageunit', $(this).data('imageunit'));
            formData.append('imagecount', $(this).data('imagecount'));
            formData.append('pid', $("#project_id").val());
            console.log('Uploading file:', file);
            for (let pair of formData.entries()) {
                console.log(pair[0]+ ':', pair[1]);
            }

            $.ajax({
                url: '{{ route("uploadImages") }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                xhr: function () {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener('progress', function (evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = (evt.loaded / evt.total) * 100;
                            process_bar.html(percentComplete.toFixed(2) + '%').width(percentComplete + '%');
                        }
                    }, false);
                    return xhr;
                },
                success: function (data) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        $(`.${content} img`).attr('src', e.target.result).removeClass('d-none').css('background', '#e1eff5');

                    }
                    reader.readAsDataURL(file);
                    process_bar.html('0%').css('width', '0%');
                    $(`.${content} .image-delete`).removeClass('d-none');
                    $('[data-bs-target="#navs-justified-keypoint"]').prop('disabled', false);
                    $('[data-bs-target="#navs-justified-meta-title"]').prop('disabled', false);
                    $('[data-bs-target="#navs-justified-meta-description"]').prop('disabled', false);
                    $('.image_detail_alert.bg-label-success').removeClass("d-none");
                    $('.image_detail_alert.bg-label-danger').addClass("d-none");
                    $('.val-message').removeClass('d-none');
                    setTimeout(function () {
                        $('.val-message').addClass('d-none');
                    }, 2000);
                }
            });
        });

        var product_url = '{{asset('uploads/products')}}';
        $(document).on("click", '[data-bs-target="#navs-justified-image"]', function () {
            $.ajax({
                url: '{{ route("getProductImage") }}',
                type: "POST",
                data: {
                    'pid': $("#project_id").val(),
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
            }).done(function (res) {
                if (res["error_code"] == 200) {
                    $("#image-view-content").html('');
                    // For every unit, show unit/color details above the images, then show image slots.
                    $.each(res["images"], function (index, image) {
                        // Display the unit/color info - you can add more unit info as needed
                        var _res = `
                            <div class="unit-header mb-2 px-2 py-1 bg-light rounded border">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="fw-bold">${image.color_name || 'No Color'}</span>
                                    <span class="color-show" style="background:${image.color_code}; width: 20px; height: 20px; display: inline-block; border-radius: 5px; border: 1px solid #ccc;"></span>
                                </div>
                                <div class="small text-muted">
                                    Unit ID: <b>${image.product_unit_id || '-'}</b>
                                    &nbsp;|&nbsp;
                                    Product Image ID: <b>${image.product_image_id || '-'}</b>
                                </div>
                            </div>
                            <div class="row mt-2 mb-4">`;
                        // Show up to 5 image slots for this unit
                        for (var i = 1; i < 6; i++) {
                            _res += `
                                <div class="col-md-2 mx-2">                  
                                    <div class="image-content img-con-${i}-${image.product_image_id}">
                                        <span class="${(image['web_image_' + i] != null) ? '' : 'd-none'} image-delete" data-imageunit="${image.product_image_id}" data-imagecount="${i}" data-content="img-con-${i}-${image.product_image_id}"><i class='bx bxs-trash'></i></span>
                                        <input accept=".png, .jpg, .jpeg" data-imageunit="${image.product_image_id}" data-imagecount="${i}" class="product_upload" type="file" data-content="img-con-${i}-${image.product_image_id}" id="product_upload_${image.product_image_id}_${i}" style="display: none">
                                        <img class="${(image['web_image_' + i] != null) ? '' : 'd-none'}" style="${(image['web_image_' + i] != null) ? 'background:#e1eff5' : ''}" src="${(image['web_image_' + i] != null) ? (product_url + '/' + image['web_image_' + i]) : ''}">
                                        <label for="product_upload_${image.product_image_id}_${i}"><i class='bx bx-plus'></i> Add Image </label>
                                        <div class="progress w-100">
                                            <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                                0%
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                        }
                        // Optionally show video fields below the image list
                        _res += `
                            <div class="mt-3 mb-2 d-none">
                                <label>Video Link</label>
                                <input class="form-control video-url" data-pro-image-id="${image.product_image_id}" type="text" name="web_video" value="${image.web_video ? image.web_video : ''}">
                            </div>
                            <form id="upload-video" enctype="multipart/form-data">
                                <div class="mt-3 mb-3">
                                    <label>Upload Video</label>
                                    <input class="form-control video-file" id="video-file" data-pro-image-id="${image.product_image_id}" type="file" name="web_video" value="${image.web_video ? image.web_video : ''}">
                                </div>
                                <div style="position:relative;width: fit-content;" class="${image.web_video ? '' : 'd-none'}">
                                    <div class="sm-del-btn" id="delete-video" data-imageunit="${image.product_image_id}">
                                        <i class='bx bxs-trash'></i>
                                    </div>
                                    <video width="320" height="240" autoplay controls>
                                        <source src="{{asset('uploads/products/videos') . '/'}}${image.web_video ? image.web_video : ''}" type="video/mp4">
                                    </video>
                                </div>
                            </form>
                        </div>
                        `;
                        $("#image-view-content").append(_res);
                    });
                } else {
                    $("#image-view-content").html('<h3>No Unit List</h3>')
                }


            }).fail(function () {

            })
        })

        $(document).on("click", ".image-delete", function () {
            var content = $(this).data('content');
            $.ajax({
                url: '{{ route("deleteProductImages") }}',
                type: "POST",
                data: {
                    'pid': $("#project_id").val(),
                    _token: '{{ csrf_token() }}',
                    imageunit: $(this).data('imageunit'),
                    imagecount: $(this).data('imagecount')
                },
                dataType: 'json',
            }).done(function (res) {
                if (res["error_code"] == 200) {

                    var process_bar = $(`.${content} .progress-bar`);
                    process_bar.html('0%').css('width', '0%');
                    $(`.${content} img`).addClass('d-none');
                    $(`.${content} .image-delete`).addClass('d-none');

                } else {

                }


            }).fail(function () {

            })



        })

        $(document).on("change", "#keypoint", function () {

            $.ajax({
                url: '{{ route("saveWordProduct") }}',
                type: "POST",
                data: {
                    'pid': $("#project_id").val(),
                    _token: '{{ csrf_token() }}',
                    keypoint: $("#keypoint").val(),
                },
                dataType: 'json',
            }).done(function (res) {
                if (res["error_code"] == 200) {
                    $('.key_detail_alert.bg-label-success').removeClass("d-none");
                    $('.key_detail_alert.bg-label-danger').addClass("d-none");
                    $('.val-message').removeClass('d-none');
                    setTimeout(function () {
                        $('.val-message').addClass('d-none');
                    }, 3000);
                } else {

                }
            }).fail(function () {
            })
        });

        $(document).on("input", "#metatitle", function () {

            $.ajax({
                url: '{{ route("savemetatitle") }}',
                type: "POST",
                data: {
                    'pid': $("#project_id").val(),
                    _token: '{{ csrf_token() }}',
                    input: $("#metatitle").val(),
                },
                dataType: 'json',
            }).done(function (res) {
                if (res["error_code"] == 200) {
                    $('.meta_title').removeClass("d-none");
                    //  $('.key_detail_alert.bg-label-danger').addClass("d-none");
                    $('.val-message').removeClass('d-none');
                    setTimeout(function () {
                        $('.val-message').addClass('d-none');
                    }, 2000);
                } else {

                }
            }).fail(function () {
            })
        });

        $(document).on("input", "#metadescription", function () {

            $.ajax({
                url: '{{ route("savemetadescription") }}',
                type: "POST",
                data: {
                    'pid': $("#project_id").val(),
                    _token: '{{ csrf_token() }}',
                    input: $("#metadescription").val(),
                },
                dataType: 'json',
            }).done(function (res) {
                if (res["error_code"] == 200) {
                    $('.meta_desc').removeClass("d-none");
                    //  $('.key_detail_alert.bg-label-danger').addClass("d-none");
                    $('.val-message').removeClass('d-none');
                    setTimeout(function () {
                        $('.val-message').addClass('d-none');
                    }, 3000);
                } else {

                }
            }).fail(function () {
            })
        });


        $(document).on('click', '.unitdelete', function () {
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
                        url: '{{ route("deleteUnitList") }}',
                        method: 'GET',
                        dataType: 'json',
                        data: {
                            uid: $(this).data('id'),
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
            // Get all data attributes in an object
            $('#navs-justified-messages .alert.alert-danger')
            .hide()
            const data = $(this).data();
            console.log(data);
            var colorValue = $(this).data('color');

                var selectElement = document.getElementById('product_color');
                selectElement.value = colorValue;
                var event = new Event('change');
                selectElement.dispatchEvent(event);

            // Standard fields mapping: data-attribute => input/select ID
            const mapping = {
                color: "#product_color",            
                id: "#unit_id",
                price: "#unit_price",
                mrpPrice: "#mrp_price",
                qty: "#product_stock"
            };

                $('#dropdown-selected span').text($(this).data('colorname'));
    
                    $('#product_color').val(colorValue).trigger("change");
           

            // Iterate mapped fields and assign if present in data
            Object.keys(mapping).forEach(function(key) {
                // Skip color (handled above)
                if (key === 'color') return;
                if (data[key] !== undefined) {
                    $(mapping[key]).val(data[key]).trigger("change");
                }
            });

            // If there are any other dynamic attributes (e.g., ramsize, storage, etc)
            // whose input fields are named as: "#product_" + key
            Object.keys(data).forEach(function(key) {
                if (
                    key === 'color' ||
                    key === 'colorname' ||
                    Object.keys(mapping).includes(key)
                ) return;

                const inputId = '#unit_' + key;
                if ($(inputId).length) {
                    $(inputId).val(data[key]).trigger("change");
                }
            });

            // Always show the reset button
            $('#unitreset').removeClass('d-none');
        });

        // chengeb
        function copyData(productUnitId = '', size = '', unit_price = '', mrp = '', type = '', design = '', color = '',  dynamicAttrs = [], qty = '',) {
            $('#navs-justified-messages .alert.alert-danger')
            .hide();
            $('#unit_id').val(0);
            // $('#copy_unit_id').val(productUnitId);
            $('#product_size').val(size);

            $('#unit_price').val(unit_price);
            $('#mrp_price').val(mrp);
            $('#product_material').val(type);
            $('#product_design').val(design);
            $('#product_stock').val(parseInt(qty, 10) || 0);

            $('#product_color').val(color).trigger("change");
            const selectedText = $('#product_color option[value="' + color + '"]').text() || 'Select';
            $('#dropdown-selected span').text(selectedText);

            // If dynamic attributes are passed, update for each
            if (Array.isArray(dynamicAttrs)) {
                @foreach($dynamicAttributes as $index => $dynamicAttribute)
                    if (typeof dynamicAttrs[{{$index}}] !== 'undefined') {
                        $('#unit_{{ $dynamicAttribute["attribute"]->attribute_slug }}').val(dynamicAttrs[{{$index}}]).trigger("change");
                    }
                @endforeach
            }
        }

        $(document).on('change', '.video-file', function () {

            var formData = new FormData();
            var file = $('.video-file').prop('files')[0];
            formData.append('web_video', file);
            formData.append('image_id', $(this).data('pro-image-id'));
            formData.append('_token', '{{ csrf_token() }}');

            $.ajax({
                url: '{{ route("uploadvideo") }}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response['error_code'] == 200)
                        $('[data-bs-target="#navs-justified-image"]').click();
                    $('.val-message').removeClass('d-none');
                    setTimeout(function () {
                        $('.val-message').addClass('d-none');

                    }, 2000);
                },
                error: function (xhr, status, error) {

                    console.error(xhr.responseText);
                }
            });
        });
        $(document).on("click", "#delete-video", function () {

            var unit_id = $(this).data('imageunit');
            $.ajax({
                url: '{{ route("deletevideo") }}',
                type: "POST",
                data: {
                    'pid': $("#project_id").val(),
                    _token: '{{ csrf_token() }}',
                    imageunit: unit_id,
                },
                dataType: 'json',
            }).done(function (res) {
                if (res["error_code"] == 200) {

                    $('[data-bs-target="#navs-justified-image"]').click();
                } else {

                }


            }).fail(function () {

            });



        });


        $(document).on('change', '.video-url', function () {

            console.log('img id : ' + $(this).data('pro-image-id'));


            $.ajax({
                url: '{{ route("uploadImages") }}',
                method: 'POST',
                data: {
                    image_id: $(this).data('pro-image-id'),
                    video_url: $(this).val(),
                    _token: '{{ csrf_token() }}',
                },
                success: function (response) {
                    if (response['error_code'] == 200)
                        ta.ajax.reload();
                    $('.val-message').removeClass('d-none');
                    setTimeout(function () {
                        $('.val-message').addClass('d-none');
                    }, 2000);
                },
                error: function (error) {
                    console.error('Error deleting item:', error);
                }

            });

        });

        document.addEventListener('DOMContentLoaded', function () {
            const customizeYes = document.getElementById('customize_yes');
            const customizeNo = document.getElementById('customize_no');
            const custDescriptionField = document.getElementById('cust_description_field');
            const customizeOptionsField = document.getElementById('customize_options_field');

            // Function to toggle visibility
            function toggleCustomFields() {
                if (customizeYes.checked) {
                    customizeOptionsField.style.display = 'block';
                    custDescriptionField.style.display = 'block';
                } else {
                    customizeOptionsField.style.display = 'none';
                    custDescriptionField.style.display = 'none';
                }
            }

            // Add event listeners
            customizeYes.addEventListener('change', toggleCustomFields);
            customizeNo.addEventListener('change', toggleCustomFields);

            // Initialize on page load
            toggleCustomFields();
        });

    </script>


@endsection