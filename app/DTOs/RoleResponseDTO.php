<?php

namespace App\DTOs;


class RoleResponseDTO
{
    public function __construct(
        public int $id,
        public string $name,
    ) {}
    public static function fromEntity(\Spatie\Permission\Models\Role $role): self
    {
        return new self(
            id: $role->id,
            name: $role->name,
        );
    }
}