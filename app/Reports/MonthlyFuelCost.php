<?php

namespace App\Reports;

use App\Contracts\ReportContract;
use App\DTOs\GenerateReportDTO;
use App\Models\FuelSupplier;
use Illuminate\Database\Eloquent\Collection;

class MonthlyFuelCost implements ReportContract
{
    public function getDados(GenerateReportDTO $dto): Collection
    {
        if (!$dto->startDate || !$dto->endDate) {
            throw new \Exception('Data de início e fim são obrigatórias');
        }
        $result = FuelSupplier::query()
            ->join('vehicles AS v', 'v.id', '=', 'fuel_suppliers.vehicle_id')
            ->whereRaw('YEAR(fuel_supplier_date) = ?', [now()->year])            
            ->selectRaw('DATE_FORMAT(fuel_supplier_date, "%m/%Y") as month')
            ->selectRaw('v.id as vehicle_id')
            ->selectRaw('SUM(fuel_supplier_total) as total_cost')
            ->selectRaw('CONCAT(v.vehicle_plate, " - ", v.vehicle_model) as vehicle')
            ->orderBy('month', 'asc')
            ->groupBy(['month', 'vehicle_id'])
            ->get()
            ->map(fn(object $fuelSupplier) => [
                'month' => $fuelSupplier->month,
                'total_cost' => 'R$ ' . number_format($fuelSupplier->total_cost, 2, ',', '.'),
                'vehicle' => $fuelSupplier->vehicle,
            ]);
        return new Collection($result);
    }

    public function getHeadings(): array
    {
        return [
            'month' => 'Mês',
            'total_cost' => 'Custo Total',
            'vehicle' => 'Veículo',
        ];
    }

    public function getTitle(): string
    {
        return 'Custo Mensal de Combustível por Veículo';
    }
}