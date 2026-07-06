<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\VehicleFine;
use App\Notifications\VehicleFineNotification;
use App\VehicleFineStatusEnum;
use Illuminate\Console\Command;
use Illuminate\Notifications\Notification;

class NotificationVehicleFineExpire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notification-vehicle-fine-expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notifica os usuarios sobre multas próximas ao vencimento';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $vehicleFines = VehicleFine::with(['vehicle'])
            ->with(['vehicle', 'driver'])
            ->where('vehicle_fine_paid_date', '<=', now()->addDays(10))
            // ->where('vehicle_fine_paid_date', '>=', now()->addDays(5))
            ->where('vehicle_fine_status', VehicleFineStatusEnum::PENDING)
            ->get();
        $users = User::whereHas('roles', function($query) {
            $query->where('name', 'administrador');
        })->get();
        // foreach ($vehicleFines as $vehicleFine) {
        //     $vehicleFine->driver->notify(new VehicleFineNotification($vehicleFine));
        // }
        if ($vehicleFines->isNotEmpty()) {
            $users = User::whereHas('roles', function($query) {
                $query->where('name', 'administrador');
            })->get();
            \Illuminate\Support\Facades\Notification::send($users, new VehicleFineNotification($vehicleFines));
        }
    }
}
