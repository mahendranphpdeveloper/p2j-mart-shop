@extends('layouts.commonMaster')
@section('layoutContent')
<script src="{{ asset('assets/js/app-ecommerce-product-add.js') }}"></script>

<!-- Content wrapper -->
<div class="content-wrapper">

    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Manage Home /</span><span> Contact Us</span>
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
            <form action="{{route('save.contact.us')}}" id="headerFooter" method="post" enctype="multipart/form-data">
                @csrf

                <!-- Add Header -->
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">

                    <div class="d-flex flex-column justify-content-center">
                        <!-- <h4 class="mb-1 mt-3">Change Contact Us Details</h4> -->
                    </div>

                    <div class="d-flex align-content-center flex-wrap gap-3">
                        <button class="discard btn btn-label-secondary">Discard</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>

                </div>

                <!-- Add Footer -->
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">

                </div>

                <div class="row">

                    <!-- Second column-->
                    <div class="col-lg-1"></div>
                    <div class="col-12 col-lg-8">

                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-tile mb-0">Page Contents</h5>
                            </div>
                            <div class="card-body">

                                <div class="mb-3">
                                    <label class="form-label" for="content">Address Title</label>
                                    <input class="form-control" type="text" id="content" name="address_title"
                                        placeholder="You can change Address Title name"
                                        value="{{ isset($data[0]->address_title) ? $data[0]->address_title:''}}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="content">Address Content</label>
                                    <textarea class="form-control" type="text" id="content" name="address_content"
                                        placeholder="Enter the Address">{!! isset($data[0]->address_content) ? $data[0]->address_content:''!!}</textarea>
                                </div>

                                <hr>

                                <div class="mb-3 mt-2">
                                    <label class="form-label" for="content">Contact Info Title</label>
                                    <input class="form-control" type="text" id="content" name="contact_us_title"
                                        placeholder="You can change contact info title"
                                        value="{{ isset($data[0]->contact_us_title) ? $data[0]->contact_us_title:''}}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="mobile">Mobile No</label>
                                    <input type="text" class="form-control" id="mobile"
                                        value="{{isset($data[0]->mobile_no) ? $data[0]->mobile_no:''}}"
                                        placeholder="Enter Mobile No" name="mobile_no" aria-label="mobile">
                                </div>

                                <hr>

                                <div class="mb-4">
                                    <label class="form-label" for="email">Email Info Title</label>
                                    <input type="text" class="form-control" id="email_info"
                                        value="{{isset($data[0]->email_title) ? $data[0]->email_title:''}}"
                                        placeholder="Enter Email Title" name="email_title" aria-label="email_info">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label" for="email">Email Id</label>
                                    <input type="text" class="form-control" id="email"
                                        value="{{isset($data[0]->email) ? $data[0]->email:''}}"
                                        placeholder="Enter Email Id" name="email" aria-label="email">
                                </div>

                                <div class="mb-4">
                                    <label class="form-label" for="map">Map Link</label>
                                    <input type="text" class="form-control" id="map"
                                        value="{{isset($data[0]->map_link) ? $data[0]->map_link:''}}"
                                        placeholder="Enter Map Embbeded Link" name="map_link" aria-label="email">
                                </div>
                                @if(isset($data[0]->map_link))
                                @php echo $data[0]->map_link @endphp
                                @endif
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
    var input = document.querySelector("input[name=mobile_no]");
    var tagify = new Tagify(input);
    var input = document.querySelector("input[name=email]");
    var tagify = new Tagify(input);
</script>

@endsection