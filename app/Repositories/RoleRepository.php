<?php

namespace App\Repositories;

use App\DTOs\CreateRoleDTO;
use App\Repositories\Contracts\RoleRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleRepository implements RoleRepositoryInterface
{
    public function __construct(private Role $model){}
    public function index(
        ?string $search = null,
        ?string $sort = null,
        ?string $sortDirection = null,
        ?int $page = 1,
        ?int $perPage = 5
    ): LengthAwarePaginator
    {
        return $this->model->with('permissions')->when($search, function($query) use ($search){
            return $query->where('name', 'like', "%$search%");
        })->when($sort, function($query) use ($sort, $sortDirection){
            return $query->orderBy($sort, $sortDirection);
        })->when($page && $perPage, function($query) use ($page, $perPage){
            return $query->skip(($page - 1) * $perPage)->take($perPage);
        })->paginate($perPage, ['*'], 'page', $page);
    }
    public function createRole(CreateRoleDTO $dto): Role
    {
        return DB::transaction(function () use ($dto) {
            $role = $this->model->create($dto->toArray());
            $role->givePermissionTo($dto->permissions);
            return $role;
        });
    }
    public function updateRole(int $id, CreateRoleDTO $dto): Role
    {
        return DB::transaction(function () use ($id, $dto) {
            $role = $this->model->find($id);
            $role->update($dto->toArray());
            $role->syncPermissions($dto->permissions);
            return $role;
        });
    }
    public function deleteRole(int $id): void
    {
        $role = $this->model->find($id);        
        if (!$role) {
            throw new \Exception('Role not found');
        }
        $role->users()->detach();
        $role->permissions()->detach();
        $role->delete();
    }
    public function showRole(int $id): Role
    {
        return $this->model->find($id);
    }
    public function assignPermissionToRole(int $roleId, int $permissionId): void
    {
        $this->model->find($roleId)->permissions()->attach($permissionId);
    }
    public function removePermissionFromRole(int $roleId, int $permissionId): void
    {
        $this->model->find($roleId)->permissions()->detach($permissionId);
    }
    public function getPermissionsForRole(int $roleId): Collection
    {
        return $this->model->find($roleId)->permissions;
    }
}