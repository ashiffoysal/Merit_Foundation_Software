<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class RegisterVerifyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct($userId)
    {
        // $userId is what you pass from insertGetId()
        $this->user = User::find($userId);
    }

    public function build()
    {
        return $this->subject('Verify Your Email Address')
                    ->view('mail.verify');
    }
}
