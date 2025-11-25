@extends('layouts.app')

@section('content')

<style>
    /* Main Container */
.order-confirmation-container {
    background-color: #f8f9fa;
    min-height: 100vh;
}

/* Toast Notification */
.toast-notification-container {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 9999;
}

/* Confirmation Header Card */
.confirmation-header-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.05);
    border: none;
}

.confirmation-header {
    background: linear-gradient(135deg, #28a745, #5cb85c);
    color: white;
    padding: 1.5rem;
}

.confirmation-title {
    margin: 0;
    font-weight: 600;
    font-size: 2rem;
}

.confirmation-body {
    padding: 2rem;
    text-align: center;
    position: relative;
}

.confirmation-message {
    margin-bottom: 2rem;
    text-align: left;
}

.order-id-highlight {
    color: #28a745;
    font-weight: 700;
}

.confirmation-illustration {
    display: flex;
    justify-content: space-around;
    color: #e9ecef;
    font-size: 3rem;
    margin-top: 1.5rem;
}

/* Order Cards */
.order-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: none;
}

.order-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
}

.order-card-inner {
    display: flex;
    flex-direction: row;
}

.order-product-image {
    width: 30%;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
}

.order-image {
    max-height: 200px;
    width: auto;
    object-fit: contain;
    border-radius: 8px;
}

.order-details {
    width: 70%;
    padding: 1.5rem;
}

.order-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
}

.product-title {
    font-weight: 600;
    font-size: 1.25rem;
    margin: 0;
    color: #343a40;
}

.order-status-badge {
    padding: 0.35rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: capitalize;
}

.status-processing, .status-pending {
    background-color: #17a2b8;
    color: white;
}

.status-shipped {
    background-color: #007bff;
    color: white;
}

.status-delivered {
    background-color: #28a745;
    color: white;
}

.status-cancelled {
    background-color: #6c757d;
    color: white;
}

.status-returned {
    background-color: #ffc107;
    color: #212529;
}

.order-meta {
    color: #6c757d;
}

.order-info {
    margin-bottom: 1rem;
}

.info-label {
    font-weight: 600;
    color: #495057;
    display: inline-block;
}

.info-value {
    color: #6c757d;
}

.price {
    color: #5cb85c;
    font-weight: 600;
}

.tracking-info {
    background: #f1f8ff;
    padding: 0.75rem;
    border-radius: 8px;
    margin: 1rem 0;
}

.tracking-id {
    font-family: monospace;
    color: #0056b3;
}

.tracking-link {
    display: inline-flex;
    align-items: center;
    color: #0056b3;
    text-decoration: none;
    font-weight: 500;
}

.tracking-link:hover {
    text-decoration: underline;
}

.tracking-link i {
    margin-right: 0.5rem;
}

.order-actions {
    display: flex;
    gap: 1rem;
    margin-top: 1.5rem;
}

.action-btn {
    padding: 0.5rem 1rem;
    border-radius: 6px;
    font-size: 0.9rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    transition: all 0.2s ease;
    text-decoration: none;
}

.action-btn i {
    margin-right: 0.5rem;
}

.invoice-btn {
    background-color: #f8f9fa;
    color: #495057;
    border: 1px solid #dee2e6;
}

.invoice-btn:hover {
    background-color: #e9ecef;
    color: #212529;
}

.cancel-btn {
    background-color: #fff8f8;
    color: #dc3545;
    border: 1px solid #f5c6cb;
}

.cancel-btn:hover {
    background-color: #f8d7da;
    color: #721c24;
}

.order-info {
    margin: 0;
    padding: 0;
}

.order-info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 0.75rem;
}



/* Responsive Design */
@media (max-width: 768px) {
    .order-card-inner {
        flex-direction: column;
    }
    
    .order-product-image, .order-details {
        width: 100%;
    }
    
    .order-product-image {
        height: 200px;
    }

}
</style>

<div class="order-confirmation-container py-5">
    
      <!-- Add this modal at the top of your container -->
  <div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelOrderModalLabel">Confirm Order Cancellation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to cancel this order? This action cannot be undone.</p>
                <div class="mb-3">
                    <label for="cancelReason" class="form-label">Reason for cancellation (optional):</label>
                    <textarea class="form-control" id="cancelReason" rows="3" placeholder="Please provide a reason for cancellation"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No, Keep Order</button>
                <button type="button" class="btn btn-danger" id="confirmCancelBtn">Yes, Cancel Order</button>
            </div>
        </div>
    </div>
