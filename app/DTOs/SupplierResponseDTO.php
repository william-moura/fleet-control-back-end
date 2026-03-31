<?php

namespace App\DTOs;

use App\Models\Supplier;

class SupplierResponseDTO
{
    public function __construct(
        public int $id,
        public string $fantasyName,
        public string $corporateName,
        public string $cnpj,
    ) {}
    public static function fromEntity(Supplier $supplier): self
    {
        return new self(
            id: $supplier->id,
            fantasyName: $supplier->supplier_fantasy_name,
            corporateName: $supplier->supplier_corporate_name,
            cnpj: $supplier->supplier_cnpj,
        );
    }
}