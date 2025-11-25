<?php
// app/Services/CCAvenuePayment.php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CCAvenuePayment
{
    private $merchantId;
    private $accessCode;
    private $workingKey;
    private $redirectUrl;
    private $cancelUrl;
    private $ccavenueUrl;

    public function __construct()
    {
        $this->merchantId = config('ccavenue.merchant_id');
        $this->accessCode = config('ccavenue.access_code');
        $this->workingKey = config('ccavenue.working_key');
        
        $this->redirectUrl = route('payment.response');
        $this->cancelUrl = route('payment.cancel');
        
        $this->ccavenueUrl = config('ccavenue.mode') === 'live' 
            ? 'https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction'
            : 'https://test.ccavenue.com/transaction/transaction.do?command=initiateTransaction';
    }

    public function initiatePayment(array $orderData)
    {
        try {
            $merchantData = [
                'merchant_id' => $this->merchantId,
                'order_id' => $orderData['order_id'],
                'amount' => number_format($orderData['amount'], 2, '.', ''),
                'currency' => 'INR',
                'redirect_url' => $this->redirectUrl,
                'cancel_url' => $this->cancelUrl,
                'language' => 'EN',
                'billing_name' => $orderData['customer_name'],
                'billing_address' => $orderData['billing_address'],
                'billing_city' => $orderData['billing_city'],
                'billing_state' => $orderData['billing_state'],
                'billing_zip' => $orderData['billing_zip'],
                'billing_country' => 'India',
                'billing_tel' => $orderData['billing_tel'],
                'billing_email' => $orderData['billing_email'],
                'delivery_name' => $orderData['customer_name'],
                'delivery_address' => $orderData['shipping_address'],
                'delivery_city' => $orderData['shipping_city'],
                'delivery_state' => $orderData['shipping_state'],
                'delivery_zip' => $orderData['shipping_zip'],
                'delivery_country' => 'India',
                'delivery_tel' => $orderData['billing_tel'],
                'merchant_param1' => $orderData['user_id'],
                'merchant_param2' => $orderData['product_id'],
                'merchant_param3' => $orderData['checkout_type'],
            ];

            $encryptedData = $this->encryptData($merchantData);

            return [
                'success' => true,
                'payment_url' => $this->ccavenueUrl,
                'encrypted_data' => $encryptedData,
                'access_code' => $this->accessCode,
            ];
        } catch (\Exception $e) {
            Log::error('CCAvenue Payment Initiation Error: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Payment initiation failed'];
        }
    }

    public function handleResponse(array $response)
    {
        try {
            $decryptedResponse = $this->decryptData($response['encResp']);
            
            parse_str($decryptedResponse, $responseArray);
            
            if ($this->verifyChecksum($responseArray)) {
                return [
                    'success' => true,
                    'data' => $responseArray,
                ];
            }
            
            return ['success' => false, 'message' => 'Checksum verification failed'];
        } catch (\Exception $e) {
            Log::error('CCAvenue Response Handling Error: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Response processing failed'];
        }
    }

    private function encryptData(array $data)
    {
        $merchantData = '';
        foreach ($data as $key => $value) {
            $merchantData .= $key . '=' . $value . '&';
        }
        
        $merchantData = rtrim($merchantData, '&');
        
        $encryptedData = $this->encrypt($merchantData, $this->workingKey);
        
        return $encryptedData;
    }

    private function decryptData($encryptedData)
    {
        return $this->decrypt($encryptedData, $this->workingKey);
    }

    private function encrypt($plainText, $key)
    {
        $key = $this->hextobin(md5($key));
        $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
        $openMode = openssl_encrypt($plainText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
        $encryptedText = bin2hex($openMode);
        return $encryptedText;
    }

    private function decrypt($encryptedText, $key)
    {
        $key = $this->hextobin(md5($key));
        $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
        $encryptedText = $this->hextobin($encryptedText);
        $decryptedText = openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
        return $decryptedText;
    }

    private function hextobin($hexString)
    {
        $length = strlen($hexString);
        $binString = "";
        $count = 0;
        while ($count < $length) {
            $subString = substr($hexString, $count, 2);
            $packedString = pack("H*", $subString);
            if ($count == 0) {
                $binString = $packedString;
            } else {
                $binString .= $packedString;
            }
            $count += 2;
        }
        return $binString;
    }

    private function verifyChecksum($response)
    {
        $checksum = $response['checksum'];
        unset($response['checksum']);
        
        ksort($response);
        $merchantString = '';
        foreach ($response as $key => $value) {
            $merchantString .= $key . '=' . $value . '&';
        }
        $merchantString .= $this->workingKey;
        
        $generatedChecksum = md5($merchantString);
        
        return $generatedChecksum === $checksum;
    }
}