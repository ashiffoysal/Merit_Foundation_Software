<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Social;

class SocialController extends Controller
{
    public function index()
    {
        $socials = Social::first();
        return view('backend.social.index', compact('socials'));
    }
public function update(Request $request)
{
    $request->validate([
        'facebook'  => 'nullable|url',
        'twitter'   => 'nullable|url',
        'instagram' => 'nullable|url',
        'linkedin'  => 'nullable|url',
        'youtube'   => 'nullable|url',
    ]);

    // Get first record or create a new instance
    $social = Social::first() ?? new Social();

    // Assign values
    $social->facebook  = $request->facebook;
    $social->twitter   = $request->twitter;
    $social->instagram = $request->instagram;
    $social->linkedin  = $request->linkedin;
    $social->youtube   = $request->youtube;

    // Save record
    $social->save();

    // return redirect()->back()->with('success', 'Social media links updated successfully.');

    // For AJAX:
    return response()->json([
        'success' => true,
        'message' => 'Social media links updated successfully.'
    ]);
} 

}
