<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::guard('teacher')->check()) {
            return redirect()->route('teacher.dashboard');
        }

        return view('teacher.auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        // 5 attempts per minute per email + IP
        $key = 'teacher-login:' . Str::lower($data['email']) . '|' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            throw ValidationException::withMessages([
                'email' => 'Too many attempts. Try again in ' . RateLimiter::availableIn($key) . ' seconds.',
            ]);
        }

        $guard = Auth::guard('teacher');
        if (! $guard->attempt(['email' => Str::lower($data['email']), 'password' => $data['password']], $request->boolean('remember'))) {
            RateLimiter::hit($key);
            throw ValidationException::withMessages(['email' => 'These credentials do not match our records.']);
        }

        if (! $guard->user()->canUsePanel()) {
            $guard->logout();
            throw ValidationException::withMessages(['email' => 'Your teacher account is not active. Please contact the office.']);
        }

        RateLimiter::clear($key);
        $request->session()->regenerate();
        $guard->user()->forceFill(['last_login_at' => now()])->saveQuietly();

        return redirect()->intended(route('teacher.dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::guard('teacher')->logout();
        // keep an admin who is logged in in the same browser logged in
        $request->session()->regenerateToken();

        return redirect()->route('teacher.login')->with('status', 'You have been logged out.');
    }
}
