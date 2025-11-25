<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Exports\SalesExport;
use App\Exports\OrdersExport;
use App\Exports\CustomersExport;
use App\Exports\BestSellingExport;
use App\Exports\CategoryExport;
use App\Exports\SubCategoryExport;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;

class Reports extends Controller
{
    public function index(){
      $sales = DB::table('user_orders')->where('payment_status','Success');
      $sales_count = $sales->count();
      $sales = $sales->sum('price');

      $orders = DB::table('user_orders');
      $total_orders = $orders->count();
      $failed_orders = $total_orders-$sales_count;

      $users = DB::table('users');
      $total_users = $users->count();
      $new_users =  $users->whereMonth('created_at', Carbon::now()->month)
                          ->whereYear('created_at', Carbon::now()->year)
                          ->count();
      $old_users = $total_users-$new_users;

      $best_selling = $mostCommonAge = DB::table('user_orders')
                                          ->select('category',DB::raw('count(*) as count'))
                                          ->groupBy('category')
                                          ->orderBy('count', 'desc')
                                          ->limit(3)
                                          ->get();

       $categories = DB::table('categories')->count();
       $sub_categories = DB::table('sub_categories')->count();
      $total_products = DB::table('products')->count();

      return view('reports', compact('sales', 'sales_count', 'failed_orders', 'total_orders', 'old_users', 'new_users', 'total_users', 'best_selling', 'categories', 'sub_categories', 'total_products'));

    }

    public function downloadSales(){

        return Excel::download(new SalesExport, 'sales.xlsx');
    }

    public function downloadOrders(){

      return Excel::download(new OrdersExport, 'orders.xlsx');

    }

    public function downloadCustomers(){
      return Excel::download(new CustomersExport, 'customers.xlsx');
    }

    public function downloadBestSelling(){
      return Excel::download(new BestSellingExport, 'best-selling.xlsx');
    }

    public function downloadCategory(){
      return Excel::download(new CategoryExport, 'category.xlsx');
    }

    public function downloadSubCategory(){

      return Excel::download(new SubCategoryExport, 'sub-category.xlsx');
    }

    public function downloadProducts(){

      return Excel::download(new ProductsExport, 'products.xlsx');
    }

}
