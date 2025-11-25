@extends('layouts.commonMaster')
@section('layoutContent')


<style>

.table>:not(caption)>*>* {
    background-color: var(--bs-table-bg) !important;
    border-bottom-width: 1px !important;
    box-shadow: inset 0 0 0 9999px var(--bs-table-accent-bg) !important;
    padding: .625rem -4.75rem !important;
}

</style>
    <!-- Content wrapper -->
    <div class="content-wrapper">

        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">

            <h4 class="py-3 mb-4">
                <span class="text-muted fw-light">eCommerce /</span> Order List
            </h4>

            <!-- Order List Widget -->
            <div class="card mb-4">
                <div class="card-widget-separator-wrapper">
                    <div class="card-body card-widget-separator">
                        <div class="row gy-4 gy-sm-1">
                            <div class="col-sm-6 col-lg-3">
                                <div
                                    class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-3 pb-sm-0">
                                    <div>
                                        <h3 class="mb-2">{{ isset($orders_count) ? $orders_count : '' }}</h3>
                                        <p class="mb-0">Total Orders</p>
                                    </div>
                                    <div class="avatar me-sm-4">
                                        <span class="avatar-initial rounded bg-label-secondary">
                                            <i class="bx bx-calendar bx-sm"></i>
                                        </span>
                                    </div>
                                </div>
                                <hr class="d-none d-sm-block d-lg-none me-4">
                            </div>
                            <div class="col-sm-6 col-lg-3 customInput" data-type="pending">
                                <div
                                    class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0">
                                    <div>
                                        <h3 class="mb-2 position-relative" id="pending-count">
                                            {{ isset($orders_pending) ? $orders_pending : '' }}
                                            @if(isset($orders_pending) && $orders_pending > 0)
                                                <span class="notification-dot"></span>
                                            @endif
                                        </h3>
                                        <p class="mb-0">Pending</p>
                                    </div>
                                    <div class="avatar me-lg-4">
                                        <span class="avatar-initial rounded bg-label-secondary">
                                            <i class="bx bx-error-alt bx-sm"></i>
                                        </span>
                                    </div>
                                </div>
                                <hr class="d-none d-sm-block d-lg-none">
                            </div>
                            <div class="col-sm-6 col-lg-3 customInput" data-type="accepted">
                                <div
                                    class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                                    <div>
                                        <h3 class="mb-2" id="accepted-count">
                                            {{ isset($orders_accepted) ? $orders_accepted : '' }}
                                        </h3>
                                        <p class="mb-0">Accepted</p>
                                    </div>
                                    <div class="avatar me-sm-4">
                                        <span class="avatar-initial rounded bg-label-secondary">
                                            <i class="bx bx-check-double bx-sm"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3 customInput" data-type="rejected">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h3 class="mb-2" id="rejected-count">
                                            {{ isset($admin_rejected) ? $admin_rejected : '' }}
                                        </h3>
                                        <p class="mb-0">Rejected</p>
                                    </div>
                                    <div class="avatar">
                                        <span class="avatar-initial rounded bg-label-secondary">
                                            <i class="bx bx-x bx-sm"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order List Table -->
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" id="ordersTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="all-orders-tab" data-bs-toggle="tab" href="#all-orders"
                                role="tab">All Orders</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="customized-orders-tab" data-bs-toggle="tab" href="#customized-orders"
                                role="tab">Customized Orders</a>
                        </li>
                    </ul>
                </div>

                <div class="card-body">
                    <div class="d-flex justify-content-center mb-0">
                        <button class="btn btn-warning resetForm" data-bs-toggle="modal" data-bs-target="#orderChangeModal">
                            Change Payment Status
                        </button>
                    </div>

                    <div class="tab-content" id="ordersTabsContent">
                        <div class="tab-pane fade show active" id="all-orders" role="tabpanel">
                            <div class="card-datatable table-responsive">
                                <table class="datatables-order table border-top" data-order-type="all">
                                    <thead>
                                        <tr>
                                            <th>Sl No</th>
                                            <th>Order ID</th>
                                            <th>User Name</th>
                                            <th>Mobile No</th>
                                            <th>Address</th>
                                            <th>Payment Status</th>
                                            <th>Order Status</th>
                                            <th>Total Amount</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="customized-orders" role="tabpanel">
                            <div class="card-datatable table-responsive">
                                <table class="datatables-order table border-top" data-order-type="customized">
                                    <thead>
                                        <tr>
                                            <th>Sl No</th>
                                            <th>Order ID</th>
                                            <th>User Name</th>
                                            <th>Mobile No</th>
                                            <th>Address</th>
                                            <th>Payment Status</th>
                                            <th>Order Status</th>
                                            <th>Total Amount</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Change Payment Modal -->
            <div class="modal fade" id="orderChangeModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Change Payment Status</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="changeStatus">
                            @csrf
                            <div class="modal-body">
                                <div class="text-danger small mb-2">Warning: Please ensure that you're entering correct
                                    details.</div>
                                <div class="mb-2">
                                    <label>Enter Order ID</label>
                                    <input type="text" name="order_id" id="order_id" class="form-control">
                                </div>
                                <div class="mb-2 selectStatus d-none">
                                    <label>Select Status</label>
                                    <select id="paymentStatus" name="status" class="form-control">
                                        <option value="">Select</option>
                                        <option value="Success">Success</option>
                                        <option value="Failed">Failed</option>
                                    </select>
                                </div>
                                <div class="alert-text alert text-danger d-none" id="statusError"></div>
                                <div class="alert-text alert text-success d-none" id="statusSuccess"></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- View Order Modal -->
            <div class="modal fade" id="viewOrderModal" tabindex="-1" aria-labelledby="viewOrderModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="viewOrderModalLabel">Order #<span id="orderId"></span> details
                            </h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="viewOrderModalContent">
                            <!-- Dynamic order details content loaded here via JS -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Ship Modal --}}
            <div class="modal fade" id="shipOrderModal" tabindex="-1" aria-labelledby="shipOrderModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <form id="shipOrderForm">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Ship Order</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="order_id" id="shipOrderId">
                                <div class="mb-3">
                                    <label for="tracking_id" class="form-label">Tracking ID</label>
                                    <input type="text" class="form-control" name="tracking_id" required>
                                </div>
                                <div class="mb-3">
                                    <label for="tracking_link" class="form-label">Tracking Link</label>
                                    <input type="text" class="form-control" name="tracking_link" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Cancel Modal --}}
            <div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <form id="cancelOrderForm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Cancel Order</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="order_id" id="cancelOrderId">
                                <p>Are you sure you want to cancel this order?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-danger">Yes, Cancel</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Deliver Modal --}}
            <div class="modal fade" id="deliverOrderModal" tabindex="-1" aria-labelledby="deliverOrderModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <form id="deliverOrderForm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Deliver Order</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="order_id" id="deliverOrderId">
                                <p>Are you sure you want to mark this order as delivered?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Yes, Deliver</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .notification-dot {
            position: absolute;
            top: -5px;
            right: -8px;
            width: 10px;
            height: 10px;
            background-color: #ff0000;
            border-radius: 50%;
            border: 2px solid #fff;
            box-shadow: 0 0 5px rgba(255, 0, 0, 0.7);
        }
    </style>

    <!-- CSRF for all AJAX -->
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
    </script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Your custom scripts -->
    <script src="/js/admin-orders.js"></script>

    <script>
        const orderViewRoute = "{{ route('orders.view', ['id' => '__ID__']) }}";
    </script>

    <script>
        $(document).ready(function () {
            // Initialize Toast Container
            if ($('#toast-container').length === 0) {
                $('body').append('<div id="toast-container" style="position: fixed; top: 20px; right: 20px; z-index: 1100;"></div>');
            }

            // Helper functions (moved before DataTable init to avoid undefined errors)
            function getPaymentStatusBadge(status) {
                switch (status ? status.toLowerCase() : '') {
                    case 'success': case 'completed': return 'bg-success';
                    case 'pending': return 'bg-warning text-dark';
                    case 'failed': case 'cancelled': return 'bg-danger';
                    default: return 'bg-secondary';
                }
            }

            function getOrderStatusBadge(status) {
                switch (status ? status.toLowerCase() : '') {
                    case 'processing': case 'pending': return 'bg-info';
                    case 'shipped': return 'bg-primary';
                    case 'delivered': return 'bg-success';
                    case 'cancelled': return 'bg-danger';
                    case 'returned': return 'bg-warning text-dark';
                    default: return 'bg-secondary';
                }
            }

            function formatDateTime(dateString) {
                if (!dateString) return 'N/A';
                const date = new Date(dateString);
                return date.toLocaleString();
            }

            function truncateUrl(url, maxLength = 30) {
                if (!url) return 'N/A';
                return url.length > maxLength ? url.substring(0, maxLength) + '...' : url;
            }

            function showError(message) {
                $('#statusError').removeClass('d-none').text(message);
                setTimeout(() => $('#statusError').addClass('d-none'), 5000);
            }

            function showSuccess(message) {
                $('#statusSuccess').removeClass('d-none').text(message);
                setTimeout(() => $('#statusSuccess').addClass('d-none'), 5000);
            }

            function resetForm() {
                $('#changeStatus')[0].reset();
                $('.selectStatus').addClass('d-none');
            }

            function showModalError(message) {
                $('#viewOrderModalContent').html(`
                                        <div class="alert alert-danger">
                                            <i class="bi bi-exclamation-triangle-fill"></i> ${message}
                                        </div>
                                    `);
                $('#viewOrderModal').modal('show');
            }

            function showToast(message, type = 'success') {
                const bgClass = type === 'success' ? 'bg-success' : 'bg-danger';
                const toastId = 'toast-' + Date.now();

                const toast = $(`
                                        <div id="${toastId}" class="toast align-items-center text-white ${bgClass} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                                            <div class="d-flex">
                                                <div class="toast-body">${message}</div>
                                                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                                            </div>
                                        </div>
                                    `);

                $('#toast-container').append(toast);

                const bsToast = new bootstrap.Toast(toast[0], { delay: 3000 });
                bsToast.show();

                toast.on('hidden.bs.toast', function () {
                    $(this).remove();
                });
            }
            // Add function to show details of returned order in a modal
            // Make showReturnDetailsModal globally accessible for inline onclick
            window.showReturnDetailsModal = function (reason, details, orderId) {
                // Build modal HTML if not already present
                let $modal = $('#returnDetailsModal');
                if ($modal.length === 0) {
                    $('body').append(`
                                        <div class="modal fade" id="returnDetailsModal" tabindex="-1" aria-labelledby="returnDetailsModalLabel" aria-hidden="true">
                                          <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h5 class="modal-title" id="returnDetailsModalLabel">Return Details (Order #<span id="modalOrderId"></span>)</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                              </div>
                                              <div class="modal-body">
                                                <strong>Reason for Return:</strong>
                                                <div id="modalReturnReason" class="mb-2"></div>
                                                <strong>Additional Details:</strong>
                                                <div id="modalReturnDetails"></div>
                                              </div>
                                              <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                    `);
                    $modal = $('#returnDetailsModal');
                }

                // Unescape any HTML entities (for extra safety)
                function htmlDecode(input) {
                    var e = document.createElement('textarea');
                    e.innerHTML = input;
                    // convert '\n' to <br>
                    return e.value.replace(/\n/g, '<br>');
                }

                $('#modalOrderId').text(orderId);
                $('#modalReturnReason').html(reason ? htmlDecode(reason) : '<em>No reason provided</em>');
                $('#modalReturnDetails').html(details ? htmlDecode(details) : '<em>No details provided</em>');

                var modalObj = bootstrap.Modal ? new bootstrap.Modal($modal[0]) : $modal;
                if (modalObj && modalObj.show) {
                    modalObj.show();
                } else {
                    $modal.modal('show');
                }
            };

            // Change Payment Status

            // Initialize all tables (NO expandable rows)
            $('.datatables-order').each(function () {
                let orderType = $(this).data('order-type');
                $(this).DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('get.orders') }}",
                        data: function (d) {
                            d.order_type = orderType;
                        }
                    },
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                        { data: 'order_id', name: 'order_id' },
                        { data: 'user_name', name: 'user_name' },
                        { data: 'mobile', name: 'mobile' },
                        { data: 'address', name: 'address' },
                        { 
                            data: 'payment_status', 
                            name: 'payment_status', 
                            render: function (data) { 
                                return `<span class="badge ${getPaymentStatusBadge(data)}">${data ? $('<div>').text(data).html() : ''}</span>`; 
                            } 
                        },
                        {
                            data: 'order_status',
                            name: 'order_status',
                            render: function (data, type, row) {
                                let status = (data || '').toString().trim();
                                // Robust HTML escaper
                                function escapeHtml(str) {
                                    return String(str).replace(/[&<>"'`=\/]/g, function (s) {
                                        return ({
                                            "&": "&amp;",
                                            "<": "&lt;",
                                            ">": "&gt;",
                                            '"': "&quot;",
                                            "'": "&#39;",
                                            "/": "&#x2F;",
                                            "`": "&#x60;",
                                            "=": "&#x3D;"
                                        })[s] || s;
                                    });
                                }

                                if (status && status.toLowerCase() === 'returned') {
                                    let reason = row.return_reason ? escapeHtml(row.return_reason) : '';
                                    let details = row.return_details ? escapeHtml(row.return_details) : '';
                                    let orderId = row.order_id ? escapeHtml(row.order_id) : '';

                                    return `
                                        <span
                                            class="badge ${getOrderStatusBadge(status)}"
                                            
                                            onmouseover="this.style.background='#d1eee4';this.style.boxShadow='0 2px 20px #27ffd3b4, 0 0px 14px 2px #01ce92b0';"
                                            onmouseout="this.style.background='linear-gradient(90deg,#e0ffe8 0%,#e1f7fa 100%)';this.style.boxShadow='0 4px 16px 0 #55e6b2cc, 0 1.5px 8px 1px #0c9f78cc';"
                                            onclick="window.showReturnDetailsModal('${reason}','${details}','${orderId}')"
                                        >
                                            <i class="fas fa-comment-dots"
                                                style="color:#038ecd; font-size:1.25em; margin-right:0.32em; filter: drop-shadow(0 1px 3px #aaf6ff);"></i>
                                            <span style="vertical-align:middle;">Return&nbsp;request</span>
                                        </span>
                                    `;
                                } else {
                                    return `<span class="badge ${getOrderStatusBadge(status)}">${escapeHtml(status)}</span>`;
                                }
                            }
                        },
                        { 
                            data: 'total_amount', 
                            name: 'total_amount', 
                            render: function (data) { 
                                let n = parseFloat(data);
                                return isNaN(n) ? '' : '₹' + n.toFixed(2); 
                            } 
                        },
                        { data: 'actions', name: 'actions', orderable: false, searchable: false },
                    ],
                    order: [[1, 'desc']]
                });
            });

            // Refresh table when tab is shown
            $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
                var target = $(e.target).attr('href');
                $(target).find('.datatables-order').DataTable().ajax.reload();
            });



            $('#order_id').on('input', function () {
                const orderId = $(this).val().trim();
                $('.selectStatus').toggleClass('d-none', !orderId || isNaN(orderId));
            });

            $('#changeStatus').on('submit', function (e) {
                e.preventDefault();
                $('#statusError, #statusSuccess').addClass('d-none').text('');
                const orderId = $('#order_id').val().trim();
                const status = $('#paymentStatus').val();

                if (!orderId || isNaN(orderId)) {
                    showError('Please enter a valid numeric Order ID');
                    return;
                }

                if (!status) {
                    showError('Please select a payment status');
                    return;
                }

                const submitBtn = $(this).find('[type="submit"]');
                submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status"></span> Processing...');

                $.ajax({
                    url: "{{ route('orders.update-payment-status') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        order_id: parseInt(orderId),
                        status: status
                    },
                    success: function (response) {
                        if (response.success) {
                            showSuccess(response.message);
                            resetForm();
                            // Reload all tables
                            $('.datatables-order').each(function () {
                                $(this).DataTable().ajax.reload(null, false);
                            });
                        } else {
                            showError(response.message || 'Failed to update payment status');
                        }
                    },
                    error: function (xhr) {
                        let errorMsg = 'An error occurred. Please try again.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        } else if (xhr.statusText) {
                            errorMsg = xhr.statusText;
                        }
                        showError(errorMsg);
                    },
                    complete: function () {
                        submitBtn.prop('disabled', false).text('Submit');
                    }
                });
            });

            // Handle view order button click
            $(document).on('click', '.btn-view-order', function () {
                const orderId = $(this).data('id');
                const url = orderViewRoute.replace('__ID__', orderId);

                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            try {
                                const order = response.order;
                                // Build HTML for order details including all items
                                let html = `
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h5>Order Information</h5>
                                                            <table class="table table-sm">
                                                                <tr><th>Order ID</th><td>${order.order_id || ''}</td></tr>
                                                                <tr><th>Order Date</th><td>${formatDateTime(order.created_at)}</td></tr>
                                                                <tr><th>Total Amount</th><td>${order.total_amount ? '₹' + parseFloat(order.total_amount).toFixed(2) : ''}</td></tr>
                                                                <tr><th>Payment Status</th><td><span class="badge ${getPaymentStatusBadge(order.payment_status)}">${order.payment_status}</span></td></tr>
                                                                <tr><th>Order Status</th><td><span class="badge ${getOrderStatusBadge(order.order_status)}">${order.order_status}</span></td></tr>
                                                                <tr><th>Transaction ID</th><td>${order.transaction_id || 'N/A'}</td></tr>
                                                            </table>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h5>Shipping Information</h5>
                                                            <table class="table table-sm">
                                                                <tr><th>Tracking ID</th><td>${order.tracking_id || 'N/A'}</td></tr>
                                                                <tr><th>Tracking Link</th><td>${order.tracking_link ? `<a href="${order.tracking_link}" target="_blank">${truncateUrl(order.tracking_link)}</a>` : 'N/A'}</td></tr>
                                                                <tr><th>Shipped At</th><td>${order.shipped_at ? formatDateTime(order.shipped_at) : 'N/A'}</td></tr>
                                                                <tr><th>Delivered At</th><td>${order.delivered_at ? formatDateTime(order.delivered_at) : 'N/A'}</td></tr>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    <div class="row mt-3">
                                                        <div class="col-12">
                                                            <h5>Order Items</h5>
                                                            <table class="table table-sm" id="order-items-table">
                                                                <thead class="table-light">
                                                                    <tr>
                                                                        <th>Image</th>
                                                                        <th>Product Name</th>
                                                                        <th>Category</th>
                                                                        <th>Qty</th>
                                                                        <th>Unit Price</th>
                                                                        <th>Total</th>
                                                                        <th>Color</th>   
                                                                        <th>Attributes</th>

                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                    `;
                                if (order.items && Array.isArray(order.items) && order.items.length > 0) {
                                    order.items.forEach(function (item) {
                                        let itemTotal = (item.quantity * item.price).toFixed(2);
                                        let imageSrc = item.image || '/placeholder.jpg';
                                        html += `
                                                                <tr>
                                                                    <td><img src="${imageSrc}" alt="" style="width: 50px; height: 50px; object-fit: cover;" class="rounded"></td>
                                                                    <td>${item.product_name || item.product || 'N/A'}</td>
                                                                    <td>${item.category || 'N/A'}</td>
                                                                    <td>${item.quantity}</td>
                                                                    <td>₹${parseFloat(item.price).toFixed(2)}</td>
                                                                    <td>₹${itemTotal}</td>
                                                                    <td>
                                                                        ${item.color_code
                                                ? `<span style="display:inline-block;width:20px;height:20px;background-color:${item.color_code};border-radius:4px;border:1px solid #ccc;"></span> <code></code>`
                                                : ''
                                            }
                                                                    </td>
                                                                    <td>
                                                                        ${(item.dynamic_attributes && Array.isArray(item.dynamic_attributes) && item.dynamic_attributes.length > 0)
                                                ? item.dynamic_attributes.map(attr => `<span class="badge bg-secondary me-1">${attr.name}: ${attr.value ?? ''}</span>`).join(' ')
                                                : '<span class="text-muted">N/A</span>'
                                            }
                                                                    </td>
                                                                </tr>
                                                            `;
                                    });
                                } else {
                                    html += `<tr><td colspan="7" class="text-center">No items found</td></tr>`;
                                }

                                html += `
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    <div class="row mt-3">
                                                        <div class="col-12">
                                                            <h5>Additional Information</h5>
                                                            <table class="table table-sm" id="additional-info-table">
                                                                <tbody>
                                                                    <tr><th>Cancel Reason</th><td>${order.cancel_order_reason || 'N/A'}</td></tr>
                                                                    <tr><th>Admin Notes</th><td>${order.admin_notes || 'N/A'}</td></tr>
                                                    `;

                                // Handle customization details
                                let hasCustomization = false;
                                if (order.items && Array.isArray(order.items)) {
                                    for (let item of order.items) {
                                        if (item.product && item.product.customize == 1 && item.customization) {
                                            hasCustomization = true;
                                            html += `<tr><th>Custom Text (Item: ${item.product_name || item.product || 'N/A'})</th><td>${item.customization.custom_text || 'N/A'}</td></tr>`;
                                            if (item.customization.image_content) {
                                                html += `
                                                                        <tr>
                                                                            <th>Custom Image (Item: ${item.product_name || item.product || 'N/A'})</th>
                                                                            <td><img src="data:image/jpeg;base64,${item.customization.image_content}" alt="Custom Design" style="max-width: 200px; max-height: 200px;" class="img-thumbnail"></td>
                                                                        </tr>
                                                                    `;
                                            }
                                            break; // show only first customized
                                        }
                                    }
                                }
                                if (!hasCustomization) {
                                    html += `
                                                            <tr><th>Custom Product</th><td>No</td></tr>
                                                            <tr><th>Custom Text</th><td>N/A</td></tr>
                                                            <tr><th>Custom Image</th><td>N/A</td></tr>
                                                        `;
                                }

                                html += `
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    `;

                                $('#orderId').text(order.order_id);
                                $('#viewOrderModalContent').html(html);
                                $('#viewOrderModal').modal('show');
                            } catch (error) {
                                console.error('Error building order HTML:', error);
                                showModalError('Error processing order data. Please check console for details.');
                            }
                        } else {
                            showModalError(response.error || 'Unknown error occurred');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX error fetching order:', error);
                        let errorMsg = 'Error fetching order details';
                        try {
                            const response = JSON.parse(xhr.responseText);
                            errorMsg = response.error || errorMsg;
                        } catch (e) { }
                        showModalError(`${errorMsg} (Status: ${xhr.status})`);
                    }
                });
            });

            // Ship Order
            $(document).on('click', '.shipOrderBtn', function () {
                const orderId = $(this).data('id');
                $('#shipOrderId').val(orderId);
                $('#shipOrderModal').modal('show');
            });

            $('#shipOrderForm').submit(function (e) {
                e.preventDefault();
                const form = $(this);
                const submitBtn = form.find('[type="submit"]');
                submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Processing...');

                $.post('{{ route('orders.ship') }}', form.serialize(), function (res) {
                    if (res.success) {
                        $('#shipOrderModal').modal('hide');
                        form.trigger('reset');
                        $('.datatables-order').each(function () {
                            $(this).DataTable().ajax.reload(null, false);
                        });
                        showToast('Order shipped successfully!');
                    } else {
                        showToast(res.message || 'Failed to update order', 'danger');
                    }
                }).fail(function (xhr) {
                    showToast(xhr.responseJSON?.message || 'Server error occurred.', 'danger');
                }).always(function () {
                    submitBtn.prop('disabled', false).text('Submit');
                });
            });

            // Cancel Order
            $(document).on('click', '.cancelOrderBtn', function () {
                const orderId = $(this).data('id');
                $('#cancelOrderId').val(orderId);
                $('#cancelOrderModal').modal('show');
            });

            $('#cancelOrderForm').submit(function (e) {
                e.preventDefault();
                const submitBtn = $(this).find('[type="submit"]');
                submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Processing...');

                $.post('{{ route("orders.cancel") }}', $(this).serialize(), function (res) {
                    if (res.success) {
                        $('#cancelOrderModal').modal('hide');
                        $('.datatables-order').each(function () {
                            $(this).DataTable().ajax.reload(null, false);
                        });
                        showToast('Order cancelled successfully!');
                    } else {
                        showToast(res.message || 'Failed to cancel order', 'danger');
                    }
                }).fail(function (xhr) {
                    showToast(xhr.responseJSON?.message || 'Failed to cancel order', 'danger');
                }).always(function () {
                    submitBtn.prop('disabled', false).text('Yes, Cancel');
                });
            });

            // Deliver Order
            $(document).on('click', '.deliverOrderBtn', function () {
                const orderId = $(this).data('id');
                $('#deliverOrderId').val(orderId);
                $('#deliverOrderModal').modal('show');
            });

            $('#deliverOrderForm').submit(function (e) {
                e.preventDefault();
                const submitBtn = $(this).find('[type="submit"]');
                submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Processing...');

                $.post('{{ route("orders.deliver") }}', $(this).serialize(), function (res) {
                    if (res.success) {
                        $('#deliverOrderModal').modal('hide');
                        $('.datatables-order').each(function () {
                            $(this).DataTable().ajax.reload(null, false);
                        });
                        showToast('Order marked as delivered!');
                    } else {
                        showToast(res.message || 'Failed to update order status', 'danger');
                    }
                }).fail(function (xhr) {
                    showToast(xhr.responseJSON?.message || 'Failed to update order status', 'danger');
                }).always(function () {
                    submitBtn.prop('disabled', false).text('Yes, Deliver');
                });
            });

            // Download Invoice
            $(document).on('click', '.downloadInvoiceBtn', function () {
                const orderId = $(this).data('id');
                window.open('{{ route("orders.invoice", ":id") }}'.replace(':id', orderId), '_blank');
            });

            // Hide buttons based on status after draw
            $('.datatables-order').on('draw.dt', function () {
                $(this).find('tr').each(function () {
                    const row = $(this);
                    const orderStatusCell = row.find('td').eq(6); // Order Status column index (after removing the expand)
                    const status = orderStatusCell.text().trim().toLowerCase();

                    if (status === 'shipped' || status === 'delivered') {
                        row.find('.shipOrderBtn, .deliverOrderBtn').remove();
                    }

                    if (status === 'shipped' || status === 'cancelled' || status === 'delivered') {
                        row.find('.cancelOrderBtn').remove();
                    }
                });
            });
        });
    </script>

@endsection