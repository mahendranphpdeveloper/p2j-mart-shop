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
    <div class="content-wrapper">

        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
    
            <h4>
                <span class="text-muted fw-light">GST </span>
            </h4>
            @if($errors->any())
            <div>
                <ul>
                    <div class="alert alert-danger" style="padding-left:30px;">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </div>
                </ul>
            </div>
            @endif
          
            <div class="app-ecommerce">
                <form action="{{route('orders.store')}}" id="headerFooter" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
    
                        <div class="d-flex flex-column justify-content-center">
                            <!-- <h4 class="mb-1 mt-3">Change Header details</h4> -->
                        </div>
    
                        <div class="d-flex align-content-center flex-wrap gap-3">
                            <!-- <a href="{{route('admin-dashboard')}}" class="discard btn btn-label-secondary">Cancel</a> -->
    
                              <button type="submit" class="btn btn-primary">Save Changes</button>
                  
                        </div>
    
                    </div>
    
                    <div class="row">
    
                        <!-- First column-->
                        <div class="col-lg-1"></div>
                        <div class="col-12 col-lg-8">
    
                        <form method="POST" action="{{ route('gst.store') }}">
    @csrf

    <div id="gst-rows-container">
        <!-- GST rows will appear here -->
    </div>

    <button type="button" id="add-gst-row" class="btn btn-secondary mb-3">+ Add GST Row</button>
    <br>
    <button type="submit" class="btn btn-primary">Save All</button>
</form>

      <!-- Display existing GST rows -->
      <div class="gst-table mt-5">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>GST Status</th>
                <th>GST Percentage</th>
                <th>Category Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($gst as $row)
                <tr>
                    <td>{{ $row->id }}</td>
                    <td>{{ $row->gst_status == 1 ? 'Yes' : 'No' }}</td>
                    <td>{{ $row->gst_percentage }}%</td>
                    <td>{{ $row->category_name }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('gst.view', $row->id) }}" class="btn" style="background-color: #1d83c5; border-color: #2bb1e6; box-shadow: 0 .125rem .25rem 0 rgba(105, 108, 255, .4); color: #fcfdfd;">View</a>

                            <a href="{{ route('gst.edit', $row->id) }}" class="btn" style="background-color: #1d83c5; border-color: #2bb1e6; box-shadow: 0 .125rem .25rem 0 rgba(105, 108, 255, .4); color: #fcfdfd;">Edit</a>

                            <form action="{{ route('gst.destroy', $row->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this record?')">Delete</button>

                            </form>
                            
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>


<script>
    let gstIndex = 0;
    const categories = @json($categories);

    function generateRow(index) {
        let categoryOptions = '<option value="">Select Category</option>';
        for (const title in categories) {
            categoryOptions += `<option value="${title}">${title}</option>`;
        }

        return `
            <div class="card mb-4 gst-row">
                <div class="card-header">
                    <h5 class="card-title mb-0">GST Row #${index + 1}</h5>
                </div>
                <div class="card-body">

                    <div class="mb-3">
                        <label class="form-label me-3">Enable GST</label>
                        <input type="radio" class="me-1 gst-select" name="gst_status[${index}]" value="1" checked /> Yes
                        <input type="radio" class="ms-2 me-1 gst-select" name="gst_status[${index}]" value="0" /> No
                    </div>

                    <div class="gst-details">
                        <div class="mb-3">
                            <label class="form-label">Category Name</label>
                            <select class="form-select" name="category_name[${index}]">
                                ${categoryOptions}
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">GST in percentage (%)</label>
                            <input type="text" class="form-control" name="gst_percentage[${index}]" placeholder="Enter GST percentage">
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    document.getElementById('add-gst-row').addEventListener('click', function () {
        const container = document.getElementById('gst-rows-container');
        container.insertAdjacentHTML('beforeend', generateRow(gstIndex));
        gstIndex++;
    });

    // Add one row on page load
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('add-gst-row').click();
    });

    
</script>

    @endsection