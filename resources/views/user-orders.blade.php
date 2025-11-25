@extends('layouts.app')

@section('content')
<link rel="stylesheet" id="main_style" href="{{ asset('/home/css/style.css') }}">


<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<!-- Custom CSS -->
<style>
    :root {
        --primary-color: #2874f0;
        --secondary-color: #fb641b;
        --light: #fff;
        --dark-gray: #878787;
        --success: #388e3c;
        --danger: #ff6161;
        --warning: #ff9f00;
    }

    a {
        text-decoration: none;
    }

    body {
        background-color: var(--light-gray);
        font-family: "Times New Roman", Times, serif;
    }

    .navbar {
        background-color: var(--primary-color);
        padding: 0.8rem 1rem;
    }

    .navbar-brand {
        font-size: 1.5rem;
        font-weight: 600;
        color: white;
    }

    .search-box {
        width: 100%;
        max-width: 550px;
        position: relative;
    }

    .search-box input {
        border-radius: 2px;
        box-shadow: 0 2px 4px 0 rgba(0, 0, 0, .12);
        border: none;
        padding-left: 15px;
        height: 40px;
    }

    .search-box button {
        position: absolute;
        right: 0;
        top: 0;
        height: 40px;
        background: white;
        border: none;
        color: var(--primary-color);
    }

    .nav-link {
        color: white !important;
        font-weight: 500;
        padding: 0 1rem;
    }

    .page-title {
        font-size: 1.5rem;
        font-weight: 500;
        margin-bottom: 1.5rem;
        color: #212121;
    }

    .filter-section {
        background: white;
        border-radius: 4px;
        padding: 15px;
        margin-bottom: 20px;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, .1);
    }

    .filter-label {
        font-weight: 500;
        color: #212121;
        margin-right: 10px;
    }

    .order-card {
        background: white;
        border-radius: 4px;
        margin-bottom: 20px;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
        overflow: hidden;
    }

    .order-header {
        padding: 15px;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #fff;
    }

    .order-id {
        font-weight: 500;
        color: #212121;
    }

    .order-date {
        color: var(--dark-gray);
        font-size: 0.9rem;
    }

    .order-status {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.8rem;
        font-weight: 500;
    }
