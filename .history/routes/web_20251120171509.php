<?php


use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Orders;
use App\Http\Controllers\ContactUs;
use App\Http\Controllers\Users;
use App\Http\Controllers\SeoMetaController;

use App\Http\Controllers\HomeSliderController;
use App\Http\Controllers\InformativePagesController;
use App\Http\Controllers\SeoMetaTitleController;
use App\Http\Controllers\dashboard\Analytics;
use App\Http\Controllers\AnalyticsController;
use App\Models\Units;
use App\Http\Controllers\ComboController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ManageUnitController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\BasicController;
use App\Http\Controllers\PhotosController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\GstController;
use App\Http\Controllers\Reports;
use App\Http\Controllers\ManageHomeSections;
use App\Http\Controllers\Auth\GoogleLoginController;
use App\Http\Controllers\ManageHome;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Home;
use App\Http\Controllers\Cart;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PageController;
use App\Models\Bibliophile;



use App\Http\Controllers\AdminProducts;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\Settings;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\HeaderFooterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductList;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\Unitlist;
use App\Http\Controllers\CustomizeController;
use Illuminate\Support\Facades\DB;

//user-info Page 

Route::get('/contact1-us', [PageController::class, 'contact'])->name('contact1');
Route::get('/about-us', [PageController::class, 'about'])->name('about');
Route::get('/privacy-policy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/terms-and-condition', [PageController::class, 'terms'])->name('terms');
Route::get('/shipping-policy', [PageController::class, 'shipping'])->name('shipping');
Route::get('/returns-policy', [PageController::class, 'returns'])->name('returns');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/security', [PageController::class, 'security'])->name('security');
Route::get('/grievance-redressal', [PageController::class, 'grievance'])->name('grievance');
Route::get('/epr-compliance', [PageController::class, 'epr'])->name('epr');
Route::get('/payments', [PageController::class, 'payments'])->name('payments');
Route::get('/press', [PageController::class, 'press'])->name('press');
Route::get('/corporate-info', [PageController::class, 'corporate'])->name('corporate');
Route::get('/sitemap', [PageController::class, 'sitemap'])->name('sitemap');




// Real rollback test with DB transactions (without manual sleep and using try/catch granularity)






Route::get('/clear-all-caches', function () {
    Artisan::call('optimize:clear');
    return 'All caches have been cleared.';
});
Route::get('/category', function () {
    return view('view.category');
})->name('category');

Route::get('/customize', [ProductController::class, 'showCustomizedProducts'])->name('customize');
Route::get('/customize', [ProductController::class, 'showCustomizedProducts'])->name('customize');
Route::get('/contact', [Home::class, 'contact'])->name('contact');
Route::post('/contact', [Home::class, 'storeEnquiry'])->name('contact.submit');

Route::post('/register', function (Request $request) {
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'phone' => 'required',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'google_id' => $request->google_id,
        'email_verified_at' => now(),
        'password' => bcrypt('google-login'), // dummy password
    ]);

    Auth::guard('Bibliophile')->login($user);

    return redirect()->route('home');
})->name('register.submit');


Route::get('/', [ManageHome::class, 'index'])->name('home');

Route::get('/category', [HomeController::class, 'showAllCategories'])->name('category');

// Route::get('/wishlist', [Home::class, 'wishlist'])->name('wishlist');
Route::get('/get-product-details/{slug}', [ProductController::class, 'fetchProductDetails']);


Route::get('/register', [GoogleLoginController::class, 'showPhoneForm'])->name('register');
Route::resource('homesections', ManageHomeSections::class);
Route::get('homesections-banner-2', [ManageHomeSections::class, 'banner'])->name('homesections.banner-2');
Route::post('homesections-save-banner-2', [ManageHomeSections::class, 'Savebanner'])->name('save.banner-2');
Route::get('home-slider-banner', [ManageHome::class, 'banner'])->name('home-slider-banner');
Route::post('save-home-slider-banner', [ManageHome::class, 'saveBanner'])->name('save-slider-banner');


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.user');
Route::post('/send-otp', [LoginController::class, 'sendOtp'])->name('login.sendOtp');
Route::post('/verify-otp', [LoginController::class, 'verifyOtp'])->name('login.verifyOtp');
Route::prefix('seller')->group(function () {
    Route::get('/auth/google/callback', [GoogleLoginController::class, 'handleGoogleCallback']);
    Route::get('/login/google', [GoogleLoginController::class, 'redirectToGoogle'])->name('login.google');
    //                 Route::get('/auth/google', [GoogleAuthController::class, 'redirectToGoogle']);
    // Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);
});


