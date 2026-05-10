<?php

namespace App\Reports;

use App\Contracts\ReportContract;
use App\DTOs\GenerateReportDTO;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Collection;

class VehicleHigherCost implements ReportContract
{
    public function getDados(GenerateReportDTO $dto): Collection
    {
        if (!$dto->startDate || !$dto->endDate) {
            throw new \Exception('Data de início e fim são obrigatórias');
        }
        $result = Vehicle::query()
            ->leftJoin('fuel_suppliers', function($join) use ($dto) {
                $join->on('fuel_suppliers.vehicle_id', '=', 'vehicles.id')
                    ->whereBetween('fuel_supplier_date', [$dto->startDate->format('Y-m-d'), $dto->endDate->format('Y-m-d')]);
            })
            ->leftJoin('maintenance_control', function($join) use ($dto) {
                $join->on('maintenance_control.vehicle_id', '=', 'vehicles.id')
                    ->whereBetween('maintenance_control_date', [$dto->startDate->format('Y-m-d'), $dto->endDate->format('Y-m-d')]);
            })
            ->select(['vehicles.id', 'vehicles.vehicle_plate', 'vehicles.vehicle_model'])
            ->selectRaw('COALESCE(SUM(fuel_suppliers.fuel_supplier_total), 0) + COALESCE(SUM(maintenance_control.maintenance_control_total_cost), 0) as total_cost')
            ->groupBy(['vehicles.id', 'vehicles.vehicle_plate', 'vehicles.vehicle_model'])
            ->orderBy('total_cost', 'desc')
            ->get()
            ->map(fn(object $vehicle) => [                
                'vehicle_plate' => $vehicle->vehicle_plate,
                'vehicle_model' => $vehicle->vehicle_model,
                'total_cost' => 'R$ ' . number_format($vehicle->total_cost, 2, ',', '.'),
            ]);
        return new Collection($result);
    }

    public function getHeadings(): array
    {
        return [
            'vehicle_plate' => 'Placa',
            'vehicle_model' => 'Modelo',
            'total_cost' => 'Custo Total',
        ];
    }

    public function getTitle(): string
    {
        return 'Veículos com Maior Custo';
    }
}