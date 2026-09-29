<?php

namespace App\Reports;

use App\Contracts\ReportContract;
use App\DTOs\GenerateReportDTO;
use App\Models\Viagem;
use Illuminate\Database\Eloquent\Collection;

class VehiclesTravels implements ReportContract
{
    public function getDados(GenerateReportDTO $dto): Collection
    {
        $result = Viagem::query()
            ->with(['vehicle', 'driver'])
            // ->whereBetween('viagem_data_hora_saida', [$dto->startDate->format('Y-m-d'), $dto->endDate->format('Y-m-d')])
            ->when($dto->startDate, function($query) use ($dto) {
                $query->whereBetween('viagem_data_hora_saida', [$dto->startDate->format('Y-m-d'), $dto->endDate->format('Y-m-d')]);
            })
            ->when($dto->driverId !== null, function($query) use ($dto) {
                $query->where('viagem.driver_id', $dto->driverId);
            })
            ->when($dto->vehicleId !== null, function($query) use ($dto) {
                $query->where('viagem.vehicle_id', $dto->vehicleId);
            })
            ->get()
            ->map(fn(Viagem $viagem) => [
                'vehicle' => $viagem->vehicle->vehicle_plate,
                'driver' => $viagem->driver->driver_name,
                'viagem_data_hora_saida' => $viagem->viagem_data_hora_saida->format('d/m/Y H:i:s'),
                'viagem_data_hora_chegada' => $viagem->viagem_data_hora_chegada->format('d/m/Y H:i:s'),
                'viagem_odometro_saida' => $viagem->viagem_odometro_saida,
                'viagem_odometro_chegada' => $viagem->viagem_odometro_chegada,
                'kilometers' => $viagem->distancia_Km,
                'destino' => $viagem->viagem_endereco_destino,
            ]);
        return new Collection($result);
    }
    public function getHeadings(): array
    {
        return [
            'vehicle' => 'Veículo',
            'driver' => 'Motorista',
            'viagem_data_hora_saida' => 'Data e hora de saída',
            'viagem_data_hora_chegada' => 'Data e hora de chegada',
            'viagem_odometro_saida' => 'Odômetro de saída',
            'viagem_odometro_chegada' => 'Odômetro de chegada',
            'kilometers' => 'Kilometros percorridos',
            'destino' => 'Destino',
        ];
    }
    public function getTitle(): string
    {
        return 'Relatório de utilização';
    }
}