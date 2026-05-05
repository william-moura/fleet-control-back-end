<?php

namespace App\DTOs;

use App\Http\Requests\CreateBrandRequest;

class CreateBrandDTO
{
    public function __construct(
        public string $brand_name,
    ) {}
    public static function fromRequest(CreateBrandRequest $request): self
    {
        return new self(brand_name: $request->input('name'));
    }
    public function toArray(): array
    {
        return [
            'brand_name' => $this->brand_name,
        ];
    }
}