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
use Illuminate\Validation\Rule;

use Laravel\Cashier\Exceptions\IncompletePayment;

class UserDashboardController extends Controller
{
    // logout
    public function logout(Request $request)
    {
        auth()->logout();
        return redirect()->route('home')->with('success', 'You have been logged out successfully.');
    }

    public function update(Request $request)
    {
        // return $request->all();
        $user = Auth::user();

        $validated = $request->validate([
            'name'           => ['required', 'string', 'max:100'],
            'last_name'      => ['required', 'string', 'max:100'],
            'email'          => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'phone'          => ['nullable', 'string', 'max:20'],
            'address_line_1' => ['nullable', 'string', 'max:255'],
            'address_line_2' => ['nullable', 'string', 'max:255'],
            'city'           => ['nullable', 'string', 'max:100'],
            'postcode'       => ['nullable', 'string', 'max:20'],
            'country'        => ['nullable', 'string', 'max:100'],
            'student_name'   => ['nullable', 'string', 'max:150'],
            'age'            => ['nullable', 'integer', 'min:1', 'max:120'],
            'quran_level'    => ['nullable', 'in:Beginner,Qaida,Reading Quran,Tajweed'],
            'learning_goals' => ['nullable', 'string', 'max:1000'],
            'date_of_birth'  => ['nullable', 'date'],
            'gender'         => ['nullable', 'in:Female,Male,Prefer not to say'],
        ]);

        $update=User::where('id', $user->id)->update([
            'name'           => $validated['name'],
            'last_name'      => $validated['last_name'],
            'email'          => $validated['email'],
            'phone'          => $validated['phone'] ?? null,
            'address_line_1' => $validated['address_line_1'] ?? null,
            'address_line_2' => $validated['address_line_2'] ?? null,
            'city'           => $validated['city'] ?? null,
            'postcode'       => $validated['postcode'] ?? null,
            'country'        => $validated['country'] ?? null,
            'student_name'   => $validated['student_name'] ?? null,
            'age'            => $validated['age'] ?? null,
            'quran_level'    => $validated['quran_level'] ?? null,
            'learning_goals' => $validated['learning_goals'] ?? null,
            'date_of_birth'  => $validated['date_of_birth'] ?? null,
        ]);
        

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully.',
        ]);
    }

    /**
     * Update password (POST /profile/password)
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password'          => ['required'],
            'new_password'              => ['required', 'min:8', 'confirmed'],
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'errors'  => ['current_password' => ['Current password is incorrect.']],
            ], 422);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully.',
        ]);
    }



    public function dashboard(){

        $user          = auth()->user();
        $subscriptions = $user->subscriptions()->orderBy('created_at', 'desc')->get();
        $setupIntent   = $user->createSetupIntent();

        return view('frontend.user_dashboard.index', compact('user', 'subscriptions', 'setupIntent'));
    }
}
