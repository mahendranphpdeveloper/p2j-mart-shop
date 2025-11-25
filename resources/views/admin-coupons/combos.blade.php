@extends('layouts.commonMaster')

@section('layoutContent') 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
@section('title', 'All Combos |')
<style>
.swal2-container.swal2-top-end.swal2-backdrop-show {
    z-index: 1091 !important;
}
.swal2-popup {
  top: 10px !important;
  right: 10px !important;
}

a.btn.btn-primary.me-3.mb-3.add-discount {
    color: #fff;
}
</style>
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-datatable table-responsive">
                <div class="m-3">
                    <h4>Combos</h4>
                    <p>This Combos are available to all users.</p>
                </div>
                <div class="d-flex justify-content-end">
                    <a class="btn btn-primary me-3 mb-3 add-discount" href="{{ route('new.combo') }}">Add Combo</a>
                </div>
                <table id="couponTable" class="datatables-customers table border-top">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Combo Name</th>
                            <th>Combo Products</th>
                            <th>Total Price</th>
                            <th>Offer Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($combos as $combo)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $combo->name }}</td>
                            <td class="d-flex">
                                @foreach($combo->products() as $product)
                                    <div class="d-flex align-items-center me-2">
                                        <img src="{{ asset('/' . json_decode($product->images)[0]) }}" 
                                             alt="{{ $product->name }}" 
                                             width="40" 
                                             height="40" 
                                             class="me-1 product-image" 
                                             data-bs-toggle="modal" 
                                             data-bs-target="#productModal"
                                             data-combo-name="{{ $combo->name }}"
                                             data-products='@json($combo->products())'>
                                    </div>
                                @endforeach
                            </td>
                            <td>{{ $combo->total_price }}</td>
                            <td>{{ $combo->offer_price }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-{{ $combo->status == 1 ? 'success' : 'danger' }} dropdown-toggle" type="button" id="statusDropdown{{ $combo->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                        {{ $combo->status == 1 ? 'Active' : 'Deactive' }}
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="statusDropdown{{ $combo->id }}">
                                        <li><a class="dropdown-item" href="#" onclick="updateStatus({{ $combo->id }}, 1)">Active</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="updateStatus({{ $combo->id }}, 0)">Deactive</a></li>
                                    </ul>
                                </div>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="actionsDropdown{{ $combo->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="actionsDropdown{{ $combo->id }}">
                                        <li><a class="dropdown-item" href="{{ route('edit.combo', $combo->id) }}">Edit</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="deleteCombo({{ $combo->id }})">Delete</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Combo Products -->
<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel">Combo Products</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 id="comboNameInModal"></h6>
                <ul id="comboProductsList" class="list-group">
                    <!-- Combo products will be populated here -->
                </ul>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        // Handle click on product images
        $('.product-image').on('click', function() {
            const comboName = $(this).data('combo-name');
            const products = $(this).data('products');

            $('#comboNameInModal').text(`Combo: ${comboName}`);
            $('#comboProductsList').empty();

            products.forEach(product => {
                const productImage = JSON.parse(product.images)[0];
                $('#comboProductsList').append(`
                    <li class="list-group-item d-flex align-items-center">
                        <img src="{{ asset('/') }}${productImage}" alt="${product.name}" width="40" height="40" class="me-2">
                        <span>${product.name} - Rs. ${product.price}</span>
                    </li>
                `);
            });
        });
    });

    // Update combo status
    function updateStatus(comboId, status) {
        
        $.ajax({
            url: `{{ url('admin/combos/update-status') }}/${comboId}`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                status: status
            },
            success: function(response) {
                location.reload(); 
            }
        });
    }

    // Delete combo
    function deleteCombo(comboId) {
        if (confirm('Are you sure you want to delete this combo?')) {
            $.ajax({
                url: `{{ url('admin/combos/delete') }}/${comboId}`,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    location.reload(); // Reload the page to reflect the deletion
                }
            });
        }
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endsection