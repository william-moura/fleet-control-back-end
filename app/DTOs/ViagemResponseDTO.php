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
        public string $departureDate,
        public ?string $returnDate,
        public int $odometerDeparture,
        public ?int $odometerEntry,
        public string $origin,
        public string $destination,
        public ?VehicleResponseDTO $vehicle = null,
        public ?DriverResponseDTO $driver = null,
        public ?int $prefeituraId = null,
        public ?int $orgaoId = null,
        public ?int $secretariaId = null,
        public ?string $distanceKm = null,
        public ?string $travelTime = null,
    ) {
    }

    public static function fromEntity(Viagem $viagem, bool $simple = false): self
    {
        return new self(
            id: $viagem->id,
            vehicleId: $viagem->vehicle_id,
            driverId: $viagem->driver_id,
            departureDate: Carbon::parse($viagem->viagem_data_hora_saida)->format('d/m/Y H:i:s'),
            returnDate: $viagem->viagem_data_hora_chegada
                ? Carbon::parse($viagem->viagem_data_hora_chegada)->format('d/m/Y')
                : null,
            odometerDeparture: $viagem->viagem_odometro_saida,
            odometerEntry: $viagem->viagem_odometro_chegada,
            origin: $viagem->viagem_endereco_origem,
            destination: $viagem->viagem_endereco_destino,
            vehicle: $simple ? null : ($viagem->vehicle ? VehicleResponseDTO::fromEntity($viagem->vehicle) : null),
            driver: $simple ? null : ($viagem->driver ? DriverResponseDTO::fromEntity($viagem->driver) : null),
            prefeituraId: $viagem->vehicle->secretaria->orgao->prefeitura_id,
            orgaoId: $viagem->vehicle->secretaria->orgao_id,
            secretariaId: $viagem->vehicle->secretaria_id,
            distanceKm: $viagem->distancia_Km,
            travelTime: $viagem->tempo_viagem,
        );
    }
}