Route::get('/google/phone', [GoogleLoginController::class, 'showPhoneForm'])->name('google.phone.form');
Route::post('/google/phone', [GoogleLoginController::class, 'submitPhoneForm'])->name('google.phone.submit');

//cart

// Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
// Route::get('/cart/count', [CartController::class, 'getCartCount'])->name('cart.count');


Route::post('/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/add/t', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::get('/cart/count', [CartController::class, 'getCartCount'])->name('cart.getCount');
Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');


Route::post('/remove-from-cart', [CartController::class, 'removeFromCart'])->name('cart.remove');


//wishlist
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
Route::post('/wishlist/add', [WishlistController::class, 'add'])->name('wishlist.add');
Route::post('/wishlist/remove', [WishlistController::class, 'remove'])->name('wishlist.remove');
Route::get('/wishlist/count', [WishlistController::class, 'count'])->name('wishlist.count');

//22-5
Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('login.user'); // or wherever you want to redirect after logout
})->name('logout.user');
Route::get('/orders/success/{order}', [Home::class, 'success'])->name('orders.success');

Route::get('/order/invoice/{order_id}', [Home::class, 'downloadInvoice'])->name('order.invoice');
Route::get('/product/{id}/{slug}', [Home::class, 'show'])->name('product.viewd');



/////////////////
Route::post('/order/cancel/{order}', [Home::class, 'cancelOrder'])->name('order.cancel');


Route::post('/orders/{order}/return', [Home::class, 'returnOrder'])
    ->name('order.return');

///////////////////

Route::post('/upload-custom-image', [ProductController::class, 'uploadCustomImage']);


///shipping
// routes/web.php

Route::post('/calculate-shipping', [ProductController::class, 'calculateShipping'])->name('calculate.shipping');

//////////payment

// Payment Routes
//  Route::middleware(['auth', 'web'])->group(function() {
//   Route::match(['get', 'post'], '/payment/initiate', [PaymentsController::class, 'initiate'])->name('payment.initiate');
//     Route::post('/payment/response', [PaymentsController::class, 'response'])->name('payment.response');
//     Route::get('/payment/cancel', [PaymentsController::class, 'cancel'])->name('payment.cancel');
//     // routes/web.php (temporary route for debugging)
// Route::get('/payment/config-check', function() {
//     return response()->json([
//         'config_ccavenue' => config('ccavenue'),
//         'env_vars' => [
//             'CCAVENUE_WORKING_KEY' => env('CCAVENUE_WORKING_KEY'),
//             'CCAVENUE_MODE' => env('CCAVENUE_MODE')
//         ],
//         'config_cached' => app()->configurationIsCached()
//     ]);
// })->middleware(['auth', 'web']);
// });

/////////dummy Payment
//  Route::middleware(['auth', 'web'])->group(function() {
//  Route::match(['get', 'post'], '/payment/initiate', [PaymentController::class, 'initiate'])->name('payment.initiate');
//   Route::match(['get', 'post'],'/payment/response', [PaymentController::class, 'response'])->name('payment.response');
// });
// Payment Routes


//user-address-user-icon
Route::middleware(['auth:web'])->group(function () {
    // Route::get('/my-account', [Home::class, 'index'])->name('my-account');
    Route::post('/address/store', [Home::class, 'store'])->name('address.store');
    Route::get('/address/edit/{id}', [Home::class, 'edit'])->name('address.edit');
    Route::post('/address/update/{id}', [Home::class, 'update'])->name('address.update');
    Route::post('/address/delete/{id}', [Home::class, 'destroy'])->name('address.delete');


    Route::match(['get', 'post'], '/payment/initiate', [PaymentsController::class, 'initiate'])->name('payment.initiate');
    Route::match(['get', 'post'], '/payment/response', [PaymentsController::class, 'response'])->name('payment.response');
    Route::match(['get', 'post'], '/payment/cancel', [PaymentsController::class, 'cancel'])->name('payment.cancel');

    // Result pages
    Route::get('/payment/success', [PaymentsController::class, 'success'])->name('payment.success');
    Route::get('/payment/failed', [PaymentsController::class, 'failed'])->name('payment.failed');

    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/success/{order}', [OrderController::class, 'showSuccess'])->name('success');
        Route::post('/{order_id}/cancel', [OrderController::class, 'cancel'])->name('cancel');
        Route::get('/{order}/invoice', [OrderController::class, 'invoice'])->name('invoice');
    });
    // Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');

    Route::get('/checkout', [Home::class, 'checkout'])->middleware('auth')->name('checkout');
    Route::get('/account', [Home::class, 'userAccount'])->name('user.account');
    
    Route::get('/orders', [Home::class, 'userOrders'])->name('user.orders');

    Route::post('/user/update', [Home::class, 'userAccountUpdate'])->name('user.update');
    Route::get('/my-profile', [Home::class, 'getProfileData'])->name('profile.view');
    Route::get('/order-confirmation', [Home::class, 'confirmation'])->name('order.confirmation');
});



