<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Analytics extends Controller
{
    public function index()
    {

        $orders_count = DB::table('user_orders')->count();
        $users_count = DB::table('users')->count();
        $subcats_count = Subcategory::count();
        $categories_count = Category::count();
        $deleted_categories_count = Category::count();
        $products_count =Product::count();
        $deleted_products_count = Product::count();
        $subcats_count = Subcategory::count();
        $deleted_subcats_count = Subcategory::count();
        // dd($products_count);
        return view('admin-dashboard.dashboard', compact("deleted_categories_count","deleted_subcats_count","deleted_products_count","orders_count", "users_count", "products_count", "categories_count","subcats_count"));
    }

 public function metaTitles() {
    if(Auth::id() != 1)
        abort(404);

    // Ensure there's at least one record
    if (DB::table('meta_titles')->count() == 0) {
        DB::table('meta_titles')->insert(['id' => 1]);
    }

    $data = DB::table('meta_titles')->get();
    return view('admin.meta-titles',compact('data'));
}

   public function saveMetaTitles(Request $request)
{
    $data = [
        'home_meta_title'     => $request->home_meta_title,
            'home_meta_keys'      => $request->home_meta_keys,
            'home_meta_desc'      => $request->home_meta_desc,
            'new_meta_title'      => $request->new_meta_title,
            'new_meta_keys'       => $request->new_meta_keys,
            'new_meta_desc'       => $request->new_meta_desc,
            'cart_meta_title'     => $request->cart_meta_title,
            'cart_meta_keys'      => $request->cart_meta_keys,
            'cart_meta_desc'      => $request->cart_meta_desc,
            'profile_meta_title'  => $request->profile_meta_title,
            'profile_meta_keys'   => $request->profile_meta_keys,
            'profile_meta_desc'   => $request->profile_meta_desc,
            'checkout_meta_title' => $request->checkout_meta_title,
            'checkout_meta_keys'  => $request->checkout_meta_keys,
            'checkout_meta_desc'  => $request->checkout_meta_desc,
            'login_meta_title'    => $request->login_meta_title,
            'login_meta_keys'     => $request->login_meta_keys,
            'login_meta_desc'     => $request->login_meta_desc,
            'register_meta_title' => $request->register_meta_title,
            'register_meta_keys'  => $request->register_meta_keys,
            'register_meta_desc'  => $request->register_meta_desc,
            'about_meta_title'    => $request->about_meta_title,
            'about_meta_keys'     => $request->about_meta_keys,
            'about_meta_desc'     => $request->about_meta_desc,
            'contact_meta_title'  => $request->contact_meta_title, // ✅ correct spelling
            'contact_meta_keys'   => $request->contact_meta_keys,  // ✅ correct spelling
            'contact_meta_desc'   => $request->contact_meta_desc,
            'terms_meta_title'    => $request->terms_meta_title,
            'terms_meta_keys'     => $request->terms_meta_keys,
            'terms_meta_desc'     => $request->terms_meta_desc,
            'privacy_meta_title'  => $request->privacy_meta_title,
            'privacy_meta_keys'   => $request->privacy_meta_keys,
            'privacy_meta_desc'   => $request->privacy_meta_desc,
        ];
    
      $process = DB::table('meta_titles')->updateOrInsert(
        ['id' => 1],
        $data
    );

    if ($process) {
        return redirect()->route('meta-titles')->with('success', 'Your Changes Saved Successfully');
    } else {
        return redirect()->route('meta-titles')->with('error', 'Failed to Save');
    }
}
}    
