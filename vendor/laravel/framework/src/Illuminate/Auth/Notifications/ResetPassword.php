<?php

namespace Illuminate\Auth\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends Notification
{
    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
        ->subject('Flexigigs account password reset')
        ->greeting('Hey '.$notifiable->username)
        ->line('We just got a request to change your password on Flexigigs’ system.')
        ->action('Click here to change your password', url(config('app.url').route('password.reset', $this->token, false)))
        ->line('Didn’t request a password change? Just ignore this message and keep using your current password.');
        // ->line('Regards from the Flexigigs Team!');
    }
}
