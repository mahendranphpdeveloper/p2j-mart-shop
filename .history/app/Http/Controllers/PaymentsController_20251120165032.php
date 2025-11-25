<?php

namespace App\Http\Controllers;

use App\Models\StockReservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Helpers\Ccavenue;
use App\Models\Productunit;
use App\Models\UserOrder;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function initiate(Request $request)
    {
        try {
            $validated = $this->validatePaymentRequest($request);
            $user = Auth::user();
            $order = $this->validateOrder($validated['order_id'], $user);
            $config = $this->getValidatedConfig();
            $merchantData = $this->prepareMerchantData($order, $user, $config);
            $queryString = http_build_query($merchantData);
            $workingKey = $this->getWorkingKey($config);
            $encryptedData = Ccavenue::encrypt($queryString, $config['working_key']);

            // Validate encrypted data format
            if (!preg_match('/^[0-9A-Fa-f]+$/', $encryptedData)) {
                throw new \Exception('Invalid encrypted data format');
            }

            $ccavenueUrl = $config['urls'][$config['mode']]['transaction'];

            $viewData = [
                'ccavenueUrl' => $ccavenueUrl,
                'encryptedData' => $encryptedData,
                'accessCode' => $config['access_code'],
                'order_id' => $validated['order_id']
            ];

            Log::debug('Payment initiated', [
                'order_id' => $validated['order_id'],
                'amount' => $validated['amount'],
                'ccavenue_url' => $ccavenueUrl,
                'merchant_data' => $merchantData,
                'query_string_length' => strlen($queryString),
                'encrypted_data_length' => strlen($encryptedData),
                'access_code' => substr($config['access_code'], 0, 4) . '...',
                'view_data' => $viewData
            ]);

            return view('payments.ccavenue', $viewData);
        } catch (\Exception $e) {
            Log::error('Payment initiation failed', [
                'error' => $e->getMessage(),
                'input' => $request->all()
            ]);
            return redirect()->back()->with('error', 'Payment processing error: ' . $e->getMessage());
        }
    }

    protected function getValidatedConfig(): array
    {
        $mode = env('CCAVENUE_MODE', 'test');
        if (!in_array($mode, ['test', 'live'])) {
            throw new \RuntimeException('Invalid CCAvenue mode: ' . $mode);
        }

        $isTest = $mode === 'test';
        $prefix = $isTest ? 'test_' : '';
        $requiredKeys = ['merchant_id', 'access_code', 'working_key', 'redirect_url', 'cancel_url'];
        $config = [];

        foreach ($requiredKeys as $key) {
            $configKey = "{$prefix}{$key}";
            $value = config("ccavenue.{$configKey}") ?? env("CCAVENUE_" . strtoupper($configKey));
            if (empty($value)) {
                throw new \RuntimeException("Missing payment config: {$configKey}");
            }
            $config[$key] = $value;
            Log::debug("Config value: {$configKey}", [
                'source' => config("ccavenue.{$configKey}") ? 'config' : 'env',
                'value' => in_array($key, ['access_code', 'working_key']) ? 'masked' : $value
            ]);
        }

        $config['mode'] = $mode;
        $urls = config('ccavenue.urls', [
            'test' => ['transaction' => 'https://test.ccavenue.com/transaction/transaction.do?command=initiateTransaction'],
            'live' => ['transaction' => 'https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction']
        ]);
        if (!isset($urls[$mode]['transaction'])) {
            throw new \RuntimeException("Invalid CCAvenue URLs for mode: {$mode}");
        }
        $config['urls'] = $urls;

        return $config;
    }

    protected function getWorkingKey(array $config): string
    {
        return $config['working_key'];
    }

    protected function prepareMerchantData(UserOrder $order, $user, array $config): array
    {
        $amount = number_format((float)($order->total_amount ?? 0) + (float)($order->shipping_cost ?? 0), 2, '.', '');

        if ($amount <= 0) {
            throw new \Exception('Invalid order amount');
        }

        $address = $order->address;

        return [
            'merchant_id' => $config['merchant_id'],
            'order_id' => strtoupper($order->transaction_id ?? 'ORDER_' . time()),
            'amount' => $amount,
            'currency' => 'INR',
            'redirect_url' => $config['redirect_url'],
            'cancel_url' => $config['cancel_url'],
            'language' => 'EN',
            'billing_name' => $user->name ?? 'Guest',
            'billing_email' => $user->email ?? '',
            'billing_tel' => $user->phone ?? '',
            'billing_address' => $address->address ?? '',
            'billing_city' => $address->city ?? '',
            'billing_state' => $address->state ?? '',
            'billing_zip' => $address->pincode ?? '',
            'billing_country' => 'India',
            'delivery_name' => $user->name ?? 'Guest',
            'delivery_address' => $address->address_line1 ?? '',
            'delivery_city' => $address->city ?? '',
            'delivery_state' => $address->state ?? '',
            'delivery_zip' => $address->pincode ?? '',
            'delivery_country' => 'India',
            'merchant_param1' => (string)($user->id ?? ''),
            'merchant_param2' => 'p2jmart',
            'merchant_param3' => (string)($order->order_id ?? ''),
            'merchant_param4' => '',
            'merchant_param5' => '',
            'promo_code' => '',
            'customer_identifier' => $user->email ?? '',
            'tid' => uniqid()
        ];
    }

    protected function validatePaymentRequest(Request $request): array
    {
        if ($request->has('order_id')) {
            $request->merge(['order_id' => strtoupper($request->input('order_id'))]);
        }

        return $request->validate([
            'order_id' => ['required', 'string', 'max:100', 'regex:/^[A-Z0-9_-]+$/'],
            'amount' => ['required', 'numeric', 'min:1', 'max:999999']
        ], [
            'order_id.regex' => 'Order ID contains invalid characters'
        ]);
    }

    protected function validateOrder(string $orderId, $user): UserOrder
    {
        $order = UserOrder::where('transaction_id', $orderId)
            ->where('user_id', $user->id)
            ->first() ?? throw new \Exception('Order not found');

        if (!$order->address) {
            throw new \Exception('Shipping address missing');
        }

        if (!$order->isPayable()) {
            throw new \Exception('Order not payable: ' . $order->order_status);
        }

        return $order;
    }

    public function response(Request $request)
    {
        try {
            $config = $this->getValidatedConfig();
            $encResponse = $request->input('encResp') ?? throw new \Exception('Missing encrypted response');
            $decryptedResponse = Ccavenue::decrypt($encResponse, $config['working_key']);
            parse_str($decryptedResponse, $responseData);

            Log::info('CCAvenue response', ['order_id' => $responseData['order_id'] ?? 'N/A', 'status' => $responseData['order_status'] ?? 'unknown']);

            return $this->processPaymentResponse($responseData);
        } catch (\Exception $e) {
            Log::error('Response processing failed', ['error' => $e->getMessage()]);
            return redirect()->route('payment.failed')->with('error', 'Payment verification failed');
        }
    }

    public function cancel(Request $request)
    {

        $orderNo = $request->input('orderNo');
        Log::info('Payment cancellation requested', ['order_no' => $orderNo, 'user_id' => auth()->id()]);

        $order = UserOrder::where('transaction_id', $orderNo)
            ->where('user_id', auth()->id())
            ->first();

        if (!$order) {          
            return redirect()->route('checkout')->with('warning', 'Order not found.');
        }


        $expiredReservations = StockReservation::where('status', 'reserved')
            ->where('order_id', $orderNo)
            ->get();

            foreach ($expiredReservations as $reservation) {            // Update reservation status to released
                $reservation->status = 'released';
                $reservation->save();

                if ($reservation->product_unit_id && $reservation->qty > 0) {
                    $productUnit = Productunit::where('product_unit_id', $reservation->product_unit_id)->first();
                    if ($productUnit) {
                        $productUnit->increment('stock', $reservation->qty);
                    
                    } else {
                
                    }
                }
            }

        // Update order status
        $order->cancel('Payment cancelled via CCAvenue');

        Log::info('Order cancelled', ['order_id' => $order->order_id, 'order_no' => $orderNo]);

        return redirect()->route('checkout')->with('warning', 'Payment was cancelled. Your order has been cancelled and stock has been released where applicable.');
    }


    protected function processPaymentResponse(array $responseData)
    {
        $orderId = $responseData['order_id'] ?? throw new \Exception('Missing order_id');
        $status = $responseData['order_status'] ?? 'unknown';

        $order = UserOrder::where('transaction_id', $orderId)
            ->where('user_id', Auth::id())
            ->first() ?? throw new \Exception('Order not found');

        if ($status === 'Success') {

            $expiredReservations = StockReservation::where('status', 'reserved')
                ->where('order_id', $orderId)
                ->get();

            foreach ($expiredReservations as $reservation) {
                $reservation->status = 'confirmed';
                $reservation->save();
            }
            $order->markAsPaid();
            $order->update(['transaction_id' => $responseData['tracking_id'] ?? $orderId]);
            return redirect()->route('payment.success')->with('success', 'Payment successful');
        }

        Log::error('Payment failed or was not successful', [
            'order_id' => $orderId,
            'status' => $status,
            'response_data' => $responseData
        ]);

        $paymentStatus = $status === 'Aborted' ? 'cancelled' : 'failed';
        $order->update(['payment_status' => $paymentStatus]);

        // Restore stock for all items on failure or abort
        foreach ($order->items as $item) {
            if ($item->product_unit_id && $item->quantity > 0) {
                $productUnit = Productunit::where('product_unit_id', $item->product_unit_id)->first();
                if ($productUnit) {
                    $productUnit->increment('stock', $item->quantity);
                    Log::info('Restored product unit stock after payment failure/abort', [
                        'product_unit_id' => $item->product_unit_id,
                        'quantity_restored' => $item->quantity,
                        'order_id' => $orderId,
                        'new_stock' => $productUnit->fresh()->stock,
                    ]);
                } else {
                    Log::warning('Attempted to restore stock for missing product unit', [
                        'product_unit_id' => $item->product_unit_id,
                        'order_id' => $orderId,
                    ]);
                }
            }
        }

        return redirect()->route('payment.failed')->with('error', 'Payment failed or aborted');
    }

    public function success()
    {
        return view('payments.success');
    }

    public function failed()
    {
        return view('payments.failed');
    }
}
