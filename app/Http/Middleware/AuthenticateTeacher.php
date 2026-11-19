<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/** Teacher panel: must be logged in on the `teacher` guard and still allowed to use the panel. */
class AuthenticateTeacher
{
    public function handle(Request $request, Closure $next): Response
    {
        $guard   = Auth::guard('teacher');
        $teacher = $guard->user();

        if (! $teacher) {
            return $request->expectsJson()
                ? response()->json(['message' => 'Please log in again.'], 401)
                : redirect()->guest(route('teacher.login'));
        }

        if (! $teacher->canUsePanel()) {
            $guard->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('teacher.login')->withErrors(['email' => 'Your teacher account is not active. Please contact the office.']);
        }

        Auth::shouldUse('teacher');

        return $next($request);
    }
}
