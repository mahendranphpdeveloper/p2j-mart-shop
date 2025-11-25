@extends('layouts.commonMaster')

@section('layoutContent')

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

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white shadow-sm px-3 py-2 rounded">

                <li class="breadcrumb-item">
                    <a href="{{ route('categories.view') }}" class="text-dark text-decoration-none">
                        <i class="fas fa-tags  me-1"></i> Categories
                    </a>
                </li>
                <li class="breadcrumb-item active text-primary" aria-current="page">
                    <i class="fas fa-th-list me-1"></i> Subcategories
                </li>
            </ol>
        </nav>
    </div>




    <div class="card p-3 mt-3">
        <div class="container mt-5">
            <button class="btn btn-primary mb-3 float-end" data-bs-toggle="modal" data-bs-target="#addsubcategoriesModal">Add subcategories</button>
            <table class="table table-bordered" id="subcategories-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Image</th>
                        <th>Attributes</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- subcategories Rows will be inserted here dynamically -->
                </tbody>
            </table>
        </div>

        <!-- Add subcategories Modal -->
        <div class="modal fade" id="addsubcategoriesModal" tabindex="-1" aria-labelledby="addsubcategoriesModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title " id="addsubcategoriesModalLabel">Add subcategories</h5>
                        <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addsubcategoriesForm">
                            @csrf
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Image</label>
                                <input type="file" class="form-control" id="image" name="image" required>
                            </div>
                            <input type="hidden" class="form-control" id="category_slug" name="category_slug" value="{{$category_slug}}" required>
                            <div class="mb-3">
                                <label for="attribute_search" class="form-label">Search Attribute</label>
                                <input type="text" class="form-control" id="attribute_search" placeholder="Search attributes..." onkeyup="filterAttributes()">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Select Attributes</label>
                                <div id="attributeList">
                                    @foreach($attributes as $attribute)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            id="attribute_{{ $attribute->id }}"
                                            name="selected_attributes[{{ $attribute->id }}]"
                                            value="{{ $attribute->attribute_name }}">
                                        <label class="form-check-label" for="attribute_{{ $attribute->id }}">
                                            {{ $attribute->attribute_name }}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="display_order" class="form-label">Order</label>
                                <input type="number" min="1" class="form-control" id="display_order" name="display_order" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit subcategories Modal -->
        <div class="modal fade" id="editsubcategoriesModal" tabindex="-1" aria-labelledby="editsubcategoriesModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editsubcategoriesModalLabel">Edit subcategories</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form id="editsubcategoriesForm">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" id="editsubcategoriesId" name="id">
                            <div class="mb-3">
                                <label for="editTitle" class="form-label">Title</label>
                                <input type="text" class="form-control" id="editTitle" name="title" required>
                            </div>
                            <div class="mb-3">
                                <label for="editimage" class="form-label">Image</label>
                                <input type="file" class="form-control" id="editimage" name="image">
                            </div>
                            {{-- <div class="mb-3">
                                <label for="editDescription" class="form-label">Description</label>
                                <textarea class="form-control" id="editDescription" name="description" rows="4" required></textarea>
                            </div> --}}
                             <div class="mb-3">
                                <label for="edit_attribute_search" class="form-label">Search Attribute</label>
                                <input type="text" class="form-control" id="edit_attribute_search" placeholder="Search attributes..." onkeyup="edit_filterAttributes()">
                            </div> 

                            <div class="mb-3">
                                <label class="form-label">Select Attributes</label>
                                <div id="edit_attributeList">
                                    @foreach($attributes as $attribute)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            id="edit_attribute_{{ $attribute->id }}"
                                            name="selected_attributes[{{ $attribute->id }}]"
                                            value="{{ $attribute->attribute_name }}"
                                            @if(isset($selectedAttributes) && array_key_exists($attribute->id, $selectedAttributes)) checked @endif>
                                        <label class="form-check-label" for="edit_attribute_{{ $attribute->id }}">
                                            {{ $attribute->attribute_name }}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div> 
                            <div class="mb-3">
                                <label for="editDisplayOrder" class="form-label">Order</label>
                                <input type="number" min="1" class="form-control" id="editDisplayOrder" name="display_order" required>
                            </div>
                            <div class="mb-3">
                                <label for="editStatus" class="form-label">Status</label>
                                <select class="form-control" id="editStatus" name="status" required>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete subcategories Modal -->
        <div class="modal fade" id="deletesubcategoriesModal" tabindex="-1" aria-labelledby="deletesubcategoriesModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deletesubcategoriesModalLabel">Delete subcategories</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-4">
                            <h4 class="text-danger">Delete Confirmation</h4>
                            <p class="lead">Are you sure you want to delete the subcategory "<strong id="subcategoriesName"></strong>"?</p>
                            <p>Please type the subcategory title "<strong id="subcategoriesNameConfirmation"></strong>" to confirm:</p>
                        </div>
                        <div class="mb-4">
                            <input type="text" id="titleConfirmationInput" class="form-control form-control-lg" placeholder="Type the subcategory title to confirm" />
                        </div>
                        <form id="deletesubcategoriesForm">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" id="deletesubcategoriesId">
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-danger btn-lg w-48" id="deleteButton" disabled>
                                    <i class="fa fa-trash-alt"></i> Delete
                                </button>
                                <button type="button" class="btn btn-secondary btn-lg w-48" data-bs-dismiss="modal">
                                    <i class="fa fa-times"></i> Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function filterAttributes() {
            let input = document.getElementById("attribute_search").value.toLowerCase();
            let attributes = document.querySelectorAll("#attributeList .form-check");

            attributes.forEach(attr => {
                let label = attr.querySelector("label").textContent.toLowerCase();
                attr.style.display = label.includes(input) ? "block" : "none";
            });
        }


        function edit_filterAttributes() {
            let input = document.getElementById("edit_attribute_search").value.toLowerCase();
            let attributes = document.querySelectorAll("#edit_attributeList .form-check");

            attributes.forEach(attr => {
                let label = attr.querySelector("label").textContent.toLowerCase();
                attr.style.display = label.includes(input) ? "block" : "none";
            });
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const subcategoriesTable = document.getElementById('subcategories-table').getElementsByTagName('tbody')[0];
            let subcategoriesData = [];
            var category_slug = @json($category_slug);
            function fetchsubcategories() {
                $.ajax({
                    url: "{{ route('subcategories.index', ':category_slug') }}".replace(':category_slug', category_slug),
                    type: 'GET',
                    success: function(data) {
                        subcategoriesData = data.subcategories;
                        console.log(data.count);
                        document.getElementById('display_order').value = data.count + 1;
                        document.getElementById('display_order').setAttribute('max', data.count + 1); // max = count + 1
                        document.getElementById('editDisplayOrder').setAttribute('max', data.count); // max = count + 1
                        rendersubcategoriesTable();
                    },
                    error: function(error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error fetching subcategories: ' + error,
                        });
                    }
                });
            }
            // Render subcategories in table
            function rendersubcategoriesTable() {
                subcategoriesTable.innerHTML = ''; // Clear existing rows
                subcategoriesData.forEach(subcategory => {
                    const row = subcategoriesTable.insertRow();
                    const routeViewsproductsPage = @json(route('products.show', ['product' => '__slug__']));
                    row.innerHTML = `
                    <td>${subcategory.title}</td>
                    <td><img src="{{asset('/${subcategory.image}')}}" class="img-thumbnail" width="80"></td>
                    <td>
                    <ul>
                        ${subcategory.selected_attributes 
                        ? Object.values(subcategory.selected_attributes)
                            .map(attr => `<li>${attr}</li>`)
                            .join("") 
                        : ""}
                    </ul>
                    </td>


                    <td>${subcategory.display_order}</td>
                    <td>${subcategory.status}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="editsubcategory(${subcategory.id})" data-bs-toggle="modal" data-bs-target="#editsubcategoriesModal">
                            <i class="fa fa-pencil-alt"></i> 
                        </button>
                          <button class="btn btn-danger btn-sm" onclick="deletesubcategory(${subcategory.id}, '${subcategory.title}')" data-bs-toggle="modal" data-bs-target="#deletesubcategoriesModal">
                        <i class="fa fa-trash"></i> 
                          </button>
                        <a href="${routeViewsproductsPage.replace('__slug__', subcategory.id)}" class="btn btn-info btn-sm">
                        Manage Products
                        </a>
                    </td>
                `;
                });
            }

            // Add subcategory
            $('#addsubcategoriesForm').on('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                $.ajax({
                    url: "{{ route('subcategories.store') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    success: function(data) {
                        if (data.success) {
                            subcategoriesData.push(data.subcategory);
                            rendersubcategoriesTable();
                            $('#addsubcategoriesForm')[0].reset();
                            $('#addsubcategoriesModal').modal('hide');
                            fetchsubcategories();
                            Swal.fire({
                                icon: 'success',
                                title: 'subcategory Added',
                                text: 'The subcategory has been added successfully.',
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Error: Upload the Image in PNG or JPG format.' ,
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error: ' + error,
                        });
                    }
                });
            });            
            window.editsubcategory = function(id) {
                const subcategory = subcategoriesData.find(p => p.id === id);
                $('#editsubcategoriesId').val(subcategory.id);
                $('#editTitle').val(subcategory.title);
                // Set checkboxes for selected attributes in edit modal (edit_attributeList)
                $('#edit_attributeList input[type="checkbox"]').prop('checked', false); // Uncheck all first
                if (subcategory.selected_attributes) {
                    // selected_attributes is expected to be an object with attribute ids as keys (or an array of ids)
                    if (Array.isArray(subcategory.selected_attributes)) {
                        subcategory.selected_attributes.forEach(function(attrId) {
                            $('#edit_attribute_' + attrId).prop('checked', true);
                        });
                    } else {
                        Object.keys(subcategory.selected_attributes).forEach(function(attrId) {
                            $('#edit_attribute_' + attrId).prop('checked', true);
                        });
                    }
                }
                $('#editDescription').val(subcategory.description);
                $('#editDisplayOrder').val(subcategory.display_order);
                $('#editStatus').val(subcategory.status);
            };
            $('#editsubcategoriesForm').on('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const subcategoryId = $('#editsubcategoriesId').val();
                $.ajax({
                    url: `{{ route('subcategories.update', ':subcategory') }}`.replace(':subcategory', subcategoryId),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        '_method': 'PATCH',
                    },
                    success: function(data) {
                        if (data.success) {
                            subcategoriesData = subcategoriesData.map(subcategory => subcategory.id === data.subcategory.id ? data.subcategory : subcategory);
                            rendersubcategoriesTable();
                            $('#editsubcategoriesModal').modal('hide');
                            fetchsubcategories();
                            Swal.fire({
                                icon: 'success',
                                title: 'subcategory Updated',
                                text: 'The subcategory has been updated successfully.',
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Error: ' + data.message,
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error: ' + error,
                        });
                    }
                });
            });

            $('#deletesubcategoriesForm').on('submit', function(e) {
                e.preventDefault();
                const subcategoryId = $('#deletesubcategoriesId').val(); // Get the subcategory ID to be deleted
                $.ajax({
                    url: `{{ route('subcategories.destroy', ':subcategory') }}`.replace(':subcategory', subcategoryId), // Construct URL dynamically
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        '_method': 'DELETE', // Use DELETE method as per RESTful conventions
                    },
                    success: function(data) {
                        if (data.success) {
                            subcategoriesData = subcategoriesData.filter(subcategory => subcategory.id !== subcategoryId); // Remove the deleted subcategory from the data
                            rendersubcategoriesTable(); // Re-render the table after deletion
                            $('#deletesubcategoriesModal').modal('hide'); // Close the modal
                            Swal.fire({
                                icon: 'success',
                                title: 'subcategory Deleted',
                                text: 'The subcategory has been deleted successfully.',
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Error: ' + data.message,
                            });
                        }
                        fetchsubcategories(); // Refresh subcategories data
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error: ' + error,
                        });
                    }
                });
            });

            fetchsubcategories();
        });

        function deletesubcategory(subcategoryId, subcategoryTitle) {
            console.log(subcategoryId);
            console.log('dfsfsd');
            console.log(subcategoryTitle);
            // Set the subcategory title and ID in the modal for confirmation
            document.getElementById('subcategoriesName').textContent = subcategoryTitle;
            document.getElementById('subcategoriesNameConfirmation').textContent = subcategoryTitle;
            document.getElementById('deletesubcategoriesId').value = subcategoryId;

            // Enable or disable the delete button based on the input in the modal
            const titleConfirmationInput = document.getElementById('titleConfirmationInput');
            const deleteButton = document.getElementById('deleteButton');

            // Check if the user typed the correct subcategory title
            titleConfirmationInput.addEventListener('input', function() {
                if (titleConfirmationInput.value.trim() === subcategoryTitle) {
                    deleteButton.disabled = false; // Enable the delete button if the title matches
                } else {
                    deleteButton.disabled = true; // Disable the delete button if the title doesn't match
                }
            });
        }
    </script>
    @endsection