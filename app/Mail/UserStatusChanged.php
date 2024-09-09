<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Modules\Users\Models\User;

class UserStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function envelope(): Envelope
    {
        $subject = match ($this->user->status) {
            User::REJECTED => 'Анкета отклонена',
            User::BLOCKED => 'Анкета заблокирована',
            User::PUBLISHED => 'Анкета опубликована',
            default => 'Статус анкеты изменён',
        };

        Log::info('User status changed', ['status' => gettype($this->user->status)]);

        return new Envelope(
            from: new Address(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME')),
            subject: $subject,
        );
    }

    public function content(): Content
    {
        $content = match ($this->user->status) {
            User::REJECTED => 'Анкета отклонена модератором. Попробуйте изменить фотографии или описание.',
            User::BLOCKED => 'Ваш профиль заблокирован. Обратитесь в службу поддержки.',
            User::PUBLISHED => 'Анкета была успешно опубликована.',
            default => 'Статус анкеты был изменён.',
        };

        return new Content(
            view: 'emails.user.status-changed',
            with: [
                'user' => $this->user,
                'content' => $content,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
