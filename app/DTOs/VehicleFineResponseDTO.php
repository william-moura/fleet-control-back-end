<?php

namespace App\DTOs;

use App\Models\VehicleFine;
use App\VehicleFineStatusEnum;

class VehicleFineResponseDTO
{
    public function __construct(
        public int $id,
        public int $vehicleId,
        public int $driverId,
        public float $fineAmount,
        public string $fineDate,
        public string $fineLevel,
        public float $finePoints,
        public string $fineNotes,
        public string $fineStatus,
        public string $finePaidDate,
        public VehicleResponseDTO $vehicle,
        public DriverResponseDTO $driver,
    ) {}
    public static function fromEntity(VehicleFine $vehicleFine): self
    {
        return new self(
            id: $vehicleFine->id,
            vehicleId: $vehicleFine->vehicle_id,
            driverId: $vehicleFine->driver_id,
            fineAmount: $vehicleFine->vehicle_fine_amount,
            fineDate: $vehicleFine->vehicle_fine_date?->format('Y-m-d'),
            fineLevel: $vehicleFine->vehicle_fine_level,
            finePoints: $vehicleFine->vehicle_fine_points,
            fineNotes: $vehicleFine->vehicle_fine_notes,
            fineStatus: VehicleFineStatusEnum::from($vehicleFine->vehicle_fine_status)->label(),
            finePaidDate: $vehicleFine->vehicle_fine_paid_date?->format('Y-m-d'),
            vehicle: VehicleResponseDTO::fromEntity($vehicleFine->vehicle),
            driver: DriverResponseDTO::fromEntity($vehicleFine->driver),
        );
    }
}