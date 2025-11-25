<!-- BEGIN: Theme CSS-->
<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet">

<link rel="stylesheet" href="{{ asset(('assets/vendor/fonts/boxicons.css')) }}" />
<link rel="stylesheet" href="{{ asset(('assets/vendor/fonts/flag-icons.css')) }}" />
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<!-- Core CSS -->
<link rel="stylesheet" href="{{ asset(('assets/vendor/css/core.css')) }}" />
<link rel="stylesheet" href="{{ asset(('assets/vendor/css/theme-default.css')) }}" />
<link rel="stylesheet" href="{{ asset(('assets/vendor/fonts/fontawesome.css')) }}" />



<link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

<!-- Vendors CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/editor.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />

<!-- Vendor Styles -->
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/typography.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/katex.css') }}" />

<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/dropzone/dropzone.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/tagify/tagify.css') }}" />

<!-- Vendor Styles -->
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />

<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.45.2/apexcharts.min.css" /> -->


<!-- Page Styles -->
<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/card-analytics.css') }}" />

<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />


<script src="{{ asset('assets/vendor/libs/tagify/tagify.js') }}"></script>


<!-- laravel style -->
<script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
<script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<!-- <script src="{{ asset('assets/js/config.js') }}"></script> -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>

<style>
 .cke_notifications_area{
    display: none;
 }
.cke_notification_warning {
    display: none;
}
.bootstrap-tagsinput {
    width: 100%;
    min-height: 38px;
}
.bootstrap-tagsinput .tag {
    background-color: #007bff;
    color: white;
    padding: 0.3em 0.5em;
    margin: 2px;
    border-radius: 3px;
}
</style>
<!-- Vendor Styles -->
@yield('vendor-style')


<!-- Page Styles -->
@yield('page-style')
