@extends('layouts.commonMaster')

@section('layoutContent')

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
    <div class="app-ecommerce">
        <form action="{{ route('save-security-policy') }}" method="POST">
            @csrf
    
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Security Policy</h5>
                </div>
                <div class="card-body">
    
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
    
                    <!-- Title Input -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" 
                            value="{{ isset($securityPolicy) ? $securityPolicy->title : '' }}" required>
                    </div>
    
                    <!-- CKEditor Content -->
                    <div class="mb-3">
                        <label for="content" class="form-label">Content</label>
                        <textarea class="form-control" id="content" name="content">
                            {{ isset($securityPolicy) ? $securityPolicy->content : '' }}
                        </textarea>
                    </div>
    
                    <!-- Save Button -->
                    <button type="submit" class="btn btn-primary">Save</button>
    
                </div>
            </div>
    
        </form>
    </div>
    
    {{-- CKEditor Script --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.2/classic/ckeditor.js"></script>
    <script>
        ClassicEditor.create(document.querySelector('#content'))
            .catch(error => console.error(error));
    </script>
    
    @endsection