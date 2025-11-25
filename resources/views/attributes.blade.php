@extends('layouts.commonMaster')
@section('layoutContent')
@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error!</strong> {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success!</strong> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<style>
    .color-box {
        display: inline-block;
        width: 20px;
        height: 20px;
        border-radius: 4px;
        margin-right: 5px;
        border: 1px solid #ccc;
    }
    .badge {
        margin-right: 5px;
    }
    .option-container {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        margin-bottom: 10px;
    }
</style>
<style>
    #color_code {
        width: 50px;
        height: 30px;
        margin: 0;
        padding: 4px;
    }
    .color-show {
        width: 30px !important;
        height: 20px !important;
        display: inline-block;
        border: 1.5px solid #000;
        text-align: center;
    }
    .color-row {
        display: flex;
    }
    div#colors {
        width: 67%;
        height: 30px;
        margin: 0;
        padding: 4px;
    }
    .color-wrapper {
        margin-right: 10px;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card p-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>Attributes Management</h5>
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addAttributeModal">
                Add Attribute
            </button>
        </div>
<div class="card-body py-2">
    <div class="row align-items-center">
        <!-- Items per page dropdown (left side) -->
        <div class="col-md-6">
            <form method="GET" action="{{ route('attributes.index') }}" class="form-inline">
                <label for="perPage" class="me-2">Items per page:</label>
                <select name="perPage" id="perPage" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
                    <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('perPage') == 100 ? 'selected' : '' }}>100</option>
                </select>
            </form>
        </div>
        
        <!-- Search form (right side) -->
        <div class="col-md-6 text-end">
            <form method="GET" action="{{ route('attributes.index') }}" class="d-inline-flex">
                <div class="input-group input-group-sm" style="width: 250px;">
                    <input type="text" 
                           name="search" 
                           class="form-control form-control-sm" 
                           placeholder="Search attributes..."
                           value="{{ request('search') }}"
                           style="border-top-right-radius: 0; border-bottom-right-radius: 0;">
                    <button class="btn btn-sm btn-primary" 
                            type="submit"
                            style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
                        <i class="bx bx-search-alt"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
        <table class="table">
            <thead>
                <tr>
                    <th>Attribute Name</th>
                    <th>Display Order</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attributes as $attribute)
                <tr>
                    <td>{{ $attribute->attribute_name }}</td>
                    <td>{{ $attribute->display_order }}</td>
                    <td>
                        <span class="badge bg-{{ $attribute->status == 'active' ? 'success' : 'danger' }}">
                            {{ ucfirst($attribute->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('attributes.manage', ['slug' => $attribute->attribute_slug]) }}" 
                           class="btn mx-4 btn-icon btn-outline-primary p-2" style="width: fit-content;">
                            <span class="tf-icons bx bx-pencil"></span> Manage
                        </a>
                        <button class="btn btn-icon btn-outline-secondary p-2" data-bs-toggle="modal" 
                                data-bs-target="#editAttributeModal{{ $attribute->id }}">
                            <span class="tf-icons bx bx-edit"></span>
                        </button>
                        @if($attribute->attribute_slug != 'color')
                        <button class="btn btn-icon btn-outline-danger p-2" data-bs-toggle="modal" 
                                data-bs-target="#deleteAttributeModal{{ $attribute->id }}">
                            <span class="tf-icons bx bx-trash"></span>
                        </button>
                        @endif
                    </td>
                </tr>

                <!-- Edit Attribute Modal -->
                <div class="modal fade" id="editAttributeModal{{ $attribute->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Attribute</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('attributes.update', $attribute->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="attribute_name" class="form-label">Attribute Name</label>
                                        <input type="text" 
                                               class="form-control attribute_name" 
                                               id="attribute_name" 
                                               name="attribute_name" 
                                               value="{{ $attribute->attribute_name }}" 
                                               required 
                                               pattern="^[a-z]+$" 
                                               title="Use only lowercase English letters, no spaces, no numbers, no symbols, no uppercase"
                                               autocomplete="off">
                                        <div class="span">
                                            Only lowercase letters allowed. No spaces, numbers, symbols, or uppercase characters.
                                        </div>
                                    </div>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            const attrInputsEdit = document.querySelectorAll('.attribute_name');
                                            attrInputsEdit.forEach(function(attrInputEdit) {
                                                attrInputEdit.addEventListener('input', function() {
                                                    let val = this.value;
                                                    this.value = val.replace(/[^a-z]/g, '');
                                                });
                                            });
                                        });
                                    </script>
                                    <div class="mb-3">
                                        <label for="display_order" class="form-label">Display Order</label>
                                        <input type="number" class="form-control" id="display_order" 
                                               name="display_order" value="{{ $attribute->display_order }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-select" id="status" name="status" required>
                                            <option value="active" {{ $attribute->status == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ $attribute->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Delete Attribute Modal -->
                <div class="modal fade" id="deleteAttributeModal{{ $attribute->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('attributes.destroy', $attribute->id) }}" method="POST" id="deleteAttributeForm{{ $attribute->id }}">
                                @csrf
                                @method('DELETE')
                                <div class="modal-header">
                                    <h5 class="modal-title text-danger">Delete Attribute: "{{ $attribute->attribute_name }}"?</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="alert alert-info">
                                        <strong>Info:</strong> Removing this attribute will affect your <b>products</b> and <b>units</b> that are connected with this attribute. 
                                        <br>
                                        First, confirm you wish to remove this attribute.
                                    </div>
                                    <div class="mb-2">
                                        <span class="fw-bold">This attribute is used in:</span>
                                        <ul>
                                            <li>Product Units: <span id="affectedProductUnits{{$attribute->id}}" style="font-weight:normal">
                                                {{-- You may show dynamic info here in controller if available, or populate via AJAX --}}
                                                (Will affect associated product_unit records)
                                            </span></li>
                                            {{-- Add more affected area if needed --}}
                                        </ul>
                                    </div>
                                    <div class="alert alert-warning">
                                        <strong>Warning:</strong> This will also delete all its options and break the attribute from any product/unit that uses it.<br>
                                        <b>This action cannot be undone!</b>
                                    </div>
                                    <div>
                                        <label for="attributeDeleteConfirm{{$attribute->id}}" class="form-label"><strong>Type <span class="text-danger">delete</span> to confirm:</strong></label>
                                        <input type="text" id="attributeDeleteConfirm{{$attribute->id}}" class="form-control" required 
                                               autocomplete="off" 
                                               placeholder="Type 'delete' to continue"
                                               oninput="document.getElementById('deleteConfirmBtn{{$attribute->id}}').disabled = (this.value.trim().toLowerCase() !== 'delete')">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" id="deleteConfirmBtn{{$attribute->id}}" class="btn btn-danger" disabled>
                                        Delete Attribute
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
        
    </div>
</div>

<!-- Add Attribute Modal -->
<div class="modal fade" id="addAttributeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Attribute</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('attributes.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="new_attribute_name" class="form-label">Attribute Name</label>
                        <input type="text" class="form-control" id="new_attribute_name" name="attribute_name" required 
                            pattern="^[a-z]+$" 
                            title="Use only lowercase English letters, no spaces, no numbers, no symbols, no uppercase" 
                            autocomplete="off">
                        <div class="span">
                            Only lowercase letters allowed. No spaces, numbers, symbols, or uppercase characters.
                        </div>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const attrInput = document.getElementById('new_attribute_name');
                            attrInput.addEventListener('input', function() {
                                // Remove all except a-z lowercase
                                let val = this.value;
                                // Remove non-lowercase letters
                                this.value = val.replace(/[^a-z]/g, '');
                            });
                        });
                    </script>
                    <div class="mb-3">
                        <label for="new_display_order" class="form-label">Display Order</label>
                        <input type="number" class="form-control" id="new_display_order" name="display_order" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_status" class="form-label">Status</label>
                        <select class="form-select" id="new_status" name="status" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="options" class="form-label">Initial Options (comma separated)</label>
                        <textarea class="form-control" id="options" name="options" 
                                  placeholder="Enter comma separated options (e.g., Small, Medium, Large)"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Attribute</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection