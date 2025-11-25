@extends('layouts.commonMaster')
@section('layoutContent')
<script src="{{ asset('assets/js/app-ecommerce-product-add.js') }}"></script>
<style>
   .img-thumbs {
  background: #eee;
  border: 1px solid #ccc;
  border-radius: 0.25rem;
  margin: 1.5rem 0;
  padding: 0.75rem;
}
.img-thumbs-hidden {
  display: none;
}

.wrapper-thumb {
  position: relative;
  display:inline-block;
  margin: 1rem 0;
  justify-content: space-around;
}

.img-preview-thumb {
  background: #fff;
  border: 1px solid none;
  border-radius: 0.25rem;
  box-shadow: 0.125rem 0.125rem 0.0625rem rgba(0, 0, 0, 0.12);
  margin-right: 1rem;
  max-width: 140px;
  padding: 0.25rem;
}

.remove-btn{
  position:absolute;
  display:flex;
  justify-content:center;
  align-items:center;
  font-size:.7rem;
  top:-5px;
  right:10px;
  width:20px;
  height:20px;
  background:white;
  border-radius:10px;
  font-weight:bold;
  cursor:pointer;
}

.remove-btn:hover{
  box-shadow: 0px 0px 3px grey;
  transition:all .3s ease-in-out;
}
</style>
<!-- Content wrapper -->
<div class="content-wrapper">

    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Products /</span><span> Add Product</span>
        </h4>
        @if($errors->any())
        <div>
            <ul>
                <div class="alert alert-danger" style="padding-left:30px;">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </div>
            </ul>
        </div>
        @endif
        <div class="app-ecommerce">
            <form action="{{route('products.store')}}" id="addProducts" method="post" enctype="multipart/form-data">
                @csrf

                @if(isset($product[0]->id))
                <input type="hidden" name="is_edit" value="{{$product[0]->id}}">
                @endif
                <!-- Add Product -->
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">

                    <div class="d-flex flex-column justify-content-center">
                        <h4 class="mb-1 mt-3">Add a new Product</h4>
                        <!-- <p class="text-muted">Orders placed across your store</p> -->
                    </div>

                    <div class="d-flex align-content-center flex-wrap gap-3">
                        <button class="btn btn-label-secondary">Discard</button>
                        <button type="submit" class="btn btn-primary">Publish product</button>
                    </div>

                </div>

                <div class="row">

                    <!-- First column-->
                    <div class="col-12 col-lg-8">
                        <!-- Product Information -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-tile mb-0">Product information</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label" for="ecommerce-product-name">Name</label>
                                    <input type="text" class="form-control" id="ecommerce-product-name"
                                        value="{{isset($product[0]->name) ? $product[0]->name:''}}"
                                        placeholder="Product title" name="name" aria-label="Product title">
                                </div>

                                <!-- Description -->
                                <div>
                                    <label class="form-label">Description</label>
                                    <div class="form-control p-0 pt-1">

                                        <div class="comment-editor border-0 pb-4" id="product-description">
                                        </div>
                                        <input type="hidden" id="description" name="description">

                                    </div>
                                </div>
                                <div class="row mb-3 mt-3 align-items-center">
                                    <div class="col-6"><label class="form-label" for="height">Height
                                            <span class="text-muted">(Optional)</span></label>
                                        <input type="number" class="form-control" id="height" placeholder="Enter Height"
                                            name="height" aria-label="Height"
                                            value="{{isset($product[0]->height) ? $product[0]->height:''}}">

                                    </div>
                                    <div class="col-6 mt-4">
                                        <select class="select2 form-control" name="height_unit">
                                            <option value="">Select Unit</option>
                                            <option value="mm" {{isset($product) && ($product[0]->height_unit == 'mm' )
                                                ? 'selected' :''}} >mm</option>
                                            <option value="cm" {{isset($product) && ($product[0]->height_unit == 'cm' )
                                                ? 'selected' :''}}>cm</option>
                                            <option value="in" {{isset($product) && ($product[0]->height_unit == 'in' )
                                                ? 'selected' :''}}>in</option>
                                            <option value="m" {{isset($product) && ($product[0]->height_unit == 'm' )
                                                ? 'selected' :''}}>m</option>
                                        </select>
                                    </div>
                                    <div class="col-6"><label class="form-label" for="width">Width</label>
                                        <input type="text" class="form-control" id="width" placeholder="Enter width"
                                            name="width" aria-label="Width"
                                            value="{{isset($product[0]->width) ? $product[0]->width:''}}">
                                    </div>
                                    <div class="col-6 mt-4">
                                        <select class="select2 form-control" name="width_unit">
                                            <option value="">Select Unit</option>
                                            <option value="mm" {{isset($product) && ($product[0]->width_unit == 'mm' )
                                                ? 'selected' :''}} >mm</option>
                                            <option value="cm" {{isset($product) && ($product[0]->width_unit == 'cm' )
                                                ? 'selected' :''}}>cm</option>
                                            <option value="in" {{isset($product) && ($product[0]->width_unit == 'in' )
                                                ? 'selected' :''}}>in</option>
                                            <option value="m" {{isset($product) && ($product[0]->width_unit == 'm' )
                                                ? 'selected' :''}}>m</option>

                                        </select>
                                    </div>
                                    <div class="col-6"><label class="form-label" for="Weight">Weight</label>
                                        <input type="text" class="form-control" id="weight" placeholder="Enter Weight"
                                            name="weight" aria-label="Weight"
                                            value="{{isset($product[0]->weight) ? $product[0]->weight:''}}">
                                    </div>
                                    <div class="col-6 mt-4">
                                        <select class="select2 form-control" name="weight_unit">
                                            <option value="">Select Unit</option>
                                            <option value="g" {{isset($product) && ($product[0]->weight_unit == 'g' )
                                                ? 'selected' :''}} >g</option>
                                            <option value="kg" {{isset($product) && ($product[0]->weight_unit == 'kg' )
                                                ? 'selected' :''}} >kg</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Product Information -->
                        <!-- Media -->
                        <!-- Image -->
                        <div class="card mb-4">
                            <div class="px-4 py-2 mb-3">
                                <label class="form-label" for="image">Upload Image</label>
                                <input class="form-control" type="file" id="image" name="images">




                                <div>
                                    @if(isset($product[0]->images) )
                                    <img src="{{asset('uploads/products').'/'.$product[0]->images}}"
                                        class="custom-image" id="imagePreview">
                                    @endif
                                </div>

                            </div>
                        </div>
                        <!-- /Media -->
                        <!-- Variants -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Variants</h5>
                            </div>
                            <div class="card-body">
                                <form class="form-repeater">
                                    <div data-repeater-list="group-a">
                                        <div data-repeater-item>
                                            <div class="row">

                                                <div class="mb-3 col-6">
                                                    <label class="form-label">Size <span class="text-muted">(Use Enter
                                                            Key to Add Multiple sizes)</span></label>
                                                    <input type="text" class="form-control" name="size"
                                                        value="{{isset($product[0]->size) ? $product[0]->size:''}}"
                                                        placeholder="Enter the size" />
                                                </div>

                                                <div class="col-6"></div>

                                                <div class="mb-3 col-6">
                                                    <div>
                                                        <label class="form-label">Color <span class="text-muted">(Select
                                                                the color and Enter the color code )</span></label>
                                                    </div>
                                                    <input type="text" id="color" name="color"
                                                        value="{{isset($product[0]->color) ? $product[0]->color:''}}">
                                                </div>

                                                <div class="col-6 align-items-center" id="colorPicker">
                                                    <div id="colorDisplay"></div>
                                                    <label class="form-label">Color <span class="text-muted">(You can
                                                            get the color code by selecting a color )</span></label>
                                                    <input type="color" id="picker" onchange="updateColor()" />
                                                    <p id="colorCode"><span id="codeValue">#000000</span></p>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                        <!-- /Variants -->

                        <div class="container my-5">
  <h3 class="text-center">Multiple Upload Images and Remove Button </h3>
  <div class="row">
    <div class="col">
      <!-- <form action="" method="post" enctype="multipart/form-data" id="form-upload"> -->
        <div class="form-group mt-5">
          <label for="">Choose Images</label>
          <input type="file" class="form-control" name="multipleimages[]" multiple id="upload-img" />
        </div>
        <div class="img-thumbs img-thumbs-hidden" id="img-preview"></div>
        <!-- <button type="submit" class="btn btn-dark">Upload</button> -->
      <!-- </form> -->
     </div>
   </div>