.status-completed{
     background-color: rgba(56, 142, 60, 0.1);
        color: var(--success);
}
    .status-delivered {
        background-color: rgba(56, 142, 60, 0.1);
        color: var(--success);
    }

    .status-shipped {
        background-color: rgba(255, 159, 0, 0.1);
        color: var(--warning);
    }

    .status-processing {
        background-color: rgba(33, 150, 243, 0.1);
        color: var(--primary-color);
    }

    .status-cancelled {
        background-color: rgba(255, 97, 97, 0.1);
        color: var(--danger);
    }

    .order-body {
        padding: 15px;
    }

    .product-img {
        width: 80px;
        height: 80px;
        object-fit: contain;
        border: 1px solid #f0f0f0;
        padding: 5px;
    }

    .product-name {
        font-weight: 500;
        color: #212121;
        margin-bottom: 5px;
    }

    .product-price {
        font-weight: 500;
        color: #212121;
    }

    .product-qty {
        color: var(--dark-gray);
        font-size: 0.9rem;
    }

    .order-footer {
        padding: 15px;
        border-top: 1px solid #f0f0f0;
        background-color: #fafafa;
    }

    .order-total {
        font-weight: 500;
        color: #212121;
    }

    .action-btn {
        padding: 6px 15px;
        border-radius: 2px;
        font-weight: 500;
        font-size: 0.9rem;
        text-transform: uppercase;
    }

    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .btn-secondary {
        background-color: white;
        border: 1px solid #e0e0e0;
        color: #212121;
    }

    .pagination {
        margin-top: 20px;
        justify-content: center;
    }

    .page-link {
        color: var(--primary-color);
        border: 1px solid #e0e0e0;
    }

    .page-item.active .page-link {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .empty-orders {
        text-align: center;
        padding: 50px 0;
    }

    .empty-orders i {
        font-size: 3rem;
        color: var(--dark-gray);
        margin-bottom: 15px;
    }

    .empty-orders h3 {
        font-weight: 500;
        color: #212121;
        margin-bottom: 10px;
    }

    .empty-orders p {
        color: var(--dark-gray);
        margin-bottom: 20px;
    }

    .btn-shop-now {
        background-color: var(--secondary-color);
        border-color: var(--secondary-color);
        padding: 8px 20px;
        font-weight: 500;
    }

    @media (max-width: 767px) {
        .order-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .order-status-container {
            margin-top: 10px;
        }

        .product-details {
            margin-top: 15px;
        }

        .action-buttons {
            flex-direction: column;
            align-items: flex-start;
        }

        .action-btn {
            margin-bottom: 10px;
            width: 100%;
        }
    }

    .order-summary {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
    }

    .product-image {
        width: 80px;
        height: 116px;
        object-fit: cover;
        border-radius: 4px;
    }

    .image-preview-container {
        width: 100%;
        min-height: 120px;
        border-radius: 8px;
        border: 1px dashed #ccc;
        padding: 15px;
        margin-top: 10px;
    }

    .image-preview-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 10px;
    }

    .preview-item {
        position: relative;
        width: 120px;
        height: 120px;
        border-radius: 4px;
        overflow: hidden;
        border: 1px solid #dee2e6;
    }

    .preview-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .remove-image {
        position: absolute;
        top: 5px;
        right: 5px;
        background-color: rgba(255, 255, 255, 0.8);
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: #dc3545;
        border: none;
        font-size: 14px;
    }

    .remove-image:hover {
        background-color: rgba(255, 255, 255, 1);
        color: #b02a37;
    }

    .no-images-text {
        color: #6c757d;
        text-align: center;
        width: 100%;
        padding: 20px;
    }


    .modal-header {
        border-bottom: 1px solid #dee2e6;
        background-color: #f8f9fa;
    }

    .modal-footer {
        border-top: 1px solid #dee2e6;
        background-color: #f8f9fa;
    }

    .cancel-reason {
        margin-bottom: 20px;
    }

    .return-details {
        background-color: #fff8e1;
        border-radius: 8px;
        padding: 15px;
        margin-top: 20px;
        border-left: 4px solid #ffc107;
    }

    .success-icon {
        font-size: 4rem;
        color: #28a745;
        margin-bottom: 1rem;
    }

    .success-modal .modal-header {
        border-bottom: none;
        padding-bottom: 0;
    }

    .success-modal .modal-body {
        text-align: center;
        /* padding-top: 2rem;
    padding-bottom: 2rem; */
    }

    .success-modal .modal-footer {
        border-top: none;
        justify-content: center;
    }

    .success-details {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        margin: 20px 0;
        text-align: left;
    }

    .image-preview {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 10px;
    }

    .image-preview div {
        position: relative;
    }

    .image-preview img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 5px;
        border: 1px solid #ddd;
    }

    .remove-btn {
        position: absolute;
        top: 5px;
        right: 5px;
        background: red;
        color: white;
        border: none;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        font-size: 14px;
        cursor: pointer;
    }

    .my-order-title {
        padding: 20px;
        border-bottom: 1px solid #eee;
    }

    .Keep-Order {
        background-color: #388e3c;
        color: #fff;
    }

    .Keep-Order:hover {
        background-color: rgb(26, 104, 44);
        color: #fff;
    }
</style>

