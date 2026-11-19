<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function show()
    {
        $teacher = auth('teacher')->user()->load(['branch', 'subjects', 'levels']);

        return view('teacher.profile', compact('teacher'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password'         => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
        ]);

        $teacher = auth('teacher')->user();
        if (! Hash::check($request->current_password, $teacher->password)) {
            return $request->expectsJson()
                ? response()->json(['message' => 'The given data was invalid.', 'errors' => ['current_password' => ['Your current password is not correct.']]], 422)
                : back()->withErrors(['current_password' => 'Your current password is not correct.']);
        }

        $teacher->forceFill(['password' => $request->password])->save();

        return $request->expectsJson()
            ? response()->json(['message' => 'Password changed.', 'redirect' => route('teacher.profile')])
            : back()->with('success', 'Password changed.');
    }
}
