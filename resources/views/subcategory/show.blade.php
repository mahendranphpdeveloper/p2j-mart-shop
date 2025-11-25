@extends('layouts.app') <!-- Or your master layout -->

@section('content')
<div class="container my-5">
    @if($subcategory)
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h2>{{ $subcategory->title }}</h2>
                <img src="{{ asset($subcategory->image) }}" alt="{{ $subcategory->title }}" class="img-fluid my-3" style="max-height: 400px;">
                <p class="lead">{{ $subcategory->description ?? 'No description available.' }}</p>
            </div>
        </div>
    @else
        <div class="alert alert-danger text-center">
            Subcategory not found.
        </div>
    @endif
</div>
@endsection
