@extends('layouts.commonMaster')
@section('layoutContent')

@if (session('message'))

<div aria-live="polite" aria-atomic="true" class="position-relative">
    <div class="toast-container top-0 end-0 p-3">
        <div class="bs-toast toast show bg-success" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <i class='bx bx-bell me-2'></i>
                <div class="me-auto fw-medium">Message</div>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                {{ session('message') }}
            </div>
        </div>
    </div>
</div>

@endif

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">

    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Account Settings /</span> Change Password
    </h4>

    <div class="row">
        <div class="col-md-12">

            <!-- Change Password -->
            <div class="card mb-4">
                <h5 class="card-header">Change Password</h5>
                <div class="card-body">
                    <form action="{{route('settings.store')}}" id="formAccountSettings" method="POST">
                        @csrf


                        <div class="row">
                            <div class="mb-3 col-md-6 form-password-toggle">
                                <label class="form-label" >Name</label>
                                <input type="text" name="name" class="form-control" value="{{ isset($admin_user->name)?$admin_user->name:'' }}" />
                            </div>
                                @if($errors->has('name'))
                                    <div class="text-danger">{{ $errors->first('name') }}</div>
                                @endif

                            <div class="mb-3 col-md-6 form-password-toggle">
                                <label class="form-label" >Email</label>
                                <input type="text"  class="form-control" value="{{ isset($admin_user->username)?$admin_user->username:'' }}" disabled/>
                            </div>
                        </div>


                        <div class="row">
                            <div class="mb-3 col-md-6 form-password-toggle">
                                <label class="form-label" for="newPassword">New Password</label>
                                <div class="input-group input-group-merge">
                                    <input class="form-control" type="password" id="newPassword" name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                                @if($errors->has('password'))
                                    <div class="text-danger">{{ $errors->first('password') }}</div>
                                @endif
                            </div>

                            <div class="mb-3 col-md-6 form-password-toggle">
                                <label class="form-label" for="confirmPassword">Confirm New Password</label>
                                <div class="input-group input-group-merge">
                                   <input class="form-control" type="password" id="newPassword" name="new_password"
    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                                @if($errors->has('confirm_password'))
                                    <div class="text-danger">{{ $errors->first('confirm_password') }}</div>
                                @endif
                            </div>

                            <div class="col-12 mt-1">
                                <button type="submit" class="btn btn-primary me-2">Save changes</button>
                                <button type="reset" class="btn btn-label-secondary">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--/ Change Password -->

        </div>
    </div>

</div>
<!-- / Content -->

@endsection
<script>
        document.addEventListener('DOMContentLoaded', function () {
            CKEDITOR.replace('editor');
            const toastEl = document.querySelector('.toast');
            if (toastEl) {
                const toast = new bootstrap.Toast(toastEl, {
                    autohide: true,
                    delay: 5000
                });
                setTimeout(() => {
                    toast.hide();
                }, 3000);
            }

        });
</script>
