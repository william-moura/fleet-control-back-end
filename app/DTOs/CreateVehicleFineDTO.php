<?php

namespace App\DTOs;

use App\Http\Requests\VehicleFineRequest;
use DateTimeImmutable;

class CreateVehicleFineDTO
{
    public function __construct(
        public int $vehicle_id,
        public int $driver_id,
        public float $vehicle_fine_amount,
        public DateTimeImmutable $vehicle_fine_date,
        public string $vehicle_fine_level,
        public float $vehicle_fine_points,
        public string $vehicle_fine_notes,
        public int $vehicle_fine_status,
        public ?DateTimeImmutable $vehicle_fine_paid_date = null,
    ) {}
    public static function fromRequest(VehicleFineRequest $request): self
    {
        return new self(
            vehicle_id: $request->vehicleId,
            driver_id: $request->driverId,
            vehicle_fine_amount: $request->vehicleFineAmount,
            vehicle_fine_date: new DateTimeImmutable($request->vehicleFineDate),
            vehicle_fine_level: $request->vehicleFineLevel,
            vehicle_fine_points: $request->vehicleFinePoints,
            vehicle_fine_notes: $request->vehicleFineNotes,
            vehicle_fine_status: $request->vehicleFineStatus,
            vehicle_fine_paid_date: $request->vehicleFinePaidDate ? new DateTimeImmutable($request->vehicleFinePaidDate) : null,
        );
    }

    public function toArray(): array
    {
        return [
            'vehicle_id' => $this->vehicle_id,
            'driver_id' => $this->driver_id,
            'vehicle_fine_amount' => $this->vehicle_fine_amount,
            'vehicle_fine_date' => $this->vehicle_fine_date,
            'vehicle_fine_level' => $this->vehicle_fine_level,
            'vehicle_fine_points' => $this->vehicle_fine_points,
            'vehicle_fine_notes' => $this->vehicle_fine_notes,
            'vehicle_fine_status' => $this->vehicle_fine_status,
            'vehicle_fine_paid_date' => $this->vehicle_fine_paid_date,
        ];
    }
}