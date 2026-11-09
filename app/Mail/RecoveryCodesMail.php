<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RecoveryCodesMail extends Mailable
{
    use SerializesModels;

    public function __construct(
        public User $user,
        public array $codes
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Tus códigos de recuperación · ArrozConecta');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.recovery-codes');
    }
}
