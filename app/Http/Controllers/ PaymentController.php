<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Ccavenue;

class PaymentController extends Controller
{
   public function initiate(Request $request)
{
    
      dd($request->all());
    $workingKey = config('ccavenue.working_key');
    $accessCode = config('ccavenue.access_code');
    
    // Prepare merchant data
    $merchantData = [
        'tid' => uniqid(),
        'merchant_id' => config('ccavenue.merchant_id'),
        'order_id' => $request->input('order_id', 'ORDER_'.time()),
        'amount' => number_format($request->amount, 2, '.', ''),
        'currency' => 'INR',
        'redirect_url' => route('payment.response'),
        'cancel_url' => route('payment.cancel'),
        'language' => 'EN',
        // Add other required parameters
    ];

    // Convert to query string
    $queryString = http_build_query($merchantData);
    
    // Encrypt the data
    $encryptedData = Ccavenue::encrypt($queryString, $workingKey);
    
    // Generate payment URL
    $paymentUrl = (config('ccavenue.mode') === 'test' 
        ? 'https://test.ccavenue.com' 
        : 'https://secure.ccavenue.com') . 
        '/transaction/transaction.do?command=initiateTransaction&encRequest=' . 
        $encryptedData . '&access_code=' . $accessCode;

   return view('payments.ccavenue', [
    'paymentUrl' => $paymentUrl,
    'order_id' => $merchantData['order_id'],
    'debug_data' => $merchantData // for testing
]);
}

    public function response(Request $request)
    {
        $workingKey = config('ccavenue.working_key');
        $encResponse = $request->encResp;
        $decryptedResponse = Ccavenue::decrypt($encResponse, $workingKey);
        
        return view('payments.response', compact('decryptedResponse'));
    }
}