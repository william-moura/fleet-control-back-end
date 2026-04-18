<?php

namespace App\Repositories;

use App\DTOs\CreateUserDTO;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(private User $model){}
    public function index(
        ?string $search = null,
        ?string $sort = null,
        ?string $sortDirection = null,
        ?int $page = 1,
        ?int $perPage = 5
    ): LengthAwarePaginator
    {
        return $this->model->with('roles')->query()
        ->when($search, function($query) use ($search){
            return $query->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%");
        })->when($sort, function($query) use ($sort, $sortDirection){
            return $query->orderBy($sort, $sortDirection);
        })->when($page && $perPage, function($query) use ($page, $perPage){
            return $query->skip(($page - 1) * $perPage)->take($perPage);
        })->paginate($perPage, ['*'], 'page', $page);
    }
    public function createUser(CreateUserDTO $dto): User
    {
        return DB::transaction(function () use ($dto) {
            $user = $this->model->create($dto->toArray());
            $user->assignRole($dto->role_id);
            return $user;
        });
    }
    public function updateUser(int $id, CreateUserDTO $dto): User
    {
        return $this->model->find($id)->update($dto->toArray()) ? $this->model->find($id) : null;
    }
    public function deleteUser(int $id): void
    {
        $this->model->find($id)->delete();
    }
    public function showUser(int $id): User
    {
        return $this->model->find($id);
    }
    public function assignRoleToUser(int $userId, int $roleId): void
    {
        $this->model->find($userId)->assignRole($roleId);
    }
    public function removeRoleFromUser(int $userId, int $roleId): void
    {
        $this->model->find($userId)->removeRole($roleId);
    }
    public function assignPermissionToUser(int $userId, int $permissionId): void
    {
        $this->model->find($userId)->assignPermission($permissionId);
    }
    public function removePermissionFromUser(int $userId, int $permissionId): void
    {
        $this->model->find($userId)->removePermission($permissionId);
    }
}