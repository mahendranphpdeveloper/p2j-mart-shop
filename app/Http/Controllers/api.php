<?php

use Illuminate\Support\Facades\Route;

// GET all products - demo data
Route::get('/products', function () {
    $products = [
        [
            'id' => 1,
            'name' => 'iPhone 15',
            'description' => 'Latest Apple smartphone with A16 chip',
            'price' => 999.99,
        ],
        [
            'id' => 2,
            'name' => 'Samsung Galaxy S23',
            'description' => 'Flagship phone from Samsung',
            'price' => 899.99,
        ],
        [
            'id' => 3,
            'name' => 'OnePlus 11',
            'description' => 'High-performance phone with smooth UI',
            'price' => 749.99,
        ]
    ];

    return response()->json($products);
});
