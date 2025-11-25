@extends('layouts.commonMaster')

@section('layoutContent')
<style>
    /* Ensure SweetAlert appears above the modal */
.swal2-container {
    z-index: 99999 !important;
}
</style>
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between">
            <h4 class="text-muted fw-light">Shipping Cost</h4>
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addEditModal">Add State</button>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Shipping Cost Details</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>State Name</th>
                            <th>Base Weight (g)</th>
                            <th>Base Cost ($)</th>
                            <th>Additional Weight Unit (g)</th>
                            <th>Additional Cost Per Unit ($)</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i=1;
                        @endphp
                        @foreach($states as $state)
                        <tr id="row-{{$state->id}}">
                            <td>{{ $i++ }}</td>
                            <td>{{ $state->name }}</td>
                            <td>{{ $state->base_weight }}</td>
                            <td>{{ $state->base_cost }}</td>
                            <td>{{ $state->additional_weight_unit }}</td>
                            <td>{{ $state->additional_cost_per_unit }}</td>
                            <td>
                                <button class="btn btn-info editBtn mb-3" 
                                    data-id="{{ $state->id }}"
                                    data-name="{{ $state->name }}" 
                                    data-base_weight="{{ $state->base_weight }}" 
                                    data-base_cost="{{ $state->base_cost }}" 
                                    data-additional_weight_unit="{{ $state->additional_weight_unit }}" 
                                    data-additional_cost_per_unit="{{ $state->additional_cost_per_unit }}"
                                    >Edit</button>
                                <button class="btn btn-danger deleteBtn" data-id="{{ $state->id }}">Delete</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- Add/Edit Modal -->
<div class="modal fade" id="addEditModal" tabindex="-1" aria-labelledby="addEditModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add State</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="stateForm">
                    @csrf
                    <input type="hidden" id="state_id">
                    
                    <!-- State Name -->
                    <div class="mb-3">
                        <label for="state_name" class="form-label">State Name</label>
                        <input type="text" id="state_name" class="form-control" required>
                    </div>

                    <!-- Base Weight -->
                    <div class="mb-3">
                        <label for="base_weight" class="form-label">Base Weight (grams)</label>
                        <input type="number" id="base_weight" class="form-control" required>
                    </div>

                    <!-- Base Shipping Cost -->
                    <div class="mb-3">
                        <label for="base_cost" class="form-label">Base Shipping Cost (for base weight)</label>
                        <input type="number" id="base_cost" class="form-control" required>
                    </div>

                    <!-- Additional Weight Unit -->
                    <div class="mb-3">
                        <label for="additional_weight_unit" class="form-label">Additional Weight Unit (grams)</label>
                        <input type="number" id="additional_weight_unit" class="form-control" required>
                    </div>

                    <!-- Additional Cost Per Unit -->
                    <div class="mb-3">
                        <label for="additional_cost_per_unit" class="form-label">Additional Cost Per Unit</label>
                        <input type="number" id="additional_cost_per_unit" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-success">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    console.log("DOM ready.");

    // Open Edit Modal
    $(".editBtn").click(function() {
        let id = $(this).data('id');
        console.log("Edit button clicked for ID:", id);

        // Fetch the state data from the server
        let url = "{{ route('edit-state', ':id') }}".replace(':id', id);
        console.log("Edit URL:", url);

        $.ajax({
            url: url,
            type: "GET",
            success: function(response) {
                console.log("Edit AJAX Success:", response);

                // Populate the form fields with the response data
                $("#modalTitle").text("Edit State");
                $("#state_id").val(response.id);
                $("#state_name").val(response.name);
                $("#base_weight").val(response.base_weight);
                $("#base_cost").val(response.base_cost);
                $("#additional_weight_unit").val(response.additional_weight_unit);
                $("#additional_cost_per_unit").val(response.additional_cost_per_unit);

                console.log("Form fields populated");

                // Show the modal
                $("#addEditModal").modal('show');
                console.log("Modal shown");
            },
            error: function(xhr) {
                console.error("Edit AJAX Error:", xhr);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to fetch state data. Please try again.',
                });
            }
        });
    });

    // Save or Update State
    $("#stateForm").submit(function(e) {
        e.preventDefault();
        console.log("Form submit intercepted");

        let state_id = $("#state_id").val();
        let name = $("#state_name").val();
        let baseWeight = $("#base_weight").val();
        let baseCost = $("#base_cost").val();
        let additionalWeightUnit = $("#additional_weight_unit").val();
        let additionalCostPerUnit = $("#additional_cost_per_unit").val();

        console.log("Form values:", {
            state_id,
            name,
            baseWeight,
            baseCost,
            additionalWeightUnit,
            additionalCostPerUnit
        });

        $.ajax({
            url: "{{ route('save-shipping-cost') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                state_id: state_id,
                name: name,
                base_weight: baseWeight,
                base_cost: baseCost,
                additional_weight_unit: additionalWeightUnit,
                additional_cost_per_unit: additionalCostPerUnit
            },
            success: function(response) {
                console.log("Save AJAX Success:", response);
                $("#addEditModal").modal('hide');
                console.log("Modal hidden");

                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'State details updated successfully!',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    console.log("Reloading page after save");
                    location.reload();
                });
            },
            error: function(xhr) {
                console.error("Save AJAX Error:", xhr);
                $("#addEditModal").modal('hide');
                console.log("Modal hidden due to error");

                let errorMessage = 'Something went wrong. Please try again.';
                if (xhr.status === 422) {
                    errorMessage = xhr.responseJSON.error || 'State already exists!';
                    console.log("422 error message:", errorMessage);
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorMessage,
                    backdrop: true
                }).then(() => {
                    console.log("Reloading page after error");
                    location.reload();
                });
            }
        });
    });

    // Delete State
    $(".deleteBtn").click(function() {
        let id = $(this).data('id');
        console.log("Delete button clicked for ID:", id);

        Swal.fire({
            title: "Are you sure?",
            text: "This action cannot be undone!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                let url = "{{ route('delete-state', ':id') }}".replace(':id', id);
                console.log("Delete URL:", url);

                $.ajax({
                    url: url,
                    type: "DELETE",
                    data: { _token: "{{ csrf_token() }}" },
                    success: function(response) {
                        console.log("Delete AJAX Success:", response);
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: 'State has been removed.',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            console.log("Removing row from DOM");
                            $("#row-" + id).remove();
                        });
                    },
                    error: function(xhr) {
                        console.error("Delete AJAX Error:", xhr);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to delete the state. Try again.',
                        });
                    }
                });
            } else {
                console.log("Delete cancelled by user");
            }
        });
    });
});
</script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
@endsection
