<?php

namespace App\Services;

use App\DTOs\CreateUserDTO;
use App\DTOs\UserResponseDTO;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService
{
    public function __construct(protected UserRepositoryInterface $userRepository)
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
        $users = $this->userRepository->index($search, $sort, $sortDirection, $page, $perPage);
        return $users->through(fn(User $user) => UserResponseDTO::fromEntity($user));
    }
    public function create(CreateUserDTO $dto): User
    {
        return $this->userRepository->createUser($dto);
    }
    public function getUser(int $id): UserResponseDTO
    {
        $user = $this->userRepository->showUser($id);
        return UserResponseDTO::fromEntity($user);
    }
}