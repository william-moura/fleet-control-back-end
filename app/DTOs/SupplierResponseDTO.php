<?php

namespace App\DTOs;

use App\Models\Supplier;

class SupplierResponseDTO
{
    public function __construct(
        public int $id,
        public string $supplierFantasyName,
        public string $supplierCorporateName,
        public string $supplierCnpj,
        public ?string $supplierIe,
        public ?string $supplierAddress,
        public ?string $supplierNumber,
        public ?string $supplierComplement,
        public ?string $supplierNeighborhood,
        public ?string $supplierCity,
        public ?string $supplierState,
        public ?string $supplierZipCode,
        public ?string $supplierPhone,
        public ?string $supplierEmail,
        public ?string $supplierNotes,
        public int $supplierStatus,
    ) {}
    public static function fromEntity(Supplier $supplier): self
    {
        return new self(
            id: $supplier->id,
            supplierFantasyName: $supplier->supplier_fantasy_name,
            supplierCorporateName: $supplier->supplier_corporate_name,
            supplierCnpj: $supplier->supplier_cnpj,
            supplierIe: $supplier->supplier_ie,
            supplierAddress: $supplier->supplier_address,
            supplierNumber: $supplier->supplier_number,
            supplierComplement: $supplier->supplier_complement,
            supplierNeighborhood: $supplier->supplier_neighborhood,
            supplierCity: $supplier->supplier_city,
            supplierState: $supplier->supplier_state,
            supplierZipCode: $supplier->supplier_zip_code,
            supplierPhone: $supplier->supplier_phone,
            supplierEmail: $supplier->supplier_email,
            supplierNotes: $supplier->supplier_notes,
            supplierStatus: $supplier->supplier_status,
        );
    }
}