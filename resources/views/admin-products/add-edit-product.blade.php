@extends('layouts.commonMaster')
@section('layoutContent')
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css"/> -->
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
.custom-align{
    column-gap: 15px;
}
</style>
<!-- Content wrapper -->
<div class="content-wrapper">

    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Productsss /</span><span> Add Product</span>
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
            <form action="{{ isset($product[0]->id) ? route('update-cat-product',['id'=>$product[0]->id]): route('products.store')}}" id="addProducts" method="post" enctype="multipart/form-data">
                @csrf

                @if(isset($product[0]->id))
                <input type="hidden" name="is_edit" value="{{$product[0]->id}}">
                @endif
                <input type="hidden" name="cat_id" value="{{isset($cate)?$cate[0]->id:''}}">

                <!-- Add Product -->
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">

                    <div class="d-flex flex-column justify-content-center">
                        <h4 class="mb-1 mt-3">Add a new Product</h4>
                        <!-- <p class="text-muted">Orders placed across your store</p> -->
                    </div>

                    <div class="d-flex align-content-center flex-wrap gap-3">
                        <a href="{{URL::previous()}}" class="btn btn-label-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save product</button>
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
                                        placeholder="Product title" name="name" aria-label="Product title" required>
                                </div>

                                <!-- Description -->
                                <div>
                                    <label class="form-label">Description</label>
                                    <div class="form-control p-0 pt-1">

                                        <div class="comment-editor border-0 pb-4" id="product-description">
                                        </div>
                                        <input type="hidden" id="description" name="description" >

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
                        <div class="card mt-3 mb-3 p-4">
    <form method="POST" class="form-horizontal well" role="form">
        <fieldset>
            <h5 class="card-title mb-3">Variants</h5>
            <div class="repeater-default">
                <div data-repeater-list="variant" id="repeater" class="drag">
            @if(isset($product[0]->variants) && $product[0]->variants!=null )
                @foreach(json_decode($product[0]->variants) as $key => $data)
                <div data-repeater-item="">
                    <div class="form-group">
                        <div class="d-flex align-items-center custom-align mb-3">
                            <div>
                                <label class="control-label">Select</label>
                                <select name="variant[{{$key}}][name]" class="form-control">
                                    <option value="">Select</option>
                                    <option value="size" {{isset($data->name) && $data->name=="size"?'selected':''}} >Size</option>
                                    <option value="color" {{isset($data->name) && $data->name=="color"?'selected':''}}>Color</option>
                                </select>
                            </div>
                            <div>
                                <label class="control-label">Value</label>
                                <input type="text" name="variant[{{$key}}][value]" value="{{isset($data->value)?$data->value:''}}" class="form-control"/>
                            </div>
                            <div>
                                <label class="control-label">Price</label>
                                <input type="text" name="variant[{{$key}}][price]" value="{{isset($data->price)?$data->price:''}}" class="form-control"/>
                            </div>
                            <div class="mt-4">
                                <span data-repeater-delete="" class="form-control btn btn-danger btn-sm delete-btn">
                                    <span class="glyphicon glyphicon-remove"></span> Delete
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif

            <!-- <div class="repeater-default">
                <div data-repeater-list="variant" id="repeater" class="drag"> -->
                    <div data-repeater-item="">
                        <div class="form-group">
                            <div class="d-flex align-items-center custom-align mb-3">
                                <div>
                                    <label class="control-label">Select</label>
                                    <select name="variant[3][name]" class="form-control">
                                        <option value="">Select</option>
                                        <option value="size">Size</option>
                                        <option value="color">Color</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="control-label">Value</label>
                                    <input type="text" name="variant[3][value]" value="" class="form-control"/>
                                </div>
                                <div>
                                    <label class="control-label">Price</label>
                                    <input type="text" name="variant[3][price]" value="" class="form-control"/>
                                </div>
                                <div class="mt-4">
                                    <span data-repeater-delete="" class="form-control btn btn-danger btn-sm delete-btn">
                                        <span class="glyphicon glyphicon-remove"></span> Delete
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between custom-align">
                    <div class="form-group mt-3">
                        <div class="col-sm-offset-1 col-sm-11">
                            <span data-repeater-create="" class="btn btn-info btn-md onclick">
                                <span class="glyphicon glyphicon-plus"></span> Add
                            </span>
                        </div>
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
        </fieldset>
    </form>
</div>

