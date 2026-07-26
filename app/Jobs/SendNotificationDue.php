<?php

namespace App\Jobs;

use App\Mail\DueDateVehicle;
use App\Models\AlertsDueDate;
use DateTimeImmutable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class SendNotificationDue implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $targetDate = Carbon::now()->addDays(10);
        $alerts = AlertsDueDate::whereDate('due_date', $targetDate)
        ->where('status', 'pending')
        ->with(['user', 'alertable'])
        ->get();        
        foreach ($alerts as $alert) {            
            $alert->user->notify(new \App\Notifications\DueDateVehicle( $alert->alertable, $alert->description, new DateTimeImmutable($alert->due_date)));
            $alert->update(['status' => 'sent']);
        }
    }
}
