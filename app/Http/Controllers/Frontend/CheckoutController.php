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
            'package_id'          => 'required|exists:plans,id',
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

        BookLesson::create([
            'parent_name'        => $request->parent_name,
            'email'              => $request->email,
            'phone'              => $request->phone,
            'emergency_phone'    => $request->emergency_phone,
            'address'            => $request->address,
            'post_code'          => $request->post_code,
            'student_first_name' => $request->student_first_name,
            'student_last_name'  => $request->student_last_name,
            'current_level'      => $request->current_level,
            'preferred_tutor'    => $request->preferred_tutor,
            'preferred_time'     => $request->preferred_time,
            'notes'              => $request->notes,
            'package_id'            => $request->package_id,
            'donation_interest'  => false,
            'status'             => 'pending',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Message sent successfully'
        ]);
    }

    // 


    public function checkoutreal(Request $request)
    {
       return $request;
        $package_id    = 1;
        $stripePriceId = 'price_1TnzAyIi1Z8eD8I6DLfDwkvg'; // your real price ID

        return $request->user()
            ->newSubscription('default', $stripePriceId)
            ->checkout([
                'success_url' => route('checkout-success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url'  => route('checkout-cancel'),
                'metadata'    => [
                    'plan_id' => $package_id,
                    'user_id' => Auth::id(),
                ],
            ]);
    }

    // ─── SUCCESS PAGE ────────────────────────────────────────────────────────
    public function checkoutSuccess(Request $request)
    {
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
