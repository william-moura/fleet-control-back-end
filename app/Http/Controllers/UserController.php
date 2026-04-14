<?php

namespace App\Http\Controllers;

use App\DTOs\CreateUserDTO;
use App\DTOs\UserResponseDTO;
use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(protected UserService $service)
    {
    }
    public function index(): JsonResponse
    {
        $users = $this->service->index();
        return response()->json($users->map(fn(User $user) => UserResponseDTO::fromEntity($user)), 200);
    }
    public function create(CreateUserRequest $request): JsonResponse
    {
        $dto = CreateUserDTO::fromRequest($request);
        $user = $this->service->create($dto);
        return response()->json(UserResponseDTO::fromEntity($user), 201);
    }
}
