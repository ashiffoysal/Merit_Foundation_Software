<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMessageMail extends Mailable
{
    use Queueable, SerializesModels;


    public function __construct($data)
    {
        $this->data = $data;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Contact Message Mail',
        );
    }


    public function content(): Content
    {
        return new Content(
            view: 'mail.contact_message.index',
            with: [
                'data' => $this->data,
            ],
        ); 

        $this->replyTo($this->data->email, $this->data->first_name . ' ' . $this->data->last_name);
    }


    public function attachments(): array
    {
        return [];
    }
}
