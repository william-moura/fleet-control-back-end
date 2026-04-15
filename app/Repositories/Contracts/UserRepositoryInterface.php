<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;
use App\DTOs\CreateUserDTO;
use App\Models\User;

interface UserRepositoryInterface
{
    public function index(): Collection;
    public function createUser(CreateUserDTO $dto): User;
    public function updateUser(int $id, CreateUserDTO $dto): User;
    public function deleteUser(int $id): void;
    public function showUser(int $id): ?User;
    public function assignRoleToUser(int $userId, int $roleId): void;
    public function removeRoleFromUser(int $userId, int $roleId): void;
    public function assignPermissionToUser(int $userId, int $permissionId): void;
    public function removePermissionFromUser(int $userId, int $permissionId): void;
}