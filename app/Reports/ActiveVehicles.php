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
            ->with(['brand', 'fuelType', 'maxKilometer', 'secretarias'])
            // ->where('vehicle_status', 1)
            ->get()
            ->map(fn(object $vehicle) => [
                'vehicle_plate' => $vehicle->vehicle_plate,
                'vehicle_model' => $vehicle->vehicle_model,
                'vehicle_year' => $vehicle->vehicle_year,
                'vehicle_brand' => $vehicle->brand->brand_name,
                'vehicle_fuel_type' => $vehicle->fuelType->fuel_type_name,
                'vehicle_tank_capacity' => number_format($vehicle->vehicle_tank_capacity, 2, ',', '.'),
                'vehicle_current_mileage' => number_format($vehicle->maxKilometer?->kilometers_value ?? $vehicle->vehicle_current_mileage, 2, ',', '.'),
                'vehicle_status' => $this->getStatus($vehicle->vehicle_status),
                'secretaria' => $vehicle->secretarias->pluck('secretaria_name')->implode(', '),                
            ]);
        return new Collection($result);
    }

    public function getHeadings(): array
    {
        return [
            'vehicle_plate' => 'Placa',
            'vehicle_model' => 'Modelo',
            'vehicle_brand' => 'Marca',
            'vehicle_year' => 'Ano',
            'secretaria' => 'Secretaria/setor',
            'vehicle_status' => 'Situação',
            'vehicle_current_mileage' => 'Kilometragem Atual',
            'vehicle_fuel_type' => 'Combustível',            
        ];
    }

    public function getTitle(): string
    {
        return 'Relatório geral de Veículos';
    }

    private function getStatus(string $status): string
    {
        return match ($status) {
            '1' => 'Ativo',
            '0' => 'Inativo',
            '2' => 'Manutenção',
            default => $status,
        };
    }
}