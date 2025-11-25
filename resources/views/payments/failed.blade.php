<!DOCTYPE html>
<html>
<head>
    <title>Payment Failed</title>
    <style>
        .container { text-align: center; margin-top: 50px; font-family: Arial, sans-serif; }
        .error { color: #721c24; background-color: #f8d7da; padding: 15px; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="error">
            <h2>Payment Failed</h2>
            <p>There was an issue processing your payment. Please try again or contact support.</p>
            <a href="{{ route('home') }}">Try Again</a>
        </div>
    </div>
</body>
</html>