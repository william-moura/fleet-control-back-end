<?php

namespace App\Reports;

use App\Contracts\ReportContract;
use App\DTOs\GenerateReportDTO;
use App\Models\MaintenanceControl;
use App\Models\MaintenanceRelationService;
use Illuminate\Database\Eloquent\Collection;

class VehicleMaintenanceReport implements ReportContract
{
    public function getDados(GenerateReportDTO $dto): Collection
    {
        $result = MaintenanceControl::query()
            ->with(['vehicle', 'maintenanceRelationServices', 'supplier', 'maintenanceRelationServices.maintenanceService'])            
            ->when($dto->startDate, function($query) use ($dto) {
                $query->whereBetween('maintenance_control_date', [$dto->startDate->format('Y-m-d'), $dto->endDate->format('Y-m-d')]);
            })
            ->when($dto->vehicleIds !== null, function($query) use ($dto) {
                $query->whereIn('maintenance_control.vehicle_id', $dto->vehicleIds);
            })
            ->get()
            ->map(fn(MaintenanceControl $vehicleMaintenance) => [
                'vehicle' => $vehicleMaintenance->vehicle->vehicle_plate . ' ' . $vehicleMaintenance->vehicle->vehicle_model ?? '',                
                'services' => $vehicleMaintenance->maintenanceRelationServices->map(fn(MaintenanceRelationService $service) => $service->maintenanceService->maintenance_control_service_name)->implode(', '),
                'supplier' => $vehicleMaintenance->supplier->supplier_fantasy_name,
                'maintenanceControlDate' => $vehicleMaintenance->maintenance_control_date->format('d/m/Y'),
                'maintenanceControlKilometers' => $vehicleMaintenance->maintenance_control_kilometers,
                'maintenanceControlDescription' => $vehicleMaintenance->maintenance_control_description,
                'maintenanceControlTotalCost' => $vehicleMaintenance->maintenance_control_total_cost,
                'maintenanceControlNextDate' => $vehicleMaintenance->maintenance_control_next_date->format('d/m/Y'),                
            ]);
        return new Collection($result);
    }
    public function getHeadings(): array
    {
        return [
            'vehicle' => 'Veículo',
            'services' => 'Tipo de manutenção',
            'supplier' => 'Oficina',
            'maintenanceControlDate' => 'Data',
            'maintenanceControlTotalCost' => 'Valor total',
            'maintenanceControlKilometers' => 'Km',
            'maintenanceControlNextDate' => 'Próxima manutenção',
            'maintenanceControlDescription' => 'Descrição',
        ];
    }
    public function getTitle(): string
    {
        return 'Relatório de Manutenções de Veículos';
    }
}