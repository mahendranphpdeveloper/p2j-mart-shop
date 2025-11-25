@extends('layouts.home')

@section('content')
<div class="container py-5">
    <h1>{{ $privacy->title ?? 'Privacy Policy' }}</h1>
    <div>{!! $privacy->content ?? 'No privacy policy available.' !!}</div>
</div>
@endsection
