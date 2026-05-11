<?php

namespace App\DTOs;

use App\Models\VehicleFine;

class VehicleFineResponseDTO
{
    public function __construct(
        public int $id,
        public int $vehicleId,
        public int $driverId,
        public float $vehicleFineAmount,
        public string $vehicleFineDate,
        public string $vehicleFineLevel,
        public float $vehicleFinePoints,
        public string $vehicleFineNotes,
        public int $vehicleFineStatus,
        public string $vehicleFinePaidDate,
        public VehicleResponseDTO $vehicle,
        public DriverResponseDTO $driver,
    ) {}
    public static function fromEntity(VehicleFine $vehicleFine): self
    {
        return new self(
            id: $vehicleFine->id,
            vehicleId: $vehicleFine->vehicle_id,
            driverId: $vehicleFine->driver_id,
            vehicleFineAmount: $vehicleFine->vehicle_fine_amount,
            vehicleFineDate: $vehicleFine->vehicle_fine_date,
            vehicleFineLevel: $vehicleFine->vehicle_fine_level,
            vehicleFinePoints: $vehicleFine->vehicle_fine_points,
            vehicleFineNotes: $vehicleFine->vehicle_fine_notes,
            vehicleFineStatus: $vehicleFine->vehicle_fine_status,
            vehicleFinePaidDate: $vehicleFine->vehicle_fine_paid_date,
            vehicle: VehicleResponseDTO::fromEntity($vehicleFine->vehicle),
            driver: DriverResponseDTO::fromEntity($vehicleFine->driver),
        );
    }
}