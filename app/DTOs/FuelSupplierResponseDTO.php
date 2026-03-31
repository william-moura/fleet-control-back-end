<?php

namespace App\DTOs;

use App\Models\FuelSupplier;

class FuelSupplierResponseDTO
{
    public function __construct(
        public int $id,
        public int $supplier_id,
        public int $fuel_type_id,
        public int $driver_id,
        public int $vehicle_id,
        public float $fuel_supplier_price,
        public float $fuel_supplier_quantity,
        public float $fuel_supplier_total,
        public string $fuel_supplier_date,
        public float $fuel_supplier_kilometers,
        public string $fuel_supplier_notes,
        public int $fuel_supplier_status,
        public string $fuel_supplier_invoice_number,
    ) {}

    public static function fromEntity(FuelSupplier $fuelSupplier): self
    {
        return new self(
            id: $fuelSupplier->id,
            supplier_id: $fuelSupplier->supplier_id,
            fuel_type_id: $fuelSupplier->fuel_type_id,
            driver_id: $fuelSupplier->driver_id,
            vehicle_id: $fuelSupplier->vehicle_id,
            fuel_supplier_price: $fuelSupplier->fuel_supplier_price,
            fuel_supplier_quantity: $fuelSupplier->fuel_supplier_quantity,
            fuel_supplier_total: $fuelSupplier->fuel_supplier_total,
            fuel_supplier_date: $fuelSupplier->fuel_supplier_date,
            fuel_supplier_kilometers: $fuelSupplier->fuel_supplier_kilometers,
            fuel_supplier_notes: $fuelSupplier->fuel_supplier_notes,
            fuel_supplier_status: $fuelSupplier->fuel_supplier_status,
            fuel_supplier_invoice_number: $fuelSupplier->fuel_supplier_invoice_number,
        );
    }
}