<?php

namespace App\Http\Controllers;


use App\Models\AboutOurMachineries;
use App\Models\AboutUs;
use App\Models\Accreditation;
use App\Models\ContactUs;
use App\Models\HomeContact;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Mail\EnquiryMail;
use App\Models\AboutTop;
use App\Models\AboutWhychoose;
use App\Models\CallToUs;
use App\Models\CounterSection;
use App\Models\Discover;
use App\Models\KnowUs;
use App\Models\OneSideRideFare;
use App\Models\RateTariff;
use App\Models\Travel;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Mail;
use App\Models\Category;
use App\Models\SubCategory;
class HomeController extends Controller
{

    public function index()
    {
        $categories = Category::where('status', 1)->orderBy('display_order', 'asc')->get();
    
        Log::info('Session details on home index', [
            'session_id' => session()->getId(),
            'all_session' => session()->all()
        ]);
        return view('view.index', compact('categories'));
    }
    public function showAllCategories()
{
    $categories = Category::with('subcategories')->get(); // eager load subcategories
    $categories = Category::with(['subcategories' => function($query) {
        $query->orderBy('updated_at', 'desc');
    }])->get();
    
    return view('view.category', compact('categories'));
}

    public function submit(Request $request){
        Log::info($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required',
            'phone' => 'required',
            'machinery' => 'required',
            'message' => 'required',
        ],[
            'phone.integer' => 'Invalid Mobile No'
            ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors( $validator->errors())->withInput();
        }

        $recaptcha_response = $_POST['g-recaptcha-response'];
        $secret_key = env('NOCAPTCHA_SECRET');
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret_key&response=$recaptcha_response");
        $response_data = json_decode($response);

        if ($response_data->success) {
        
            Mail::to('mpmsiva@gmail.com')->send(new EnquiryMail($request->except('_token','submit')));
            Mail::to('mpmsiva@gmail.com')->send(new EnquiryMail($request->except('_token','submit')));
            return redirect()->back()->with('success','Your Enquiry is Received Successfully. ');
            // Inquires::create($request->except('_token','g-recaptcha-response'));
        }else{

            return redirect()->back()->with('error','Please Verify the Captcha.')->withInput();
        }

    }

    public function show($id)
{
    $product = Product::with(['images', 'category', 'subCategory'])
                ->where('product_id', $id)
                ->where('is_deleted', 0)
                ->firstOrFail();

    return view('product.show', compact('product'));
}

}
