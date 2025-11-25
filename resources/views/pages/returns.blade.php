@extends('layouts.home')

@section('content')
<div class="container py-5">
    <h1>{{ $returns->title ?? 'Refund & Cancellation Policy' }}</h1>
    <div>{!! $returns->content ?? 'No refund and cancellation policy content found.' !!}</div>
</div>
@endsection
