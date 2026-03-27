<?php

namespace App\DTOs;

class SyncedDriversResponseDTO
{
    public function __construct(
        public int $driverId,
        public string $driverName
    ) {
        $this->driverId = $driverId;
        $this->driverName = $driverName;
    }
    public static function fromEntity(object $driver): self
    {
        return new self(
            driverId: $driver->id,
            driverName: $driver->driver_name,
        );
    }
}