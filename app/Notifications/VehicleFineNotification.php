<?php

namespace App\Notifications;

use App\Models\User;
use App\Models\VehicleFine;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VehicleFineNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private Collection $vehicleFines)
    {
        $this->vehicleFines = $vehicleFines;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('FrotaSync - Vencimento de Multa')
            ->line('Você recebeu uma notificação de vencimento de multa')            
            ->view('emails.multas_vencendo', ['multas' => $this->vehicleFines, 'user' => $notifiable]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'FrotaSync - Vencimento de Multa',
            'message' => 'Você recebeu uma notificação de vencimento de multa',
            'data' => [
                'fines' => $this->vehicleFine,
            ],
        ];
    }
    public function toDatabase(object $notifiable): array
    {
        return $this->toArray($notifiable);
    }
}
