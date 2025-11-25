<?php

namespace App\Console\Commands;

use App\Models\Orders;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\Productunit;
use App\Models\StockReservation;
use App\Models\UserOrder;

class ReleaseExpiredStock extends Command
{
    protected $signature = 'stock:release';
    protected $description = 'Release reserved stock for expired reservations';

    public function handle()
    {
        Log::info("Release expired reserved stock back to products");

        // Using Eloquent and the StockReservation model
        $expiredReservations = StockReservation::where('status', 'reserved')
            ->where('expires_at', '<', now())
            ->get();


            Log::info(now());
            
            Log::info('Processing expired stock reservations', ['count' => $expiredReservations->count()]);
            
            foreach ($expiredReservations as $reservation) {
                // Update reservation status to released
                Log::info($reservation->expires_at );


            $reservation->status = 'released';
            $reservation->save();

            if ($reservation->product_unit_id && $reservation->qty > 0) {
                $productUnit = Productunit::where('product_unit_id', $reservation->product_unit_id)->first();
                $order = UserOrder::where('transaction_id', $reservation->order_id)->first();
                if ($order) {
                    $order->payment_status = 'pending';
                    $order->save();
                }

                if ($productUnit) {
                    $productUnit->increment('stock', $reservation->qty);
               
                } else {
                    Log::warning('Product unit not found to restore stock', [
                        'product_unit_id' => $reservation->product_unit_id,
                        'reservation_id' => $reservation->id
                    ]);
                }
            }
        }

        $this->info('Expired reserved stock released and restored successfully.');
        return Command::SUCCESS;
    }
}