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
    <!-- <h4 class="mb-0 fw-bold">Categories</h4> -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-white shadow-sm px-3 py-2 rounded mb-0">
            <!-- <li class="breadcrumb-item">
                <a href="{{route('categories.view')}}" class="text-dark text-decoration-none">
                    <i class="bx bxs-shopping-bags me-1"></i> Products
                </a>
            </li> -->
            
            <li class="breadcrumb-item active text-primary" aria-current="page">
                <i class="fas fa-tags me-1"></i> Categories
            </li>
        </ol>
    </nav>
</div>


    <div class="card p-3 mt-3">
        <div class="container mt-5">
            <!-- Button to open Add categories Modal -->
            <button class="btn btn-primary mb-3 float-end " data-bs-toggle="modal" data-bs-target="#addcategoriesModal">Add Categories</button>

            <!-- Categories Table -->
            <table class="table table-bordered" id="categories-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Image</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Categories Rows will be inserted here dynamically -->
                </tbody>
            </table>
        </div>

        <!-- Add Categories Modal -->
        <div class="modal fade" id="addcategoriesModal" tabindex="-1" aria-labelledby="addcategoriesModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addcategoriesModalLabel">Add Categories</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addcategoriesForm">
                            @csrf
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            <div class="mb-3">
                                    <label for="image" class="form-label">Image</label>
                                    <input type="file" class="form-control" id="image" name="image" required>
                                </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
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

        <!-- Edit Categories Modal -->
        <div class="modal fade" id="editcategoriesModal" tabindex="-1" aria-labelledby="editcategoriesModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editcategoriesModalLabel">Edit Categories</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editcategoriesForm">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" id="editcategoriesId" name="id">
                            <div class="mb-3">
                                <label for="editTitle" class="form-label">Title</label>
                                <input type="text" class="form-control" id="editTitle" name="title" required>
                            </div>
                            <div class="mb-3">
                                <label for="editimage" class="form-label">Image</label>
                                <input type="file" class="form-control" id="editimage" name="image">
                                <div id="editImagePreview" class="mt-2">
                                    <!-- Image preview will be inserted here dynamically -->
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="editDescription" class="form-label">Description</label>
                                <textarea class="form-control" id="editDescription" name="description" rows="4" required></textarea>
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

        <!-- Delete Categories Modal -->
        <div class="modal fade" id="deletecategoriesModal" tabindex="-1" aria-labelledby="deletecategoriesModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deletecategoriesModalLabel">Delete Categories</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-4">
                            <h4 class="text-danger">Delete Confirmation</h4>
                            <p class="lead">Are you sure you want to delete the category "<strong id="categoriesName"></strong>"?</p>
                            <p>Please type the category title "<strong id="categoriesNameConfirmation"></strong>" to confirm:</p>
                        </div>
                        <div class="mb-4">
                            <input type="text" id="titleConfirmationInput" class="form-control form-control-lg" placeholder="Type the category title to confirm" />
                        </div>
                        <form id="deletecategoriesForm">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" id="deletecategoriesId">
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
    document.addEventListener('DOMContentLoaded', function () {
        const categoriesTable = document.getElementById('categories-table').getElementsByTagName('tbody')[0];
        let categoriesData = [];

        // Enhanced error logging function
        function logError(error, context = '') {
            console.error(`Error ${context}:`, {
                message: error.message || 'No error message',
                status: error.status || 'No status',
                responseText: error.responseText || 'No response text',
                stack: error.stack || 'No stack trace'
            });
            
            // Return a user-friendly error message
            if (error.responseJSON && error.responseJSON.message) {
                return error.responseJSON.message;
            } else if (error.responseText) {
                try {
                    const parsed = JSON.parse(error.responseText);
                    return parsed.message || parsed.error || error.responseText;
                } catch (e) {
                    return error.responseText;
                }
            }
            return error.message || 'An unknown error occurred';
        }

        // Fetch categories on page load
        function fetchCategories() {
            $.ajax({
                url: "{{ route('categories.index') }}",
                type: 'GET',
                success: function(data) {
                    categoriesData = data.categories;
                    console.log(data.count);
                    document.getElementById('display_order').value = data.count + 1;
                    document.getElementById('display_order').setAttribute('max', data.count + 1);
                    document.getElementById('editDisplayOrder').setAttribute('max', data.count);
                    renderCategoriesTable();
                },
                error: function(error) {
                    const errorMessage = logError(error, 'fetching categories');
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error fetching categories: ' + errorMessage,
                    });
                }
            });
        }

        // Render categories in table
        const routeViewsubcategoryPage = @json(route('subcategories.view', ['category_slug' => '__slug__']));
        function renderCategoriesTable() {
            categoriesTable.innerHTML = '';
            categoriesData.forEach(category => {
                const row = categoriesTable.insertRow();
                row.innerHTML = `
                    <td>${category.title}</td>
                    <td><img src="{{asset('/${category.image}')}}" class="img-thumbnail" width="80"></td>
                    <td>${category.display_order}</td>
                    <td>${category.status}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="editCategory(${category.id})" data-bs-toggle="modal" data-bs-target="#editcategoriesModal">
                            <i class="fa fa-pencil-alt"></i> 
                        </button>
                        <button class="btn btn-danger btn-sm" onclick="deleteCategory(${category.id}, '${category.title}')" data-bs-toggle="modal" data-bs-target="#deletecategoriesModal">
                            <i class="fa fa-trash"></i> 
                        </button>
                        <a href="${routeViewsubcategoryPage.replace('__slug__', category.category_slug)}" class="btn btn-info btn-sm">
                            Manage Sub Category
                        </a>
                    </td>
                `;
            });
        }

        // Add category
        $('#addcategoriesForm').on('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            $.ajax({
                url: "{{ route('categories.store') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                success: function (data) {
                    if (data.success) {
                        categoriesData.push(data.category);
                        renderCategoriesTable();
                        $('#addcategoriesForm')[0].reset();
                        $('#addcategoriesModal').modal('hide');
                        fetchCategories();
                        Swal.fire({
                            icon: 'success',
                            title: 'Category Added',
                            text: 'The category has been added successfully.',
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error:  Upload the Image in PNG or JPG format. ' ,
                        });
                    }
                },
                error: function (xhr, status, error) {
                    const errorMessage = logError(xhr, 'adding category');
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error: ' + errorMessage,
                    });
                }
            });
        });

        // Edit category
        window.editCategory = function (id) {
            const category = categoriesData.find(p => p.id === id);
            $('#editcategoriesForm')[0].reset();
            $('#editcategoriesId').val(category.id);
            // Show existing image in preview (if present)
            if (category.image) {
                let imageUrl = `{{ asset('') }}${category.image}`;
                $('#editImagePreview').html(`<img src="${imageUrl}" alt="Category Image" class="img-thumbnail" style="max-width:120px;">`);
            } else {
                $('#editImagePreview').html('');
            }
            $('#editTitle').val(category.title);
            $('#editDescription').val(category.description);
            $('#editDisplayOrder').val(category.display_order);
            $('#editStatus').val(category.status);
        };

        // Update category
        $('#editcategoriesForm').on('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            const categoryId = $('#editcategoriesId').val();

            $.ajax({
                url: `{{ route('categories.update', ':category') }}`.replace(':category', categoryId),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    '_method': 'PATCH', 
                },
                success: function (data) {
                    if (data.success) {
                        categoriesData = categoriesData.map(category => category.id === data.category.id ? data.category : category);
                        renderCategoriesTable();
                        $('#editcategoriesModal').modal('hide');
                        fetchCategories();
                        Swal.fire({
                            icon: 'success',
                            title: 'Category Updated',
                            text: 'The category has been updated successfully.',
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error: ' + (data.message || 'Unknown error'),
                        });
                    }
                },
                error: function (xhr, status, error) {
                    const errorMessage = logError(xhr, 'updating category');
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error: ' + errorMessage,
                    });
                }
            });
        });

        // Delete category
        $('#deletecategoriesForm').on('submit', function (e) {
            e.preventDefault();
            const categoryId = $('#deletecategoriesId').val();

            $.ajax({
                url: `{{ route('categories.destroy', ':category') }}`.replace(':category', categoryId),
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    '_method': 'DELETE',
                },
                success: function (data) {
                    if (data.success) {
                        categoriesData = categoriesData.filter(category => category.id !== categoryId);
                        renderCategoriesTable();
                        $('#deletecategoriesModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Category Deleted',
                            text: 'The category has been deleted successfully.',
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error: ' + (data.message || 'Unknown error'),
                        });
                    }
                    fetchCategories();
                },
                error: function (xhr, status, error) {
                    const errorMessage = logError(xhr, 'deleting category');
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error: ' + errorMessage,
                    });
                }
            });
        });

        fetchCategories();
    });
    
    function deleteCategory(categoryId, categoryTitle) {
        console.log('Deleting category:', {id: categoryId, title: categoryTitle});
        document.getElementById('categoriesName').textContent = categoryTitle;
        document.getElementById('categoriesNameConfirmation').textContent = categoryTitle;
        document.getElementById('deletecategoriesId').value = categoryId;

        const titleConfirmationInput = document.getElementById('titleConfirmationInput');
        const deleteButton = document.getElementById('deleteButton');

        titleConfirmationInput.addEventListener('input', function () {
            deleteButton.disabled = (titleConfirmationInput.value.trim() !== categoryTitle);
        });
    }
</script>
@endsection
