<?php

namespace App\Repositories\Contracts;

use App\DTOs\CreateRoleDTO;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Role;
use Illuminate\Pagination\LengthAwarePaginator;

interface RoleRepositoryInterface
{
    public function index(
        ?string $search = null,
        ?string $sort = null,
        ?string $sortDirection = null,
        ?int $page = 1,
        ?int $perPage = 5
    ): LengthAwarePaginator;
    public function createRole(CreateRoleDTO $dto): Role;
    public function updateRole(int $id, CreateRoleDTO $dto): Role;
    public function deleteRole(int $id): void;
    public function showRole(int $id): Role;
    public function assignPermissionToRole(int $roleId, int $permissionId): void;
    public function removePermissionFromRole(int $roleId, int $permissionId): void;
    public function getPermissionsForRole(int $roleId): Collection;
}