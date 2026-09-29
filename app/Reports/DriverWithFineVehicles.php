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
        $result = VehicleFine::query()
            ->with(['vehicle', 'driver'])
            ->when($dto->startDate, function($query) use ($dto) {
                $query->whereBetween('vehicle_fine_date', [$dto->startDate->format('Y-m-d'), $dto->endDate->format('Y-m-d')]);
            })
            ->when($dto->driverId !== null, function($query) use ($dto) {
                $query->where('vehicle_fines.driver_id', $dto->driverId);
            })
            ->when($dto->vehicleId !== null, function($query) use ($dto) {
                $query->where('vehicle_fines.vehicle_id', $dto->vehicleId);
            })
            ->join('vehicles', 'vehicles.id', '=', 'vehicle_fines.vehicle_id')
            ->join('drivers', 'drivers.id', '=', 'vehicle_fines.driver_id')
            ->select(['drivers.id', 'drivers.driver_name', 'vehicle_fines.vehicle_fine_amount', 'vehicle_fines.vehicle_id', 'vehicle_fines.driver_id', 'vehicle_fines.vehicle_fine_date', 'vehicle_fines.vehicle_fine_level', 'vehicle_fines.vehicle_fine_notes'])
            ->selectRaw('SUM(vehicle_fines.vehicle_fine_amount) as total_fines, SUM(vehicle_fines.vehicle_fine_points) as total_points')
            ->groupBy(['drivers.id', 'drivers.driver_name', 'vehicle_fines.vehicle_fine_amount', 'vehicle_fines.vehicle_id', 'vehicle_fines.driver_id', 'vehicle_fines.vehicle_fine_date', 'vehicle_fines.vehicle_fine_level', 'vehicle_fines.vehicle_fine_notes'])
            ->orderBy('total_fines', 'desc')
            ->get()        
            ->map(fn(VehicleFine $vehicleFine) => [
                'driver' => $vehicleFine->driver_name?? 'Não informado',
                'total_amount' => 'R$ ' . number_format($vehicleFine->total_fines, 2, ',', '.'),
                'total_points' => $vehicleFine->total_points,
                'vehicle' => $vehicleFine->vehicle->vehicle_plate . ' - ' . $vehicleFine->vehicle->vehicle_model ?? '',
                'vehicle_fine_date' => $vehicleFine->vehicle_fine_date?->format('d/m/Y'),
                'vehicle_fine_level' => $vehicleFine->vehicle_fine_level,
                'description' => $vehicleFine->vehicle_fine_notes,
            ]);
        return new Collection($result);
    }
    public function getHeadings(): array
    {
        return [                        
            'driver' => 'Nome do Motorista',
            'total_amount' => 'Total de Multas',
            'total_points' => 'Total de Pontos',
            'vehicle' => 'Veículo',
            'vehicle_fine_date' => 'Data da Multa',
            'vehicle_fine_level' => 'Tipo de Infração',
            'description' => 'Descrição',
        ];
    }
    public function getTitle(): string
    {
        return 'Multas por Motorista';
    }
}