@extends('layouts.commonMaster')

@section('layoutContent')
<div class="container">
    <h2>GST Details</h2>
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <td>{{ $gst->id }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>{{ $gst->gst_status ? 'Enabled' : 'Disabled' }}</td>
        </tr>
        <tr>
            <th>Percentage</th>
            <td>{{ $gst->gst_percentage }}%</td>
        </tr>
        <tr>
            <th>Category</th>
            <td>{{ $gst->category_name }}</td>
        </tr>
    </table>
    <a href="{{ route('gst') }}" class="btn btn-primary">Back to GST List</a>
</div>
@endsection
