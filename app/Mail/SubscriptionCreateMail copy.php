<?php

namespace App\Mail;


use App\Models\User;
use App\Models\Subscription;
use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Laravel\Cashier\Cashier;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SubscriptionCreateMail extends Mailable
{
    
    use Queueable, SerializesModels;
 
    public User $user;
    public ?string $planId;
    public ?Subscription $subscription;
    public ?Transaction $transaction;
 
    // ---- Resolved, ready-to-print values passed straight to the view ----
    public string $planName;
    public string $billingCycle;
    public string $subscriptionStatus;
    public string $amount;
    public string $currencySymbol;
    public string $currencyCode;
    public string $paymentMethod;
    public string $transactionId;
    public string $invoiceNumber;
    public string $purchaseDate;
    public string $startDate;
    public string $renewalDate;
 
    /**
     * @param User $user The newly subscribed customer.
     * @param string|null $planId The internal plan identifier passed
     *        through Stripe Checkout session metadata (metadata.plan_id).
     *        Kept for reference/logging; display data is resolved from
     *        the user's latest subscription + transaction instead, since
     *        those rows are guaranteed to reflect what Stripe actually
     *        charged.
     */
    public function __construct(User $user, ?string $planId = null)
    {
        $this->user = $user;
        $this->planId = $planId;
 
        // Most recently created subscription row for this user.
        $this->subscription = Subscription::where('user_id', $user->id)
            ->latest('created_at')
            ->first();
 
        // Most recent Stripe invoice/transaction for this user.
        $this->transaction = Transaction::where('user_id', $user->id)
            ->latest('created_at')
            ->first();
 
        $this->resolveDisplayData();
    }
 
    /**
     * Turns the raw model data (+ a Stripe Price lookup) into plain
     * strings the Blade template can print directly.
     */
    protected function resolveDisplayData(): void
    {
        $interval = 'month';
        $productName = null;
 
        if ($this->subscription && $this->subscription->stripe_price) {
            try {
                $price = Cashier::stripe()->prices->retrieve(
                    $this->subscription->stripe_price,
                    ['expand' => ['product']]
                );
 
                $productName = $price->product->name ?? $price->nickname ?? null;
                $interval = $price->recurring->interval ?? 'month';
            } catch (\Throwable $e) {
                report($e);
            }
        }
 
        $this->planName = $productName ?: 'Merit Learning Plan';
        $this->billingCycle = $interval === 'year' ? 'Yearly' : 'Monthly';
 
        $this->subscriptionStatus = $this->subscription
            ? ucfirst($this->subscription->stripe_status)
            : 'Active';
 
        // --- Amount / currency, from the transactions table ---
        $this->amount = $this->transaction
            ? number_format((float) $this->transaction->amount, 2)
            : '0.00';
 
        $currencyCode = $this->transaction ? strtoupper($this->transaction->currency) : 'USD';
        $this->currencyCode = $currencyCode;
        $this->currencySymbol = $this->currencySymbolFor($currencyCode);
 
        // --- Payment method, from the users table (Cashier pm_type/pm_last_four) ---
        $this->paymentMethod = $this->user->pm_type
            ? (ucfirst($this->user->pm_type) . ' •••• ' . $this->user->pm_last_four)
            : 'Card on file';
 
        // --- IDs ---
        $this->transactionId = $this->transaction->stripe_invoice_id ?? ($this->subscription->stripe_id ?? 'N/A');
        $this->invoiceNumber = $this->transaction
            ? ('INV-' . str_pad((string) $this->transaction->id, 6, '0', STR_PAD_LEFT))
            : 'N/A';
 
        // --- Dates ---
        $purchasedAt = $this->transaction?->created_at ?? $this->subscription?->created_at ?? now();
        $startedAt = $this->subscription?->created_at ?? now();
 
        $this->purchaseDate = Carbon::parse($purchasedAt)->format('d M Y');
        $this->startDate = Carbon::parse($startedAt)->format('d M Y');
        $this->renewalDate = Carbon::parse($startedAt)
            ->copy()
            ->addMonths($interval === 'year' ? 12 : 1)
            ->format('d M Y');
    }
 
    protected function currencySymbolFor(string $code): string
    {
        return match ($code) {
            'USD' => '$',
            'GBP' => '£',
            'EUR' => '€',
            default => $code . ' ',
        };
    }
 
    /**
     * Build the message.
     */
    public function build(): self
    {
        return $this
            ->to($this->user->email, trim($this->user->name . ' ' . $this->user->last_name))
            ->subject("Welcome! Your Subscription is Now Active 🎉")
            ->view('mail.successmail')
            // ->text('emails.subscription.create-text')
            ->with([
                'user' => $this->user,
                'subscription' => $this->subscription,
                'transaction' => $this->transaction,
                'planName' => $this->planName,
                'billingCycle' => $this->billingCycle,
                'subscriptionStatus' => $this->subscriptionStatus,
                'amount' => $this->amount,
                'currencySymbol' => $this->currencySymbol,
                'currencyCode' => $this->currencyCode,
                'paymentMethod' => $this->paymentMethod,
                'transactionId' => $this->transactionId,
                'invoiceNumber' => $this->invoiceNumber,
                'purchaseDate' => $this->purchaseDate,
                'startDate' => $this->startDate,
                'renewalDate' => $this->renewalDate,
            ]);
    }
}
