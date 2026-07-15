<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Laravel\Cashier\Cashier;
use Carbon\Carbon;

class SubscriptionCancelledMail extends Mailable
{
   use Queueable, SerializesModels;

    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Subscription Cancelled',
            replyTo: [
                new Address(
                    $this->data['email'],
                    $this->data['first_name'].' '.$this->data['last_name']
                ),
            ],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.cancelsubscription',
            with: [
                'data' => $this->data,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}