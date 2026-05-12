<?php

namespace App\DTOs;

use App\Http\Requests\VehicleFineRequest;
use DateTimeImmutable;

class CreateVehicleFineDTO
{
    public function __construct(
        public int $vehicleId,
        public int $driverId,
        public float $fineAmount,
        public DateTimeImmutable $fineDate,
        public string $fineType,
        public float $finePoints,
        public string $fineNotes,
        public int $fineStatus,
        public ?DateTimeImmutable $fineDueDate = null,
    ) {}
    public static function fromRequest(VehicleFineRequest $request): self
    {
        return new self(
            vehicleId: $request->vehicleId,
            driverId: $request->driverId,
            fineAmount: $request->fineAmount,
            fineDate: new DateTimeImmutable($request->fineDate),
            fineType: $request->fineType,
            finePoints: $request->finePoints,
            fineNotes: $request->fineNotes,
            fineStatus: $request->fineStatus,
            fineDueDate: $request->fineDueDate ? new DateTimeImmutable($request->fineDueDate) : null,
        );
    }

    public function toArray(): array
    {
        return [
            'vehicle_id' => $this->vehicleId,
            'driver_id' => $this->driverId,
            'vehicle_fine_amount' => $this->fineAmount,
            'vehicle_fine_date' => $this->fineDate,
            'vehicle_fine_level' => $this->fineType,
            'vehicle_fine_points' => $this->finePoints,
            'vehicle_fine_notes' => $this->fineNotes,
            'vehicle_fine_status' => $this->fineStatus,
            'vehicle_fine_paid_date' => $this->fineDueDate,
        ];
    }
}