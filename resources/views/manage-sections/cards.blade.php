@extends('layouts.commonMaster')
@section('layoutContent')
<script src="{{ asset('assets/js/app-ecommerce-product-add.js') }}"></script>

<!-- Content wrapper -->
<div class="content-wrapper">

    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Manage Home /</span><span> Cards</span>
        </h4>
        @if(session()->has('message'))
            <div class="alert alert-success">{{session('message')}}</div>
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
            <form action="{{route('homesections.store')}}" method="post" enctype="multipart/form-data">
                @csrf
       
                <!-- Add Header -->
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">

                    <div class="d-flex flex-column justify-content-center">
                        <h4 class="mb-1 mt-3">Change 3 Cards details</h4>
                    </div>

                    <div class="d-flex align-content-center flex-wrap gap-3">
                        <button class="discard btn btn-label-secondary">Discard</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>

                </div>

                <div class="card m-4 p-3">
                    <ul class="nav nav-pills nav-fill">
                        <li class="nav-item">
                            <a class="nav-link active next-tab" aria-current="page" data-target="tab1" href="#">Card 1</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link next-tab" data-target="tab2" href="#">Card 2</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link next-tab" data-target="tab3" href="#">Card 3</a>
                        </li>
                    </ul>
                </div>

                <div class="tab-content">
                    <div class="tab-pane active" id="tab1">

                        <div class="row">

                            <!-- First column-->
                            <div class="col-lg-1"></div>
                            <div class="col-12 col-lg-8">

                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="card-tile mb-0">Card 1 Details</h5>
                                    </div>
                                    <div class="card-body">

                                        <div class="mb-3">
                                            <label class="form-label" for="img_title">Title 1</label>
                                            <input type="text" class="form-control" id="title1"
                                                value="{{isset($data[0]->card_1_title_1) ? $data[0]->card_1_title_1:''}}"
                                                placeholder="Enter Title 1" name="card_1_title_1"
                                                aria-label="img_title" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="img_title">Title 2</label>
                                            <input type="text" class="form-control" id="img_title2"
                                                value="{{isset($data[0]->card_1_title_2) ? $data[0]->card_1_title_2:''}}"
                                                placeholder="Enter Title 2" name="card_1_title_2"
                                                aria-label="img_title" required>
                                        </div>

                                        <!-- Image -->
                                        <div class="mb-3">
                                            <label class="form-label" for="image">Upload Image</label>
                                            <input class="form-control" type="file" id="image" name="image_1" >
                                            <small class="text-muted">Upload Image must have 455px Width and 205px Height</small>
                                            <div>
                                                @if(isset($data[0]->image_1) )
                                                <img src="{{asset('uploads/banners').'/'.$data[0]->image_1}}"
                                                    class="" id="imagePreview">
                                                @endif
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                        <button class="btn btn-primary next-tab" data-target="tab2">Next</button>
                    </div>
                    <!--  /  Content for Tab 1 -->
                    <div class="tab-pane" id="tab2">
                        <div class="row">

                            <!-- First column-->
                            <div class="col-lg-1"></div>
                            <div class="col-12 col-lg-8">

                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="card-tile mb-0">Card 2 Details</h5>
                                    </div>
                                    <div class="card-body">

                                        <div class="mb-3">
                                            <label class="form-label" for="img_title">Title 1</label>
                                            <input type="text" class="form-control" id="title1"
                                                value="{{isset($data[0]->card_2_title_1) ? $data[0]->card_2_title_1:''}}"
                                                placeholder="Enter Title 1" name="card_2_title_1"
                                                aria-label="img_title" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="img_title">Title 2</label>
                                            <input type="text" class="form-control" id="img_title2"
                                                value="{{isset($data[0]->card_2_title_2) ? $data[0]->card_2_title_2:''}}"
                                                placeholder="Enter Title 2" name="card_2_title_2"
                                                aria-label="img_title" required>
                                        </div>

                                        <!-- Image -->
                                        <div class="mb-3">
                                            <label class="form-label" for="image">Upload Image</label>
                                            <input class="form-control" type="file" id="image" name="image_2" >
                                            <small class="text-muted">Upload Image must have 455px Width and 205px Height</small>

                                            <div>
                                                @if(isset($data[0]->image_2) )
                                                <img src="{{asset('uploads/banners').'/'.$data[0]->image_2}}"
                                                    class="" id="imagePreview">
                                                @endif
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                        <button class="btn btn-primary next-tab" data-target="tab1">Previous</button>
                        <button class="btn btn-primary next-tab" data-target="tab3">Next</button>
                    </div>
                    <!--  /  Content for Tab 2 -->
                    <div class="tab-pane" id="tab3">
                        <div class="row">

                            <!-- First column-->
                            <div class="col-lg-1"></div>
                            <div class="col-12 col-lg-8">

                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="card-tile mb-0">Card 3 Details</h5>
                                    </div>
                                    <div class="card-body">

                                        <div class="mb-3">
                                            <label class="form-label" for="img_title">Title 1</label>
                                            <input type="text" class="form-control" id="title1"
                                                value="{{isset($data[0]->card_3_title_1) ? $data[0]->card_3_title_1:''}}"
                                                placeholder="Enter Title 1" name="card_3_title_1"
                                                aria-label="img_title" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="img_title">Title 2</label>
                                            <input type="text" class="form-control" id="img_title2"
                                                value="{{isset($data[0]->card_3_title_2) ? $data[0]->card_3_title_2:''}}"
                                                placeholder="Enter Title 2" name="card_3_title_2"
                                                aria-label="img_title" required>
                                        </div>

                                        <!-- Image -->
                                        <div class="mb-3">
                                            <label class="form-label" for="image">Upload Image</label>
                                            <input class="form-control" type="file" id="image" name="image_3">
                                            <small class="text-muted">Upload Image must have 455px Width and 205px Height</small>

                                            <div>
                                                @if(isset($data[0]->image_3) )
                                                <img src="{{asset('uploads/banners').'/'.$data[0]->image_3}}"
                                                    class="" id="imagePreview">
                                                @endif
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                        <button class="btn btn-primary next-tab" data-target="tab2">Previous</button>
                    </div>
                    <!--  /  Content for Tab 3 -->
                </div>
                <!-- Tabs end -->

        </div>
        </form>
    </div>

</div>
<!-- / Content -->
<script>
  
    document.querySelectorAll('.next-tab').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault(); 

            const targetTabId = this.getAttribute('data-target'); 
            const targetTab = document.getElementById(targetTabId); 

            document.querySelectorAll('.tab-pane').forEach(tab => {
                tab.classList.remove('active');
            });
            targetTab.classList.add('active');

            document.querySelectorAll('.nav-link').forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('data-target') === targetTabId) {
                    link.classList.add('active');
                }
            });
        });
    });
</script>

@endsection