<?php

namespace App\Services;

use App\DTOs\CreateUserDTO;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class UserService
{
    public function __construct(protected UserRepositoryInterface $userRepository)
    {
    }
    public function index(): Collection
    {
        return $this->userRepository->index();
    }
    public function create(CreateUserDTO $dto): User
    {
        return $this->userRepository->createUser($dto);
    }
}