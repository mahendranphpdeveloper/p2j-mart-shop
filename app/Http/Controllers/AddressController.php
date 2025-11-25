<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AddressController extends Controller
{
    // In your AddressController
  public function store(Request $request)
{
    Log::info('AddressController: store method started');

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'address' => 'required|string',
        'city' => 'required|string|max:100',
        'pincode' => 'required|string|max:10',
        'state' => 'required|string|max:100',
    ]);

    Log::info('AddressController: Validation successful', ['validated_data' => $validated]);

    $user = Auth::user();

    Log::info('AddressController: Retrieved authenticated user', ['user' => $user]);

    $address = new Address(); // Instantiate the Address model here

    if ($user) {
        $address->user_id = $user->id;
        Log::info('AddressController: User ID set on address', ['user_id' => $user->id]);
    } else {
        Log::warning('AddressController: No authenticated user found, user_id not set');
    }

    $address->name = $validated['name'];
    Log::info('AddressController: Name set on address', ['name' => $address->name]);
    $address->phone = $validated['phone'];
    Log::info('AddressController: Phone set on address', ['phone' => $address->phone]);
    $address->address = $validated['address'];
    Log::info('AddressController: Address set on address', ['address' => $address->address]);
    $address->city = $validated['city'];
    Log::info('AddressController: City set on address', ['city' => $address->city]);
    $address->pincode = $validated['pincode'];
    Log::info('AddressController: Pincode set on address', ['pincode' => $address->pincode]);
    $address->state = $validated['state'];
    Log::info('AddressController: State set on address', ['state' => $address->state]);

    $address->save();

    Log::info('AddressController: Address saved to database', ['address_id' => $address->id]);

     return response()->json([
        'success' => true,
        'message' => 'Address saved successfully!',
        'address_id' => $address->id,
        'address' => $address
    ]);
}

    public function select(Request $request)
    {
        Log::info('AddressController: select method started');

        $request->validate([
            'selected_address' => 'required|exists:addresses,id'
        ]);

        Log::info('AddressController: Validation successful', ['selected_address_id' => $request->selected_address]);

        session(['selected_address_id' => $request->selected_address]);

        Log::info('AddressController: Selected address ID stored in session', ['selected_address_id' => session('selected_address_id')]);

        return redirect()->back()->with('success', 'Address selected.');
    }
}