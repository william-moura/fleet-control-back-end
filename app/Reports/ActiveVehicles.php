<?php

namespace App\Reports;

use App\Contracts\ReportContract;
use App\DTOs\GenerateReportDTO;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Collection;

class ActiveVehicles implements ReportContract
{
    public function getDados(GenerateReportDTO $dto): Collection
    {
        $result = Vehicle::query()
            ->with(['brand', 'fuelType', 'maxKilometer'])
            ->where('vehicle_status', 1)
            ->get()
            ->map(fn(object $vehicle) => [
                'vehicle_plate' => $vehicle->vehicle_plate,
                'vehicle_model' => $vehicle->vehicle_model,
                'vehicle_year' => $vehicle->vehicle_year,
                'vehicle_brand' => $vehicle->brand->brand_name,
                'vehicle_fuel_type' => $vehicle->fuelType->fuel_type_name,
                'vehicle_tank_capacity' => number_format($vehicle->vehicle_tank_capacity, 2, ',', '.'),
                'vehicle_current_mileage' => number_format($vehicle->maxKilometer?->kilometers_value ?? $vehicle->vehicle_current_mileage, 2, ',', '.'),
            ]);
        return new Collection($result);
    }

    public function getHeadings(): array
    {
        return [
            'vehicle_plate' => 'Placa',
            'vehicle_model' => 'Modelo',
            'vehicle_year' => 'Ano',
            'vehicle_brand' => 'Marca',
            'vehicle_fuel_type' => 'Tipo de Combustível',
            'vehicle_tank_capacity' => 'Capacidade do Tanque',
            'vehicle_current_mileage' => 'Kilometragem Atual',
        ];
    }

    public function getTitle(): string
    {
        return 'Veículos Ativos';
    }
}