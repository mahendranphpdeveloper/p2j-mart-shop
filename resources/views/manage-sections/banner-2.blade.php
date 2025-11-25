@extends('layouts.commonMaster')
@section('layoutContent')
<script src="{{ asset('assets/js/app-ecommerce-product-add.js') }}"></script>
<style>
.cus-image{
    width:100%;   
}
</style>
<!-- Content wrapper -->
<div class="content-wrapper">

    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Manage Home /</span><span> Banner 2</span>
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
            <form action="{{route('save.banner-2')}}" id="headerFooter" method="post"
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
                                <h5 class="card-tile mb-0"> Banner 2 Details</h5>
                            </div>
                            <div class="card-body">

                                <div class="mb-3">
                                    <label class="form-label" >Title 1 </label>
                                    <input type="text" class="form-control" id="content"
                                        value="{{isset($data[0]->title_1) ? $data[0]->title_1:''}}"
                                        placeholder="Enter Title 1" name="title_1" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" >Title 2 </label>
                                    <input type="text" class="form-control" id="content"
                                        value="{{isset($data[0]->title_2) ? $data[0]->title_2:''}}"
                                        placeholder="Enter Title 2" name="title_2" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" >Title 3 </label>
                                    <input type="text" class="form-control" id="content"
                                        value="{{isset($data[0]->title_3) ? $data[0]->title_3:''}}"
                                        placeholder="Enter Title 3" name="title_3" required>
                                </div>

                                 <!-- Image -->
                                 <div class="mb-3">
                                    <label class="form-label" for="image">Upload Banner 2 Image</label>
                                    <input class="form-control" type="file" id="image" name="image">

                                    <div>
                                        @if(isset($data[0]->image) )
                                        <input type="hidden" name="old_image" value="{{$data[0]->image}}" >
                                        <img src="{{asset('uploads/banners').'/'.$data[0]->image}}"
                                            class="cus-image mt-2" id="imagePreview">
                                        @endif
                                    </div>

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