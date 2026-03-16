<?php

namespace App\DTOs;

class FuelTypeResponseDTO
{
    public function __construct(
        public int $id,
        public string $name,
    ) {}
    public static function fromEntity(object $fuelType): self
    {
        return new self(
            id: $fuelType->id,
            name: $fuelType->fuel_type_name,
        );
    }
}