<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // The controller constructor
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // Show the login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle a login request to the application
    public function login(Request $request)
    {
        $this->validateLogin($request);

        if (Auth::attempt($this->credentials($request))) {
            // Check user role and redirect accordingly
            if (Auth::user()->role == 'admin') {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->intended($this->redirectPath());
        }

        return $this->sendFailedLoginResponse($request);
    }

    // Validate the user login request
    protected function validateLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    }

    // Get the login credentials from the request
    protected function credentials(Request $request)
    {
        return $request->only('email', 'password');
    }

    // Send a failed login response
    protected function sendFailedLoginResponse(Request $request)
    {
        return redirect()->back()->withErrors([
            'email' => 'Invalid Credentials.',
        ])->onlyInput('email');
    }

    // Get the post-login redirect path
    protected function redirectPath()
    {
        return '/home';
    }

    // Handle logout request
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
