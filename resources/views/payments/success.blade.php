<!DOCTYPE html>
<html>
<head>
    <title>Payment Success</title>
    <style>
        .container { text-align: center; margin-top: 50px; font-family: Arial, sans-serif; }
        .success { color: #155724; background-color: #d4edda; padding: 15px; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="success">
            <h2>Payment Successful!</h2>
            <p>Your payment has been processed successfully.</p>
            <a href="{{ route('home') }}">Return to Home</a>
        </div>
    </div>
</body>
</html>