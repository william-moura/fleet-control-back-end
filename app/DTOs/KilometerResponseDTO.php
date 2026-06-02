<?php

namespace App\DTOs;

use App\Models\Kilometer;
use DateTimeImmutable;
use Illuminate\Support\Carbon;
class KilometerResponseDTO
{
    public function __construct(
        public int $id,
        public int $vehicleId,
        public ?int $driverId = null,
        public float $kilometersValue,
        public string $kilometersDate,
        public ?string $kilometersNotes = null,
        public int $kilometersStatus,
        public ?VehicleResponseDTO $vehicle = null,
    ) {}
    public static function fromEntity(Kilometer $kilometer): self
    {
        return new self(
            id: $kilometer->id,
            vehicleId: $kilometer->vehicle_id,
            driverId: $kilometer->driver_id ?? null,
            kilometersValue: $kilometer->kilometers_value,
            kilometersDate: Carbon::parse($kilometer->kilometers_date)->format('Y-m-d'),
            kilometersNotes: $kilometer->kilometers_notes,
            kilometersStatus: $kilometer->kilometers_status,
            vehicle: $kilometer->vehicle ? VehicleResponseDTO::fromEntity($kilometer->vehicle) : null,
        );
    }
}