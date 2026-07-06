<?php

namespace App\Http\Controllers;

use App\DTOs\CreateRoleDTO;
use App\DTOs\RoleResponseDTO;
use App\Http\Requests\CreateRoleRequest;
use App\Services\RoleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct(protected RoleService $service)
    {
    }
    public function index(Request $request): JsonResponse
    {
        $roles = $this->service->index(            
            $request->search??null,
            $request->sort??null,
            $request->sortDirection??null,
            $request->page??1,
            $request->per_page??5,
        );        
        return response()->json($roles, 200);
    }
    public function store(CreateRoleRequest $request): JsonResponse
    {
        $dto = CreateRoleDTO::fromRequest($request);
        $role = $this->service->createRole($dto);
        return response()->json($role, 201);
    }
    public function show($id): JsonResponse
    {
        $role = $this->service->showRole($id);
        return response()->json($role, 200);
    }
    public function update(CreateRoleRequest $request, $id): JsonResponse
    {
        $dto = CreateRoleDTO::fromRequest($request);
        $role = $this->service->updateRole($id, $dto);
        return response()->json($role, 200);
    }
    public function destroy($id): JsonResponse
    {
        $this->service->deleteRole($id);
        return response()->json(null, 204);
    }
}
