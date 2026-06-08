<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisterVerifyMail;
use Carbon\Carbon;


class UserLoginController extends Controller
{
  

    public function login(Request $request)
    {
        
         $validator = Validator::make($request->all(), [
            'email'    => ['required', 'email'],
            'password' => ['required', 'string', 'min:4'],
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
            'password'   => ['required', 'string', 'min:4', 'confirmed'],
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
       $code = rand(100000, 999999);

$userId = User::insertGetId([
    'name'      => $request->first_name,
    'last_name' => $request->last_name,
    'email'     => $request->email,
    'phone'     => $request->phone,
    'password'  => Hash::make($request->password),
    'code'      => $code,
]);

$user = User::find($userId); // ✅ fetch the full model

Mail::to($request->email)->send(new RegisterVerifyMail($userId));

return response()->json([
    'success' => true,
    'message' => 'Account created! We\'ve sent a verification code to ' . $user->email,
]);
    }



    public function verifyEmail(Request $request)
    {
         

        $user = User::where('email', $request->email)
                    ->where('code', $request->code)
                    ->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired verification code.',
            ], 400);
        }
        $update=User::where('id', $user->id)->update([
            'email_verified_at' => Carbon::now(),
            'code'              => null,
            'is_verified'      => 1, // Optional: add a flag to indicate verification status
             // clear code after use
             'is_active' => 1, // Optional: activate the user account after verification
        ]);
        
        Auth::login($user); 

       return redirect()->route('dashboard')->with('success', 'Your email has been verified! Welcome to your dashboard.');
    }

    // resend code
        public function resendVerification(Request $request)
        {
            $user = User::where('email', $request->email)->first();
    
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'No account found with that email address.',
                ], 404);
            }
    
            if ($user->hasVerifiedEmail()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your email is already verified. Please log in.',
                ], 400);
            }
    
            // Generate a new verification code
            $code = rand(100000, 999999);
            $user->update(['code' => $code]);
    
            // Resend the verification email
            Mail::to($user->email)->send(new RegisterVerifyMail($user->id));
    
            return response()->json([
                'success' => true,
                'message' => 'A new verification code has been sent to ' . $user->email,
            ]);
        }

        // forgot password page
        public function showForgotPasswordForm()
        {
            return view('auth.forgot-password');
        }
        // forgot password
        public function forgotPassword(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'email' => ['required', 'email', 'exists:users,email'],
            ], [
                'email.required' => 'Email address is required.',
                'email.email'    => 'Please enter a valid email address.',
                'email.exists'   => 'No account found with that email address.',
            ]);
            // validation failed
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors'  => $validator->errors(),
                ], 422);
            }
            // generate reset token and send email
            $user = User::where('email', $request->email)->first();
            $token = Str::random(60);
            $user->update(['password_reset_token' => $token, 'password_reset_sent_at' => Carbon::now()]);
            Mail::to($user->email)->send(new PasswordResetMail($user, $token));
            return response()->json([
                'success' => true,
                'message' => 'A password reset link has been sent to ' . $user->email,
            ]);
        }
}