<!-- Main Content -->
<div class="container my-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3 mb-4">
            <div class="list-group">
                <a href="#" class="list-group-item list-group-item-action">
                    <i class="fas fa-user-circle me-2"></i> Account
                </a>
                <a href="#" class="list-group-item list-group-item-action active">
                    <i class="fas fa-box me-2"></i> My Orders
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    <i class="fi-rr-heart me-2"></i> My Wishlist
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    <i class="fas fa-map-marker-alt me-2"></i> My Addresses
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    <i class="fas fa-credit-card me-2"></i> My Payments
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </a>
            </div>
        </div>

        <!-- Orders Content -->
        <div class="col-lg-9">
    @if ($orders->isEmpty())
        <div class="alert alert-info">You have no orders yet.</div>
    @else
       
        @foreach ($orders as $order)
            <div class="order-card mb-4">
                 <div class="my-order-title">
            <h1 class="page-title mb-0">My Orders</h1>
        </div>
        
                <div class="order-header">
                    <div>
                        <div class="order-id">Order #{{ $order->id }}</div>
                        <div class="order-date">Placed on {{ $order->created_at->format('d M, Y') }}</div>
                    </div>
                    <div class="order-status-container">
                        <span class="order-status status-{{ strtolower($order->status) }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>
                
                <div class="order-body">
                    @foreach ($order->items as $item)
                        <div class="row mb-3">
                            <div class="col-md-2 col-4">
                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="product-img">
                            </div>
                            <div class="col-md-6 col-8 product-details">
                                <div class="product-name">{{ $item->product->name }}</div>
                                <div class="product-price">Rs. {{ number_format($item->price, 2) }}</div>
                                <div class="product-qty">Qty: {{ $item->quantity }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="order-footer">
                    <div class="row">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <div class="order-total">Total: Rs. {{ number_format($order->total_amount, 2) }}</div>
                            <small class="text-muted">Paid using {{ ucfirst($order->payment_method) }}</small>
                        </div>
                         
                        <div class="col-md-6 ">
                             <div class="d-flex justify-content-md-end action-buttons">
                            @if ($order->status == 'completed')
                                <a href="{{ route('track.order', \Hashids::encode($order->id)) }}"  class="btn btn-primary action-btn me-2">Track Order</a>
                                <a href="{{ route('orders.invoice', \Hashids::encode($order->id)) }}" class="btn btn-secondary action-btn" target="_blank">View Invoice</a>
                            @elseif ($order->status == 'pending')
                                <form action="{{ route('orders.cancel', $order->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to cancel this order?');">
                                        Cancel
                                    </button>
                                </form>
                            @endif
                        </div>
                         </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>

    </div>
</div>
<!-- Cancel Order Modal -->
<div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelOrderModalLabel">Cancel Order #ORD123456789</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="order-summary mb-4">
                    <div class="row">
                        <div class="col-md-2">
                            <img src="assets/img/product-images/book11.png" alt="Product" class="product-image">
                        </div>
                        <div class="col-md-10">
                            <h6>Wireless Bluetooth Headphones</h6>
                            <p class="text-muted mb-1">Color: Black | Size: Standard</p>
                            <p class="text-muted mb-1">Seller: AudioTech</p>
                            <p class="fw-bold mb-0">₹1,999</p>
                        </div>
                    </div>
                </div>

                <form id="cancelOrderForm">
                    <div class="cancel-reason">
                        <label for="cancelReason" class="form-label fw-bold">Reason for Cancellation</label>
                        <select class="form-select" id="cancelReason" required>
                            <option value="" selected disabled>Select a reason</option>
                            <option value="mind_change">I changed my mind</option>
                            <option value="price">Found a better price elsewhere</option>
                            <option value="delivery">Delivery time is too long</option>
                            <option value="mistake">Ordered by mistake</option>
                            <option value="payment">Payment issues</option>
                            <option value="other">Other reason</option>
                        </select>

                        <div class="mt-3" id="otherReasonContainer" style="display: none;">
                            <label for="otherReason" class="form-label">Please specify:</label>
                            <textarea class="form-control" id="otherReason" rows="2"></textarea>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="additionalComments" class="form-label fw-bold">Additional Comments
                            (Optional)</label>
                        <textarea class="form-control" id="additionalComments" rows="3"
                            placeholder="Please provide any additional information that might help us improve"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="imageUpload" class="form-label fw-bold">Upload Images (Optional)</label>
                        <input type="file" class="form-control" id="imageUpload" accept="image/*" multiple>
                        <div class="form-text">Upload images if needed to explain your cancellation reason.</div>

                        <div class="image-preview-container">
                            <div id="imagePreviewGrid" class="image-preview-grid">
                                <div class="no-images-text" id="noImagesText">
                                    Image previews will appear here
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="return-details">
                        <h6 class="fw-bold">Return & Refund Information</h6>
                        <ul class="mb-0">
                            <li>Refund will be processed to your original payment method</li>
                            <li>Refund typically takes 5-7 business days to reflect in your account</li>
                            <li>If you paid using a credit/debit card, the amount will be refunded to the same card</li>
                            <li>For COD orders, refund will be processed to your bank account</li>
                        </ul>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn Keep-Order" data-bs-dismiss="modal">Keep Order</button>
                <button type="button" class="btn btn-danger" id="confirmCancel">Confirm Cancellation</button>
            </div>
        </div>
    </div>
</div>
<!-- Cancellation Success Modal -->
<div class="modal fade success-modal" id="successModal" tabindex="-1" aria-labelledby="successModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <i class="bi bi-check-circle-fill success-icon"></i>
                <h4 class="mb-3">Order Cancellation Successful!</h4>
                <p class="text-muted">Your order #ORD123456789 has been successfully cancelled.</p>

                <div class="success-details">
                    <h6 class="fw-bold mb-3">Refund Details:</h6>
                    <div class="row mb-2">
                        <div class="col-6 text-muted">Refund Amount:</div>
                        <div class="col-6 fw-bold">₹1,999</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6 text-muted">Refund Method:</div>
                        <div class="col-6">Original Payment Method</div>
                    </div>
                    <div class="row">
                        <div class="col-6 text-muted">Expected Refund Date:</div>
                        <div class="col-6">Within 5-7 business days</div>
                    </div>
                </div>

                <p>A confirmation email has been sent to your registered email address.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                    onclick="window.location.href='index.php#new-arrivals'">Continue Shopping</button>
            </div>
        </div>
    </div>
</div>

@endsection