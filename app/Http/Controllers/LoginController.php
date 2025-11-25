<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('view.login');
    }

    // Step 1: Send OTP
    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $otp = rand(100000, 999999);

        Session::put('otp', $otp);
        Session::put('email', $request->email);

        Mail::raw("Your OTP is: $otp", function ($message) use ($request) {
            $message->to($request->email)->subject('Your OTP Code');
        });

        return back()->with('message', 'OTP sent to your email.');
    }

    // Step 2: Verify OTP and login
    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required']);

        if ($request->otp == Session::get('otp')) {
            $email = Session::get('email');

            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => explode('@', $email)[0],
                    'password' => bcrypt(str()->random(16)),
                ]
            );

            // Save old session ID before login
            $old_session_id = session()->getId();

            // Log in user
            Auth::login($user);

            // Move guest cart items to user
            Cart::where('session_id', $old_session_id)
                ->update([
                    'user_id' => $user->id,
                    'session_id' => ''
                ]);

            // Clear OTP session
            Session::forget(['otp', 'email']);

            Log::info('User logged in with OTP', ['user_id' => $user->id]);

            // ✅ Redirect user back to checkout (or intended URL)
            return redirect()->intended(route('home'));
        }

        return back()->withErrors(['otp' => 'Invalid OTP.']);
    }

    // (Optional) Used for password login flow if needed
    protected function authenticated(Request $request, $user)
    {
        return redirect()->intended('/');
    }
}
