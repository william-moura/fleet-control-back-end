<?php

namespace App\DTOs;

class SyncedDriversResponseDTO
{
    public function __construct(
        public int $id,
        public string $driverName
    ) {
        $this->id = $id;
        $this->driverName = $driverName;
    }
    public static function fromEntity(object $driver): self
    {
        return new self(
            id: $driver->id,
            driverName: $driver->driver_name,
        );
    }
}