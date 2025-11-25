<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\HeaderFooter;
use App\Models\ContactUs;
use App\Models\Contact;
use App\Models\Quotes;
use App\Models\Category;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // This shares the header_footer data with all views
        View::composer('*', function ($view) {
            $headerFooter = HeaderFooter::find(1);
            $view->with('headerFooter', $headerFooter);

            $categories = Category::where('status', 'active')
            ->orderBy('display_order', 'asc')
            ->get();
$view->with('categories', $categories);
        });

        View::composer('layouts.header', function ($view) {
            $cartController = new CartController();
            $cartCount = $cartController->cartCount();
            $view->with('cartCount', $cartCount);
        });
        
          View::composer('*', function ($view) {
        $contact = Contact::first();
        $footer = HeaderFooter::first();
        $view->with(compact('contact', 'footer'));
    });
    
 Validator::extend('recaptcha', function ($attribute, $value, $parameters, $validator) {
    $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
        'secret' => env('NOCAPTCHA_SECRET'),
        'response' => $value,
        'remoteip' => request()->ip()
    ])->json();
    
    return $response['success'];
});
    }
}
