@extends('layouts.home')
@section('content')

    <style>
        .account-wishlist a {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: #333;
            border-radius: 5px;
            transition: all 0.3s;
        }

        .account-wishlist li {
            list-style: none;
        }

        .account-wishlist a.active {
            background-color: #031B4E;
            color: #fff;
        }

        .account-wishlist a:hover {
            background-color: #f8f9fa;
        }

        .alert {
            margin-top: 15px;
        }
    </style>

    <!-- START SECTION BREADCRUMB -->
    <div class="bg-white page-title-mini py-3">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12">
                    <ol class="breadcrumb justify-content-md-end">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">My Account</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- END SECTION BREADCRUMB -->

    <!-- START MAIN CONTENT -->
    <div class="main_content">
        <div class="custom-container1">
            <div class="account-container">
                <div class="row">
                    <div class="col-lg-3 col-md-12 col-sm-12">
                        <!-- Sidebar -->
                        <div class="account-sidebar">
                            <div class="user-info">
                                <div class="user-avatar">{{ $initials ?? 'JD' }}</div>
                                <div class="user-name">{{ $user->name ?? 'John Doe' }}</div>
                                <div class="user-email">{{ $user->email ?? 'john.doe@example.com' }}</div>
                            </div>
                            <ul class="account-sidebar-menu">
                                <li><a href="#" class="active" data-section="orders">Orders</a></li>
                                <li><a href="#" data-section="profile">Profile</a></li>
                                <li><a href="#" data-section="addresses">Addresses</a></li>
                            </ul>
                            <div>
                                <ul class="account-wishlist">
                                    <li><a href="{{ route('wishlist') }}">Wishlist</a></li>
                                    <li>
                                        <a href="{{ route('logout.user') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-9 col-md-12 col-sm-12">
                        <!-- Main Content Area -->
                        <div class="account-content">
                            <!-- Success/Error Alert -->
                            <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;"
                                id="success-message">
                                <span></span>
                                <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
                            </div>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;"
                                id="error-message">
                                <span></span>
                                <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
                            </div>

                            <!-- Orders Section -->
                    products details 
                            <!-- END Orders Section -->
                            <style>
                                .order-products-wrap {
                                    display: flex;
                                    gap: 6px;
                                    flex-wrap: wrap;
                                }
                                .order-product-thumb {
                                    display: inline-block;
                                    vertical-align: middle;
                                }
                            </style>

                            <!-- Profile Section (Hidden by default) -->
                            <div id="profile">
                                <h2 class="section-title">Profile Information</h2>
                                @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                @if($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form method="POST" action="{{ route('user.update') }}" class="profile-form">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email Address</label>
                                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Phone Number</label>
                                        <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                                    </div>
                                    <div class="form-group full-width">
                                        <button type="submit" class="save-btn">Save Changes</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Addresses Section (Hidden by default) -->
                            <div id="addresses">
                                <h2 class="section-title">My Addresses</h2>
                                <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addAddressModal">Add
                                    New Address</button>
                                <div class="addresses-grid" id="addressesGrid">
                                    @foreach($addresses as $address)
                                        <div class="address-card" id="address-{{ $address->id }}">
                                            <span class="address-type">{{ $address->type ?? 'Home' }}</span>
                                            <div class="address-name">{{ $address->name }}</div>
                                            <div class="address-details">
                                                {{ $address->address }}<br>
                                                {{ $address->city }}, {{ $address->state }} - {{ $address->pincode }}<br>
                                                Phone: {{ $address->phone }}
                                            </div>
                                            <div class="address-actions">
                                                <a href="#" class="address-btn edit-btn" data-toggle="modal"
                                                    data-target="#editAddressModal{{ $address->id }}">Edit</a>
                                                <form method="POST" action="{{ route('address.delete', $address->id) }}"
                                                    class="d-inline" style="display:inline;">
                                                    @csrf
                                                    @method('POST')
                                                    <a href="#" class="address-btn delete-btn"
                                                        onclick="event.preventDefault(); if(confirm('Delete this address?')) { this.closest('form').submit(); }">
                                                        Delete
                                                    </a>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                @foreach($addresses as $address)
                                    <div class="modal fade" id="editAddressModal{{ $address->id }}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <form method="POST" action="{{ route('address.update', $address->id) }}">
                                                @csrf
                                                @method('POST')
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Address</h5>
                                                        <button type="button" class="close"
                                                            data-dismiss="modal"><span>×</span></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label>Name</label>
                                                            <input type="text" name="name" value="{{ $address->name ?? '' }}"
                                                                class="form-control" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Phone</label>
                                                            <input type="text" name="phone" value="{{ $address->phone ?? '' }}"
                                                                class="form-control" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Address</label>
                                                            <textarea name="address" class="form-control"
                                                                required>{{ $address->address ?? '' }}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Type</label>
                                                            <select name="type" class="form-control" required>
                                                                <option value="">Select Type</option>
                                                                <option value="Home" {{ $address->type == 'Home' ? 'selected' : '' }}>Home</option>
                                                                <option value="Office" {{ $address->type == 'Office' ? 'selected' : '' }}>Office</option>
                                                                <option value="Other" {{ $address->type == 'Other' ? 'selected' : '' }}>Other</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>City</label>
                                                            <input type="text" name="city" value="{{ $address->city ?? '' }}"
                                                                class="form-control" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>State</label>
                                                            <input type="text" name="state" value="{{ $address->state ?? '' }}"
                                                                class="form-control" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Pincode</label>
                                                            <input type="text" name="pincode"
                                                                value="{{ $address->pincode ?? '' }}" class="form-control"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Cancel</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="modal fade" id="addAddressModal" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <form method="POST" action="{{ route('address.store') }}">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Add Address</h5>
                                                    <button type="button" class="close"
                                                        data-dismiss="modal"><span>×</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Name</label>
                                                        <input type="text" name="name" value="{{ old('name') }}"
                                                            class="form-control" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Phone</label>
                                                        <input type="text" name="phone" value="{{ old('phone') }}"
                                                            class="form-control" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Address</label>
                                                        <textarea name="address" class="form-control"
                                                            required>{{ old('address') }}</textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Type</label>
                                                        <select name="type" class="form-control" required>
                                                            <option value="">Select Type</option>
                                                            <option value="Home">Home</option>
                                                            <option value="Office">Office</option>
                                                            <option value="Other">Other</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>City</label>
                                                        <input type="text" name="city" value="{{ old('city') }}"
                                                            class="form-control" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>State</label>
                                                        <input type="text" name="state" value="{{ old('state') }}"
                                                            class="form-control" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Pincode</label>
                                                        <input type="text" name="pincode" value="{{ old('pincode') }}"
                                                            class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Cancel</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div id="wishlist">
                                <table class="table table-responsive account-wishlist">
                                    <thead>
                                        <tr>
                                            <th class="product-thumbnail"> </th>
                                            <th class="product-name">Product</th>
                                            <th class="product-price">Price</th>
                                            <th class="product-stock-status">Stock Status</th>
                                            <th class="product-add-to-cart"></th>
                                            <th class="product-remove">Remove</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="product-thumbnail"><a href="#"><img src="assets/images/toy-1.jpg"
                                                        alt="product1"></a></td>
                                            <td class="product-name" data-title="Product"><a href="#">Blue Dress For
                                                    Woman</a></td>
                                            <td class="product-price" data-title="Price">₹45.00</td>
                                            <td class="product-stock-status" data-title="Stock Status"><span
                                                    class="badge rounded-pill text-bg-success">In Stock</span></td>
                                            <td class="product-add-to-cart"><a href="#" class="btn btn-fill-out"><i
                                                        class="fa-solid fa-cart-shopping"></i> Add to Cart</a></td>
                                            <td class="product-remove" data-title="Remove"><a href="#"
                                                    class="remove-icon d-none d-md-inline"><i
                                                        class="fa-solid fa-xmark"></i></a>
                                                <a href="#"
                                                    class="remove-text d-inline d-md-none btn btn-danger btn-sm">Remove</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="product-thumbnail"><a href="#"><img src="assets/images/toy-2.jpg"
                                                        alt="product2"></a></td>
                                            <td class="product-name" data-title="Product"><a href="#">Lether Gray Tuxedo</a>
                                            </td>
                                            <td class="product-price" data-title="Price">₹55.00</td>
                                            <td class="product-stock-status" data-title="Stock Status"><span
                                                    class="badge rounded-pill text-bg-danger">No Stack</span></td>
                                            <td class="product-add-to-cart"><a href="#" class="btn btn-fill-out"><i
                                                        class="fa-solid fa-cart-shopping"></i> Add to Cart</a></td>
                                            <td class="product-remove" data-title="Remove"><a href="#"
                                                    class="remove-icon d-none d-md-inline"><i
                                                        class="fa-solid fa-xmark"></i></a>
                                                <a href="#"
                                                    class="remove-text d-inline d-md-none btn btn-danger btn-sm">Remove</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="product-thumbnail"><a href="#"><img src="assets/images/toy-3.jpg"
                                                        alt="product3"></a></td>
                                            <td class="product-name" data-title="Product"><a href="#">woman full sliv
                                                    dress</a></td>
                                            <td class="product-price" data-title="Price">₹68.00</td>
                                            <td class="product-stock-status" data-title="Stock Status"><span
                                                    class="badge rounded-pill text-bg-success">In Stock</span></td>
                                            <td class="product-add-to-cart"><a href="#" class="btn btn-fill-out"><i
                                                        class="fa-solid fa-cart-shopping"></i> Add to Cart</a></td>
                                            <td class="product-remove" data-title="Remove"><a href="#"
                                                    class="remove-icon d-none d-md-inline"><i
                                                        class="fa-solid fa-xmark"></i></a>
                                                <a href="#"
                                                    class="remove-text d-inline d-md-none btn btn-danger btn-sm">Remove</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="product-thumbnail"><a href="#"><img src="assets/images/toy-4.jpg"
                                                        alt="product3"></a></td>
                                            <td class="product-name" data-title="Product"><a href="#">woman full sliv
                                                    dress</a></td>
                                            <td class="product-price" data-title="Price">₹68.00</td>
                                            <td class="product-stock-status" data-title="Stock Status"><span
                                                    class="badge rounded-pill text-bg-success">In Stock</span></td>
                                            <td class="product-add-to-cart"><a href="#" class="btn btn-fill-out"><i
                                                        class="fa-solid fa-cart-shopping"></i> Add to Cart</a></td>
                                            <td class="product-remove" data-title="Remove"><a href="#"
                                                    class="remove-icon d-none d-md-inline"><i
                                                        class="fa-solid fa-xmark"></i></a>
                                                <a href="#"
                                                    class="remove-text d-inline d-md-none btn btn-danger btn-sm">Remove</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="product-thumbnail"><a href="#"><img src="assets/images/toy-5.jpg"
                                                        alt="product3"></a></td>
                                            <td class="product-name" data-title="Product"><a href="#">woman full sliv
                                                    dress</a></td>
                                            <td class="product-price" data-title="Price">₹68.00</td>
                                            <td class="product-stock-status" data-title="Stock Status"><span
                                                    class="badge rounded-pill text-bg-success">In Stock</span></td>
                                            <td class="product-add-to-cart"><a href="#" class="btn btn-fill-out"><i
                                                        class="fa-solid fa-cart-shopping"></i> Add to Cart</a></td>
                                            <td class="product-remove" data-title="Remove"><a href="#"
                                                    class="remove-icon d-none d-md-inline"><i
                                                        class="fa-solid fa-xmark"></i></a>
                                                <a href="#"
                                                    class="remove-text d-inline d-md-none btn btn-danger btn-sm">Remove</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT -->

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.cancel-order-form').on('submit', function (e) {
                e.preventDefault();
                var form = $(this);
                var orderId = form.data('order-id');
                var url = '{{ route("order.cancel", ":order_id") }}'.replace(':order_id', orderId);
                var errorMessage = form.find('.error-message');
                var successAlert = $('#success-message');
                var errorAlert = $('#error-message');

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: form.serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.success) {
                            // Update the order status in the UI
                            var orderRow = $('tr[data-order-id="' + orderId + '"]');
                            orderRow.find('.order-status')
                                .removeClass('status-processing')
                                .addClass('status-cancelled')
                                .text('Cancelled');
                            // Remove the cancel button
                            orderRow.find('.cancel-btn').remove();
                            // Close the modal
                            $('#cancelOrderModal' + orderId).modal('hide');
                            // Show success message
                            successAlert.find('span').text(response.message);
                            successAlert.show();
                            setTimeout(() => successAlert.fadeOut(), 3000);
                        } else {
                            errorMessage.text(response.error).show();
                        }
                    },
                    error: function (xhr) {
                        var error = xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error : 'An error occurred';
                        errorMessage.text(error).show();
                        errorAlert.find('span').text(error);
                        errorAlert.show();
                        setTimeout(() => errorAlert.fadeOut(), 3000);
                        console.error('Cancellation error:', xhr.responseText);
                    }
                });
            });

            // Hide alerts when closed
            $('.alert .close').on('click', function () {
                $(this).parent().hide();
            });
        });
    </script>

@endsection