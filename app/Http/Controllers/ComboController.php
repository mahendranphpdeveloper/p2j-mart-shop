<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Combo;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class ComboController extends Controller
{
    public function index()
    {
        $combos = Combo::get();
        return view('admin-coupons.combos', compact('combos'));
    }

    public function addCombo()
    {
        $categories = Category::with('subcategories.products')->get();
        return view('admin-coupons.add-combo', compact('categories'));
    }

    public function storeCombo(Request $request)
    {
        $productIds = is_array($request->product_ids) ? $request->product_ids[0] : $request->product_ids;
        
        $request->merge([
            'product_ids' => explode(',', $productIds),
        ]);
        // dd($request->all());
    
        $request->validate([
            'name' => 'required',
            'product_ids' => 'required|array|min:2', 
            'product_ids.*' => 'exists:products,id', 
            'offer_price' => 'required|numeric',
        ]);
    
        // Calculate total price of selected products
        $totalPrice = Product::whereIn('id', $request->product_ids)->sum('price');
    
        // Create the combo
        Combo::create([
            'name' => $request->name,
            'product_ids' => $request->product_ids,
            'total_price' => $totalPrice,
            'offer_price' => $request->offer_price,
        ]);
    
        return redirect()->route('combo.index')->with('success', 'Combo created successfully.');
    }
    public function getSubcategories($categoryId)
    {
        $subcategories = SubCategory::where('category_id', $categoryId)->get();
        return response()->json($subcategories);
    }


    public function getProducts($subcategoryId)
    {
        $products = Product::where('subcate_id', $subcategoryId)->get();
        return response()->json($products);
    }
    public function edit($id)
{
    $combo = Combo::findOrFail($id);
    $categories = Category::all();
    $subcategories = SubCategory::all();
    $products = Product::all();
    return view('admin.edit-combo', compact('combo', 'categories', 'subcategories', 'products'));
}

public function update(Request $request, $id)
{
    // Convert the comma-separated string of product IDs to an array
    // dd($request->all());
    $productIdsString = $request->product_ids[0]; // Get the first element of the array
    $productIds = explode(',', $productIdsString); // Convert the string to an array

    // Merge the product IDs back into the request
    $request->merge([
        'product_ids' => $productIds,
    ]);



    // Validate the request
    $request->validate([
        'name' => 'required',
        'product_ids' => 'required|array|min:2', 
        'product_ids.*' => 'exists:products,id', 
        'offer_price' => 'required|numeric',
    ]);

    // Find the combo product
    $combo = Combo::findOrFail($id);

    // Calculate the total price of the selected products
    $totalPrice = Product::whereIn('id', $request->product_ids)->sum('price');

    // Update the combo product
    $combo->update([
        'name' => $request->name,
        'product_ids' => $request->product_ids,
        'total_price' => $totalPrice,
        'offer_price' => $request->offer_price,
    ]);

    return redirect()->route('combo.index')->with('success', 'Combo updated successfully.');
}

public function updateStatus(Request $request, $id)
{
    $combo = Combo::findOrFail($id);
    $combo->update(['status' => $request->status]);
    return response()->json(['success' => 'Status updated successfully.']);
}

public function delete($id)
{
    $combo = Combo::findOrFail($id);
    $combo->delete();
    return response()->json(['success' => 'Combo deleted successfully.']);
}


public function create()
{
    $categories = Category::pluck('title', 'id'); // id => title
    $subcategories = SubCategory::pluck('title');

    return view('admin-coupons.add-combo', compact('categories', 'subcategories'));
}
}
