<!-- BEGIN: Vendor JS-->
<!-- <script src="{{ asset(('assets/vendor/libs/jquery/jquery.js')) }}"></script> -->
<script src="{{ asset(('assets/vendor/libs/popper/popper.js')) }}"></script>
<script src="{{ asset(('assets/vendor/js/bootstrap.js')) }}"></script>
<script src="{{ asset(('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')) }}"></script>
<script src="{{ asset(('assets/vendor/libs/hammer/hammer.js')) }}"></script>
<script src="{{ asset(('assets/vendor/libs/typeahead-js/typeahead.js')) }}"></script>


<script src="{{ asset(('assets/vendor/js/menu.js')) }}"></script>
<script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>



{{-- <script src="{{ asset(('assets/vendor/libs/quill/katex.js')) }}"></script> --}}
{{-- <script src="{{ asset(('assets/vendor/libs/quill/quill.js')) }}"></script> --}}

<script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/dropzone/dropzone.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/jquery-repeater/jquery-repeater.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
<!-- <script src="{{ asset('assets/js/ui-cards-analytics.js') }}"></script> -->

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.45.2/apexcharts.min.js"></script> -->
<!-- <script src="{{ asset('assets/vendor/libs/tagify/tagify.js') }}"></script> -->

<script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>

@yield('vendor-script')
<!-- END: Page Vendor JS-->
<!-- BEGIN: Theme JS-->
<script src="{{ asset(('assets/js/main.js')) }}"></script>

<!-- END: Theme JS-->
<!-- Pricing Modal JS-->
@stack('pricing-script')
<!-- END: Pricing Modal JS-->
<!-- BEGIN: Page JS-->
@yield('page-script')
<!-- END: Page JS-->
