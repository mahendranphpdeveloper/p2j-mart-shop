<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BasicController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'brand' => 'nullable|string',
            'quantity' => 'required|integer',
            'warranty' => 'nullable|string',
            'return_policy' => 'nullable|string',
            'delivery_mode' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'display_order' => 'required|integer',
        ]);

        DB::table('basic')->insert($validated);

        return response()->json(['message' => 'Saved successfully!']);
    }
}
