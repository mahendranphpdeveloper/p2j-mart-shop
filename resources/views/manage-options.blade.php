@extends('layouts.commonMaster')
@section('layoutContent')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card p-3">
       <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Manage {{ $attribute->attribute_name }} Options</h5>
    <div class="d-flex align-items-center">
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary me-2">
            <i class="bx bx-arrow-back me-1"></i> Back
        </a>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addOptionModal">
            <i class="bx bx-plus me-1"></i> Add Option
        </button>
    </div>
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
                           placeholder="Search ..."
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
                    <th>Option Name</th>
                    <th>Slug</th>
                    @if(strtolower($attribute->attribute_name) == 'color')
                        <th>Color Code</th>
                    @endif
                    <th>Order</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($options as $option)
                <tr>
                    <td>{{ $option->{$attribute->attribute_slug . '_name'} }}</td>
                    <td>{{ $option->slug }}</td>
                    @if(strtolower($attribute->attribute_name) == 'color')
                        <td>
                            <span style="display:inline-block;width:30px;height:20px;background-color:{{ $option->color_code ?? '#fff' }};border:1px solid #ccc;border-radius:3px;"></span>
                          
                        </td>
                    @endif
                    <td>{{ $option->web_order }}</td>
                    <td>
                        <span class="badge bg-{{ $option->web_status == 0 ? 'success' : 'danger' }}">
                            {{ $option->web_status == 0 ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary edit-option" 
                                data-bs-toggle="modal" 
                                data-bs-target="#editOptionModal{{ $option->{'m_'.$attribute->attribute_slug.'_id'} }}"
                                data-id="{{ $option->{'m_'.$attribute->attribute_slug.'_id'} }}">
                            <i class="bx bx-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger delete-option" 
                                data-bs-toggle="modal"
                                data-bs-target="#deleteOptionModal{{ $option->{'m_'.$attribute->attribute_slug.'_id'} }}"
                                data-id="{{ $option->{'m_'.$attribute->attribute_slug.'_id'} }}">
                            <i class="bx bx-trash"></i>
                        </button>
                    </td>
                </tr>

                <!-- Edit Option Modal -->
                <div class="modal fade" id="editOptionModal{{ $option->{'m_'.$attribute->attribute_slug.'_id'} }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Option</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('attributes.option.update', ['slug' => $attribute->attribute_slug, 'id' => $option->{'m_'.$attribute->attribute_slug.'_id'}]) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="edit_option_name" class="form-label">Option Name</label>
                                        <input type="text" class="form-control" id="edit_option_name" 
                                               name="name" value="{{ $option->{$attribute->attribute_slug . '_name'} }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit_option_order" class="form-label">Display Order</label>
                                        <input type="number" class="form-control" id="edit_option_order" 
                                               name="order" value="{{ $option->web_order }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit_option_status" class="form-label">Status</label>
                                        <select class="form-select" id="edit_option_status" name="status" required>
                                            <option value="0" {{ $option->web_status == 0 ? 'selected' : '' }}>Active</option>
                                            <option value="1" {{ $option->web_status == 1 ? 'selected' : '' }}>Inactive</option>
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

                <!-- Delete Option Modal -->
                <div class="modal fade" id="deleteOptionModal{{ $option->{'m_'.$attribute->attribute_slug.'_id'} }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Confirm Deletion</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete this option?</p>
                                <p class="text-danger"><strong>Warning:</strong> This action cannot be undone.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <form action="{{ route('attributes.option.destroy', ['slug' => $attribute->attribute_slug, 'id' => $option->{'m_'.$attribute->attribute_slug.'_id'}]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete Option</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Add Option Modal -->
<div class="modal fade" id="addOptionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Option</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('attributes.option.store', ['slug' => $attribute->attribute_slug]) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="option_name" class="form-label">Option Name</label>
                        <input type="text" class="form-control" id="option_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="option_order" class="form-label">Display Order</label>
                        <input type="number" class="form-control" id="option_order" name="order" required>
                    </div>
                    <div class="mb-3">
                        <label for="option_status" class="form-label">Status</label>
                        <select class="form-select" id="option_status" name="status">
                            <option value="0">Active</option>
                            <option value="1">Inactive</option>
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
@endsection