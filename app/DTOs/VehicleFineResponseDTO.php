<?php

namespace App\DTOs;

use App\Models\VehicleFine;
use App\VehicleFineStatusEnum;
use Illuminate\Support\Carbon;

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
        public ?string $fineNotes = null,
        public string $fineStatus,
        public string $finePaidDate,
        public ?VehicleResponseDTO $vehicle = null,
        public ?DriverResponseDTO $driver = null,
    ) {}
    public static function fromEntity(VehicleFine $vehicleFine, bool $simple = false): self
    {
        return new self(
            id: $vehicleFine->id,
            vehicleId: $vehicleFine->vehicle_id,
            driverId: $vehicleFine->driver_id,
            fineAmount: $vehicleFine->vehicle_fine_amount,
            fineDate: Carbon::parse($vehicleFine->vehicle_fine_date)->format('Y-m-d'),
            fineLevel: $vehicleFine->vehicle_fine_level,
            finePoints: $vehicleFine->vehicle_fine_points,
            fineNotes: $vehicleFine->vehicle_fine_notes ?? null,
            fineStatus: VehicleFineStatusEnum::from($vehicleFine->vehicle_fine_status)->label(),
            finePaidDate: Carbon::parse($vehicleFine->vehicle_fine_paid_date)->format('Y-m-d'),
            vehicle: $simple ? null : ($vehicleFine->vehicle ? VehicleResponseDTO::fromEntity($vehicleFine->vehicle) : null),
            driver: $simple ? null : ($vehicleFine->driver ? DriverResponseDTO::fromEntity($vehicleFine->driver) : null),
        );
    }
}