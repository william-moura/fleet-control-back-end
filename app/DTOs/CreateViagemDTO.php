<?php

namespace App\DTOs;

use App\Http\Requests\CreateViagemRequest;
use Illuminate\Support\Carbon;

class CreateViagemDTO
{
    public function __construct(
        public int $vehicleId,
        public int $driverId,
        public string $dataHoraSaida,
        public ?string $dataHoraChegada,
        public int $odometroSaida,
        public ?int $odometroChegada,
        public string $enderecoOrigem,
        public string $enderecoDestino,
        public ?string $distanceKm,
        public ?string $travelTime,
    ) {
    }

    public static function fromRequest(CreateViagemRequest $request): self
    {
        return new self(
            vehicleId: $request->integer('vehicleId'),
            driverId: $request->integer('driverId'),
            dataHoraSaida: Carbon::createFromFormat('d/m/Y', $request->string('departureDate')->toString())->format('Y-m-d'),
            dataHoraChegada: Carbon::createFromFormat('d/m/Y', $request->string('returnDate')->toString())->format('Y-m-d'),
            odometroSaida: $request->integer('odometerDeparture'),
            odometroChegada: $request->filled('odometerEntry') ? $request->integer('odometerEntry') : null,
            enderecoOrigem: $request->string('origin')->toString(),
            enderecoDestino: $request->string('destination')->toString(),
            distanceKm: $request->string('distanceKm')->toString(),
            travelTime: $request->string('travelTime')->toString(),
        );
    }

    public function toArray(): array
    {
        return [
            'vehicle_id' => $this->vehicleId,
            'driver_id' => $this->driverId,
            'viagem_data_hora_saida' => $this->dataHoraSaida,
            'viagem_data_hora_chegada' => $this->dataHoraChegada,
            'viagem_odometro_saida' => $this->odometroSaida,
            'viagem_odometro_chegada' => $this->odometroChegada,
            'viagem_endereco_origem' => $this->enderecoOrigem,
            'viagem_endereco_destino' => $this->enderecoDestino,
            'distancia_Km' => $this->distanceKm,
            'tempo_viagem' => $this->travelTime,
        ];
    }
}
