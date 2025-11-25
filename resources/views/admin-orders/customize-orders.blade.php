@extends('layouts.commonMaster')

@section('layoutContent')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-12">
            <h1 class="h3 mb-2 text-gray-800">Customized Orders Management</h1>
            <p class="mb-4">View and manage all customized product orders</p>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Customized Orders</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" 
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" 
                     aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="#">Export to Excel</a>
                    <a class="dropdown-item" href="#">Print</a>
                </div>
            </div>
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="customOrdersTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>Order ID</th>
                            <th>Product</th>
                            <th>Customer</th>
                            <th>Customization</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customizedOrders as $order)
                        <tr>
                            <td>
                                {{ $order->order_id ?? 'N/A' }}
                                @if(!$order->order_id)
                                    <span class="badge badge-warning ml-2">Unprocessed</span>
                                @endif
                            </td>
                            <td>
                                @if($order->product)
                                    <div class="d-flex align-items-center">
                                        @if($order->product->image)
                                        <img src="{{ asset('storage/'.$order->product->image) }}" 
                                             class="img-thumbnail mr-2" 
                                             width="40" height="40" 
                                             alt="{{ $order->product->product_name }}">
                                        @endif
                                        <div>
                                            <strong>{{ $order->product->product_name }}</strong>
                                            <div class="text-muted small">SKU: {{ $order->product->sku ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-danger">Product deleted</span>
                                @endif
                            </td>
                            <td>
                                @if($order->user)
                                    <div>
                                        <strong>{{ $order->user->name }}</strong>
                                        <div class="text-muted small">{{ $order->user->email }}</div>
                                        <div class="text-muted small">
                                            @if($order->user->phone)
                                                {{ $order->user->phone }}
                                            @else
                                                Phone not provided
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted">Guest checkout</span>
                                @endif
                            </td>
                           <td>
    <div class="customization-details">
        @if($order->custom_text)
            <p><strong>Text:</strong> {{ Str::limit($order->custom_text, 50) }}</p>
        @endif
        
      @if($order->custom_image)
    @php
        $imagePath = 'storage/' . $order->custom_image;
        $fullPath = storage_path('app/public/' . $order->custom_image);
    @endphp
    
    @if(file_exists($fullPath))
        <a href="{{ asset($imagePath) }}" 
           data-lightbox="custom-image-{{ $order->id }}"
           data-title="Customization for Order #{{ $order->order_id ?? 'N/A' }}">
            <img src="{{ asset($imagePath) }}"
                 class="img-thumbnail" 
                 width="60" 
                 alt="Custom Image">
        </a>
    @else
        <span class="text-danger">Image file missing ({{ $order->custom_image }})</span>
    @endif
@else
    <span class="text-muted">No custom image</span>
@endif
    </div>
</td>   
                            <td>
                                @if(isset($order->order_status))
                                    <span class="badge 
                                        @if($order->order_status == 'processing') badge-warning
                                        @elseif($order->order_status == 'shipped') badge-info
                                        @elseif($order->order_status == 'delivered') badge-success
                                        @elseif($order->order_status == 'cancelled') badge-danger
                                        @else badge-secondary @endif">
                                        {{ ucfirst($order->order_status) }}
                                    </span>
                                @else
                                    <span class="badge badge-light">Not ordered</span>
                                @endif
                            </td>
                            <td>
                                {{ $order->order_date ? $order->order_date->format('M d, Y H:i') : $order->created_at->format('M d, Y H:i') }}
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-info" 
                                            data-toggle="modal" 
                                            data-target="#orderDetailModal"
                                            data-order-id="{{ $order->order_id ?? $order->id }}"
                                            title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    
                                    @if($order->order_id)
                                        <a href="{{ route('admin.orders.edit', $order->order_id) }}" 
                                           class="btn btn-primary" title="Edit Order">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @else
                                        <button class="btn btn-success" 
                                                data-toggle="modal" 
                                                data-target="#createOrderModal"
                                                data-customization-id="{{ $order->id }}"
                                                title="Create Order">
                                            <i class="fas fa-cart-plus"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <div class="empty-state">
                                    <i class="fas fa-shopping-bag fa-3x text-gray-400 mb-3"></i>
                                    <h4>No Customized Orders Found</h4>
                                    <p class="text-muted">There are currently no customized product orders in the system.</p>
                                    <a href="#" class="btn btn-primary mt-2">
                                        <i class="fas fa-plus mr-2"></i> Add New Product
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
           @if($customizedOrders->hasPages())
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="float-right">
                {{ $customizedOrders->links() }}  {{-- Works now! --}}
            </div>
        </div>
    </div>
@endif
        </div>
    </div>
</div>

<!-- Order Detail Modal -->
<div class="modal fade" id="orderDetailModal" tabindex="-1" role="dialog" aria-hidden="true">
    <!-- Modal content would go here -->
</div>

<!-- Create Order Modal -->
<div class="modal fade" id="createOrderModal" tabindex="-1" role="dialog" aria-hidden="true">
    <!-- Modal content would go here -->
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#customOrdersTable').DataTable({
            responsive: true,
            columnDefs: [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: 1 },
                { responsivePriority: 3, targets: -1 }
            ]
        });

        // Lightbox initialization
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true,
            'showImageNumberLabel': false
        });
    });
</script>
@endpush

@endsection