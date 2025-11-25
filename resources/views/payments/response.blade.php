<!DOCTYPE html>
<html>
<head>
    <title>Payment Response</title>
</head>
<body>
<center>
    @php
        $order_status = "";
        $decryptValues = explode('&', $decryptedResponse);
        $dataSize = sizeof($decryptValues);
    @endphp

    @foreach ($decryptValues as $value)
        @php
            $information = explode('=', $value);
            if ($loop->index == 3) $order_status = $information[1];
        @endphp
    @endforeach

    @if($order_status === "Success")
        <p>Thank you for shopping with us. Your transaction is successful.</p>
    @elseif($order_status === "Aborted")
        <p>Thank you for shopping with us. We will keep you posted regarding your order.</p>
    @elseif($order_status === "Failure")
        <p>Thank you for shopping with us. However, the transaction has been declined.</p>
    @else
        <p>Security Error. Illegal access detected</p>
    @endif

    <table cellspacing="4" cellpadding="4">
        @foreach ($decryptValues as $value)
            @php $information = explode('=', $value); @endphp
            <tr><td>{{ $information[0] }}</td><td>{{ $information[1] }}</td></tr>
        @endforeach
    </table>
</center>
</body>
</html>