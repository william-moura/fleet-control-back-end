<?php

namespace App\Reports;

use App\Contracts\ReportContract;
use App\DTOs\GenerateReportDTO;
use App\Models\Driver;
use Illuminate\Database\Eloquent\Collection;

class DriverGeneralReport implements ReportContract
{
    public function getDados(GenerateReportDTO $dto): Collection
    {
        if (!$dto->startDate || !$dto->endDate) {
            throw new \Exception('Data de início e fim são obrigatórias');
        }
        $result = Driver::query()
            ->with(['vehicles', 'vehicleFines', 'trips'])
            // ->whereBetween('driver_hire_date', [$dto->startDate->format('Y-m-d'), $dto->endDate->format('Y-m-d')])
            ->get()
            ->map(fn(Driver $driver) => [
                'driver' => $driver->driver_name,
                'driver_hire_date' => $driver->driver_hire_date,
                'driver_vehicles' => $driver->vehicles->pluck('vehicle_plate')->implode(', '),
                'total_trips' => $driver->trips->count(),
                'total_kilometers' => $driver->vehicleFines->sum('vehicle_fine_distance'),
                'total_fines' => $driver->vehicleFines->sum('vehicle_fine_amount'),
                'total_points' => $driver->vehicleFines->sum('vehicle_fine_points'),
                'occurrences' => $driver->vehicleFines->pluck('vehicle_fine_notes')->implode(', '),
            ]);
        return new Collection($result);
    }
    public function getHeadings(): array
    {
        return [
            'driver' => 'Motorista',
            'cnh' => 'CNH/Categoria',
            'driver_vehicles' => 'Veículos associados',
            'total_trips' => 'Quantidade de viagens',
            'total_kilometers' => 'Kilometragem total percorrida',
            'total_fines' => 'Total de multas',
            'total_points' => 'Total de pontos',
            'occurrences' => 'Ocorrências',
        ];
    }
    public function getTitle(): string
    {
        return 'Relatório geral de motoristas';
    }
}