</div>


                    </div>
                    <!-- /Second column -->

                    <!-- Second column -->
                    <div class="col-12 col-lg-4">
                        <!-- Pricing Card -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Pricing</h5>
                            </div>
                            <div class="card-body">
                                <!-- Base Price -->
                                <div class="mb-3">
                                    <label class="form-label" for="product-price">Base Price</label>
                                    <input type="number" class="form-control" id="product-price" placeholder="Price"
                                        name="base_price" aria-label="Product price"
                                        value="{{isset($product[0]->base_price) ? $product[0]->base_price:''}}">
                                </div>
                                <!-- Discounted Price -->
                                <div class="mb-3">
                                    <label class="form-label" for="discount-price">Discounted
                                        Price</label>
                                    <input type="number" class="form-control" id="discount-price"
                                        placeholder="Discounted Price" name="discount_price"
                                        aria-label="Product discounted price"
                                        value="{{isset($product[0]->discount_price) ? $product[0]->discount_price:''}}">
                                </div>
                                <!-- Qty -->
                                <div class="mb-3">
                                    <label class="form-label" for="Quantity">Quantity</label>
                                    <input type="number" class="form-control" id="Quantity" placeholder="Enter Quantity"
                                        name="qty" aria-label="Product qty"
                                        value="{{isset($product[0]->qty) ? $product[0]->qty:''}}">
                                </div>

                                <!-- In stock -->
                                <div class="mb-3 col ecommerce-select2-dropdown">
                                    <label class="form-label mb-1" for="status-org">In Stock
                                    </label>
                                    <select id="stock" class="select2 form-select" data-placeholder="Select Status"
                                        name="in_stock">

                                        <option value="true" {{isset($product[0]->in_stock) &&
                                            ($product[0]->in_stock=="true") ? 'selected':''}}>Available</option>
                                        <option value="false" {{isset($product[0]->status) &&
                                            ($product[0]->in_stock=="false") ? 'selected':''}} >Not Available</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- /Pricing Card -->
                        <!-- Organize Card -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Organize</h5>
                            </div>
                            <div class="card-body">

                                <!-- Category -->
                                <div class="mb-3 col ecommerce-select2-dropdown">
                                    <label class="form-label mb-1 d-flex justify-content-between align-items-center"
                                        for="category-org">
                                        <span>Category</span>
                                    </label>
                                    <select id="category-org" class="select2 form-select"
                                        data-placeholder="Select Category" name="category">
                                        <option value="">Select Category</option>
                                        @foreach($category as $val)
                                        <option value="{{$val->name}}" {{
                                            ($cat[0]->name == $val->name) ? 'selected':''}} >{{$val->name}}
                                        </option>
                                        @endforeach

                                    </select>
                                </div>
                                <!-- Collection -->
                                <div class="mb-3 col ecommerce-select2-dropdown">
                                    <label class="form-label mb-1" for="collection">Collection
                                    </label>
                                    <select id="collection" class="select2 form-select" data-placeholder="Collection"
                                        name="collection">
                                        <option selected value="null">None</option>
                                        <option value="trending-collection" {{isset($product[0]->collection) &&
                                            ($product[0]->collection=="trending-collection") ? 'selected':''}}>Trending
                                            collections</option>
                                    </select>
                                </div>
                                <!-- Status -->
                                <div class="mb-3 col ecommerce-select2-dropdown">
                                    <label class="form-label mb-1" for="status-org">Status
                                    </label>
                                    <select id="status" class="select2 form-select" data-placeholder="Select Status"
                                        name="status">
                                        <option value="">Select</option>
                                        <option value="Active" {{isset($product[0]->status) &&
                                            ($product[0]->status=="Active") ? 'selected':''}}>Active</option>
                                        <option value="Deactive" {{isset($product[0]->status) &&
                                            ($product[0]->status=="Deactive") ? 'selected':''}} >Deactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- /Organize Card -->
                    </div>
                    <!-- /Second column -->
                </div>
            </form>
        </div>

    </div>
    <!-- / Content -->

    <script>
