<?php

namespace App\Http\Controllers;

use App\Models\Price;
use App\Models\Product;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    /**
     * Store a newly created price in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'new_price' => 'required|numeric',
            'old_price' => 'nullable|numeric',
            'discount'  => 'nullable|numeric',
        ]);

        Price::create($validated);

        return redirect()->back()->with('success', 'Price added successfully.');
    }

    /**
     * Show the form for editing the price.
     */
    public function edit(Price $price)
    {
        return view('prices.edit', compact('price'));
    }

    /**
     * Update the specified price in storage.
     */
    public function update(Request $request, Price $price)
    {
        $validated = $request->validate([
            'new_price' => 'required|numeric',
            'old_price' => 'nullable|numeric',
            'discount'  => 'nullable|numeric',
        ]);

        $price->update($validated);

        return redirect()->back()->with('success', 'Price updated successfully.');
    }

    /**
     * Remove the specified price from storage.
     */
    public function destroy(Price $price)
    {
        $price->delete();

        return redirect()->back()->with('success', 'Price deleted successfully.');
    }
}
