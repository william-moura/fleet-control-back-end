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
        if (!$dto->startDate || !$dto->endDate) {
            throw new \Exception('Data de início e fim são obrigatórias');
        }
        $result = FuelSupplier::query()
            ->with(['vehicle', 'driver', 'fuelType', 'supplier'])
            // ->whereBetween('viagem_data_hora_saida', [$dto->startDate->format('Y-m-d'), $dto->endDate->format('Y-m-d')])
            ->get()
            ->map(fn(FuelSupplier $viagem) => [
                'vehicle' => $viagem->vehicle->vehicle_plate . '' . $viagem->vehicle->vehicle_model ?? '',
                'driver' => $viagem->driver->driver_name,
                'fuelType' => $viagem->fuelType->fuel_type_name,
                'fuelSupplierPrice' => $viagem->fuel_supplier_total,
                'fuelSupplierQuantity' => $viagem->fuel_supplier_quantity,
                'fuelSupplierKilometers' => $viagem->fuel_supplier_kilometers,
                'supplier' => $viagem->supplier->supplier_name,
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