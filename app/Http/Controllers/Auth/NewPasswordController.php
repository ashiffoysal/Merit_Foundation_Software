<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request): View
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws ValidationException
     */
//    public function store(Request $request)
// {
//     $request->validate([
//         'token' => 'required',
//         'email' => 'required|email',
//         'password' => 'required|confirmed|min:8',
//     ]);

//     $user = User::where('email', $request->email)
//         ->where('password_reset_token', $request->token)
//         ->first();

//     if (!$user) {
//         return back()->withErrors([
//             'email' => 'Invalid or expired reset token.'
//         ]);
//     }

//     $user->update([
//         'password' => Hash::make($request->password),
//         'password_reset_token' => null,
//         'password_reset_sent_at' => null,
//         'remember_token' => Str::random(60),
//     ]);

//     return redirect()->route('login')
//         ->with('success', 'Password reset successfully.');
// }
 public function store(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = User::where('email', $request->email)
                    ->where('password_reset_token', $request->token)
                    ->whereNotNull('password_reset_sent_at')
                    ->where('password_reset_sent_at', '>=', now()->subMinutes(60))
                    ->first();

        if (!$user) {
            // AJAX-friendly error response
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Invalid or expired reset link. Please request a new one.',
                    'errors'  => [
                        'email' => ['Invalid or expired reset token.']
                    ]
                ], 422);
            }

            return back()->withErrors([
                'email' => 'Invalid or expired reset token.'
            ]);
        }

        $user->update([
            'password'               => Hash::make($request->password),
            'password_reset_token'   => null,
            'password_reset_sent_at' => null,
            'remember_token'         => Str::random(60),
        ]);

        // AJAX-friendly success response
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Password reset successfully.',
            ], 200);
        }

        return redirect()->route('login')
                         ->with('success', 'Password reset successfully.');
    }
}
