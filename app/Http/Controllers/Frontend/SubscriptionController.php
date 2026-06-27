<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Cashier\Exceptions\IncompletePayment;

class SubscriptionController extends Controller
{
     // ─── SHOW PLANS PAGE ────────────────────────────────────────────────────
    public function showPlans()
    {
        $user   = auth()->user();
        $intent = $user->createSetupIntent();  // for Stripe.js
        dd($intent);
        // return view('subscription.plans', compact('user', 'intent'));
    }

    // ─── CREATE SUBSCRIPTION ────────────────────────────────────────────────
    public function create(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string',
            'plan'           => 'required|string',
        ]);

        $user = auth()->user();

        try {
            // Save payment method & set as default
            $user->updateDefaultPaymentMethod($request->payment_method);

            // Create subscription
            $user->newSubscription('default', $request->plan)
                 ->create($request->payment_method);

            return redirect()->route('subscribe.success')
                             ->with('success', 'Subscription created successfully!');

        } catch (IncompletePayment $e) {
            return redirect()->route('cashier.payment', [$e->payment->id, 'redirect' => route('subscribe.success')]);
        } catch (\Exception $e) {
            return back()->with('error', 'Subscription failed: ' . $e->getMessage());
        }
    }

    // ─── PAUSE SUBSCRIPTION ─────────────────────────────────────────────────
    public function pause()
    {
        $user = auth()->user();

        if (!$user->subscribed('default')) {
            return back()->with('error', 'No active subscription found.');
        }

        // Pause at end of current billing period
        $user->subscription('default')->pauseNow();
        // OR pause at period end: ->pause()

        return back()->with('success', 'Subscription paused successfully!');
    }

    // ─── RESUME SUBSCRIPTION ────────────────────────────────────────────────
    public function resume()
    {
        $user = auth()->user();

        if (!$user->subscription('default') || !$user->subscription('default')->paused()) {
            return back()->with('error', 'No paused subscription found.');
        }

        $user->subscription('default')->resume();

        return back()->with('success', 'Subscription resumed successfully!');
    }

    // ─── CANCEL SUBSCRIPTION ────────────────────────────────────────────────
    public function cancel(Request $request)
    {
        $user = auth()->user();

        if (!$user->subscribed('default')) {
            return back()->with('error', 'No active subscription found.');
        }

        if ($request->input('immediately') === 'true') {
            // Cancel right now
            $user->subscription('default')->cancelNow();
            $message = 'Subscription cancelled immediately.';
        } else {
            // Cancel at end of billing period (grace period)
            $user->subscription('default')->cancel();
            $message = 'Subscription will cancel at end of billing period.';
        }

        return back()->with('success', $message);
    }

    // ─── UPDATE / SWAP PLAN ─────────────────────────────────────────────────
    public function update(Request $request)
    {
        $request->validate([
            'new_plan' => 'required|string',
        ]);

        $user = auth()->user();

        if (!$user->subscribed('default')) {
            return back()->with('error', 'No active subscription found.');
        }

        // Swap to new plan immediately (prorates by default)
        $user->subscription('default')->swap($request->new_plan);
        // No proration: ->noProrate()->swap($request->new_plan)

        return back()->with('success', 'Subscription updated to new plan!');
    }

    // ─── SUCCESS PAGE ───────────────────────────────────────────────────────
    public function success()
    {
        return view('subscription.success');
    }


     
}
