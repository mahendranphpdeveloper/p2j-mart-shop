<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class GoogleLoginController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            Log::info('Google authentication successful', [
                'google_id' => $googleUser->getId(),
                'email' => $googleUser->getEmail(),
                'name' => $googleUser->getName()
            ]);

            // Find existing user by email or google id
            $user = User::where('email', $googleUser->getEmail())
                        ->orWhere('google_id', $googleUser->getId())
                        ->first();

            if (!$user) {
                // New user - store data in session for registration
                $request->session()->put('google_auth_data', [
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar()
                ]);

                Log::info('New Google user, redirecting to phone form');
                return redirect()->route('google.phone.form');
            }

            // Existing user - update google id if missing
            if (empty($user->google_id)) {
                $user->google_id = $googleUser->getId();
            }

            // Mark email as verified if not already
            if (empty($user->email_verified_at)) {
                $user->email_verified_at = now();
            }

            $user->save();

            // Authenticate the user
            Auth::login($user, true);
            session()->regenerate();
            session()->save();

            Log::info('User authenticated via Google', ['user_id' => $user->id]);

            // Handle phone number requirement
            if (empty($user->phone)) {
                Log::info('User missing phone number, redirecting to phone form');
                return redirect()->route('google.phone.form');
            }

            // Check for buy_now_session_id (for checkout flow)
            if ($request->session()->has('buy_now_session_id')) {
                $sessionId = $request->session()->pull('buy_now_session_id');
                Log::info('Redirecting to checkout with session', ['session_id' => $sessionId]);
                return redirect()->route('products.checkout', ['session_id' => $sessionId]);
            }

            // Check for intended URL
            if ($request->session()->has('url.intended')) {
                $intendedUrl = $request->session()->pull('url.intended');
                Log::info('Redirecting to intended URL', ['url' => $intendedUrl]);
                return redirect()->to($intendedUrl);
            }

            // Default redirect
            Log::info('Redirecting to home');
            return redirect()->route('home')->with('success', 'Login successful!');

        } catch (\Exception $e) {
            Log::error('Google authentication failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('login.user')
                ->with('error', 'Google login failed. Please try again or use another method.');
        }
    }

    public function showPhoneForm()
    {
        $googleUser = session('google_auth_data');

        if (!$googleUser) {
            return redirect()->route('login.user')->with('error', 'Google authentication session expired. Please login again.');
        }

        return view('auth.phone', compact('googleUser'));
    }

    public function submitPhoneForm(Request $request)
    {
        $request->validate([
            'phone' => 'required|regex:/^\+[0-9]{1,3}[0-9]{4,14}$/',
        ]);

        $googleUser = session('google_auth_data');

        if (!$googleUser) {
            return redirect()->route('login.user')->with('error', 'Google authentication session expired. Please login again.');
        }

        // Try to find the user
        $user = User::where('google_id', $googleUser['google_id'])
                    ->orWhere('email', $googleUser['email'])
                    ->first();

        if ($user) {
            // Update phone and google_id if user exists
            $user->update([
                'phone' => $request->phone,
                'google_id' => $googleUser['google_id'],
            ]);
        } else {
            // Create new user if not found
            $user = User::create([
                'name' => $googleUser['name'],
                'email' => $googleUser['email'],
                'google_id' => $googleUser['google_id'],
                'phone' => $request->phone,
                'email_verified_at' => now(),
                'password' => bcrypt(str()->random(12)),
            ]);
        }

        // Log in the user
        Auth::login($user);

        // Clear session data
        session()->forget('google_auth_data');

        return redirect()->route('home')->with('success', 'Registration complete!');
    }
}