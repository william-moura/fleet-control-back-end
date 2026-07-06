<?php

namespace App\DTOs;

use App\Http\Requests\StoreKilometerRequest;
use DateTimeImmutable;

class CreateKilometerDTO
{
    public function __construct(
        public int $vehicle_id,
        public int $driver_id,
        public float $kilometers_value,
        public DateTimeImmutable $kilometers_date,
        public ?string $kilometers_notes = null,
        public int $kilometers_status = 1,
    ) {}
    public function toArray(): array
    {
        return [
            'vehicle_id' => $this->vehicle_id,
            'driver_id' => $this->driver_id,
            'kilometers_value' => $this->kilometers_value,
            'kilometers_date' => $this->kilometers_date,
            'kilometers_notes' => $this->kilometers_notes,
            'kilometers_status' => $this->kilometers_status,
        ];
    }
    public static function fromRequest(StoreKilometerRequest $request): self
    {
        return new self(
            vehicle_id: $request->vehicleId,
            driver_id: $request->driverId,
            kilometers_value: $request->kilometersValue,
            kilometers_date: new DateTimeImmutable($request->kilometersDate),
            kilometers_notes: $request->kilometersNotes,
            kilometers_status: $request->kilometersStatus?? 1,
        );
    }
}