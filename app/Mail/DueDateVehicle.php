<?php

namespace App\Mail;

use App\Models\Vehicle;
use DateTimeImmutable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\SerializesModels;

class DueDateVehicle extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(private Vehicle $vehicle, private string $description, private DateTimeImmutable $dueDate)
    {
        //        
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    public function via(object $notifiable): array
    {        
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        // dd($this->dueDate);
        return (new MailMessage)
        ->subject('FrotaSync - Notificações')
        ->line('Uma notificação está próxima de vencer')
        ->view('emails.notifications', ['vehicle' => $this->vehicle, 'user' => $notifiable, 'description' => $this->description, 'dueDate' => $this->dueDate]);
    }
}
