<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class MakehubController extends Controller
{



public function checkoutSuccess(Request $request)
    {
        //  return view('frontend.checkout.success');

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
