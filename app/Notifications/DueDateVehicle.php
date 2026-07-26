<?php

namespace App\Notifications;

use App\Models\Vehicle;
use DateTimeImmutable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DueDateVehicle extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private Vehicle $vehicle, private string $description, private DateTimeImmutable $dueDate)
    {
        
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
        ->subject('FrotaSync - Notificações')
        ->line('Uma notificação está próxima de vencer')
        ->view('emails.notifications', ['vehicle' => $this->vehicle, 'user' => $notifiable, 'description' => $this->description, 'dueDate' => $this->dueDate]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'vehicle_id' => $this->vehicle->id,
            'vehicle_plate' => $this->vehicle->plate,
            'vehicle_brand' => $this->vehicle->brand,
            'vehicle_model' => $this->vehicle->model,
            'mensagem' => $notifiable->notificationDescription
        ];
    }
}
