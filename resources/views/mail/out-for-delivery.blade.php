<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Shipped</title>
</head>
<body>
    <h2>Your Order #{{ $order_id }} has been shipped!</h2>

    <p><strong>Tracking ID:</strong> {{ $tracking_id }}</p>
    <p><strong>Track here:</strong> <a href="{{ $tracking_link }}">{{ $tracking_link }}</a></p>

    <p>We hope you enjoy your purchase. Thank you for shopping with us!</p>
</body>
</html>
