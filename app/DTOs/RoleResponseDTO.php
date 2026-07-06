<?php

namespace App\DTOs;

use Spatie\Permission\Models\Permission;

class RoleResponseDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public array $permissions,
    ) {}
    public static function fromEntity(\Spatie\Permission\Models\Role $role): self
    {
        return new self(
            id: $role->id,
            name: $role->name,
            permissions: $role->permissions->map(fn(Permission $permission) => PermissionResponseDTO::fromEntity($permission))->toArray(),
        );
    }
}