Route::post('/products/checkout/initiate', [ProductController::class, 'initiateCheckout'])
    ->name('products.checkout.initiate');

Route::get('/products/checkout/{session_id}', [ProductController::class, 'showCheckout'])
    ->name('products.checkout');


Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');

Route::post('/place-order', [OrderController::class, 'store'])->name('place.order');




//Route::get('/orders/success', [OrderController::class, 'showSuccess'])->name('orders.success');

Route::post('/save-address', [AddressController::class, 'store'])->name('save.address');

Route::post('/address/select', [AddressController::class, 'select'])->name('address.select');

///admin Orders list 

Route::resource('/orders', Orders::class);

Route::get('get-orders', [Orders::class, 'get'])->name('get.orders');

// Approve/reject return request (for admin return workflow)
Route::post('orders/return-action', [Orders::class, 'processReturnAction'])->name('orders.return-action');


Route::post('orders/deliver', [Orders::class, 'deliver'])->name('orders.deliver');

///////////
Route::get('orders/view/{id}', [Orders::class, 'viewOrders'])->name('orders.view');
Route::post('orders/ship', [Orders::class, 'ship'])->name('orders.ship');

Route::get('/orders/{order}/invoice', [Orders::class, 'downloadInvoice'])
    ->name('orders.invoice');

Route::post(
    '/orders/update-payment-status',
    [Orders::class, 'updatePaymentStatus']
)
    ->name('orders.update-payment-status');
//
Route::get('cancel-order-request', [Orders::class, 'CancelRequest'])->name('cancel-order-request');
Route::get('help-support', [Orders::class, 'helpSupport'])->name('help-support');
Route::get('/get-orders-help', [Orders::class, 'getOrdersHelp'])->name('get.orders.help');



///
Route::get('/admin/cancel-requests', [Orders::class, 'CancelRequest'])->name('get.cancel.orders');




Route::post('/gst-store', [Orders::class, 'store'])->name('gst.store');
Route::get('/gst', [Orders::class, 'gst'])->name('gst.index');
Route::get('/gst/{id}', [Orders::class, 'shows'])->name('gst.view');
Route::get('/gst/{id}/edit', [Orders::class, 'edits'])->name('gst.edit');
Route::put('/gst/{id}', [Orders::class, 'updates'])->name('gst.update');
Route::delete('/gst/{id}', [Orders::class, 'destroys'])->name('gst.destroy');

Route::resource('gst', Orders::class);


Route::get('/subcategory/{id}/products', [ProductController::class, 'getBySubcategory'])->name('subcategory.products');

Route::get('/subcategory/{id}', [ProductController::class, 'getBySubcategory'])->name('subcategory.products');
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.products');
Route::get('/gift-products', [ProductController::class, 'gift'])->name('gift.products');
Route::post('/get-product-image', [ProductController::class, 'getProductImage'])->name('getProductImage');
Route::post('/delete-product-images', [ProductController::class, 'deleteProductImages'])->name('deleteProductImages');
// Show full product page with related products
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.view');

// Show only specific product (separate view)
Route::get('/product-only/{slug}', [ProductController::class, 'showOnly'])->name('product.show');
Route::get('/gift-items/{subcategory_slug}', [ProductController::class, 'fetchGiftItemsBySubcategory']);


Route::post('/products/{product}/customize', [ProductController::class, 'saveCustomization'])->name('products.save-customization');

