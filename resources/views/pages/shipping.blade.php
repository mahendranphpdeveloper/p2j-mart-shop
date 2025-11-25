@extends('layouts.home')

@section('content')
<div class="container py-5">
    <h1>{{ $delivery->title ?? 'Shipping & Delivery Policy' }}</h1>
    <div>{!! $delivery->content ?? 'No delivery policy available.' !!}</div>
</div>
@endsection
