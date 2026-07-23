<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubscriptionCreateMail;

class MakehubController extends Controller
{



// public function checkoutSuccess(Request $request)
//     {
        

//         $sessionId = $request->get('session_id');

//         if (!$sessionId) {
//             return redirect()->route('home')->with('error', 'Invalid session.');
//         }

//         $session = Cashier::stripe()->checkout->sessions->retrieve($sessionId, [
//             'expand' => ['subscription', 'customer'],
//         ]);

//         if ($session->payment_status !== 'paid') {
//             return redirect()->route('home')->with('error', 'Payment not completed.');
//         }

   
//         $user = Auth::user();

//         if ($session->subscription && $user) {
         
//             if (!$user->stripe_id && $session->customer) {
//                 $user->stripe_id = is_string($session->customer)
//                     ? $session->customer
//                     : $session->customer->id;
//                 $user->save();
//             }

//             $user->updateStripeCustomer();
//         }

//         $planId = $session['metadata']['plan_id'] ?? null;

//         Mail::send(new SubscriptionCreateMail($user, $planId));
//         return view('frontend.checkout.success', [
//             'orderId' => $planId,
//             'session' => $session,
//         ]);
//     }



public function checkoutSuccess(Request $request)
{
    $sessionId = $request->get('session_id');

    if (!$sessionId) {
        return redirect()->route('home')->with('error', 'Invalid session.');
    }

    // Retrieve session from Stripe with everything we need for the receipt
    $session = Cashier::stripe()->checkout->sessions->retrieve($sessionId, [
        'expand' => [
            'subscription',
            'subscription.latest_invoice.payment_intent',
            'subscription.plan.product',
            'customer',
        ],
    ]);

    if ($session->payment_status !== 'paid') {
        return redirect()->route('home')->with('error', 'Payment not completed.');
    }

    $user = Auth::user();

    if ($session->subscription && $user) {
        if (!$user->stripe_id && $session->customer) {
            $user->stripe_id = is_string($session->customer)
                ? $session->customer
                : $session->customer->id;
            $user->save();
        }

        $user->updateStripeCustomer();
    }

    $planId = $session['metadata']['plan_id'] ?? null;

    // Pass the Stripe session itself so the mailable isn't blind
    // if the webhook hasn't written the DB rows yet.
    Mail::to($user->email)->send(new SubscriptionCreateMail($user, $planId, $session));

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