Route::get('gst', [Orders::class, 'gst'])->name('gst');
Route::get('/get-category-titles', [CategoryController::class, 'getCategoryTitles']);
Route::get('/get-subcategories/{categoryTitle}', [SubCategoryController::class, 'getByCategory']);

Route::get('view-enquires', [ContactUs::class, 'view'])->name('view.enquires');
Route::get('get-enquires', [ContactUs::class, 'get'])->name('get.enquires');
Route::get('get-users', [Users::class, 'get'])->name('get.customers');
Route::resource('users', Users::class);





// Route::post('/submit-contact', [HomeController::class, 'submit'])->name('contact.submit');
Route::get('/admin', [LoginBasic::class, 'index'])->name('login');
Route::group(['prefix' => 'admin'], function () {
    Route::post('/verify-user', [LoginBasic::class, 'verify'])->name('check-login');
    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/logout', [LoginBasic::class, 'logout'])->name('admin-logout');
        Route::get('/contact-us', [HeaderFooterController::class, 'index'])->name('contactus');
        Route::post('/save-contactus', [HeaderFooterController::class, 'save'])->name('save-contactus');
        Route::get('/header-footer-content', [HeaderFooterController::class, 'headerFooter'])->name('common');
        Route::post('/save-header-footer-content', [HeaderFooterController::class, 'saveHeaderFooter'])->name('save-common');
        Route::resource('/settings', Settings::class);

        Route::resource('settings', Settings::class);
        Route::get('dynamic-units', [Settings::class, 'dynamicUnits'])->name('settings.dynamic-units');
        Route::post('save-dynamic-units', [Settings::class, 'saveDynamicUnits'])->name('save-dynamic-units');
        Route::get('edit-dynamic-units/{id}', [Settings::class, 'editDynamicUnits'])->name('edit-dynamic-units');
        Route::get('get-dynamic-table', [Settings::class, 'get'])->name('get-dynamic-table');
        Route::post('delete-dynamic-units', [Settings::class, 'deleteDynamicUnits'])->name('delete-dynamic-units');
        Route::get('state-based-shipping-cost', [Settings::class, 'shippingCost'])->name('settings.shipping-cost');
        Route::post('/save-shipping-cost', [Settings::class, 'saveShippingCost'])->name('save-shipping-cost');
        // Route::get('/edit-state/{id}', [Settings::class, 'editState'])->name('edit-state');
        Route::get('/edit-state/{id}', [Settings::class, 'editState'])->name('edit-state');

        Route::delete('/delete-state/{id}', [Settings::class, 'deleteState'])->name('delete-state');
        Route::post('/shipping-cost/delete/{id}', [Settings::class, 'destroyShippingCost'])->name('shipping-cost.destroy');

       // Cancel an order (ensure CSRF-protected POST route for AJAX compatibility)
       Route::post('orders/cancel', [Orders::class, 'cancel'])->name('orders.cancel');
        // Resourceful routes for orders (use correct resource path)
        // Route::resource('orders', Orders::class);

        //
        Route::get('get-orders', [Orders::class, 'get'])->name('get.orders');
        //
        Route::get('/contact-us', [ContactUsController::class, 'edit'])->name('contact-us.edit');
        Route::put('/contact-us', [ContactUsController::class, 'update'])->name('contact-us.update');


        Route::get('/categories', [CategoryController::class, 'view'])->name('categories.view');
        Route::get('/categoriespageindex', [CategoryController::class, 'index'])->name('categories.index');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::patch('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::post('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');


        // Route::get('/admin', function () {
        //     // Admin panel
        // })->middleware('admin'); // Uses the 'admin' alias from Kernel.php



        //SEO Meta

        Route::get('/meta-titles', [Analytics::class, 'metaTitles'])->name('meta-titles');
        Route::post('save-meta-titles', [Analytics::class, 'saveMetaTitles'])->name('save.meta-titles');

        //combo 
        Route::get('/combo-list', [ComboController::class, 'index'])->name('combo.index');
        Route::get('/add-combo', [ComboController::class, 'addCombo'])->name('new.combo');
        Route::post('/store-combo', [ComboController::class, 'storeCombo'])->name('store.combo');
        Route::get('/get-subcategories/{categoryId}', [ComboController::class, 'getSubcategories'])->name('getSubcategories');
        Route::get('/get-products/{subcategoryId}', [ComboController::class, 'getProducts'])->name('getProducts');
        Route::get('/combos/edit/{id}', [ComboController::class, 'edit'])->name('edit.combo');
        Route::put('/combos/update/{id}', [ComboController::class, 'update'])->name('update.combo');
        Route::post('/combos/update-status/{id}', [ComboController::class, 'updateStatus'])->name('update.status');
        Route::delete('/combos/delete/{id}', [ComboController::class, 'delete'])->name('delete.combo');

        Route::middleware(['CheckAdminUser', 'single.session'])->group(function () {

            Route::get('/dashboard', [Analytics::class, 'index'])->name('admin-dashboard');
        });
        //enquiries

        // Home Slider     

        Route::get('/home-slider', [HomeSliderController::class, 'index'])->name('homeslider.index'); // View Sliders
        Route::post('/home-slider/store', [HomeSliderController::class, 'store'])->name('homeslider.store'); // Add New Slider
        Route::post('/home-slider/update', [HomeSliderController::class, 'update'])->name('homeslider.update'); // Update Slider
        Route::post('/home-slider/delete/{id}', [HomeSliderController::class, 'destroy'])->name('homeslider.delete'); // Delete Slider
        //informative pages 
        Route::get('/informative-pages/privacy-policy', [InformativePagesController::class, 'privacyPolicy'])
            ->name('informative-pages.privacy-policy');
        Route::post('/save-privacy-policy', [InformativePagesController::class, 'savePrivacyPolicy'])->name('save-privacy-policy');

        Route::get('/informative-pages/delivery-policy', [InformativePagesController::class, 'deliveryPolicy'])->name('informative-pages.delivery-policy');
        Route::post('/save-delivery-policy', [InformativePagesController::class, 'saveDeliveryPolicy'])->name('save-delivery-policy');

        Route::get('/informative-pages/terms-conditions', [InformativePagesController::class, 'termsConditions'])->name('informative-pages.terms-conditions');
        Route::post('/informative-pages/terms-conditions/save', [InformativePagesController::class, 'saveTermsConditions'])->name('save-terms-conditions');
        Route::get('/security-policy', [InformativePagesController::class, 'securityPolicy'])->name('informative-pages.security-policy');
        Route::post('/save-security-policy', [InformativePagesController::class, 'saveSecurityPolicy'])->name('save-security-policy');
        Route::get('/Refund-Cancellation-Policy', [InformativePagesController::class, 'eprCompliance'])->name('informative-pages.epr_compliance');
        Route::post('/save-epr-compliance', [InformativePagesController::class, 'saveEprCompliance'])->name('save-epr-compliance');




        Route::get('/subcategories/{category_slug}', [SubCategoryController::class, 'view'])->name('subcategories.view');
        Route::get('/subcategoriespage/{category_slug}', [SubCategoryController::class, 'index'])->name('subcategories.index');
        Route::post('/subcategories', [SubCategoryController::class, 'store'])->name('subcategories.store');
        Route::patch('/subcategories/{subcategory}', [SubCategoryController::class, 'update'])->name('subcategories.update');
        Route::post('/subcategories/{subcategory}', [SubCategoryController::class, 'destroy'])->name('subcategories.destroy');

        Route::resource('products', AdminProducts::class);
        Route::post('products/edit-category-product', [AdminProducts::class, 'editProduct'])->name('edit-cat-product');
        Route::post('products/update-category-product/{id}', [AdminProducts::class, 'updateIt'])->name('update-cat-product');
        Route::post('get-products-table', [AdminProducts::class, 'getProducts'])->name('get-products-table');
        Route::post('update-product', [AdminProducts::class, 'updateTable'])->name('update-product');
        Route::post('update-product-image', [AdminProducts::class, 'uploadMultipleImages'])->name('update-product-image');
        Route::post('update-product-variants', [AdminProducts::class, 'updateVariants'])->name('update-product-variants');


        Route::post('manage-images', [AdminProducts::class, 'manageImages'])->name('remove.image');
        Route::get('category-add-edit-product/{id}', [AdminProducts::class, 'categoryAddProduct'])->name('category-add-edit-product');
        Route::get('admin-products-delete/{id}', [AdminProducts::class, 'delete'])->name('admin-delete-products');



        // unit List

        Route::group(['prefix' => 'unit'], function () {

            Route::get('/material', [Unitlist::class, 'material'])->name('unit-material');
            Route::get('material-get-data', [Unitlist::class, 'getMatrial'])->name('get-material-table');
            Route::get('getMatrialData', [Unitlist::class, 'getMatrialData'])->name('getMatrialData');
            Route::post('storeMatrial', [Unitlist::class, 'storeMatrial'])->name('storeMatrial');
            Route::post('material-delete-data', [Unitlist::class, 'deleteMatrial'])->name('delete-material-table');
            //finally added
            Route::get('/design', [Unitlist::class, 'design'])->name('unit-design');
            Route::resource('unitlist', Unitlist::class);
            Route::get('design-get-data', [Unitlist::class, 'getDesign'])->name('get-design-table');
            Route::get('getDesignData', [Unitlist::class, 'getDesignData'])->name('getDesignData');
            Route::post('design-delete-data', [Unitlist::class, 'deleteDesign'])->name('design-delete-data');
            // Route::post('storeDesign', [Unitlist::class, 'storeDesign'])->name('storeMatrial');

            Route::get('/size', [Unitlist::class, 'size'])->name('unit-size');
            Route::get('size-get-data', [Unitlist::class, 'getSize'])->name('get-size-table');
            Route::get('getSizeData', [Unitlist::class, 'getSizeData'])->name('getSizeData');
            Route::post('storeSize', [Unitlist::class, 'storeSize'])->name('storeSize');
            Route::post('size-delete-data', [Unitlist::class, 'deleteSize'])->name('delete-size-table');

            Route::get('/unit-color2', [AttributeController::class, 'index'])->name('unit-color2');

            Route::get('/attribute', [Unitlist::class, 'attribute'])->name('unit-attribute');
            Route::get('attribute-get-data', [Unitlist::class, 'getAttribute'])->name('get-attribute-table');
            Route::get('getAttributeData', [Unitlist::class, 'getAttributeData'])->name('getAttributeData');
            Route::post('storeAttribute', [Unitlist::class, 'storeAttribute'])->name('storeAttribute');
            Route::post('attribute-delete-data', [Unitlist::class, 'deleteAttribute'])->name('delete-attribute-table');

            Route::get('/{type}', [Unitlist::class, 'attribute'])->name('unit.attribute');

            // Dynamic route to fetch table data based on the type
            Route::get('/get-table-data/get', [Unitlist::class, 'getAttributeList'])->name('get-table-data');
            Route::get('/getAttributeData/get', [Unitlist::class, 'getAttributeData'])->name('getAttributeData');

            Route::post('/attribute/store', [Unitlist::class, 'storeAttribute'])->name('storeAttribute');

            Route::post('/attribute/delete', [Unitlist::class, 'deleteAttribute'])->name('deleteAttribute');




            Route::get('/color', [Unitlist::class, 'color'])->name('unit-color');
            Route::get('color-get-data', [Unitlist::class, 'getColor'])->name('get-color-table');
            Route::get('getColorData', [Unitlist::class, 'getColorData'])->name('getColorData');
            Route::post('storeColor', [Unitlist::class, 'storeColor'])->name('storeColor');
            Route::post('color-delete-data', [Unitlist::class, 'deleteColor'])->name('delete-color-table');
        });

        Route::get('admin/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');

        //  Route::post('storebasicdetails', [ProductList::class, 'saveBasicdetails'])->name('storebasicdetails');
        //  Route::post('pricebasicdetails', [ProductList::class, 'savePricedetails'])->name('pricebasicdetails');
        //  Route::post('getUnitList', [ProductList::class, 'getUnitList'])->name('getUnitList');
        //  Route::post('storeUnitdetails', [ProductList::class, 'storeUnitdetails'])->name('storeUnitdetails');
        //  Route::post('uploadImages', [ProductList::class, 'uploadImages'])->name('uploadImages');
        //  Route::post('uploadvideo', [ProductList::class, 'uploadVideo'])->name('uploadvideo');
        //  Route::post('deletevideo', [ProductList::class, 'deleteProductVideo'])->name('deletevideo');
        //  Route::post('getProductImage', [ProductList::class, 'getProductImage'])->name('getProductImage');
        //  Route::post('deleteProductImages', [ProductList::class, 'deleteProductImages'])->name('deleteProductImages');
        //  Route::post('saveWordProduct', [ProductList::class, 'saveWordProduct'])->name('saveWordProduct');

        //  Route::post('savemetatitle', [ProductList::class, 'saveMetaTitle'])->name('savemetatitle');
        //  Route::post('savemetadescription', [ProductList::class, 'saveMetaDescription'])->name('savemetadescription');

        //   Route::post('delete-product-table', [ProductList::class, 'deleteProduct'])->name('delete-product-table');


        // Attributes -Aj


        // Attributes main routes
        Route::prefix('attributes')->group(function () {
            Route::get('/', [AttributeController::class, 'index'])->name('attributes.index');
            Route::post('/', [AttributeController::class, 'store'])->name('attributes.store');
            Route::put('/{id}', [AttributeController::class, 'update'])->name('attributes.update');
            Route::delete('/{id}', [AttributeController::class, 'destroy'])->name('attributes.destroy');

            // Attribute Options Management
            Route::prefix('{slug}')->group(function () {
                Route::get('/manage', [AttributeController::class, 'manageOptions'])->name('attributes.manage');
                Route::post('/options', [AttributeController::class, 'storeOption'])->name('attributes.option.store');
                Route::put('/options/{id}', [AttributeController::class, 'updateOption'])->name('attributes.option.update');
                Route::delete('/options/{id}', [AttributeController::class, 'destroyOption'])->name('attributes.option.destroy');
            });
        });

        Route::get('productadd', [ProductList::class, 'index'])->name('productadd');
        Route::post('storebasicdetails', [ProductList::class, 'saveBasicdetails'])->name('storebasicdetails');
        Route::post('pricebasicdetails', [ProductList::class, 'savePricedetails'])->name('pricebasicdetails');
        Route::post('getUnitList', [ProductList::class, 'getUnitList'])->name('getUnitList');
        Route::post('storeUnitdetails', [ProductList::class, 'storeUnitdetails'])->name('storeUnitdetails');
        Route::post('uploadImages', [ProductList::class, 'uploadImages'])->name('uploadImages');
        Route::post('uploadvideo', [ProductList::class, 'uploadVideo'])->name('uploadvideo');
        Route::post('deletevideo', [ProductList::class, 'deleteProductVideo'])->name('deletevideo');
        Route::post('getProductImage', [ProductList::class, 'getProductImage'])->name('getProductImage');
        Route::post('deleteProductImages', [ProductList::class, 'deleteProductImages'])->name('deleteProductImages');
        Route::post('saveWordProduct', [ProductList::class, 'saveWordProduct'])->name('saveWordProduct');

        Route::post('savemetatitle', [ProductList::class, 'saveMetaTitle'])->name('savemetatitle');
        Route::post('savemetadescription', [ProductList::class, 'saveMetaDescription'])->name('savemetadescription');

        Route::post('delete-product-table', [ProductList::class, 'deleteProduct'])->name('delete-product-table');
        //    Route::resource('admin-home', ManageHome::class);
        //    Route::get('admin-home-get-data', [ManageHome::class, 'getSlider'])->name('get-slider-table');
        //    Route::post('admin-home-delete-data', [ManageHome::class, 'deleteSlider'])->name('delete-slider-table');
        Route::get('deleteUnitList', [ProductList::class, 'deleteUnitList'])->name('deleteUnitList');



        /////////cuo
        Route::get('/customize-orders', [customizeController::class, 'index'])->name('customize.orders');












        Route::get('reports', [Reports::class, 'index'])->name('reports');
        Route::get('/download-sales-report', [Reports::class, 'downloadSales'])->name('download-sales-report');
        Route::get('/download-orders-report', [Reports::class, 'downloadOrders'])->name('download-orders-report');
        Route::get('/download-customers-report', [Reports::class, 'downloadCustomers'])->name('download-customers-report');
        Route::get('/download-best-selling-report', [Reports::class, 'downloadBestSelling'])->name('download-best-selling-report');
        Route::get('/download-category-report', [Reports::class, 'downloadCategory'])->name('download-category-report');
        Route::get('/download-sub-category-report', [Reports::class, 'downloadSubCategory'])->name('download-sub-category-report');
        Route::get('/download-products-report', [Reports::class, 'downloadProducts'])->name('download-products-report');

        Route::resource('charts', Charts::class);
        Route::post('/home/save-header-footer', [ManageHome::class, 'saveHeader'])->name('save.header-footer');
    });
});
