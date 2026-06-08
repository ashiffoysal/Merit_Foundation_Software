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

class UserDashboardController extends Controller
{
    // logout
    public function logout(Request $request)
    {
        auth()->logout();
        return redirect()->route('home')->with('success', 'You have been logged out successfully.');
    }
}