<div class="card container my-5">
  <h3 class="text-center mt-4">Upload Multiple Product Images</h3>
  <div class="row">
    <div class="col">
      <div class="form-group mt-5">
        <label for="">Choose Images</label>
        <input type="file" class="form-control" name="multiple_images[]" value="{{isset($product[0]->multiple_images)}}" multiple id="upload-img" />
      </div>
      <input type="hidden" name="old_image" value="{{isset($product[0]->multiple_images)?$product[0]->multiple_images:''}}" >
      <div class="img-thumbs" id="img-preview">
        @if(isset($product[0]->multiple_images) && $product[0]->multiple_images!=null)
          @foreach(json_decode($product[0]->multiple_images) as $image)
            <div class="wrapper-thumb" data-image="{{ $image }}">
              <img src="{{ asset('uploads/products') . '/' . $image }}" class="img-preview-thumb">
              <span class="remove-btn">x</span>
              <input type="hidden" name="id" class="product-id" value="{{$product[0]->id}}">
            </div>
          @endforeach
        @endif
      </div>
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

                                 <!-- Sort order -->
                                 <div class="mb-3">
                                    <label class="form-label" for="sort-order">Sort Order</label>
                                    <input type="number" class="form-control" placeholder="Enter Sort order"
                                        name="sort_order"
                                        value="{{isset($product[0]->sort_order) ? $product[0]->sort_order:$sort_count}}">
                                        <input type="hidden" name="old_sort" value="{{isset($product[0]->sort_order)?$product[0]->sort_order:null}}">
                                    <small>Please enter value between 1 to {{isset($sort_count)?$sort_count:''}}</small>
                                </div>
                                <!-- Category -->
                                <div class="mb-3 col ecommerce-select2-dropdown">
                                    <label class="form-label mb-1 d-flex justify-content-between align-items-center"
                                        for="category-org">
                                        <span>Category</span>
                                    </label>
                                    <select id="category-org" class="select2 form-select"
                                        data-placeholder="Select Category" name="category">
                                        <option value="">Select Category</option>
                                        @foreach($category as $cat)
                                        <option value="{{$cat->name}}" {{isset($cate[0]->name) && $cate[0]->name== $cat->name?'selected':'' }} {{isset($product[0]->category) &&
                                            ($product[0]->category==$cat->name) ? 'selected':''}} >{{$cat->name}}
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
                                        <option selected value="Active" {{isset($product[0]->status) &&
                                            ($product[0]->status=="Active") ? 'selected':''}}>Active</option>
                                        <option value="Deactive" {{isset($product[0]->status) &&
                                            ($product[0]->status=="Deactive") ? 'selected':''}} >Deactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- /Organize Card -->

                        <!-- video-->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Video Url</h5>
                            </div>
                            <div class="card-body">

                               <!-- Collection -->
                                <div class="mb-3 col ecommerce-select2-dropdown">
                                    <label class="form-label mb-1" for="collection">Url
                                    </label>
                                        <textarea class="form-control" type="text" name="video_url" value="" > {{isset($product[0]->video_url)?$product[0]->video_url:''}} </textarea>
                                </div>
                                @if(isset($product[0]->video_url))
                                    <iframe width="auto" height="auto" src="https://www.youtube.com/embed/{{$product[0]->video_url}}" allowfullscreen ></iframe>
                                @endif


                            </div>
                        </div>
                        <!-- /Video-->

                    </div>
                    <!-- /Second column -->
                </div>
            </form>
        </div>

    </div>
    <!-- / Content -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.js"></script>
<script>
// $('.onclick').on('click',function(){
//     $('#repeater').removeClass('d-none');
// });

$(document).ready(function() {
        $('.delete-btn').click(function() {
            $(this).closest('[data-repeater-item]').remove();
        });
    });

	var repeater = $(".repeater-default").repeater({
		initval: 1,
	});

	jQuery(".drag").sortable({
			axis: "y",
			cursor: "pointer",
			opacity: 0.5,
			placeholder: "row-dragging",
			delay: 150,
			update: function (event, ui) {
				console.log("repeaterVal");
				console.log(repeater.repeaterVal());
				console.log("serializeArray");
				console.log($("form").serializeArray());
			},
			// update: function(event, ui) {
			//     $('.repeater-default').repeater( 'setIndexes' );
			// }
		})
		.disableSelection();

</script>
<script>

$(document).ready(function() {
    $('.remove-btn').on('click', function() {
        var image = $(this).closest('.wrapper-thumb').data('image');
        var productId = $(this).siblings('.product-id').val();

        $.ajax({
            url: '{{ route("remove.image") }}',
            method: 'POST',
            data: {
                image: image,
                id: productId,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                $('.wrapper-thumb[data-image="' + image + '"]').remove();
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });

  $('#upload-img').change(function(event) {
    var imgPreview = $('#img-preview');
    var totalFiles = event.target.files.length;

    if (totalFiles) {
      imgPreview.removeClass('img-thumbs-hidden');
    }

    for (var i = 0; i < totalFiles; i++) {
      var wrapper = $('<div>').addClass('wrapper-thumb');
      var removeBtn = $('<span>').addClass('remove-btn').text('x');
      var img = $('<img>').addClass('img-preview-thumb').attr('src', URL.createObjectURL(event.target.files[i]));

      wrapper.append(img).append(removeBtn);
      imgPreview.append(wrapper);
    }

    $('.remove-btn').click(function() {
      $(this).parent('.wrapper-thumb').remove();
    });
  });
});



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
