<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function login(Request $request)
{
    // Show login page (GET)
    if ($request->isMethod('get')) {
        return view('backend.admin.login');
    }

    // Validate incoming JSON
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required|min:6',
    ]);

    $credentials = $request->only('email', 'password');
    $remember    = $request->boolean('remember'); // handles the remember checkbox

    if (Auth::guard('admin')->attempt($credentials, $remember)) {
        $request->session()->regenerate(); // prevent session fixation

        return response()->json([
            'success'  => true,
            'message'  => 'Login successful.',
            'redirect' => '/admin/dashboard',
        ]);
    }

    return response()->json([
        'success' => false,
        'message' => 'These credentials do not match our records.',
        'errors'  => [
            'email' => ['Invalid email or password.'],
        ],
    ], 401);
}
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }
}
