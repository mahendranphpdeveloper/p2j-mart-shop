@extends('layouts.commonMaster')
@section('layoutContent')
<script src="{{ asset('assets/js/app-ecommerce-product-add.js') }}"></script>

<!-- Content wrapper -->
<div class="content-wrapper">

    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Manage Home /</span><span> Header & Footer</span>
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
            <form action="{{route('save.header-footer')}}" id="headerFooter" method="post"
                enctype="multipart/form-data">
                @csrf

                <!-- Add Header -->
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">

                    <div class="d-flex flex-column justify-content-center">
                        <h4 class="mb-1 mt-3">Change Header details</h4>
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
                                <h5 class="card-tile mb-0">Header Details</h5>
                            </div>
                            <div class="card-body">

                                <div class="mb-3">
                                    <label class="form-label" for="img_title">Small Title</label>
                                    <input type="text" class="form-control" id="img_title1"
                                        value="{{isset($data[0]->small_title) ? $data[0]->small_title:''}}"
                                        placeholder="Enter Header Small Title" name="small_title" aria-label="img_title">
                                </div>

                                <!-- Image -->
                                <div class="mb-3">
                                    <label class="form-label" for="image">Upload Header & Footer Image</label>
                                    <input class="form-control" type="file" id="image" name="image">

                                    <div>
                                        @if(isset($data[0]->image) )
                                        <img src="{{asset('uploads/logo').'/'.$data[0]->image}}"
                                            class="custom-image" id="imagePreview">
                                        @endif
                                    </div>

                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="img_title">Image Title 1</label>
                                    <input type="text" class="form-control" id="img_title1"
                                        value="{{isset($data[0]->title_1) ? $data[0]->title_1:''}}"
                                        placeholder="Enter Image Title No 1" name="title_1" aria-label="img_title">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="img_title">Image Title 2</label>
                                    <input type="text" class="form-control" id="img_title2"
                                        value="{{isset($data[0]->title_2) ? $data[0]->title_2:''}}"
                                        placeholder="Enter Image Title No 2" name="title_2" aria-label="img_title">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="helpline">Helpline Name</label>
                                    <input type="text" class="form-control" id="helpline_content"
                                        value="{{isset($data[0]->helpline_name) ? $data[0]->helpline_name:''}}"
                                        placeholder="You can change helpline name" name="helpline_name"
                                        aria-label="helpline">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="helpline">Helpline No</label>
                                    <input type="text" class="form-control" id="helpline"
                                        value="{{isset($data[0]->helpline_no) ? $data[0]->helpline_no:''}}"
                                        placeholder="Enter Helpline No" name="helpline_no" aria-label="helpline">
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                <!-- Add Footer -->
                <!-- <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">

                    <div class="d-flex flex-column justify-content-center">
                        <h4 class="mb-1 mt-3">Change Footer details</h4>
                    </div>
                </div> -->

                <!-- Second column-->

                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-12 col-lg-8">

                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-tile mb-0">Footer Details</h5>
                            </div>
                            <div class="card-body">

                                 <div class="mb-3">
                                    <label class="form-label" for="content">Footer Content</label>
                                    <textarea class="form-control" type="text" id="content"
                                        name="footer_content">{!! isset($data[0]->footer_content) ? $data[0]->footer_content:''!!}</textarea>
                                </div>

                                <!--
                                <div class="mb-3">
                                    <label class="form-label" for="content">Contact Info Name</label>
                                    <input class="form-control" type="text" id="content" name="contact_us_name"
                                        placeholder="You can change contact info name"
                                        value="{{ isset($data[0]->contact_us_name) ? $data[0]->contact_us_name:''}}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="contact_info">Contact Info</label>
                                    <textarea class="form-control" type="text" id="contact_info" name="contact_info"
                                        placeholder="Enter Contact Address">{!! isset($data[0]->contact_info) ? $data[0]->contact_info:''!!}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="mobile">Mobile No</label>
                                    <input type="text" class="form-control" id="mobile"
                                        value="{{isset($data[0]->footer_mobile) ? $data[0]->footer_mobile:''}}"
                                        placeholder="Enter Mobile No" name="footer_mobile" aria-label="mobile">
                                </div>

                                <div class="mb-4">
                                    <label class="form-label" for="email">Email Id</label>
                                    <input type="email" class="form-control" id="email"
                                        value="{{isset($data[0]->email) ? $data[0]->email:''}}"
                                        placeholder="Enter Email Id" name="email" aria-label="email">
                                </div> -->

                                <h5 class="card-tile mb-0">Social Media Links</h5>

                                <div class="mb-3 mt-3">
                                    <label class="form-label" for="facebook">facebook link</label>
                                    <input type="text" class="form-control" id="facebook"
                                        value="{{isset($data[0]->facebook_link) ? $data[0]->facebook_link:''}}"
                                        placeholder="Enter facebook Link" name="facebook_link" aria-label="facebook">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="twitter">Twitter Link</label>
                                    <input type="text" class="form-control" id="twitter"
                                        value="{{isset($data[0]->twitter_link) ? $data[0]->twitter_link:''}}"
                                        placeholder="Enter twitter link" name="twitter_link" aria-label="twitter">
                                </div>
                                <div class="mb-3">
                        <label class="form-label" for="instagram">Instagram</label>
                        <input type="text" class="form-control" id="instagram"
                            value="{{ isset($data[0]->instagram_link) ? $data[0]->instagram_link : '' }}"
                            placeholder="Enter Instagram link" name="instagram_link" aria-label="instagram">
                    </div>


                    <div class="mb-3">
                        <label class="form-label" for="youtube">YouTube</label>
                        <input type="text" class="form-control" id="youtube"
                            value="{{ isset($data[0]->youtube_link) ? $data[0]->youtube_link : '' }}"
                            placeholder="Enter YouTube link" name="youtube_link" aria-label="youtube">
                    </div>


                                   <!-- Down Content 3 -->
    <!-- Down Content 1 -->
    <div class="container mt-4">
    <div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Down Content 1</h5>

                <!-- Icon input with preview -->
                <div class="form-group">
                    <label>Icon (Font Awesome)</label>
                    <div class="input-group">
                        <input type="text" class="form-control icon-input" name="down_content_1[0][icon]"
                               placeholder="fa fa-icon" onkeyup="updateIconPreview(this, 'icon-preview-1-fa')"
                               value="{{ old('down_content_1[0][icon]', json_decode($common->down_content_1)[0]->icon ?? '') }}">
                        <span class="input-group-text" id="icon-preview-1">
                            <i class="fa {{ old('down_content_1[0][icon]', json_decode($common->down_content_1)[0]->icon ?? '') }} " id="icon-preview-1-fa"></i>
                        </span>
                    </div>
                </div>

                <!-- Title input -->
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" class="form-control"
                           name="down_content_1[0][title]"
                           placeholder="Title"
                           value="{{ old('down_content_1[0][title]', json_decode($common->down_content_1)[0]->title ?? '') }}">
                </div>

                <!-- Content input -->
                <div class="form-group">
                    <label>Content</label>
                    <textarea class="form-control" name="down_content_1[0][content]" placeholder="Content">{{ old('down_content_1[0][content]', json_decode($common->down_content_1)[0]->content ?? '') }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- Down Content 2 -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Down Content 2</h5>

                <!-- Icon input with preview -->
                <div class="form-group">
                    <label>Icon (Font Awesome)</label>
                    <div class="input-group">
                        <input type="text" class="form-control icon-input" name="down_content_2[0][icon]"
                               placeholder="fa fa-icon" onkeyup="updateIconPreview(this, 'icon-preview-2-fa')"
                               value="{{ old('down_content_2[0][icon]', json_decode($common->down_content_2)[0]->icon ?? '') }}">
                        <span class="input-group-text" id="icon-preview-2">
                            <i class="fa {{ old('down_content_2[0][icon]', json_decode($common->down_content_2)[0]->icon ?? '') }}" id="icon-preview-2-fa"></i>
                        </span>
                    </div>
                </div>

                <!-- Title input -->
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" class="form-control"
                           name="down_content_2[0][title]"
                           placeholder="Title"
                           value="{{ old('down_content_2[0][title]', json_decode($common->down_content_2)[0]->title ?? '') }}">
                </div>

                <!-- Content input -->
                <div class="form-group">
                    <label>Content</label>
                    <textarea class="form-control" name="down_content_2[0][content]" placeholder="Content">{{ old('down_content_2[0][content]', json_decode($common->down_content_2)[0]->content ?? '') }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- Down Content 3 -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Down Content 3</h5>

                <!-- Icon input with preview -->
                <div class="form-group">
                    <label>Icon (Font Awesome)</label>
                    <div class="input-group">
                        <input type="text" class="form-control icon-input" name="down_content_3[0][icon]"
                               placeholder="fa fa-icon" onkeyup="updateIconPreview(this, 'icon-preview-3-fa')"
                               value="{{ old('down_content_3[0][icon]', json_decode($common->down_content_3)[0]->icon ?? '') }}">
                        <span class="input-group-text" id="icon-preview-3">
                            <i class="fa {{ old('down_content_3[0][icon]', json_decode($common->down_content_3)[0]->icon ?? '') }}" id="icon-preview-3-fa"></i>
                        </span>
                    </div>
                </div>

                <!-- Title input -->
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" class="form-control"
                           name="down_content_3[0][title]"
                           placeholder="Title"
                           value="{{ old('down_content_3[0][title]', json_decode($common->down_content_3)[0]->title ?? '') }}">
                </div>

                <!-- Content input -->
                <div class="form-group">
                    <label>Content</label>
                    <textarea class="form-control" name="down_content_3[0][content]" placeholder="Content">{{ old('down_content_3[0][content]', json_decode($common->down_content_3)[0]->content ?? '') }}</textarea>
                </div>
            </div>
        </div>
 </div>
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

<!-- <a href="https://www.facebook.com/sharer/sharer.php?u=https://www.webdevelopmentindia.co.in/new-trends/web6/index.php"
                                    target="_blank">Share on Facebook</a> -->
<!-- <a href="https://twitter.com/intent/tweet?url=https://www.webdevelopmentindia.co.in/new-trends/web6/index.php"
                                    target="_blank">Share on Twitter</a>
                                <a href="https://www.linkedin.com/shareArticle?url=https://www.webdevelopmentindia.co.in/new-trends/web6/index.php"
                                    target="_blank">Share on LinkedIn</a> -->