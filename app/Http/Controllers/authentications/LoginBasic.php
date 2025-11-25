<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HeaderFooter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class LoginBasic extends Controller
{
    public function index()
    {
        $content = HeaderFooter::where('id', 1)->first();
        return view('content.authentications.auth-login-basic', compact('content'));
    }

  public function verify(Request $request)
{
    Log::info('Login verification started.');

    $validator = Validator::make($request->all(), [
        'email' => 'required|string', // This is actually username in your case
        'password' => 'required|string'
    ]);

    if ($validator->fails()) {
        Log::warning('Validation failed', ['errors' => $validator->errors()]);
        return redirect()->back()
            ->withErrors($validator)
            ->withInput($request->except('password'));
    }

    Log::info('Validation passed.', ['email' => $request->email]);

    // Attempt login using username (your form calls it 'email')
    $credentials = [
        'username' => $request->email,
        'password' => $request->password
    ];

    Log::info('Attempting to authenticate admin.', $credentials);

    if (Auth::guard('admin')->attempt($credentials)) {
        Log::info('Authentication successful.');
       Log::info('Redirecting to admin dashboard.');
return redirect('/admin/categories');

    }

    Log::warning('Authentication failed.', ['username' => $request->email]);

    return redirect()->back()
        ->withInput($request->only('email'))
        ->with('error', 'Invalid username or password');
}
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('login');
    }
}