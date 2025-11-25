@extends('layouts.commonMaster')

@section('layoutContent')
<div class="container">
    <h2>Edit GST</h2>

    <form action="{{ route('gst.update', $gst->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="gst_status">Status</label>
            <select name="gst_status" id="gst_status" class="form-control">
                <option value="1" {{ $gst->gst_status ? 'selected' : '' }}>Enabled</option>
                <option value="0" {{ !$gst->gst_status ? 'selected' : '' }}>Disabled</option>
            </select>
        </div>

        <div class="form-group">
            <label for="gst_percentage">Percentage</label>
            <input type="number" name="gst_percentage" id="gst_percentage" class="form-control" value="{{ $gst->gst_percentage }}" required>
        </div>

        <div class="form-group">
            <label for="category_name">Category Name</label>
            <input type="text" name="category_name" id="category_name" class="form-control" value="{{ $gst->category_name }}" required>
        </div>

        <button type="submit" class="btn btn-success">Save Changes</button>
    </form>

    <a href="{{ route('gst') }}" class="btn btn-secondary">Back to GST List</a>
</div>
@endsection
