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
        $result = FuelSupplier::query()
            ->join('vehicles AS v', 'v.id', '=', 'fuel_suppliers.vehicle_id')
            //->where('vehicle_id', $vehicleId)
            ->whereBetween('fuel_supplier_date', [$dto->startDate->format('Y-m-d'), $dto->endDate->format('Y-m-d')])
            ->select([
                'v.id'                
                //'vehicles.vehicle_plate', 
                //'vehicles.vehicle_model'
            ])
            ->selectRaw('CONCAT(v.vehicle_plate, " - ", v.vehicle_model) as veículo')
            ->selectRaw('SUM(fuel_supplier_quantity) as quatidade')
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
                'quantity' => $fuelSupplier->quantidade,
                'consumption' => $fuelSupplier->consumption,
                'consumption_percentage' => $fuelSupplier->consumption_percentage,
                'consumption_per_liter' => $fuelSupplier->consumption_per_liter,
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
            'consumption' => 'Consumo',
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