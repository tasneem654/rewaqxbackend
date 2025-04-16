<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AdminResetPasswordNotification extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Reset Admin Password')
            ->line('Click the button below to reset your admin password:')
            ->action('Reset Password', url('/admin/reset-password/' . $this->token))
            ->line('If you didn\'t request this, no action is needed.');
    }
}
