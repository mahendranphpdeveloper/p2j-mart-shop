<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Redirect</title>
    <style>
        .payment-container { text-align: center; margin-top: 50px; font-family: Arial, sans-serif; }
        .loader { border: 5px solid #f3f3f3; border-top: 5px solid #3498db; border-radius: 50%; width: 50px; height: 50px; animation: spin 2s linear infinite; margin: 20px auto; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    </style>
</head>
<body>
    <div class="payment-container">
        <h2>Processing Your Payment</h2>
        <p>Please wait while we redirect you to the secure payment gateway...</p>
        <div class="loader"></div>

    <form id="ccavenue_form" method="POST" action="{{ $ccavenueUrl }}">
    <input type="hidden" name="encRequest" value="{{ $encryptedData }}">
    <input type="hidden" name="access_code" value="{{ $accessCode }}">
    <noscript>
        <input type="submit" value="Click here to proceed to payment">
    </noscript>
</form>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('ccavenue_form').submit();
    });
</script>
    </div>
</body>
</html>