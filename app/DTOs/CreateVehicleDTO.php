<?php

namespace App\DTOs;

use App\Http\Requests\StoreVehicleRequest;

readonly class CreateVehicleDTO
{
    public function __construct(
        public string $vehiclePlate,
        public int $brandId,
        public string $vehicleModel,
        public int $vehicleYear,
        public int $fuelTypeId,
        public float $vehicleTankCapacity,
        public int $vehicleCurrentMileage,
        public string $vehicleStatus,
        public ?\DateTimeImmutable $vehiclePurchaseDate = null,
        public ?string $vehicleNotes = null,
    ) {}

    /**
     * Útil para instanciar a partir de um Request do Laravel ou Symfony
     */
    public static function fromArray(array $data): self
    {
        return new self(
            vehiclePlate: $data['vehicle_plate'],
            brandId: (int) $data['brand_id'],
            vehicleModel: $data['vehicle_model'],
            vehicleYear: (int) $data['vehicle_year'],
            fuelTypeId: (int) $data['fuel_type_id'],
            vehicleTankCapacity: (float) $data['vehicle_tank_capacity'],
            vehicleCurrentMileage: (int) $data['vehicle_current_mileage'],
            vehicleStatus: $data['vehicle_status'],
            vehiclePurchaseDate: isset($data['vehicle_purchase_date']) 
                ? new \DateTimeImmutable($data['vehicle_purchase_date']) 
                : null,
            vehicleNotes: $data['vehicle_notes'] ?? null,
        );
    }

    public static function fromRequest(StoreVehicleRequest $request): self
    {
        return new self(...$request->validated());
    }
}