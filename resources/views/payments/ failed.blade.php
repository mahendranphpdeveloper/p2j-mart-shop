@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h4 class="mb-0">Payment Failed</h4>
                </div>
                <div class="card-body text-center">
                    <div class="mb-4">
                        <i class="fas fa-times-circle fa-5x text-danger"></i>
                    </div>
                    <h3>Payment Unsuccessful</h3>
                    <p class="lead">We couldn't process your payment.</p>
                    <p>Order ID: <strong>{{ $order }}</strong></p>
                    
                    <div class="alert alert-warning">
                        @if(session('error'))
                            {{ session('error') }}
                        @else
                            Please try again or contact support if the problem persists.
                        @endif
                    </div>
                    
                    <div class="mt-4">
                        <a href="{{ route('checkout') }}" class="btn btn-primary me-2">
                            Try Again
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection