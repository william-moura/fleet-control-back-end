<?php

namespace App\DTOs;

class BrandResponseDTO
{
    public function __construct(
        public int $id,
        public string $name,
    ) {}
    public static function fromEntity(object $brand): self
    {
        return new self(
            id: $brand->id,
            name: $brand->brand_name,
        );
    }
}