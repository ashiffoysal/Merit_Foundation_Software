<?php

namespace App\Mail;
 
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Laravel\Cashier\Cashier;

class SubscriptionPauseMail extends Mailable
{
    use Queueable, SerializesModels;
 
    public User $user;
    public Subscription $subscription;
 
    // ---- Resolved, ready-to-print values passed straight to the view ----
    public string $planName;
    public string $pauseDate;
    public string $billingStatus;
 
    /**
     * @param User $user The subscriber whose subscription was paused.
     * @param Subscription $subscription The Cashier subscription row
     *        that was just paused (subscription->stripe_status === 'paused').
     */
    public function __construct(User $user, Subscription $subscription)
    {
        $this->user = $user;
        $this->subscription = $subscription;
 
        $this->resolveDisplayData();
    }
 
    /**
     * Turns the raw subscription model (+ a Stripe Price lookup) into
     * plain strings the Blade template can print directly.
     */
    protected function resolveDisplayData(): void
    {
        $productName = null;
 
        // Ask Stripe for the human-readable plan/product name tied to
        // this subscription's price. Wrapped in a try/catch so a Stripe
        // API hiccup never blocks the pause confirmation email from
        // sending.
        if ($this->subscription->stripe_price) {
            try {
                $price = Cashier::stripe()->prices->retrieve(
                    $this->subscription->stripe_price,
                    ['expand' => ['product']]
                );
 
                $productName = $price->product->name ?? $price->nickname ?? null;
            } catch (\Throwable $e) {
                report($e);
            }
        }
 
        $this->planName = $productName ?: 'Merit Learning Plan';
 
        // The subscription row's updated_at was just touched by the
        // pause() controller action, so it reflects the moment the
        // pause took effect.
        $this->pauseDate = $this->subscription->updated_at
            ? $this->subscription->updated_at->format('d M Y')
            : now()->format('d M Y');
 
        $this->billingStatus = 'On Hold — No Charges';
    }
 
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            to: [new Address($this->user->email, trim($this->user->name . ' ' . $this->user->last_name))],
            subject: 'Your Subscription Has Been Paused',
        );
    }
 
    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.pausemail',
            // text: 'emails.subscription.pause-text',
            with: [
                'user' => $this->user,
                'subscription' => $this->subscription,
                'planName' => $this->planName,
                'pauseDate' => $this->pauseDate,
                'billingStatus' => $this->billingStatus,
            ],
        );
    }
 
    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
