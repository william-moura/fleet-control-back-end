<?php

namespace App\DTOs;

use App\Models\FuelSupplier;
use Illuminate\Support\Carbon;

class FuelSupplierResponseDTO
{
    public function __construct(
        public int $id,
        public int $supplierId,
        public int $fuelTypeId,
        public int $driverId,
        public int $vehicleId,
        public float $fuelSupplierPrice,
        public float $fuelSupplierQuantity,
        public float $fuelSupplierTotal,
        public string $fuelSupplierDate,
        public float $fuelSupplierKilometers,
        public ?string $fuelSupplierNotes = null,
        public int $fuelSupplierStatus,
        public string $fuelSupplierInvoiceNumber,
        public SupplierResponseDTO $supplier,
        public FuelTypeResponseDTO $fuelType,
        public DriverResponseDTO $driver,
        public VehicleResponseDTO $vehicle,
    ) {}

    public static function fromEntity(FuelSupplier $fuelSupplier): self
    {
        return new self(
            id: $fuelSupplier->id,
            supplierId: $fuelSupplier->supplier_id,
            fuelTypeId: $fuelSupplier->fuel_type_id,
            driverId: $fuelSupplier->driver_id,
            vehicleId: $fuelSupplier->vehicle_id,
            fuelSupplierPrice: $fuelSupplier->fuel_supplier_price,
            fuelSupplierQuantity: $fuelSupplier->fuel_supplier_quantity,
            fuelSupplierTotal: $fuelSupplier->fuel_supplier_total,
            fuelSupplierDate: Carbon::parse($fuelSupplier->fuel_supplier_date)->format('Y-m-d'),
            fuelSupplierKilometers: $fuelSupplier->fuel_supplier_kilometers,
            fuelSupplierNotes: $fuelSupplier->fuel_supplier_notes,
            fuelSupplierStatus: $fuelSupplier->fuel_supplier_status,
            fuelSupplierInvoiceNumber: $fuelSupplier->fuel_supplier_invoice_number,
            supplier: SupplierResponseDTO::fromEntity($fuelSupplier->supplier),
            fuelType: FuelTypeResponseDTO::fromEntity($fuelSupplier->fuelType),
            driver: DriverResponseDTO::fromEntity($fuelSupplier->driver),
            vehicle: VehicleResponseDTO::fromEntity($fuelSupplier->vehicle),
        );
    }
}