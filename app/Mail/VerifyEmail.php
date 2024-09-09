<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Modules\Users\Models\User;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected User $user;
    protected string $token;

    public function __construct(User $user, string $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME')),
            subject: 'Подтверждение почты',
        );
    }

    public function content(): Content
    {
        $url = route('email.verify', ['user_id' => $this->user->id, 'token' => $this->token]);

        return new Content(
            view: 'emails.email.verify-email',
            with: [
                'url' => $url,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
