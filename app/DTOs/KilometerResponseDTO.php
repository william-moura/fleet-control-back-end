<?php

namespace App\DTOs;

use App\Models\Kilometer;
use DateTimeImmutable;
class KilometerResponseDTO
{
    public function __construct(
        public int $id,
        public int $vehicleId,
        public int $driverId,
        public float $kilometersValue,
        public DateTimeImmutable $kilometersDate,
        public ?string $kilometersNotes = null,
        public int $kilometersStatus,
    ) {}
    public static function fromEntity(Kilometer $kilometer): self
    {
        return new self(
            id: $kilometer->id,
            vehicleId: $kilometer->vehicle_id,
            driverId: $kilometer->driver_id,
            kilometersValue: $kilometer->kilometers_value,
            kilometersDate: new DateTimeImmutable($kilometer->kilometers_date),
            kilometersNotes: $kilometer->kilometers_notes,
            kilometersStatus: $kilometer->kilometers_status,
        );
    }
}