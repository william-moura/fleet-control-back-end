<?php

namespace App\Http\Controllers;

use App\DTOs\CreateOrgaoDTO;
use App\Http\Requests\CreateOrgaoRequest;
use App\Services\OrgaoService;
use Illuminate\Http\JsonResponse;

class OrgaoController extends Controller
{
    public function __construct(private OrgaoService $orgaoService)
    {
    }

    public function index(): JsonResponse
    {
        return response()->json($this->orgaoService->getAllOrgaos(), 200);
    }

    public function store(CreateOrgaoRequest $request): JsonResponse
    {
        $orgao = $this->orgaoService->createOrgao(CreateOrgaoDTO::fromRequest($request));

        return response()->json($orgao, 201);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json($this->orgaoService->getOrgaoById($id), 200);
    }

    public function update(CreateOrgaoRequest $request, int $id): JsonResponse
    {
        $orgao = $this->orgaoService->updateOrgao(CreateOrgaoDTO::fromRequest($request), $id);

        return response()->json($orgao, 200);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->orgaoService->deleteOrgao($id);

        return response()->json(null, 204);
    }
}
