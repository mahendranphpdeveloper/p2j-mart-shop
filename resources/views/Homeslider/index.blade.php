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

    <h2 class="mb-4">Home Sliders</h2>

    <!-- Add New Slider Form -->
    <div class="card mb-4">
        <div class="card-header">Add New Slider</div>
        <div class="card-body">
            <form action="{{ route('homeslider.store') }}" method="POST" enctype="multipart/form-data" id="addSliderForm">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" id="title" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <textarea name="content" id="content" class="form-control" rows="4" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" name="image" id="image" class="form-control" accept="image/*" required>
                </div>

                <div class="mb-3">
                    <label for="sort_order" class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" id="sort_order" class="form-control" min="0" value="{{ ($sliders->max('sort_order') ?? 0) + 1 }}">
                </div>

                <button type="submit" class="btn btn-success">Add Slider</button>
            </form>
        </div>
    </div>

    <!-- Sliders List -->
    <div class="card">
        <div class="card-header">Slider List</div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sl.NO</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Sort Order</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sliders as $key => $slider)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{!! $slider->title !!}</td>
                        <td>{!! $slider->content !!}</td>
                        <td><img src="{{ asset('uploads/sliders/' . $slider->image) }}" alt="Slider Image" width="100"></td>
                        <td>{{ $slider->sort_order ?? 0 }}</td>
                        <td>
                            <button class="btn btn-info btn-sm editBtn"
                                data-id="{{ $slider->id }}"
                                data-title="{{ $slider->title }}"
                                data-content="{{ $slider->content }}"
                                data-image="{{ asset('uploads/sliders/' . $slider->image) }}"
                                data-sort_order="{{ $slider->sort_order ?? 0 }}">
                                <i class="fas fa-edit"></i>
                            </button>

                            <form action="{{ route('homeslider.delete', $slider->id) }}" method="POST" class="delete-form d-inline">
                                @csrf
                                <button type="button" class="btn btn-danger btn-sm delete-btn">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Edit Slider Modal -->
    <div class="modal fade" id="editSliderModal" tabindex="-1" aria-labelledby="editSliderModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSliderModalLabel">Edit Slider</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('homeslider.update') }}" method="POST" enctype="multipart/form-data" id="editSliderForm">
                        @csrf
                        <input type="hidden" name="id" id="edit_slider_id">

                        <div class="mb-3">
                            <label for="edit_title" class="form-label">Title</label>
                            <input type="text" name="title" id="edit_title" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="edit_content" class="form-label">Content</label>
                            <textarea name="content" id="edit_content" class="form-control" rows="4" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="edit_image" class="form-label">Current Image</label><br>
                            <img id="edit_preview" src="" alt="Slider Image" width="100"><br><br>
                            <input type="file" name="image" id="edit_image" class="form-control" accept="image/*">
                        </div>

                        <div class="mb-3">
                            <label for="edit_sort_order" class="form-label">Sort Order</label>
                            <input type="number" name="sort_order" id="edit_sort_order" class="form-control" min="0" value="0">
                        </div>

                        <button type="submit" class="btn btn-primary">Update Slider</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".delete-btn").forEach(button => {
            button.addEventListener("click", function () {
                let form = this.closest("form");
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        $('.editBtn').click(function () {
            let id = $(this).data('id');
            let title = $(this).data('title');
            let content = $(this).data('content');
            let image = $(this).data('image');
            let sortOrder = $(this).data('sort_order') ?? 0;

            $('#edit_slider_id').val(id);
            $('#edit_title').val(title);
            $('#edit_content').val(content);
            $('#edit_preview').attr('src', image);
            $('#edit_sort_order').val(sortOrder);

            $('#editSliderModal').modal('show');
        });
    });
</script>

@endsection
