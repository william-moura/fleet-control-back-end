<?php

namespace App\Http\Controllers;

use App\DTOs\CreateSecretariaDTO;
use App\Http\Requests\CreateSecretariaRequest;
use App\Services\SecretariaService;
use Illuminate\Http\JsonResponse;

class SecretariaController extends Controller
{
    public function __construct(private SecretariaService $secretariaService)
    {
    }

    public function index(): JsonResponse
    {
        return response()->json($this->secretariaService->getAllSecretarias(), 200);
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
}