</div>


    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Toast Container -->
            <div id="toastContainer" class="toast-notification-container"></div>

            @if(session('success'))
                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        showToast('success', '{{ session("success") }}');
                    });
                </script>
            @endif

            <!-- Confirmation Header -->
          <div class="confirmation-header-card mb-4">
                <div class="confirmation-header">
                    <h4 class="confirmation-title text-white">
                      <i class="fas fa-check-circle me-2"></i> Order Confirmation
                    </h4>
                </div>
                <div class="row align-items-center">
                  <div class="col-md-8 confirmation-body">
                    <p class="confirmation-message">
                        Thank you for your purchase! Your order 
                        <strong class="order-id-highlight">#{{ $order->order_id }}</strong> 
                        has been placed successfully. We've sent a confirmation email with the details of your order. You will receive another update once your order has shipped.
                    </p>
                </div>
                
                <!-- Continue Shopping Button -->
                <div class="col-md-4 text-center mb-4">
                    <a href="{{ route('home') }}" class="btn btn-outline-success px-3 py-2 continue-shopping-btn">
                         <i class="fa-solid fa-bag-shopping me-2 "></i> Continue Shopping
                    </a>
                 </div>
               </div>
            </div>


            <!-- Orders List -->
            @foreach($allOrders->sortByDesc('created_at') as $userOrder)
            <div class="order-card mb-4" id="order-{{ $userOrder->order_id }}">
                <div class="order-card-inner">
                    <div class="order-product-image">
                        <img src="{{ asset('uploads/products/'.$userOrder->product->productImage->web_image_1) }}" alt="Product Image" class="img-fluid rounded-start">
                    </div>
                    <div class="order-details">
                        <div class="order-header">
                            <h5 class="product-title">{{ $userOrder->product->product_name ?? 'Product Unavailable' }}</h5>
                            <span class="order-status-badge status-{{ str_replace(' ', '-', $userOrder->order_status) }}">
                                {{ str_replace('_', ' ', $userOrder->order_status) }}
                            </span>
                        </div>
                        <div class="order-meta">
                           <p class="order-info">
                                <div class="order-info-grid">
                                    <div class="order-info-item">
                                        <span class="info-label">Order ID:</span>
                                        <span class="info-value">#{{ $userOrder->order_id }}</span>
                                    </div>
                                    <div class="order-info-item">
                                        <span class="info-label">Date:</span>
                                        <span class="info-value">{{ $userOrder->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <div class="order-info-item">
                                        <span class="info-label">Quantity:</span>
                                        <span class="info-value">{{ $userOrder->quantity }}</span>
                                    </div>
                                    <div class="order-info-item">
                                        <span class="info-label">Total:</span>
                                        <span class="info-value price">₹{{ number_format($userOrder->total_amount, 2) }}</span>
                                    </div>
                                </div>
                            </p>

                            @if($userOrder->tracking_id || $userOrder->tracking_link)
                                <div class="tracking-info">
                                    @if($userOrder->tracking_id)
                                        <p><span class="info-label">Tracking ID:</span> <span class="tracking-id">{{ $userOrder->tracking_id }}</span></p>
                                    @endif
                                    @if($userOrder->tracking_link)
                                        <a href="{{ $userOrder->tracking_link }}" target="_blank" class="tracking-link">
                                            <i class="fas fa-map-marked-alt"></i> Track Your Package
                                        </a>
                                    @endif
                                </div>
                            @endif

                            <div class="order-actions">
                                <a href="{{ route('orders.invoice', $userOrder->order_id) }}" class="action-btn invoice-btn">
                                    <i class="fas fa-file-invoice"></i> Download Invoice
                                </a>

                                @if(in_array($userOrder->order_status, ['processing', 'pending']))
                                    <button class="action-btn cancel-btn cancel-order-btn" data-order-id="{{ $userOrder->order_id }}">
                                        <i class="fas fa-times"></i> Cancel Order
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const cancelOrderModal = new bootstrap.Modal(document.getElementById('cancelOrderModal'));
    let currentOrderId = null;

    document.querySelectorAll('.cancel-order-btn').forEach(button => {
        button.addEventListener('click', function () {
            currentOrderId = this.dataset.orderId;
            cancelOrderModal.show();
        });
    });

 document.getElementById('confirmCancelBtn').addEventListener('click', async function () {
    if (!currentOrderId) return;
    
    const cancelReason = document.getElementById('cancelReason').value;
    cancelOrderModal.hide();
    
    try {
        // Create FormData instead of JSON
        const formData = new FormData();
        formData.append('cancel_reason', cancelReason);
        
        const response = await fetch(`/p2j-mart-22/orders/${currentOrderId}/cancel`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: formData // Send FormData instead of JSON
        });

        const data = await response.json();

        if (response.ok && data.success) {
            showToast('success', 'Order cancelled successfully.');
            const orderElement = document.getElementById(`order-${currentOrderId}`);
            if (orderElement) {
                const statusBadge = orderElement.querySelector('.order-status-badge');
                if (statusBadge) {
                    statusBadge.textContent = 'cancelled';
                    statusBadge.className = 'order-status-badge status-cancelled';
                }
                const cancelBtn = orderElement.querySelector('.cancel-order-btn');
                if (cancelBtn) cancelBtn.remove();
            }
        } else {
            showToast('danger', data.error || 'Failed to cancel order.');
        }
    } catch (error) {
        console.error('Cancellation error:', error);
        showToast('danger', 'Something went wrong while cancelling the order.');
    }
    
    // Reset the modal for next use
    document.getElementById('cancelReason').value = '';
});

    function showToast(type, message) {
        const toastContainer = document.getElementById('toastContainer');
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
        toastContainer?.appendChild(toast);
        setTimeout(() => toast.remove(), 5000);
    }
});
</script>



@endsection

