@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">

            <!-- Order Confirmation -->
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0"><i class="fas fa-check-circle me-2"></i> Order Confirmation</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="alert alert-info">
                        <h5 class="alert-heading">Thank you for your order!</h5>
                        <p>Your order #{{ $order->order_id }} has been placed successfully.</p>
                    </div>

                    {{-- You can include order summary details here --}}
                </div>
            </div>

            <!-- All Orders List -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-list-alt me-2"></i> Your Orders</h4>
                </div>
                <div class="card-body">
                    @if($allOrders->isEmpty())
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i> No orders found.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Items</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($allOrders as $userOrder)
                                        <tr class="{{ $userOrder->order_id == $order->order_id ? 'table-success' : '' }}" data-order-id="{{ $userOrder->order_id }}">
                                            <td>#{{ $userOrder->order_id }}</td>
                                            <td>{{ $userOrder->created_at->format('M d, Y') }}</td>
                                            <td>
                                                @if($userOrder->product)
                                                    {{ $userOrder->product->product_name }} (x{{ $userOrder->quantity }})
                                                @else
                                                    Product not available
                                                @endif
                                            </td>
                                            <td>₹{{ number_format($userOrder->total_amount, 2) }}</td>
                                            <td class="order-status">
                                                <span class="badge 
                                                    @if($userOrder->order_status === 'processing') bg-info
                                                    @elseif($userOrder->order_status === 'shipped') bg-primary
                                                    @elseif($userOrder->order_status === 'delivered') bg-success
                                                    @elseif($userOrder->order_status === 'cancelled') bg-secondary
                                                    @elseif($userOrder->order_status === 'returned') bg-warning
                                                    @endif text-capitalize">
                                                    {{ str_replace('_', ' ', $userOrder->order_status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('orders.success', $userOrder->order_id) }}"
                                                   class="btn btn-sm btn-outline-primary" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>

                                                @if(in_array($userOrder->order_status, ['processing', 'pending']))
                                                    <button class="btn btn-sm btn-outline-danger cancel-order-btn"
                                                            data-order-id="{{ $userOrder->order_id }}" title="Cancel Order">
                                                        <i class="fas fa-times"></i> Cancel
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Toast Container -->
<div id="toastContainer" class="position-fixed bottom-0 end-0 p-3" style="z-index: 1055;"></div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.cancel-order-btn').forEach(button => {
        button.addEventListener('click', async function (e) {
            e.preventDefault();
            const orderId = this.dataset.orderId;

            if (!confirm('Are you sure you want to cancel this order?')) {
                return;
            }

            const originalHtml = this.innerHTML;
            this.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Cancelling...';
            this.disabled = true;

            try {
                const response = await fetch(`/orders/${orderId}/cancel`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({})
                });

                const data = await response.json();

                if (!response.ok || !data.success) {
                    throw new Error(data.error || 'Failed to cancel order.');
                }

                // Update status badge
                const row = document.querySelector(`tr[data-order-id="${orderId}"]`);
                const statusCell = row.querySelector('.order-status');
                statusCell.innerHTML = `<span class="badge bg-secondary text-capitalize">cancelled</span>`;

                // Remove cancel button
                this.remove();

                showToast('success', data.message);
            } catch (error) {
                console.error(error);
                showToast('danger', error.message);
            } finally {
                this.innerHTML = originalHtml;
                this.disabled = false;
            }
        });
    });

    function showToast(type, message) {
        const toastContainer = document.getElementById('toastContainer');
        const toastId = 'toast-' + Date.now();
        const toast = document.createElement('div');
        toast.className = `toast align-items-center text-white bg-${type} border-0 show`;
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">${message}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        `;
        toastContainer.appendChild(toast);

        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();

        toast.addEventListener('hidden.bs.toast', () => toast.remove());
    }
});
</script>
@endpush
