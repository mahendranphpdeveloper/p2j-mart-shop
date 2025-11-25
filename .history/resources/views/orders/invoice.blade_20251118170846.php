@extends('layouts.app')

@section('content')

    <style>
        /* Invoice Styling */
        .invoice-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .invoice-header {
            border-radius: 8px 8px 0 0 !important;
        }

        .invoice-card {
            border: none;
            border-radius: 8px;
        }

        .info-card {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 1.25rem;
            height: 100%;
        }

        .info-title {
            color: #495057;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 0.5rem;
            margin-bottom: 1rem;
        }

        .invoice-table {
            margin-bottom: 0;
        }

        .invoice-table th {
            background-color: #f1f8ff !important;
            color: #495057;
        }

        .grand-total {
            font-weight: 700;
            color: #dc3545;
        }

        .section-title {
            color: #495057;
            margin-bottom: 1rem;
        }

        .signature-line {
            width: 200px;
            border-top: 1px solid #000;
            margin-top: 15px;
        }

        .print-btn {
            transition: all 0.3s ease;
        }

        .print-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .back-btn {
            padding: 0.5rem 1.5rem;
        }

        /* Print Specific Styles */
        @media print {
            body * {
                visibility: hidden;
            }

            #invoice-print-section,
            #invoice-print-section * {
                visibility: visible;
            }

            #invoice-print-section {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                margin: 0;
                padding: 0;
                box-shadow: none;
            }

            .invoice-header {
                background-color: #007bff !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .d-print-none {
                display: none !important;
            }

            .info-card {
                background-color: #f8f9fa !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .invoice-table th {
                background-color: #f1f8ff !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <!-- Invoice Print Section -->
                <div id="invoice-print-section" class="invoice-container">
                    <div class="card invoice-card">
                        <div class="card-header invoice-header bg-primary text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="mb-0  text-white"><i class="fas fa-file-invoice me-2"></i> Order Invoice</h4>
                                <div class="d-print-none">
                                    <button onclick="printInvoice()" class="btn btn-light btn-sm print-btn">
                                        <i class="fas fa-print me-1"></i> Print Invoice
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="card-body invoice-body">
                            <!-- Company Logo and Info -->
                            <div class="mb-4 d-print-block">
                                <img src="{{ asset('uploads/logo/' . $headerFooter->image) }}" alt="Company Logo"
                                    class="invoice-logo mb-2" style="height: 65px;">
                            </div>

                            <div class="row mb-4 invoice-info-section">
                                <div class="col-md-6">
                                    <div class="info-card">
                                        <h5 class="info-title"><i class="fas fa-info-circle me-2"></i>Order Information</h5>
                                        <p><strong>Invoice #:</strong>
                                            INV-{{ str_pad($order->order_id, 6, '0', STR_PAD_LEFT) }}</p>
                                        <p><strong>Order Date:</strong> {{ $order->created_at->format('F j, Y') }}</p>
                                        <p><strong>Status:</strong>
                                            <span class="badge status-badge bg-primary text-capitalize">
                                                {{ str_replace('_', ' ', $order->order_status) }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-card">
                                        <h5 class="info-title"><i class="fas fa-credit-card me-2"></i>Payment Information
                                        </h5>
                                        <p><strong>Payment Status:</strong>
                                            <span
                                                class="badge status-badge {{ $order->payment_status === 'completed' ? 'bg-success' : 'bg-warning' }} text-capitalize">
                                                {{ $order->payment_status }}
                                            </span>
                                        </p>
                                        <p><strong>Transaction ID:</strong> {{ $order->transaction_id }}</p>
                                        <p><strong>Total Amount:</strong>
                                            ₹{{ number_format($order->total_amount + ($order->shipping_cost ?? 0), 2) }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4 invoice-info-section">
                                <div class="col-md-6">
                                    <div class="info-card">
                                        <h5 class="info-title"><i class="fas fa-user me-2"></i>Billing Information</h5>
                                        <p><strong>Customer ID:</strong>
                                            {{ str_pad($order->user_id, 6, '0', STR_PAD_LEFT) }}</p>
                                        <p><strong>Customer Name:</strong> {{ Auth::user()->name }}</p>
                                        <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-card">
                                        <h5 class="info-title"><i class="fas fa-truck me-2"></i>Shipping Information</h5>
                                        @if($order->address)
                                            <p><strong>Name:</strong> {{ $order->address->name }}</p>
                                            <p><strong>Address:</strong> {{ $order->address->address_line1 }},
                                                {{ $order->address->address_line2 }}</p>
                                            <p><strong>City:</strong> {{ $order->address->city }}, {{ $order->address->state }}
                                                - {{ $order->address->zipcode }}</p>
                                            <p><strong>Phone:</strong> {{ $order->address->phone }}</p>
                                        @else
                                            <p class="text-danger">Shipping address not found</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4 invoice-items-section">
                                <h5 class="section-title"><i class="fas fa-box-open me-2"></i>Order Items</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered invoice-table">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="5%">#</th>
                                                <th width="45%">Product</th>
                                                <th width="15%">Quantity</th>
                                                <th width="15%">Unit Price</th>
                                                <th width="20%">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($order->items as $i => $item)
                                                <tr>
                                                    <td>{{ $i+1 }}</td>
                                                    <td>
                                                        @if($item->product)
                                                            {{ $item->product->product_name }}
                                                        @else
                                                            Product not found
                                                        @endif
                                                        @if($item->productUnit)
                                                            <br><small class="text-muted">Unit: {{ $item->productUnit->unit_name ?? '' }}</small>
                                                        @endif
                                                    </td>
                                                    <td>{{ $item->quantity }}</td>
                                                    <td>₹{{ number_format($item->price, 2) }}</td>
                                                    <td>₹{{ number_format($item->price * $item->quantity, 2) }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">No items found for this order.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4" class="text-end"><strong>Shipping:</strong></td>
                                                <td>₹{{ number_format($order->shipping_cost ?? 0, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-end"><strong>Grand Total:</strong></td>
                                                <td class="grand-total">
                                                    ₹{{ number_format(($order->total_amount ?? 0) + ($order->shipping_cost ?? 0), 2) }}
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <div class="border-top pt-4 mt-4 invoice-footer">
                                <div class="d-flex justify-content-between">
                                    <div class="thank-you-note">
                                        <h6>Thank you for your business!</h6>
                                        <p class="text-muted">If you have any questions about this invoice, please contact
                                            our customer support.</p>
                                        <div class="signature-area mt-3">
                                            <p class="mb-1">Authorized Signature</p>
                                            <div class="signature-line"></div>
                                        </div>
                                    </div>
                                    <div class="invoice-meta text-end">
                                        <p class="mb-1"><strong>Order ID:</strong> #{{ $order->order_id }}</p>
                                        <p class="mb-0"><strong>Invoice Date:</strong> {{ now()->format('F j, Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Back Button (Non-Printable) -->
                <div class="d-print-none text-center mt-4">
                    <a href="{{ route('home') }}" class="btn btn-primary back-btn">
                        <i class="fas fa-arrow-left me-2"></i> Back to Orders
                    </a>
                </div>
            </div>
        </div>
    </div>



    <script>
        function printInvoice() {
            window.print();
        }
    </script>
@endsection