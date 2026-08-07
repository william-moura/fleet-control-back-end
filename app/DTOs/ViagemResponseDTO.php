<?php

namespace App\DTOs;

use App\Models\Viagem;
use Illuminate\Support\Carbon;

class ViagemResponseDTO
{
    public function __construct(
        public int $id,
        public int $vehicleId,
        public int $driverId,
        public string $dataHoraSaida,
        public ?string $dataHoraChegada,
        public int $odometroSaida,
        public ?int $odometroChegada,
        public string $enderecoOrigem,
        public string $enderecoDestino,
        public ?VehicleResponseDTO $vehicle = null,
        public ?DriverResponseDTO $driver = null,
    ) {
    }

    public static function fromEntity(Viagem $viagem, bool $simple = false): self
    {
        return new self(
            id: $viagem->id,
            vehicleId: $viagem->vehicle_id,
            driverId: $viagem->driver_id,
            dataHoraSaida: Carbon::parse($viagem->viagem_data_hora_saida)->format('Y-m-d H:i:s'),
            dataHoraChegada: $viagem->viagem_data_hora_chegada
                ? Carbon::parse($viagem->viagem_data_hora_chegada)->format('Y-m-d H:i:s')
                : null,
            odometroSaida: $viagem->viagem_odometro_saida,
            odometroChegada: $viagem->viagem_odometro_chegada,
            enderecoOrigem: $viagem->viagem_endereco_origem,
            enderecoDestino: $viagem->viagem_endereco_destino,
            vehicle: $simple ? null : ($viagem->vehicle ? VehicleResponseDTO::fromEntity($viagem->vehicle) : null),
            driver: $simple ? null : ($viagem->driver ? DriverResponseDTO::fromEntity($viagem->driver) : null),
        );
    }
}
