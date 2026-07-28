<?php

namespace App\Console\Commands;

use App\Models\Driver;
use App\Models\User;
use App\Notifications\CnhVencidaNotification;
use Illuminate\Console\Command;

class VerificarCnhVencida extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:verificar-cnh-vencida';    

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispara e-mail para o motorista com CNH vencida';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $drivers = Driver::where('driver_license_expiration_date', '<', now())->get();
        if ($drivers->isEmpty()) {
            $this->info('Nenhum motorista encontrado com CNH vencida');
            return;
        }
        $admins = User::with('roles')->role('administrador')->get();
        foreach ($drivers as $driver) {
            $driver->notify(new CnhVencidaNotification($driver));
            foreach ($admins as $admin) {
                $admin->notify(new CnhVencidaNotification($driver));
            }
        }
        $this->info('E-mails disparados para ' . $drivers->count() . ' motoristas e ' . $admins->count() . ' administradores notificados');
    }
}
