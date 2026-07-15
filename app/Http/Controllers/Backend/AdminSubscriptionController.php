<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Subscription;
use App\Models\Plan;
use App\Models\User;
use App\Mail\SubscriptionPauseMail;
use App\Mail\SubscriptionResumeMail;
use Illuminate\Support\Facades\Mail;

class AdminSubscriptionController extends Controller
{
        public function pause($id)
    {
        $sub = Subscription::findOrFail($id);
 
        try {
            \Stripe\Stripe::setApiKey(config('cashier.secret'));
 
            \Stripe\Subscription::update($sub->stripe_id, [
                'pause_collection' => ['behavior' => 'mark_uncollectible'],
            ]);
 
            $sub->stripe_status = 'paused';
            $sub->save();

   $planName= Plan::where('stripe_price_id', $sub->stripe_price)->first()?->name ?? 'Merit Learning Plan';        
        $data = [
            'first_name' => Auth::user()->name,
            'last_name'  => Auth::user()->last_name,
            'email'      => Auth::user()->email,
            'planName'   => $planName,
            'pauseDate'  => now()->format('d M Y'),
        ];

        Mail::to(Auth::user()->email)->send(new SubscriptionPauseMail($data));
            return back()->with('success', 'Subscription paused successfully.');
 
        } catch (\Exception $e) {
            Log::error('Admin pause error: ' . $e->getMessage());
            return back()->with('error', 'Could not pause: ' . $e->getMessage());
        }
    }
 
    // ── Resume (from paused OR grace period) ──────────────────────────────────
    public function resume($id)
    {
        $sub = Subscription::findOrFail($id);
 
        try {
            \Stripe\Stripe::setApiKey(config('cashier.secret'));
 
            if ($sub->stripe_status === 'paused') {
                // Remove pause_collection to resume
                \Stripe\Subscription::update($sub->stripe_id, [
                    'pause_collection' => '',
                ]);
                $sub->stripe_status = 'active';
                $sub->save();
 
            } else {
                // Resume from grace period (was cancel_at_period_end)
                \Stripe\Subscription::update($sub->stripe_id, [
                    'cancel_at_period_end' => false,
                ]);
                $sub->ends_at = null;
                $sub->save();
            }
 
            return back()->with('success', 'Subscription resumed successfully.');
 
        } catch (\Exception $e) {
            Log::error('Admin resume error: ' . $e->getMessage());
            return back()->with('error', 'Could not resume: ' . $e->getMessage());
        }
    }
 
    // ── Cancel at period end ──────────────────────────────────────────────────
    public function cancel($id)
    {
        $sub = Subscription::findOrFail($id);
 
        try {
            $sub->cancel(); // Cashier built-in — cancels at period end
 
            return back()->with('success', 'Subscription will cancel at period end.');
 
        } catch (\Exception $e) {
            Log::error('Admin cancel error: ' . $e->getMessage());
            return back()->with('error', 'Could not cancel: ' . $e->getMessage());
        }
    }
 
    // ── Cancel immediately ────────────────────────────────────────────────────
    public function cancelNow($id)
    {
        $sub = Subscription::findOrFail($id);
 
        try {
            $sub->cancelNow(); // Cashier built-in — immediate cancel
 
            return back()->with('success', 'Subscription cancelled immediately.');
 
        } catch (\Exception $e) {
            Log::error('Admin cancelNow error: ' . $e->getMessage());
            return back()->with('error', 'Could not cancel: ' . $e->getMessage());
        }
    }
}
