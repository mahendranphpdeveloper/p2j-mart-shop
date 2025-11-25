@extends('layouts.commonMaster')
@section('layoutContent')
<script src="{{ asset('assets/js/app-ecommerce-product-add.js') }}"></script>

<!-- Content wrapper -->
<div class="content-wrapper">

    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Manage Home /</span><span> Slider Banner</span>
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
        @if(session()->has('message'))
        <div class="alert alert-success">{{session('message')}}</div>
        @endif
        <div class="app-ecommerce">
            <form action="{{route('save-slider-banner')}}" id="headerFooter" method="post"
                enctype="multipart/form-data">
                @csrf

                <!-- Add Header -->
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">

                    <div class="d-flex flex-column justify-content-center">
                        <!-- <h4 class="mb-1 mt-3">Change Header details</h4> -->
                    </div>

                    <div class="d-flex align-content-center flex-wrap gap-3">
                        <button class="discard btn btn-label-secondary">Discard</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>

                </div>

                <div class="row">

                    <!-- First column-->
                    <div class="col-lg-1"></div>
                    <div class="col-12 col-lg-8">

                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-tile mb-0">Slider Banner Details</h5>
                            </div>
                            <div class="card-body">

                                <!-- Image -->
                                <div class="mb-3">
                                    <label class="form-label" for="image">Upload Slider Banner Image</label>
                                    <input class="form-control" type="file" id="image" name="image">

                                    <div>
                                        @if(isset($data[0]->image) )
                                        <img src="{{asset('uploads/banner').'/'.$data[0]->image}}"
                                            class="custom-image" id="imagePreview">
                                        @endif
                                    </div>

                                </div>
                                

                                <div class="mb-3">
                                    <label class="form-label" >Content </label>
                                    <textarea type="text" class="form-control" id="content"
                                        value="{{isset($data[0]->content) ? $data[0]->content:''}}"
                                        placeholder="Enter content" name="content">{{isset($data[0]->content) ? $data[0]->content:''}} </textarea>
                                </div>

                                <!-- Image 2 -->
                            <div class="mb-3">
                                <label class="form-label" for="image2">Upload Slider Banner Image 2</label>
                                <input class="form-control" type="file" id="image2" name="image2">

                                <div>
                                    @if(isset($data[0]->image2))
                                    <img src="{{ asset('uploads/banner/'.$data[0]->image2) }}" class="custom-image" id="image2Preview">
                                    @endif
                                </div>
                            </div>


                            <!-- Content 2 -->
                            <div class="mb-3">
                                <label class="form-label">Content 2</label>
                                <textarea class="form-control" id="content2"
                                    name="content2"
                                    placeholder="Enter content 2">{{ isset($data[0]->content2) ? $data[0]->content2 : '' }}</textarea>
                            </div>

                            </div>
                        </div>
                    </div>

                </div>

        </div>
        </form>
    </div>

</div>
<!-- / Content -->
<script>
    $('.discard').on('click', function (e) {
        e.preventDefault();
        $('#headerFooter').trigger('reset');
    });
</script>

@endsection