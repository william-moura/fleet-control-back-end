<?php

namespace App\DTOs;

use App\Http\Requests\StoreVehicleRequest;
use DateTimeImmutable;

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
        public ?DateTimeImmutable $vehiclePurchaseDate = null,
        public ?string $vehicleNotes = null,
    ) {}

    /**
     * Útil para instanciar a partir de um Request do Laravel ou Symfony
     */
    public static function fromArray(array $data): self
    {
        return new self(
            vehiclePlate: $data['vehiclePlate'],
            brandId: (int) $data['brandId'],
            vehicleModel: $data['vehicleModel'],
            vehicleYear: (int) $data['vehicleYear'],
            fuelTypeId: (int) $data['fuelTypeId'],
            vehicleTankCapacity: (float) $data['vehicleTankCapacity'],
            vehicleCurrentMileage: (int) $data['vehicleCurrentMileage'],
            vehicleStatus: $data['vehicleStatus'],
            vehiclePurchaseDate: isset($data['vehiclePurchaseDate']) 
                ? new DateTimeImmutable($data['vehiclePurchaseDate'])
                : null,
            vehicleNotes: $data['vehicleNotes'] ?? null,
        );
    }

    public static function fromRequest(StoreVehicleRequest $request): self
    {
        return new self(...$request->getAllData());
    }
}