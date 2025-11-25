@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-list-alt me-2"></i> My Orders</h4>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($orders->isEmpty())
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i> You haven't placed any orders yet.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Items</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Payment</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>#{{ $order->order_id }}</td>
                                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                                            <td>
                                                @if($order->product)
                                                    {{ $order->product->product_name }} (x{{ $order->quantity }})
                                                @else
                                                    Product not available
                                                @endif
                                            </td>
                                            <td>₹{{ number_format($order->total_amount, 2) }}</td>
                                            <td>
                                                <span class="badge 
                                                    @if($order->order_status === 'processing') bg-info
                                                    @elseif($order->order_status === 'shipped') bg-primary
                                                    @elseif($order->order_status === 'delivered') bg-success
                                                    @elseif($order->order_status === 'cancelled') bg-secondary
                                                    @elseif($order->order_status === 'returned') bg-warning
                                                    @endif text-capitalize">
                                                    {{ str_replace('_', ' ', $order->order_status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge 
                                                    @if($order->payment_status === 'completed') bg-success
                                                    @elseif($order->payment_status === 'pending') bg-warning
                                                    @else bg-danger
                                                    @endif text-capitalize">
                                                    {{ $order->payment_status }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('orders.show', $order->order_id) }}" class="btn btn-sm btn-outline-primary" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('orders.invoice', $order->order_id) }}" class="btn btn-sm btn-outline-secondary" title="View Invoice">
                                                    <i class="fas fa-file-invoice"></i>
                                                </a>
                                                @if($order->order_status === 'processing')
                                                    <form action="{{ route('orders.cancel', $order->order_id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Cancel Order" onclick="return confirm('Are you sure you want to cancel this order?')">
                                                            <i class="fas fa-times-circle"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            {{ $orders->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection