<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CompanyInformation;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class CompanyInformationController extends Controller
{


    public function index()
    {
        return view('backend.companyInformation.index');
    }
    // update company information
    public function Update(Request $request)
    {  $validated = $request->validate([
            'organisation_name' => 'required|string|max:255',
            'charity_number'    => 'nullable|string|max:100',
            'primary_email'     => 'required|email|max:255',
            'safeguarding_email'=> 'required|email|max:255',
            'office_hours'      => 'nullable|string|max:100',
            'phone'             => 'required|string|max:30',
            'address'           => 'required|string|max:500',
            'logo'              => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'favicon'           => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,ico,webp|max:512',
        ]);

        $company = CompanyInformation::firstOrNew([]);

        // Fill basic fields
        $company->organisation_name  = $validated['organisation_name'];
        $company->charity_number     = $validated['charity_number'] ?? $company->charity_number;
        $company->primary_email      = $validated['primary_email'];
        $company->safeguarding_email = $validated['safeguarding_email'];
        $company->office_hours       = $validated['office_hours'] ?? $company->office_hours;
        $company->phone              = $validated['phone'];
        $company->address            = $validated['address'];

        $logoUrl    = null;
        $faviconUrl = null;

        // Handle Logo upload
        if ($request->hasFile('logo')) {
            if ($company->logo && Storage::disk('public')->exists($company->logo)) {
                Storage::disk('public')->delete($company->logo);
            }
            $path = $request->file('logo')->store('company', 'public');
            $company->logo = $path;
            $logoUrl = Storage::url($path);
        }

        // Handle Favicon upload
        if ($request->hasFile('favicon')) {
            if ($company->favicon && Storage::disk('public')->exists($company->favicon)) {
                Storage::disk('public')->delete($company->favicon);
            }
            $path = $request->file('favicon')->store('company', 'public');
            $company->favicon = $path;
            $faviconUrl = Storage::url($path);
        }

        $company->save();

        return response()->json([
            'success' => true,
            'message' => 'Organisation details saved successfully.',
            'logo'    => $logoUrl,
            'favicon' => $faviconUrl,
        ]);
    }

    // 

     public function saveAdminProfile(Request $request)
    {
 
        /** @var User $admin */
        $admin = Auth::user();

        $rules = [
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|max:255|unique:users,email,' . $admin->id,
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];

        // Only validate password fields if any are filled
        $changingPassword = $request->filled('current_password')
            || $request->filled('password')
            || $request->filled('password_confirmation');

        if ($changingPassword) {
            $rules['current_password']      = 'required|string';
            $rules['password']              = ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()];
            $rules['password_confirmation'] = 'required|string';
        }

        $validated = $request->validate($rules);

        // Verify current password
        if ($changingPassword) {
            if (!Hash::check($request->current_password, $admin->password)) {
                return response()->json([
                    'success' => false,
                    'errors'  => ['current_password' => ['Current password is incorrect.']],
                ], 422);
            }
        }

        // Update basic info
        $admin->name  = $validated['name'];
        $admin->email = $validated['email'];

        // Update password
        if ($changingPassword) {
            $admin->password = Hash::make($validated['password']);
        }

        // Handle profile image upload
        $imageUrl = null;
        if ($request->hasFile('profile_image')) {
            if ($admin->profile_image && Storage::disk('public')->exists($admin->profile_image)) {
                Storage::disk('public')->delete($admin->profile_image);
            }
            $path = $request->file('profile_image')->store('avatars', 'public');
            $admin->profile_image = $path;
            $imageUrl = Storage::url($path);
        }

        $admin->save();

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully.',
            'user' => [
                'name'              => $admin->name,
                'email'             => $admin->email,
                'profile_image'     => $admin->profile_image,
                'profile_image_url' => $imageUrl,
            ],
        ]);
    }
}
