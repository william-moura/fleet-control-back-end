<?php

namespace App\Reports;

use App\Contracts\ReportContract;
use App\DTOs\GenerateReportDTO;
use App\Models\FuelSupplier;
use Illuminate\Database\Eloquent\Collection;

class ConsuptionByVehicle implements ReportContract
{
    public function getDados(GenerateReportDTO $dto): Collection
    {
        if (!$dto->startDate || !$dto->endDate) {
            throw new \Exception('Data de início e fim são obrigatórias');
        }
        $result = FuelSupplier::query()
            ->join('vehicles AS v', 'v.id', '=', 'fuel_suppliers.vehicle_id')            
            ->whereBetween('fuel_supplier_date', [$dto->startDate->format('Y-m-d'), $dto->endDate->format('Y-m-d')])
            ->when($dto->vehicleId, function($query) use ($dto) {
                $query->where('fuel_suppliers.vehicle_id', $dto->vehicleId);
            })
            ->select([
                'v.id'
            ])
            ->selectRaw('CONCAT(v.vehicle_plate, " - ", v.vehicle_model) as veículo')
            ->selectRaw('SUM(fuel_supplier_quantity) as quantity')
            ->selectRaw('SUM(fuel_suppliers.fuel_supplier_total) as total_cost')
            ->selectRaw('SUM(fuel_supplier_quantity) / SUM(fuel_supplier_total) as consumption')
            ->selectRaw('SUM(fuel_supplier_quantity) / SUM(fuel_supplier_total) * 100 as consumption_percentage')
            ->selectRaw('(MAX(fuel_supplier_kilometers) - MIN(fuel_supplier_kilometers)) / SUM(fuel_supplier_quantity) as consumption_per_liter')
            ->selectRaw('count(fuel_suppliers.id) as total_fuel_suppliers')
            ->groupBy(['v.id'])
            ->get()
            ->map(fn(object $fuelSupplier) => [
                'id' => $fuelSupplier->id,
                'vehicle_model' => $fuelSupplier->veículo,
                'quantity' => number_format($fuelSupplier->quantity, 2, ',', '.'),
                'consumption' => 'R$ ' . number_format($fuelSupplier->consumption, 2, ',', '.'),
                'consumption_percentage' => number_format($fuelSupplier->consumption_percentage, 2, ',', '.') . '%',
                'consumption_per_liter' => number_format($fuelSupplier->consumption_per_liter, 2, ',', '.') . ' km/l',
                'total_fuel_suppliers' => $fuelSupplier->total_fuel_suppliers,
            ]);
        return new Collection($result);
    }
    public function getHeadings(): array
    {
        return [
            'id' => 'ID',
            'vehicle_model' => 'Veículo',
            'quantity' => 'Quantidade',
            'consumption' => 'Custo médio por litro',
            'consumption_percentage' => 'Consumo Percentual',
            'consumption_per_liter' => 'Consumo por Litro',
            'total_fuel_suppliers' => 'Total de Abastecimentos',
        ];
    }
    public function getTitle(): string
    {
        return 'Consumo por Veículo';
    }
}