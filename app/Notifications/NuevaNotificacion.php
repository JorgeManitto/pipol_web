<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NuevaNotificacion extends Notification
{
    use Queueable;

    public $mensaje;
    public $url;
    /**
     * Create a new notification instance.
     */
    public function __construct($mensaje, $url = null)
    {
        $this->mensaje = $mensaje;
        $this->url = $url ?? url('/dashboard');
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database', 'broadcast']; // canales
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable)
    {
        return (new MailMessage)
            ->subject('Nueva notificación')
            ->line($this->mensaje)
            ->action('Ver más', $this->url);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'mensaje' => $this->mensaje,
            'url' => $this->url,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'mensaje' => $this->mensaje,
            'url' => $this->url,
            'created_at' => now()->toDateTimeString(),
        ]);
    }
}
