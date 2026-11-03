<?php

namespace App\Console\Commands;

use App\Models\AlertsSetting;
use App\Models\MaintenanceControl;
use App\Models\User;
use App\Notifications\ManutencaoNotification;
use Illuminate\Console\Command;

class VerificarDiaManutencao extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:verificar-dia-manutencao';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispara e-mail para os administradores sobre veículos em dia de manutenção';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $alertSettings = AlertsSetting::where('alert_type', 'manutencao')->first();
        $maintenanceControls = MaintenanceControl::with('vehicle')->where('next_maintenance_date', '<', now()->addDays($alertSettings->days_before))->get();
        if ($maintenanceControls->isEmpty()) {
            $this->info('Nenhum veículo encontrado em dia de manutenção');
            return;
        }
        $admins = User::with('roles')->role('administrador')->get();
        foreach ($maintenanceControls as $vehicle) {
            foreach ($admins as $admin) {
                $admin->notify(new ManutencaoNotification($maintenanceControls->vehicle));
            }
        }
        $this->info('E-mails enviados para os administradores sobre veículos em dia de manutenção');
    }
}