var imgUpload = document.getElementById('upload-img')
  , imgPreview = document.getElementById('img-preview')
  , imgUploadForm = document.getElementById('form-upload')
  , totalFiles
  , previewTitle
  , previewTitleText
  , img;

imgUpload.addEventListener('change', previewImgs, true);

function previewImgs(event) {
  totalFiles = imgUpload.files.length;

     if(!!totalFiles) {
    imgPreview.classList.remove('img-thumbs-hidden');
  }

  for(var i = 0; i < totalFiles; i++) {
    wrapper = document.createElement('div');
    wrapper.classList.add('wrapper-thumb');
    removeBtn = document.createElement("span");
    nodeRemove= document.createTextNode('x');
    removeBtn.classList.add('remove-btn');
    removeBtn.appendChild(nodeRemove);
    img = document.createElement('img');
    img.src = URL.createObjectURL(event.target.files[i]);
    img.classList.add('img-preview-thumb');
    wrapper.appendChild(img);
    wrapper.appendChild(removeBtn);
    imgPreview.appendChild(wrapper);

    $('.remove-btn').click(function(){
      $(this).parent('.wrapper-thumb').remove();
    });

  }


}


        var quill = new Quill('#product-description', {
            modules: {
                toolbar: [
                    [{
                        header: [1, 2, false]
                    }],
                    ['bold', 'italic', 'underline'],
                    ['image', 'code-block']
                ]
            },
            placeholder: 'Compose an epic...',
            theme: 'snow' // or 'bubble'
        });

        @if (isset($product[0] -> description))
            quill.clipboard.dangerouslyPasteHTML(@json($product[0] -> description));
        $('#description').val(quill.root.innerHTML);
        @endif

        $(document).ready(function () {

            quill.on('text-change', function () {

                var descriptionContent = quill.root.innerHTML;

                $('#description').val(descriptionContent);
            });

            $('#multiselect').select2();


        });

        var input = document.querySelector("input[name=size]");
        var tagify = new Tagify(input);


        function updateColor() {
            const colorPicker = document.getElementById("picker");
            const colorDisplay = document.getElementById("colorDisplay");
            const colorCode = document.getElementById("codeValue");

            const selectedColor = colorPicker.value;
            colorDisplay.style.backgroundColor = selectedColor;
            colorCode.innerText = `Color Code: ${selectedColor}`;
        }
        var input = document.querySelector("input[name=color]");
        var tagify = new Tagify(input);

    </script>


    @endsection
