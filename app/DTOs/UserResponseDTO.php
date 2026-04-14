<?php

namespace App\DTOs;

use App\Models\User;
use App\DTOs\RoleResponseDTO;
class UserResponseDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public ?RoleResponseDTO $role,
    ) {}
    public static function fromEntity(User $user): self
    {
        return new self(
            id: $user->id,
            name: $user->name,
            email: $user->email,
            role: $user->roles->first() ? RoleResponseDTO::fromEntity($user->roles->first()) : null,
        );
    }
}