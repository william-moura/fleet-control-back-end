<?php

namespace App\Http\Controllers;

use App\DTOs\CreateSecretariaDTO;
use App\Http\Requests\CreateSecretariaRequest;
use App\Services\SecretariaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SecretariaController extends Controller
{
    public function __construct(private SecretariaService $secretariaService)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $limit = $request->input('limit', 10);
        $page = $request->input('page', 1);
        $search = $request->input('search', '');
        $sort = $request->input('sort', 'created_at');
        $sortDirection = $request->input('sort_direction', 'desc');
        return response()->json($this->secretariaService->getAllSecretarias($limit, $page, $search, $sort, $sortDirection), 200);
    }

    public function store(CreateSecretariaRequest $request): JsonResponse
    {
        $secretaria = $this->secretariaService->createSecretaria(CreateSecretariaDTO::fromRequest($request));
        return response()->json($secretaria, 201);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json($this->secretariaService->getSecretariaById($id), 200);
    }

    public function update(CreateSecretariaRequest $request, int $id): JsonResponse
    {
        $secretaria = $this->secretariaService->updateSecretaria(CreateSecretariaDTO::fromRequest($request), $id);

        return response()->json($secretaria, 200);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->secretariaService->deleteSecretaria($id);

        return response()->json(null, 204);
    }

    public function getNextRegistration(): JsonResponse
    {
        return response()->json($this->secretariaService->getNextRegistration(), 200);
    }

    public function getSecretariaByOrgaoId(int $orgaoId): JsonResponse
    {
        return response()->json($this->secretariaService->getSecretariaByOrgaoId($orgaoId), 200);
    }

    public function allSecretarias(): JsonResponse
    {
        return response()->json($this->secretariaService->allSecretarias(), 200);
    }
}
