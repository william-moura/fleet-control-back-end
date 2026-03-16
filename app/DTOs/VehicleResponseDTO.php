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
        public ?string $brand,
        public ?string $fuelType,
    ) {}

    /**
     * Útil para instanciar a partir de um Model do Eloquent ou Doctrine
     */
    public static function fromEntity(object $vehicle): self
    {
        return new self(
            id: $vehicle->id,
            vehiclePlate: $vehicle->vehicle_plate,
            brandId: $vehicle->brand->id,            
            vehicleModel: $vehicle->vehicle_model,
            vehicleYear: $vehicle->vehicle_year,
            fuelTypeId: $vehicle->fuelType->id,
            vehicleTankCapacity: (float) $vehicle->vehicle_tank_capacity,
            vehicleCurrentMileage: $vehicle->vehicle_current_mileage,
            vehicleStatus: ($vehicle->vehicle_status == 1 ? 'ativo' : 'inativo'),
            vehiclePurchaseDate: $vehicle->vehicle_purchase_date?->format('d/m/Y'),
            vehicleNotes: $vehicle->vehicle_notes,
            brand: $vehicle->brand->brand_name,
            fuelType: $vehicle->fuelType->fuel_type_name,
        );
    }
}