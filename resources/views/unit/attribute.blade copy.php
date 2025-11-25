@extends('layouts.commonMaster')
@section('layoutContent')

@section('title', 'All customers |')

@php
    $label = ucfirst($type); // e.g., 'Size'
    $title = $label . ' List';
    $form_id = strtolower($type) . '-form'; // e.g., size-form, color-form
    $table_id = strtolower($type) . '_table';
    $route_prefix = strtolower($type); // e.g., size
@endphp

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">{{ $title }} /</span> {{ $label }}
        </h4>

        <div class="card">
            <div class="card-datatable table-responsive">
                <table id="{{ $table_id }}" class="datatables-customers table border-top">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ $label }}</th>
                            <th>Order</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <!-- Offcanvas Form -->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="edit-model" aria-labelledby="offcanvasEndLabel">
                <div class="offcanvas-header">
                    <h5 id="offcanvasEndLabel" class="offcanvas-title">{{ $label }}</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body mb-auto mx-0 flex-grow-0">
                    <form id="{{ $form_id }}" onsubmit="return false">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">{{ $label }} Name*</label>
                            <input type="text" class="form-control" name="{{ $route_prefix }}_name" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Order *</label>
                            <input type="text" class="form-control onlynumber" name="web_order" required />
                            <div class="form-text text-danger" id="order-info">Order between 1 to 8</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Select status</label>
                            <select class="form-select" name="status" required>
                                <option value="">Select Status</option>
                                <option value="0">Active</option>
                                <option value="1">Inactive</option>
                            </select>
                        </div>
                        <div class="offcanvas-header align-self-end">
                            <input type="hidden" name="id" value="0" />
                            <button type="reset" class="btn bg-label-danger" data-bs-dismiss="offcanvas">Discard</button>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let ta;

$(document).ready(function () {
    ta = $("#{{ $table_id }}").DataTable({
        ajax: {
            url: '{{ route("get-table-data") }}?table={{ $type }}',
            method: 'GET',
        },
        columns: [
            {
                className: "text-center",
                render: (data, type, row, meta) => meta.row + 1
            },
            { data: "{{ $route_prefix }}_name" },
            { data: "web_order" },
            {
                className: "text-center",
                render: (data, type, row) =>
                    `<span class="badge bg-label-${row.web_status == 1 ? 'danger' : 'success'}">
                        ${row.web_status == 1 ? 'Inactive' : 'Active'}
                    </span>`
            },
            {
                className: "text-center",
                render: (data, type, row) => `
                    <button type="button" data-id="${row.id}" class="update_data btn btn-icon btn-outline-primary">
                        <span class="tf-icons bx bx-pencil"></span>
                    </button>
                    <button type="button" data-id="${row.id}" class="btn delete btn-icon btn-outline-danger">
                        <span class="tf-icons bx bxs-trash"></span>
                    </button>
                `
            }
        ]
    });



    $(document).on('click', '.delete', function () {
        const id = $(this).data('id');
        Swal.fire({ ... }).then((result) => {
            if (result.isConfirmed) {
                $.post('{{ route("delete-" . $route_prefix . "-table") }}', { id, _token: '{{ csrf_token() }}' }, function (res) {
                    if (res.error_code == 200) ta.ajax.reload();
                });
            }
        });
    });

    $(document).on('click', '.update_data', function () {
        const id = $(this).data('id');
        $.get('{{ route("get" . ucfirst($route_prefix) . "Data") }}', { id }, function (res) {
            const form = $("#{{ $form_id }}")[0];
            form.reset();
            if (id == 0) {
                form.id.value = 0;
                form.web_order.value = res.count + 1;
            } else {
                form.id.value = id;
                form["{{ $route_prefix }}_name"].value = res.data["{{ $route_prefix }}_name"] ?? '';
                form.web_order.value = res.data.web_order ?? '';
                form.status.value = res.data.web_status ?? '';
            }
            $('#edit-model').offcanvas('show');
        });
    });

    $('#{{ $form_id }}').on('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        $.ajax({
            url: '{{ route("store" . ucfirst($route_prefix)) }}',
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                if (res.error_code == 200) {
                    $('#edit-model').offcanvas('hide');
                    ta.ajax.reload();
                }
            }
        });
    });
});
</script>

@endsection
