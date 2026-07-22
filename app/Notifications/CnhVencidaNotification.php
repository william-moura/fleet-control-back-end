<?php

namespace App\Notifications;

use App\Models\Driver;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CnhVencidaNotification extends Notification
{
    use Queueable;

        

    /**
     * Create a new notification instance.
     */
    public function __construct(public Driver $driver)
    {
        $this->driver = $driver;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // return ['mail'];
        if ($notifiable instanceof Driver) {
            return ['mail'];
        }
        if ($notifiable instanceof User) {
            return ['database'];
        }

        return [];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
        ->subject('Atenção: sua CNH está vencida')
        ->greeting('Olá, ' . $this->driver->driver_name)
        ->line('Sua CNH está vencida. Por favor, renove-a o mais rápido possível.')
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
            'title' => 'Atenção: CNH está vencida',
            'message' => 'A CNH do motorista ' . $this->driver->driver_name . ' está vencida.',
            'driver_id' => $this->driver->id,
            'driver_name' => $this->driver->driver_name,
            'driver_license_expiration_date' => $this->driver->driver_license_expiration_date,
        ];
    }
}
