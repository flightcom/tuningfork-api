<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Utils\Token;

class UserCreated extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $appUrl = config('app.url');
        $tokenLength = config('constants.password_token_length');
        $token = Token::getToken($tokenLength);

        return (new MailMessage())
            ->line('Votre compte vient d\'être créé. Veuillez suivre le lien suivant')
            ->line('pour définir votre mot de passe :')
            ->action(
                'Définir mon mot de passe',
                "$appUrl/password-reset/$token/?email=".$this->user->email)
            ->line('Bienvenue sur l\'instrumentèque !');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
        ];
    }
}
