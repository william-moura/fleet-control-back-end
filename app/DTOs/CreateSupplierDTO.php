<?php

namespace App\DTOs;

use App\Http\Requests\StoreSupplierRequest;

class CreateSupplierDTO
{
    public function __construct(
        public string $supplier_fantasy_name    ,
        public string $supplier_corporate_name,
        public string $supplier_cnpj,
        public ?string $supplier_ie = null,
        public ?string $supplier_address = null,
        public ?string $supplier_number = null,
        public ?string $supplier_complement = null,
        public ?string $supplier_neighborhood = null,
        public ?string $supplier_city = null,
        public ?string $supplier_state = null,
        public ?string $supplier_zip_code = null,
        public ?string $supplier_phone = null,
        public ?string $supplier_email = null,
        public int $supplier_status,
        public ?string $supplier_notes = null,
    ) {}

    public static function fromRequest(StoreSupplierRequest $request): self
    {
        return new self(
            supplier_fantasy_name: $request->supplierFantasyName,
            supplier_corporate_name: $request->supplierCorporateName,
            supplier_cnpj: $request->supplierCnpj,
            supplier_ie: $request->supplierIe,
            supplier_address: $request->supplierAddress,
            supplier_number: $request->supplierNumber,
            supplier_complement: $request->supplierComplement,
            supplier_neighborhood: $request->supplierNeighborhood,
            supplier_city: $request->supplierCity,
            supplier_state: $request->supplierState,
            supplier_zip_code: $request->supplierZipCode,
            supplier_phone: $request->supplierPhone,
            supplier_email: $request->supplierEmail,
            supplier_status: $request->supplierStatus,
            supplier_notes: $request->supplierNotes,
        );        
    }
    public function toArray(): array
    {
        return [
            'supplier_fantasy_name' => $this->supplier_fantasy_name,
            'supplier_corporate_name' => $this->supplier_corporate_name,
            'supplier_cnpj' => $this->supplier_cnpj,
            'supplier_ie' => $this->supplier_ie,
            'supplier_address' => $this->supplier_address,
            'supplier_number' => $this->supplier_number,
            'supplier_complement' => $this->supplier_complement,
            'supplier_neighborhood' => $this->supplier_neighborhood,
            'supplier_city' => $this->supplier_city,
            'supplier_state' => $this->supplier_state,
            'supplier_zip_code' => $this->supplier_zip_code,
            'supplier_phone' => $this->supplier_phone,
            'supplier_email' => $this->supplier_email,
            'supplier_status' => $this->supplier_status,
            'supplier_notes' => $this->supplier_notes,
        ];
    }
}