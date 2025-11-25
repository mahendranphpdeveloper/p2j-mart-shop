@extends('layouts.home')

@section('content')
<div class="container py-5">
    <h1>{{ $terms->title ?? 'Terms and Conditions' }}</h1>
    <div>{!! $terms->content ?? 'No content available.' !!}</div>
</div>
@endsection

