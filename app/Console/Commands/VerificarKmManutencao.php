<?php

namespace App\Console\Commands;

use App\Models\AlertsSetting;
use App\Models\MaintenanceControl;
use App\Models\User;
use App\Models\Vehicle;
use App\Notifications\KmManutencaoNotification;
use Illuminate\Console\Command;

class VerificarKmManutencao extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:verificar-km-manutencao';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $alertSettings = AlertsSetting::where('alert_type', 'kmManutencao')->first();
        $maintenances = MaintenanceControl::with(['vehicle' => function ($query) use ($alertSettings) {
            $query->withHas('maxKilometer')->whereHas('maxKilometer', function ($query) use ($alertSettings) {
                $query->where('kilometers_value', '>=', $alertSettings->days_before);
            });
        }])->get();
        if ($maintenances->isEmpty()) {
            $this->info('Nenhum veículo encontrado com km de manutenção');
            return;
        }
        $admins = User::with('roles')->role('administrador')->get();
        foreach ($maintenances as $maintenance) {            
            foreach ($admins as $admin) {
                $admin->notify(new KmManutencaoNotification($maintenance->vehicle));
            }
        }
    }
}
