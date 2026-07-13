<?php

namespace App\DTOs;

use App\Models\Driver;
use App\Models\FuelSupplier;
use App\Models\Kilometer;
use App\Models\MaintenanceControl;
use App\Models\Media;
use App\Models\Vehicle;
use App\Models\VehicleFine;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

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
        public ?Collection $drivers,
        public ?Collection $photos,
        public ?float $totalFines = null,
        public ?float $totalKilometersCost = null,
        public ?string $vehicleChassisNumber = null,
        public ?string $vehicleRenavamNumber = null,
        public ?string $vehicleColor = null,
        public ?string $vehicleTransmissionType = null,
        public ?int $vehicleModelYear = null,        
        public ?Collection $maintenances = null,
        public ?Collection $fuelSuppliers = null,
        public ?Collection $fines = null,
    ) {}

    /**
     * Útil para instanciar a partir de um Model do Eloquent ou Doctrine
     */
    public static function fromEntity(Vehicle $vehicle, bool $simple = false): self
    {
        $divisor = $vehicle->maxKilometer?->kilometers_value ?? $vehicle->vehicle_current_mileage;
        if ($divisor == 0) {
            $divisor = 1;
        }
        $totalKilometersCost = ($vehicle->fines?->sum('vehicle_fine_amount') ?? 0 + $vehicle->fuelSuppliers?->sum('fuel_supplier_total') ?? 0 + $vehicle->maintenances?->sum('maintenance_control_total_cost') ?? 0 ) / $divisor;
        return new self(
            id: $vehicle->id,
            vehiclePlate: $vehicle->vehicle_plate,
            brandId: $vehicle->brand->id,            
            vehicleModel: $vehicle->vehicle_model,
            vehicleYear: $vehicle->vehicle_year,
            fuelTypeId: $vehicle->fuelType->id,
            vehicleTankCapacity: (float) $vehicle->vehicle_tank_capacity,
            vehicleCurrentMileage: $vehicle->maxKilometer?->kilometers_value ?? $vehicle->vehicle_current_mileage,
            vehicleStatus: ($vehicle->vehicle_status == 1 ? 'ativo' : 'inativo'),
            vehiclePurchaseDate: Carbon::parse($vehicle->vehicle_purchase_date)->format('Y-m-d'),
            vehicleNotes: $vehicle->vehicle_notes,
            brand: strtoupper($vehicle->brand->brand_name),
            fuelType: $vehicle->fuelType->fuel_type_name,
            drivers: $vehicle->drivers->count() > 0 ? $vehicle->drivers->map(fn(Driver $driver) => DriverResponseDTO::fromEntity($driver)) : null,
            photos: $vehicle->media->map(fn(Media $media) => PhotoResponseDTO::fromEntity($media)),
            totalFines: $vehicle->fines?->sum('vehicle_fine_amount') ?? 0,
            totalKilometersCost: $totalKilometersCost,
            vehicleChassisNumber: $vehicle->vehicle_chassis_number,
            vehicleRenavamNumber: $vehicle->vehicle_renavam_number,
            vehicleColor: $vehicle->vehicle_color,
            vehicleTransmissionType: $vehicle->vehicle_transmission_type,
            vehicleModelYear: $vehicle->vehicle_model_year,            
            maintenances: !$simple ? $vehicle->maintenances->map(fn(MaintenanceControl $maintenance) => MaintenanceResponseDTO::fromEntity($maintenance)) : null,
            fuelSuppliers: $vehicle->fuelSuppliers->map(fn(FuelSupplier $fuelSupplier) => FuelSupplierResponseDTO::fromEntity($fuelSupplier, true)),
            fines: $vehicle->fines->map(fn(VehicleFine $fine) => VehicleFineResponseDTO::fromEntity($fine, true)),
        );
    }
}