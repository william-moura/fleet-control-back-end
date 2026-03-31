<?php

namespace App\DTOs;

use App\Http\Requests\StoreFuelSupplierRequest;
use DateTimeImmutable;

class CreateFuelSupplierDTO
{
    public function __construct(
        public int $supplier_id,
        public int $fuel_type_id,
        public int $driver_id,
        public int $vehicle_id,
        public float $fuel_supplier_price,
        public float $fuel_supplier_quantity,
        public float $fuel_supplier_total,
        public DateTimeImmutable $fuel_supplier_date,
        public float $fuel_supplier_kilometers,
        public string $fuel_supplier_notes,
        public int $fuel_supplier_status,
        public string $fuel_supplier_invoice_number,
    ) {}
    public function toArray(): array
    {
        return [
            'supplier_id' => $this->supplier_id,
            'fuel_type_id' => $this->fuel_type_id,
            'driver_id' => $this->driver_id,
            'vehicle_id' => $this->vehicle_id,
            'fuel_supplier_price' => $this->fuel_supplier_price,
            'fuel_supplier_quantity' => $this->fuel_supplier_quantity,
            'fuel_supplier_total' => $this->fuel_supplier_total,
            'fuel_supplier_date' => $this->fuel_supplier_date,
            'fuel_supplier_kilometers' => $this->fuel_supplier_kilometers,
            'fuel_supplier_notes' => $this->fuel_supplier_notes,
            'fuel_supplier_status' => $this->fuel_supplier_status,
            'fuel_supplier_invoice_number' => $this->fuel_supplier_invoice_number,
        ];
    }
    public static function fromRequest(StoreFuelSupplierRequest $request): self
    {
        return new self(
            supplier_id: $request->supplier_id,
            fuel_type_id: $request->fuel_type_id,
            driver_id: $request->driver_id,
            vehicle_id: $request->vehicle_id,
            fuel_supplier_price: $request->fuel_supplier_price,
            fuel_supplier_quantity: $request->fuel_supplier_quantity,
            fuel_supplier_total: $request->fuel_supplier_total,
            fuel_supplier_date: new DateTimeImmutable($request->fuel_supplier_date),
            fuel_supplier_kilometers: $request->fuel_supplier_kilometers,
            fuel_supplier_notes: $request->fuel_supplier_notes,
            fuel_supplier_status: $request->fuel_supplier_status,
            fuel_supplier_invoice_number: $request->fuel_supplier_invoice_number,
        );
    }
}