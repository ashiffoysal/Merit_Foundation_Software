<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Cashier\Exceptions\IncompletePayment;
use Stripe\Webhook;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubscriptionPauseMail;
use App\Mail\SubscriptionResumeMail;
use App\Mail\SubscriptionCancelledMail;

class SubscriptionController extends Controller
{


public function webhook(Request $request)
{
    $payload = $request->getContent();

    $sig = $request->header('Stripe-Signature');

    try {

        $event = Webhook::constructEvent(
            $payload,
            $sig,
            config('cashier.webhook.secret')
        );

    } catch (\Exception $e) {

        return response()->json([
            'error' => $e->getMessage()
        ], 400);

    }

    // Process event...

    return response()->json(['success' => true]);
}
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
public function pause($id)
{
    $subscription = Auth::user()->subscriptions()->findOrFail($id);

    if ($subscription->stripe_status !== 'active') {
        return back()->with('error', 'Only active subscriptions can be paused.');
    }

    try {
        // Cashier v16 way — pauses payment collection on Stripe
        \Stripe\Stripe::setApiKey(config('cashier.secret'));

        \Stripe\Subscription::update($subscription->stripe_id, [
            'pause_collection' => ['behavior' => 'mark_uncollectible'],
        ]);

        // Update local DB immediately (don't wait for webhook)
        $subscription->stripe_status = 'paused';
        $subscription->save();
        Mail::send(new SubscriptionPauseMail(Auth::user(), $subscription));
        return back()->with('success', 'Subscription paused successfully.');

    } catch (\Exception $e) {
        Log::error('Pause error: ' . $e->getMessage());
        return back()->with('error', 'Could not pause: ' . $e->getMessage());
    }
}

   public function resume($id)
{
    $subscription = Auth::user()->subscriptions()->findOrFail($id);

    if ($subscription->stripe_status !== 'paused' && !$subscription->onGracePeriod()) {
        return back()->with('error', 'Subscription cannot be resumed.');
    }

    try {
        \Stripe\Stripe::setApiKey(config('cashier.secret'));

        if ($subscription->stripe_status === 'paused') {
            // Resume from paused state — remove pause_collection
            \Stripe\Subscription::update($subscription->stripe_id, [
                'pause_collection' => '',
            ]);

            $subscription->stripe_status = 'active';
            $subscription->save();

        } else {
            // Resume from grace period (was cancelled but still in period)
            $subscription->resume();
        }
         Mail::send(new SubscriptionResumeMail(Auth::user(), $subscription));
        return back()->with('success', 'Subscription resumed successfully.');

    } catch (\Exception $e) {
        Log::error('Resume error: ' . $e->getMessage());
        return back()->with('error', 'Could not resume: ' . $e->getMessage());
    }
}

// ─── CANCEL AT PERIOD END ────────────────────────────────────────────────────
public function cancel($id)
{
    $subscription = Auth::user()->subscriptions()->findOrFail($id);

    if (!$subscription->active()) {
        return back()->with('error', 'No active subscription to cancel.');
    }

    try {
        $subscription->cancel(); // Cashier v16 — cancels at period end ✅
        Mail::send(new SubscriptionCancelledMail(Auth::user(), $subscription));
        return back()->with('success', 'Subscription will cancel at period end.');

    } catch (\Exception $e) {
        Log::error('Cancel error: ' . $e->getMessage());
        return back()->with('error', 'Could not cancel: ' . $e->getMessage());
    }
}

// ─── CANCEL IMMEDIATELY ──────────────────────────────────────────────────────
public function cancelNow($id)
{
    $subscription = Auth::user()->subscriptions()->findOrFail($id);

    try {
        $subscription->cancelNow(); // Cashier v16 ✅
        Mail::send(new SubscriptionCancelledMail(Auth::user(), $subscription));
        return back()->with('success', 'Subscription cancelled immediately.');

    } catch (\Exception $e) {
        Log::error('CancelNow error: ' . $e->getMessage());
        return back()->with('error', 'Could not cancel: ' . $e->getMessage());
    }
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
