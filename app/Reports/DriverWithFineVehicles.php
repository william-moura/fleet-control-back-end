<?php

namespace App\Reports;

use App\Contracts\ReportContract;
use App\DTOs\GenerateReportDTO;
use App\Models\FuelSupplier;
use App\Models\VehicleFine;
use Illuminate\Database\Eloquent\Collection;

class DriverWithFineVehicles implements ReportContract
{
    public function getDados(GenerateReportDTO $dto): Collection
    {
        if (!$dto->startDate || !$dto->endDate) {
            throw new \Exception('Data de início e fim são obrigatórias');
        }
        $result = VehicleFine::query()
            ->with(['vehicle', 'driver'])
            ->whereBetween('vehicle_fine_date', [$dto->startDate->format('Y-m-d'), $dto->endDate->format('Y-m-d')])
            ->join('vehicles', 'vehicles.id', '=', 'vehicle_fines.vehicle_id')
            ->join('drivers', 'drivers.id', '=', 'vehicle_fines.driver_id')
            ->select(['drivers.id', 'drivers.driver_name', 'vehicle_fines.vehicle_fine_amount'])
            ->selectRaw('SUM(vehicle_fines.vehicle_fine_amount) as total_fines, SUM(vehicle_fines.vehicle_fine_points) as total_points')
            ->groupBy(['drivers.id', 'drivers.driver_name', 'vehicle_fines.vehicle_fine_amount'])
            ->orderBy('total_fines', 'desc')
            ->get()
            ->map(fn(object $vehicleFine) => [
                'driver' => $vehicleFine->driver_name?? 'Não informado',
                'total_amount' => 'R$ ' . number_format($vehicleFine->total_fines, 2, ',', '.'),
                'total_points' => $vehicleFine->total_points,
            ]);
        return new Collection($result);
    }
    public function getHeadings(): array
    {
        return [                        
            'driver' => 'Nome do Motorista',
            'total_amount' => 'Total de Multas',
            'total_points' => 'Total de Pontos',
        ];
    }
    public function getTitle(): string
    {
        return 'Multas por Motorista';
    }
}