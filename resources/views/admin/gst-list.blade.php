@extends('layouts.app') {{-- or your layout file --}}

@section('content')
<div class="container">
    <h2>GST List</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Status</th>
                <th>Percentage</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($gstData as $gst)
                <tr>
                    <td>{{ $gst->id }}</td>
                    <td>{{ $gst->gst_status ? 'Enabled' : 'Disabled' }}</td>
                    <td>{{ $gst->gst_percentage }}%</td>
                    <td>{{ $gst->category_name }}</td>
                    <td>
                        <a href="{{ route('gst.view', $gst->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('gst.edit', $gst->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('gst.delete', $gst->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this GST row?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
