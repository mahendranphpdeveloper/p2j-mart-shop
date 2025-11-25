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

    <form action="{{ route('contact-us.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="d-flex justify-content-between">
            <div class="h4 py-1 mb-4">
                <span class="text-muted fw-light">Update Contact Us Information</span>
            </div>
            <div>
                <button type="submit" class="btn btn-success">Save</button>
            </div>
        </div>

        <div class="card  mb-3 p-3" style="    background-color: aqua;">

            <div class="mb-3">
                <label for="meta_title" class="form-label">Meta Title</label>
                <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $contactUs->meta_title ?? '') }}" aria-describedby="metaTitleHelp">
                @error('meta_title')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="meta_keywords" class="form-label">Meta Keywords</label>
                <input type="text" name="meta_keywords" class="form-control" value="{{ old('meta_keywords', $contactUs->meta_keywords ?? '') }}" aria-describedby="metaKeywordsHelp">
                @error('meta_keywords')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="meta_description" class="form-label">Meta Description</label>
                <textarea name="meta_description" class="form-control" aria-describedby="metaDescriptionHelp">{{ old('meta_description', $contactUs->meta_description ?? '') }}</textarea>
                @error('meta_description')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <!-- Meta Data Section -->

                <div class="row">
                    <div class="col-6">

                        <!-- Titles Section -->
                        <div class="mb-3">
                            <label for="address_title_1" class="form-label">Address Title </label>
                            <input type="text" name="address_title_1" class="form-control" value="{{ old('address_title_1', $contactUs->address_title_1 ?? '') }}" aria-describedby="addressTitle1Help">
                            @error('address_title_1')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone_title_1" class="form-label">Phone Title </label>
                            <input type="text" name="phone_title_1" class="form-control" value="{{ old('phone_title_1', $contactUs->phone_title_1 ?? '') }}" aria-describedby="phoneTitle1Help">
                            @error('phone_title_1')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email_title_1" class="form-label">Email Title </label>
                            <input type="text" name="email_title_1" class="form-control" value="{{ old('email_title_1', $contactUs->email_title_1 ?? '') }}" aria-describedby="emailTitle1Help">
                            @error('email_title_1')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">

                        <!-- Address, Phone, Email -->
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea name="address" class="form-control" aria-describedby="addressHelp">{{ old('address', $contactUs->address ?? '') }}</textarea>
                            @error('address')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <textarea name="phone" class="form-control" aria-describedby="phoneHelp">{{ old('phone', $contactUs->phone ?? '') }}</textarea>
                            @error('phone')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <textarea name="email" class="form-control" aria-describedby="emailHelp">{{ old('email', $contactUs->email ?? '') }}</textarea>
                            @error('email')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>




                    <!-- Embed Map Link -->
                    <div class="mb-3">
                        <label for="embed_map_link" class="form-label">Embed Map Link</label>
                        <input type="text" name="embed_map_link" class="form-control" value="{{ old('embed_map_link', $contactUs->embed_map_link ?? '') }}" aria-describedby="embedMapLinkHelp">
                        @error('embed_map_link')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-6">
                        <div class="mb-3">
                            <label for="form_title" class="form-label">Form Title</label>
                            <input type="text" name="form_title" class="form-control" value="{{ old('form_title', $contactUs->form_title ?? '') }}" aria-describedby="formTitleHelp">
                            @error('form_title')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="form_content" class="form-label">Form Content</label>
                            <textarea name="form_content" id="form_content" class="form-control" aria-describedby="formContentHelp">{{ old('form_content', $contactUs->form_content ?? '') }}</textarea>
                            @error('form_content')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror  
                        </div>
                    </div>
                </div>
                <!-- Form Title and Content -->

            </div>
        </div>

    </form>

    <hr>
</div>
<script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#form_content'), {
            toolbar: ['bold', 'bulletedList'], // Only bold and bullet list options
            paste: {
                format: 'text' // Ensures pasted content is in plain text
            },
            // Optional: Configure other settings if needed
        })
        .catch(error => {
            console.error(error);
        });

    // Apply a static font size using CSS
    document.querySelector('.ck-editor__editable').style.fontSize = '16px'; // Change this size as needed
</script>

<style>
    /* Static font sizes for p, h1, h2, h3, h4 tags in CKEditor */
    .ck-editor__editable {
        font-size: 16px; /* Set default font size for content inside CKEditor */
    }

    .ck-editor__editable p {
        font-size: 16px; /* Set static font size for <p> */
    }

    .ck-editor__editable h1 {
        font-size: 16px; /* Static font size for <h1> */
    }

    .ck-editor__editable h2 {
        font-size: 16px; /* Static font size for <h2> */
    }

    .ck-editor__editable h3 {
        font-size: 16px; /* Static font size for <h3> */
    }

    .ck-editor__editable h4 {
        font-size: 16px; /* Static font size for <h4> */
    }
</style>

<script>
        document.addEventListener('DOMContentLoaded', function() {

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
            const keywords = document.querySelector('input[name=meta_keywords ]');
            new Tagify(keywords);
        });

        document.querySelector('form').addEventListener('submit', function(event) {
            // Select the address or phone textarea elements
            const address = document.getElementById('address');
            const phone = document.getElementById('phone');
            const email = document.getElementById('email');

            // If the address field exists, process its value
            if (address) {
                // Split the input by newlines and filter out empty lines
                const lines = address.value.split('\n').filter(line => line.trim() !== '');
                // Convert lines to JSON and update the textarea's value
                address.value = JSON.stringify(lines);
            }

            // If the phone field exists, process its value
            if (phone) {
                // Split the input by newlines and filter out empty lines
                const lines = phone.value.split('\n').filter(line => line.trim() !== '');
                // Convert lines to JSON and update the textarea's value
                phone.value = JSON.stringify(lines);
            }
            if (email) {
                // Split the input by newlines and filter out empty lines
                const lines = email.value.split('\n').filter(line => line.trim() !== '');
                // Convert lines to JSON and update the textarea's value
                email.value = JSON.stringify(lines);
            }
        });
    </script>
@endsection