<?php

namespace App\DTOs;

readonly class VehicleResponseDTO
{
    public function __construct(
        public int $id,
        public string $vehiclePlate,
        public int $brandId,
        public string $vehicleModel,
        public int $vehicleYear,
        public int $fuelTypeId,
        public float $vehicleTankCapacity,
        public int $vehicleCurrentMileage,
        public string $vehicleStatus,
        public ?string $vehiclePurchaseDate, // Formatado como string para JSON
        public ?string $vehicleNotes,
    ) {}

    /**
     * Útil para instanciar a partir de um Model do Eloquent ou Doctrine
     */
    public static function fromEntity(object $vehicle): self
    {
        return new self(
            id: $vehicle->id,
            vehiclePlate: $vehicle->vehicle_plate,
            brandId: $vehicle->brand_id,
            vehicleModel: $vehicle->vehicle_model,
            vehicleYear: $vehicle->vehicle_year,
            fuelTypeId: $vehicle->fuel_type_id,
            vehicleTankCapacity: (float) $vehicle->vehicle_tank_capacity,
            vehicleCurrentMileage: $vehicle->vehicle_current_mileage,
            vehicleStatus: $vehicle->vehicle_status,
            vehiclePurchaseDate: $vehicle->vehicle_purchase_date?->format('Y-m-d'),
            vehicleNotes: $vehicle->vehicle_notes,
        );
    }
}