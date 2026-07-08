<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\BookLesson;
use Illuminate\Support\Facades\Validator;
use Carbpn\Carbon;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Cashier;
use App\Models\User;
use Illuminate\Support\Facades\Log;
Use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;



class CheckoutController extends Controller
{
     public function checkout(Request $request)
    {
         $plan = $request->plan;
       
        $allPackage=Plan::with('category')->orderBy('sort_order')->get();
        return view('frontend.booklesson.checkout', compact('plan', 'allPackage'));
   

    }

public function checkoutstore(Request $request)
{
    $validator = Validator::make($request->all(), [
        'parent_name'        => 'required|string|max:255',
        'email'              => 'required|email|max:255',
        'package_id'         => 'required|exists:plans,id',
        'phone'              => 'required|string|max:30',
        'emergency_phone'    => 'nullable|string|max:30',
        'address'            => 'required|string|max:500',
        'post_code'          => 'required|string|max:20',
        'student_first_name' => 'required|string|max:255',
        'student_last_name'  => 'required|string|max:255',
        'current_level'      => 'nullable|in:Complete Beginner,Qaida / Basics,Reading Quran,Tajweed,Hifz (Memorisation)',
        'preferred_tutor'    => 'required|in:Not Specified,Male Tutor,Female Tutor',
        'preferred_time'     => 'required|in:Morning (8am–12pm),Afternoon (12pm–5pm),Evening (5pm–9pm),Weekend only,Flexible — any time',
        'notes'              => 'nullable|string|max:2000',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors'  => $validator->errors(),
        ], 422);
    }

    $data = $validator->validated();

    BookLesson::create([
        'parent_name'        => $data['parent_name'],
        'email'              => $data['email'],
        'phone'              => $data['phone'],
        'emergency_phone'    => $data['emergency_phone'] ?? null,
        'address'            => $data['address'],
        'post_code'          => $data['post_code'],
        'student_first_name' => $data['student_first_name'],
        'student_last_name'  => $data['student_last_name'],
        'current_level'      => $data['current_level'] ?? null,
        'preferred_tutor'    => $data['preferred_tutor'],
        'preferred_time'     => $data['preferred_time'],
        'notes'              => $data['notes'] ?? null,
        'package_id'         => $data['package_id'],
        'donation_interest'  => false,
        'status'             => 'pending',
    ]);

    return response()->json([
        'success'  => true,
        'message'  => 'Lesson booked successfully.',
        'redirect' => url('checkout/' . $data['package_id']),
    ]);
}

    // 


    public function checkoutreal(Request $request, $plan)
    {

       
    $package_id = $plan; // Assuming $plan is the ID of the selected package
    $plan = Plan::findOrFail($package_id);
    // Your Stripe Price ID
    $stripePriceId = $plan->stripe_price_id;

    return $request->user()
        ->newSubscription('{{ $plan->name }}', $stripePriceId)
        ->checkout([
            'success_url' => route('checkout-success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'  => route('checkout-cancel'),

            'metadata' => [
                'plan_id' => $package_id,
                'user_id' => $request->user()->id,
            ],
        ]);
    }

    // ─── SUCCESS PAGE ────────────────────────────────────────────────────────
    public function checkoutSuccess(Request $request)
    {
         return view('frontend.checkout.success');

        $sessionId = $request->get('session_id');

        if (!$sessionId) {
            return redirect()->route('home')->with('error', 'Invalid session.');
        }

        // Retrieve session from Stripe
        $session = Cashier::stripe()->checkout->sessions->retrieve($sessionId, [
            'expand' => ['subscription', 'customer'],
        ]);

        if ($session->payment_status !== 'paid') {
            return redirect()->route('home')->with('error', 'Payment not completed.');
        }

        // Sync subscription to DB manually (in case webhook is slow)
        $user = Auth::user();

        if ($session->subscription && $user) {
            // Update stripe_id on user if not set
            if (!$user->stripe_id && $session->customer) {
                $user->stripe_id = is_string($session->customer)
                    ? $session->customer
                    : $session->customer->id;
                $user->save();
            }

            // Sync the subscription from Stripe to your DB
            $user->updateStripeCustomer();
        }

        $planId = $session['metadata']['plan_id'] ?? null;

        return view('frontend.checkout.success', [
            'orderId' => $planId,
            'session' => $session,
        ]);
    }

    // ─── CANCEL PAGE ─────────────────────────────────────────────────────────
    public function checkoutCancel()
    {
        return view('frontend.checkout.cancel');
    }

 
}
