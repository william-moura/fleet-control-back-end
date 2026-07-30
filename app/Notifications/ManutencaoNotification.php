<?php

namespace App\Notifications;

use App\Models\Vehicle;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ManutencaoNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Vehicle $vehicle)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Atenção: veículo em dia de manutenção')
            ->greeting('Olá')
            ->line('O veículo ' . $this->vehicle->vehicle_model . ' está proximo da data de manutenção.')
            ->line('Atenciosamente, ' . config('app.name'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Atenção: Veículo proximo da data de manutenção',
            'message' => 'O veículo ' . $this->vehicle->vehicle_model . '-' . $this->vehicle->vehicle_plate . ' está proximo da data de manutenção.'
        ];
    }
}
