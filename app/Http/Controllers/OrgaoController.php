<?php

namespace App\Http\Controllers;

use App\DTOs\CreateOrgaoDTO;
use App\Http\Requests\CreateOrgaoRequest;
use App\Services\OrgaoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrgaoController extends Controller
{
    public function __construct(private OrgaoService $orgaoService)
    {
    }

    public function index(Request $request): JsonResponse
    {
        return response()->json($this->orgaoService->getAllOrgaos(
            limit: $request->integer('limit', 10),
            page: $request->integer('page', 1),
            search: $request->string('search', ''),
            sort: $request->string('sort', 'created_at'),
            sortDirection: $request->string('sortDirection', 'desc'),
        ), 200);
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
    public function getNextRegistration(): JsonResponse
    {
        return response()->json($this->orgaoService->getNextRegistration(), 200);
    }
}
