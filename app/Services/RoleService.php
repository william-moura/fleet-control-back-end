<?php

namespace App\Services;

use App\DTOs\CreateRoleDTO;
use App\DTOs\PermissionResponseDTO;
use App\DTOs\RoleResponseDTO;
use App\Repositories\Contracts\RoleRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleService
{
    public function __construct(protected RoleRepositoryInterface $repository)
    {
    }
    public function index(
        ?string $search = null,
        ?string $sort = null,
        ?string $sortDirection = null,
        ?int $page = 1,
        ?int $perPage = 5
    ): LengthAwarePaginator
    {
        $roles = $this->repository->index($search, $sort, $sortDirection, $page, $perPage);
        return $roles->through(fn(Role $role) => RoleResponseDTO::fromEntity($role));
    }
    public function createRole(CreateRoleDTO $dto): RoleResponseDTO
    {
        $role = $this->repository->createRole($dto);
        return RoleResponseDTO::fromEntity($role);
    }
    public function updateRole(int $id, CreateRoleDTO $dto): RoleResponseDTO
    {
        $role = $this->repository->updateRole($id, $dto);
        return RoleResponseDTO::fromEntity($role);
    }
    public function deleteRole(int $id): void
    {
        $this->repository->deleteRole($id);
    }
    public function showRole(int $id): RoleResponseDTO
    {
        $role = $this->repository->showRole($id);
        return RoleResponseDTO::fromEntity($role);
    }
    public function assignPermissionToRole(int $roleId, int $permissionId): void
    {
        $this->repository->assignPermissionToRole($roleId, $permissionId);
    }
    public function removePermissionFromRole(int $roleId, int $permissionId): void
    {
        $this->repository->removePermissionFromRole($roleId, $permissionId);
    }
    public function getPermissionsForRole(int $roleId): array
    {
        $permissions = $this->repository->getPermissionsForRole($roleId);
        return $permissions->map(fn(Permission $permission) => PermissionResponseDTO::fromEntity($permission))->toArray();
    }
}