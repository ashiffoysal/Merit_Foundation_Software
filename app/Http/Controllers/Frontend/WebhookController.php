<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Cashier;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;

class WebhookController extends Controller
{
 public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sig     = $request->header('Stripe-Signature');

        // ── Verify signature ─────────────────────────────────────────────────
        try {
            $event = Webhook::constructEvent(
                $payload,
                $sig,
                config('cashier.webhook.secret')
            );
        } catch (SignatureVerificationException $e) {
            Log::error('Webhook signature failed: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid signature'], 400);
        } catch (\Exception $e) {
            Log::error('Webhook error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        }

        $type = $event->type;
        $data = $event->data->object;

        Log::info('✅ Stripe Webhook: ' . $type);

        match ($type) {
            'checkout.session.completed'     => $this->handleCheckoutCompleted($data),
            'customer.subscription.created'  => $this->handleSubscriptionCreated($data),
            'customer.subscription.updated'  => $this->handleSubscriptionUpdated($data),
            'customer.subscription.deleted'  => $this->handleSubscriptionDeleted($data),
            'customer.subscription.paused'   => $this->handleSubscriptionPaused($data),
            'customer.subscription.resumed'  => $this->handleSubscriptionResumed($data),
            'invoice.payment_succeeded'      => $this->handleInvoicePaid($data),
            'invoice.payment_failed'         => $this->handleInvoiceFailed($data),
            'payment_method.attached'        => $this->handlePaymentMethodAttached($data),
            default => Log::info('Unhandled event: ' . $type),
        };

        return response()->json(['success' => true], 200);
    }

    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Checkout completed → link customer to user, sync payment method & subscription.
     */
    private function handleCheckoutCompleted(object $session): void
    {
        $userId     = $session->metadata->user_id ?? null;
        $customerId = $session->customer          ?? null;

        if (!$userId || !$customerId) {
            Log::warning('checkout.session.completed: missing metadata.');
            return;
        }

        $user = User::find($userId);
        if (!$user) {
            Log::warning("User {$userId} not found.");
            return;
        }

        // ── Save stripe_id ───────────────────────────────────────────────────
        if (!$user->stripe_id) {
            $user->stripe_id = $customerId;
            $user->save();
        }

        // ── Sync payment method from Stripe customer ─────────────────────────
        $this->syncPaymentMethod($user, $customerId);

        // ── Sync subscriptions ───────────────────────────────────────────────
        $this->syncSubscriptions($user, $customerId);

        Log::info("✅ Checkout complete for user {$userId}");
    }

    /**
     * Sync payment method (pm_type, pm_last_four) from Stripe to users table.
     */
    private function syncPaymentMethod(User $user, string $customerId): void
    {
        try {
            $customer = Cashier::stripe()->customers->retrieve($customerId, [
                'expand' => ['default_source', 'invoice_settings.default_payment_method'],
            ]);

            $pm = $customer->invoice_settings->default_payment_method ?? null;

            if ($pm) {
                if (is_string($pm)) {
                    $pm = Cashier::stripe()->paymentMethods->retrieve($pm);
                }

                $user->pm_type      = $pm->type === 'card' ? $pm->card->brand : $pm->type;
                $user->pm_last_four = $pm->card->last4 ?? null;
                $user->save();

                Log::info("✅ Payment method synced for user {$user->id}: {$user->pm_type} ****{$user->pm_last_four}");
            }
        } catch (\Exception $e) {
            Log::error('syncPaymentMethod error: ' . $e->getMessage());
        }
    }

    /**
     * Sync all subscriptions from Stripe into the subscriptions table.
     */
    private function syncSubscriptions(User $user, string $customerId): void
    {
        try {
            $stripeSubs = Cashier::stripe()->subscriptions->all([
                'customer' => $customerId,
                'limit'    => 10,
            ]);

            foreach ($stripeSubs->data as $stripeSub) {
                $this->upsertSubscription($user, $stripeSub);
            }
        } catch (\Exception $e) {
            Log::error('syncSubscriptions error: ' . $e->getMessage());
        }
    }

    /**
     * Create or update a subscription row in DB.
     */
    private function upsertSubscription(User $user, object $stripeSub): void
    {
        $priceId  = $stripeSub->items->data[0]->price->id  ?? null;
        $quantity = $stripeSub->items->data[0]->quantity   ?? 1;
        $itemId   = $stripeSub->items->data[0]->id         ?? null;

        $endsAt = null;
        if ($stripeSub->cancel_at_period_end && $stripeSub->current_period_end) {
            $endsAt = Carbon::createFromTimestamp($stripeSub->current_period_end);
        }
        if ($stripeSub->status === 'canceled' && $stripeSub->ended_at) {
            $endsAt = Carbon::createFromTimestamp($stripeSub->ended_at);
        }

        // ── Upsert subscriptions table ───────────────────────────────────────
        $subscription = $user->subscriptions()->updateOrCreate(
            ['stripe_id' => $stripeSub->id],
            [
                'type'          => 'default',
                'stripe_status' => $stripeSub->status,
                'stripe_price'  => $priceId,
                'quantity'      => $quantity,
                'trial_ends_at' => $stripeSub->trial_end
                                    ? Carbon::createFromTimestamp($stripeSub->trial_end)
                                    : null,
                'ends_at'       => $endsAt,
            ]
        );

        // ── Upsert subscription_items table ──────────────────────────────────
        if ($itemId && $priceId) {
            $subscription->items()->updateOrCreate(
                ['stripe_id' => $itemId],
                [
                    'stripe_product' => $stripeSub->items->data[0]->price->product ?? null,
                    'stripe_price'   => $priceId,
                    'quantity'       => $quantity,
                ]
            );
        }

        Log::info("✅ Subscription upserted: {$stripeSub->id} [{$stripeSub->status}]");
    }

    private function handleSubscriptionCreated(object $stripeSub): void
    {
        $user = $this->getUserByCustomer($stripeSub->customer);
        if ($user) $this->upsertSubscription($user, $stripeSub);
    }

    private function handleSubscriptionUpdated(object $stripeSub): void
    {
        $user = $this->getUserByCustomer($stripeSub->customer);
        if ($user) $this->upsertSubscription($user, $stripeSub);
    }

    private function handleSubscriptionDeleted(object $stripeSub): void
    {
        $user = $this->getUserByCustomer($stripeSub->customer);
        if (!$user) return;

        $sub = $user->subscriptions()->where('stripe_id', $stripeSub->id)->first();
        if ($sub) {
            $sub->stripe_status = 'canceled';
            $sub->ends_at       = now();
            $sub->save();
            Log::info("✅ Subscription cancelled: {$stripeSub->id}");
        }
    }

    private function handleSubscriptionPaused(object $stripeSub): void
    {
        $user = $this->getUserByCustomer($stripeSub->customer);
        if (!$user) return;

        $sub = $user->subscriptions()->where('stripe_id', $stripeSub->id)->first();
        if ($sub) {
            $sub->stripe_status = 'paused';
            $sub->save();
            Log::info("✅ Subscription paused: {$stripeSub->id}");
        }
    }


    private function handleSubscriptionResumed(object $stripeSub): void
    {
        $user = $this->getUserByCustomer($stripeSub->customer);
        if (!$user) return;

        $sub = $user->subscriptions()->where('stripe_id', $stripeSub->id)->first();
        if ($sub) {
            $sub->stripe_status = 'active';
            $sub->ends_at       = null;
            $sub->save();
            Log::info("✅ Subscription resumed: {$stripeSub->id}");
        }
    }

    /**
     * Invoice paid → save to transactions table.
     */
    private function handleInvoicePaid(object $invoice): void
    {
        $user = $this->getUserByCustomer($invoice->customer);
        if (!$user) return;

        // Save to transactions table
        \DB::table('transactions')->updateOrInsert(
            ['stripe_invoice_id' => $invoice->id],
            [
                'user_id'           => $user->id,
                'stripe_invoice_id' => $invoice->id,
                'amount'            => $invoice->amount_paid / 100,
                'currency'          => strtoupper($invoice->currency),
                'status'            => 'paid',
                'description'       => $invoice->description ?? 'Subscription payment',
                'created_at'        => now(),
                'updated_at'        => now(),
            ]
        );

        Log::info("✅ Transaction saved for user {$user->id} — " . ($invoice->amount_paid / 100));
    }

    private function handleInvoiceFailed(object $invoice): void
    {
        $user = $this->getUserByCustomer($invoice->customer);
        if (!$user) return;

        \DB::table('transactions')->updateOrInsert(
            ['stripe_invoice_id' => $invoice->id],
            [
                'user_id'           => $user->id,
                'stripe_invoice_id' => $invoice->id,
                'amount'            => $invoice->amount_due / 100,
                'currency'          => strtoupper($invoice->currency),
                'status'            => 'failed',
                'description'       => 'Payment failed',
                'created_at'        => now(),
                'updated_at'        => now(),
            ]
        );

        Log::warning("❌ Payment failed for user {$user->id}");
    }

    private function handlePaymentMethodAttached(object $pm): void
    {
        if (!isset($pm->customer)) return;

        $user = $this->getUserByCustomer($pm->customer);
        if (!$user) return;

        if ($pm->type === 'card') {
            $user->pm_type      = $pm->card->brand;
            $user->pm_last_four = $pm->card->last4;
            $user->save();
            Log::info("✅ Payment method attached for user {$user->id}");
        }
    }

    // ── Helper ───────────────────────────────────────────────────────────────

    private function getUserByCustomer(string $customerId): ?User
    {
        return User::where('stripe_id', $customerId)->first();
    }
}