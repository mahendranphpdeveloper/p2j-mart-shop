<?php

namespace App\Http\Controllers;

use App\Mail\VerifySeller;
use App\Models\HeaderFooter;
use App\Models\Seller;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Laravel\Socialite\Facades\Socialite;


class UserController extends Controller
{
    
    public function index()
    {
        $content = HeaderFooter::where('id',1)->first();
        return view('seller.login',compact('content'));
    }
   
    public function register()
    {
        $content = HeaderFooter::where('id',1)->first();
        return view('seller.register',compact('content'));
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
  {
    try{

        $user = Socialite::driver('google')->user();
        \Log::info(json_encode($user));
      $existingUser = Seller::where('email', $user->email)->first();
      \Log::info(json_encode($existingUser));
    //  if(!isset($existingUser)){
    //      return redirect()->route('login')->with('error','Unable to Login, Your Account is Inactive');
    //  }else{

    //  }

      if ($existingUser) {
        //   Session::put('trend_id', $existingUser->id);
        //   Session::put('trend_email', $existingUser->email);
        //   Session::put('trend_lastname', $existingUser->last_name);
        //   Session::put('trend_name', $existingUser->name);
            Auth::guard('seller')->attempt(['email' => $existingUser->email, 'password' => $existingUser->password]);
          return redirect()->route('seller.dashboard');

      } else {
        return redirect()->to('login')->with(['user'=>$user->email, 'first_name'=>$user->user['given_name'],'last_name'=>$user->user['family_name'] ]);
        // return redirect()->route('register')->with('error','Your Account is not registered with us, Please Register Your Account to continue');
      }

    }catch(\Exception $e){

    }

  }
   
    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        // dd($request->all());

        $data = $request->all();

        $validator = Validator::make($request->all(), [

            'name' => 'required|string|max:255',
            'email' => 'required|unique:seller,email|string|max:255',
            'mobile_no' => ['required', 'numeric', 'digits:10'],
            'password' => 'required|string|max:255|min:4',
        ],[
            'mobile_no.integer' => 'Enter valid mobile no',
            'mobile_no.min' => 'Enter valid mobile no',
            'mobile_no.max' => 'Enter 10 digit mobile no',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

                $request->merge(['password' => Hash::make($request->password),
                                'remember_token' => Str::random(16)
                ]);

           $user =  Seller::create($request->except('_token'));
           Mail::to($request->email)->send(new VerifySeller(['name'=>$request->name,'remember_token'=>Crypt::encrypt($request->remember_token)]));
            //    event(new Registered($user));

        if ($user) {
            return redirect()->back()->withSuccess('Changes saved successfully');
        } else {
            return redirect()->back()->withError('Something went wrong, Please Try again');

        }
    }

    public function verify($token=null){

        if($token){
            $seller = Seller::where('remember_token',Crypt::decrypt($token))->first();
            if($seller){
                // Seller::where('remember_token',Crypt::decrypt($token))->update(['remember_token'=>null]);
                $seller->verified = 1;
                $seller->remember_token = null;
                $seller->save();
                return redirect()->route('seller-login')->withSuccess('Account Verified Successfully, Login to Continue');
            }else{
                return redirect()->route('seller-login')->withError('Verify Token is Expired');
            }
        }else{
            return redirect()->route('seller-login')->with('Something Went Wrong');
        }
    }


    public function login(Request $request){

        // dd($request->all());

        $user = Seller::where('email', '=', $request->email)->first();
        if (!$user) {
         return redirect()->back()->withError('Invalid Email, Please Enter Correct Email');
     }
        
     if (Hash::check($request->password, $user->password)) {
        
        if (Auth::guard('seller')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->intended('/seller/dashboard');
        }
            //  return redirect()->route('admin-dashboard');
     } else {
        return redirect()->back()->withError('Invalid Password');
     }
     }
 
     public function logout()
     {
 
        //  $userId = Auth::id();
         Auth::logout();
         session()->flush();
 
         return redirect()->route('seller-login');
     }

    public function show(string $id)
    {
        //
    }

   
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
