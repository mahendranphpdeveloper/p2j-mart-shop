<?php

namespace App\Services;

use App\Models\State;
use App\Models\Product;
use App\Models\Address;
use Illuminate\Support\Facades\Log;

class ShippingService
{
    public function calculateShippingCost($productId, $quantity, $addressId)
    {
        Log::info("calculateShippingCost START", [
            'product_id' => $productId,
            'quantity' => $quantity,
            'address_id' => $addressId,
        ]);

        try {
            $address = Address::findOrFail($addressId);
            Log::info("Address found", ['address' => $address]);

            $state = State::where('name', $address->state)->firstOrFail();
            Log::info("State found", ['state' => $state]);

            $product = Product::where('product_id', $productId)
                ->where('is_deleted', 0)
                ->firstOrFail();
            Log::info("Product found", ['product' => $product]);

            if (!is_numeric($product->weight)) {
                Log::error("Weight is not numeric or missing", ['weight' => $product->weight]);
                throw new \Exception("Weight not set for product.");
            }

            $totalWeight = (float) $product->weight * $quantity;
            Log::info("Total weight calculated", ['totalWeight' => $totalWeight]);

            if ($totalWeight <= $state->base_weight) {
                Log::info("Weight within base limit", ['base_cost' => $state->base_cost]);
                return $state->base_cost;
            }

            $additionalWeight = $totalWeight - $state->base_weight;
            $additionalUnits = ceil($additionalWeight / $state->additional_weight_unit);
            $additionalCost = $additionalUnits * $state->additional_cost_per_unit;

            Log::info("Additional shipping calculated", [
                'additionalWeight' => $additionalWeight,
                'additionalUnits' => $additionalUnits,
                'additionalCost' => $additionalCost,
                'totalCost' => $state->base_cost + $additionalCost,
            ]);

            return $state->base_cost + $additionalCost;

        } catch (\Exception $e) {
            Log::error("Shipping calculation failed: " . $e->getMessage(), [
                'exception' => $e
            ]);
            return 0;
        }
    }

    public function calculateCartShippingCost($cartItems, $addressId)
    {
        Log::info("calculateCartShippingCost START", [
            'cartItems' => $cartItems,
            'address_id' => $addressId,
        ]);

        try {
            $address = Address::findOrFail($addressId);
            Log::info("Address found", ['address' => $address]);

            $state = State::where('name', $address->state)->firstOrFail();
            Log::info("State found", ['state' => $state]);

            $totalWeight = 0;

            foreach ($cartItems as $item) {
                Log::info("Processing cart item", ['item' => $item]);

                $product = Product::where('product_id', $item->product_id)
                    ->where('is_deleted', 0)
                    ->first();

                if ($product && is_numeric($product->weight)) {
                    $weightToAdd = (float) $product->weight * $item->quantity;
                    $totalWeight += $weightToAdd;
                    Log::info("Product weight added", [
                        'product_id' => $product->product_id,
                        'weight' => $product->weight,
                        'quantity' => $item->quantity,
                        'weightToAdd' => $weightToAdd,
                        'runningTotalWeight' => $totalWeight
                    ]);
                } else {
                    Log::warning("Invalid product or missing weight", ['product' => $product]);
                }
            }

            if ($totalWeight <= $state->base_weight) {
                Log::info("Total cart weight within base limit", ['base_cost' => $state->base_cost]);
                return $state->base_cost;
            }

            $additionalWeight = $totalWeight - $state->base_weight;
            $additionalUnits = ceil($additionalWeight / $state->additional_weight_unit);
            $additionalCost = $additionalUnits * $state->additional_cost_per_unit;

            Log::info("Additional cart shipping calculated", [
                'additionalWeight' => $additionalWeight,
                'additionalUnits' => $additionalUnits,
                'additionalCost' => $additionalCost,
                'totalCost' => $state->base_cost + $additionalCost,
            ]);

            return $state->base_cost + $additionalCost;

        } catch (\Exception $e) {
            Log::error("Cart shipping calculation failed: " . $e->getMessage(), [
                'exception' => $e
            ]);
            return 0;
        }
    }
}
