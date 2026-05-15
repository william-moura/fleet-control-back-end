<?php

namespace App\DTOs;

use App\Http\Requests\CreateRoleRequest;

class CreateRoleDTO
{
    public function __construct(
        public string $name,
        public ?array $permissions = null,
    ) {}
    public static function fromRequest(CreateRoleRequest $request): self
    {
        return new self(
            name: $request->input('name'),
            permissions: $request->input('permissions'),
        );
    }
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'permissions' => $this->permissions,
        ];
    }
}