<?php

namespace App\DTOs;

use App\Http\Requests\CreateUserRequest;
use Illuminate\Http\Request;

class CreateUserDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public int $role_id,
    ) {}
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'role_id' => $this->role_id,
        ];
    }
    public static function fromRequest(CreateUserRequest $request): self
    {
        return new self(
            name: $request->input('name'),
            email: $request->input('email'),
            password: $request->input('password'),
            role_id: (int) $request->input('role_id'),
        );
    }
}