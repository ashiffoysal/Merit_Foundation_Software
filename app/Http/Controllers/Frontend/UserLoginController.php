<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserLoginController extends Controller
{
  

    public function login(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'email'    => ['required', 'email'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'email.required'    => 'Email address is required.',
            'email.email'       => 'Please enter a valid email address.',
            'password.required' => 'Password is required.',
            'password.min'      => 'Password must be at least 6 characters.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        $credentials = $request->only('email', 'password');
        $remember    = $request->boolean('remember');

        if (!Auth::attempt($credentials, $remember)) {
            return response()->json([
                'success' => false,
                'errors'  => ['email' => ['Invalid email or password. Please try again.']],
            ], 401);
        }

        $user = Auth::user();

        // Block unverified users
        if (!$user->hasVerifiedEmail()) {
            Auth::logout();
            return response()->json([
                'success' => false,
                'errors'  => ['email' => ['Please verify your email address before signing in. Check your inbox for the verification link.']],
                'unverified' => true,
                'email'   => $request->email,
            ], 403);
        }

        $request->session()->regenerate();

        return response()->json([
            'success'  => true,
            'message'  => 'Welcome back, ' . $user->first_name . '!',
            'redirect' => route('dashboard'),
        ]);
    }

    public function register(Request $request)
    {
        // Handle registration logic here
    }

    public function resendVerification(Request $request)
    {
        // Handle resend verification logic here
    }
}
