<?php

namespace App\Reports;

use App\Contracts\ReportContract;
use App\DTOs\GenerateReportDTO;
use App\Models\FuelSupplier;
use Illuminate\Database\Eloquent\Collection;

class ConsuptionByDriver implements ReportContract
{
    public function getDados(GenerateReportDTO $dto): Collection
    {
        if (!$dto->startDate || !$dto->endDate) {
            throw new \Exception('Data de início e fim são obrigatórias');
        }
        $result = FuelSupplier::query()
            ->join('drivers AS d', 'd.id', '=', 'fuel_suppliers.driver_id')
            ->whereBetween('fuel_supplier_date', [$dto->startDate->format('Y-m-d'), $dto->endDate->format('Y-m-d')])
            ->select([
                'd.id',
                'd.driver_name'
            ])
            ->selectRaw('SUM(fuel_supplier_quantity) as quantity')
            ->selectRaw('SUM(fuel_supplier_total) as total')
            ->selectRaw('COUNT(fuel_suppliers.id) as quantity_suppliers')            
            ->groupBy(['d.id', 'd.driver_name'])
            ->get()
            ->map(fn(object $fuelSupplier) => [                
                'driver_name' => $fuelSupplier->driver_name,
                'quantity_liters' => number_format($fuelSupplier->quantity, 2, ',', '.'),
                'total_cost' => 'R$ ' . number_format($fuelSupplier->total, 2, ',', '.'),
                'quantity_suppliers' => $fuelSupplier->quantity_suppliers,
            ]);
        return new Collection($result);
    }

    public function getHeadings(): array
    {
        return [
            'driver_name' => 'Motorista',
            'quantity_liters' => 'Quantidade de Litros',
            'total_cost' => 'Custo Total',
            'quantity_suppliers' => 'Quantidade de Abastecimentos',
        ];
    }

    public function getTitle(): string
    {
        return 'Consumo por Motorista';
    }
}