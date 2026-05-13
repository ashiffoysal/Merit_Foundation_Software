<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

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
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:100'],
            'last_name'  => ['required', 'string', 'max:100'],
            'email'      => ['required', 'email', 'unique:users,email'],
            'phone'      => ['required', 'string', 'max:20'],
            'password'   => ['required', 'string', 'min:8', 'confirmed'],
            'terms'      => ['accepted'],
        ], [
            'first_name.required' => 'First name is required.',
            'last_name.required'  => 'Last name is required.',
            'email.required'      => 'Email address is required.',
            'email.email'         => 'Please enter a valid email address.',
            'email.unique'        => 'An account with this email already exists.',
            'phone.required'      => 'Phone number is required.',
            'password.required'   => 'Password is required.',
            'password.min'        => 'Password must be at least 8 characters.',
            'password.confirmed'  => 'Passwords do not match.',
            'terms.accepted'      => 'You must agree to the Privacy Policy and Terms & Conditions.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        $user = User::create([
            'name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'password'   => Hash::make($request->password),
        ]);

        // Fire the Registered event → triggers SendEmailVerificationNotification
        // event(new Registered($user));

        return response()->json([
            'success' => true,
            'message' => 'Account created! We\'ve sent a verification link to ' . $user->email . '. Please check your inbox (and spam folder) to activate your account.',
        ]);
    }

    public function resendVerification(Request $request)
    {
        // Handle resend verification logic here
    }
}
