@extends('layouts.commonMaster')
@section('layoutContent')
<style>
  .feature-options > div:first-child {
    font-weight: bold;
  }
  @keyframes blink {
  0% { opacity: 1; }
  50% { opacity: 0; }
  100% { opacity: 1; }
}

.blink {
  animation: blink 2s infinite;
}
</style>

<!-- Content wrapper -->
<div class="content-wrapper">

    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="py-1 mb-2">
            <span class="text-muted fw-light">Manage Admins</span>
        </h4>
        <div>
            <div class="alert alert-success d-none" id="successMessage"></div>
        </div>

        <div class="app-ecommerce-category">


            <div class="row">
                    <div class="col-lg-6 col-md-12 col-6 mb-6">
                      <div class="card h-100">
                        <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between mb-4">
                            <div class="avatar flex-shrink-0">
                              <img src="{{asset('assets/img/icons/unicons/chart-success.png') }}" alt="chart success" class="rounded">
                            </div>
                            <strong class="mb-1">Orders</strong>
                            <div class="dropdown">
                              <button class="d-none btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-dots-vertical-rounded text-muted"></i>
                              </button>
                                <a href="{{ route('download-orders-report') }}">
                                  <i class='h3 blink text-success bx bxs-download' ></i>
                                </a>
                              <div class="d-none dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3" style="">
                                <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                              </div>
                            </div>
                          </div>
                          <div class="mb-1">Total:  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ isset($total_orders)?$total_orders:'' }} </div>
                          <div class="mb-1">Failed:    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ isset($failed_orders)?$failed_orders:'' }}</div>
                          <div class="mb-1">Completed: &nbsp;{{isset($sales_count)?$sales_count:''}} </div>

                          <!-- <small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i> +72.80%</small> -->
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-6 mb-6">
                      <div class="card h-100">
                        <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between mb-4">
                            <div class="avatar flex-shrink-0">
                              <img src="{{asset('assets/img/icons/unicons/wallet-info.png')}}" alt="wallet info" class="rounded">
                            </div>
                            <strong class="mb-1">Sales</strong>
                            <div class="dropdown">
                              <button class="d-none btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-dots-vertical-rounded text-muted"></i>
                              </button>
                                <a href="{{ route('download-sales-report') }}">
                                  <i class='h3 blink text-success bx bxs-download' ></i>
                                </a>
                            </div>
                          </div>

                          <h4 class="card-title mb-3">₹{{isset($sales)?$sales:''}}</h4>
                          <small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i> {{isset($sales_count)?$sales_count:''}} (Sales count)</small>
                        </div>
                      </div>
                    </div>


                  <div class="col-xxl-8 mt-4 mb-6">
                    <div class="card h-100">
                      <div class="card-body row g-4 p-3">
                        <div class="col-md-6 card-separator">
                          <div class="p-6">
                            <div class="card-title d-flex align-items-start justify-content-between">
                              <h5 class="mb-0">New Customers</h5>
                              <h5>Old Customers</h5>
                              <a href="{{ route('download-customers-report') }}">
                                <i class="h3 blink text-success bx bxs-download"></i>
                              </a>
                            </div>
                            <div class="d-flex justify-content-around" style="position: relative;">
                              <div class="mt-auto">
                                <h3 class="mb-1">{{isset($new_users)?$new_users:''}}</h3>
                                <small class="{{isset($new_users)?'text-success':'text-danger'}} text-nowrap fw-medium">
                                  <i class="bx {{isset($new_users)?'bx-up-arrow-alt':'bx-down-arrow-alt'}}"></i> ( This Month )</small>
                              </div>

                              <div class="mt-auto">
                                <h3 class="mb-1">{{isset($old_users)?$old_users:''}}</h3>
                                <small class="text-success text-nowrap fw-medium"><i class="bx bx-up-arrow-alt"></i> ( Except This Month )</small>
                              </div>

                              <div class="resize-triggers"><div class="expand-trigger"><div style="width: 463px; height: 121px;"></div></div><div class="contract-trigger"></div></div></div>
                              <div class="d-flex justify-content-center" style="position: relative;">
                                  <strong>Total users: {{isset($total_users)?$total_users:''}}</strong>
                              </div>
                          </div>

                        </div>
                        <div class="col-md-6">
                          <div class="p-6">
                            <div class="card-title d-flex align-items-start justify-content-between">
                              <h5 class="mb-0">Best Selling Category</h5>
                            </div>
                            <div class="d-flex justify-content-between" style="position: relative;">

                              @isset($best_selling)
                                @foreach ($best_selling as $key => $val)
                                  <div class="mt-auto">
                                    <div class="h5 mb-1">{{ $key+1 }}. {{$val->category}}
                                    <small class="text-success text-nowrap fw-medium"><i class="bx bx-up-arrow-alt"></i> {{$val->count}}</small>
                                    </div>
                                  </div>
                                @endforeach
                              @endisset

                              <div>
                                  <a href="{{ route('download-best-selling-report') }}">
                                      <i class='h3 blink text-success bx bxs-download' ></i>
                                  </a>
                              </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

    </div>

                  <div class="row g-6 mt-3">
                      <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="card">
                          <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                              <h6 class="fw-normal mb-0 text-body">Category</h6>

                              <div>
                                  <a href="{{ route('download-category-report') }}">
                                      <i class='h3 blink text-success bx bxs-download' ></i>
                                  </a>
                              </div>

                            </div>
                            <div class="d-flex justify-content-between align-items-end">
                              <div class="role-heading">
                                <h5 class="mb-1"> {{isset($categories)?$categories:''}} </h5>
                              </div>
                            </div>

                          </div>
                        </div>
                      </div>
                      <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="card">
                          <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                              <h6 class="fw-normal mb-0 text-body">Subcategory</h6>

                              <div>
                                  <a href="{{ route('download-sub-category-report') }}">
                                      <i class='h3 blink text-success bx bxs-download' ></i>
                                  </a>
                              </div>


                            </div>
                            <div class="d-flex justify-content-between align-items-end">
                              <div class="role-heading">
                                  <h5 class="mb-1"> {{isset($sub_categories)?$sub_categories:''}} </h5>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="card">
                          <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                              <h6 class="fw-normal mb-0 text-body">Total Products</h6>

                              <div>
                                  <a href="{{ route('download-products-report') }}">
                                      <i class='h3 blink text-success bx bxs-download' ></i>
                                  </a>
                              </div>

                            </div>
                            <div class="d-flex justify-content-between align-items-end">
                              <div class="role-heading">
                                <h5 class="mb-1"> {{isset($total_products)?$total_products:''}} </h5>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>



                    </div>

                  </div>
    <!-- / Content -->

    @endsection
