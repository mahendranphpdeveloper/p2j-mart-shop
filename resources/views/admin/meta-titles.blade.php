@extends('layouts.commonMaster')

@section('layoutContent')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">

<style>
.bootstrap-tagsinput {
    width: 100%;
    padding: 10px;
}
    .bootstrap-tagsinput .tag {
        margin-right: 2px;
        color: white;
        background-color: #5bc0de;
        padding: 5px;
        border-radius: 3px;
    }
    .bootstrap-tagsinput input {
        width: auto;
    }
    .submit-btn {
    /* position: relative;
    left: 46%;
    bottom: 17px; */
}

</style>
<div class="container mt-4">

    @if(session('success'))
    <div aria-live="polite" aria-atomic="true" class="position-relative">
        <div class="toast-container top-0 end-0 p-3">
            <div class="bs-toast toast show bg-success" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <i class='bx bx-bell me-2'></i>
                    <div class="me-auto fw-medium">Message</div>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    {{ session('success') }}
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="content-wrapper">

        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
    
            <h4 class="py-2 mb-1">
                <span class="text-muted fw-light">Meta Titles </span>
            </h4>
            @if(session()->has('success'))
                <div class="alert alert-success">{{session('success')}}</div>
            @endif
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
            @php ($error = $errors->all());   @endphp
            @if($error)
            <div class="alert alert-danger">{{isset($error[0])?$error[0]:''}}</div>
            <div class="alert alert-danger">{{isset($error[1])?$error[1]:''}}</div>
            @endif
            <div class="app-ecommerce">  
                <form action="{{route('save.meta-titles')}}" method="post" enctype="multipart/form-data">
                    @csrf 
                    <div style="display: block;"> <!-- Should not be 'none' -->
              <button class="submit-btn btn btn-primary next-tab">Save</button>
            </div> 
                            <div class="row">
    
                                <div class="col-12 col-lg-6">
    
                                    <div class="card mb-3">
                                        <div class="card-header">
                                            <h5 class="card-tile mb-0">Home Page</h5>
                                        </div>
                                        <div class="card-body">
    
                                            <div class="mb-2">
                                                <label class="form-label" for="img_title">Meta title</label>
                                                <input type="text" class="form-control" id="title1"
                                                    value="{{isset($data[0]->home_meta_title) ? $data[0]->home_meta_title:''}}"
                                                    placeholder="Enter Meta Title" name="home_meta_title"
                                                    aria-label="img_title" >
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label" for="img_title">Meta Keywords</label>
                                               <input type="text" name="home_meta_keys" value="{{isset($data[0]->home_meta_keys) ? $data[0]->home_meta_keys:''}}" class="meta_keys form-control" data-role="tagsinput" placeholder="Add Meta Keywords" />
                                            </div>
    
                                            <div class="mb-2">
                                                <label class="form-label" for="img_title">Description </label>
                                                <input type="text" class="form-control"
                                                    value="{{isset($data[0]->home_meta_desc) ? $data[0]->home_meta_desc:''}}"
                                                    placeholder="Enter Meta Description" name="home_meta_desc" >
                                            </div>
    
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="col-12 col-lg-6">
    
                                    <div class="card mb-3">
                                        <div class="card-header">
                                            <h5 class="card-tile mb-0">Category Page</h5>
                                        </div>
                                        <div class="card-body">
    
                                            <div class="mb-2">
                                                <label class="form-label" for="img_title">Meta title</label>
                                                <input type="text" class="form-control" id="title1"
                                                    value="{{isset($data[0]->cat_meta_title) ? $data[0]->cat_meta_title:''}}"
                                                    placeholder="Enter Meta Title" name="cat_meta_title"
                                                    aria-label="img_title" >
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label" for="img_title">Meta Keywords</label>
                                               <input type="text" name="cat_meta_keys" value="{{isset($data[0]->cat_meta_keys) ? $data[0]->cat_meta_keys:''}}" class="meta_keys form-control" data-role="tagsinput" placeholder="Add Meta Keywords" />
                                            </div>
    
                                            <div class="mb-2">
                                                <label class="form-label" for="img_title">Description </label>
                                                <input type="text" class="form-control"
                                                    value="{{isset($data[0]->cat_meta_desc) ? $data[0]->cat_meta_desc:''}}"
                                                    placeholder="Enter Description" name="cat_meta_desc" >
                                            </div>
    
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="col-12 col-lg-6">
    
                                    <div class="card mb-3">
                                        <div class="card-header">
                                            <h5 class="card-tile mb-0">New Arrivals</h5>
                                        </div>
                                        <div class="card-body">
    
                                            <div class="mb-2">
                                                <label class="form-label" for="img_title">Meta title</label>
                                                <input type="text" class="form-control" id="title1"
                                                    value="{{isset($data[0]->new_meta_title) ? $data[0]->new_meta_title:''}}"
                                                    placeholder="Enter Meta Title" name="new_meta_title"
                                                    aria-label="img_title" >
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label" for="img_title">Meta Keywords</label>
                                               <input type="text" name="new_meta_keys" value="{{isset($data[0]->new_meta_keys) ? $data[0]->new_meta_keys:''}}" class="meta_keys form-control" data-role="tagsinput" placeholder="Add Meta Keywords" />
                                            </div>
    
                                            <div class="mb-2">
                                                <label class="form-label" for="img_title">Description </label>
                                                <input type="text" class="form-control"
                                                    value="{{isset($data[0]->new_meta_desc) ? $data[0]->new_meta_desc:''}}"
                                                    placeholder="Enter Description" name="new_meta_desc" >
                                            </div>
    
                                        </div>
                                    </div>
                                </div>
                                
                                <!--/Related Items -->
                                <div class="col-12 col-lg-6">
    
                                    <div class="card mb-3">
                                        <div class="card-header">
                                            <h5 class="card-tile mb-0">Cart Page</h5>
                                        </div>
                                        <div class="card-body">
    
                                            <div class="mb-2">
                                                <label class="form-label" for="img_title">Meta title</label>
                                                <input type="text" class="form-control" id="title1"
                                                    value="{{isset($data[0]->cart_meta_title) ? $data[0]->cart_meta_title:''}}"
                                                    placeholder="Enter Meta Title" name="cart_meta_title"
                                                    aria-label="img_title" >
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label" for="img_title">Meta Keywords</label>
                                               <input type="text" name="cart_meta_keys" value="{{isset($data[0]->cart_meta_keys) ? $data[0]->cart_meta_keys:''}}" class="meta_keys form-control" data-role="tagsinput" placeholder="Add Meta Keywords" />
                                            </div>
    
                                            <div class="mb-2">
                                                <label class="form-label" for="img_title">Description </label>
                                                <input type="text" class="form-control"
                                                    value="{{isset($data[0]->cart_meta_desc) ? $data[0]->cart_meta_desc:''}}"
                                                    placeholder="Enter Description" name="cart_meta_desc" >
                                            </div>
    
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
    
                                    <div class="card mb-3">
                                        <div class="card-header">
                                            <h5 class="card-tile mb-0">Profile Page</h5>
                                        </div>
                                        <div class="card-body">
    
                                            <div class="mb-2">
                                                <label class="form-label" for="img_title">Meta title</label>
                                                <input type="text" class="form-control" id="title1"
                                                    value="{{isset($data[0]->profile_meta_title) ? $data[0]->profile_meta_title:''}}"
                                                    placeholder="Enter Meta Title" name="profile_meta_title"
                                                    aria-label="img_title" >
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label" for="img_title">Meta Keywords</label>
                                               <input type="text" name="profile_meta_keys" value="{{isset($data[0]->profile_meta_keys) ? $data[0]->profile_meta_keys:''}}" class="meta_keys form-control" data-role="tagsinput" placeholder="Add Meta Keywords" />
                                            </div>
    
                                            <div class="mb-2">
                                                <label class="form-label" for="img_title">Description </label>
                                                <input type="text" class="form-control"
                                                    value="{{isset($data[0]->profile_meta_desc) ? $data[0]->profile_meta_desc:''}}"
                                                    placeholder="Enter Description" name="profile_meta_desc" >
                                            </div>
    
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
    
                                    <div class="card mb-3">
                                        <div class="card-header">
                                            <h5 class="card-tile mb-0">Checkout Page</h5>
                                        </div>
                                        <div class="card-body">
    
                                            <div class="mb-2">
                                                <label class="form-label" for="img_title">Meta title</label>
                                                <input type="text" class="form-control" id="title1"
                                                    value="{{isset($data[0]->checkout_meta_title) ? $data[0]->checkout_meta_title:''}}"
                                                    placeholder="Enter Meta Title" name="checkout_meta_title"
                                                    aria-label="img_title" >
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label" for="img_title">Meta Keywords</label>
                                               <input type="text" name="checkout_meta_keys" value="{{isset($data[0]->checkout_meta_keys) ? $data[0]->checkout_meta_keys:''}}" class="meta_keys form-control" data-role="tagsinput" placeholder="Add Meta Keywords" />
                                            </div>
    
                                            <div class="mb-2">
                                                <label class="form-label" for="img_title">Description </label>
                                                <input type="text" class="form-control"
                                                    value="{{isset($data[0]->checkout_meta_desc) ? $data[0]->checkout_meta_desc:''}}"
                                                    placeholder="Enter Description" name="checkout_meta_desc" >
                                            </div>
    
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
    
                                    <div class="card mb-3">
                                        <div class="card-header">
                                            <h5 class="card-tile mb-0">Login Page</h5>
                                        </div>
                                        <div class="card-body">
    
                                            <div class="mb-2">
                                                <label class="form-label" for="img_title">Meta title</label>
                                                <input type="text" class="form-control" id="title1"
                                                    value="{{isset($data[0]->login_meta_title) ? $data[0]->login_meta_title:''}}"
                                                    placeholder="Enter Meta Title" name="login_meta_title"
                                                    aria-label="img_title" >
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label" for="img_title">Meta Keywords</label>
                                               <input type="text" name="login_meta_keys" value="{{isset($data[0]->login_meta_keys) ? $data[0]->login_meta_keys:''}}" class="meta_keys form-control" data-role="tagsinput" placeholder="Add Meta Keywords" />
                                            </div>
    
                                            <div class="mb-2">
                                                <label class="form-label" for="img_title">Description </label>
                                                <input type="text" class="form-control"
                                                    value="{{isset($data[0]->login_meta_desc) ? $data[0]->login_meta_desc:''}}"
                                                    placeholder="Enter Description" name="login_meta_desc" >
                                            </div>
    
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
    
                                    <div class="card mb-3">
                                        <div class="card-header">
                                            <h5 class="card-tile mb-0">Register Page</h5>
                                        </div>
                                        <div class="card-body">
    
                                            <div class="mb-2">
                                                <label class="form-label" for="img_title">Meta title</label>
                                                <input type="text" class="form-control" id="title1"
                                                    value="{{isset($data[0]->register_meta_title) ? $data[0]->register_meta_title:''}}"
                                                    placeholder="Enter Meta Title" name="register_meta_title"
                                                    aria-label="img_title" >
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label" for="img_title">Meta Keywords</label>
                                               <input type="text" name="register_meta_keys" value="{{isset($data[0]->register_meta_keys) ? $data[0]->register_meta_keys:''}}" class="meta_keys form-control" data-role="tagsinput" placeholder="Add Meta Keywords" />
                                            </div>
    
                                            <div class="mb-2">
                                                <label class="form-label" for="img_title">Description </label>
                                                <input type="text" class="form-control"
                                                    value="{{isset($data[0]->register_meta_desc) ? $data[0]->register_meta_desc:''}}"
                                                    placeholder="Enter Description" name="register_meta_desc" >
                                            </div>
    
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
    
                                    <div class="card mb-3">
                                        <div class="card-header">
                                            <h5 class="card-tile mb-0">About Us Page</h5>
                                        </div>
                                        <div class="card-body">
    
                                            <div class="mb-2">
                                                <label class="form-label" for="img_title">Meta title</label>
                                                <input type="text" class="form-control" id="title1"
                                                    value="{{isset($data[0]->about_meta_title) ? $data[0]->about_meta_title:''}}"
                                                    placeholder="Enter Meta Title" name="about_meta_title"
                                                    aria-label="img_title" >
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label" for="img_title">Meta Keywords</label>
                                               <input type="text" name="about_meta_keys" value="{{isset($data[0]->about_meta_keys) ? $data[0]->about_meta_keys:''}}" class="meta_keys form-control" data-role="tagsinput" placeholder="Add Meta Keywords" />
                                            </div>
    
                                            <div class="mb-2">
                                                <label class="form-label" for="img_title">Description </label>
                                                <input type="text" class="form-control"
                                                    value="{{isset($data[0]->about_meta_desc) ? $data[0]->about_meta_desc:''}}"
                                                    placeholder="Enter Description" name="about_meta_desc" >
                                            </div>
    
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
    
                                    <div class="card mb-3">
                                        <div class="card-header">
                                            <h5 class="card-tile mb-0">Contact Us Page</h5>
                                        </div>
                                        <div class="card-body">
    
                                            <div class="mb-2">
                                                <label class="form-label" for="img_title">Meta title</label>
                                                <input type="text" class="form-control" id="title1"
                                                    value="{{isset($data[0]->contact_meta_title) ? $data[0]->contact_meta_title:''}}"
                                                    placeholder="Enter Meta Title" name="contact_meta_title"
                                                    aria-label="img_title" >
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label" for="img_title">Meta Keywords</label>
                                               <input type="text" name="contact_meta_keys" value="{{isset($data[0]->contact_meta_keys) ? $data[0]->contact_meta_keys:''}}" class="meta_keys form-control" data-role="tagsinput" placeholder="Add Meta Keywords" />
                                            </div>
    
                                            <div class="mb-2">
                                                <label class="form-label" for="img_title">Description </label>
                                                <input type="text" class="form-control"
                                                    value="{{isset($data[0]->contact_meta_desc) ? $data[0]->contact_meta_desc:''}}"
                                                    placeholder="Enter Description" name="contact_meta_desc" >
                                            </div>
    
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
    
                                    <div class="card mb-3">
                                        <div class="card-header">
                                            <h5 class="card-tile mb-0">Terms & Condition Page</h5>
                                        </div>
                                        <div class="card-body">
    
                                            <div class="mb-2">
                                                <label class="form-label" for="img_title">Meta title</label>
                                                <input type="text" class="form-control" id="title1"
                                                    value="{{isset($data[0]->terms_meta_title) ? $data[0]->terms_meta_title:''}}"
                                                    placeholder="Enter Meta Title" name="terms_meta_title"
                                                    aria-label="img_title" >
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label" for="img_title">Meta Keywords</label>
                                               <input type="text" name="terms_meta_keys" value="{{isset($data[0]->terms_meta_keys) ? $data[0]->terms_meta_keys:''}}" class="meta_keys form-control" data-role="tagsinput" placeholder="Add Meta Keywords" />
                                            </div>
    
                                            <div class="mb-2">
                                                <label class="form-label" for="img_title">Description </label>
                                                <input type="text" class="form-control"
                                                    value="{{isset($data[0]->terms_meta_desc) ? $data[0]->terms_meta_desc:''}}"
                                                    placeholder="Enter Description" name="terms_meta_desc" >
                                            </div>
    
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
    
                                    <div class="card mb-3">
                                        <div class="card-header">
                                            <h5 class="card-tile mb-0">Privacy Policy Page</h5>
                                        </div>
                                        <div class="card-body">
    
                                            <div class="mb-2">
                                                <label class="form-label" for="img_title">Meta title</label>
                                                <input type="text" class="form-control" id="title1"
                                                    value="{{isset($data[0]->privacy_meta_title) ? $data[0]->privacy_meta_title:''}}"
                                                    placeholder="Enter Meta Title" name="privacy_meta_title"
                                                    aria-label="img_title" >
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label" for="img_title">Meta Keywords</label>
                                               <input type="text" name="privacy_meta_keys" value="{{isset($data[0]->privacy_meta_keys) ? $data[0]->privacy_meta_keys:''}}" class="meta_keys form-control" data-role="tagsinput" placeholder="Add Meta Keywords" />
                                            </div>
    
                                            <div class="mb-2">
                                                <label class="form-label" for="img_title">Description </label>
                                                <input type="text" class="form-control"
                                                    value="{{isset($data[0]->privacy_meta_desc) ? $data[0]->privacy_meta_desc:''}}"
                                                    placeholder="Enter Description" name="privacy_meta_desc" >
                                            </div>
    
                                        </div>
                                    </div>
                                </div>
                            </div>
    
            </div>
            </form>
        </div>
    
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>
    
    <script>
    $(document).ready(function() {
        $('.meta_keys').tagsinput({
            // trimValue: true,
            confirmKeys: [13, 44],
        });
    });
    </script>
    
    @endsection