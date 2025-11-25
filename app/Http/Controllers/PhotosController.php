<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Photo;

class PhotosController extends Controller
{
    /**
     * Show the form to upload photos with product details.
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Handle the storing of product and 5 photos.
     */
    public function store(Request $request)
    {
        // Validate product and photos
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'quantity' => 'required|integer',
            'warranty' => 'nullable|string|max:255',
            'return_policy' => 'nullable|string|max:255',
            'delivery_mode' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'display_order' => 'required|integer',
            'photos' => 'required|array|size:5',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Store Product
        $product = Product::create([
            'name' => $request->name,
            'brand' => $request->brand,
            'quantity' => $request->quantity,
            'warranty' => $request->warranty,
            'return_policy' => $request->return_policy,
            'delivery_mode' => $request->delivery_mode,
            'status' => $request->status,
            'display_order' => $request->display_order,
        ]);

        // Store Photos
        foreach ($request->file('photos') as $index => $photo) {
            $path = $photo->store('products', 'public');

            Photo::create([
                'product_id' => $product->id,
                'photo_path' => $path,
                'is_primary' => $index === 0, // First photo is primary
            ]);
        }

        return redirect()->route('photos.create')->with('success', 'Product and 5 photos uploaded successfully!');
    }
}
