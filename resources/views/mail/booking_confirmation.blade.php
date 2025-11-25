<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h3 {
            color: #333;
            text-align: center;
        }
        .table {
            width: 100%;
            margin-bottom: 20px;
        }
        .table td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        .table .label {
            font-weight: bold;
            color: #333;
        }
        .table .value {
            color: #555;
        }
        .additional-info {
            list-style-type: none;
            padding-left: 0;
        }
        .additional-info li {
            padding: 5px 0;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            margin-top: 20px;
        }
        .footer a {
            color: #007BFF;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="container">
    <h3>Booking Confirmation</h3>
    
    <table class="table">
        <tr>
            <td class="label">Booking Id</td>
            <td class="value">{{ $summaryData->booking_id ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="label">Pickup Date:</td>
            <td class="value">{{ $summaryData->pickup_date ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="label">Pickup Time:</td>
            <td class="value">{{ $summaryData->pickup_time ?? 'N/A' }}</td>
        </tr>
        @if($summaryData->trip_type == 'roundTrip' && !empty($summaryData->return_date))
        <tr>
            <td class="label">Return Date:</td>
            <td class="value">{{ $summaryData->return_date ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="label">Return Time:</td>
            <td class="value">{{ $summaryData->return_time ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="label">Total days:</td>
            <td class="value">{{ $summaryData->numberOfDays ?? 'N/A' }}</td>
        </tr>
       @endif
        <tr>
            <td class="label">Customer Name:</td>
            <td class="value">{{ $summaryData->customer_name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="label">Mobile:</td>
            <td class="value">{{ $summaryData->mobile ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="label">Trip Type:</td>
            <td class="value">{{ $summaryData->trip_type ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="label">From:</td>
            <td class="value">{{ $summaryData->pickupLocation ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="label">To:</td>
            <td class="value">{{ $summaryData->dropLocation ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="label">Distance:</td>
            <td class="value">{{ $summaryData->distance ?? 'N/A' }} km</td>
        </tr>
        <!--<tr>-->
        <!--    <td class="label">Duration:</td>-->
        <!--    <td class="value">{{ $summaryData->duration ?? 'N/A' }}</td>-->
        <!--</tr>-->
        <tr>
            <td class="label">Model Type:</td>
            <td class="value">{{ $summaryData->model_type ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="label">Base Fare [{{ $summaryData->base_klm }} km]:</td>
            <td class="value">₹{{ $summaryData->base_fare ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="label">Driver Allowance:</td>
            <td class="value">₹{{ $summaryData->driver_allowance ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="label">Additional Fare [{{ $summaryData->add_klm }} km]:</td>
            <td class="value">₹{{ $summaryData->add_fare ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="label">Total Fare:</td>
            <td class="value">₹{{ $summaryData->total_fare ?? 'N/A' }}</td>
        </tr>
    </table>

    <p><strong>Additional Info:</strong></p>
    <ul class="additional-info">
        @foreach(explode('*', $summaryData->additional_info) as $info)
            <li>{{ trim($info) }}</li>
        @endforeach
    </ul>

    <div class="footer">
        <p>Thank you for booking with us!</p>
        <p>If you have any questions, feel free to <a href="helloprimecabs@gmail.com">contact our support team</a>.</p>
    </div>
</div>

</body>
</html>
