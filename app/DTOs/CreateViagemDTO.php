<?php

namespace App\DTOs;

use App\Http\Requests\CreateViagemRequest;

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
    ) {
    }

    public static function fromRequest(CreateViagemRequest $request): self
    {
        return new self(
            vehicleId: $request->integer('vehicleId'),
            driverId: $request->integer('driverId'),
            dataHoraSaida: $request->string('dataHoraSaida')->toString(),
            dataHoraChegada: $request->input('dataHoraChegada'),
            odometroSaida: $request->integer('odometroSaida'),
            odometroChegada: $request->filled('odometroChegada') ? $request->integer('odometroChegada') : null,
            enderecoOrigem: $request->string('enderecoOrigem')->toString(),
            enderecoDestino: $request->string('enderecoDestino')->toString(),
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
        ];
    }
}
