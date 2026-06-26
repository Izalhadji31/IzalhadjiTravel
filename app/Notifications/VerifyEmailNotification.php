<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyEmailNotification extends Notification
{
    use Queueable;

    /**
     * The email verification URL.
     */
    public string $verificationUrl;

    /**
     * The user's name.
     */
    public string $userName;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $verificationUrl, string $userName = 'Pengguna')
    {
        $this->verificationUrl = $verificationUrl;
        $this->userName = $userName;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Verifikasi Email - ASR GO')
            ->view('emails.verify-email', [
                'verificationUrl' => $this->verificationUrl,
                'userName' => $this->userName,
                'user' => $notifiable,
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'verificationUrl' => $this->verificationUrl,
        ];
    }
}
