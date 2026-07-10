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
    public function index(Request $request): JsonResponse
    {
        $users = $this->service->index(
            $request->search??null,
            $request->sort??null,
            $request->sortDirection??null,
            $request->page??1,
            $request->perPage??5
        );
        return response()->json($users, 200);
    }
    public function create(CreateUserRequest $request): JsonResponse
    {
        $dto = CreateUserDTO::fromRequest($request);
        $user = $this->service->create($dto);
        return response()->json(UserResponseDTO::fromEntity($user), 201);
    }
    public function getUser(int $id): JsonResponse
    {
        $user = $this->service->getUser($id);
        return response()->json($user, 200);
    }
}
