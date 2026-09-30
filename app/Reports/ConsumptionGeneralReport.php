<?php

namespace App\Reports;

use App\Contracts\ReportContract;
use App\DTOs\GenerateReportDTO;
use App\Models\FuelSupplier;
use Illuminate\Database\Eloquent\Collection;

class ConsumptionGeneralReport implements ReportContract
{
    public function getDados(GenerateReportDTO $dto): Collection
    {
        $result = FuelSupplier::query()
            ->with(['vehicle', 'driver', 'fuelType', 'supplier'])
            ->when($dto->startDate, function($query) use ($dto) {
                $query->whereBetween('fuel_supplier_date', [$dto->startDate->format('Y-m-d'), $dto->endDate->format('Y-m-d')]);
            })
            ->when($dto->driverId !== null, function($query) use ($dto) {
                $query->where('fuel_suppliers.driver_id', $dto->driverId);
            })
            ->when($dto->vehicleIds !== null, function($query) use ($dto) {
                $query->whereIn('fuel_suppliers.vehicle_id', $dto->vehicleIds);
            })
            ->get()
            ->map(fn(FuelSupplier $viagem) => [
                'vehicle' => $viagem->vehicle->vehicle_plate . '' . $viagem->vehicle->vehicle_model ?? '',
                'driver' => $viagem->driver->driver_name,
                'fuelType' => $viagem->fuelType->fuel_type_name,
                'fuelSupplierPrice' => 'R$ ' . number_format($viagem->fuel_supplier_total, 2, ',', '.'),
                'fuelSupplierLiters' => number_format($viagem->fuel_supplier_quantity, 2, ',', '.'),
                'fuelSupplierKilometers' => number_format($viagem->fuel_supplier_kilometers, 2, ',', '.'),
                'supplier' => $viagem->supplier->supplier_corporate_name,
                'fuelSupplierDate' => $viagem->fuel_supplier_date->format('d/m/Y'),
            ]);
        return new Collection($result);
    }

    public function getHeadings(): array
    {
        return [
            'vehicle' => 'Veículo',
            'fuelSupplierDate' => 'Data',
            'fuelType' => 'Tipo de Combustível',
            'fuelSupplierLiters' => 'Litros',
            'fuelSupplierPrice' => 'Valor pago',
            'supplier' => 'Posto',
            'fuelSupplierKilometers' => 'Km no abastecimento',
            'driver' => 'Motorista',
        ];
    }

    public function getTitle(): string
    {
        return 'Relatório de Consumo Geral';
    }

}