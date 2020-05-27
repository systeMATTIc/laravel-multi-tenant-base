<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TenantCreated extends Notification
{
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // todo use lang
        $loginUrl = "http://{$notifiable->tenant->domain}/login";

        $password = session()->get('tenant_admin.pass');
        session()->forget('tenant_admin.pass');

        return (new MailMessage)
                    ->subject('Welcome to App')
                    ->greeting('Hello, ' . $notifiable->first_name)
                    ->line('You have been provisioned as the administrator for your organisation.')
                    ->line('Your assigned password is ' . $password)
                    ->action('Login to your account', $loginUrl)
                    ->line('Thanks for choosing us!');
    }


    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        // todo -> use lang 
        return [
            'title' => 'Welcome to App',
            'message' => "Your account has been setup as the administrator for your organisation. Do ensure to change your password."
        ];
    }
}
