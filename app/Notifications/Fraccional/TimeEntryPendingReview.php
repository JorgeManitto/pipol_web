<?php
namespace App\Notifications\Fraccional;

use App\Models\Fraccional\TimeEntry;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\{Notification, Messages\MailMessage};

class TimeEntryPendingReview extends Notification
{
    use Queueable;

    public function __construct(public TimeEntry $entry) {}

    public function via($notifiable): array { return ['mail']; }

    public function toMail($notifiable): MailMessage
    {
        $entry = $this->entry;
        return (new MailMessage)
            ->subject('Nuevas horas para revisar · Pipol Fraccional')
            ->greeting("Hola {$notifiable->name},")
            ->line("{$entry->professional->name} cargó {$entry->hours} hs trabajadas el {$entry->worked_on->format('d/m/Y')}.")
            ->line("Tarea: {$entry->description}")
            ->line('Tenés 72hs para aprobarlas o iniciar un reclamo. Si no respondés, se aprueban automáticamente.')
            ->action('Revisar ahora', route('fraccional.chat.show', $entry->contract->engagement));
    }
}