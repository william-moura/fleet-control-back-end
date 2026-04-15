<?php

namespace App\DTOs;

use Spatie\Permission\Models\Permission;

class PermissionResponseDTO
{
    public function __construct(
        public int $id,
        public string $name,
    ) {}
    public static function fromEntity(Permission $permission): self
    {
        return new self(
            id: $permission->id,
            name: $permission->name,
        );
    }
}